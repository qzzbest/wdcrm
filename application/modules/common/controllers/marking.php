<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_marking_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('employee');
		$this->load->model('employee_model');
	}
	
	//示例：信息获取未读信息(时时监听)
	public function index()
	{
		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		#导航栏处理
		$type = 1; 
		$this->menuProcess($page,$type);		

		$limit=10;
		$start=($page-1)*$limit;
		$field='*';

		$param_url=array();
		//超级管理员选中的咨询师
		$selected_job=trim($this->input->get('job'))!=''?trim($this->input->get('job')):'';

		#搜索年月
		$selectYear=trim($this->input->get('year'))!=''?trim($this->input->get('year')):'';
		$selectMonth=trim($this->input->get('month'))!=''?trim($this->input->get('month')):'';
		
		$param_url['job']=$selected_job;
		$param_url['year']=$selectYear;
		$param_url['month']=$selectMonth;

		if($selectYear==''){
			$selectYear = date('Y',time());
		}else{
			$selectYear = $selectYear;
		}
		if($selectMonth==''){
			$selectMonth = date('m',time());
		}else{
			$selectMonth = $selectMonth;
		}

		//2014-06
		$start_search_date = $selectYear.'-'.$selectMonth.'-1 00:00:00';
		$end_search_date = $selectYear.'-'.$selectMonth.'-31 23:59:59';

		$start_search_time = strtotime($start_search_date);		
		$end_search_time = strtotime($end_search_date);	

		$this->load->model('employee_model');
		//查询管理员列表
		$list= $this->employee_model->select_index($start,$limit,$selected_job,$start_search_time,$end_search_time);
		$count= $this->employee_model->select_index_count($selected_job);
		$stand_list=$this->employee_model->get_stand();
		//查询职位
		$employee_job=$this->main_data_model->getAll('*','employee_job');

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = $this->_buildUrl($param_url);

		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['num_links'] = 4;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$data=array(
			'list'=>$list,
			'employee_job'=>$employee_job,
			'create_page'=>$create_page,
			'selected_job'=>$selected_job,
			'stand_list'=>$stand_list,
			'selectYear'=>$selectYear,
			'selectMonth'=>$selectMonth
			);
		$this->load->view('marking_list',$data);

		exit;
		
	}

	public function edit()
	{	
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[1][1];

		if(isset($_POST['dosubmit'])){
			$mark_by = $this->input->post('employee_id');
			$mark = $this->input->post("mark_id");
			$integral = $this->input->post("integral");
			$integral_date = $this->input->post("integral_date");
			$integral_time = $this->input->post("integral_time");
			$message = $this->input->post("message");
			
			$date = strtotime($integral_date.' '.$integral_time);

			$data=array(
				'mark_by'=>$mark_by,
				'mark'=>$mark,
				'integral'=>$integral,
				'date'=>$date,
				'message'=>$message
			);	

	  		$this->main_data_model->insert($data,"integral");
			redirect($location);
		}
		

		$id = $this->uri->segment(5,0);	

		#导航栏处理
		$type = 4; 
		$this->menuProcess($id,$type);	

		$this->load->model('employee_model');
		$info=$this->main_data_model->getOne("employee_id = '{$id}'");

		if(getcookie_crm('employee_power')==1){
			$where_join = "employee.employee_power = ".getcookie_crm('employee_power');
			$join = array('employee_job_id','employee_job','employee_job.employee_job_id = employee.employee_job_id','left');
			$employee_info = $list = $this->main_data_model->select('employee_id',$where_join,0,0,0,$join,'employee');

			if( $info['employee_power'] == 1 ){
				$role = array();
			}else{
				$where = "employee_job_id != ".$employee_info[0]['employee_job_id'];
				$role=$this->main_data_model->getOtherAll('*',$where,'employee_job');

			}
				
		}else{
			$role=$this->main_data_model->getAll('*','employee_job');
		}

		$stand_list=$this->employee_model->get_stand();
	
		$data=array(
			'info'=>$info,
			'role'=>$role,
			'stand_list'=>$stand_list,
			);
		$this->load->view('marking_edit',$data);
	}

	/* 
	*评分列表
	*/
	public function detail(){
		$this->load->model('employee_model');
		$id = $this->uri->segment(5,0);	

		#导航栏处理
		$type = 2; 
		$this->menuProcess($id,$type);		

		$info=$this->main_data_model->getOne("employee_id = '{$id}'");
		$integral=$this->employee_model->get_Intergral($id);
		$stand_list=$this->employee_model->get_stand();

		$data=array(
			'info'=>$info,
			'integral'=>$integral,
			'stand_list'=>$stand_list
			);
		$this->load->view('detail',$data);
	
	}

	/* 
	*删除一条评分积分
	*
	*/
	public function del_onemark($id){
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];

		$this->employee_model->del_onemark($id);	
		redirect($location);
	}


	/* 
	*编辑评分标准
	*
	*/
	public function standard(){
		$this->load->model('employee_model');

		#导航栏处理
		$type = 3; 
		$this->menuProcess('',$type);		

		$stand = $this->employee_model->get_stand();
		$data=array(
			'stand'=>$stand	
		);
		$this->load->view('standard',$data);
	
	}

	/* 
	*删除一条评分标准
	*
	*/
	public function del_stand($id){
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];

		$this->load->model('employee_model');
		$stand = $this->employee_model->del_stand($id);
		redirect($location);
	}

	/* 
	*添加一条评分标准
	*
	*/
	public function add_stand(){

		#导航栏处理
		$type = 6; 
		$this->menuProcess('',$type);	

		$this->load->view('addone');
	}

	/* 
	*添加一条评分标准
	*
	*/
	public function add_one(){
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];

		$this->load->model('employee_model');
		if($_POST){
			$content = $_POST['content'];
			$type = $_POST['type'];
			$remark = $_POST['remark'];
			$this->employee_model->add_stand($content,$type,$remark);
		}
		redirect($location);
	}

	/* 
	*编辑一条评分标准
	*
	*/
	public function edit_stand($id){

		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];

		$this->load->model('employee_model');
		if($_POST){
			$type = $_POST['type'];
			$cont = $_POST['content'];
			$remark = $_POST['remark'];
			$this->employee_model->edit_stand($type,$cont,$remark,$id);
			redirect($location);
		}
		
		$one_stand=$this->employee_model->get_one_stand($id);

		#导航栏处理
		$type = 5; 
		$this->menuProcess($id,$type);		

		$data=array('one_stand'=>$one_stand);
		$this->load->view('editone',$data);
	}

	/* 
	*通过审核
	*
	*/
	public function pass($id){
		if($_POST['Action']=='pass'){
			$list= $this->employee_model->pass_mark($id);
			if($list){
				echo 1;
			}else{
				echo 0;
			}
		}else if($_POST['Action']=='no_pass'){
			$list= $this->employee_model->no_pass($id);
			if($list){
				echo 1;
			}else{
				echo 0;
			}
		}
	}

	/**
	 * 批量操作评分状态
	 */
	public function actionPassAll()
	{	
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];

		$type = $this->input->post('action_type');
		$ids = $this->input->post('ids');
		$where = db_create_in($ids,'id');

		switch ($type) {
			case 1:  //通过
				$status = array('state'=>1);
				$this->main_data_model->update($where,$status,'integral');
				break;
			case 2: //不通过
				$status = array('state'=>-1);
				$this->main_data_model->update($where,$status,'integral');
				break;
			case 3:
				$del_where = array('id',$ids);
				$this->main_data_model->delete($del_where,2,'integral');
				break;
			
			default:
				# code...
				break;
		}

		redirect($location);
	}

	/* 
	*移动评分标准
	*
	*/
	public function move_stan(){
		if($_POST){
			$sheet = substr($_POST['sheet'],0,-1);
			$type=intval($_POST['type']);
			if($type>=0){
			$this->employee_model->move_stan($sheet,$type);
			};
			redirect(module_folder(5).'/marking/standard');
		}
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
		
		
		$urls =site_url(module_folder(5)."/marking/index?".$param_url);
		
		return $urls;
	}

	/**
	 * 导航条处理
	 */
	public function menuProcess($param='',$type)
	{	

		switch ($type) {
			case 1:  //首页
				$url[0]=array('评分管理', site_url(module_folder(5).'/marking/index/'));
				$url[1]=array('评分管理分页',site_url(module_folder(5).'/marking/index?&per_page='.$param));
				break;
			case 2:
				$url= unserialize(getcookie_crm('url'));
				if(isset($url[3])){
					unset($url[3]);
				}
				$url[2]=array('评分详情', site_url(module_folder(5).'/marking/detail/'.$param));
				break;
			case 3:
				$url= unserialize(getcookie_crm('url'));
				if(isset($url[3])){
					unset($url[3]);
				}
				$url[2]=array('评分标准列表', site_url(module_folder(5).'/marking/standard/'));
				break;
			case 4:  //评分
				$url= unserialize(getcookie_crm('url'));
				if(isset($url[3])){
					unset($url[3]);
				}
				$url[2]=array('员工评分', site_url(module_folder(5).'/marking/edit/'.$param));
				break;
			case 5:
				$url= unserialize(getcookie_crm('url'));
				$url[3]=array('编辑评分标准', site_url(module_folder(5).'/marking/edit_stand/'.$param));
				break;
			case 6:
				$url= unserialize(getcookie_crm('url'));
				$url[3]=array('添加评分标准', site_url(module_folder(5).'/marking/add_stand/'.$param));
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