<?php
// +----------------------------------------------------------------------
// | 三二分段 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\admin\behavior;

use think\Log;

class Cron
{
	protected $options   =  array(
            'cron_max_time' =>  60,
        );
	public function run(&$params)
    {
        $this->options['cron_max_time']=config('cron_max_time')?:60;
        $lockfile	 =	 RUNTIME_PATH.'cron.lock';
        if(is_writable($lockfile) && filemtime($lockfile) > $_SERVER['REQUEST_TIME'] - $this->options['cron_max_time']) {
            return ;
        } else {
            touch($lockfile);
        }
        @set_time_limit(1000);
        @ignore_user_abort(true);
		if(is_file(RUNTIME_PATH.'~crons.php')) {
            $crons	=	include RUNTIME_PATH.'~crons.php';
        }elseif(is_file(ROOT_PATH.'app/crons.php')){
            $crons	=	include ROOT_PATH.'app/crons.php';
        }
        if(isset($crons) && is_array($crons)) {
            $update	 =	 false;
            $log	=	array();
            foreach ($crons as $key=>$cron){
                if(empty($cron[2]) || $_SERVER['REQUEST_TIME']>=$cron[2]) {
                    debug('cronStart');
                    include ROOT_PATH.'app/cron/'.$cron[0].'.php';
					debug('cronEnd');
                    $_useTime	 =	 debug('cronStart','cronEnd', 6);
                    $cron[2]	=	$_SERVER['REQUEST_TIME']+$cron[1];
                    $crons[$key]	=	$cron;
                    $log[] = "Cron:$key Runat ".date('Y-m-d H:i:s')." Use $_useTime s\n";
                    $update	 =	 true;
                }
            }
            if($update) {
                Log::write(implode('',$log));
                $content  = "<?php\nreturn ".var_export($crons,true).";\n?>";
                file_put_contents(RUNTIME_PATH.'~crons.php',$content);
            }
        }
        file_exists($lockfile) && unlink($lockfile);
        return ;
    }
}
