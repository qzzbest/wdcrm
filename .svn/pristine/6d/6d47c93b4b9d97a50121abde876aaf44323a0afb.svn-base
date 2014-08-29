<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class P_knowledge_model extends CI_Model 
{
	private $t;#员工表
	private $t1;
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('knowledge');
		$this->t1=$this->db->dbprefix('student_knowleage_relation');
	}

	/**
	 *  查询某个知识点
	 */
	public function selectKnowledge($where)
	{
		$data = $this->db->select('*')
				 ->where($where)
				 ->get($this->t);         

		return $data->row_array();		                       
	}

	/**
	 *  查询学生报读的知识点
	 */
	public function selectStudentKnowledge($where)
	{
		$data = $this->db->select('*')
				 ->where($where)
				 ->get($this->t1);         

		return $data->row_array();		                       
	}

	/**
	 *  查询学生报读的知识点
	 */
	public function selectAllKnowledge($where_in)
	{
		$data = $this->db->select('*')
				 ->where_in('knowledge_id',$where_in)
				 ->get($this->t);         

		return $data->result_array();		                       
	}

	/**
	 *  查询学生报读的知识点
	 */
	public function selectAllStuKnowledge($where='',$where_in='')
	{
		$this->db->select('*');
			
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($where_in)){
			$this->db->where_in('study_status',$where_in);
		}
		
		$data = $this->db->get($this->t1);         

		return $data->result_array();		                       
	}

	/**
	 * 查询单个学生报读的知识点和相应知识点
	 */
	public function select_knowledge_info($where)
	{
		$this->db->select('*')
				 ->join($this->t1, $this->t1.'.knowledge_id = '.$this->t.'.knowledge_id', 'left')
				 ->order_by('student_knowleage_relation.knowledge_id','asc')
				 ->where($where);

		$data=$this->db->get($this->t);

		return $data->row_array();
	}

	/**
	 * 查询所有学生报读的知识点和相应知识点
	 */
	public function student_knowledge_info($where)
	{
		$this->db->select('*')
				 ->join($this->t1, $this->t1.'.knowledge_id = '.$this->t.'.knowledge_id', 'left')
				 ->order_by('student_knowleage_relation.knowledge_id','asc')
				 ->where($where);

		$data=$this->db->get($this->t);

		return $data->result_array();
	}

	/**
	 * 更新学生知识点的状态（未读、就读、复读）
	 */
	public function update_student_knowledge($where='',$where_in='',$data)
	{	
		 
		if($where!=''){
			$this->db->where($where);
		}

		if($where_in!=''){
			$this->db->where_in('student_id',$where_in);
		}
		
		$this->db->update($this->t1,$data);		    
	}

}