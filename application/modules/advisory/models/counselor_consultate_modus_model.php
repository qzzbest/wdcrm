<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_counselor_consultate_modus_model extends CI_Model 
{
	private $t;#咨询者的咨询形式表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('counselor_consultate_modus');
	}
	
	/**
	 *	查询
	 */
	public function select($limit)
	{
		$this->db->select('consultant_consultate_id,consultant_consultate_name')
				 ->order_by('consultant_consultate_id asc')
				 ->limit($limit,0);
		
		$data=$this->db->get($this->t);
        return $data->result_array();
		
	}
	/**
	 * 查询所有的咨询形式
	 */
	public function getAll(){
		$this->db->select('consultant_consultate_id,consultant_consultate_name');

		$data=$this->db->get($this->t);
        return $data->result_array();

	}

	/**
	 * 获取到名字
	 */
	public function getName($id)
	{
		$this->db->select('consultant_consultate_name')
			     ->where('consultant_consultate_id',$id);

		$data= $this->db->get($this->t);
		$name= $data->row_array();
		return $name['consultant_consultate_name'];
	}
}