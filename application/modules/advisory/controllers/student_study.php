<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生操作
 */
class Advisory_student_study_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
	}

	public function index()
	{
		$data['act'] = $act = $this->uri->segment(5,'index');
		$data['student_id'] = $student_id = $this->uri->segment(6,0);
		//查询学生名字
		$where_student=array('student_id'=>$student_id);
		$data['student']=$this->main_data_model->getOne($where_student,'consultant_id,student_id,student_name
			','student');

		//查询手机号码、QQ号码
		$phone_qq_where = array('consultant_id'=>$data['student']['consultant_id'],'student_id'=>$data['student']['student_id']);
		$data['phone_infos'] = $this->main_data_model->getOtherAll('*',$phone_qq_where,'consul_stu_phones');

		$data['qq_infos'] = $this->main_data_model->getOtherAll('*',$phone_qq_where,'consul_stu_qq');

		#班级类型ID
		$data['classroom_type_id']=$classroom_type_id=trim($this->input->get('classroom_type_id'))!=''?trim($this->input->get('classroom_type_id')):'';

		#班级状态
		$data['state']=$state=trim($this->input->get('state'))!=''?trim($this->input->get('state')):'';

		#导航栏处理
		$this->menuProcess($act,$student_id);	

		switch ($act) {
			case 'index':
				$student_id = $data['student_id'];
				$this->load->model('p_student_model');
				$this->load->model('p_classroom_model');
				$this->load->model('p_classroom_student_model');
				$this->load->model('p_knowledge_model');
				$this->load->model('p_employee_model');
				
				#班级类型列表
				$this->load->model('p_classroom_type_model','classroom_type');
				$data['classroom_type']= $this->classroom_type->selectClassType();

				#查找班级类型
				$data['select_type']=trim($this->input->get('classtype'))!=''?trim($this->input->get('classtype')):'';

				#查找班级学生记录
				$get_where = array('student_id'=>$data['student_id']);
				$cls_stu_info = $this->p_classroom_student_model->classroom_student_info($get_where,'*');

				$num = 1;
				foreach ($cls_stu_info as $key => $value) {
					#序号
					$cls_stu_info[$key]['serial_number']=$num;//每条数据对应当前页的每一个值

					$classroom_where = array('classroom.classroom_id'=>$value['classroom_id']);
					if($classroom_type_id != ''){
						$classroom_where = $classroom_where+array('classroom.classroom_type_id'=>$classroom_type_id);
					}
					if($state != ''){
						$classroom_where = $classroom_where+array('classroom.class_status'=>$state);
					}
					$classroom_info = $this->p_classroom_model->classroom_info_all($classroom_where,'*');

					if(!empty($classroom_info)){
						$cls_stu_info[$key]['classroom_name'] = $classroom_info['classroom_name'];
						$cls_stu_info[$key]['open_classtime'] = date('Y-m-d',$classroom_info['open_classtime']);
						if(!empty($classroom_info['close_classtime'])){
							$cls_stu_info[$key]['close_classtime'] = date('Y-m-d',$classroom_info['close_classtime']);
						}else{
							$cls_stu_info[$key]['close_classtime'] = "";
						}	
						$cls_stu_info[$key]['classroom_type_name'] = $classroom_info['classroom_type_name'];
						$cls_stu_info[$key]['class_status'] = $classroom_info['class_status'];
						$cls_stu_info[$key]['classroom_group'] = $classroom_info['classroom_group'];

						$cls_stu_info[$key]['employee_info'] = $this->p_employee_model->selectEmployee($classroom_info['employee_id']);
						#获取班级课程进度
						$where = array('classroom_knowledge_relation.classroom_id'=>$value['classroom_id']);
						$cls_stu_info[$key]['cls_known'] = $this->p_classroom_model->classroom_knowledge_info($where,'*');
					}else{	
						unset($cls_stu_info[$key]);
					}

					$num ++;
				}

				$data['cls_stu_info'] = $cls_stu_info;
				break;
					
			case 'attendance':
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
				//接收班级
				$data['selectClass'] = trim($this->input->get('selectClass'))!=''?trim($this->input->get('selectClass')):'';
				#学员所在班级
				$this->load->model('classroom_model','classroom');
				$data['class'] = $this->classroom->student_class($student_id);
				//查找学生姓名
				$data['student'] = $this->main_data_model->getOne(array('student_id'=>$student_id),'student_name','student');
				//查找学生某个班级的考勤状况
				$this->load->model('student_attendance_score_model');
				$data['all'] = $this->student_attendance_score_model->select_check($student_id,$data['selectClass']);
				break;
			case 'exam':
				//成绩类型表查询
				$data['selectClass'] = trim($this->input->get('selectClass'))!=''?trim($this->input->get('selectClass')):'';
				
				$this->load->model('classroom_model','classroom');
				//考试类型
				$data['all_exam'] = $this->classroom->class_exam($data['selectClass']);
				#学员所在班级
				$data['class'] = $this->classroom->student_class($student_id);

				$this->load->model('student_attendance_score_model');
				$data['stu_exam'] = $this->student_attendance_score_model->select_all_score($student_id,$data['selectClass'] );
				break;
		}

		$this->load->view('student_study_list',$data);
	}
	/**
	 * 导航条处理
	 */
	private function menuProcess($act,$student_id)
	{	
		$url= unserialize(getcookie_crm('url'));
		
		$url[2]=array('就读情况',site_url(module_folder(2).'/student_study/index/'.$act.'/'.$student_id));

		$_COOKIE['url']= authcode(serialize($url),'ENCODE');

		setcookie_crm('url',serialize($url));

	}
}