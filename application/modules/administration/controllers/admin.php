<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理员操作
 */
class Administration_admin_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('employee');
	}

	public function index()
	{
		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=10;
		$start=($page-1)*$limit;
		$field='*';

		$param_url=array();
		//超级管理员选中的咨询师
		$selected_job=trim($this->input->get('job'))!=''?trim($this->input->get('job')):'';

		$this->load->model('employee_model');
		//查询管理员列表
		$list= $this->employee_model->select_index($start,$limit,$selected_job);
		$count= $this->employee_model->select_index_count($selected_job);
		//查询职位
		$employee_job=$this->main_data_model->getAll('*','employee_job');

		#分页类
		$this->load->library('pagination');
		if($selected_job===''){
			$config['base_url'] = site_url(module_folder(1).'/admin/index?');
		}else{
			$config['base_url'] = site_url(module_folder(1).'/admin/index?job='.$selected_job);
		}
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['num_links'] = 4;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$data=array(
			'list'=>$list,
			'employee_job'=>$employee_job,
			'create_page'=>$create_page,
			'selected_job'=>$selected_job
			);
		$this->load->view('admin_list',$data);
	}
	
	public function add()
	{
		$check=array(
			array('username','用户名'),
			array('password','密 码'),
			array('pwdconfirm','确认密码')
		);
		check_form($check);
		if ($this->form_validation->run() == FALSE){
			if(getcookie_crm('employee_power')==1){
				$where_join = "employee.employee_power = ".getcookie_crm('employee_power');
				$join = array('employee_job_id','employee_job','employee_job.employee_job_id = employee.employee_job_id','left');
				$employee_info = $list = $this->main_data_model->select('employee_id',$where_join,0,0,0,$join,'employee');
				$where = "employee_job_id != ".$employee_info[0]['employee_job_id'];
				$data['role']=$this->main_data_model->getOtherAll('*',$where,'employee_job');
				
			}else{
				$data['role']=$this->main_data_model->getAll('*','employee_job');
			}
			$data['department']=$this->main_data_model->getAll('*','department');
			$data['province'] = $this->main_data_model->getOtherAll('*',array('parent_id'=>1),'region');

	   		$this->load->view('admin_add',$data);
	  	}else{
	  		//echo "<pre>";
	  		//print_r($_POST);die;
	  		#接收通讯录信息	
			$phones_data= $this->input->post("emplpyee_phone");	//手机
			$work_phone= $this->input->post("phone_hide");		//是否是工作手机

	  		$qq_data= $this->input->post("emplpyee_qq");		//QQ
	  		$work_qq= $this->input->post("qq_hide");			//是否是工作QQ

	  		$email_data= $this->input->post("emplpyee_email");	//邮箱
	  		$work_email= $this->input->post("email_hide");		//是否是工作邮箱

	  		$weixin_data= $this->input->post("emplpyee_weixin");//微信

	  		#接收用户名密码
			$data['admin_name'] = $this->input->post("username");	//用户名
			$password = $this->input->post("password");				//密码
			$pwdconfirm = $this->input->post("pwdconfirm");			//确认密码
			$data['employee_name'] = $this->input->post("pname");	//真实姓名
			$data['mark_power'] = $this->input->post("mark_power");	//权限（评分方面）

			

			#接收基本信息
			$data['department_id'] = $this->input->post("department");	//部门
			$data['employee_job_id'] = $this->input->post("role");		//角色
			$data['employee_telephone'] = $this->input->post("telephone");	//电话
			$data['employee_sex'] = $this->input->post("sex");				//性别
			$data['identity_card_number'] = $this->input->post("id_card");	//身份证
			$year = $this->input->post("selectYear");				//年
			$month = $this->input->post("selectMonth");				//月
			$day = $this->input->post("selectDay");					//日
			$data['birthday'] = strtotime($year.'-'.$month.'-'.$day);	//出生日期
			$data['province'] = $this->input->post("province");		//省
			$data['city'] = $this->input->post("city");				//市
			$data['area'] = $this->input->post("sc");				//区/县
			$data['is_marry'] = $this->input->post("is_marry");		//婚姻状况
			$data['employee_education'] = $this->input->post("education");	//学历
			$data['employee_major'] = $this->input->post("specialty");		//专业
			$data['graduate_institutions'] = $this->input->post("school");			//毕业学校
			$data['employed_date'] = strtotime($this->input->post("entry_time"));	//入职时间


			#判断用户名是否存在
			$user=$this->main_data_model->getAll("admin_name");			
			for($i=0;$i<count($user);$i++){
				if($user[$i]['admin_name'] == $data['admin_name']){
					show_message('用户名已存在');
				}
			}
			#判断密码和确认密码是否一致
			if($password != $pwdconfirm){
				show_message('密码和确认密码不一致');
			}
			$data['admin_password'] = md5($pwdconfirm);	//密码
		
			if($data['employee_job_id']==19){#人事、就业权限
				$data['employee_power'] = 2;	//评分权限
			}

			#返回插入的员工id		
	  		$result = $this->main_data_model->insert($data);

	  		if($result>0){
	  			#手机号码处理
	  			$phones_data=array_unique($phones_data);
				foreach ($phones_data as $k=>$v) {
					$v= trim($v);
					if($v!=''){
						$where=array('employee_phone_number'=>$v);
						//重复即不在插入
						if($this->main_data_model->count($where,'employee_phone')>1){continue;};
						$insert_phone=array();
						$insert_phone['employee_id']=$result;
						$insert_phone['employee_phone_number']=$v;
						$insert_phone['is_workphone']=$work_phone[$k];
						$this->main_data_model->insert($insert_phone,'employee_phone');
					}
				}

	  			#qq处理
	  			$qq_data=array_unique($qq_data);
				foreach ($qq_data as $k=>$v) {
					$v= trim($v);
					if($v!=''){
						$where=array('employee_qq'=>$v);
						//重复即不在插入
						if($this->main_data_model->count($where,'employee_qq')>1){continue;};
						$insert_qq=array();
						$insert_qq['employee_id']=$result;
						$insert_qq['employee_qq']=$v;
						$insert_qq['is_workqq']=$work_qq[$k];
						$this->main_data_model->insert($insert_qq,'employee_qq');
					}
				}
				
				#email处理
	  			$email_data=array_unique($email_data);
				foreach ($email_data as $k=>$v) {
					$v= trim($v);
					if($v!=''){
						$where=array('employee_email_number'=>$v);
						//重复即不在插入
						if($this->main_data_model->count($where,'employee_email')>1){continue;};
						$insert_email=array();
						$insert_email['employee_id']=$result;
						$insert_email['employee_email_number']=$v;
						$insert_email['is_workemail']=$work_email[$k];
						$this->main_data_model->insert($insert_email,'employee_email');
					}
				}

				#微信处理
	  			$weixin_data=array_unique($weixin_data);
				foreach ($weixin_data as $v) {
					$v= trim($v);
					if($v!=''){
						$where=array('employee_weixin_number'=>$v);
						//重复即不在插入
						if($this->main_data_model->count($where,'employee_weixin')>1){continue;};
						$insert_weixin=array();
						$insert_weixin['employee_id']=$result;
						$insert_weixin['employee_weixin_number']=$v;
						$this->main_data_model->insert($insert_weixin,'employee_weixin');
					}
				}
			}
			
			redirect(module_folder(1).'/admin/index');	
		}	
	}

	public function edit()
	{
		if(isset($_POST['dosubmit'])){
			$id = $this->input->post('id');
			$password = $this->input->post("password");
			$pwdnew = $this->input->post("pwdnew");
			/*$pwdconfirm = $this->input->post("pwdconfirm");*/
			$pname = $this->input->post("pname");
			$role = $this->input->post("role");
			$mark_power = $this->input->post("mark_power");

			$user=$this->main_data_model->getOne("employee_id = '{$id}'");
			//如果密码为空就默认原来的密码
			if(isset($password) && !empty($password)){
				/*if($user['admin_password'] != md5($password)){
					show_message('原密码错误');
				}*/
				if($password !== $pwdnew){
					show_message('密码和确认密码不一致');
				}
				$pw_md5=md5($pwdnew);
			}else{
				$pw_md5=$user['admin_password'];
			}
			
			$data=array(
				'admin_password'=>$pw_md5,
				'employee_name'=>$pname,
			);

			if($role){
				$data['employee_job_id'] = $role;
			}
			if($mark_power){
				$data['mark_power'] = $mark_power;
			}
			
	  		$this->main_data_model->update("employee_id = '{$id}'",$data);
			redirect(module_folder(1).'/admin/index');
		}
		

		$employee_id = $this->uri->segment(5,0);	
		$where = array('employee_id'=>$employee_id);

		#员工基本信息
		$info = $this->main_data_model->getOne($where);

		#员工phone
		$employee_phone = $this->main_data_model->setTable('employee_phone')->getOtherAll('*',$where);

		#员工qq
		$employee_qq = $this->main_data_model->setTable('employee_qq')->getOtherAll('*',$where);

		#员工email
		$employee_email = $this->main_data_model->setTable('employee_email')->getOtherAll('*',$where);

		#员工微信
		$employee_weixin = $this->main_data_model->setTable('employee_weixin')->getOtherAll('*',$where);

		#部门
		$data['department']=$this->main_data_model->getAll('*','department');	
		#省
		$data['province'] = $this->main_data_model->getOtherAll('*',array('parent_id'=>1),'region');
		#市
		$data['city'] = $this->main_data_model->getOtherAll('*',array('parent_id'=>$info['province']),'region');
		#县
		$data['area'] = $this->main_data_model->getOtherAll('*',array('parent_id'=>$info['city']),'region');

		$data['info'] = $info;
		$data['employee_phone1']= array_shift($employee_phone);
		$data['employee_phone'] = $employee_phone;
		//print_r($data['employee_phone1']);
		$data['employee_qq1']   = array_shift($employee_qq);
		$data['employee_qq']    = $employee_qq;
		$data['employee_email1']= array_shift($employee_email);
		$data['employee_email'] = $employee_email;
		$data['employee_weixin1']= array_shift($employee_weixin);
		$data['employee_weixin'] = $employee_weixin;

		if(getcookie_crm('employee_power')==1){
			$where_join = "employee.employee_power = ".getcookie_crm('employee_power');
			$join = array('employee_job_id','employee_job','employee_job.employee_job_id = employee.employee_job_id','left');
			$employee_info = $list = $this->main_data_model->select('employee_id',$where_join,0,0,0,$join,'employee');

			if( $info['employee_power'] == 1 ){
				$data['role'] = array();
			}else{
				$where = "employee_job_id != ".$employee_info[0]['employee_job_id'];
				$data['role']=$this->main_data_model->getOtherAll('*',$where,'employee_job');

			}
				
		}else{
			
			$data['role']=$this->main_data_model->getAll('*','employee_job');
		}

		$this->load->view('admin_edit',$data);
	}

	public function delete()
	{
		$id = $this->input->post('id');
		#删除到最后一条时会出错
		$num = 0;
		if (!empty($id)) {
			foreach ($id as $key => $value) {
				$count = $this->main_data_model->count(array('employee_id'=>$value));
				if($count != 0){
					$num ++;
				}
			}
		}
		
		if ($num == 0) {
			show_message("无效参数");
		}

		if (!empty($id)) {
			foreach ($id as $key => $value) {
				$where=array('employee_id'=>$value);
				#查询多个咨询师
				$res1 = $this->main_data_model->count($where,'consultant');
				$res2 = $this->main_data_model->count($where,'student');
				$res3 = $this->main_data_model->count($where,'time_remind');

				#查询是哪个咨询师还有资源
				$sel = $this->main_data_model->getOne($where,'employee_name');
				if($res1>0 || $res2>0 || $res3>0){
					show_message($sel['employee_name']."还有资源没转移，请先转移");
				}
			}
		}
		
		#批量删除管理员
		$result = $this->main_data_model->delete(array('employee_id',$id),2);	
		if($result>0){
  			show_message('删除成功!',site_url(module_folder(1).'/admin/index'));	
  		}else{
  			show_message('操作失败!');
  		}

	}

	public function info()
	{
		header("Content-Type:text/html;charset=utf-8");

		$employee_id = $this->input->post("id");
		$where = array('employee_id'=>$employee_id);

		#信息
		$employee = $this->main_data_model->getOne($where,'','employee');

		#员工phone
		$employee_phone = $this->main_data_model->setTable('employee_phone')->getOtherAll('employee_phone_number,is_workphone',$where);

		#员工qq
		$employee_qq = $this->main_data_model->setTable('employee_qq')->getOtherAll('employee_qq,is_workqq',$where);

		#员工email
		$employee_email = $this->main_data_model->setTable('employee_email')->getOtherAll('employee_email_number,is_workemail',$where);

		#员工微信
		$employee_weixin = $this->main_data_model->setTable('employee_weixin')->getOtherAll('employee_weixin_number',$where);

		#员工籍贯
		$province = $this->main_data_model->setTable('region')->getOne(array('region_id'=>$employee['province']),'region_name');
		$city = $this->main_data_model->setTable('region')->getOne(array('region_id'=>$employee['city']),'region_name');
		$area = $this->main_data_model->setTable('region')->getOne(array('region_id'=>$employee['area']),'region_name');

		#部门
		$department = $this->main_data_model->setTable('department')->getOne(array('department_id'=>$employee['department_id']),'department_name');
		#角色
		$role = $this->main_data_model->setTable('employee_job')->getOne(array('employee_job_id'=>$employee['employee_job_id']),'employee_job_name');

		
		$str='<table border="1" width="100%">';
		$str.="<tr>";
		$str.="<td width='23%'>姓名</td><td>".$employee['employee_name']."</td>";
		$str.="</tr>";

		$str.="<tr>";
		$str.="<td>性别</td>";
		$str.="<td>";
		if ($employee['employee_sex']==1) {
			$str.='男';
		}else if($employee['employee_sex']==2){
			$str.='女';
		}else{
			$str.='';
		}
		$str.="</td>";
		$str.="</tr>";

		#入职时间
		$str.="<tr>";
		$str.="<td>入职时间</td><td>".date('Y-m-d',$employee['employed_date'])."</td>";
		$str.="</tr>";

		#所属部门
		$str.="<tr>";
		$str.="<td>所属部门</td>";
		$str.="<td>";
		if(isset($department['department_name'])){
			$str.=$department['department_name'];
		}
		$str.="</td>";
		$str.="</tr>";

		#所属角色
		$str.="<tr>";
		$str.="<td>所属角色</td>";
		$str.="<td>";
		if(isset($role['employee_job_name'])){
			$str.=$role['employee_job_name'];
		}
		$str.="</td>";
		$str.="</tr>";

		#电话
		$str.="<tr>";
		$str.="<td>电话</td><td>".$employee['employee_telephone']."</td>";
		$str.="</tr>";

		#phone
		$str.="<tr>";
		$str.="<td>手机号码</td>";
		$str.="<td>";
		if($employee_phone){
			foreach($employee_phone as $item){	
				$str.=$item['employee_phone_number'];
				if($item['is_workphone']==1){
					$str.='&nbsp;(工作)<br />';
				}else{
					$str.='&nbsp;(私人)<br />';
				}
			}
		}
		$str.="</td>";
		$str.="</tr>";

		#qq
		$str.="<tr>";
		$str.="<td>QQ</td>";
		$str.="<td>";
		if($employee_qq){
			foreach($employee_qq as $item){	
				$str.=$item['employee_qq'];
				if($item['is_workqq']==1){
					$str.='&nbsp;(工作)<br />';
				}else{
					$str.='&nbsp;(私人)<br />';
				}
			}
		}
		$str.="</td>";
		$str.="</tr>";

		#邮箱
		$str.="<tr>";
		$str.="<td>邮箱</td>";
		$str.="<td>";
		if($employee_email){
			foreach($employee_email as $item){	
				$str.=$item['employee_email_number'];
				if($item['is_workemail']==1){
					$str.='&nbsp;(工作)<br />';
				}else{
					$str.='&nbsp;(私人)<br />';
				}
			}
		}
		$str.="</td>";
		$str.="</tr>";

		#微信
		$str.="<tr>";
		$str.="<td>微信</td>";
		$str.="<td>";
		if($employee_weixin){
			foreach($employee_weixin as $item){	
				$str.=$item['employee_weixin_number'];
			}
		}
		$str.="</td>";
		$str.="</tr>";

		#出生日期
		$str.="<tr>";
		$str.="<td>出生日期</td><td>".date('Y-m-d',$employee['birthday'])."</td>";
		$str.="</tr>";

		#籍贯
		$str.="<tr>";
		$str.="<td>籍贯</td>";
		$str.="<td>";
		if(isset($province['region_name'])){
			$str.= $province['region_name'].'省';
		}
		if(isset($city['region_name'])){
			$str.= $city['region_name'].'市';
		}
		if(isset($area['region_name'])){
			$str.= $area['region_name'];
		}
		$str.="</td>";
		$str.="</tr>";
		
		#身份证
		$str.="<tr>";
		$str.="<td>身份证</td><td>".$employee['identity_card_number']."</td>";
		$str.="</tr>";
		
		#婚姻状况
		if($employee['is_marry']==1){
			$marry='已婚';
		}else{
			$marry='未婚';
		}
		$str.="<tr>";
		$str.="<td>婚姻状况</td><td>".$marry."</td>";
		$str.="</tr>";
		
		#学历
		$str.="<tr>";
		$str.="<td>学历</td><td>".$employee['employee_education']."</td>";
		$str.="</tr>";
		
		#专业
		$str.="<tr>";
		$str.="<td>专业</td><td>".$employee['employee_major']."</td>";
		$str.="</tr>";
		
		#毕业学校
		$str.="<tr>";
		$str.="<td>毕业学校</td><td>".$employee['graduate_institutions']."</td>";
		$str.="</tr>";
		

		$str.="</table>";
		echo json_encode(array('data'=>$str));
		exit;
	}


	/**
	 * 转接学生与咨询者
	 */
	public function changeTeach()
	{

		$check=array(
			array('teach1','咨询师1'),
			array('teach2','咨询师2'),
		);
		check_form($check);

		if ($this->form_validation->run() == FALSE){
			$this->load->model('employee_model');
			$teach= $this->employee_model->selectConsultantTeach();
			#赋值
			$data=array(
				'teach'=>$teach
			);
			#指定视图输出
			$this->load->view('changeTeach',$data);
		}else{
			$teach1=$this->input->post('teach1');
			$teach2=$this->input->post('teach2');

			$where=array('employee_id'=>$teach1);
			$data=array(
				'old_employee_id'=>$teach1,
				'employee_id'=>$teach2
			);
			//更新咨询师,增加原来的咨询师
			$res1 = $this->main_data_model->update($where,$data,'consultant');
			$res2 = $this->main_data_model->update($where,$data,'student');
			$res3 = $this->main_data_model->update($where,$data,'time_remind');

			if ($res1 && $res2 && $res3) {
				show_message('交接成功!',site_url(module_folder(1).'/admin/index'));
			}else{
				show_message('交接成功!',site_url(module_folder(1).'/admin/index'));
			}
		}
	}


	public function check()
	{
		header("Content-Type:text/html;charset=utf-8");

		$value = $this->input->post('value');
		$id = $this->input->post('id');
		
		$this->load->model('employee_model');
		$res=$this->employee_model->check($value,$id);

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	public function region()
	{
		header("Content-Type:text/html;charset=utf-8");

		$region_id = $this->input->get('region_id');
	
		$where = array('parent_id'=>$region_id);
		$res = $this->main_data_model->getOtherAll('*',$where,'region');

		echo json_encode($res);
		exit;
	}

}