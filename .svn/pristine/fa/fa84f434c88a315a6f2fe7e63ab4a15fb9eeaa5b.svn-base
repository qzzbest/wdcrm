<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者咨询形式
 */
class Administration_counselor_consultate_modus_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('counselor_consultate_modus');
	}
	/**
	 * 咨询形式列表
	 */
	public function index()
	{
		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=10;
		$start=($page-1)*$limit;

		$this->load->model('counselor_consultate_modus_model','counselor_consultate_modus');
		
		$info= $this->counselor_consultate_modus->select($start,$limit);


		#分页类
		$this->load->library('pagination');

		$config['base_url']=site_url(module_folder(1).'/counselor_consultate_modus/index?');
	
		$config['total_rows'] =$this->counselor_consultate_modus->count();
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
		$this->load->view('counselor_consultate_modus_list',$data);
		
	}
	public function add()
	{

		$check=array(
			array('consultant_consultate_name','咨询形式')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			
	   		$this->load->view('counselor_consultate_modus_add');

	  	}else{
			$name = $this->input->post("consultant_consultate_name");
			$value = $this->input->post("desc");
			
			$data=array(
				'consultant_consultate_name'=>$name,
				'consultant_consultate_desc'=>$value
			);
		
	  		$res= $this->main_data_model->insert($data);	
	  	
	  		if ($res) {
				show_message('添加成功!',site_url(module_folder(1).'/counselor_consultate_modus/index'));	
			}else{
				show_message('添加失败!');	
			}
			
		}
		
	}
	/**
	 * 检查咨询形式是否已重复
	 */
	public function check()
	{
		$check= $this->input->post('value');

		$id=$this->input->post('id');

		$this->load->model('counselor_consultate_modus_model','counselor_consultate_modus');

		$res=$this->counselor_consultate_modus->check($check,$id);

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
			array('consultant_consultate_name','咨询形式'),
			array('id','咨询形式id')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			
			$id = $this->uri->segment(5,0);
			$where=array('consultant_consultate_id'=>$id);
			$res=$this->main_data_model->getOne($where);

			$data=array(
				'info'=>$res
			);

	   		$this->load->view('counselor_consultate_modus_edit',$data);

	  	}else{
			$name  = $this->input->post("consultant_consultate_name");
			$value = $this->input->post("desc");
			$id    = $this->input->post("id");
			
			$where=array('consultant_consultate_id'=>$id);
			$data=array(
				'consultant_consultate_name'=>$name,
				'consultant_consultate_desc'=>$value
			);
		
	  		$this->main_data_model->update($where,$data);	
	  	
	  		
			show_message('编辑成功!',site_url(module_folder(1).'/counselor_consultate_modus/index'));	
			
			
		}
	}
	/**
	 * 修改启用、未启用的状态值
	 */
	public function changeStatus()
	{
		$id= $this->input->post("id");

		$status= $this->input->post("status");

		if($id){
			$where=array('consultant_consultate_id'=>$id);
			$data=array(
				'consultant_consultate_status'=>$status,
			);
			$res=$this->main_data_model->update($where,$data);
			if ($res) {
				echo json_encode(array('result'=>1));
				die;
			}

		}

		echo json_encode(array('result'=>0));
		die;
	}
}