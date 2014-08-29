<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者表模型
 */
class Advisory_consultant_record_model extends CI_Model 
{
	private $t;#表名
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('consultant_record');
	}
		
	/**
	 *	查询学员的咨询记录（包括咨询者）
	 */
	public function select_student_record($start,$limit,$student_id,$consultant_id)
	{	
		$t=$this->t;

		$filed='*';
		
		$sql="(SELECT {$filed} FROM {$t} WHERE student_id=$student_id ORDER BY consultant_record_time DESC) UNION (SELECT {$filed} FROM {$t} WHERE consultant_id=$consultant_id  ORDER BY consultant_record_time DESC) LIMIT $start,$limit";
		
		$data= $this->db->query($sql);

        return $data->result_array();
		
	}
	/**
	 * 查询学员咨询记录总数
	 */
	public function student_record_count($student_id,$consultant_id)
	{	
		$t=$this->t;
		
		$sql="(SELECT count(*) FROM {$t} WHERE student_id=$student_id) UNION (SELECT count(*) FROM {$t} WHERE consultant_id=$consultant_id)";
		echo $sql;exit;
		$data= $this->db->query($sql);
		return $data->count_all_results($this->t);
	}
	/**
	 * 查询出第一条咨询记录
	 */
	public function selectfirsttime($id)
	{

		$this->db->select('consultant_record_time')
				 ->where('consultant_id',$id)
				 ->order_by('consultant_record_time ASC')
				 ->limit(1);



		$data=$this->db->get($this->t);
        return $data->row_array();

	}
	/**
	 * 删除多条记录
	 */
	public function deleteRecord($consultant_id,$ids)
	{

		$this->db->where('consultant_id',$consultant_id);
		$this->db->where_in('consultant_record_id',$ids);
		$this->db->delete($this->t);

		return $this->db->affected_rows();
	}
}