<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生操作
 */
class Teaching_student_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
		$this->main_data_model->setTable('student');
		$this->load->model('student_model','student');
		$this->_checkPower();
	}

	public function index()
	{
		$data['type'] = $type = $this->uri->segment(5,'index');
		#咨询师
		$this->load->model('p_employee_model');

		//接收日期类型
		$data['select_type']=$select_type=trim($this->input->get('select_type'))!=''?trim($this->input->get('select_type')):'';

		//选中知识点查询学员
		$data['selected_knownledge']=$selected_knownledge=trim($this->input->get('knowledge_id'))!=''?trim($this->input->get('knowledge_id')):'';

		$data['teach']= $this->p_employee_model->selectDepartment();

		$data['cur_pag']=$page=$this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=20;
		$start=($page-1)*$limit;

		$param_url=array();
		$param_url['select_type']=$select_type;
		$param_url['knowledge_id']=$selected_knownledge;

		#接收分类
		$type_data = $this->uri->segment(6, 0);

		#导航条处理
		$this->menuProcess($type,$type_data);

		#搜索
		$search = trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
		$param_url['search']=$search;

		#搜索分类
		$key = $this->input->get('key')?$this->input->get('key'):'student_name';
		$param_url['key']=$key;

		//查询知识点
		$data['knowledge_info']=$this->main_data_model->getAll('knowledge_id,knowledge_name','knowledge');

		//超级管理员选中的咨询师
		$data['selected_teach']=$selected_teach=trim($this->input->get('teach'))!=''?trim($this->input->get('teach')):'';

		$param_url['teach']=$selected_teach;

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

		$this->load->model('student_model','student');
		$this->student->init($selected_teach);

		$search_key_type=array('student_name','student_education','student_school','student_specialty');
		if (in_array($key,$search_key_type)) {
			if($select_type!='' && $selected_knownledge!=''){
				$where_other = array('select_type'=>$select_type,'knownledge_id'=>$selected_knownledge);
			}else{
				$where_other = '';
			}	
			$student = $this->student->select_index($start,$limit,$key,$search,$start_time,$end_time,$selected_teach,$where_other);
			$count=$this->student->select_index_count($key,$search,$start_time,$end_time,$where_other);
		}else{
			#通过联系方式查找
			$model="consul_stu_{$key}_model";
			$this->load->model($model,'contact');
			$data=$this->contact->select_student($search);
			$data=$this->_dataProcess($data,'student_id');
			$count=count($data);
			if ($count==0) {
				show_message('没有查询到相关的信息。');
			}
			
			$student=$this->student->select_contact_like($data,$start,$limit);
		}

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		$this->load->model('classroom_model','classroom');

		$this->load->model('employee_model','employee');

		foreach($student as $k=>$v){
			#序号
			$student[$k]['serial_number']=$number[$k];

			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('student_id'=>$v['student_id']));
			$student[$k]['phone']=$this->_dataProcess($tmp,'phone_number');
			
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('student_id'=>$v['student_id']));
			$student[$k]['qq']=$this->_dataProcess($tmp,'qq_number');

			#员工名字
			$student[$k]['employee'] = $this->employee->select_employee($v['employee_id']);	

			#学员所在班级
			$tmp = $this->classroom->student_class($v['student_id']);
			$student[$k]['class']=$this->_dataProcess($tmp,'classroom_name');
		}

		#分页类
		$this->load->library('pagination');
		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url,$type,$type_data);
		$config['total_rows'] =$count;
		$config['per_page'] = $limit; 

		$config['num_links'] = 5;
		$config['page_query_string']=true;
		
		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$where=array('class_status'=>1);
		//获取班级列表
		$data['classroom_list'] = $this->main_data_model->getOtherAll('classroom_id,classroom_name,course_schedule',$where,'classroom');
		//组装班级知识点名称
		foreach ($data['classroom_list'] as $k => $vv) {
			$course_schedule = explode(',',$vv['course_schedule']);
		
			#找出已读的知识点
			$this->load->model('p_knowledge_model');
			$knowledgeInfo = $this->p_knowledge_model->selectAllKnowledge($course_schedule);

			$knowledge = '&nbsp;&nbsp;&nbsp;';
			foreach ($knowledgeInfo as $v) {
				$knowledge .= $v['knowledge_name'].'，';
			}

			$data['classroom_list'][$k]['knowledge'] = rtrim($knowledge,"，");
		}

		$data['student_info']=array(
			'count'=>$count,
			'list'=>$student,
			'page'=>$create_page,
			'key'=>$key,
			'select_type'=>$select_type,
			'selected_knownledge'=>$selected_knownledge,
			'search'=>$search
		);

		$this->load->view('student_list',$data);
	}

	public function edit()
	{

		$edit = $this->uri->segment(5,0);

		if ($edit==0) {
			show_message('无效的参数!',site_url(module_folder(4).'/student/index'));			
		}

		$check=array(
			array('student_name','学员姓名')
		);
		check_form($check);
		
		if ($this->form_validation->run() == FALSE){
			//通过学员ID查询咨询者ID(#学员信息)
			$where=array('student_id'=>$edit);
			$student = $this->main_data_model->getOne($where,'*','student');

			//获取咨询者信息
			$con_where = array('consultant_id'=>$student['consultant_id']);
			$consultant = $this->main_data_model->getOne($con_where,'consultant_id','consultant');

			$where=array('student_id'=>$edit,'consultant_id'=>$student['consultant_id']);

			#学员的qq
			$consultant_qq = $this->main_data_model->getOtherAll('qq_number,qq_id',$where,'consul_stu_qq');
			#学员的phone
			$consultant_phone = $this->main_data_model->getOtherAll('phone_number,phone_id',$where,'consul_stu_phones');
			#学员的email
			$consultant_email = $this->main_data_model->getOtherAll('email,email_id',$where,'consul_stu_email');

			#赋值
			$data['student']          =$student;	
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
				$data['location']=site_url(module_folder(4).'/student/index/index/0');	
			}

			$this->load->view('student_edit',$data);

		}else{
			//接收跳转地址
			$location=$this->input->post('location');

			$data=array();
	  		
	  		$consultant_id = $this->input->post("consultant_id");#咨询者ID

	  		#接收phone QQ 邮箱
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
	  		
	  		$stu_data['student_other_contacts']   = $con_data['consultant_other_contacts'] = $this->input->post("student_other_contacts");#其他联系方式
			$stu_data['student_name']             = $con_data['consultant_name']           = $this->input->post("student_name");#姓名
			$stu_data['student_sex']   			  = $con_data['consultant_sex']            = $this->input->post("sex");#性别
				
			$stu_data['student_otherinfo']           = $con_data['consultant_otherinfo'] = $this->input->post("student_otherinfo");#学员的其他信息
 
			$stu_data['student_school']  		 	 = $con_data['consultant_school']    = $this->input->post("student_school");#毕业学校
			$stu_data['student_specialty']   		 = $con_data['consultant_specialty'] = $this->input->post("student_specialty");#专业

			#学号
			//$stu_data['student_number'] = $this->input->post("student_number");
			#身份证
			$stu_data['certificate'] = $this->input->post("certificate");
			#是否领取学生证
			$stu_data['is_card'] = $this->input->post("student_card");
			#是否领取教材
			$stu_data['is_material'] = $this->input->post("material");
			#是否自带电脑
			$stu_data['is_computer'] = $this->input->post("computer");
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

			$where=array('student_id'=>$edit);
			#修改学员的信息
	  		$res= $this->main_data_model->update($where,$stu_data,'student');

	  		#修改咨询者的信息
	  		$where=array('consultant_id'=>$consultant_id);
	  		$this->main_data_model->update($where,$con_data,'consultant');
	
			//更新phone
			if($update_phone && !empty($update_phone)){
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
						$res1=$this->main_data_model->update($where_phone,$edit_phone,'consul_stu_phones');
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
						$res2=$this->main_data_model->update($where_qq,$edit_qq,'consul_stu_qq');
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
						$res3=$this->main_data_model->update($where_email,$edit_email,'consul_stu_email');
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

			show_message('编辑成功!',$location);	
			
		}
	}
	/**
	 *  批量安排班级
	 */
	public function allArrangeClass()
	{
		if (!empty($_POST)) { 
			/*$classroom_id = $this->input->post('class');
			$all_student = $this->input->post('all_student');
			
			//判断有没有选中学生
			if(empty($all_student)){
				show_message('请选择要安排班级的学生');
			}
			$all_student=explode(',', $all_student);

			$data = array();
			foreach ($all_student as $value) {
				$data[] = array(
					'classroom_id'=>$classroom_id,
					'student_id'=>$value,
				);

				$where=array('student_id'=>$value,'classroom_id'=>$classroom_id);
				$res = $this->main_data_model->getOne($where,'*','student_classroom_relation');

				if($res){
					//查询哪个学生
					$where_student=array('student_id'=>$res['student_id']);
					$student = $this->main_data_model->getOne($where_student,'student_name','student');
					//查询哪个班级
					$where_class=array('classroom_id'=>$classroom_id);
					$class = $this->main_data_model->getOne($where_class,'classroom_name','classroom');

					show_message($student['student_name']."已经在".$class['classroom_name']."班级,请重新选择");
				}
			}
			
			$result=$this->main_data_model->insert_batch($data,'student_classroom_relation');

			if($result>0){
	  			show_message('操作成功',site_url(module_folder(4).'/student/index'));
	  		}else{
	  			show_message('操作失败！');
	  		}*/
	  		$classroom_id = $this->input->post('allclass');
			$all_student = $this->input->post('all_student');
			
			//判断有没有选中学生
			if(empty($all_student)){
				show_message('请选择要安排班级的学生');
			}
			if(empty($classroom_id)){
	  			show_message('请至少选择一个班级');
	  		}
			
			$all_student=explode(',', $all_student);

			$this->load->model('classroom_model','classroom');
			foreach ($all_student as $value) {
				foreach ($classroom_id as $val) {

					$res = $this->classroom->student_class($value);
			  		//已经在的班级的班级类型,目的做复读
			  		$already=array();
			  		foreach ($res as $v) {
			  			$already[]=$v['classroom_type_id'];
			  		}
			  		$already=array_unique($already);
					//所报班级的班级类型,目的做复读
					$where_type = array('classroom_id'=>$val);
					$arrange=$this->main_data_model->getOne($where_type,'classroom_type_id','classroom');
					//如果存在就表示复读生
					if(in_array($arrange['classroom_type_id'],$already)){
						$is_first=2;
					}else{
						$is_first=1;
					}

					$where=array('student_id'=>$value,'classroom_id'=>$val,'show_status'=>1);
					$res1 = $this->main_data_model->getOne($where,'*','student_classroom_relation');

					if($res1){
						//查询哪个学生
						/*$where_student=array('student_id'=>$res['student_id']);
						$student = $this->main_data_model->getOne($where_student,'student_name','student');
						//查询哪个班级
						$where_class=array('classroom_id'=>$val);
						$class = $this->main_data_model->getOne($where_class,'classroom_name','classroom');

						show_message($student['student_name']."已经在".$class['classroom_name']."班级,请重新选择");*/
						continue;
					}
					//查询之前是否在这个班级
					$where = array('student_id'=>$value,'classroom_id'=>$val);
					$res2 = $this->main_data_model->getOne($where,'*','student_classroom_relation');
					if($res2){
						$status = array('show_status'=>1,'is_first'=>$is_first);
						$result = $this->main_data_model->update($where,$status,'student_classroom_relation');
					}else{
						$data=array(
							'classroom_id'=>$val,
							'student_id'=>$value,
							'show_status'=>1,
							'is_first'=>$is_first
						);
						$result=$this->main_data_model->insert($data,'student_classroom_relation');
					}
				}
			}

			if(isset($result) && $result>0){
	  			show_message('操作成功',site_url(module_folder(4).'/student/index'));
	  		}else{
	  			show_message('操作失败！');
	  		}
		}
	}
	/**
	 *  ajax获取更为详细的学员信息。
	 */
	public function info()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$id= $this->input->post("id");

		$where=array('student_id'=>$id);
		#学员
		$student= $this->main_data_model->getOne($where,'','student');

		#学员phone
		$student_phone= $this->main_data_model->setTable('consul_stu_phones')->select('phone_number',$where);

		#学员qq
		$student_qq= $this->main_data_model->setTable('consul_stu_qq')->select('qq_number',$where);
		
		#学员email
		$student_email= $this->main_data_model->setTable('consul_stu_email')->select('email',$where);

		#学员所在班级
		$this->load->model('classroom_model','classroom');
		$student_class = $this->classroom->student_class($id);

		#咨询师
		$this->load->model('employee_model','employee');
		$employee = $this->employee->select_employee($student['employee_id']);	

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

		#就读班级
		if($student_class){
				$str.="<tr>";
				$str.="<td>就读班级</td>";
				$str.="<td>";
			foreach($student_class as $item){	
				$str.=$item['classroom_name']."&nbsp;&nbsp;&nbsp;";
			}
				$str.="</td>";
				$str.="</tr>";
		}

		#咨询师
		$str.="<tr>";
		$str.="<td>咨询师</td><td>".$employee['employee_name']."</td>";
		$str.="</tr>";

		#身份证
		if(trim($student['certificate'])!=''){
			$str.="<tr>";
			$str.="<td>身份证</td><td>".$student['certificate']."</td>";
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

		#学员状态
		if ($student['student_status']==1) {
		 	$student_status= '就读';
		}else if($student['student_status']==2){
		 	$student_status= '毕业';
		}else if($student['student_status']==0){
			$student_status= '休学';
		}else{
			$student_status= '';
		}
		$str.="<tr>";
		$str.="<td>学员状态</td><td>".$student_status."</td>";
		$str.="</tr>";

		#状态备注
		if(trim($student['status_remark'])!=''){
			$str.="<tr>";
			$str.="<td>学员状态备注</td><td>".$student['status_remark']."</td>";
			$str.="</tr>";
		}

		#领取学生证
		if($student['is_card']==1){
			$str.="<tr>";
			$str.="<td>学生证</td><td>已领取</td>";
			$str.="</tr>";
		}

		#领取教材
		if($student['is_material']==1){
			$str.="<tr>";
			$str.="<td>教材</td><td>已领取</td>";
			$str.="</tr>";
		}
		#自带电脑
		if($student['is_computer']==1){
			$str.="<tr>";
			$str.="<td>电脑</td><td>自带电脑</td>";
			$str.="</tr>";
		}

		$str.="</table>";

		$info_url = site_url(module_folder(4).'/student/edit/'.$student['student_id']);

		echo json_encode(array('status'=>1, 'data'=>$str, 'info_url'=>$info_url));
		exit;

	}
	/**
	 *  报读课程信息
	 */
	public function courseInfo()
	{
		header("Content-Type:text/html;charset=utf-8");
		$student_id= $this->input->post("id");

		//根据学生id，去查找学生还款账单表
		$where=array('student_id'=>$student_id,'is_fail'=>1);
		$all = $this->main_data_model->getOtherAll('repayment_id',$where,'crm_student_repayment_bills');

		if(empty($all)){ 
			$str = "暂无此学生的已报课程信息";
			echo json_encode(array('data'=>$str));
			exit;
		}
		
		$this->load->model('student_knowleage_relation_model','student_knowleage_relation');
		//查找学生知识点表,重组数组	
		foreach ($all as $value) {
			$knowledge = $this->student_knowleage_relation->select_index($student_id,$value['repayment_id']);
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

		$str="<table border='1' width='100%'>";

		$str.="<tr>";
		$str.="<td width='100px'>课程</td><td>知识点</td>";
		$str.="</tr>";

		foreach ($list as $value) {
			$str.="<tr>";
			#课程
			$str.="<td width='100px'>";
			if(!empty($value['course_name'])){
				foreach ($value['course_name'] as $v) {
					$str.= $v."&nbsp;&nbsp;";
				}
			}
			$str.="</td>";
			#知识点
			$str.="<td>";
			if(!empty($value['knowledge_name'])){
				foreach ($value['knowledge_name'] as $v) {
					$str.= $v."&nbsp;&nbsp;";
				}
			}
			$str.="</td>";

			$str.="</tr>";
		}
		
		$str.="</table>";
		echo json_encode(array('status'=>1, 'data'=>$str));
		exit;
	}
	/**
	 *  ajax获取学员要复读知识点信息。
	 */
	public function repeatKnowledge()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$student_id= $this->input->post("id");

		#学生信息
		$this->load->model('p_student_model');
		$where = array('student_id'=>$student_id);
		$stu_info = $this->p_student_model->getStudentInfo("student_name",$where);

		#学生复读知识点
		$this->load->model('p_knowledge_model');
		$where = array('student_knowleage_relation.student_id'=>$student_id,'student_knowleage_relation.study_status'=>2);
		$info = $this->p_knowledge_model->student_knowledge_info($where);

		$str = '';
		if(!empty($info)){
			foreach ($info as $key => $value) {
				$str .= $value['knowledge_name']."，";
			}
			$str = rtrim($str,'，');
		}
		echo json_encode(array('status'=>1, 'data'=>$str,'stu_name'=>$stu_info['student_name']));
		exit;
	}
	/**
	 *  ajax获取学员所在班级
	 */
	public function studentClass()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$student_id= $this->input->post("id");

		//查找班级列表
		$where=array('class_status'=>1);
		$classroom_list = $this->main_data_model->getOtherAll('classroom_id,classroom_name,course_schedule',$where,'classroom');
		//查找学生已经所在的班级
		$this->load->model('classroom_model','classroom');
		$student_class = $this->classroom->student_classid($student_id);

		/*$str = '<select class="form-control" name="class" required><option value="">请选择班级</option>';

		foreach ($classroom_list as $key => $value) {
			$classroom_id = $value['classroom_id'];
			$classroom_name = $value['classroom_name'];

			if(in_array($classroom_id, $student_class))	{
				$dis_select = "disabled";
			}else{
				$dis_select = " ";
			}

		$str.=<<<HTML
			<option value="$classroom_id" $dis_select>$classroom_name</option>
HTML;
		}

		$str.= '</select>';*/
		//需求修改
		$str = '';
		foreach ($classroom_list as $key => $value) {
			$classroom_id = $value['classroom_id'];
			$classroom_name = $value['classroom_name'];

			if(in_array($classroom_id, $student_class))	{
				$is_check = "checked";
				$dis_abled = "disabled";
			}else{
				$is_check = "";
				$dis_abled = "";
			}

			$course_schedule = explode(',',$value['course_schedule']);

			#找出已读的知识点
			$this->load->model('p_knowledge_model');
			$knowledgeInfo = $this->p_knowledge_model->selectAllKnowledge($course_schedule);

			$knowledge = '&nbsp;&nbsp;&nbsp;';
			foreach ($knowledgeInfo as $k => $v) {
				$knowledge .= $v['knowledge_name'].'，';
			}

			$knowledge = "<font color='blue'>".rtrim($knowledge,"，")."</font>";

		$str.=<<<HTML
			<div>
				<label>
					<input type="checkbox" class="ace" name="class[]" value="$classroom_id" $is_check $dis_abled />
					<span class="lbl">$classroom_name</span>

					<span class="lbl">$knowledge</span>
				</label>	
			</div>
HTML;
		}

		echo json_encode(array('status'=>1, 'data'=>$str));
		exit;
	}
	/**
	 *  安排班级
	 */
	public function arrangeClass()
	{
		if (!empty($_POST)) { 
			/*$classroom_id = $this->input->post('class');
			$student_id = $this->input->post('student_id');
			$data=array(
				'classroom_id'=>$classroom_id,
				'student_id'=>$student_id,
			);
			$result=$this->main_data_model->insert($data,'student_classroom_relation');
			if($result>0){
	  			show_message('操作成功',site_url(module_folder(4).'/student/index'));
	  		}else{
	  			show_message('操作失败！');
	  		}*/
	  		//需求修改
	  		$classroom_id = $this->input->post('class');
			$student_id = $this->input->post('student_id');
			if(empty($classroom_id)){
	  			show_message('请至少选择一个班级');
	  		}

	  		$this->load->model('classroom_model','classroom');
	  		$res = $this->classroom->student_class($student_id);

	  		//已经在的班级的班级类型,目的做复读
	  		$already=array();
	  		foreach ($res as $key => $value) {
	  			$already[]=$value['classroom_type_id'];
	  		}
	  		$already=array_unique($already);

			foreach ($classroom_id as $value) {
				//所报班级的班级类型,目的做复读
				$where_type = array('classroom_id'=>$value);
				$arrange=$this->main_data_model->getOne($where_type,'classroom_type_id','classroom');
				//如果存在就表示复读生
				if(in_array($arrange['classroom_type_id'],$already)){
					$is_first=2;
				}else{
					$is_first=1;
				}

				//查询之前是否在这个班级
				$where = array('student_id'=>$student_id,'classroom_id'=>$value);
				$result = $this->main_data_model->getOne($where,'*','student_classroom_relation');

				//如果在就更新，否则就添加
				if($result){
					$status = array('show_status'=>1,'is_first'=>$is_first);
					$result = $this->main_data_model->update($where,$status,'student_classroom_relation');
				}else{
					$data=array(
						'classroom_id'=>$value,
						'student_id'=>$student_id,
						'show_status'=>1,
						'is_first'=>$is_first
					);
					$result = $this->main_data_model->insert($data,'student_classroom_relation');
				}
			}
			if($result>0){
	  			show_message('操作成功',site_url(module_folder(4).'/student/index'));
	  		}else{
	  			show_message('操作失败！');
	  		}
		}
	}

	/**
	 *  ajax获取学员状态
	 */
	public function studentStatus()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$student_id= $this->input->post("id");

		//查找学员状态
		$where = array('student_id'=>$student_id);
		$student = $this->main_data_model->getOne($where,'student_status,status_remark','student');

		$str = '<select class="form-control" name="student_status">';
		if($student['student_status']==1){
			$str.='<option value="1" selected>就读</option><option value="2">毕业</option><option value="0">休学</option>';
		}elseif ($student['student_status']==2) {
			$str.='<option value="1">就读</option><option value="2" selected>毕业</option><option value="0">休学</option>';	
		}elseif ($student['student_status']==0) {
			$str.='<option value="1">就读</option><option value="2">毕业</option><option value="0" selected>休学</option>';		
		}
		
		$str.= '</select>';

		echo json_encode(array('status'=>1, 'data'=>$str,'remark'=>$student['status_remark']));
		exit;
	}
	/**
	 *  修改学员状态
	 */
	public function editStudentStatus()
	{
		if (!empty($_POST)) {

			$student_id = $this->input->post('student_statusid');
			$student_status = $this->input->post('student_status');
			$status_remark = $this->input->post('status_remark');

			$where = array('student_id'=>$student_id);
			$data = array(
				'student_status'=>$student_status,
				'status_remark'=>$status_remark
			);

			$result=$this->main_data_model->update($where,$data,'student');
			if($result>0){
	  			show_message('操作成功',site_url(module_folder(4).'/student/index'));
	  		}else{
	  			redirect(site_url(module_folder(4).'/student/index'));
	  		}

		}
	}
	/**
	 * 预分配学号列表
	 */
	public function preNumberList()
	{

		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit = 20;
		$start = ($page-1)*$limit;
		
		$this->load->model('consultant_model');
		$pre_student = $this->consultant_model->select_number_index($start,$limit);
		$count = $this->consultant_model->select_number_count();

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		$this->load->model('employee_model','employee');

		foreach($pre_student as $k=>$v){
			#序号
			$pre_student[$k]['serial_number']=$number[$k];

			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('consultant_id'=>$v['consultant_id']));
			$pre_student[$k]['phone']=$this->_dataProcess($tmp,'phone_number');
			
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('consultant_id'=>$v['consultant_id']));
			$pre_student[$k]['qq']=$this->_dataProcess($tmp,'qq_number');

			#员工名字
			$pre_student[$k]['employee'] = $this->employee->select_employee($v['employee_id']);	
		}

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(4)."/student/preNumberList?");
		$config['total_rows'] =$count;
		$config['per_page'] = $limit; 

		$config['num_links'] = 5;
		$config['page_query_string'] = true;
		
		$this->pagination->initialize($config);
		$create_page = $this->pagination->create_links();

		$data=array(
			'list'=>$pre_student,
			'page'=>$create_page,
		);
		$this->load->view('pre_student_list',$data);
	}
	/**
	 * 添加预分配学号
	 */
	public function preNumberAdd()
	{
		if (!empty($_POST)) {

			$con_stu_name = $this->input->post('con_stu_name');
			$con_stu_phone = $this->input->post('con_stu_phone');
			$con_stu_qq = $this->input->post('con_stu_qq');

			#接收
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

  				$con_stu_info = $this->main_data_model->getOne(array('consultant_id'=>$res['consultant_id']),'pre_number','consultant');
  				if($con_stu_info['pre_number']!=''){
  					show_message('已添加此咨询者的预学号');
  				}
  				//如果有结果就往这个咨询者添加学号
  				$this->load->model('consultant_model');
  				$con_pre_number=$this->consultant_model->select_number();

  				$this->load->model('student_model');
  				$student_number=$this->student_model->select_number();
  				//如果不为空就咨询者那里累加,如果为空的话就在学员表哪里累加
  				if(!empty($con_pre_number[0]['pre_number'])){
  					//防止出错,以最大的作为增加的
  					if($con_pre_number[0]['pre_number']>$student_number[0]['student_number']){
  						$number=$con_pre_number[0]['pre_number'];
  					}else{
  						$number=$student_number[0]['student_number'];
  					}
  					//根据年份，自动调用函数加1
	  				$add_number = getYearNum($number);
	  				//$add_number=addManiac($number,1);
	  				$data=array('pre_number'=>$add_number);
	  				$result=$this->main_data_model->update(array('consultant_id'=>$res['consultant_id']),$data,'consultant');
  				}else{
  					//根据年份，自动调用函数加1
	  				$add_number = getYearNum($student_number[0]['student_number']);
	  				//$add_number=addManiac($student_number[0]['student_number'],1);
  					$data=array('pre_number'=>$add_number);
  					$result=$this->main_data_model->update(array('consultant_id'=>$res['consultant_id']),$data,'consultant');
  				}

  			}else{
  				show_message('没有此咨询者');
  			}

  			if($result){
  				show_message('操作成功',site_url(module_folder(4).'/student/preNumberList'));
  			}else{
  				show_message('操作失败');
  			}
		}
	}
	
	public function checkType()
	{ 
		header("Content-Type:text/html;charset=utf-8");

		$type= $this->input->post('type');
		$value= $this->input->post('value');
		
		$arr=array('qq','phones');
		if (!in_array($type,$arr)) {
			//ajax过来的数据错误
			$res['status'] = 0;
			echo json_encode($res);
			die;
		}

		$table='consul_stu_'.$type;
		
		if($type=='phones'){
			$where_join = $table.".phone_number = '".trim($value)."'";
		}else if($type=='qq'){
			$where_join = $table.".qq_number = '".trim($value)."'";
		}

		$where_join.=" AND crm_consultant.show_status = 1";
		
		//查询记录
		$join = array('consultant_name','consultant','consultant.consultant_id = '.$table.'.consultant_id','left');
		$list = $this->main_data_model->select('consultant_id',$where_join,0,0,0,$join,$table);

		if ($list) {
			echo json_encode(array('status'=>1,'consultant_name'=>$list[0]['consultant_name']));
		}else{
			//此咨询者不在表中
			echo json_encode(array('status'=>2));
		}
		die;
	}
	public function checkCert()
	{ 
		header("Content-Type:text/html;charset=utf-8");

		$value = $this->input->post('value');
		$id = $this->input->post('id');
		
		$res=$this->student->check($value,$id);

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
	private function menuProcess($type,$type_data)
	{	
		$url[0]=array('学员列表', site_url(module_folder(4).'/student/index/index/0'));

		#当前页码
		$per_page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		if($type=='index'){	

			#搜索
			$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
			
			#搜索分类
			$key= $this->input->get('key')?$this->input->get('key'):'student_name';

			if($search!=''){
				$url[1]=array('学员搜索',site_url(module_folder(4).'/student/index/index/0?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));
			}else{
				$url[1]=array('学员分页',site_url(module_folder(4).'/student/index/index/0?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));
			}


		}
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');

		setcookie_crm('url',serialize($url));

	}
	/**
	 * qq与phone的数据简单处理
	 */
	private  function _dataProcess($arr,$str)
	{
		$data=array();
		foreach ($arr as $key => $value) {
			$data[]=$value[$str];
		}
		return $data;
	}
	/**
	 * 建立url地址
	 */
	private function _buildUrl($arr,$type,$type_data,$type_url='')
	{
		$param_url = "";
		foreach($arr as $key=>$val){
			if(trim($val)!=''){
				$param_url .= $key."=".$val."&";	
			}
		}
		$param_url = rtrim($param_url, "&");
		
		if($type_url != ''){
			$urls =site_url(module_folder(4)."/student/repeatReadStudent/$type/$type_data?".$param_url);
		}else{
			$urls =site_url(module_folder(4)."/student/index/$type/$type_data?".$param_url);
		}
		
		
		return $urls;
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
				}

			}else{
				$res = array();
			}

		}
	}

	/**
	 * 要复读的学员列表
	 */
	public function repeatReadStudent()
	{
		$data['type'] = $type = $this->uri->segment(5,'index');

		#咨询师
		$this->load->model('p_employee_model');

		$data['teach']= $this->p_employee_model->selectDepartment();

		$data['cur_pag']=$page=$this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=20;
		$start=($page-1)*$limit;

		$param_url=array();

		//选中知识点查询学员
		$data['selected_knownledge']=$selected_knownledge=trim($this->input->get('knowledge_id'))!=''?trim($this->input->get('knowledge_id')):'';

		$param_url['knowledge_id']=$selected_knownledge;

		//查询知识点
		$data['knowledge_info']=$this->main_data_model->getAll('knowledge_id,knowledge_name','knowledge');

		//超级管理员选中的咨询师
		$data['selected_teach']=$selected_teach=trim($this->input->get('teach'))!=''?trim($this->input->get('teach')):'';

		$param_url['teach']=$selected_teach;
			
		#接收分类
		$type = $this->uri->segment(5, 'index');
		$type_data = $this->uri->segment(6, 0);

		#搜索
		$search = trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
		$param_url['search']=$search;

		#搜索分类
		$key = $this->input->get('key')?$this->input->get('key'):'student_name';
		$param_url['key']=$key;

		$this->load->model('student_model','student');
		$this->student->init($selected_teach);
		$this->student->init($selected_knownledge,'k');
		$this->student->init(2,'status'); //要复读的

		$search_key_type=array('student_name','student_education','student_school','student_specialty');
		if (in_array($key,$search_key_type)) {
			$student = $this->student->select_index($start,$limit,$key,$search,'','',$selected_teach);
			$count=$this->student->select_index_count($key,$search);
		}else{
			#通过联系方式查找
			$model="consul_stu_{$key}_model";
			$this->load->model($model,'contact');
			$data=$this->contact->select_student($search);
			$data=$this->_dataProcess($data,'student_id');
			$count=count($data);
			if ($count==0) {
				show_message('没有查询到相关的信息。');
			}
			
			$student=$this->student->select_contact_like($data,$start,$limit);
		}

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		$this->load->model('classroom_model','classroom');

		$this->load->model('employee_model','employee');

		foreach($student as $k=>$v){
			#序号
			$student[$k]['serial_number']=$number[$k];

			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('student_id'=>$v['student_id']));
			$student[$k]['phone']=$this->_dataProcess($tmp,'phone_number');
			
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('student_id'=>$v['student_id']));
			$student[$k]['qq']=$this->_dataProcess($tmp,'qq_number');

			#员工名字
			$student[$k]['employee'] = $this->employee->select_employee($v['employee_id']);	

			#学员所在班级
			$tmp = $this->classroom->student_class($v['student_id']);
			$student[$k]['class']=$this->_dataProcess($tmp,'classroom_name');

			#学生复读的知识点
			$this->load->model('p_knowledge_model');
			$where = array('student_knowleage_relation.study_status'=>2);
			$student[$k]['read_knowledge']=$this->p_knowledge_model->student_knowledge_info($where);
		}

		#分页类
		$this->load->library('pagination');
		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url,$type,$type_data,'repeat');
		$config['total_rows'] =$count;
		$config['per_page'] = $limit; 

		$config['num_links'] = 5;
		$config['page_query_string']=true;
		
		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$data['student_info']=array(
			'count'=>$count,
			'list'=>$student,
			'page'=>$create_page,
		);

		$this->load->view('student_list',$data);
	}
	/**
	 *  权限问题
	 */
	private function _checkPower()
	{
		$login_job = getcookie_crm('employee_job_id');
		$teaching_job = array(4,5,11);
		if(!in_array($login_job, $teaching_job)){
			show_message('你没有此权限',site_url('login/index'));
		}
	}
}