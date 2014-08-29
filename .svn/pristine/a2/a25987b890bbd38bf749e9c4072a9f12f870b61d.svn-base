<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 班级模型
 */
class Teaching_classroom_model extends CI_Model 
{

	private $t;#表名1
	private $t1;#表名2
	private $t2;#表名3
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('classroom');
		$this->t1=$this->db->dbprefix('classroom_type');
		$this->t2=$this->db->dbprefix('knowledge');
		$this->t3=$this->db->dbprefix('student_classroom_relation');
	}
	
	/**
	 * 班级列表 查询
	 */
	public function select_index($start,$limit,$status='',$employee_id='',$class_type='',$start_search_time='',$end_search_time='',$like='')
	{

		$field='*';

		$this->db->select($field)
				 ->order_by($this->t.'.class_status ASC')
				 ->order_by($this->t.'.classroom_type_id ASC')
				 ->limit($limit,$start);
		#班级状态
		if($status !=''){
			$this->db->where('class_status',$status);
		}
		#搜索
		if ($like !='') {
			$this->db->like('classroom_name',$like);
		}
		#讲师id
		if($employee_id !=''){
			$this->db->where('employee_id',$employee_id);
		}
		#开班日期
		if($start_search_time !=''){
			$this->db->where('open_classtime >=',$start_search_time);
		}
		if($end_search_time !=''){
			$this->db->where('open_classtime <=',$end_search_time);
		}
		#班级类型
		if($class_type !=''){
			$this->db->where('classroom_type_id',$class_type);
		}		 

		$data=$this->db->get($this->t);

		return $data->result_array();

	}
	/**
	 * 班级分页统计
	 */
	public function select_index_count($status='',$employee_id='',$class_type='',$start_search_time,$end_search_time,$like)
	{
		#班级状态
		if($status !=''){
			$this->db->where('class_status',$status);
		}
		#讲师id
		if($employee_id !=''){
			$this->db->where('employee_id',$employee_id);
		}
		#搜索
		if ($like !='') {
			$this->db->like('classroom_name',$like);
		}
		#开班日期
		if($start_search_time !=''){
			$this->db->where('open_classtime >=',$start_search_time);
		}
		if($end_search_time !=''){
			$this->db->where('open_classtime <=',$end_search_time);
		}

		#班级类型
		if ($class_type!='') {
			$this->db->where('classroom_type_id', $class_type); 
		}
		return $this->db->count_all_results($this->t);
	}
	/**
	 * 班级类型列表 查询
	 */
	public function select_type_index($start,$limit,$classroom_type_id)
	{

		$field='*';

		$this->db->select($field)
				 ->where('class_status',2)
				 ->where('classroom_type_id',$classroom_type_id)
				 ->order_by($this->t.'.class_status ASC')
				 ->order_by($this->t.'.classroom_type_id ASC')
				 ->limit($limit,$start); 

		$data=$this->db->get($this->t);

		return $data->result_array();

	}
	/**
	 * 班级类型分页统计
	 */
	public function select_type_index_count($classroom_type_id)
	{
		$this->db->where('class_status',2)
				 ->where('classroom_type_id',$classroom_type_id);

		return $this->db->count_all_results($this->t);
	}
	/**
	 * 班级查询
	 */
	public function select_one($classroom_id)
	{

		$field='*';

		$this->db->select($field)
				 ->join('employee','employee.employee_id=classroom.employee_id','left')
				 ->where('classroom_id',$classroom_id);

		$data=$this->db->get($this->t);

		return $data->row_array();

	}
	/**
	 * 班级学生列表 查询
	 */
	public function select_class_student($id,$start,$limit)
	{

		$field='student.student_id,student.student_number,student.student_name,student.student_sex,is_computer,student_classroom_relation.is_first';

		$this->db->select($field)
				 ->join('student','student.student_id=student_classroom_relation.student_id','left')
				 ->where('classroom_id',$id)
				 ->where($this->t3.'.show_status',1)
				 ->limit($limit,$start)
				 ->order_by('is_computer DESC')
				 ->order_by('is_first ASC');

		$data=$this->db->get($this->t3);

		return $data->result_array();

	}
	/**
	 * 班级学生分页统计
	 */
	public function select_class_student_count($id,$is_first='')
	{
		$this->db->where('classroom_id',$id)
				 ->where($this->t3.'.show_status',1);
		//查询人数(不算复读)
		if($is_first!=''){
			$this->db->where('is_first',$is_first);
		}
		return $this->db->count_all_results($this->t3);
	}
	
	/**
	 * 删除班级学生
	 */
	/*public function delete_class_student($student_id,$classroom_id)
	{
		$this->db->where('classroom_id',$classroom_id)
				 ->where_in('student_id',$student_id)
		         ->delete('student_classroom_relation');
		return $this->db->affected_rows();
	}*/
	//虚拟删除学生
	public function change_status($student_id,$classroom_id,$status)
	{
		$this->db->where('classroom_id',$classroom_id)
				 ->where_in('student_id',$student_id)
		         ->update($this->t3,$status);
		return $this->db->affected_rows();
	}

	/**
	 *  获取学员所在班级id
	 */
	public function student_classid($student_id)
	{
		$data = $this->db->select('classroom_id')
				         ->where('student_id',$student_id)
				         ->where($this->t3.'.show_status',1)
				 		 ->get($this->t3);

		$res=array();
		foreach ($data->result_array() as $value) {	
			$res[]=$value['classroom_id'];
		}
		return $res;
	}
	/**
	 *  获取学员所在班级名
	 */
	public function student_class($student_id)
	{
		$data = $this->db->select($this->t.'.classroom_id,'.$this->t.'.classroom_name,'.$this->t.'.classroom_type_id')
						 ->join('classroom','classroom.classroom_id=student_classroom_relation.classroom_id','left')
				         ->where('student_id',$student_id)
				         ->where($this->t.'.class_status',1)
				         ->where($this->t3.'.show_status',1)
				 		 ->get($this->t3);
		return $data->result_array();
	}
	/**
	 *  获取学员所在班级名称(不管班级是否结束)
	 */
	public function student_all_class($student_id)
	{
		$data = $this->db->select($this->t.'.classroom_id,'.$this->t.'.classroom_name')
						 ->join('classroom','classroom.classroom_id=student_classroom_relation.classroom_id','left')
				         ->where('student_id',$student_id)
				 		 ->get($this->t3);
		return $data->result_array();
	}

	/**
	 *  获取班级对应的知识点
	 */
	public function classKnownledge($classroom_type_id)
	{
		$data = $this->db->select($this->t2.'.knowledge_id,'.$this->t2.'.knowledge_name')
						 ->join($this->t2,$this->t1.'.classroom_type_id='.$this->t2.'.classroom_type_id','left')
				         ->where($this->t1.'.classroom_type_id',$classroom_type_id)
				 		 ->get($this->t1);
		return $data->result_array();
	}
	/**
	 * 检测名字重复
	 */
	public function check($name,$id=false)
	{
		$this->db->where('classroom_name', $name);
		
		if($id){
			$this->db->where('classroom_id !=', $id);
		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}
}