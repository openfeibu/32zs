<?php
namespace app\admin\controller;

use think\Db;
use think\Cache;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\MemberList;
use app\admin\model\Examination as ExaminationModel;
use app\admin\model\Subject as SubjectModel;

class Examination extends Base
{
    public function rooms()
    {
        $rooms = Db::name('room')->where('school_id',$this->admin['school_id'])->order('room_id','asc')->select();
        $this->assign('rooms',$rooms);
        return $this->fetch();
    }
    public function room_runedit()
    {
        $data = input('post.');
        $ids = $data['id'];
        $room_names = $data['room_name'];
        $numbers = $data['room_number'];

        Db::name('room')->where('school_id',$this->admin['school_id'])->where('room_id','not in',$ids)->delete();
        foreach ($room_names as $key => $room_name) {
            if($room_name && $numbers[$key])
            {
                $room_data[$key] = [
                    'room_name' => $room_name,
                    'room_number' => $numbers[$key],
                    'school_id' => $this->admin['school_id'],
                ];
                if($ids[$key])
                {
                    $room = Db::name('room')->where('school_id',$this->admin['school_id'])->where('room_id',$ids[$key])->find();
                    if($room)
                    {
                        Db::name('room')->where('school_id',$this->admin['school_id'])->where('room_id',$ids[$key])->update($room_data[$key]);
                    }
                }else{
                    Db::name('room')->insert($room_data[$key]);
                }
            }
        }
        $this->success('已保存',url('admin/Examination/rooms'));
    }

