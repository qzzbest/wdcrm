<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teaching_classroom_type_model extends CI_Model 
{
	private $t;#员工表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('classroom_type');
	}

	/**
	 * 根据全部班级类型
	 */
	public function select_class_type()
	{
		$this->db->select('*');

		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 连表查询知识点
	 * @param  int $classroom_type_id 班级类型ID
	 */
	public function select_knowledge($classroom_type_id)
	{
		$this->db->select('knowledge.knowledge_id,knowledge.knowledge_name')
				->join('knowledge', 'knowledge.classroom_type_id='.$this->t.'.classroom_type_id','left')
				->where($this->t.'.classroom_type_id', $classroom_type_id)
				->order_by('knowledge.knowledge_order ASC');
		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 班级分页统计
	 */
	public function select_count()
	{
		return $this->db->count_all_results($this->t);
	}
	/**
	 * 根据某个班级类型
	 */
	public function select_one($classroom_type_id)
	{
		$this->db->select('*')
				 ->where('classroom_type_id', $classroom_type_id);

		$data=$this->db->get($this->t);

		return $data->row_array();
	}
	/**
	 * 编辑的时候查询某个班级知识点
	 */
	public function select_all_knowledge($classroom_type_id)
	{
		$this->db->select('knowledge_id,knowledge_name,knowledge_order')
				 ->where('classroom_type_id', 0)
				 ->or_where('classroom_type_id', $classroom_type_id)
				 ->order_by('classroom_type_id DESC')
				 ->order_by('knowledge_order ASC');
		$data=$this->db->get('knowledge');

		return $data->result_array();
	}
	/**
	 * 检测名字重复
	 */
	public function check($name,$id=false)
	{
		$this->db->where('classroom_type_name', $name);
		if($id){

			$this->db->where('classroom_type_id !=', $id);

		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}
}