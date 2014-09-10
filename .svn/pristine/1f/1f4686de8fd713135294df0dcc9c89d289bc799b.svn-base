<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者表
 */
class Market_market_model extends CI_Model 
{
	private $t;#表名
	private $employee_id;#员工id
	private $p; #员工的权限
	private $teach_id;#超级管理员选择的咨询师
	function __construct()
	{
		parent::__construct();
		
		$this->t = $this->db->dbprefix('market'); 

		$this->p = getcookie_crm('employee_power');
		$this->employee_id= getcookie_crm('employee_id');

	}
	/**
	 * 初始化一下,辅助构造函数。
	 */
	public function init($id)
	{
		$this->teach_id=$id;
	}

	/**
	 * 管理员与超级管理员的区别
	 */
	private function _power()
	{
		//如果是普通管理员，只是查询出自己的咨询者
		if($this->p==0){
			$this->db->where('employee_id',$this->employee_id);
		}
		if($this->p==1){ //如果是超级管理员
			//管理员选择咨询师查看
			if($this->teach_id!==''){
				$this->db->where('employee_id',$this->teach_id);
			}
		}
		
	}

	/**
	 * 咨询者列表 查询
	 */
	public function select_index($start,$limit,$order=0,$start_time,$end_time,$employee_id='',$key='',$like='')
	{
		$field='*';

		$this->db->select($field);

		//权限限制
		$this->_power();
		//搜索
		if ($key !='' && $like !='') {
			$this->db->like($key,$like);
		}
		//排序
		if($order==1){
			$this->db->order_by('login_date ASC');
		}else{
			$this->db->order_by('login_date DESC');
		}
		//搜索日期
		if($start_time != '' && $end_time==''){
			$this->db->where('login_date =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where('login_date >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where('login_date <=',$end_time);
	       	}
		}
		//市场专员
		if($employee_id!=''){
			$this->db->where('employee_id',$employee_id);
		}
		$this->db->where('show_status',1);
		$this->db->limit($limit,$start);
		$data=$this->db->get($this->t);

		return $data->result_array();
	
	}

	/**
	 * 咨询列表分页统计
	 */
	public function select_index_count($start_time,$end_time,$employee_id='',$key='',$like='')
	{

		//权限
		$this->_power();
		//搜索
		if ($key !='' && $like !='') {
			$this->db->like($key,$like);
		}
		//搜索日期
		if($start_time != '' && $end_time==''){
			$this->db->where('login_date =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where('login_date >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where('login_date <=',$end_time);
	       	}
		}
		if($employee_id!=''){
			$this->db->where('employee_id',$employee_id);
		}
		$this->db->where('show_status',1);
		return $this->db->count_all_results($this->t);
	}

	/**
	 * 检查操作的咨询者是否
	 */
	public function checkData($id,$type)
	{
		//如果是超级管理员
		if($this->p==1){
			return 1;
		}
		$this->db->select('employee_id');

		if($type=='in'){
			$this->db->where_in('market_id',$id);
		}else{
			$this->db->where('market_id',$id);
		}

		$data=$this->db->get($this->t);

		$res= $data->result_array();


		foreach ($res as $key => $value) {
			if($value['employee_id']!=$this->employee_id){
				return 0; //表示操作了不属于他的数据
			}
		}
		
		return 1;//表示通过数据校验
	}
}