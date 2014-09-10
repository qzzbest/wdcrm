<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market_remind_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('time_remind');
	}

	public function index()
	{
		#当前页码
		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		#导航栏处理
		$type = 1; 
		$this->menuProcess($page,$type);	

		$limit = 10;
		$start = ($page-1)*$limit;

		#接收日期
		$starttime = $this->input->get('start_time') ? $this->input->get('start_time'):'';
		$endtime = $this->input->get('end_time') ? $this->input->get('end_time'):'' ;
		
		if(!empty($starttime)){
			$start_time = strtotime($starttime);
		}else{
			$start_time = $starttime;
		}

		if(!empty($endtime)){
			$end_time = strtotime($endtime.'23:59:59');
		}else{
			$end_time = $endtime;
		}
			
		$param_url['start_time']=$starttime;
		$param_url['end_time']=$endtime;

		$employee_id = getcookie_crm('employee_id');

		$this->load->model('time_remind_model');
		$list= $this->time_remind_model->select_index($employee_id,$start,$limit,$start_time,$end_time);
		$count=$this->time_remind_model->select_index_count($employee_id,$start_time,$end_time);

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		foreach($list as $k=>$v){
			#序号
			$list[$k]['serial_number']=$number[$k];
		}	

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = $this->_buildUrl($param_url);
		$config['total_rows'] = $count;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 5;
		$config['num_links'] = 4;
		$config['page_query_string']=true;
		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();

		$data=array(
			'list'=>$list,
			'page'=>$page,
		);
		$this->load->view('time_remind_list',$data);
	}
	/**
	 * 建立url地址
	 */
	private function _buildUrl($arr)
	{

		$param_url = "";
		foreach($arr as $key=>$val){
			if(trim($val)!=''){
				$param_url .= $key."=".$val."&";	
			}
		}
		$param_url = rtrim($param_url, "&");
		
		
		$urls =site_url(module_folder(6)."/remind/index?".$param_url);
		
		return $urls;
	}
	public function add()
	{

		$check=array(
			array('remind_content','提醒内容'),
		);

		#导航栏处理
		$type = 2; 
		$this->menuProcess('',$type);	

		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[1][1];

		check_form($check);
		if ($this->form_validation->run() == FALSE){
	   		$this->load->view('time_remind_add');
	  	}else{

	  		$remind_remark = $this->input->post("remind_remark");

	  		$remind_content = $this->input->post("remind_content");
	  		$remind_date = $this->input->post("remind_date");
	  		$remind_time = $this->input->post("remind_time");
	  		$time_remind_status = 0;

	  		#批量提醒
	  		foreach($remind_content as $k=>$v){
	  			
	  			$data=array(
					'employee_id'=>getcookie_crm('employee_id'),
  					'time_remind_content'=>$remind_content[$k],
  					'time_remind_time'=>strtotime($remind_date[$k].' '.$remind_time[$k]),
  					'time_remind_status'=>$time_remind_status,
  					'remind_remark'=>$remind_remark[$k],
  				);

	  			$insert_id=$this->main_data_model->insert($data,'time_remind');
  				
	  		}

	  		show_message('添加成功!',$location);	
	  	}
	}

	public function edit()
	{

		$check=array(
			array('remind_content','提醒内容'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){

			$id = $this->uri->segment(5,0);	
			$data['list']=$this->main_data_model->getOne("time_remind_id = '{$id}'");
			
			#导航栏处理
			$type = 3; 
			$this->menuProcess($id,$type);	

	   		$this->load->view('time_remind_edit',$data);
	  	}else{

	  		//获取跳转地址
			$url=unserialize(getcookie_crm('url'));
			$location=$url[1][1];

	  		//更新	  		
	  		$remind_id = $this->input->post('id');
	  		$remind_content = $this->input->post("remind_content");
	  		$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");
			$remindtime = strtotime($remind_date.' '.$remind_time);
	  		$remind_remark = $this->input->post("remind_remark") ? $this->input->post("remind_remark") : '';;


			$data_remind=array(
				'time_remind_content'=>$remind_content,
				'time_remind_time'=>$remindtime,
				'remind_remark'=>$remind_remark
				);

			$where_remind = array('time_remind_id'=>$remind_id,'employee_id'=>getcookie_crm('employee_id'));
			$res=$this->main_data_model->update($where_remind,$data_remind,'time_remind');

	  		show_message('成功!',$location);
	  	}
	}
	#批量修改
	public function allEdit()
	{
		#导航栏处理
		$type = 4; 
		$this->menuProcess('',$type);	

		$check=array(
			array('remind_content','提醒内容'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){

			$id=$this->input->post('id');
			$this->load->model('time_remind_model');
			$data['list']= $this->time_remind_model->select($id);
			
	   		$this->load->view('time_remind_alledit',$data);
	  	}else{

	  		//获取跳转地址
			$url=unserialize(getcookie_crm('url'));
			$location=$url[1][1];

	  		$remind_id = $this->input->post("id");
	  		$remind_content = $this->input->post("remind_content");
	  		$remind_date = $this->input->post("remind_date");
	  		$remind_time = $this->input->post("remind_time");
	  		$time_remind_status = 0;

	  		$remind_remark = $this->input->post("remind_remark") ? $this->input->post("remind_remark") : '';;

			//更新操作
			if($remind_content && !empty($remind_content)){

				$remind_content=array_unique($remind_content);	
				foreach ($remind_content as $k=>$v) {
					if($v!=''){
						$data=array();
						$data['time_remind_content']=$remind_content[$k];
						$data['time_remind_time']=strtotime($remind_date[$k].' '.$remind_time[$k]);
						$data['time_remind_status']=$time_remind_status;
						$data['remind_remark']=$remind_remark[$k];

						$where_remind = array('time_remind_id'=>$remind_id[$k],'employee_id'=>getcookie_crm('employee_id'));
						$this->main_data_model->update($where_remind,$data,'time_remind');

					}

				}
				
			}
			
			show_message('修改成功!',$location); //如果没有更新内容，直接提示跳转
	  	}
	}
	
	/**
	 * 删除提醒
	 */
	public function ignore()
	{

		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[1][1];
			
		$id = $this->input->post('id');
		
		$employee_id=getcookie_crm('employee_id');//得到当前咨询者的id

		foreach ($id as $v) {
			$where = array('time_remind_id'=>$v,'employee_id'=>$employee_id);
			$result = $this->main_data_model->delete($where,1,'time_remind');
			$this->main_data_model->delete($where,1,'setview_consultant_record');
		}
		
		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}

	}

	/**
	 * 咨询者提醒的增加,修改
	 */
	public function consultantRemind()
	{

		$check=array(
			array('remind_content','提醒内容'),
		);
		check_form($check);
		$client = $this->input->post("client");

		if ($this->form_validation->run() == FALSE){
			if($client){
				$this->load->view('client_list',$data);
			}else{
				$this->load->view('advisory_list',$data);
			}
	   		
	  	}else{
	  		$remind_consultant_id = $this->input->post("remind_consultant_id");
	  		$time_remind_id = $this->input->post("time_remind_id");
	  		$remind_content = $this->input->post("remind_content");
			$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");
			$remindtime = strtotime($remind_date.' '.$remind_time);
			$time_remind_status=0;

			#提醒备注、上门、重点跟进
			$remind_remark = $this->input->post("remind_remark");
			$is_set_view = $this->input->post("is_set_view");
			$is_important = $this->input->post("is_important");

			#找到该学生的咨询师id
			$where=array('consultant_id'=>$remind_consultant_id);
  			$consultant_info= $this->main_data_model->getOne($where,'consultant_id,employee_id,consultant_name,is_student','consultant');

  			//start 2014-6-8 判断操作的时候是否是所属咨询师
  			if($consultant_info['employee_id']!=getcookie_crm('employee_id')){
  				show_message('权限不对',site_url(module_folder(2).'/advisory/index/index/0'));
  			}
  			//end

			$data = array(
				'time_remind_content' => $remind_content,
				'time_remind_time' => $remindtime,
				'time_remind_status' => $time_remind_status,
				'employee_id' => $consultant_info['employee_id'],
				'consultant_id' => $remind_consultant_id,
				'is_set_view'=>$is_set_view,
				'is_important'=>$is_important,
				'remind_remark'=>$remind_remark
			);

			if($client){
				$data['is_client'] = 1;
			}

			#判断是更新还是增加操作
	  		if( !empty($time_remind_id) ){				
				$where = array('time_remind_id'=>$time_remind_id);
				$res=$this->main_data_model->update($where,$data,'time_remind');	

				#查询是否存在教务提醒记录
				$record_res = $this->main_data_model->getOne($where,'record_id','setview_consultant_record');

				if(!empty($record_res) && $is_set_view==0){#删除记录		
					$record_where = array('record_id'=>$record_res['record_id']);		
					$this->main_data_model->delete($record_where,1,'setview_consultant_record');
				}else if(!empty($record_res) && $is_set_view==1){ #更新记录
					$record_where = array('record_id'=>$record_res['record_id']);
					$this->main_data_model->update($record_where,array('remind_remark'=>$remind_remark),'setview_consultant_record');
				}else{

					$remind_info = $this->main_data_model->getOne($where,'consultant_id','time_remind');
					if($remind_info['consultant_id']){
						$add_data = array(
							'consultant_id'=>$remind_info['consultant_id'],
							'employee_id'=>$consultant_info['employee_id'],
							'remind_remark'=>$remind_remark,
							'time_remind_id'=>$time_remind_id
						);
						$this->main_data_model->insert($add_data,'setview_consultant_record');
					}			
				}	

			}else{
				$res=$this->main_data_model->insert($data);

				if(!empty($remind_consultant_id) && $is_set_view==1){ #添加教务提醒记录

					$add_data = array(
						'consultant_id'=>$remind_consultant_id,
						'employee_id'=>$consultant_info['employee_id'],
						'remind_remark'=>$remind_remark,
						'time_remind_id'=>$res
					);

					$this->main_data_model->insert($add_data,'setview_consultant_record');
				}				
			}
		  	
	  		if($res>0){
	  			if($client){
	  				show_message('成功!',site_url(module_folder(2).'/client/index'));	
	  			}else{
	  				show_message('成功!',site_url(module_folder(2).'/advisory/index'));	
	  			}
  				
	  		}else{
	  			show_message('失败!');
	  		}	
	  		
	  	}
	}

	/**
	 * 咨询者提醒的删除
	 */
	public function deleteConsultantRemind()
	{
		$id = $this->uri->segment(5, 0);
		$client = $this->uri->segment(6, 0);
		
		$where=array('time_remind_id'=>$id,'employee_id'=>getcookie_crm('employee_id'));
		//$data=array('time_remind_status'=>-1);
		//$this->main_data_model->update($where,$data,'time_remind');
		$res=$this->main_data_model->delete($where,1,'time_remind');
		$this->main_data_model->delete($where,1,'setview_consultant_record');

		if($client){
			show_message('操作成功!',site_url(module_folder(2).'/client/index'));	
		}else{
			show_message('操作成功!',site_url(module_folder(2).'/advisory/index'));	
		}
	
	}

	/**
	 * 检查该咨询者是否是该咨询师的
	 * @param $id int 接收一个咨询者id
	 * @param $type 默认空，如果为in,则表示查询多个id
	 * @param $is_ajax 是否是ajax
	 */
	private function _checkPower($id,$type='',$is_ajax='')
	{

		if(!$id){
			show_message('权限不对',site_url(module_folder(6).'/remind/index'));
		}

		$this->load->model('market_model');

		$res= $this->market_model->checkData($id,$type);

		
		if ($res===0) {
			if($is_ajax=='ajax'){
				return 0;//表示操作了非法数据	
			}else{
				show_message('权限不对',site_url(module_folder(6).'/market/index/index/0'));
			}
		
		}else{
			return 1;
		}

	}


	/**
	 * 学员提醒的增加,修改
	 */
	public function marketRemind()
	{
		$check=array(
			array('remind_content','提醒内容'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
	   		$this->load->view('market_list',$data);
	  	}else{
	  		$market_id = $this->input->post("market_id");
	  		$time_remind_id = $this->input->post("time_remind_id");
	  		$remind_content = $this->input->post("remind_content");
			$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");
			$remindtime = strtotime($remind_date.' '.$remind_time);
			$time_remind_status=0;

			#提醒备注、上门、重点跟进
			$remind_remark = $this->input->post("remind_remark");
			//$is_important = $this->input->post("is_important");
			
  			#找到该学生的咨询师和之前的咨询者id
  			$where=array('market_id'=>$market_id);
  			$employee_id= $this->main_data_model->getOne($where,'employee_id,market_id','market');

  			//start 2014-6-8 判断操作的时候是否是所属咨询师
  			if($employee_id['employee_id']!=getcookie_crm('employee_id')){
  				show_message('权限不对',site_url(module_folder(6).'/market/index/index/0'));
  			}
  			//end

			$data = array(
				'employee_id'=>$employee_id['employee_id'],
				'market_id'=>$employee_id['market_id'],
				'time_remind_content'=>$remind_content,
				'time_remind_time'=>$remindtime,
				'time_remind_status'=>$time_remind_status,
				//'is_important'=>$is_important,
				'remind_remark'=>$remind_remark
			);

			#判断是更新操作还是增加操作
			if(!empty($time_remind_id)){				
				$remind_id = array('time_remind_id'=>$time_remind_id);
				$res=$this->main_data_model->update($remind_id,$data,'time_remind');
			}else{
				$res=$this->main_data_model->insert($data);
			}

	  		show_message('成功!',site_url(module_folder(6).'/market/index'));	
	  	}
	}

	/**
	 * 学员提醒的删除
	 */
	public function deleteMarketRemind()
	{
  		$id = $this->uri->segment(5, 0);
		
		$where=array('time_remind_id'=>$id,'employee_id'=>getcookie_crm('employee_id'));
		$data=array('time_remind_status'=>-1);
		$this->main_data_model->update($where,$data,'time_remind');

		show_message('删除成功!',site_url(module_folder(6).'/market/index'));
		
	}

	/**
	 * 学员提醒的信息
	 */
	public function remindMarketInfo()
	{
		header("Content-Type:text/html;charset=utf-8");
		$id= $this->input->post("id");

		$where=array('market_id'=>$id,'time_remind_status !='=>-1,'employee_id'=>getcookie_crm('employee_id'));
		$remind = $this->main_data_model->getOne($where,'','time_remind');

		if(!empty($remind)){
			$remind['day'] = date("Y-m-d",$remind['time_remind_time']);
			$remind['time'] = date("H:i:s",$remind['time_remind_time']);
			$market_id=$remind['market_id'];
		}else{
			$market_id='';
		}

		
		//检查咨询者所属者
		$check_result = $this->_checkPower($market_id,'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}

		#查询学员的姓名,手机,QQ加入到提醒内容
		$where_id = array('market_id'=>$id);
		$market_info = $this->main_data_model->getOne($where_id,'school','market');

		if( !empty($market_info) ){
			$marketinfo = "学校: ".$market_info['school'];
		}

		$del=site_url(module_folder(6).'/remind/deleteMarketRemind/'.$remind['time_remind_id']);

		$str=<<<HTML
		<a class="btn btn-xs btn-danger" href="$del" class="delete_remind" role="button" >删除</a>
HTML;
		echo json_encode(array('data'=>$remind,'str'=>$str,'marketinfo'=>$marketinfo));
		exit;
	}


	/**
	 * 右上角添加、修改提醒
	 */
	public function actionSelfRemind()
	{
		$check=array(
			array('remind_content','提醒内容'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
	   		$this->load->view('time_remind_list');
	  	}else{
	  		$time_remind_id = $this->input->post("time_remind_id");
	  		$remind_content = $this->input->post("remind_content");
			$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");
			$remindtime = strtotime($remind_date.' '.$remind_time);
			$time_remind_status=0;

			#提醒备注、上门、重点跟进
	  		//$is_important = $this->input->post("is_important");
	  		$remind_remark = $this->input->post("remind_remark");

  			$data = array(
				'employee_id'=>getcookie_crm('employee_id'),
				'time_remind_content'=>$remind_content,
				'time_remind_time'=>$remindtime,
				'time_remind_status'=>$time_remind_status,
				//'is_important'=>$is_important,
				'remind_remark'=>$remind_remark
			);

  			#判断是更新操作还是增加操作
			if(!empty($time_remind_id)){			

				$remind_id = array('time_remind_id'=>$time_remind_id,'employee_id'=>getcookie_crm('employee_id'));
				$res=$this->main_data_model->update($remind_id,$data,'time_remind');
			}else{			
				$res=$this->main_data_model->insert($data);
			}

	  		show_message('成功!',site_url(module_folder(6).'/remind/index'));
	  	}
	}


	/**
	 * qq与phone的数据简单处理
	 */
	private  function _dataProcess($arr,$str){
		$data=array();
		foreach ($arr as $key => $value) {
			$data[]=$value[$str];
		}
		return $data;
	}
	public function deleteRemind()
	{
		header("Content-Type:text/html;charset=utf-8");

		$remind_id = $this->input->post('id');

		$where=array('time_remind_id'=>$remind_id,'employee_id'=>getcookie_crm('employee_id'));	
		$res=$this->main_data_model->delete($where,1,'time_remind');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	/**
	 * 头部提醒的信息 
	 */
	public function remindInfo()
	{	
		header("Content-Type:text/html;charset=utf-8");
		$id= $this->input->post("id");

		$where=array('time_remind_id'=>$id);
		$remind = $this->main_data_model->getOne($where,'','time_remind');

		#查询学员的姓名,手机,QQ加入到提醒内容
		/*$where_id = array('market_id'=>$id);
		$market_info = $this->main_data_model->getOne($where_id,'school','market');

		if(isset($market_info) && !empty($market_info) ){
			$marketinfo = "学校: ".$market_info['school'];
		}*/
		$remind['day'] = date("Y-m-d",$remind['time_remind_time']);
		$remind['time'] = date("H:i:s",$remind['time_remind_time']);
		
		$del=site_url(module_folder(6).'/remind/deleteMarketRemind/'.$remind['time_remind_id']);

		$str=<<<HTML
		<a class="btn btn-xs btn-danger" href="$del" class="delete_remind" role="button" >删除</a>
HTML;
		echo json_encode(array('data'=>$remind,'str'=>$str/*,'marketinfo'=>$marketinfo*/));
		exit;

	}	

	/**
	 * 导航条处理
	 */
	public function menuProcess($param='',$type)
	{	

		switch ($type) {
			case 1:  
				$url[0]=array('咨询提醒管理', site_url(module_folder(6).'/remind/index'));
				$url[1]=array('咨询提醒列表',site_url(module_folder(6).'/remind/index?&per_page='.$param));
				break;
			case 2:
				$url= unserialize(getcookie_crm('url'));
				$url[2]=array('添加咨询提醒', site_url(module_folder(6).'/remind/add/'));
				break;
			case 3:
				$url= unserialize(getcookie_crm('url'));
				$url[2]=array('修改咨询提醒', site_url(module_folder(6).'/remind/edit/'.$param));
				break;
			case 4:
				$url= unserialize(getcookie_crm('url'));
				$url[2]=array('批量修改咨询提醒', site_url(module_folder(6).'/remind/allEdit/'));
				break;

			default:
				# code...
				break;
		}

		//之前是这么做
		//$_COOKIE['url']=serialize($url);
		//加密处理
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');
		setcookie_crm('url',serialize($url));
	}
}