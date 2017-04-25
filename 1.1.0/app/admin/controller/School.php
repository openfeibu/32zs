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
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use think\Db;
use think\Cache;

class School extends Base
{
	public function school_list()
    {
		$search_name=input('search_name');
		$map=array();
		if($search_name){
			$map['school_name']= array('like',"%".$search_name."%");
		}
		$school_list = Db::name('school')->where($map)->order('school_id')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$page = $school_list->render();
		$this->assign('search_name',$search_name);
		$this->assign('school_list',$school_list);
		$this->assign('page',$page);

        return $this->fetch();
    }
    public function school_add()
    {
        return $this->fetch();
    }
	public function school_runadd()
	{
		$data = [
			'school_name' => input('school_name'),
		];
		SchoolModel::create($data);

		$this->success('添加成功',url('admin/School/school_list'));

	}
	public function school_edit()
	{
		$school_id = input('school_id','0');
		$school = Db::name('school')->where(array('school_id' => $school_id))->find();
		if(!$school)
		{
			$this->error('不存在中职学校',url('admin/School/major_list'));
		}
		$this->assign('school',$school);
		return $this->fetch();
	}
	public function school_runedit()
	{
		$school_id = input('school_id','0');
		$school = Db::name('school')->where(array('school_id' => $school_id))->find();
		if(!$school)
		{
			$this->error('不存在中职学校',url('admin/School/major_list'));
		}
		$srt = Db::name('school')->where(array('school_id' => $school_id))->update(array('school_name' => input('school_name')));
		$this->success('更新成功',url('admin/School/school_list'));
	}
	public function school_del()
	{
		$p=input('p');
		$school_id = input('school_id','0');
		$data_admin = Db::name('admin')->where(array('school_id' => $school_id))->find();
		$data_member = Db::name('member_list')->where(array('school_id' => $school_id))->find();
		if($data_admin || $data_member)
		{
			$this->error('删除失败,请先删除该学院下的中职管理员及用户',url('admin/School/major_list', array('p' => $p)));
		}
		$rst=Db::name('school')->where(array('school_id'=>$school_id))->delete();
		if($rst!==false){
			$this->success('删除成功',url('admin/School/school_list', array('p' => $p)));
		}else{
			$this->error('删除失败',url('admin/School/school_list', array('p' => $p)));
		}

	}
	public function major_add()
	{
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		return $this->fetch();
	}
	public function major_list()
	{
		$school_id = input('school_id','0');
		/*
		$school = Db::name('school')->where(array('school_id' => $school_id))->find();
		if(!$school)
		{
			$this->error('不存在中职学校',url('admin/School/school_list'));
		}*/
		$search_name = input('search_name');
		$map=array();

		if($school_id)
		{
			$map['m.school_id']= $school_id;
		}

		$major_list = Db::name('major')->alias('m')
					->join(config('database.prefix').'school s','s.school_id = m.school_id')
					->join(config('database.prefix').'recruit_major rm','rm.recruit_major_id = m.recruit_major_id')
					->where($map)
					->order('s.school_id','DESC')
					->order('m.major_id','DESC')
					->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);

