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
use app\admin\model\MemberList;
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\Score as ScoreModel;
use think\Db;
use think\Cache;

class Matriculate extends Base
{
    public function index()
    {
        $school_id = input('school_id','');
        $school_list = Db::name('school')->select();
        $first_school_id = $school_list ? $school_list[0]['school_id'] : ''   ;
        $school_id = $school_id ? $school_id : $first_school_id;
        $recruit_major_id = input('recruit_major_id','');
        $recruit_major_list = [];
        if(!$recruit_major_id)
        {
            $recruit_major_list = EnrollmentModel::get_enrollment_recruit_major($school_id);
            $recruit_major_id =  $recruit_major_list ? $recruit_major_list[0]['recruit_major_id'] : '';
        }
        $recruit_major = Db::name('recruit_major')->where(['recruit_major_id' => $recruit_major_id])->find();
        $enrollment = Db::name('enrollment')->where(['school_id' => $school_id,'recruit_major_id' => $recruit_major_id])->find();
        $data = [];
        if($enrollment){
            $data = EnrollmentModel::get_enroll_member_list($enrollment,$recruit_major,$school_id);
            $this->assign('enrollment',$enrollment);
        }

        $school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
        $this->assign('member_list',$data);
        $this->assign('ranking',1);
        $this->assign('school_id',$school_id);
        $this->assign('recruit_major_id',$recruit_major_id);
        $this->assign('recruit_major_list',$recruit_major_list);
        if(request()->isAjax()){
            return $this->fetch('ajax_list');
        }else{
            return $this->fetch();
        }
    }
    public function ajax_enrollment_recruit_major()
    {
        if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$school_id = input('school_id','0');
            $recruit_major_list = EnrollmentModel::get_enrollment_recruit_major($school_id);

			$html = '';
			foreach($recruit_major_list as $key => $major)
			{
				$html .= "<option value='".$major['recruit_major_id']."'>".$major['recruit_major_name']."</option>";
			}
			return [
				'code' => 200,
				'html' => $html,
			];
		}
    }
    public function export()
    {
        $min_score = Db::name('min_score')->find();
        $min_score = $min_score ? $min_score['min_score'] : 0;
        $school_id = input('school_id','');
        $school_list = Db::name('school')->select();
        $first_school_id = $school_list ? $school_list[0]['school_id'] : ''   ;
        $school_id = $school_id ? $school_id : $first_school_id;
        $recruit_major_id = input('recruit_major_id','');
        $recruit_major_list = [];
        if(!$recruit_major_id)
        {
            $recruit_major_list = EnrollmentModel::get_enrollment_recruit_major($school_id);
            $recruit_major_id =  $recruit_major_list ? $recruit_major_list[0]['recruit_major_id'] : '';
        }
        $recruit_major = Db::name('recruit_major')->where(['recruit_major_id' => $recruit_major_id])->find();
        $enrollment = Db::name('enrollment')->where(['school_id' => $school_id,'recruit_major_id' => $recruit_major_id])->find();
        $school = Db::name('school')->where(['school_id' => $school_id])->field('school_name')->find();
        $data = [];
        if($enrollment){
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
            $score_model = new ScoreModel();
    		foreach ($data as $key => $value) {
                $major = MajorModel::get_major_detail($value['major_id'],$value['school_id']);
                $subject_list = $major['subjects'];
                $major_score_data = $score_model->get_member_subject_score($subject_list,$value['member_list_id']);

                $major_score_arr = $major_score_data['major_score_arr'];
    			$major_subject_name_arr = $major['major_subject_name_arr'];

                $major_score_desc = major_score_desc($major_subject_name_arr,$major_score_arr);
                $major_score_total = handle_major_score($major_score_arr);

    			$data[$key]['major_score_arr'] = $major_score_arr;
    			$data[$key]['major_score_desc'] = $major_score_desc;
    			$data[$key]['major_score_total'] = $major_score_total;
    			$data[$key]['total_score'] = $major_score_total;
                $data[$key]['admission_status'] = $major_score_data['admission_status'];
                $data[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
                $data[$key]['member_list_username'] = $value['member_list_username']."\t";
                $data[$key]['ZexamineeNumber'] = $value['ZexamineeNumber']."\t";
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
        }

        $field_titles = ['姓名','中职考生号','身份证','高职专业','转段成绩','排名','是否录取'];
        $fields = ['member_list_nickname','ZexamineeNumber','member_list_username','recruit_major_name','major_score_total','ranking','admission_status_desc'];
        $table = $recruit_major['recruit_major_name'].'-'.$school['school_name'].'录取结果'.date('YmdHis');
        error_reporting(E_ALL);
        date_default_timezone_set('Asia/chongqing');
        $objPHPExcel = new \PHPExcel();
        //import("Org.Util.PHPExcel.Reader.Excel5");
        /*设置excel的属性*/
        $objPHPExcel->getProperties()->setCreator("wuzhijie")//创建人
        ->setLastModifiedBy("wuzhijie")//最后修改人
        ->setKeywords("excel")//关键字
        ->setCategory("result file");//种类

        //第一行数据
        $objPHPExcel->setActiveSheetIndex(0);
        $active = $objPHPExcel->getActiveSheet();
        foreach($field_titles as $i=>$name){
            $ck = num2alpha($i++) . '1';
            $active->setCellValue($ck, $name);
        }
        //填充数据
        foreach($data as $k => $v){
            $k=$k+1;
            $num=$k+1;//数据从第二行开始录入
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
    public function min_score()
    {
        $min_score = Db::name('min_score')->find();
        $this->assign('min_score',$min_score['min_score']);
        return $this->fetch();
    }
    public function min_score_runedit()
    {
        $min_score = input('min_score',0);
        $rst = Db::name('min_score')->where(array('min_score' => array('NEQ','-1')))->update(['min_score' => $min_score]);
        if($rst!==false){
			$this->success('修改成功',url('admin/Matriculate/min_score'));
		}else{
			$this->error('修改失败',url('admin/Matriculate/min_score'));
		}
    }
}
