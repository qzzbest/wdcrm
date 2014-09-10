<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market_market_record_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('market_record');
		$this->load->model('market_record_model','market_record');
	}

	public function index()
	{
		//接收分页
		$data['cur_pag']=$page=$this->input->get('per_page') ? $this->input->get('per_page'):1;
		
		$market_id = $this->uri->segment(5);

		//检查咨询者所属者
		$this->_checkPower($market_id);
		#导航条处理
		$this->menuProcess($market_id);

		$count = $this->market_record->select_index_count($market_id);
		if ($count==0) {
			gorecord("亲,还没有此市场资源的咨询记录哦",$market_id,4);
		}
			
		$limit = 20;
		$start = ($page-1) * $limit;
		//查找列表
		$list = $this->market_record->select_index($start,$limit,$market_id);
		
		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		foreach ($list as $k => $value) {
			$list[$k]['serial_number']=$number[$k];//每条数据对应当前页的每一个值
		}
		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(6).'/market_record/index/'.$market_id.'?');
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['uri_segment'] = 7;
		$config['num_links'] = 5;
		$config['page_query_string'] = true;
		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$where=array('market_id'=>$market_id);
		$name = $this->main_data_model->setTable('market')->getOne($where,'school');
		$data=array(
			'list'=>$list,
			'create_page'=>$create_page,
			'market_id'=>$market_id,
			'name'=>$name,
		);

		$this->load->view('market_record_list',$data);
	}

	public function add()
	{
		$check=array(
			array('description','咨询记录'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			$data['uid'] = $this->uri->segment(5,0);
			$where=array('market_id'=>$data['uid']);

			//检查咨询者所属者
			$this->_checkPower($data['uid']);

			//获取学校名称
			$data['name'] = $this->main_data_model->setTable('market')->getOne($where,'school,employee_id');
	   		$this->load->view('market_record_add',$data);
	  	}else{
	  		$uid = $this->input->post('uid');
	  		$description = $this->input->post("description");
			$day = strtotime($this->input->post("day"));
			//时间提醒
			$employee_id = $this->input->post("employee_id");
			$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");

			$remind_remark = $this->input->post("remind_remark");
			//$is_important = $this->input->post("is_important");

			if(!empty($_POST['remind_date']) && !empty($_POST['remind_time'])){
				$remindtime = strtotime($remind_date.' '.$remind_time);
				$time_remind_status = 0;
			}else{
				$remindtime = 0;
				$time_remind_status = -1;
			}

			$data = array(
				'market_id'=>$uid,
				'market_record_desc'=>$description,
				'market_record_time'=>$day,
			);
			//添加咨询记录
	  		$result = $this->main_data_model->insert($data,'market_record');

	  		//添加提醒
	  		$remind_data = array(
				'employee_id'=>$employee_id,
				'market_id'=>$uid,
				'market_record_id'=>$result,
				'time_remind_content'=>$description,
				'time_remind_time'=>$remindtime,
				'time_remind_status'=>$time_remind_status,
				'remind_remark'=>$remind_remark
			);

	  		$this->main_data_model->setTable('time_remind')->insert($remind_data);

			if($result>0){
				show_message('添加成功！',site_url(module_folder(6).'/market_record/index/'.$uid));	
	  		}else{
	  			show_message('添加失败！');
	  		}
	  	}
	}

	public function edit()
	{
		$check=array(
			array('description','咨询记录'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			$data['uid'] = $this->uri->segment(5,0);
			$where=array('market_id'=>$data['uid']);

			//检查咨询者所属者
			$this->_checkPower($data['uid']);

			//获取学校名称
			$data['name'] = $this->main_data_model->setTable('market')->getOne($where,'school,employee_id');

			#获取咨询记录信息
			$record_id = $this->uri->segment(6,0);	
			$data['info']=$this->market_record->select_one($record_id);

			if(isset($_SERVER['HTTP_REFERER'])){
				$data['location']=$_SERVER['HTTP_REFERER'];
			}else{
				$data['location']=site_url(module_folder(6).'/market_record/index/'.$data['uid']);	
			}
			#获取提醒信息
			$data['rem']=$this->main_data_model->setTable('time_remind')->getOne(array('market_record_id'=>$record_id));

	   		$this->load->view('market_record_edit',$data);
	  	}else{
	  		$location = $this->input->post('location');
	  		$id = $this->input->post('id');
	  		$uid = $this->input->post('uid');
	  		$description = $this->input->post("description");
			$day = strtotime($this->input->post("day"));
			//时间提醒
			$employee_id = $this->input->post("employee_id");
			$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");

			$remind_remark = $this->input->post("remind_remark");
			//$is_important = $this->input->post("is_important");

			$data = array(
				'market_id'=>$uid,
				'market_record_desc'=>$description,
				'market_record_time'=>$day,
			);
			//echo '<pre>';print_r($_POST);die;
			//更新咨询记录
			$where_update = array('market_record_id' =>$id);
	  		$result = $this->main_data_model->update($where_update,$data);

	  		if(!empty($_POST['remind_date']) && !empty($_POST['remind_time'])){	
				$remindtime = strtotime($remind_date.' '.$remind_time);
				$time_remind_status = 0;
			}else{
				$remindtime = 0;
				$time_remind_status = -1;
			}
			$remind_data = array(
				'employee_id'=>$employee_id,
				'market_id'=>$uid,
				'time_remind_content'=>$description,
				'time_remind_time'=>$remindtime,
				'time_remind_status'=>$time_remind_status,
				'remind_remark'=>$remind_remark
			);

			//查询之前是否有咨询记录提醒
			$where_record=array('market_record_id'=>$id);
			$res_record=$this->main_data_model->getOne($where_record,'market_record_id,time_remind_id','time_remind');

			#判断是更新还是增加操作
	  		if($res_record){
				$remind_id = $this->main_data_model->update($where_record,$remind_data,'time_remind');
			}else{
				$remind_id = $this->main_data_model->insert($remind_data,'time_remind');
			}

			if ($result>0 || $res_record>0) {
				show_message('修改成功!',$location);
			}else{
				redirect(site_url(module_folder(6).'/market_record/index/'.$uid));
			}
	  	}
	}

	/**
	 * 删除咨询记录
	 */
	public function delete()
	{
		//接收市场id和记录id
		$mid = $this->input->post('mid');
		$id = $this->input->post('id');
		
		//检查咨询者所属者
		$this->_checkPower($mid);

		$res = $this->market_record->delete_record($mid,$id);

		//判断总数,作用跳转地址
		$count = $this->main_data_model->count(array('market_id'=>$mid));
		$url= unserialize(getcookie_crm('url'));
		if($count>0){
			$location=$url[2][1];
		}else{
			$location=$url[1][1];
		}
		
		if($res>0){
  			show_message('删除成功!',$location);
  		}else{
  			show_message('删除失败!');
  		}
	}
	/**
	 * 导航条处理
	 */
	public function menuProcess($market_id)
	{	
		$url = unserialize(getcookie_crm('url'));

		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		$url[2]=array('咨询记录',site_url(module_folder(6).'/market_record/index/'.$market_id.'?&per_page='.$page));

		//之前是这么做
		//$_COOKIE['url']=serialize($url);
		//加密处理
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');
		setcookie_crm('url',serialize($url));
		
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
			show_message('权限不对',site_url(module_folder(6).'/market/index'));
		}

		$this->load->model('market_model');

		$res= $this->market_model->checkData($id,$type);

		
		if ($res===0) {
			if($is_ajax=='ajax'){
				return 0;//表示操作了非法数据	
			}else{
				show_message('权限不对',site_url(module_folder(6).'/market/index'));
			}
		
		}else{
			return 1;
		}

	}
}