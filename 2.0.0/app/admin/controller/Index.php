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
use think\Cache;
use think\helper\Time;
use app\admin\model\School as SchoolModel;
use app\admin\model\News as NewsModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\MemberList;

class Index extends Base
{
    /**
     * 后台首页
     */
	public function index()
	{
		$news_model=new NewsModel;
		$member_model=new MemberList;
		$school_model = new SchoolModel;
		//日期时间戳
		list($start_t, $end_t) = Time::today();
		list($start_y, $end_y) = Time::yesterday();
		$ydate = date('Y');
		$statistics = array();
		//中职专业负责人
        if($this->admin['group_id'] == 3)
        {
            $statistics = [];
            $major_ids = array_filter(json_decode($this->admin['major_id'],true));
            $major_list = MajorModel::get_secondary_vocat_major_list($major_ids,$this->admin['school_id']);

            foreach($major_list as $key => $major)
            {
                $statistics[$key] = $major;
				//$statistics[$key]['enrolling_student_count'] = 	Db::name('enrollment')->where(['major_id' => $major['major_id'],'school_id' => $this->admin['school_id']])->value('enrollment_number');
                $statistics[$key]['student_count'] = Db::name('member_list')->where(['major_id' => $major['major_id'],'school_id' => $this->admin['school_id']])->count();
                $statistics[$key]['enrolment_auditing_count'] = Db::name('member_list')->where(['major_id' => $major['major_id'],'school_id' => $this->admin['school_id'],'user_status' => '1' ])->count();
                $statistics[$key]['enrolment_unauditing_count'] = $statistics[$key]['student_count']  - $statistics[$key]['enrolment_auditing_count'];
                $statistics[$key]['score_auditing_count'] = Db::name('member_list')->alias('m')->join(config('database.prefix').'major_score ms','m.member_list_id = ms.member_list_id','left')->where('ms.major_score_status',1)->where(['m.major_id' => $major['major_id'],'m.school_id' => $this->admin['school_id']])->count();
                $statistics[$key]['score_unauditing_count'] = $statistics[$key]['student_count']  - $statistics[$key]['score_auditing_count'];
            }
        }
		//高职专业负责人
		if($this->admin['group_id'] == 4)
        {
			$recruit_major = Db::name('recruit_major')->where(['recruit_major_id' => $this->admin['recruit_major_id']])->find();
			$statistics['recruit_major'] = $recruit_major;
			$school_list = $school_model->get_school_list_rmi($this->admin['recruit_major_id']);
			$major_ids_arr = array_column($school_list, 'major_ids');
			$major_id_arrs = array();
			foreach ($major_ids_arr as $key => $major_ids) {
				$major_id_arr = array_filter(explode(',',$major_ids));
				$major_id_arrs = array_merge($major_id_arrs,$major_id_arr);
			}
			$map['m.major_id'] = ['in',$major_id_arrs];
			$statistics['student_count'] =  Db::name('member_list')->alias('m')->where($map)->count();
			$statistics['score_auditing_count'] = Db::name('member_list')->alias('m')->join(config('database.prefix').'major_score ms','m.member_list_id = ms.member_list_id','left')->where('ms.recruit_score_status',1)->where($map)->count();
			$statistics['score_unauditing_count'] = $statistics['student_count'] - $statistics['score_auditing_count'];
		}
		//高职招生负责人 系统运维工程师
		if($this->admin['group_id'] == 5 || $this->admin['group_id'] == 1)
        {
			$school_count = Db::name('school')->count();
			$recruit_major_count = Db::name('recruit_major')->count();
			$major_count = Db::name('major')->count();
			$min_score = Db::name('min_score')->value('min_score');
			$enroll_count = Db::name('enrollment')->sum('enrollment_number');
			$student_count = Db::name('member_list')->count();
			$enroll_student_count =  Db::name('statistics')->where('ydate',$ydate)->value('enroll_student_count');
			$statistics = [
				'school_count' => $school_count,
				'recruit_major_count' => $recruit_major_count,
				'major_count' => $major_count,
				'min_score' => $min_score,
				'enroll_count' => $enroll_count,
				'enroll_student_count' => $enroll_student_count,
				'student_count' => $student_count
			];
		}
		$this->assign('statistics',$statistics);
		//渲染模板
        return $this->fetch();
	}
    /**
     * 后台多语言切换
     */
	public function lang()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$lang=input('lang_s');
			session('login_http_referer',$_SERVER["HTTP_REFERER"]);
			switch ($lang) {
				case 'cn':
					cookie('think_var', 'zh-cn');
				break;
				case 'en':
					cookie('think_var', 'en-us');
				break;
				//其它语言
				default:
					cookie('think_var', 'zh-cn');
			}
			Cache::clear();
			$this->success('切换成功',session('login_http_referer'));
		}
	}
	public function test()
	{
		//Db::name('school')->where('school_','1')->find();
		$this->error('ceshi');
	}
}
