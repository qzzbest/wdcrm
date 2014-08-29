<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者操作
 */
class Advisory_achieve_statistics_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
	}

	/*
	 * 业绩统计(学员缴费统计)
	 */
	public function index()
	{
		#查还款表：crm_refund_loan_time
		$this->load->model('refund_loan_time_model','loan_time_model');
		$this->load->model('student_repayment_bills_model','student_repayment_bills');
		$this->load->model('p_employee_model');
		$this->load->model('consultant_channel_model');
		$this->load->model('marketing_specialist_model');

		#当前页码
		$data['cur_pag']= $page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		$limit=20;#每页显示多少条
		
		$start=($page-1)*$limit;

		//多个查询参数处理
		$param_url=array();

		#渠道ID
		$selectYear=trim($this->input->get('selectYear'))!=''?trim($this->input->get('selectYear')):'';

		#渠道ID
		$selectMonth=trim($this->input->get('selectMonth'))!=''?trim($this->input->get('selectMonth')):'';

		#渠道ID
		$data['channel_id']=$channel_id=trim($this->input->get('channel_id'))!=''?trim($this->input->get('channel_id')):'';

		#市场专员
		$data['statistics_id']=$statistics_id=trim($this->input->get('statistics_id'))!=''?trim($this->input->get('statistics_id')):'';

		#学生姓名
		$data['search_name']=$search_name=trim($this->input->get('search_name'))!=''?trim($this->input->get('search_name')):'';
		$param_url['search_name']=$search_name;
		//echo $data['search_name'];

		#咨询师
		$data['selected_teach']=$selected_teach=trim($this->input->get('teach'))!=''?trim($this->input->get('teach')):'';

		if(!empty($selectYear) && !empty($selectMonth)){
			$data['selectYear'] = $selectYear;
			$data['selectMonth'] = $selectMonth;
		}else if(!empty($selectYear) && empty($selectMonth)){
			$data['selectYear'] = $selectYear;
			$data['selectMonth'] = date('m',time());
		}else if(empty($selectYear) && !empty($selectMonth)){
			$data['selectYear'] = date('Y',time());
			$data['selectMonth'] = $selectMonth;
		}else{
			$data['selectYear'] = date('Y',time());
			$data['selectMonth'] = date('m',time());
		}

		$date = $data['selectYear'].'-'.$data['selectMonth'];
		$arr = AssignTabMonth($date,0);

		$start_search_time = strtotime($arr['first_date']);		
		$end_search_time = strtotime($arr['last_date']);		

		$param_url['channel_id']=$channel_id;
		$param_url['statistics_id']=$statistics_id;
		$param_url['teach']=$selected_teach;
		$param_url['selectYear']=$data['selectYear'];
		$param_url['selectMonth']=$data['selectMonth'];

		#接收日期
		$data['starttime'] = $starttime = $this->input->get('start_time') ? $this->input->get('start_time'):'';
		$data['endtime'] = $endtime = $this->input->get('end_time') ? $this->input->get('end_time'):'' ;

		if(!empty($starttime)){
			$start_time = strtotime($starttime);
			$param_url['start_time']=$starttime;
		}else{
			$start_time = '';
		}

		if(!empty($endtime)){
			$end_time = strtotime($endtime.'23:59:59');
			$param_url['end_time']=$endtime;
		}else{
			$end_time = '';
		}

		#查渠道表信息
		$this->load->model('consultant_channel_model');
		$data['consultant_channel'] = $this->consultant_channel_model->getAll();

		#市场专员
		$this->load->model('employee_model');
		$data['marketing_specialist'] = $this->employee_model->selectEmployee(18);

		#咨询师
		$this->load->model('employee_model');
		$data['teach']= $this->employee_model->selectDepartment();
		
		$data['count_money'] = $this->loan_time_model->countMoney($start_search_time,$end_search_time,$channel_id,$statistics_id,$selected_teach,$start_time,$end_time,$search_name);

		$field = 'student_repayment_bills.*,refund_loan_time.*,consultant.consultant_id,consultant.consultant_name,consultant.employee_id,consultant.consultant_channel_id,consultant.marketing_specialist_id';
		
		$loan_time_info = $this->loan_time_model->select_refund_loan($field,$start,$limit,$start_search_time,$end_search_time,$channel_id,$statistics_id,$selected_teach,$start_time,$end_time,$search_name);

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数

		//$total_page = floor($count/$limit) != 0 ? floor($count/$limit) : 1;//总共多少页

		$number = array();
		for($i=$begin;$i<=$total;$i++){
			$number[]=$i;//当前页的每个值赋给数组
		}

		foreach ($loan_time_info as $key => $value) {
			#序号
			$loan_time_info[$key]['serial_number']=$number[$key];//每条数据对应当前页的每一个值

			#查询咨询师信息
			$employee_info = $this->p_employee_model->selectEmployee($value['employee_id']);

			$channel_info = $this->consultant_channel_model->getOne($value['consultant_channel_id']);

			$specialist_info = $this->p_employee_model->selectEmployee($value['marketing_specialist_id']);

			$this->load->model('student_model');
			$where = array('consultant_id'=>$value['consultant_id']);
			$student_info = $this->student_model->getStudentInfo('student_id',$where);

			if($student_info){ #报读课程
				$loan_time_info[$key]['courseInfo'] = $this->getCourseInfo($value['repayment_id'],$student_info['student_id']);
			}else{
				$loan_time_info[$key]['courseInfo'] = '';
			}   
			#客户项目
			$loan_time_info[$key]['projectInfo'] = $this->getProjectInfo($value['repayment_id'],$value['consultant_id']);		

			$loan_time_info[$key]['employee_name'] = $employee_info['employee_name'];

			#缴费数额，是否缴清
			$loan_time_info[$key]['study_expense'] = $value['study_expense'];
			$loan_time_info[$key]['already_payment'] = $value['already_payment'];
			
			if(!empty($channel_info)){
				$loan_time_info[$key]['consultant_channel_name'] = $channel_info['consultant_channel_name'];
			}
			if(!empty($specialist_info)){
				$loan_time_info[$key]['marketing_specialist_name'] = $specialist_info['employee_name'];
			}

			#是否缴清
			$paywhere = ' and t.`already_paytime` <= '.$value['already_paytime'].' and t.`repayment_id` = '.$value['repayment_id'];
			$loan_info = $this->loan_time_model->count_refund_loan($paywhere,$start_search_time,$end_search_time,$channel_id,$statistics_id,$selected_teach,$start_time,$end_time);

			$loan_time_info[$key]['difference'] = $value['study_expense'] - $loan_info;		
		}

		$count = $this->loan_time_model->select_refund_count($start_search_time,$end_search_time,$channel_id,$statistics_id,$selected_teach,$start_time,$end_time,$search_name);

		#分页类
		$this->load->library('pagination');

		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url);
	
		$config['total_rows'] = $count;
		$config['per_page']   = $limit; 

		$config['uri_segment']= 5;
		$config['num_links']  = 5;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();

		#赋值
		$data['adviachieve_info']=array(
			'list'=>$loan_time_info,
			'page'=>$page
		);

		#指定模板
		$this->load->view('adviachieve_statistic_list',$data);
	}

	/**
	 * 获取报读课程信息
	 */
	private function getCourseInfo($payid,$student_id)
	{
		$this->load->model('stu_curriculum_model','stu_curriculum');
		$this->load->model('stu_knowleage_model','stu_knowleage');
		//查看课程
		$c_sql = "SELECT * FROM ".$this->db->dbprefix('student_curriculum_relation')." AS stu_c LEFT JOIN ".$this->db->dbprefix('curriculum_system')." AS cur_s ON stu_c.curriculum_system_id = cur_s.curriculum_system_id WHERE stu_c.student_id = $student_id AND stu_c.repayment_id = ".$payid;
		$curriculum_info = $this->stu_curriculum->getStuCourse($c_sql);

		//查看知识点
		$k_sql = "SELECT * FROM ".$this->db->dbprefix('student_knowleage_relation')." AS stu_k LEFT JOIN ".$this->db->dbprefix('knowledge')." AS know ON stu_k.knowledge_id = know.knowledge_id WHERE stu_k.student_id = $student_id AND stu_k.repayment_id = ".$payid;
		$knowleage_info = $this->stu_knowleage->getStuKnowleage($k_sql);

		$str = '';
		if($curriculum_info && $knowleage_info){
			$str = '报读课程：';
			foreach ($curriculum_info as $k => $v) {
				$str .= $v['curriculum_system_name'].'&nbsp;&nbsp;&nbsp;';
			}

			$str .= '<br />';

			$str .= '知识点：';
			foreach ($knowleage_info as $kk => $vv) {
				$str .= $vv['knowledge_name'].'&nbsp;&nbsp;&nbsp;';
			}
		}	

		return $str;
	}

	/**
	 * 获取客户的项目信息
	 */
	private function getProjectInfo($payid,$consultant_id)
	{
		$this->load->model('client_project_model');
		$where = array('repayment_id'=>$payid,'consultant_id'=>$consultant_id);
		$project_info = $this->client_project_model->select_one('*',$where);
		$str = '';
		if($project_info){
			$str = '项目名称：'.$project_info['project_name'].'<br />项目地址：<a href="'.$project_info['project_url'].'" target="_blank">'.$project_info['project_url'].'</a>';
		}
		return $str;
	}

	/**
	 * 建立url地址
	 */
	private function _buildUrl($arr)
	{

		$param_url = "";
		foreach($arr as $key=>$val){
			if(trim($val)!=''){
				$param_url .= $key."=".$val."&";	
			}
		}
		$param_url = rtrim($param_url, "&");
		
		$urls =site_url(module_folder(2)."/achieve_statistics/index?".$param_url);
		
		return $urls;
	}
}