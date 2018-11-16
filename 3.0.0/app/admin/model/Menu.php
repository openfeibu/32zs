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
 * 前台菜单模型
 * @package app\admin\model
 */
class Menu extends Model
{
	public function news()
	{
		return $this->hasMany('News','news_columnid')->bind('menu_name');
	}
}
