<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_regulations_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->model('files_model');
		$this->load->model('regulations_model');
	}
	
	/**
	 * 显示规章制度列表
	 */
	public function index()
	{	

		$regulation_type = $this->uri->segment(5,1);

		if($regulation_type==1){
			$regulation_type_name = '公司行政管理制度';
		}else if($regulation_type==2){
			$regulation_type_name = '讲师岗位制度';
		}else if($regulation_type==3){
			$regulation_type_name = '咨询师岗位规范';
		}else if($regulation_type==4){
			$regulation_type_name = '先就业后付款申请注意事项';
		}else if($regulation_type==5){
			$regulation_type_name = '人事就业岗位规范';
		}else if($regulation_type==6){
			$regulation_type_name = '行政教务岗位规范';
		}

		$search_title=trim($this->input->get('search_title'))!=''?trim($this->input->get('search_title')):'';

		$page = $this->uri->segment(6,1);
		$limit=20;
		$start=($page-1)*$limit;

		$where = array('regulation_type'=>$regulation_type);

		#查询规章制度记录
		$regulations_info = $this->regulations_model->select('*',$start,$limit,$where,'',$search_title);

		foreach ($regulations_info as $key => $value) {
			$q_where = array('file_type'=>2,'file_type_cate'=>1,'type_id'=>$value['regulation_id']);
			$regulations_info[$key]['title_files'] = $this->files_model->select('*',$q_where);

			$a_where = array('file_type'=>2,'file_type_cate'=>2,'type_id'=>$value['regulation_id']);
			$regulations_info[$key]['content_files'] = $this->files_model->select('*',$a_where);
		}

		#统计规章制度记录总数
		$count = $this->regulations_model->select_count($where,'',$search_title);

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(5).'/regulations/index/'.$regulation_type);
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['uri_segment']= 6;
		$config['num_links'] = 6;
		//$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$data=array(
			'list'=>$regulations_info,
			'create_page'=>$create_page,
			'regulation_type'=>$regulation_type,
			'regulation_type_name'=>$regulation_type_name
			);
		$this->load->view('regulations_list',$data);
		
	}

	/**
	 * 添加规章制度
	 */
	public function add()
	{	

		if ( empty($_POST) ){

			$data['regulation_type'] = $this->uri->segment(5,1);

			if($data['regulation_type']==1){
				$data['regulation_type_name'] = '公司行政管理制度';
			}else if($data['regulation_type']==2){
				$data['regulation_type_name'] = '讲师岗位制度';
			}else if($data['regulation_type']==3){
				$data['regulation_type_name'] = '咨询师岗位规范常识';
			}else if($data['regulation_type']==4){
				$data['regulation_type_name'] = '先就业后付款申请注意事项';
			}else if($data['regulation_type']==5){
				$data['regulation_type_name'] = '人事就业岗位规范';
			}else if($data['regulation_type']==6){
				$data['regulation_type_name'] = '行政教务岗位规范';
			}

			//检查权限
			$url = site_url(module_folder(5).'/regulations/index/'.$data['regulation_type']);
			$this->_checkPower($url);

			$this->load->view('regulations_add',$data);
		
	  	}else{
	  		$regulation_title= trim($this->input->post("regulation_title")) ? trim($this->input->post("regulation_title")) : '';
	  		$regulation_content= trim($this->input->post("regulation_content")) ? trim($this->input->post("regulation_content")) : '';
	  		$regulation_type= trim($this->input->post("regulation_type")) ? trim($this->input->post("regulation_type")) : 1;

	  		#一定要规章制度标题
	  		if(!empty($regulation_title)){

	  			#规章制度标题
	  			if(!empty($regulation_title)){
	  				$check_where = array('regulation_title'=>$regulation_title,'regulation_type'=>$regulation_type);
		  			$check_info = $this->regulations_model->getOne('regulation_id',$check_where);

		  			if(!empty($check_info)){
		  				show_message('该标题已经添加过了！');
		  			}

		  			$add_data = array(
		  					'regulation_title'=>$regulation_title,
		  					'regulation_content'=>$regulation_content,
		  					'regulation_type'=>$regulation_type
		  				);

		  			$insert_id = $this->regulations_model->insert($add_data);
	  			}
	  			

	  			#上传规章制度图片
	  		// 	if($insert_id){

	  		// 		if( !file_exists('./upload/regulations/'.date('Y/m/d')) ){
					// 	mkdir('./upload/regulations/'.date('Y/m/d'),0777,true); //存放原图路径
					// }
					// if( !file_exists('./upload/answer/'.date('Y/m/d')) ){
					// 	mkdir('./upload/answer/'.date('Y/m/d'),0777,true); //存放原图路径
					// }

					// foreach ($_FILES['regulations_file_add']['name'] as $key => $value) {
					// 	if($_FILES['regulations_file_add']['error'][$key]==0){

					// 		$name = $_FILES['regulations_file_add']['name'][$key];
					// 		$entend = pathinfo($name,PATHINFO_EXTENSION);
					// 		if( $entend != 'jpg' && $entend != 'gif' && $entend != 'png' ){
					// 			jump('上传文件类型有误!');
					// 			break;
					// 		}else{
					// 			$new_filename = date('YmdHis',time()).mt_rand(10000,99999).'.'.$entend;
					// 			$new_uploadfile_path = './upload/regulations/'.date('Y/m/d').'/'.$new_filename;
					// 			move_uploaded_file($_FILES['regulations_file_add']['tmp_name'][$key],$new_uploadfile_path);

					// 			$file_path = './upload/regulations/'.date('Y/m/d').'/'.$new_filename;
					// 		}

					// 		#记录文件路径
	  		// 				$file_add = array(
	  		// 					'file_url'=>$file_path,
	  		// 					'file_type'=>1,
	  		// 					'file_type_cate'=>1, #规章制度
	  		// 					'type_id'=>$insert_id
	  		// 				);		
	  		// 				$this->files_model->insert($file_add);
							
					// 	}
						
					// }

					// foreach ($_FILES['answer_file_add']['name'] as $key => $value) {
					// 	if($_FILES['answer_file_add']['error'][$key]==0){

					// 		$name = $_FILES['answer_file_add']['name'][$key];
					// 		$entend = pathinfo($name,PATHINFO_EXTENSION);
					// 		if( $entend != 'jpg' && $entend != 'gif' && $entend != 'png' ){
					// 			jump('上传文件类型有误!');
					// 			break;
					// 		}else{
					// 			$new_filename = date('YmdHis',time()).mt_rand(10000,99999).'.'.$entend;
					// 			$new_uploadfile_path = './upload/answer/'.date('Y/m/d').'/'.$new_filename;
					// 			move_uploaded_file($_FILES['answer_file_add']['tmp_name'][$key],$new_uploadfile_path);

					// 			$file_path = './upload/answer/'.date('Y/m/d').'/'.$new_filename;
					// 		}

					// 		#记录文件路径
	  		// 				$file_add = array(
	  		// 					'file_url'=>$file_path,
	  		// 					'file_type'=>1,
	  		// 					'file_type_cate'=>2, #答案
	  		// 					'type_id'=>$insert_id
	  		// 				);		
	  		// 				$this->files_model->insert($file_add);
							
					// 	}
						
					// }
						
	  		// 	}

	  			show_message('添加成功！',site_url(module_folder(5).'/regulations/index/'.$regulation_type));
	  			
	  		}else{

	  			show_message('请输入规章制度标题！');
	  		}
	  	}
	}

	/**
	 * 修改规章制度
	 */
	public function edit()
	{
		$regulation_id = $this->uri->segment(5,0);

		if ( empty($_POST) ){

			$data['regulation_type'] = $this->uri->segment(6,0);

			if($data['regulation_type']==1){
				$data['regulation_type_name'] = '公司行政管理制度';
			}else if($data['regulation_type']==2){
				$data['regulation_type_name'] = '讲师岗位制度';
			}else if($data['regulation_type']==3){
				$data['regulation_type_name'] = '咨询师岗位规范常识';
			}else if($data['regulation_type']==4){
				$data['regulation_type_name'] = '先就业后付款申请注意事项';
			}else if($data['regulation_type']==5){
				$data['regulation_type_name'] = '人事就业岗位规范';
			}else if($data['regulation_type']==6){
				$data['regulation_type_name'] = '行政教务岗位规范';
			}

			//检查权限
			$url = site_url(module_folder(5).'/regulations/index/'.$data['regulation_type']);
			$this->_checkPower($url);

			#常见规章制度信息
			$where=array('regulation_id'=>$regulation_id);
			$data['regulation_info'] = $this->regulations_model->getOne('*',$where);

			#常见规章制度图片
			// $file_where = array('file_type'=>1)+$where;
			// $data['files_info'] = $this->files_model->select($file_where);

			$this->load->view('regulations_edit',$data);

		}else{

			$regulation_title= trim($this->input->post("regulation_title")) ? trim($this->input->post("regulation_title")) : '';
	  		$regulation_content= trim($this->input->post("regulation_content")) ? trim($this->input->post("regulation_content")) : '';
	  		$regulation_type= trim($this->input->post("regulation_type")) ? trim($this->input->post("regulation_type")) : 1;

	  		if(!empty($regulation_title)){

	  			$update_data = array(
	  					'regulation_title'=>$regulation_title,
	  					'regulation_content'=>$regulation_content
	  				);
	  			$update_where=array('regulation_id'=>$regulation_id);

	  			$this->regulations_model->edit($update_where,$update_data);
	  			
	  		}else{

	  			show_message('请输入规章制度标题！');
	  		}

			show_message('编辑成功!',site_url(module_folder(5).'/regulations/index/'.$regulation_type));
		}
	}

	/**
	 * 删除规章制度
	 */
	public function delete()
	{
		$regulation_id = $this->uri->segment(5,0);
		$regulation_type = $this->uri->segment(6,0);

		$regulation_where = array('regulation_id'=>$regulation_id);
		$this->regulations_model->delete($regulation_where,1);

		// $files_where = array('file_type'=>1,'type_id'=>$regulation_id);
		// $this->files_model->delete($files_where,1);

		show_message('删除成功!',site_url(module_folder(5).'/regulations/index/'.$regulation_type));

	}

	/**
	 * 删除规章制度文件
	 */
	public function delete_file()
	{
		
	}
	

	/**
	 * 检查该咨询者是否是该咨询师的
	 * @param $id int 接收一个咨询者id
	 * @param $type 默认空，如果为in,则表示查询多个id
	 * @param $is_ajax 是否是ajax
	 */
	private function _checkPower($url)
	{

		$this->load->model('p_employee_model');
	
		$res= $this->p_employee_model->checkData();
		
		if ($res===0) {
			show_message('权限不对',$url);
		}else{
			return 1;
		}

	}
}