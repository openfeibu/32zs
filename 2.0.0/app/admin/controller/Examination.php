<?php
namespace app\admin\controller;

use think\Db;
use think\Cache;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\MemberList;

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
        $this->success('添加成功',url('admin/Examination/rooms'));
    }
    /*
    public function createExamination()
    {
        $rooms = Db::name('room')->where('school_id',$this->admin['school_id'])->order('room_id','asc')->select();
        $this->assign('rooms',$rooms);
        $major_ids = json_decode($this->admin['major_id'],true);
        $major_list = MajorModel::get_secondary_vocat_major_list($major_ids,$this->admin['school_id']);
        $recruit_major_data = array();
        $member_count = Db::name('member_list')->where(['major_id' => ['in',$major_ids],'school_id' => $this->admin['school_id'],'user_status' => 1])->count();
        foreach ($major_list as $key => $major) {
            $recruit_major_id = $major['recruit_major_id'];
            $recruit_major_data[$recruit_major_id]['recruit_major_name'] = $major['recruit_major_name'];
            $recruit_major_data[$recruit_major_id]['recruit_major_id'] = $recruit_major_id;
            $recruit_major_data[$recruit_major_id]['majors'][] =  $major;
        }
        foreach($recruit_major_data as $rk => $recruit_major)
        {
            $examination = Db::name('examination')->where('recruit_major_id',$recruit_major['recruit_major_id'])->where('school_id',$this->admin['school_id'])->find();
            $room_id = [];
            $recruit_major_data[$rk]['examination'] = [];
            if($examination)
            {
                $examination_rooms = Db::name('examination_room')->where('examination_id',$examination['examination_id'])->select();
                foreach($examination_rooms as $ex => $examination_room){
                    $room_id[] = $examination_room['room_id'];
                }
                $recruit_major_data[$rk]['examination'] = $examination;
            }
            $recruit_major_data[$rk]['room_id'] = $room_id;
        }

        $this->assign('member_count',$member_count);
        $this->assign('recruit_major_data',$recruit_major_data);
        return $this->fetch();
    }*/
    public function createExamination()
    {
        $rooms = Db::name('room')->where('school_id',$this->admin['school_id'])->order('room_id','asc')->select();
        $this->assign('rooms',$rooms);
        $recruit_major_data = EnrollmentModel::get_enrollment_recruit_major($this->admin['school_id']);

        foreach ($recruit_major_data as $rk => $recruit_major) {
            $major_id_arr = array_filter(explode(',',$recruit_major['major_ids']));
            $member_count = Db::name('member_list')->where(['major_id' => ['in',$major_id_arr],'school_id' => $this->admin['school_id'],'user_status' => 1])->count();
            $recruit_major_data[$rk]['member_count'] = $member_count;
            $major_list = MajorModel::get_secondary_vocat_major_list($major_id_arr,$this->admin['school_id']);
            $recruit_major_data[$rk]['majors'] = $major_list;
            $examination = Db::name('examination')->where('recruit_major_id',$recruit_major['recruit_major_id'])->where('school_id',$this->admin['school_id'])->find();
            $room_id = [];
            $recruit_major_data[$rk]['examination'] = [];
            $recruit_major_data[$rk]['is_examination'] = 0;
            if($examination)
            {
                $examination_rooms = Db::name('examination_room')->where('examination_id',$examination['examination_id'])->select();
                foreach($examination_rooms as $ex => $examination_room){
                    $room_id[] = $examination_room['room_id'];
                }
                $recruit_major_data[$rk]['examination'] = $examination;
                $recruit_major_data[$rk]['is_examination'] = 1;
            }
            $recruit_major_data[$rk]['room_id'] = $room_id;
        }

        $this->assign('recruit_major_data',$recruit_major_data);
        return $this->fetch();
    }
    public function storeExamination()
    {
        $post_data = input('post.');
        $data['recruit_major_id'] = $recruit_major_id = $post_data['recruit_major_id'];
        $data['date'] = $date = $post_data['date'];
        $data['starttime'] = $starttime = $post_data['starttime'];
        $data['endtime'] = $endtime = $post_data['endtime'];
        $data['school_id'] = $this->admin['school_id'];
        $room_ids = $post_data['room_id'];
        $examination = Db::name('examination')->where('recruit_major_id',$recruit_major_id)->where('school_id',$this->admin['school_id'])->find();
        if($examination)
        {
            Db::name('examination')->where('examination_id',$examination['examination_id'])->update([
                'date' => $post_data['date'],
                'starttime' => $post_data['starttime'],
                'endtime' => $post_data['endtime'],
            ]);
            Db::name('examination_room')->where('examination_id',$examination['examination_id'])->delete();
            $examination_id = $examination['examination_id'];
        }else{
            Db::name('examination')->insert($data);
            $examination_id = Db::name('examination')->getLastInsID();
        }
        foreach ($room_ids as $key => $room_id) {
            Db::name('examination_room')->insert(['room_id' => $room_id,'examination_id' => $examination_id]);
        }
        $this->success('添加成功',url('admin/Examination/createExamination'));
    }
    public function exportExamination()
    {
        $recruit_major_id = input('recruit_major_id');
        $school_id = $this->admin['school_id'];
        $enrollment = Db::name('enrollment')->where(['school_id' => $school_id,'recruit_major_id' => $recruit_major_id])->find();
        $recruit_major = Db::name('recruit_major')->where(['recruit_major_id' => $recruit_major_id])->find();
        $major_ids = array_filter(explode(',',$enrollment['major_ids']));
        $where['s.school_id'] = $school_id;
        $where['a.major_id'] = array('in',$major_ids);
        $member_model=new MemberList;
        $member_list = $member_model->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
                ->join(config('database.prefix').'member_info mi','mi.member_list_id = a.member_list_id')
                ->join(config('database.prefix').'school s','a.school_id = s.school_id')
                ->join(config('database.prefix').'major m','a.major_id = m.major_id')
                ->where($where)
                ->where('a.user_status',1)
                ->field('a.member_list_nickname,a.member_list_username,a.member_list_headpic, mi.ZexamineeNumber')
                ->select();
        $examination = Db::name('examination')->where('recruit_major_id',$recruit_major['recruit_major_id'])->where('school_id',$this->admin['school_id'])->find();
        $examination_rooms = Db::name('examination_room')->alias('er')
                            ->join(config('database.prefix').'room r','r.room_id = er.room_id')
                            ->where('er.examination_id',$examination['examination_id'])
                            ->field('r.room_id,r.room_number,r.room_name')
                            ->order('r.room_id','asc')
                            ->select();
        $i = 0;
        $rooms_data =[];
        foreach ($examination_rooms as $erk => $erv) {
            $room_number = $erv['room_number'];
            for ($num=1; $num < $room_number; $num++) {
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
		$pdf->SetAuthor("Gouweiba");
		$pdf->SetTitle("pdf test");
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$pdf->SetMargins(9, 20,0);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(false);
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//$pdf->SetFont('stsongstdlight', '', 13);
		$title = "ceshi";
        $i = 0;
        $page = 0;
        foreach ($member_list as $mk => $mvalue) {
            $page =1;
            $pdf->AddPage();
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
}
