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
use app\admin\model\Major as MajorModel;
use app\admin\model\RecruitMajor as RecruitMajorModel;

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
    public static function get_enroll_member_list($enrollment,$recruit_major,$school_id)
    {
        $min_score = Db::name('min_score')->find();
        $min_score = $min_score ? $min_score['min_score'] : 0;
        $major_ids = array_filter(explode(',',$enrollment['major_ids']));
        $where['s.school_id'] = $school_id;
        $where['a.major_id'] = array('in',$major_ids);
        $member_model=new MemberList;

        $member_list=$member_model->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
                ->join(config('database.prefix').'member_info mi','mi.member_list_id = a.member_list_id')
                ->join(config('database.prefix').'school s','a.school_id = s.school_id')
                ->join(config('database.prefix').'major m','a.major_id = m.major_id')
                ->where($where)
                ->field('a.*,b.*,s.school_id,m.major_id,m.major_name,s.school_id,s.school_name,mi.ZexamineeNumber')
                ->select();

        $data = $member_list;

        $ranking = 1;
        foreach ($data as $key => $value) {
            $major = MajorModel::get_major_detail($value['major_id'],$value['school_id']);
            $major_score_arr = [];
            $major_score_desc = $major_score_total = '';
            $major_score_key = $major['major_score_key'] ? array_filter(json_decode($major['major_score_key'],true)) : [];
            if($value['major_score']){
                $major_score_arr = json_decode($value['major_score'],true);
                $major_score_desc = major_score_desc($major_score_key,$major_score_arr);
                $major_score_total = handle_major_score($major_score_arr);
            }
            else{
                $major_score_arr = json_decode($value['major_score'],true);
                $major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
            }
            $data[$key]['major_score_arr'] = $major_score_arr;
            $data[$key]['major_score_desc'] = $major_score_desc;
            $data[$key]['major_score_total'] = $major_score_total;
            $data[$key]['recruit_score'] = $recruit_score =  sprintf('%.2f',$value['recruit_score']);
            $data[$key]['total_score'] = sprintf('%.2f',$major_score_total + $value['recruit_score']);
            $data[$key]['admission_status'] = 1;
            if($value['recruit_score'] < $min_score)
            {
                $data[$key]['admission_status'] = 0;
            }
            $data[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
        }
        array_multisort(array_column($data,'admission_status'),SORT_DESC,array_column($data,'total_score'),SORT_DESC,$data);
        foreach ($data as $key => $value) {
            $data[$key]['ranking'] = $ranking;
            if($value['ranking'] > $enrollment['enrollment_number'])
            {
                $data[$key]['admission_status'] = 0;
            }
            $data[$key]['admission_status_desc'] = $data[$key]['admission_status'] ? '是' : '否';
            $ranking++;
        }
        return $data;
    }
    public static function get_enroll_member_count()
    {
        $member_model=new MemberList;
        $min_score = Db::name('min_score')->find();
        $min_score = $min_score ? $min_score['min_score'] : 0;
        $school_list = Db::name('school')->field('school_id')->select();
        $enroll_all_count = $enroll_count = 0;
        foreach ($school_list as $key => $school) {
            $school_id = $school['school_id'];
            $recruit_major_list = self::get_enrollment_recruit_major($school_id);
            foreach ($recruit_major_list as $key => $recruit_major) {
                $enrollment = Db::name('enrollment')->where(['school_id' => $school_id,'recruit_major_id' => $recruit_major['recruit_major_id']])->field('major_ids,enrollment_number')->find();
                $major_ids = array_filter(explode(',',$enrollment['major_ids']));
                $where['s.school_id'] = $school_id;
                $where['a.major_id'] = array('in',$major_ids);

                $member_list=$member_model->alias('a')
                        ->join(config('database.prefix').'school s','a.school_id = s.school_id')
                        ->join(config('database.prefix').'major m','a.major_id = m.major_id')
                        ->where($where)
                        ->field('s.school_id,m.major_id,a.major_score,a.recruit_score')
                        ->select();

                $data = $member_list;
                $ranking = 1;
                foreach ($data as $key => $value) {
                    $major = MajorModel::get_major_detail($value['major_id'],$value['school_id']);
                    $major_score_arr = [];
                    $major_score_desc = $major_score_total = '';
                    if($value['major_score']){
                        $major_score_arr = json_decode($value['major_score'],true);
                        $major_score_total = handle_major_score($major_score_arr);
                    }
                    $data[$key]['major_score_total'] = $major_score_total;
                    $data[$key]['recruit_score'] = $recruit_score =  sprintf('%.2f',$value['recruit_score']);
                    $data[$key]['total_score'] = sprintf('%.2f',$major_score_total + $value['recruit_score']);
                    $data[$key]['admission_status'] = 1;
                    if($value['recruit_score'] < $min_score)
                    {
                        $data[$key]['admission_status'] = 0;
                    }
                }
                array_multisort(array_column($data,'admission_status'),SORT_DESC,array_column($data,'total_score'),SORT_DESC,$data);
                $enroll_count = 0;
                foreach ($data as $key => $value) {
                    $data[$key]['ranking'] = $ranking;
                    if($value['ranking'] > $enrollment['enrollment_number'])
                    {
                        $data[$key]['admission_status'] = 0;
                    }else{
                        $enroll_count++;
                    }
                    $data[$key]['admission_status_desc'] = $data[$key]['admission_status'] ? '是' : '否';
                    $ranking++;
                }
                $enroll_all_count += $enroll_count;
            }
        }
        return $enroll_all_count;
    }

}
