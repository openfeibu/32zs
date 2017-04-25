<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;
use app\admin\model\MemberList;

class Member extends Base
{
	/*
     * 用户管理
     */
	public function member_list(){
		$key=input('key');
		$opentype_check=input('opentype_check','');
		$activetype_check=input('activetype_check','');
		$school_id = input('school_id','');
		$major_id = input('major_id','' );
		$where=array();
		if($this->admin['major_id'])
		{
			$major_ids = json_decode($this->admin['major_id'],true);
			$where['a.major_id'] = array('in',$major_ids);
			$major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
			$this->assign('major_list',$major_list);
		}
		if($opentype_check !== ''){
			$where['member_list_open']=$opentype_check;
		}
		if($activetype_check !== ''){
			$where['user_status']=$activetype_check;
		}
		if($school_id !== ''){
			$where['a.school_id'] = $school_id;
		}
		if($major_id !== ''){
			$where['a.major_id'] = $major_id;
		}
		$member_model=new MemberList;
		$member_list=$member_model->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
			    ->join(config('database.prefix').'school s','a.school_id = s.school_id','left')
				->join(config('database.prefix').'major m','a.major_id = m.major_id','left')
				->join(config('database.prefix').'recruit_major rm','m.recruit_major_id = rm.recruit_major_id','left')
				->where($where)->where('member_list_username|member_list_nickname','like',"%".$key."%")
				->field('a.*,b.*,m.major_name,m.major_code,m.score as major_score_key,m.major_name,s.school_id,s.school_name,rm.recruit_major_name')
				->order('member_list_addtime desc')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);

		$show=$member_list->render();
		$show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

		$data = $member_list->all();
		foreach ($data as $k => $value) {
			$major_score_arr = [];
			$major_score_desc = $major_score_total = '';
			$major_score_key =array_filter(json_decode($value['major_score_key'],true));
			if($value['major_score']){
				$major_score_arr = json_decode($value['major_score'],true);
				$major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
				$major_score_desc = major_score_desc($major_score_key,$major_score_arr);
				$major_score_total = handle_major_score($major_score_arr);
			}
			else{
				$major_score_arr = json_decode($value['major_score'],true);
				$major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
			}
			$data[$k]['major_score_arr'] = $major_score_arr;
			$data[$k]['major_score_desc'] = $major_score_desc;
			$data[$k]['major_score_total'] = $major_score_total;
			$data[$k]['total_score'] = $major_score_total + $value['recruit_score'];
		}
		/*
		if($this->admin['major_id'])
		{
			$major_ids = json_decode($this->admin['major_id'],true);
			$major = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->find();
			$major_score_key =array_filter(json_decode($major['score'],true));
			$this->assign('major_score_key',$major_score_key);
		}*/

		$school_list = Db::name('school')->select();


