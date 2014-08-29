<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teaching_consul_stu_qq_model extends CI_Model 
{
	private $t;#咨询者的咨询形式表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('consul_stu_qq');
	}
	
	/**
	 *	查询
	 */
	public function select_student($like)
	{
	
		$this->db->select('student.student_id')
				 ->from($this->t)
				 ->join('student','student.student_id='.$this->t.'.student_id','left')
				 ->like($this->t.'.qq_number',$like)
				 ->group_by("student.student_id");
		
		$data=$this->db->get();
	
		
		return $data->result_array();
		
	}
	
}