<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;
use think\Db;
use app\admin\model\Subject as SubjectModel;

/**
 * 文章模型
 * @package app\admin\model
 */
class Score extends Model
{
	public function majorScoreAdd($member_list_id,$subject_id,$major_score)
	{
		$rstdata['error'] = 0;
		$rstdata['content'] = '';
		$major_score_data = Db::name('major_score')->where(array('member_list_id' => $member_list_id,'subject_id' => $subject_id))->find();
        if($major_score_data)
        {
            if($major_score_data['major_score_status'] == 1)
            {
				$rstdata['error'] = 1;
				$rstdata['content'] = '提交失败。已打印通过不能修改';
                return $rstdata;
            }
            $data = [
                'major_score' => $major_score,
                'major_score_status' => 0,
            ];
            $rst = Db::name('major_score')->where(array('major_score_id' => $major_score_data['major_score_id']))->update($data);
			if($rst!==false){
				$rstdata['content'] = '提交成功。';
				return $rstdata;
			}else{
				$rstdata['error'] = 1;
				$rstdata['content'] = '提交失败。';
                return $rstdata;
			}
        }
        $data = [
            'member_list_id' => $member_list_id,
            'subject_id' => $subject_id,
            'major_score' => $major_score
        ];
        $rst = Db::name('major_score')->insert($data);
		if($rst !== false){
			$rstdata['content'] = '提交成功。';
			return $rstdata;
		}else{
			$rstdata['error'] = 1;
			$rstdata['content'] = '提交失败。';
			return $rstdata;
		}
	}
	public function recruitScoreAdd($member_list_id,$recruit_major_score)
	{
        if(!$member_list_id){
            return [
				'code' => 0,
				'msg' => '参数错误'
			];
        }
        $recruit_major_score_data = Db::name('recruit_major_score')->where(array('member_list_id' => $member_list_id))->find();
        if($recruit_major_score_data)
        {
            if($recruit_major_score_data['recruit_major_score_status'] == 1)
            {
                return [
					'code' => 0,
					'msg' => '提交失败，已打印通过请勿重复提交'
				];
            }
			if($recruit_major_score_data['recruit_major_score'] == $recruit_major_score){
				return [
					'code' => 2,
					'msg' => ''
				];
			}
            $data = [
                'recruit_major_score' => $recruit_major_score,
                'recruit_major_score_status' => 0,
            ];
            $rst = Db::name('major_score')->where(array('member_list_id' => $member_list_id))->update($data);
			if($rst!==false){
				return [
					'code' => 1,
					'msg' => '提交成功，请等待考生打印'
				];
			}else{
				return [
					'code' => 0,
					'msg' => '提交失败'
				];
			}
        }
        else{
            $data = [
                'member_list_id' => $member_list_id,
                'recruit_major_score' => $recruit_major_score,
                'recruit_major_score_status' => 0,
            ];
            $rst = Db::name('recruit_major_score')->insert($data);
            if($rst!==false){
                return [
					'code' => 1,
					'msg' => '提交成功，请等待考生打印'
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
	public function getMajorScoreList($map,$where,$search_key='',$subject_list=array(),$is_page = 1)
	{
	    $member_list = Db::name('major_score')->alias("ms")
            ->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','right')
            ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id');
        if($map){
            $member_list = $member_list->where($map);
        }
        if($where){
            $member_list = $member_list->where($where);
        }
        if($search_key)
        {
            $member_list = $member_list->where('member_list_username|member_list_nickname|ZexamineeNumber','like',"%".$search_key."%");
        }
        $member_list = $member_list->where(get_year_where());
        $member_list_id_arr = $member_list->order('ms.major_score_status asc')->group('m.member_list_id')->column('m.member_list_id');
        $member_list_ids = implode(',',$member_list_id_arr);

        $score_list = Db::name('member_list')->alias("m")
            ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
            ->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
            ->where('m.member_list_id','in',$member_list_ids)
            ->order('m.major_id asc')
            ->order("locate('m.member_list_id','".$member_list_ids."')")
            ->order('m.member_list_id desc')
            ->field('m.member_list_nickname , m.member_list_username, m.member_list_id,m.year,mj.major_name,mj.major_name,m.major_id,m.school_id,mi.ZexamineeNumber');
        if($is_page)
        {
            $score_list = $score_list->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
        }else{
            $score_list = $score_list->select();
        }
        if($is_page)
        {
            $page = $score_list->render();
            $score_list = $score_list->all();
            $data['page'] = $page;
        }

        foreach($score_list as $key => $member)
        {
            $major_score_arr = $major_subject_score_arr = array();
            $major_score_status = 1;
            if(empty($subject_list))
            {
                $subject_list = SubjectModel::get_subject_list($member['major_id'],$member['school_id']);
            }
            if(empty($subject_list))
            {
                $major_score_status = 0;
            }
            $subject_id_arr = array_column($subject_list,'subject_id');
            $subject_score_list = DB::name('major_score')->where('member_list_id',$member['member_list_id'])->where(array('subject_id' => array('in',$subject_id_arr)))->field('major_score,major_score_status,subject_id')->order('subject_id','asc')->select();
            $score_subject_id_arr = array_column($subject_score_list,'subject_id');
            $subject_score_list = array_column($subject_score_list,NULL,'subject_id');
            if(count($score_subject_id_arr) < count($subject_score_list))
            {
                $major_score_status = 0;
            }
            foreach ($subject_list as $subject_key => $subject)
            {
                if(in_array($subject['subject_id'],$score_subject_id_arr))
                {
                    $major_score = $subject_score_list[$subject['subject_id']]['major_score'];
                    $major_score_status = $subject_score_list[$subject['subject_id']]['major_score_status'];
                }else{
                    $major_score = '';
                    $major_score_status = '';
                }
                $major_subject_score_arr[] = [
                    'subject_id' => $subject['subject_id'],
                    'subject_name' => $subject['subject_name'],
                    'score' => $major_score,
                    'major_score_status' => $major_score_status,
                ];
                $major_score_arr[] = $major_score;
            }
            /*
            foreach ($subject_list as $subject_key => $subject)
            {
                $score = DB::name('major_score')->where('member_list_id',$member['member_list_id'])->where('subject_id',$subject['subject_id'])->field('major_score,major_score_status')->find();
                $major_score_arr[] = $score ? $score['major_score'] : '';
                if(!$score || (!empty($score) && !$score['major_score_status']))
                {
                    $major_score_status = 0;
                }
                $major_subject_score_arr[] = [
                    'subject_id' => $subject['subject_id'],
                    'subject_name' => $subject['subject_name'],
                    'score' => $score ? $score['major_score'] : '',
                    'major_score_status' => $score ? $score['major_score_status'] : 0,
                ];
            }
            */
            $score_list[$key]['major_score_arr'] = $major_score_arr;
            $score_list[$key]['major_subject_score_arr'] = $major_subject_score_arr;
            $score_list[$key]['major_score_status'] = $major_score_status;
        }
        $data['score_list'] = $score_list;
        return $data;
	}
	public function handleMajorScoreList($score_list,$major_subject_name_arr,$status)
	{
		$no = 1;
		foreach($score_list as $key => $val)
		{
            $major_score_arr = $val['major_score_arr'];
            $major_score_desc = major_score_desc($major_subject_name_arr,$major_score_arr);
            $major_score_arr = handle_major_score_arr($major_subject_name_arr,$major_score_arr);
            $score_list[$key]['major_score_arr'] = $major_score_arr;
            $score_list[$key]['major_score_desc'] = $major_score_desc;
            $major_score_status = $val['major_score_status'] ? $val['major_score_status'] : 0 ;
            $score_list[$key]['major_score_status'] = $major_score_status ;
            $score_list[$key]['status_desc'] = $status[$major_score_status] ;
            $major_score_total = handle_major_score($major_score_arr);
            $score_list[$key]['major_score_total'] = $major_score_total;
            $j = 0;
            foreach ($major_score_arr as $major_score_k => $major_score_v) {
                $score_list[$key]['major_'.$j] = $major_score_v;
                $j++;
            }
			$score_list[$key]['no'] = $no;
			$no++;
		}
		return $score_list;
	}
	public function getRecruitMajorScoreList($map,$where,$search_key = '',$is_page = 1)
	{
        $score_list =  Db::name('recruit_major_score')->alias("rms")
            ->join(config('database.prefix').'member_list m','m.member_list_id = rms.member_list_id','right')
            ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
            ->join(config('database.prefix').'major mj','mj.major_id = m.major_id')
            ->join(config('database.prefix').'school s','s.school_id = m.school_id');
		if($map){
			$score_list = $score_list->where($map);
		}
		if($where){
			$score_list = $score_list->where($where);
		}
		if($search_key)
		{
			$score_list = $score_list->where('member_list_username|member_list_nickname|ZexamineeNumber','like',"%".$search_key."%");
		}
        $score_list = $score_list->where(get_year_where('m'));
        $score_list =$score_list->order('s.school_id desc')
                                ->order('m.major_id asc')
				                ->order('m.member_list_id desc')
								->field('s.school_id,s.school_name,mi.ZexamineeNumber,rms.recruit_major_score_id,rms.recruit_major_score_status,rms.recruit_major_score,m.member_list_nickname,m.member_list_username, m.member_list_id,m.major_id,mj.major_name,mj.major_id');
		if($is_page)
		{
		   $score_list = $score_list->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		}else{
		   $score_list = $score_list->select();
		}

		return $score_list;
	}
	public function handleRecruitMajorScoreList($score_list,$status,$recruit_major)
	{
		$no = 1;
		foreach($score_list as $key => $val)
		{
            $val_recruit_major_score_status = $val['recruit_major_score_status'] ? $val['recruit_major_score_status'] : 0;
            $score_list[$key]['status_desc'] = $status[$val_recruit_major_score_status];
			if($recruit_major)
			{
				$score_list[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
			}
			$score_list[$key]['no'] = $no;
			$no++;
		}
		return $score_list;
	}
	public function get_member_major_score($member_list_id,$subject_list)
    {
        foreach ($subject_list as $subject_key => $subject)
        {
            $score = DB::name('major_score')->where('subject_id',$subject['subject_id'])->where('member_list_id',$member_list_id)->field('major_score,major_score_status')->find();
            $major_subject_score_arr[] = [
                'subject_id' => $subject['subject_id'],
                'subject_name' => $subject['subject_name'],
                'score' => $score ? $score['major_score'] : '',
                'major_score_status' => $score ? $score['major_score_status'] : 0,
            ];
        }
        return $major_subject_score_arr;
    }
}
