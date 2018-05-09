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
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\MajorScoreConfig as MajorScoreConfigModel;
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
		$school_list = Db::name('school')->where($map)->order('school_id','DESC')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$data = $school_list->all();
		foreach ($data as $key => $school) {
			$data[$key]['member_count'] = Db::name('member_list')->where('school_id' , $school['school_id'])->count();
		}

		$page = $school_list->render();
		$this->assign('search_name',$search_name);
		$this->assign('school_list',$data);
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
		$enrollment = Db::name('enrollment')->where(array('school_id' => $school_id))->find();
		if($data_admin || $data_member || $enrollment)
		{
			$this->error('删除失败,请先删除该学院下的招生计划、中职管理员及考生',url('admin/School/major_list', array('p' => $p)));
		}
		$rst=Db::name('school')->where(array('school_id'=>$school_id))->delete();
		if($rst!==false){
			$this->success('删除成功',url('admin/School/school_list', array('p' => $p)));
		}else{
			$this->error('删除失败',url('admin/School/school_list', array('p' => $p)));
		}

	}
	public function school_delall(){
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/school/school_list',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'school_id in('.implode(',',$ids).')';
		}else{
			$where = 'school_id = '.$ids;
		}
		$enrollment_count = Db::name('enrollment')->where($where)->count();
		$member_count = Db::name('member_list')->where($where)->count();
		$admin_count = Db::name('admin')->where($where)->count();
		if($enrollment_count || $member_count || $admin_count)
		{
			$this->error('删除失败,请先删除跟该学校关联的招生计划、考生及中职专业负责人',url('admin/School/school_list', array('p' => $p)));
		}else{
			Db::name('school')->where($where)->delete();
			$this->success('删除成功',url('admin/School/school_list', array('p' => $p)));
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
		$search_name = input('search_name');
		$map=array();
		if($search_name){
			$map['m.major_name']= array('like',"%".$search_name."%");
		}

		$major_list = Db::name('major')->alias('m')
					->where($map)
					->order('m.major_id','DESC')
					->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);

		$data = $major_list->all();

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
	public function major_delall(){
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/major/major_list',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'major_id in('.implode(',',$ids).')';
		}else{
			$where = 'major_id = '.$ids;
		}
		$member_count = Db::name('member_list')->where($where)->count();
		$admin_count = Db::name('admin')->where($where)->count();
		if($member_count || $admin_count)
		{
			$this->error('删除失败,请先删除跟该中职关联的考生及中职专业负责人',url('admin/school/major_list', array('p' => $p)));
		}else{
			Db::name('major')->where($where)->delete();
			$this->success('删除成功',url('admin/school/major_list', array('p' => $p)));
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

		$major_list = MajorModel::get_secondary_vocat_major_list($major_ids,$school_id);

		foreach($major_list as $key => $val)
		{
			$major_list[$key]['score_desc'] = '';
			if($val['score']){
				$score_arr = json_decode($val['score'],true);
				$major_list[$key]['score_desc'] = implode(' , ',$score_arr);
			}
		}
		$this->assign('major_list',$major_list);

		return $this->fetch();
	}
	public function secondary_vocat_major_edit()
	{
		$major_id= input('major_id');
		$major = MajorModel::get_major_detail($major_id,$this->admin['school_id']);
		if(!$major)
		{
			$this->error('不存在该专业');
		}
		$major_score = $major['score'] ? json_decode($major['score'],true) : [];
		$this->assign('major_score',$major_score);
		$this->assign('major',$major);
		return $this->fetch();
	}

	public function secondary_vocat_major_runedit()
	{
		$major_id= input('major_id');
		$major = MajorModel::get_major_detail($major_id,$this->admin['school_id']);
		if(!$major)
		{
			$this->error('不存在该专业');
		}
		$score = $_POST['score'];

		if($major['score'])
		{
			$data = [
				'score' => json_encode($score),
			];
			$rst = Db::name('major_score_config')->where(array('score_config_id' => $major['score_config_id']))->update($data);
		}else{
			$data = [
				'major_id' => $major_id,
				'school_id' => $this->admin['school_id'],
				'score' => json_encode($score),
			];
			$rst = MajorScoreConfigModel::create($data);
		}
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
		$this->assign('major',$major);

		return $this->fetch();
	}
	public function major_runadd()
	{
		$data = [
			'major_name' => input('major_name'),
			'major_code' => input('major_code'),
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
		$data = [
			'major_name' => input('major_name'),
			'major_code' => input('major_code'),
		];
		$rst = Db::name('major')->where(array('major_id' => $major['major_id']))->update($data);
		if($rst!==false){
			$this->success('修改成功',url('admin/School/major_list'));
		}else{
			$this->error('修改失败',url('admin/School/major_list'));
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
			$map['recruit_major_name']= array('like',"%".$search_name."%");
		}
		$major_list = Db::name('recruit_major')
							->where($map)
							->order('recruit_major_id','DESC')
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
			'recruit_major_code' => input('recruit_major_code'),
			// 'min_score'
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
			'recruit_major_code' => input('recruit_major_code'),
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
						->join(config('database.prefix').'enrollment e','e.recruit_major_id = am.recruit_major_id')
						->join(config('database.prefix').'recruit_major rm','rm.recruit_major_id = am.recruit_major_id')
						->where(array('rm.recruit_major_id' => $recruit_major_id))
						->find();
		if($data_admin)
		{
			$this->error('删除失败,请先删除该专业下的高职管理员及招生计划',url('admin/School/recruit_major_list', array('p' => $p)));
		}
		$rst=Db::name('recruit_major')->where(array('recruit_major_id'=>$recruit_major_id))->delete();
		if($rst!==false){
			$this->success('删除成功',url('admin/School/recruit_major_list', array('p' => $p)));
		}else{
			$this->error('删除失败',url('admin/School/recruit_major_list', array('p' => $p)));
		}

	}
	public function recruit_major_delall()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/School/recruit_major_list',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'recruit_major_id in('.implode(',',$ids).')';
		}else{
			$where = 'recruit_major_id = '.$ids;
		}
		$rst=Db::name('recruit_major')->where($where)->delete();
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
	public function ajax_major_checkbox(){
		if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$school_id = input('school_id','0');

			$major_list = MajorModel::get_major_list($school_id);

			$html = '';
			foreach($major_list as $key => $major)
			{
				$html .= "<label id='news_flag_h'><input checked class='ace ace-checkbox-2' type='checkbox' name='major_id[]' value='".$major['major_id']."'/><span class='lbl'>".$major['major_name']."</span></label>";
				// $html .= "<option value='".$major['major_id']."'>".$major['major_name']."</option>";
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

			$major_list = MajorModel::get_major_list($school_id);

			$html = '<option value="">所有中职专业</option>';
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
	public function ajax_major2(){
		if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$school_id = input('school_id','0');

			$major_list = MajorModel::get_major_list($school_id);

			$html = '';
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

}
