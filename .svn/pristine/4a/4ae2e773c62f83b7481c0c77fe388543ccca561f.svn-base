<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_files_model extends CI_Model 
{
	private $table;#员工表
	function __construct()
	{
		parent::__construct();
		$this->table=$this->db->dbprefix('files');
	}

	/**
	 * 咨询常见问题列表
	 */
	public function getOne($field,$where)
	{
		$this->db->select($field);
		$this->db->where($where);
		$data = $this->db->get($this->table);
		return $data->row_array();
	}
	
	/**
	 * 咨询常见问题列表
	 */
	public function select($fields,$where='',$table='')
	{
		$table = $table==''?$this->table:$table;
		$this->db->select($fields);

		if($where!=''){
			$this->db->where($where);
		}
		$data = $this->db->get($table);
		return $data->result_array();	         
	}


	/**
	 * 添加常见问题
	 */
	public function insert($data,$table='')
	{
		$table = $table==''?$this->table:$table;
		if($data){
			$this->db->insert($table,$data);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	/**
	 * 添加多个常见问题
	 */
	public function insert_batch($data,$table='')
	{
		$table = $table==''?$this->table:$table;
		if($data){
			$this->db->insert_batch($table,$data);
			return $this->db->insert_id();
		}else{
			return false;
		}
	}

	/**
	 * 修改常见问题
	 */
	public function edit()
	{
		
	}

	/**
	 * 删除常见问题
	 */
	public function delete($where,$num=1,$table='')
	{
		$table = $table==''?$this->table:$table;
		if($num===1){
			$this->db->where($where);
		}else{
			$this->db->where_in($where[0],$where[1]);
		}
		$this->db->delete($table);
		return $this->db->affected_rows();
	}

	

}