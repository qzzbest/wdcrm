<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 学生表模型
 */
class Advisory_student_attendance_score_model extends CI_Model 
{

	
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('student_attendance_score');
	}

	/**
	 * 学生成绩查询
	 */
	public function select_score($student_id,$classroom_id,$exam_id)
	{

		$field='student_score';

		$this->db->select($field);

		$this->db->where('student_id',$student_id)
				 ->where('classroom_id',$classroom_id)
				 ->where('exam_id',$exam_id)
				 ->where('is_exam',1);

		$data=$this->db->get($this->t);

		return $data->row_array();

	}
	/**
	 * 学生成绩查询
	 */
	public function select_all_score($student_id,$classroom_id)
	{

		$field='exam_id,student_score';

		$this->db->select($field);

		$this->db->where('student_id',$student_id)
				 ->where('classroom_id',$classroom_id)
				 ->where('is_exam',1);

		$data=$this->db->get($this->t);

		return $data->result_array();

	}
	/**
	 * 学生考勤查询
	 */
	public function select_attendance($student_id,$classroom_id,$record_time,$time_part)
	{

		$field='student_attendance_status,student_attendance_desc';

		$this->db->select($field);

		$this->db->where('student_id',$student_id)
				 ->where('classroom_id',$classroom_id)
				 ->where('record_time',$record_time)
				 ->where('time_part',$time_part);

		$data=$this->db->get($this->t);

		return $data->row_array();

	}
	/**
	 * 学生作业查询
	 */
	public function select_homework($student_id,$classroom_id,$record_time)
	{

		$field='student_score,	student_score_desc';

		$this->db->select($field);

		$this->db->where('student_id',$student_id)
				 ->where('classroom_id',$classroom_id)
				 ->where('record_time',$record_time);

		$data=$this->db->get($this->t);

		return $data->row_array();

	}

	/**
	 * 具体某个班的某个学生的考勤作业查询
	 */
	public function select_check($student_id,$classroom_id)
	{
		$field='*';

		$this->db->select($field);

		$this->db->where('student_id',$student_id)
				 ->where('classroom_id',$classroom_id);

		$data=$this->db->get($this->t);

		return $data->result_array();

	}
}