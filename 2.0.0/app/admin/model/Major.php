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
use think\Db;
/**
 * 文章模型
 * @package app\admin\model
 */
class Major extends Model
{
	public static function get_major_list($school_id)
	{
		$enrollments = Db::name('enrollment')->where(['school_id' => $school_id])->select();
		$arr = [];
		foreach ($enrollments as $key => $enrollment) {
			$major_id_arr = explode(',',$enrollment['major_ids']);
			$major_id_arr = array_filter($major_id_arr);
			$arr = array_merge($arr,$major_id_arr);
		}
		$major_list = Db::name('major')->where(array('major_id' => array('in',$arr)))->select();
		return $major_list;
	}
	public static function get_major_detail($major_id,$school_id)
	{
		$major = Db::name('major')->where(array('major_id' => $major_id))->find();
		$major['score'] = [];
		$major['score_config_id'] = '';
		if($major)
		{
			$major_score_config = Db::name('major_score_config')->where(['major_id' => $major['major_id'] , 'school_id' => $school_id])->find();
			if($major_score_config){
				$major['score'] = $major_score_config['score'];
				$major['score_config_id'] =  $major_score_config['score_config_id'];
			}
		}
		$major['major_score_key'] = $major['score'];
		return $major;
	}
	public static function get_secondary_vocat_major_list($major_ids,$school_id)
	{
		$major_list  = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->order('major_id','ASC')->select();
		foreach($major_list as $key => $major)
		{
			$recruit_major = \app\admin\model\RecruitMajor::get_recruit_major($school_id,$major['major_id']);
			$major_list[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
			$major_list[$key]['recruit_major_id'] = $recruit_major['recruit_major_id'];
			$major_list[$key]['score'] = [];
			$major_list[$key]['score_config_id'] = '';
			$major_score_config = Db::name('major_score_config')->where(['major_id' => $major['major_id'] , 'school_id' => $school_id])->find();
			if($major_score_config){
				$major_list[$key]['score'] = $major_score_config['score'];
				$major_list[$key]['score_config_id'] =  $major_score_config['score_config_id'];
			}
			$major_list[$key]['major_score_key'] = $major_list[$key]['score'];

		}

		return $major_list;
	}
}
