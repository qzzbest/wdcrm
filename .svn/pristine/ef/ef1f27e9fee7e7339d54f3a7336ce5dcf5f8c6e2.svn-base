<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生操作
 */
class Common_student_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
		$this->main_data_model->setTable('student');
	}

	public function index()
	{
		header('Content-Type:text/html;charset=UTF-8');
		#查询所有咨询者或者学生对应的咨询师
		#搜索分类
		$data['seach'] = $search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
		if(!empty($search)){
			$count_where = array('consultant_name'=>$search,'show_status !='=>0);
			$data['count'] = $this->main_data_model->count($count_where,'consultant');

			if($data['count']>1){
				$data['con_info'] = $this->main_data_model->getOtherAll('*',$count_where,'consultant');
			}else{
				$data['con_info'] = $this->main_data_model->getOne($count_where,'*','consultant');
				$employee_where = array('employee_id'=>$data['con_info']['employee_id']);
				$employee_info = $this->main_data_model->getOne($employee_where,'*','employee');
				$data['con_info']['employee_name']=$employee_info['employee_name'];
			}
			if(empty($data['con_info'])){
				show_message('找不到对应的咨询师！');
			}else{
				$this->load->view('employee_info',$data);
			}

		}else{
			show_message('请输入姓名！');
		}	
	}
	public function add()
	{
		
		
	}
	public function edit()
	{
		
	}
	public function delete()
	{
		
	}
	
}