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
		
	   		$this->load->view('admin_add',$data);
	  	}else{
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$pwdconfirm = $this->input->post("pwdconfirm");
			$pname = $this->input->post("pname");
			$role = $this->input->post("role");
			$mark_power = $this->input->post("mark_power");

			$user=$this->main_data_model->getAll("admin_name");			
			for($i=0;$i<count($user);$i++){
				if($user[$i]['admin_name'] == $username){
					show_message('用户名已存在');
				}
			}
			if($password != $pwdconfirm){
				show_message('密码和确认密码不一致');
			}
			$pw_md5=md5($pwdconfirm);
			
			$data=array(
				'admin_name'=>$username,
				'admin_password'=>$pw_md5,
				'employee_name'=>$pname,
				'employee_job_id'=>$role,
			);
			if($role==19){#人事、就业权限
				$data['employee_power'] = 2; 
			}

			if($mark_power){
				$data['mark_power'] = $mark_power;
			}
		
	  		$this->main_data_model->insert($data);			
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
		

		$id = $this->uri->segment(5,0);	
		$info=$this->main_data_model->getOne("employee_id = '{$id}'");

		if(getcookie_crm('employee_power')==1){
			$where_join = "employee.employee_power = ".getcookie_crm('employee_power');
			$join = array('employee_job_id','employee_job','employee_job.employee_job_id = employee.employee_job_id','left');
			$employee_info = $list = $this->main_data_model->select('employee_id',$where_join,0,0,0,$join,'employee');

			if( $info['employee_power'] == 1 ){
				$role = array();
			}else{
				$where = "employee_job_id != ".$employee_info[0]['employee_job_id'];
				$role=$this->main_data_model->getOtherAll('*',$where,'employee_job');

			}
				
		}else{
			$role=$this->main_data_model->getAll('*','employee_job');
		}

		$data=array(
			'info'=>$info,
			'role'=>$role
			);
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

	public function info(){
		header("Content-Type:text/html;charset=utf-8");
		$id = $_POST["id"];
		$res=$this->main_data_model->getOne("employee_id = '{$id}'");
		$crm_user_name = $res['admin_name'];
		
		$str=<<<HTML
		<table>
			<tr>
				<td>用户名</td>
				<td>$crm_user_name</td>
			</tr>
		</table>
HTML;
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

}