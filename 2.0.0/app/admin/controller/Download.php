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

class Download
{
    public function member_excel()
    {
        $file_name = '中职学生导入示例表格.xls';
        $file_sub_path = ROOT_PATH.'/public/excel/sample/';
        $file_path = $file_sub_path.$file_name;
        if (!file_exists($file_path)) {  //判断文件是否存在
            $this->error('文件不存在');
        }
        $fp = fopen($file_path, "r+") or die('打开文件错误');   //下载文件必须要将文件先打开。写入内存
        $file_size = filesize($file_path);
        Header("Content-type:application/octet-stream");
        //按照字节格式返回
        Header("Accept-Ranges:bytes");
        //返回文件大小
        Header("Accept-Length:".$file_size);
        //弹出客户端对话框，对应的文件名
        Header("Content-Disposition:attachment;filename=".$file_name);
        //防止服务器瞬间压力增大，分段读取
        $buffer = 1024;
        while (!feof($fp)) {
            $file_data = fread($fp, $buffer);
            echo $file_data;
        }
        fclose($fp);
    }
}
