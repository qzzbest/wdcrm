<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生已报课程
 */
class Advisory_student_course_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
		$this->main_data_model->setTable('student_repayment_bills');
		$this->load->model('stu_curriculum_model','stu_curriculum');
		$this->load->model('stu_knowleage_model','stu_knowleage');
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

	public function index()
	{
		$student_id = $this->uri->segment(5);
		#导航条处理
		$this->menuProcess($student_id);
		
		//检查学生所属者
		$this->_checkPower($student_id);

		$page = $this->uri->segment(6, 1);
		$limit=10;
		$start=($page-1)*$limit;
		$where_must = array('is_fail'=>1);//正常的缴费记录（排除失效的记录）
		$where=array('student_id'=>$student_id)+$where_must;#条件

		$this->load->model('student_knowleage_relation_model','student_knowleage_relation');
		#查询学生所报的知识点
		$all = $this->main_data_model->select('*',$where,0,$start,$limit,0,'crm_student_repayment_bills');

		$list = array();
		foreach ($all as $k=>$v) {
			$knowledge=$this->student_knowleage_relation->select_index($student_id,$v['repayment_id']);
			#分隔课程和知识点进行查询
			//防止出错
			if(!empty($knowledge['k_id'])){
				$knowledge_id = explode(",",$knowledge['k_id']);
				$knowledge['knowledge_name']=$this->student_knowleage_relation->select_knowledge($knowledge_id);
			}
			if(!empty($knowledge['c_id'])){
				$course_id = explode(",",$knowledge['c_id']);
				$knowledge['course_name']=$this->student_knowleage_relation->select_curriculum($course_id);
			}	
			$list[]=$knowledge;
		}

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(2).'/student_course/index/'.$student_id.'/');
		$config['total_rows'] =$this->main_data_model->setTable('student_repayment_bills')->count($where);
		$config['per_page'] = $limit; 
		$config['uri_segment'] = 6;
		$config['num_links'] = 2;
		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();
		#获取用户数据
		$info = $this->main_data_model->setTable('student')->getOne(array('student_id'=>$student_id));
		$data=array(
			'list'=>$list,
			'info'=>$info,
			'page'=>$page
		);
		$this->load->view('student_course_list',$data);
	}

	/**
	 * 导航条处理
	 */
	private function menuProcess($student_id)
	{	
		$url= unserialize(getcookie_crm('url'));


		$url[2]=array('已报课程',site_url(module_folder(2).'/student_course/index/'.$student_id));

		//之前是这么做
		//$_COOKIE['url']=serialize($url);
		//加密处理
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');

		setcookie_crm('url',serialize($url));
	}

	/**
	 *  添加课程、缴费
	 */
	public function add()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];

		$check=array(
				array('tuition_total','应缴学费')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			//显示课程列表
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
			$data['uid'] = $this->uri->segment(5,0);
			$data['name'] = $this->main_data_model->getOne(array('student_id'=>$data['uid']),'student_name','student');
			$this->load->view('student_course_add',$data);
	  	}else{
			
			$course_info = $this->input->post();

			//检查学生所属者
			$this->_checkPower($course_info['student_id']);

			//判断是否已选中课程
			if(empty($course_info['course_name']) || empty($course_info['knowledge_name'])){
				show_message('请选择课程！');
			}

			$info=$this->main_data_model->getOne(array('student_id'=>$course_info['student_id']),'*','student');
			$employee_id=$info['employee_id'];#员工ID

			#插入基本还款账单
			$pay_info = array(
					'student_id'=>$course_info['student_id'],
					'consultant_id'=>$info['consultant_id'],
					'course_remark'=>$course_info['course_remark'], #课程备注
					'payment_type_id'=>$course_info['payment_type_id'],#缴费类型
					'study_expense'=>$course_info['tuition_total'],#应缴学费
					'special_payment_remark'=>$course_info['special_payment_remark'] #特殊情况备注	

				);

			//先就业后付款（包吃住）
			if($course_info['payment_type_id']==3){
				$pay_info['apply_money'] = $course_info['apply_money1'];
				$pay_info['organization_paydate'] = $course_info['organization_paydate1'];
				$pay_info['student_start_paydate'] = strtotime($course_info['student_start_paydate1']);
				$pay_info['apply_desc'] = $course_info['apply_desc1'];
			}

			//先就业后付款（不包吃住）
			if($course_info['payment_type_id']==4){
				$pay_info['apply_money'] = $course_info['apply_money2'];
				$pay_info['organization_paydate'] = $course_info['organization_paydate2'];
				$pay_info['student_start_paydate'] = strtotime($course_info['student_start_paydate2']);
				$pay_info['apply_desc'] = $course_info['apply_desc2'];
			}

			//先就业后付款（工资方案）
			if($course_info['payment_type_id']==5){
				$pay_info['apply_money'] = $course_info['apply_money3'];
				$pay_info['organization_paydate'] = $course_info['organization_paydate3'];
				$pay_info['student_start_paydate'] = strtotime($course_info['student_start_paydate3']);
				$pay_info['apply_desc'] = $course_info['apply_desc3'];
			}

			$repayment_id = $this->main_data_model->insert($pay_info,'student_repayment_bills');

			#新增缴费、定位费记录（学费记录表）
			$refund_info = array(
						'student_id' => $course_info['student_id'],
						'consultant_id'=>$info['consultant_id'],
						'payment_money' => $course_info['already_total'], #已缴学费
						'repayment_id'  => $repayment_id, #账单ID
						'payment_status'=> 1, #缴费状态
						'payment_desc'  => $course_info['payment_desc'], #学费描述
						'payment_type_id' => $course_info['payment_type_id'] #缴费类型
					);

			if(!empty($course_info['course_payment_time'])){
				$refund_info['payment_time'] = strtotime($course_info['course_payment_time']); #缴费日期
				$refund_info['already_paytime'] = strtotime($course_info['course_payment_time']); #完成缴费日期
			}else{
				$refund_info['payment_time'] = time();
				$refund_info['already_paytime'] = time();
			}


			if($course_info['select_type'] == 1){ #定位费（学费记录）
				$refund_info['payment_type'] = 2; #缴费类型（0，缴费/默认；1，生活补贴；2，定位费；3，分期缴费）
				$position_total = $course_info['already_total']; //定位费
			}else{
				$position_total = '';
			}	

			$this->main_data_model->insert($refund_info,'refund_loan_time');

			#分期应缴学费
			if($course_info['payment_type_id']==2){  #分期付款
				if(!empty($course_info['payment_time1'])){
					foreach ($course_info['payment_time1'] as $k => $v) {
						if(!empty($v)){
							$refund_data = array(
								'student_id' => $course_info['student_id'],
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

							$refund_id = $this->main_data_model->insert($refund_data,'refund_loan_time');

							$remind_info = array(     #分期缴费提醒
								'loan_time_id' => $refund_id,
								'consultant_id' => $info['consultant_id'],
								'student_id' => $course_info['student_id'],
								'employee_id' =>$employee_id,#员工ID
								'time_remind_time' => strtotime($course_info['remind_time1'][$k]),#提醒时间
								'repayment_id'=>$repayment_id 
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

							$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$course_info['payment_money1'][$k].'元，请及时提醒该学生完成缴费！';

							$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
						}						
					}			
				}
			}

			#先就业后付款（包吃住=》生活补贴）
			if($course_info['payment_type_id']==3){  #生活补贴
				if(!empty($course_info['payment_time2'])){
					foreach ($course_info['payment_time2'] as $k => $v) {
						if(!empty($v)){
							$refund_data = array(
								'student_id' => $course_info['student_id'],
								'consultant_id'=>$info['consultant_id'],
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

							$refund_id = $this->main_data_model->insert($refund_data,'refund_loan_time');

							$remind_info = array(    #生活补贴时间提醒
								'loan_time_id' => $refund_id,
								'consultant_id' => $info['consultant_id'],
								'student_id' => $course_info['student_id'],
								'employee_id' =>$employee_id,#员工ID
								'time_remind_time' => strtotime($course_info['remind_time2'][$k]),#提醒时间
								'repayment_id'=>$repayment_id,
								'payment_type' => 1 
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

							$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（包吃住），发放生活补贴的时间到了，发放金额是：'.$course_info['payment_money2'][$k].'元，请及时处理！';

							$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
						}
					}			
				}
			}

			#先就业后付款（工资方案=》工资补贴）
			if($course_info['payment_type_id']==5){  #工资补贴
				if(!empty($course_info['payment_time3'])){
					foreach ($course_info['payment_time3'] as $k => $v) {
						if(!empty($v)){
							$refund_data = array(
								'student_id' => $course_info['student_id'],
								'consultant_id'=>$info['consultant_id'],
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

							$refund_id = $this->main_data_model->insert($refund_data,'refund_loan_time');

							$remind_info = array(    #工资补贴时间提醒
								'loan_time_id' => $refund_id,
								'consultant_id' => $info['consultant_id'],
								'student_id' => $course_info['student_id'],
								'employee_id' =>$employee_id,#员工ID
								'time_remind_time' => strtotime($course_info['remind_time3'][$k]),#提醒时间
								'repayment_id'=>$repayment_id,
								'payment_type' => 4 
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

							$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（工资方案），发放工资补贴的时间到了，发放金额是：'.$course_info['payment_money3'][$k].'元，请及时处理！';

							$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
						}
					}			
				}
			}

			if(!empty($course_info['course_payment_time'])){
				//获取最早的报读课程时间
				$this->load->model('student_repayment_bills_model','student_repayment_bills');
				$record_where = array('student_id'=>$course_info['student_id']);
				$min_record_course = $this->student_repayment_bills->course_payment_time($record_where);	

		  		//更新下报名日期(最早报名日期)
		  		if(!empty($min_record_course)){
		  			$sign_up_where=array('student_id'=>$course_info['student_id']);
					$sign_up_data = array('sign_up_date'=>$min_record_course);
					$this->main_data_model->update($sign_up_where,$sign_up_data,'student');
		  		}
				
			}

			#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
			$this->_update_payment_info($course_info['tuition_total'],$repayment_id,$course_info['student_id'],$position_total);

			#更新课程
			$insert_course = array();
			foreach ($course_info['course_name'] as $key => $value) {
				$insert_course[] = array(

						'student_id' => $course_info['student_id'],
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

						'student_id' => $course_info['student_id'],
						'knowledge_id' => $v,
						'curriculum_system_id' => $key,
						'repayment_id' => $repayment_id
					);
				}
				
			}

  			$this->main_data_model->insert_batch($insert_knowledge,'student_knowleage_relation');

			if($repayment_id>0){

	  			show_message($info['student_name'].'成功报读课程！',$location);
	  		}else{
	  			show_message('操作失败！');
	  		}
			
		}
	}
	public function edit()
	{

		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		if(isset($url[2][1])){
			$location=$url[2][1];
		}else{
			$location='';
		}
		

		$check=array(
				array('tuition_total','应缴学费')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){			

			#缴费类型
			$data['payment_type_info'] = array();
			$data['payment_type_info'] = $this->main_data_model->getAll('*','payment_type');

			$data['uid'] = $this->uri->segment(5,0);//学生id

			$data['id'] = $id = $this->uri->segment(6,0);

			$data['name'] = $this->main_data_model->getOne(array('student_id'=>$data['uid']),'student_name','student');

			$join = array(array('*','payment_type','student_repayment_bills.payment_type_id = payment_type.payment_type_id','left'));
			$where = array('repayment_id'=>$id);
			$list = $this->main_data_model->select('*',$where,0,0,'',$join,'student_repayment_bills');

			//获取所有缴费记录
			$this->load->model('student_repayment_bills_model','student_repayment_bills');
			$refund_where = "`student_id` = ".$data['uid']." and  `repayment_id` = $id and `payment_type` not in (0,2)"; //分期、生后补贴
			$data['refund_loan_info'] = $this->student_repayment_bills->query('*',$refund_where);

			//查找最早的缴费记录
			$payment_where = array('student_id'=>$data['uid'])+$where;
			$min_record_info = $this->student_repayment_bills->course_payment_time($payment_where);

			if($min_record_info){
				$min_where = "`already_paytime` = ".$min_record_info." and `student_id` = ".$data['uid']." and  `repayment_id` = $id  and `payment_type` in (0,2)";
				$min_info = $this->student_repayment_bills->query('*',$min_where);
			}else{
				$min_info = array();
			}

			$data['min_info'] = $min_info;

			#查看学生当前报读的课程
			$c_sql = "SELECT * FROM ".$this->db->dbprefix('student_curriculum_relation')." AS stu_c LEFT JOIN ".$this->db->dbprefix('curriculum_system')." AS cur_s ON stu_c.curriculum_system_id = cur_s.curriculum_system_id WHERE stu_c.student_id = ".$data['uid']." AND stu_c.repayment_id = ".$id;
			$curriculum_info = $this->stu_curriculum->getStuCourse($c_sql);

			#查看学生当前报读的知识点
			$k_sql = "select id,repayment_id,curriculum_system_id,group_concat(knowledge_id) AS g_k from crm_student_knowleage_relation WHERE student_id = ".$data['uid']." AND repayment_id = ".$id." group by curriculum_system_id";
			$knowledge_info = $this->stu_knowleage->getStuKnowleage($k_sql);
		
			foreach ($knowledge_info as $key => $value) {
				$knowledge_info[$key]['g_k'] = explode(',',$value['g_k']);
			}

			$data['list'] = $list[0];
			$data['curriculum_info'] = json_encode($curriculum_info);
			$data['knowledge_info'] = json_encode($knowledge_info);

			#显示课程列表
			$where=array('curriculum_system_status'=>1);
			$curriculum_system=$this->main_data_model->getOtherAll('*',$where,'curriculum_system');
			
			#数据合并处理
			$curriculum_system=$this->unionProcess($curriculum_system,$curriculum_info);

			$data['course'] = array();

			#课程体系和知识点
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

			$this->load->view('student_course_edit',$data);
	  	}else{
	  		$update = $this->input->post();

	  		//检查学生所属者
			$this->_checkPower($update['student_id']);

			//判断是否已选中课程
			if(empty($update['course_name']) || empty($update['knowledge_name'])){
				show_message('请选择课程！');
			}

			$id = $this->input->post('repayment_id');

			$info=$this->main_data_model->getOne(array('student_id'=>$update['student_id']),'*','student');
			$employee_id=$info['employee_id'];
			$where=array('repayment_id'=>$id);

			//修改之前先删除。

			//删除缴费记录
			//$refund_delete = array('payment_status'=>0)+$where;
			//$this->main_data_model->delete($refund_delete,1,'refund_loan_time');
			
			/*if($update['payment_type_id'] != $update['old_payment_type_id']){
				$refund_delete = array('payment_status'=>0)+$where;
				$this->main_data_model->delete($refund_delete,1,'refund_loan_time');
			}else{
				$this->main_data_model->delete($where,1,'refund_loan_time');
			}	*/	
			

			//删除学生课程
			$this->main_data_model->delete($where,1,'student_curriculum_relation');

			//删除学生知识点
			$this->main_data_model->delete($where,1,'student_knowleage_relation');

			#执行修改
			$data=array();

			$data['student_id']=$update['student_id'];#学生id
			$data['study_expense']=$update['tuition_total'];#应缴学费
			$data['course_remark']=$update['course_remark'];#课程备注
			$data['special_payment_remark']=$update['special_payment_remark'];#特殊情况备注
			$data['payment_type_id']=$update['payment_type_id'];#缴费类型


			#先就业后付款（包吃住）
			if($update['payment_type_id']==3){
				$data['apply_money'] = $update['apply_money1'];
				$data['organization_paydate'] = $update['organization_paydate1'];
				$data['student_start_paydate'] = strtotime($update['student_start_paydate1']);
				$data['apply_desc'] = $update['apply_desc1'];
			}

			#先就业后付款（不包吃住）
			if($update['payment_type_id']==4){
				$data['apply_money'] = $update['apply_money2'];
				$data['organization_paydate'] = $update['organization_paydate2'];
				$data['student_start_paydate'] = strtotime($update['student_start_paydate2']);
				$data['apply_desc'] = $update['apply_desc2'];
			}

			#先就业后付款（包吃住）
			if($update['payment_type_id']==5){
				$data['apply_money'] = $update['apply_money3'];
				$data['organization_paydate'] = $update['organization_paydate3'];
				$data['student_start_paydate'] = strtotime($update['student_start_paydate3']);
				$data['apply_desc'] = $update['apply_desc3'];
			}

			#修改缴费记录
	  		$this->main_data_model->update($where,$data,'student_repayment_bills');

	  		//修改、更新第一次缴费记录
  			$pay_refund = array(
						'student_id'=>$update['student_id'],
						'consultant_id'=>$info['consultant_id'],
						'payment_money' => $update['already_total'], #已缴学费
						'repayment_id'  => $id, #账单ID
						'payment_status'=> 1, #缴费状态
						'payment_desc'  => $update['payment_desc'],  #学费描述
						'payment_type_id' => $update['payment_type_id'] #缴费类型
					);
			if(!empty($update['course_payment_time'])){
				$pay_refund['payment_time'] = strtotime($update['course_payment_time']); #缴费日期
				$pay_refund['already_paytime'] = strtotime($update['course_payment_time']); #完成缴费日期
			}else{
				$pay_refund['payment_time'] = time();
				$pay_refund['already_paytime'] = time();		
			}

			if($update['select_type'] == 1){ #定位费（学费记录）
				$pay_refund['payment_type'] = 2; #缴费类型（0，缴费/默认；1，生活补贴；2，定位费；3，分期缴费）
				$position_total = $update['already_total']; //定位费
			}else{
				$pay_refund['payment_type'] = 0;
				$position_total = '';
			}

	  		if(!empty($update['old_id'])){

	  			//更新
	  			$where = array('id'=>$update['old_id']);
	  			$this->main_data_model->update($where,$pay_refund,'refund_loan_time');

	  		}else{

	  			//添加
				$this->main_data_model->insert($pay_refund,'refund_loan_time');

	  		}

	  		#修改缴费记录（旧）
	  		if($update['payment_type_id']==2){  #分期付款
				if(!empty($update['update_payment_time1'])){
					foreach ($update['update_payment_time1'] as $k => $v) {
						$where_refund = array('id'=>$k);
						$where_remind = array('loan_time_id'=>$k);
						if(!empty($v)){

							#暂时处理
					  		$result = $this->main_data_model->getOne($where_remind,'time_remind_id','time_remind');
					  		if(!empty($result)){

								$refund_info = array(
									'student_id' => $update['student_id'],
									'consultant_id'=>$info['consultant_id'],
									'payment_time' => strtotime($v), #应缴费日期
									'payment_money' => isset($update['update_payment_money1'][$k]) ? $update['update_payment_money1'][$k] : '', #应缴学费
									'remind_time' => isset($update['update_remind_time1'][$k]) ? strtotime($update['update_remind_time1'][$k]) : '', #提醒时间
									'payment_desc' => isset($update['update_payment_desc1'][$k]) ? $update['update_payment_desc1'][$k] : '',  #学费说明
								);

								$re1=$this->main_data_model->update($where_refund,$refund_info,'refund_loan_time');

								#分期付款提醒
								$remind_info = array(
									'time_remind_time' => strtotime($update['update_remind_time1'][$k]),#提醒时间
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

								$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['update_payment_money1'][$k].'元，请及时提醒该学生完成缴费！';

								$re1=$this->main_data_model->update($where_remind,$remind_info,'time_remind');
							}

						}else{
							//如果为空，就删除
							$this->main_data_model->delete($where_refund,1,'refund_loan_time');

						}
					}			
				}
			}

	  		#添加缴费记录（新）
			if($update['payment_type_id']==2){  #分期付款
				if(!empty($update['add_payment_time1'])){
					foreach ($update['add_payment_time1'] as $k => $v) {
						if(!empty($v)){
							$refund_info = array(
								'student_id' => $update['student_id'],
								'consultant_id'=>$info['consultant_id'],
								'payment_time' => strtotime($v), #应缴费日期
								'already_paytime' => 0, #完成缴费日期
								'payment_money' => isset($update['add_payment_money1'][$k]) ? $update['add_payment_money1'][$k] : '', #应缴学费
								'remind_time' => isset($update['add_remind_time1'][$k]) ? strtotime($update['add_remind_time1'][$k]) : '', #提醒时间
								'repayment_id' => $id, #账单ID
								'payment_status' => 0, #缴费状态
								'payment_desc' => isset($update['add_payment_desc1'][$k]) ? $update['add_payment_desc1'][$k] : '',  #学费说明
								'payment_type_id' => $update['payment_type_id'], #缴费类型
								'payment_type' => 3
							);


							$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

							$remind_info = array(  #分期付款提醒
								'loan_time_id' => $refund_id,
								'consultant_id' => $info['consultant_id'],
								'student_id' => $update['student_id'],
								'employee_id' =>$employee_id,#员工ID
								'time_remind_time' => strtotime($update['add_remind_time1'][$k]),#提醒时间
								'repayment_id'=>$id #账单ID
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

							$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['add_payment_money1'][$k].'元，请及时提醒该学生完成缴费！';

							$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
						}
					}			
				}
			}

			#修改先就业后付款（包吃住）（旧）
			if($update['payment_type_id']==3){ #生活补贴
				if(!empty($update['update_payment_time2'])){
					foreach ($update['update_payment_time2'] as $k => $v) {
						$where_refund = array('id'=>$k);
						$where_remind = array('loan_time_id'=>$k);
						if(!empty($v)){

							#暂时处理
					  		$result = $this->main_data_model->getOne($where_remind,'time_remind_id','time_remind');
					  		if(!empty($result)){

								$refund_info = array(
									'student_id' => $update['student_id'],
									'consultant_id'=>$info['consultant_id'],
									'payment_time' => strtotime($v), #放款日期
									'already_paytime' => 0, #完成放款日期
									'payment_money' => isset($update['update_payment_money2'][$k]) ? $update['update_payment_money2'][$k] : '', #放款金额
									'remind_time' => isset($update['update_remind_time2'][$k]) ? strtotime($update['update_remind_time2'][$k]) : '', #提醒时间
									'repayment_id' => $id, #账单ID
									'payment_status' => 0, #缴费状态
									'payment_desc' => isset($update['update_payment_desc2'][$k]) ? $update['update_payment_desc2'][$k] : '',  #放款说明
									'payment_type_id' => $update['payment_type_id'], #缴费类型
									'payment_type' => 1
								);

								$re1=$this->main_data_model->update($where_refund,$refund_info,'refund_loan_time');
	 							
	 							#生活补贴提醒
								$remind_info = array(
									'time_remind_time' => strtotime($update['update_remind_time2'][$k]),#提醒时间
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

								$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['update_payment_money2'][$k].'元，请及时提醒该学生完成缴费！';

								$re1=$this->main_data_model->update($where_remind,$remind_info,'time_remind');
							}

						}else{
							//如果为空，就删除
							$this->main_data_model->delete($where_refund,1,'refund_loan_time');
						}
					}			
				}
			}

			#修改先就业后付款（包吃住）（新）
			if($update['payment_type_id']==3){ #生活补贴
				if(!empty($update['add_payment_time2'])){
					foreach ($update['add_payment_time2'] as $k => $v) {
						if(!empty($v)){
							$refund_info = array(
								'student_id' => $update['student_id'],
								'consultant_id'=>$info['consultant_id'],
								'payment_time' => strtotime($v), #放款日期
								'already_paytime' => 0, #完成放款日期
								'payment_money' => isset($update['add_payment_money2'][$k]) ? $update['add_payment_money2'][$k] : '', #放款金额
								'remind_time' => isset($update['add_remind_time2'][$k]) ? strtotime($update['add_remind_time2'][$k]) : '', #提醒时间
								'repayment_id' => $id, #账单ID
								'payment_status' => 0, #缴费状态
								'payment_desc' => isset($update['add_payment_desc2'][$k]) ? $update['add_payment_desc2'][$k] : '',  #放款说明
								'payment_type_id' => $update['payment_type_id'], #缴费类型
								'payment_type' => 1
							);

							$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

							$remind_info = array(    #生活补贴提醒
								'loan_time_id' => $refund_id,
								'consultant_id' => $info['consultant_id'],
								'student_id' => $update['student_id'],
								'employee_id' =>$employee_id,#员工ID
								'time_remind_time' => strtotime($update['add_remind_time2'][$k]),#提醒时间
								'repayment_id'=>$id, #账单ID
								'payment_type'=>1
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

							$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（包吃住），发放生活补贴的时间到了，发放金额是：'.$update['add_payment_money2'][$k].'元，请及时处理！';

							$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
						}
					}			
				}
			}

			#修改先就业后付款（工资方案）（旧）
			if($update['payment_type_id']==5){ #工资补贴
				if(!empty($update['update_payment_time3'])){
					foreach ($update['update_payment_time3'] as $k => $v) {
						$where_refund = array('id'=>$k);
						$where_remind = array('loan_time_id'=>$k);
						if(!empty($v)){

							#暂时处理
					  		$result = $this->main_data_model->getOne($where_remind,'time_remind_id','time_remind');
					  		if(!empty($result)){

								$refund_info = array(
									'student_id' => $update['student_id'],
									'consultant_id'=>$info['consultant_id'],
									'payment_time' => strtotime($v), #放款日期
									'already_paytime' => 0, #完成放款日期
									'payment_money' => isset($update['update_payment_money3'][$k]) ? $update['update_payment_money3'][$k] : '', #放款金额
									'remind_time' => isset($update['update_remind_time3'][$k]) ? strtotime($update['update_remind_time3'][$k]) : '', #提醒时间
									'repayment_id' => $id, #账单ID
									'payment_status' => 0, #缴费状态
									'payment_desc' => isset($update['update_payment_desc3'][$k]) ? $update['update_payment_desc3'][$k] : '',  #放款说明
									'payment_type_id' => $update['payment_type_id'], #缴费类型
									'payment_type' => 4
								);

								$re1=$this->main_data_model->update($where_refund,$refund_info,'refund_loan_time');
	 							
	 							#生活补贴提醒
								$remind_info = array(
									'time_remind_time' => strtotime($update['update_remind_time3'][$k]),#提醒时间
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

								$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['update_payment_money3'][$k].'元，请及时提醒该学生完成缴费！';

								$re1=$this->main_data_model->update($where_remind,$remind_info,'time_remind');
							}

						}else{
							//如果为空，就删除
							$this->main_data_model->delete($where_refund,1,'refund_loan_time');
						}
					}			
				}
			}

			#修改先就业后付款（工资方案）（新）
			if($update['payment_type_id']==5){ #工资补贴
				if(!empty($update['add_payment_time3'])){
					foreach ($update['add_payment_time3'] as $k => $v) {
						if(!empty($v)){
							$refund_info = array(
								'student_id' => $update['student_id'],
								'consultant_id'=>$info['consultant_id'],
								'payment_time' => strtotime($v), #放款日期
								'already_paytime' => 0, #完成放款日期
								'payment_money' => isset($update['add_payment_money3'][$k]) ? $update['add_payment_money3'][$k] : '', #放款金额
								'remind_time' => isset($update['add_remind_time3'][$k]) ? strtotime($update['add_remind_time3'][$k]) : '', #提醒时间
								'repayment_id' => $id, #账单ID
								'payment_status' => 0, #缴费状态
								'payment_desc' => isset($update['add_payment_desc3'][$k]) ? $update['add_payment_desc3'][$k] : '',  #放款说明
								'payment_type_id' => $update['payment_type_id'], #缴费类型
								'payment_type' => 4
							);

							$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

							$remind_info = array(    #生活补贴提醒
								'loan_time_id' => $refund_id,
								'consultant_id' => $info['consultant_id'],
								'student_id' => $update['student_id'],
								'employee_id' =>$employee_id,#员工ID
								'time_remind_time' => strtotime($update['add_remind_time3'][$k]),#提醒时间
								'repayment_id'=>$id, #账单ID
								'payment_type'=>4
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

							$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（工资方案），发放工资补贴的时间到了，发放金额是：'.$update['add_payment_money3'][$k].'元，请及时处理！';

							$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
						}
					}			
				}
			}

			#更新报名日期
			if(!empty($update['course_payment_time'])){
				//获取最早的报读课程时间
				$this->load->model('student_repayment_bills_model','student_repayment_bills');
				$record_where = array('student_id'=>$update['student_id']);
				$min_record_course = $this->student_repayment_bills->course_payment_time($record_where);	

		  		//更新下报名日期(最早报名日期)
		  		if(!empty($min_record_course)){
		  			$sign_up_where=array('student_id'=>$update['student_id']);
					$sign_up_data = array('sign_up_date'=>$min_record_course);
					$this->main_data_model->update($sign_up_where,$sign_up_data,'student');
		  		}		
			}

			//查询学生信息
	  		$info=$this->main_data_model->getOne(array('student_id'=>$update['student_id']),'*','student');

			#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
			$this->_update_payment_info($update['tuition_total'],$id,$update['student_id'],$position_total);

			#更新课程
			$insert_course = array();
			foreach ($update['course_name'] as $key => $value) {
				$insert_course[] = array(

						'student_id' => $update['student_id'],
						'curriculum_system_id' => $value,
						'repayment_id' => $id
					);
			}
				
			$this->main_data_model->insert_batch($insert_course,'student_curriculum_relation');

  			#更新知识点
  			$insert_knowledge = array();
			foreach ($update['knowledge_name'] as $key => $value) {

				foreach ($value as $k => $v) {
					
					$insert_knowledge[] = array(

						'student_id' => $update['student_id'],
						'knowledge_id' => $v,
						'curriculum_system_id' => $key,
						'repayment_id' => $id
					);
				}
				
			}

  			$this->main_data_model->insert_batch($insert_knowledge,'student_knowleage_relation');

			show_message($info['student_name'].'成功修改课程！',$location);
			
		}
	}
	/**
	 * 查询学生的id,并且做数据验证,删除学生的课程的这个学生是否是所属的咨询师的
	 */
	private function _selectStudentId($id_arr)
	{
		$this->load->model('student_repayment_bills_model');

		$student_id_arr= $this->student_repayment_bills_model->studentIdSelect($id_arr);

		//检查咨询者所属者
		$this->_checkPower($student_id_arr,'in');

	}


	public function delete()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];
		
		#批量删除
		$dele_arr= $this->input->post('id');
		$where = db_create_in($dele_arr,'repayment_id');

		$this->_selectStudentId($dele_arr); //数据检验


		$data = array('is_fail' => 0);
		$this->main_data_model->update($where,$data,'student_repayment_bills');

		//查询学员id和学员对应的咨询者id
		$this->load->model('student_repayment_bills_model');
		$student_info = $this->student_repayment_bills_model->student_number($dele_arr[0]);




		//通过学员id查找该学员是否报了其他课程
		$where_student=array('student_id' => $student_info['student_id'],'is_fail' => 1);
		$res=$this->main_data_model->count($where_student,'student_repayment_bills');

		//如果该学员没有其他课程，删除该学员，更新咨询者等状态
		if($res<=0){
			
			//虚拟删除学员
			$where_student=array('student_id' => $student_info['student_id']);
			$student_status=array('show_status' => 0);
			$this->main_data_model->update($where_student,$student_status,'student');

			//更新咨询者，QQ，电话，邮箱，咨询记录的is_student状态
			$where_consultant=array('consultant_id' => $student_info['consultant_id']);
			$is_student=array('is_student' => 0);

			$this->main_data_model->update($where_consultant,$is_student,'consultant');
			$this->main_data_model->update($where_consultant,$is_student,'consul_stu_phones');
			$this->main_data_model->update($where_consultant,$is_student,'consul_stu_qq');
			$this->main_data_model->update($where_consultant,$is_student,'consul_stu_email');
			$this->main_data_model->update($where_consultant,$is_student,'consultant_record');
		}

		//删除账单表
		//$res1 = $this->main_data_model->delete($where,1,'student_repayment_bills');
		/*//删除缴费记录表
		$res2 = $this->main_data_model->delete($where,1,'refund_loan_time');
		//删除学生课程表
		$res3 = $this->main_data_model->delete($where,1,'student_curriculum_relation');
		//删除学生知识点表
		$res4 = $this->main_data_model->delete($where,1,'student_knowleage_relation');*/
		
		// if($res1>0 && $res2>0 && $res3>0 && $res4>0){
  // 			show_message('删除成功!',$location);	
  // 		}else{
  // 			show_message('操作失败!');
  // 		}

  		show_message('删除成功!',$location);
	}

	public function info()
	{
		header("Content-Type:text/html;charset=utf-8");
		$id= $this->input->post("id");



		#查询所报的课程和知识点
		$this->load->model('student_knowleage_relation_model','student_knowleage_relation');
		$knowledge=$this->student_knowleage_relation->select_one($id);



		//检查咨询者所属者
		$check_result = $this->_checkPower($knowledge['student_id'],'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}


		#处理所报的课程和知识点
		$knowledge_id = explode(",",$knowledge['k_id']);
		$course_id = explode(",",$knowledge['c_id']);
		$knowledge['knowledge_name']=$this->student_knowleage_relation->select_knowledge($knowledge_id);
		$knowledge['course_name']=$this->student_knowleage_relation->select_curriculum($course_id);

		#查询学生姓名
		$student=$this->main_data_model->getOne(array('student_id'=>$knowledge['student_id']),'student_id,student_name','student');

		#查询缴费类型
		$payment_type=$this->main_data_model->getOne(array('payment_type_id'=>$knowledge['payment_type_id']),'payment_type_name','payment_type');
		
		#查询缴费记录表
		if($knowledge['payment_type_id']==2 || $knowledge['payment_type_id'] == 3){
			$where=array('repayment_id'=>$knowledge['repayment_id']);
		}else{
			$where=array('repayment_id'=>$knowledge['repayment_id'],'payment_type'=>0,'payment_status' => 0);
		}
		$payment=$this->main_data_model->getOtherAll('*',$where,'refund_loan_time');

		$str="<h6>学生姓名:".$student['student_name']."</h6>";
		$str.="<span>已报课程</span>";
		$str.="<table border='1' width='100%'>";
		
		if($knowledge['course_name']){
			$course_info='';
			foreach($knowledge['course_name'] as $item){
				$course_info = $course_info." ".$item;
			}
				$str.="<tr>";
				$str.="<td width='85px'>课程</td><td>".$course_info."</td>";
				$str.="</tr>";
		}

		if($knowledge['knowledge_name']){
			$knowledge_info='';
			foreach($knowledge['knowledge_name'] as $item){
				$knowledge_info = $knowledge_info." ".$item;
			}
				$str.="<tr>";
				$str.="<td>知识点</td><td>".$knowledge_info."</td>";
				$str.="</tr>";
			
		}

		if($knowledge['course_remark']){
			$str.="<tr>";
			$str.="<td>课程备注</td><td>".$knowledge['course_remark']."</td>";
			$str.="</tr>";
		}

		if($knowledge['payment_type_id']){
			$str.="<tr>";
			$str.="<td>缴费类型</td><td>".$payment_type['payment_type_name']."</td>";
			$str.="</tr>";
		}

		if($knowledge['study_expense']){
			$str.="<tr>";
			$str.="<td>应缴学费(元)</td><td>".$knowledge['study_expense']."</td>";
			$str.="</tr>";
		}

		if($knowledge['already_payment']){
			$str.="<tr>";
			$str.="<td>已缴学费(元)</td><td>".$knowledge['already_payment']."</td>";
			$str.="</tr>";
		}

		if($knowledge['position_total']){
			$str.="<tr>";
			$str.="<td>定位费(元)</td><td>".$knowledge['position_total']."</td>";
			$str.="</tr>";
		}

		if($knowledge['payment_time']){
			$payment_time = !empty($knowledge['payment_time']) ? date('Y-m-d',$knowledge['payment_time']) : '无';

			$str.="<tr>";
			$str.="<td>缴费日期</td><td>".$payment_time."</td>";
			$str.="</tr>";
		}

		if($knowledge['special_payment_remark']){
			$str.="<tr>";
			$str.="<td>特殊情况备注</td><td>".$knowledge['special_payment_remark']."</td>";
			$str.="</tr>";
		}

		if($knowledge['apply_money']){
			$str.="<tr>";
			$str.="<td>申请额度(元)</td><td>".$knowledge['apply_money']."</td>";
			$str.="</tr>";
		}

		if($knowledge['organization_paydate']){
			$str.="<tr>";
			$str.="<td>机构代还时间段</td><td>".$knowledge['organization_paydate']."</td>";
			$str.="</tr>";
		}

		if($knowledge['student_start_paydate']){
			$student_start_paydate = !empty($knowledge['student_start_paydate']) ? date('Y-m-d',$knowledge['student_start_paydate']) : '无';

			$str.="<tr>";
			$str.="<td>学生开始还款日期</td><td>".$student_start_paydate."</td>";
			$str.="</tr>";
		}

		$str.="</table>";

		$res['data'] = $str;
		$res['info_url'] = site_url(module_folder(2).'/student_payment/index/'.$student['student_id'].'/'.$knowledge['repayment_id']);

		echo json_encode($res);
		exit;
	}
	/**
	 * 数据并集处理
	 */
	public function unionProcess($one,$two)
	{

		foreach ($two as $key => $value) {
			unset($value['id']);
			unset($value['student_id']);
			unset($value['repayment_id']);

			$two[$key]=$value;
		}
		//合并数组
		$result=array_merge($one,$two);
		//去除重复的值
		$result= $this->array_unique_fb($result);
	

		function cmp($a, $b)
		{
		    if ($a['curriculum_system_id'] == $b['curriculum_system_id']) {
		        return 0;
		    }
		    return ($a['curriculum_system_id'] < $b['curriculum_system_id']) ? -1 : 1;
		}



		usort($result, "cmp");

			
		return $result;

	}
	/**
	 * 二维数组去掉重复值
	 */
	public function array_unique_fb($array2D)
	{
		foreach ($array2D as $v){
			$v=serialize($v);//降维
			$temp[]=$v;
		}
		$temp=array_unique($temp);//去掉重复的字符串,也就是重复的一维数组
		foreach ($temp as $k => $v){
			$temp[$k]=unserialize($v);//再将拆开的数组重新组装
		}
		return $temp;
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
	 * 删除分期付款/生活补贴
	 */
	public function deletePayRef()
	{
		header("Content-Type:text/html;charset=utf-8");

		$id = $this->input->post('pid');  //还款表id crm_refund_loan_time 

		//得到学生的id
		$this->load->model('refund_loan_time_model');
 		$student_id= $this->refund_loan_time_model->selectStudentId($id);

 		//检查咨询者所属者
		$check_result = $this->_checkPower($student_id['student_id'],'','ajax');	

		if(!$check_result){ //如果返回的是 0
			echo json_encode(array('status'=>0));
			exit;
		}

		$time_id = $this->input->post('time_id');  //提醒表id

		$where=array('id'=>$id);	
		$res=$this->main_data_model->delete($where,1,'refund_loan_time');

		#暂时处理
		$where_remind=array('loan_time_id'=>$id);
  		$result = $this->main_data_model->getOne($where_remind,'time_remind_id','time_remind');
  		if(!empty($result)){

			#删除提醒表对应的ID
			$res=$this->main_data_model->delete($where_remind,1,'time_remind');

		}

		echo json_encode(array('status'=>1));
		exit;
	}

	/**
	 * 更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
	 */
	public function _update_payment_info($tuition_total,$repayment_id,$student_id,$position_total='')
	{

		#更新账单表的 已缴学费 already_payment
		$refund_where = array('repayment_id'=>$repayment_id,'payment_status'=>1,'payment_type !='=>1,'student_id'=>$student_id);
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

		$update_data['position_total'] = $position_total;

		$update_where = array('repayment_id'=>$repayment_id,'student_id'=>$student_id);
		$this->main_data_model->update($update_where,$update_data,'student_repayment_bills');
	}
}