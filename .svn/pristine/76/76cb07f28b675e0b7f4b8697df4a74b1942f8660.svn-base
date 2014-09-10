<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_marketing_specialist_model extends CI_Model 
{
	private $t;#渠道表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('marketing_specialist');
	}

	/**
	 * 查询所有的咨询形式
	 */
	public function getAll(){
		$this->db->select('marketing_specialist_id,marketing_specialist_name');

		$data=$this->db->get($this->t);
        return $data->result_array();

	}

	/**
	 * 获取到名字
	 */
	public function getName($id)
	{	
		$this->db->select('marketing_specialist_name')
			     ->where('marketing_specialist_id',$id);


		$data= $this->db->get($this->t);
		$name= $data->row_array();
		return $name['marketing_specialist_name'];
	}

	/**
	 * 获取到名字
	 */
	public function getOne($id)
	{	
		$this->db->select('marketing_specialist_name')
			     ->where('marketing_specialist_id',$id);


		$data= $this->db->get($this->t);
		$name= $data->row_array();
		return $name;
	}

}