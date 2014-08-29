<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学员缴费记录
 */
class Advisory_project_payment_module extends CI_Module {

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
		#查询某个客户的缴费记录
		#当前页码
		$consultant_id = $this->uri->segment(5);

		//检查客户所属者
		$this->_checkPower($consultant_id);

		$repayment_id = $this->uri->segment(6);
		#导航栏
		$this->menuProcess($consultant_id);
		
		$where=array('consultant_id'=>$consultant_id);
		#学员
		$consultant_info= $this->main_data_model->getOne($where,'consultant_id,consultant_name','consultant');

		$page = $this->uri->segment(6, 1);

		$limit=0;#每页显示多少条
		
		$start=($page-1)*$limit;

		$field='*';#查询字段
		//$where_must = array('is_fail'=>1,'is_project'=>1);//正常的缴费记录（排除失效的记录）
		if(!empty($repayment_id)){
			$where=array('student_repayment_bills.consultant_id'=>$consultant_id,'repayment_id'=>$repayment_id);#条件
		}else{
			$where=array('student_repayment_bills.consultant_id'=>$consultant_id);#条件
		}
		
		$orders=0;#排序
		$join = array('*','payment_type','student_repayment_bills.payment_type_id = payment_type.payment_type_id','left');
		
		$client_repayment_info= $this->main_data_model->select($field,$where,$orders,$start,$limit,$join);
	
		$this->load->model('refund_loan_time_model','loan_time_model');

