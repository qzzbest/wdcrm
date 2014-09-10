<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询渠道操作
 */
class Administration_marketing_specialist_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('marketing_specialist');
	}
	/**
	 * 渠道列表
	 */
	public function index()
	{

		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=10;
		$start=($page-1)*$limit;

		$this->load->model('marketing_specialist_model');
		
		$info= $this->marketing_specialist_model->select($start,$limit);


		#分页类
		$this->load->library('pagination');

		$config['base_url']=site_url(module_folder(1).'/consultant_channel/index?');
	
		$config['total_rows'] =$this->marketing_specialist_model->count();
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
		$this->load->view('marketing_specialist_list',$data);
	}


	/**
	 * 添加渠道
	 */
	public function add(){

		$check=array(
			array('marketing_specialist_name','市场专员')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){

	   		#指定模板输出
			$this->load->view('marketing_specialist_add');
	  	}else{
			$marketing_specialist_name = $this->input->post("marketing_specialist_name");
			$marketing_specialist_desc = $this->input->post("marketing_specialist_desc");

			$marketing_specialist=$this->main_data_model->getAll("marketing_specialist_name");			
			for($i=0;$i<count($marketing_specialist);$i++){
				if($marketing_specialist[$i]['marketing_specialist_name'] == $marketing_specialist_name){
					show_message('市场专员已存在');
				}
			}

			$data=array(
				'marketing_specialist_name'=>$marketing_specialist_name,
				'marketing_specialist_desc'=>$marketing_specialist_desc
			);
		
	  		$this->main_data_model->insert($data);			
			redirect(module_folder(1).'/marketing_specialist/index');	
		}	

	}

	/**
	 * 检查咨询形式是否已重复
	 */
	public function check()
	{
		$check= $this->input->post('value');

		$id=$this->input->post('id');

		$this->load->model('marketing_specialist_model','marketing_specialist');

		$res=$this->marketing_specialist->check($check,$id);

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

			$marketing_specialist_id = $this->input->post('marketing_specialist_id');
			$marketing_specialist_name = $this->input->post("marketing_specialist_name");
			$marketing_specialist_desc = $this->input->post("marketing_specialist_desc");
			
			$where = "`marketing_specialist_id` != ".$marketing_specialist_id;
			$marketing_specialist=$this->main_data_model->getOtherAll('marketing_specialist_name',$where,"marketing_specialist");
			for($i=0;$i<count($marketing_specialist);$i++){
				if($marketing_specialist[$i]['marketing_specialist_name'] == $marketing_specialist_name){
					show_message('咨询渠道已存在');
				}
			}
			
			$data=array(
				'marketing_specialist_name'=>$marketing_specialist_name,
				'marketing_specialist_desc'=>$marketing_specialist_desc
			);
		
	  		$this->main_data_model->update("marketing_specialist_id = '{$marketing_specialist_id}'",$data);
			redirect(module_folder(1).'/marketing_specialist/index');
		}
		$marketing_specialist_id = $this->uri->segment(5,0);	
		$info=$this->main_data_model->getOne("marketing_specialist_id = '{$marketing_specialist_id}'");
		$data=array(
			'info'=>$info
			);
		$this->load->view('marketing_specialist_edit',$data);

	}
	/**
	 * 修改启用、未启用的状态值
	 */
	public function changeStatus()
	{
		$id= $this->input->post("id");

		$status= $this->input->post("status");
		if($id){
			$where=array('marketing_specialist_id'=>$id);
			$data=array(
				'marketing_specialist_status'=>$status
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