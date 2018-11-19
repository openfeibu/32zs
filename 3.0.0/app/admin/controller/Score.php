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

class Score extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->schoolModel = new SchoolModel();
        $this->scoreModel = new ScoreModel();
    }
    public function score_list()
    {
        $search_key= trim(input('search_key',''));

        $admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
					->join(config('database.prefix').'auth_group c','b.group_id = c.id')
					->where(array('a.admin_id'=>session('admin_auth.aid')))
					->find();

        $major_ids = json_decode($admin['major_id'],true);

        $major_list = [];

        $major_id = input('major_id',$major_ids['0']);

        $school_id = input('school_id',$admin['school_id']);

        $major_score_status = input('major_score_status','');

        $map['m.major_id'] = $major_id;

        $map['m.school_id'] = $admin['school_id'];


        //$map['ms.subject_id'] = $admin['school_id'];
        $where = $mapor = '';
        if($major_score_status == 1){
            $map['ms.major_score_status'] = $major_score_status;
        }else if($major_score_status == ''){

        }else{
            $where .= '( ms.major_score_status IS NULL or ms.major_score_status <= 0)';
        }

        $subject_ids = isset($_POST['subject_id']) ? implode(',',$_POST['subject_id']): '' ;

        $subject_list = SubjectModel::get_subject_list($major_id,$school_id,'',$subject_ids);

        $major_subject_name_arr = array_column($subject_list, 'subject_name');
        $this->assign('major_subject_name_arr',$major_subject_name_arr);

        $data = $this->scoreModel->getMajorScoreList($map,$where,$search_key,$subject_list);

        $score_list = $data['score_list'];

        $major = MajorModel::get_major_detail($major_id,$admin['school_id']);

        $status = config("status");

        $score_list = $this->scoreModel->handleMajorScoreList($score_list,$major_subject_name_arr,$status);

		$page = $data['page'];

        $major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
        $this->assign('major_id',$major_id);
        $this->assign('major_score_status',$major_score_status);
        $this->assign('major_list',$major_list);
		$this->assign('data',$score_list);
		$this->assign('page',$page);
        $this->assign('search_key',$search_key);
        $this->assign('all_subject_list',$major['subjects']);

        if(request()->isAjax()){
            return $this->fetch('ajax_score_list');
        }else{
            return $this->fetch();
        }
    }
	 public function score_all()
    {
        $search_key= trim(input('search_key',''));
        $major_id = input('major_id','');
        $recruit_major_id = input('recruit_major_id','');
        $school_id = input('school_id','');
        $major_score_status = input('major_score_status','');
        $this->assign('major_score_status',$major_score_status);
        $map = [];
        $major_list = [];
        $where = $mapor = '';
        if($major_id){
            $map['m.major_id'] = $major_id;
        }
        if($school_id){
            $map['m.school_id'] = $school_id;
            $major_list = MajorModel::get_major_list($school_id);
        }
        if($major_score_status == 1){
            $map['ms.major_score_status'] = $major_score_status;
        }else if($major_score_status == ''){

        }else{
            $where .= '( ms.major_score_status IS NULL or ms.major_score_status <= 0)';
        }
        if($major_id && $school_id)
        {
            $subject_ids = isset($_POST['subject_id']) ? implode(',',$_POST['subject_id']): '' ;

            $subject_list = SubjectModel::get_subject_list($major_id,$school_id,'',$subject_ids);

            $data = $this->scoreModel->getMajorScoreList($map,$where,$search_key,$subject_list);
        }
        else{
            $data = $this->scoreModel->getMajorScoreList($map,$where,$search_key);
        }

		$score_list = $data['score_list'];
		$status = config("status");

		foreach($score_list as $key => $val)
		{
            $recruit_major = Db::name('recruit_major')->alias('rm')
                                    ->join(config('database.prefix').'enrollment e','e.recruit_major_id = rm.recruit_major_id')
                                    ->where(array('e.major_ids' => array('LIKE' , '%,'.$val['major_id'].',%')))
                                    ->where(array('e.school_id' => $val['school_id']))
                                    ->find();
            $score_list[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
            $major = MajorModel::get_major_detail($val['major_id'],$val['school_id']);
            $major_subject_name_arr = $major['major_subject_name_arr'];
            $major_score_arr = $val['major_score_arr'];
            $major_score_desc = major_score_desc($major_subject_name_arr,$major_score_arr);
            $major_score_arr = handle_major_score_arr($major_subject_name_arr,$major_score_arr);
            $score_list[$key]['major_score_arr'] = $major_score_arr;
            $score_list[$key]['major_score_desc'] = $major_score_desc;
            $major_score_status = $val['major_score_status'] ? $val['major_score_status'] : 0 ;
            $score_list[$key]['major_score_status'] = $major_score_status ;
			$score_list[$key]['status_desc'] = $status[$major_score_status] ;
			$score_list[$key]['major_subject_name_arr'] =  $major_subject_name_arr;
            $major_score_total = handle_major_score($major_score_arr);
            $score_list[$key]['major_score_total'] = $major_score_total;
		}

		$page = $data['page'];
        $school_list = Db::name('school')->select();

		$this->assign('school_list',$school_list);
        $this->assign('major_list',$major_list);
        $this->assign('school_id',$school_id);
        $this->assign('major_id',$major_id);
		$this->assign('data',$score_list);
		$this->assign('page',$page);
        $this->assign('search_key',$search_key);
        if(request()->isAjax()){
            return $this->fetch('ajax_score_all');
        }else{
            return $this->fetch();
        }
    }
    public function score_add()
    {
        $member_list_id = input('member_list_id');
        $member_list_edit = Db::name('member_list')->where(array('member_list_id' => $member_list_id))->find();

        $major = MajorModel::get_major_detail($member_list_edit['major_id'],$member_list_edit['school_id']);
        $major_subject_score_arr = $this->scoreModel->get_member_major_score($member_list_id,$major['subjects']);
		$this->assign('major_subject_score_arr',$major_subject_score_arr);
        $this->assign('member_list_edit',$member_list_edit);
        return $this->fetch();
    }
    public function score_runadd()
    {
        $member_list_id = $_POST['member_list_id'];
        $subject_id = $_POST['subject_id'];
        if(!$member_list_id || !$subject_id){
            $this->error('参数错误！');
        }
        $major_score = $_POST['score'];
        if(is_array($major_score))
        {
            $major_score = array_filter($major_score);
            foreach ($major_score as $key => $val)
            {
                $data = $this->scoreModel->majorScoreAdd($member_list_id,$subject_id[$key],$val);
            }
        }else{
            $data = $this->scoreModel->majorScoreAdd($member_list_id,$subject_id,$major_score);
        }

        if($data['error']){
            $this->error($data['content']);
        }else{
            $this->success($data['content'],url('admin/Score/score_list'));
        }
    }
	public function score_del()
	{
		$p=input('p');
		$rst=Db::name('major_score')->where(array('member_list_id'=>input('member_list_id')))->delete();
		if($rst!==false){
			$this->success('删除成功',url('admin/Score/score_list',array('p' => $p)));
		}else{
			$this -> error("删除失败！",url('admin/Score/score_list',array('page' => $p)));
		}
	}
    public function check_score_list_export()
    {
        $major_id = input('major_id','');
        $unauditing_count = Db::name('member_list')->alias('m')->join(config('database.prefix').'major_score ms','m.member_list_id = ms.member_list_id','left')->where('ms.major_score_status IS NUll or ms.major_score_status <= 0')->where(['m.major_id' => $major_id,'m.school_id' => $this->admin['school_id']])->count();
        if($unauditing_count>0)
        {
            $this -> error("该专业存在未审核成绩，无法导出。");
        }
        $this->success('导出');
    }
    public function score_list_export()
    {
        $major_id = input('major_id','');

        $map['m.major_id'] = $major_id;

        $map['m.school_id'] = $this->admin['school_id'];

        $map['ms.major_score_status'] = 1;

        $subject_ids = isset($_POST['subject_id']) ? implode(',', $_POST['subject_id']) : '';

        $subject_list = SubjectModel::get_subject_list($major_id, $this->admin['school_id'], '', $subject_ids);

        $data = $this->scoreModel->getMajorScoreList($map,'','',$subject_list,0);

        $major = MajorModel::get_major_detail($major_id,$this->admin['school_id']);

        $school = Db::name('school')->where(['school_id' =>$this->admin['school_id'] ])->find();

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

	public function score_active()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/score/score_list',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id ='.$ids;
		}

		$rst=Db::name('major_score')->where($where)->setField('major_score_status',1);
		if($rst!==false){
			$this->success("操作成功",url('admin/score/score_list',array('page' => $p)));
		}else{
			$this -> error("操作失败！",url('admin/score/score_list',array('page' => $p)));
		}
	}
	public function score_unactive()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/score/score_all',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}

		$rst=Db::name('major_score')->where($where)->setField('major_score_status',0);
		if($rst!==false){
			$this->success("操作成功",url('admin/score/score_all',array('page' => $p)));
		}else{
			$this -> error("操作失败！",url('admin/score/score_all',array('page' => $p)));
		}
	}

    public function major_score_import()
    {
        $major_ids = json_decode($this->admin['major_id'],true);
        if (!empty($_FILES['file_stu']['name'])){
            $major_id = input('major_id','');
            if(!$major_id)
            {
                $this->error('请先选择中职专业');
            }
            if(!in_array($major_id,$major_ids))
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
            $major = MajorModel::get_major_detail($major_id,$this->admin['school_id']);
            $major_subject_name_arr = $major['major_subject_name_arr'];
            $this->assign('major_subject_name_arr',$major_subject_name_arr);
            $data = [];
            foreach ( $res as $k => $v ){
                if ($k == 1)
                {
                    $excel_subject_name_arr = array_slice($v,4);
                    foreach ($excel_subject_name_arr as $key => $excel_subject_name)
                    {
                        $subject = Db::name('subject')->where('school_id',$this->admin['school_id'])->where('major_id',$major_id)->where('subject_name',trim($excel_subject_name))->where(get_year_where())->find();
                        $excel_subject_list[] = $subject;
                    }
                }
	            if ($k != 1 && trim($v[0])){
                    if($major['major_name'] != trim($v[3])){
                        $this->error('提交的excel数据中的中职专业与筛选中的中职专业不符');
                    }
                    $member_list_id = trim($v[0]);
                    $major_score_data = Db::name('major_score')->where(array('member_list_id' => $member_list_id))->field('major_score_status')->find();
                    $member_list = Db::name('member_list')->where(array('member_list_id' => $member_list_id,'major_id' => $major_id,'school_id' => $this->admin['school_id']))->field('member_list_id')->find();
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

        $major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
        $this->assign('major_list',$major_list);
        return $this->fetch();
    }
    public function check_major_score_import()
    {
        $major_id = input('major_id','');

        $map['s.major_id'] = $major_id;

        $map['s.school_id'] = $this->admin['school_id'];

        $subject = Db::name('subject')->alias('s')->where($map)->where(get_year_where('s'))->find();
        if(!$subject)
        {
            $this->error('该中职专业下未设置科目，无法导出模板');
        }
        $this->success('',url('admin/score/major_score_export_forimport',['major_id' => $major_id]));
    }
    public function major_score_export_forimport()
    {
        $major_id = input('major_id','');

        $map['m.major_id'] = $major_id;

        $map['m.school_id'] = $this->admin['school_id'];

        $where = "ms.major_score_status IS NUll or ms.major_score_status <= 0";

        $subject_ids = isset($_POST['subject_id']) ? implode(',', $_POST['subject_id']) : '';

        $subject_list = SubjectModel::get_subject_list($major_id, $this->admin['school_id'], '', $subject_ids);

        $data = $this->scoreModel->getMajorScoreList($map,'','',$subject_list,0);

        $score_list = $data['score_list'];

        $major = MajorModel::get_major_detail($major_id,$this->admin['school_id']);
        $major_name = $major['major_name'];

        $school = Db::name('school')->where(['school_id' =>$this->admin['school_id'] ])->find();

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

        $table = '转段考核成绩录入模板（'.$major_name.'）';

        export_excel($score_list,$table,$field_titles,$fields);

    }
    public function major_score_export_runimport()
    {
        $major_ids = json_decode($this->admin['major_id'],true);
        $major_id = input('major_id','');
        if(!$major_id)
        {
            $this->error('请先选择中职专业');
        }
        if(!in_array($major_id,$major_ids))
        {
            $this->error('请勿操作其他中职专业');
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
        $this->success('操作成功',url('admin/score/score_list',['major_id' => $major_id]));
    }

    public function recruit_score_list()
    {
        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
        $map = [];
        $where = $mapor = '';
        $school_id_arr = $major_id_arrs = array();
        $school_id_arr = array_column($school_list,'school_id');
        $major_id_arrs = $this->schoolModel->get_school_list_major_ids($school_list);

        $map['mj.major_id'] = ['in',$major_id_arrs];

        $search_key= trim(input('search_key',''));
        $major_id = input('major_id','');
        $recruit_major_id = input('recruit_major_id',$this->admin['recruit_major_id']);
        $school_id = input('school_id','');

        if($major_id){
            $map['m.major_id'] = $major_id;
        }
        if($school_id){
            $map['m.school_id'] = $school_id;
        }else{
            $map['m.school_id'] = ['in',$school_id_arr];
        }

        $recruit_major_score_status = input('recruit_major_score_status','');

        if($recruit_major_score_status == 1){
            $map['rms.recruit_major_score_status'] = $recruit_major_score_status;
        }else if($recruit_major_score_status == ''){

        }else{
            $where .= '( rms.recruit_major_score_status IS NULL or rms.recruit_major_score_status <= 0)';
        }

		$score_list = $this->scoreModel->getRecruitMajorScoreList($map,$where,$search_key);

		$data = $score_list->all();
		$status = config("status");

		$data = $this->scoreModel->handleRecruitMajorScoreList($data,$status,'');

		$page = $score_list->render();

		$this->assign('school_list',$school_list);
		$this->assign('data',$data);
        $this->assign('school_id',$school_id);
        $this->assign('major_id',$major_id);
        $this->assign('recruit_major_score_status',$recruit_major_score_status);
		$this->assign('page',$page);
        $this->assign('search_key',$search_key);
        if(request()->isAjax()){
            return $this->fetch('ajax_recruit_score_list');
        }else{
            return $this->fetch();
        }
    }
    public function check_recruit_score_list_export()
    {
        $school_id = input('school_id','');
        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
        $school_id_arr = $major_id_arr = array();
        $map = [];
        $where = '';
        $school_id_arr = $major_id_arrs = array();
        foreach ($school_list as $school_key => $school_value) {
            $school_id_arr[] = $school_value['school_id'];
            $major_id_arr = array_filter(explode(',',$school_value['major_ids']));
            $major_id_arrs = array_merge($major_id_arrs,$major_id_arr);
        }
        if($school_id){
            $map['m.school_id'] = $school_id;
        }else{
            $map['m.school_id'] = ['in',$school_id_arr];
        }
        $map['m.major_id'] = ['in',$major_id_arrs];
        $where = ' (rms.recruit_major_score_status IS NULL or rms.recruit_major_score_status <= 0) ';

        $unauditing_count = Db::name('member_list')->alias('m')->join(config('database.prefix').'recruit_major_score rms','m.member_list_id = rms.member_list_id','left')->where(get_year_where('m'))->where($where)->where($map)->count();

        if($unauditing_count>0)
        {
            $this -> error("所选中职学校存在未审核成绩，无法导出。");
        }
        $this->success('导出');

    }
    public function recruit_score_list_export()
    {
        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
        $school_id_arr = $major_id_arr = array();
        $map = [];
        $where = '';

        $school_id_arr = $major_id_arrs = array();
        foreach ($school_list as $school_key => $school_value) {
            $school_id_arr[] = $school_value['school_id'];
            $major_id_arr = array_filter(explode(',',$school_value['major_ids']));
            $major_id_arrs = array_merge($major_id_arrs,$major_id_arr);
        }

        $map['mj.major_id'] = ['in',$major_id_arrs];

        $major_id = input('major_id','');
        $recruit_major_id = input('recruit_major_id','');
        $school_id = input('school_id','');
        $recruit_major_score_status = input('recruit_major_score_status','');

        if($major_id){
            $map['m.major_id'] = $major_id;
        }
        if($school_id){
            $map['m.school_id'] = $school_id;
        }else{
            $map['m.school_id'] = ['in',$school_id_arr];
        }

        $data = $this->scoreModel->getRecruitMajorScoreList($map,$where,'',0);

		$status = config("status_title");
        $recruit_major = Db::name('recruit_major')->where('recruit_major_id',$this->admin['recruit_major_id'])->find();

        $data = $this->scoreModel->handleRecruitMajorScoreList($data,$status,$recruit_major);

        $field_titles = ['序号','姓名','中职考生号','身份证号','中职学校','中职专业','技能考核成绩','状态'];

        $fields = ['no','member_list_nickname','ZexamineeNumber','member_list_username','school_name','major_name','recruit_major_score','status_desc'];

        $table = $recruit_major['recruit_major_name'].'专业技能考核成绩单'.date('Ymd');
        $title = $recruit_major['recruit_major_name'].'专业      技能考核成绩单';
        $this->recruit_score_list_export_pdf($field_titles,$fields,$data,$table,$title);

        return false;

    }
    public function recruit_score_add()
    {

    }
	public function recruit_score_runedit()
    {
        $member_list_id = input('member_list_id');
        $recruit_major_score = input('recruit_major_score',0);
        return $this->scoreModel->recruitScoreAdd($member_list_id,$recruit_major_score);

    }
	public function recruit_score_all()
    {
        $search_key= trim(input('search_key',''));
        $major_id = input('major_id','');
        $recruit_major_id = input('recruit_major_id','');
        $school_id = input('school_id','');
        $map = [];
        $where = '';
        if($major_id){
            $map['m.major_id'] = $major_id;
        }
        if($school_id){
            $map['m.school_id'] = $school_id;
        }
        if($recruit_major_id){
            $map['rm.recruit_major_id'] = $recruit_major_id;
        }

        $major_id = input('major_id','');

        $school_id = input('school_id','');
        $recruit_major_score_status = input('recruit_major_score_status','');

        if($recruit_major_score_status != ''){
            $where = 'rms.recruit_major_score_status = '.$recruit_major_score_status;
        }else{
            $map['rms.recruit_major_score'] = ['<>','NULL'];
        }

        $score_list = $this->scoreModel->getRecruitMajorScoreList($map,$where,$search_key);

		$data = $score_list->all();
		$status = config("status");

		foreach($data as $key => $val)
		{
            $recruit_major = Db::name('recruit_major')->alias('rm')
                                    ->join(config('database.prefix').'enrollment e','e.recruit_major_id = rm.recruit_major_id')
                                    ->where(array('e.major_ids' => array('LIKE' , '%,'.$val['major_id'].',%')))
                                    ->find();
            $data[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
            $val_recruit_major_score_status = $val['recruit_major_score_status'] ? $val['recruit_major_score_status'] : 0;
			$data[$key]['status_desc'] = $status[$val_recruit_major_score_status];
		}

		$page = $score_list->render();
        $school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
        $this->assign('school_id',$school_id);
		$this->assign('data',$data);
		$this->assign('page',$page);
        $this->assign('search_key',$search_key);
        $this->assign('recruit_major_score_status',$recruit_major_score_status);
        if(request()->isAjax()){
            return $this->fetch('ajax_recruit_score_all');
        }else{
            return $this->fetch();
        }
    }

	public function recruit_score_active()
	{
		$p = input('p');
        $school_id = input('school_id');
        $major_id = input('major_id');
		$ids = input('n_id/a');
        $post = input('post.');
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/score/recruit_score_all',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id ='.$ids;
		}
        $rst=Db::name('recruit_major_score')->where($where)->setField('recruit_major_score_status',1);
		if($rst!==false){
			$this->success("操作成功",url('admin/score/recruit_score_list',array('p'=>$p,'school_id' =>$school_id,'major_id'=>$major_id )));
		}else{
			$this -> error("操作失败！",url('admin/score/recruit_score_list',array('p'=>$p,'school_id' =>$school_id,'major_id'=>$major_id )));
		}
	}
	public function recruit_score_unactive()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/score/recruit_score_all',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}

		$rst=Db::name('recruit_major_score')->where($where)->setField('recruit_major_score_status',0);
		if($rst!==false){
			$this->success("操作成功",url('admin/score/recruit_score_all',array('page' => $p)));
		}else{
			$this -> error("操作失败！",url('admin/score/recruit_score_all',array('page' => $p)));
		}
	}

    public function score_list_export_pdf($field_titles=array(),$fields=array(),$data=array(),$table='Newfile',$title){

		set_time_limit(120);
		if(empty($field_titles) || empty($data)) $this->error("导出的数据为空！");
		require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/ScoreListTCPDF.php');
		$pdf = new \ScoreListTCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);//新建pdf文件
		 //设置文件信息
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(config('pdf_common.author'));
		$pdf->SetTitle($table);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //设置页眉页脚
        $pdf->SetHeaderData('', '', config('pdf_common.header_name'),$title,array(66,66,66), array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(5, 24, 5);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, 40);//设置自动分页符
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setLanguageArray($l);
        $pdf->SetFont('droidsansfallback', '');
        $pdf->AddPage();

        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(66, 66, 66);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('droidsansfallback', '',9);
        // Header
        $num_headers = count($field_titles);
        for($i = 0; $i < $num_headers; ++$i) {
        	$pdf->MultiCell(280/$num_headers, 8, $field_titles[$i], $border=1, $align='C',1, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
        }
        $pdf->Ln();

        // 填充数据
        $fill = 0;
        foreach($data as $list) {
            //每頁重复表格标题行
            if(($pdf->getPageHeight()-$pdf->getY())<($pdf->getBreakMargin()+2)){
                $pdf->AddPage();
                $pdf->SetFillColor(245, 245, 245);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(66, 66, 66);
                $pdf->SetLineWidth(0.3);
                $pdf->SetFont('droidsansfallback', '',9);
                // Header
                for($i = 0; $i < $num_headers; ++$i) {
                	$pdf->MultiCell(280/$num_headers, 8, $field_titles[$i], $border=1, $align='C',1, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
                }

                $pdf->Ln();

            }
            // Color and font restoration
            $pdf->SetFillColor(245, 245, 245);
            $pdf->SetTextColor(40);
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('droidsansfallback', '');

            foreach($fields as $i=>$name){
				$pdf->MultiCell(280/$num_headers, 6, $list[$name], $border=1, $align='C',$fill, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
            }

            $pdf->Ln();
            $fill=!$fill;
        }


		// reset pointer to the last page
		$pdf->lastPage();

        $showType= 'D';//PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
        $pdf->Output("{$table}.pdf", $showType);
        exit;
	}
    public function recruit_score_list_export_pdf($field_titles=array(),$fields=array(),$data=array(),$table='Newfile',$title)
    {
        set_time_limit(120);
		if(empty($field_titles) || empty($data)) $this->error("导出的数据为空！");
        require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/RecruitScoreListTCPDF.php');
		$pdf = new \RecruitScoreListTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);//新建pdf文件
		 //设置文件信息
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(config('pdf_common.author'));
		$pdf->SetTitle($table);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //设置页眉页脚
        $pdf->SetHeaderData('', '', config('pdf_common.header_name'),$title,array(66,66,66), array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, 30);//设置自动分页符
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setLanguageArray($l);
        $pdf->SetFont('droidsansfallback', '');
        $pdf->AddPage();

        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(66, 66, 66);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('droidsansfallback', '',9);
        // Header
        $num_headers = count($field_titles);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell(180/$num_headers, 8, $field_titles[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();

        // 填充数据
        $fill = 0;
        foreach($data as $list) {
            //每頁重复表格标题行
            if(($pdf->getPageHeight()-$pdf->getY())<($pdf->getBreakMargin()+2)){
                $pdf->SetFillColor(245, 245, 245);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(66, 66, 66);
                $pdf->SetLineWidth(0.3);
                $pdf->SetFont('droidsansfallback', '',9);
                // Header
                for($i = 0; $i < $num_headers; ++$i) {
                    $pdf->Cell(180/$num_headers, 8, $field_titles[$i], 1, 0, 'C', 1);
                }
                $pdf->Ln();
            }
            // Color and font restoration
            $pdf->SetFillColor(245, 245, 245);
            $pdf->SetTextColor(40);
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('droidsansfallback', '');

            foreach($fields as $i=>$name){
				$pdf->MultiCell(180/$num_headers, 6, $list[$name], $border=1, $align='C',$fill, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
            }

            $pdf->Ln();
            $fill=!$fill;
        }

		// reset pointer to the last page
		$pdf->lastPage();

        $showType= 'D'; //PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
        $pdf->Output("{$table}.pdf", $showType);
        exit;
    }

    public function recruit_score_import()
    {
        $recruit_major_id = $this->admin['recruit_major_id'];
        $school_list = $this->schoolModel->get_school_list_rmi($recruit_major_id);
        $school_id = input('school_id','');
        $this->assign('school_id',$school_id);
        if (!empty($_FILES['file_stu']['name'])){
            $post_file = $_FILES ['file_stu'];
            $savePath = ROOT_PATH. 'public/excel/';
            $file = uploadFile($post_file,$savePath);
            $res = read($file);
			if (!$res){
				$this->error ('数据处理失败');
			}

            $data = [];
            foreach ( $res as $k => $v ){
	            if ($k != 1 && trim($v[0])){
                    $school = Db::name('school')->where('school_id',$school_id)->field('school_name')->find();
                    if($school['school_name'] != trim($v[4]))
                    {
                        $this->error ('请选择对应中职学校');
                    }
                    $member_list_id = trim($v[0]);
                    $recruit_major_score_data = Db::name('recruit_major_score')->where(array('member_list_id' => $member_list_id))->field('recruit_major_score_status')->find();
                    $major_id_arrs = $this->schoolModel->get_school_list_major_ids($school_list);
                    $member_list = Db::name('member_list')->where(array('member_list_id' => $member_list_id,'major_id' => ['in',$major_id_arrs]))->field('member_list_id')->find();
                    if(!$member_list || ($recruit_major_score_data && $recruit_major_score_data['recruit_major_score_status'] == 1))
                    {
                        continue;
                    }
                    $data[$k]['member_list_id'] = $member_list_id;
                    $data[$k]['member_list_nickname'] = trim($v[1]);
                    $data[$k]['member_list_username'] = trim($v[2]);
                    $data[$k]['recruit_major_name'] = trim($v[5]);
                    $data[$k]['school_name'] = trim($v[4]);
                    $data[$k]['major_name'] = trim($v[5]);
                    $data[$k]['recruit_major_score'] = trim($v[6]);
                }
            }
            $this->assign('data',$data);
            return $this->fetch('ajax_recruit_score_import');
        }
        $this->assign('school_list',$school_list);
        return $this->fetch();
    }
    public function recruit_score_export_forimport()
    {
        $recruit_major_id = $this->admin['recruit_major_id'];
        $school_id = input('school_id','');
        $school = Db::name('school')->where(['school_id' => $school_id])->find();
        $school_list = $this->schoolModel->get_school_list_rmi($recruit_major_id);
        $school_id_arr = $major_id_arr = array();
        $map = [];
        $where = '';

        $school_id_arr = $major_id_arrs = array();
        foreach ($school_list as $school_key => $school_value) {
            $school_id_arr[] = $school_value['school_id'];
            $major_id_arr = array_filter(explode(',',$school_value['major_ids']));
            $major_id_arrs = array_merge($major_id_arrs,$major_id_arr);
        }
        $map['mj.major_id'] = ['in',$major_id_arrs];
        if($school_id){
            $map['m.school_id'] = $school_id;
        }else{
            $map['m.school_id'] = ['in',$school_id_arr];
        }
        $where .= '( rms.recruit_major_score_status IS NULL or rms.recruit_major_score_status <= 0)';

        $data = $this->scoreModel->getRecruitMajorScoreList($map,$where,'',0);

		$status = config("status_title");
        $recruit_major = Db::name('recruit_major')->where('recruit_major_id',$recruit_major_id)->find();

        $data = $this->scoreModel->handleRecruitMajorScoreList($data,$status,$recruit_major);

        $field_titles = ['考生ID','姓名','身份证号','高职专业','中职学校','中职专业','技能成绩'];

        $fields = ['member_list_id','member_list_nickname','member_list_username','recruit_major_name','school_name','major_name','recruit_major_score'];

        $table = '技能考核成绩录入模板（'.$school['school_name'].'）';

        export_excel($data,$table,$field_titles,$fields);
    }
    public function recruit_score_runimport()
    {
        $member_list_ids = input('n_id/a');
        $post_score = input('recruit_major_score/a');
        $school_id = input('school_id','');
        foreach ($member_list_ids as $key => $member_list_id) {
            $recruit_score = $post_score[$key];
            $this->scoreModel->recruitScoreAdd($member_list_id,$recruit_score);
        }
        $this->success('操作成功',url('admin/score/recruit_score_list',['school_id' => $school_id]));
    }
    public function sec_vocat_recruit_score_list()
    {
        $major_ids = json_decode($this->admin['major_id'],true);
        $school_id = $this->admin['school_id'];
        $recruit_major_list = RecruitMajorModel::get_sec_vocat_recruit_major_list($school_id,$major_ids);

        $map = [];
        $where = '';

        $recruit_major_id = input('recruit_major_id',current($recruit_major_list)['recruit_major_id']);
        $enrollment = Db::name('enrollment')->where(['school_id' => $school_id,'recruit_major_id' => $recruit_major_id])->find();
        $recruit_major = Db::name('recruit_major')->where(['recruit_major_id' => $recruit_major_id])->find();
        $major_ids = array_filter(explode(',',$enrollment['major_ids']));
        $map['s.school_id'] = $school_id;
        $map['mj.major_id'] = array('in',$major_ids);

		$score_list = $this->scoreModel->getRecruitMajorScoreList($map,$where,'');

		$data = $score_list->all();
		$status = config("status");

		$data = $this->scoreModel->handleRecruitMajorScoreList($data,$status,'');
		$page = $score_list->render();

		$this->assign('data',$data);
        $this->assign('recruit_major_list',$recruit_major_list);
        $this->assign('recruit_major',$recruit_major);
		$this->assign('page',$page);
        if(request()->isAjax()){
            return $this->fetch('ajax_sec_vocat_recruit_score_list');
        }else{
            return $this->fetch();
        }
    }
    public function school_recruit_score_export()
    {
        $recruit_major_id = input('recruit_major_id','');
        $school_id = $this->admin['school_id'];
        $school = Db::name('school')->where(['school_id' => $school_id])->find();
        $enrollment = Db::name('enrollment')->where(['school_id' => $school_id,'recruit_major_id' => $recruit_major_id])->find();
        $recruit_major = Db::name('recruit_major')->where(['recruit_major_id' => $recruit_major_id])->find();
        $major_ids = array_filter(explode(',',$enrollment['major_ids']));
        $map = [];
        $where = '';
        $map['m.school_id'] = $school_id;
        $map['mj.major_id'] = ['in',$major_ids];

        $data = $this->scoreModel->getRecruitMajorScoreList($map,$where,'',0);

		$status = config("status_title");

        $data = $this->scoreModel->handleRecruitMajorScoreList($data,$status,$recruit_major);
        $title = $school['school_name'].'      对口'.$recruit_major['recruit_major_name'].'专业      ';
        $table = $recruit_major['recruit_major_name']."专业";
        if(!$is_score = input('score',1)){
            foreach($data as $k => $v)
            {
                $data[$k]['recruit_major_score'] = '';
            }
            $table.='技能考核登分表';
            $title.="技能考核登分表";
        }else{
            $table.='技能考核成绩单';
            $title.="技能考核成绩单";
        }
        $table.="(".$school['school_name'].")".date('Ymd');
        $field_titles = ['序号','姓名','中职考生号','身份证号','中职专业','技能考核成绩'];

        $fields = ['no','member_list_nickname','ZexamineeNumber','member_list_username','major_name','recruit_major_score'];

        $this->school_recruit_score_export_pdf($field_titles,$fields,$data,$table,$title,$is_score);

        //export_excel($data,$table,$field_titles,$fields);
    }
    private function school_recruit_score_export_pdf($field_titles=array(),$fields=array(),$data=array(),$table,$title,$is_score = 1)
    {
        set_time_limit(120);
        require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        if($is_score == 1)
        {
            require_once(EXTEND_PATH . 'tcpdf/SchoolRecruitScoreListTCPDFWithScore.php');
            $pdf = new \SchoolRecruitScoreListTCPDFWithScore('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        }else{
            require_once(EXTEND_PATH . 'tcpdf/SchoolRecruitScoreListTCPDF.php');
            $pdf = new \SchoolRecruitScoreListTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        }

		 //设置文件信息
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(config('pdf_common.author'));
		$pdf->SetTitle($table);
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //设置页眉页脚
        $pdf->SetHeaderData('', '', config('pdf_common.header_name'),$title,array(66,66,66), array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, 30);//设置自动分页符
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setLanguageArray($l);
        $pdf->SetFont('droidsansfallback', '');
        $pdf->AddPage();

        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(66, 66, 66);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('droidsansfallback', '',9);
        // Header
        $num_headers = count($field_titles);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell(180/$num_headers, 8, $field_titles[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();

        // 填充数据
        $fill = 0;
        foreach($data as $list) {
            //每頁重复表格标题行
            if(($pdf->getPageHeight()-$pdf->getY())<($pdf->getBreakMargin()+2)){
                $pdf->SetFillColor(245, 245, 245);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(66, 66, 66);
                $pdf->SetLineWidth(0.3);
                $pdf->SetFont('droidsansfallback', '',9);
                // Header
                for($i = 0; $i < $num_headers; ++$i) {
                    $pdf->Cell(180/$num_headers, 8, $field_titles[$i], 1, 0, 'C', 1);
                }
                $pdf->Ln();
            }
            // Color and font restoration
            $pdf->SetFillColor(245, 245, 245);
            $pdf->SetTextColor(40);
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('droidsansfallback', '');

            foreach($fields as $i=>$name){
				$pdf->MultiCell(180/$num_headers, 6, $list[$name], $border=1, $align='C',$fill, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
            }

            $pdf->Ln();
            $fill=!$fill;
        }

		// reset pointer to the last page
		$pdf->lastPage();

        $showType= 'D'; //PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
        $pdf->Output("{$table}.pdf", $showType);
        exit;
    }
}
