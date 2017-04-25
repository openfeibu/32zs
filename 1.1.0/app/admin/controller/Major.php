<?php

namespace app\admin\controller;

use app\admin\model\Major as MajorModel;
use think\Db;
use think\Cache;

class Major extends Base
{
    
    public function major_add()
	{
		return $this->fetch();
	}
	public function major_list()
	{
		$school_id = input('school_id');
		$search_name = input('search_name');
		$map=array();
		if($search_name){
			$map['major_name']= array('like',"%".$search_name."%");
		}
		if($school_id)
		{
			$map['school_id']= array('like',"%".$school_id."%");
		}
		$major_list = Db::name('major')->where($map)->order('major_id')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$page = $major_list->render();
		$this->assign('major_list',$major_list);
		$this->assign('page',$page);
		return $this->fetch();
	}
	public function major_runadd()
	{
		$data = [
			'major_name' => input('major_name'),
			'school_id'	 => input('school_id'),
		];
		MajorModel::create($data);
		$this->success('添加成功',url('admin/School/major_list'));
	}
}

