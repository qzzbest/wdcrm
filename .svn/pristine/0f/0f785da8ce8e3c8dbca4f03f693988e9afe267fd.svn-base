<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 学生表模型
 */
class Teaching_student_attendance_score_model extends CI_Model 
{

	
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('student_attendance_score');
	}

	/**
	 * 计算班级考试总分（不算复读）
	 */
	public function count_all_score($classroom_id,$exam_id)
	{
		$count_sql = 'SELECT SUM(`student_score`) AS score FROM '.$this->t.' AS a LEFT JOIN crm_student_classroom_relation AS b ON a.student_id = b.student_id AND a.classroom_id = b.classroom_id  WHERE a.`classroom_id` = '.$classroom_id.' AND `exam_id` ='.$exam_id.' AND `is_exam` = 1 AND `is_first` = 1';
		//echo $count_sql;die;
		$count_score = $this->db->query($count_sql);
		$res = $count_score->row_array();
		return $res['score'];
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
				 ->where('is_exam',0)
				 ->where('record_time',$record_time);

		$data=$this->db->get($this->t);

		return $data->row_array();

	}
	/*public function select_check($student_id,$classroom_id)
	{


		$sql="SELECT *,group_concat(time_part)as t_id, group_concat(student_attendance_status)as s_id,group_concat(student_attendance_desc)as s_desc FROM crm_student_attendance_score WHERE student_id=".$student_id." AND classroom_id=".$classroom_id." group by record_time";

		$data = $this->db->query($sql);

        return $data->result_array();

	}*/

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