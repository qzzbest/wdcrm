<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class P_student_model extends CI_Model 
{
	private $t;#学生就读记录表	
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('student_attended_record');
		$this->t1=$this->db->dbprefix('student');
		$this->t2=$this->db->dbprefix('student_knowleage_relation');
	}

	/**
	 *	查看学生的信息
	 */
	public function getStudentInfo($field,$where='')
	{
		$this->db->select($field);
		if(!empty($where)){
			$this->db->where($where);
		}
		$data = $this->db->get($this->t1);
		return $data->row_array();		 
	}

	/**
	 *  查询单个的就读记录
	 */
	public function selectAttendedRecord($where)
	{
		$data = $this->db->select('*')
				 ->where($where)
				 ->get($this->t);         

		return $data->row_array();		                       
	}

	/**
	 *  查询所有的就读记录
	 */
	public function attendedRecordAll($where)
	{
		$data = $this->db->select('*')
				 ->where($where)
				 ->join($this->t2, $this->t2.'.id = '.$this->t.'.relation_id', 'left')
				 ->get($this->t);         

		return $data->result_array();		                       
	}

	/**
	 *  添加就读记录
	 */
	public function addAttendedRecord($data)
	{
		return $this->db->insert($this->t,$data);
	}

	/**
	 *  更新就读记录
	 */
	public function editAttendedRecord($where,$data)
	{
		$this->db->where($where);
		$this->db->update($this->t,$data);		                               
	}

	/**
	 *  更新学生信息
	 */
	public function editStudentInfo($where,$data)
	{
		$this->db->where($where);
		$this->db->update($this->t1,$data);		                               
	}
}