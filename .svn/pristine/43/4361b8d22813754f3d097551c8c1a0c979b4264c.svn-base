<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生操作
 */
class Teaching_student_attendance_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
		$this->main_data_model->setTable('student');
	}

	public function index()
	{
		$selectYear = trim($this->input->get('selectYear'))!=''?trim($this->input->get('selectYear')):'';
		$selectMonth = trim($this->input->get('selectMonth'))!=''?trim($this->input->get('selectMonth')):'';

		if($selectYear==''){
			$data['selectYear'] = date('Y',time());
		}else{
			$data['selectYear'] = $selectYear;
		}
		if($selectMonth==''){
			$data['selectMonth'] = date('m',time());
		}else{
			$data['selectMonth'] = $selectMonth;
		}
		//查询时间
		$data['dayinfo'] = getdaysinmonth($data['selectYear'],$data['selectMonth']);
		//接收学生id
		$data['student_id'] = $student_id = $this->uri->segment(5,0);
		//接收班级
		$data['selectClass'] = $classroom_id = trim($this->input->get('selectClass'))!=''?trim($this->input->get('selectClass')):'';
		#学员所在班级
		$this->load->model('classroom_model','classroom');
		$data['class'] = $this->classroom->student_all_class($student_id);
		//查找学生姓名
		$data['student'] = $this->main_data_model->getOne(array('student_id'=>$student_id),'student_name','student');
		//查找学生某个班级的考勤状况
		$this->load->model('student_attendance_score_model');
		$data['all'] = $this->student_attendance_score_model->select_check($student_id,$classroom_id);
		/*foreach ($data['all'] as $key => $value) {
			if(!empty($value['t_id'])){
				$part = explode(",",$value['t_id']);
				$status = explode(",",$value['s_id']);
				$remark = explode(",",$value['s_desc']);
				$data['all'][$key]['all_id'] = array_combine($part,$status);
				$data['all'][$key]['all_desc'] = array_combine($part,$remark);
			}	
		}*/
		$this->load->view('check_student_list',$data);
	}
}