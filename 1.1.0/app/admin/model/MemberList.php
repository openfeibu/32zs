<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;

/**
 * 会员模型
 * @package app\admin\model
 */
class MemberList extends Model
{
	public function news()
	{
		return $this->hasMany('News','news_auto');
	}
	/**
	 * 增加会员
	 * @return int 0或会员id
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
		$member['certificate'] = json_decode($member['certificate'],true);
		$member['resume'] = json_decode($member['resume'],true);
		$member['prize'] = json_decode($member['prize'],true);
		$member['family'] = json_decode($member['family'],true);
		return $member;
	}
}
