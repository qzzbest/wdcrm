<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_consulting_questions_model extends CI_Model 
{
	private $table;#咨询常见问题表
	function __construct()
	{
		parent::__construct();
		$this->table=$this->db->dbprefix('consulting_questions');
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
	public function select($fields,$start,$limit,$where='',$table='',$like_name='')
	{
		$table = $table==''?$this->table:$table;
		if($where!=''){
			$where = " where $where";
		}else{
			$where = "";
		}

		if($like_name!=''){
			$like = " where	 `questions_name` like '%$like_name' or `questions_name` like '%$like_name%' or `questions_name` like '$like_name%'";
		}else{
			$like = "";
		}


		$sql = "select $fields from ".$table." $where $like";
		$query = $this->db->query($sql);
		return $query->result_array();

		// $this->db->select($fields);

		// if($where!=''){
		// 	$this->db->where($where);
		// }	

		// $this->db->limit($limit,$start);

		// $data = $this->db->get($table);	    
		// return $data->result_array();     
	}

	/**
	 * 咨询常见问题列表
	 */
	public function select_count($where='',$table='',$like_name='')
	{
		$table = $table==''?$this->table:$table;

		if($where!=''){
			$this->db->where($where);
		}
		if($like_name!=''){
			$this->db->like('questions_name',$like_name);
		}

		return $this->db->count_all_results($this->table);
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
	 * 修改常见问题
	 */
	public function edit($where,$data,$table='')
	{
		$table = $table==''?$this->table:$table;
		$this->db->where($where);
		$this->db->update($table,$data);
		return $this->db->affected_rows();
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