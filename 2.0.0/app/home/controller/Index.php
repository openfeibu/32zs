<?php
// +----------------------------------------------------------------------
// | 三二分段 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\home\controller;

use think\Cache;
use think\Db;
use think\captcha\Captcha;

class Index extends Base
{
	public function index()
    {
		//中部轮播，头条，滚动
		$center_slideshow = Db::name('news')->where(array('news_flag' => 'c,f','news_open'=>1,'news_back'=>0,'news_columnid' => 19))->find();
		$center_slideshow_imgs = array_filter(explode(",", $center_slideshow['news_pic_allurl']));
		$this->assign('center_slideshow_imgs',$center_slideshow_imgs);
		//底部轮播，头条，滚动
		$footer_slideshow = Db::name('news')->where(array('news_flag' => 'c,f','news_open'=>1,'news_back'=>0,'news_columnid' => 20))->find();
		$footer_slideshow_imgs = array_filter(explode(",", $center_slideshow['news_pic_allurl']));
		$this->assign('footer_slideshow_imgs',$footer_slideshow_imgs);
		return $this->view->fetch(':index');
	}
	public function visit()
    {
		$user=Db::name("member_list")->where(array("member_list_id"=>input('id',0,'intval')))->find();
		if(empty($user)){
			$this->error(lang('member not exist'));
		}
		$this->assign($user);
		return $this->view->fetch('user:index');
	}
	public function verify_msg()
	{
		ob_end_clean();
		$verify = new Captcha (config('verify'));
		return $verify->entry('msg');
	}
	public function lang()
	{
		if (!request()->isAjax()){
			$this->error(lang('submission mode incorrect'));
		}else{
			$lang=input('lang_s');
			switch ($lang) {
				case 'cn':
					cookie('think_var', 'zh-cn');
				break;
				case 'en':
					cookie('think_var', 'en-us');
				break;
				//其它语言
				default:
					cookie('think_var', 'zh-cn');
			}
			Cache::clear();
			$this->success(lang('success'),url('home/Index/index'));
		}
	}
	public function addmsg()
    {
		if (!request()->isAjax()){
			$this->error(lang('submission mode incorrect'));
		}else{
			$verify =new Captcha ();
			if (!$verify->check(input('verify'), 'msg')) {
				$this->error(lang('verifiy incorrect'));
			}
			$data=array(
				'plug_sug_name'=>input('plug_sug_name'),
				'plug_sug_email'=>input('plug_sug_email'),
				'plug_sug_content'=>input('plug_sug_content'),
				'plug_sug_addtime'=>time(),
				'plug_sug_open'=>0,
				'plug_sug_ip'=>request()->ip(),
			);
			$rst=Db::name('plug_sug')->insert($data);
			if($rst!==false){
				$this->success(lang('message success'));
			}else{
				$this->error(lang('message failed'));
			}
		}
	}
}
