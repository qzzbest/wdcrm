<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administration_employee_model extends CI_Model 
{
	private $t;#员工表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('employee');
	}
	/**
	 * 管理员列表
	 */
	public function select_index($start,$limit,$employee_job_id)
	{
		$this->db->select('*')
				 ->join('employee_job', 'employee_job.employee_job_id='.$this->t.'.employee_job_id','left')
				 ->limit($limit,$start);
		if($employee_job_id!=''){
			$this->db->where('employee.employee_job_id',$employee_job_id);
		}		 
		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 员工分页统计
	 */
	public function select_index_count($employee_job_id)
	{
		if ($employee_job_id!='') {
			$this->db->where('employee_job_id', $employee_job_id); 
		}
		return $this->db->count_all_results($this->t);
	}
	/**
	 * 查找所有的咨询师
	 */
	public function selectConsultantTeach()
	{

		$this->db->select('employee_id,employee_name')
				 ->join('employee_job', 'employee_job.employee_job_id ='.$this->t.'.employee_job_id', 'left')
				 ->where('employee_job_name','咨询师');

		$data=$this->db->get($this->t);

		return $data->result_array();

	}

	/**
	 * 检测名字重复
	 */
	public function check($name,$id=false)
	{
		$this->db->where('admin_name', $name);
		if($id){

			$this->db->where('employee_id !=', $id);

		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}

}