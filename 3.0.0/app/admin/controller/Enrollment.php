<?php

namespace app\admin\controller;

use app\admin\model\School as SchoolModel;
use app\admin\model\Major as MajorModel;
use app\admin\model\Enrollment as EnrollmentModel;
use app\admin\model\Admin as AdminModel;
use app\admin\model\RecruitMajor as RecruitMajorModel;
use app\admin\model\MajorScoreConfig as MajorScoreConfigModel;
use think\Db;
use think\Cache;
use Overtrue\Pinyin\Pinyin;

class Enrollment extends Base
{
    public function enrollment()
    {
        $enrollments = Db::name('enrollment')->alias('e')
            ->join(config('database.prefix').'recruit_major rm','e.recruit_major_id = rm.recruit_major_id')
            ->join(config('database.prefix').'school s','e.school_id = s.school_id')
            ->where(get_year_where('e'))
            //->order('e.recruit_major_id','asc')
            //->order('s.school_id','asc')
            ->order('e.enrollment_id','asc')
            ->select();

        foreach ($enrollments as $key => $enrollment) {
            $major_ids = explode(',',$enrollment['major_ids']);
            $major_ids = array_filter($major_ids);
            $majors = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
            $major_desc = '';
            foreach ($majors as $k => $major) {
                $major_desc.= $major['major_name'] . '(' . $major['major_code'] . ') ';
            }
            $enrollments[$key]['majors'] = $majors;
            $enrollments[$key]['major_desc'] = $major_desc;
        }
        $this->assign('enrollments',$enrollments);
        return $this->fetch();
    }
    public function enrollment_add()
	{
		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		$major_list = Db::name('major')->select();
		$this->assign('major_list',$major_list);
		return $this->fetch();
	}
	public function enrollment_runadd()
	{
		$major_ids = array_unique(array_filter($_POST['major_id']));
		$major_ids = implode(',',$major_ids);
		$major_ids = ','.$major_ids.',';
		$data = [
			'recruit_major_id' => input('recruit_major_id'),
			'major_ids' => $major_ids,
			'school_id' => input('school_id'),
			'enrollment_number' => input('enrollment_number'),
		];
		EnrollmentModel::create($data);
		$this->success('添加成功',url('admin/Enrollment/enrollment'));
	}
    public function enrollment_edit()
	{
        $enrollment_id = input('enrollment_id',0,'intval');
        $enrollment = EnrollmentModel::get_enrollment($enrollment_id);
        if(!$enrollment){
            return $this->error('数据不存在');
        }
 		$recruit_major_list = Db::name('recruit_major')->select();
		$this->assign('recruit_major_list',$recruit_major_list);
		$school_list = Db::name('school')->select();
		$this->assign('school_list',$school_list);
		$major_list = Db::name('major')->select();
		$this->assign('major_list',$major_list);
        $this->assign('enrollment',$enrollment);
		return $this->fetch();
	}
	public function enrollment_runedit()
	{
        $enrollment_id = input('enrollment_id','');
        $enrollment = EnrollmentModel::get_enrollment($enrollment_id);
        if(!$enrollment){
            return $this->error('数据不存在');
        }
		$data = [
			'recruit_major_id' => input('recruit_major_id'),
			'enrollment_number' => input('enrollment_number'),
		];
        $rst = Db::name('enrollment')->where(['enrollment_id' => $enrollment_id])->update($data);

        $this->success('操作成功',url('admin/Enrollment/enrollment'));


	}
    public function enrollment_del()
    {
        $p=input('p');
        $enrollment_id=input('enrollment_id');
        $enrollment_model=new EnrollmentModel;
        $enrollment = $enrollment_model->where(['enrollment_id' => $enrollment_id])->find();
        if(!$enrollment){
            return $this->error('数据不存在');
        }
        $admin_list = Db::name('admin')->where(['school_id' => $enrollment['school_id']])->select();
        $member_list = Db::name('member_list')->where(['school_id' => $enrollment['school_id']])->select();
        if($admin_list || $member_list)
        {
            return $this->error('请先删除与该招生计划关联学校下的中职负责人及中职考生数据');
        }
        $rst = $enrollment_model->where(array('enrollment_id'=>$enrollment_id))->delete();
        if($rst!==false){
            $this->success('删除成功',url('admin/Enrollment/enrollment', array('p' => $p)));
        }else{
            $this->error('删除失败',url('admin/Enrollment/enrollment', array('p' => $p)));
        }

    }
    public function enrollment_delall()
    {
        $p = input('p');
        $ids = input('n_id/a');
        $enrollment_model = new EnrollmentModel;
        if(empty($ids)){
            $this -> error("请选择列表",url('admin/Enrollment/enrollment',array('page' => $p)));
        }
        if(is_array($ids)){
            $where = 'enrollment_id in('.implode(',',$ids).')';
        }else{
            $where = 'enrollment_id = '.$ids;
        }
        $school_ids = [];
        $enrollment_list = $enrollment_model->where($where)->select();
        foreach ($enrollment_list as $key => $enrollment) {
            $school_ids[] = $enrollment['school_id'];
        }
        $admin_list = Db::name('admin')->where(['school_id' => ['in',$school_ids]])->select();
        $member_list = Db::name('member_list')->where(['school_id' => ['in',$school_ids]])->select();
        if($admin_list || $member_list)
        {
            return $this->error('请先删除与该招生计划关联学校下的中职负责人及中职考生数据');
        }
        $rst = $enrollment_model->where($where)->delete();
        if($rst!==false){
			$this->success('删除成功',url('admin/Enrollment/enrollment', array('p' => $p)));
		}else{
			$this->error('删除失败',url('admin/Enrollment/enrollment', array('p' => $p)));
		}
    }

