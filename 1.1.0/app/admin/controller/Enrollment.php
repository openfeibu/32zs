<?php

namespace app\admin\controller;

use app\admin\model\School as SchoolModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\MajorScoreConfig as MajorScoreConfigModel;
use think\Db;
use think\Cache;

class Enrollment extends Base
{
    public function enrollment_add()
	{
		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		$major_list = Db::name('major')->select();
		$this->assign('major_list',$major_list);
		return $this->fetch();
	}
	public function enrollment_runadd()
	{
		$major_ids = array_unique(array_filter($_POST['major_id']));
		$major_ids = implode(',',$major_ids);
		$major_ids = ','.$major_ids.',';
		$data = [
			'recruit_major_id' => input('recruit_major_id'),
			'major_ids' => $major_ids,
			'school_id' => input('school_id'),
			'enrollment_number' => input('enrollment_number'),
		];
		EnrollmentModel::create($data);
		$this->success('添加成功',url('admin/Enrollment/enrollment'));
	}
    public function enrollment_edit()
	{
        $enrollment_id = input('enrollment_id',0,'intval');
        $enrollment = EnrollmentModel::get_enrollment($enrollment_id);
        if(!$enrollment){
            return $this->error('数据不存在');
        }
 		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		$major_list = Db::name('major')->select();
		$this->assign('major_list',$major_list);
        $this->assign('enrollment',$enrollment);
		return $this->fetch();
	}
	public function enrollment_runedit()
	{
        $enrollment_id = input('enrollment_id','');
        $enrollment = EnrollmentModel::get_enrollment($enrollment_id);
        if(!$enrollment){
            return $this->error('数据不存在');
        }
		$data = [
			'recruit_major_id' => input('recruit_major_id'),
			'enrollment_number' => input('enrollment_number'),
		];
        $rst = Db::name('enrollment')->where(['enrollment_id' => $enrollment_id])->update($data);

        $this->success('操作成功',url('admin/Enrollment/enrollment'));


	}
    public function enrollment_del()
    {
        $p=input('p');
        $enrollment_id=input('enrollment_id');
        $enrollment_model=new EnrollmentModel;
        $enrollment = $enrollment_model->where(['enrollment_id' => $enrollment_id])->find();
        if(!$enrollment){
            return $this->error('数据不存在');
        }
        $admin_list = Db::name('admin')->where(['school_id' => $enrollment['school_id']])->select();
        $member_list = Db::name('member_list')->where(['school_id' => $enrollment['school_id']])->select();
        if($admin_list || $member_list)
        {
            return $this->error('请先删除与该招生计划关联学校下的中职负责人及中职学生数据');
        }
        $rst = $enrollment_model->where(array('enrollment_id'=>$enrollment_id))->delete();
        if($rst!==false){
            $this->success('删除成功',url('admin/Enrollment/enrollment', array('p' => $p)));
        }else{
            $this->error('删除失败',url('admin/Enrollment/enrollment', array('p' => $p)));
        }

    }
    public function enrollment_delall()
    {
        $p = input('p');
        $ids = input('n_id/a');
        $enrollment_model = new EnrollmentModel;
        if(empty($ids)){
            $this -> error("请选择列表",url('admin/Enrollment/enrollment',array('p'=>$p)));
        }
        if(is_array($ids)){
            $where = 'enrollment_id in('.implode(',',$ids).')';
        }else{
            $where = 'enrollment_id = '.$ids;
        }
        $school_ids = [];
        $enrollment_list = $enrollment_model->where($where)->select();
        foreach ($enrollment_list as $key => $enrollment) {
            $school_ids[] = $enrollment['school_id'];
        }
        $admin_list = Db::name('admin')->where(['school_id' => ['in',$school_ids]])->select();
        $member_list = Db::name('member_list')->where(['school_id' => ['in',$school_ids]])->select();
        if($admin_list || $member_list)
        {
            return $this->error('请先删除与该招生计划关联学校下的中职负责人及中职学生数据');
        }
        $rst = $enrollment_model->where($where)->delete();
        if($rst!==false){
			$this->success('删除成功',url('admin/Enrollment/enrollment', array('p' => $p)));
		}else{
			$this->error('删除失败',url('admin/Enrollment/enrollment', array('p' => $p)));
		}
    }
	public function enrollment()
	{
		$enrollments = Db::name('enrollment')->alias('e')
							->join(config('database.prefix').'recruit_major rm','e.recruit_major_id = rm.recruit_major_id')
							->join(config('database.prefix').'school s','e.school_id = s.school_id')
                            ->order('e.enrollment_id','desc')
							->select();


		foreach ($enrollments as $key => $enrollment) {
			$major_ids = explode(',',$enrollment['major_ids']);
			$major_ids = array_filter($major_ids);
			$majors = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
			$major_desc = '';
			foreach ($majors as $k => $major) {
				$major_desc.= $major['major_name'] . '(' . $major['major_code'] . ') ';
			}
			$enrollments[$key]['majors'] = $majors;
			$enrollments[$key]['major_desc'] = $major_desc;
		}
		$this->assign('enrollments',$enrollments);
		return $this->fetch();
	}
	public function export_enrollment()
	{
		$enrollments = Db::name('enrollment')->alias('e')
							->join(config('database.prefix').'recruit_major rm','e.recruit_major_id = rm.recruit_major_id')
							->join(config('database.prefix').'school s','e.school_id = s.school_id')
							->select();
		foreach ($enrollments as $key => $enrollment) {
			$major_ids = explode(',',$enrollment['major_ids']);
			$major_ids = array_filter($major_ids);
			$majors = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
			$major_desc = '';
			foreach ($majors as $k => $major) {
				$major_desc.= $major['major_name'] . '(' . $major['major_code'] . ') ';
			}
			$enrollments[$key]['majors'] = $majors;
			$enrollments[$key]['major_desc'] = $major_desc;
		}
		$data = $enrollments;
        $field_titles = ['对口中职学校名称','高职专业名称','高职专业代码','对口中职专业名称(含代码)','招生计划数'];
        $fields = ['school_name','recruit_major_name','recruit_major_code','major_desc','enrollment_number'];
        $table = '招生计划表'.date('YmdHis');
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