    public function createExamination()
    {
        $rooms = Db::name('room')->where('school_id',$this->admin['school_id'])->order('room_id','asc')->select();
        $this->assign('rooms',$rooms);

        $major_ids = json_decode($this->admin['major_id'],true);
        $data = array();

        foreach ($major_ids as $key => $major_id)
        {
            $examination_list = Db::name('examination')->where('school_id',$this->admin['school_id'])->where('major_id',$major_id)->select();
            $examination_list_data = array();
            $all_examination_subject_id_arr = array();
            foreach ($examination_list as $examination_key => $examination)
            {
                $examination_list_data[$examination_key] = $examination;

                $examination_subject_list = Db::name('examination_subject')->alias('es')
                    ->join(config('database.prefix').'subject s','es.subject_id = s.subject_id')
                    ->where('es.examination_id',$examination['examination_id'])
                    ->field('s.subject_name,s.subject_id,es.examination_id')
                    ->select();

                $examination_subject_id_arr = array_column($examination_subject_list,'subject_id');
                $all_examination_subject_id_arr = array_merge($examination_subject_id_arr,$all_examination_subject_id_arr);
                $examination_list_data[$examination_key]['examination_subject_list'] = $examination_subject_list;
                $examination_list_data[$examination_key]['examination_subject_id_arr'] = $examination_subject_id_arr;

                $examination_room_list = Db::name('examination_room')->alias('er')
                    ->join(config('database.prefix').'room r','r.room_id = er.room_id')
                    ->where('er.examination_id',$examination['examination_id'])
                    ->field('r.room_name,r.room_id,er.examination_id')
                    ->select();
                $examination_room_id_arr = array_column($examination_room_list,'room_id');
                $examination_list_data[$examination_key]['examination_room_list'] = $examination_room_list;
                $examination_list_data[$examination_key]['examination_room_id_arr'] = $examination_room_id_arr;

            }

            $data[$key]['examination_list_data'] = $examination_list_data;
            $data[$key]['all_examination_subject_id_arr'] = $all_examination_subject_id_arr;
            $where = [];
            if(count($all_examination_subject_id_arr))
            {
                $where = ['subject_id' => ['not in',$all_examination_subject_id_arr]];
            }

            $subject_list = SubjectModel::get_subject_list($major_id,$this->admin['school_id'],'','');
            $data[$key]['subject_list'] = $subject_list;
            $left_subject_list = SubjectModel::get_subject_list($major_id,$this->admin['school_id'],'','',$where);
            $data[$key]['left_subject_list'] = $left_subject_list;
            $enrollment = EnrollmentModel::get_enrollment_major($this->admin['school_id'],$major_id);
            $data[$key]['recruit_major_name'] = $enrollment['recruit_major_name'];
            $major = Db::name('major')->find($major_id);
            $data[$key]['major_name'] = $major['major_name'];
            $data[$key]['major_id'] = $major['major_id'];
            $member_count = Db::name('member_list')->where(['major_id' => ['in',$major['major_id']],'school_id' => $this->admin['school_id'],'user_status' => 1])->where(get_year_where())->count();
            $data[$key]['member_count'] = $member_count;
            $data[$key]['is_examination'] = 0;
        }
        $this->assign('data',$data);
        if(request()->isAjax()){
            return $this->fetch('examination_table');
        }
        return $this->fetch();
    }
    public function storeExamination()
    {
        $post_data = input('post.');
        $data['major_id'] = $major_id = $post_data['major_id'];
        $data['examination_id'] = $examination_id = $post_data['examination_id'] ?? 0;
        $data['date'] = $date = $post_data['date'];
        $data['starttime'] = $starttime = $post_data['starttime'];
        $data['endtime'] = $endtime = $post_data['endtime'];
        $data['school_id'] = $this->admin['school_id'];
        $room_ids = $post_data['room_id'];
        $subject_ids = $post_data['subject_id'];
        if(strtotime($starttime) >= strtotime($endtime))
        {
            $this->error('时间安排不正确');
        }
        if(!count($subject_ids))
        {
            $this->error('请选择考试科目');
        }
        $examination = (new ExaminationModel())->find($examination_id);
        foreach ($room_ids as $key => $room_id) {
            $other_examination_rooms = Db::name('examination')->alias('e')
                                ->join(config('database.prefix').'examination_room er','er.examination_id = e.examination_id')
                                ->join(config('database.prefix').'room r','r.room_id = er.room_id');
            if($examination)
            {
                $other_examination_rooms = $other_examination_rooms->where('e.examination_id','<>',$examination['examination_id']);
            }
            $other_examination_rooms = $other_examination_rooms->where('e.school_id',$this->admin['school_id'])
                                ->where('r.room_id',$room_id)
                                ->field('e.*,r.room_name')
                                ->select();
            if($other_examination_rooms)
            {
                foreach ($other_examination_rooms as $key => $other_examination_room)
                {
                    if($other_examination_room['date'] == $date)
                    {
                        if(strtotime($starttime) > strtotime($other_examination_room['endtime']) || strtotime($endtime) < strtotime($other_examination_room['starttime']))
                        {
                            continue;
                        }else{
                            $this->error($other_examination_room['room_name'].'该时间段被占用');
                        }
                    }
                }
            }
        }

        if($examination)
        {
            Db::name('examination')->where('examination_id',$examination['examination_id'])->update([
                'date' => $post_data['date'],
                'starttime' => $post_data['starttime'],
                'endtime' => $post_data['endtime'],
            ]);
            Db::name('examination_room')->where('examination_id',$examination['examination_id'])->delete();
            Db::name('examination_subject')->where('examination_id',$examination['examination_id'])->delete();
            $examination_id = $examination['examination_id'];
        }else{
            Db::name('examination')->insert($data);
            $examination_id = Db::name('examination')->getLastInsID();
        }
        foreach ($room_ids as $key => $room_id) {
            Db::name('examination_room')->insert(['room_id' => $room_id,'examination_id' => $examination_id]);
        }
        foreach ($subject_ids as $key => $subject_id) {
            Db::name('examination_subject')->insert(['subject_id' => $subject_id,'examination_id' => $examination_id]);
        }
        $this->success('已保存',url('admin/Examination/createExamination'),['examination_id' => $examination_id]);
    }
    public function deleteExamination()
    {
        $examination_id = input('examination_id','');
        $examination = ExaminationModel::get($examination_id);
        if(!$examination)
        {
            $this->error('考试安排不存在');
        }
        $examination->delete();
        Db::name('examination_room')->where('examination_id',$examination['examination_id'])->delete();
        Db::name('examination_subject')->where('examination_id',$examination['examination_id'])->delete();
        $this->success('删除成功',url('admin/Examination/createExamination'));
    }
    public function exportExamination()
    {
        $examination_id = input('examination_id');
        $examination = ExaminationModel::get($examination_id);
        if(!$examination)
        {
            $this->error('考试安排不存在');
        }
        $where['s.school_id'] = $examination['school_id'];
        $where['a.major_id'] = $examination['major_id'];
        $member_model=new MemberList;
        $member_list = $member_model->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
                ->join(config('database.prefix').'member_info mi','mi.member_list_id = a.member_list_id')
                ->join(config('database.prefix').'school s','a.school_id = s.school_id')
                ->join(config('database.prefix').'major m','a.major_id = m.major_id')
                ->where($where)
                ->where('a.user_status',1)
                ->where(get_year_where('a'))
                //->where('a.member_list_id','in',['138','160'])
                ->field('a.member_list_nickname,a.member_list_username,a.member_list_headpic, mi.ZexamineeNumber')
                ->limit(2)
                ->select();

        $examination_room_list = Db::name('examination_room')->alias('er')
                            ->join(config('database.prefix').'room r','r.room_id = er.room_id')
                            ->where('er.examination_id',$examination['examination_id'])
                            ->field('r.room_id,r.room_number,r.room_name')
                            ->order('r.room_id','asc')
                            ->select();
        $i = 0;
        $rooms_data = [];
        foreach ($examination_room_list as $erk => $erv) {
            $room_number = $erv['room_number'];
            for ($num=1; $num <= $room_number; $num++) {
                $rooms_data[$i] =[
                    'room_no' => sprintf("%03d", $num),
                    'room_name' => $erv['room_name'],
                ];
                $i++;
            }
        }
        $examination_subject_list = Db::name('examination_subject')->alias('es')
            ->join(config('database.prefix').'subject s','es.subject_id = s.subject_id')
            ->where('es.examination_id',$examination['examination_id'])
            ->field('s.subject_name,s.subject_id,es.examination_id')
            ->select();
        $examination_subject_name_arr = array_column($examination_subject_list,'subject_name');
        $examination_subject_names = implode(' ',$examination_subject_name_arr);
        $recruit_major = RecruitMajorModel::get_recruit_major($examination['school_id'],$examination['major_id']);
        $this->assign('recruit_major',$recruit_major);
        $this->assign('examination',$examination);
        $this->assign('examination_subject_names',$examination_subject_names);

        require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/TCPDF.php');
		$pdf = new \tcpdf\TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(config('pdf_common.author'));
		$pdf->SetTitle("转段考核准考证");
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(13, 3,0);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(false);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//$pdf->SetFont('stsongstdlight', '', 13);
		$title = "ceshi";
        $i = 0;
        $page = 0;
        foreach ($member_list as $mk => $mvalue) {
            if($page%2==0)
            {
                $pdf->AddPage();
            }
            $page++;
			$pdf->setPageMark();
            $member_list[$mk]['room_name'] = $rooms_data[$i]['room_name'];
            $member_list[$mk]['room_no'] = $rooms_data[$i]['room_no'];
            $i++;
            $this->assign('member',$member_list[$mk]);
            $content = $this->fetch('ticket');
            $pdf->writeHTML($content, true, false, false, false, '');
        }
		if($page == 0)
		{
			$pdf->AddPage();
		}
		$pdf->lastPage();
		$pdf->Output($recruit_major['recruit_major_name']."准考证" . '.pdf', 'D');
        exit;
    }
    public function exportExaminationSeats()
    {
        $examination_id = input('examination_id');
        $examination = ExaminationModel::get($examination_id);
        if(!$examination)
        {
            $this->error('考试安排不存在');
        }
        $where['s.school_id'] = $examination['school_id'];
        $where['a.major_id'] = $examination['major_id'];
        $recruit_major = RecruitMajorModel::get_recruit_major($examination['school_id'],$examination['major_id']);
        $member_model=new MemberList;
        $member_list = $member_model->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
                ->join(config('database.prefix').'member_info mi','mi.member_list_id = a.member_list_id')
                ->join(config('database.prefix').'school s','a.school_id = s.school_id')
                ->join(config('database.prefix').'major m','a.major_id = m.major_id')
                ->where($where)
                ->where('a.user_status',1)
                ->where(get_year_where('a'))
                ->field('a.member_list_nickname,a.member_list_username,a.member_list_headpic, mi.ZexamineeNumber')
                //->limit(11)
                ->select();

        $examination_rooms = Db::name('examination_room')->alias('er')
                            ->join(config('database.prefix').'room r','r.room_id = er.room_id')
                            ->where('er.examination_id',$examination['examination_id'])
                            ->field('r.room_id,r.room_number,r.room_name')
                            ->order('r.room_id','asc')
                            ->select();
        $i = 0;
        $rooms_data = [];
        foreach ($examination_rooms as $erk => $erv) {
            $room_number = $erv['room_number'];
            for ($num=1; $num <= $room_number; $num++) {
                $rooms_data[$i] =[
                    'room_no' => sprintf("%03d", $num),
                    'room_name' => $erv['room_name'],
                ];
                $i++;
            }
        }

        $this->assign('recruit_major',$recruit_major);
        $this->assign('examination',$examination);

        require_once(EXTEND_PATH . 'tcpdf/examples/lang/eng.php');
        require_once(EXTEND_PATH . 'tcpdf/TCPDF.php');
		$pdf = new \tcpdf\TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(config('pdf_common.author'));
		$pdf->SetTitle("专业技能考核座位贴");
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(13, 3,0);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(false);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//$pdf->SetFont('stsongstdlight', '', 13);
		$title = "ceshi";
        $i = 0;
        foreach ($member_list as $mk => $mvalue) {
            $member_list[$mk]['room_name'] = $rooms_data[$i]['room_name'];
            $member_list[$mk]['room_no'] = $rooms_data[$i]['room_no'];
            $i++;
        }
        $page = 0;
        $count = count($member_list);
        for ($page=$page; $page < $count; $page++) {
            if($page%10==0)
            {
                $pdf->AddPage();
                $pdf->setPageMark();
                $member_seats = array_slice($member_list,$page,10);
                $this->assign('member_seats',$member_seats);
                $i=$j=0;
                foreach ($member_seats as $key => $member) {
                    $this->assign('member',$member);
                    $content = $this->fetch('seats');
                    if($i%2==0)
                    {
                        $pdf->writeHTMLCell(0, 0, 3, 28*$i+10, $content, $border=0, true, false, false, false, '');
                    }else{
                        $pdf->writeHTMLCell(0, 0, 108, 28*($i-1)+10, $content, $border=0, true, false, false, false, '');
                    }
                    $i++;
                }
            }

        }
		if($page == 0)
		{
			$pdf->AddPage();
		}
		$pdf->lastPage();
		$pdf->Output($recruit_major['recruit_major_name']."转段考核座位贴" . '.pdf', 'D');
        exit;
    }
}
