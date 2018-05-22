<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\Major as MajorModel;

/**
 * 考生模型
 * @package app\admin\model
 */
class MemberList extends Model
{
	public function news()
	{
		return $this->hasMany('News','news_auto');
	}
	/**
	 * 增加考生
	 * @return int 0或考生id
	 */
	public static function add($username,$salt='',$pwd,$groupid=1,$nickname='',$email='',$tel='',$open=0,$status=0)
	{
		$salt=$salt?:random(10);
		$sldata=array(
			'member_list_username'=>$username,
			'member_list_salt' => $salt,
			'member_list_pwd'=>encrypt_password($pwd,$salt),
			'member_list_groupid'=>$groupid,
			'member_list_nickname'=>$nickname,
			'member_list_email'=>$email,
			'member_list_tel'=>$tel,
			'member_list_open'=>$open,
			'last_login_ip'=>request()->ip(),
			'member_list_addtime'=>time(),
			'last_login_time'=>time(),
			'user_status'=>$status,
		);
		$member=self::create($sldata);
		if($member){
			return $member['member_list_id'];
		}else{
			return 0;
		}
	}
	public static function getMember($member_list_id)
	{
		$member= self::name('member_list')->alias('m')
					->join(config('database.prefix').'member_info mi','m.member_list_id =mi.member_list_id')
					->where(array('m.member_list_id' => $member_list_id))->find();
  		$member = self::handleMember($member);
		return $member;
	}
	public static function handleMember($member)
	{
		$member['certificate'] = json_decode($member['certificate'],true);
		$member['resume'] = json_decode($member['resume'],true);
		$member['prize'] = json_decode($member['prize'],true);
		$member['family'] = json_decode($member['family'],true);
		$member['sex'] = get_sex($member['member_list_username']);
		$member['date'] = get_birth($member['member_list_username']);
		$member['documentType'] = mb_substr($member['documentType'],0,6,'utf-8');
		$member['domicile'] = mb_substr($member['domicile'],0,6,'utf-8');
		return $member;
	}
	public function getMemberList($map,$where,$is_page = 1)
	{
		$member_list = $this->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
			    ->join(config('database.prefix').'school s','a.school_id = s.school_id')
				->join(config('database.prefix').'major m','a.major_id = m.major_id')
				->join(config('database.prefix').'member_info mi','mi.member_list_id = a.member_list_id');
		if($map)
		{
			$member_list = $member_list->where($map);
		}
		if($where)
		{
			$member_list = $member_list->where($where);
		}
		$member_list = $member_list->field('a.*,b.*,m.major_id,m.major_name,m.major_code,m.major_name,s.school_id,s.school_name,mi.*')->order('a.member_list_id','desc');
		if($is_page){
			$member_list = $member_list->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		}else{
			$member_list= $member_list->select();
		}
		return $member_list;
	}
	public function handleMemberList($data)
	{
		foreach ($data as $k => $value) {
			$recruit_major = RecruitMajorModel::get_recruit_major($value['school_id'],$value['major_id']);
            $data[$k]['recruit_major_name'] = $recruit_major['recruit_major_name'];
			$data[$k]['recruit_major_code'] = $recruit_major['recruit_major_code'];
			$major_score_arr = [];
			$major_score_desc = '';
			$major_score_total = 0;
			$major = MajorModel::get_major_detail($value['major_id'],$value['school_id']);
            $major_score_key = $major['major_score_key'] ? array_filter(json_decode($major['major_score_key'],true)) : [];
			if($value['major_score']){
				$major_score_arr = json_decode($value['major_score'],true);
				$major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
				$major_score_desc = major_score_desc($major_score_key,$major_score_arr);
				$major_score_total = handle_major_score($major_score_arr);
			}
			else{
				$major_score_arr = json_decode($value['major_score'],true);
				$major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
			}
			$data[$k]['major_score_arr'] = $major_score_arr;
			$data[$k]['major_score_desc'] = $major_score_desc;
			$data[$k]['major_score_total'] = $major_score_total;
			$data[$k]['total_score'] = $major_score_total + $value['recruit_score'];
		}
		return $data;
	}
	public function handleMemberList2($data)
	{
		foreach ($data as $k => $value) {
			$recruit_major = RecruitMajorModel::get_recruit_major($value['school_id'],$value['major_id']);
			$data[$k]['recruit_major_name'] = $recruit_major['recruit_major_name'];
			$major_score_arr = [];
		   	$major_score_total = 0;
			$major = MajorModel::get_major_detail($value['major_id'],$value['school_id']);
			$major_score_key = $major['major_score_key'] ? array_filter(json_decode($major['major_score_key'],true)) : [];
			if($value['major_score']){
				$major_score_arr = json_decode($value['major_score'],true);
				$major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
				$major_score_total = handle_major_score($major_score_arr);
			}
			else{
				$major_score_arr = json_decode($value['major_score'],true);
				$major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
			}
			$data[$k]['major_score_total'] = $major_score_total;
			$data[$k]['total_score'] = $major_score_total + $value['recruit_score'];
			$data[$k]['member_list_username'] = $value['member_list_username']."\t";
            $data[$k]['ZexamineeNumber'] = $value['ZexamineeNumber']."\t";
		}
		return $data;
	}
}
