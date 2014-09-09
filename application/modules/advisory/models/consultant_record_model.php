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
	/**
	 *	咨询者信息查询
	 */
	public function select($like)
	{
	
		$query = $this->db->query('select consultant_id,consultant_record_desc from crm_consultant_record where consultant_record_desc="'.$like.'"') ;
		$result = $query->result_array();
		
		//var_dump($result);die;
		return $result;
		}
	/**
	 *	咨询者信息连表查询
	 */
	public function select_consultant_record($like)
	{
		
		// $this->db->select('consultant.consultant_id')
		// 		 ->from($this->t)
		// 		 ->join('consultant','consultant.consultant_id='.$this->t.'.consultant_id','left')
		// 		 ->like($this->t.'.consultant_record_desc',$like)
		// 		 ->group_by("consultant.consultant_id");
		
		// $data=$this->db->get();
	
		
		// return $data->result_array();
	$query = $this->db->query('select ccr.consultant_id,ccr.consultant_record_desc,c.* from crm_consultant_record as ccr left join crm_consultant as c on ccr.consultant_id=c.consultant_id where c.is_student=0 and ccr.consultant_record_desc like "%'.$like.'%"') ;

		$result = $query->result_array();
		
		
		return $result;
		
	}
	/**
	 *	查询咨询者的咨询记录
	 */
	public function select_record_maxtime($consultant_id)
	{	
		$field='consultant_record_time';
		$this->db->select_max($field)
				 ->where('consultant_id',$consultant_id);
				 
		$data=$this->db->get($this->t);

        return $data->row_array();
		
	}
}