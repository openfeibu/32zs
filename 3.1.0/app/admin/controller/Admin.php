<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\model\AuthRule;
use app\admin\model\SchoolModel;
use think\Db;
use think\Cache;
use app\admin\model\Major as MajorModel;

class Admin extends Base
{
	/**
	 * 管理员列表
	 */
	public function admin_list()
	{
		$search_name=input('search_name');
		$group_id = input('group_id','');
		$this->assign('search_name',$search_name);
		$map=array();
		if($search_name){
			$map['admin_username']= array('like',"%".$search_name."%");
		}
		if($group_id){
			$map['aga.group_id'] = 4;
		}
		$admin_list=Db::name('admin')->alias('a')
							->join(config('database.prefix').'auth_group_access aga','aga.uid = a.admin_id')
							->where($map)->order('a.admin_id')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$page = $admin_list->render();
		$this->assign('group_id',$group_id);
		$this->assign('admin_list',$admin_list);
		$this->assign('page',$page);
		return $this->fetch();
	}

	/**
	 * 管理员添加
	 */
	public function admin_add()
	{
		$group_id = input('group_id','');
		$school_list = Db::name('school')->select();
		$auth_group=Db::name('auth_group')->select();
		$this->assign('school_list',$school_list);
		$this->assign('auth_group',$auth_group);
		$this->assign('group_id',$group_id);
		return $this->fetch();
	}
	/**
	 * 管理员添加操作
	 */
	public function admin_runadd()
	{
		$major_id = null !== input('major_id') ? input('major_id') : 0;
		$admin_id=AdminModel::add(input('admin_username'),'',input('admin_pwd'),input('admin_email',''),input('admin_tel',''),input('admin_open',1),input('admin_realname',''),input('group_id'),input('school_id','0'),$major_id);
		if($admin_id){
			$this->success('管理员添加成功',url('admin/Admin/admin_list'));
		}else{
			$this->error('已存在管理员或添加失败',url('admin/Admin/admin_list'));
		}
	}
	/**
	 * 管理员修改
	 */
	public function admin_edit()
	{
		$auth_group=Db::name('auth_group')->select();
		$admin_list=Db::name('admin')->find(input('admin_id'));
		$auth_group_access=Db::name('auth_group_access')->where(array('uid'=>$admin_list['admin_id']))->value('group_id');
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		$this->assign('admin_list',$admin_list);
		$this->assign('auth_group',$auth_group);
		$this->assign('auth_group_access',$auth_group_access);
		return $this->fetch();
	}
	/**
	 * 重置密码
	 */
	public function admin_changed_reset($admin_id){
		$data['admin_pwd'] = '123456';
        $data['admin_pwd_salt']=random(10);
        $data['admin_pwd']=encrypt_password($data['admin_pwd'],$data['admin_pwd_salt']);
        $data['admin_changepwd']=time();
 		$res = Db::name('admin')->where('admin_id',$admin_id)->update($data);
 		if($res)
			return json(['msg'=>'重置密码成功']);
		else
			return json(['msg'=>'重置密码失败']);

	}
	/**
	 * 管理员修改操作
	 */
	public function admin_runedit()
	{
		$data=input('post.');
		$rst=AdminModel::edit($data);
		if($rst!==false){
			$this->success('管理员修改成功',url('admin/Admin/admin_list'));
		}else{
			$this->error('管理员修改失败',url('admin/Admin/admin_list'));
		}
	}
	/**
	 * 管理员删除
	 */
	public function admin_del()
	{
		$admin_id=input('admin_id');
		if (empty($admin_id)){
			$this->error('用户ID不存在',url('admin/Admin/admin_list'));
		}
		//对应考生ID
		$member_id=Db::name('admin')->where('admin_id',$admin_id)->value('member_id');
		Db::name('admin')->delete($admin_id);
		//删除对应考生
		if($member_id){
			Db::name('member_list')->delete($member_id);
		}
		$rst=Db::name('auth_group_access')->where('uid',$admin_id)->delete();
		if($rst!==false){
			$this->success('管理员删除成功',url('admin/Admin/admin_list'));
		}else{
			$this->error('管理员删除失败',url('admin/Admin/admin_list'));
		}
	}
	public function admin_delall()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/Admin/admin_list',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'admin_id in('.implode(',',$ids).')';
		}else{
			$where = 'admin_id = '.$ids;
		}
		$rst = Db::name('admin')->where($where)->delete();
		$url = input('return_url','');
		if($rst!==false){
			$this->success('管理员删除成功',$url);
		}else{
			$this->error('管理员删除失败',$url);
		}
	}
	public function secondary_vocat_admin_list()
	{
		$search_name=input('search_name');
		$this->assign('search_name',$search_name);
		$map=array();
		$map['aga.group_id'] = 3;
		if($search_name){
			$map['a.admin_username']= array('like',"%".$search_name."%");
		}
		$admin_list=Db::name('admin')->alias('a')
							->join(config('database.prefix').'auth_group_access aga','aga.uid = a.admin_id')
							->join(config('database.prefix').'school s','s.school_id = a.school_id')
							->where($map)->order('a.admin_id','desc')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		
		
		$data = $admin_list->all();
		foreach ($data as $key => $value) {
			$major_ids = array_filter(json_decode($value['major_id'],true));
			$major_list = MajorModel::get_secondary_vocat_major_list($major_ids,$value['school_id']);
			$major_desc = '';
			foreach ($major_list as $k => $v) {
				$major_desc .= '<span style="margin-right:10px;">'.$v['major_name'].'</span>';
			}
			$data[$key]['major_desc'] = $major_desc;
		}
		$page = $admin_list->render();
		$this->assign('group_id',4);
		$this->assign('admin_list',$data);
		$this->assign('page',$page);
		return $this->fetch();
	}
	public function secondary_vocat_admin_add()
	{
		$group_id = 3;
		$school_list = Db::name('school')->select();
		$auth_group=Db::name('auth_group')->select();
		$this->assign('school_list',$school_list);
		$this->assign('auth_group',$auth_group);
		$this->assign('group_id',$group_id);
		return $this->fetch();
	}
	public function secondary_vocat_admin_runadd()
	{
		$school_id = input('school_id');
		$major_id = json_encode($_POST['major_id']);
		$admin_id=AdminModel::add(input('admin_username'),'',input('admin_pwd'),input('admin_email',''),input('admin_tel',''),input('admin_open',1),input('admin_realname',''),3,$school_id,$major_id);
		if($admin_id){
			$this->success('管理员添加成功',url('admin/Admin/secondary_vocat_admin_list'));
		}else{
			$this->error('已存在管理员或添加失败',url('admin/Admin/secondary_vocat_admin_list'));
		}
	}

	//secondary_vocat_admin_list
	public function check_admin_list($report="false"){
		//逻辑编写
		//1 先查询招生计划表 当前年份  键 中职专业，学校id
		//2 查询管理员表 对应的
		//3 有则直接调出来，
		//4 无则新创建一个
		$search_name=input('search_name');
		$this->assign('search_name',$search_name);
		//当前年份
		$list = Db::name('enrollment')->where(get_year_where())->select();

		$admin_list = [];

		foreach ($list as $key => $value) {
			//获取最后一个userid 进行递增排序
			$username = Db::name('auth_group_access')->alias('aga')
						->join('zs_admin a','a.admin_id = aga.uid')
						->where('group_id',3)->limit(1)->order('uid desc')->column('admin_username');

			//没有中职专业负责老师
			// dump($username);
			if($username){
				preg_match_all('/\d+/',$username[0],$user_id);
				$user_id = intval($user_id[0][0]+1); //递增
				$user_id_len = strlen($user_id);
				for ($i=0; $i < 3-$user_id_len; $i++) { 
					$user_id = '0'.$user_id;
				}
			}else{
				$user_id = '001';
			}
			
			// preg_match_all('/\d+/',$username[0],$user_id);
			// $user_id = intval($user_id[0][0]+1); //递增
			// $user_id_len = strlen($user_id);
			// for ($i=0; $i < 3-$user_id_len; $i++) { 
			// 	$user_id = '0'.$user_id;
			// }
			$new_user_id = "gdaib".$user_id;

			// $username = $username+1;
			// echo $value['school_id']."<br>";
			// echo $value['major_ids']."<br>";
			preg_match_all('/\d+/',$value['major_ids'],$arr);
			$major_ids = join('',$arr[0]);
			//专业
			$major_id = "[\"".$major_ids."\"]";

			//学校
			$school_id = $value['school_id'];

			// echo $school_id."<br>";
			// echo $major_id."<br>";

			$check_admin = Db::name('admin')->alias('a')
				->join('zs_school s','s.school_id = a.school_id')
				->where('a.school_id',$school_id)
				->where('a.major_id',$major_id)
				->select();


			if($check_admin){
				//查询专业名称
				$get_major_name = Db::name('major')->where('major_id',$major_ids)->find();
				$check_admin[0] = array_merge($check_admin[0],$get_major_name);
				$check_admin[0]['addtime'] = date('Y-m-d H:i:s',$check_admin[0]['admin_addtime']);
				$admin_list = array_merge($admin_list,$check_admin);
			}else{
				// echo $school_id;
				// echo $school_id."<br>";
				// echo $major_id."<br>";
				// echo $new_user_id."<br>";
				$admin_id=AdminModel::add($new_user_id,'','123456',input('admin_email',''),input('admin_tel',''),input('admin_open',1),input('admin_realname',''),3,$school_id,$major_id);
				$check_admin = Db::name('admin')->where('admin_id',$admin_id)->select();
				//查询专业名称
				$get_major_name = Db::name('major')->where('major_id',$major_ids)->find();
				$check_admin[0] = array_merge($check_admin[0],$get_major_name);
				//time
				$check_admin[0]['addtime'] = date('Y-m-d H:i:s',$check_admin[0]['admin_addtime']);
				$admin_list = array_merge($admin_list,$check_admin);
				// dump($admin_id);
			}
		}

		if($report == 'true'){
			return $admin_list;
		}
		// dump($admin_list);

		$this->assign('admin_list',$admin_list);
		$this->assign('page','');
		return $this->fetch();


	}
	//2019.11.20
	public function check_admin_list_export()
	{
		$data = $this->check_admin_list('true');
		// halt($data);
		// $map['aga.group_id'] = 3;
		// $data = Db::name('admin')->alias('a')
		// 					->join(config('database.prefix').'auth_group_access aga','aga.uid = a.admin_id')
		// 					->join(config('database.prefix').'school s','s.school_id = a.school_id')
		// 					->where($map)->order('a.admin_id','desc')->select();

		// foreach ($data as $key => $value) {
		// 	$major_ids = array_filter(json_decode($value['major_id'],true));
		// 	$major_list = MajorModel::get_secondary_vocat_major_list($major_ids,$value['school_id']);
		// 	$major_desc = '';
		// 	foreach ($major_list as $k => $v) {
		// 		$major_desc .= $v['major_name'].'   ';
		// 	}
		// 	$data[$key]['major_desc'] = $major_desc;
		// }
		
		$field_titles = ['中职专业负责人','中职学校','中职专业','创建时间'];
        $fields = ['admin_username','school_name','major_name','addtime'];
        $table = '中职专业负责人'.date('YmdHis');
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

	public function secondary_vocat_admin_edit()
	{
		$auth_group=Db::name('auth_group')->select();
		$admin_list=Db::name('admin')->find(input('admin_id'));
		$auth_group_access=Db::name('auth_group_access')->where(array('uid'=>$admin_list['admin_id']))->value('group_id');

		$school_id = $admin_list['school_id'];
		$major_ids = json_decode($admin_list['major_id'],true);

		$major_list = MajorModel::get_major_list($school_id);
		$majors = Db::name('major')->where(['major_id' => array('in',$major_ids)])->select();
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		$this->assign('majors',$majors);
		$this->assign('major_ids',$major_ids);
		$this->assign('major_list',$major_list);
		$this->assign('admin_list',$admin_list);
		$this->assign('auth_group',$auth_group);
		$this->assign('auth_group_access',$auth_group_access);
		return $this->fetch();
	}
	public function secondary_vocat_admin_runedit()
	{
		$data=input('post.');
		$data['school_id'] = input('school_id');
		$data['major_id'] = json_encode($_POST['major_id']);
		$data['group_id'] = 3;
		$rst=AdminModel::edit($data);
		if($rst!==false){
			$this->success('修改成功',url('admin/Admin/secondary_vocat_admin_list'));
		}else{
			$this->error('修改失败',url('admin/Admin/secondary_vocat_admin_list'));
		}
	}
	public function secondary_vocat_admin_del()
	{
		$admin_id=input('admin_id');
		if (empty($admin_id)){
			$this->error('用户ID不存在',url('admin/Admin/admin_list'));
		}
		//对应考生ID
		$member_id=Db::name('admin')->where('admin_id',$admin_id)->value('member_id');
		Db::name('admin')->delete($admin_id);
		//删除对应考生
		if($member_id){
			Db::name('member_list')->delete($member_id);
		}
		$rst=Db::name('auth_group_access')->where('uid',$admin_id)->delete();
		if($rst!==false){
			$this->success('删除成功',url('admin/Admin/secondary_vocat_admin_list'));
		}else{
			$this->error('删除失败',url('admin/Admin/secondary_vocat_admin_list'));
		}
	}
	public function secondary_vocat_admin_export()
	{
		$map['aga.group_id'] = 3;
		$data = Db::name('admin')->alias('a')
							->join(config('database.prefix').'auth_group_access aga','aga.uid = a.admin_id')
							->join(config('database.prefix').'school s','s.school_id = a.school_id')
							->where($map)->order('a.admin_id','desc')->select();

		foreach ($data as $key => $value) {
			$major_ids = array_filter(json_decode($value['major_id'],true));
			$major_list = MajorModel::get_secondary_vocat_major_list($major_ids,$value['school_id']);
			$major_desc = '';
			foreach ($major_list as $k => $v) {
				$major_desc .= $v['major_name'].'   ';
			}
			$data[$key]['major_desc'] = $major_desc;
		}
		
		$field_titles = ['中职专业负责人','中职学校','中职专业'];
        $fields = ['admin_username','school_name','major_desc'];
        $table = '中职专业负责人'.date('YmdHis');
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
	public function university_admin_list()
	{
		$search_name=input('search_name');
		$this->assign('search_name',$search_name);
		$map=array();
		$map['aga.group_id'] = 4;
		if($search_name){
			$map['a.admin_username']= array('like',"%".$search_name."%");
		}
		$admin_list=Db::name('admin')->alias('a')
							->join(config('database.prefix').'auth_group_access aga','aga.uid = a.admin_id')
							->join(config('database.prefix').'recruit_major rm','rm.recruit_major_id = a.recruit_major_id')
							->where($map)->order('a.admin_id','desc')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$page = $admin_list->render();
		$this->assign('group_id',4);
		$this->assign('admin_list',$admin_list);
		$this->assign('page',$page);
		return $this->fetch();
	}
	public function university_admin_add()
	{
		$group_id = 4;
		$school_list = Db::name('school')->select();
		$auth_group=Db::name('auth_group')->select();
		$this->assign('school_list',$school_list);
		$this->assign('group_id',$group_id);
		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		return $this->fetch();
	}
	public function university_admin_runadd()
	{
		$major_id = null !== input('major_id') ? input('major_id') : 0;
		$admin_id=AdminModel::add(input('admin_username'),'',input('admin_pwd'),input('admin_email',''),input('admin_tel',''),input('admin_open',1),input('admin_realname',''),4,input('school_id','0'),$major_id,input('recruit_major_id',0));
		if($admin_id){
			$this->success('添加成功',url('admin/Admin/university_admin_list'));
		}else{
			$this->error('已存在管理员或添加失败',url('admin/Admin/university_admin_list'));
		}
	}
	public function university_admin_edit()
	{
		$auth_group=Db::name('auth_group')->select();
		$admin_list=Db::name('admin')->find(input('admin_id'));
		$auth_group_access=Db::name('auth_group_access')->where(array('uid'=>$admin_list['admin_id']))->value('group_id');
		$school_list = Db::name('school')->select();
		$major_list = Db::name('major')->where(array('major_id' => $admin_list['major_id']))->select();
		$this->assign('school_list',$school_list);
		$this->assign('major_list',$major_list);
		$this->assign('admin_list',$admin_list);
		$this->assign('auth_group',$auth_group);
		$this->assign('auth_group_access',$auth_group_access);
		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		return $this->fetch();
	}

	public function university_admin_runedit()
	{
		$data=input('post.');
		$data['group_id'] = 4;
		$rst=AdminModel::edit($data);
		if($rst!==false){
			$this->success('修改成功',url('admin/Admin/university_admin_list'));
		}else{
			$this->error('修改失败',url('admin/Admin/university_admin_list'));
		}
	}
	public function university_admin_del()
	{
		$admin_id=input('admin_id');
		if (empty($admin_id)){
			$this->error('用户ID不存在',url('admin/Admin/admin_list'));
		}
		//对应考生ID
		$member_id=Db::name('admin')->where('admin_id',$admin_id)->value('member_id');
		Db::name('admin')->delete($admin_id);
		//删除对应考生
		if($member_id){
			Db::name('member_list')->delete($member_id);
		}
		$rst=Db::name('auth_group_access')->where('uid',$admin_id)->delete();
		if($rst!==false){
			$this->success('删除成功',url('admin/Admin/university_admin_list'));
		}else{
			$this->error('删除失败',url('admin/Admin/university_admin_list'));
		}
	}
	public function university_admin_export()
	{
		$map['aga.group_id'] = 4;
		$data=Db::name('admin')->alias('a')
							->join(config('database.prefix').'auth_group_access aga','aga.uid = a.admin_id')
							->join(config('database.prefix').'recruit_major rm','rm.recruit_major_id = a.recruit_major_id')
							->where($map)->order('a.admin_id','desc')->select();

		$field_titles = ['高职专业负责人','高职专业'];
		$fields = ['admin_username','recruit_major_name'];
		$table = '高职专业负责人'.date('YmdHis');
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
	/**
	 * 管理员开启/禁止
	 */
	public function admin_state()
	{
		$id=input('x');
		if (empty($id)){
			$this->error('用户ID不存在',url('admin/Admin/admin_list'));
		}
		$status=Db::name('admin')->where('admin_id',$id)->value('admin_open');//判断当前状态情况
		if($status==1){
			$statedata = array('admin_open'=>0);
			Db::name('admin')->where('admin_id',$id)->setField($statedata);
			$this->success('状态禁止');
		}else{
			$statedata = array('admin_open'=>1);
			Db::name('admin')->where('admin_id',$id)->setField($statedata);
			$this->success('状态开启');
		}
	}
	/**
	 * 用户组列表
	 */
	public function admin_group_list()
	{
		$auth_group=Db::name('auth_group')->select();
		$this->assign('auth_group',$auth_group);
		return $this->fetch();
	}
	/**
	 * 用户组添加
	 */
	public function admin_group_add()
	{
		return $this->fetch();
	}
	/**
	 * 用户组添加操作
	 */
	public function admin_group_runadd()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Admin/admin_group_list'));
		}else{
			$sldata=array(
				'title'=>input('title'),
				'status'=>input('status',0),
				'addtime'=>time(),
			);
			$rst=Db::name('auth_group')->insert($sldata);
			if($rst!==false){
				$this->success('用户组添加成功',url('admin/Admin/admin_group_list'));
			}else{
				$this->error('用户组添加失败',url('admin/Admin/admin_group_list'));
			}
		}
	}
	/**
	 * 用户组删除操作
	 */
	public function admin_group_del()
	{
		$rst=Db::name('auth_group')->delete(input('id'));
		if($rst!==false){
			$this->success('用户组删除成功',url('admin/Admin/admin_group_list'));
		}else{
			$this->error('用户组删除失败',url('admin/Admin/admin_group_list'));
		}
	}
	/**
	 * 用户组编辑
	 */
	public function admin_group_edit()
	{
		$group=Db::name('auth_group')->find(input('id'));
		$this->assign('group',$group);
		return $this->fetch();
	}
	/**
	 * 用户组编辑操作
	 */
	public function admin_group_runedit()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Admin/admin_group_list'));
		}else{
			$sldata=array(
				'id'=>input('id'),
				'title'=>input('title'),
				'status'=>input('status'),
			);
			Db::name('auth_group')->update($sldata);
			$this->success('用户组修改成功',url('admin/Admin/admin_group_list'));
		}
	}
	/**
	 * 用户组开启/禁用
	 */
	public function admin_group_state()
	{
		$id=input('x');
		$status=Db::name('auth_group')->where('id',$id)->value('status');//判断当前状态情况
		if($status==1){
			$statedata = array('status'=>0);
			Db::name('auth_group')->where('id',$id)->setField($statedata);
			$this->success('状态禁止');
		}else{
			$statedata = array('status'=>1);
			Db::name('auth_group')->where('id',$id)->setField($statedata);
			$this->success('状态开启');
		}
	}
	/**
	 * 权限配置
	 */
	public function admin_group_access()
	{
		$admin_group=Db::name('auth_group')->where(array('id'=>input('id')))->find();
		$data=AuthRule::get_ruels_tree();
		$this->assign('admin_group',$admin_group);
		$this->assign('datab',$data);
		return $this->fetch();
	}
	/**
	 * 权限配置保存
	 */
	public function admin_group_runaccess()
	{
		$new_rules = input('new_rules/a');
		$imp_rules = implode(',', $new_rules);
		$sldata=array(
			'id'=>input('id'),
			'rules'=>$imp_rules,
		);
		if(Db::name('auth_group')->update($sldata)!==false){
			Cache::clear();
			$this->success('权限配置成功',url('admin/Admin/admin_group_list'));
		}else{
			$this->error('权限配置失败',url('admin/Admin/admin_group_list'));
		}
	}
	/*
	 * 管理员信息
	 */
	public function profile()
	{
		$admin=array();
		if(session('admin_auth.aid')){
			$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
					->join(config('database.prefix').'auth_group c','b.group_id = c.id')
					->where(array('a.admin_id'=>session('admin_auth.aid')))->find();
			$news_count=Db::name('News')->where(array('news_auto'=>session('admin_auth.member_id')))->count();
			$admin['news_count']=$news_count;
		}
		$this->assign('admin', $admin);
		return $this->fetch();
	}
	/*
	 * 管理员头像
	 */
	public function avatar()
	{
		$imgurl=input('imgurl');
		//去'/'
		$imgurl=str_replace('/','',$imgurl);
		$url='/data/upload/avatar/'.$imgurl;
		$state=false;
		if(config('storage.storage_open')){
			//七牛
			$upload = \Qiniu::instance();
			$info = $upload->uploadOne('.'.$url,"image/");
			if ($info) {
				$state=true;
				$imgurl= config('storage.domain').$info['key'];
				@unlink('.'.$url);
			}
		}
		if($state !=true){
			//本地
			//写入数据库
			$data['uptime']=time();
			$data['filesize']=filesize('.'.$url);
			$data['path']=$url;
			Db::name('plug_files')->insert($data);
		}
		$admin=Db::name('admin')->where(array('admin_id'=>session('admin_auth.aid')))->find();
		$admin['admin_avatar']=$imgurl;
		$rst=Db::name('admin')->where(array('admin_id'=>session('admin_auth.aid')))->update($admin);
		if($rst!==false){
			session('admin_avatar',$imgurl);
			$this->success ('头像更新成功',url('admin/Admin/profile'));
		}else{
			$this->error ('头像更新失败',url('admin/Admin/profile'));
		}
	}
	public function addMajorAdmins()
	{
		exit;
		$i = 0;
		$schools = Db::name('school')->select();
		foreach ($schools as $key => $school) {
			$i++;
			$admin_username = str_pad($i,3,"0",STR_PAD_LEFT);
			$major_list = MajorModel::get_major_list($school['school_id']);
			$major_ids = array_column($major_list,'major_id');
			Db::name('admin')->where(['school_id' =>$school['school_id'],'major_id' => json_encode($major_ids) ])->delete();
			AdminModel::add($admin_username,'','123456','','',input('admin_open',1),'',3,$school['school_id'],json_encode($major_ids));
		}

	}

	public function setGetYearWhere($year){
		// Cache::set('year','2018');
		Cache::set('year',$year);
		return $this->redirect('/admin/index');
	}
}
