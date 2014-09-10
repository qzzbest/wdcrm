<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 班级模型
 */
class Advisory_classroom_model extends CI_Model 
{

	private $t;#表名1
	private $t1;#表名2
	private $t2;#表名3
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('classroom');
	}
	
	/**
	 *  获取学员所在班级名称(不管班级是否结束)
	 */
	public function student_class($student_id)
	{
		$data = $this->db->select($this->t.'.classroom_id,'.$this->t.'.classroom_name')
						 ->join('classroom','classroom.classroom_id=student_classroom_relation.classroom_id','left')
				         ->where('student_id',$student_id)
				 		 ->get('student_classroom_relation');
		return $data->result_array();
	}
	/**
	 *  获取学员所在班级名称
	 */
	public function class_exam($classroom_id)
	{
		$data = $this->db->select('knowledge_exam.*')
						 ->join('knowledge_exam','classroom.classroom_type_id=knowledge_exam.classroom_type_id','left')
				         ->where('classroom_id',$classroom_id)
				 		 ->get($this->t);
		return $data->result_array();
	}

	
}