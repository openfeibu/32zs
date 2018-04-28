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

/**
 * 文章模型
 * @package app\admin\model
 */
class Score extends Model
{
	public function getMajorScoreList($map,$where,$search_key = '',$is_page = 1)
	{
		$score_list = Db::name('major_score')->alias("ms")
							->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','right')
	                        ->join(config('database.prefix').'member_info mi','m.member_list_id = mi.member_list_id')
	                        ->join(config('database.prefix').'major mj','mj.major_id = m.major_id');
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
	    $score_list =$score_list->order('ms.major_score_status asc')
		                        ->order('m.member_list_id desc')
								->order('major_score_id desc')
								->field('ms.major_score, ms.major_score_id,ms.major_score_status,m.member_list_nickname , m.member_list_username, m.member_list_id,mj.major_name,mj.major_name,m.major_id,m.school_id,mi.ZexamineeNumber');

	   if($is_page)
	   {
		   $score_list = $score_list->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
	   }else{
		   $score_list = $score_list->select();
	   }

		return $score_list;
	}
	public function handleMajorScoreList($score_list,$major_score_key,$status)
	{
		foreach($score_list as $key => $val)
		{
            $major_score_arr = json_decode($val['major_score'],true);
            $major_score_desc = major_score_desc($major_score_key,$major_score_arr);
            $major_score_arr = handle_major_score_arr($major_score_key,$major_score_arr);
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
		}
		return $score_list;
	}
	public function getRecruitMajorScoreList($map,$where,$search_key = '',$is_page = 1)
	{
		$score_list = Db::name('major_score')->alias("ms")
						->join(config('database.prefix').'member_list m','m.member_list_id = ms.member_list_id','right')
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
        $score_list =$score_list->order('ms.major_score_status ASC')
				                ->order('s.school_id desc')
				                ->order('m.member_list_id desc')
								->field('s.school_id,s.school_name,mi.ZexamineeNumber,ms.major_score_id,ms.major_score, ms.major_score_status,ms.recruit_score,ms.recruit_score_status,m.member_list_nickname,m.member_list_username, m.member_list_id,m.major_id,ms.major_score_id,mj.major_name,mj.major_id')
								->order('major_score_id desc');
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
		foreach($score_list as $key => $val)
		{
            $val_recruit_score_status = $val['recruit_score_status'] ? $val['recruit_score_status'] : 0;
            $score_list[$key]['status_desc'] = $status[$val_recruit_score_status];
			if($recruit_major)
			{
				$score_list[$key]['recruit_major_name'] = $recruit_major['recruit_major_name'];
			}
		}
		return $score_list;
	}
}
