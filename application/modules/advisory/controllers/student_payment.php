<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学员缴费记录
 */
class Advisory_student_payment_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('student_repayment_bills');
		$this->load->model('stu_curriculum_model','stu_curriculum');
		$this->load->model('stu_knowleage_model','stu_knowleage');
	}

	public function index()
	{
		#查询某个学生的缴费记录
		#当前页码
		$student_id = $this->uri->segment(5);

		//检查学生所属者
		$this->_checkPower($student_id);

		$repayment_id = $this->uri->segment(6);
		#导航栏
		$this->menuProcess($student_id);
		
		$where=array('student_id'=>$student_id);
		#学员
		$student_info= $this->main_data_model->getOne($where,'student_id,student_name','student');

		$page = $this->uri->segment(6, 1);

		$limit=0;#每页显示多少条
		
		$start=($page-1)*$limit;

		$field='*';#查询字段
		//$where_must = array('is_fail'=>1);//正常的缴费记录（排除失效的记录）
		if(!empty($repayment_id)){
			$where=array('student_repayment_bills.student_id'=>$student_id,'repayment_id'=>$repayment_id);#条件
		}else{
			$where=array('student_repayment_bills.student_id'=>$student_id);#条件
		}
		
		$orders=0;#排序
		$join = array('*','payment_type','student_repayment_bills.payment_type_id = payment_type.payment_type_id','left');
		
		$student_repayment_info= $this->main_data_model->select($field,$where,$orders,$start,$limit,$join);
	
		$this->load->model('refund_loan_time_model','loan_time_model');

		$number = array();
		foreach ($student_repayment_info as $key => $value) {

			$student_repayment_info[$key]['course_info'] = $this->getCourseInfo($value['repayment_id'],$value['student_id']);

			$study_expense = $value['study_expense'];
			#统计已缴费用
			$paywhere = "`repayment_id` = ".$value['repayment_id']." AND `payment_status`!=0 AND `payment_type` not in(1,4)"; 
			$count_money = $this->loan_time_model->count_payment($paywhere);  #统计已缴费用
			$pay_money = $study_expense - $count_money; #还需要缴多少费用
			$student_repayment_info[$key]['pay_money'] = $pay_money;
			
			$field='*';#查询字段
			if(!empty($repayment_id)){
				if($value['payment_type_id']==5){
					$where=array('refund_loan_time.student_id'=>$student_id,'refund_loan_time.repayment_id'=>$repayment_id,'refund_loan_time.payment_type !='=>4);#条件
				}else{
					$where=array('refund_loan_time.student_id'=>$student_id,'refund_loan_time.repayment_id'=>$repayment_id,'refund_loan_time.payment_type !='=>1);#条件
				}
			}else{
				if($value['payment_type_id']==5){
					$where=array('refund_loan_time.student_id'=>$student_id,'refund_loan_time.repayment_id'=>$value['repayment_id'],'refund_loan_time.payment_type !='=>4);#条件
				}else{
					$where=array('refund_loan_time.student_id'=>$student_id,'refund_loan_time.repayment_id'=>$value['repayment_id'],'refund_loan_time.payment_type !='=>1);#条件
				}
			}

			//$where = $where + array('refund_loan_time.payment_status !='=>2);#排除已经删除、退费的记录

			$orders='refund_loan_time.payment_type_id asc,refund_loan_time.already_paytime desc';#排序
			$join = array('*','payment_type','refund_loan_time.payment_type_id = payment_type.payment_type_id','left');

			$student_repayment_info[$key]['refund_loan_time'] = $this->main_data_model->select($field,$where,$orders,$start,$limit,$join,'refund_loan_time');

			foreach ($student_repayment_info[$key]['refund_loan_time'] as $k => $v) {
				#序号
				$student_repayment_info[$key]['refund_loan_time'][$k]['serial_number']=$k+1;//每条数据对应当前页的每一个值

				if($v['payment_status'] == 2 && $v['payment_money']>0){
					unset($student_repayment_info[$key]['refund_loan_time'][$k]);
				}
			}	

		}

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(2).'/student_payment/index/'.$student_id);

		$count_where = array('student_id'=>$student_id);
		$config['total_rows'] =$this->main_data_model->count($count_where);
		$config['per_page'] = $limit;

		$config['uri_segment'] = 6;
		$config['num_links'] = 2;
		
		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();

		#赋值
		$data=array(
			'student_info'=>$student_info,
			'list'=>$student_repayment_info,
			'page'=>$page
		);


		#指定模板
		$this->load->view('student_payment_list',$data);

	}

	/**
	 * 导航条处理
	 */
	private function menuProcess($student_id)
	{	
		$url= unserialize(getcookie_crm('url'));


		$url[2]=array('缴费记录列表',site_url(module_folder(2).'/student_payment/index/'.$student_id));

		
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
	 * 编辑学员缴费记录
	 */
	public function edit()
	{

		//接收缴费记录id
		$edit = $this->uri->segment(5, 0);

		if ($edit==0) {
			show_message('无效的参数!');			
		}

		$check=array(
				array('tuition_total','应缴学费')
		);
		
		check_form($check);

		$where=array('repayment_id'=>$edit);

		if ($this->form_validation->run() == FALSE){

			
			$info=	$this->main_data_model->getOne($where);

			$payment_type_id=$info['payment_type_id'];#缴费类型
			
			$refund_loan_time=array();#还款或返款日期
			if ($payment_type_id==2||$payment_type_id==3) {
				$this->load->model('refund_loan_time_model','refund_loan_time');
				$tmp= $this->refund_loan_time->select($edit);
				$refund_loan_time['refund_loan1']  =array_shift($tmp);
				$refund_loan_time['refund_loan']  =$tmp;
			}			
				
			$data=array(
				'info'=>$info,
				'refund_loan_time'=> $refund_loan_time,
				'payment_type_id'=>$info['payment_type_id'],
				'student_id'=>$info['student_id'],
				'payment_type_info'=> $this->main_data_model->getAll('*','payment_type')
			);
			
			$this->load->view('student_payment_edit',$data);
		}else{
			#接收
			$update = $this->input->post();
			
			//检查学生所属者
			$this->_checkPower($update['student_id']);

			#数据校验
			if( $update['payment_type_id'] == '' ){
				show_message('请选择缴费类型！');
				die;
			}
			
			//修改之前先删除。
			//删除提醒
			$this->main_data_model->delete($where,1,'time_remind');
			//删除还款、补贴时间表"
			$this->main_data_model->delete($where,1,'refund_loan_time');

			#执行修改
			$data=array();

			$data['student_id']=$update['student_id'];#学生id
			$data['payment_type_id']=$update['payment_type_id'];#缴费类型
			$data['study_expense']=$update['tuition_total'];#应缴学费
			$data['payment_desc']=$update['payment_desc'];#学费说明
			$data['special_payment_remark']=$update['special_payment_remark'];#特殊情况备注
			$data['payment_time']=time();

			$data['already_payment']=$update['already_total']; #已缴学费

			if ($data['payment_type_id']==1) { #一次性缴费	
				$data['apply_money']=0;#申请额度
				$data['organization_paydate']='';#机构代还时间段
				$data['student_start_paydate']=0;#学生开始还款日期
				
			}
			if($data['payment_type_id']==2){ #分期付款
				$data['apply_money']=0;#申请额度
				$data['organization_paydate']='';#机构代还时间段
				$data['student_start_paydate']=0;#学生开始还款日期
			}
			if($data['payment_type_id']==3){ #先就业后付款
				$data['apply_money']=$update['apply_money1'];#申请额度
				$data['organization_paydate']=$update['organization_paydate1'];#机构代还时间段 
				$data['student_start_paydate']=strtotime($update['student_start_paydate1']);#学生开始还款日期  

			}
			if($data['payment_type_id']==4){ #先就业后付款(不包吃住)
				$data['apply_money']=$update['apply_money2'];#申请额度
				$data['organization_paydate']=$update['organization_paydate2'];#机构代还时间段 
				$data['student_start_paydate']=strtotime($update['student_start_paydate2']);#学生开始还款日期
			}

			#修改缴费记录
	  		$res= $this->main_data_model->update($where,$data,'student_repayment_bills');

	  		$info=$this->main_data_model->getOtherAll('student_name,employee_id',array('student_id'=>$data['student_id']),'student');


	  		//分期还款、先就业后付款（包吃住）
	  		if($update['payment_type_id']==2 || $update['payment_type_id']==3){    
				
				if(!empty($update['payment_time'])){
					//添加还款、补贴时间表
					$refund_info = array();
					foreach ($update['payment_time'] as $k => $v) {
						if($v != ''){
							$refund_info[] = array(
								'payment_time' => strtotime($v),
								'payment_money' => $update['payment_money'][$k],
								'remind_time' => strtotime($update['remind_time'][$k]),
								'repayment_id' => $payment_id 
							);
						}
					}

					$this->main_data_model->insert_batch($refund_info,'refund_loan_time');
				}
					
				if(!empty($update['remind_time'])){
					//添加时间提醒
					$remind_info=array();

					foreach($update['remind_time'] as $k=>$v){
						if($v != ''){
							$remind_info[$k] = array(
								'student_id'       => $update['student_id'],
								'employee_id'      => $info['employee_id'],#员工ID
								'time_remind_time' => strtotime($update['remind_time'][$k]),
								'repayment_id'     => $payment_id 
							);
							#查询学员的姓名,手机,QQ加入到提醒内容
							$where_id = array('student_id'=>$info['student_id']);
							$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
							$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
							//分割数组
							$phone=$this->_dataProcess($phone_infos,'phone_number');
							$phone=implode(',', $phone);
							$qq=$this->_dataProcess($qq_infos,'qq_number');
							$qq=implode(',', $qq);

							if($update['payment_type_id']==2){
								$remind_info[$k]['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['payment_money'][$k].'元，请及时提醒该学生完成缴费！';
								$remind_info[$k]['consultant_info'] = "学员姓名: ".$info['student_name']."<br />手机号码: ".$phone."<br />QQ号码: ".$qq;
							}else if($update['payment_type_id']==3){
								$remind_info[$k]['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（包吃住），发放生活补贴的时间到了，发放金额是：'.$update['payment_money'][$k].'元，请及时处理！';
								$remind_info[$k]['consultant_info'] = "学员姓名: ".$info['student_name']."<br />手机号码: ".$phone."<br />QQ号码: ".$qq;
							}
						}

					}

					$this->main_data_model->insert_batch($remind_info,'time_remind');
				}			
				
			}

			if ($res>0) {
				show_message('编辑成功',site_url(module_folder(2).'/student_payment/index/'.$update['student_id']));
			}else{
				show_message('编辑失败');
			}


		}

	}


	/**
	 * 删除缴费记录（删除）
	 */
	public function delete()
	{
		$payment_id= $this->input->post("payment_id");
		$paytime= $this->input->post("paytime");

		//得到学生的id
		$this->load->model('refund_loan_time_model');
 		$student_id= $this->refund_loan_time_model->selectStudentId($payment_id);

 		//检查咨询者所属者
		$check_result = $this->_checkPower($student_id['student_id'],'','ajax');	

		if(!$check_result){ //如果返回的是 0
			echo json_encode(array('data'=>0));
			exit;
		}

		$this->load->model('student_repayment_bills_model');

		$where = array('id'=>$payment_id);
		#查询账单记录
		$info = $this->main_data_model->getOne($where,'*','refund_loan_time');

		if($info['payment_type']==3 && $info['payment_status']==0){ #分期付款(未完成)
			$this->main_data_model->delete($where,1,'refund_loan_time');
		}else{
			$payment_info = $this->student_repayment_bills_model->getOne($info['repayment_id']);

			#删除缴费记录（虚拟删除，要保留该记录，更新删除时间）
			$data = array('payment_status'=>2);
			$this->main_data_model->update($where,$data,'refund_loan_time');

			#创建新的缴费记录（退费记录），用来做统计的
			$add_data = array(
					'student_id'=>$info['student_id'],
					'consultant_id'=>$info['consultant_id'],
					'payment_time'=>$info['payment_time'],
					'payment_money'=>-$info['payment_money'],
					'already_paytime'=>strtotime($paytime),
					'repayment_id'=>$info['repayment_id'],
					'payment_type_id'=>$info['payment_type_id'],
					'payment_status'=>2,
					'payment_desc'=>$info['payment_desc'],
					'special_payment_remark'=>$info['special_payment_remark'],
					'payment_type'=>$info['payment_type'],
				);

			$this->main_data_model->insert($add_data,'refund_loan_time');

			#删除缴费提醒(不要做统计，只是做记录，所以可以确定删除)
			$remind_where = array('loan_time_id' => $payment_id);
			$this->main_data_model->delete($remind_where,1,'time_remind');

			if($info['payment_type'] == 2){
				#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status 和 定位费
				$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$info['student_id'],'no');
			}else{
				$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$info['student_id']);
			}
		}
		
		//通过学员id查找该学员是否报了其他课程
		$where_student=array('student_id' => $student_id['student_id'],'payment_status !=' => 2,'repayment_id'=>$info['repayment_id']);
		$res=$this->main_data_model->count($where_student,'refund_loan_time');

		//统计是否还有未删除的学费，如果没有就更新账单状态
		if($res<=0){
			$data = array('is_fail'=>0);
			$where = array('repayment_id'=>$info['repayment_id']);
			$this->main_data_model->update($where,$data,'student_repayment_bills');
		}
		echo json_encode(array('data'=>1));
		exit;
	}

	/**
	 * 删除缴费记录（真正删除缴费记录）
	 */
	public function delete_pay()
	{
		$pay_id= $this->input->post("pay_id");

		//得到学生的id
		$this->load->model('refund_loan_time_model');
 		$student_id= $this->refund_loan_time_model->selectStudentId($pay_id);

 		//检查咨询者所属者
		$check_result = $this->_checkPower($student_id['student_id'],'','ajax');	

		if(!$check_result){ //如果返回的是 0
			echo json_encode(array('data'=>0));
			exit;
		}

		$where = array('id'=>$pay_id);
		#查询账单记录
		$info = $this->main_data_model->getOne($where,'*','refund_loan_time');

		$this->load->model('student_repayment_bills_model');
		$payment_info = $this->student_repayment_bills_model->getOne($info['repayment_id']);

		#删除缴费记录		
		$this->main_data_model->delete($where,1,'refund_loan_time');

		#更新账单表的 已缴费用 already_payment 和 完成状态 payment_status 和 定位费
		if($info['payment_type'] == 2){
			$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$info['student_id'],'no');
		}else{
			$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$info['student_id']);
		}

		echo json_encode(array('data'=>1));
		exit;
	}

	/**
	 * 删除缴费记录（退费）
	 */
	public function delete_paycord(){
		$payment_id= $this->input->post("payment_id");
		$paytime= $this->input->post("paytime");
		$delete_paymoney = $this->input->post("delete_paymoney");

		//得到学生的id
		$this->load->model('refund_loan_time_model');
 		$student_id= $this->refund_loan_time_model->paymentStudentId($payment_id);

 		//检查咨询者所属者
		$check_result = $this->_checkPower($student_id['student_id'],'','ajax');	

		if(!$check_result){ //如果返回的是 0
			echo json_encode(array('data'=>0));
			exit;
		}

		$this->load->model('student_repayment_bills_model');
		$payment_info = $this->student_repayment_bills_model->getOne($payment_id);
		
		#判断：如果是全部退费就让学生退学
		if($payment_info['already_payment'] < trim($delete_paymoney)){
			echo json_encode(array('data'=>0));
			exit;
		}else{
			$add_data = array(
				'student_id'=>$student_id['student_id'],
				'consultant_id'=>$payment_info['consultant_id'],
				'payment_money'=>-trim($delete_paymoney),
				'already_paytime'=>strtotime($paytime),
				'repayment_id'=>$payment_id,
				'payment_type_id'=>$payment_info['payment_type_id'],
				'payment_status'=>2,
				'payment_desc'=>'退费'
			);

			$this->main_data_model->insert($add_data,'refund_loan_time');

			if($payment_info['already_payment'] == trim($delete_paymoney)){
				#如果只退一部分的话就不用让学生退学
				$where = array('repayment_id'=>$payment_id);
				$data = array('is_fail' => 0);
				$this->main_data_model->update($where,$data,'student_repayment_bills');

				#删除缴费提醒(不要做统计，只是做记录，所以可以确定删除)
				// $remind_where = array('loan_time_id' => $payment_id);
				// $this->main_data_model->delete($remind_where,1,'time_remind');

			}

			$this->_update_payment_info($payment_info['study_expense'],$payment_id,$student_id['student_id']);

			echo json_encode(array('data'=>1));
			exit;
		}
		

		#创建新的缴费记录（退费记录），用来做统计的
		//$refund_info = $this->main_data_model->getOtherAll('*',$where,'refund_loan_time');
		// foreach ($refund_info as $key => $value) {	

		// 	if($value['payment_type']==3 && $value['payment_status']==0){ #分期付款（未完成）
		// 		$delete_where = array('id'=>$value['id']);
		// 		$this->main_data_model->delete($delete_where,1,'refund_loan_time');
		// 	}else{
		// 		$refund_data = array('payment_status'=>2);
		// 		$update_where = array('id'=>$value['id']);
		// 		$this->main_data_model->update($update_where,$refund_data,'refund_loan_time');

		// 		if($value['payment_status']!=2){
		// 			$add_data = array(
		// 				'student_id'=>$value['student_id'],
		// 				'consultant_id'=>$value['consultant_id'],
		// 				'payment_time'=>$value['payment_time'],
		// 				'payment_money'=>-$value['payment_money'],
		// 				'already_paytime'=>strtotime($paytime),
		// 				'repayment_id'=>$value['repayment_id'],
		// 				'payment_type_id'=>$value['payment_type_id'],
		// 				'payment_status'=>2,
		// 				'payment_desc'=>$value['payment_desc'],
		// 				'special_payment_remark'=>$value['special_payment_remark'],
		// 				'payment_type'=>$value['payment_type'],
		// 			);

		// 			$this->main_data_model->insert($add_data,'refund_loan_time');
		// 		}	
		// 	}		
		// }

		

		//查询学员id和学员对应的咨询者id
		// $this->load->model('student_repayment_bills_model');
		// $student_info = $this->student_repayment_bills_model->student_number($payment_id);

		//通过学员id查找该学员是否报了其他课程
		// $where_student=array('student_id' => $student_info['student_id'],'is_fail' => 1);
		// $res=$this->main_data_model->count($where_student,'student_repayment_bills');

		//如果该学员没有其他课程，不删除该学员，不更新咨询者等状态
		// if($res<=0){
			
		// 	//虚拟删除学员
		// 	$where_student=array('student_id' => $student_info['student_id']);
		// 	$student_status=array('show_status' => 0);
		// 	$this->main_data_model->update($where_student,$student_status,'student');

		// 	//更新咨询者，QQ，电话，邮箱，咨询记录的is_student状态
		// 	$where_consultant=array('consultant_id' => $student_info['consultant_id']);
		// 	$is_student=array('is_student' => 0);

		// 	$this->main_data_model->update($where_consultant,$is_student,'consultant');
		// 	$this->main_data_model->update($where_consultant,$is_student,'consul_stu_phones');
		// 	$this->main_data_model->update($where_consultant,$is_student,'consul_stu_qq');
		// 	$this->main_data_model->update($where_consultant,$is_student,'consul_stu_email');
		// 	$this->main_data_model->update($where_consultant,$is_student,'consultant_record');
		// }		
		
	}

	/**
	 * 缴费记录信息 （这个方法现在没有用到了，2014-06-06）
	 */
	public function info()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$repayment_id= $this->input->post("repayment_id");

		$where=array('repayment_id'=>$repayment_id);

		//生活补贴
		$life_help_info = $this->main_data_model->getOtherAll('*',$where,'refund_loan_time');

		//组装成表格
		$str  = '<table border="1" width="100%" class="life_info">';
		$str .= '<tr>';
		$str .= '<th>补贴时间</th>';
		$str .= '<th>生活费(元)</th>';
		$str .= '<th>提醒时间</th>';
		$str .= '</tr>';

		if( !empty($life_help_info) ){

			foreach($life_help_info as $item){

				$tmp=$item['remind_time']==0?'&nbsp;':date('Y-m-d',$item['remind_time']);
				
				$str .= '<tr align="center">';	
				$str .= '<td>'.date('Y-m-d',$item['payment_time']).'</td>';
				$str .= '<td>'.$item['payment_money'].'</td>';
				if(!empty($item['remind_time'])){
					$str .= '<td>'.date('Y-m-d',$item['remind_time']).'</td>';
				}else{
					$str .= '<td>无</td>';
				}
				
				$str .= "</tr>";		
			}

		}

	
		$str.="</table>";
	
		echo json_encode(array('data'=>$str));
		exit;
	}

	/**
	 * 处理缴费状态(修改、更新记录)
	 */
	public function actionPayment()
	{
		#缴费记录id
		$payment_id = $this->input->post('payment_id');
		#完成缴费日期
		$payment_time 	= $this->input->post('payment_time');
		#已缴学费
		$payment_money = $this->input->post('payment_money');
		#提醒时间
		$remind_time = $this->input->post('remind_time');
		#学费描述
		$payment_desc = $this->input->post('payment_desc');
		#学费缴费类型
		$payment_type_id = $this->input->post('payment_type_id');
		#类型
		$type = $this->input->post('type');
		$this->load->model('student_repayment_bills_model');

		$where = array('id'=>$payment_id);
		#查询状态
		$refund_info = $this->main_data_model->getOne($where,'payment_status,student_id','refund_loan_time');

		//检查学生所属者
		$this->_checkPower($refund_info['student_id']);

		if($type == 'one'){ #修改学费、定位费、分期付款
			
			if($payment_type_id == 2){  //分期付款(包括提醒)

					#学费缴费类型
					$status = $this->input->post('status');
					$where_remind = array('loan_time_id'=>$payment_id);

					$student_info=$this->main_data_model->getOne(array('student_id'=>$refund_info['student_id']),'student_name','student');

					$data = array(
						'payment_money' => $payment_money,
						'payment_desc' => $payment_desc,
						'payment_type_id' => $payment_type_id
					);

					if(isset($status) && $status != -1){   //已完成
						$data['already_paytime'] = strtotime($payment_time);
						$data['already_payment'] = $payment_money;			
						$data['payment_status'] = $status;

						if($status == 0){
							$remind_info = array('time_remind_status' => 0);
						}else{
							$remind_info = array();
						}					
						
					}else{   //未完成
						if($refund_info['payment_status'] == 1){
							$data['already_paytime'] = strtotime($payment_time);
						}else{
							$data['payment_time'] = strtotime($payment_time);
						}	

						$data['remind_time'] = strtotime($remind_time);

						#修改分期提醒
						$remind_info = array(
							'time_remind_time' => strtotime($remind_time)#提醒时间
						);
					}	

					#查询学生的姓名,手机,QQ加入到提醒内容
					$where_id = array('student_id'=>$refund_info['student_id']);
					$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
					$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
					//分割数组
					$phone=$this->_dataProcess($phone_infos,'phone_number');
					$phone=implode(',', $phone);
					$qq=$this->_dataProcess($qq_infos,'qq_number');
					$qq=implode(',', $qq);

					$remind_info['time_remind_content'] = '学员 '.$student_info['student_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$payment_money.'元，请及时提醒该学生完成缴费！';

					$re1=$this->main_data_model->update($where_remind,$remind_info,'time_remind');	

			}else{
				$data = array(   //修改学费、定位费
					'payment_time' => strtotime($payment_time),
					'already_paytime' => strtotime($payment_time),
					'payment_money' => $payment_money,
					'payment_desc' => $payment_desc,
					'payment_type_id' => $payment_type_id
				);
			}

			$this->main_data_model->update($where,$data,'refund_loan_time');

			#查询账单记录
			$info = $this->main_data_model->getOne($where,'repayment_id,payment_type','refund_loan_time');
			$payment_info = $this->student_repayment_bills_model->getOne($info['repayment_id']);

			if($info['payment_type'] == 2){
				#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status 和 定位费
				$position_total = $payment_money;
			}else{
				$position_total = '';
			}

			//更新账单表
			$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$refund_info['student_id'],$position_total);
			//查询学生id
			$loan_info = $this->main_data_model->getOne(array('id'=>$payment_id),'student_id','refund_loan_time');

			//更新下报名日期(最早报名日期)
			$this->_update_min_sign($loan_info['student_id']);

			echo json_encode(array('data'=>1));
			exit;

		}else if($type == 'two'){  //完成分期缴费操作(注：设置提醒时间：不提醒)
			#修改已缴学费
			$money 	= $this->input->post('money');
			//分期付款的id
			$time_id = $this->input->post('time_id');
			//完成缴费日期
			$paytime = $this->input->post('paytime');		

			$res=$this->student_repayment_bills_model->changeAlreadyPayment($money,$payment_id);

			$refund_data = array(
				'payment_status'=>1,
				'already_payment'=>$money,
				'already_paytime'=>strtotime($paytime),
				'payment_type_id' => $payment_type_id
			);
			$where=array('id'=>$time_id);

			#修改分期付款信息
	  		$res= $this->main_data_model->update($where,$refund_data,'refund_loan_time');

	  		#查询账单记录
			$info = $this->main_data_model->getOne($where,'repayment_id','refund_loan_time');
			$payment_info = $this->student_repayment_bills_model->getOne($info['repayment_id']);

			$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$refund_info['student_id']);

			//查询学生id
			$loan_info = $this->main_data_model->getOne(array('id'=>$payment_id),'student_id','refund_loan_time');

			//更新下报名日期(最早报名日期)
			$this->_update_min_sign($loan_info['student_id']);

	  		#暂时处理
	  		$where_remind = array('loan_time_id'=>$payment_id);
	  		$result = $this->main_data_model->getOne($where_remind,'time_remind_id','time_remind');
	  		
	  		if(!empty($result)){

	  			#修改提醒记录（删除）
		  		$remind_info['time_remind_status'] = -1; #删除
				$re1=$this->main_data_model->update($where_remind,$remind_info,'time_remind');
	
	  		}

	  		echo json_encode(array('data'=>1));
			exit;
		
		}else if($type == 'three'){  //完成生活补贴

			$pay_status = $this->input->post('pay_status');
			$remind_status = $this->input->post('remind_status');
			$update_payment_time = $this->input->post('update_payment_time');
			$update_payment_money = $this->input->post('update_payment_money');
			$update_remind_time = $this->input->post('update_remind_time');
			$payment_desc = $this->input->post('update_payment_desc');

	  		$refund_data = array(
				'payment_time' => strtotime($update_payment_time),
				'payment_money' => $update_payment_money,
				'remind_time' => strtotime($update_remind_time),
				'payment_desc' => $payment_desc,
				'payment_status' => $pay_status

			);
			$where=array('id'=>$payment_id);

			#修改分期付款信息
	  		$res= $this->main_data_model->update($where,$refund_data,'refund_loan_time');

	  		#暂时处理
	  		$remind_where=array('loan_time_id'=>$payment_id);
	  		$result = $this->main_data_model->getOne($remind_where,'time_remind_id','time_remind');
	  		if(!empty($result)){

	  			if(!empty($update_remind_time)){
	  				#修改分期付款信息
		  			$remind_data = array('time_remind_status'=>$remind_status,'time_remind_time'=>strtotime($update_remind_time));
	  			}else{
	  				$remind_data = array('time_remind_status'=>$remind_status);
	  			}
		  		
		  		$res= $this->main_data_model->update($remind_where,$remind_data,'time_remind');
			}

			echo json_encode(array('data'=>1));
			exit;
		
		}	
	}


	/**
	 * ajax(学费缴费情况)：一次性付款、先就业后付款（包吃住）、先就业后付款（不包吃住）
	 */
	public function disposableAjax()
	{
		$payid = $this->input->post('id');
		$student_id = $this->input->post('student_id');

		//检查咨询者所属者
		$check_result = $this->_checkPower($student_id,'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}	


		#查看当前付款的信息
		$paywhere = "`repayment_id` = $payid";
		$disposable_info = $this->main_data_model->getOne($paywhere,'*','student_repayment_bills');
		$payment_type_id = $disposable_info['payment_type_id'];
		$position_payment_desc = $disposable_info['payment_desc'];
		$study_expense = $disposable_info['study_expense'];
		$position_total = $disposable_info['position_total'];
		$position_total = empty($position_total) ? 0 : $position_total;

		#缴费类型
		$where_type = array('payment_type_id'=>$payment_type_id);
		$payment_type_info = $this->main_data_model->getOne($where_type,'payment_type_name','payment_type');
		$payment_type_name = $payment_type_info['payment_type_name'];

		$this->load->model('refund_loan_time_model','loan_time_model');

		#统计包括定位费的已缴学费
		$paywhere = "`repayment_id` = $payid AND `payment_status` = 1 AND `payment_type` != 1"; 
		$payment_money = $this->loan_time_model->count_payment($paywhere);
		$payment_money = $payment_money == 0 ? 0 : $payment_money;

		$count_money = $this->loan_time_model->count_payment($paywhere);  #统计已缴学费

		$pay_money = $study_expense - $count_money; #还需要缴多少学费

		$str = $this->getCourseInfo($payid,$student_id); #显示课程和知识点

		$str .= '<br /><br />';
		
		if($pay_money < 0){
			$str .= '<div>该学生的缴费类型是：'.$payment_type_name.'，应缴学费是：'.$study_expense.' 元，定位费是：'.$position_total.' 元，已缴学费是：'.$payment_money.' 元，您现在的学费超出金额 '.abs($pay_money).' 元</div><br />';
		}else{
			$str .= '<div>该学生的缴费类型是：'.$payment_type_name.'，应缴学费是：'.$study_expense.' 元，定位费是：'.$position_total.' 元，已缴学费是：'.$payment_money.' 元，还需要缴费的金额是：'.$pay_money.' 元</div><br />';
		}
		

	$str .= <<<ABC
				<input type="hidden" name="payment_type_id" value="$payment_type_id" />
				<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success addpay">
							<i class="icon-plus"> 添加学费</i>
				</button>
ABC;

	$str .= <<<ABC
			<table style="margin: 0px auto;" class="none" id="disposable_payment">
				<tr>
					<th class="center">缴费日期</th>
					<th class="center">缴费金额(元)</th>
					<th class="center">学费说明</th>
				</tr>
ABC;

$str .= <<<ABC

				</table>
				<input type="hidden" name="payment_id" value="$payid">
				<input type="hidden" name="student_id" value="$student_id">
				<input type="hidden" name="study_expense" value="$study_expense">
				<div class="col-sm-5 dis_sm" style="float:right; clear: both;"></div>

<script type="text/javascript">
jQuery(function($){

	$('button[data-target="#moneyAdd"]').click(function (){

		$('#disposable_payment').removeClass('none');
	});

	$('#installmentsEdit').submit(function () {

		//日期
		var payment_time= $('#fenqi_payment input[name="payment_time[]"]');
		
		var num=0;
		for(var j=0,l=payment_time.length; j<l; j++){
			
			if(payment_time[j].value==''){

				num ++;
				
			}

		}

		if(num > 0){
			$('#modal-body').find('.col-sm-5').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请填完整缴费日期！</div>');
			return false;
		}
			
	});

});
</script>

ABC;
		echo json_encode(array('data'=>$str,'content'=>'disposable'));
		exit;



	}


	/**
	 * 补贴日期ajax (修补(检查咨询者所属者)到这个方法的时候，在views层找不到调用这个方法的代码。)
	 */
	public function loansAjax($payid,$pay_info)
	{

		//查询该笔还款的信息
		$this->load->model('student_repayment_bills_model');
		$pay_info= $this->student_repayment_bills_model->getOne($payid);

		//缴费类型
		$where_type = array('payment_type_id'=>$pay_info['payment_type_id']);
		$payment_type_info = $this->main_data_model->getOne($where_type,'payment_type_name','payment_type');

		//查看当前付款的信息
		$paywhere = "`repayment_id` = $payid AND `payment_status` = 0";

		$refund_info = $this->main_data_model->getOtherAll('*',$paywhere,'refund_loan_time');

		//2014-6-7 start
		//检查咨询者所属者
		$check_result = $this->_checkPower($refund_info['student_id'],'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}
		//end

		//统计所有的费用总额
		$count_money = $this->main_data_model->query('SUM(`payment_money`) AS c','refund_loan_time',$paywhere);

		$student_id = $pay_info['student_id'];
		$payment_type_id = $pay_info['payment_type_id'];
		$position_total = $pay_info['position_total'];
		$study_expense = $pay_info['study_expense'];

		$pay_money = $pay_info['study_expense'] - $count_money['c'] - $position_total;

		$pay_money = $pay_money == 0 ? 0 : $pay_money;

		if(!empty($pay_info['position_total_date'])){
			$position_total_date = date('Y/m/d',$pay_info['position_total_date']);
		}else{
			$position_total_date = '';
		}

		$str = $this->getCourseInfo($payid,$pay_info['student_id']);

		$str .= '<br /><br />';

		if($pay_money < 0){
			$str .= '<div>该学生的缴费类型是：'.$payment_type_name.'，应缴学费是：'.$study_expense.' 元，定位费是：'.$position_total.' 元，已缴学费是：'.$payment_money.' 元，您现在的学费超出金额 '.abs($pay_money).' 元</div><br /><input type="hidden" value="'.$study_expense.'" name="count_money" />';
		}else{
			$str .= '<div>该学生的缴费类型是：'.$payment_type_info['payment_type_name'].'，应缴学费是：'.$study_expense.' 元，定位费是：'.$position_total.' 元，还需要缴费的金额是：'.$pay_money.' 元</div><input type="hidden" value="'.$study_expense.'" name="count_money" />';
		}
		

		$str .= <<<ABC
				<div class="modal-body" style="padding-bottom: 12px;">
					日期：
					<input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$position_total_date" name="position_total_date" placeholder="缴费日期" />

					定位费：
	      			<input type="text" name="position_total" placeholder="请输入定位费"  id="position_total" type-data="false" value="$position_total" /> 元

				</div>
				<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success addpay">
						<i class="icon-plus">添加缴费</i>
				</button>

				<table style="margin: 0px auto;" class="none" id="fenqi_payment">
				<tr>
					<th class="center">补贴日期</th>
					<th class="center">补贴金额(元)</th>
					<th class="center">提醒时间</th>	
				</tr>
ABC;
		foreach($refund_info as $item){

			$payment_time = date('Y/m/d',$item['payment_time']);;
			$payment_money = $item['payment_money'];
			$remind_time =$item['remind_time']==0 ?'':date('Y/m/d',$item['remind_time']);

		$str .= <<<ABC
				<tr>
					<td><input type="text" class="date-picker col-xs-12" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$payment_time" name="payment_time[]" placeholder="补贴日期" /></td>
					<td><input type="text" class="col-xs-12" value="$payment_money" name="payment_money[]" placeholder="补贴金额" /></td>
					<td><input type="text" class="col-xs-12" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time[]" value="$remind_time" placeholder="提醒时间" /></td>
					<td>
						<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
						<i class="icon-minus smaller-75"></i>
						</button>
					</td>
				</tr>
ABC;


		}	

		$count_refund = count($refund_info);		
				 			

$str .= <<<ABC
		</table>
		<input type="hidden" name="payment_id" value="$payid">
		<input type="hidden" name="student_id" value="$student_id">
		<input type="hidden" name="study_expense" value="$study_expense">
		<input type="hidden" name="payment_type_id" value="$payment_type_id">
		<div class="col-sm-5" style="float:right; clear: both;"></div>

<script type="text/javascript">
jQuery(function($){

	var count_refund = $count_refund;

	if(count_refund>0){
		$('#fenqi_payment').show();
	}else{
		$('button[data-target="#moneyAdd"]').click(function ()
		{
			$('#fenqi_payment').removeClass('none');
		});
	}
});
</script>

ABC;


		echo json_encode(array('data'=>$str,'content'=>'loans'));
		exit;



	}

	/**
	 * 分期付款（学费处理）
	 */
	public function installmentAjax()
	{
		$payid = $this->input->post('id');
		$student_id = $this->input->post('student_id');

		//检查咨询者所属者
		$check_result = $this->_checkPower($student_id,'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}	


		//查询该笔还款的信息
		$this->load->model('student_repayment_bills_model');
		$pay_info= $this->student_repayment_bills_model->getOne($payid);
		$study_expense = $pay_info['study_expense'];
		$position_total = $pay_info['position_total'];
		$position_total = empty($position_total) ? 0 : $position_total;
		$payment_type_id = $pay_info['payment_type_id'];

		//缴费类型
		$where_type = array('payment_type_id'=>$payment_type_id);
		$payment_type_info = $this->main_data_model->getOne($where_type,'payment_type_name','payment_type');
		$payment_type_name = $payment_type_info['payment_type_name'];

		$this->load->model('refund_loan_time_model','loan_time_model');

		#统计除定位费的已缴学费
		$paywhere = "`repayment_id` = $payid AND `payment_status` = 1 AND `payment_type` != 1"; 
		$payment_money = $this->loan_time_model->count_payment($paywhere);
		$payment_money = $payment_money == 0 ? 0 : $payment_money;

		$count_money = $this->loan_time_model->count_payment($paywhere);  #统计已缴学费

		$pay_money = $study_expense - $count_money; #还需要缴多少学费

		$str = $this->getCourseInfo($payid,$student_id); #显示课程和知识点

		$str .= '<br /><br />';
		
		if($pay_money < 0){
			$str .= '<div>该学生的缴费类型是：'.$payment_type_name.'，应缴学费是：'.$study_expense.' 元，定位费是：'.$position_total.' 元，已缴学费是：'.$payment_money.' 元，您现在的学费超出金额 '.abs($pay_money).' 元</div><br />';
		}else{
			$str .= '<div>该学生的缴费类型是：'.$payment_type_name.'，应缴学费是：'.$study_expense.' 元，定位费是：'.$position_total.' 元，已缴学费是：'.$payment_money.' 元，还需要缴费的金额是：'.$pay_money.' 元</div><br />';
		}
		
		#查看是否存在定位费
		$paywhere = "`repayment_id` = $payid AND `payment_status` = 1 AND `payment_type` = 2"; 
		$refund_info_one = $this->main_data_model->getOne($paywhere,'*','refund_loan_time');  #定位费记录

		$paywhere = "`repayment_id` = $payid AND `payment_status` = 1 AND `payment_type` = 0"; 
		$refund_info_two = $this->main_data_model->getOne($paywhere,'*','refund_loan_time');  #学费记录

		$str .= '<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success addpay"><i class="icon-plus"> 添加分期缴费</i></button>';

		$str .= <<<ABC

				<table style="margin: 0px auto;" class="none" id="fenqi_payment">
				<tr>
					<th class="center">应缴费日期</th>
					<th class="center">应缴费金额(元)</th>
					<th class="center">提醒时间</th>
					<th class="center">学费说明</th>
				</tr>
ABC;

$str .= <<<ABC
		</table>
		<input type="hidden" name="payment_id" value="$payid">
		<input type="hidden" name="student_id" value="$student_id">
		<input type="hidden" name="study_expense" value="$study_expense">
		<input type="hidden" name="payment_type_id" value="$payment_type_id">
		<div class="col-sm-5" style="float:right; clear: both;"></div>

<script type="text/javascript">
jQuery(function($){

	$('button[data-target="#moneyAdd"]').click(function ()
	{
		$('#fenqi_payment').removeClass('none');
	});

	var fqmoneyall = 0;

	$('#installmentAjax').submit(function () {

		//日期
		var payment_time= $('#fenqi_payment input[name="payment_time[]"]');
		
		var num=0;
		for(var j=0,l=payment_time.length; j<l; j++){
			
			if(payment_time[j].value==''){

				num ++;
				
			}

		}

		if(num > 0){
			$('#modal-body').find('.col-sm-5').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请填完整还款日期！</div>');
			return false;
		}

		//金额
		var payment_money = $('#fenqi_payment input[name="payment_money[]"]');
		var fqmoneyall=0;
		for(var j=0,l=payment_money.length; j<l; j++){
			var z= payment_money[j].value; //用户输入的金额
			if($.isNumeric(z)){
				fqmoneyall+=parseFloat(z);
			}else{
				$('#modal-body').find('.col-sm-5').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请填写学费！</div>');
				return false;
			}
		}

	});
});
</script>

ABC;
		echo json_encode(array('data'=>$str,'content'=>'installments'));
		exit;

	}	

	/**
	 * 申请缴费情况ajax
	 */
	public function applyAjax()
	{

		$payid = $this->input->post('id');
		$student_id = $this->input->post('student_id');

		//检查咨询者所属者
		$check_result = $this->_checkPower($student_id,'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}	

		//查询该笔还款的信息
		$this->load->model('student_repayment_bills_model');
		$pay_info= $this->student_repayment_bills_model->getOne($payid);

		$apply_money = $pay_info['apply_money'];
		$payment_type_id = $pay_info['payment_type_id'];
		$organization_paydate = $pay_info['organization_paydate'];
		$student_start_paydate = $pay_info['student_start_paydate'] ? date('Y/m/d',$pay_info['student_start_paydate']) : '';
		$apply_desc = $pay_info['apply_desc'];

		//查看当前付款的信息	
		$refund_info = array();
		if($pay_info['payment_type_id'] == 3){
			$paywhere = "`repayment_id` = $payid AND `payment_type` = 1";
			$refund_info = $this->main_data_model->getOtherAll('*',$paywhere,'refund_loan_time');
		}elseif ($pay_info['payment_type_id'] == 5) {
			$paywhere = "`repayment_id` = $payid AND `payment_type` = 4";
			$refund_info = $this->main_data_model->getOtherAll('*',$paywhere,'refund_loan_time');
		}

		$url = site_url(module_folder(2).'/student_payment/actionPayment');

		$str = <<<ABC
				<div class="modal-body" style="padding-bottom: 12px;">
					<table style="margin: 0px auto;">
						<tr>
							<th class="center">申请额度(元)</th>
							<th class="center">机构代还时间段</th>
							<th class="center">开始还款日期</th>
							<th class="center">备注</th>	
						</tr>

						<tr>
							<td><input type="text" class="date-picker col-xs-12" value="$apply_money" name="apply_money" placeholder="申请额度" /></td>
							<td><input type="text" class="col-xs-12" data-date-format="yyyy/mm/dd" value="$organization_paydate" name="organization_paydate" placeholder="机构代还时间段" /></td>
							<td><input type="text" class="col-xs-12" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="student_start_paydate" value="$student_start_paydate" placeholder="开始还款日期" /></td>
							<td><input type="text" class="date-picker col-xs-12" value="$apply_desc" name="apply_desc" placeholder="备注" /></td>
						</tr>

					</table>
				</div>

				
ABC;
if($pay_info['payment_type_id'] == 3){
		$str .= <<<ABC
				<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success addpay">
						<i class="icon-plus">添加生活补贴</i>
				</button>
				<table style="margin: 0px auto;" class="none" id="fenqi_payment">
				<tr>
					<th class="center">补贴日期</th>
					<th class="center">补贴金额(元)</th>
					<th class="center">提醒时间</th>
					<th class="center">补贴说明</th>
					<th class="center">操作</th>	
				</tr>
ABC;


		foreach($refund_info as $item){

			$pay_id = $item['id'];
			$payment_time = date('Y/m/d',$item['payment_time']);;
			$payment_money = $item['payment_money'];
			$remind_time =$item['remind_time']==0 ?'':date('Y/m/d',$item['remind_time']);
			$payment_desc = $item['payment_desc'];

			$id = $item['id'];
			if($item['payment_status'] == 0){
				$status = '<button type="button" data="'.$id.'" class="btn spinner-down btn-xs btn-danger complete_apply white">未完成</button>';
			}else{
				$status = '<button type="button" data="'.$id.'" class="btn spinner-down btn-xs btn-danger cancel_apply white">已完成</button>';
			}

		$str .= <<<ABC
				<tr>
					<td><input type="text" class="date-picker col-xs-12" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$payment_time" name="update_payment_time[$pay_id]" placeholder="补贴日期" /></td>
					<td><input type="text" class="col-xs-12" value="$payment_money" name="update_payment_money[$pay_id]" placeholder="补贴金额" /></td>
					<td><input type="text" class="col-xs-12" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="update_remind_time[$pay_id]" value="$remind_time" placeholder="提醒时间" /></td>
					<td><input type="text" class="col-xs-12" value="$payment_desc" name="update_payment_desc[$pay_id]" placeholder="补贴说明" /></td>
					<td class="change_status">
						$status
					</td>
				</tr>
ABC;


		}	

			
}else if($pay_info['payment_type_id'] == 5){
		$str .= <<<ABC
				<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success addpay">
						<i class="icon-plus">添加工资补贴</i>
				</button>
				<table style="margin: 0px auto;" class="none" id="fenqi_payment">
				<tr>
					<th class="center">补贴日期</th>
					<th class="center">补贴金额(元)</th>
					<th class="center">提醒时间</th>
					<th class="center">补贴说明</th>
					<th class="center">操作</th>	
				</tr>
ABC;


		foreach($refund_info as $item){

			$pay_id = $item['id'];
			$payment_time = date('Y/m/d',$item['payment_time']);;
			$payment_money = $item['payment_money'];
			$remind_time =$item['remind_time']==0 ?'':date('Y/m/d',$item['remind_time']);
			$payment_desc = $item['payment_desc'];

			$id = $item['id'];
			if($item['payment_status'] == 0){
				$status = '<button type="button" data="'.$id.'" class="btn spinner-down btn-xs btn-danger complete_apply white">未完成</button>';
			}else{
				$status = '<button type="button" data="'.$id.'" class="btn spinner-down btn-xs btn-danger cancel_apply white">已完成</button>';
			}

		$str .= <<<ABC
				<tr>
					<td><input type="text" class="date-picker col-xs-12" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$payment_time" name="update_payment_time[$pay_id]" placeholder="补贴日期" /></td>
					<td><input type="text" class="col-xs-12" value="$payment_money" name="update_payment_money[$pay_id]" placeholder="补贴金额" /></td>
					<td><input type="text" class="col-xs-12" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="update_remind_time[$pay_id]" value="$remind_time" placeholder="提醒时间" /></td>
					<td><input type="text" class="col-xs-12" value="$payment_desc" name="update_payment_desc[$pay_id]" placeholder="补贴说明" /></td>
					<td class="change_status">
						$status
					</td>
				</tr>
ABC;


		}
			
}	

$count_refund = count($refund_info);
$str .= <<<ABC
		</table>
		<input type="hidden" name="payment_id" value="$payid">
		<input type="hidden" name="student_id" value="$student_id">
		<input type="hidden" name="payment_type_id" value="$payment_type_id" />
		<div class="col-sm-5" style="float:right; clear: both;"></div>

<script type="text/javascript">
jQuery(function($){

	var count_refund = $count_refund;

	if(count_refund>0){
		$('#fenqi_payment').show();
	}else{
		$('button[data-target="#moneyAdd"]').click(function ()
		{
			$('#fenqi_payment').removeClass('none');
		});
	}

	//未完成
	$('.change_status').on('click','.complete_apply',function ()
	{
		var id = $(this).attr('data');
		var update_payment_time = $('input[name="update_payment_time['+id+']"]').val();
		var update_payment_money = $('input[name="update_payment_money['+id+']"]').val();
		var update_remind_time = $('input[name="update_remind_time['+id+']"]').val();
		var update_payment_desc = $('input[name="update_payment_desc['+id+']"]').val();
		var _this = $(this);

		$.ajax({
	        type: "POST",
	        url: "$url",
	        data: "payment_id="+id+"&update_payment_time="+update_payment_time+"&update_payment_money="+update_payment_money+"&update_remind_time="+update_remind_time+"&update_payment_desc="+update_payment_desc+"&type=three&pay_status=1&remind_status=-1",
	        dataType:'json',
	        success: function(res){
	        	if(res.data == 1){
	       			//location.reload();
	       			$(_this).parent().html('<button type="button" data="'+id+'" class="btn spinner-down btn-xs btn-danger cancel_apply white">已完成</button>');
	       		}else if(res.data == 'no'){ //暂时处理
	       			alert('该记录有问题，暂时不能处理！');
	       		}
	        }
   		});

	});
	
	//已完成
	$('.change_status').on('click','.cancel_apply',function ()
	{
		var id = $(this).attr('data');
		var update_payment_time = $('input[name="update_payment_time['+id+']"]').val();
		var update_payment_money = $('input[name="update_payment_money['+id+']"]').val();
		var update_remind_time = $('input[name="update_remind_time['+id+']"]').val();
		var update_payment_desc = $('input[name="update_payment_desc['+id+']"]').val();
		var _this = $(this);

		$.ajax({
	        type: "POST",
	        url: "$url",
	        data: "payment_id="+id+"&update_payment_time="+update_payment_time+"&update_payment_money="+update_payment_money+"&update_remind_time="+update_remind_time+"&update_payment_desc="+update_payment_desc+"&type=three&pay_status=0&remind_status=0",
	        dataType:'json',
	        success: function(res){
	        	if(res.data == 1){
	       			//location.reload();
	       			$(_this).parent().html('<button type="button" data="'+id+'" class="btn spinner-down btn-xs btn-danger complete_apply white">未完成</button>');
	       		}else if(res.data == 'no'){ //暂时处理
	       			alert('该记录有问题，暂时不能处理！');
	       		}
	        }
   		});

	});

});

jQuery(function($){

	function start_end_time(obj){

		$('input[name='+obj+']').daterangepicker(
			{
				format: 'YYYY/MM/DD',
				locale: {
                    applyLabel: '确定',
                    cancelLabel: '取消',
                    fromLabel: '开始',
                    toLabel: '结束',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['周日', '周一', '周二', '周三', '周四', '周五','周六'],
                    monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                    firstDay: 1
                }
				
			});

		$('input[name='+obj+']').focus(function(){

				$('.daterangepicker').css('z-index',1060);

		});

	}
	start_end_time('organization_paydate');
});
</script>

ABC;


		echo json_encode(array('data'=>$str,'content'=>'loans'));
		exit;



	}

	/**
	 * 获取报读课程信息
	 */
	private function getCourseInfo($payid,$student_id)
	{
		//查看课程
		$c_sql = "SELECT * FROM ".$this->db->dbprefix('student_curriculum_relation')." AS stu_c LEFT JOIN ".$this->db->dbprefix('curriculum_system')." AS cur_s ON stu_c.curriculum_system_id = cur_s.curriculum_system_id WHERE stu_c.student_id = $student_id AND stu_c.repayment_id = ".$payid;
		$curriculum_info = $this->stu_curriculum->getStuCourse($c_sql);

		//查看知识点
		$k_sql = "SELECT * FROM ".$this->db->dbprefix('student_knowleage_relation')." AS stu_k LEFT JOIN ".$this->db->dbprefix('knowledge')." AS know ON stu_k.knowledge_id = know.knowledge_id WHERE stu_k.student_id = $student_id AND stu_k.repayment_id = ".$payid;
		$knowleage_info = $this->stu_knowleage->getStuKnowleage($k_sql);


		$str = '报读课程：';
		foreach ($curriculum_info as $k => $v) {
			$str .= $v['curriculum_system_name'].'&nbsp;&nbsp;&nbsp;';
		}

		$str .= '<br />';

		$str .= '知识点：';
		foreach ($knowleage_info as $kk => $vv) {
			$str .= $vv['knowledge_name'].'&nbsp;&nbsp;&nbsp;';
		}

		return $str;
	}

	/**
	 * 添加学费（一次性付款、先就业后付款(包吃住)、先就业后付款(不包吃住)）
	 */
	public function installDisposable()
	{

		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		if(isset($url[2][1])){
			$location=$url[2][1];
		}else{
			$location='';
		}
		
		
		$payment_id = $this->input->post('payment_id');
		$study_expense = $this->input->post('study_expense');
		$student_id=$this->input->post('student_id');
		$payment_type_id = $this->input->post('payment_type_id');

		//检查学生所属者
		$this->_checkPower($student_id);


		$where=array('repayment_id'=>$payment_id);
		#接收
		$update = $this->input->post();

		//得到学生的相关信息
		$this->load->model('student_model','student');
		$info= $this->student->getInfo($student_id);

		if(!empty($update['payment_time'])){
			#学费
			$refund_info = array();
			foreach ($update['payment_time'] as $k => $v) {
				if($v != ''){
					$refund_info[] = array(
						'student_id' => $student_id,
						'consultant_id'=>$info['consultant_id'],
						'payment_type_id' => $payment_type_id,
						'payment_time' => strtotime($v),
						'already_paytime' => strtotime($v),
						'payment_money' => $update['payment_money'][$k],
						'repayment_id' => $payment_id,
						'payment_desc' => $update['payment_desc'][$k],
						'payment_status' => 1,
						'payment_type'   => 0
					);
				}
			}

			$this->main_data_model->insert_batch($refund_info,'refund_loan_time');

		}

		#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
		$this->_update_payment_info($study_expense,$payment_id,$student_id);

		//更新下报名日期(最早报名日期)
		$this->_update_min_sign($student_id);
		
		show_message('更新成功',$location);	
	}
	/**
	 * 添加分期付款
	 */
	public function installmentsEdit()
	{	
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		if(isset($url[2][1])){
			$location=$url[2][1];
		}else{
			$location='';
		}
		
		$payment_id = $this->input->post('payment_id');
		$student_id=$this->input->post('student_id');
		$study_expense = $this->input->post('study_expense');
		$payment_type_id = $this->input->post('payment_type_id');

		//检查学生所属者
		$this->_checkPower($student_id);

		$where=array('repayment_id'=>$payment_id);

		#接收
		$update = $this->input->post();

		//得到学生的相关信息
		$this->load->model('student_model','student');
		$info= $this->student->getInfo($student_id);

		if(!empty($update['payment_time'])){   //添加分期学费		
			foreach ($update['payment_time'] as $k => $v) {
				if($v != ''){
					$refund_info = array(
						'student_id' => $student_id,
						'consultant_id'=>$info['consultant_id'],
						'payment_type_id' => $payment_type_id,
						'payment_time' => strtotime($v),
						'payment_money' => $update['payment_money'][$k],
						'remind_time' => strtotime($update['remind_time'][$k]),
						'repayment_id' => $payment_id,
						'payment_desc' => $update['payment_desc'][$k],
						'payment_type' => 3
					);

					$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

					$remind_info = array(     #分期缴费提醒
						'loan_time_id' => $refund_id,
						'consultant_id' => $info['consultant_id'],
						'student_id' => $update['student_id'],
						'employee_id' => $info['employee_id'],#员工ID
						'time_remind_time' => strtotime($update['remind_time'][$k]),
						'repayment_id'=>$payment_id 
					);
					#查询学员的姓名,手机,QQ加入到提醒内容
					$where_id = array('student_id'=>$student_id);
					$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
					$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
					//分割数组
					$phone=$this->_dataProcess($phone_infos,'phone_number');
					$phone=implode(',', $phone);
					$qq=$this->_dataProcess($qq_infos,'qq_number');
					$qq=implode(',', $qq);

					$remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['payment_money'][$k].'元，请及时提醒该学生完成缴费！';

					$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
				}
			}
		}
		
		#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
		$this->_update_payment_info($study_expense,$payment_id,$student_id);

		//更新下报名日期(最早报名日期)
		$this->_update_min_sign($student_id);
		
		show_message('更新成功',$location);
	}

	/**
	 * 先就业后付款(涉及生活补贴,工资补贴)
	 */
	public function installapplyEdit()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];

		$payment_id = $this->input->post('data_payid');
		$student_id = $this->input->post('student_id');
		$apply_money=$this->input->post('apply_money');
		$organization_paydate = $this->input->post('organization_paydate');
		$student_start_paydate=$this->input->post('student_start_paydate');
		$apply_desc=$this->input->post('apply_desc');

		//检查学生所属者
		$this->_checkPower($student_id);

		$where=array('repayment_id'=>$payment_id);

		$data = array('apply_money'=>$apply_money,'organization_paydate'=>$organization_paydate,'student_start_paydate'=>strtotime($student_start_paydate),'apply_desc'=>$apply_desc);

		//更新下缴费记录
		$this->main_data_model->update($where,$data,'student_repayment_bills');	

		//查询缴费类型ID
		$this->load->model('student_repayment_bills_model','student_repayment_bills');
		$payment_info = $this->student_repayment_bills->getOne($payment_id);

		if($payment_info['payment_type_id'] == 3){

			//删除提醒
			// $where_time=array('time_remind_status'=>0,'payment_type'=>1)+$where;
			// $this->main_data_model->delete($where_time,1,'time_remind');

			//得到学生的相关信息
			$this->load->model('student_model','student');
			$info= $this->student->getInfo($student_id);

			#接收
			$update = $this->input->post();

			#更新生活补贴(旧)
			if(!empty($update['update_payment_time'])){			  //更新还款、补贴时间表	
				foreach ($update['update_payment_time'] as $k => $v) {
					$where_pay = array('id'=>$k);
					$where_remind = array('loan_time_id'=>$k);
					if($v != ''){
						
						#暂时处理
				  		$result = $this->main_data_model->getOne($where_remind,'time_remind_id','time_remind');
				  		if(!empty($result)){

							$update_refund_info = array(
								'student_id' => $student_id,
								'payment_type_id' => $payment_info['payment_type_id'],
								'payment_time' => strtotime($v),
								'payment_money' => $update['update_payment_money'][$k],
								'remind_time' => strtotime($update['update_remind_time'][$k]),
								'payment_desc' => $update['update_payment_desc'][$k],
								'repayment_id' => $payment_id,
								'payment_type' => 1
							);
				
							$re=$this->main_data_model->update($where_pay,$update_refund_info,'refund_loan_time');					

							//更新时间提醒
							if(!empty($update['update_remind_time'][$k])){
								$update_remind_info = array(
									'time_remind_time' => strtotime($update['update_remind_time'][$k]),
								);
								#查询学员的姓名,手机,QQ加入到提醒内容
								$where_id = array('student_id'=>$student_id);
								$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
								$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
								//分割数组
								$phone=$this->_dataProcess($phone_infos,'phone_number');
								$phone=implode(',', $phone);
								$qq=$this->_dataProcess($qq_infos,'qq_number');
								$qq=implode(',', $qq);

								$update_remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（包吃住），发放生活补贴的时间到了，发放金额是：'.$update['update_payment_money'][$k].'元，请及时处理！';
				
								$re=$this->main_data_model->update($where_remind,$update_remind_info,'time_remind');
							}
						}
  
					}else{
						//如果为空，就删除
						$this->main_data_model->delete($where_pay,1,'refund_loan_time');
					}
					
				}
			}


			//添加还款、补贴时间表
			if(!empty($update['add_payment_time'])){  	
				foreach ($update['add_payment_time'] as $k => $v) {
					if($v != ''){
						$add_refund_info = array(
							'student_id' => $student_id,
							'consultant_id' => $info['consultant_id'],
							'payment_type_id' => $payment_info['payment_type_id'],
							'payment_time' => strtotime($v),
							'payment_money' => $update['add_payment_money'][$k],
							'remind_time' => strtotime($update['add_remind_time'][$k]),
							'payment_desc' => $update['add_payment_desc'][$k],
							'repayment_id' => $payment_id,
							'payment_type' => 1
						);

						$refund_id = $this->main_data_model->insert($add_refund_info,'refund_loan_time');

						$add_remind_info = array(
							'loan_time_id' => $refund_id,
							'consultant_id' => $info['consultant_id'],
							'student_id' => $update['student_id'],
							'employee_id' => $info['employee_id'],#员工ID
							'time_remind_time' => strtotime($update['add_remind_time'][$k]),
							'repayment_id'=>$payment_id,
							'payment_type' => 1
						);
						#查询学员的姓名,手机,QQ加入到提醒内容
						$where_id = array('student_id'=>$student_id);
						$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
						$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
						//分割数组
						$phone=$this->_dataProcess($phone_infos,'phone_number');
						$phone=implode(',', $phone);
						$qq=$this->_dataProcess($qq_infos,'qq_number');
						$qq=implode(',', $qq);

						$add_remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（包吃住），发放生活补贴的时间到了，发放金额是：'.$update['add_payment_money'][$k].'元，请及时处理！';

						$remind_id = $this->main_data_model->insert($add_remind_info,'time_remind');
					}					
				}
			}
		}else if($payment_info['payment_type_id'] == 5){

			//得到学生的相关信息
			$this->load->model('student_model','student');
			$info= $this->student->getInfo($student_id);

			#接收
			$update = $this->input->post();

			#更新工资补贴(旧)
			if(!empty($update['update_payment_time'])){			  //更新还款、补贴时间表	
				foreach ($update['update_payment_time'] as $k => $v) {
					$where_pay = array('id'=>$k);
					$where_remind = array('loan_time_id'=>$k);
					if($v != ''){
						
						#暂时处理
				  		$result = $this->main_data_model->getOne($where_remind,'time_remind_id','time_remind');
				  		if(!empty($result)){

							$update_refund_info = array(
								'student_id' => $student_id,
								'payment_type_id' => $payment_info['payment_type_id'],
								'payment_time' => strtotime($v),
								'payment_money' => $update['update_payment_money'][$k],
								'remind_time' => strtotime($update['update_remind_time'][$k]),
								'payment_desc' => $update['update_payment_desc'][$k],
								'repayment_id' => $payment_id,
								'payment_type' => 4
							);
				
							$re=$this->main_data_model->update($where_pay,$update_refund_info,'refund_loan_time');					

							if(!empty($update['update_remind_time'][$k])){
								//更新时间提醒
								$update_remind_info = array(
									'time_remind_time' => strtotime($update['update_remind_time'][$k]),
								);
								#查询学员的姓名,手机,QQ加入到提醒内容
								$where_id = array('student_id'=>$student_id);
								$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
								$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
								//分割数组
								$phone=$this->_dataProcess($phone_infos,'phone_number');
								$phone=implode(',', $phone);
								$qq=$this->_dataProcess($qq_infos,'qq_number');
								$qq=implode(',', $qq);

								$update_remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（工资方案），发放工资补贴的时间到了，发放金额是：'.$update['update_payment_money'][$k].'元，请及时处理！';
				
								$re=$this->main_data_model->update($where_remind,$update_remind_info,'time_remind');
							}
						}
  
					}else{
						//如果为空，就删除
						$this->main_data_model->delete($where_pay,1,'refund_loan_time');
					}
					
				}
			}


			//添加还款、补贴时间表
			if(!empty($update['add_payment_time'])){  	
				foreach ($update['add_payment_time'] as $k => $v) {
					if($v != ''){
						$add_refund_info = array(
							'student_id' => $student_id,
							'consultant_id' => $info['consultant_id'],
							'payment_type_id' => $payment_info['payment_type_id'],
							'payment_time' => strtotime($v),
							'payment_money' => $update['add_payment_money'][$k],
							'remind_time' => strtotime($update['add_remind_time'][$k]),
							'payment_desc' => $update['add_payment_desc'][$k],
							'repayment_id' => $payment_id,
							'payment_type' => 4
						);

						$refund_id = $this->main_data_model->insert($add_refund_info,'refund_loan_time');

						$add_remind_info = array(
							'loan_time_id' => $refund_id,
							'consultant_id' => $info['consultant_id'],
							'student_id' => $update['student_id'],
							'employee_id' => $info['employee_id'],#员工ID
							'time_remind_time' => strtotime($update['add_remind_time'][$k]),
							'repayment_id'=>$payment_id,
							'payment_type' => 4
						);
						#查询学员的姓名,手机,QQ加入到提醒内容
						$where_id = array('student_id'=>$student_id);
						$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
						$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
						//分割数组
						$phone=$this->_dataProcess($phone_infos,'phone_number');
						$phone=implode(',', $phone);
						$qq=$this->_dataProcess($qq_infos,'qq_number');
						$qq=implode(',', $qq);

						$add_remind_info['time_remind_content'] = '学员 '.$info['student_name'].'的学费是属于先就业后付款（工资方案），发放工资补贴的时间到了，发放金额是：'.$update['add_payment_money'][$k].'元，请及时处理！';

						$remind_id = $this->main_data_model->insert($add_remind_info,'time_remind');
					}					
				}
			}
		}
		
		show_message('更新成功',$location);
	}

	/**
	 * 修改分期付款信息
	 */
	public function payinfoAjax()
	{
		$payid = $this->input->post('id');
		$where = array('id'=>$payid);
		$refund_info = $this->main_data_model->getOne($where,'*','refund_loan_time');

		//检查咨询者所属者
		$check_result = $this->_checkPower($refund_info['student_id'],'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}

		$res = array();
		if(!empty($refund_info)){

			if(!empty($refund_info['already_paytime'])){
				$already_paytime = date('Y/m/d',$refund_info['already_paytime']);
			}else{
				$already_paytime = '';
			}

			if(!empty($refund_info['remind_time'])){
				$remind_time = date('Y/m/d',$refund_info['remind_time']);
			}else{
				$remind_time = '';
			}
			$payment_time = date('Y/m/d',$refund_info['payment_time']);
			$payment_money = $refund_info['payment_money'];
			$payment_desc = $refund_info['payment_desc'];
			$payment_type_id = $refund_info['payment_type_id'];
			$payment_status = $refund_info['payment_status'];
			$payment_type = $refund_info['payment_type'];

			$url = site_url(module_folder(2).'/student_payment/actionPayment');

			$select = '';
			if($payment_status == 1){
				$select .= '<option value="1" selected="selected">已完成</option>';
				$select .= '<option value="0">未完成</option>';
			}else{
				$select .= '<option value="1">已完成</option>';
				$select .= '<option value="0" selected="selected">未完成</option>';
			}


//符合的缴费类型
$type_arr_one = array(1,3);	 //生活补贴、分期
$type_arr_two = array(0,2);	 //缴费、定位费		
if($payment_status == 1 && in_array($payment_type, $type_arr_one)){
	
$str = <<<ABC
	<input type="hidden" id="two_payment_id" name="payment_id" value="$payid" />
	<div class="modal-body" id="modal-body_two">
		<table style="margin: 0px auto;">
	<tr>
		<th class="center">缴费日期</th>
		<th class="center">缴费金额(元)</th>
		<th class="center">学费说明</th>
		<th class="center">状态</th>
	</tr>
	<tr>
		<td><input type="text" class="date-picker col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$already_paytime" name="payment_time" placeholder="缴费日期" /></td>
		<td><input type="text" class="col-xs-12 width145" value="$payment_money" name="payment_money" placeholder="缴费金额" /></td>
		<td><input type="text" class="col-xs-12 width145" name="payment_desc" value="$payment_desc" placeholder="学费说明" /></td>
		<td>
			<select name="payment_status" id="payment_status">
				$select
			</select>
		</td>
	</tr>
	</table>
	<input type="hidden" name="payment_type_id" value="$payment_type_id" />
	</div>	
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	<button type="button" class="btn btn-primary" id="pay_two_submit">保存</button>
	</div>
ABC;




}else if($payment_status == 1 && in_array($payment_type, $type_arr_two)){
	
$str = <<<ABC
	<input type="hidden" id="two_payment_id" name="payment_id" value="$payid" />
	<div class="modal-body" id="modal-body_two">
		<table style="margin: 0px auto;">
	<tr>
		<th class="center">缴费日期</th>
		<th class="center">缴费金额(元)</th>
		<th class="center">学费说明</th>
	</tr>
	<tr>
		<td><input type="text" class="date-picker col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$already_paytime" name="payment_time" placeholder="缴费日期" /></td>
		<td><input type="text" class="col-xs-12 width145" value="$payment_money" name="payment_money" placeholder="缴费金额" /></td>
		<td><input type="text" class="col-xs-12 width145" name="payment_desc" value="$payment_desc" placeholder="学费说明" /></td>
	</tr>
	</table>
	<input type="hidden" name="payment_type_id" value="$payment_type_id" />
	</div>	
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	<button type="button" class="btn btn-primary" id="pay_two_submit">保存</button>
	</div>
ABC;




}else{
$str = <<<ABC
	<input type="hidden" id="two_payment_id" name="payment_id" value="$payid" />
	<div class="modal-body" id="modal-body_two">
		<table style="margin: 0px auto;">
	<tr>
		<th class="center">应缴费日期</th>
		<th class="center">应缴费金额(元)</th>
		<th class="center">提醒时间</th>
		<th class="center">学费说明</th>
	</tr>
	<tr>
		<td><input type="text" class="date-picker col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$payment_time" name="payment_time" placeholder="应缴费日期" /></td>
		<td><input type="text" class="col-xs-12 width145" value="$payment_money" name="payment_money" placeholder="应缴费金额" /></td>
		<td><input type="text" class="col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time" value="$remind_time" placeholder="提醒时间" /></td>
		<td><input type="text" class="col-xs-12 width145" name="payment_desc" value="$payment_desc" placeholder="学费说明" /></td>
	</tr>
	</table>
	<input type="hidden" name="payment_type_id" value="$payment_type_id" />
	</div>	
	<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	<button type="button" class="btn btn-primary" id="pay_two_submit">保存</button>
	</div>
ABC;

}

$str .= <<<ABC
<script type="text/javascript">
$('input[data-target="#dateShow"]').datepicker();

$('input[data-target="#dateShow"]').focus(function(){

	$('.dropdown-menu').css('z-index',1060);

});

//处理分期付款操作
$('#pay_two_submit').on('click',function () {
	
	var payment_id = $('#two_payment_id').val();
	var payment_time = $('#modal-body_two input[name="payment_time"]').val();
	var payment_money = $('#modal-body_two input[name="payment_money"]').val();
	var remind_time = $('#modal-body_two input[name="remind_time"]').val();
	var payment_desc = $('#modal-body_two input[name="payment_desc"]').val();
	var payment_type_id = $('#modal-body_two input[name="payment_type_id"]').val();
	var status = $('#payment_status option:selected').val();
	if(status == undefined){
		status = -1;
	}

	$.ajax({
        type: "POST",
        url: "$url",
        data: "payment_id="+payment_id+"&payment_time="+payment_time+"&payment_money="+payment_money+"&payment_desc="+payment_desc+"&remind_time="+remind_time+"&type=one&payment_type_id="+payment_type_id+"&status="+status,
        dataType:'json',
        success: function(res){
        	if(res.data == 1){
       			location.reload();
       		}
        }
	});
});

</script>

ABC;

		$res['str'] = $str;
		}
		
		echo json_encode($res);
		exit;

	}

	/**
	 * qq与phone的数据简单处理
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
	 * 更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
	 */
	private function _update_payment_info($tuition_total,$repayment_id,$student_id,$position_total='')
	{
		#更新账单表的 已缴学费 already_payment
		$refund_where = array('repayment_id'=>$repayment_id,'payment_status !='=>0,'payment_type !='=>1,'student_id'=>$student_id);
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
			if($position_total == 'no'){
				$update_data['position_total'] = 0;
			}else{
				$update_data['position_total'] = $position_total;
			}		
		}

		$update_where = array('repayment_id'=>$repayment_id,'student_id'=>$student_id);
		$this->main_data_model->update($update_where,$update_data,'student_repayment_bills');
	}

	/**
	 * 更新下报名日期(最早报名日期)
	 */
	private function _update_min_sign($student_id)
	{
		//获取最早的报读课程时间
		$this->load->model('student_repayment_bills_model','student_repayment_bills');
		$record_where = array('student_id'=>$student_id);
		$min_record_course = $this->student_repayment_bills->course_payment_time($record_where);	

  		//更新下报名日期(最早报名日期)
  		if(!empty($min_record_course)){
  			$sign_up_where=array('student_id'=>$student_id);
			$sign_up_data = array('sign_up_date'=>$min_record_course);
			$this->main_data_model->update($sign_up_where,$sign_up_data,'student');
  		}
		
	}
}