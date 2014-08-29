<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_stu_curriculum_model extends CI_Model 
{
	private $t;#咨询者的咨询形式表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('curriculum_system');
	}

	/**
	 * 查询学生和课程关系
	 */
	public function getStuCourse($sql)
	{

    	$query = $this->db->query($sql);

    	return $query->result_array();
	}

}