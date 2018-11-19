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
use think\Db;
use think\Cache;
use think\Loader;

class UniversityScore extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->schoolModel = new SchoolModel();
        $this->scoreModel = new ScoreModel();
    }

    public function score_list()
    {
        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
        $major_id_arr = $this->schoolModel->get_school_list_major_ids($school_list);

        $search_key = trim(input('search_key', ''));

        $admin = Db::name('admin')->alias("a")->join(config('database.prefix') . 'auth_group_access b', 'a.admin_id =b.uid')
            ->join(config('database.prefix') . 'auth_group c', 'b.group_id = c.id')
            ->where(array('a.admin_id' => session('admin_auth.aid')))
            ->find();

        $school_id = input('school_id', $school_list[0]['school_id']);
        $major_list = MajorModel::get_major_list($school_id);

        $major_id = input('major_id', $major_list['0']['major_id']);

        $major_score_status = input('major_score_status', '');

        $map['m.major_id'] = $major_id;

        $map['m.school_id'] = $school_id;

        //$map['ms.subject_id'] = $admin['school_id'];
        $where = $mapor = '';
        if ($major_score_status == 1) {
            $map['ms.major_score_status'] = $major_score_status;
        } else if ($major_score_status == '') {

        } else {
            $where .= '( ms.major_score_status IS NULL or ms.major_score_status <= 0)';
        }

        $subject_ids = isset($_POST['subject_id']) ? implode(',', $_POST['subject_id']) : '';

        $subject_list = SubjectModel::get_subject_list($major_id, $school_id, '', $subject_ids);

        $major_subject_name_arr = array_column($subject_list, 'subject_name');
        $this->assign('major_subject_name_arr', $major_subject_name_arr);

        $data = $this->scoreModel->getMajorScoreList($map, $where, $search_key, $subject_list);

        $score_list = $data['score_list'];

        $major = MajorModel::get_major_detail($major_id, $admin['school_id']);

        $status = config("status");

        $score_list = $this->scoreModel->handleMajorScoreList($score_list, $major_subject_name_arr, $status);

        $page = $data['page'];

        $this->assign('major_id', $major_id);
        $this->assign('school_id',$school_id);
        $this->assign('school_list',$school_list);
        $this->assign('major_score_status', $major_score_status);
        $this->assign('major_list', $major_list);
        $this->assign('data', $score_list);
        $this->assign('page', $page);
        $this->assign('search_key', $search_key);
        $this->assign('all_subject_list', $major['subjects']);

        if (request()->isAjax()) {
            return $this->fetch('ajax_score_list');
        } else {
            return $this->fetch('score_list');
        }
    }
    public function score_active()
    {
        $p = input('p');
        $ids = input('n_id/a');
        if(empty($ids)){
            $this -> error("请选择列表",url('admin/universityScore/score_list',array('page' => $p)));
        }
        if(is_array($ids)){
            $where = 'member_list_id in('.implode(',',$ids).')';
        }else{
            $where = 'member_list_id ='.$ids;
        }

        $rst=Db::name('major_score')->where($where)->setField('major_score_status',1);
        if($rst!==false){
            $this->success("操作成功",url('admin/universityScore/score_list',array('page' => $p)));
        }else{
            $this -> error("操作失败！",url('admin/universityScore/score_list',array('page' => $p)));
        }
    }
    public function check_score_list_export()
    {
        $major_id = input('major_id','');
        $school_id = input('school_id', '');
        $unauditing_count = Db::name('member_list')->alias('m')->join(config('database.prefix').'major_score ms','m.member_list_id = ms.member_list_id','left')->where('ms.major_score_status IS NUll or ms.major_score_status <= 0')->where(['m.major_id' => $major_id,'m.school_id' => $school_id])->where(get_year_where('m'))->count();
        if($unauditing_count>0)
        {
            $this -> error("该专业存在未审核成绩，无法导出。");
        }
        $this->success('导出');
    }
    public function score_list_export()
    {
        $major_id = input('major_id','');

        $school_id = input('school_id', '');

        $map['m.major_id'] = $major_id;

        $map['m.school_id'] = $school_id;

        $map['ms.major_score_status'] = 1;

        $subject_ids = isset($_POST['subject_id']) ? implode(',', $_POST['subject_id']) : '';

        $subject_list = SubjectModel::get_subject_list($major_id, $school_id, '', $subject_ids);

        $data = $this->scoreModel->getMajorScoreList($map,'','',$subject_list,0);

        $major = MajorModel::get_major_detail($major_id,$school_id);

        $school = Db::name('school')->where(['school_id' =>$school_id ])->find();

        $title = $school['school_name'].'  '.$major['major_name'].'专业   转段考核成绩单';

        $major_score = $major['score'] ? json_decode($major['score'],true) :[];
        $major_score = array_filter($major_score);

        $major_subject_name_arr = $major['major_subject_name_arr'];

        $data = $this->scoreModel->handleMajorScoreList($data,$major_subject_name_arr,config("status_title"));

        $field_titles = ['序号','姓名','中职考生号','身份证号'];
        $i = 4;
        foreach ($major_score as $k => $mv) {
            $field_titles[$i] = $mv;
            $i++;
        }
        $field_titles[$i] = '转段考核成绩';
        $field_titles[$i+1] = '审核状态';

        $fields = ['no','member_list_nickname','ZexamineeNumber','member_list_username','major_name','major_score_total'];
        $i = 4; $j = 0;
        foreach ($major_score as $k => $mv) {
            $fields[$i] = 'major_'.$j;
            $i++;
            $j++;
        }
        $fields[$i] = 'major_score_total';
        $fields[$i+1] = 'status_desc';

        $table = $school['school_name'].$major['major_name'].'专业转段考核成绩单'.date('Ymd');

        $this->score_list_export_pdf($field_titles,$fields,$data,$table,$title);
        return false;

    }
    public function major_score_import()
    {
        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
        $school_id = input('school_id', $school_list[0]['school_id']);
        $major_list = MajorModel::get_major_list($school_id);
        $major_id = input('major_id', $major_list['0']['major_id']);
        $this->assign('school_list',$school_list);
        $this->assign('major_list',$major_list);
        $this->assign('major_id', $major_id);
        $this->assign('school_id',$school_id);
        return $this->fetch();
    }
    public function major_score_runimport()
    {
        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
        $major_id_arr = $this->schoolModel->get_school_list_major_ids($school_list);
        if (!empty($_FILES['file_stu']['name'])){
            $major_id = input('major_id','');
            $school_id = input('school_id','');
            if(!$school_id)
            {
                $this->error('请先选择中职学校');
            }
            if(!$major_id)
            {
                $this->error('请先选择中职专业');
            }
            if(!in_array($major_id,$major_id_arr))
            {
                $this->error('请勿操作其他中职专业');
            }
            $post_file = $_FILES ['file_stu'];
            $savePath = ROOT_PATH. 'public/excel/';
            $file = uploadFile($post_file,$savePath);
            $res = read($file);
            if (!$res){
                $this->error ('数据处理失败');
            }
            $major = MajorModel::get_major_detail($major_id,$school_id);
            $major_subject_name_arr = $major['major_subject_name_arr'];
            $this->assign('major_subject_name_arr',$major_subject_name_arr);
            $data = [];
            $excel_subject_list = array();
            foreach ( $res as $k => $v ){
                if ($k == 1)
                {
                    $excel_subject_name_arr = array_slice($v,4);
                    foreach ($excel_subject_name_arr as $key => $excel_subject_name)
                    {
                        $subject = Db::name('subject')->where('school_id',$school_id)->where('major_id',$major_id)->where('subject_name',trim($excel_subject_name))->where(get_year_where())->find();
                        $excel_subject_list[] = $subject;
                    }
                }
                if ($k != 1 && trim($v[0])){
                    if($major['major_name'] != trim($v[3])){
                        $this->error('提交的excel数据中的中职专业与筛选中的中职专业不符');
                    }
                    $member_list_id = trim($v[0]);
                    $major_score_data = Db::name('major_score')->where(array('member_list_id' => $member_list_id))->field('major_score_status')->find();
                    $member_list = Db::name('member_list')->where(array('member_list_id' => $member_list_id,'major_id' => $major_id,'school_id' => $school_id))->field('member_list_id')->find();
                    if(!$member_list || ($major_score_data && $major_score_data['major_score_status'] == 1))
                    {
                        continue;
                    }
                    $data[$k]['member_list_id'] = $member_list_id;
                    $data[$k]['member_list_nickname'] = trim($v[1]);
                    $data[$k]['member_list_username'] = trim($v[2]);
                    $data[$k]['major_name'] = trim($v[3]);
                    $data[$k]['major_score_arr'] = array_slice($v,4);
                    $excel_score_arr = array_slice($v,4);
                    $major_subject_score_arr = array();
                    foreach ($excel_score_arr as $excel_score_key => $excel_score)
                    {
                        $major_subject_score_arr[] = [
                            'subject_id' => $excel_subject_list[$excel_score_key]['subject_id'],
                            'subject_name' => $excel_subject_list[$excel_score_key]['subject_name'],
                            'score' => $excel_score,
                        ];
                    }
                    $data[$k]['major_subject_score_arr'] = $major_subject_score_arr;
                }

            }
            $this->assign('data',$data);
            $this->assign('excel_subject_list',$excel_subject_list);
            return $this->fetch('ajax_major_score_import');
        }

        $major_list = Db::name('major')->where(array('major_id' => array('in',$major_id_arr)))->select();
        $this->assign('major_list',$major_list);
        return $this->fetch();
    }
    public function major_score_export_runimport()
    {
        $major_id = input('major_id','');
        $school_id = input('school_id','');
        if(!$major_id)
        {
            $this->error('请先选择中职专业');
        }

        $member_list_ids = input('n_id/a');
        foreach ($member_list_ids as $key => $member_list_id) {
            $post_scores = input('major_score_'.$member_list_id.'/a');
            $post_subject_ids = input('subject_id_'.$member_list_id.'/a');
            foreach ($post_scores as $post_score_key => $major_score)
            {
                $subject_id = $post_subject_ids[$post_score_key];
                $data = $this->scoreModel->majorScoreAdd($member_list_id,$subject_id,$major_score);
            }
        }
        $this->success('操作成功',url('admin/UniversityScore/score_list',['major_id' => $major_id,'school_id'=>$school_id]));
    }
    public function check_major_score_import()
    {
        $major_id = input('major_id','');
        $school_id = input('school_id','');

        $map['s.major_id'] = $major_id;
        $map['s.school_id'] = $school_id;

        $subject = Db::name('subject')->alias('s')->where($map)->where(get_year_where('s'))->find();
        if(!$subject)
        {
            $this->error('该中职专业下未设置科目，无法导出模板');
        }
        $this->success('',url('admin/UniversityScore/major_score_export_forimport',['major_id'=>$major_id,'school_id' => $school_id ]));
    }

    public function major_score_export_forimport()
    {
        $major_id = input('major_id','');
        $school_id = input('school_id','');

        $map['m.major_id'] = $major_id;
        $map['m.school_id'] = $school_id;

        $where = "ms.major_score_status IS NUll or ms.major_score_status <= 0";

        $subject_ids = isset($_POST['subject_id']) ? implode(',', $_POST['subject_id']) : '';

        $subject_list = SubjectModel::get_subject_list($major_id, $school_id, '', $subject_ids);

        $data = $this->scoreModel->getMajorScoreList($map,$where,'',$subject_list,0);

        $score_list = $data['score_list'];
        $major = MajorModel::get_major_detail($major_id,$school_id);
        $major_name = $major['major_name'];

        $school = Db::name('school')->where(['school_id' =>$school_id ])->find();

        $major_subject_name_arr = array_column($subject_list,'subject_name');

        $score_list = $this->scoreModel->handleMajorScoreList($score_list,$major_subject_name_arr,config("status_title"));

        $field_titles = ['考生ID','姓名','身份证号','中职专业'];
        $i = 4;
        foreach ($major_subject_name_arr as $k => $major) {
            $field_titles[$i] = $major;
            $i++;
        }

        $fields = ['0' => 'member_list_id','1' => 'member_list_nickname','2' => 'member_list_username','3' => 'major_name'];
        $i = 4; $j = 0;
        foreach ($major_subject_name_arr as $k => $major) {
            $fields[$i] = 'major_'.$j;
            $i++;
            $j++;
        }

        $table = $school['school_name'].$major_name.'转段考核成绩录入模板';

        export_excel($score_list,$table,$field_titles,$fields);

    }
}