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
use app\admin\model\MemberList;
use think\Db;
use think\Cache;

class Matriculate extends Base
{
    public function index()
    {
        $school_id = input('school_id','');
        $recruit_major_id = input('recruit_major_id','');
        $where['rm.recruit_major_id'] = $recruit_major_id;
        $recruit_major = Db::name('recruit_major')->alias('rm')
							->join(config('database.prefix').'major mj','mj.recruit_major_id = rm.recruit_major_id')
                            ->join(config('database.prefix').'enrollment e','e.recruit_major_id = rm.recruit_major_id')
							->field(array(
								'rm.*',
								'e.enrollment_number as zs_number'
							))
							->where($where)
							->find();
        $member_model=new MemberList;
        $member_list=$member_model->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
                ->join(config('database.prefix').'member_info mi','mi.member_list_id = a.member_list_id')
			    ->join(config('database.prefix').'school s','a.school_id = s.school_id','left')
				->join(config('database.prefix').'major m','a.major_id = m.major_id','left')
				->join(config('database.prefix').'recruit_major rm','m.recruit_major_id = rm.recruit_major_id','left')
				->where($where)
				->field('a.*,b.*,m.score as major_score_key,m.major_name,s.school_id,s.school_name,rm.recruit_major_name,mi.ZexamineeNumber')
				->select();
		$data = $member_list;
        $ranking = 1;
		foreach ($data as $key => $value) {
			$major_score_arr = [];
			$major_score_desc = $major_score_total = '';
			$major_score_key =array_filter(json_decode($value['major_score_key'],true));
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
			$data[$key]['total_score'] = $major_score_total + $value['recruit_score'];
            $data[$key]['admission_status'] = 1;
            if($value['recruit_score'] < $recruit_major['min_score'])
            {
                $data[$key]['admission_status'] = 0;
            }

		}
        array_multisort(array_column($data,'admission_status'),SORT_DESC,array_column($data,'total_score'),SORT_DESC,$data);
        foreach ($data as $key => $value) {
            $data[$key]['ranking'] = $ranking;
            if($value['ranking'] > $recruit_major['zs_number'])
            {
                $data[$key]['admission_status'] = 0;
            }
            $data[$key]['admission_status_desc'] = $data[$key]['admission_status'] ? '是' : '否';
            $ranking++;
        }

        $school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
        $this->assign('member_list',$data);
        $this->assign('ranking',1);
        if(request()->isAjax()){
            return $this->fetch('ajax_list');
        }else{
            return $this->fetch();
        }
    }
    public function export()
    {
        $recruit_major_id = input('recruit_major_id');
        $where['rm.recruit_major_id'] = $recruit_major_id;
        $recruit_major = Db::name('recruit_major')->alias('rm')
							->join(config('database.prefix').'major mj','mj.recruit_major_id = rm.recruit_major_id')
                            ->join(config('database.prefix').'enrollment e','e.recruit_major_id = rm.recruit_major_id')
							->field(array(
								'rm.*',
								'e.enrollment_number as zs_number'
							))
							->where($where)
							->group('rm.recruit_major_id')
							->find();
        $member_model=new MemberList;
        $member_list=$member_model->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
                ->join(config('database.prefix').'member_info mi','mi.member_list_id = a.member_list_id')
			    ->join(config('database.prefix').'school s','a.school_id = s.school_id','left')
				->join(config('database.prefix').'major m','a.major_id = m.major_id','left')
				->join(config('database.prefix').'recruit_major rm','m.recruit_major_id = rm.recruit_major_id','left')
				->where($where)
				->field('a.*,b.*,m.score as major_score_key,m.major_name,s.school_id,s.school_name,rm.recruit_major_name,mi.ZexamineeNumber')
				->select();
		$data = $member_list;
        $ranking = 1;
		foreach ($data as $key => $value) {
			$major_score_arr = [];
			$major_score_desc = $major_score_total = '';
			$major_score_key =array_filter(json_decode($value['major_score_key'],true));
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
			$data[$key]['total_score'] = $major_score_total + $value['recruit_score'];
            $data[$key]['admission_status'] = 1;
            if($value['recruit_score'] < $recruit_major['min_score'])
            {
                $data[$key]['admission_status'] = 0;
            }
		}
        array_multisort(array_column($data,'admission_status'),SORT_DESC,array_column($data,'total_score'),SORT_DESC,$data);
        foreach ($data as $key => $value) {
            $data[$key]['ranking'] = $ranking;
            if($value['ranking'] > $recruit_major['zs_number'])
            {
                $data[$key]['admission_status'] = 0;
            }
            $data[$key]['admission_status_desc'] = $data[$key]['admission_status'] ? '是' : '否';
            $ranking++;
        }
        $field_titles = ['姓名','中职考生号','身份证','高职专业','核定理论成绩','技能考核成绩','总分','排名','是否录取'];
        $fields = ['member_list_nickname','ZexamineeNumber','member_list_username','recruit_major_name','major_score_total','recruit_score','total_score','ranking','admission_status_desc'];
        $table = '三二分段考核理论成绩';
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
}
