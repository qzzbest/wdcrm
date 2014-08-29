<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 知识点操作
 */
class Administration_knowledge_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('knowledge');
	}
	/**
	 * 知识点列表
	 */
	public function index()
	{

		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=10;
		$start=($page-1)*$limit;

		$this->load->model('knowledge_model');
		
		$knowledge= $this->knowledge_model->select($start,$limit);

		#分页类
		$this->load->library('pagination');

		$config['base_url']=site_url(module_folder(1).'/knowledge/index?');
	
		$config['total_rows'] =$this->knowledge_model->count();
		$config['per_page']   = $limit; 

		$config['uri_segment']= 5;
		$config['num_links']  = 5;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();


		#赋值
		$data=array(

			'list'=>$knowledge,
			'page'=>$page

		);

		#指定模板输出
		$this->load->view('knowledge_list',$data);
	}

	public function add()
	{
		if (isset($_POST['dosubmit'])){
			$check=array(
				array('knowledge_name','知识点'),
				array('knowledge_order','知识点排序')
			);
			check_form($check);

			$knowledge_name = $this->input->post("knowledge_name");
			$knowledge_lesson = intval($this->input->post("knowledge_lesson"));
			$knowledge_order = intval($this->input->post("knowledge_order"));
			
			$data=array(
				'knowledge_name'=>$knowledge_name,
				'knowledge_lesson'=>$knowledge_lesson,
				'knowledge_order'=>$knowledge_order,
			);
	  		
	  		$this->main_data_model->insert($data);
	  			
			redirect(module_folder(1).'/knowledge/index');	
		}
		$this->load->view('knowledge_add');	
	}

	public function edit()
	{
		if (isset($_POST['dosubmit'])){
			$check=array(
				array('knowledge_name','知识点'),
				array('knowledge_order','知识点排序')
			);
			check_form($check);

			$knowledge_id = $this->input->post("knowledge_id");

			$knowledge_name = $this->input->post("knowledge_name");
			$knowledge_lesson = intval($this->input->post("knowledge_lesson"));
			$knowledge_order = intval($this->input->post("knowledge_order"));
			
			$data=array(
				'knowledge_name'=>$knowledge_name,
				'knowledge_lesson'=>$knowledge_lesson,
				'knowledge_order'=>$knowledge_order,
			);
			
			$this->main_data_model->update("knowledge_id = '{$knowledge_id}'",$data);
				
			redirect(module_folder(1).'/knowledge/index');	
		}

		$id = $this->uri->segment(5,0);
		$data['info']=$this->main_data_model->getOne(array('knowledge_id'=>$id),'*','knowledge');
		$this->load->view('knowledge_edit',$data);		

	}

	public function check(){
		header("Content-Type:text/html;charset=utf-8");

		$value = $this->input->post('value');
		$id = $this->input->post('id');
		
		$this->load->model('knowledge_model','knowledge');
		$res=$this->knowledge->check($value,$id);

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	
	/**
	 * 设置启用与未启用
	 */
	public function changeStatus()
	{
		$id= $this->input->post("id");

		$status= $this->input->post("status");

		if($id){
			$where=array('knowledge_id'=>$id);
			$data=array(
				'knowledge_status'=>$status,
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