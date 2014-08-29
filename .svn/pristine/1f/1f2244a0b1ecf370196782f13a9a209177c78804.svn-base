<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class P_classroom_type_model extends CI_Model 
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
	public function selectClassType($status='')
	{
		$this->db->select('*');
		if($status!=''){
			$this->db->where('type_status',$status);
		}
		$data=$this->db->get($this->t);

		return $data->result_array();
	}

	/**
	 * 连表查询知识点
	 * @param  int $classroom_type_id 班级类型ID
	 */
	public function select_knowledge($where='',$where_not_in='')
	{
		$this->db->select('knowledge.knowledge_id,knowledge.knowledge_name')
				->join('knowledge', 'knowledge.classroom_type_id='.$this->t.'.classroom_type_id','left')
				->where('knowledge.knowledge_status',1)
				->order_by('knowledge.knowledge_order ASC');
		if($where){
			$this->db->where($where);
		}
		if($where_not_in){
			$this->db->where_not_in('knowledge.knowledge_id',$where_not_in);
		}

		$data=$this->db->get($this->t);

		return $data->result_array();
	}

}