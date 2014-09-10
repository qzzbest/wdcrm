<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生报读课程表模型
 */
class Teaching_student_knowleage_relation_model extends CI_Model 
{
	private $t;#表名
	private $t1;#表名
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('student_knowleage_relation'); 

	}


	/**
	 *  连表查询学生所报全部的知识点,课程体系进行组合
	 */
	public function select_index($student_id,$repayment_id)
	{
		$sql="SELECT crm_student_repayment_bills.*,crm_student_knowleage_relation.student_id,crm_student_knowleage_relation.repayment_id,crm_student_knowleage_relation.curriculum_system_id,group_concat(knowledge_id)as k_id, group_concat(curriculum_system_id)as c_id FROM crm_student_knowleage_relation LEFT JOIN crm_student_repayment_bills ON crm_student_repayment_bills.repayment_id = crm_student_knowleage_relation.repayment_id WHERE crm_student_knowleage_relation.student_id=".$student_id." AND crm_student_knowleage_relation.repayment_id=".$repayment_id." group by crm_student_knowleage_relation.repayment_id";
		
		$data= $this->db->query($sql);

        return $data->row_array();
	}
	/**
	 *  查询学生所报课程的名称
	 */
	public function select_curriculum($curriculum_system_id)
	{
		$data=$this->db->select('curriculum_system_name')
				 	   ->where_in('curriculum_system_id',$curriculum_system_id)
				 	   ->get('curriculum_system');
        $res=array();
		foreach ($data->result_array() as  $value) {
			$res[]= $value['curriculum_system_name'];
		}
        return $res;
	}
	/**
	 *  查询学生所报知识点名称
	 */
	public function select_knowledge($knowledge_id)
	{
		$data=$this->db->select('knowledge_name')
				 	   ->where_in('knowledge_id',$knowledge_id)
				 	   ->get('knowledge');
		$res=array();
		foreach ($data->result_array() as  $value) {
			$res[]= $value['knowledge_name'];
		}
        return $res;
	}
	/**
	 *  查询学生所报一次课程体系和知识点
	 */
	public function select_one($repayment_id)
	{
		$sql="SELECT crm_student_repayment_bills.*,crm_student_knowleage_relation.student_id,crm_student_knowleage_relation.repayment_id,crm_student_knowleage_relation.curriculum_system_id,group_concat(knowledge_id)as k_id, group_concat(curriculum_system_id)as c_id FROM crm_student_knowleage_relation LEFT JOIN crm_student_repayment_bills ON crm_student_repayment_bills.repayment_id = crm_student_knowleage_relation.repayment_id WHERE crm_student_knowleage_relation.repayment_id=".$repayment_id." group by crm_student_knowleage_relation.repayment_id";
		
		$data= $this->db->query($sql);

        return $data->row_array();
	}
	
}