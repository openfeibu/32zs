<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;
use app\admin\model\MemberList;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\Score as ScoreModel;
use app\admin\model\School as SchoolModel;

class Member extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->schoolModel = new SchoolModel();
        $this->scoreModel = new ScoreModel();
    }
	/*
     * 用户管理
     */
	public function member_list(){
		$key = trim(input('key'));
		$opentype_check=input('opentype_check','');
		$activetype_check=input('activetype_check','');
		$school_id = input('school_id','');
		$major_id = input('major_id','' );
		$map=array();
		if($this->admin['group_id'] == 3)
		{
			$major_ids = json_decode($this->admin['major_id'],true);
			$map['a.major_id'] = array('in',$major_ids);
            $map['a.school_id'] = $this->admin['school_id'];
			$major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
			$this->assign('major_list',$major_list);
			//$major_id = isset($major_ids[0]) ? $major_ids[0] : '';
		}
        if($this->admin['group_id'] == 4)
        {
            $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
            $school_id_arr = array_column($school_list,'school_id');
            $map['a.school_id'] = array('in',$school_id_arr);
            $this->assign('school_list',$school_list);
        }
		if($opentype_check !== ''){
			$map['member_list_open']=$opentype_check;
		}
		if($activetype_check !== ''){
			$map['user_status']=$activetype_check;
		}

		if($major_id !== ''){
			$map['a.major_id'] = $major_id;
		}

        if($school_id !== ''){
            $map['a.school_id'] = $school_id;
        }

		$map['member_list_username|member_list_nickname|ZexamineeNumber'] = [
			'like',"%".$key."%"
		];

		$member_model=new MemberList;
		$member_list = $member_model->getMemberList($map,'');

		$show=$member_list->render();
		/*
		$show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);*/

		$data = $member_list->all();
		$data = $member_model->handleMemberList($data);

        if($this->admin['group_id'] == 5)
        {
            $school_list = Db::name('school')->select();
            $this->assign('school_list', $school_list);
        }
		$this->assign('school_id',$school_id);
		$this->assign('major_id',$major_id);
		$this->assign('opentype_check',$opentype_check);
		$this->assign('activetype_check',$activetype_check);
		$this->assign('member_list',$data);
		$this->assign('page',$show);
		$this->assign('val',$key);

		if(request()->isAjax()){
			if($this->admin['group_id'] == 3)
			{
				return $this->fetch('sec_vocat_ajax_member_list');
			}
			if($this->admin['group_id'] == 4)
            {
                return $this->fetch('university_ajax_member_list');
            }
			return $this->fetch('ajax_member_list');
		}else{
			if($this->admin['group_id'] == 3)
			{
				return $this->fetch('sec_vocat_member_list');
			}
            if($this->admin['group_id'] == 4)
            {
                return $this->fetch('university_member_list');
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
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
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

			$school_id =  $admin['school_id'] ? $admin['school_id'] : input('school_id');
			$major_id =  input('major_id');
			$member_list_salt=random(10);
			$member_list_username = trim(input('member_list_username'));
			if(!is_idcard($member_list_username))
			{
				$this->error('身份证不正确',url('admin/Member/member_add'));
			}
			if(Db::name('member_list')->where(['member_list_username' => $member_list_username])->find()){
				$this->error('已存在该用户',url('admin/Member/member_add'));
			}

            $enrollment = EnrollmentModel::get_enrollment_major($school_id,$major_id);
            $major_ids = trim($enrollment['major_ids'],',');
            $member_count = MemberList::get_member_count(['school_id' => $school_id,'major_id' => ['in',$major_ids]]);
            if(!$enrollment)
            {
                $this->error ('未找到该中职学校下该中职专业对应的招生计划',url('admin/Member/member_add'));
            }
            if($member_count + 1 > $enrollment['enrollment_number'])
            {
                $this->error ('学生人数超过招生计划数'.$enrollment['enrollment_number'].'人',url('admin/Member/member_add'));
            }

			$birth = get_birth($member_list_username);
			$sex = get_sex($member_list_username);
			$member_list_pwd = input('member_list_pwd') ? input('member_list_pwd') : substr($member_list_username, -6);
			$sl_data=array(
				'member_list_groupid'=>1,
				'member_list_username'=> $member_list_username,
				'member_list_salt' => $member_list_salt,
				'member_list_pwd'=>encrypt_password($member_list_pwd,$member_list_salt),
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
				'school_id' => $school_id,
				'major_id' => $major_id,
                'year' => get_year(),
			);
			$rst=MemberList::create($sl_data);
			$data['member_list_id'] = $rst->member_list_id;
			$data['certificate'] = json_encode(config('certificate'));
			$data['resume'] = json_encode(config('resume'));
			$data['prize'] = json_encode(config('prize'));
			$data['family'] = json_encode(config('family'));
			$data['date'] = $birth;
			$data['sex'] = $sex;
			$info = Db::name('member_info')->insert($data);
			if($rst!==false){
				$this->success('考生添加成功',url('admin/Member/member_list'));
			}else{
				$this->error('考生添加失败',url('admin/Member/member_list'));
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
			$major_list = MajorModel::get_major_list($member_list_edit['school_id']);
		}

		$info =  MemberList::getMember(input('member_list_id'));
		$major = Db::name('major')->where(array('major_id' => $member_list_edit['major_id']))->find();
		$this->assign('major',$major);
		$this->assign('info',$info);
		$this->assign('school_list',$school_list);
		$this->assign('major_list',$major_list);
		$this->assign('member_list_edit',$member_list_edit);
		$this->assign('province',$province);
		$this->assign('city',$city);
		$this->assign('town',$town);
		$this->assign('member_group',$member_group);

		$school = Db::name('school')->where(array('school_id' => $member_list_edit['school_id']))->find();
		$this->assign('school',$school);
		$recruit_major = RecruitMajorModel::get_recruit_major($member_list_edit['school_id'],$member_list_edit['major_id']);
		$this->assign('recruit_major',$recruit_major);
        $school_id = input('school_id','');
		if($this->admin['group_id'] == 3) {
            $major_ids = json_decode($this->admin['major_id'], true);
            $where['a.major_id'] = array('in', $major_ids);
            if ($this->admin['school_id']) {
                $where['a.school_id'] = $this->admin['school_id'];
            } else {
                if ($school_id !== '') {
                    $where['a.school_id'] = $school_id;
                }
            }
        }
        if($this->admin['group_id'] == 4) {
            $school_list = $this->schoolModel->get_school_list_rmi($this->admin['recruit_major_id']);
            $school_id_arr = array_column($school_list,'school_id');
            $where['a.school_id'] = array('in',$school_id_arr);
            $major_id_arrs = $this->schoolModel->get_school_list_major_ids($school_list);
            $map['m.major_id'] = ['in',$major_id_arrs];
        }

        $next_member_list_id = Db::name('member_list')->alias('a')
                ->join(config('database.prefix').'school s','a.school_id = s.school_id')
                ->join(config('database.prefix').'major m','a.major_id = m.major_id')
                ->where($where)
                ->where('a.member_list_id','<',$member_list_edit['member_list_id'])
                ->order('a.school_id','asc')
                ->order('a.major_id','asc')
                ->order('a.member_list_id','desc')
                ->value('a.member_list_id');
        $last_member_list_id = Db::name('member_list')->alias('a')
                ->join(config('database.prefix').'school s','a.school_id = s.school_id')
                ->join(config('database.prefix').'major m','a.major_id = m.major_id')
                ->where($where)
                ->where('a.member_list_id','>',$member_list_edit['member_list_id'])
                ->order('a.school_id','asc')
                ->order('a.major_id','asc')
                ->order('a.member_list_id','desc')
                ->value('a.member_list_id');
        $this->assign('next_member_list_id',$next_member_list_id ? $next_member_list_id : 0);
        $this->assign('last_member_list_id',$last_member_list_id ? $last_member_list_id : 0);
        if($this->admin['group_id'] == 3) {
            return $this->fetch('sec_vocat_member_edit');
        }
        if($this->admin['group_id'] == 4) {
            return $this->fetch('university_member_edit');
        }

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
			if($school_id)
			{
				$sl_data['school_id']=$school_id;
			}
			$sl_data['major_id']=$major_id;
			$rst=MemberList::update($sl_data);
			if($rst!==false){
				$this->success('考生修改成功',url('admin/Member/member_list'));
			}else{
				$this->error('考生修改失败');
			}
		}
	}
	public function avatar()
	{
		$imgurl=input('imgurl');
        //去'/'
        $imgurl=str_replace('/','',$imgurl);
        $rst = Db::name('member_list')->where(array('member_list_id'=>input('member_list_id')))->update(array('member_list_headpic'=>$imgurl));
        if($rst!==false){
            $this->success('更新成功',url('admin/Member/member_edit',['member_list_id' => input('member_list_id')]));
        }else{
            $this->error('操作失败',url('admin/Member/member_edit',['member_list_id' => input('member_list_id')]));
        }
	}
	public function member_edit_GexamineeNumber()
	{
		$member_list_id = input('member_list_id');
        if(!$member_list_id){
            return [
				'code' => 0,
				'msg' => '参数错误'
			];
        }
		$member_list = Db::name('member_info')->where(array('member_list_id' => $member_list_id))->find();
        if($member_list)
        {
			$data = [
                'GexamineeNumber' => input('GexamineeNumber'),
            ];
			$rst = Db::name('member_info')->where(array('member_list_id' => $member_list_id))->update($data);
			if($rst!==false){
				return [
					'code' => 1,
					'msg' => '提交成功'
				];
			}else{
				return [
					'code' => 0,
					'msg' => '提交失败'
				];
			}
		}
		return [
			'code' => 0,
			'msg' => '参数错误'
		];
	}
	/*
     * 考生禁止/取消禁止
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
	public function member_unactive()
	{
		$p = input('p');
		$ids = input('n_id/a');
		$query = get_query() ;
		unset($query['n_id']);
		if(empty($ids)){
			$this -> error("请选择用户",url('admin/Member/member_list',$query));
		}
		if(is_array($ids)){//判断获取文章ID的形式是否数组
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}
		$member_model=new MemberList;
		$rst=$member_model->where($where)->setField('user_status',0);
		if($rst!==false){
			$this->success("操作成功",url('admin/Member/member_list',$query));
		}else{
			$this -> error("操作失败！",url('admin/Member/member_list',$query));
		}
	}
	//批量审核
	public function open()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择用户",url('admin/Member/member_list',array('page' => $p)));
		}
		if(is_array($ids)){//判断获取文章ID的形式是否数组
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}
		$member_model=new MemberList;
		$rst=$member_model->where($where)->setField('member_list_open',1);
		if($rst!==false){
			$this->success("操作成功",url('admin/Member/member_list',array('page' => $p)));
		}else{
			$this -> error("操作失败！",url('admin/Member/member_list',array('page' => $p)));
		}
	}
	//批量激活
	public function active()
	{
		$p = input('p');
		$ids = input('n_id/a');
		if(empty($ids)){
			$this -> error("请选择用户",url('admin/Member/member_list',array('page' => $p)));
		}
		if(is_array($ids)){//判断获取文章ID的形式是否数组
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id='.$ids;
		}
		$member_model=new MemberList;
		$rst=$member_model->where($where)->setField('user_status',1);
		if($rst!==false){
			$this->success("操作成功",url('admin/Member/member_list',array('page' => $p)));
		}else{
			$this -> error("操作失败！",url('admin/Member/member_list',array('page' => $p)));
		}
	}
	/*
     * 考生激活/取消激活
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
     * 考生删除
     */
	public function member_del()
	{
		$p=input('p');
		$member_list_id=input('member_list_id');
		$member_model=new MemberList;
		$rst=Db::name('admin')->where('member_id',$member_list_id)->find();
		if($rst){
			$this->error('此考生已关联管理员,请从管理员处删除',url('admin/Member/member_list', array('p' => $p)));
		}else{
			$rst=$member_model->where(array('member_list_id'=>$member_list_id))->delete();
			if($rst!==false){
				$this->success('考生删除成功',url('admin/Member/member_list', array('p' => $p)));
			}else{
				$this->error('考生删除失败',url('admin/Member/member_list', array('p' => $p)));
			}
		}
	}
	public function member_delall()
	{
		$p = input('p');
		$ids = input('n_id/a');
		$member_model=new MemberList;
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/Member/member_list',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id = '.$ids;
		}
		$rst=$member_model->where($where)->delete();
		if($rst!==false){
			$this->success('考生删除成功',url('admin/Member/member_list', array('p' => $p)));
		}else{
			$this->error('考生删除失败',url('admin/Member/member_list', array('p' => $p)));
		}
	}
	public function sec_vocat_member_delall()
	{
		$p = input('p');
		$ids = input('n_id/a');
		$member_model=new MemberList;
		if(empty($ids)){
			$this -> error("请选择列表",url('admin/Member/member_list',array('page' => $p)));
		}
		if(is_array($ids)){
			$where = 'member_list_id in('.implode(',',$ids).')';
		}else{
			$where = 'member_list_id = '.$ids;
		}

		$rst = $member_model->where($where)->where('school_id',$this->admin['school_id'])->delete();
		if($rst!==false){
			$this->success('考生删除成功',url('admin/Member/member_list', array('p' => $p)));
		}else{
			$this->error('考生删除失败',url('admin/Member/member_list', array('p' => $p)));
		}
	}
	/*
     *考生组显示列表
     */
	public function member_group_list()
	{
		$member_group=Db::name('member_group');
		$member_group_list=$member_group->order('member_group_order')->select();
		$this->assign('member_group_list',$member_group_list);
		return $this->fetch();
	}

	/*
     * 考生组添加方法
     */
	public function member_group_runadd()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_group_list'));
		}else{
			$rst=Db::name('member_group')->insert(input('post.'));
			if($rst!==false){
				$this->success('考生组添加成功',url('admin/Member/member_group_list'));
			}else{
				$this->error('考生组添加失败',url('admin/Member/member_group_list'));
			}
		}
	}

	/*
     * 考生组删除
     */
	public function member_group_del()
	{
		$member_group_id=input('member_group_id');
		if (empty($member_group_id)){
			$this->error('考生组ID不存在',url('admin/Member/member_group_list'));
		}
        $rst=Db::name('member_group')->where(array('member_group_id'=>input('member_group_id')))->delete();
        if($rst!==false){
            $this->success('考生组删除成功',url('admin/Member/member_group_list'));
        }else{
            $this->error('考生组删除失败',url('admin/Member/member_group_list'));
        }
	}

	/*
     * 改变考生组状态
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
     * 修改考生组返回值
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
				$this->success('考生组修改成功',url('admin/Member/member_group_list'));
			}else{
				$this->error('考生组修改失败',url('admin/Member/member_group_list'));
			}
		}
	}
	public function member_import()
	{
		if($this->admin['group_id'] == 5 || $this->admin['group_id'] == 1)
		{
			$major_list = Db::name('major')->select();
	        $this->assign('major_list',$major_list);
			$school_list = Db::name('school')->select();
			$this->assign('school_list',$school_list);
			return $this->fetch('admin_member_import');
		}else{
			$major_ids = json_decode($this->admin['major_id'],true);
			$major_list = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
			$this->assign('major_list',$major_list);
			return $this->fetch();
		}

	}
	public function admin_member_import()
	{
		$major_list = Db::name('major')->select();
        $this->assign('major_list',$major_list);
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		return $this->fetch();
	}
	public function member_runimport()
	{
        $major_id = input('major_id');
        if(empty($major_id))
        {
            $this->error("请选择中职专业");
        }
        $school_id = $this->admin['school_id'] ? $this->admin['school_id'] : input('school_id');

		if (! empty ( $_FILES ['file_stu'] ['name'] )){

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
			$res = filter_array($res);
            $enrollment = EnrollmentModel::get_enrollment_major($school_id,$major_id);
            $major_ids = trim($enrollment['major_ids'],',');
            $member_count = MemberList::get_member_count(['school_id' => $school_id,'major_id' => ['in',$major_ids]]);

            if(!$enrollment)
            {
                $this->error ('未找到该中职学校下该中职专业对应的招生计划',url('admin/Member/member_import'));
            }
            $upload_member_count = count($res)-1;
            if($member_count + $upload_member_count > $enrollment['enrollment_number'])
            {
                $this->error ('学生人数超过招生计划数'.$enrollment['enrollment_number'].'人',url('admin/Member/member_import'));
            }

	        foreach ( $res as $k => $v ){
	            if ($k != 1 && trim($v[0])){
	                $data=array();
					$member_list_username = trim($v[0]);
					//通过身份证号查询出性别与生日
					$birth = get_birth($member_list_username);
					$sex = get_sex($member_list_username);
	                $member_list_salt = random(10);
	                $member_list_pwd = substr($member_list_username, -6);
	                $sl_data = [
	                    'member_list_groupid' => 1,
	    				'member_list_username'=>$member_list_username,
	    				'member_list_salt' => $member_list_salt,
	    				'member_list_pwd'=>encrypt_password($member_list_pwd,$member_list_salt),
	    				'member_list_nickname'=>$v[1],
	    				'member_list_open'=>1,
	    				'member_list_addtime'=>time(),
	    				'user_status'=>0,
	    				'score'=>0,
	    				'coin'=>0,
	    				'school_id' => $school_id,
	    				'major_id' => input('major_id'),
                        'year' => input('year',date('Y'))
	                ];
	                $result = MemberList::create($sl_data);

	                if($result)
	                {
	                    $data['member_list_id'] = $result->member_list_id;
	        			$data['certificate'] = json_encode(config('certificate'));
	        			$data['resume'] = json_encode(config('resume'));
	        			$data['prize'] = json_encode(config('prize'));
	        			$data['family'] = json_encode(config('family'));
						$data['date'] = $birth;
						$data['sex'] = $sex;
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
		if($member_list_edit['user_status'] != 1){
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
	public function member_export()
	{
		$map = ['a.school_id' => $this->admin['school_id']] ;
		$member_model=new MemberList;
		$data = $member_model->getMemberList($map,'',0);
		$data = $member_model->handleMemberList2($data);

		$field_titles = ['中职考生号','高考考生号','姓名','身份证号码','中职所在专业','中职学校','对口高职专业','户口所在地','生源地','考生联系人','联系电话','联系地址','邮编'];
        $fields = ['ZexamineeNumber','GexamineeNumber','member_list_nickname','member_list_username','major_name','school_name','recruit_major_name','domicile','documentType','addressee','tell','address','zipCode'];
        $table = '中职考生'.date('YmdHis');
		export_excel($data,$table,$field_titles,$fields);
	}
	public function admin_member_export()
	{
		$member_model=new MemberList;
		$data = $member_model->getMemberList([],'',0);
		$data = $member_model->handleMemberList2($data);

		$field_titles = ['中职考生号','高考考生号','姓名','身份证号码','中职所在专业','中职学校','对口高职专业','理论成绩','技能成绩','总分','户口所在地','生源地','考生联系人','联系电话','联系地址','邮编'];
        $fields = ['ZexamineeNumber','GexamineeNumber','member_list_nickname','member_list_username','major_name','school_name','recruit_major_name','major_score_total','recruit_score','total_score','domicile','documentType','addressee','tell','address','zipCode'];
        $table = '中职考生'.date('YmdHis');
        export_excel($data,$table,$field_titles,$fields);
	}
	public function member_export_pdf()
	{
		set_time_limit(0);
		$map['a.school_id']	= $this->admin['school_id'];
		$map['a.user_status'] = 1 ;
		$major_id = input('major_id');
		if($major_id)
		{
			$map['a.major_id'] = $major_id;
		}
		$member_model=new MemberList;
		$data = $member_model->getMemberList($map,'',0);
		$data = $member_model->handleMemberList2($data);
		require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/TCPDF.php');
		$pdf = new \tcpdf\TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor("Gouweiba");
		$pdf->SetTitle("pdf test");
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(9, 2,0);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(false);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//$pdf->SetFont('stsongstdlight', '', 13);
		$title = "ceshi";
		$i = 0;
		foreach($data as $key=> $val)
		{
			$i = 1;
			$pdf->AddPage();
			$pdf->setPageMark();
			$info = MemberList::handleMember($val);
			$this->assign('info',$info);
			$content = $this->fetch('member_table');
			$pdf->writeHTML($content, true, false, false, false, '');
		}
		if($i == 0)
		{
			$pdf->AddPage();
		}
		$pdf->lastPage();
		$pdf->Output("已审核考生报名表" . '.pdf', 'D');
		exit;
	}
	public function test()
	{
		$member_list_id = 1534;
		$info =  MemberList::getMember($member_list_id);

		$major = Db::name('major')->where(array('major_id' => $info['major_id']))->find();
		$this->assign('major',$major);
		$this->assign('info',$info);
		$school = Db::name('school')->where(array('school_id' => $info['school_id']))->find();
		$this->assign('school',$school);

		$recruit_major = RecruitMajorModel::get_recruit_major($info['school_id'],$info['major_id']);
		$this->assign('recruit_major',$recruit_major);

		$info['major_name'] = $major['major_name'];
		$info['school_name'] = $school['school_name'];
		$info['recruit_major_name'] = $recruit_major['recruit_major_name'];

		require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/TCPDF.php');
		$pdf = new \tcpdf\TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor("Gouweiba");
		$pdf->SetTitle("pdf test");
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(9, 2,0);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(false);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$pdf->AddPage();
		$pdf->setPageMark();
		$this->assign('info',$info);
		$content = $this->fetch('member_table');
		$pdf->writeHTML($content, true, false, false, false, '');
		$pdf->lastPage();
		$pdf->Output("已审核考生报名表" . '.pdf', 'I');
		exit;
	}
}
