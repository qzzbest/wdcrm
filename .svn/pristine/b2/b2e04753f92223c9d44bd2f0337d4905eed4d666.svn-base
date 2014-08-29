<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_consul_stu_phones_model extends CI_Model 
{
	private $t;#咨询者的咨询形式表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('consul_stu_phones');
	}
	
	/**
	 *	查询
	 */
	public function select($like,$is_client=0)
	{
	
		$this->db->select('consultant.consultant_id')
				 ->from($this->t)
				 ->join('consultant','consultant.consultant_id='.$this->t.'.consultant_id','left')
				 ->like($this->t.'.phone_number',$like)
				 ->group_by("consultant.consultant_id");
		if($is_client){
			$this->db->where('consultant.is_client',1);
		}
		$data=$this->db->get();
	
		
		return $data->result_array();
		
	}
	/**
	 *	查询
	 */
	public function select_student($like)
	{
	
		$this->db->select('student.student_id')
				 ->from($this->t)
				 ->join('student','student.student_id='.$this->t.'.student_id','left')
				 ->like($this->t.'.phone_number',$like)
				 ->group_by("student.student_id");
		
		$data=$this->db->get();
	
		
		return $data->result_array();
		
	}
}