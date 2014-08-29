<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 班级模型
 */
class P_classroom_student_model extends CI_Model 
{

	private $t;#表名1
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('student_classroom_relation');
	}

	/**
	 * 班级学生信息
	 */
	public function classroom_student_info($where,$select='')
	{		
		if ($select!='') {
			$this->db->select($select);
		}
		$this->db->where($where);
		
		$data = $this->db->get($this->t);
		
		return $data->result_array();
	}


}