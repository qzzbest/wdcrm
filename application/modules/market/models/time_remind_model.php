<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Market_time_remind_model extends CI_Model 
{
	private $t;#咨询者的咨询形式表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('time_remind');
	}
	
	/**
	 *	查询列表
	 */
	public function select_index($employee_id,$start,$limit,$start_time,$end_time)
	{
		$where = " `time_remind_status` in(0,1) and `employee_id`=$employee_id ";
		$limit = "  limit $start,$limit ";

		if($start_time != '' and $end_time==''){
			$where .= ' and FROM_UNIXTIME(`time_remind_time`,"%Y%m%d") = '.date('Ymd',$start_time);
			$limit = '';
		}else{
			if($start_time!=''){
	       		//$this->db->where('time_remind_time >=',$start_time);
	       		$where .= ' and `time_remind_time` >= '.$start_time;
	       		$limit = '';
	       	}
	       	if($end_time!=''){
	       		$where .= ' and `time_remind_time` <= '.$end_time;
	       		//$this->db->where('time_remind_time <=',$end_time);
	       		$limit = '';
	       	}
		}
       	

       	$sql = "SELECT * FROM `crm_time_remind` WHERE $where order by FROM_UNIXTIME(`time_remind_time`,'%Y%m%d%') asc, `is_important` desc, `is_set_view` asc,`time_remind_time` asc, `time_remind_status` desc $limit";

       	$query = $this->db->query($sql);
       	return $query->result_array();
	}
	/**
	 * 分页统计
	 */
	public function select_index_count($employee_id,$start_time,$end_time)
	{
		$this->db->where('employee_id',$employee_id)
				 ->where_in('time_remind_status', array(0,1));

		if($start_time != '' and $end_time==''){
			$this->db->where('FROM_UNIXTIME(`time_remind_time`,"%Y%m%d") =',date('Ymd',$start_time));
		}else{
			if($start_time!=''){
	       		$this->db->where('time_remind_time >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where('time_remind_time <=',$end_time);
	       	}
		}

		return $this->db->count_all_results($this->t);
	}
	/**
	 * 通过联系方式查找到的咨询者
	 */
	public function select_contact_like($data,$start,$limit,$employee_id,$start_time,$end_time)
	{

		$this->db->select('*');
		$this->db->where($this->t.'.employee_id',$employee_id);
		$this->db->where_in($this->t.'.time_remind_status', array(0,1));
		$this->db->where_in($this->t.'.consultant_id',$data);
		

		if($start_time != '' and $end_time==''){
			$this->db->where('FROM_UNIXTIME('.$this->t.'.`time_remind_time`,"%Y%m%d") =',date('Ymd',$start_time));
		}else{
			if($start_time!=''){
	       		$this->db->where($this->t.'.time_remind_time >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where($this->t.'.time_remind_time <=',$end_time);
	       	}
		}

		$this->db->order_by($this->t.".time_remind_time","asc");
		$this->db->order_by($this->t.".is_important","desc");
		$this->db->order_by($this->t.".is_set_view","desc");
		$this->db->order_by($this->t.".time_remind_status","desc");
		$this->db->limit($limit,$start);

		$data=$this->db->get($this->t);

		return $data->result_array();

	}
	/**
	 * 通过联系方式查找到的咨询者
	 */
	public function select_contact_count($data,$employee_id,$start_time,$end_time)
	{

		$this->db->select('*');
		$this->db->where($this->t.'.employee_id',$employee_id);
		$this->db->where_in($this->t.'.time_remind_status', array(0,1));
		$this->db->where_in($this->t.'.consultant_id',$data);

		if($start_time != '' and $end_time==''){
			$this->db->where('FROM_UNIXTIME('.$this->t.'.`time_remind_time`,"%Y%m%d") =',date('Ymd',$start_time));
		}else{
			if($start_time!=''){
	       		$this->db->where($this->t.'.time_remind_time >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where($this->t.'.time_remind_time <=',$end_time);
	       	}
		}	

		return $this->db->count_all_results($this->t);
	}
	/**
	 *	查询
	 */
	public function select($id)
	{
	
		$this->db->select('*')
				 ->where_in('time_remind_id', $id)
				 ->order_by("time_remind_status","desc")
				 ->order_by("time_remind_time","desc");
		
		$data=$this->db->get($this->t);
	
		return $data->result_array();
		
	}
	/**
	 * 通过姓名查找到的咨询者
	 */
	public function select_consultant($employee_id,$like='',$start,$limit,$start_time,$end_time)
	{
		$this->db->select('*');

		$this->db->where($this->t.'.employee_id',$employee_id);
		$this->db->where_in($this->t.'.time_remind_status', array(0,1));

		if($start_time != '' and $end_time==''){
			$this->db->where('FROM_UNIXTIME('.$this->t.'.`time_remind_time`,"%Y%m%d") =',date('Ymd',$start_time));
		}else{
			if($start_time!=''){
	       		$this->db->where($this->t.'.time_remind_time >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where($this->t.'.time_remind_time <=',$end_time);
	       	}
		}

		$this->db->join('consultant','consultant.consultant_id='.$this->t.'.consultant_id','left');
		$this->db->like('consultant_name', $like);
		$this->db->order_by($this->t.".time_remind_time","asc");
		$this->db->order_by($this->t.".is_important","desc");
		$this->db->order_by($this->t.".is_set_view","desc");
		$this->db->order_by($this->t.".time_remind_status","desc");
		$this->db->limit($limit,$start);


		$data=$this->db->get($this->t);
	
		return $data->result_array();
	}
	/**
	 * 通过姓名查找到的咨询者分页
	 */
	public function select_consultant_count($like='',$employee_id,$start_time,$end_time)
	{
		$this->db->select('*');

		$this->db->where($this->t.'.employee_id',$employee_id);
		$this->db->where_in($this->t.'.time_remind_status', array(0,1));

		if($start_time != '' and $end_time==''){
			$this->db->where('FROM_UNIXTIME('.$this->t.'.`time_remind_time`,"%Y%m%d") =',date('Ymd',$start_time));
		}else{
			if($start_time!=''){
	       		$this->db->where($this->t.'.time_remind_time >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where($this->t.'.time_remind_time <=',$end_time);
	       	}
		}

		$this->db->from($this->t);
		$this->db->join('consultant','consultant.consultant_id='.$this->t.'.consultant_id','left');
		$this->db->like('consultant_name', $like);

		return $this->db->count_all_results();
	}

	/**
	 * 删除提醒
	 */
	public function deleteTimeRemind($where='')
	{
		if($where==''){
			$w = 1;
		}else{
			$w = $where;
		}
		$sql = 'DELETE FROM '.$this->t.' where '.$w;
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
}