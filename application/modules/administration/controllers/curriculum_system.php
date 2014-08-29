<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 知识点操作
 */
class Administration_curriculum_system_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('curriculum_system');
	}
	/**
	 * 课程列表
	 */
	public function index()
	{	
		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;;
		$limit=10;
		$start=($page-1)*$limit;

		$this->load->model('curriculum_system_model','curriculum_system');
		
		$curriculum_system= $this->curriculum_system->select($start,$limit);

		//课程体系和知识点
		
		foreach ($curriculum_system as $key => $value) {
			$curriculum_system[$key]['course_name'] = $this->curriculum_system->select_knowledge($value['curriculum_system_id']);
		}

		#分页类
		$this->load->library('pagination');

		$config['base_url']=site_url(module_folder(1).'/curriculum_system/index?');
	
		$config['total_rows'] =$this->curriculum_system->count();
		$config['per_page']   = $limit; 

		$config['uri_segment']= 5;
		$config['num_links']  = 5;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();


		#赋值
		$data=array(

			'list'=>$curriculum_system,
			'page'=>$page

		);

		#指定模板输出
		$this->load->view('curriculum_system_list',$data);	
	}

	public function add()
	{
		
		if (isset($_POST['dosubmit'])){
			$check=array(
				array('knowledge_ids','知识点'),
				array('curriculum_system_name','课程')
			);
			check_form($check);

			$course['curriculum_system_name'] = $this->input->post("curriculum_system_name");
			$knowledge_ids = $this->input->post("knowledge_ids");

			//添加课程
			$res=$this->main_data_model->insert($course,'curriculum_system');
			
			$knowledge = array();
			foreach ($knowledge_ids as $key => $value) {
				$knowledge[]=array(
					'curriculum_system_id'=>$res,
					'knowledge_id'=>$value
				);
			}
			//添加课程与知识点的关系	
			$this->main_data_model->insert_batch($knowledge,'curriculum_knowleage_relation');

			redirect(module_folder(1).'/curriculum_system/index');	
		}
		//查询课程下的知识点
		$where=array('knowledge_status'=>1);
		$list=$this->main_data_model->getOtherAll('*',$where,'knowledge');

		$data=array(
			'list'=>$list,
			);
		$this->load->view('curriculum_system_add',$data);	
	}

	public function edit()
	{
		if (isset($_POST['dosubmit'])){
			$check=array(
				array('knowledge_ids','知识点'),
				array('curriculum_system_name','课程')
			);
			check_form($check);

			$curriculum_system_id = $this->input->post("id");
			$course['curriculum_system_name'] = $this->input->post("curriculum_system_name");
			$knowledge_ids = $this->input->post("knowledge_ids");

			$where=array('curriculum_system_id'=>$curriculum_system_id);
			//更新课程名称
			$this->main_data_model->update($where,$course);
			
			//删除之前课程与知识点的关系
			$this->main_data_model->delete($where,1,'curriculum_knowleage_relation');

			$knowledge = array();
			foreach ($knowledge_ids as $key => $value) {
				$knowledge[]=array(
					'curriculum_system_id'=>$curriculum_system_id,
					'knowledge_id'=>$value
				);
			}
			//更新课程与知识点的关系	
			$this->main_data_model->insert_batch($knowledge,'curriculum_knowleage_relation');

			redirect(module_folder(1).'/curriculum_system/index');	
		}

		$id = $this->uri->segment(5,0);
		$this->load->model('curriculum_system_model','curriculum_system');
		//查询课程下的知识点
		$info = $this->curriculum_system->select_kid($id);
		//获取启用状态下的全部知识点
		$where=array('knowledge_status'=>1);
		$all = $this->main_data_model->getOtherAll('*',$where,'knowledge');
		//查询选中的知识点
		$this->load->model('curriculum_system_model','curriculum_system');
		$sel = $this->curriculum_system->select_knowledge1($id);

		//合并数组，循环得到并集
		$merge=array_merge($sel,$all);
		foreach ($merge as $key => $value) {
			$k = $value['knowledge_id'];
			$unique[$k] = $value['knowledge_name'];
		}
	
		$list = array_unique($unique);

		$data=array(
			'list'=>$list,
			'info'=>$info,
			);
		$this->load->view('curriculum_system_edit',$data);	
	}

	//ajax判断是否重名
	public function check(){
		header("Content-Type:text/html;charset=utf-8");

		$value = $this->input->post('value');
		$id = $this->input->post('id');
		
		$this->load->model('curriculum_system_model','curriculum_system');
		$res=$this->curriculum_system->check($value,$id);

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	
	public function changeStatus()
	{
		$id= $this->input->post("id");
		$status= $this->input->post("status");

		if($id){
			$where=array('curriculum_system_id'=>$id);
			$data=array(
				'curriculum_system_status'=>$status,
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