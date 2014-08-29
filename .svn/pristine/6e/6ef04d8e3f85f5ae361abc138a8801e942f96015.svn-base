<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 知识点操作
 */
class Teaching_classroom_type_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('classroom_type');
		$this->load->model('classroom_type_model','classroom_type');
	}
	
	public function index()
	{	
		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;;
		$limit=10;
		$start=($page-1)*$limit;	
		
		$list = $this->classroom_type->select_class_type($start,$limit);

		foreach ($list as $key => $value) {
			$list[$key]['course_name'] = $this->classroom_type->select_knowledge($value['classroom_type_id']);
		}

		$count = $this->classroom_type->select_count();
		
		#分页类
		$this->load->library('pagination');

		$config['base_url']=site_url(module_folder(4).'/classroom_type/index?');
	
		$config['total_rows'] = $count;
		$config['per_page']   = $limit; 

		$config['uri_segment']= 5;
		$config['num_links']  = 5;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();


		#赋值
		$data=array(

			'list'=>$list,
			'page'=>$page

		);

		#指定模板输出
		$this->load->view('classroom_type_list',$data);	
	}

	public function add()
	{
		
		if (isset($_POST['dosubmit'])){
			//验证
			$check=array(
				array('knowledge_ids','知识点'),
				array('classroom_type_name','班级类型')
			);
			check_form($check);

			//接收
			$type['classroom_type_name'] = $this->input->post("classroom_type_name");
			$knowledge_ids = $this->input->post("knowledge_ids");

			//添加课程
			$res=$this->main_data_model->insert($type,'classroom_type');

			//更新知识点表的id
			$knowledge_where = db_create_in($knowledge_ids,'knowledge_id');
			$status = array('classroom_type_id'=>$res);
			$this->main_data_model->update($knowledge_where,$status,'knowledge');

			redirect(module_folder(4).'/classroom_type/index');	
		}
		//查询课程下的知识点
		$where=array('knowledge_status'=>1,'classroom_type_id'=>0);
		$list=$this->main_data_model->getOtherAll('*',$where,'knowledge');

		$data=array(
			'list'=>$list,
			);
		$this->load->view('classroom_type_add',$data);	
	}

	public function edit()
	{
		if (isset($_POST['dosubmit'])){
			$check=array(
				//array('knowledge_ids','知识点'),
				array('classroom_type_name','班级类型')
			);
			check_form($check);

			$classroom_type_id = $this->input->post("id");
			$classroom_type_name = $this->input->post("classroom_type_name");
			$knowledge_ids = $this->input->post("knowledge_ids");

			
			$where = array('classroom_type_id'=>$classroom_type_id);
			//更新课程名字
			$name = array('classroom_type_name'=>$classroom_type_name);
			$res=$this->main_data_model->update($where,$name,'classroom_type');

			//如果查出的知识点是空的就直接更新为0
			if(empty($knowledge_ids)){
				$where = array('knowledge_status'=>1,'classroom_type_id'=>$classroom_type_id);
				$list = $this->main_data_model->getOtherAll('knowledge_id',$where,'knowledge');

				$empty_status=array('classroom_type_id'=>0);
				foreach ($list as $value) {
					$empty_knowledge=array('knowledge_id'=>$value['knowledge_id']);
					$this->main_data_model->update($empty_knowledge,$empty_status,'knowledge');
				}
				
			}
			//把提交上来的更新为对应的类型id
			if(is_array($knowledge_ids)){
				$add_status=array('classroom_type_id'=>$classroom_type_id);
				foreach ($knowledge_ids as $value) {
					$add_knowledge=array('knowledge_id'=>$value);
					$this->main_data_model->update($add_knowledge,$add_status,'knowledge');
				}
			}

			//查询之前以选中的知识点，如果去掉了，状态更新为0
			//先查出原有的知识点	
			$where = array('knowledge_status'=>1,'classroom_type_id'=>$classroom_type_id);
			$list = $this->main_data_model->getOtherAll('knowledge_id',$where,'knowledge');

			$all = array();
			foreach ($list as $value) {
				$all[] = $value['knowledge_id'];
			}
			$result = array_diff($all,$knowledge_ids);
			//更新
			if(!empty($result)){

				$del_status=array('classroom_type_id'=>0);
				foreach ($result as $value) {
					$del_knowledge=array('knowledge_id'=>$value);
					$this->main_data_model->update($del_knowledge,$del_status,'knowledge');
				}
				
			}

			redirect(module_folder(4).'/classroom_type/index');	
		}

		$type_id = $this->uri->segment(5,0);
		//查课程类型和对应的知识点表
		$class_type = $this->classroom_type->select_one($type_id);
		$knowledge['course'] = $this->classroom_type->select_knowledge($type_id);
		
		$info = array_merge($class_type,$knowledge);

		//查询全部未分配的知识点
		$all_knowledge = $this->classroom_type->select_all_knowledge($type_id);

		$data=array(
			'info'=>$info,
			'all_knowledge'=>$all_knowledge,
			);
		$this->load->view('classroom_type_edit',$data);	
	}

	
	/*public function delete()
	{
		
		$type_id= $this->input->post('id');

		//删除班级类型
		$result = $this->main_data_model->delete(array('classroom_type_id',$type_id),2,'classroom_type');
		
		#修改知识点与班级类型的关系
		$where = db_create_in($type_id,'classroom_type_id');
		$status = array('classroom_type_id'=>0);
		$this->main_data_model->update($where,$status,'knowledge');

		if($result>0){
  			show_message('删除成功!',site_url(module_folder(4).'/classroom_type/index'));	
  		}else{
  			show_message('操作失败!');
  		}
	}*/
	/**
	 * 启用，禁用
	 */
	public function changeStatus()
	{
		$id= $this->input->post("id");
		$status= $this->input->post("status");

		if($id){
			$where=array('classroom_type_id'=>$id);
			$data=array(
				'type_status'=>$status,
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
	//ajax判断是否重名
	public function check(){
		header("Content-Type:text/html;charset=utf-8");

		$value = $this->input->post('value');
		$id = $this->input->post('id');
	
		$res=$this->classroom_type->check($value,$id);

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
}