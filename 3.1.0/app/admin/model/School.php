<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
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
            ->where(get_year_where('e'))
            ->field('s.school_id,s.school_name,e.major_ids')
            ->select();

        foreach ($school_list as $key => $value) {
            $val = str_replace(",","",$value['major_ids']);
            $res = Db::name('major')->where("major_id in ( ".$val." )")->select();
            if($res){
                $school_list[$key]['major_name'] = $res[0]['major_name'];
                $school_list[$key]['major_id'] = $res[0]['major_id'];
            }else{
                $school_list[$key]['major_name'] = "";
                $school_list[$key]['major_id'] = "";
            }
                
        }
        
		return $school_list;
	}
	public function get_school_list_major_ids($school_list)
	{
		$major_id_arrs = array();
		foreach ($school_list as $school_key => $school_value) {
            $school_id_arr[] = $school_value['school_id'];
            $major_id_arr = array_filter(explode(',',$school_value['major_ids']));
            $major_id_arrs = array_merge($major_id_arrs,$major_id_arr);
        }
		return $major_id_arrs;
	}
}
