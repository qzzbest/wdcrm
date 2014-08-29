<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生操作
 */
class Advisory_student_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
		$this->main_data_model->setTable('student');
	}

	public function index()
	{
		#咨询师
		$this->load->model('employee_model');

		$data['teach']= $this->employee_model->selectDepartment();

		$param_url=array();

		//超级管理员选中的咨询师
		$data['selected_teach']=$selected_teach=trim($this->input->get('teach'))!=''?trim($this->input->get('teach')):'';

		$param_url['teach']=$selected_teach;
		

		//选中知识点查询学员
		$data['selected_knownledge']=$selected_knownledge=trim($this->input->get('knowledge_id'))!=''?trim($this->input->get('knowledge_id')):'';

		$data['study_status']=$study_status=trim($this->input->get('study_status'))!=''?trim($this->input->get('study_status')):'';

		$param_url['knowledge_id']=$selected_knownledge;
		$param_url['study_status']=$study_status;

		//报名时间排序
		$data['order']=$order=trim($this->input->get('order'))!=''?trim($this->input->get('order')):'';
		$param_url['order']=$order;

		//权限限制,如果不是超级管理员，而又选中了某位咨询师，属于不合理状态
		if(getcookie_crm('employee_power')==0 && $selected_teach!=''){
			show_message('权限不对!');
		}

		//查询知识点
		$data['knowledge_info']=$this->main_data_model->getAll('knowledge_id,knowledge_name','knowledge');
		
		#班级类型列表
		$data['curriculum_system']= $this->main_data_model->setTable('curriculum_system')->getAll('*');

		#班级类型ID
		$data['curriculum_system_id']=$curriculum_system_id=trim($this->input->get('curriculum_system_id'))!=''?trim($this->input->get('curriculum_system_id')):'';

		#接收分类
		$type = $this->uri->segment(5, 'index');
		$type_data = $this->uri->segment(6, 0);
		#导航条处理
		$this->menuProcess($type,$type_data);

		#当前页码
		$data['cur_pag']=$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		#搜索
		$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
		$param_url['search']=$search;

		#搜索分类
		$key= $this->input->get('key')?$this->input->get('key'):'student_name';
		$param_url['key']=$key;

		$limit=20;#每页显示多少条
		
		$start=($page-1)*$limit;
		
		//接收日期类型
		$data['select_day']=$select_day=trim($this->input->get('select_day'))!=''?trim($this->input->get('select_day')):'';
		$param_url['select_day']=$select_day;

		#接收日期
		$starttime = $this->input->get('start_time');
		$endtime = $this->input->get('end_time');
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

		#加载学生model
		$this->load->model('student_model','student');
		$this->student->init($selected_teach);
		$this->student->init($selected_knownledge,'k');
		$this->student->init($curriculum_system_id,'c');

		if(!empty($study_status)){
			$this->student->init($study_status,'status'); #0默认  要么1；要么2
		}

		
		if ($type=='index') {//学生列表
			//姓名、学历、学校、专业,如果是这几种，直接查询
			$search_key_type=array('student_name','student_education','student_school','student_specialty');

			if (in_array($key,$search_key_type)) {
				if($select_day==2){
					//回访记录查询列表和总数
					$student_info=$this->student->select_record_time($start,$limit,$start_time,$end_time,$selected_teach);
					$count=$this->student->select_record_time_count($start_time,$end_time,$selected_teach);
				}else{
					$student_info=$this->student->select_index($start,$limit,$key,$search,$start_time,$end_time,$order);
					$count=$this->student->select_index_count($key,$search,$start_time,$end_time);
				}
				
						
			}else{ //先查找可能的这个搜索文字匹配的学生id

				$model="consul_stu_{$key}_model";
				$this->load->model($model,'contact');
				$data=$this->contact->select_student($search);
				$data=$this->_dataProcess($data,'student_id');
				$count=count($data);
				if ($count==0) {
					show_message('没有查询到相关的信息。');
				}
				
				$student_info=$this->student->select_contact_like($data,$start,$limit);

			}
			
		//咨询形式
		}else if(in_array($type, array('consultant_channel_id','consultant_consultate_id'))){
			$tmp=array($type,$type_data);
			$student_info=$this->student->consultate_channel($start,$limit,$tmp,$start_time,$end_time,$order);

			$count=$this->student->consultate_channel_count($tmp,$start_time,$end_time);
			
		}else{
			die;
		}

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		foreach($student_info as $k=>$v){
			#序号
			$student_info[$k]['serial_number']=$number[$k];//每条数据对应当前页的每一个值

			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('student_id'=>$v['student_id']));	
			$student_info[$k]['phone']=$this->_dataProcess($tmp,'phone_number');		
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('student_id'=>$v['student_id']));		
			$student_info[$k]['qq']=$this->_dataProcess($tmp,'qq_number');
			#email
			$tmp= $this->main_data_model->setTable('consul_stu_email')
										->select('email',array('student_id'=>$v['student_id']));
			$student_info[$k]['email']=$this->_dataProcess($tmp,'email');

			#提醒
			$tmp= $this->main_data_model->setTable('time_remind')
										->select('*',array('student_id'=>$v['student_id'],'time_remind_status !='=>-1));				
			$student_info[$k]['message']=$this->_dataProcess($tmp,'student_id');

		}
		#分页类
		$this->load->library('pagination');
		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url,$type,$type_data);	
		
		$config['total_rows'] =$count;
		$config['per_page'] = $limit; 

		$config['uri_segment'] = 7;//这个配置已经无意义
		$config['num_links'] = 5;
		$config['page_query_string']=true;
		

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();

		#学生总数
		if ($type==='index') {
			$consultate_channel_name='学生';
		}else{
			$arr=array('consultant_channel_id'=>'consultant_channel_model',
				   'consultant_consultate_id'=>'counselor_consultate_modus_model'
				   );
			$this->load->model($arr[$type],'consultate_channel');
			$consultate_channel_name= $this->consultate_channel->getName($type_data);
			
		}
		

		$count=sprintf('<span>%s人数:<em style="color:red">%d</em>人</span>',$consultate_channel_name,$count);

		/*$student_knowleage = $this->main_data_model->setTable('student_knowleage_relation')->getOtherAll('*',array('knowledge_id'=>$selected_knownledge));*/

		foreach ($student_info as $k => $value) {
			$student_info[$k]['employee_name'] = $this->main_data_model->setTable('employee')->getOne(array('employee_id'=>$value['employee_id']),'employee_name');

			$where_repayment1=array('student_id' => $value['student_id'],'is_project'=>0);
			$where_repayment2=array('student_id' => $value['student_id'],'is_fail'=>1,'is_project'=>0);
			$result = $this->main_data_model->getOne($where_repayment1,'*','student_repayment_bills');
			$res=$this->main_data_model->count($where_repayment2,'student_repayment_bills');

			if(!empty($result) && $res<=0){
				$student_info[$k]['refund'] = 1;
			}else{
				$student_info[$k]['refund'] = 0;
			}
			
			$old_employee_name = $this->main_data_model->setTable('employee')->getOne(array('employee_id'=>$value['old_employee_id']),'employee_name');

			if(!empty($old_employee_name)){
				$student_info[$k]['old_employee_name'] = $old_employee_name['employee_name'];
			}else{
				$student_info[$k]['old_employee_name'] = "";
			}	
		}
		#赋值
		$data['student_info']=array(
			'count'=>$count,
			'list'=>$student_info,
			'page'=>$page,
			'key'=>$key,
			'search'=>$search
		);

		#指定模板
		$this->load->view('student_list',$data);

		
	}
	/**
	 * 建立url地址
	 */
	private function _buildUrl($arr,$type,$type_data)
	{

		$param_url = "";
		foreach($arr as $key=>$val){
			if(trim($val)!=''){
				$param_url .= $key."=".$val."&";	
			}
		}
		$param_url = rtrim($param_url, "&");
		
		
		$urls =site_url(module_folder(2)."/student/index/$type/$type_data?".$param_url);
		
		return $urls;
	}
	/**
	 *  (把一个二维的数组变成一维) qq、phone、email、学生学号的数据简单处理
	 *	@param array  $arr 数据
	 *	@param string $str 需要降维的key
	 *	@return array 一个一维数组
	 */
	private function _dataProcess($arr,$str)
	{
		$data=array();
		foreach ($arr as $key => $value) {
			$data[]=$value[$str];
		}
		return $data;
	}
	/**
	 * 导航条处理
	 */
	private function menuProcess($type,$type_data)
	{	
		$url[0]=array('学员列表', site_url(module_folder(2).'/student/index/index/0'));

		#当前页码
		$per_page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		if($type=='index'){	

			#搜索
			$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
			
			#搜索分类
			$key= $this->input->get('key')?$this->input->get('key'):'student_name';

			if($search!=''){
				$url[1]=array('学员搜索',site_url(module_folder(2).'/student/index/index/0?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));
			}else{
				$url[1]=array('学员分页',site_url(module_folder(2).'/student/index/index/0?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));
			}


		}elseif(in_array($type, array('consultant_channel_id','consultant_consultate_id'))){
			$arr=array('consultant_channel_id'=>'consultant_channel_model',
			   'consultant_consultate_id'=>'counselor_consultate_modus_model'
			   );
			$this->load->model($arr[$type],'consultate_channel');
			$consultate_channel_name= $this->consultate_channel->getName($type_data);
			
			$url[1]=array($consultate_channel_name.'分页',site_url(module_folder(2).'/student/index/'.$type.'/'.$type_data.'?per_page='.$per_page));
			
		}
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
			show_message('权限不对',site_url(module_folder(2).'/advisory/index/index/0'));
		}

		$this->load->model('student_model');

		$res= $this->student_model->checkData($id,$type);

		
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
	 * 编辑学员信息
	 */
	public function edit()
	{

		$edit = $this->uri->segment(5,0);

		if ($edit==0) {
			show_message('无效的参数!',site_url(module_folder(2).'/student/index'));			
		}

		//检查学生所属者
		$this->_checkPower($edit);

		$check=array(
			array('student_name','学员姓名')
		);
		check_form($check);
		
		if ($this->form_validation->run() == FALSE){
			#获取咨询者渠道、咨询者咨询形式数据
			$data=$this->_pubilcData();

			#超级管理员、调出所有咨询师的信息
			if(getcookie_crm('employee_power')==1){
				#咨询师信息
				$this->load->model('employee_model');
				$data['teach']= $this->employee_model->selectDepartment();

			}

			//通过学员ID查询咨询者ID(#学员信息)
			$where=array('student_id'=>$edit);
			$student = $this->main_data_model->getOne($where,'*','student');

			//获取咨询者信息
			$con_where = array('consultant_id'=>$student['consultant_id']);
			$consultant = $this->main_data_model->getOne($con_where,'consultant_id,consultant_consultate_id,consultant_channel_id,marketing_specialist_id,consultant_otherinfo,consultant_consultate_other,consultant_channel_other,consultant_consultate_remark,consultant_channel_remark','consultant');

			$where=array('student_id'=>$edit,'consultant_id'=>$student['consultant_id']);

			#学员的qq
			$consultant_qq = $this->main_data_model->getOtherAll('qq_number,qq_id',$where,'consul_stu_qq');

			#学员的phone
			$consultant_phone = $this->main_data_model->getOtherAll('phone_number,phone_id',$where,'consul_stu_phones');
			#学员的email
			$consultant_email = $this->main_data_model->getOtherAll('email,email_id',$where,'consul_stu_email');

			#获取缴费日期最早的两个时间
			$min_where = " `student_id` = $edit";
			$order = " order by `payment_time` asc limit 2 ";
			$min_payment_time = $this->main_data_model->query('distinct `payment_time`','refund_loan_time',$min_where,'all',$order);
			$min_payment_time = array_multi2single($min_payment_time);

			if( !empty($record_course_info) ){

				if(count($min_payment_time) < 2){
					
					$data['payment_time_nums'] = 'one';
					$data['second_payment_time'] = max($min_payment_time);
					
				}else{
					$min_payment_time = array_multi2single($min_payment_time);
					$data['payment_time_nums'] = 'more';
					$data['second_payment_time'] = max($min_payment_time);
					
				}
			}else{
				$data['payment_time_nums'] = 'one';
				$data['second_payment_time'] = '';
			}

			#赋值
			$data['student']       =$student;
			$data['consultant']       =$consultant;		
			$data['consultant_qq1']   =array_shift($consultant_qq);
			$data['consultant_qq']    =$consultant_qq;
			$data['consultant_phone1']=array_shift($consultant_phone);
			$data['consultant_phone'] =$consultant_phone;
			$data['consultant_email1']=array_shift($consultant_email);
			$data['consultant_email'] =$consultant_email;

			if(isset($_SERVER['HTTP_REFERER'])){
				$data['location']=$_SERVER['HTTP_REFERER'];//跳转地址
			}else{
				$data['location']=site_url(module_folder(2).'/student/index/index/0');	
			}	

			#市场专员
			$this->load->model('employee_model');
			$data['marketing_specialist'] = $this->employee_model->selectEmployee(18);

			$this->load->view('student_edit',$data);

		}else{
			//接收跳转地址
			$location=$this->input->post('location');

			$data=array();
	  		
	  		$consultant_id = $this->input->post("consultant_id");#咨询者ID
	  		$stu_data['student_other_contacts']   = $con_data['consultant_other_contacts'] = $this->input->post("student_other_contacts");#其他联系方式
			$stu_data['student_name']             = $con_data['consultant_name']           = $this->input->post("student_name");#姓名
			$stu_data['student_sex']   			  = $con_data['consultant_sex']            = $this->input->post("sex");#性别
			$con_data['consultant_consultate_id'] = $this->input->post("consultant_consultate_id");#咨询者咨询形式
			$con_data['consultant_consultate_remark']  = $this->input->post("consultant_consultate_remark");#咨询者咨询形式备注
			$con_data['consultant_channel_remark']     = $this->input->post("consultant_channel_remark");#咨询者咨询渠道备注

			//咨询形式其他信息。
			$con_data['consultant_consultate_other'] = $this->input->post("consultant_consultate_other");
			$con_data['consultant_channel_id']       = $this->input->post("consultant_channel_id");#学员渠道ID
			$con_data['consultant_channel_other']    = $this->input->post("consultant_channel_other");//咨询形式渠道其他
			$con_data['marketing_specialist_id']       = $this->input->post("marketing_specialist_id");#学员市场专员ID
				
			$stu_data['student_otherinfo']           = $con_data['consultant_otherinfo'] = $this->input->post("student_otherinfo");#学员的其他信息
 
			$stu_data['student_school']  		 	 = $con_data['consultant_school']    = $this->input->post("student_school");#毕业学校
			$stu_data['student_specialty']   		 = $con_data['consultant_specialty'] = $this->input->post("student_specialty");#专业

			$stu_data['student_lastime']			 = $con_data['consultant_lastime']	 = time(); #最后修改时间

			$sign_up_date = $this->input->post("sign_up_date");
			if(!empty($sign_up_date)){

				$stu_data['sign_up_date']			 = strtotime($sign_up_date); #修改报名时间

				//更改最早缴费时间
				$record_where = array('student_id'=>$edit);
				$this->load->model('student_repayment_bills_model','repayment_bills_model');
				$min_payment_time = $this->repayment_bills_model->course_payment_time($record_where);

				$record_where = array('payment_time'=>$min_payment_time,'student_id'=>$edit);
				$update_data = array('payment_time'=>$stu_data['sign_up_date']);
				$this->main_data_model->update($record_where,$update_data,'refund_loan_time');

			}

			#学历
			$education = $this->input->post("student_education");
			$education_other = $this->input->post("student_education_other");

			if ($education=='其他') {
				$con_data['consultant_education']=$stu_data['student_education']=$education_other;
				if($stu_data['student_education']==''){
					$con_data['consultant_education']=$stu_data['student_education']='其他';
				}
			}else{
				$stu_data['student_education']=$con_data['consultant_education'] =$education;
			}


			//如果接收到 员工id，则表示是超级管理员
			$employee=$this->input->post("employee_id");
			$old_employee_id=$this->input->post("old_employee_id");
			if($employee){
				$stu_data['employee_id']   =$employee;
				$stu_data['old_employee_id']   =$old_employee_id;
				$con_data['old_employee_id']=$stu_data['old_employee_id'];//记录原有的咨询师
			}else{
				$stu_data['employee_id']   =getcookie_crm('employee_id');#员工ID
			}

			$con_data['employee_id']=$stu_data['employee_id'];//更改咨询者的所属咨询师

			$where=array('student_id'=>$edit);
			#修改学员的信息
	  		$res= $this->main_data_model->update($where,$stu_data,'student');

	  		#修改咨询者的信息
	  		$where=array('consultant_id'=>$consultant_id);
	  		$this->main_data_model->update($where,$con_data,'consultant');

	  		
			#接收phone
			$update_phone= $this->input->post("update_phone");
			$add_phone= $this->input->post("add_phone");

			$update_qq= $this->input->post("update_qq");
			$add_qq= $this->input->post("add_qq");

			$update_email= $this->input->post("update_email");
			$add_email= $this->input->post("add_email");

			//验证QQ 电话 邮箱
	  		if(!empty($update_phone)){
				$res_p = $this->check_info($update_phone,'phones',$consultant_id);
		  		if(!empty($res_p)){
		  			show_message($res_p['con_info'][0]['consultant_name']."已使用此".$res_p['type']."(咨询师:".$res_p['teach_name'].")");
		  		}
	  		}
	  		if(!empty($add_phone)){
	  			$res_p1 = $this->check_info($add_phone,'phones',$consultant_id);
		  		if(!empty($res_p1)){
		  			show_message($res_p1['con_info'][0]['consultant_name']."已使用此".$res_p1['type']."(咨询师:".$res_p1['teach_name'].")");
		  		}
		  	}	
			if(!empty($update_qq)){
		  		$res_q = $this->check_info($update_qq,'qq',$consultant_id);
		  		if(!empty($res_q)){
		  			show_message($res_q['con_info'][0]['consultant_name']."已使用此".$res_q['type']."(咨询师:".$res_q['teach_name'].")");
		  		}
		  	}
		  	if(!empty($add_qq)){
		  		$res_q1 = $this->check_info($add_qq,'qq',$consultant_id);
		  		if(!empty($res_q1)){
		  			show_message($res_q1['con_info'][0]['consultant_name']."已使用此".$res_q1['type']."(咨询师:".$res_q1['teach_name'].")");
		  		}
		  	}
		  	if(!empty($update_email)){
		  		$res_e = $this->check_info($update_email,'email',$consultant_id);
				if(!empty($res_e)){
		  			show_message($res_e['con_info'][0]['consultant_name']."已使用此".$res_e['type']."(咨询师:".$res_e['teach_name'].")");
		  		}
		  	}
		  	if(!empty($add_email)){
		  		$res_e1 = $this->check_info($add_email,'email',$consultant_id);
		  		if(!empty($res_e1)){
		  			show_message($res_e1['con_info'][0]['consultant_name']."已使用此".$res_e1['type']."(咨询师:".$res_e1['teach_name'].")");
		  		}
		  	}
	
			//更新phone
			if($update_phone && !empty($update_phone)){
				//$update_phone=array_unique($update_phone);
				foreach ($update_phone as $k=>$v) {
					$v= trim($v);
					$where_phone = array('phone_id'=>$k);
					if($v!=''){
						$edit_phone=array();
						$edit_phone['is_student']=1;
						$edit_phone['consultant_id']=$consultant_id;
						$edit_phone['student_id']=$edit;
						$edit_phone['phone_number']=$v;

						//第几个phone
						$re1=$this->main_data_model->update($where_phone,$edit_phone,'consul_stu_phones');
					}else{
						//如果为空，就删除
						$this->main_data_model->delete($where_phone,1,'consul_stu_phones');

					}

				}
				
			}
			//插入phone
			if($add_phone && !empty($add_phone)){
	  			$add_phone=array_unique($add_phone);
				foreach ($add_phone as $v) {
					$v= trim($v);
					if($v!=''){
						$insert_phone=array();
						$insert_phone['is_student']=1;
						$insert_phone['consultant_id']=$consultant_id;
						$insert_phone['student_id']=$edit;
						$insert_phone['phone_number']=$v;

						$res1=$this->main_data_model->insert($insert_phone,'consul_stu_phones');
					}

				}
			}
			
			//更新QQ
			if($update_qq && !empty($update_qq)){
				//$update_qq=array_unique($update_qq);
				foreach ($update_qq as $k=>$v) {
					$v= trim($v);
					$where_qq = array('qq_id'=>$k);
					if($v!=''){
						$edit_qq=array();
						$edit_qq['is_student']=1;
						$edit_qq['consultant_id']=$consultant_id;
						$edit_qq['student_id']=$edit;
						$edit_qq['qq_number']=$v;

						//第几个QQ
						$re2=$this->main_data_model->update($where_qq,$edit_qq,'consul_stu_qq');
					}else{
						//如果为空，就删除
						$this->main_data_model->delete($where_qq,1,'consul_stu_qq');

					}

				}
				
			}
			//插入QQ
			if($add_qq && !empty($add_qq)){
	  			$add_qq=array_unique($add_qq);
				foreach ($add_qq as $v) {
					$v= trim($v);
					if($v!=''){
						$insert_qq=array();
						$insert_qq['is_student']=1;
						$insert_qq['consultant_id']=$consultant_id;
						$insert_qq['student_id']=$edit;
						$insert_qq['qq_number']=$v;

						$res2=$this->main_data_model->insert($insert_qq,'consul_stu_qq');
					}

				}
			}
			
			//更新email
			if($update_email && !empty($update_email)){
				//$update_email=array_unique($update_email);	
				foreach ($update_email as $k=>$v) {
					$v= trim($v);
					$where_email = array('email_id'=>$k);
					if($v!=''){
						$edit_email=array();
						$edit_email['is_student']=1;
						$edit_email['consultant_id']=$consultant_id;
						$edit_email['student_id']=$edit;
						$edit_email['email']=$v;

						//第几个email
						$re3=$this->main_data_model->update($where_email,$edit_email,'consul_stu_email');
					}else{
						//如果为空，就删除
						$this->main_data_model->delete($where_email,1,'consul_stu_email');

					}

				}
				
			}
			//插入email
			if($add_email && !empty($add_email)){
	  			$add_email=array_unique($add_email);
				foreach ($add_email as $v) {
					$v= trim($v);
					if($v!=''){
						$insert_email=array();
						$insert_email['is_student']=1;
						$insert_email['consultant_id']=$consultant_id;
						$insert_email['student_id']=$edit;
						$insert_email['email']=$v;
						$res3=$this->main_data_model->insert($insert_email,'consul_stu_email');
					}

				}
			}

			if ($res||$res1||$res2||$res3) {
				show_message('编辑成功!',$location);	
			}else{
				show_message('编辑失败!');	
			}
	  	
		}
	}

	/**
	 * 虚拟删除学员，更新学员状态（一般都是误操作）
	 */
	public function changeStatus()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[1][1];
		
		$dele_arr= $this->input->post('id');

		//检查咨询者所属者
		$this->_checkPower($dele_arr,'in');

		$where = $remind_where = db_create_in($dele_arr,'student_id');
		#修改学员状态
		$status = array('show_status'=>0);
		$result = $this->main_data_model->update($where,$status,'student');

		#修改咨询者状态
		$res = $this->main_data_model->getOtherAll('consultant_id,student_id',$where,'student');
		if($res>0){
			$del_consult=array();
			foreach ($res as $value) {
				$del_consult[]=$value['consultant_id'];
			}
			$consutlant_where = db_create_in($del_consult,'consultant_id');
			$con_status = array('is_student'=>0);
			$this->main_data_model->update($consutlant_where,$con_status,'consultant');

			#如果删除学生，就把记录（课程、知识点，缴费记录，缴费账单，提醒记录）全部删除
			$stu_cur_where = array('student_id',$dele_arr);
			$con_cur_where = array('consultant_id',$del_consult);
			$this->main_data_model->delete($stu_cur_where,2,'student_curriculum_relation');
			$this->main_data_model->delete($stu_cur_where,2,'student_knowleage_relation');
			$this->main_data_model->delete($stu_cur_where,2,'refund_loan_time');
			$this->main_data_model->delete($stu_cur_where,2,'student_repayment_bills');
			$this->main_data_model->delete($stu_cur_where,2,'time_remind');
			$this->main_data_model->delete($con_cur_where,2,'time_remind');

/*			$del_repayment=array();
			foreach ($res as $value) {
				$del_repayment[]=$value['student_id'];
			}
			$repayment_where = db_create_in($del_repayment,'student_id');
			$repayment_status = array('is_fail'=>0);
			$this->main_data_model->update($repayment_where,$repayment_status,'student_repayment_bills');		*/	
			
		}

		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}
	}

	/**
	 * 删除学员，顺带删除学员的phone跟qq
	 */
	/*public function delete()
	{
		$id = $this->uri->segment(5, 0);
		#删除学员
		$where=array('student_id'=>$id);
		$result = $this->main_data_model->delete($where,1,'student');

		#删除qq与phone
		$student=array('is_student'=>1);
		$where=$where+$student;
		$this->main_data_model->delete($where,1,'consul_stu_phones');
		$this->main_data_model->delete($where,1,'consul_stu_qq');

		if($result>0){
  			show_message('删除成功!',site_url(module_folder(2).'/student/index'));	
  		}else{
  			show_message('操作失败!');
  		}
	}*/

	/**
	 * 批量删除学员
	 */
	/*public function deleteAll()
	{
		//获取跳转地址
		/*$url=unserialize(getcookie_crm('url'));
		$location=$url[1][1];
		
		$id = $this->input->post('id');
		#删除到最后一条时会出错
		$num = 0;
		if (!empty($id)) {
			foreach ($id as $key => $value) {
				$count = $this->main_data_model->count(array('student_id'=>$value));
				if($count != 0){
					$num ++;
				}
			}
		}
		
		if ($num == 0) {
			show_message("无效参数");
		}

		#批量删除学员
		$result = $this->main_data_model->delete(array('student_id',$id),2);

		#删除qq与phone
		$where="`is_student` = '1' AND student_id ".db_create_in($id);

		$this->main_data_model->delete($where,1,'consul_stu_phones');
		$this->main_data_model->delete($where,1,'consul_stu_qq');

		//更改咨询者的提醒（设置不提醒）
		$remind_where = "student_id ".db_create_in($id);
		$remind_data = array('time_remind_status'=>-1);
		$this->main_data_model->update($remind_where,$remind_data,'time_remind');
		
		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}

	}*/

	/**
	 *  ajax获取更为详细的学员信息。
	 */
	public function info()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$id= $this->input->post("id");

		//检查咨询者所属者
		$check_result = $this->_checkPower($id,'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}


		$where=array('student_id'=>$id);
		#学员
		$student= $this->main_data_model->getOne($where,'','student');

		$con_where=array('consultant_id'=>$student['consultant_id']);

		#原作为咨询者的信息
		$consultant= $this->main_data_model->getOne($con_where,'consultant_consultate_id,consultant_consultate_other,consultant_channel_id,consultant_channel_other,marketing_specialist_id,consultant_consultate_remark,consultant_channel_remark','consultant');

		#学员phone
		$student_phone= $this->main_data_model->setTable('consul_stu_phones')->select('phone_number',$where);

		#学员qq
		$student_qq= $this->main_data_model->setTable('consul_stu_qq')->select('qq_number',$where);
		
		#学员email
		$student_email= $this->main_data_model->setTable('consul_stu_email')->select('email',$where);


		$str="<table border='1' width='100%'>";
		$str.="<tr>";
		$str.="<td>姓名</td><td>".$student['student_name']."</td>";
		$str.="</tr>";

		#phone
		if($student_phone){
			foreach($student_phone as $item){
				$str.="<tr>";
				$str.="<td>联系方式</td><td>".$item['phone_number']."</td>";
				$str.="</tr>";
			}
		}
		#qq
		if($student_qq){
			foreach($student_qq as $item){
				$str.="<tr>";
				$str.="<td>QQ</td><td>".$item['qq_number']."</td>";
				$str.="</tr>";
			}
		}
		#email
		if($student_email){
			foreach($student_email as $item){
				$str.="<tr>";
				$str.="<td>email</td><td>".$item['email']."</td>";
				$str.="</tr>";
			}
		}

		#其他联系方式
		if($student['student_other_contacts'] != ''){
			$str.="<tr>";
			$str.="<td>其他联系方式</td><td>".$student['student_other_contacts']."</td>";
			$str.="</tr>";
		}

		#性别
		if ($student['student_sex']==1) {
		 	$sex= '男';
		}else if($student['student_sex']==2){
		 	$sex= '女';
		}else{
			$sex= '';
		}
		#性别
		$str.="<tr>";
		$str.="<td>性别</td><td>".$sex."</td>";
		$str.="</tr>";

		#报名时间
		$str.="<tr>";
		$str.="<td>报名时间</td><td>".date('Y-m-d',$student['sign_up_date'])."</td>";
		$str.="</tr>";


		#咨询形式
		if($consultant['consultant_consultate_id']!=0 && $consultant['consultant_consultate_id']!=6){	  //其他咨询形式
			$where=array('consultant_consultate_id'=>$consultant['consultant_consultate_id']);
			$tmp= $this->main_data_model->getOne($where,'consultant_consultate_name','counselor_consultate_modus');
			$str.="<tr>";
			$str.="<td>咨询形式</td><td>".$tmp['consultant_consultate_name']."</td>";
			$str.="</tr>";

		}else{
			$str.="<tr>";
			$str.="<td>咨询形式</td><td>".$consultant['consultant_consultate_other']."</td>";
			$str.="</tr>";			
		}

		#咨询形式备注
		if($consultant['consultant_consultate_remark'] != ''){
			$str.="<tr>";
			$str.="<td>咨询形式备注</td><td>".$consultant['consultant_consultate_remark']."</td>";
			$str.="</tr>";
		}

		#渠道
		if($consultant['consultant_channel_id']!=0 && $consultant['consultant_channel_id']!=12){     //其他咨询渠道
			$where=array('consultant_channel_id'=>$consultant['consultant_channel_id']);
			$tmp=$this->main_data_model->getOne($where,'consultant_channel_name	','consultant_channel');
			
			$str.="<tr>";
			$str.="<td>渠道</td><td>".$tmp['consultant_channel_name']."</td>";
			$str.="</tr>";

		}else{
			$str.="<tr>";
			$str.="<td>渠道</td><td>".$consultant['consultant_channel_other']."</td>";
			$str.="</tr>";			
		}

		#渠道备注
		if($consultant['consultant_channel_remark'] != ''){
			$str.="<tr>";
			$str.="<td>渠道备注</td><td>".$consultant['consultant_channel_remark']."</td>";
			$str.="</tr>";
		}

		#市场专员
		$this->load->model('p_employee_model');
		$tmp = $this->p_employee_model->selectEmployee($consultant['marketing_specialist_id']);
		if(!empty($tmp)){
			$str.="<tr>";
			$str.="<td>市场专员</td><td>".$tmp['employee_name']."</td>";
			$str.="</tr>";
		}
		
		#学员其他信息
		if(trim($student['student_otherinfo'])!=''){
			$str.="<tr>";
			$str.="<td>学员其他信息</td><td>".$student['student_otherinfo']."</td>";
			$str.="</tr>";
		}

		#学历
		if(trim($student['student_education'])!=''){
			$str.="<tr>";
			$str.="<td>学历</td><td>".$student['student_education']."</td>";
			$str.="</tr>";
		}
		#毕业学校
		if(trim($student['student_school'])!=''){
			$str.="<tr>";
			$str.="<td>毕业学校</td><td>".$student['student_school']."</td>";
			$str.="</tr>";
		}
		#就读专业
		if(trim($student['student_specialty'])!=''){
			$str.="<tr>";
			$str.="<td>就读专业</td><td>".$student['student_specialty']."</td>";
			$str.="</tr>";
		}

		$str.="</table>";

		$res['data'] = $str;
		$res['info_url'] = site_url(module_folder(2).'/student/edit/'.$student['student_id']);

		echo json_encode($res);
		exit;

	}
	

	/**
	 * 咨询者渠道、咨询者咨询形式数据的获取
	 */
	private function _pubilcData()
	{

		#咨询者渠道
		$where=array('consultant_channel_status'=>1);
		$consultant_channel=$this->main_data_model->getAll('consultant_channel_id,consultant_channel_name','consultant_channel');
		
		#咨询者咨询形式
		$where=array('consultant_consultate_status'=>1);
		$consultant_consultate=$this->main_data_model->getAll('consultant_consultate_id,consultant_consultate_name','counselor_consultate_modus');
		
		// #咨询者市场专员
		// $where=array('marketing_specialist_status'=>1);
		// $marketing_specialist=$this->main_data_model->getOtherAll('marketing_specialist_id,marketing_specialist_name',$where,'marketing_specialist');

		#赋值到模板
		$data=array(
			'consultant_consultate'=>$consultant_consultate,
			'consultant_channel'   =>$consultant_channel
			// 'marketing_specialist'   =>$marketing_specialist
		);

		return $data;
	}
	/**
	 * 批量修正数据，此方法是为了修正旧的报表数据，学生的信息更新了，作为咨询者的信息没有更新，所以把学生的信息，更新到咨询者那里去。
	 */
	/*
	public function changeData()
	{
		
		  //student_other_contacts  其他联系方式
		  //student_sex			  学生性别
		  //student_name 			  学员姓名
		  //student_education 	  学员学历
		  //student_school		  学员毕业院校
		  //student_specialty		  学员就读专业
		  //student_otherinfo 	  学员其他信息
	
		$student= $this->main_data_model->getAll('student_other_contacts,consultant_id,student_sex,student_name,student_education,student_school,student_specialty,student_otherinfo','student');

		foreach($student as $item){

			$where=array('consultant_id'=>$item['consultant_id']);

			$data=array(
				'consultant_other_contacts'=>$item['student_other_contacts'],
				'consultant_sex'=>$item['student_sex'],
				'consultant_name'=>$item['student_name'],
				'consultant_education'=>$item['student_education'],
				'consultant_school'=>$item['student_school'],
				'consultant_specialty'=>$item['student_specialty'],
				'consultant_otherinfo'=>$item['student_otherinfo']
				);

			$res= $this->main_data_model->update($where,$data,'consultant');

			echo $res.'<br />';

		}
	}
	*/
	public function deleteQQ()
	{
		header("Content-Type:text/html;charset=utf-8");

		$qq_id = $this->input->post('qid');

		$where=array('qq_id'=>$qq_id);	
		$res=$this->main_data_model->delete($where,1,'consul_stu_qq');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	public function deleteEmail()
	{
		header("Content-Type:text/html;charset=utf-8");

		$email_id = $this->input->post('eid');

		$where=array('email_id'=>$email_id);	
		$res=$this->main_data_model->delete($where,1,'consul_stu_email');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	public function deletePhone()
	{
		header("Content-Type:text/html;charset=utf-8");

		$phone_id = $this->input->post('pid');

		$where=array('phone_id'=>$phone_id);	
		$res=$this->main_data_model->delete($where,1,'consul_stu_phones');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	public function check_info($data,$type,$id){

		$data=array_unique($data);

		foreach ($data as $value) {
			$value= trim($value);
			if($value!=''){

				$table='consul_stu_'.$type;
				if($type=='qq'){
					$where_join = $table.".qq_number = '".trim($value)."'";
					$typename = 'QQ';
				}else if($type=='phones'){	
					$where_join = $table.".phone_number = '".trim($value)."'";
					$typename = '手机号码';
				}else{
					$where_join = $table.".email = '".trim($value)."'"; 	
					$typename = '邮箱';		
				}	

				//如果是编辑
				if ($id!=0) {
					$where_join.=" AND crm_".$table.".consultant_id != ".$id;				
				}

				$where_join.=" AND crm_consultant.show_status = 1";

				//查询记录
				$join = array('*','consultant','consultant.consultant_id = '.$table.'.consultant_id','left');
				$res['con_info'] = $list = $this->main_data_model->select('*',$where_join,0,0,0,$join,$table);

				if(isset($list[0]['employee_id'])){
					//咨询师名字
					$where=array('employee_id'=>$list[0]['employee_id']);
					$teach= $this->main_data_model->getOne($where,'admin_name','employee');
					$teach_name=isset($teach['admin_name'])?$teach['admin_name']:'';
				}

				if ($list) {
					$res['type'] = $typename;
					$res['teach_name'] = $teach_name;
					return $res;
					//break;
				}

			}else{
				$res = array();
			}

		}
	}

	/**
	 *	处理要复读的课程
	 */
	public function repeatReadKnowleage()
	{
		$student_id = $this->input->post('student_id');
			
		#显示已读的知识点（查“学生、知识点表”）
		#已报读课程(已读)
		#如果已经复读过的，就标红色（查“学生就读表”）
		#更新为“就读状态”为2，复读

		$this->load->model('p_student_model');
		$this->load->model('p_knowledge_model');
		$this->load->model('p_classroom_type_model','classroom_type');
		$type_info = $this->classroom_type->selectClassType();

		$this->load->model('student_model');
		$where = array('student_id'=>$student_id);
		$data = $this->student_model->getStudentInfo('constu_intention_course,intention_course_remark,repeat_course_remark',$where);

		#已读
		$where = array('student_id'=>$student_id);
		$where_in = array(1,2);
		$stu_know_info = $this->p_knowledge_model->selectAllStuKnowledge($where,$where_in);

		$repeat_course = array();
		foreach ($stu_know_info as $key => $value) {
			$repeat_course[] = $value['knowledge_id'];
		}

		foreach ($type_info as $key => $value) {
			$where = array('knowledge.classroom_type_id'=>$value['classroom_type_id']);
			$type_info[$key]['type_knownledge_info'] = $this->classroom_type->select_knowledge($where);	
			if(!empty($type_info[$key]['type_knownledge_info'])){
				foreach ($type_info[$key]['type_knownledge_info'] as $k => $v) {
					if(!in_array($v['knowledge_id'], $repeat_course)){
						unset($type_info[$key]['type_knownledge_info'][$k]);
					}else{
						$where_k = array('student_id'=>$student_id,'knowledge_id'=>$v['knowledge_id']);
						$know_info = $this->p_knowledge_model->selectStudentKnowledge($where_k);
						$type_info[$key]['type_knownledge_info'][$k]['study_status'] = $know_info['study_status'];
						$type_info[$key]['type_knownledge_info'][$k]['rel_id'] = $know_info['id'];

					}
				}
			}
		}

		foreach ($type_info as $key => $value) {
			if(empty($type_info[$key]['type_knownledge_info'])){
				unset($type_info[$key]);
			}else{
				foreach ($type_info[$key]['type_knownledge_info'] as $k => $v) {
					$where_rel = array('relation_id'=>$v['rel_id'],'attended_status'=>2);
					$data_rel = $this->p_student_model->selectAttendedRecord($where_rel);
					if($data_rel){
						$type_info[$key]['type_knownledge_info'][$k]['is_repeat'] = 1;
					}else{
						$type_info[$key]['type_knownledge_info'][$k]['is_repeat'] = 0;
					}
				}
			}
		}

		$str1 = '<ul id="repeat_course" class="tree-folder-header tree">';
		foreach ($type_info as $key => $value) {

			if(!empty($type_info[$key]['type_knownledge_info'])){
				$str .= '<li><i class="icon-plus"></i><input type="checkbox" name="course_type[]" value="'.$value['classroom_type_id'].'" class="ace" /><span class="lbl"><label style="cursor:pointer;">'.$value['classroom_type_name'].'</label> </span>';

				$str .= '<ul>'; 
				foreach ($type_info[$key]['type_knownledge_info'] as $k => $v) {

					if($v['study_status'] == 2){
						$checked = 'checked="checked"';
					}else{
						$checked = '';
					}

					if($v['is_repeat'] == 1){
						$str .= '<li class="second"><input type="checkbox" class="ace" name="type_knownledge[]" value="'.$v['knowledge_id'].'" '.$checked.' /><span class="lbl" data-event="click"><font color="red"> '.$v['knowledge_name'].' </font></span></li>';
					}else{
						$str .= '<li class="second"><input type="checkbox" class="ace" name="type_knownledge[]" value="'.$v['knowledge_id'].'" '.$checked.' /><span class="lbl" data-event="click"> '.$v['knowledge_name'].' </span></li>';
					}
					
				}
				$str .= '<div class="clear"></div>';
				$str .= '</ul>'; 
				$str .= '</li>'; 
			}			
		}
		$str1 .= '</ul>'; 

		$str1 .= '<br />备注：<textarea name="repeatCourseRemark" id="" cols="50" rows="10">'.$data['repeat_course_remark'].'</textarea>';
		
		echo json_encode(array('str'=>$str1));

	}

	/**
	 *  处理学生就读情况（复读）
 	 */
	public function actionRepeatRead()
	{
		$student_id = $this->input->post('student_id');
		$course_type = $this->input->post('course_type');
		$type_knownledge = $this->input->post('type_knownledge');
		$repeatCourseRemark = $this->input->post('repeatCourseRemark');

		$this->load->model('p_student_model');
		$this->load->model('p_knowledge_model');

		$where_knowledge = array('student_id'=>$student_id);
		$where_knowledge_in = array(1,2,3);
		$result_knowledge = $this->p_knowledge_model->selectAllStuKnowledge($where_knowledge,$where_knowledge_in);

		foreach ($result_knowledge as $key => $value) {
			$where = array('student_id'=>$student_id,'knowledge_id'=>$value['knowledge_id']);
			if(!empty($type_knownledge) && in_array($value['knowledge_id'], $type_knownledge)){		
				$data = array('study_status'=>2);		
			}else{
				$data = array('study_status'=>1);
			}
			$this->p_knowledge_model->update_student_knowledge($where,'',$data);	
		}

		$where_student = array('student_id'=>$student_id);
		$data_student = array('repeat_course_remark'=>$repeatCourseRemark);
		$this->p_student_model->editStudentInfo($where_student,$data_student);

		show_message('操作成功！');
	}

	/**
	 *	一次性处理所有学生的“要复读”状态
	 */
	public function allRepeatKnowleage()
	{
		$changeKnowledgeId = $this->input->post('changeKnowledgeId');
		$student_id = $this->input->post('student_id');
		$student_id = explode(',', $student_id);

		$this->load->model('p_knowledge_model');

		//如果只是复读一个知识点
		$data = array('study_status'=>2);
		foreach ($student_id as $value) {
			$where = array('student_id'=>$value,'knowledge_id'=>$changeKnowledgeId);
			$this->p_knowledge_model->update_student_knowledge($where,'',$data);
		}
		echo json_encode(array('status'=>1));
		exit;
	}

	/**
	 * 获取对应类型的知识点
	 * $type   1=》要复读的（查询已读的）   2=》已复读（查询要复读的）   3=》已读（查所有报读知识点未读的）    4=》意向课程（查所有的知识点）-- 排除已经报读的
	 * $selected 选中的知识点
	 * 数据表字段 study_status 0，未读/默认；1，已读；2，要复读；3，已复读；4，意向课程
	 */
	public function getKnowleage()
	{
		$student_id = $this->input->post('student_id');

		$this->load->model('p_student_model');
		$this->load->model('p_classroom_model');
		$this->load->model('p_knowledge_model');

		#查询学生的就读记录
		$where = array('student_knowleage_relation.student_id'=>$student_id);
		$record_info = $this->p_student_model->attendedRecordAll($where);

		$str = '';
		foreach ($record_info as $key => $value) {
			$classroom_where = array('classroom_id'=>$value['classroom_id']);
			$classroom_info = $this->p_classroom_model->classroom_info_all($classroom_where,'*');

			$knowledge_where = array('student_knowleage_relation.id'=>$value['relation_id']);
			$knowledge_info = $this->p_knowledge_model->select_knowledge_info($knowledge_where);

			$classroom_name = $classroom_info['classroom_name'];
			$open_classtime = date('Y-m-d',$classroom_info['open_classtime']);
			if(!empty($classroom_info['close_classtime'])){
				$close_classtime = date('Y-m-d',$classroom_info['close_classtime']);
			}else{
				$close_classtime = "";
			}	
			$classroom_type_name = $classroom_info['classroom_type_name'];
			$knowledge_name = $knowledge_info['knowledge_name'];

			if($value['study_status'] == 1){
				$study_status = "已读";
			}else{
				$study_status = "要复读";
			}

			$str .= <<<ABC
						<tr>
							<td>$classroom_name</td>
							<td>$open_classtime</td>
							<td>$close_classtime</td>
							<td>$classroom_type_name</td>
							<td>$knowledge_name</td>
							<td>$study_status</td>
						</tr>
ABC;
		}



		$str = <<<HTML

		<div class="modal-header">
     		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
        	<h4 class="modal-title">就读情况</h4>
      	</div>
      	<div class="modal-body ">
			<table cellpadding="5px" border="1" align="center">
				<tr>
					<th width="70px" align="center">就读班级</th>
					<th width="80px" align="center">开班时间</th>	
					<th width="80px" align="center">结课时间</th>	
					<th width="70px" align="center">课程类型</th>	
					<th align="center">知识点</th>	
					<th width="110px" align="center">就读状态</th>	
				</tr>
				$str
			</table>	
		</div>

HTML;

		echo json_encode(array('data'=>$str));
		exit;

		
	}

	/**
	 * 处理学生就读情况
	 */
	public function actionReadKnowleage()
	{
		$type = $this->input->post('status_type');
		$student_id = $this->input->post('student_id');
		$knowledge_id = $this->input->post('knowledge_id');

		$where=array('student_id'=>$student_id);
		$where_in=$knowledge_id;

		if($knowledge_id){ //更新学生、知识点关系表状态
			switch ($type) {
				case 1:
					$data = array('study_status'=>2);
					break;
				case 2:
					$data = array('study_status'=>3);
					break;
				case 3:
					$data = array('study_status'=>1);
					break;
	
				
				default:
					# code...
					break;
			}
		}

		$this->load->model('student_model');
		$this->student_model->updateKnowleage($data,$where,$where_in);

		show_message('操作成功!');	
	}

	/**
	 *	咨询者意向课程
	 */
	public function intentionKnowleage()
	{
		#记录意向课程
		$student_id = $this->input->post('student_id');

		$this->load->model('p_classroom_type_model','classroom_type');

		$type_info = $this->classroom_type->selectClassType();

		$this->load->model('student_model');
		$where = array('student_id'=>$student_id);
		$data = $this->student_model->getStudentInfo('constu_intention_course,intention_course_remark',$where);
		$intention_course_arr = explode(',',$data['constu_intention_course']);

		#已报读课程
		$this->load->model('student_knowleage_relation_model','student_knowleage_relation');
		$where = array('student_id'=>$student_id);
		$stu_know_info = $this->student_knowleage_relation->getReadKnowledge($where);
		$repeat_knowledge = array();
		foreach ($stu_know_info as $key => $value) {
			$repeat_knowledge[] = $value['knowledge_id'];
		}
		foreach ($intention_course_arr as $key => $value) {
			if(in_array($value, $repeat_knowledge)){
				unset($intention_course_arr[$key]);
			}
		}

		$str = '<ul id="menu_course" class="tree-folder-header tree">';
		foreach ($type_info as $key => $value) {
			$where = array('knowledge.classroom_type_id'=>$value['classroom_type_id']);
			$type_info[$key]['type_knownledge_info'] = $this->classroom_type->select_knowledge($where);	

			if(!empty($type_info[$key]['type_knownledge_info'])){
				$str .= '<li><i class="icon-plus"></i><input type="checkbox" name="course_type[]" value="'.$value['classroom_type_id'].'" class="ace" /><span class="lbl"><label style="cursor:pointer;">'.$value['classroom_type_name'].'</label> </span>';

				$str .= '<ul>'; 
				foreach ($type_info[$key]['type_knownledge_info'] as $k => $v) {

					if(in_array($v['knowledge_id'], $intention_course_arr)){
						$str .= '<li class="second"><input type="checkbox" checked="checked" class="ace" name="type_knownledge[]" value="'.$v['knowledge_id'].'" /><span class="lbl" data-event="click"> '.$v['knowledge_name'].' </span></li>';
					}else{
						if(in_array($v['knowledge_id'], $repeat_knowledge)){
							$str .= '<li class="second"><input type="checkbox" class="ace" name="type_knownledge[]" value="'.$v['knowledge_id'].'" disabled="disabled" /><span class="lbl" data-event="click"> '.$v['knowledge_name'].' </span></li>';
						}else{
							$str .= '<li class="second"><input type="checkbox" class="ace" name="type_knownledge[]" value="'.$v['knowledge_id'].'" /><span class="lbl" data-event="click"> '.$v['knowledge_name'].' </span></li>';
						}
						
					}
				}
				$str .= '<div class="clear"></div>';
				$str .= '</ul>'; 
				$str .= '</li>'; 
			}			
		}
		$str .= '</ul>'; 

		$str .= '<br />备注：<textarea name="intentionCourseRemark" id="" cols="50" rows="10">'.$data['intention_course_remark'].'</textarea>';


		#记录要复读课程
		$this->load->model('p_student_model');
		$this->load->model('p_knowledge_model');
		#$this->load->model('p_classroom_type_model','classroom_type');
		$type_info = $this->classroom_type->selectClassType();

		$this->load->model('student_model');
		$where = array('student_id'=>$student_id);
		$data = $this->student_model->getStudentInfo('constu_intention_course,intention_course_remark,repeat_course_remark',$where);

		#已读
		$where = array('student_id'=>$student_id);
		$where_in = array(1,2,3);
		$stu_know_info = $this->p_knowledge_model->selectAllStuKnowledge($where,$where_in);

		$repeat_course = array();
		foreach ($stu_know_info as $key => $value) {
			$repeat_course[] = $value['knowledge_id'];
		}

		foreach ($type_info as $key => $value) {
			$where = array('knowledge.classroom_type_id'=>$value['classroom_type_id']);
			$type_info[$key]['type_knownledge_info'] = $this->classroom_type->select_knowledge($where);	
			if(!empty($type_info[$key]['type_knownledge_info'])){
				foreach ($type_info[$key]['type_knownledge_info'] as $k => $v) {
					if(!in_array($v['knowledge_id'], $repeat_course)){
						unset($type_info[$key]['type_knownledge_info'][$k]);
					}else{
						$where_k = array('student_id'=>$student_id,'knowledge_id'=>$v['knowledge_id']);
						$know_info = $this->p_knowledge_model->selectStudentKnowledge($where_k);
						$type_info[$key]['type_knownledge_info'][$k]['study_status'] = $know_info['study_status'];
						$type_info[$key]['type_knownledge_info'][$k]['rel_id'] = $know_info['id'];

					}
				}
			}
		}

		foreach ($type_info as $key => $value) {
			if(empty($type_info[$key]['type_knownledge_info'])){
				unset($type_info[$key]);
			}else{
				foreach ($type_info[$key]['type_knownledge_info'] as $k => $v) {
					$where_rel = array('relation_id'=>$v['rel_id'],'attended_status'=>2);
					$data_rel = $this->p_student_model->selectAttendedRecord($where_rel);
					if($data_rel){
						$type_info[$key]['type_knownledge_info'][$k]['is_repeat'] = 1;
					}else{
						$type_info[$key]['type_knownledge_info'][$k]['is_repeat'] = 0;
					}
				}
			}
		}

		$str1 = '<ul id="repeat_course" class="tree-folder-header tree">';
		foreach ($type_info as $key => $value) {

			if(!empty($type_info[$key]['type_knownledge_info'])){
				$str1 .= '<li><i class="icon-plus"></i><input type="checkbox" name="course_type1[]" value="'.$value['classroom_type_id'].'" class="ace" /><span class="lbl"><label style="cursor:pointer;">'.$value['classroom_type_name'].'</label> </span>';

				$str1 .= '<ul>'; 
				foreach ($type_info[$key]['type_knownledge_info'] as $k => $v) {

					if($v['study_status'] == 2){
						$checked = 'checked="checked"';
					}else{
						$checked = '';
					}

					if($v['is_repeat'] == 1){
						$str1 .= '<li class="second"><input type="checkbox" class="ace" name="type_knownledge[]" value="'.$v['knowledge_id'].'" '.$checked.' /><span class="lbl" data-event="click"><font color="red"> '.$v['knowledge_name'].' </font></span></li>';
					}else{
						$str1 .= '<li class="second"><input type="checkbox" class="ace" name="type_knownledge[]" value="'.$v['knowledge_id'].'" '.$checked.' /><span class="lbl" data-event="click"> '.$v['knowledge_name'].' </span></li>';
					}
					
				}
				$str1 .= '<div class="clear"></div>';
				$str1 .= '</ul>'; 
				$str1 .= '</li>'; 
			}			
		}
		$str1 .= '</ul>'; 

		$str1 .= '<br />备注：<textarea name="repeatCourseRemark" id="" cols="50" rows="10">'.$data['repeat_course_remark'].'</textarea>';
		$res = 'yes';

		if(empty($type_info)){
			$str1 = '<div>该学员没有已读的课程</div>';
			$res = 'no';
		}
		echo json_encode(array('str'=>$str,'str1'=>$str1,'stat'=>$res));
	}

	/**
	 * 处理意向课程
	 */
	public function actionIntentionCourse()
	{
		$student_id = $this->input->post('student_id');
		$course_type = $this->input->post('course_type');
		$type_knownledge = $this->input->post('type_knownledge');
		$intentionCourseRemark = $this->input->post('intentionCourseRemark');

		$this->load->model('student_model');

		$where = array('student_id'=>$student_id);
		if(!empty($type_knownledge)){
			$type_knownledge_arr = implode(',', $type_knownledge);
			$data = array('constu_intention_course'=>$type_knownledge_arr,'intention_course_remark'=>$intentionCourseRemark);
		
			$this->student_model->editIntentionCourse($where,$data);
		}

		show_message('操作成功！');
		
	}

	/**
	 * 获取学员信息
	 */
	public function studentInfo(){

		$where_id = array('student_id'=>$_POST['stu_id']);
		#查询咨询者的姓名,手机,QQ加入到提醒内容		
		$student_info = $this->main_data_model->getOne($where_id,'student_name,consultant_id','student');

		$where = array('consultant_id'=>$student_info['consultant_id']);
		$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where,'consul_stu_phones');
		$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where,'consul_stu_qq');

		//分割数组
		$phone=$this->_dataProcess($phone_infos,'phone_number');
		$phone=implode(',', $phone);
		$qq=$this->_dataProcess($qq_infos,'qq_number');
		$qq=implode(',', $qq);

		if( !empty($student_info) ){
			$studentinfo = "姓名: ".$student_info['student_name']."&nbsp;&nbsp;手机号码: ".$phone."&nbsp;&nbsp;QQ号码: ".$qq;
		}else{
			$studentinfo = '';
		}

		echo json_encode(array('info'=>$studentinfo));
		exit;
	}
}