<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者员工职位
 */
class Administration_employee_job_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('employee_job');
	}
	/**
	 * 员工职位列表
	 */
	public function index()
	{
		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=10;
		$start=($page-1)*$limit;

		$this->load->model('employee_job_model');
		
		$info= $this->employee_job_model->select($start,$limit);


		#分页类
		$this->load->library('pagination');

		$config['base_url']=site_url(module_folder(1).'/employee_job/index?');
	
		$config['total_rows'] =$this->employee_job_model->count();
		$config['per_page']   = $limit; 

		$config['uri_segment']= 5;
		$config['num_links']  = 5;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();


		#赋值
		$data=array(

			'list'=>$info,
			'page'=>$page

		);

		#指定模板输出
		$this->load->view('employee_job_list',$data);
		
	}
	public function add()
	{

		$check=array(
			array('employee_job_name','职位名称')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			
	   		$this->load->view('employee_job_add');

	  	}else{
			$name = $this->input->post("employee_job_name");
			$value = $this->input->post("desc");
			
			$data=array(
				'employee_job_name'=>$name,
				'employee_job_desc'=>$value
			);
		
	  		$res= $this->main_data_model->insert($data);	
	  	
	  		if ($res) {
				show_message('添加成功!',site_url(module_folder(1).'/employee_job/index'));	
			}else{
				show_message('添加失败!');	
			}
			
		}
		
	}
	/**
	 * 检查员工职位是否已重复
	 */
	public function check()
	{
		$check= $this->input->post('value');

		$id=$this->input->post('id');

		$this->load->model('employee_job_model');

		$res=$this->employee_job_model->check($check,$id);

		if($res){
			echo json_encode(array('status'=>1));
			die;
		}

		echo json_encode(array('status'=>2));
		die;
	}
	/**
	 * 修改
	 */
	public function edit()
	{
		$check=array(
			array('employee_job_name','职位名称'),
			array('id','员工职位id')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			
			$id = $this->uri->segment(5,0);
			$where=array('employee_job_id'=>$id);
			$res=$this->main_data_model->getOne($where);

			$data=array(
				'info'=>$res
			);

	   		$this->load->view('employee_job_edit',$data);

	  	}else{
			$name  = $this->input->post("employee_job_name");
			$value = $this->input->post("desc");
			$id    = $this->input->post("id");
			
			$where=array('employee_job_id'=>$id);
			$data=array(
				'employee_job_name'=>$name,
				'employee_job_desc'=>$value
			);
		
	  		$this->main_data_model->update($where,$data);	
	  	
	  		
			show_message('编辑成功!',site_url(module_folder(1).'/employee_job/index'));	
			
			
		}
	}
	/**
	 * 删除
	 */
	public function delete()
	{
		$id = $this->uri->segment(5,0);

		if($id){
			$where=array('employee_job_id'=>$id);
			$res=$this->main_data_model->delete($where,1);
			if ($res) {
				show_message('删除成功!',site_url(module_folder(1).'/employee_job/index'));	
			}

		}

		show_message('删除失败!',site_url(module_folder(1).'/employee_job/index'));	
	}
}