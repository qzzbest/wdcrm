<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_stu_knowleage_model extends CI_Model 
{
	private $t;#咨询者的咨询形式表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('knowledge');
	}

	/**
	 * 查询学生和知识点关系
	 */
	public function getStuKnowleage($sql)
	{

    	$query = $this->db->query($sql);

    	return $query->result_array();

	}

}