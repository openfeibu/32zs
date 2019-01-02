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
use think\Cache;

class Export extends Model
{
    public $header_name = '';

    public function score_list_export_pdf($field_titles=array(),$fields=array(),$data=array(),$table='Newfile',$title){

        set_time_limit(120);
        if(empty($field_titles) || empty($data)) $this->error("导出的数据为空！");
        require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/ScoreListTCPDF.php');
        $pdf = new \ScoreListTCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);//新建pdf文件
        //设置文件信息
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(config('pdf_common.author'));
        $pdf->SetTitle($table);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //设置页眉页脚
        $pdf->SetHeaderData('', '', $this->header_name,$title,array(66,66,66), array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(5, 24, 5);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, 40);//设置自动分页符
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //$pdf->setLanguageArray($l);
        $pdf->SetFont('droidsansfallback', '');
        $pdf->AddPage();

        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(66, 66, 66);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('droidsansfallback', '',9);
        // Header
        $num_headers = count($field_titles);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->MultiCell(280/$num_headers, 8, $field_titles[$i], $border=1, $align='C',1, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
        }
        $pdf->Ln();

        // 填充数据
        $fill = 0;
        foreach($data as $list) {
            //每頁重复表格标题行
            if(($pdf->getPageHeight()-$pdf->getY())<($pdf->getBreakMargin()+2)){
                $pdf->AddPage();
                $pdf->SetFillColor(245, 245, 245);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(66, 66, 66);
                $pdf->SetLineWidth(0.3);
                $pdf->SetFont('droidsansfallback', '',9);
                // Header
                for($i = 0; $i < $num_headers; ++$i) {
                    $pdf->MultiCell(280/$num_headers, 8, $field_titles[$i], $border=1, $align='C',1, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
                }

                $pdf->Ln();

            }
            // Color and font restoration
            $pdf->SetFillColor(245, 245, 245);
            $pdf->SetTextColor(40);
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('droidsansfallback', '');

            foreach($fields as $i=>$name){
                $pdf->MultiCell(280/$num_headers, 6, $list[$name], $border=1, $align='C',$fill, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
            }

            $pdf->Ln();
            $fill=!$fill;
        }


        // reset pointer to the last page
        $pdf->lastPage();

        $showType= 'D';//PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
        $pdf->Output("{$table}.pdf", $showType);
        exit;
    }
    public function recruit_score_list_export_pdf($field_titles=array(),$fields=array(),$data=array(),$table='Newfile',$title)
    {
        set_time_limit(120);
        if(empty($field_titles) || empty($data)) $this->error("导出的数据为空！");
        require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/RecruitScoreListTCPDF.php');
        $pdf = new \RecruitScoreListTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);//新建pdf文件
        //设置文件信息
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(config('pdf_common.author'));
        $pdf->SetTitle($table);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //设置页眉页脚
        $pdf->SetHeaderData('', '', $this->header_name,$title,array(66,66,66), array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, 30);//设置自动分页符
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //$pdf->setLanguageArray($l);
        $pdf->SetFont('droidsansfallback', '');
        $pdf->AddPage();

        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(66, 66, 66);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('droidsansfallback', '',9);
        // Header
        $num_headers = count($field_titles);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell(180/$num_headers, 8, $field_titles[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();

        // 填充数据
        $fill = 0;
        foreach($data as $list) {
            //每頁重复表格标题行
            if(($pdf->getPageHeight()-$pdf->getY())<($pdf->getBreakMargin()+2)){
                $pdf->SetFillColor(245, 245, 245);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(66, 66, 66);
                $pdf->SetLineWidth(0.3);
                $pdf->SetFont('droidsansfallback', '',9);
                // Header
                for($i = 0; $i < $num_headers; ++$i) {
                    $pdf->Cell(180/$num_headers, 8, $field_titles[$i], 1, 0, 'C', 1);
                }
                $pdf->Ln();
            }
            // Color and font restoration
            $pdf->SetFillColor(245, 245, 245);
            $pdf->SetTextColor(40);
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('droidsansfallback', '');

            foreach($fields as $i=>$name){
                $pdf->MultiCell(180/$num_headers, 6, $list[$name], $border=1, $align='C',$fill, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
            }

            $pdf->Ln();
            $fill=!$fill;
        }

        // reset pointer to the last page
        $pdf->lastPage();

        $showType= 'D'; //PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
        $pdf->Output("{$table}.pdf", $showType);
        exit;
    }
    public function school_recruit_score_export_pdf($field_titles=array(),$fields=array(),$data=array(),$table,$title,$is_score = 1)
    {
        set_time_limit(120);
        require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        if($is_score == 1)
        {
            require_once(EXTEND_PATH . 'tcpdf/SchoolRecruitScoreListTCPDFWithScore.php');
            $pdf = new \SchoolRecruitScoreListTCPDFWithScore('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        }else{
            require_once(EXTEND_PATH . 'tcpdf/SchoolRecruitScoreListTCPDF.php');
            $pdf = new \SchoolRecruitScoreListTCPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
        }

        //设置文件信息
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor(config('pdf_common.author'));
        $pdf->SetTitle($table);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        //设置页眉页脚
        $pdf->SetHeaderData('', '', config('pdf_common.header_name'),$title,array(66,66,66), array(0,0,0));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);//设置默认等宽字体
        $pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);//设置页面边幅
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(30);
        $pdf->SetAutoPageBreak(TRUE, 30);//设置自动分页符
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //$pdf->setLanguageArray($l);
        $pdf->SetFont('droidsansfallback', '');
        $pdf->AddPage();

        $pdf->SetFillColor(245, 245, 245);
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(66, 66, 66);
        $pdf->SetLineWidth(0.3);
        $pdf->SetFont('droidsansfallback', '',9);
        // Header
        $num_headers = count($field_titles);
        for($i = 0; $i < $num_headers; ++$i) {
            $pdf->Cell(180/$num_headers, 8, $field_titles[$i], 1, 0, 'C', 1);
        }
        $pdf->Ln();

        // 填充数据
        $fill = 0;
        foreach($data as $list) {
            //每頁重复表格标题行
            if(($pdf->getPageHeight()-$pdf->getY())<($pdf->getBreakMargin()+2)){
                $pdf->SetFillColor(245, 245, 245);
                $pdf->SetTextColor(0);
                $pdf->SetDrawColor(66, 66, 66);
                $pdf->SetLineWidth(0.3);
                $pdf->SetFont('droidsansfallback', '',9);
                // Header
                for($i = 0; $i < $num_headers; ++$i) {
                    $pdf->Cell(180/$num_headers, 8, $field_titles[$i], 1, 0, 'C', 1);
                }
                $pdf->Ln();
            }
            // Color and font restoration
            $pdf->SetFillColor(245, 245, 245);
            $pdf->SetTextColor(40);
            $pdf->SetLineWidth(0.1);
            $pdf->SetFont('droidsansfallback', '');

            foreach($fields as $i=>$name){
                $pdf->MultiCell(180/$num_headers, 6, $list[$name], $border=1, $align='C',$fill, $ln=0, $x='', $y='',  $reseth=true, $stretch=0,$ishtml=false, $autopadding=true, $maxh=0, $valign='C', $fitcell=true);
            }

            $pdf->Ln();
            $fill=!$fill;
        }

        // reset pointer to the last page
        $pdf->lastPage();

        $showType= 'D'; //PDF输出的方式。I，在浏览器中打开；D，以文件形式下载；F，保存到服务器中；S，以字符串形式输出；E：以邮件的附件输出。
        $pdf->Output("{$table}.pdf", $showType);
        exit;
    }
}