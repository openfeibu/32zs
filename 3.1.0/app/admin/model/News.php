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

/**
 * 文章模型
 * @package app\admin\model
 */
class News extends Model
{
	protected $insert = ['news_hits' => 200];
	public function user()
	{
		return $this->belongsTo('admin','admin_id');
	}
	public function menu()
	{
		return $this->belongsTo('Menu','id');
	}
}
