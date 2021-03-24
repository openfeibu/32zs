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
use think\Cache;

class Subject extends Model
{
    protected $tableName = 'subject';

    public static function get_subject_list($major_id,$school_id,$year='',$subject_ids='',$where=[])
    {
        //2019 注释
        // if(!$where)
        // {
        //     $cache_name = $major_id.'_'.$school_id.'_'.$subject_ids.'_'.$year.'_'.'subject_list';
        //     $subject_list_cache = Cache::get($cache_name);
        //     if($subject_list_cache)
        //     {
        //         return $subject_list_cache;
        //     }
        // }
        
        $subject_list =  Db::name('subject')->where(['major_id' => $major_id , 'school_id' => $school_id]);
        if($subject_ids)
        {
            $subject_list = $subject_list->where('subject_id','in',$subject_ids);
        }
        if($where)
        {
            $subject_list = $subject_list->where($where);
        }
        $subject_list = $subject_list->select();

        if(!$where) {
            Cache::tag($major_id . '_' . $school_id . '_' . 'subject_list')->set($major_id . '_' . $school_id . '_' . $subject_ids . '_' . $year . '_' . 'subject_list', $subject_list);
        }
        return $subject_list;
    }

    public static function get_subject_list1($major_id,$school_id,$year='',$subject_ids='',$where=[])
    {
        
        $subject_list =  Db::name('subject')->where(['major_id' => $major_id , 'school_id' => $school_id, 'year'=>$year]);
        if($subject_ids)
        {
            $subject_list = $subject_list->where('subject_id','in',$subject_ids);
        }
        if($where)
        {
            $subject_list = $subject_list->where($where);
        }
        $subject_list = $subject_list->select();

        if(!$where) {
            Cache::tag($major_id . '_' . $school_id . '_' . 'subject_list')->set($major_id . '_' . $school_id . '_' . $subject_ids . '_' . $year . '_' . 'subject_list', $subject_list);
        }
        return $subject_list;
    }
}

