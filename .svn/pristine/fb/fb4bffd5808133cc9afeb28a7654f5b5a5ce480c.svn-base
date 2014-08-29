<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_consulting_questions_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->model('files_model');
		$this->load->model('consulting_questions_model','consulting_questions');
	}
	
	/**
	 * 显示问题列表
	 */
	public function index()
	{

		$search_qusetion=trim($this->input->get('search_qusetion'))!=''?trim($this->input->get('search_qusetion')):'';

		$page = $this->uri->segment(5,1);
		$limit=20;
		$start=($page-1)*$limit;

		#查询问题记录
		$question_info = $this->consulting_questions->select('*',$start,$limit,'','',$search_qusetion);

		foreach ($question_info as $key => $value) {
			$q_where = array('file_type'=>1,'file_type_cate'=>1,'type_id'=>$value['questions_id']);
			$question_info[$key]['question_files'] = $this->files_model->select('*',$q_where);

			$a_where = array('file_type'=>1,'file_type_cate'=>2,'type_id'=>$value['questions_id']);
			$question_info[$key]['answer_files'] = $this->files_model->select('*',$a_where);
		}

		#统计问题记录总数
		$count = $this->consulting_questions->select_count('','',$search_qusetion);

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(5).'/consulting_questions/index');
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['uri_segment']= 5;
		$config['num_links'] = 4;
		//$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();


		$data=array(
			'list'=>$question_info,
			'create_page'=>$create_page
			);
		$this->load->view('consulting_questions_list',$data);
		
	}

	/**
	 * 添加问题
	 */
	public function add()
	{	

		if ( empty($_POST) ){

			//检查权限
			$url = site_url(module_folder(5).'/consulting_questions/index/');
			$this->_checkPower($url);

			$this->load->view('consulting_questions_add');
		
	  	}else{
	  		$question= trim($this->input->post("question")) ? trim($this->input->post("question")) : '';
	  		$answer= trim($this->input->post("answer")) ? trim($this->input->post("answer")) : '';

	  		#一定要添加问题名称
	  		if(!empty($question)){

	  			#填写问题名称
	  			if(!empty($question)){
	  				$check_where = array('questions_name'=>$question);
		  			$check_info = $this->consulting_questions->getOne('questions_id',$check_where);

		  			if(!empty($check_info)){
		  				show_message('该问题已经添加过了！');
		  			}

		  			$add_data = array(
		  					'questions_name'=>$question,
		  					'questions_answer'=>$answer
		  				);

		  			$insert_id = $this->consulting_questions->insert($add_data);
	  			}
	  			

	  			#上传问题图片
	  			if($insert_id && !empty($_FILES)){

	  				if( !file_exists('./upload/question/'.date('Y/m/d')) ){
						mkdir('./upload/question/'.date('Y/m/d'),0777,true); //存放原图路径
					}
					if( !file_exists('./upload/answer/'.date('Y/m/d')) ){
						mkdir('./upload/answer/'.date('Y/m/d'),0777,true); //存放原图路径
					}

					if(!empty($_FILES['question_file_add'])){
						foreach ($_FILES['question_file_add']['name'] as $key => $value) {
							if($_FILES['question_file_add']['error'][$key]==0){

								$name = $_FILES['question_file_add']['name'][$key];
								$entend = pathinfo($name,PATHINFO_EXTENSION);
								if( $entend != 'jpg' && $entend != 'gif' && $entend != 'png' ){
									jump('上传文件类型有误!');
									break;
								}else{
									$new_filename = date('YmdHis',time()).mt_rand(10000,99999).'.'.$entend;
									$new_uploadfile_path = './upload/question/'.date('Y/m/d').'/'.$new_filename;
									move_uploaded_file($_FILES['question_file_add']['tmp_name'][$key],$new_uploadfile_path);

									$file_path = './upload/question/'.date('Y/m/d').'/'.$new_filename;
								}

								#记录文件路径
		  						$file_add = array(
		  							'file_url'=>$file_path,
		  							'file_type'=>1,
		  							'file_type_cate'=>1, #问题
		  							'type_id'=>$insert_id
		  						);		
		  						$this->files_model->insert($file_add);
								
							}
							
						}
					}
					
					if(!empty($_FILES['answer_file_add'])){
						foreach ($_FILES['answer_file_add']['name'] as $key => $value) {
							if($_FILES['answer_file_add']['error'][$key]==0){

								$name = $_FILES['answer_file_add']['name'][$key];
								$entend = pathinfo($name,PATHINFO_EXTENSION);
								if( $entend != 'jpg' && $entend != 'gif' && $entend != 'png' ){
									jump('上传文件类型有误!');
									break;
								}else{
									$new_filename = date('YmdHis',time()).mt_rand(10000,99999).'.'.$entend;
									$new_uploadfile_path = './upload/answer/'.date('Y/m/d').'/'.$new_filename;
									move_uploaded_file($_FILES['answer_file_add']['tmp_name'][$key],$new_uploadfile_path);

									$file_path = './upload/answer/'.date('Y/m/d').'/'.$new_filename;
								}

								#记录文件路径
		  						$file_add = array(
		  							'file_url'=>$file_path,
		  							'file_type'=>1,
		  							'file_type_cate'=>2, #答案
		  							'type_id'=>$insert_id
		  						);		
		  						$this->files_model->insert($file_add);
								
							}
							
						}
					}
						
	  			}

	  			show_message('添加成功！',site_url(module_folder(5).'/consulting_questions/index/'));
	  			
	  		}else{

	  			show_message('请输入常见问题名称！');
	  		}
	  	}
	}

	/**
	 * 修改问题
	 */
	public function edit()
	{
		$questions_id = $this->uri->segment(5,0);
		if ( empty($_POST) ){

			//检查权限
			$url = site_url(module_folder(5).'/consulting_questions/index/');
			$this->_checkPower($url);

			#常见问题信息
			$where=array('questions_id'=>$questions_id);
			$data['questions_info'] = $this->consulting_questions->getOne('*',$where);

			#常见问题图片
			$q_where = array('file_type'=>1,'file_type_cate'=>1,'type_id'=>$questions_id);
			$data['question_files'] = $this->files_model->select('*',$q_where);

			$a_where = array('file_type'=>1,'file_type_cate'=>2,'type_id'=>$questions_id);
			$data['answer_files'] = $this->files_model->select('*',$a_where);

			$this->load->view('consulting_questions_edit',$data);

		}else{

			$question= trim($this->input->post("question")) ? trim($this->input->post("question")) : '';
	  		$answer= trim($this->input->post("answer")) ? trim($this->input->post("answer")) : '';

	  		if(!empty($question)){

	  			$update_data = array(
	  					'questions_name'=>$question,
	  					'questions_answer'=>$answer
	  				);
	  			$update_where=array('questions_id'=>$questions_id);

	  			$this->consulting_questions->edit($update_where,$update_data);

	  			if(!empty($_FILES)){

	  				if( !file_exists('./upload/question/'.date('Y/m/d')) ){
						mkdir('./upload/question/'.date('Y/m/d'),0777,true); //存放原图路径
					}
					if( !file_exists('./upload/answer/'.date('Y/m/d')) ){
						mkdir('./upload/answer/'.date('Y/m/d'),0777,true); //存放原图路径
					}

					if(!empty($_FILES['question_file_add'])){
						foreach ($_FILES['question_file_add']['name'] as $key => $value) {
							if($_FILES['question_file_add']['error'][$key]==0){

								$name = $_FILES['question_file_add']['name'][$key];
								$entend = pathinfo($name,PATHINFO_EXTENSION);
								if( $entend != 'jpg' && $entend != 'gif' && $entend != 'png' ){
									jump('上传文件类型有误!');
									break;
								}else{
									$new_filename = date('YmdHis',time()).mt_rand(10000,99999).'.'.$entend;
									$new_uploadfile_path = './upload/question/'.date('Y/m/d').'/'.$new_filename;
									move_uploaded_file($_FILES['question_file_add']['tmp_name'][$key],$new_uploadfile_path);

									$file_path = './upload/question/'.date('Y/m/d').'/'.$new_filename;
								}

								#记录文件路径
		  						$file_add = array(
		  							'file_url'=>$file_path,
		  							'file_type'=>1,
		  							'file_type_cate'=>1, #问题
		  							'type_id'=>$questions_id
		  						);		
		  						$this->files_model->insert($file_add);
								
							}
							
						}
					}
					
					if(!empty($_FILES['answer_file_add'])){
						foreach ($_FILES['answer_file_add']['name'] as $key => $value) {
							if($_FILES['answer_file_add']['error'][$key]==0){

								$name = $_FILES['answer_file_add']['name'][$key];
								$entend = pathinfo($name,PATHINFO_EXTENSION);
								if( $entend != 'jpg' && $entend != 'gif' && $entend != 'png' ){
									jump('上传文件类型有误!');
									break;
								}else{
									$new_filename = date('YmdHis',time()).mt_rand(10000,99999).'.'.$entend;
									$new_uploadfile_path = './upload/answer/'.date('Y/m/d').'/'.$new_filename;
									move_uploaded_file($_FILES['answer_file_add']['tmp_name'][$key],$new_uploadfile_path);

									$file_path = './upload/answer/'.date('Y/m/d').'/'.$new_filename;
								}

								#记录文件路径
		  						$file_add = array(
		  							'file_url'=>$file_path,
		  							'file_type'=>1,
		  							'file_type_cate'=>2, #答案
		  							'type_id'=>$questions_id
		  						);		
		  						$this->files_model->insert($file_add);
								
							}
							
						}
					}
					

	  			}
	  			
	  			
	  		}else{

	  			show_message('请输入常见问题！');
	  		}

			show_message('编辑成功!',site_url(module_folder(5).'/consulting_questions/index/'));
		}
	}

	/**
	 * 删除问题
	 */
	public function delete()
	{
		$questions_id = $this->uri->segment(5,0);

		$questions_where = array('questions_id'=>$questions_id);
		$this->consulting_questions->delete($questions_where,1);

		$files_where = array('file_type'=>1,'type_id'=>$questions_id);

		#先通过问题id删除对应的图片
		$file_url = $this->files_model->select('file_url',$files_where);

		foreach ($file_url as $key => $value) {
			if(!empty($value['file_url'])){
				unlink($value['file_url']);
			}
		}


		$this->files_model->delete($files_where,1);

		show_message('删除成功!',site_url(module_folder(5).'/consulting_questions/index/'));

	}

	/**
	 * 删除问题文件
	 */
	public function delete_file()
	{
		$file_id = $this->input->post('file_id');

		$files_where = array('file_id'=>$file_id);

		#先通过问题id删除对应的图片
		$file_url = $this->files_model->getOne('file_url',$files_where);

		if(!empty($file_url['file_url'])){
			unlink($file_url['file_url']);
		}
		
		$res = $this->files_model->delete($files_where,1);

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
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