<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Market_employee_model extends CI_Model 
{
	private $t;#员工表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('employee');
		$this->t1=$this->db->dbprefix('employee_job');
	}

	/**
	 * 根据员工职位ID查询相应的员工信息
	 */
	public function selectEmployee($employee_job_id)
	{
		$this->db->select($this->t.'.employee_id,'.$this->t.'.employee_name')
				 ->join($this->t1, $this->t1.'.employee_job_id ='.$this->t.'.employee_job_id', 'left')
				 ->where($this->t1.'.employee_job_id',$employee_job_id);

		$data=$this->db->get($this->t);

		return $data->result_array();
	}
}