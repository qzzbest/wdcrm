<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administration_curriculum_system_model extends CI_Model 
{
	private $t;#课程表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('curriculum_system');
	}
	/**
	 * 课程列表
	 * @param int $start 分页起始值
	 * @param int $limit 每页显示条数
	 */
	public function select($start,$limit)
	{
		$this->db->limit($limit,$start);
		
		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 连表查询知识点
	 * @param  int $curriculum_system_id 课程体系ID
	 */
	public function select_knowledge($curriculum_system_id)
	{
		$this->db->select('*')
				->join('curriculum_knowleage_relation', 'curriculum_knowleage_relation.curriculum_system_id='.$this->t.'.curriculum_system_id','left')
				->join('knowledge', 'knowledge.knowledge_id=curriculum_knowleage_relation.knowledge_id','left')
				->where($this->t.'.curriculum_system_id', $curriculum_system_id)
				->order_by('knowledge.knowledge_order ASC');
		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	
	/**
	 * 课程统计
	 */
	public function count()
	{
		return $this->db->count_all_results($this->t);
	}

	/**
	 * 查询知识点id
	 */
	public function select_kid($curriculum_system_id)
	{
		$data=$this->db->select($this->t.'.curriculum_system_id, '.$this->t.'.curriculum_system_name, curriculum_knowleage_relation.knowledge_id')
				   ->join('curriculum_knowleage_relation', 'curriculum_knowleage_relation.curriculum_system_id='.$this->t.'.curriculum_system_id','left')
				   ->where($this->t.'.curriculum_system_id', $curriculum_system_id)
			       ->get($this->t);

		$res=array();
		foreach ($data->result_array() as $key => $value) {	
			$res['curriculum_system_id']=$value['curriculum_system_id'];
			$res['curriculum_system_name']=$value['curriculum_system_name'];
			$res['knowledge_id'][$key]=$value['knowledge_id'];
		}

		return $res;
	}
	/**
	 * 检测名字重复
	 */
	public function check($name,$id=false)
	{
		$this->db->where('curriculum_system_name', $name);
		if($id){

			$this->db->where('curriculum_system_id !=', $id);

		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}

	public function select_knowledge1($curriculum_system_id)
	{
		$this->db->select('knowledge.*')
				->join('curriculum_knowleage_relation', 'curriculum_knowleage_relation.curriculum_system_id='.$this->t.'.curriculum_system_id','left')
				->join('knowledge', 'knowledge.knowledge_id=curriculum_knowleage_relation.knowledge_id','left')
				->where($this->t.'.curriculum_system_id', $curriculum_system_id)
				->order_by('knowledge.knowledge_order ASC');
		$data=$this->db->get($this->t);

		return $data->result_array();
	}
}