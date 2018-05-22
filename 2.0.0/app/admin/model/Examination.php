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

class Examination extends Model
{
    public function static getExamination($recruit_major_id,$school_id)
    {
        return Db::name('examination')->where('recruit_major_id',$recruit_major_id)->where('school_id',$school_id)->find();
    }
}
