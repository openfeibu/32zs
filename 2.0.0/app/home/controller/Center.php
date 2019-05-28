<?php
// +----------------------------------------------------------------------
// | 三二分段 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\home\controller;

use think\Db;
use app\admin\model\MemberList;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\Major as MajorModel;

class Center extends Base
{
	protected function _initialize()
    {
		parent::_initialize();
		$this->check_login();
	}
	public function index()
    {
		$info = MemberList::getMember($this->user['member_list_id']);
		$time = time();
		$date = date('  Y  年  m  月  d  日',$time);
		$num=str_pad($this->user['member_list_id'],4,"0",STR_PAD_LEFT);
		$this->assign('num',$num);
		$major = Db::name('major')->where(array('major_id' => $this->user['major_id']))->find();
		$this->assign('major',$major);
		$school = Db::name('school')->where(array('school_id' => $this->user['school_id']))->find();
		$this->assign('school',$school);
		$recruit_major = RecruitMajorModel::get_recruit_major($this->user['school_id'],$this->user['major_id']);
		$this->assign('recruit_major',$recruit_major);
		$this->assign($this->user);
		$this->assign('info',$info);
		$this->assign('date',$date);
		return $this->view->fetch('user:center');
    }
	public function grade()
	{
		$major = MajorModel::get_major_detail($this->user['major_id'],$this->user['school_id']);
		$major_score_key = $major['score'] ? array_filter(json_decode($major['score'],true)) : [];
		$major_score_arr = [];
		$major_score_desc = $major_score_total = $total_score = '';
		$recruit_score = '';
		if($this->user['major_score']){
			$major_score_arr = array_filter(json_decode($this->user['major_score'],true));
			$major_score_desc = major_score_desc($major_score_key,$major_score_arr);
			$major_score_total = handle_major_score($major_score_arr);
			$recruit_score = $this->user['recruit_score'];
		}else{
			$score = Db::name('major_score')->where(['member_list_id' => $this->user['member_list_id']])->find();
			$major_score_arr = json_decode($score['major_score'],true);
			$major_score_desc = major_score_desc($major_score_key,$major_score_arr);
			$recruit_score = $score['recruit_score'];
		}
		$total_score = $major_score_total + $recruit_score;
		$this->assign($this->user);
		$this->assign('recruit_score',$recruit_score);
		$this->assign('major_score_desc',$major_score_desc);
		$this->assign('major_score_total',$major_score_total);
		$this->assign('total_score',$total_score);
		$this->assign('major_score_key',$major_score_key);
		$this->assign('major_score_arr',$major_score_arr);
		return $this->view->fetch('user:grade');
	}
	/*
	public function confirm_grade()
	{
		$where = array('member_list_id' => $this->user['member_list_id']);
		$data = Db::name('major_score')->where($where)->find();
		if($data && (!$this->user['major_score'] && !$this->user['recruit_score'])){
			$rst = Db::name('major_score')->where($where)->setField(['major_score_status' => 1,'recruit_score_status' => 1]);
			Db::name('member_list')->where($where)->update(array('major_score' => $data['major_score'],'recruit_score' => $data['recruit_score']));
		}
		return [
			'code' => 200,
			'msg'  => '操作成功',
		];
	}*/
	public function setting()
	{
		$this->assign($this->user);
		return $this->view->fetch('user:setting');
	}
    //编辑用户资料
	public function edit()
    {
		$province = Db::name('Region')->where ( array('pid'=>1) )->select ();
		$city=Db::name('Region')->where ( array('pid'=>$this->user['member_list_province']) )->select ();
		$town=Db::name('Region')->where ( array('pid'=>$this->user['member_list_city']) )->select ();
		$this->assign('province',$province);
		$this->assign('city',$city);
		$this->assign('town',$town);
		$this->assign($this->user);
		return $this->view->fetch('user:edit');
    }
    public function runedit()
    {
    	if(request()->isPost()){
			$post=input('post.');
			$rst=Db::name('member_list')->where(array('member_list_id'=>$this->user['member_list_id']))->update($post);
			if ($rst!==false) {
				$this->user=Db::name('member_list')->find($this->user['member_list_id']);
				session('user',$this->user);
				$this->success(lang('save success'),url("home/Center/edit"));
			} else {
				$this->error(lang('save failed'));
			}
    	}
    }
	//修改密码
	public function password()
    {
		$this->assign($this->user);
		return $this->view->fetch('user:password');
    }
	public function runchangepwd()
    {
    	if (request()->isPost()) {
			$old_password=input('old_password');
    		$password=input('password');
			$repassword=input('repassword');
    		if(empty($old_password)){
    			$this->error(lang('old pwd empty'));
    		}
    		if(empty($password)){
    			$this->error(lang('new pwd empty'));
    		}
			if($password!==$repassword){
    			$this->error(lang('pwd not same'));
    		}
			$member=Db::name('member_list');
    		$user=$member->where(array('member_list_id'=>$this->user['member_list_id']))->find();
			$member_list_salt=$user['member_list_salt'];
    		if(encrypt_password($old_password,$member_list_salt)===$user['member_list_pwd']){
				if(encrypt_password($password,$member_list_salt)==$user['member_list_pwd']){
					$this->error(lang('new pwd the same as old pwd'));
				}else{
					$data['member_list_pwd']=encrypt_password($password,$member_list_salt);
					$data['member_list_id']=$this->user['member_list_id'];
					$rst=$member->update($data);
					if ($rst!==false) {
						$this->success(lang('revise success'),url('home/Center/index'));
					} else {
						$this->error(lang('revise failed'));
					}
				}
    		}else{
    			$this->error(lang('old pwd not correct'));
    		}
    	}
    }
	public function avatar()
    {
        $imgurl=input('imgurl');
        //去'/'
        $imgurl=str_replace('/','',$imgurl);
        $rst=Db::name('member_list')->where(array('member_list_id'=>$this->user['member_list_id']))->update(array('member_list_headpic'=>$imgurl));
        if($rst!==false){
            session('user_avatar',$imgurl);
			$this->user['member_list_headpic']=$imgurl;
			$url='/data/upload/avatar/'.$imgurl;
			//写入数据库
			$data['uptime']=time();
			$data['filesize']=filesize('./'.$url);
			$data['path']=$url;
			Db::name('plug_files')->insert($data);
            $this->success (lang('avatar update success'),url('home/Center/index'));
        }else{
            $this->error (lang('avatar update failed'),url('home/Center/index'));
        }
    }
    public function bang()
    {
    	$oauth_user_model=Db::name("OauthUser");
    	$oauths=$oauth_user_model->where(array("uid"=>$this->user['member_list_id']))->select();
    	$new_oauths=array();
    	foreach ($oauths as $oa){
    		$new_oauths[strtolower($oa['oauth_from'])]=$oa;
    	}
    	$this->assign("oauths",$new_oauths);
		return $this->view->fetch('user:bang');
    }
    public function fav()
    {
		$favorites_model=Db::name("favorites");
        $favorites=$favorites_model->alias("a")->join(config('database.prefix').'news b','a.t_id =b.n_id')->where(array('uid'=>$this->user['member_list_id']))->order('a.id asc')->paginate(config('paginate.list_rows'));
		$show=$favorites->render();
		$this->assign('page',$show);
		$this->assign("favorites",$favorites);
		return $this->view->fetch('user:favorite');
	}
    public function delete_favorite()
    {
        $id=input("id",0,"intval");
        $p=input("p",1,"intval");
        $favorites_model=Db::name("favorites");
        $result=$favorites_model->where(array('id'=>$id,'uid'=>$this->user['member_list_id']))->delete();
        if($result){
            $this->success(lang('cancel collection success'),url('home/Center/fav',array('page' => $p)));
        }else {
            $this->error(lang('cancel collection failed'));
        }
    }
	public function update_info()
	{
		$info = $this->getMemberInfo();
		$name = input('name');
		$value = input('value');
		if(strstr($name,'certificate'))
		{
			$type = "certificate";
		}
		else if(strstr($name,'prize'))
		{
			$type = "prize";
		}
		else if(strstr($name,'resume'))
		{
			$type = "resume";
		}
		else if(strstr($name,'family')){
			$type = "family";
		}
		if(isset($type))
		{
			$arr = $info[$type];
			$vaArr = explode('_',$name);
			$arr[$vaArr['1']][$vaArr['0']] = $value;
			$name = $type;
			$value = json_encode($arr);
		}
		Db::name('member_info')->where(array('member_list_id'=>$this->user['member_list_id']))->update(array($name => $value));

	}
	private function getMemberInfo()
	{
		$info = Db::name('member_info')->where(array('member_list_id'=>$this->user['member_list_id']))->find();
		$info['name'] = $this->user['member_list_nickname'];
		$info['cardId'] = $this->user['member_list_username'];
		$info['certificate'] = json_decode($info['certificate'],true);
		$info['resume'] = json_decode($info['resume'],true);
		$info['prize'] = json_decode($info['prize'],true);
		$info['family'] = json_decode($info['family'],true);
		return $info;
	}
}
