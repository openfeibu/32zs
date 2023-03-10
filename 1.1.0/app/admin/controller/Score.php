<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\School as SchoolModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\Score as ScoreModel;
use think\Db;
use think\Cache;
use think\Loader;

class Score extends Base
{
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

        $school_id = input('school_id','');

        $major_score_status = input('major_score_status','');

        $map['m.major_id'] = $major_id;

        $map['m.school_id'] = $admin['school_id'];

        if($major_score_status){
            $map['ms.major_score_status'] = $major_score_status;
        }

		$score_list = Db::name('major_score')->alias("ms")
						->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','right')
                        ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
                        ->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
						->where($map)
                        ->where('member_list_username|member_list_nickname|ZexamineeNumber','like',"%".$search_key."%")
                        ->order('ms.major_score_status desc')
                        ->order('m.member_list_id desc')
						->field('ms.major_score, ms.major_score_id,ms.major_score_status,m.member_list_nickname , m.member_list_username, m.member_list_id,mj.major_name,mj.major_name,m.major_id,m.school_id,mi.ZexamineeNumber')
						->order('major_score_id desc')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);

		$data = $score_list->all();
		$status = config("status");

        $major = MajorModel::get_major_detail($major_id,$admin['school_id']);


        $major_score = $major['score'] ? json_decode($major['score'],true) :[];
		$major_score = array_filter($major_score);
		$this->assign('major_score',$major_score);

        $major_score_key = $major['major_score_key'] ? array_filter(json_decode($major['major_score_key'],true)) : [];

		foreach($data as $key => $val)
		{
            $major_score_arr = json_decode($val['major_score'],true);
            $major_score_desc = major_score_desc($major_score_key,$major_score_arr);
            $major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
            $data[$key]['major_score_arr'] = $major_score_arr;
            $data[$key]['major_score_desc'] = $major_score_desc;
            $major_score_status = $val['major_score_status'] ? $val['major_score_status'] : 0 ;
            $data[$key]['major_score_status'] = $major_score_status ;
            $data[$key]['status_desc'] = $status[$major_score_status] ;
            $major_score_total = handle_major_score($major_score_arr);
            $data[$key]['major_score_total'] = $major_score_total;
		}

		$page = $score_list->render();


        $major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
        $this->assign('major_id',$major_id);
        $this->assign('major_list',$major_list);
		$this->assign('data',$data);
		$this->assign('page',$page);
        $this->assign('search_key',$search_key);
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
        if($major_id){
            $map['m.major_id'] = $major_id;
        }
        if($school_id){
            $map['m.school_id'] = $school_id;
        }
        if($major_score_status!=''){
            $map['ms.major_score_status'] = $major_score_status;
        }

		$score_list = Db::name('major_score')->alias("ms")
						->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','left')
                        ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
						->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
						->where($map)
                        ->where('member_list_username|member_list_nickname|ZexamineeNumber','like',"%".$search_key."%")
                        ->order('m.member_list_id desc')
						->field('mi.ZexamineeNumber,ms.major_score_id,ms.major_score, ms.major_score_status,m.member_list_nickname , m.member_list_username, m.member_list_id,m.major_id,ms.major_score_id,mj.major_name,m.school_id')
						->order('major_score_id desc')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);

		$data = $score_list->all();
		$status = config("status");

		foreach($data as $key => $val)
		{
            $recruit_major = Db::name('recruit_major')->alias('rm')
                                    ->join(config('database.prefix').'enrollment e','e.recruit_major_id = rm.recruit_major_id')
                                    ->where(array('e.major_ids' => array('LIKE' , '%,'.$val['major_id'].',%')))
                                    ->where(array('e.school_id' => $val['school_id']))
                                    ->find();
            $data[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
            $major = MajorModel::get_major_detail($val['major_id'],$val['school_id']);
            $major_score_key = $major['major_score_key'] ? array_filter(json_decode($major['major_score_key'],true)) : [];
            $major_score_arr = json_decode($val['major_score'],true);
            $major_score_desc = major_score_desc($major_score_key,$major_score_arr);
            $major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
            $data[$key]['major_score_arr'] = $major_score_arr;
            $data[$key]['major_score_desc'] = $major_score_desc;
            $major_score_status = $val['major_score_status'] ? $val['major_score_status'] : 0 ;
            $data[$key]['major_score_status'] = $major_score_status ;
			$data[$key]['status_desc'] = $status[$major_score_status] ;
			$data[$key]['major_score_key'] =  $major_score_key;
            $major_score_total = handle_major_score($major_score_arr);
            $data[$key]['major_score_total'] = $major_score_total;
		}

		$page = $score_list->render();
        $school_list = Db::name('school')->select();

		$this->assign('school_list',$school_list);
		$this->assign('data',$data);
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
        $member_list_edit=Db::name('member_list')->where(array('member_list_id'=>input('member_list_id')))->find();
        $major_score_data = Db::name('major_score')->where(array('member_list_id' => input('member_list_id')))->find();
        if($major_score_data)
        {
            $major_score_val = json_decode($major_score_data['major_score'],true);
            $this->assign('major_score_val',$major_score_val);
        }
        $major = MajorModel::get_major_detail($member_list_edit['major_id'],$member_list_edit['school_id']);
		$major_score = $major['score'] ? json_decode($major['score'],true) : [];
		$major_score = array_filter($major_score);
		$this->assign('major_score',$major_score);
        $this->assign('member_list_edit',$member_list_edit);
        return $this->fetch();
    }
    public function score_runadd()
    {
        $member_list_id = input('member_list_id');
        if(!$member_list_id){
            $this->error('???????????????');
        }
        $score = $_POST['score'];
        $major_score = json_encode($score);
        $major_score_data = Db::name('major_score')->where(array('member_list_id' => $member_list_id))->find();
        if($major_score_data)
        {
            if($major_score_data['major_score_status'] == 1)
            {
                $this->error('??????????????????????????????????????????');
            }
            $data = [
                'major_score' => $major_score,
                'major_score_status' => 0,
            ];
            $rst = Db::name('major_score')->where(array('member_list_id' => $member_list_id))->update($data);
			if($rst!==false){
            $this->success('????????????????????????????????????',url('admin/Score/score_list'));
			}else{
				$this->error('????????????');
			}
        }
        $data = [
            'member_list_id' => $member_list_id,
            'major_score' => $major_score
        ];
        $rst = Db::name('major_score')->insert($data);
        if($rst!==false){
            $this->success('????????????????????????????????????',url('admin/Score/score_list'));
        }else{
            $this->error('????????????');
        }
    }
	public function score_del()
	{
		$p=input('p');
		$rst=Db::name('major_score')->where(array('member_list_id'=>input('member_list_id')))->delete();
		if($rst!==false){
			$this->success('????????????',url('admin/Score/score_list',array('p' => $p)));
		}else{
			$this -> error("???????????????",url('admin/Score/score_list',array('p'=>$p)));
		}
	}
    public function score_list_export()
    {
        $major_id = input('major_id','');

        $map['m.major_id'] = $major_id;

        $map['m.school_id'] = $this->admin['school_id'];

        $data = Db::name('major_score')->alias("ms")
                        ->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','right')
                        ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
                        ->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
                        ->where($map)
                        ->order('ms.major_score_status desc')
                        ->order('m.member_list_id desc')
                        ->field('ms.major_score, ms.major_score_id,ms.major_score_status,m.member_list_nickname , m.member_list_username, m.member_list_id,mj.major_name,mj.major_name,m.major_id,m.school_id,mi.ZexamineeNumber')
                        ->order('major_score_id desc')->select();

        $status = config("status_title");

        $major = MajorModel::get_major_detail($major_id,$this->admin['school_id']);

        $school = Db::name('school')->where(['school_id' =>$this->admin['school_id'] ])->find();

        $title = $school['school_name'].'  '.$major['major_name'].'   ?????????????????????';
        $author = '?????????????????????????????????   ??????';

        $major_score = $major['score'] ? json_decode($major['score'],true) :[];
		$major_score = array_filter($major_score);

        $major_score_key = $major['major_score_key'] ? array_filter(json_decode($major['major_score_key'],true)) : [];

		foreach($data as $key => $val)
		{
            $major_score_arr = json_decode($val['major_score'],true);
            $major_score_desc = major_score_desc($major_score_key,$major_score_arr);
            $major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
            $data[$key]['major_score_arr'] = $major_score_arr;
            $data[$key]['major_score_desc'] = $major_score_desc;
            $major_score_status = $val['major_score_status'] ? $val['major_score_status'] : 0 ;
            $data[$key]['major_score_status'] = $major_score_status ;
            $data[$key]['status_desc'] = $status[$major_score_status] ;
            $major_score_total = handle_major_score($major_score_arr);
            $data[$key]['major_score_total'] = $major_score_total;
            // $data[$key]['member_list_username'] = $val['member_list_username']."\t";
            // $data[$key]['ZexamineeNumber'] = $val['ZexamineeNumber']."\t";
            $j = 0;
            foreach ($major_score_arr as $major_score_k => $major_score_v) {
                $data[$key]['major_'.$j] = $major_score_v;
                $j++;
            }
		}
        $field_titles = ['0' => '??????','1' => '???????????????','2' => '?????????','3' => '????????????'];
        $i = 4;
        foreach ($major_score as $k => $major) {
            $field_titles[$i] = $major;
            $i++;
        }
        $field_titles[$i] = '??????????????????';
        $field_titles[$i+1] = '????????????';

        $fields = ['0' => 'member_list_nickname','1' => 'ZexamineeNumber','2' => 'member_list_username','3' => 'major_name','major_score_total','status_desc'];
        $i = 4; $j = 0;
        foreach ($major_score as $k => $major) {
            $fields[$i] = 'major_'.$j;
            $i++;
            $j++;
        }
        $fields[$i] = 'major_score_total';
        $fields[$i+1] = 'status_desc';

        $table = '??????????????????????????????'.date('YmdHis');

        $this->score_list_export_pdf($field_titles,$fields,$data,$table,$title,$author);
        return false;

        error_reporting(E_ALL);
        date_default_timezone_set('Asia/chongqing');
        $objPHPExcel = new \PHPExcel();
        //import("Org.Util.PHPExcel.Reader.Excel5");
        /*??????excel?????????*/
        $objPHPExcel->getProperties()->setCreator("wuzhijie")//?????????
        ->setLastModifiedBy("wuzhijie")//???????????????
        ->setKeywords("excel")//?????????
        ->setCategory("result file");//??????

        //???????????????
        $objPHPExcel->setActiveSheetIndex(0);
        $active = $objPHPExcel->getActiveSheet();
        foreach($field_titles as $i=>$name){
            $ck = num2alpha($i++) . '1';
            $active->setCellValue($ck, $name);
        }
        //????????????
        foreach($data as $k => $v){
            $k=$k+1;
            $num=$k+1;//??????????????????????????????
            $objPHPExcel->setActiveSheetIndex(0);
            foreach($fields as $i=>$name){
                $ck = num2alpha($i++) . $num;
                $active->setCellValue($ck, $v[$name]);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle($table);
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$table.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;

    }
    public function recruit_score_list()
    {
        $admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
                    ->join(config('database.prefix').'auth_group c','b.group_id = c.id')
                    ->where(array('a.admin_id'=>session('admin_auth.aid')))
                    ->find();
        $school_list = Db::name('school')->alias('s')
                                         ->join(config('database.prefix').'enrollment e','e.school_id = s.school_id')
                                         ->where(array('e.recruit_major_id' => $admin['recruit_major_id']))
                                         ->field('s.school_id,s.school_name,e.major_ids')
                                         ->select();
        $map = [];
        $where = '';
        $school_id_arr = $major_id_arrs = array();
        foreach ($school_list as $school_key => $school_value) {
            $school_id_arr[] = $school_value['school_id'];
            $major_id_arr = array_filter(explode(',',$school_value['major_ids']));
            $major_id_arrs = array_merge($major_id_arrs,$major_id_arr);
        }

        $map['mj.major_id'] = ['in',$major_id_arrs];

        $search_key= trim(input('search_key',''));
        $major_id = input('major_id','');
        $recruit_major_id = input('recruit_major_id',$admin['recruit_major_id']);
        $school_id = input('school_id','');


        if($major_id){
            $map['m.major_id'] = $major_id;
        }
        if($school_id){
            $map['m.school_id'] = $school_id;
        }else{
            $map['m.school_id'] = ['in',$school_id_arr];
        }

        $recruit_score_status = input('recruit_score_status','');


        if($recruit_score_status === '0'){
            $where = 'ms.recruit_score_status <> 1';
        }
        else if($recruit_score_status == 1){
            $where = 'ms.recruit_score_status = 1';
        }


		$score_list = Db::name('major_score')->alias("ms")
						->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','right')
                        ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
						->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
                        ->join(config('database.prefix').'school s','s.school_id = m.school_id')
						->where($map)
                        ->where('member_list_username|member_list_nickname|ZexamineeNumber','like',"%".$search_key."%")
                        ->where($where)
                        ->order('ms.major_score_status ASC')
                        ->order('s.school_id desc')
                        ->order('m.member_list_id desc')
						->field('s.school_id,s.school_name,mi.ZexamineeNumber,ms.major_score_id,ms.major_score, ms.major_score_status,ms.recruit_score,ms.recruit_score_status,m.member_list_nickname,m.member_list_username, m.member_list_id,m.major_id,ms.major_score_id,mj.major_name,mj.major_id')
						->order('major_score_id desc')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);

		$data = $score_list->all();
		$status = config("status");

		foreach($data as $key => $val)
		{
            /*
            $recruit_major = Db::name('recruit_major')->alias('rm')
                                    ->join(config('database.prefix').'enrollment e','e.recruit_major_id = rm.recruit_major_id')
                                    ->where(array('e.major_ids' => array('LIKE' , '%,'.$val['major_id'].',%')))
                                    ->where(array('e.school_id' => $val['school_id']))
                                    ->find();
            $data[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];

            $major = MajorModel::get_major_detail($val['major_id'],$val['school_id']);
            $major_score_key =array_filter(json_decode($major['major_score_key'],true));
            $major_score_arr = json_decode($val['major_score'],true);
            $major_score_desc = major_score_desc($major_score_key,$major_score_arr);
            $major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
            $data[$key]['major_score_arr'] = $major_score_arr;
            $data[$key]['major_score_desc'] = $major_score_desc;
			$data[$key]['major_score_key'] =  $major_score_key;
            */
            $val_recruit_score_status = $val['recruit_score_status'] ? $val['recruit_score_status'] : 0;
            $data[$key]['status_desc'] = $status[$val_recruit_score_status];
		}
		$page = $score_list->render();

		$this->assign('school_list',$school_list);
		$this->assign('data',$data);
        $this->assign('school_id',$school_id);
        $this->assign('major_id',$major_id);
		$this->assign('page',$page);
        $this->assign('search_key',$search_key);
        $this->assign('recruit_score_status',$recruit_score_status);
        if(request()->isAjax()){
            return $this->fetch('ajax_recruit_score_list');
        }else{
            return $this->fetch();
        }
    }
    public function recruit_score_list_export()
    {
        $school_list = Db::name('school')->alias('s')
                                         ->join(config('database.prefix').'enrollment e','e.school_id = s.school_id')
                                         ->where(array('e.recruit_major_id' => $this->admin['recruit_major_id']))
                                         ->field('s.school_id,s.school_name,e.major_ids')
                                         ->select();
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

        if($major_id){
            $map['m.major_id'] = $major_id;
        }
        if($school_id){
            $map['m.school_id'] = $school_id;
        }else{
            $map['m.school_id'] = ['in',$school_id_arr];
        }

        $major_id = input('major_id','');

        $school_id = input('school_id','');
        $recruit_score_status = input('recruit_score_status','');


        if($recruit_score_status === '0'){
            $where = 'ms.recruit_score_status <> 1';
        }
        else if($recruit_score_status == 1){
            $where = 'ms.recruit_score_status = 1';
        }

		$data = Db::name('major_score')->alias("ms")
						->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','right')
                        ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
						->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
                        ->join(config('database.prefix').'school s','s.school_id = m.school_id')
						->where($map)
                        ->where($where)
                        ->order('ms.major_score_status ASC')
                        ->order('s.school_id desc')
                        ->order('m.member_list_id desc')
						->field('s.school_id,s.school_name,mi.ZexamineeNumber,ms.major_score_id,ms.major_score, ms.major_score_status,ms.recruit_score,ms.recruit_score_status,m.member_list_nickname,m.member_list_username, m.member_list_id,m.major_id,ms.major_score_id,mj.major_name')
						->order('major_score_id desc')->select();


		$status = config("status_title");
        $recruit_major = Db::name('recruit_major')->where('recruit_major_id',$this->admin['recruit_major_id'])->find();
		foreach($data as $key => $val)
		{
            $val_recruit_score_status = $val['recruit_score_status'] ? $val['recruit_score_status'] : 0;
            $data[$key]['status_desc'] = $status[$val_recruit_score_status];
            $data[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
            // $data[$key]['member_list_username'] = $val['member_list_username']."\t";
            // $data[$key]['ZexamineeNumber'] = $val['ZexamineeNumber']."\t";
		}
        $field_titles = ['??????','???????????????','?????????','????????????','????????????','????????????','????????????','????????????'];

        $fields = ['member_list_nickname','ZexamineeNumber','member_list_username','recruit_major_name','school_name','major_name','recruit_score','status_desc'];

        $table = '????????????'.$recruit_major['recruit_major_name'].'??????????????????'.date('YmdHis');
        $title = $recruit_major['recruit_major_name'].'      ??????????????????';
        $author = '?????????????????????????????????      ????????????';
        //$this->export_pdf($field_titles,$fields,$data,$table,$title,$author);
        $this->recruit_score_list_export_pdf($field_titles,$fields,$data,$table,$title,$author);

        return false;

        error_reporting(E_ALL);
        date_default_timezone_set('Asia/chongqing');
        $objPHPExcel = new \PHPExcel();
        //import("Org.Util.PHPExcel.Reader.Excel5");
        /*??????excel?????????*/
        $objPHPExcel->getProperties()->setCreator("wuzhijie")//?????????
        ->setLastModifiedBy("wuzhijie")//???????????????
        ->setKeywords("excel")//?????????
        ->setCategory("result file");//??????

        //???????????????
        $objPHPExcel->setActiveSheetIndex(0);
        $active = $objPHPExcel->getActiveSheet();
        foreach($field_titles as $i=>$name){
            $ck = num2alpha($i++) . '1';
            $active->setCellValue($ck, $name);
        }
        //????????????
        foreach($data as $k => $v){
            $k=$k+1;
            $num=$k+1;//??????????????????????????????
            $objPHPExcel->setActiveSheetIndex(0);
            foreach($fields as $i=>$name){
                $ck = num2alpha($i++) . $num;
                $active->setCellValue($ck, $v[$name]);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle($table);
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$table.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;

    }
    public function recruit_score_add()
    {

    }
	public function recruit_score_runedit()
    {
        $member_list_id = input('member_list_id');
        if(!$member_list_id){
            return [
				'code' => 0,
				'msg' => '????????????'
			];
        }

        $major_score_data = Db::name('major_score')->where(array('member_list_id' => $member_list_id))->find();
        if($major_score_data)
        {
            if($major_score_data['recruit_score'] == 1)
            {
                return [
					'code' => 0,
					'msg' => '????????????????????????????????????????????????'
				];
            }
			if($major_score_data['recruit_score'] == input('recruit_score')){
				return [
					'code' => 2,
					'msg' => ''
				];
			}
            $data = [
                'recruit_score' => input('recruit_score'),
                'recruit_score_status' => 0,
            ];
            $rst = Db::name('major_score')->where(array('member_list_id' => $member_list_id))->update($data);
			if($rst!==false){
				return [
					'code' => 1,
					'msg' => '????????????????????????????????????'
				];
			}else{
				return [
					'code' => 0,
					'msg' => '????????????'
				];
			}
        }
        else{
            $data = [
                'member_list_id' => $member_list_id,
                'major_score' => '',
                'recruit_score' => input('recruit_score'),
                'recruit_score_status' => 0,
            ];
            $rst = Db::name('major_score')->insert($data);
            if($rst!==false){
                return [
					'code' => 1,
					'msg' => '????????????????????????????????????'
				];
            }else{
                return [
					'code' => 0,
					'msg' => '????????????'
				];
            }
        }

		return [
			'code' => 0,
			'msg' => '????????????'
		];

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
        $recruit_score_status = input('recruit_score_status','');

        if($recruit_score_status != ''){
            $where = 'ms.recruit_score_status = '.$recruit_score_status;
        }


		$score_list = Db::name('major_score')->alias("ms")
						->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','left')
                        ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
						->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
                        ->join(config('database.prefix').'school s','s.school_id = m.school_id')
						->where($map)
                        ->where($where)
                        ->where(['ms.recruit_score' => ['<>','NULL']])
                        ->where('member_list_username|member_list_nickname|ZexamineeNumber','like',"%".$search_key."%")
                        ->order('ms.major_score_status ASC')
                        ->order('s.school_id desc')
                        ->order('m.member_list_id desc')
						->field('s.school_id,s.school_name,mi.ZexamineeNumber,ms.major_score_id,ms.major_score, ms.major_score_status,ms.recruit_score,ms.recruit_score_status,m.member_list_nickname,m.member_list_username, m.member_list_id,m.major_id,ms.major_score_id,mj.major_name')
						->order('major_score_id desc')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);

		$data = $score_list->all();
		$status = config("status");

		foreach($data as $key => $val)
		{
            $recruit_major = Db::name('recruit_major')->alias('rm')
                                    ->join(config('database.prefix').'enrollment e','e.recruit_major_id = rm.recruit_major_id')
                                    ->where(array('e.major_ids' => array('LIKE' , '%,'.$val['major_id'].',%')))
                                    ->find();
            $data[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
            $major = MajorModel::get_major_detail($val['major_id'],$val['school_id']);
            $major_score_key = $major['major_score_key'] ? array_filter(json_decode($major['major_score_key'],true)) : [];
            $major_score_arr = json_decode($val['major_score'],true);
            $major_score_desc = major_score_desc($major_score_key,$major_score_arr);
            $major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
            $data[$key]['major_score_arr'] = $major_score_arr;
            $data[$key]['major_score_desc'] = $major_score_desc;
            $val_recruit_score_status = $val['recruit_score_status'] ? $val['recruit_score_status'] : 0;
			$data[$key]['status_desc'] = $status[$val_recruit_score_status];
			$data[$key]['major_score_key'] =  $major_score_key;
		}

		$page = $score_list->render();
        $school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		$this->assign('data',$data);
		$this->assign('page',$page);
        $this->assign('search_key',$search_key);
        $this->assign('recruit_score_status',$recruit_score_status);
        if(request()->isAjax()){
            return $this->fetch('ajax_recruit_score_all');
        }else{
            return $this->fetch();
        }
    }
	public function score_active()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("???????????????",url('admin/score/score_all',array('p'=>$p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id ='.$ids;
		}

		$rst=Db::name('major_score')->where($where)->setField('major_score_status',1);
		if($rst!==false){
			foreach($ids as $key => $id)
			{
				$data = Db::name('major_score')->where(array('member_list_id' => $id))->find();
				if($data){
					Db::name('member_list')->where(array('member_list_id' => $data['member_list_id']))->update(array('major_score' => $data['major_score']));
				}
			}
			$this->success("????????????",url('admin/score/score_list',array('p'=>$p)));
		}else{
			$this -> error("???????????????",url('admin/score/score_list',array('p'=>$p)));
		}
	}
	public function score_unactive()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("???????????????",url('admin/score/score_all',array('p'=>$p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}

		$rst=Db::name('major_score')->where($where)->setField('major_score_status',0);
		if($rst!==false){
			$this->success("????????????",url('admin/score/score_all',array('p'=>$p)));
		}else{
			$this -> error("???????????????",url('admin/score/score_all',array('p'=>$p)));
		}
	}
	public function recruit_score_active()
	{
		$p = input('p');
        $school_id = input('school_id');
        $major_id = input('major_id');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("???????????????",url('admin/score/recruit_score_all',array('p'=>$p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id ='.$ids;
		}

		$rst=Db::name('major_score')->where($where)->setField('recruit_score_status',1);
		if($rst!==false){
			foreach($ids as $key => $id)
			{
				$data = Db::name('major_score')->where(array('member_list_id' => $id))->find();
				if($data){
					Db::name('member_list')->where(array('member_list_id' => $data['member_list_id']))->update(array('recruit_score' => $data['recruit_score']));
				}
			}
			$this->success("????????????",url('admin/score/recruit_score_list',array('p'=>$p,'school_id' =>$school_id,'major_id'=>$major_id )));
		}else{
			$this -> error("???????????????",url('admin/score/recruit_score_list',array('p'=>$p,'school_id' =>$school_id,'major_id'=>$major_id )));
		}
	}
	public function recruit_score_unactive()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("???????????????",url('admin/score/recruit_score_all',array('p'=>$p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}

		$rst=Db::name('major_score')->where($where)->setField('recruit_score_status',0);
		if($rst!==false){
			$this->success("????????????",url('admin/score/recruit_score_all',array('p'=>$p)));
		}else{
			$this -> error("???????????????",url('admin/score/recruit_score_all',array('p'=>$p)));
		}
	}

    public function score_list_export_pdf($field_titles=array(),$fields=array(),$data=array(),$fileName='Newfile',$title,$author=''){

		set_time_limit(120);
		if(empty($field_titles) || empty($data)) $this->error("????????????????????????");
		require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/ScoreListTCPDF.php');
		$pdf = new \ScoreListTCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);//??????pdf??????
		 //??????????????????
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor("Author");
		$pdf->SetTitle("pdf test");
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //??????????????????
        $pdf->SetHeaderData('', '', $author,$title,array(66,66,66), array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//????????????????????????
        $pdf->SetMargins(5, 24, 5);//??????????????????
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, 40);//?????????????????????
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

        // ????????????
        $fill = 0;
        foreach($data as $list) {
            //???????????????????????????
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

        $showType= 'D';//PDF??????????????????I???????????????????????????D???????????????????????????F???????????????????????????S??????????????????????????????E??????????????????????????????
        $pdf->Output("{$fileName}.pdf", $showType);
        exit;
	}
    public function recruit_score_list_export_pdf($field_titles=array(),$fields=array(),$data=array(),$fileName='Newfile',$title,$author='')
    {
        set_time_limit(120);
		if(empty($field_titles) || empty($data)) $this->error("????????????????????????");
        require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/RecruitScoreListTCPDF.php');
		$pdf = new \RecruitScoreListTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);//??????pdf??????
		 //??????????????????
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor("Author");
		$pdf->SetTitle("pdf test");
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //??????????????????
        $pdf->SetHeaderData('', '', $author,$title,array(66,66,66), array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//????????????????????????
        $pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);//??????????????????
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, 30);//?????????????????????
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

        // ????????????
        $fill = 0;
        foreach($data as $list) {
            //???????????????????????????
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

        $showType= 'D'; //PDF??????????????????I???????????????????????????D???????????????????????????F???????????????????????????S??????????????????????????????E??????????????????????????????
        $pdf->Output("{$fileName}.pdf", $showType);
        exit;
    }
}
