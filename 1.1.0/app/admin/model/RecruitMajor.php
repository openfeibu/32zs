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
								->where(array('e.school_id' => $school_id))
								->find();
		return $recruit_major;
	}
}
