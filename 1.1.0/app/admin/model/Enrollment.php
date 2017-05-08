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

class Enrollment extends Model
{
    public static function get_enrollment_recruit_major($school_id)
    {
        $recruit_major_list = Db::name('enrollment')->alias('e')
                                ->join(config('database.prefix').'recruit_major rm','rm.recruit_major_id = e.recruit_major_id')
                                ->where(['e.school_id' => $school_id])
                                ->select();
        return $recruit_major_list;
    }
    public static function get_enrollment($enrollment_id)
    {
        $enrollment = Db::name('enrollment')->alias('e')
                            ->join(config('database.prefix').'recruit_major rm','rm.recruit_major_id = e.recruit_major_id')
                            ->join(config('database.prefix').'school s','s.school_id = e.school_id')
                            ->where(['enrollment_id' => $enrollment_id])
                            ->find();
        $major_ids = explode(',',$enrollment['major_ids']);
        $major_ids = array_filter($major_ids);
        $majors = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
        $major_desc = '';
        foreach ($majors as $k => $major) {
            $major_desc.= $major['major_name'] . '(' . $major['major_code'] . ') ';
        }
        $enrollment['majors'] = $majors;
        $enrollment['major_desc'] = $major_desc;
        $enrollment['major_id_arr'] = array_unique(array_filter(explode(',',$enrollment['major_ids'])));
        return $enrollment;
    }
}
