<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生已报课程
 */
class Advisory_client_project_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
		$this->main_data_model->setTable('student_repayment_bills');
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

	public function index()
	{
		$consultant_id = $this->uri->segment(5);
		#导航条处理
		$this->menuProcess($consultant_id);
		
		//检查学生所属者
		$this->_checkPower($consultant_id);

		$page = $this->uri->segment(6, 1);
		$limit=15;
		$start=($page-1)*$limit;
		$this->load->model('client_project_model');
		$table = 'student_repayment_bills';
		$where_must = array($table.'.consultant_id'=>$consultant_id,$table.'.is_fail'=>1,$table.'.is_project'=>1);
		$client_project=$this->client_project_model->select_index($where_must,$start,$limit);

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(2).'/client_project/index/'.$consultant_id.'/');
		$config['total_rows'] =$this->main_data_model->setTable('student_repayment_bills')->count($where_must);
		$config['per_page'] = $limit; 
		$config['uri_segment'] = 6;
		$config['num_links'] = 2;
		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();
		#获取用户数据
		$info = $this->main_data_model->setTable('consultant')->getOne(array('consultant_id'=>$consultant_id));
		$data=array(
			'list'=>$client_project,
			'info'=>$info,
			'page'=>$page
		);

		$this->load->view('client_project_info_list',$data);
	}

	/**
	 * 导航条处理
	 */
	private function menuProcess($consultant_id)
	{	
		$url= unserialize(getcookie_crm('url'));


		$url[2]=array('客户项目',site_url(module_folder(2).'/client_project/index/'.$consultant_id));

		//之前是这么做
		//$_COOKIE['url']=serialize($url);
		//加密处理
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');

		setcookie_crm('url',serialize($url));
	}

	/**
	 *  添加项目
	 */
	public function add()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[2][1];

		$check=array(
				array('project_already_total','应缴费用')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			//缴费类型
			$data['payment_type_info'] = array();
			$data['payment_type_info'] = $this->main_data_model->getAll('*','payment_type');
			$data['uid'] = $this->uri->segment(5,0);
			$data['name'] = $this->main_data_model->getOne(array('consultant_id'=>$data['uid']),'consultant_name','consultant');
			$this->load->view('client_project_add',$data);
	  	}else{
			
			$course_info = $this->input->post();

			//检查学生所属者
			$this->_checkPower($course_info['consultant_id']);

			$info=$this->main_data_model->getOne(array('consultant_id'=>$course_info['consultant_id']),'*','consultant');
			$employee_id=$info['employee_id'];#员工ID

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

			if($repayment_id>0){

	  			show_message($info['consultant_name'].'成功添加项目！',$location);
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
				array('project_already_total','应缴费用')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){			

			#缴费类型
			$data['payment_type_info'] = array();
			$data['payment_type_info'] = $this->main_data_model->getAll('*','payment_type');

			$data['uid'] = $uid = $this->uri->segment(5,0);//客户id

			$data['id'] = $id = $this->uri->segment(6,0); //账单id

			$data['name'] = $this->main_data_model->getOne(array('consultant_id'=>$data['uid']),'consultant_name','consultant');

			$join = array(array('*','payment_type','student_repayment_bills.payment_type_id = payment_type.payment_type_id','left'));
			$where = array('repayment_id'=>$id);
			$data['list'] = $this->main_data_model->select('*',$where,0,0,'',$join,'student_repayment_bills');

			//获取该项目的信息
			$this->load->model('client_project_model');
			$where = array('consultant_id'=>$uid,'repayment_id'=>$id);
			$data['project_info'] = $this->client_project_model->select_one('*',$where);

			//获取所有缴费记录
			$this->load->model('student_repayment_bills_model','student_repayment_bills');
			$refund_where = "`consultant_id` = ".$data['uid']." and  `repayment_id` = $id and `payment_type` not in (0,2)"; //分期、生后补贴
			$data['refund_loan_info'] = $this->student_repayment_bills->query('*',$refund_where);

			//查找最早的缴费记录
			$payment_where = array('consultant_id'=>$data['uid'])+$where;
			$min_record_info = $this->student_repayment_bills->course_payment_time($payment_where);

			if($min_record_info){
				$min_where = "`already_paytime` = ".$min_record_info." and `consultant_id` = ".$data['uid']." and  `repayment_id` = $id  and `payment_type` in (0,2)";
				$min_info = $this->student_repayment_bills->query('*',$min_where);
			}else{
				$min_info = array();
			}

			$data['min_info'] = $min_info;

			$this->load->view('client_project_edit',$data);
	  	}else{
	  		$update = $this->input->post();

	  		//检查学生所属者
			$this->_checkPower($update['consultant_id']);

			$id = $this->input->post('repayment_id');

			$info=$this->main_data_model->getOne(array('consultant_id'=>$update['consultant_id']),'*','consultant');
			$employee_id=$info['employee_id'];
			$where=array('repayment_id'=>$id);		

			#执行修改
			$data=array();

			$data['consultant_id']=$update['consultant_id'];#咨询者id
			$data['study_expense']=$update['project_total_money'];#项目总费用
			$data['special_payment_remark']=$update['project_payment_remark'];#特殊情况备注
			$data['payment_type_id']=$update['payment_type_id'];#缴费类型

			#修改缴费记录
	  		$this->main_data_model->update($where,$data,'student_repayment_bills');

	  		//修改、更新第一次缴费记录
  			$pay_refund = array(
						'consultant_id'=>$update['consultant_id'],
						'payment_money' => $update['project_already_total'], #已缴学费
						'repayment_id'  => $id, #账单ID
						'payment_status'=> 1, #缴费状态
						'payment_desc'  => $update['project_payment_remark'],  #学费描述
						'payment_type_id' => $update['payment_type_id'] #缴费类型
					);
			if(!empty($update['project_payment_time'])){
				$pay_refund['payment_time'] = strtotime($update['project_payment_time']); #缴费日期
				$pay_refund['already_paytime'] = strtotime($update['project_payment_time']); #完成缴费日期
			}else{
				$pay_refund['payment_time'] = time();
				$pay_refund['already_paytime'] = time();		
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
				if(!empty($update['update_pro_payment_time'])){
					foreach ($update['update_pro_payment_time'] as $k => $v) {
						$where_refund = array('id'=>$k);
						$where_remind = array('loan_time_id'=>$k);
						if(!empty($v)){

							#暂时处理
					  		$result = $this->main_data_model->getOne($where_remind,'time_remind_id','time_remind');
					  		if(!empty($result)){

								$refund_info = array(
									'consultant_id' => $update['consultant_id'],
									'payment_time' => strtotime($v), #应缴费日期
									'payment_money' => isset($update['update_pro_payment_money'][$k]) ? $update['update_pro_payment_money'][$k] : '', #应缴费用
									'remind_time' => isset($update['update_pro_remind_time'][$k]) ? strtotime($update['update_pro_remind_time'][$k]) : '', #提醒时间
									'payment_desc' => isset($update['update_pro_payment_desc'][$k]) ? $update['update_pro_payment_desc'][$k] : '',  #项目备注
								);

								$re1=$this->main_data_model->update($where_refund,$refund_info,'refund_loan_time');

								#分期付款提醒
								$remind_info = array(
									'time_remind_time' => strtotime($update['update_pro_payment_time'][$k]),#提醒时间
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

								$remind_info['time_remind_content'] = '学员 '.$info['consultant_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['update_pro_payment_money'][$k].'元，请及时提醒该学生完成缴费！';

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
				if(!empty($update['add_pro_payment_time'])){
					foreach ($update['add_pro_payment_time'] as $k => $v) {
						if(!empty($v)){
							$refund_info = array(
								'consultant_id' => $update['consultant_id'],
								'payment_time' => strtotime($v), #应缴费日期
								'already_paytime' => 0, #完成缴费日期
								'payment_money' => isset($update['add_pro_payment_money'][$k]) ? $update['add_pro_payment_money'][$k] : '', #应缴费用
								'remind_time' => isset($update['add_pro_remind_time'][$k]) ? strtotime($update['add_pro_remind_time'][$k]) : '', #提醒时间
								'repayment_id' => $id, #账单ID
								'payment_status' => 0, #缴费状态
								'payment_desc' => isset($update['add_pro_payment_desc'][$k]) ? $update['add_pro_payment_desc'][$k] : '',  #项目说明
								'payment_type_id' => $update['payment_type_id'], #缴费类型
								'payment_type' => 3
							);


							$refund_id = $this->main_data_model->insert($refund_info,'refund_loan_time');

							$remind_info = array(  #分期付款提醒
								'loan_time_id' => $refund_id,
								'consultant_id' => $info['consultant_id'],
								'employee_id' =>$employee_id,#员工ID
								'is_client'=>1,
								'time_remind_time' => strtotime($update['add_pro_remind_time'][$k]),#提醒时间
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

							$remind_info['time_remind_content'] = '学员 '.$info['consultant_name'].'的学费是属于分期付款，现在缴费时间到了，缴费金额是：'.$update['add_pro_payment_money'][$k].'元，请及时提醒该学生完成缴费！';

							$remind_id = $this->main_data_model->insert($remind_info,'time_remind');
						}
					}			
				}
			}

			#更新账单表的 已缴学费 already_payment 和 完成状态 payment_status
			$this->_update_payment_info($update['project_total_money'],$id,'',$info['consultant_id']);

			#记录项目信息
			$project_info = array(
					'project_name' => $update['project_name'],
					'project_url' => $update['project_url'],
					'project_remark' => $update['project_payment_remark']
				);
			$project_where = array('consultant_id'=>$info['consultant_id'],'repayment_id'=>$id);
			$this->main_data_model->update($project_where,$project_info,'client_project_record');

			show_message($info['consultant_name'].'成功修改项目！',$location);
			
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


		$data = array('is_fail' => 0,'is_project'=>0);
		$this->main_data_model->update($where,$data,'student_repayment_bills');

		//查询客户id
		$this->load->model('student_repayment_bills_model');
		$client_info = $this->student_repayment_bills_model->consultant_number($dele_arr[0]);

		//通过客户id查找该客户是否有其他项目账单
		$where_client=array('consultant_id' => $client_info['consultant_id'],'is_fail' => 1,'is_project'=>1);
		$res=$this->main_data_model->count($where_client,'student_repayment_bills');

		//如果该学员没有其他课程，删除该学员，更新咨询者等状态
		if($res<=0){
			
			//虚拟删除客户
			$where_consultant=array('consultant_id' => $client_info['consultant_id']);
			$consultant_status=array('is_client' => 0);
			$this->main_data_model->update($where_consultant,$consultant_status,'consultant');
			$this->main_data_model->update($where_consultant,$consultant_status,'consultant_record');
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

		#查看项目信息
		$this->load->model('client_project_model');
		$where = array('repayment_id'=>$id);
		$project_info = $this->client_project_model->select_one('*',$where);

		#检查咨询者所属者
		$check_result = $this->_checkPower($project_info['consultant_id'],'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}

		#查询客户姓名
		$client=$this->main_data_model->getOne(array('consultant_id'=>$project_info['consultant_id']),'consultant_id,consultant_name','consultant');

		#查询缴费账单
		$repayment_info=$this->main_data_model->getOne(array('repayment_id'=>$id),'*','student_repayment_bills');

		#查询缴费类型
		$payment_type=$this->main_data_model->getOne(array('payment_type_id'=>$repayment_info['payment_type_id']),'payment_type_name','payment_type');
		
		#查询缴费记录表
		if($repayment_info['payment_type_id']==2){
			$where=array('repayment_id'=>$id);
		}else{
			$where=array('repayment_id'=>$id,'payment_type'=>0,'payment_status' => 0);
		}
		$payment=$this->main_data_model->getOtherAll('*',$where,'refund_loan_time');

		$str="<h6>客户姓名:".$client['consultant_name']."</h6>";
		$str.="<span>已接项目</span>";
		$str.="<table border='1' width='100%'>";

		if($project_info['project_name']){
			$str.="<tr>";
			$str.="<td>项目名称</td><td>".$project_info['project_name']."</td>";
			$str.="</tr>";
		}

		if($project_info['project_url']){
			$str.="<tr>";
			$str.="<td>项目参考网址</td><td><a href='".$project_info['project_url']."' target='_blank'>".$project_info['project_url']."</a></td>";
			$str.="</tr>";
		}

		if($repayment_info['study_expense']){
			$str.="<tr>";
			$str.="<td>项目总费用(元)</td><td>".$repayment_info['study_expense']."</td>";
			$str.="</tr>";
		}

		if($repayment_info['already_payment']){
			$str.="<tr>";
			$str.="<td>已缴费用(元)</td><td>".$repayment_info['already_payment']."</td>";
			$str.="</tr>";
		}

		if($repayment_info['special_payment_remark']){
			$str.="<tr>";
			$str.="<td>项目备注</td><td>".$repayment_info['special_payment_remark']."</td>";
			$str.="</tr>";
		}

		$str.="</table>";

		$res['data'] = $str;
		$res['info_url'] = site_url(module_folder(2).'/project_payment/index/'.$project_info['consultant_id'].'/'.$id);

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
	 * 删除分期付款
	 */
	public function deletePayRef()
	{
		header("Content-Type:text/html;charset=utf-8");

		$id = $this->input->post('pid');  //还款表id crm_refund_loan_time 

		//得到学生的id
		$this->load->model('refund_loan_time_model');
 		$consultant_id= $this->refund_loan_time_model->selectConsultantId($id);

 		//检查咨询者所属者
		$check_result = $this->_checkPower($consultant_id['consultant_id'],'','ajax');	

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
}