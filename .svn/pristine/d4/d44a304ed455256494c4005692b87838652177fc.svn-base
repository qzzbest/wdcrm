<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_client_project_model extends CI_Model 
{
	private $t;#咨询者的咨询形式表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('client_project_record');
		$this->t1=$this->db->dbprefix('student_repayment_bills');
	}
	
	/**
	 *	查询
	 */
	public function select_index($where,$start,$limit)
	{
		$field = $this->t.'.*,'.$this->t1.'.*';
		$this->db->select($field);
		$this->db->join($this->t1, $this->t.'.repayment_id='.$this->t1.'.repayment_id','left');
		$this->db->limit($limit,$start);
		$this->db->where($where);
		$data=$this->db->get($this->t);

		return $data->result_array();
		
	}

	/**
	 * 查询某一个项目信息
	 */
	public function select_one($field,$where)
	{
		$data=$this->db->select($field)
		         ->where($where)
		         ->get($this->t);
		return $data->row_array();       
	}
	
}