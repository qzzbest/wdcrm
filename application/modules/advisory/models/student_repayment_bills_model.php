<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_student_repayment_bills_model extends CI_Model 
{
	private $t;#学员还款账单表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('student_repayment_bills');
		$this->t1=$this->db->dbprefix('refund_loan_time');
	}

	/**
	 * 查询该笔还款的基本信息
	 */
	public function getOne($id)
	{
		
		$this->db->select('student_id,consultant_id,payment_type_id,study_expense,already_payment,position_total,position_total_date,payment_desc,apply_money,organization_paydate,student_start_paydate,apply_desc')
			 	 ->where('repayment_id',$id);

		$data= $this->db->get($this->t);

		return $data->row_array();
	}

	/**
	 * 查询该账单的详细信息
	 */
	public function getInfo($where)
	{
		
		$this->db->select('student_id,payment_type_id,study_expense,already_payment,position_total,position_total_date,payment_desc,apply_money,organization_paydate,student_start_paydate,apply_desc')
			 	 ->where($where);

		$data= $this->db->get($this->t);

		return $data->row_array();
	}

	/**
	 * 获取所有的缴费记录
	 */
	public function query($field,$where)
	{	
		$sql = "select $field from ".$this->t1." where $where";
		$query = $this->db->query($sql);

		return $query->result_array();
	}

	/**
	 * 修改已缴学费
	 */
	public function changeAlreadyPayment($money,$id)
	{

		$sql = 'UPDATE '.$this->t.' SET `already_payment` = `already_payment` + '.$money.' WHERE repayment_id = '.$id;
		$this->db->query($sql);

		return $this->db->affected_rows();
	
	}

	/**
	 * 获取最早的缴费日期
	 */
	public function course_payment_time($record_where)
	{
	  	$record_course_info = $this->main_data_model->getOtherAll('already_paytime',$record_where,'refund_loan_time');

	  	if( !empty($record_course_info) ){
	  		foreach ($record_course_info as $key => $value) {
	  			if( empty($value['already_paytime']) || $value['already_paytime'] == 0 ){
	  				unset($record_course_info[$key]);
	  				continue;
	  			}
	  		}
	  	}

	  	if( !empty($record_course_info) ){
		  	//转化成一维数组
			$record_course_info = array_multi2single($record_course_info);
			return min($record_course_info);
		}else{
			return '';
		}
	}
	/**
	 * 获取学员id和学员对应的咨询者id
	 */
	public function student_number($repayment_id)
	{
	  	$this->db->select('student.student_id,student.consultant_id')
				 ->join('student','student.student_id='.$this->t.'.student_id','left')
				 ->where($this->t.'.repayment_id',$repayment_id);
				 
		$data=$this->db->get($this->t);

        return $data->row_array();
	}

	/**
	 * 获取学员id和学员对应的咨询者id
	 */
	public function consultant_number($repayment_id)
	{
	  	$this->db->select('consultant.consultant_id')
				 ->join('consultant','consultant.consultant_id='.$this->t.'.consultant_id','left')
				 ->where($this->t.'.repayment_id',$repayment_id);
				 
		$data=$this->db->get($this->t);

        return $data->row_array();
	}

	/**
	 * 获取课程的学员id
	 */
	function studentIdSelect($data)
	{
		$this->db->select('student_id');
		$this->db->where_in('repayment_id',$data);
		$data=$this->db->get($this->t);
		
		$student_arr= $data->result_array();

		$result=array();
		//过滤重复的学生id
		foreach ($student_arr as $value) {
			if(!in_array($value['student_id'],$result)){
				$result[]=$value['student_id'];
			}
		}

		return $result;
	}

	/**
	 * 删除账单
	 */
	public function deleteRepaymentBills($where='')
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