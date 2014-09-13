<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();

		$this->main_data_model->setTable('employee');
	}
	public function index()
	{
		$check=array(
			array('username','用户名'),
			array('password','密 码'),
			array('seccode','验证码')
		);
		check_form($check);		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login');
		}else{
			$username = $this->input->post("username");
			$pwd = $this->input->post("password");
			$password = md5($pwd);
			$seccode = $this->input->post('seccode');
			$remember = $this->input->post('remember');
			if($seccode != $_SESSION['seccode']){
				show_message('验证码错误',site_url('login/index'));
			}
			$where_login = array(
				'admin_name'=>$username,
				'admin_password'=>$password,
				'show_status'=>1,
				);
			$data = $this->main_data_model->getOne($where_login);
			if ($data) {
				/*记住用户名和密码
				if($remember == 1){
					$remuser = array(
	                   'remember' => 1,
	                   'name' => $data['admin_name'],
	                   'pwd' => $pwd
               		);
					setcookie_crm($remuser);
				}else{
					$remuser = array(
	                   'remember' => '',
	                   'name' => '',
	                   'pwd' => ''
               		);
					setcookie_crm($remuser);
				}*/

				//是否登录，用户信息
				$usermeg = array(
                   'username' => $data['admin_name'],
                   'islogin' => 1,
				   'employee_id'=>$data['employee_id'],
				   'employee_power'=>$data['employee_power'],
					'mark_power'=>$data['mark_power'],
				   'employee_job_id'=>$data['employee_job_id'],
               	);
				setcookie_crm($usermeg);

				//更新提醒时间（默认3秒钟）
				$where = array('employee_id'=>$data['employee_id']);
				$remind_data = array('remind_time'=>3000);
				$this->main_data_model->update($where,$remind_data,'employee');
				//更新登录信息	
				$lastip=$_SERVER['REMOTE_ADDR'];
				$lasttime=time();
				$last=array(
					'lastip'=>$lastip,
					'lasttime'=>$lasttime
					);
				$this->main_data_model->update($where,$last);

				#根据不同的职位登录跳转不同的页面
				//咨询师
				$advisory_job = array(2,8,11);
				//人事、就业
				$personnel_employ = array(19);
				//教务	
				$teaching_job = array(4,5);
				//技术
				$technique_job = array(1,12);
				//市场
				$market_job = array(18);

				if(in_array($data['employee_job_id'], $advisory_job)){
					redirect(module_folder(2).'/advisory/index');
				}else if(in_array($data['employee_job_id'], $teaching_job)){
					redirect(module_folder(4).'/student/index');
				}else if(in_array($data['employee_job_id'], $technique_job)){
					redirect(module_folder(5).'/marking/index');
				}else if(in_array($data['employee_job_id'], $market_job)){
					redirect(module_folder(6).'/market/index');
				}else if(in_array($data['employee_job_id'], $personnel_employ)){
					redirect(module_folder(2).'/student/index');
				}else{
					show_message('您没有此权限',site_url('login/index'));
				}
			}else{
				show_message('用户名或密码错误',site_url('login/index'));
			}
		}	
	}
	public function logout(){

		delcookie_crm('islogin');
		redirect('login/index');
	}
	/**
	* 注册生成验证码
	*/	
	function captcha()
	{
		$this->load->helper('captcha');
		code();
	}
}