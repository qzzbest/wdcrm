<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生操作
 */
class Teaching_classroom_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
		$this->main_data_model->setTable('classroom');
		$this->load->model('classroom_model','classroom');
		$this->_checkPower();
	}

	public function index()
	{
		#讲师列表
		$this->load->model('employee_model');
		$data['teach']= $this->employee_model->selectDepartment(1);
		#班级类型列表
		$this->load->model('p_classroom_type_model','classroom_type');
		$data['classroom_type']= $this->classroom_type->selectClassType();

		$data['cur_pag']=$page=$this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=20;
		$start=($page-1)*$limit;
	
		//班级状态
		$status = $this->input->get('status')?$this->input->get('status'):'';
		//讲师
		$data['teacher'] = $employee_id = $this->input->get('teacher')?$this->input->get('teacher'):'';
		//班级名称
		$search = $this->input->get('search')?$this->input->get('search'):'';

		#搜索年月
		$selectYear=trim($this->input->get('year'))!=''?trim($this->input->get('year')):'';
		$selectMonth=trim($this->input->get('month'))!=''?trim($this->input->get('month')):'';
		//2014-06
		$start_search_date = $selectYear.'-'.$selectMonth.'-1';
		$end_search_date = $selectYear.'-'.$selectMonth.'-31';

		$start_search_time = strtotime($start_search_date);		
		$end_search_time = strtotime($end_search_date);	
		if($selectYear==''){
			$data['selectYear'] = date('Y',time());
		}else{
			$data['selectYear'] = $selectYear;
		}
		if($selectMonth==''){
			$data['selectMonth'] = date('m',time());
		}else{
			$data['selectMonth'] = $selectMonth;
		}
		//多个查询参数处理
		$param_url=array();

		$param_url['status']=$status;
		$param_url['teacher']=$employee_id;
		$param_url['selectYear']=$selectYear;
		$param_url['selectMonth']=$selectMonth;

		#查找班级类型
		$select_type=trim($this->input->get('classtype'))!=''?trim($this->input->get('classtype')):'';
		$param_url['classtype']=$select_type;

		$data['type'] = $type = $this->uri->segment(5, 'index');
		//$type_data = $this->uri->segment(6, 0);

		$data['all_type'] = $this->main_data_model->getAll('*','classroom_type');
		#导航条处理
		$this->menuProcess();

		#查询班级列表和班级总数
		if($type=='index'){
			$classroom = $this->classroom->select_index($start,$limit,$status,$employee_id,$select_type,$start_search_time,$end_search_time,$search);
			$count = $this->classroom->select_index_count($status,$employee_id,$select_type,$start_search_time,$end_search_time,$search);
		}else{
			$classroom = $this->classroom->select_type_index($start,$limit,$type);
			$count = $this->classroom->select_type_index_count($type);
		}
		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		$this->load->model('employee_model','employee');

		$this->load->model('p_classroom_model');
		$login_job = getcookie_crm('employee_job_id');
		foreach($classroom as $k=>$v){
			#序号
			$classroom[$k]['serial_number']=$number[$k];

			#班级学员总数
			$classroom[$k]['student_count'] = $this->classroom->select_class_student_count($v['classroom_id']);

			#员工名字
			$classroom[$k]['employee'] = $this->employee->select_employee($v['employee_id']);		

			if(in_array($login_job, array(2))){
				#获取班级课程进度
				$where = array('classroom_knowledge_relation.classroom_id'=>$v['classroom_id']);
				$classroom[$k]['cls_known'] = $this->p_classroom_model->classroom_knowledge_info($where,'*');
			}
		}

		#分页类
		$this->load->library('pagination');
		
		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url,$type);

		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 

		$config['num_links'] = 5;
		$config['page_query_string']=true;
		
		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$data['classroom_info']=array(
			'count'=>$count,
			'list'=>$classroom,
			'page'=>$create_page,
			'status'=>$status,
			'select_type'=>$select_type
		);

		$this->load->view('classroom_list',$data);
	}

	public function add()
	{
		
		$check=array(
			array('classroom_name','班级名称'),
			array('class_address','上课地点'),
			array('class_time','上课时间'),
			array('open_classtime','开班日期')
		);
		check_form($check);
			
		if ( $this->form_validation->run() == FALSE){
			$this->load->model('employee_model');
			$data['teach']= $this->employee_model->selectDepartment(1);
			#班级类型列表
			$this->load->model('p_classroom_type_model','classroom_type');
			$data['classroom_type']= $this->classroom_type->selectClassType(1);
			$this->load->view('classroom_add',$data);
	  	}else{

	  		$classroom_name = $this->input->post('classroom_name');
	  		$classroom_group = $this->input->post('classroom_group');
	  		$employee = $this->input->post("employee_id");	
	  		$classroom_type_id = $this->input->post("classroom_type");	
	  		$class_address = $this->input->post("class_address");
			$class_time = $this->input->post("class_time");
			$open_classtime = strtotime($this->input->post("open_classtime"));

			$data = array(
				'classroom_type_id'=>$classroom_type_id,
				'classroom_name'=>$classroom_name,
				'classroom_group'=>$classroom_group,
				'employee_id'=>$employee,
				'class_address'=>$class_address,
				'class_time'=>$class_time,
				'open_classtime'=>$open_classtime
			);

	  		$result = $this->main_data_model->insert($data,'classroom');

	  		#记录班级和知识点关系表
	  		$cls_where = array('classroom_type_id'=>$classroom_type_id);
	  		$cls_known_info = $this->main_data_model->setTable('knowledge')->getOtherAll('*',$cls_where);
	  		foreach ($cls_known_info as $key => $value) {
	  			$cls_known = array('knowledge_id'=>$value['knowledge_id'],'classroom_id'=>$result);
	  			$this->main_data_model->insert($cls_known,'classroom_knowledge_relation');
	  		}

			if($result>0){
				show_message('添加成功！',site_url(module_folder(4).'/classroom/index/index'));	
	  		}else{
	  			show_message('添加失败！');
	  		}
		}

	}

	public function edit()
	{
	
		$check=array(
			array('classroom_name','班级名称'),
			array('class_address','上课地点'),
			array('class_time','上课时间'),
			array('open_classtime','开班日期')
		);
		check_form($check);
			
		if ( $this->form_validation->run() == FALSE){
			$edit = $this->uri->segment(5,0);
			$where = array('classroom_id'=>$edit);
			$data['classroom'] = $this->main_data_model->getOne($where);

			$this->load->model('employee_model');
			$data['teach']= $this->employee_model->selectDepartment(1);
			$this->load->model('p_classroom_type_model','classroom_type');
			$data['classroom_type']= $this->classroom_type->selectClassType(1);
			$this->load->view('classroom_edit',$data);
	  	}else{

	  		$classroom_id = $this->input->post('classroom_id');
	  		$classroom_type_id = $this->input->post('classroom_type');
	  		$classroom_name = $this->input->post('classroom_name');
	  		$classroom_group = $this->input->post('classroom_group');
	  		$employee = $this->input->post("employee_id");	
	  		$class_address = $this->input->post("class_address");
			$class_time = $this->input->post("class_time");
			$open_classtime = strtotime($this->input->post("open_classtime"));
			$close_classtime = $this->input->post("close_classtime");

			if(!empty($close_classtime)){
				$close_classtime = strtotime($close_classtime);
				$class_status = 2;
			}else{
				$close_classtime = NULL;
				$class_status = 1;
			}

			$data = array(
				'classroom_type_id'=>$classroom_type_id,
				'classroom_name'=>$classroom_name,
				'classroom_group'=>$classroom_group,
				'employee_id'=>$employee,
				'class_address'=>$class_address,
				'class_time'=>$class_time,
				'open_classtime'=>$open_classtime,
				'close_classtime'=>$close_classtime,
				'class_status'=>$class_status,
			);

	  		$where_class = array('classroom_id'=>$classroom_id);	
			$result = $this->main_data_model->update($where_class,$data,'classroom');

			if($result>0){
				show_message('修改成功！',site_url(module_folder(4).'/classroom/index/index'));	
	  		}else{
	  			redirect(site_url(module_folder(4).'/classroom/index/index'));
	  		}
		}
	}
	
	public function upgradeClass()
	{
		if(!empty($_POST)){
			//升级班级要不要多一个备注说是哪个班级的
			$classroom_id = $this->input->post('upclass_id');
			$upgrade_name = $this->input->post('upgrade_name');
			$classroom_type_id = $this->input->post('classroom_type_id');

			$where_class=array('classroom_id'=>$classroom_id);
			$old_class = $this->main_data_model->getOne($where_class,'*','classroom');

			//升级班级
			$classroom=array(
				'classroom_name'=>$upgrade_name,
				'old_classroom_name'=>$old_class['classroom_name'],
				'classroom_type_id'=>$classroom_type_id,
				'open_classtime'=>time(),
				'employee_id'=>$old_class['employee_id'],
				'class_address'=>$old_class['class_address'],
				'class_time'=>$old_class['class_time'],
				'classroom_group'=>$old_class['classroom_group'],
				'class_status'=>1,
			);
			$new_class_id = $this->main_data_model->insert($classroom,'classroom');

			#记录班级和知识点关系表
			$cls_where = array('classroom_type_id'=>$classroom_type_id);
			$cls_known_info = $this->main_data_model->setTable('knowledge')->getOtherAll('*',$cls_where);
			foreach ($cls_known_info as $key => $value) {
				$cls_known = array('knowledge_id'=>$value['knowledge_id'],'classroom_id'=>$new_class_id);
				$this->main_data_model->insert($cls_known,'classroom_knowledge_relation');
			}

			//结束以前的班级
			$data=array(
				'class_status'=>2,
				'close_classtime'=>time(),
			);
			$close_class = $this->main_data_model->update($where_class,$data,'classroom');
			//升级班级学生
			$where_class_student = array('classroom_id'=>$classroom_id,'show_status'=>1);
			$old_student = $this->main_data_model->getOtherAll('student_id',$where_class_student,'student_classroom_relation');

			$class_student = array();
			foreach ($old_student as $key => $value) {
				//已经在的班级的班级类型,目的做复读
				$res = $this->classroom->student_class($value['student_id']);
		  		$already=array();
		  		foreach ($res as $val) {
		  			$already[]=$val['classroom_type_id'];
		  		}
		  		$already=array_unique($already);
				//如果存在就表示复读生
				if(in_array($classroom_type_id,$already)){
					$class_student[$key]['is_first']=2;
				}else{
					$class_student[$key]['is_first']=1;
				}

				$class_student[$key]['student_id']=$value['student_id'];
				$class_student[$key]['classroom_id']=$new_class_id;
				$class_student[$key]['show_status']=1;
			}
			$new_student = $this->main_data_model->insert_batch($class_student,'student_classroom_relation');

			show_message('操作成功!',site_url(module_folder(4).'/classroom/index/index'));	
		}
	}

	public function classroomStudent()
	{
		$data['act'] = $act = $this->uri->segment(5,'index');
		$data['classroom_id'] = $classroom_id = $this->uri->segment(6,0);

		#导航处理
		$this->menuProcess($act,$classroom_id);

		$page=$this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=100;
		$start=($page-1)*$limit;

		$data['exam']=$exam = trim($this->input->get('exam'))!=''?trim($this->input->get('exam')):'';
		$data['checkday']=$checkday = trim($this->input->get('checkday'))!=''?trim($this->input->get('checkday')):'';
		$data['checktime']=$checktime = trim($this->input->get('checktime'))!=''?trim($this->input->get('checktime')):'';
		$data['workday']=$workday = trim($this->input->get('workday'))!=''?trim($this->input->get('workday')):'';

		$checkday=strtotime($checkday);
		$workday=strtotime($workday);

		#查询班级列表和班级总数
		$class_student = $this->classroom->select_class_student($classroom_id,$start,$limit);
		$count = $this->classroom->select_class_student_count($classroom_id);

		//查询平均分
		$this->load->model('student_attendance_score_model','student_attendance_score');
		if($exam!=''){
			$exam_score = $this->student_attendance_score->count_all_score($classroom_id,$exam);
			$exam_count = $this->classroom->select_class_student_count($classroom_id,1);
			$data['average']=round($exam_score/$exam_count,2);
		}
		
		#获取班级信息
		$this->load->model('p_classroom_model');
		$where = array('classroom_id'=>$data['classroom_id']);
		$data['classroom_info'] = $this->p_classroom_model->classroom_info($where,'*');

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}
		
		foreach($class_student as $k=>$v){
			#序列号
			$class_student[$k]['serial_number']=$number[$k];

			switch ($act) {
				case 'index':
					#手机号
					$tmp= $this->main_data_model->setTable('consul_stu_phones')
												->select('phone_number',array('student_id'=>$v['student_id']));
				
					$class_student[$k]['phone']=$this->_dataProcess($tmp,'phone_number');
					
					#qq
					$tmp= $this->main_data_model->setTable('consul_stu_qq')
												->select('qq_number',array('student_id'=>$v['student_id']));
					$class_student[$k]['qq']=$this->_dataProcess($tmp,'qq_number');
					break;
				case 'attendance':
					#手机号
					$tmp= $this->main_data_model->setTable('consul_stu_phones')
												->select('phone_number',array('student_id'=>$v['student_id']));
				
					$class_student[$k]['phone']=$this->_dataProcess($tmp,'phone_number');
					
					#qq
					$tmp= $this->main_data_model->setTable('consul_stu_qq')
												->select('qq_number',array('student_id'=>$v['student_id']));
					$class_student[$k]['qq']=$this->_dataProcess($tmp,'qq_number');

					#考勤
					$class_student[$k]['attendance']=$this->student_attendance_score->select_attendance($v['student_id'],$data['classroom_id'],$checkday,$checktime);
					break;
				case 'homework':
					$class_student[$k]['homework']=$this->student_attendance_score->select_homework($v['student_id'],$data['classroom_id'],$workday);
					break;
				case 'exam':
					$class_student[$k]['score']=$this->student_attendance_score->select_score($v['student_id'],$data['classroom_id'],$exam);
					break;
			}
		}
		if(isset($_SERVER['HTTP_REFERER'])){
			$data['location']=$_SERVER['HTTP_REFERER'];//跳转地址
		}else{
			$data['location']=site_url(module_folder(4).'/classroom/classroomStudent/index/'.$classroom_id);	
		}
		#获取班级下面的知识点
		$class_knownledge = $this->classKnownledge($data['classroom_id']);

		#找出已读的知识点
		// $course_schedule = explode(',',$data['classroom_info']['course_schedule']);

		// foreach ($class_knownledge as $key => $value) {
		// 	if(in_array($value['knowledge_id'], $course_schedule)){
		// 		$class_knownledge[$key]['complete'] = 1;
		// 	}else{
		// 		$class_knownledge[$key]['complete'] = 0;
		// 	}
		// }

		$data['class_knownledge'] = $class_knownledge;

		#分页类
		$this->load->library('pagination');
		$config['base_url']=site_url(module_folder(4)."/classroom/classroomStudent/$act/$classroom_id?");
		$config['total_rows'] =$count;
		$config['per_page'] = $limit; 

		$config['num_links'] = 5;
		$config['page_query_string']=true;
		
		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		//成绩类型表查询
		$where_type=array('classroom_type_id'=>$data['classroom_info']['classroom_type_id']);
		$data['all_exam']=$this->main_data_model->getOtherAll('*',$where_type,'knowledge_exam');

		$data['class_student_info']=array(
			'count'=>$count,
			'list'=>$class_student,
			'page'=>$create_page,
		);

		$this->load->view('classroom_student_list',$data);
	}
	/**
	 * 删除班级学生
	 */
	/*public function deleteClassroomStudent()
	{	
		$student_id = $this->input->post('id');
		$classroom_id = $this->input->post('class_id');

		#批量删除某个班的学员
		$result = $this->classroom->delete_class_student($student_id,$classroom_id);
		
		if($result>0){
  			show_message('删除成功!',site_url(module_folder(4).'/classroom/classroomStudent/index/'.$classroom_id));	
  		}else{
  			show_message('操作失败!');
  		}
	}*/
	/**
	 * 虚拟删除班级学生
	 */
	public function deleteClassroomStudent()
	{	
		$student_id = $this->input->post('id');
		$classroom_id = $this->input->post('class_id');

		#批量删除某个班的学员
		$status = array('show_status'=>0);
		$result = $this->classroom->change_status($student_id,$classroom_id,$status);

		if($result>0){
  			show_message('删除成功!',site_url(module_folder(4).'/classroom/classroomStudent/index/'.$classroom_id));	
  		}else{
  			show_message('操作失败!');
  		}
	}

	/**
	 *  班级结课
	 */
	public function closeClass()
	{
		if (!empty($_POST)) { 

			$classroom_id = $this->input->post('classroom_id');
			$close_classtime = $this->input->post('close_classtime');

			$where_class = array('classroom_id'=>$classroom_id);
			$data=array(
				'class_status'=>2,
				'close_classtime'=>strtotime($close_classtime),
			);

			$result = $this->main_data_model->update($where_class,$data,'classroom');

			if($result>0){
	  			show_message('操作成功',site_url(module_folder(4).'/classroom/index/index'));
	  		}else{
	  			show_message('操作失败！');
	  		}
		}
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
		$classroom_list = $this->main_data_model->getOtherAll('classroom_id,classroom_name',$where,'classroom');
		//查找学生已经所在的班级
		$this->load->model('classroom_model','classroom');
		$student_class = $this->classroom->student_classid($student_id);

		$str = '<select class="form-control" name="class" required><option value="">请选择班级</option>';

		foreach ($classroom_list as $key => $value) {
			$classroom_id = $value['classroom_id'];
			$classroom_name = $value['classroom_name'];

			if(in_array($classroom_id, $student_class))	{
				$dis_select = "disabled style='color:#ff0000;'";
			}else{
				$dis_select = " ";
			}

		$str.=<<<HTML
			<option value="$classroom_id" $dis_select>$classroom_name</option>
HTML;
		}

		$str.= '</select>';

		echo json_encode(array('status'=>1, 'data'=>$str));
		exit;
	}
	/**
	 *  学员转班
	 */
	public function changeClass()
	{
		if (!empty($_POST)) { 
			$student_id = $this->input->post('student_id');
			$class_ago = $this->input->post('class_ago');
			$class = $this->input->post('class');
			$change_reason = $this->input->post('change_reason');

			//虚拟删除原来的班级
			$old_class = array('student_id'=>$student_id,'classroom_id'=>$class_ago);
			$reason = array('show_status'=>0,'change_reason'=>$change_reason);
			$this->main_data_model->update($old_class,$reason,'student_classroom_relation');

			$res = $this->classroom->student_class($student_id);
	  		//已经在的班级的班级类型,目的做复读
	  		$already=array();
	  		foreach ($res as $key => $value) {
	  			$already[]=$value['classroom_type_id'];
	  		}
	  		$already=array_unique($already);
			//所报班级的班级类型,目的做复读
			$where_type = array('classroom_id'=>$class);
			$arrange=$this->main_data_model->getOne($where_type,'classroom_type_id','classroom');
			//如果存在就表示复读生
			if(in_array($arrange['classroom_type_id'],$already)){
				$is_first=2;
			}else{
				$is_first=1;
			}

			//查询之前是否在这个班级
			$new_class = array('student_id'=>$student_id,'classroom_id'=>$class);
			$result = $this->main_data_model->getOne($new_class,'*','student_classroom_relation');
			//存在的话就更新，否则就添加
			if($result){
				$status = array('show_status'=>1,'is_first'=>$is_first);
				$res1 = $this->main_data_model->update($new_class,$status,'student_classroom_relation');
			}else{
				$data=array(
					'student_id'=>$student_id,
					'classroom_id'=>$class,
					'show_status'=>1,
					'is_first'=>$is_first
				);
				$res1 = $this->main_data_model->insert($data,'student_classroom_relation');
			}
			

			if($res1>0){
	  			show_message('操作成功',site_url(module_folder(4).'/classroom/classroomStudent/index/'.$class_ago));
	  		}else{
	  			show_message('操作失败！');
	  		}
		}
	}
	/**
	 *  有无电脑
	 */
	public function isComputer()
	{
		$id=$this->input->post('id');
		$is_computer=$this->input->post('is_computer');
		
		$where=array('student_id'=>$id);
		$data=array('is_computer'=>intval($is_computer));

		$res = $this->main_data_model->update($where,$data,'student');
		if ($res>0) {
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}

		die;
	}
	/**
	 *  批量记录考勤
	 */
	public function attendanceAdd()
	{
		if(!empty($_POST)){
			$classroom_id = $this->input->post('classroom_id');
			$student_id = $this->input->post('check_student');
			$record_time = $this->input->post('check_day');
			$time_part = $this->input->post('check_time');
			$student_attendance_status = $this->input->post('check_status');
			$student_attendance_desc = $this->input->post('remark');
			$record_video = $this->input->post('record_video');
			$record_knowledge = $this->input->post('record_knowledge');

			//跳转地址
			$location=$this->input->post('location');
			//判断有没有选中学生
			if(empty($student_id)){
				show_message('请选择要记录考勤的学生');
			}

			$all_student=explode(',', $student_id);

			foreach ($all_student as $value) {
				$where = array(
					'student_id'=>$value,
					'classroom_id'=>$classroom_id,
					'record_time'=>strtotime($record_time),
					'time_part'=>$time_part
				);
				$res = $this->main_data_model->getOne($where,'*','student_attendance_score');

				if($res){
					$update_data = array(
						'student_attendance_status'=>$student_attendance_status,
						'student_attendance_desc'=>$student_attendance_desc
					);
					$result = $this->main_data_model->update($where,$update_data,'student_attendance_score');
				}else{
					$insert_data = array(
						'classroom_id'=>$classroom_id,
						'student_id'=>$value,
						'record_time'=>strtotime($record_time),
						'time_part'=>$time_part,
						'student_attendance_status'=>$student_attendance_status,
						'student_attendance_desc'=>$student_attendance_desc,
					);
					$result = $this->main_data_model->insert($insert_data,'student_attendance_score');
				}
				//录制视频
				if($record_video==1 && !empty($record_knowledge)){
					$video = array(
						'student_id'=>$value,
						'knowledge'=>$record_knowledge,
						'record_time'=>strtotime($record_time),
					);
					$this->main_data_model->insert($video,'student_video');
				}
			}

			if($result){
	  			show_message('操作成功',$location);
	  		}else{
	  			show_message('操作失败！');
	  		}
		}
	}
	/**
	 *  ajax修改成绩
	 */
	public function studentScore(){
		
		$student_id = $this->input->post('student_id');
		$classroom_id = $this->input->post('classroom_id');
		$exam_id = $this->input->post('exam_id');
		$student_score = $this->input->post('student_score');

		$where=array('student_id'=>$student_id,'classroom_id'=>$classroom_id,'exam_id'=>$exam_id,'is_exam'=>1);

		$count = $this->main_data_model->count($where,'student_attendance_score');
		
		//查询是更新还是插入操作
		if($count>0){
			$update_score = array('student_score'=>$student_score);
			$res = $this->main_data_model->update($where,$update_score,'student_attendance_score');
		}else{
			$insert_score = array(
				'student_id'=>$student_id,
				'classroom_id'=>$classroom_id,
				'is_exam'=>1,
				'exam_id'=>$exam_id,
				'student_score'=>$student_score,
			);
			$res = $this->main_data_model->insert($insert_score,'student_attendance_score');
		}
		
		if ($res>0) {
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
	}
	/**
	 *  ajax修改作业
	 */
	public function studentHomeworkScore(){
		
		$student_id = $this->input->post('student_id');
		$classroom_id = $this->input->post('classroom_id');
		$homework_score = $this->input->post('homework_score');
		$hw_remark = $this->input->post('hw_remark');
		$hw_day = $this->input->post('hw_day');

		$where=array('student_id'=>$student_id,'classroom_id'=>$classroom_id,'record_time'=>strtotime($hw_day),'time_part'=>0);

		$count = $this->main_data_model->count($where,'student_attendance_score');
		
		//查询是更新还是插入操作
		if($count>0){
			$update_score = array('student_score'=>$homework_score,'student_score_desc'=>$hw_remark);
			$res = $this->main_data_model->update($where,$update_score,'student_attendance_score');
		}else{
			$insert_score = array(
				'student_id'=>$student_id,
				'classroom_id'=>$classroom_id,
				'student_score'=>$homework_score,
				'record_time'=>strtotime($hw_day),
				'student_score_desc'=>$hw_remark,
				'is_exam'=>0,
			);
			$res = $this->main_data_model->insert($insert_score,'student_attendance_score');
		}
		
		if ($res>0) {
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
	}
	/**
	 *  知识点记录/课程进度
	 */
	public function classCourseSchedule()
	{	
		$course_id = $this->input->post('course_id');
		$classroom_id = $this->input->post('classroom_id');
		$cls_konwid = $this->input->post('cls_konwid');
		$type = $this->input->post('type');

		#获取班级信息
		$this->load->model('p_classroom_model');
		$this->load->model('p_knowledge_model');
		$this->load->model('p_classroom_student_model');

		switch ($type) {
			case 0: #操作未读状态
				$schedule_state = 1;
				//更新该班级所有学生的课程就读情况（已读）	
 				$data_knowledge = array('study_status'=>3);
 				$attended_status = 3;#就读状态
				break;
			case 1: #操作正在读状态
				$schedule_state = 2;
				//更新该班级所有学生的课程就读情况（未读）
				$data_knowledge = array('study_status'=>1);
				$attended_status = 1;#就读状态
				break;
			case 2: #操作已读状态
				$schedule_state = 0;
				//更新该班级所有学生的课程就读情况（未读）
				$data_knowledge = array('study_status'=>0);
				$attended_status = 0;#就读状态
				break;
			
			default:
				# code...
				break;
		}
		$u_where = array('id'=>$cls_konwid);
		$u_data = array('schedule_state'=>$schedule_state);
		$this->main_data_model->setTable('classroom_knowledge_relation')->update($u_where,$u_data);

		$where_classroom = array('classroom_id'=>$classroom_id);
		$class_student = $this->p_classroom_student_model->classroom_student_info($where_classroom,'*');

		$stu_ids = array();
		foreach ($class_student as $key => $value) {
			$stu_ids[] = $value['student_id'];
		}
		
		$where_in = $stu_ids;

		if(!empty($stu_ids)){
			$where_knowledge = array('knowledge_id'=>$course_id);
			$this->p_knowledge_model->update_student_knowledge($where_knowledge,$where_in,$data_knowledge);

			#记录到“学生就读记录表”中
			$this->load->model('p_knowledge_model');
			$this->load->model('p_student_model');
			foreach ($stu_ids as $key => $value) {
				$where = array('student_id'=>$value,'knowledge_id'=>$course_id);
				$result = $this->p_knowledge_model->selectStudentKnowledge($where);
				if($result){
					$where_attended = array('classroom_id'=>$classroom_id,'relation_id'=>$result['id']);
					$attended_result = $this->p_student_model->selectAttendedRecord($where_attended);
					if($attended_result){
						#做更新
						$edit_where = array('attended_record_id'=>$attended_result['attended_record_id']);
						$editAttended = array('attended_status'=>$attended_status);
						$this->p_student_model->editAttendedRecord($edit_where,$editAttended);
					}else{
						#做插入
						$addAttended = array(
							'classroom_id'=>$classroom_id,
							'relation_id'=>$result['id'],
							'attended_status'=>$attended_status
						);
						$this->p_student_model->addAttendedRecord($addAttended);
					}			
				}
			}
		}

		echo json_encode(array('status'=>1));
	}

	/**
	 *  学生录制视频列表
	 */
	public function studentVideo()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$student_id= $this->input->post("id");

		$where=array('student_id'=>$student_id);
		$video_list = $this->main_data_model->getOtherAll('*',$where,'student_video');
		$video_count = $this->main_data_model->count($where,'student_video');

		$str="<div>共<span style='color:#ff0000'>".$video_count."</span>个视频</div>";
		$str.="<table border='1'>";
		$str.="<tr>";
		$str.="<th width='80px' align='center'>时间</th><th width='80px' align='center'>知识点</th>	</td>";
		$str.="</tr>";

		foreach($video_list as $item){
			$str.="<tr>";
			$str.="<td>".date('Y-m-d',$item['record_time'])."</td><td>".$item['knowledge']."</td>";
			$str.="</tr>";
		}

		$str.="</table>";

		$msg = "此学生暂无视频录制记录";

		if($video_list){
			echo json_encode(array('status'=>1, 'data'=>$str));	
		}else{
			echo json_encode(array('status'=>0, 'data'=>$msg));	
		}
		exit;
	}
	/**
	 * 导出考勤表
	 */
	public function attendanceExport()
	{
		
		$classroom_id = $this->uri->segment(5);
		//班级信息
		$class_info = $this->classroom->select_one($classroom_id);

		$info = '班级: '.$class_info['classroom_name'].'   开班时间: '.$class_info['open_classtime'].'   上课时间: '.$class_info['class_time'].'   上课地点: '.$class_info['class_address'].'   讲师: '.$class_info['employee_name'];

		//班级学生列表
		$class_student = $this->classroom->select_class_student($classroom_id,0,100);

		//加载phpexcel类
		$this->load->library('excel/PHPExcel.php');
		//$this->load->library('excel/PHPExcel/Writer/Excel5.php');
		$resultPHPExcel = new PHPExcel(); 
		 
		//合并单元格
		$resultPHPExcel->getActiveSheet()->mergeCells('A1:S1');
		$resultPHPExcel->getActiveSheet()->mergeCells('A2:D2');
		$resultPHPExcel->getActiveSheet()->mergeCells('E2:H2');
		$resultPHPExcel->getActiveSheet()->mergeCells('I2:M2');
		$resultPHPExcel->getActiveSheet()->mergeCells('N2:S2');
		//设置参数 设值
		$resultPHPExcel->getActiveSheet()->setCellValue('A1', $info); 
		$resultPHPExcel->getActiveSheet()->setCellValue('A2', '出勤：√');
		$resultPHPExcel->getActiveSheet()->setCellValue('E2', '请假：△');
		$resultPHPExcel->getActiveSheet()->setCellValue('I2', '迟到：○');
		$resultPHPExcel->getActiveSheet()->setCellValue('N2', '旷课：×');

		$resultPHPExcel->getActiveSheet()->setCellValue('A3', '序号'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('B3', '学号'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('C3', '姓名'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('D3', '性别'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('E3', '联系电话'); 
		$resultPHPExcel->getActiveSheet()->setCellValue('F3', 'QQ'); 

		//设置边框
		$styleArray = array(  
	        'borders' => array(  
	            'allborders' => array(  
	                //'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的  
	                'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框  
	                //'color' => array('argb' => 'FFFF0000'),  
	            ),  
	        ),  
	    );  
		
		$i = 4;
		$j = 1;
		foreach($class_student as $item){ 
			if ($item['student_sex']==1) {
			 	$sex = '男';
			}else if($item['student_sex']==2){
			 	$sex = '女';
			}else{
			 	$sex = '';
			}
			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('student_id'=>$item['student_id']));
			$phone=implode($this->_dataProcess($tmp,'phone_number'),',');
			
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('student_id'=>$item['student_id']));
			$qq=implode($this->_dataProcess($tmp,'qq_number'),',');

			$computer= $this->main_data_model->setTable('student')
										->getOne(array('student_id'=>$item['student_id']),'is_computer');

			$resultPHPExcel->getActiveSheet()->setCellValue('A' . $i, $j); 
			$resultPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item['student_number']); 
			$resultPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item['student_name']);
			$resultPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sex); 
			$resultPHPExcel->getActiveSheet()->setCellValue('E' . $i, $phone); 
			$resultPHPExcel->getActiveSheet()->setCellValue('F' . $i, $qq);

			//设置边框
			$resultPHPExcel->getActiveSheet()->getStyle('A1'.':S' . $i)->applyFromArray($styleArray);
			//居中
			$resultPHPExcel->getActiveSheet()->getStyle('A1'.':S' . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//复读生加背景颜色
			if($item['is_first']==2){
				$resultPHPExcel->getActiveSheet()->getStyle('B' . $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$resultPHPExcel->getActiveSheet()->getStyle('B' . $i)->getFill()->getStartColor()->setARGB('FFEC8B');
			}
			//自带电脑
			if($item['is_computer']==1){
				$resultPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$resultPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFill()->getStartColor()->setARGB('FFEC8B');
			}
			//设置字体
			$resultPHPExcel->getActiveSheet()->getStyle('A1'.':S' . $i)->getFont()->setName('宋体');
			$resultPHPExcel->getActiveSheet()->getStyle('A2'.':S' . $i)->getFont()->setSize(12);

			$i ++; 
			$j ++;
		}

		//设置宽度
		$resultPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$resultPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$resultPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
		$resultPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$resultPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$resultPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		//设置字体
		
		$resultPHPExcel->getActiveSheet()->getStyle('A1:S3')->getFont()->setBold(true);
		

		//设置样式
		$resultPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$resultPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('FFEC8B');

		//文件命名
		$outputFileName = $class_info['classroom_name'].'.xls'; 
		$xlsWriter = new PHPExcel_Writer_Excel5($resultPHPExcel); 
		
		header("Content-Type: application/force-download"); 
		header("Content-Type: application/octet-stream"); 
		header("Content-Type: application/download"); 
		header('Content-Disposition:inline;filename="'.$outputFileName.'"'); 
		header("Content-Transfer-Encoding: binary"); 
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Pragma: no-cache"); 
		$xlsWriter->save( "php://output" );

	}
	/**
	 * 导航条处理
	 */
	private function menuProcess($act='',$classroom_id='')
	{	
		$url[0]=array('班级列表', site_url(module_folder(4).'/classroom/index/index/'));
		$classroom_id = $this->uri->segment(6,0);

		#当前页码
		$per_page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		$status = $this->input->get('status')?$this->input->get('status'):'';
		//讲师
		$employee_id = $this->input->get('teacher')?$this->input->get('teacher'):'';

		#搜索年月
		$selectYear=trim($this->input->get('year'))!=''?trim($this->input->get('year')):'';
		$selectMonth=trim($this->input->get('month'))!=''?trim($this->input->get('month')):'';
		
		//if($type=='index'){
			if($status!='' || $employee_id!='' || $selectYear!='' || $selectMonth!=''){
				$url[1]=array('班级搜索',site_url(module_folder(4).'/classroom/index/index?'.'status='.$status.'&teacher='.$employee_id.'&year='.$selectYear.'&month='.$selectMonth.'&per_page='.$per_page));
			}else{
				$url[1]=array('班级分页',site_url(module_folder(4).'/classroom/index/index?'.'status='.$status.'&teacher='.$employee_id.'&year='.$selectYear.'&month='.$selectMonth.'&per_page='.$per_page));
			}
		/*}else{

			$where_type = array('classroom_type_id'=>$type);
			$class_type = $this->main_data_model->getOne($where_type,'*','classroom_type');
			
			$url[1]=array($class_type['classroom_type_name'].'分页',site_url(module_folder(4).'/classroom/index/'.$type.'?&per_page='.$per_page));
		}*/

		if($act!='' && $classroom_id!=''){
			$exam = trim($this->input->get('exam'))!=''?trim($this->input->get('exam')):'';
			$checkday = trim($this->input->get('checkday'))!=''?trim($this->input->get('checkday')):'';
			$checktime = trim($this->input->get('checktime'))!=''?trim($this->input->get('checktime')):'';
			$workday = trim($this->input->get('workday'))!=''?trim($this->input->get('workday')):'';

			if($act=='attendance'){
				$url[2]=array('考勤记录',site_url(module_folder(4).'/classroom/classroomStudent/'.$act.'/'.$classroom_id.'?checkday='.$checkday.'&checktime='.$checktime));
			}else if($act=='homework'){
				$url[2]=array('作业记录',site_url(module_folder(4).'/classroom/classroomStudent/'.$act.'/'.$classroom_id.'?workday='.$workday));
			}else if($act=='exam'){
				$url[2]=array('成绩列表',site_url(module_folder(4).'/classroom/classroomStudent/'.$act.'/'.$classroom_id.'?exam='.$exam));
			}else{
				$url[2]=array('学生列表',site_url(module_folder(4).'/classroom/classroomStudent/'.$act.'/'.$classroom_id));
			}
			
		}
		

		$_COOKIE['url']= authcode(serialize($url),'ENCODE');

		setcookie_crm('url',serialize($url));

	}
	/**
	 *  获取班级下面的知识点
	 */
	private function classKnownledge($classroom_id)
	{
		$this->load->model('p_classroom_model');
		$this->load->model('classroom_model');
		
		$where = array('classroom_id'=>$classroom_id);
		$cls_known = $this->main_data_model->setTable('classroom_knowledge_relation')->getOtherAll('*',$where);

		foreach ($cls_known as $key => $value) {
			$k_where = array('knowledge_id'=>$value['knowledge_id']);
			$knowledge_info = $this->main_data_model->setTable('knowledge')->getOne($k_where,'*');
			$cls_known[$key]['knowledge_name'] = $knowledge_info['knowledge_name'];
			$cls_known[$key]['knowledge_lesson'] = $knowledge_info['knowledge_lesson'];
		}

		return $cls_known;
	}
	/**
	 *  验证班级名称是否重复
	 */
	public function check(){
		header("Content-Type:text/html;charset=utf-8");

		$value = $this->input->post('value');
		$id = $this->input->post('id');
		
		$res=$this->classroom->check($value,$id);

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}

	private function _dataProcess($arr,$str)
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
	private function _buildUrl($arr,$type)
	{

		$param_url = "";
		foreach($arr as $key=>$val){
			if(trim($val)!=''){
				$param_url .= $key."=".$val."&";	
			}
		}
		$param_url = rtrim($param_url, "&");
		
		
		$urls =site_url(module_folder(4)."/classroom/index/$type?".$param_url);
		
		return $urls;
	}
	/**
	 *  权限问题
	 */
	private function _checkPower()
	{
		$login_job = getcookie_crm('employee_job_id');
		$teaching_job = array(2,4,5,11);
		if(!in_array($login_job, $teaching_job)){
			show_message('你没有此权限',site_url('login/index'));
		}
	}
}