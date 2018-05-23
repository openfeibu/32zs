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
class RecruitMajor extends Model
{
	public static function get_recruit_major($school_id,$major_id)
	{
		$recruit_major = Db::name('recruit_major')->alias('rm')
								->join(config('database.prefix').'enrollment e','e.recruit_major_id = rm.recruit_major_id')
								->where(array('e.major_ids' => array('LIKE' , '%,'.$major_id.',%')))
								->whereOr('e.major_ids',$major_id)
								->where(array('e.school_id' => $school_id))
								->find();
		return $recruit_major;
	}
	public static function get_sec_vocat_recruit_major_list($school_id,$major_id_arr)
	{
		$recruit_major_list = [];
		foreach ($major_id_arr as $key => $major_id) {
			$recruit_major = self::get_recruit_major($school_id,$major_id);
			if($recruit_major)
			{
				$recruit_major_list[$recruit_major['recruit_major_id']] = $recruit_major;
			}
		}
		return $recruit_major_list;
	}
}
