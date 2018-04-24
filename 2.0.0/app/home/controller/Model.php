<?php
// +----------------------------------------------------------------------
// | 三二分段 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\home\controller;

use think\Db;

class Model extends Base
{
    //模型内页
    public function index()
    {
		//内容id
		$id=input('id');
		//栏目id
		$cid=input('cid');
		$menu=Db::name('menu')->find($cid);
		$tplname=$menu['menu_newstpl'];
    	$tplname=$tplname?$tplname:'news';
		$model=Db::name('model')->find($menu['menu_modelid']);
		$data=Db::name($model['model_name'])->find($id);
		if(empty($data)){
		    $this->error(lang('operation not valid'));
		}
		$this->assign($data);
		return $this->view->fetch(":$tplname");
    }
}
