<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者操作
 */
class Advisory_advisory_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('consultant');
	}

	public function index()
	{
		//显示课程列表(设为学员)
		$where=array('curriculum_system_status'=>1);
		$curriculum_system=$this->main_data_model->getOtherAll('*',$where,'curriculum_system');

		$data['course'] = array();
		
		//课程体系和知识点
		foreach ($curriculum_system as $key => $value) {
			$where = array('curriculum_system.curriculum_system_id' => $value['curriculum_system_id']);
			$data['course'][$key]['curriculum_system_name'] = $value['curriculum_system_name'];
			$data['course'][$key]['curriculum_system_id'] = $value['curriculum_system_id'];

			$orders='knowledge.knowledge_order ASC,knowledge.knowledge_id ASC';#排序(管理员自定义排序)
			$join = array(
						array('*','curriculum_knowleage_relation','curriculum_system.curriculum_system_id = curriculum_knowleage_relation.curriculum_system_id','left'),
						array('*','knowledge','curriculum_knowleage_relation.knowledge_id = knowledge.knowledge_id','left')
					);

			$data['course'][$key]['course_name'] = $this->main_data_model->select('*',$where,$orders,0,'',$join,'curriculum_system');
		}

		//缴费类型
		$data['payment_type_info'] = array();
		$data['payment_type_info'] = $this->main_data_model->getAll('*','payment_type');


		#咨询师
		$this->load->model('employee_model');
		$data['teach']= $this->employee_model->selectDepartment();

		#市场专员
		$this->load->model('employee_model');
		$data['marketing_specialist'] = $this->employee_model->selectEmployee(18);


		//多个查询参数处理
		$param_url=array();

		//超级管理员选中的咨询师
		$data['selected_teach']=$selected_teach=trim($this->input->get('teach'))!=''?trim($this->input->get('teach')):'';

		#市场专员
		$data['statistics_id']=$statistics_id=trim($this->input->get('statistics_id'))!=''?trim($this->input->get('statistics_id')):'';

		$param_url['teach']=$selected_teach;
		$param_url['statistics_id']=$statistics_id;

		//权限限制,如果不是超级管理员，而又选中了某位咨询师，属于不合理状态
		if(getcookie_crm('employee_power')==0 && $selected_teach!=''){
			show_message('权限不对!');
		}

		//咨询日期排序
		$data['order']=$order=trim($this->input->get('order'))!=''?trim($this->input->get('order')):'';
		$param_url['order']=$order;

		#接收分类
		$data['changeType']= $type = $this->uri->segment(5, 'index');
		$data['changeData']= $type_data = $this->uri->segment(6, 0);

		#导航栏处理
		$this->menuProcess($type,$type_data);		

		#当前页码
		$data['cur_pag']= $page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		#搜索
		$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
		
		$param_url['search']=$search;

		#搜索分类
		$key= $this->input->get('key')?$this->input->get('key'):'consultant_name';
		
		$param_url['key']=$key;

		$limit=20;#每页显示多少条
		
		$start=($page-1)*$limit;

		//接收日期类型
		$data['select_day']=$select_day=trim($this->input->get('select_day'))!=''?trim($this->input->get('select_day')):'';
		$param_url['select_day']=$select_day;

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

		$consultant_id = $this->input->get('consultant_id') ? $this->input->get('consultant_id'):'';
		$param_url['consultant_id']=$consultant_id;

		#加载咨询者模型
		$this->load->model('consultant_model','consultant');
		$this->consultant->init($selected_teach);

		if ($type=='index') {//咨询者列表
			$search_key_type=array('consultant_name','consultant_education','consultant_school','consultant_specialty');
			if (in_array($key,$search_key_type)) {
				if($select_day==2){
					//回访记录查询列表和总数
					$consultant=$this->consultant->select_record_time($start,$limit,$start_time,$end_time,$selected_teach);
					$count=$this->consultant->select_record_time_count($start_time,$end_time,$selected_teach);
				}else{
					$consultant=$this->consultant->select_index($start,$limit,$key,$search,$start_time,$end_time,$consultant_id,$order,'',$statistics_id);
					$count=$this->consultant->select_index_count($key,$search,$start_time,$end_time,$consultant_id,'',$statistics_id);
				}

			}else{
				//联系方式查找
				$model="consul_stu_{$key}_model";
				$this->load->model($model,'contact');
				
				$data_s=$this->contact->select($search);
				$data_s=$this->_dataProcess($data_s,'consultant_id');
				$count=count($data_s);
			
				$data_s[]=0;  //因搜索关键字查到咨询者删除记录跳转出现重复，所以直接显示空数据，不做提示
				
				$consultant=$this->consultant->select_contact_like($data_s,$start,$limit);
				
			}
			
			
		//咨询者咨询形式、咨询渠道
		}else if(in_array($type, array('consultant_channel_id','consultant_consultate_id'))){

			$tmp=array($type,$type_data);
			$consultant=$this->consultant->consultate_channel($start,$limit,$tmp,$start_time,$end_time,$order,$selected_teach);

			$count=$this->consultant->consultate_channel_count($tmp,$start_time,$end_time);
		
		}else if($type=='consultant_set_view'){ //未上门，已上门
			$consultant=$this->consultant->select_view($start,$limit,$type_data,$start_time,$end_time,$order);
			$count=$this->consultant->select_view_count($type_data,$start_time,$end_time);
		}else{
			die;
		}
		
		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数

		//$total_page = floor($count/$limit) != 0 ? floor($count/$limit) : 1;//总共多少页

		$number = array();
		for($i=$begin;$i<=$total;$i++){
			$number[]=$i;//当前页的每个值赋给数组
		}

		foreach($consultant as $k=>$v){
			#序号
			$consultant[$k]['serial_number']=$number[$k];//每条数据对应当前页的每一个值
			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('consultant_id'=>$v['consultant_id']));
		
			
			$consultant[$k]['phone']=$this->_dataProcess($tmp,'phone_number');
			
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('consultant_id'=>$v['consultant_id']));
			
			
			$consultant[$k]['qq']=$this->_dataProcess($tmp,'qq_number');

			#email
			$tmp= $this->main_data_model->setTable('consul_stu_email')
										->select('email',array('consultant_id'=>$v['consultant_id']));
			
			
			$consultant[$k]['email']=$this->_dataProcess($tmp,'email');

			#提醒
			$tmp= $this->main_data_model->setTable('time_remind')
										->select('*',array('consultant_id'=>$v['consultant_id'],'consultant_record_id'=>0,'student_id'=>0,'time_remind_status'=>0,'is_client'=>0)
											);
			
			$consultant[$k]['message']=$this->_dataProcess($tmp,'consultant_id');

		}

		#分页类
		$this->load->library('pagination');

		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url,$type,$type_data);

		$config['total_rows'] =$count;
		$config['per_page']   = $limit; 

		$config['uri_segment']= 5;
		$config['num_links']  = 5;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();
		
		#统计咨询者各个渠道人数
		$tmps=array($type,$type_data);
		if($type=='index'){

			if($select_day==2){
				//回访记录人数
				$notvisit=$this->consultant->select_record_view_count(0,$start_time,$end_time,$selected_teach);
				$visit=$this->consultant->select_record_view_count(1,$start_time,$end_time,$selected_teach);
				$data['member']='已上门人数：<em id="visit" style="color:red">'.$visit.'</em> 人'.'未上门人数：<em id="notvisit" style="color:red">'.$notvisit.'</em> 人';
			}else{
				$notvisit=$this->consultant->select_view_count(0,$start_time,$end_time);
				$visit=$this->consultant->select_view_count(1,$start_time,$end_time);
				$data['member']='已上门人数：<em id="visit" style="color:red">'.$visit.'</em> 人'.'未上门人数：<em id="notvisit" style="color:red">'.$notvisit.'</em> 人';
			}

		}elseif(in_array($type, array('consultant_channel_id','consultant_consultate_id'))){
			$arr=array('consultant_channel_id'=>'consultant_channel_model',
				   'consultant_consultate_id'=>'counselor_consultate_modus_model'
				   );
			$this->load->model($arr[$type],'consultate_channel');
			$consultate_channel_name= $this->consultate_channel->getName($type_data);
			$data['member']=sprintf('<span>%s人数:<em style="color:red">%d</em>人</span>',$consultate_channel_name,$count);
			
		}elseif($type=='consultant_set_view'){
				if($type_data==1){
					$notvisit=$this->consultant->select_view_count(1,$start_time,$end_time);
					$data['member']='已上门人数：<em id="notvisit" style="color:red">'.$notvisit.'</em> 人';
				}else{
					$visit=$this->consultant->select_view_count(0,$start_time,$end_time);
					$data['member']='未上门人数：<em id="visit" style="color:red">'.$visit.'</em> 人';
				}
		}
		

		//如果是学生的consultant_id
		$stu_consultant_id=array();
		//如果是已上门的
		if ($type=='consultant_set_view' && $type_data=='1') {
			$set_stu_bg=1;//这个当初是为了设置背景颜色的。
			foreach($consultant as $item){
				if ($item['is_student']==1) {
					$stu_consultant_id[]=$item['consultant_id'];
				}	
			}
		}else{
			$set_stu_bg=0;
		}


		//如果是咨询者列表
		if ($type=='index'||$type!='consultant_set_view') {
			$set_stu_bg=2;//这个当初是为了设置背景颜色的。
			foreach($consultant as $item){
				if ($item['is_student']==1) {
					$stu_consultant_id[]=$item['consultant_id'];
				}	
			}
		}
		
		$data['set_stu_bg']=$set_stu_bg;
		$data['stu_consultant_id']=json_encode($stu_consultant_id);

		foreach ($consultant as $k => $value) {
			$consultant[$k]['employee_name'] = $this->main_data_model->setTable('employee')->getOne(array('employee_id'=>$value['employee_id']),'employee_name');
			$old_employee_name = $this->main_data_model->setTable('employee')->getOne(array('employee_id'=>$value['old_employee_id']),'employee_name');

			if(!empty($old_employee_name)){
				$consultant[$k]['old_employee_name'] = $old_employee_name['employee_name'];
			}else{
				$consultant[$k]['old_employee_name'] = "";
			}
		}	

		#赋值
		$data['admin_info']=array(
			'count'=>$count,
			'list'=>$consultant,
			'page'=>$page,
			'key'=>$key,
			'search'=>$search
		);

		#指定模板
		$this->load->view('advisory_list',$data);
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
		
		
		$urls =site_url(module_folder(2)."/advisory/index/$type/$type_data?".$param_url);
		
		return $urls;
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
	/**
	 * 导航条处理
	 */
	private function menuProcess($type,$type_data)
	{	
		$url[0]=array('咨询者列表', site_url(module_folder(2).'/advisory/index/index/0'));

		$per_page= $this->input->get('per_page')?$this->input->get('per_page'):'1';
		
		if($type=='index'){
			#搜索
			$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
			#搜索分类
			$key= $this->input->get('key')?$this->input->get('key'):'consultant_name';
			
			if($search!=''){
				$url[1]=array('咨询者搜索',site_url(module_folder(2).'/advisory/index/index/0?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));	
			}else{
				$url[1]=array('咨询者分页',site_url(module_folder(2).'/advisory/index/index/0?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));
			}
			


		}elseif(in_array($type, array('consultant_channel_id','consultant_consultate_id'))){
		
			$arr=array('consultant_channel_id'=>'consultant_channel_model',
			   'consultant_consultate_id'=>'counselor_consultate_modus_model'
			   );
			$this->load->model($arr[$type],'consultate_channel');
			$consultate_channel_name= $this->consultate_channel->getName($type_data);
			
			$url[1]=array($consultate_channel_name.'分页',site_url(module_folder(2).'/advisory/index/'.$type.'/'.$type_data.'?per_page='.$per_page));
			
		}elseif($type=='consultant_set_view'){
			
			if($type_data==1){
				$tmp_name='已上门';
			}else{
				$tmp_name='未上门';
			}

			$url[1]=array($tmp_name.'分页', site_url(module_folder(2).'/advisory/index/consultant_set_view/'.$type_data.'?per_page='.$per_page));
		}
		
		
		//之前是这么做
		//$_COOKIE['url']=serialize($url);
		//加密处理
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');
		
		setcookie_crm('url',serialize($url));

	}
	/**
	 * 添加咨询者的时候修改面包屑导航
	 */
	private function _addUrl()
	{
		$url[0]=array('咨询者列表', site_url(module_folder(2).'/advisory/index/index/0'));
		$url[1]=array('咨询者分页',site_url(module_folder(2).'/advisory/index/index/0?'.'per_page=1'));
		
		//之前是这么做
		//$_COOKIE['url']=serialize($url);
		//加密处理
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');

		setcookie_crm('url',serialize($url));
	}

	/**
	 *	添加咨询者
	 *
	 */
	public function add()
	{
		$this->_addUrl();
		
		$check=array(
			array('consultant_name','咨询者姓名')
		);
		check_form($check);
		
		if ( $this->form_validation->run() == FALSE){
			
			#获取咨询者咨询形式与咨询者渠道、市场专员的数据
			$data=$this->_pubilcData();

			#超级管理员、调出所有咨询师的信息
			if(getcookie_crm('employee_power')==1){
				#咨询师
				$this->load->model('employee_model');
				$data['teach']= $this->employee_model->selectDepartment();
			}

			#市场专员
			$this->load->model('employee_model');
			$data['marketing_specialist'] = $this->employee_model->selectEmployee(18);

			$this->load->view('advisory_add',$data);
		
	  	}else{

	  		$qq_data= $this->input->post("consultant_qq_number");
	  		$phones_data= $this->input->post("consultant_phone_number");
	  		$email_data= $this->input->post("consultant_email_number");

	  		if(!empty($qq_data)){
				$res = $this->check_info($qq_data,'qq',0);
		  		if(!empty($res)){
		  			show_message($res['con_info'][0]['consultant_name']."已使用此".$res['type']."(咨询师:".$res['teach_name'].")");
		  		}
	  		}
			if(!empty($phones_data)){
		  		$res = $this->check_info($phones_data,'phones',0);

		  		if(!empty($res)){
		  			show_message($res['con_info'][0]['consultant_name']."已使用此".$res['type']."(咨询师:".$res['teach_name'].")");
		  		}
		  	}
		  	if(!empty($email_data)){
		  		$res = $this->check_info($email_data,'email',0);
				if(!empty($res)){
		  			show_message($res['con_info'][0]['consultant_name']."已使用此".$res['type']."(咨询师:".$res['teach_name'].")");
		  		}
		  	}

	  		$data=array();
	  		
	  		$data['consultant_other_contacts']          = $this->input->post("consultant_other_contacts");#其他联系方式
			$data['consultant_name']          = $this->input->post("consultant_name");#姓名
			$data['consultant_sex']           = $this->input->post("sex");#性别
			$data['consultant_consultate_remark']       = $this->input->post("consultant_consultate_remark");#咨询者咨询形式备注
			$data['consultant_channel_remark']       = $this->input->post("consultant_channel_remark");#咨询者咨询渠道备注
			$data['consultant_firsttime']     = time();#时间
			$data['consultant_lastime']     = time();#最后修改时间
			$data['consultant_consultate_id'] = $this->input->post("consultant_consultate_id");#咨询者咨询形式
			//咨询形式其他
			$data['consultant_consultate_other']=$this->input->post("consultant_consultate_other");
			
			$data['consultant_channel_id']    = $this->input->post("consultant_channel_id");#咨询者渠道ID

			//咨询渠道其他
			$data['consultant_channel_other']=$this->input->post("consultant_channel_other");		

			$data['marketing_specialist_id']    = $this->input->post("marketing_specialist_id");#咨询者市场专员ID

			$data['consultant_otherinfo']     = $this->input->post("consultant_otherinfo");#咨询者的其他信息

			$set_view= $this->input->post("set_view"); #上门时间
			if ($set_view=='1') {
				$data['consultant_set_view_time']  = time();#咨询者的上门时间
				$data['consultant_set_view']  = $set_view;
			}else{
				$data['consultant_set_view_time']  = 0;#咨询者的上门时间
				$data['consultant_set_view']  = 0;
			}
				
			
			$data['consultant_school']    = $this->input->post("consultant_school");#毕业学校
			$data['consultant_specialty']    = $this->input->post("consultant_specialty");#专业

			#学历
			$education = $this->input->post("consultant_education");
			$education_other = $this->input->post("consultant_education_other");

			if ($education=='其他') {
				$data['consultant_education']=$education_other;
				if($data['consultant_education']==''){
					$data['consultant_education']='其他';
				}
			}else{
				$data['consultant_education']=$education;
			}

			//如果接收到 员工id，则表示是超级管理员
			$employee=$this->input->post("employee_id");
			if($employee){
				$data['employee_id']   =$employee;
			}else{
				$data['employee_id']   =getcookie_crm('employee_id');#员工ID
			}
			
			#返回插入的咨询者id
	  		$res= $this->main_data_model->insert($data,'consultant');

	  		if($res>0){
	  			#接收qq号
	  			$qq_data= $this->input->post("consultant_qq_number");
	  			$qq_data=array_unique($qq_data);
				foreach ($qq_data as $v) {
					$v= trim($v);
					if($v!=''){
						$where=array('qq_number'=>$v);
						//重复即不在插入
						if($this->main_data_model->count($where,'consul_stu_qq')>1){continue;};
						$insert_qq=array();
						$insert_qq['is_student']=0;
						$insert_qq['consultant_id']=$res;
						$insert_qq['student_id']=0;
						$insert_qq['qq_number']=$v;
						$this->main_data_model->insert($insert_qq,'consul_stu_qq');
					}
				}
				#接收phone号
	  			$phone_data= $this->input->post("consultant_phone_number");
	  			$phone_data=array_unique($phone_data);
				foreach ($phone_data as $v) {
					$v= trim($v);
					if($v!=''){
						$where=array('phone_number'=>$v);
						//重复即不在插入
						if($this->main_data_model->count($where,'consul_stu_phones')>1){continue;};
						$insert_phone=array();
						$insert_phone['is_student']=0;
						$insert_phone['consultant_id']=$res;
						$insert_phone['student_id']=0;
						$insert_phone['phone_number']=$v;
						$this->main_data_model->insert($insert_phone,'consul_stu_phones');
					}
				}

				#接收email
	  			$email_data= $this->input->post("consultant_email_number");
	  			$email_data=array_unique($email_data);
				foreach ($email_data as $v) {
					$v= trim($v);
					if($v!=''){
						$where=array('email'=>$v);
						//重复即不在插入
						if($this->main_data_model->count($where,'consul_stu_email')>1){continue;};
						$insert_email=array();
						$insert_email['is_student']=0;
						$insert_email['consultant_id']=$res;
						$insert_email['student_id']=0;
						$insert_email['email']=$v;
						$this->main_data_model->insert($insert_email,'consul_stu_email');
					}
				}

	  			if($this->input->post("location")==1){
	  				show_message('添加成功！',site_url(module_folder(2).'/advisory/index/index/0'));
	  			}else{
	  				show_message('添加成功！',site_url(module_folder(2).'/consultant_record/add/'.$res));	
	  			}
	  			

	  		}else{
	  			show_message('添加失败！');
	  		}
	  		
			
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
			show_message('权限不对',site_url(module_folder(2).'/advisory/index/index/0'));
		}

		$this->load->model('consultant_model');

		$res= $this->consultant_model->checkData($id,$type);

		
		if ($res===0) {
			if($is_ajax=='ajax'){
				return 0;//表示操作了非法数据	
			}else{
				show_message('权限不对',site_url(module_folder(2).'/advisory/index/index/0'));
			}
		
		}else{
			return 1;
		}

	}

	/**
	 * 编辑咨询者
	 */
	public function edit()
	{

		$edit = $this->uri->segment(5,0);
		$client_type = $this->uri->segment(6,0);

		//检查咨询者所属者
		$this->_checkPower($edit);


		if ($edit==0) {
			show_message('无效的参数!',site_url(module_folder(2).'/student/index'));			
		}

		$check=array(
			array('consultant_name','咨询者姓名')
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

			#咨询者信息
			$where=array('consultant_id'=>$edit);
			$consultant = $this->main_data_model->getOne($where);

			#咨询者的qq
			$consultant_qq = $this->main_data_model->getOtherAll('qq_number,qq_id',$where,'consul_stu_qq');
			#咨询者的phone
			$consultant_phone =	$this->main_data_model->getOtherAll('phone_number,phone_id',$where,'consul_stu_phones');
			#咨询者的email
			$consultant_email =	$this->main_data_model->getOtherAll('email,email_id',$where,'consul_stu_email');

			#赋值
			$data['consultant']       =$consultant;
			
			$data['consultant_qq1']   =array_shift($consultant_qq);
			$data['consultant_qq']    =$consultant_qq;
			$data['consultant_phone1']=array_shift($consultant_phone);
			$data['consultant_phone'] =$consultant_phone;
			$data['consultant_email1']=array_shift($consultant_email);
			$data['consultant_email'] =$consultant_email;
			if(isset($_SERVER['HTTP_REFERER'])){
				$data['location']=$_SERVER['HTTP_REFERER'];
			}else{
				$data['location']=site_url(module_folder(2).'/advisory/index/index/0');	
			}
			
			$data['client_type'] = $client_type;

			#市场专员
			$this->load->model('employee_model');
			$data['marketing_specialist'] = $this->employee_model->selectEmployee(18);

			$this->load->view('advisory_edit',$data);


		}else{
			$location=$this->input->post('location');

			$data=array();
	  		$stu_info=array();
	  		$stu_info['student_other_contacts']= $data['consultant_other_contacts'] = $this->input->post("consultant_other_contacts");#其他联系方式
			$stu_info['student_name']		   = $data['consultant_name']           = $this->input->post("consultant_name");#姓名
			$stu_info['student_sex']		   = $data['consultant_sex']            = $this->input->post("sex");#性别
			$stu_info['student_lastime']	   = $data['consultant_lastime']        = time();#最后修改时间
			$data['consultant_consultate_id']  = $this->input->post("consultant_consultate_id");#咨询者咨询形式
			$data['consultant_consultate_remark'] = $this->input->post("consultant_consultate_remark");#咨询者咨询形式备注
			$data['consultant_channel_remark']    = $this->input->post("consultant_channel_remark");#咨询者咨询渠道备注

			//咨询形式其他信息。
			$data['consultant_consultate_other']=$this->input->post("consultant_consultate_other");
			
			$data['consultant_channel_id']    = $this->input->post("consultant_channel_id");#咨询者渠道ID

			$data['marketing_specialist_id']    = $this->input->post("marketing_specialist_id");#咨询者市场专员ID

			//咨询渠道其他信息
			$data['consultant_channel_other']=$this->input->post("consultant_channel_other");
			

			$stu_info['student_otherinfo']   = $data['consultant_otherinfo']     = $this->input->post("consultant_otherinfo");#咨询者的其他信息

			$stu_info['student_school']      = $data['consultant_school']    = $this->input->post("consultant_school");#毕业学校
			$stu_info['student_specialty']   = $data['consultant_specialty']    = $this->input->post("consultant_specialty");#专业

			#学历
			$education = $this->input->post("consultant_education");
			$education_other = $this->input->post("consultant_education_other");

			if ($education=='其他') {
				$data['consultant_education']=$education_other;
				if($data['consultant_education']==''){
					$data['consultant_education']='其他';
				}
			}else{
				$data['consultant_education']=$education;
			}

			$stu_info['student_education'] =$data['consultant_education'];

			#接收是不是学生
			$is_student= $this->input->post("is_student");

			$set_view = $this->input->post("set_view");

			if($is_student==0){ //如果是学生，就不能改了
				#未上门与已上门
				if ($set_view=='1') {
					if(!$this->input->post("consultant_set_view_time")){
						$data['consultant_set_view_time']  = time();#咨询者的上门时间
					}else{
						$data['consultant_set_view_time']  = $this->input->post("consultant_set_view_time");#咨询者的上门时间
					}
									
					$data['consultant_set_view']  = $set_view;
				}else{
					$data['consultant_set_view_time']  = 0;#咨询者的上门时间
					$data['consultant_set_view']  = 0;
				}
			}

			//如果接收到 员工id，则表示是超级管理员
			$employee=$this->input->post("employee_id");
			$old_employee_id=$this->input->post("old_employee_id");
			if($employee){
				$data['employee_id']   =$employee;
				$data['old_employee_id']   =$old_employee_id;
				$stu_info['employee_id']=$data['employee_id'];
				$stu_info['old_employee_id']=$old_employee_id;
			}

			

			//如果是学生,修改学生的信息
			if($is_student){
				$this->_editStudentInfo($stu_info,$edit);
			}


			$where=array('consultant_id'=>$edit);

			#修改咨询者的信息
	  		$res= $this->main_data_model->update($where,$data,'consultant');
			#学生ID
			$where = array('consultant_id'=>$edit);
			$student_info = $this->main_data_model->getOne($where,'student_id','student');

			/*#删除旧的phone号
			$this->main_data_model->delete($where,1,'consul_stu_phones');
  			#接收phone号
	  		$phone_data= $this->input->post("consultant_phone_number");
	  		$phone_data=array_unique($phone_data);
			foreach ($phone_data as $v) {
				$v= trim($v);
				if($v!=''){
					$insert_phone=array();
					$insert_phone['is_student']=0;
					$insert_phone['consultant_id']=$edit;			
					$insert_phone['phone_number']=$v;

					if($is_student==1){
						$insert_phone['student_id']=$student_info['student_id'];
					}else{
						$insert_phone['student_id']=0;
					}
			 	    $res1= $this->main_data_model->insert($insert_phone,'consul_stu_phones');
				}
			}*/

			#删除旧的qq号
			//$this->main_data_model->delete($where,1,'consul_stu_qq');

			#接收qq号,插入新的qq号
  			/*$qq_data= $this->input->post("consultant_qq_number");
  			$qq_data=array_unique($qq_data);
			foreach ($qq_data as $v) {
				$v= trim($v);
				if($v!=''){
					$insert_qq=array();
					$insert_qq['is_student']=0;
					$insert_qq['consultant_id']=$edit;
					$insert_qq['qq_number']=$v;

					if($is_student==1){
						$insert_qq['student_id']=$student_info['student_id'];
					}else{
						$insert_qq['student_id']=0;
					}
					$res2=$this->main_data_model->insert($insert_qq,'consul_stu_qq');
				}

			}*/

			/*#删除旧的 email
			$this->main_data_model->delete($where,1,'consul_stu_email');

				#接收email ,插入新的email
  			$email_data= $this->input->post("consultant_email_number");
  			$email_data=array_unique($email_data);
			foreach ($email_data as $v) {
				$v= trim($v);
				if($v!=''){
					$insert_email=array();
					$insert_email['is_student']=0;
					$insert_email['consultant_id']=$edit;
					$insert_email['email']=$v;

					if($is_student==1){
						$insert_email['student_id']=$student_info['student_id'];
					}else{
						$insert_email['student_id']=0;
					}
					$res2=$this->main_data_model->insert($insert_email,'consul_stu_email');
				}

			}*/
			#接收phone QQ email
	  		$update_phone= $this->input->post("update_phone");
			$add_phone= $this->input->post("add_phone");

			$update_qq= $this->input->post("update_qq");
			$add_qq= $this->input->post("add_qq");

			$update_email= $this->input->post("update_email");
			$add_email= $this->input->post("add_email");

			//验证QQ 电话 邮箱
	  		if(!empty($update_phone)){
				$res_p = $this->check_info($update_phone,'phones',$edit);
		  		if(!empty($res_p)){
		  			show_message($res_p['con_info'][0]['consultant_name']."已使用此".$res_p['type']."(咨询师:".$res_p['teach_name'].")");
		  		}
	  		}
	  		if(!empty($add_phone)){
	  			$res_p1 = $this->check_info($add_phone,'phones',$edit);
		  		if(!empty($res_p1)){
		  			show_message($res_p1['con_info'][0]['consultant_name']."已使用此".$res_p1['type']."(咨询师:".$res_p1['teach_name'].")");
		  		}
		  	}	
			if(!empty($update_qq)){
		  		$res_q = $this->check_info($update_qq,'qq',$edit);
		  		if(!empty($res_q)){
		  			show_message($res_q['con_info'][0]['consultant_name']."已使用此".$res_q['type']."(咨询师:".$res_q['teach_name'].")");
		  		}
		  	}
		  	if(!empty($add_qq)){
		  		$res_q1 = $this->check_info($add_qq,'qq',$edit);
		  		if(!empty($res_q1)){
		  			show_message($res_q1['con_info'][0]['consultant_name']."已使用此".$res_q1['type']."(咨询师:".$res_q1['teach_name'].")");
		  		}
		  	}
		  	if(!empty($update_email)){
		  		$res_e = $this->check_info($update_email,'email',$edit);
				if(!empty($res_e)){
		  			show_message($res_e['con_info'][0]['consultant_name']."已使用此".$res_e['type']."(咨询师:".$res_e['teach_name'].")");
		  		}
		  	}
		  	if(!empty($add_email)){
		  		$res_e1 = $this->check_info($add_email,'email',$edit);
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
						$edit_phone['is_student']=0;
						$edit_phone['consultant_id']=$edit;
						$edit_phone['phone_number']=$v;

						if($is_student==1){
							$edit_phone['student_id']=$student_info['student_id'];
						}else{
							$edit_phone['student_id']=0;
						}
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
						$insert_phone['is_student']=0;
						$insert_phone['consultant_id']=$edit;
						$insert_phone['phone_number']=$v;

						if($is_student==1){
							$insert_phone['student_id']=$student_info['student_id'];
						}else{
							$insert_phone['student_id']=0;
						}
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
						$edit_qq['is_student']=0;
						$edit_qq['consultant_id']=$edit;
						$edit_qq['qq_number']=$v;

						if($is_student==1){
							$edit_qq['student_id']=$student_info['student_id'];
						}else{
							$edit_qq['student_id']=0;
						}
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
						$insert_qq['is_student']=0;
						$insert_qq['consultant_id']=$edit;
						$insert_qq['qq_number']=$v;

						if($is_student==1){
							$insert_qq['student_id']=$student_info['student_id'];
						}else{
							$insert_qq['student_id']=0;
						}
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
						$edit_email['is_student']=0;
						$edit_email['consultant_id']=$edit;
						$edit_email['email']=$v;

						if($is_student==1){
							$edit_email['student_id']=$student_info['student_id'];
						}else{
							$edit_email['student_id']=0;
						}
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
						$insert_email['is_student']=0;
						$insert_email['consultant_id']=$edit;
						$insert_email['email']=$v;

						if($is_student==1){
							$insert_email['student_id']=$student_info['student_id'];
						}else{
							$insert_email['student_id']=0;
						}
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
	 * 修改咨询者的信息、顺带修改学生的信息
	 */
	private function _editStudentInfo($stu,$edit)
	{

		$where=array('consultant_id'=>$edit);
		$this->main_data_model->update($where,$stu,'student');

	}

	/**
	 * 虚拟删除咨询者，同步删除学员、客户（一般都是误操作）
	 */
	public function changeStatus()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[1][1];
		
		$dele_arr= $this->input->post('checkbox_consultant');

		//检查咨询者所属者
		$this->_checkPower($dele_arr,'in');

		$where = $remind_where = db_create_in($dele_arr,'consultant_id');
		#修改咨询者状态
		$status = array('show_status'=>0);
		$result = $this->main_data_model->update($where,$status,'consultant');

		#如果是学员，修改学员状态
		$res = $this->main_data_model->getOtherAll('consultant_id,student_id',$where,'student');

		if(!empty($res)){
			$this->main_data_model->update($where,$status,'student');
			$dele_stu_arr=array();
			foreach ($res as $value) {
				$dele_stu_arr[]=$value['student_id'];
			}
			#删除学生，就把记录（课程、知识点，缴费记录，缴费账单，提醒记录）全部删除
			$stu_cur_where = array('student_id',$dele_stu_arr);
			$con_cur_where = array('consultant_id',$dele_arr);
			$this->main_data_model->delete($stu_cur_where,2,'student_curriculum_relation');
			$this->main_data_model->delete($stu_cur_where,2,'student_knowleage_relation');
			$this->main_data_model->delete($stu_cur_where,2,'refund_loan_time');
			$this->main_data_model->delete($stu_cur_where,2,'student_repayment_bills');
			$this->main_data_model->delete($stu_cur_where,2,'time_remind');
			$this->main_data_model->delete($con_cur_where,2,'time_remind');			
		}

		#如果删除客户，就把记录（项目，缴费记录，缴费账单，提醒记录）全部删除
		$con_cur_where = array('consultant_id',$dele_arr);//refund_loan_time表中要保证student_id是null
		$this->main_data_model->delete($con_cur_where,2,'client_project_record');

		$this->load->model('student_repayment_bills_model','student_repayment_bills');
		$del_where1 = $where." and student_id is null ";
		$this->student_repayment_bills->deleteRepaymentBills($del_where1);

		$this->load->model('refund_loan_time_model','refund_loan_time');
		$del_where2 = $where." and student_id is null ";
		$this->refund_loan_time->deletePayment($del_where2);

		$this->load->model('time_remind_model');
		$del_where3 = $where." and is_client=1 ";
		$this->time_remind_model->deleteTimeRemind($del_where3);

		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}
	}

	/**
	 * 删除咨询者，顺带删除咨询者的phone跟qq，如果是已经成为学员的，不删除qq、phone
	 */
	/*public function delete()
	{	
		$delete = $this->uri->segment(5,0);

		#删除咨询者
		$where=array('consultant_id'=>$delete);
		$result= $this->main_data_model->delete($where,1,'consultant');

		#删除qq与phone
		$student=array('is_student'=>0);
		$where=$where+$student;
		$this->main_data_model->delete($where,1,'consul_stu_phones');
		$this->main_data_model->delete($where,1,'consul_stu_qq');
		$this->main_data_model->delete($where,1,'consul_stu_email');

		if($result>0){
  			show_message('删除成功!',site_url(module_folder(2).'/advisory/index'));	
  		}else{
  			show_message('操作失败!');
  		}
	}*/
	

	/**
	 * 批量删除咨询者
	 */
	/*public function deleteAll()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));

		
		$location=$url[1][1];

		$dele_arr= $this->input->post('checkbox_consultant');

		#批量删除咨询者
		$where = $remind_where = db_create_in($dele_arr,'consultant_id');

		$result= $this->main_data_model->delete($where,1,'consultant');

		#删除qq与phone
		$where="`is_student` = '0' AND ".db_create_in($dele_arr,'consultant_id');

		$this->main_data_model->delete($where,1,'consul_stu_phones');
		$this->main_data_model->delete($where,1,'consul_stu_qq');
		$this->main_data_model->delete($where,1,'consul_stu_email');

		//更改咨询者的提醒（设置不提醒）
		$remind_data = array('time_remind_status'=>-1);
		$this->main_data_model->update($remind_where,$remind_data,'time_remind');
		
		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}

	}*/
	/**
	 * 设置为已上门，1表示已上门,0表示未上门
	 * 返回状态status 0表示错误,1表示成功
	 */
	public function setView(){
		$id=$this->input->post('id');

		//检查咨询者所属者
		$check_result = $this->_checkPower($id,'','ajax');
		if(!$check_result){ //如果返回的是 0,这个
			echo json_encode(array('status'=>0));
			die;
		}

		if ($id==false) {
			echo json_encode(array('status'=>0));
			die;
		}
		$where=array('consultant_id'=>$id);
		$data=array('consultant_set_view'=>1,'consultant_set_view_time'=>time());

		$num= $this->main_data_model->update($where,$data,'consultant');
		$visit= $this->main_data_model->count(array("consultant_set_view"=>1,"is_student"=>0),'consultant');
		$notvisit= $this->main_data_model->count(array("consultant_set_view"=>0,"is_student"=>0),'consultant');

		if ($num>0) {
			echo json_encode(array('status'=>1,'visit'=>$visit,'notvisit'=>$notvisit));
		}else{
			echo json_encode(array('status'=>0));
		}

		die;
	}
	/**
	 *  ajax获取更为详细的咨询者信息。
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

		$where=array('consultant_id'=>$id);
		#咨询者
		$consultant= $this->main_data_model->getOne($where,'','consultant');

		#咨询者phone
		$consultant_phone= $this->main_data_model->setTable('consul_stu_phones')->select('phone_number',$where);

		#咨询者qq
		$consultant_qq= $this->main_data_model->setTable('consul_stu_qq')->select('qq_number',$where);

		#咨询者email
		$consultant_email= $this->main_data_model->setTable('consul_stu_email')->select('email',$where);
		
		$str='<table border="1" width="100%">';
		$str.="<tr>";
		$str.="<td width='23%'>姓名</td><td>".$consultant['consultant_name']."</td>";
		$str.="</tr>";
	
		#phone
		if($consultant_phone){
			foreach($consultant_phone as $item){
				$str.="<tr>";
				$str.="<td>联系方式</td><td>".$item['phone_number']."</td>";
				$str.="</tr>";
			}
		}
		#qq
		if($consultant_qq){
			foreach($consultant_qq as $item){
				$str.="<tr>";
				$str.="<td>QQ</td><td>".$item['qq_number']."</td>";
				$str.="</tr>";
			}
		}
		#邮箱
		if($consultant_email){
			foreach($consultant_email as $item){
				$str.="<tr>";
				$str.="<td>邮箱</td><td>".$item['email']."</td>";
				$str.="</tr>";
			}
		}

		#其他联系方式
		if($consultant['consultant_other_contacts'] != ''){
			$str.="<tr>";
			$str.="<td>其他联系方式</td><td>".$consultant['consultant_other_contacts']."</td>";
			$str.="</tr>";
		}	

		#性别
		if ($consultant['consultant_sex']==1) {
			 	$sex = '男';
			}else if($consultant['consultant_sex']==2){
			 	$sex = '女';
			}else{
				$sex = '';
			}
		#性别
		$str.="<tr>";
		$str.="<td>性别</td><td>".$sex."</td>";
		$str.="</tr>";
		#添加时间
		$str.="<tr>";
		$str.="<td>添加时间</td><td>".date('Y-m-d',$consultant['consultant_firsttime'])."</td>";
		$str.="</tr>";
		
		#咨询形式
		if($consultant['consultant_consultate_id']!=0 && $consultant['consultant_consultate_id']!=6){	 //其他咨询形式
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
		if($consultant['consultant_channel_id']!=0 && $consultant['consultant_channel_id']!=12){    //其他咨询渠道
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
		
		#咨询者其他信息
		if(trim($consultant['consultant_otherinfo'])!=''){
			$str.="<tr>";
			$str.="<td>咨询者其他信息</td><td>".$consultant['consultant_otherinfo']."</td>";
			$str.="</tr>";
		}

		#学历
		if(trim($consultant['consultant_education'])!=''){
			$str.="<tr>";
			$str.="<td>学历</td><td>".$consultant['consultant_education']."</td>";
			$str.="</tr>";
		}
		#毕业学校
		if(trim($consultant['consultant_school'])!=''){
			$str.="<tr>";
			$str.="<td>毕业学校</td><td>".$consultant['consultant_school']."</td>";
			$str.="</tr>";
		}
		#就读专业
		if(trim($consultant['consultant_specialty'])!=''){
			$str.="<tr>";
			$str.="<td>就读专业</td><td>".$consultant['consultant_specialty']."</td>";
			$str.="</tr>";
		}

		#是否上门
		if($consultant['consultant_set_view'] == 0){
			$set_view = '未上门';
		}else{
			$set_view = '已上门';
		}

		$str.="<tr>";
		$str.="<td>是否已上门</td><td>".$set_view."</td>";
		$str.="</tr>";


		$str.="</table>";

		$res['data'] = $str;
		$res['info_url'] = site_url(module_folder(2).'/advisory/edit/'.$id);
		$res['status']=1;
		
		echo json_encode($res);
		exit;

	}
	
	/**
	 *  设为学员
	 */
	public function setStudent()
	{

		header("Content-Type:text/html;charset=utf-8");
		if (!empty($_POST)) { 

			$course_info = $this->input->post();
/*echo '<pre>';
print_r($course_info);exit;*/
			//检查操作该咨询者的咨询师是否服务器的对应。
			$this->_checkPower($course_info['consultant_id']);


			//判断是否已选中课程
			if(empty($course_info['course_name']) || empty($course_info['knowledge_name'])){
				show_message('请选择课程或知识点！');
			}

			$check=array(
				array('tuition_total','应缴学费'),
				array('already_total','已缴学费'),
			);
			check_form($check);
			
			#更新咨询者为学员
			$where = array('consultant_id'=>$course_info['consultant_id'],'is_student'=>0);
			$consultant_info = $this->main_data_model->getOne($where,'*','consultant');
			$info = array_merge($course_info,$consultant_info);

			//联系方式
			$consultant_phone = $this->main_data_model->getOtherAll('*',$where,'consul_stu_phones');
			//qq
			$consultant_qq = $this->main_data_model->getOtherAll('*',$where,'consul_stu_qq');
			//eamil
			$consultant_email = $this->main_data_model->getOtherAll('*',$where,'consul_stu_email');

			//设为学员
			$student_info = array(
					'consultant_id'=>$info['consultant_id'], #咨询者ID
					'employee_id'=>$info['employee_id'], #咨询师ID
					'student_other_contacts'=>$info['consultant_other_contacts'], #学员其他联系方式
					'student_sex'=>$info['consultant_sex'], #学员性别
					'student_name'=>$info['consultant_name'], #学员名字
					'student_education'=>$info['consultant_education'], #学员学历
					'student_school'=>$info['consultant_school'], #学员毕业学校
					'student_specialty'=>$info['consultant_specialty'], #学员就读专业
					'sign_up_date'=>strtotime($course_info['course_payment_time']), #第一次的缴费日期就是报名时间
					'constu_intention_course'=>$info['constu_intention_course'],
					'intention_course_remark'=>$info['intention_course_remark']
				);

			//更新学号,如果咨询者有预学号就直接更新,没有的话就查询自动增加
			/*if(!empty($info['pre_number'])){
				$student_info['student_number']=$info['pre_number']; #预学号
				//删除预学号
  				$pre_student = array('consultant_id' => $info['consultant_id']);
				$pre_data = array('pre_number' => '');
  				$this->main_data_model->update($pre_student,$pre_data,'consultant');
			}else{
  				$this->load->model('consultant_model');
  				$con_pre_number=$this->consultant_model->select_number();

  				$this->load->model('student_model');
  				$student_number=$this->student_model->select_number();
  				//如果不为空就咨询者那里累加,如果为空的话就在学员表那里累加
  				if(!empty($con_pre_number[0]['pre_number'])){
  					//防止出错,以最大的作为增加的
  					if($con_pre_number[0]['pre_number']>$student_number[0]['student_number']){
  						$number=$con_pre_number[0]['pre_number'];
  					}else{
  						$number=$student_number[0]['student_number'];
  					}
  					//查出的学号加1
	  				$add_number = getYearNum($number);
	  				$student_info['student_number']=$add_number; #预学号
  				}else{
  					//查出的学号加1
  					$add_number = getYearNum($student_number[0]['student_number']);
  					$student_info['student_number']=$add_number; #预学号	
  				}
			}*/
			//查询学生表，看之前是否是学生
			$where_consultant=array('consultant_id'=>$info['consultant_id']);
			$res_student=$this->main_data_model->getOne($where_consultant,'student_id','student');
			//如果是就更新操作，不是就插入操作
			if($res_student){
				$where_student=array('student_id' => $res_student['student_id']);
				$student_status=array('show_status' => 1);
				$this->main_data_model->update($where_student,$student_status,'student');
				$student_id  = $res_student['student_id'];
			}else{
				$student_id  = $this->main_data_model->insert($student_info,'student');
			}

			//$student_id  = $this->main_data_model->insert($student_info,'student');

			$employee_id = $info['employee_id'];
			if($student_id>0){
				#插入基本还款账单
				$pay_info = array(
						'student_id'=>$student_id,
						'consultant_id'=>$info['consultant_id'],
						'course_remark'=>$course_info['course_remark'], #课程备注
						'payment_type_id'=>$course_info['payment_type_id'],#缴费类型
						'study_expense'=>$course_info['tuition_total'],#应缴学费
						'special_payment_remark'=>$course_info['special_payment_remark'] #特殊情况备注				
					);

				#先就业后付款（包吃住）
				if($course_info['payment_type_id']==3){
					$pay_info['apply_money'] = $course_info['apply_money1'];
					$pay_info['organization_paydate'] = $course_info['organization_paydate1'];
					$pay_info['student_start_paydate'] = strtotime($course_info['student_start_paydate1']);
					$pay_info['apply_desc'] = $course_info['apply_desc1'];
				}

				#先就业后付款（不包吃住）
				if($course_info['payment_type_id']==4){
					$pay_info['apply_money'] = $course_info['apply_money2'];
					$pay_info['organization_paydate'] = $course_info['organization_paydate2'];
					$pay_info['student_start_paydate'] = strtotime($course_info['student_start_paydate2']);
					$pay_info['apply_desc'] = $course_info['apply_desc2'];
				}

				#先就业后付款（工资方案）
				if($course_info['payment_type_id']==5){
					$pay_info['apply_money'] = $course_info['apply_money3'];
					$pay_info['organization_paydate'] = $course_info['organization_paydate3'];
					$pay_info['student_start_paydate'] = strtotime($course_info['student_start_paydate3']);
					$pay_info['apply_desc'] = $course_info['apply_desc3'];
				}

				$repayment_id = $this->main_data_model->insert($pay_info,'student_repayment_bills');

				#新增缴费、定位费记录（学费记录表）
				$pay_refund = array(
							'student_id'=>$student_id,
							'consultant_id'=>$info['consultant_id'],
							'payment_money' => $course_info['already_total'], #已缴学费
							'repayment_id'  => $repayment_id, #账单ID
							'payment_status'=> 1, #缴费状态
							'payment_desc'  => $course_info['payment_desc'],  #学费描述
							'payment_type_id' => $course_info['payment_type_id'] #缴费类型
						);
				if(!empty($course_info['course_payment_time'])){
					$pay_refund['payment_time'] = strtotime($course_info['course_payment_time']); #缴费日期
					$pay_refund['already_paytime'] = strtotime($course_info['course_payment_time']); #完成缴费日期
				}else{
					$pay_refund['payment_time'] = time();
					$pay_refund['already_paytime'] = time();		
				}

				if($course_info['select_type'] == 1){ #定位费（学费记录）
					$pay_refund['payment_type'] = 2; #缴费类型（0，缴费/默认；1，生活补贴；2，定位费；3，分期缴费 4，工资补贴）
					$position_total = $course_info['already_total']; //定位费
				}else{
					$position_total = '';
				}

				$this->main_data_model->insert($pay_refund,'refund_loan_time');

				#分期应缴学费
				if($course_info['payment_type_id']==2){  #分期付款
					if(!empty($course_info['payment_time1'])){
						foreach ($course_info['payment_time1'] as $k => $v) {
							if(!empty($v)){
								$refund_info = array(
									'student_id' => $student_id,
									'consultant_id'=>$info['consultant_id'],
									'payment_time' => strtotime($v), #应缴费日期
									'already_paytime' => 0, #完成缴费日期
									'payment_money' => $course_info['payment_money1'][$k], #应缴学费
									'remind_time' => strtotime($course_info['remind_time1'][$k]), #提醒时间
									'repayment_id' => $repayment_id, #账单ID
									'payment_status' => 0, #缴费状态
									'payment_desc' => $course_info['payment_desc1'][$k],  #学费说明
									'payment_type_id' => $course_info['payment_type_id'], #缴费类型
									'payment_type' => 3
								);

								$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

								$remind_info = array(         #分期缴费提醒
									'loan_time_id' => $refund_id,
									'consultant_id' => $info['consultant_id'],
									'student_id' => $student_id,
									'employee_id' => $employee_id,#员工ID
									'repayment_id'=>$repayment_id,
									'time_remind_time'=>strtotime($course_info['remind_time1'][$k])//有时间就提醒
								);

								#查询咨询者的姓名,手机,QQ加入到提醒内容
								$where_id = array('consultant_id'=>$info['consultant_id']);
								$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
								$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
								//分割数组
								$phone=$this->_dataProcess($phone_infos,'phone_number');
								$phone=implode(',', $phone);
								$qq=$this->_dataProcess($qq_infos,'qq_number');
								$qq=implode(',', $qq);

								$remind_info['time_remind_content'] = '学员 '.$info['consultant_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$course_info['payment_money1'][$k].'元，请及时提醒该学生完成缴费！';

								$remind_id = $this->main_data_model->insert($remind_info,'time_remind');							
							}
						}			
					}
				}

				 #先就业后付款（包吃住=》生活补贴）
				if($course_info['payment_type_id']==3){ 
					if(!empty($course_info['payment_time2'])){
						foreach ($course_info['payment_time2'] as $k => $v) {
							if(!empty($v)){
								$refund_info = array(
									'student_id' => $student_id,
									'consultant_id' => $info['consultant_id'],
									'payment_time' => strtotime($v), #放款日期
									'already_paytime' => 0, #完成放款日期
									'payment_money' => $course_info['payment_money2'][$k], #放款金额
									'remind_time' => strtotime($course_info['remind_time2'][$k]), #提醒时间
									'repayment_id' => $repayment_id, #账单ID
									'payment_status' => 0, #缴费状态
									'payment_desc' => $course_info['payment_desc2'][$k],  #放款说明
									'payment_type_id' => $course_info['payment_type_id'], #缴费类型
									'payment_type' => 1
								);

								$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

								$remind_info = array(    #生活补贴时间提醒
									'loan_time_id' => $refund_id,
									'consultant_id' => $info['consultant_id'],
									'student_id' => $student_id,
									'employee_id' => $employee_id,#员工ID
									'time_remind_time' => strtotime($course_info['remind_time2'][$k]), #提醒时间
									'repayment_id'=>$repayment_id,
									'payment_type'=> 1
								);
								#查询咨询者的姓名,手机,QQ加入到提醒内容
								$where_id = array('consultant_id'=>$info['consultant_id']);
								$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
								$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
								//分割数组
								$phone=$this->_dataProcess($phone_infos,'phone_number');
								$phone=implode(',', $phone);
								$qq=$this->_dataProcess($qq_infos,'qq_number');
								$qq=implode(',', $qq);

								$remind_info['time_remind_content'] = '学员 '.$info['consultant_name'].'的学费是属于先就业后付款（包吃住），发放生活补贴的时间到了，发放金额是：'.$course_info['payment_money2'][$k].'元，请及时处理！';

								$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
							}
						}			
					}
				}

				#先就业后付款（工资方案=》工资补贴）
				if($course_info['payment_type_id']==5){ 
					if(!empty($course_info['payment_time3'])){
						foreach ($course_info['payment_time3'] as $k => $v) {
							if(!empty($v)){
								$refund_info = array(
									'student_id' => $student_id,
									'consultant_id' => $info['consultant_id'],
									'payment_time' => strtotime($v), #放款日期
									'already_paytime' => 0, #完成放款日期
									'payment_money' => $course_info['payment_money3'][$k], #放款金额
									'remind_time' => strtotime($course_info['remind_time3'][$k]), #提醒时间
									'repayment_id' => $repayment_id, #账单ID
									'payment_status' => 0, #缴费状态
									'payment_desc' => $course_info['payment_desc3'][$k],  #放款说明
									'payment_type_id' => $course_info['payment_type_id'], #缴费类型
									'payment_type' => 4
								);

								$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

								$remind_info = array(    #工资补贴时间提醒
									'loan_time_id' => $refund_id,
									'consultant_id' => $info['consultant_id'],
									'student_id' => $student_id,
									'employee_id' => $employee_id,#员工ID
									'time_remind_time' => strtotime($course_info['remind_time3'][$k]), #提醒时间
									'repayment_id'=>$repayment_id,
									'payment_type'=> 4
								);
								#查询咨询者的姓名,手机,QQ加入到提醒内容
								$where_id = array('consultant_id'=>$info['consultant_id']);
								$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
								$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
								//分割数组
								$phone=$this->_dataProcess($phone_infos,'phone_number');
								$phone=implode(',', $phone);
								$qq=$this->_dataProcess($qq_infos,'qq_number');
								$qq=implode(',', $qq);

								$remind_info['time_remind_content'] = '学员 '.$info['consultant_name'].'的学费是属于先就业后付款（工资方案），发放工资补贴的时间到了，发放金额是：'.$course_info['payment_money3'][$k].'元，请及时处理！';

								$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
							}
						}			
					}
				}

				#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
				$this->_update_payment_info($course_info['tuition_total'],$repayment_id,$student_id,'',$position_total);

				#更新课程
				$insert_course = array();
				foreach ($course_info['course_name'] as $key => $value) {
					$insert_course[] = array(

							'student_id' => $student_id,
							'curriculum_system_id' => $value,
							'repayment_id' => $repayment_id
						);
				}
					
				$this->main_data_model->insert_batch($insert_course,'student_curriculum_relation');

	  			#更新知识点
	  			$insert_knowledge = array();
				foreach ($course_info['knowledge_name'] as $key => $value) {

					foreach ($value as $k => $v) {
						
						$insert_knowledge[] = array(

							'student_id' => $student_id,
							'knowledge_id' => $v,
							'curriculum_system_id' => $key,
							'repayment_id' => $repayment_id
						);
					}
				}

	  			$this->main_data_model->insert_batch($insert_knowledge,'student_knowleage_relation');

				//更新联系方式
				if (!empty($consultant_phone)) {
					foreach ($consultant_phone as $key => $value) {
						$update_where = array('phone_id'=>$value['phone_id']);
						$update_data = array('student_id'=>$student_id,'is_student'=>1);
						$this->main_data_model->update($update_where,$update_data,'consul_stu_phones');
					}
				}

				//更新QQ号码
				if (!empty($consultant_qq)) {
					foreach ($consultant_qq as $key => $value) {
						$update_where = array('qq_id'=>$value['qq_id']);
						$update_data = array('student_id'=>$student_id,'is_student'=>1);
						$this->main_data_model->update($update_where,$update_data,'consul_stu_qq');
					}
				}

				//更新email邮箱
				if (!empty($consultant_email)) {
					foreach ($consultant_email as $key => $value) {
						$update_where = array('email_id'=>$value['email_id']);
						$update_data = array('student_id'=>$student_id,'is_student'=>1);
						$this->main_data_model->update($update_where,$update_data,'consul_stu_email');
					}
				}

				//更新咨询者信息（is_student）
				$update_consultant = array('is_student'=>1);
				$this->main_data_model->update($where,$update_consultant,'consultant');
			}

			if($student_id>0){

	  			show_message($info['consultant_name'].'已成为文豆学员！',site_url(module_folder(2).'/student/index/index/0'));
	  		}else{
	  			show_message('操作失败！');
	  		}
			
		}
	}

	/**
	 *  设为客户
	 */
	public function setClient()
	{

		header("Content-Type:text/html;charset=utf-8");
		if (!empty($_POST)) { 

			$course_info = $this->input->post();

			//检查操作该咨询者的咨询师是否服务器的对应。
			$this->_checkPower($course_info['consultant_id']);

			$check=array(
				array('project_total_money','应缴项目总费用'),
				array('project_already_total','应缴费用'),
			);
			check_form($check);
			
			#更新咨询者为学员
			$where = array('consultant_id'=>$course_info['consultant_id']);
			$consultant_info = $this->main_data_model->getOne($where,'*','consultant');
			$info = array_merge($course_info,$consultant_info);

			$employee_id = $info['employee_id'];
			#插入基本还款账单
			$pay_info = array(
					'consultant_id'=>$info['consultant_id'],
					'payment_type_id'=>$course_info['payment_type_id'],#缴费类型
					'study_expense'=>$course_info['project_total_money'],#项目总费用
					'special_payment_remark'=>$course_info['project_payment_remark'], #特殊情况备注
					'is_project' => 1				
				);

			$repayment_id = $this->main_data_model->insert($pay_info,'student_repayment_bills');

			#新增缴费记录
			$pay_refund = array(
						'consultant_id'=>$info['consultant_id'],
						'payment_money' => $course_info['project_already_total'], #已缴费用
						'repayment_id'  => $repayment_id, #账单ID
						'payment_status'=> 1, #缴费状态
						'payment_desc'  => $course_info['project_payment_remark'],  #备注
						'payment_type_id' => $course_info['payment_type_id'] #缴费类型
					);

			if(!empty($course_info['project_payment_time'])){
				$pay_refund['payment_time'] = strtotime($course_info['project_payment_time']); #缴费日期
				$pay_refund['already_paytime'] = strtotime($course_info['project_payment_time']); #完成缴费日期
			}else{
				$pay_refund['payment_time'] = time();
				$pay_refund['already_paytime'] = time();		
			}

			$this->main_data_model->insert($pay_refund,'refund_loan_time');

			#分期应缴学费
			if($course_info['payment_type_id']==2){  #分期付款
				if(!empty($course_info['pro_payment_time'])){
					foreach ($course_info['pro_payment_time'] as $k => $v) {
						if(!empty($v)){
							$refund_info = array(
								'consultant_id'=>$info['consultant_id'],
								'payment_time' => strtotime($v), #应缴费日期
								'already_paytime' => 0, #完成缴费日期
								'payment_money' => $course_info['pro_payment_money'][$k], #应缴学费
								'remind_time' => strtotime($course_info['pro_remind_time'][$k]), #提醒时间
								'repayment_id' => $repayment_id, #账单ID
								'payment_status' => 0, #缴费状态
								'payment_desc' => $course_info['pro_payment_desc'][$k],  #学费说明
								'payment_type_id' => $course_info['payment_type_id'], #缴费类型
								'payment_type' => 3
							);

							$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

							$remind_info = array(         #分期缴费提醒
								'loan_time_id' => $refund_id,
								'consultant_id' => $info['consultant_id'],
								'employee_id' => $employee_id,#员工ID
								'repayment_id'=>$repayment_id,
								'is_client'=>1,
								'time_remind_time'=>strtotime($course_info['pro_remind_time'][$k])//有时间就提醒
							);

							#查询咨询者的姓名,手机,QQ加入到提醒内容
							$where_id = array('consultant_id'=>$info['consultant_id']);
							$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
							$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
							//分割数组
							$phone=$this->_dataProcess($phone_infos,'phone_number');
							$phone=implode(',', $phone);
							$qq=$this->_dataProcess($qq_infos,'qq_number');
							$qq=implode(',', $qq);

							$remind_info['time_remind_content'] = '客户 '.$info['consultant_name'].'的项目费用是属于分期付款，现在缴费时间到了，缴费金额是：'.$course_info['pro_payment_money'][$k].'元，请及时提醒该客户完成缴费！';

							$remind_id = $this->main_data_model->insert($remind_info,'time_remind');							
						}
					}			
				}
			}

			#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
			$this->_update_payment_info($course_info['project_total_money'],$repayment_id,'',$info['consultant_id']);

			#记录项目信息
			$project_info = array(
					'project_name' => $course_info['project_name'],
					'project_url' => $course_info['project_url'],
					'project_remark' => $course_info['project_payment_remark'],
					'consultant_id' => $info['consultant_id'],
					'repayment_id' => $repayment_id
				);
			$project_id  = $this->main_data_model->insert($project_info,'client_project_record');

			$where = array('consultant_id'=>$course_info['consultant_id']);
			//更新咨询者信息（is_client）
			$update_consultant = array('is_client'=>1);
			$this->main_data_model->update($where,$update_consultant,'consultant');

			if($project_id>0){

	  			show_message($info['consultant_name'].'已成为文豆客户！',site_url(module_folder(2).'/client/index/index/0'));
	  		}else{
	  			show_message('操作失败！');
	  		}
			
		}
	}

	/**
	 * ajax校验咨询者名称
	 */
	public function checkInfo()
	{
		$type = $this->input->post('type');
		$value= $this->input->post('value');

		if( $type == 'consultant_name' ){
			$where=array('consultant_name'=>trim($value),'show_status'=>1);
			$table = 'consultant';
		}else if( $type == 'student_name' ){
			$where=array('student_name'=>trim($value),'show_status'=>1);
			$table = 'student';
		}

		$num= $this->main_data_model->count($where,$table);

		if ($num>0) {
			$res['status'] = 1;
			echo json_encode($res);
		}else{
			//此咨询者不在表中
			$res['status'] = 2;
			echo json_encode($res);
		}
		die;
	}
	
	/**
	 * ajax校验qq、手机号、邮箱
	 */
	public function checked()
	{ 
		$id=$this->uri->segment(5, 0);
		$type = $this->input->post('type');
		$value= $this->input->post('value');
		$arr=array('qq','phones','email');
		if (!in_array($type,$arr)) {
			//ajax过来的数据错误
			$res['status'] = 0;
			echo json_encode($res);
			die;
		}

		$table='consul_stu_'.$type;
		
		if($type=='qq'){
			//$where=array('qq_number'=>trim($value));
			$where_join = $table.".qq_number = '".trim($value)."'";
		}else if($type=='phones'){
			//$where=array('phone_number'=>trim($value));	
			$where_join = $table.".phone_number = '".trim($value)."'";
		}else{
			//$where=array('email'=>trim($value));
			$where_join = $table.".email = '".trim($value)."'"; 		
		}
		
		//如果是编辑
		if ($id!=0) {
			//$where+=array($table.'.consultant_id != '=>$id);			
			$where_join.=" AND crm_".$table.".consultant_id != ".$id;	
		}
		$where_join.=" AND crm_consultant.show_status = 1";

		//$num= $this->main_data_model->count($where,$table);
		
		//查询记录
		$join = array('*','consultant','consultant.consultant_id = '.$table.'.consultant_id','left');
		$res['con_info'] = $list = $this->main_data_model->select('*',$where_join,0,0,0,$join,$table);

		if(isset($list[0]['employee_id'])){
			//咨询师名字
			$where=array('employee_id'=>$list[0]['employee_id']);
			$teach= $this->main_data_model->getOne($where,'admin_name','employee');

			$res['teach']=isset($teach['admin_name'])?$teach['admin_name']:'';
		
		}

		//if ($num>0) {
		if ($list) {
			$res['status'] = 1;
			echo json_encode($res);
		}else{
			//此咨询者不在表中
			$res['status'] = 2;
			echo json_encode($res);
		}
		die;
	}

	/**
	 * 咨询者渠道、咨询者咨询形式数据的获取
	 */
	private function _pubilcData()
	{

		#咨询者渠道
		$where=array('consultant_channel_status'=>1);
		$consultant_channel=$this->main_data_model->getOtherAll('consultant_channel_id,consultant_channel_name',$where,'consultant_channel');
		
		#咨询者咨询形式
		$where=array('consultant_consultate_status'=>1);
		$consultant_consultate=$this->main_data_model->getOtherAll('consultant_consultate_id,consultant_consultate_name',$where,'counselor_consultate_modus');

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
	 * 获取侧边栏咨询形式、
	 */
	public function menuConsultate()
	{
		$this->load->model('counselor_consultate_modus_model','counselor_consultate_modus');
		
		return $this->counselor_consultate_modus->getAll();
	}
	/**
	 * 咨询渠道的信息
	 */
	public function menuChannel()
	{
		$this->load->model('consultant_channel_model','consultant_channel');

		return  $this->consultant_channel->getAll();
	}
	
	/**
	 * 更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
	 */
	private function _update_payment_info($tuition_total,$repayment_id,$student_id='',$consultant_id='',$position_total='')
	{
		#更新账单表的 已缴学费 already_payment
		$refund_where = array('repayment_id'=>$repayment_id,'payment_status'=>1,'payment_type !='=>1);
		$update_where = array('repayment_id'=>$repayment_id);
		if($student_id){
			$refund_where['student_id'] = $student_id;
			$update_where = $update_where + array('student_id'=>$student_id);
		}
		if($consultant_id){
			$refund_where['consultant_id'] = $consultant_id;
			$update_where = $update_where + array('consultant_id'=>$consultant_id);
		}

		$refund_info = $this->main_data_model->getOtherAll('*',$refund_where,'refund_loan_time');

		$count_money = 0;
		foreach($refund_info as $item){
			$count_money += $item['payment_money'];
		}

		#更新账单表的完成状态 payment_status
		if( $tuition_total > $count_money ){ #未缴清
			$update_data = array('already_payment'=>$count_money,'payment_status'=>0);
		}else if( $tuition_total == $count_money ){ #已缴清
			$update_data = array('already_payment'=>$count_money,'payment_status'=>1);
		}else if( $tuition_total < $count_money ){ #超额
			$update_data = array('already_payment'=>$count_money,'payment_status'=>2);
		}

		if($position_total){
			$update_data['position_total'] = $position_total;
		}

		$this->main_data_model->update($update_where,$update_data,'student_repayment_bills');
	}

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

	public function check_info($data,$type,$id)
	{

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
	 *	咨询者意向课程
	 */
	public function intentionKnowleage()
	{
		$consultant_id = $this->input->post('consultant_id');

		$this->load->model('p_classroom_type_model','classroom_type');

		$type_info = $this->classroom_type->selectClassType();

		$this->load->model('consultant_model');
		$where = array('consultant_id'=>$consultant_id);
		$data = $this->consultant_model->getConsultantInfo('constu_intention_course,intention_course_remark',$where);
		$intention_course_arr = explode(',',$data['constu_intention_course']);

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
						$str .= '<li class="second"><input type="checkbox" class="ace" name="type_knownledge[]" value="'.$v['knowledge_id'].'" /><span class="lbl" data-event="click"> '.$v['knowledge_name'].' </span></li>';
					}
				}
				$str .= '<div class="clear"></div>';
				$str .= '</ul>'; 
				$str .= '</li>'; 
			}			
		}
		$str .= '</ul>'; 

		$str .= '<br />备注：<textarea name="intentionCourseRemark" id="" cols="50" rows="10">'.$data['intention_course_remark'].'</textarea>';
		
		echo json_encode(array('str'=>$str));
	}

	/**
	 * 处理意向课程
	 */
	public function actionIntentionCourse()
	{
		$consultant_id = $this->input->post('consultant_id');
		$course_type = $this->input->post('course_type');
		$type_knownledge = $this->input->post('type_knownledge');
		$intentionCourseRemark = $this->input->post('intentionCourseRemark');

		$this->load->model('consultant_model');

		$where = array('consultant_id'=>$consultant_id);
		if(!empty($type_knownledge)){
			$type_knownledge_arr = implode(',', $type_knownledge);
			$data = array('constu_intention_course'=>$type_knownledge_arr,'intention_course_remark'=>$intentionCourseRemark);
			$this->consultant_model->editIntentionCourse($where,$data);
		}

		show_message('操作成功！');
		
	}

	/**
	 * 获取咨询者信息
	 */
	public function consultantInfo(){

		$where_id = array('consultant_id'=>$_POST['con_id']);
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

		echo json_encode(array('info'=>$consultantinfo));
		exit;
	}
}