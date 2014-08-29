<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administration_consultant_channel_model extends CI_Model 
{
	private $t;#渠道表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('consultant_channel');
	}
	
	/**
	 * 渠道列表
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
	 * 渠道统计
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
		$this->db->where('consultant_channel_name', $name);
		if($id){

			$this->db->where('consultant_channel_id  !=', $id);

		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}
}