<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生操作
 */
class Common_employee_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
	}

	/**
	 * 员工信息
	 */
	public function employeeInfo($employee_job_name)
	{
		$this->load->model('employee_model');
		$employee_info = $this->employee_model->selectDepartment($employee_job_name);

		return $employee_info;
	}
}

