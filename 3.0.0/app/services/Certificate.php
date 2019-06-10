<?php
// +----------------------------------------------------------------------
// | 三二分段
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.feibu.info All rights reserved.
// +----------------------------------------------------------------------
// | Author: feibu 319096000@qq.com
// +----------------------------------------------------------------------

namespace app\services;

use think\Model;
use think\Db;
use QL\QueryList;
use app\admin\model\MemberList as  MemberListModel;
use app\services\HttpCurl;
//use Mohuishou\ImageOCR\Image;
use Mohuishou\ImageOCR\StorageFile;
use app\services\ImageOCR\Image;
use app\services\CaptchaOCR;

class Certificate extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->member_model = new MemberListModel();

    }
    public function test_verify_img()
    {
        $http_curl = new HttpCurl();
        $image_name = 'verify_img'.time().'.jpg';
        $folder = 'verify_images';
        $img_url = "http://search.neea.edu.cn/Imgs.do?act=verify&t=0.8841180045674784";
        $header[] = "Referer: http://search.neea.edu.cn/QueryMarkUpAction.do?act=doQueryCond&sid=300&pram=certi";
        $header[] = "Accept: image/webp,image/apng,image/*,*/*;q=0.8";
        $header[] = "Accept-Encoding: gzip, deflate";
        $header[] = "Accept-Language: zh-CN,zh;q=0.9,en;q=0.8";
        $header[] = "Connection: keep-alive";
        $header[] = "Host: search.neea.edu.cn";
        $header[] = "Referer: http://search.neea.edu.cn/QueryMarkUpAction.do?act=doQueryCond&sid=300&pram=certi";
        $header[] = "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36";
        $save_image = save_image($img_url,$folder,$image_name,$header);
        $image_path = $save_image['save_path'];
        $captcha_ocr = new CaptchaOCR($image_path);
        $captcha_ocr->image_hash('neea');
        $a = $captcha_ocr->find('neea');
        $code = implode("",$a);

        $img = "<img src='/data/upload/verify_images/".$image_name."'>";
        echo $img;

        var_dump($code);exit;
    }
    public function test()
    {
        /*
         * 测试 PSE_to_201701
         *
         */
        //$img = "<img src='http://query.5184.com/query/image.jsp?time=".math_random()."'>";
       // echo $img;
        $n = 1;
        $success_num = 0;
        $fail_num = 0;
        while($n<=100)
        {
            $this->http_curl = new HttpCurl();
        $image_name = 'verify_img'.time().'.jpg';
        $folder = 'verify_images';
        $img_url = "http://query.5184.com/query/image.jsp?time=".math_random();
        $save_image = save_image($img_url,$folder,$image_name);
        $image_path = $save_image['save_path'];
       // var_dump($image_path);exit;

       // $image_path = '/home/vagrant/Code/32zs/3.0.0/data/upload/verify_images/verify_img1544692012.jpg';

        /*
                $image=new Image($image_path);

                $code = '7575';
                $code_arr = str_split($code);
                $db = new StorageFile();

                for($i=0;$i<$image::CHAR_NUM;$i++){
                    $hash_img_data=implode("",$image->splitImage($i));
                    $db->add($code_arr[$i],$hash_img_data);
                }
         */

        /*
        echo "<img src='/data/upload/verify_images/".$image_name."'>";
                $image = new Image($image_path);
                $a=$image->find();
                $code=implode("",$a);
                echo "验证码：$code \n";
        */

        /*
        $image = new Image($image_path);
        $code = input('code');

        $code_arr = str_split($code);
        $db = new StorageFile();
        for($i=0;$i< $image::CHAR_NUM;$i++){
            $hash_img_data=implode("",$image->splitImage($i));
            $db->add($code_arr[$i],$hash_img_data);
        }
        exit;
        */
        $captcha_ocr = new CaptchaOCR($image_path);
        $captcha_ocr->image_hash('5184');

        $a = $captcha_ocr->find('5184');
        $code = implode("",$a);

        $member_list_username = '44528119970825031X';
        $member_list_nickname = '许钊纹';
        $exam_number = '528116102100002';
        //$header[] = "Cookie: JSESSIONID=D4123E2520F1859F092C2538B5DCF25D.tomcat1";
        $url = 'http://query.5184.com/query/fxl/zz_score_2016_a.jsp';
        $data = $this->http_curl->setParams(['name0' => $exam_number,'name1' => $member_list_username,'rand' => $code, 'serChecked' => 'on'])->get($url);
        list($header, $body) = explode("\r\n\r\n", $data, 2);
//var_dump($header);
        $table = QueryList::html($body)->find('table');
//var_dump($table);exit;
        // 采集表头
        $tableHeader = $table->find('tr:eq(0)')->find('th')->texts();
        $exam_data = $table->find('tr:eq(1)')->find('td')->texts();
        /*
        // 采集表的每行内容
        $tableRows = $table->find('tr:gt(0)')->map(function($row){
            return $row->find('td')->texts()->all();
        });
        print_r($tableRows->all());
        */
        print_r($exam_data->all());
        print_r($tableHeader->all());
        exit;
        echo "<img src='/data/upload/verify_images/".$image_name."'>";
        if(count($tableHeader))
        {
            var_dump($code."成功"."\n");
            $code_arr = str_split($code);
            $db = new StorageFile();
            for($i=0;$i< $image::CHAR_NUM;$i++){
                $hash_img_data=implode("",$image->splitImage($i));
                $db->add($code_arr[$i],$hash_img_data);
            }
            $success_num++;
        }else{
            var_dump($code."失败"."\n");
            $fail_num++;

        }
        sleep(1);
            $n++;
        }
        var_dump('成功次数：'.$success_num);
        var_dump('失败次数：'.$fail_num);
        exit;

        //$member_list = $this->member_model->limit(1000)->select();


    }
    public function test_NCRE()
    {

    }
    /**
     * NCRE 证书
     * 来源：http://zscx.neea.edu.cn/html1/folder/1508/211-1.htm?sid=300
     */
    public function NCRE()
    {

    }

    /**
     * PETS 证书
     * 来源：http://zscx.neea.edu.cn/html1/folder/1508/211-1.htm?sid=280
     */
    public function PETS()
    {

    }
    /* 专业技能考试 Professional Skills Exam */
    public function PSE($exam_info)
    {
        //$exam_year = substr($exam_info['exam_date'],0,4);
        //$exam_year_type = substr($exam_info['exam_date'],4,1);
        list($exam_year,$exam_year_type) = explode('_',$exam_info['exam_date']);

        $exam_info['exam_year'] = $exam_year;
        if($exam_year <= '2017')
        {
            if($exam_info['exam_date'] == '2017b')
            {
                return $this->PSE_2017b($exam_info);
            }else{
                return $this->PSE_to_2017a($exam_info);
            }
        }
    }

    /**
     * 2017 上半年及以前 专业技能课程等级证书
     * 来源：http://query.5184.com/query/query_list.jsp?queryType=14
     */
    public function PSE_to_2017a($exam_info)
    {
        $http_curl = new HttpCurl();

        $member_list_username = $exam_info['member_list_username'];
        $member_list_nickname = $exam_info['member_list_nickname'];
        $exam_number = $exam_info['exam_number'];
        $url = "http://query.5184.com/query/fxl/zz_score_".$exam_info['exam_date'].".jsp";

        $image_name = 'verify_img'.time().'.jpg';
        $folder = 'verify_images';
        $img_url = "http://query.5184.com/query/image.jsp?time=".math_random();
        $save_image = save_image($img_url,$folder,$image_name);
        $image_path = $save_image['save_path'];
        $captcha_ocr = new CaptchaOCR($image_path);
        $captcha_ocr->image_hash('5184');
        $a = $captcha_ocr->find('5184');
        $code = implode("",$a);

        $data = $http_curl->setParams(['name0' => $exam_number,'name1' => $member_list_username,'rand' => $code, 'serChecked' => 'on'])->get($url);
        list($header, $body) = explode("\r\n\r\n", $data, 2);
        $table = QueryList::html($body)->find('table');
        $tableHeader = $table->find('tr:eq(0)')->find('th')->texts();
        $exam_data = $table->find('tr:eq(1)')->find('td')->texts();
        if(count($tableHeader))
        {
            $code_arr = str_split($code);
            $db = new StorageFile();
            for($i=0;$i< $image::CHAR_NUM;$i++){
                $hash_img_data=implode("",$image->splitImage($i));
                $db->add($code_arr[$i],$hash_img_data);
            }
            $pse_content = [];
            foreach ($tableHeader as $key => $value)
            {
                $pse_content[$value] = $exam_data[$key];
            }
            $pse_data = [
                'member_list_id' => $exam_info['member_list_id'],
                'score' => $exam_data[4],
                'content' => json_encode($pse_content),
                'date' => $exam_info['exam_date'],
                'exam_number' => $exam_data[5]
            ];
            $exist_pse_data = Db::name('pse')->where('member_list_id',$exam_info['member_list_id'])->where('date',$exam_info['exam_date'])->find();
            if($exist_pse_data)
            {
                Db::name('pse')->where('member_list_id',$exam_info['member_list_id'])->update($pse_data);
            }else{
                Db::name('pse')->insert($pse_data);
            }
            return "success";
        }else{
            return $this->PSE_to_2017a();
        }
    }

    /**
     * 2017下半年 专业技能课程等级证书
     * 来源：http://service.southcn.com/ksy-zz/#/index
     */
    public function PSE_2017b()
    {

    }
    /**
     * 2018年 专业技能课程等级证书
     * 来源： 广东省教育考试院小程序
     * 2018上半年：https://aiexam-yun.pingan.com.cn/v1/scorequery/query/score
     * {"request_id":"61926c1e-fa09-11e8-9234-0123456789ab","info":{"plat":"aa","device":"ios"},"data":{"id_score_query":"17","input_param_value":["****","***"]}}
     * 2018下半年：https://aiexam-yun.pingan.com.cn/v1/scorequery/query/score
     * {"request_id":"61926c1e-fa09-11e8-9234-0123456789ab","info":{"plat":"aa","device":"ios"},"data":{"id_score_query":"18","input_param_value":["*****","*****"]}}
     * X-JWt-Token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhaWV4YW0udjEiLCJpYXQiOjE1NDQxMDc0NjUsInN1YiI6ImI4YTFhN2I5ZmY1YjQzNjg4MWYwOGY4NmNjMGI0MTIwIiwidHlwZSI6InB1YmxpYyIsImV4cCI6MTU0NDE5Mzg2NX0.gRyL3oj_IE9T4pEx2X11tnKR5y65WY3wufhVsDbDets
     * 分析：id_score_query 不同；request_id 一直变化，未知影响
     *
     */
    public function PSE_2018()
    {

    }

}