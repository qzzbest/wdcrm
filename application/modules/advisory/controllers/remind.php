<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_remind_module extends CI_Module {

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

		#搜索
		$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';	
		$param_url['search']=$search;

		#搜索分类
		$key= $this->input->get('key');
		$param_url['key']=$key;

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

		//咨询者姓名查找
		if($key=='consultant_name'){
			$list=$this->time_remind_model->select_consultant($employee_id,$search,$start,$limit,$start_time,$end_time);
			$count=$this->time_remind_model->select_consultant_count($search,$employee_id,$start_time,$end_time);
		}
		//联系方式查找
		if($key=='qq' || $key=='phones'){
			
			$model="consul_stu_{$key}_model";
			$this->load->model($model,'contact');
			
			$data_s=$this->contact->select($search);
			$data_s=$this->_dataProcess($data_s,'consultant_id');
			$count=count($data_s);
			if ($count==0) {
				show_message('没有查询到相关的信息。');
			}
						
			$list=$this->time_remind_model->select_contact_like($data_s,$start,$limit,$employee_id,$start_time,$end_time);
			$count=$this->time_remind_model->select_contact_count($data_s,$employee_id,$start_time,$end_time);
		}
		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		$remind_id=array();
		foreach($list as $k=>$v){
			#序号
			$list[$k]['serial_number']=$number[$k];
			#姓名
			$list[$k]['consultant']= $this->main_data_model->setTable('consultant')
										->getOne(array('consultant_id'=>$v['consultant_id']),'consultant_name');
			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('consultant_id'=>$v['consultant_id']));
		
			
			$list[$k]['phone']=$this->_dataProcess($tmp,'phone_number');
			
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('consultant_id'=>$v['consultant_id']));
			
			
			$list[$k]['qq']=$this->_dataProcess($tmp,'qq_number');

			//上门的
			if ($v['is_set_view']==1) {
				$remind_id[]=$v['time_remind_id'];
			}	
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
			'key'=>$key,
			'search'=>$search,
			'remind_id'=>json_encode($remind_id)
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
		
		
		$urls =site_url(module_folder(2)."/remind/index?".$param_url);
		
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
	  		$is_set_view = $this->input->post("is_set_view");
	  		$is_important = $this->input->post("is_important");
	  		$remind_remark = $this->input->post("remind_remark");

	  		$con_stu_name = $this->input->post("con_stu_name");
	  		$con_stu_phone = $this->input->post("con_stu_phone");
	  		$con_stu_qq = $this->input->post("con_stu_qq");
	  		
	  		$remind_content = $this->input->post("remind_content");
	  		$remind_date = $this->input->post("remind_date");
	  		$remind_time = $this->input->post("remind_time");
	  		$time_remind_status = 0;

	  		$res = array();
	  		#通过输入的手机号码/qq号码/姓名查询改咨询者、学员（同步）	
	  	

	 

	  

	  		#批量提醒
	  		foreach($remind_content as $k=>$v){

	  			if(!empty($con_stu_name[$k])){

	  				$info = $this->main_data_model->getOne(array('consultant_name'=>trim($con_stu_name[$k])),'consultant_id','consultant');
	  				$consultant_id = $info['consultant_id'];
	  			}else if(!empty($con_stu_phone[$k])){

	  				$info = $this->main_data_model->getOne(array('phone_number'=>trim($con_stu_phone[$k])),'consultant_id','consul_stu_phones');
	  				$consultant_id = $info['consultant_id'];

	  			}else if(!empty($con_stu_qq[$k])){

	  				$info = $this->main_data_model->getOne(array('qq_number'=>trim($con_stu_qq[$k])),'consultant_id','consul_stu_qq');	
	  				$consultant_id = $info['consultant_id'];	
	  			}else{
	  				$consultant_id = 0;
	  			}

	  			if($consultant_id != 0){
	  				$where_id = array('consultant_id'=>$info['consultant_id']);
					$consultant_info = $this->main_data_model->getOne($where_id,'consultant_name','consultant');
					$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
					$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
					//分割数组
					$phone=$this->_dataProcess($phone_infos,'phone_number');
					$phone=implode(',', $phone);
					$qq=$this->_dataProcess($qq_infos,'qq_number');
					$qq=implode(',', $qq);
					$consultant_info = "姓名: ".$consultant_info['consultant_name']."&nbsp;&nbsp;手机号码: ".$phone."&nbsp;&nbsp;QQ号码: ".$qq;
	  			}else{
	  				$consultant_info = '';
	  			}
	  			

	  			$data=array(
					'employee_id'=>getcookie_crm('employee_id'),
  					'time_remind_content'=>$remind_content[$k],
  					'time_remind_time'=>strtotime($remind_date[$k].' '.$remind_time[$k]),
  					'time_remind_status'=>$time_remind_status,
  					'consultant_id'=>$consultant_id,
  					'consultant_info'=>$consultant_info,
  					'remind_remark'=>$remind_remark[$k],
  					'is_set_view'=>$is_set_view[$k],
  					'is_important'=>$is_important[$k]
  				);

	  			$insert_id=$this->main_data_model->insert($data,'time_remind');

	  			//如果是上门的，要同步更新到教务统计中
  				if(!empty($consultant_info) && $is_set_view[$k] == 1){ 
  					$set_view_data = array(
  						'consultant_id'=>$info['consultant_id'],
  						'remind_remark'=>$remind_remark[$k],
  						'employee_id'=>getcookie_crm('employee_id'),
  						'time_remind_id'=>$insert_id
  					);
  					$this->main_data_model->insert($set_view_data,'setview_consultant_record');
  				}
  				

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

			if($data['list']['consultant_id']!=0){
				$where_id = array('consultant_id'=>$data['list']['consultant_id']);
				$consultant_info = $this->main_data_model->getOne($where_id,'consultant_name','consultant');
				$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
				$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
				//分割数组
				$phone=$this->_dataProcess($phone_infos,'phone_number');
				$phone=implode(',', $phone);
				$qq=$this->_dataProcess($qq_infos,'qq_number');
				$qq=implode(',', $qq);
				$consultant_info = "姓名: ".$consultant_info['consultant_name']."&nbsp;&nbsp;手机号码: ".$phone."&nbsp;&nbsp;QQ号码: ".$qq;
				$data['consultant_info'] = $consultant_info;

				$data['consultant_id'] = $data['list']['consultant_id'];

				if($data['list']['is_set_view'] == 1){
					$data['record_info'] = $this->main_data_model->getOne(array('time_remind_id'=>$data['list']['time_remind_id']),'*','setview_consultant_record');
				}else{
					$data['record_info'] = '';
				}
				
			}else{ 
				$data['consultant_id'] = '';
				$data['consultant_info'] = '';
				$data['record_info'] = '';
			}	

	   		$this->load->view('time_remind_edit',$data);
	  	}else{

	  		//获取跳转地址
			$url=unserialize(getcookie_crm('url'));
			$location=$url[1][1];

	  		//更新
	  		$record_id = $this->input->post('record_id');
	  		$consultant_id = $this->input->post('consultant_id');
	  		
	  		$remind_id = $this->input->post('id');
	  		$remind_content = $this->input->post("remind_content");
	  		$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");
			$remindtime = strtotime($remind_date.' '.$remind_time);

			$is_set_view = $this->input->post("is_set_view");
	  		$is_important = $this->input->post("is_important");
	  		$remind_remark = $this->input->post("remind_remark") ? $this->input->post("remind_remark") : '';;

			if(!empty($record_id) && $is_set_view==1){
				#查询是否有教务统计记录
				$update_data = array('remind_remark'=>$remind_remark);
				$this->main_data_model->update(array('record_id'=>$record_id),$update_data,'setview_consultant_record');	
			}else if(empty($record_id) && $is_set_view==1 && !empty($consultant_id)){
				$insert_data = array(
						'consultant_id'=>$consultant_id,
  						'remind_remark'=>$remind_remark,
  						'employee_id'=>getcookie_crm('employee_id'),
  						'time_remind_id'=>$remind_id
					);
				$this->main_data_model->insert($insert_data,'setview_consultant_record');	
			}else if(!empty($record_id) && $is_set_view==0){
				$this->main_data_model->delete(array('record_id'=>$record_id),1,'setview_consultant_record');
			}	

			$data_remind=array(
				'time_remind_content'=>$remind_content,
				'time_remind_time'=>$remindtime,
				'is_set_view'=>$is_set_view,
				'is_important'=>$is_important,
				'remind_remark'=>$remind_remark
				);

			$where_remind = array('time_remind_id'=>$remind_id,'employee_id'=>getcookie_crm('employee_id'));
			$res=$this->main_data_model->update($where_remind,$data_remind,'time_remind');

	  		/*$remind_id = $this->input->post('id');
	  		$consultant_id = $this->input->post('consultant_id');
	  		$student_id = $this->input->post('student_id');
	  		$consultant_record_id = $this->input->post('consultant_record_id');
	  		$repayment_id = $this->input->post('repayment_id');
	  		$remind_content = $this->input->post("remind_content");
	  		$remind_date = $this->input->post("remind_date");
	  		$remind_time = $this->input->post("remind_time");
	  		$time_remind_status = 0;

			$data=array();
	  		foreach($remind_content as $k=>$v){
	  			$data[]=array(
					'employee_id'=>getcookie_crm('employee_id'),
  					'time_remind_content'=>$remind_content[$k],
  					'time_remind_time'=>strtotime($remind_date[$k].' '.$remind_time[$k]),
  					'time_remind_status'=>$time_remind_status,
  					'consultant_id'=>$consultant_id[$k],
  					'student_id'=>$student_id[$k],
  					'consultant_record_id'=>$consultant_record_id[$k],
  					'repayment_id'=>intval($repayment_id[$k])
  				);
	  		}

	  		$this->main_data_model->delete(array('time_remind_id',$remind_id),2,'time_remind');
			$res=$this->main_data_model->insert_batch($data,'time_remind');*/

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
		$remind_ids = $this->input->post("ids");
		if ($this->form_validation->run() == FALSE && empty($remind_ids)){

			$id=$this->input->post('id');
			$this->load->model('time_remind_model');
			$data['list']= $this->time_remind_model->select($id);
			$ids = array();
			$record_ids = array();
			foreach ($data['list'] as $key => $value) {
				$ids[] = $value['time_remind_id'];

				if($value['consultant_id'] != 0){
					$where_id = array('consultant_id'=>$value['consultant_id']);
					$consultant_info = $this->main_data_model->getOne($where_id,'consultant_name','consultant');
					$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
					$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
					//分割数组
					$phone=$this->_dataProcess($phone_infos,'phone_number');
					$phone=implode(',', $phone);
					$qq=$this->_dataProcess($qq_infos,'qq_number');
					$qq=implode(',', $qq);
					$consultant_info = "姓名: ".$consultant_info['consultant_name']."&nbsp;&nbsp;手机号码: ".$phone."&nbsp;&nbsp;QQ号码: ".$qq;
					$data['list'][$key]['consultant_info'] = $consultant_info;

					if($value['is_set_view'] == 1){
						$record_info = $this->main_data_model->getOne(array('time_remind_id'=>$value['time_remind_id']),'*','setview_consultant_record');
						if(!empty($record_info)){
							$record_ids[] = $record_info['record_id'];
						}else{
							$record_ids[] = 0;
						}
						
					}else{
						$record_ids[] = 0;
					}
				}else{
					$data['list'][$key]['consultant_info'] = '';
				}
				
			}
			$data['ids'] = implode(',', $ids);
			$data['record_ids'] = implode(',', $record_ids);
	   		$this->load->view('time_remind_alledit',$data);
	  	}else{

	  		//获取跳转地址
			$url=unserialize(getcookie_crm('url'));
			$location=$url[1][1];

	  		$remind_id = $this->input->post("id");
	  		$consultant_id = $this->input->post('consultant_id');
	  		$student_id = $this->input->post('student_id');
	  		$consultant_record_id = $this->input->post('consultant_record_id');
	  		$repayment_id = $this->input->post('repayment_id');
	  		$remind_content = $this->input->post("remind_content");
	  		$remind_date = $this->input->post("remind_date");
	  		$remind_time = $this->input->post("remind_time");
	  		$time_remind_status = 0;

	  		$record_ids = $this->input->post("record_ids");
	  		$record_arr = explode(',', $record_ids);

	  		$is_set_view = $this->input->post("is_set_view");
	  		$is_important = $this->input->post("is_important");
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
						$data['consultant_id']=$consultant_id[$k];
						$data['student_id']=$student_id[$k];
						$data['consultant_record_id']=$consultant_record_id[$k];
						$data['repayment_id']=$repayment_id[$k];
						$data['is_set_view']=$is_set_view[$k];
						$data['is_important']=$is_important[$k];
						$data['remind_remark']=$remind_remark[$k];

						$where_remind = array('time_remind_id'=>$remind_id[$k],'employee_id'=>getcookie_crm('employee_id'));
						$this->main_data_model->update($where_remind,$data,'time_remind');

					}

					if($record_arr[$k]!=0 && $is_set_view[$k]==1){
						#查询是否有教务统计记录
						$update_data = array('remind_remark'=>$remind_remark[$k]);
						$this->main_data_model->update(array('record_id'=>$record_arr[$k]),$update_data,'setview_consultant_record');	
					}else if($record_arr[$k]==0 && $is_set_view[$k]==1 && $consultant_id[$k]){
						$insert_data = array(
								'consultant_id'=>$consultant_id[$k],
		  						'remind_remark'=>$remind_remark[$k],
		  						'employee_id'=>getcookie_crm('employee_id'),
		  						'time_remind_id'=>$remind_id[$k]
							);
						$this->main_data_model->insert($insert_data,'setview_consultant_record');	
					}else if($record_arr[$k] != 0 && $is_set_view[$k]==0){
						$this->main_data_model->delete(array('record_id'=>$record_arr[$k]),1,'setview_consultant_record');
					}	
				}
				
			}
			
			show_message('修改成功!',$location); //如果没有更新内容，直接提示跳转
	  	}
	}
	
	/**
	 * 更改提醒状态
	 */
	/*public function delete()
	{

		$id = $this->input->post('id');
		#删除到最后一条时会出错
		$num = 0;
		if (!empty($id)) {
			foreach ($id as $key => $value) {
				$count = $this->main_data_model->count(array('time_remind_id'=>$value));
				if($count != 0){
					$num ++;
				}
			}
		}
		
		if ($num == 0) {
			show_message("无效参数");
		}

		#批量删除学员
		$result = $this->main_data_model->delete(array('time_remind_id',$id),2);
		
		if($result>0){
  			show_message('操作成功!',site_url(module_folder(2).'/remind/index'));	
  		}else{
  			show_message('操作失败!');
  		}

	}*/
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
			show_message('权限不对',site_url(module_folder(2).'/remind/index'));
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
	 * 咨询者提醒的信息 (这个方法还未修改 数据所有者检验)
	 */
	public function remindConsultantInfo()
	{	
		header("Content-Type:text/html;charset=utf-8");
		
		$client = $this->uri->segment(5, 0);

		$id= $this->input->post("id");

		$type= $this->input->post("type");

		$where_remind = array();
		if($client){
			$where_remind = array('is_client'=>1);
		}

		if($type == 'self'){//右上角的提醒
			$where=array('time_remind_id'=>$id)+$where_remind;
			//通过提醒ID查咨询者ID
			$remind = $this->main_data_model->getOne($where,'','time_remind');
			$where_id = array('consultant_id'=>$remind['consultant_id']);

			$consultant_id=$remind['consultant_id'];
		}else{//咨询列表的咨询者ID
			$where=array('consultant_id'=>$id,'student_id'=>0,'time_remind_status'=>0)+$where_remind;
			$where_id = array('consultant_id'=>$id);
			$remind = $this->main_data_model->getOne($where,'','time_remind');

			$consultant_id=$id;
		}
		
		//检查咨询者所属者
		if($consultant_id){
			$check_result = $this->_checkPower($consultant_id,'','ajax');
			if(!$check_result){ //如果返回的是 0,这个
				$res['status']=0;
				echo json_encode($res);
				exit;
			}	
		}	

	
		$remind['day'] = date("Y-m-d",$remind['time_remind_time']);
		$remind['time'] = date("H:i:s",$remind['time_remind_time']);
		$remind['consultant_id'] = $consultant_id;

		#查询咨询者的姓名,手机,QQ加入到提醒内容		
		$consultant_info = $this->main_data_model->getOne($where_id,'consultant_name','consultant');
		$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
		$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');

		//分割数组
		$phone=$this->_dataProcess($phone_infos,'phone_number');
		$phone=implode(',', $phone);
		$qq=$this->_dataProcess($qq_infos,'qq_number');
		$qq=implode(',', $qq);

		if( !empty($consultant_info) ){
			$consultantinfo = "姓名: ".$consultant_info['consultant_name']."&nbsp;&nbsp;手机号码: ".$phone."&nbsp;&nbsp;QQ号码: ".$qq;
		}else{
			$consultantinfo = '';
		}

		if($client){
			$del=site_url(module_folder(2).'/remind/deleteConsultantRemind/'.$remind['time_remind_id'].'/client');
		}else{
			$del=site_url(module_folder(2).'/remind/deleteConsultantRemind/'.$remind['time_remind_id']);
		}

		if($type == 'self'){
			$str=<<<HTML

		编辑提醒<span style="float:right;padding-right:10px;" id="del_remind"><a class="btn btn-xs btn-danger" href="$del" class="delete_remind" role="button" >删除</a></span>
	
HTML;
		}else{
			$str=<<<HTML
			<a class="btn btn-xs btn-danger" href="$del" class="delete_remind" role="button" >删除</a>
HTML;
		}
		
		echo json_encode(array('data'=>$remind,'str'=>$str,'consultantinfo'=>$consultantinfo));
		exit;

	}

	/**
	 * 学员提醒的增加,修改
	 */
	public function studentRemind()
	{
		$check=array(
			array('remind_content','提醒内容'),
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
	   		$this->load->view('student_list',$data);
	  	}else{
	  		$remind_student_id = $this->input->post("remind_student_id");
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
			
  			#找到该学生的咨询师和之前的咨询者id
  			$where=array('student_id'=>$remind_student_id);
  			$employee_id= $this->main_data_model->getOne($where,'employee_id,consultant_id','student');

  			//start 2014-6-8 判断操作的时候是否是所属咨询师
  			if($employee_id['employee_id']!=getcookie_crm('employee_id')){
  				show_message('权限不对',site_url(module_folder(2).'/student/index/index/0'));
  			}
  			//end

			$data = array(
				'employee_id'=>$employee_id['employee_id'],
				'consultant_id'=>$employee_id['consultant_id'],
				'student_id'=>$remind_student_id,
				'time_remind_content'=>$remind_content,
				'time_remind_time'=>$remindtime,
				'time_remind_status'=>$time_remind_status,
				'is_set_view'=>$is_set_view,
				'is_important'=>$is_important,
				'remind_remark'=>$remind_remark
			);
			#判断是更新操作还是增加操作
			if(!empty($time_remind_id)){				
				$remind_id = array('time_remind_id'=>$time_remind_id);
				$res=$this->main_data_model->update($remind_id,$data,'time_remind');

				#查询是否存在教务提醒记录
				$record_res = $this->main_data_model->getOne($remind_id,'record_id','setview_consultant_record');

				if(!empty($record_res) && $is_set_view==0){#删除记录		
					$record_where = array('record_id'=>$record_res['record_id']);		
					$this->main_data_model->delete($record_where,1,'setview_consultant_record');
				}else if(!empty($record_res) && $is_set_view==1){ #更新记录
					$record_where = array('record_id'=>$record_res['record_id']);
					$this->main_data_model->update($record_where,array('remind_remark'=>$remind_remark),'setview_consultant_record');
				}else{

					$remind_info = $this->main_data_model->getOne($remind_id,'consultant_id','time_remind');
					if($remind_info['consultant_id']){
						$add_data = array(
							'consultant_id'=>$remind_info['consultant_id'],
							'employee_id'=>$employee_id['employee_id'],
							'remind_remark'=>$remind_remark,
							'time_remind_id'=>$time_remind_id
						);
						$this->main_data_model->insert($add_data,'setview_consultant_record');
					}			
				}	

			}else{
				$res=$this->main_data_model->insert($data);

				if(!empty($employee_id['consultant_id']) && $is_set_view==1){ #添加教务提醒记录

					$add_data = array(
						'consultant_id'=>$employee_id['consultant_id'],
						'employee_id'=>$employee_id['employee_id'],
						'remind_remark'=>$remind_remark,
						'time_remind_id'=>$res
					);

					$this->main_data_model->insert($add_data,'setview_consultant_record');
				}	
			}

	  		if($res>0){
  				show_message('成功!',site_url(module_folder(2).'/student/index'));	
	  		}else{
	  			show_message('失败!');
	  		}
	  	}
	}

	/**
	 * 学员提醒的删除
	 */
	public function deleteStudentRemind()
	{
  		$id = $this->uri->segment(5, 0);
		
		$where=array('time_remind_id'=>$id,'employee_id'=>getcookie_crm('employee_id'));
		$data=array('time_remind_status'=>-1);
		$this->main_data_model->update($where,$data,'time_remind');

		show_message('删除成功!',site_url(module_folder(2).'/student/index'));
		
	}

	/**
	 * 学员提醒的信息
	 */
	public function remindStudentInfo()
	{
		header("Content-Type:text/html;charset=utf-8");
		$id= $this->input->post("id");
		$where=array('student_id'=>$id,'time_remind_status !='=>-1,'employee_id'=>getcookie_crm('employee_id'));
		$remind = $this->main_data_model->getOne($where,'','time_remind');
		$remind['day'] = date("Y-m-d",$remind['time_remind_time']);
		$remind['time'] = date("H:i:s",$remind['time_remind_time']);

		$consultant_id=$remind['consultant_id'];
		//检查咨询者所属者
		$check_result = $this->_checkPower($consultant_id,'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}

		#查询学员的姓名,手机,QQ加入到提醒内容
		$where_id = array('student_id'=>$id);
		$consultant_info = $this->main_data_model->getOne($where_id,'student_name','student');
		$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
		$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
		
		$phone=$this->_dataProcess($phone_infos,'phone_number');
		$phone=implode(',', $phone);
		$qq=$this->_dataProcess($qq_infos,'qq_number');
		$qq=implode(',', $qq);

		if( !empty($consultant_info) ){
			$consultantinfo = "学生姓名: ".$consultant_info['student_name']."&nbsp;&nbsp;手机号码: ".$phone."&nbsp;&nbsp;QQ号码: ".$qq;
		}

		$del=site_url(module_folder(2).'/remind/deleteStudentRemind/'.$remind['time_remind_id']);

		$str=<<<HTML
		<a class="btn btn-xs btn-danger" href="$del" class="delete_remind" role="button" >删除</a>
HTML;
		echo json_encode(array('data'=>$remind,'str'=>$str,'consultantinfo'=>$consultantinfo));
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

	  		//咨询者、学员的信息
	  		$con_stu_name = $this->input->post("con_stu_name");
	  		$con_stu_phone = $this->input->post("con_stu_phone");
	  		$con_stu_qq = $this->input->post("con_stu_qq");

	  		$time_remind_id = $this->input->post("time_remind_id");
	  		$remind_content = $this->input->post("remind_content");
			$remind_date = $this->input->post("remind_date");
			$remind_time = $this->input->post("remind_time");
			$remindtime = strtotime($remind_date.' '.$remind_time);
			$time_remind_status=0;

			#提醒备注、上门、重点跟进
			$is_set_view = $this->input->post("is_set_view");
	  		$is_important = $this->input->post("is_important");
	  		$remind_remark = $this->input->post("remind_remark");

	  		$consultant_id = $this->input->post("consultant_id");
	  		$market_id = $this->input->post("market_id");
			
  			#通过输入的手机号码/qq号码/姓名查询改咨询者、学员（同步）	
  			if(!empty($con_stu_phone)){
  				$res= $this->main_data_model->getOne(array('phone_number'=>trim($con_stu_phone)),'consultant_id','consul_stu_phones');
  			}
  			if( !empty($con_stu_qq) && empty($res) ){

  				$res= $this->main_data_model->getOne(array('qq_number'=>trim($con_stu_qq)),'consultant_id','consul_stu_qq');
  			}

  			if( !empty($con_stu_name) && empty($res) ){

  				$res= $this->main_data_model->getOne(array('consultant_name'=>trim($con_stu_name)),'consultant_id','consultant');
  			}

  			if( !empty($res) ){	//找到咨询者信息

  				$con_stu_info = $this->main_data_model->getOne(array('consultant_id'=>$res['consultant_id']),'employee_id,consultant_id,consultant_name','consultant');

  			}

  			$data = array(
				'employee_id'=>getcookie_crm('employee_id'),
				'time_remind_content'=>$remind_content,
				'time_remind_time'=>$remindtime,
				'time_remind_status'=>$time_remind_status,
				'is_set_view'=>$is_set_view,
				'is_important'=>$is_important,
				'remind_remark'=>$remind_remark
			);

	  		if( !empty($con_stu_name) || !empty($con_stu_phone) || !empty($con_stu_qq) ){
	  				
	  			if(!empty($con_stu_info)){
	  				$where_id = array('consultant_id'=>$con_stu_info['consultant_id']);
	  				$consultant_info = $this->main_data_model->getOne($where_id,'consultant_name','consultant');
					$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
					$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
					//分割数组
					$phone=$this->_dataProcess($phone_infos,'phone_number');
					$phone=implode(',', $phone);
					$qq=$this->_dataProcess($qq_infos,'qq_number');
					$qq=implode(',', $qq);
					$data['consultant_id'] = $con_stu_info['consultant_id'];
					$consultant_info = "姓名: ".$consultant_info['consultant_name']."&nbsp;&nbsp;手机号码: ".$phone."&nbsp;&nbsp;QQ号码: ".$qq;
					$data['consultant_info'] = $consultant_info;

  				}else{
  					show_message('该咨询者/学员不存在，请正确输入信息!');
  				}
  				
  			}else if(!empty($consultant_id)){
  				$data['consultant_id'] = $consultant_id;
  			}else if(!empty($market_id)){
  				$data['market_id'] = $market_id;
  			}

  			$market_job = array(18);
			if( !in_array(getcookie_crm('employee_job_id'),$market_job) ){
	  			#判断是更新操作还是增加操作
				if(!empty($time_remind_id)){			

					$remind_id = array('time_remind_id'=>$time_remind_id,'employee_id'=>getcookie_crm('employee_id'));
					$res=$this->main_data_model->update($remind_id,$data,'time_remind');

					#查询是否存在教务提醒记录
					$record_res = $this->main_data_model->getOne($remind_id,'record_id','setview_consultant_record');
					
					if(!empty($record_res) && $is_set_view==0){#删除记录		
						$record_where = array('record_id'=>$record_res['record_id']);		
						$this->main_data_model->delete($record_where,1,'setview_consultant_record');
					}else if(!empty($record_res) && $is_set_view==1){ #更新记录
						$record_where = array('record_id'=>$record_res['record_id']);
						$this->main_data_model->update($record_where,array('remind_remark'=>$remind_remark),'setview_consultant_record');
					}else{

						$remind_info = $this->main_data_model->getOne($remind_id,'consultant_id','time_remind');
						if($remind_info['consultant_id']){
							$add_data = array(
								'consultant_id'=>$remind_info['consultant_id'],
								'employee_id'=>getcookie_crm('employee_id'),
								'remind_remark'=>$remind_remark,
								'time_remind_id'=>$time_remind_id
							);
							$this->main_data_model->insert($add_data,'setview_consultant_record');
						}			
					}
				}else{
					
					$res=$this->main_data_model->insert($data);

					if(!empty($data['consultant_id']) && $is_set_view==1){ #添加教务提醒记录

						$add_data = array(
							'consultant_id'=>$data['consultant_id'],
							'employee_id'=>getcookie_crm('employee_id'),
							'remind_remark'=>$remind_remark,
							'time_remind_id'=>$res
						);

						$this->main_data_model->insert($add_data,'setview_consultant_record');
					}

				}
			}
			
	  		if($res>0){
  				show_message('成功!',site_url(module_folder(2).'/remind/index'));
	  		}else{
	  			show_message('失败!');
	  		}	
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
		$this->main_data_model->delete($where,1,'setview_consultant_record');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}	

	/**
	 * 导航条处理
	 */
	public function menuProcess($param='',$type)
	{	

		switch ($type) {
			case 1:  
				$url[0]=array('咨询提醒管理', site_url(module_folder(2).'/remind/index'));
				$url[1]=array('咨询提醒列表',site_url(module_folder(2).'/remind/index?&per_page='.$param));
				break;
			case 2:
				$url= unserialize(getcookie_crm('url'));
				$url[2]=array('添加咨询提醒', site_url(module_folder(2).'/remind/add/'));
				break;
			case 3:
				$url= unserialize(getcookie_crm('url'));
				$url[2]=array('修改咨询提醒', site_url(module_folder(2).'/remind/edit/'.$param));
				break;
			case 4:
				$url= unserialize(getcookie_crm('url'));
				$url[2]=array('批量修改咨询提醒', site_url(module_folder(2).'/remind/allEdit/'));
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