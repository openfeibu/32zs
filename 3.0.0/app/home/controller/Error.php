<?php
// +----------------------------------------------------------------------
// | 三二分段 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\home\controller;

class Error extends Base
{
    //空控制器
    public function index()
    {
        $this->error(lang('operation not valid'));
    }
}