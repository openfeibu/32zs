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
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\Subject as SubjectModel;
use app\admin\model\Major as MajorModel;
use think\Cache;

class Major extends Model
{
    public static function get_major($major_id)
    {
        $major = Db::name('major')->cache(true)->find($major_id);
        return $major;
    }
	public static function get_major_list($school_id,$recruit_major_id = 0)
	{
		$enrollments = Db::name('enrollment');
        if($recruit_major_id)
        {
            $enrollments = $enrollments->where(['recruit_major_id' => $recruit_major_id]);
        }
        $enrollments = $enrollments->where(['school_id' => $school_id])->where(get_year_where())->select();

		$arr = [];
		foreach ($enrollments as $key => $enrollment) {
			$major_id_arr = explode(',',$enrollment['major_ids']);
			$major_id_arr = array_filter($major_id_arr);
			$arr = array_merge($arr,$major_id_arr);
		}
		$major_list = Db::name('major')->where(array('major_id' => array('in',$arr)))->select();
		return $major_list;
	}
	public static function get_major_detail($major_id,$school_id,$year='')
	{
        $major = self::get_major($major_id);
		$major['major_subject_name_arr'] = [];

		if($major)
		{
            // 2020.7.1 改用get_subject_list1
            $subjects = SubjectModel::get_subject_list1($major_id,$school_id,$year);
            $major_subject_name_arr = array();
            if($subjects)
            {
                foreach ($subjects as $key => $subject)
                {
                    $major_subject_name_arr[] = $subject['subject_name'];
                }
            }
            $major['major_subject_name_arr'] = $major_subject_name_arr;
            $major['subjects'] = $subjects;
		}

		return $major;
	}
    //2019.12.28 编辑科目
    public static function get_major_detail1($major_id,$school_id,$year='')
    {
        $major = self::get_major($major_id);
        $major['major_subject_name_arr'] = [];

        if($major)
        {
            $subjects = SubjectModel::get_subject_list1($major_id,$school_id,$year);
            $major_subject_name_arr = array();
            if($subjects)
            {
                foreach ($subjects as $key => $subject)
                {
                    $major_subject_name_arr[] = $subject['subject_name'];
                }
            }
            $major['major_subject_name_arr'] = $major_subject_name_arr;
            $major['subjects'] = $subjects;
        }

        return $major;
    }

	public static function get_secondary_vocat_major_list($major_ids,$school_id)
	{
		$major_list  = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->order('major_id','ASC')->select();
        $secondary_vocat_major_list = array();
        $i = 0;
        $year = array();
		foreach($major_list as $key => $major)
		{
            $enrollment_major_list = EnrollmentModel::get_year_enrollment_major_list($school_id,$major['major_id']);
            // halt($enrollment_major_list);
            foreach ($enrollment_major_list as $k => $enrollment_major)
            {
                $secondary_vocat_major_list[$i] = $enrollment_major;
                $secondary_vocat_major_list[$i]['major_name'] = $major['major_name'];
                $secondary_vocat_major_list[$i]['major_id'] = $major['major_id'];
                $major_list[$key]['subject'] = '';
                $subjects = Db::name('subject')->where(['major_id' => $major['major_id'] , 'school_id' => $school_id,'year' => $enrollment_major['year']])->order('subject_id','asc')->select();
                $major_subject_name_arr = array();
                if($subjects)
                {
                    foreach ($subjects as $k => $subject)
                    {
                        $major_subject_name_arr[] = $subject['subject_name'];
                    }
                }
                $secondary_vocat_major_list[$i]['major_subject_name_arr'] = $major_subject_name_arr;
                $secondary_vocat_major_list[$i]['subjects'] = $subjects;
                $year[] = $enrollment_major['year'];
                $i++;
            }
		}
        array_multisort($year,SORT_NUMERIC,SORT_DESC,$secondary_vocat_major_list);
		return $secondary_vocat_major_list;
	}
}
