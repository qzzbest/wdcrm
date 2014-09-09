<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_employee_model extends CI_Model 
{
	private $t;#员工表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('employee');
		$this->i=$this->db->dbprefix('integral');
		$this->s=$this->db->dbprefix('standard');
	}
	/**
	 * 管理员列表
	 */
	public function select_index($start,$limit,$employee_job_id,$start_time,$end_time)
	{
		$this->db->select('*')
				 ->join('employee_job', 'employee_job.employee_job_id='.$this->t.'.employee_job_id','left')
				 ->limit($limit,$start);
		if($employee_job_id!=''){
			$this->db->where('employee.employee_job_id',$employee_job_id);
		}		 

		$data=$this->db->get($this->t);
		
		$info = $data->result_array();
		
		foreach($info as $k=>$v){
			$sql="SELECT sum(integral) as c FROM ".$this->i." WHERE mark=".$v['employee_id']." AND state=1 AND date>=".$start_time." AND date<=".$end_time;
			$query=$this->db->query($sql);
			$info[$k]['inte']=$query->row_array();
			$sql2="select date as t from ".$this->i." WHERE mark=".$v['employee_id']." order by id DESC limit 1";
			$query=$this->db->query($sql2);
			$info[$k]['last_mark']=$query->row_array();
			$sql3="select count(state) as s from ".$this->i." WHERE mark=".$v['employee_id']." AND state=0";
			$query=$this->db->query($sql3);
			$info[$k]['state']=$query->row_array();
		}
		return $info;
	}
	/**
	 * 员工分页统计
	 */
	public function select_index_count($employee_job_id)
	{
		if ($employee_job_id!='') {
			$this->db->where('employee_job_id', $employee_job_id); 
		}
		return $this->db->count_all_results($this->t);
	}

	/**
	 * 查找所有的咨询师
	 */
	public function selectConsultantTeach()
	{

		$this->db->select('employee_id,employee_name')
				 ->join('employee_job', 'employee_job.employee_job_id ='.$this->t.'.employee_job_id', 'left')
				 ->where('employee_job_name','咨询师');

		$data=$this->db->get($this->t);

		return $data->result_array();

	}
	/**
	 * 查询员工名字
	 */
	public function select_employee($employee_id)
	{
		$this->db->select('employee_name')
				 ->where($this->t.'.employee_id',$employee_id);

		$data=$this->db->get($this->t);

		return $data->row_array();
	}
	/**
	 * 检测名字重复
	 */
	public function check($name,$id=false)
	{
		$this->db->where('admin_name', $name);
		if($id){

			$this->db->where('employee_id !=', $id);

		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}


	 /**
	 * 检测名字重复
	 */
	public function get_Intergral($id)
	{
		
		$sql = "SELECT * FROM ".$this->i." as a LEFT JOIN ".$this->t." as b ON a.mark_by=b.employee_id WHERE a.mark=".$id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	 /**
	 * 获取评分标准总则
	 */
	public function get_stand()
	{
		$sql0 = "SELECT * FROM ".$this->s." WHERE type=0";
		$query0 = $this->db->query($sql0);
		$stand[0] = $query0->result_array();

		$sql1 = "SELECT * FROM ".$this->s." WHERE type=1";
		$query1 = $this->db->query($sql1);
		$stand[1] = $query1->result_array();

		$sql2 = "SELECT * FROM ".$this->s." WHERE type=2";
		$query2 = $this->db->query($sql2);
		$stand[2] = $query2->result_array();
		return $stand;
	}


	/**
	 * 根据部门查询咨询师信息
	 */
	public function selectDepartment($employee_job_name)
	{
		$this->db->select('employee_id,employee_name')
				 ->join('employee_job', 'employee_job.employee_job_id ='.$this->t.'.employee_job_id', 'left')
				->where('employee_job_name',$employee_job_name);

		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	
	 /**
	 * 获取一条评分标准
	 */
	public function get_one_stand($id)
	{
		$sql = "SELECT * FROM ".$this->s." WHERE id=".$id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	/**
	 * 删除评分标准
	 */
	public function del_stand($id)
	{
		$sql = "delete from ".$this->s." WHERE id=".$id;
		$query = $this->db->query($sql);
	}

	/**
	 * 添加一条评分标准
	 */
	public function add_stand($c,$t,$r)
	{
		$sql = "INSERT INTO  ".$this->s." (`content`,`type`,`remark`)VALUES ('$c','$t','$r')";
		$query = $this->db->query($sql);
	}

	/**
	 * 编辑一条评分标准
	 */
	public function edit_stand($type,$cont,$remark,$id)
	{
		$sql = "UPDATE ".$this->s." SET type='$type',content = '$cont',remark = '$remark' WHERE id = '$id'";
		$query = $this->db->query($sql);
	}

	/**
	 * 通过一条评分审核
	 */
	public function pass_mark($id)
	{
		$sql = "UPDATE ".$this->i." SET state = 1 WHERE id = '$id'";
		$query = $this->db->query($sql);
		if($query){
			return 1;
		}
	}

	/**
	 * 评分审核不通过
	 */
	public function no_pass($id)
	{
		$sql = "UPDATE ".$this->i." SET state = -1 WHERE id = '$id'";
		$query = $this->db->query($sql);
		if($query){
			return 1;
		}
	}

	/**
	 * 更改评分审核
	 */
	public function actionPass()
	{
		# code...
	}

	/**
	 * 改变评分标准的类型
	 */
	public function move_stan($sheet,$type)
	{
		$sql = "UPDATE ".$this->s." SET type = $type WHERE id in ($sheet)";
		$query = $this->db->query($sql);
		if($query){
			return 1;
		}
	}

	/**
	 * 删除一条评分
	 */
	public function del_onemark($id){
		$sql = "delete from ".$this->i." WHERE id=".$id;
		$query = $this->db->query($sql);
	}

	/**
	 * 通讯录列表
	 */
	public function select_contact($start,$limit)
	{
		$this->db->select('*')
				 ->limit($limit,$start);
		 
		$data=$this->db->get($this->t);

		return $data->result_array();
	}
	/**
	 * 通讯录分页统计
	 */
	public function select_contact_count()
	{

		return $this->db->count_all_results($this->t);
	}
}