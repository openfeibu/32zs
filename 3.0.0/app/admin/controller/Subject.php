<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\School as SchoolModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\Score as ScoreModel;
use app\admin\model\Subject as SubjectModel;
use app\admin\model\Enrollment as EnrollmentModel;
use think\Db;
use think\Cache;
use think\Loader;

class Subject extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->schoolModel = new SchoolModel();
        $this->scoreModel = new ScoreModel();
    }
    public function subject_list()
    {
        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
        $subject_list = array();
        $i = 0;
        foreach ($school_list as $school_key => $school)
        {
            $major_id_arr = array_filter(explode(',',$school['major_ids']));
            $major_list = MajorModel::get_secondary_vocat_major_list($major_id_arr,$school['school_id']);
            foreach($major_list as $key => $val)
            {
                $subject_list[$i] = $val;
                $subject_list[$i]['school_name'] = $school['school_name'];
                $subject_list[$i]['major_subject_name_arr'] = $val['major_subject_name_arr'];
                $subject_desc = '';
                foreach ($val['subjects'] as $subject)
                {
                    $subject_desc .= $subject['subject_name']."(".$subject['max_score']."),";
                }
                $subject_desc = rtrim($subject_desc,',');
                $subject_list[$i]['subject_desc'] = $subject_desc;
                $i++;
            }
        }
        $this->assign('subject_list',$subject_list);
        return $this->fetch();
    }
    public function subject_edit()
    {
        $major_id = input('major_id');
        $enrollment_id = input('enrollment_id');
        $enrollment = EnrollmentModel::find($enrollment_id);
        if(!$enrollment)
        {
            $this->error('该中职专业找不到匹配的招生计划，禁止设置科目');
        }
        $major = MajorModel::get_major_detail($major_id,$enrollment['school_id'],$enrollment['year']);
        if(!$major)
        {
            $this->error('不存在该中职专业');
        }
        $school = Db::name('school')->find($enrollment['school_id']);
        $this->assign('school',$school);
        $this->assign('major',$major);
        $this->assign('enrollment',$enrollment);
        return $this->fetch();
    }
    public function subject_runedit()
    {
        $major_id= input('major_id');
        $enrollment_id = input('enrollment_id');
        $enrollment = EnrollmentModel::find($enrollment_id);
        if(!$enrollment)
        {
            $this->error('该中职专业找不到匹配的招生计划，禁止设置科目');
        }
        $major = MajorModel::get_major_detail($major_id,$enrollment['school_id'],$enrollment['year']);
        if(!$major)
        {
            $this->error('不存在该专业');
        }
        $subject_names = $_POST['subject_name'];
        $max_scores = $_POST['max_score'];
        if(isset($_POST['subject_id']) && !empty($_POST['subject_id']))
        {
            $subject_ids = $_POST['subject_id'];
            foreach ($subject_ids as $key => $subject_id) {
                $data = [
                    'subject_name' => trim($subject_names[$key]),
                    'max_score' => trim($max_scores[$key]),
                ];
                $rst = SubjectModel::where('subject_id',$subject_id)->update($data);
                unset($subject_names[$key]);
                unset($max_scores[$key]);
            }
            //$this->success('修改成功',url('admin/School/secondary_vocat_major_list'));
        }
        foreach ($subject_names as $key => $subject_name)
        {
            $data = [
                'major_id' => $major_id,
                'school_id' => $this->admin['school_id'],
                'subject_name' => trim($subject_name),
                'enrollment_id' => trim(input('enrollment_id')),
                'year' => trim(input('year')),
                'max_score' => $max_scores[$key],
            ];
            $rst = SubjectModel::create($data);
        }
        Cache::clear($major_id.'_'.$enrollment['school_id'].'_'.'subject_list');
        SubjectModel::get_subject_list($major_id,$this->admin['school_id']);
        $this->success('修改成功',url('admin/Subject/subject_list'));
    }
    public function subject_delete()
    {
        $subject_id = input('subject_id');

        SubjectModel::where('subject_id',$subject_id)->delete();
        $this->success('删除科目成功');
    }
}