		$data = $major_list->all();
		foreach($data as $key => $major)
		{
			$data[$key]['major_score'] = json_decode($major['score'],true);
		}
		$page = $major_list->render();
		$this->assign('major_list',$data);
		$this->assign('page',$page);
		$this->assign('search_name',$search_name);
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		if(request()->isAjax()){
            return $this->fetch('ajax_major_list');
        }else{
            return $this->fetch();
        }
	}
	public function secondary_vocat_major_list()
	{
		$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
					->join(config('database.prefix').'auth_group c','b.group_id = c.id')
					->where(array('a.admin_id'=>session('admin_auth.aid')))
					->find();
		$school_id = $admin['school_id'];
		$major_ids = json_decode($admin['major_id'],true);
		$school_major_arr = $major_list = [];

		$major_list = Db::name('major')->alias('mj')
							->join(config('database.prefix').'school s','s.school_id = mj.school_id')
							->where(array('major_id' => array('in',$major_ids)))
							->order('s.school_id','DESC')
							->select();
		foreach($major_list as $key => $val)
		{
			$score_arr = json_decode($val['score'],true);
			$major_list[$key]['score_desc'] = implode(' , ',$score_arr);
		}
		$this->assign('major_list',$major_list);

		return $this->fetch();
	}
	public function secondary_vocat_major_edit()
	{
		$major_id= input('major_id');
		$major = Db::name('major')->where(array('major_id' => $major_id))->find();
		if(!$major)
		{
			$this->error('不存在该专业');
		}
		$school = Db::name('school')->where(array('school_id' => $major['school_id']))->find();
		$major_score = json_decode($major['score'],true);
		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		$this->assign('school',$school);
		$this->assign('major',$major);
		$this->assign('major_score',$major_score);
		return $this->fetch();
	}

	public function secondary_vocat_major_runedit()
	{
		$major_id= input('major_id');
		$major = Db::name('major')->where(array('major_id' => $major_id))->find();
		if(!$major)
		{
			$this->error('不存在该专业');
		}
		$score = $_POST['score'];
		$data = [
			'score' => json_encode($score),
		];
		$rst = Db::name('major')->where(array('major_id' => $major['major_id']))->update($data);
		if($rst!==false){
			$this->success('修改成功',url('admin/School/secondary_vocat_major_list'));
		}else{
			$this->error('修改失败',url('admin/School/secondary_vocat_major_list'));
		}
	}

	public function major_edit()
	{
		$major_id= input('major_id','0');
		$major = Db::name('major')->where(array('major_id' => $major_id))->find();
		if(!$major)
		{
			$this->error('不存在该专业');
		}
		$school = Db::name('school')->where(array('school_id' => $major['school_id']))->find();
		$major_score = json_decode($major['score'],true);
		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		$this->assign('school',$school);
		$this->assign('major',$major);
		$this->assign('major_score',$major_score);
		return $this->fetch();
	}
	public function major_runadd()
	{
		$score = $_POST['score'];
		$school_id = input('school_id','0');
		$school = Db::name('school')->where(array('school_id' => $school_id))->find();
		if(!$school)
		{
			$this->error('不存在中职学校',url('admin/School/school_list'));
		}
		$data = [
			'major_name' => input('major_name'),
			'school_id'	 => $school_id,
			'recruit_major_id' => input('recruit_major_id'),
			'major_code' => input('major_code'),
			'score' => json_encode($score),
			'number' => input('number'),
		];
		MajorModel::create($data);
		$this->success('添加成功',url('admin/School/major_list'));
	}
	public function major_runedit()
	{
		$major_id= input('major_id','0');
		$major = Db::name('major')->where(array('major_id' => $major_id))->find();
		if(!$major)
		{
			$this->error('不存在该专业');
		}
		$score = $_POST['score'];
		$data = [
			'major_name' => input('major_name'),
			'score' => json_encode($score),
			'major_code' => input('major_code'),
			'recruit_major_id' => input('recruit_major_id'),
			'number' => input('number'),
		];
		$rst = Db::name('major')->where(array('major_id' => $major['major_id']))->update($data);
		if($rst!==false){
			$this->success('修改成功',url('admin/School/major_edit',array('major_id' => $major_id)));
		}else{
			$this->error('修改失败',url('admin/School/major_edit',array('major_id' => $major_id)));
		}
	}
	public function major_del()
	{
		$p=input('p');
		$major_id = input('major_id','0');
		$data_admin = Db::name('admin')->where(array('major_id' => $major_id))->find();
		$data_member = Db::name('member_list')->where(array('major_id' => $major_id))->find();
		if($data_admin || $data_member)
		{
			$this->error('删除失败,请先删除该专业下的中职管理员及用户',url('admin/School/major_list', array('p' => $p)));
		}
		$rst=Db::name('major')->where(array('major_id'=>$major_id))->delete();
		if($rst!==false){
			$this->success('删除成功',url('admin/School/major_list', array('p' => $p)));
		}else{
			$this->error('删除失败',url('admin/School/major_list', array('p' => $p)));
		}

	}
	public function recruit_major_list()
	{
		$search_name = input('search_name');
		$map=array();
		if($search_name){
			$map['rm.major_name']= array('like',"%".$search_name."%");
		}
		$major_list = Db::name('recruit_major')->alias('rm')
							->join(config('database.prefix').'major mj','mj.recruit_major_id = rm.recruit_major_id')
							->field(array(
								'rm.*',
								'sum(mj.number) as zs_number'
							))
							->where($map)
							->order('rm.recruit_major_id')
							->group('rm.recruit_major_id')
							->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);

		$page = $major_list->render();
		$this->assign('major_list',$major_list);
		$this->assign('search_name',$search_name);
		$this->assign('page',$page);
		return $this->fetch();
	}
	public function recruit_major_add()
	{
		return $this->fetch();
	}
	public function recruit_major_edit()
	{
		$recruit_major_id= input('recruit_major_id','0');
		$recruit_major = Db::name('recruit_major')->where(array('recruit_major_id' => $recruit_major_id))->find();
		if(!$recruit_major)
		{
			$this->error('不存在该专业');
		}
		$this->assign('recruit_major',$recruit_major);
		return $this->fetch();
	}
	public function recruit_major_runadd()
	{
		$data = [
			'recruit_major_name' => input('recruit_major_name'),
			'min_score'
		//	'number'	 => input('number'),
		];
		RecruitMajorModel::create($data);
		$this->success('添加成功',url('admin/School/recruit_major_list'));
	}
	public function recruit_major_runedit()
	{
		$recruit_major_id= input('recruit_major_id','0');
		$data = [
			'recruit_major_name' => input('recruit_major_name'),
			//'number'	 => input('number'),
		];
		$rst = Db::name('recruit_major')->where(array('recruit_major_id' => $recruit_major_id))->update($data);
		if($rst!==false){
			$this->success('修改成功',url('admin/School/recruit_major_edit',array('recruit_major_id' => $recruit_major_id)));
		}else{
			$this->error('修改失败',url('admin/School/recruit_major_edit',array('recruit_major_id' => $recruit_major_id)));
		}
	}
	public function recruit_major_del()
	{
		$p=input('p');
		$recruit_major_id = input('recruit_major_id','0');

		$data_admin = Db::name('admin')->alias('am')
						->join(config('database.prefix').'major mj','mj.major_id = am.major_id')
						->join(config('database.prefix').'recruit_major rm','rm.recruit_major_id = mj.recruit_major_id')
						->where(array('rm.recruit_major_id' => $recruit_major_id))
						->find();
		if($data_admin)
		{
			$this->error('删除失败,请先删除该专业下的中职管理员及用户',url('admin/School/major_list', array('p' => $p)));
		}
		$rst=Db::name('recruit_major')->where(array('recruit_major_id'=>$recruit_major_id))->delete();
		if($rst!==false){
			$this->success('删除成功',url('admin/School/recruit_major_list', array('p' => $p)));
		}else{
			$this->error('删除失败',url('admin/School/recruit_major_list', array('p' => $p)));
		}

	}
	public function ajax_recruit_major(){
		if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$school_id = input('school_id','0');
			$recruit_major_list = Db::name('recruit_major')->alias('rm')
										->join(config('database.prefix').'major mj','mj.recruit_major_id = rm.recruit_major_id')
										->join(config('database.prefix').'admin am','am.major_id = mj.major_id')
										->where(array('am.school_id' => $school_id))
										->field('rm.recruit_major_name,rm.recruit_major_id')
										->distinct('recruit_major_id')
										->select();
			$html = '<option value="">请选择高职专业</option>';
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
	public function ajax_major(){
		if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$school_id = input('school_id','0');
			$major_list = Db::name('major')->where(array('school_id' => $school_id))->select();
			$html = '<option value="">请选择中职专业</option>';
			foreach($major_list as $key => $major)
			{
				$html .= "<option value='".$major['major_id']."'>".$major['major_name']."</option>";
			}
			return [
				'code' => 200,
				'html' => $html,
			];
		}
	}
	public function ajax_enrollment_recruit_major()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$school_id = input('school_id','0');
			$recruit_major_list =Db::name('enrollment')->alias('e')
									->join(config('database.prefix').'recruit_major rm','rm.recruit_major_id = e.recruit_major_id')
									->where(['e.school_id' => $school_id])
									->select();

			$html = '<option value="">请选择高职专业</option>';
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
	public function ajax_secondary_vocat_major()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$school_id = input('school_id','0');
			$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
						->join(config('database.prefix').'auth_group c','b.group_id = c.id')
						->where(array('a.admin_id'=>session('admin_auth.aid')))
						->find();

	        $major_list = [];
			$major_ids = json_decode($admin['major_id'],true);
			$major_list = Db::name('major')->where(array('school_id' => $school_id,'major_id' => array('in' , $major_ids)))->select();
			$html = '<option value="">请选择中职专业</option>';
			foreach($major_list as $key => $major)
			{
				$html .= "<option value='".$major['major_id']."'>".$major['major_name']."</option>";
			}
			return [
				'code' => 200,
				'html' => $html,
			];
		}
	}
	public function enrollment_add()
	{
		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		return $this->fetch();
	}
	public function enrollment_runadd()
	{
		$data = [
			'recruit_major_id' => input('recruit_major_id'),
			'school_id' => input('school_id'),
			'enrollment_number' => input('enrollment_number'),
		];
		EnrollmentModel::create($data);
		$this->success('添加成功',url('admin/School/enrollment'));
	}
	public function enrollment()
	{
		$enrollments = Db::name('enrollment')->alias('e')
							->join(config('database.prefix').'recruit_major rm','e.recruit_major_id = rm.recruit_major_id')
							->join(config('database.prefix').'school s','e.school_id = s.school_id')
							->select();
		/*
		$enrollments = Db::name('major')->alias('mj')
							->join(config('database.prefix').'recruit_major rm','mj.recruit_major_id = rm.recruit_major_id')
							->join(config('database.prefix').'school s','mj.school_id = s.school_id')
							->order('mj.school_id')
							->select();*/
		foreach ($enrollments as $key => $enrollment) {
			$majors = Db::name('major')->where(['recruit_major_id' => $enrollment['recruit_major_id'],'school_id' => $enrollment['school_id']])->select();
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
		/*
		$data = Db::name('major')->alias('mj')
							->join(config('database.prefix').'recruit_major rm','mj.recruit_major_id = rm.recruit_major_id')
							->join(config('database.prefix').'school s','mj.school_id = s.school_id')
							->order('mj.school_id')
							->select();*/
		$enrollments = Db::name('enrollment')->alias('e')
							->join(config('database.prefix').'recruit_major rm','e.recruit_major_id = rm.recruit_major_id')
							->join(config('database.prefix').'school s','e.school_id = s.school_id')
							->select();
		foreach ($enrollments as $key => $enrollment) {
			$majors = Db::name('major')->where(['recruit_major_id' => $enrollment['recruit_major_id'],'school_id' => $enrollment['school_id']])->select();
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