		foreach ($client_repayment_info as $key => $value) {

			#项目信息
			$repayment_where = array('repayment_id'=>$value['repayment_id']);
			$client_repayment_info[$key]['project_info'] = $this->main_data_model->getOne($repayment_where,'*','client_project_record ');

			$study_expense = $value['study_expense'];
			#统计已缴费用
			$paywhere = "`repayment_id` = ".$value['repayment_id']." AND `payment_status`!=0 AND `payment_type` != 1"; 
			$count_money = $this->loan_time_model->count_payment($paywhere);  #统计已缴费用
			$pay_money = $study_expense - $count_money; #还需要缴多少费用
			$client_repayment_info[$key]['pay_money'] = $pay_money;

			$field='*';#查询字段
			if(!empty($repayment_id)){
				if($value['payment_type_id']==5){
					$where=array('refund_loan_time.consultant_id'=>$consultant_id,'refund_loan_time.repayment_id'=>$repayment_id,'refund_loan_time.payment_type !='=>4);#条件
				}else{
					$where=array('refund_loan_time.consultant_id'=>$consultant_id,'refund_loan_time.repayment_id'=>$repayment_id,'refund_loan_time.payment_type !='=>1);#条件
				}
			}else{
				if($value['payment_type_id']==5){
					$where=array('refund_loan_time.consultant_id'=>$consultant_id,'refund_loan_time.repayment_id'=>$value['repayment_id'],'refund_loan_time.payment_type !='=>4);#条件
				}else{
					$where=array('refund_loan_time.consultant_id'=>$consultant_id,'refund_loan_time.repayment_id'=>$value['repayment_id'],'refund_loan_time.payment_type !='=>1);#条件
				}
			}

			$orders='refund_loan_time.payment_type_id asc,refund_loan_time.already_paytime desc';#排序
			$join = array('*','payment_type','refund_loan_time.payment_type_id = payment_type.payment_type_id','left');

			$client_repayment_info[$key]['refund_loan_time'] = $this->main_data_model->select($field,$where,$orders,$start,$limit,$join,'refund_loan_time');

			foreach ($client_repayment_info[$key]['refund_loan_time'] as $k => $v) {
				#序号
				$client_repayment_info[$key]['refund_loan_time'][$k]['serial_number']=$k+1;#每条数据对应当前页的每一个值

				if($v['payment_status'] == 2 && $v['payment_money']>0){
					unset($client_repayment_info[$key]['refund_loan_time'][$k]);
				}
			}	

		}

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(2).'/project_payment/index/'.$consultant_id);

		$count_where = array('consultant_id'=>$consultant_id);
		$config['total_rows'] =$this->main_data_model->count($count_where);
		$config['per_page'] = $limit;

		$config['uri_segment'] = 6;
		$config['num_links'] = 2;
		
		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();

		#赋值
		$data=array(
			'consultant_info'=>$consultant_info,
			'list'=>$client_repayment_info,
			'page'=>$page
		);


		#指定模板
		$this->load->view('project_payment_list',$data);

	}

	/**
	 * 导航条处理
	 */
	private function menuProcess($consultant_id)
	{	
		$url= unserialize(getcookie_crm('url'));


		$url[2]=array('缴费记录列表',site_url(module_folder(2).'/project_payment/index/'.$consultant_id));

		
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
			show_message('权限不对',site_url(module_folder(2).'/client/index/index/0'));
		}

		$this->load->model('consultant_model');

		$res= $this->consultant_model->checkData($id,$type);
		
		if ($res===0) {
			if($is_ajax=='ajax'){
				return 0;//表示操作了非法数据	
			}else{
				show_message('权限不对',site_url(module_folder(2).'/client/index/index/0'));
			}
		
		}else{
			return 1;
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
 		$consultant_id= $this->refund_loan_time_model->selectConsultantId($payment_id);

 		//检查咨询者所属者
		$check_result = $this->_checkPower($consultant_id['consultant_id'],'','ajax');	

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
				#更新账单表的 已缴费用 already_payment 和 完成状态 payment_status 和 定位费
				$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$info['consultant_id'],'no');
			}else{
				$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$info['consultant_id']);
			}
		}

		//通过学员id查找该学员是否报了其他课程
		$where_consultant=array('consultant_id' => $consultant_id['consultant_id'],'payment_status !=' => 2,'repayment_id'=>$info['repayment_id']);
		$res=$this->main_data_model->count($where_consultant,'refund_loan_time');

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

		//得到咨询者的id
		$this->load->model('refund_loan_time_model');
 		$consultant_id= $this->refund_loan_time_model->selectConsultantId($pay_id);

 		//检查咨询者所属者
		$check_result = $this->_checkPower($consultant_id['consultant_id'],'','ajax');	

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

		#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status 和 定位费
		if($info['payment_type'] == 2){		
			$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$info['consultant_id'],'no');
		}else{
			$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$info['consultant_id']);
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
 		$consultant_id= $this->refund_loan_time_model->paymentConsultantId($payment_id);

 		//检查咨询者所属者
		$check_result = $this->_checkPower($consultant_id['consultant_id'],'','ajax');	

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

			$this->_update_payment_info($payment_info['study_expense'],$payment_id,$payment_info['consultant_id']);

			echo json_encode(array('data'=>1));
			exit;
		}

		//查询客户id
		// $this->load->model('student_repayment_bills_model');
		// $consultant_info = $this->student_repayment_bills_model->consultant_number($payment_id);

		//通过客户id查找该客户是否有其他项目账单
		// $where_client=array('consultant_id' => $consultant_info['consultant_id'],'is_fail' => 1,'is_project'=>1);
		// $res=$this->main_data_model->count($where_client,'student_repayment_bills');

		//如果该学员没有其他课程，删除该学员，更新咨询者等状态
		// if($res<=0){
			
		// 	//虚拟删除客户
		// 	$where_consultant=array('consultant_id' => $consultant_info['consultant_id']);
		// 	$consultant_status=array('is_client' => 0);
		// 	$this->main_data_model->update($where_consultant,$consultant_status,'consultant');
		// 	$this->main_data_model->update($where_consultant,$consultant_status,'consultant_record');
		// }
		
		//echo json_encode(array('data'=>1));
		//exit;
	}

	/**
	 * 处理缴费状态
	 */
	public function actionPayment()
	{
		#缴费记录id
		$payment_id = $this->input->post('payment_id');
		#完成缴费日期
		$payment_time 	= $this->input->post('payment_time');
		#已缴费用
		$payment_money = $this->input->post('payment_money');
		#提醒时间
		$remind_time = $this->input->post('remind_time');
		#费用描述
		$payment_desc = $this->input->post('payment_desc');
		#费用缴费类型
		$payment_type_id = $this->input->post('payment_type_id');
		#类型
		$type = $this->input->post('type');
		$this->load->model('student_repayment_bills_model');

		$where = array('id'=>$payment_id);
		#查询状态
		$refund_info = $this->main_data_model->getOne($where,'payment_status,consultant_id','refund_loan_time');

		//检查学生所属者
		$this->_checkPower($refund_info['consultant_id']);

		if($type == 'one'){ #修改费用、定位费、分期付款
			
			if($payment_type_id == 2){  //分期付款(包括提醒)

					#项目缴费类型
					$status = $this->input->post('status');
					$where_remind = array('loan_time_id'=>$payment_id);

					$consultant_info=$this->main_data_model->getOne(array('consultant_id'=>$refund_info['consultant_id']),'consultant_name','consultant');

					$data = array(
						'payment_money' => $payment_money,
						'payment_desc' => $payment_desc,
						'payment_type_id' => $payment_type_id
					);

					if(isset($status) && $status != -1){   //已完成
						$data['already_payment'] = $payment_money;			
						$data['payment_status'] = $status;
						$data['already_paytime'] = strtotime($payment_time);

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
					$where_id = array('consultant_id'=>$refund_info['consultant_id']);
					$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
					$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
					//分割数组
					$phone=$this->_dataProcess($phone_infos,'phone_number');
					$phone=implode(',', $phone);
					$qq=$this->_dataProcess($qq_infos,'qq_number');
					$qq=implode(',', $qq);

					$remind_info['time_remind_content'] = '客户 '.$consultant_info['consultant_name'].'的费用是属于分期付款，现在缴费时间到了，缴费金额是：'.$payment_money.'元，请及时提醒该客户完成缴费！';

					$re1=$this->main_data_model->update($where_remind,$remind_info,'time_remind');	

			}else{
				$data = array(   //修改费用
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
				#更新账单表的 已缴费用 already_payment 和 完成状态 payment_status 和 定位费
				$position_total = $payment_money;
			}else{
				$position_total = '';
			}

			//更新账单表
			$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$refund_info['consultant_id'],$position_total);

			echo json_encode(array('data'=>1));
			exit;

		}else if($type == 'two'){  //完成分期缴费操作(注：设置提醒时间：不提醒)
			#修改已缴费用
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

			$this->_update_payment_info($payment_info['study_expense'],$info['repayment_id'],$refund_info['consultant_id']);

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
		
		}	
	}


	/**
	 * ajax(费用缴费情况)：一次性付款、先就业后付款（包吃住）、先就业后付款（不包吃住）
	 */
	public function disposableAjax()
	{
		$payid = $this->input->post('id'); //账单ID
		$consultant_id = $this->input->post('consultant_id');

		//检查咨询者所属者
		$check_result = $this->_checkPower($consultant_id,'','ajax');	

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

		#统计包括定位费的已缴费用
		$paywhere = "`repayment_id` = $payid AND `payment_status` = 1 AND `payment_type` != 1"; 
		$payment_money = $this->loan_time_model->count_payment($paywhere);
		$payment_money = $payment_money == 0 ? 0 : $payment_money;

		$count_money = $this->loan_time_model->count_payment($paywhere);  #统计已缴费用

		$pay_money = $study_expense - $count_money; #还需要缴多少费用

		$str = $this->getProjectInfo($payid,$consultant_id); #显示项目信息

		$str .= '<br /><br />';
		
		if($pay_money < 0){
			$str .= '<div>该客户的缴费类型是：'.$payment_type_name.'，项目总费用是：'.$study_expense.' 元，已缴费用是：'.$payment_money.' 元，您现在的费用超出金额 '.abs($pay_money).' 元</div><br />';
		}else{
			$str .= '<div>该客户的缴费类型是：'.$payment_type_name.'，项目总费用是：'.$study_expense.' 元，已缴费用是：'.$payment_money.' 元，还需要缴费的金额是：'.$pay_money.' 元</div><br />';
		}
		

	$str .= <<<ABC
				<input type="hidden" name="payment_type_id" value="$payment_type_id" />
				<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success addpay">
							<i class="icon-plus"> 添加项目费用</i>
				</button>
ABC;

	$str .= <<<ABC
			<table style="margin: 0px auto;" class="none" id="disposable_payment">
				<tr>
					<th class="center">缴费日期</th>
					<th class="center">缴费金额(元)</th>
					<th class="center">缴费说明</th>
				</tr>
ABC;

$str .= <<<ABC

				</table>
				<input type="hidden" name="payment_id" value="$payid">
				<input type="hidden" name="consultant_id" value="$consultant_id">
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
	 * 分期付款（缴费处理）
	 */
	public function installmentAjax()
	{
		$payid = $this->input->post('id');
		$consultant_id = $this->input->post('consultant_id');

		//检查咨询者所属者
		$check_result = $this->_checkPower($consultant_id,'','ajax');	

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

		#统计除定位费的已缴费用
		$paywhere = "`repayment_id` = $payid AND `payment_status` = 1 AND `payment_type` != 1"; 
		$payment_money = $this->loan_time_model->count_payment($paywhere);
		$payment_money = $payment_money == 0 ? 0 : $payment_money;

		$count_money = $this->loan_time_model->count_payment($paywhere);  #统计已缴费用

		$pay_money = $study_expense - $count_money; #还需要缴多少费用

		$str = $this->getProjectInfo($payid,$consultant_id); #显示项目信息

		$str .= '<br /><br />';
		
		if($pay_money < 0){
			$str .= '<div>该客户的缴费类型是：'.$payment_type_name.'，项目总费用是：'.$study_expense.' 元，已缴费用是：'.$payment_money.' 元，您现在的费用超出金额 '.abs($pay_money).' 元</div><br />';
		}else{
			$str .= '<div>该学生的缴费类型是：'.$payment_type_name.'，项目总费用是：'.$study_expense.' 元，已缴费用是：'.$payment_money.' 元，还需要缴费的金额是：'.$pay_money.' 元</div><br />';
		}
		
		#查看是否存在定位费
		$paywhere = "`repayment_id` = $payid AND `payment_status` = 1 AND `payment_type` = 2"; 
		$refund_info_one = $this->main_data_model->getOne($paywhere,'*','refund_loan_time');  #定位费记录

		$paywhere = "`repayment_id` = $payid AND `payment_status` = 1 AND `payment_type` = 0"; 
		$refund_info_two = $this->main_data_model->getOne($paywhere,'*','refund_loan_time');  #费用记录

		$str .= '<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success addpay"><i class="icon-plus"> 添加分期缴费</i></button>';

		$str .= <<<ABC

				<table style="margin: 0px auto;" class="none" id="fenqi_payment">
				<tr>
					<th class="center">应缴费日期</th>
					<th class="center">应缴费金额(元)</th>
					<th class="center">提醒时间</th>
					<th class="center">缴费说明</th>
				</tr>
ABC;

$str .= <<<ABC
		</table>
		<input type="hidden" name="payment_id" value="$payid">
		<input type="hidden" name="consultant_id" value="$consultant_id">
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
				$('#modal-body').find('.col-sm-5').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请填写费用！</div>');
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
	 * 获取项目信息
	 */
	private function getProjectInfo($payid,$consultant_id)
	{
		#查看项目信息
		$repayment_where = array('repayment_id'=>$payid);
		$project_info = $this->main_data_model->getOne($repayment_where,'*','client_project_record');

		$str = '';
		$str .= '项目名称：'.$project_info['project_name'].'<br />';
		$str .= '项目参考地址：<a href="'.$project_info['project_url'].'" target="_blank">'.$project_info['project_url'].'</a><br />';
		$str .= '项目备注：'.$project_info['project_remark'];

		return $str;
	}

	/**
	 * 添加新项目（一次性付款）
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
		$consultant_id=$this->input->post('consultant_id');
		$payment_type_id = $this->input->post('payment_type_id');

		//检查学生所属者
		$this->_checkPower($consultant_id);


		$where=array('repayment_id'=>$payment_id);
		#接收
		$update = $this->input->post();

		//得到学生的相关信息
		$this->load->model('consultant_model','consultant');
		$info= $this->consultant->getInfo($consultant_id);

		if(!empty($update['payment_time'])){
			#费用
			$refund_info = array();
			foreach ($update['payment_time'] as $k => $v) {
				if($v != ''){
					$refund_info[] = array(
						'consultant_id' => $consultant_id,
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

		#更新账单表的 已缴费用 already_payment 和 完成状态 payment_status
		$this->_update_payment_info($study_expense,$payment_id,$consultant_id);
		
		show_message('添加成功',$location);	
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
		$consultant_id=$this->input->post('consultant_id');
		$study_expense = $this->input->post('study_expense');
		$payment_type_id = $this->input->post('payment_type_id');

		//检查学生所属者
		$this->_checkPower($consultant_id);

		$where=array('repayment_id'=>$payment_id);

		#接收
		$update = $this->input->post();

		//得到学生的相关信息
		$this->load->model('consultant_model','consultant');
		$info= $this->consultant->getInfo($consultant_id);

		if(!empty($update['payment_time'])){   //添加分期费用		
			foreach ($update['payment_time'] as $k => $v) {
				if($v != ''){
					$refund_info = array(
						'consultant_id' => $consultant_id,
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
						'employee_id' => $info['employee_id'],#员工ID
						'time_remind_time' => strtotime($update['remind_time'][$k]),
						'is_client'=>1,
						'repayment_id'=>$payment_id 
					);
					#查询学员的姓名,手机,QQ加入到提醒内容
					$where_id = array('consultant_id'=>$consultant_id);
					$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
					$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
					//分割数组
					$phone=$this->_dataProcess($phone_infos,'phone_number');
					$phone=implode(',', $phone);
					$qq=$this->_dataProcess($qq_infos,'qq_number');
					$qq=implode(',', $qq);

					$remind_info['time_remind_content'] = '客户 '.$info['consultant_name'].'的缴费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['payment_money'][$k].'元，请及时提醒该客户完成缴费！';

					$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
				}
			}
		}
		
		#更新账单表的 已缴费用 already_payment 和 完成状态 payment_status
		$this->_update_payment_info($study_expense,$payment_id,$consultant_id);
		
		show_message('添加成功',$location);
	}


	/**
	 * 修改分期付款信息
	 */
	public function payinfoAjax()
	{
		$payid = $this->input->post('id'); //缴费记录
		$where = array('id'=>$payid);
		$refund_info = $this->main_data_model->getOne($where,'*','refund_loan_time');

		//检查咨询者所属者
		$check_result = $this->_checkPower($refund_info['consultant_id'],'','ajax');	

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

			$url = site_url(module_folder(2).'/project_payment/actionPayment');

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
		<th class="center">缴费说明</th>
		<th class="center">状态</th>
	</tr>
	<tr>
		<td><input type="text" class="date-picker col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$already_paytime" name="payment_time" placeholder="缴费日期" /></td>
		<td><input type="text" class="col-xs-12 width145" value="$payment_money" name="payment_money" placeholder="缴费金额" /></td>
		<td><input type="text" class="col-xs-12 width145" name="payment_desc" value="$payment_desc" placeholder="缴费说明" /></td>
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
		<th class="center">缴费说明</th>
	</tr>
	<tr>
		<td><input type="text" class="date-picker col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$already_paytime" name="payment_time" placeholder="缴费日期" /></td>
		<td><input type="text" class="col-xs-12 width145" value="$payment_money" name="payment_money" placeholder="缴费金额" /></td>
		<td><input type="text" class="col-xs-12 width145" name="payment_desc" value="$payment_desc" placeholder="缴费说明" /></td>
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
		<th class="center">缴费说明</th>
	</tr>
	<tr>
		<td><input type="text" class="date-picker col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="$payment_time" name="payment_time" placeholder="应缴费日期" /></td>
		<td><input type="text" class="col-xs-12 width145" value="$payment_money" name="payment_money" placeholder="应缴费金额" /></td>
		<td><input type="text" class="col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time" value="$remind_time" placeholder="提醒时间" /></td>
		<td><input type="text" class="col-xs-12 width145" name="payment_desc" value="$payment_desc" placeholder="缴费说明" /></td>
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
	 * 更新账单表的 已缴费用 already_payment 和 完成状态 payment_status
	 */
	private function _update_payment_info($tuition_total,$repayment_id,$consultant_id,$position_total='')
	{
		#更新账单表的 已缴费用 already_payment
		$refund_where = array('repayment_id'=>$repayment_id,'payment_status !='=>0,'payment_type !='=>1,'consultant_id'=>$consultant_id);
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

		$update_where = array('repayment_id'=>$repayment_id,'consultant_id'=>$consultant_id);
		$this->main_data_model->update($update_where,$update_data,'student_repayment_bills');
	}

}