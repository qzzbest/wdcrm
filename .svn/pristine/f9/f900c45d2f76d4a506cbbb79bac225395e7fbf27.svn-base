<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administration_knowledge_model extends CI_Model 
{
	private $t;#知识点表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('knowledge');
	}
	/**
	 * 知识点列表
	 */
	public function select($start,$limit)
	{
		$this->db->order_by('knowledge_status DESC,knowledge_order ASC')->limit($limit,$start);
		
		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 知识点统计
	 */
	public function count()
	{
		return $this->db->count_all_results($this->t);
	}
	/**
	 * 检测名字重复
	 */
	public function check($name,$id=false)
	{
		$this->db->where('knowledge_name', $name);
		if($id){

			$this->db->where('knowledge_id !=', $id);

		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}
}