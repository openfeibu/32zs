<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\Common;
use app\admin\model\AuthRule;
use think\Db;

class Base extends Common
{
	public function _initialize()
	{
        parent::_initialize();
 		if(!$this->check_admin_login()) $this->redirect('admin/Login/login');//未登录
 		$auth=new AuthRule;
		$id_curr=$auth->get_url_id();
        if(!$auth->check_auth($id_curr)) $this->error('没有权限',url('admin/Index/index'));
		//获取有权限的菜单tree
		$menus=$auth->get_admin_menus();
		$this->assign('menus',$menus);
		//当前方法倒推到顶级菜单ids数组
		$menus_curr=$auth->get_admin_parents($id_curr);
		$this->assign('menus_curr',$menus_curr);
		//取当前操作菜单父节点下菜单 当前菜单id(仅显示状态)
        $menus_child=$auth->get_admin_parent_menus($id_curr);
		$this->assign('menus_child',$menus_child);
		$this->assign('id_curr',$id_curr);

		$admin=array();
		if(session('admin_auth.aid')){
			$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
					->join(config('database.prefix').'auth_group c','b.group_id = c.id')
					->where(array('a.admin_id'=>session('admin_auth.aid')))->find();
			$news_count=Db::name('News')->where(array('news_auto'=>session('admin_auth.member_id')))->count();
			$admin['news_count']=$news_count;
		}
		$this->admin = $admin;
		$this->assign('admin', $admin);
		$head_title = '';
		if($admin['recruit_major_id'])
		{
			$recruit_major = Db::name('recruit_major')->where(['recruit_major_id' => $admin['recruit_major_id']])->find();
			$head_title = '('.$recruit_major['recruit_major_name'].')';
		}
		if($admin['school_id'])
		{
			$school = Db::name('school')->where(['school_id' => $admin['school_id']])->find();
			$head_title = '('.$school['school_name'].')';
		}
		$this->assign('head_title', $head_title);
		$this->assign('admin_avatar',session('admin_auth.admin_avatar'));
	}
}
