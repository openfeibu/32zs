<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Db;
use think\Model;

class School extends Model
{
	public function get_school_list_rmi($recruit_major_id)
	{
		$school_list = Db::name('school')->alias('s')
                                         ->join(config('database.prefix').'enrollment e','e.school_id = s.school_id')
                                         ->where(array('e.recruit_major_id' => $recruit_major_id))
                                         ->field('s.school_id,s.school_name,e.major_ids')
                                         ->select();
		return $school_list;
	}
}
