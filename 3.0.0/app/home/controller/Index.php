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
use app\services\Certificate;
use Mohuishou\ImageOCR\Image;
use Mohuishou\ImageOCR\StorageFile;

class Index extends Base
{
	public function index()
    {
		//中部轮播，头条，滚动
		$center_slideshow = Db::name('news')->where(array('news_open'=>1,'news_back'=>0,'news_columnid' => 19))->find();
		$center_slideshow_imgs = array_filter(explode(",", $center_slideshow['news_pic_allurl']));
		$this->assign('center_slideshow_imgs',$center_slideshow_imgs);
		//底部轮播，头条，滚动
		$footer_slideshow = Db::name('news')->where(array('news_open'=>1,'news_back'=>0,'news_columnid' => 20))->find();
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
	public function test()
    {
        $certificate =  new Certificate();
/*
        $member_list_username = '44528119970825031X';
        $member_list_nickname = '许钊纹';
        $exam_number = '528116102100002';
        $year = '2016';
        $exam_info = [
            'member_list_id' => 1,
            'member_list_username' => $member_list_username,
            'member_list_nickname' => $member_list_nickname,
            'exam_number' => $exam_number,
            'year' => $year,
            'exam_date' => '2016_a'
        ];
        return $certificate->PSE($exam_info);
*/

        $image_name = 'verify_img'.time().'.jpg';
        $folder = 'verify_images';
        $img_url = "http://search.neea.edu.cn/Imgs.do?act=verify&t=0.8841180045674784";
        $header[] = "Referer: http://search.neea.edu.cn/QueryMarkUpAction.do?act=doQueryCond&sid=300&pram=certi";
        $header[] = "Accept: image/webp,image/apng,image/*,*/*;q=0.8";
        $header[] = "Accept-Encoding: gzip, deflate";
        $header[] = "Accept-Language: zh-CN,zh;q=0.9,en;q=0.8";
        $header[] = "Connection: keep-alive";
        $header[] = "Host: search.neea.edu.cn";
        $header[] = "Referer: http://search.neea.edu.cn/QueryMarkUpAction.do?act=doQueryCond&sid=300&pram=certi";
        $header[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36";
        $save_image = save_image($img_url,$folder,$image_name,$header);
        $image_path = $save_image['save_path'];
        $send = input('send','');

        if($send)
        {
            $image = new Image(input('image_path'));
            $code = input('code');
            $code_arr = str_split($code);
            $db = new StorageFile();

            for($i=0;$i< $image::CHAR_NUM;$i++){
                $hash_img_data=implode("",$image->splitImage($i));
                $db->add($code_arr[$i],$hash_img_data);
            }
        }

        $verify_image = new Image($image_path);
        $a=$verify_image->find();
        $verify_code = implode("",$a);

        $this->assign('verify_code',$verify_code);
        $this->assign('image_path',$image_path);
        $this->assign('image_url','/data/upload/verify_images/'.$image_name);

        return $this->view->fetch(':test');
        /*


        $image_name = 'verify_img'.time().'.jpg';
        $folder = 'verify_images';
        $img_url = "http://query.5184.com/query/image.jsp?time=".math_random();
        $save_image = save_image($img_url,$folder,$image_name);
        $image_path = $save_image['save_path'];

        $send = input('send','');

        if($send)
        {
            $image = new Image(input('image_path'));
            $code = input('code');
            $code_arr = str_split($code);
            $db = new StorageFile();

            for($i=0;$i< $image::CHAR_NUM;$i++){
                $hash_img_data=implode("",$image->splitImage($i));
                $db->add($code_arr[$i],$hash_img_data);
            }
        }

        $verify_image = new Image($image_path);
        $a=$verify_image->find();
        $verify_code = implode("",$a);

        $this->assign('verify_code',$verify_code);
        $this->assign('image_path',$image_path);
        $this->assign('image_url','/data/upload/verify_images/'.$image_name);

        return $this->view->fetch(':test');
       // return $certificate->test();
        */
    }
}
