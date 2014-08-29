<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teaching_employee_model extends CI_Model 
{
	private $t;#员工表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('employee');
	}

	/**
	 * 根据部门查询咨询师信息
	 */
	public function selectDepartment($employee_job_id)
	{
		$this->db->select('employee_id,employee_name')
				 ->join('employee_job', 'employee_job.employee_job_id ='.$this->t.'.employee_job_id', 'left')
				->where($this->t.'.employee_job_id',$employee_job_id);

		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 查询员工名字
	 */
	public function select_employee($employee_id)
	{
		$this->db->select('employee_name')
				 ->where($this->t.'.employee_id',$employee_id);

		$data=$this->db->get($this->t);

		return $data->row_array();
	}

}