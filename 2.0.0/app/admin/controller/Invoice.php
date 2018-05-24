<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\model\SchoolModel;
use app\admin\model\Invoice as InvoiceModel;
use think\Db;
use think\Cache;
use think\Validate;

class Invoice extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->invoiceModel = new InvoiceModel;
    }
    public function index()
    {
        $invoice_list = $this->invoiceModel->order('invoice_id','asc')->select();
        $this->assign('invoice_list',$invoice_list);
        return $this->fetch();
    }
    public function check_invoice_list_export()
    {
        $invoice_count = $this->invoiceModel->count();
        if(!$invoice_count)
        {
            $this->error("暂无数据，无法导出。");
        }
        $this->success('导出');
    }
    public function invoice_list_export()
    {
        $invoice_list = $this->invoiceModel->order('invoice_id','asc')->select();

        $field_titles = [lang('invoice')['name'], lang('invoice')['duty_paragraph'], lang('invoice')['address'], lang('invoice')['tel'], lang('invoice')['bank'], lang('invoice')['blank_count'], lang('invoice')['other']];

        $fields = ['name','duty_paragraph','address','tel','bank','blank_count','other'];

        $table = '中职学校发票'.date('Ymd');
        export_excel($invoice_list,$table,$field_titles,$fields);
    }
    public function show()
    {
        $invoice = $this->invoiceModel->where('school_id',$this->admin['school_id'])->find();
        $this->assign('invoice',$invoice);
        return $this->fetch();
    }
    public function create()
    {
        $data = [
            'name' => input('name',''),
            'duty_paragraph' => input('duty_paragraph',''),
            'address' => input('address',''),
            'tel' => input('tel',''),
            'bank' => input('bank',''),
            'blank_count' => input('blank_count',''),
            'other' => input('other',''),
        ];
        $rules = [
            'name' => 'require',
            'duty_paragraph' => [
                'require',
                'regex'=>'/^[A-Z0-9]{15}$|^[A-Z0-9]{17}$|^[A-Z0-9]{18}$|^[A-Z0-9]{20}$/i'
            ],
             //'address' => 'require',
            // 'tel' => 'require',
            // 'bank' => 'require',
            // 'blank_count' => 'require',
            'tel' => "regex:0\d{2,3}-?\d{7,8}",
            'blank_count' => "regex:\d{13,}",
        ];
        $msg = [
            'name.require' => lang('invoice')['name'].'不能为空',
            'duty_paragraph.require' => lang('invoice')['duty_paragraph'].'不能为空',
            'duty_paragraph.regex' => lang('invoice')['duty_paragraph'].'格式不正确',
            'address.require' => lang('invoice')['address'].'不能为空',
            'tel.require' => lang('invoice')['tel'].'不能为空',
            'tel.regex' => lang('invoice')['tel'].'格式不正确',
            'bank.require' => lang('invoice')['bank'].'不能为空',
            'blank_count.require' => lang('invoice')['blank_count'].'不能为空',
            'blank_count.regex' => lang('invoice')['blank_count'].'格式不正确',
        ];
        $validate = new Validate($rules,$msg);
        $result = $validate->check($data);
        if(true !==$result){
            $return_data['code']=0;
            $return_data['msg']=$validate->getError();
            $this->error($return_data['msg']);
        }
        $invoice = $this->invoiceModel->where('school_id',$this->admin['school_id'])->find();
        if($invoice)
        {
            $rst = $this->invoiceModel->where('invoice_id',$invoice['invoice_id'])->update($data);
        }else{
            $data['school_id'] = $this->admin['school_id'];
            $rst = $this->invoiceModel->create($data);
        }
        $this->success('保存成功');
    }
}
