<?php
namespace app\home\controller;

use think\Db;
use app\admin\model\Enrollment as EnrollmentModel;

class Statistics extends Base
{
    public function index()
    {
        $y = date('Y');
        $enroll_student_count = EnrollmentModel::get_enroll_member_count();
        $data = Db::name('statistics')->where('ydate',$y)->find();
        if($data){
            Db::name('statistics')->where('ydate',$y)->update(['enroll_student_count' => $enroll_student_count]);
        }else{
            Db::name('statistics')->insert(['enroll_student_count' => $enroll_student_count,'ydate' => $y]);
        }
        return 'success';
    }


}