		$this->assign('school_list',$school_list);
		$this->assign('opentype_check',$opentype_check);
		$this->assign('activetype_check',$activetype_check);
		$this->assign('member_list',$data);
		$this->assign('page',$show);
		$this->assign('val',$key);
		if(request()->isAjax()){
			if($this->admin['major_id'])
			{
				return $this->fetch('sec_vocat_ajax_member_list');
			}
			return $this->fetch('ajax_member_list');
		}else{
			if($this->admin['major_id'])
			{
				return $this->fetch('sec_vocat_member_list');
			}
			return $this->fetch();
		}
	}

	/*
     * 添加用户显示
     */
	public function member_add(){
		$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
					->join(config('database.prefix').'auth_group c','b.group_id = c.id')
					->where(array('a.admin_id'=>session('admin_auth.aid')))
					->find();
		$this->assign('admin',$admin);
		$province = Db::name('Region')->where ( array('pid'=>1) )->select ();
		$this->assign('province',$province);
		$member_group=Db::name('member_group')->order('member_group_order')->select();
		$this->assign('member_group',$member_group);
		$major_ids = json_decode($admin['major_id'],true);
		$major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
        $this->assign('major_list',$major_list);
		return $this->fetch();
	}

	/*
     * 添加用户操作
     */
	public function member_runadd(){
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_list'));
		}else{
			$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
						->join(config('database.prefix').'auth_group c','b.group_id = c.id')
						->where(array('a.admin_id'=>session('admin_auth.aid')))
						->find();
		//	$school_id =  input('school_id');
			$major_id =  input('major_id');
			$member_list_salt=random(10);
			$sl_data=array(
				'member_list_groupid'=>1,
				'member_list_username'=>input('member_list_username'),
				'member_list_salt' => $member_list_salt,
				'member_list_pwd'=>encrypt_password(input('member_list_pwd'),$member_list_salt),
				'member_list_nickname'=>input('member_list_nickname'),
				'member_list_province'=>input('member_list_province'),
				'member_list_city'=>input('member_list_city'),
				'member_list_town'=>input('member_list_town'),
				'member_list_sex'=>input('member_list_sex'),
				'member_list_tel'=>input('member_list_tel'),
				'member_list_email'=>input('member_list_email'),
				'member_list_open'=>input('member_list_open',1),
				'user_url'=>input('user_url'),
				'member_list_addtime'=>time(),
				'user_status'=>input('user_status',0),
				'signature'=>input('signature'),
				'score'=>input('score',0,'intval'),
				'coin'=>input('coin',0,'intval'),
				'school_id' => $admin['school_id'],
				'major_id' => $major_id
			);
			$rst=MemberList::create($sl_data);
			$data['member_list_id'] = $rst->member_list_id;
			$data['certificate'] = json_encode(config('certificate'));
			$data['resume'] = json_encode(config('resume'));
			$data['prize'] = json_encode(config('prize'));
			$data['family'] = json_encode(config('family'));
			$info = Db::name('member_info')->insert($data);
			if($rst!==false){
				$this->success('会员添加成功',url('admin/Member/member_list'));
			}else{
				$this->error('会员添加失败',url('admin/Member/member_list'));
			}
		}
	}

	/*
     * 修改用户信息界面
     */
	public function member_edit(){
		$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
					->join(config('database.prefix').'auth_group c','b.group_id = c.id')
					->where(array('a.admin_id'=>session('admin_auth.aid')))
					->find();
		$this->assign('admin',$admin);
		$province = Db::name('Region')->where ( array('pid'=>1) )->select ();
		$member_group=Db::name('member_group')->order('member_group_order')->select();
		$member_list_edit=Db::name('member_list')->where(array('member_list_id'=>input('member_list_id')))->find();
		$city=Db::name('Region')->where ( array('pid'=>$member_list_edit['member_list_province']) )->select ();
		$town=Db::name('Region')->where ( array('pid'=>$member_list_edit['member_list_city']) )->select ();

		$school_list = Db::name('school')->select();
		if($admin['major_id'])
		{
			$major_ids = json_decode($admin['major_id'],true);
			$major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
		}else{
			$major_list = Db::name('major')->where(array('school_id' => $member_list_edit['school_id']))->select();
		}

		$info =  MemberList::getMember(input('member_list_id'));
		$major = Db::name('major')->where(array('major_id' => $member_list_edit['major_id']))->find();
		$major_score = json_decode($major['score'],true);
		$major_score = array_filter($major_score);
		$this->assign('major_score',$major_score);
		$this->assign('info',$info);
		$this->assign('school_list',$school_list);
		$this->assign('major_list',$major_list);
		$this->assign('member_list_edit',$member_list_edit);
		$this->assign('province',$province);
		$this->assign('city',$city);
		$this->assign('town',$town);
		$this->assign('member_group',$member_group);
		return $this->fetch();
	}
	/*
	 * 修改用户操作
	 */
	public function member_runedit(){
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_list'));
		}else{
			$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
						->join(config('database.prefix').'auth_group c','b.group_id = c.id')
						->where(array('a.admin_id'=>session('admin_auth.aid')))
						->find();
			$school_id = input('school_id',0,'intval');
			$major_id = input('major_id',0,'intval');

			$sl_data['member_list_id']=input('member_list_id');
			$sl_data['member_list_groupid']=1;
			$sl_data['member_list_username']=input('member_list_username');
			$pwd=input('member_list_pwd');
			if (!empty($pwd)){
				$member_list_salt=random(10);
				$sl_data['member_list_salt']=$member_list_salt;
				$sl_data['member_list_pwd']=encrypt_password($pwd,$member_list_salt);
			}
			$sl_data['member_list_nickname']=input('member_list_nickname');
			$sl_data['member_list_province']=input('member_list_province');
			$sl_data['member_list_city']=input('member_list_city');
			$sl_data['member_list_town']=input('member_list_town');
			$sl_data['member_list_sex']=input('member_list_sex');
			$sl_data['member_list_tel']=input('member_list_tel');
			$sl_data['member_list_email']=input('member_list_email');
			$sl_data['user_status']=input('user_status',0);
			$sl_data['member_list_open']=input('member_list_open',1);
			$sl_data['user_url']=input('user_url');
			$sl_data['signature']=input('signature');
			$sl_data['score']=input('score',0,'intval');
			$sl_data['coin']=input('coin',0,'intval');
			$sl_data['school_id']=$school_id;
			$sl_data['major_id']=$major_id;
			$rst=MemberList::update($sl_data);
			if($rst!==false){
				$this->success('会员修改成功');
			}else{
				$this->error('会员修改失败');
			}
		}
	}
	/*
     * 会员禁止/取消禁止
     */
	public function member_state(){
		$id=input('x');
		$member_model=new MemberList;
		$status=$member_model->where(array('member_list_id'=>$id))->value('member_list_open');//判断当前状态情况
		if($status==1){
			$statedata = array('member_list_open'=>0);
			$member_model->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('状态禁止');
		}else{
			$statedata = array('member_list_open'=>1);
			$member_model->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('状态开启');
		}
	}
	//批量审核
	public function open()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择用户",url('admin/Member/member_list',array('p'=>$p)));
		}
		if(is_array($ids)){//判断获取文章ID的形式是否数组
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}
		$member_model=new MemberList;
		$rst=$member_model->where($where)->setField('member_list_open',1);
		if($rst!==false){
			$this->success("操作成功",url('admin/Member/member_list',array('p'=>$p)));
		}else{
			$this -> error("操作失败！",url('admin/Member/member_list',array('p'=>$p)));
		}
	}
	//批量激活
	public function active()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择用户",url('admin/Member/member_list',array('p'=>$p)));
		}
		if(is_array($ids)){//判断获取文章ID的形式是否数组
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}
		$member_model=new MemberList;
		$rst=$member_model->where($where)->setField('user_status',1);
		if($rst!==false){
			$this->success("操作成功",url('admin/Member/member_list',array('p'=>$p)));
		}else{
			$this -> error("操作失败！",url('admin/Member/member_list',array('p'=>$p)));
		}
	}
	/*
     * 会员激活/取消激活
     */
	public function member_active()
	{
		$id=input('x');
		$member_model=new MemberList;
		$status=$member_model->where(array('member_list_id'=>$id))->value('user_status');//判断当前状态情况
		if($status==1){
			$statedata = array('user_status'=>0);
			$member_model->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('未通过');
		}else{
			$statedata = array('user_status'=>1);
			$member_model->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('已通过');
		}
	}

	/*
     * 会员删除
     */
	public function member_del()
	{
		$p=input('p');
		$member_list_id=input('member_list_id');
		$member_model=new MemberList;
		$rst=Db::name('admin')->where('member_id',$member_list_id)->find();
		if($rst){
			$this->error('此会员已关联管理员,请从管理员处删除',url('admin/Member/member_list', array('p' => $p)));
		}else{
			$rst=$member_model->where(array('member_list_id'=>$member_list_id))->delete();
			if($rst!==false){
				$this->success('会员删除成功',url('admin/Member/member_list', array('p' => $p)));
			}else{
				$this->error('会员删除失败',url('admin/Member/member_list', array('p' => $p)));
			}
		}
	}
	/*
     *会员组显示列表
     */
	public function member_group_list()
	{
		$member_group=Db::name('member_group');
		$member_group_list=$member_group->order('member_group_order')->select();
		$this->assign('member_group_list',$member_group_list);
		return $this->fetch();
	}

	/*
     * 会员组添加方法
     */
	public function member_group_runadd()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_group_list'));
		}else{
			$rst=Db::name('member_group')->insert(input('post.'));
			if($rst!==false){
				$this->success('会员组添加成功',url('admin/Member/member_group_list'));
			}else{
				$this->error('会员组添加失败',url('admin/Member/member_group_list'));
			}
		}
	}

	/*
     * 会员组删除
     */
	public function member_group_del()
	{
		$member_group_id=input('member_group_id');
		if (empty($member_group_id)){
			$this->error('会员组ID不存在',url('admin/Member/member_group_list'));
		}
        $rst=Db::name('member_group')->where(array('member_group_id'=>input('member_group_id')))->delete();
        if($rst!==false){
            $this->success('会员组删除成功',url('admin/Member/member_group_list'));
        }else{
            $this->error('会员组删除失败',url('admin/Member/member_group_list'));
        }
	}

	/*
     * 改变会员组状态
     */
	public function member_group_state()
	{
		$member_group_id=input('x');
		if (!$member_group_id){
			$this->error('ID:'.$member_group_id.'不存在',url('admin/Member/member_group_list'));
		}
		$status=Db::name('member_group')->where(array('member_group_id'=>$member_group_id))->value('member_group_open');//判断当前状态情况
		if($status==1){
			$statedata = array('member_group_open'=>0);
			Db::name('member_group')->where(array('member_group_id'=>$member_group_id))->setField($statedata);
			$this->success('状态禁止');
		}else{
			$statedata = array('member_group_open'=>1);
			Db::name('member_group')->where(array('member_group_id'=>$member_group_id))->setField($statedata);
			$this->success('状态开启');
		}
	}

	/*
     * 排序更新
     */
	public function member_group_order()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_group_list'));
		}else{
			$post=input('post.');
			foreach ($post as $id => $sort){
				Db::name('member_group')->where(array('member_group_id' => $id ))->setField('member_group_order' , $sort);
			}
			$this->success('排序更新成功',url('admin/Member/member_group_list'));
		}
	}

	/*
     * 修改会员组返回值
     */
	public function member_group_edit()
	{
		$member_group_id=input('member_group_id');
		$member_group=Db::name('member_group')->where(array('member_group_id'=>$member_group_id))->find();
		$sl_data['member_group_id']=$member_group['member_group_id'];
		$sl_data['member_group_name']=$member_group['member_group_name'];
		$sl_data['member_group_open']=$member_group['member_group_open'];
		$sl_data['member_group_toplimit']=$member_group['member_group_toplimit'];
		$sl_data['member_group_bomlimit']=$member_group['member_group_bomlimit'];
		$sl_data['member_group_order']=$member_group['member_group_order'];
		$sl_data['code']=1;
		return json($sl_data);
	}

	/*
     * 修改用户组方法
     */
	public function member_group_runedit()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_group_list'));
		}else{
			$sl_data=array(
				'member_group_id'=>input('member_group_id'),
				'member_group_name'=>input('member_group_name'),
				'member_group_toplimit'=>input('member_group_toplimit'),
				'member_group_bomlimit'=>input('member_group_bomlimit'),
				'member_group_order'=>input('member_group_order'),

			);
			$rst=Db::name('member_group')->update($sl_data);
			if($rst!==false){
				$this->success('会员组修改成功',url('admin/Member/member_group_list'));
			}else{
				$this->error('会员组修改失败',url('admin/Member/member_group_list'));
			}
		}
	}
	public function member_import()
	{
		$major_ids = json_decode($this->admin['major_id'],true);
		$major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
		$this->assign('major_list',$major_list);
		return $this->fetch();
	}
	public function member_runimport()
	{

		if (! empty ( $_FILES ['file_stu'] ['name'] )){
			$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
						->join(config('database.prefix').'auth_group c','b.group_id = c.id')
						->join(config('database.prefix').'school s','s.school_id')
						->where(array('a.admin_id'=>session('admin_auth.aid')))
						->find();

			$tmp_file = $_FILES ['file_stu'] ['tmp_name'];
			$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
			$file_type = $file_types [count ( $file_types ) - 1];
			/*判别是不是.xls文件，判别是不是excel文件*/
			if (strtolower ( $file_type ) != "xls"){
				$this->error ( '不是Excel文件，重新上传',url('admin/Member/member_import'));
			}
			/*设置上传路径*/
			$savePath =ROOT_PATH. 'public/excel/';
			/*以时间来命名上传的文件*/
			$str = time ();
			$file_name = $str . "." . $file_type;
			if (! copy ( $tmp_file, $savePath . $file_name )){
				$this->error ('上传失败',url('admin/Member/member_import'));
			}
			$res = read ( $savePath . $file_name );
			if (!$res){
				$this->error ('数据处理失败',url('admin/Member/member_import'));
			}
	        foreach ( $res as $k => $v ){
	            if ($k != 1){
	                $data=array();
	                $member_list_salt = random(10);
	                $member_list_pwd = substr($str, -6);
	                $sl_data = [
	                    'member_list_groupid' => 1,
	    				'member_list_username'=>$v[0],
	    				'member_list_salt' => $member_list_salt,
	    				'member_list_pwd'=>encrypt_password($member_list_pwd,$member_list_salt),
	    				'member_list_nickname'=>$v[1],
	    				'member_list_open'=>1,
	    				'member_list_addtime'=>time(),
	    				'user_status'=>0,
	    				'score'=>0,
	    				'coin'=>0,
	    				'school_id' => $admin['school_id'],
	    				'major_id' => input('major_id')
	                ];
	                $result = MemberList::create($sl_data);

	                if($result)
	                {
	                    $data['member_list_id'] = $result->member_list_id;
	        			$data['certificate'] = json_encode(config('certificate'));
	        			$data['resume'] = json_encode(config('resume'));
	        			$data['prize'] = json_encode(config('prize'));
	        			$data['family'] = json_encode(config('family'));
	        			$info = Db::name('member_info')->insert($data);
	                }
	                if (!$result){
	                    $this->error ('导入数据失败',url('admin/Member/member_import'));
	                }
	            }
			}
			$this->success ('导入数据成功',url('admin/Member/member_list'));
		}
	}

	private function getMemberInfo($user)
	{
		$info = Db::name('member_info')->where(array('member_list_id'=>$user['member_list_id']))->find();
		$info['name'] = $user['member_list_nickname'];
		$info['cardId'] = $user['member_list_username'];
		$info['certificate'] = json_decode($info['certificate'],true);
		$info['resume'] = json_decode($info['resume'],true);
		$info['prize'] = json_decode($info['prize'],true);
		$info['family'] = json_decode($info['family'],true);
		return $info;
	}
	public function getMember($member_list_id)
	{
		$member= Db::name('member_list')->alias('m')
					->join(config('database.prefix').'member_info mi','m.member_list_id =mi.member_list_id')
					->where(array('member_list_id' => $member_list_id))->find();
		return $member;
	}
	public function update_info()
	{
		$member_list_id = input('member_list_id');
		$member_list_edit=Db::name('member_list')->where(array('member_list_id'=>$member_list_id))->find();
		$info = $this->getMemberInfo($member_list_edit);
		$name = input('name');
		$value = input('value');
		if(strstr($name,'certificate'))
		{
			$type = "certificate";
		}
		else if(strstr($name,'prize'))
		{
			$type = "prize";
		}
		else if(strstr($name,'resume'))
		{
			$type = "resume";
		}
		else if(strstr($name,'family')){
			$type = "family";
		}
		if(isset($type))
		{
			$arr = $info[$type];
			$vaArr = explode('_',$name);
			$arr[$vaArr['1']][$vaArr['0']] = $value;
			$name = $type;
			$value = json_encode($arr);
		}
		Db::name('member_info')->where(array('member_list_id'=>$member_list_id))->update(array($name => $value));

	}
}
