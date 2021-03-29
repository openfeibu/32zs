<?php
/**
 * Created by PhpStorm.
 * User: FHYI
 * Date: 2019/10/31
 * Time: 16:12
 */

namespace app\admin\controller;
use app\admin\model\School as SchoolModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\MajorResitScore as MajorResitScoreModel;
use app\admin\model\Score as ScoreModel;
use app\admin\model\Subject as SubjectModel;
use app\admin\model\Export as ExportModel;
use app\admin\controller\Auth;
use think\Db;
use think\Cache;
use think\Loader;
use think\Session;
//recruit_major_score
class MajorResitScore extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->schoolModel = new SchoolModel();
        $this->scoreModel = new ScoreModel();
        $this->MajorResitScoreModel = new MajorResitScoreModel();
        $this->exprot_model = new ExportModel();
        $Auth = new Auth();
        $admin_auth = Session('admin_auth');
        $admin_group = $Auth->getGroups($admin_auth['aid']);
        $this->assign('admin_group',$admin_group[0]);
        Session::set('admin_group',$admin_group[0]);
    }
    public function fail_score_list()
    {
        $search_key = trim(input('search_key', ''));
        $major_score_status = input('major_score_status', '');
        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
        $school_id = input('school_id',$school_list[0]['school_id']);
        //查询专业名称
        $major_list = MajorModel::get_major_list($school_id,$this->admin['recruit_major_id']);
        $major_id = input('major_id', $major_list['0']['major_id']);
        $subject_list = SubjectModel::get_subject_list1($major_id, $school_id, get_year());

        if(!$subject_list)
        {
            return $this->error ('请先录入科目');
        }

        $subject_id =  input('subject_id',$subject_list[0]['subject_id']);
        $subject_id_key =  array_search($subject_id, array_column($subject_list, 'subject_id'));

        $subject = $subject_list[$subject_id_key];

        $major_subject_name_arr = array_column($subject_list, 'subject_name');
        $major_subject_id_arr = array_column($subject_list, 'subject_id');

        $major_resit_score_list = Db::name('major_resit_score')->alias("mrs")
            ->join(config('database.prefix').'major_score ms','ms.member_list_id = mrs.member_list_id AND ms.subject_id = mrs.subject_id','right')
            ->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id')
            ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
            ->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
            ->join(config('database.prefix').'school sc','m.school_id = sc.school_id')
            ->where(get_year_where('m'))
            ->where('ms.subject_id',$subject_id)
            ->where('ms.major_score','<',$subject['max_score'] * 0.6)
            ->where('ms.major_score','<>','')
            ->where('(ms.major_score_status=1 or mrs.major_resit_score>0)');
        if($major_resit_score_list){
            $major_resit_score_list = $major_resit_score_list->where('m.member_list_username|m.member_list_nickname|mi.ZexamineeNumber','like',"%".$search_key."%");
        }
        $major_resit_score_list = $major_resit_score_list->order('m.member_list_id desc')
            ->group('m.member_list_id')
            ->field('m.member_list_nickname , m.member_list_username, m.member_list_id,m.year,mj.major_name,mj.major_name,m.major_id,m.school_id,mi.ZexamineeNumber,sc.school_name,ms.major_score,mrs.major_resit_score,mrs.major_resit_score_status,ms.subject_id')
            ->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
        //dump($major_resit_score_list);
        $this->assign('major_id', $major_id);
        $this->assign('school_id',$school_id);
        $this->assign('school_list',$school_list);
        $this->assign('major_list', $major_list);
        $this->assign('data', $major_resit_score_list->all());
        $this->assign('page', $major_resit_score_list->render());
        $this->assign('search_key', $search_key);
        $this->assign('major_subject_id_arr', $major_subject_id_arr);
        $this->assign('subject_list', $subject_list);
        $this->assign('subject_id', $subject_id);
        $this->assign('subject', $subject);
        $this->assign('major_score_status', $major_score_status);

        $major_score_status_list = ['','0','1'];
        $this->assign('major_score_status_list', $major_score_status_list);
        $this->assign('major_subject_name_arr', $major_subject_name_arr);



        if (request()->isAjax()) {
            return $this->fetch('major_resit_score/ajax_fail_score_list');
        } else {
            return $this->fetch('major_resit_score/fail_score_list');
        }
    }
    //2019.11.1
    /**
     * 废除于2021.03.26
     * 补考成绩管理
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    /*
    public function fail_score_list()
    {
        $search_key = trim(input('search_key', ''));

        $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);

        $school_id = input('school_id', $school_list[0]['school_id']); // 如果报错就是没有学生
        //2019.11.7
        // $school_now_id = input('school_id');
        // if($school_now_id)
        //     $school_id = $school_now_id;
        // else
        //     $school_id = $school_list[0]['school_id'];

        // dump($school_now_id);

        $major_list = MajorModel::get_major_list($school_id,$this->admin['recruit_major_id']);

        $major_id = input('major_id', $major_list['0']['major_id']);

        $major = MajorModel::get_major_detail($major_id, $school_id,get_year());

        $major_score_status = input('major_score_status', '');

        // 该校的全部科目
        $all_subject_list = $major['subjects'];

        // 没通过的人数
        $fail_member_list_ids = [];

        // 所有专业 all_subject_list
        // dump($all_subject_list);

        // 查询指定科目
        $input_subject_id =  input('subject_id','');

        // 补考科目
        $fail_subject_ids = [];

        // 查询所有未通过的学生 进行记录
        foreach ($all_subject_list as $key => $subject)
        {
            $subject_id = $subject['subject_id'];
            $pass_score = $subject['max_score'] * 0.6;

            $where = "ms.major_score_status = 1 AND ms.major_score != '' AND ms.major_score < ".$pass_score ." AND ms.subject_id =".$subject_id;
            //人数查出
            $member_list_ids = Db::name('major_score')->alias("ms")
                ->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id')
                ->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
                ->where($where)
                ->where(get_year_where())
                ->column('ms.member_list_id');

            // 如果传入科目
            if($input_subject_id){
                if($input_subject_id == $subject_id){
                    $fail_member_list_ids = array_merge($fail_member_list_ids,$member_list_ids);
                }
            }else{
                $fail_member_list_ids = array_merge($fail_member_list_ids,$member_list_ids);
            }

            //写入补考表
            if($member_list_ids){
                // 如果存在，记录补考科目
                $fail_subject_ids[] = $subject_id;
                foreach ($member_list_ids as $list_key => $list_value) {
                    $check_fail = Db::name('recruit_major_score')->where('member_list_id',$list_value)->where('subject_id',$subject_id)->find();
                    if(!$check_fail){
                        $recruit_major_score_data['member_list_id'] =  $list_value;
                        $recruit_major_score_data['subject_id'] =  $subject_id;
                        Db::name('recruit_major_score')->insert($recruit_major_score_data);
                    }
                }
            }
        }

        // 查询实际需要补考的科目
        foreach ($all_subject_list as $key => $subject){
            if(!in_array($subject['subject_id'],$fail_subject_ids)){
                unset($all_subject_list[$key]);
            }
        }
        $show_subject_list = $all_subject_list;

        // 查询指定的科目
        if($input_subject_id) {
            $all_subject_list = [];
            foreach ($show_subject_list as $key => $item) {
                if ($item['subject_id'] == $input_subject_id) {
                    $all_subject_list[] = $item;
                }
            }
        }

        $major_subject_name_arr = array_column($all_subject_list, 'subject_name');
        $major_subject_id_arr = array_column($all_subject_list, 'subject_id');

        $this->assign('major_subject_name_arr', $major_subject_name_arr);

        $fail_member_list_id_where = implode(',',$fail_member_list_ids);
        // echo $fail_member_list_id_where;
        if(!$fail_member_list_id_where)
        {
            $score_list = [];
            $page = [];
        }else{
            $where = "ms.member_list_id in (".$fail_member_list_id_where.") ";
            // $where .= "AND ms.recruit_major_score_status = ".$major_score_status;
            // $major_score_status = (int)$major_score_status;
            // echo intval($major_score_status);
            //查询成绩  补考的
            $data = $this->MajorResitScoreModel->getFailMajorScoreList($where, $search_key, $all_subject_list,$major_score_status);
            // dump($data);
            $score_list = $data['score_list'];

            //查询科目
            $major = MajorModel::get_major_detail($major_id, $school_id);

            $status = config("status");

            //整理数据
            $score_list = $this->MajorResitScoreModel->handleMajorScoreList($score_list, $major_subject_name_arr, $status);
            // dump($score_list);
            // halt($score_list);

            $page = $data['page'];
        }

        $this->assign('major_id', $major_id);
        $this->assign('school_id',$school_id);
        $this->assign('school_list',$school_list);
        $this->assign('major_list', $major_list);
        // dump($major_list);
        $this->assign('data', $score_list);
        $this->assign('page', $page);
        $this->assign('search_key', $search_key);
        $this->assign('major_subject_id_arr', $major_subject_id_arr);
        $this->assign('all_subject_list', $show_subject_list);
        $this->assign('subject_id', $input_subject_id);
        // dump( $major['subjects']);
        $this->assign('major_score_status', $major_score_status);

        $major_score_status_list = ['','0','1'];
        $this->assign('major_score_status_list', $major_score_status_list);

        if (request()->isAjax()) {
            return $this->fetch('major_resit_score/ajax_fail_score_list');
        } else {
            return $this->fetch('major_resit_score/fail_score_list');
        }
    }
    */
    //修改数据
    public function fail_score_runadd()
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
                $data = $this->MajorResitScoreModel->majorResitScoreAdd($member_list_id,$subject_id[$key],$val);
            }
        }else{
            $data = $this->MajorResitScoreModel->majorResitScoreAdd($member_list_id,$subject_id,$major_score);
        }

        if($data['error']){
            $this->error($data['content']);
        }else{
            $this->success($data['content'],url('admin/Score/score_list'));
        }
    }
    //审核
    public function score_active()
    {
        $p = $this->request->post('p');
        $data = $this->request->post();
        if(!isset($data['major_resit_obj'])){
            $this -> error("请选择列表",url('admin/MajorResitScore/fail_score_list',array('page' => $p)));
        }
        // if(is_array($ids)){
        //     $where = 'member_list_id in('.implode(',',$ids).')';
        // }else{
        //     $where = 'member_list_id ='.$ids;
        // }
        $major_resit_objs = $data['major_resit_obj'];
        foreach ($major_resit_objs as $key => $value) {
            foreach ($value as $val) {
                $where['member_list_id'] = $key;
                $where['subject_id'] = $val;
                 $rst=Db::name('major_resit_score')->where($where)
                    ->setField('major_resit_score_status',1);
            }
        }

        if($rst!==false){
            $this->success("操作成功",url('admin/MajorResitScore/fail_score_list',array('page' => $p)));
        }else{
            $this -> error("操作失败！",url('admin/MajorResitScore/fail_score_list',array('page' => $p)));
        }
    }
    public function score_del()
    {

        $p = $this->request->post('p');
        $data = $this->request->post();
        if(!isset($data['major_resit_obj'])){
            $this -> error("请选择列表",url('admin/MajorResitScore/fail_score_list',array('page' => $p)));
        }
        $major_resit_objs = $data['major_resit_obj'];
        foreach ($major_resit_objs as $key => $value) {
            foreach ($value as $val) {
                $where['member_list_id'] = $key;
                $where['subject_id'] = $val;
                $rst=Db::name('major_resit_score')->where($where)->delete();
            }
        }

        if($rst!==false){
            $this->success('删除成功',url('admin/MajorResitScore/fail_score_list',array('p' => $p)));
        }else{
            $this -> error("删除失败！",url('admin/MajorResitScore/fail_score_list',array('page' => $p)));
        }

    }

    //导出
    public function check_score_list_export()
    {
        $major_id = input('major_id','');
        $school_id = input('school_id', '');
        //$subject_ids = input('subject_id/a');
        $subject_id = input('subject_id');
        $unauditing_count = Db::name('member_list')->alias('m')
            ->join(config('database.prefix').'major_resit_score mrs','m.member_list_id = mrs.member_list_id','left')
            ->join(config('database.prefix').'subject s','s.subject_id = ms.subject_id');
        if($subject_id)
        {
            $unauditing_count = $unauditing_count->where('s.subject_id','=',$subject_id);
        }
        $unauditing_count = $unauditing_count->where('mrs.major_resit_score_status IS NUll or mrs.major_resit_score_status <= 0')
            ->where(['m.major_id' => $major_id,'m.school_id' => $school_id])
            ->where(get_year_where('m'))->group('m.member_list_id')
            ->count();
        if($unauditing_count>0)
        {
            // $this->error("该专业存在未审核成绩，无法导出。");
        }
        $this->success('导出');
    }
    /** 待修改 2021.03.26
     * 需修改内容：
     * 1、需先了解此处需求，是导出补考成绩，还是全部成绩
     * 2、recruit_major_score 表需改为 major_resit_score
    */
    public function score_list_export()
    {
        $major_id = input('major_id','');

        $school_id = input('school_id', '');

        $map['m.major_id'] = $major_id;

        $map['m.school_id'] = $school_id;

        $map['ms.recruit_major_score_status'] = 1;

        $subject_id = input('subject_id');
        //$subject_ids = input('subject_id/a') ? implode(',', input('subject_id/a')) : '';
        $subject_ids = $subject_id;

        $subject_list = SubjectModel::get_subject_list($major_id, $school_id, '', $subject_ids);
        // $data = $this->scoreModel->getMajorScoreList($map,'','',$subject_list,0);
        $data = $this->MajorResitScoreModel->getMajorScoreList($map,'','',$subject_list);

        // halt($subject_ids);

        $major = MajorModel::get_major_detail($major_id,$school_id);

        $school = Db::name('school')->where(['school_id' =>$school_id ])->find();

        if($subject_id)
        {
            $file_name = '过程考核成绩单';
        }else{
            $file_name = '转段考核总成绩单';
        }
        $title = '对口  '.$school['school_name'].'  '.get_grade().$major['major_name'].'  '.$file_name;

        $major_subject_name_arr = array_column($subject_list, 'subject_name');

        //$major_subject_name_arr = $major['major_subject_name_arr'];

        $data = $this->scoreModel->handleMajorScoreList($data['score_list'],$major_subject_name_arr,config("status_title"));
        $field_titles = ['序号','姓名','中职考生号','身份证号'];
        $i = 4;
        foreach ($major_subject_name_arr as $k => $mv) {
            $field_titles[$i] = $mv;
            $i++;
        }
        if($subject_id)
        {
            $field_titles[$i] = '审核状态';
        }else{
            $field_titles[$i] = '转段考核总成绩';
            $field_titles[$i+1] = '审核状态';
        }
        $fields = ['no','member_list_nickname','ZexamineeNumber','member_list_username','major_name'];
        $i = 4; $j = 0;
        foreach ($major_subject_name_arr as $k => $mv) {
            $fields[$i] = 'major_'.$j;
            $i++;
            $j++;
        }
        if($subject_id)
        {
            $fields[$i] = 'status_desc';
        }else{
            $fields[$i] = 'major_score_total';
            $fields[$i + 1] = 'status_desc';
        }
        $table = $school['school_name'].get_grade().$major['major_name'].$file_name.date('Ymd');
        $this->exprot_model->header_name = sprintf(config('pdf_common.header_name'),'   '.$this->recruit_major_name.'   ');
        $this->exprot_model->university_score_list_export_pdf($field_titles,$fields,$data,$table,$title);
        return false;

    }
}
