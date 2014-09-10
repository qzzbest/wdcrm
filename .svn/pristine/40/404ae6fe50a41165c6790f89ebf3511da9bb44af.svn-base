<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 班级模型
 */
class P_classroom_model extends CI_Model 
{

	private $t;#班级表
	private $t1;#班级类型表
	private $t2;#班级知识点关系表
	private $t3;#知识点表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('classroom');
		$this->t1=$this->db->dbprefix('classroom_type');
		$this->t2=$this->db->dbprefix('classroom_knowledge_relation');
		$this->t3=$this->db->dbprefix('knowledge');
	}

	/**
	 * 班级信息
	 */
	public function classroom_info($where,$select='')
	{		
		if ($select!='') {
			$this->db->select($select);
		}

		$this->db->where($where);
		$data= $this->db->get($this->t);
		
		return $data->row_array();
	}

	/**
	 * 班级信息
	 */
	public function classroom_info_all($where,$select='')
	{		
		if ($select!='') {
			$this->db->select($select);
		}

		$this->db->where($where);
		$this->db->join($this->t1, $this->t1.'.classroom_type_id='.$this->t.'.classroom_type_id','left');
		$data= $this->db->get($this->t);
		
		return $data->row_array();
	}

	/**
	 * 更新班级信息
	 */
	public function update_classroom_info($where,$data)
	{		
		$this->db->where($where);
		$this->db->update($this->t,$data);		    
	}

	/**
	 * 班级分类信息
	 */
	public function classroom_type_info($where='',$select='')
	{		
		if ($select!='') {
			$this->db->select($select);
		}
		if($where!=''){
			$this->db->where($where);
		}
		
		$data= $this->db->get($this->t1);
		
		return $data->row_array();
	}

	/**
	 * 班级课程、知识点进度
	 */
	public function classroom_knowledge_info($where='',$select='')
	{		
		if ($select!='') {
			$this->db->select($select);
		}

		$this->db->where($where);
		$this->db->join($this->t3, $this->t3.'.knowledge_id='.$this->t2.'.knowledge_id','left');
		$data= $this->db->get($this->t2);
		
		return $data->result_array();
	}
}