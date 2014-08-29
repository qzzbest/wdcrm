<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_consultant_channel_model extends CI_Model 
{
	private $t;#渠道表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('consultant_channel');
	}

	/**
	 * 查询所有的咨询形式
	 */
	public function getAll(){
		$this->db->select('consultant_channel_id,consultant_channel_name');

		$data=$this->db->get($this->t);
        return $data->result_array();

	}

	/**
	 * 获取到名字
	 */
	public function getName($id)
	{	
		$this->db->select('consultant_channel_name')
			     ->where('consultant_channel_id',$id);


		$data= $this->db->get($this->t);
		$name= $data->row_array();
		return $name['consultant_channel_name'];
	}

	/**
	 * 获取到名字
	 */
	public function getOne($id)
	{	
		$this->db->select('consultant_channel_name')
			     ->where('consultant_channel_id',$id);


		$data= $this->db->get($this->t);
		$name= $data->row_array();
		return $name;
	}

}