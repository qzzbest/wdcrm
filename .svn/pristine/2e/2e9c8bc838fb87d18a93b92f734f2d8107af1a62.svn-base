<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者表
 */
class Teaching_consultant_model extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('consultant');
	}
	/**
	 * 查询最大预学号
	 */
	public function select_number()
	{
		$field='pre_number';

		$this->db->select($field);

		$this->db->order_by('pre_number DESC');

		$this->db->limit(1,0);
		$this->db->where('show_status',1);

		$data=$this->db->get($this->t);

		return $data->result_array();
	
	}
	/**
	 * 查询预学号列表
	 */
	public function select_number_index($start,$limit)
	{
		$field='consultant_name,pre_number,employee_id,consultant_id';

		$this->db->select($field);

		$this->db->order_by('pre_number DESC');

		$this->db->limit($limit,$start);
		$this->db->where('show_status',1);
		$this->db->where('pre_number !=','');

		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 查询预学号列表
	 */
	public function select_number_count()
	{
		$this->db->where('show_status',1);
		$this->db->where('pre_number !=','');

		return $this->db->count_all_results($this->t);
	}
}