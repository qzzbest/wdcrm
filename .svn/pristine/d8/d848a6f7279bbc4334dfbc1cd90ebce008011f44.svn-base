<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class P_employee_model extends CI_Model 
{
	private $t;#员工表
	private $employee_id;#员工id
	private $p; #员工的权限
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('employee');

		$this->p = getcookie_crm('employee_power');
		$this->employee_id= getcookie_crm('employee_id');
	}

	/**
	 * 根据咨询师ID查询咨询师信息
	 */
	public function selectEmployee($employee_id)
	{
		$this->db->select('employee_id,employee_name')
				->where('employee_id',$employee_id);

		$data=$this->db->get($this->t);

		return $data->row_array();
	}

	/**
	 * 根据部门查询咨询师信息
	 */
	public function selectDepartment()
	{
		$this->db->select('employee_id,employee_name')
				 ->join('employee_job', 'employee_job.employee_job_id ='.$this->t.'.employee_job_id', 'left')
				->where('employee_job_name','咨询师');

		$data=$this->db->get($this->t);

		return $data->result_array();
	}

	/**
	 * 检查操作的咨询者是否
	 */
	public function checkData()
	{
		//如果是超级管理员
		if($this->p==1){
			return 1;
		}
		$this->db->select('employee_id');

		$data=$this->db->get($this->t);

		$res= $data->result_array();


		foreach ($res as $key => $value) {
			if($value['employee_id']!=$this->employee_id){
				return 0; //表示操作了不属于他的数据
			}
		}
		
		return 1;//表示通过数据校验
	}

}