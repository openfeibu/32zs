<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Cache;
use think\Loader;
use think\DB;
use app\admin\model\Admin as AdminModel;
use app\admin\model\MemberList;

class Import extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function enrollment_runimport()
    {
        if (! empty ( $_FILES ['file_stu'] ['name'] )){
            $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
			$file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
			$file_type = $file_types [count ( $file_types ) - 1];
			/*判别是不是.xls文件，判别是不是excel文件*/
			if ($file_type != "xls" && $file_type != "xlsx"){
				$this->error ( '不是Excel文件，重新上传',url('admin/Import/index'));
			}
			/*设置上传路径*/
			$savePath = ROOT_PATH. 'public/excel/';
			/*以时间来命名上传的文件*/
			$str = time ();
			$file_name = $str . "." . $file_type;
			if (! copy ( $tmp_file, $savePath . $file_name )){
				$this->error ('上传失败',url('admin/Import/index'));
			}
			$res = readWithSuffix ( $savePath . $file_name ,$file_type);
			if (!$res){
				$this->error ('数据处理失败',url('admin/Import/index'));
			}
            $schools = $major = $recruit_major = $enrollment = array();
            $errors = array();
            $major_id = $school_id = 0;
            $recruit_major_id = DB::name('recruit_major')->order('recruit_major_id','desc')->value('recruit_major_id');
            $recruit_major_id = $recruit_major_id ?? 0;
            $major_id = DB::name('major')->order('major_id','desc')->value('major_id');
            $major_id = $major_id ?? 0;
            $school_id = DB::name('school')->order('school_id','desc')->value('school_id');
            $school_id = $school_id ?? 0;

            $recruit_major_codes = $major_codes = $school_names = array();

            foreach($res as $k => $v)
            {
                if ($k != 1 && trim($v[0])){
                    $school_name = trim($v[3]);
                    if(in_array($school_name,$school_names))
                    {
                        $schools[$k]['school_id'] = get_val_from_arr2($schools,$school_name,'school_id','school_name');
                    }else{
                        $school_id++;
                        $schools[$k]['school_id'] = $school_id;
                    }
                    $schools[$k]['school_name'] = $school_names[] = $school_name = trim($v[2]);

                    $recruit_major_name = trim($v[1]);
                    $recruit_major_code = trim($v[2]);

                    $recruit_major[$k] = [
                        'recruit_major_name' => $recruit_major_name,
                        'recruit_major_code' => $recruit_major_code,
                    ];
                    if(in_array($recruit_major_code,$recruit_major_codes))
                    {
                        $recruit_major[$k]['recruit_major_id'] = get_val_from_arr2($recruit_major,$recruit_major_code,'recruit_major_id','recruit_major_code');
                    }else{
                        $recruit_major_id++;
                        $recruit_major[$k]['recruit_major_id'] = $recruit_major_id;
                    }
                    $recruit_major_codes[] = $recruit_major_code;

                    $major_name = trim($v[4]);
                    $major_code = trim($v[5]);

                    $major[$k] = [
                        'major_name' => $major_name,
                        'major_code' => $major_code,
                    ];
                    if(in_array($major_code,$major_codes))
                    {
                        $major[$k]['major_id'] = get_val_from_arr2($major,$major_code,'major_id','major_code');
                    }else{
                        $major_id++;
                        $major[$k]['major_id'] = $major_id;
                    }
                    $major_codes[] = $major_code;
                }
            }
            foreach($res as $k => $v)
            {
                if ($k != 1 && trim($v[0])){
                    $enrollment[$k] = [
                        'school_id' => $schools[$k]['school_id'],
                        'major_ids' => $major[$k]['major_id'],
                        'recruit_major_id' => $recruit_major[$k]['recruit_major_id'],
                        'enrollment_number' => intval(trim($v[6]))
                    ];
                }
            }
            var_dump($enrollment);exit;
            $recruit_major = assoc_unique($recruit_major,'recruit_major_code');
            $major = assoc_unique($major,'major_code');
            $schools = assoc_unique($schools,'school_name');
            DB::name('school')->insertAll($schools);
            DB::name('recruit_major')->insertAll($recruit_major);
            DB::name('major')->insertAll($major);
            DB::name('enrollment')->insertAll($enrollment);
            $i = 0;
            foreach($enrollment as $ek => $ev)
            {
                $i++;
                $admin_username = str_pad($i,3,"0",STR_PAD_LEFT);
                $admin_username =
                AdminModel::add($admin_username,'','123456','','',input('admin_open',1),'',3,$ev['school_id'],json_encode(array('0' => $ev['major_ids'])));
            }
            echo 'success';exit;
        //    var_dump($recruit_major);exit;
            echo '-----------------------------------错误-----------------------------------';
            var_dump($errors);
            echo '--------------------------------高职专业--------------------------------------';
            var_dump($recruit_major);
            echo '--------------------------------中职专业--------------------------------------';
            var_dump($major);
            echo '------------------------------中职学校----------------------------------------';
            var_dump($schools);
            echo '------------------------------招生计划----------------------------------------';
            var_dump($enrollment);exit;
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
                       $data['date'] = $birth;
                       $data['sex'] = $sex;
                       $info = Db::name('member_info')->insert($data);
                   }
                   if (!$result){
                       $this->error ('导入数据失败',url('admin/Member/member_import'));
                   }
               }
           }
        }
    }

    public function import_data()
    {

    }
	 public function member_data()
    {
		return $this->fetch();
    }
	 public function get_member_data()
    {
		if (! empty ( $_FILES ['file_stu'] ['name'] )){
            $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
            $file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
            $file_type = $file_types [count ( $file_types ) - 1];
            /*判别是不是.xls文件，判别是不是excel文件*/
            // if (strtolower( $file_type ) != "xls" || strtolower( $file_type )!= "xlsx" ){
                // $this->error ( '不是Excel文件，重新上传',url('admin/Import/member_data'));
            // }
            /*设置上传路径*/
            $savePath =ROOT_PATH. 'public/excel/';
            /*以时间来命名上传的文件*/
            $str = time ();
            $file_name = $str . "." . $file_type;
            if (! copy ( $tmp_file, $savePath . $file_name )){
                $this->error ('上传失败',url('admin/Import/member_data'));
            }
            $res = read ( $savePath . $file_name );
            if (!$res){
                $this->error ('数据处理失败',url('admin/Import/member_data'));
            }
            $schools = $major = $recruit_major = $enrollment = array();
            $errors = array();
            $recruit_major_id = $major_id = $school_id = 0;

            $recruit_major_codes = $major_codes = $school_names = array();
			//var_dump($res);exit;
			$exist_member_count = 0;
			$error = '';
			$exist_addressee_member = [];
            foreach($res as $k => $v)
            {
				if ($k != 1 && trim($v[0])){
					
					$member_list_username = trim($v[2]);
					//通过身份证号查询出性别与生日
					$birth = get_birth($member_list_username);
					$sex = get_sex($member_list_username);
	                $member_list_salt = random(10);
	                $member_list_pwd = substr($member_list_username, -6);
					$excel_member_list_id = trim($v[5]);
					$member_list_id = Db::name('member_list')->where('member_list_username',$member_list_username)->value('member_list_id');
					if($member_list_id)
					{
						continue;
					}
					$school_id = Db::name('school')->where('school_name',trim($v['4']))->value('school_id');
					if(!$school_id)
					{
						$error .= trim($v['4'])."不存在<br>";
					}
					$major_id = Db::name('major')->where('major_name',trim($v['3']))->value('major_id');
					if(!$major_id)
					{
						$error .= trim($v['3'])."不存在<br>";
					}
					$member_list_nickname = trim($v[1]);
					$ZexamineeNumber = trim($v[0]);
					if($excel_member_list_id)
					{
						$member_info_list_id = $excel_member_list_id;
					}else{
						$member_info_list_id =  Db::name('member_info')->where('ZexamineeNumber',$ZexamineeNumber)->value('member_list_id');
						
					}
					
					if(!$member_info_list_id)
					{
						$member_info_list_id =  Db::name('member_info')->where('addressee',$member_list_nickname)->value('member_list_id');
					}
					
					if($member_info_list_id)
					{
						$exist_member_count++;
						$major_score = Db::name('major_score')->where('member_list_id',$member_info_list_id)->find();
						$sl_data[$k] = [
							'member_list_id' => $member_info_list_id,
							'member_list_groupid' => 1,
							'member_list_username' => $member_list_username,
							'member_list_salt' => $member_list_salt,
							'member_list_pwd'=>encrypt_password($member_list_pwd,$member_list_salt),
							'member_list_nickname'=>$member_list_nickname,
							'member_list_open'=>1,
							'member_list_addtime'=>time(),
							'user_status'=> $major_score ? 1 : 0,
							'score'=>0,
							'coin'=>0,
							'school_id' => $school_id,
							'major_id' => $major_id,
							//'major_score' => isset($major_score['major_score_status']) && $major_score['major_score_status'] ? $major_score['major_score'] : NULL,
							//'recruit_score' => isset($major_score['recruit_score_status']) && $major_score['recruit_score_status'] ? $major_score['recruit_score'] : NULL,
						];
						try{
							
							$result = MemberList::create($sl_data[$k]);
						}catch(Exception $e){
							var_dump($v);
						}
					}else{
						
						$sl_data[$k] = [
							'member_list_groupid' => 1,
							'member_list_username' => $member_list_username,
							'member_list_salt' => $member_list_salt,
							'member_list_pwd'=>encrypt_password($member_list_pwd,$member_list_salt),
							'member_list_nickname'=>$v[1],
							'member_list_open'=>1,
							'member_list_addtime'=>time(),
							'user_status'=>0,
							'score'=>0,
							'coin'=>0,
							'school_id' => $school_id,
							'major_id' => $major_id
						];
						/*
						$first_name = mb_substr($member_list_nickname,0,1);
						
						$addressee_member =  Db::name('member_info')->where('addressee',$member_list_nickname)->field('ZexamineeNumber,addressee')->order('id desc')->find();
						
						$info = [];
						if(!$addressee_member)
						{
							//$info =  Db::name('member_info')->where('addressee','like','%'.$first_name.'%')->field('ZexamineeNumber,addressee')->select();
							$not_exist_member[$k] = [
								'身份证' => $v[2],
								'姓名' => $v[1],
								'学校' => $v[4],
								'考生号' => $v[0],
							];
							
						}else{
							$info =  Db::name('member_info')->where('addressee',$member_list_nickname)->field('ZexamineeNumber,addressee')->select();
							$exist_addressee_member[$k] = [
								'身份证' => $v[2],
								'姓名' => $v[1],
								'学校' => $v[4],
								'考生号' => $v[0],
								'ZexamineeNumber' => $addressee_member['ZexamineeNumber'],
								'addressee' => $addressee_member['addressee'],
								'info' => $info,
								'count' => count($info)
							];
							
						}
						*/
						
						$not_exist_member[$k] = [
							'身份证' => $v[2],
							'姓名' => $v[1],
							'学校' => $v[4],
							'考生号' => $v[0],
						];
						
						
						$result = MemberList::create($sl_data[$k]);
						
						if($result)
						{
							$data['member_list_id'] = $result->member_list_id;
							$data['certificate'] = json_encode(config('certificate'));
							$data['resume'] = json_encode(config('resume'));
							$data['prize'] = json_encode(config('prize'));
							$data['family'] = json_encode(config('family'));
							$data['ZexamineeNumber'] = $ZexamineeNumber;
							$data['date'] = $birth;
							$data['sex'] = $sex;
							$info = Db::name('member_info')->insert($data);
						}
						
						
					}
 					
					
	                
				}
			}
			
			if($error)
			{
				
				echo $error;exit;
			}
			//echo count($exist_addressee_member);
			//print_r($exist_addressee_member);exit;
			// echo count($not_exist_member);
			// echo "<prep>";
			// print_r($not_exist_member);
			// echo "</prep>";
			// exit;
			//print_r($sl_data);exit;
		}
		echo  "success";exit;
    }
	public function avatar()
	{
		$member_list = MemberList::order('member_list_id asc')->field('member_list_id')->select();
		foreach($member_list as $member)
		{
			$avatar_log = Db::name('web_log')->where([
				'controller' => 'Center',
				'action' => 'avatar',
				'uid' => $member['member_list_id']
			])->field('data')->order('id asc')->find();
			$data = [];
			if($avatar_log)
			{
				$data = unserialize($avatar_log['data']);
				MemberList::where("member_list_id",$member['member_list_id'])->update([
					'member_list_headpic' => $data['imgurl']
				]);
			}
			
			
		}
		
	}
}
