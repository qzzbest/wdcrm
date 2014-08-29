<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询渠道操作
 */
class Administration_consultant_channel_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('consultant_channel');
	}
	/**
	 * 渠道列表
	 */
	public function index()
	{

		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=10;
		$start=($page-1)*$limit;

		$this->load->model('consultant_channel_model');
		
		$info= $this->consultant_channel_model->select($start,$limit);


		#分页类
		$this->load->library('pagination');

		$config['base_url']=site_url(module_folder(1).'/consultant_channel/index?');
	
		$config['total_rows'] =$this->consultant_channel_model->count();
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
		$this->load->view('consultant_channel_list',$data);
	}


	/**
	 * 添加渠道
	 */
	public function add(){

		$check=array(
			array('consultant_channel_name','咨询渠道')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){

	   		#指定模板输出
			$this->load->view('consultant_channel_add');
	  	}else{
			$consultant_channel_name = $this->input->post("consultant_channel_name");
			$consultant_channel_desc = $this->input->post("consultant_channel_desc");

			$consultant_channel=$this->main_data_model->getAll("consultant_channel_name");			
			for($i=0;$i<count($consultant_channel);$i++){
				if($consultant_channel[$i]['consultant_channel_name'] == $consultant_channel_name){
					show_message('咨询渠道已存在');
				}
			}

			$data=array(
				'consultant_channel_name'=>$consultant_channel_name,
				'consultant_channel_desc'=>$consultant_channel_desc
			);
		
	  		$this->main_data_model->insert($data);			
			redirect(module_folder(1).'/consultant_channel/index');	
		}	

	}

	/**
	 * 检查咨询形式是否已重复
	 */
	public function check()
	{
		$check= $this->input->post('value');

		$id=$this->input->post('id');

		$this->load->model('consultant_channel_model','consultant_channel');

		$res=$this->consultant_channel->check($check,$id);

		if($res){
			echo json_encode(array('status'=>1));
			die;
		}

		echo json_encode(array('status'=>2));
		die;
	}

	/**
	 * 编辑渠道
	 */
	public function edit(){

		if(isset($_POST['dosubmit'])){

			$consultant_channel_id = $this->input->post('consultant_channel_id');
			$consultant_channel_name = $this->input->post("consultant_channel_name");
			$consultant_channel_desc = $this->input->post("consultant_channel_desc");
			
			$where = "`consultant_channel_id` != ".$consultant_channel_id;
			$consultant_channel=$this->main_data_model->getOtherAll('consultant_channel_name',$where,"consultant_channel");
			for($i=0;$i<count($consultant_channel);$i++){
				if($consultant_channel[$i]['consultant_channel_name'] == $consultant_channel_name){
					show_message('咨询渠道已存在');
				}
			}
			
			$data=array(
				'consultant_channel_name'=>$consultant_channel_name,
				'consultant_channel_desc'=>$consultant_channel_desc
			);
		
	  		$this->main_data_model->update("consultant_channel_id = '{$consultant_channel_id}'",$data);
			redirect(module_folder(1).'/consultant_channel/index');
		}
		$consultant_channel_id = $this->uri->segment(5,0);	
		$info=$this->main_data_model->getOne("consultant_channel_id = '{$consultant_channel_id}'");
		$data=array(
			'info'=>$info
			);
		$this->load->view('consultant_channel_edit',$data);

	}
	/**
	 * 修改启用、未启用的状态值
	 */
	public function changeStatus()
	{
		$id= $this->input->post("id");

		$status= $this->input->post("status");

		if($id){
			$where=array('consultant_channel_id'=>$id);
			$data=array(
				'consultant_channel_status'=>$status,
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