	public function enrollment_import()
    {
        return $this->fetch();
    }

    public function enrollment_runimport()
    {
        $pinyin = new Pinyin();
        if (! empty ( $_FILES ['file_stu'] ['name'] )){
            $tmp_file = $_FILES ['file_stu'] ['tmp_name'];
            $file_types = explode ( ".", $_FILES ['file_stu'] ['name'] );
            $file_type = $file_types [count ( $file_types ) - 1];
            /*判别是不是.xls文件，判别是不是excel文件*/
            if ($file_type != "xls" && $file_type != "xlsx"){
                $this->error ( '不是Excel文件，重新上传',url('admin/Import/index'));
            }
            /*设置上传路径*/
            $savePath = ROOT_PATH. 'public/excel/';
            /*以时间来命名上传的文件*/
            $str = time ();
            $file_name = $str . "." . $file_type;
            if (! copy ( $tmp_file, $savePath . $file_name )){
                $this->error ('上传失败',url('admin/Import/index'));
            }
            $res = readWithSuffix ( $savePath . $file_name ,$file_type);
            if (!$res){
                $this->error ('数据处理失败',url('admin/Import/index'));
            }
            $schools = $major = $recruit_major = $enrollment = array();
            $new_schools = $new_majors = $new_recruit_majors = array();
            $errors = array();
            $major_id = $school_id = 0;
            $recruit_major_id = DB::name('recruit_major')->order('recruit_major_id','desc')->value('recruit_major_id');
            $recruit_major_id = $recruit_major_id ?? 0;
            $major_id = DB::name('major')->order('major_id','desc')->value('major_id');
            $major_id = $major_id ?? 0;
            $school_id = DB::name('school')->order('school_id','desc')->value('school_id');
            $school_id = $school_id ?? 0;

            $recruit_major_codes = $major_codes = $school_names = array();

            foreach($res as $k => $v)
            {
                if ($k != 1 && trim($v[0])){
                    $school_name = trim($v[3]);
                    $schools[$k]['school_name'] = trim($v[3]);
                    /* 判断是否已有该中职 */
                    $exist_school = Db::name('school')->where('school_name',$school_name)->find();
                    if($exist_school)
                    {
                        $schools[$k]['school_id'] = $exist_school['school_id'];
                    }else{
                        if(in_array($school_name,$school_names))
                        {
                            $schools[$k]['school_id'] = get_val_from_arr2($schools,$school_name,'school_id','school_name');
                        }else{
                            $school_id++;
                            $schools[$k]['school_id'] = $school_id;
                        }
                        $new_schools[$schools[$k]['school_id']] = $schools[$k];
                    }

                    $school_names[] = $school_name;

                    $recruit_major_name = trim($v[1]);
                    $recruit_major_code = trim($v[2]);

                    $recruit_major[$k] = [
                        'recruit_major_name' => $recruit_major_name,
                        'recruit_major_code' => $recruit_major_code,
                    ];
                    /* 判断是否已有该高职专业 */
                    $exist_recruit_major = Db::name('recruit_major')->where('recruit_major_code',$recruit_major_code)->find();
                    if($exist_recruit_major)
                    {
                        $recruit_major[$k]['recruit_major_id'] = $exist_recruit_major['recruit_major_id'];
                    }else{
                        if(in_array($recruit_major_code,$recruit_major_codes))
                        {
                            $recruit_major[$k]['recruit_major_id'] = get_val_from_arr2($recruit_major,$recruit_major_code,'recruit_major_id','recruit_major_code');
                        }else{
                            $recruit_major_id++;
                            $recruit_major[$k]['recruit_major_id'] = $recruit_major_id;
                        }
                        $new_recruit_majors[$recruit_major[$k]['recruit_major_id']] = $recruit_major[$k];
                    }

                    $recruit_major_codes[] = $recruit_major_code;

                    $major_name = trim($v[4]);
                    $major_code = trim($v[5]);

                    $major[$k] = [
                        'major_name' => $major_name,
                        'major_code' => $major_code,
                    ];
                    /* 判断是否已有该高职专业 */
                    $exist_major = Db::name('major')->where('major_code',$major_code)->find();
                    if($exist_major)
                    {
                        $major[$k]['major_id'] = $exist_major['major_id'];
                    }else{
                        if(in_array($major_code,$major_codes))
                        {
                            $major[$k]['major_id'] = get_val_from_arr2($major,$major_code,'major_id','major_code');
                        }else{
                            $major_id++;
                            $major[$k]['major_id'] = $major_id;
                        }
                        $new_majors[$major[$k]['major_id']] = $major[$k];
                    }

                    $major_codes[] = $major_code;
                }
            }

            foreach($res as $k => $v)
            {
                if ($k != 1 && trim($v[0])){
                    $enrollment[$k] = [
                        'school_id' => $schools[$k]['school_id'],
                        'major_ids' => ','.$major[$k]['major_id'].',',
                        'recruit_major_id' => $recruit_major[$k]['recruit_major_id'],
                        'enrollment_number' => intval(trim($v[6])),
                        'year' => input('year',date('Y'))
                    ];
                }
            }

            /*
            $schools = array_unique($schools,SORT_REGULAR);
            $recruit_major = array_unique($recruit_major,SORT_REGULAR);
            $major = array_unique($major,SORT_REGULAR);
            */
            $recruit_major = assoc_unique($recruit_major,'recruit_major_code');
            $major = assoc_unique($major,'major_code');
            $schools = assoc_unique($schools,'school_name');
            DB::name('school')->insertAll($new_schools);
            DB::name('recruit_major')->insertAll($new_recruit_majors);
            DB::name('major')->insertAll($new_majors);
            DB::name('enrollment')->insertAll($enrollment);
            $admin_id = DB::name('admin')->order('admin_id','desc')->value('admin_id');
            $admin_id = $admin_id ?? 0;
            foreach($enrollment as $ek => $ev)
            {
                $admin_id++;
                $admin_username = 'gdaib'.str_pad($admin_id,3,"0",STR_PAD_LEFT);
                AdminModel::add($admin_username,'','123456','','',input('admin_open',1),'',3,$ev['school_id'],json_encode(array('0' => trim($ev['major_ids'],','))));
            }
            foreach ($new_recruit_majors as $nrmk => $recruit_major)
            {
                $admin_username = $pinyin->permalink($recruit_major['recruit_major_name'],'');
                AdminModel::add($admin_username,'','123456','','',input('admin_open',1),'',4,0,0,$recruit_major['recruit_major_id']);
            }
            echo 'success';exit;
            //    var_dump($recruit_major);exit;
            echo '-----------------------------------错误-----------------------------------';
            var_dump($errors);
            echo '--------------------------------高职专业--------------------------------------';
            var_dump($recruit_major);
            echo '--------------------------------中职专业--------------------------------------';
            var_dump($major);
            echo '------------------------------中职学校----------------------------------------';
            var_dump($schools);
            echo '------------------------------招生计划----------------------------------------';
            var_dump($enrollment);exit;
        }
    }
	public function export_enrollment()
	{
		$enrollments = Db::name('enrollment')->alias('e')
							->join(config('database.prefix').'recruit_major rm','e.recruit_major_id = rm.recruit_major_id')
							->join(config('database.prefix').'school s','e.school_id = s.school_id')
                            ->where(get_year_where())
                            ->order('e.enrollment_id','asc')
							->select();
		foreach ($enrollments as $key => $enrollment) {
			$major_ids = explode(',',$enrollment['major_ids']);
			$major_ids = array_filter($major_ids);
			$majors = Db::name('major')->where(array('major_id' => array('in',$major_ids)))->select();
			$major_desc = '';
			foreach ($majors as $k => $major) {
				$major_desc.= $major['major_name'] . '(' . $major['major_code'] . ') ';
			}
			$enrollments[$key]['majors'] = $majors;
			$enrollments[$key]['major_desc'] = $major_desc;
		}
		$data = $enrollments;
        $field_titles = ['对口中职学校名称','高职专业名称','高职专业代码','对口中职专业名称(含代码)','招生计划数'];
        $fields = ['school_name','recruit_major_name','recruit_major_code','major_desc','enrollment_number'];
        $table = '招生计划表'.date('YmdHis');
        error_reporting(E_ALL);
        date_default_timezone_set('Asia/chongqing');
        $objPHPExcel = new \PHPExcel();
        //import("Org.Util.PHPExcel.Reader.Excel5");
        /*设置excel的属性*/
        $objPHPExcel->getProperties()->setCreator("wuzhijie")//创建人
        ->setLastModifiedBy("wuzhijie")//最后修改人
        ->setKeywords("excel")//关键字
        ->setCategory("result file");//种类

        //第一行数据
        $objPHPExcel->setActiveSheetIndex(0);
        $active = $objPHPExcel->getActiveSheet();
        foreach($field_titles as $i=>$name){
            $ck = num2alpha($i++) . '1';
            $active->setCellValue($ck, $name);
        }
        //填充数据
        foreach($data as $k => $v){
            $k=$k+1;
            $num=$k+1;//数据从第二行开始录入
            $objPHPExcel->setActiveSheetIndex(0);
            foreach($fields as $i=>$name){
                $ck = num2alpha($i++) . $num;
                $active->setCellValue($ck, $v[$name]);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle($table);
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$table.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
	}
}
