<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administration_employee_job_model extends CI_Model 
{
	private $t;#知识点表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('employee_job');
	}
	/**
	 * 咨询者咨询的形式 列表
	 */
	public function select($start,$limit)
	{
		$this->db->limit($limit,$start);
		
		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 咨询者咨询的形式统计
	 */
	public function count()
	{
		return $this->db->count_all_results($this->t);
	}
	/**
	 * 检测名字重复
	 */
	public function check($name,$id=false)
	{
		$this->db->where('employee_job_name', $name);
		if($id){

			$this->db->where('employee_job_id  !=', $id);

		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}
}