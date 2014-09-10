<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teaching_teaching_specialist_model extends CI_Model 
{
	private $s;#上门咨询记录统计表
	private $t;#时间提醒表
	private $c;#咨询者表
	private $p;#电话表
	private $q;#QQ表
	function __construct()
	{
		parent::__construct();
		$this->s=$this->db->dbprefix('setview_consultant_record');
		$this->t=$this->db->dbprefix('time_remind');
		$this->c=$this->db->dbprefix('consultant');
		$this->p=$this->db->dbprefix('consul_stu_phones');
		$this->q=$this->db->dbprefix('consul_stu_qq');
	}

	/**
	 * 查询所有的咨询形式
	 */
	public function getAll($start,$limit,$employee_id='',$start_time='',$end_time='',$search_name='',$key=''){

		$field = $this->t.'.*,'.$this->s.'.*,'.$this->c.'.`consultant_name`';
		$this->db->select($field);
		if(!empty($employee_id)){
			$this->db->where($this->t.'.employee_id',$employee_id);
		}

		$this->db->where($this->t.'.time_remind_time >=',$start_time);
		$this->db->where($this->t.'.time_remind_time <=',$end_time);

		$this->db->where_in($this->t.'.time_remind_status',array(0,1));

		$this->db->join($this->t,$this->s.'.time_remind_id='.$this->t.'.time_remind_id','left');
		$this->db->join($this->c,$this->t.'.consultant_id='.$this->c.'.consultant_id','left');

		if($search_name != ''){
			
			switch ($key) {
				case 'consultant_name':
					$this->db->where($this->c.'.consultant_name =',$search_name);
					break;
				case 'phones':
					$this->db->where($this->p.'.phone_number =',$search_name);
					$this->db->join($this->p,$this->t.'.consultant_id='.$this->p.'.consultant_id','left');
					break;
				case 'qq':
					$this->db->where($this->q.'.qq_number =',$search_name);
					$this->db->join($this->q,$this->t.'.consultant_id='.$this->q.'.consultant_id','left');
					break;
				
				default:
					# code...
					break;
			}

		}
		#$this->db->order_by('time_remind_time','asc'); 
		$this->db->order_by($this->t.'.employee_id','asc');  #固定排序（按员工ID从小到大）

		$this->db->limit($limit,$start);
		$data=$this->db->get($this->s);
        return $data->result_array();

	}


	/**
	 * 查询所有的咨询形式
	 */
	public function info_count($employee_id='',$start_time='',$end_time='',$search_name='',$key=''){

		if(!empty($employee_id)){
			$this->db->where($this->t.'.employee_id',$employee_id);
		}

		$this->db->where($this->t.'.time_remind_time >=',$start_time);
		$this->db->where($this->t.'.time_remind_time <=',$end_time);
			
		$this->db->where_in($this->t.'.time_remind_status',array(0,1));

		$this->db->join($this->t,$this->s.'.time_remind_id='.$this->t.'.time_remind_id');
		$this->db->join($this->c,$this->t.'.consultant_id='.$this->c.'.consultant_id','left');

		if($search_name != ''){
			
			switch ($key) {
				case 'consultant_name':
					$this->db->where($this->c.'.consultant_name =',$search_name);
					break;
				case 'phones':
					$this->db->where($this->p.'.phone_number =',$search_name);
					$this->db->join($this->p,$this->t.'.consultant_id='.$this->p.'.consultant_id','left');
					break;
				case 'qq':
					$this->db->where($this->q.'.qq_number =',$search_name);
					$this->db->join($this->q,$this->t.'.consultant_id='.$this->q.'.consultant_id','left');
					break;
				
				default:
					# code...
					break;
			}

		}

		return $this->db->count_all_results($this->s);
	}

	/**
	 * 获取到名字
	 */
	public function getName($id)
	{	
		$this->db->select('marketing_specialist_name')
			     ->where('marketing_specialist_id',$id);


		$data= $this->db->get($this->t);
		$name= $data->row_array();
		return $name['marketing_specialist_name'];
	}

	/**
	 * 获取到名字
	 */
	public function getOne($id)
	{	
		$this->db->select('marketing_specialist_name')
			     ->where('marketing_specialist_id',$id);


		$data= $this->db->get($this->t);
		$name= $data->row_array();
		return $name;
	}

}