<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_file_data_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->load->model('upload_files_model','upload_files');
		$this->main_data_model->setTable('upload_files');
	}
	/**
	 * 文件列表
	 */
	public function index()
	{
		#导航条处理
		$this->menuProcess();
		
		$data['cur_pag']=$page=$this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=20;
		$start=($page-1)*$limit;

		#$data['file_status'] = $file_status = $this->uri->segment(5,1);
		
		$list = $this->upload_files->select_index($start,$limit,0,2);
		$count = $this->upload_files->select_index_count(0,2);
		//未下载总数
		#$data['nodown_count'] = $this->main_data_model->count(array('file_type'=>2,'file_status'=>1));
		//已下载总数
		#$data['down_count'] = $this->main_data_model->count(array('file_type'=>2,'file_status'=>2));
		$data['count'] = $this->main_data_model->count(array('file_type'=>2));

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}
		$this->load->model('employee_model','employee');
		foreach($list as $k=>$v){
			#序号
			$list[$k]['serial_number']=$number[$k];
			#上传人
			$list[$k]['upload'] = $this->employee->select_employee($v['upload_employee_id']);
			#下载者
			$list[$k]['download'] = $this->employee->select_employee($v['download_employee_id']);

		}
		#分页类
		$this->load->library('pagination');

		$data['tiao']=$config['base_url']=site_url(module_folder(5)."/file_data/index/?");
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 

		$config['num_links'] = 5;
		$config['page_query_string']=true;
		
		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();
		
		$data['file_info'] = array(
			'list'=>$list,
			'page'=>$create_page,
		);
		$this->load->view('file_data_list',$data);
		
	}
	/**
	 * 添加页面
	 */
	public function add()
	{
		if (isset($_POST['add']) && !empty($_POST)){

			$file_desc = $this->input->post('file_desc');

			//重新组装上传的二维数组
			foreach ($_FILES['myfile'] as $key => $value) {
				for($i=0;$i<count($value);$i++){
			        $file[$i][$key] = $value[$i];
			    } 
			}

			//允许上传类型
  			$type = array('htm','html','doc','docx','xls','xlsx','rar','zip','gzip','cab','7z','gz','bz','ppt');

			foreach ($file as $key => $value) {
				//获取文件后缀名
				$entend = pathinfo($value['name'],PATHINFO_EXTENSION);

				//判断文件后缀名是否是允许上传的类型
				if(!in_array($entend, $type)){
					continue;
				}
				
		  		//文件重命名
				$new_filename = date('YmdHis',time()).mt_rand(10000,99999).'.'.$entend;

				//文件存放路径
				$path = './upload/file/'.date('Ymd');
				if( !file_exists($path) ){
					@mkdir($path,0777,true); 
				}
				//文件路径加名字
				$file_path = $path.'/'.$new_filename;

				//从临时目录转移路径
				move_uploaded_file($value['tmp_name'],$file_path);

				//调用文件大小函数，获取文件大小
				$size = formatsize($value['size']);
				$data=array(
					'file_name'=>$value['name'],
					'file_desc'=>$file_desc[$key],
					'file_size'=>$size,
					'file_path'=>$file_path,
					'upload_employee_id'=>getcookie_crm('employee_id'),
					'upload_time'=>time(),
					'file_type'=>2,
					'file_status'=>1,
				);

				$res = $this->main_data_model->insert($data,'upload_files');

			}
			if($res>0){
				show_message('上传成功',site_url(module_folder(5).'/file_data/index'));
			}else{
				show_message('上传失败');
			}
		
	  	}else{
			$this->load->view('file_data_add');
		}
	}
	/**
	 * 进入上传文件页面
	 */
	/*public function add()
	{
		$this->load->view('file_data_add');
	}*/
	/**
	 * 上传文件操作
	 */
	/*public function uploadFile()
	{
		header("Content-type:text/html;charset=utf-8");
			
  		//print_r($_FILES);die;
  		
  		//允许上传类型
  		$type = array('htm','html','doc','docx','xls','xlsx','rar','zip','gzip','cab','7z','gz','bz');

		//获取文件后缀名
		$entend = pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION);

		//判断文件后缀名是否是允许上传的类型
		if(!in_array($entend, $type)){
			echo json_encode(array('status'=>0));
			die;
		}

		//文件名
  		$file_name = $_FILES['fileToUpload']['name'];
  		//文件重命名
		$new_filename = date('YmdHis',time()).mt_rand(10000,99999).'.'.$entend;

		//文件存放路径
		$path = './upload/file/'.date('Ymd');
		if( !file_exists($path) ){
			@mkdir($path,0777,true); 
		}
		//文件路径加名字
		$file_path = $path.'/'.$new_filename;

		//从临时目录转移路径
		move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$file_path);

		//调用文件大小函数，获取文件大小
		$size = formatsize($_FILES['fileToUpload']['size']);
	
		$data=array(
			'file_name'=>$file_name,
			'file_size'=>$size,
			'file_path'=>$file_path,
			'upload_employee_id'=>getcookie_crm('employee_id'),
			'upload_time'=>time(),
			'file_type'=>2,
			'file_status'=>1,
		);

		$res = $this->main_data_model->insert($data,'upload_files');
	}*/
	
	/**
	 * 下载文件操作
	 */
	public function downloadFile()
	{
		header("Content-type:text/html;charset=utf-8"); 
		
		//$upload_id = $this->input->get('download') ? $this->input->get('download') : 0;
		$upload_id = $this->uri->segment(5,0);
		
		#查询对应的文件
		$where = array('upload_file_id'=>$upload_id);
		$file = $this->main_data_model->getOne($where);
		#查找是否有对应的文件
		if(!file_exists($file['file_path'])){ 
			show_message("没有该文件"); 
			return false; 
		} 

		//获取文件后缀名
		//$exten = strtolower( pathinfo($file['file_path'], PATHINFO_EXTENSION) );
		$fp=fopen($file['file_path'],"r"); 
		$file_size=filesize($file['file_path']); 

		//下载文件需要用到的头信息 
		Header("Content-type: application/octet-stream"); 
		Header("Accept-Ranges: bytes"); 
		Header("Accept-Length:".$file_size); 
		Header("Content-Disposition: attachment; filename=".$file['file_name']); 
		//拼接文件名称和后缀名
		//Header("Content-Disposition: attachment; filename=".$file['file_name'].'.'.$exten); 
		$buffer=1024; 
		$file_count=0; 
		//向浏览器返回数据 
		while(!feof($fp) && $file_count<$file_size){ 
			$file_con=fread($fp,$buffer); 
			$file_count+=$buffer; 
			echo $file_con; 
		} 
		
		//让下载次数加1之后更新到数据库
		$download_number = $file['download_number']+1;
		//判断是不是第一次下载,第一次下载要更新状态,下载人,下载时间
		if($file['file_status']==1){
			$update_number = array(
				'download_number'=>$download_number,
				'download_employee_id'=>getcookie_crm('employee_id'),
				'download_time'=>time(),
				'file_status'=>2,
			);
		}else{
			$update_number = array('download_number'=>$download_number);
		}
		$res = $this->main_data_model->update($where,$update_number,'upload_files');fclose($fp);
	}
	/**
	 * 下载文件操ajax动态更新下载次数和下载人
	 */
	/*public function downloadUpdate()
	{
		header("Content-type:text/html;charset=utf-8"); 
		$upload_id = $this->input->post('id');

		//查询对应文件的下载次数
		$where = array('upload_file_id'=>$upload_id);
		$file = $this->main_data_model->getOne($where,'download_number,file_status');

		//让下载次数加1之后更新到数据库
		$download_number = $file['download_number']+1;
		//判断是不是第一次下载,第一次下载要更新状态,下载人,下载时间
		if($file['file_status']==1){
			$update_number = array(
				'download_number'=>$download_number,
				'download_employee_id'=>getcookie_crm('employee_id'),
				'download_time'=>time(),
				'file_status'=>2,
			);
		}else{
			$update_number = array('download_number'=>$download_number);
		}
		$res = $this->main_data_model->update($where,$update_number,'upload_files');

		$updatefile = $this->main_data_model->getOne($where,'download_employee_id,download_time,download_number,file_status');

		$this->load->model('employee_model','employee');
		$name = $this->employee->select_employee($updatefile['download_employee_id']);

		$downname = $name['employee_name'];
		$downtime = date('Y-m-d H:i:s',$updatefile['download_time']);
		if($updatefile['file_status']==2){
			$filestatus = '已下载';
		}else{
			$filestatus = '';
		}
		$downnumber = $updatefile['download_number'];

		if ($res>0) {
			echo json_encode(array('status'=>1,'downname'=>$downname,'downtime'=>$downtime,'filestatus'=>$filestatus,'downnumber'=>$downnumber,));
		}else{
			echo json_encode(array('status'=>0));
		}

	}*/
	/**
	 * 删除文件
	 */
	public function delFile()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[1][1];

		$upload_id = $this->input->post('id');
		
		//先查询对应的文件目录
		$file=array();
		foreach($upload_id as $item){
			$file[] = $this->main_data_model->getOne(array('upload_file_id'=>$item),'file_path');
		}
			
		//删除数据库对应的那条记录
		$result = $this->upload_files->delete_file($upload_id);
		//删除对应的文件
		foreach ($file as $value) {
			@unlink($value['file_path']);
		}

		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}
	}
	/**
	 * 导航条处理
	 */
	private function menuProcess()
	{	
		$url[0]=array('资料列表', site_url(module_folder(5).'/file_data/index/'));
		$file_status = $this->uri->segment(5,1);

		#当前页码
		$per_page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		
		/*if($selectYear!='' || $selectMonth!=''){
			$url[1]=array('文件搜索',site_url(module_folder(5).'/file/index?'.'&year='.$selectYear.'&month='.$selectMonth.'&per_page='.$per_page));
		}else{
			$url[1]=array('文件分页',site_url(module_folder(5).'/file/index?'.'&year='.$selectYear.'&month='.$selectMonth.'&per_page='.$per_page));
		}*/
		$url[1]=array('资料分页',site_url(module_folder(5).'/file_data/index/'.$file_status.'?per_page='.$per_page));

		$_COOKIE['url']= authcode(serialize($url),'ENCODE');

		setcookie_crm('url',serialize($url));

	}
}