<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_student_record_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('consultant_record');
	}

	public function index()
	{
		#查询某个学生的咨询记录
		$consultant_id = $this->uri->segment(5);

		//检查咨询者所属者
		$this->_checkPower($consultant_id);

		#导航条处理
		$this->menuProcess($consultant_id);
		$count=$this->main_data_model->count(array('consultant_id'=>$consultant_id));
		if ($count==0) {
			gorecord("亲,还没有此学员的咨询记录哦",$consultant_id,1);
		}
		$page = $this->uri->segment(6, 1);
		$limit=10;
		$start=($page-1)*$limit;
		$field='*';
		$where=array('consultant_record.consultant_id'=>$consultant_id);#条件
		$orders='consultant_record_time desc';
		$join = array('student_name,student_id','student','consultant_record.consultant_id = student.consultant_id','left');
		$list = $this->main_data_model->select($field,$where,$orders,$start,$limit,$join);
		
		//查询手机号码、QQ号码
		$phone_qq_where = array('consultant_id'=>$consultant_id,'student_id'=>$list[0]['student_id']);
		$res['phone_infos'] = $this->main_data_model->getOtherAll($field,$phone_qq_where,'consul_stu_phones');

		$res['qq_infos'] = $this->main_data_model->getOtherAll($field,$phone_qq_where,'consul_stu_qq');

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
		$config['base_url'] = site_url(module_folder(2).'/student_record/index/'.$consultant_id.'/');
		$config['total_rows'] =$this->main_data_model->setTable('consultant_record')->count($where);
		$config['per_page'] = $limit; 
		$config['uri_segment'] = 6;
		$config['num_links'] = 4;
		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();

		#查询此学生是否已经上门
		$where=array('consultant_id'=>$consultant_id);

		$set_view_time=$this->main_data_model->getOne($where,'consultant_set_view_time','consultant');
		#查询此咨询者是否已经报名
		$signup=$this->main_data_model->getOne($where,'sign_up_date','student');

		$data=array(
			'list'=>$list,
			'set_view_time'=>$set_view_time,
			'signup'=>$signup,
			'page'=>$page,
			'info'=>$res
		);
		$this->load->view('student_record_list',$data);

	}
	/**
	 * 导航条处理
	 */
	private function menuProcess($student_id)
	{	

		$url= unserialize(getcookie_crm('url'));

		$page = $this->uri->segment(6, 1);

		$url[2]=array('咨询记录',site_url(module_folder(2).'/student_record/index/'.$student_id.'/'.$page));

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
			show_message('权限不对',site_url(module_folder(2).'/student/index/index/0'));
		}

		$this->load->model('consultant_model');

		$res= $this->consultant_model->checkData($id,$type);

		
		if ($res===0) {
			if($is_ajax=='ajax'){
				return 0;//表示操作了非法数据	
			}else{
				show_message('权限不对',site_url(module_folder(2).'/student/index/index/0'));
			}
		
		}else{
			return 1;
		}

	}


	/**
	 * 添加学生的咨询记录
	 */
	public function add()
	{
		$check=array(
			array('description','咨询记录'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			$data['uid'] = $this->uri->segment(5,0);
			$where=array('consultant_id'=>$data['uid']);

			//检查咨询者所属者
			$this->_checkPower($data['uid']);

			$data['name'] = $this->main_data_model->setTable('student')->getOne($where,'student_name,employee_id');
			$data['viewtime_status'] = $this->main_data_model->getOne($where,'consultant_set_view,is_student','consultant');
	   		$this->load->view('student_record_add',$data);
	  	}else{
	  		$uid = $this->input->post('uid');
	  		$description = $this->input->post("description");
			$day = strtotime($this->input->post("day"));
			$visit = $this->input->post('visit') ? intval($this->input->post('visit')) : '';
			$is_student = 1;
			$data = array(
				'consultant_id'=>$uid,
				'is_student'=>$is_student,
				'consultant_record_desc'=>$description,
				'consultant_record_time'=>$day,
			);
		
	  		$result = $this->main_data_model->insert($data,'consultant_record');

	  		#修改咨询时间
	  		$this->_editConsultantFirsttime($uid);

	  		#更新已上门状态和时间
	  		$where=array('consultant_id'=>$uid);
  			if($visit===1){
  				$status=array('consultant_set_view'=>1,'consultant_set_view_time'=>$day);
  				$this->main_data_model->update($where,$status,'consultant');
  			}

  			#提醒备注
  			$is_set_view = $this->input->post("is_set_view");
	  		$is_important = $this->input->post("is_important");
	  		$remind_remark = $this->input->post("remind_remark");

	  		#时间提醒
			$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");
			$employee_id = $this->input->post("employee_id");

			if(!empty($_POST['remind_date']) && !empty($_POST['remind_time'])){
				$remindtime = strtotime($remind_date.' '.$remind_time);
				$time_remind_status = 0;
			}else{
				$remindtime = 0;
				$time_remind_status = -1;
			}

			$remind_data = array(
				'time_remind_content'=>$description,
				'time_remind_time'=>$remindtime,
				'consultant_record_id'=>$result,
				'consultant_id'=>$uid,
				'employee_id'=>$employee_id,
				'time_remind_status'=>$time_remind_status,
				'remind_remark'=>$remind_remark,
				'is_set_view'=>$is_set_view,
				'is_important'=>$is_important
			);
	  		$insert_id = $this->main_data_model->setTable('time_remind')->insert($remind_data);

	  		//如果是上门的，要同步更新到教务统计中
			if(!empty($uid) && $is_set_view == 1 && $time_remind_status == 0){ 
				$set_view_data = array(
					'consultant_id'=>$uid,
					'remind_remark'=>$remind_remark,
					'employee_id'=>$employee_id,
					'time_remind_id'=>$insert_id
				);
				$this->main_data_model->insert($set_view_data,'setview_consultant_record');
			}
			
			if($result>0){
				show_message('添加成功！',site_url(module_folder(2).'/student_record/index/'.$uid));	
	  		}else{
	  			show_message('添加失败！');
	  		}
	  	}
	}

	/**
	 *  修改咨询者咨询时间
	 */
	private function _editConsultantFirsttime($uid)
	{

		$this->load->model('consultant_record_model','consultant_record');

		$time= $this->consultant_record->selectfirsttime($uid);

		if(!empty($time)){

			$update=array(
				'consultant_firsttime'=>$time['consultant_record_time']
				);
			$where=array('consultant_id'=>$uid);

			$this->main_data_model->update($where,$update,'consultant');

		}			

	}

	/**
	 * 编辑咨询记录
	 */
	public function edit()
	{
		$check=array(
			array('description','咨询记录'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			#获取学员姓名
			$data['uid'] = $this->uri->segment(5,0);

			//检查咨询者所属者
			$this->_checkPower($data['uid']);

			$data['name'] = $this->main_data_model->setTable('student')->getOne(array('consultant_id'=>$data['uid']),'student_name,employee_id');
			$data['viewtime'] = $this->main_data_model->getOne(array('consultant_id'=>$data['uid']),'consultant_set_view,consultant_set_view_time,is_student','consultant');
			$data['signup'] = $this->main_data_model->getOne(array('consultant_id'=>$data['uid']),'sign_up_date','student');
			#获取学员咨询记录信息
			$id = $this->uri->segment(6,0);	
			$data['list']=$this->main_data_model->setTable('consultant_record')->getOne("consultant_record_id = '{$id}'");

			if(isset($_SERVER['HTTP_REFERER'])){
				$data['location']=$_SERVER['HTTP_REFERER'];
			}else{
				$data['location']=site_url(module_folder(2).'/student_record/index/'.$data['uid']);	
			}
			$data['rem']=$this->main_data_model->setTable('time_remind')->getOne(array('consultant_record_id'=>$id));

			if($data['rem']['is_set_view'] == 1){
				$data['record_info'] = $this->main_data_model->getOne(array('time_remind_id'=>$data['rem']['time_remind_id']),'*','setview_consultant_record');
			}else{
				$data['record_info'] = '';
			}

	   		$this->load->view('student_record_edit',$data);
	  	}else{
	  		$location = $this->input->post('location');
	  		$id = $this->input->post('id');
	  		$uid = $this->input->post('uid');
	  		$description = $this->input->post("description");
			$day = strtotime($this->input->post("day"));
			$visit = $this->input->post('visit') ? intval($this->input->post('visit')) : '';
			$is_student = 1;
			$data = array(
				'consultant_id'=>$uid,
				'is_student'=>$is_student,
				'consultant_record_desc'=>$description,
				'consultant_record_time'=>$day,
			);
		
	  		$result = $this->main_data_model->update("consultant_record_id = '{$id}'",$data);
	  		#更新已上门状态
	  		$where=array('consultant_id'=>$uid);
  			if($visit===1){			
  				$status=array('consultant_set_view'=>1,'consultant_set_view_time'=>$day);
  				$this->main_data_model->update($where,$status,'consultant');
  			}else if($visit===2){
  				$status=array('consultant_set_view'=>0,'consultant_set_view_time'=>0);
  				$this->main_data_model->update($where,$status,'consultant');
  			}

  			#提醒备注
  			$record_id = $this->input->post('record_id');
  			$is_set_view = $this->input->post("is_set_view");
	  		$is_important = $this->input->post("is_important");
	  		$remind_remark = $this->input->post("remind_remark");

			#时间提醒
			$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");
			$employee_id = $this->input->post("employee_id");

			if(!empty($_POST['remind_date']) && !empty($_POST['remind_time'])){	
				$remindtime = strtotime($remind_date.' '.$remind_time);
				$time_remind_status = 0;
			}else{
				$remindtime = 0;
				$time_remind_status = -1;
			}
			$remind_data = array(
				'time_remind_content'=>$description,
				'time_remind_time'=>$remindtime,
				'consultant_record_id'=>$id,
				'consultant_id'=>$uid,
				'employee_id'=>$employee_id,
				'time_remind_status'=>$time_remind_status,
				'is_set_view'=>$is_set_view,
				'is_important'=>$is_important,
				'remind_remark'=>$remind_remark
			);

			//查询之前是否有咨询记录提醒
			$where_record=array('consultant_record_id'=>$id);
			$res_record=$this->main_data_model->getOne($where_record,'consultant_record_id,time_remind_id','time_remind');
			#判断是更新还是增加操作
	  		if($res_record){
				$this->main_data_model->update($where_record,$remind_data,'time_remind');
				$remind_id = $res_record['time_remind_id'];
			}else{
				$remind_id = $this->main_data_model->insert($remind_data,'time_remind');
			}

			if($time_remind_status == 0){
				#更新教务统计记录
				if(!empty($record_id) && $is_set_view==1){
					#查询是否有教务统计记录
					$update_data = array('remind_remark'=>$remind_remark);
					$this->main_data_model->update(array('record_id'=>$record_id),$update_data,'setview_consultant_record');	
				}else if(empty($record_id) && $is_set_view==1 && !empty($uid)){
					$insert_data = array(
							'consultant_id'=>$uid,
	  						'remind_remark'=>$remind_remark,
	  						'employee_id'=>$employee_id,
	  						'time_remind_id'=>$remind_id
						);
					$this->main_data_model->insert($insert_data,'setview_consultant_record');	
				}else if(!empty($record_id) && $is_set_view==0){
					$this->main_data_model->delete(array('record_id'=>$record_id),1,'setview_consultant_record');
				}
			}
				
			show_message('修改成功!',$location);
			// if ($result>0) {
			// 	show_message('修改成功!',$location);	
			// }else{
			// 	redirect(site_url(module_folder(2).'/student_record/index/'.$uid));
			// }
	  	}
	}
	/**
	 * 删除咨询记录
	 */
	public function delete()
	{
		$uid = $this->input->post('uid');//学生id
	
		$cid = $this->input->post('cid');	//学生对应的咨询者id
		$id = $this->input->post('id'); 	//咨询记录id

		//检查咨询者所属者
		$this->_checkPower($cid);

		$this->load->model('consultant_record_model');
		$res= $this->consultant_record_model->deleteRecord($cid,$id);
		

		//同步删除提醒
		foreach ($id as $v) {
			$where = array('consultant_record_id'=>$v);	
			$status = array('time_remind_status'=>-1,'time_remind_time'=>0);
			//查询提醒表有没有对应的咨询记录，有就删除
			$res_record=$this->main_data_model->getOne($where,'consultant_record_id','time_remind');
			if($res_record){
				$this->main_data_model->update($where,$status,'time_remind');
			}
			
		}	
		
		$count = $this->main_data_model->count(array('consultant_id'=>$cid));
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
}