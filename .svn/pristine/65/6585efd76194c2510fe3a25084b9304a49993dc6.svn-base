<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Advisory_refund_loan_time_model extends CI_Model 
{
	private $t;#还款、放款时间表
	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('refund_loan_time');
		$this->t1=$this->db->dbprefix('student');
		$this->t2=$this->db->dbprefix('consultant');
		$this->t3=$this->db->dbprefix('student_repayment_bills');
	}
	
	/**
	 *	查询多条缴费记录
	 *  @param  $field  string 查询字段
	 *  @param  $where  string 查询条件
	 *  @param  $table  string 表名
	 *  @return 返回缴费记录数据
	 */
	public function getAll($field='*',$where='',$table='',$order_field='',$by='desc')
	{
		$table = $table != '' ? $this->db->dbprefix($table) : $this->t;
		$sql = "SELECT $field FROM ".$table;
		if($where!=''){
			$sql .= " WHERE $where ";
		}
		if($order_field != ''){
			$sql .= " order by ".$order_field." $by";
		}

		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/**
	 *	查询
	 */
	public function select($edit)
	{
	
		$where=array('repayment_id'=>$edit);
		$this->db->where($where)
				 ->order_by('payment_time asc');
		$data=$this->db->get($this->t);
	
		
		return $data->result_array();
		
	}

	/**
	 * 查询该还款、放款时间表的记录所属还款ID
	 */
	public function selectStudentId($id)
	{
		$this->db->select('student_id');
		$this->db->where('id', $id);

		$data= $this->db->get($this->t);

		return $data->row_array();
			
	}

	/**
	 * 查询该还款、放款时间表的记录所属还款ID
	 */
	public function selectConsultantId($id)
	{
		$this->db->select('consultant_id');
		$this->db->where('id', $id);

		$data= $this->db->get($this->t);

		return $data->row_array();
			
	}

	/**
	 * 查询账单表的记录所属学生ID
	 */
	public function paymentStudentId($payment_id)
	{
		$this->db->select('student_id');
		$this->db->where('repayment_id', $payment_id);

		$data= $this->db->get($this->t);

		return $data->row_array();
			
	}

	/**
	 * 查询账单表的记录所属学生ID
	 */
	public function paymentConsultantId($payment_id)
	{
		$this->db->select('consultant_id');
		$this->db->where('repayment_id', $payment_id);

		$data= $this->db->get($this->t);

		return $data->row_array();
			
	}

	/**
	 *	统计缴费记录的总学费（未缴费和完成缴费）
	 */
	public function count_payment($paywhere)
	{
		$count_sql = 'SELECT SUM(`payment_money`) AS c FROM '.$this->t.' WHERE '.$paywhere;
		$count_money = $this->db->query($count_sql);
		$res = $count_money->row_array();
		return $res['c'];
	}	
	
	/**
	 *	统计缴费记录的总记录数
	 */
	public function count_refund_loan($where,$start_search_time,$end_search_time,$channel_id='',$statistics_id='',$employee_id='')
	{

		$paywhere = 't.`payment_type` in(0,2,3) and t.`payment_money` > 0 and t.`already_paytime` != 0';
		//要排除没有完成付款的分期付款记录

		if(!empty($channel_id)){
			$paywhere .= ' and t2.`consultant_channel_id` = '.$channel_id;
		}
		if(!empty($statistics_id)){
			$paywhere .= ' and t2.`marketing_specialist_id` = '.$statistics_id;
		}
		if(!empty($employee_id)){
			$paywhere .= ' and t2.`employee_id` = '.$employee_id;
		}

		$paywhere .= $where;

		$count_sql = 'SELECT SUM(t.`payment_money`) AS c FROM '.$this->t.' as t left join '.$this->t2.' as t2 on t.`consultant_id` = t2.`consultant_id` left join '.$this->t3.' as t3 on t.repayment_id=t3.repayment_id WHERE '.$paywhere ;

		$count_money = $this->db->query($count_sql);
		$res = $count_money->row_array();
		return $res['c'];

	}	

	/**
	 *	查询还款表的具体信息（学生ID、咨询者ID、渠道ID、市场专员ID、咨询师ID）
	 */
	public function select_refund_loan($field,$start,$limit,$start_search_time,$end_search_time,$channel_id='',$statistics_id='',$employee_id='',$start_time='',$end_time='',$search_name='')
	{
		
		$this->db->select($field);

		if(!empty($channel_id)){
			$this->db->where($this->t2.'.consultant_channel_id',$channel_id);
		}
		if(!empty($statistics_id)){
			$this->db->where($this->t2.'.marketing_specialist_id',$statistics_id);
		}
		if(!empty($employee_id)){
			$this->db->where($this->t2.'.employee_id',$employee_id);
		}
		
		if($search_name != ''){
			$this->db->where($this->t2.'.consultant_name =',$search_name);
		}else{
			if(!empty($start_time)){
				if(!empty($start_time) && empty($end_time)){
					$this->db->where($this->t.'.already_paytime =',$start_time);
				}elseif(!empty($start_time) && !empty($end_time)){
					$this->db->where($this->t.'.already_paytime >=',$start_time);
					$this->db->where($this->t.'.already_paytime <=',$end_time);
				}
			}else{
				$this->db->where($this->t.'.already_paytime >=',$start_search_time);
				$this->db->where($this->t.'.already_paytime <=',$end_search_time);
			}
		}

		$this->db->limit($limit,$start);

		//$this->db->where($this->t3.'.is_fail',1);
		//$this->db->where($this->t.'.payment_status',1);
		$this->db->where_in($this->t.'.payment_type',array(0,2,3));
		//$this->db->join($this->t1,$this->t1.'.student_id='.$this->t.'.student_id');
		$this->db->join($this->t2,$this->t.'.consultant_id='.$this->t2.'.consultant_id');
		$this->db->join($this->t3,$this->t.'.repayment_id='.$this->t3.'.repayment_id');
		$this->db->order_by($this->t.'.already_paytime desc');
		$data=$this->db->get($this->t);
		
		return $data->result_array();
		
	}

	/**
	 * 咨询列表分页统计
	 */
	public function select_refund_count($start_search_time,$end_search_time,$channel_id='',$statistics_id='',$employee_id='',$start_time='',$end_time='',$search_name='')
	{
		if(!empty($channel_id)){
			$this->db->where($this->t2.'.consultant_channel_id',$channel_id);
		}
		if(!empty($statistics_id)){
			$this->db->where($this->t2.'.marketing_specialist_id',$statistics_id);
		}
		if(!empty($employee_id)){
			$this->db->where($this->t2.'.employee_id',$employee_id);
		}

		if($search_name != ''){
			$this->db->where($this->t2.'.consultant_name =',$search_name);
		}else{
			if(!empty($start_time)){
				if(!empty($start_time) && empty($end_time)){
					$this->db->where($this->t.'.already_paytime =',$start_time);
				}elseif(!empty($start_time) && !empty($end_time)){
					$this->db->where($this->t.'.already_paytime >=',$start_time);
					$this->db->where($this->t.'.already_paytime <=',$end_time);
				}
			}else{
				$this->db->where($this->t.'.already_paytime >=',$start_search_time);
				$this->db->where($this->t.'.already_paytime <=',$end_search_time);
			}
		}

		//$this->db->where($this->t3.'.is_fail',1);
		//$this->db->where($this->t.'.payment_status',1);
		$this->db->where_in($this->t.'.payment_type',array(0,2,3));
		//$this->db->join($this->t1,$this->t1.'.student_id='.$this->t.'.student_id');
		$this->db->join($this->t2,$this->t.'.consultant_id='.$this->t2.'.consultant_id');
		$this->db->join($this->t3,$this->t.'.repayment_id='.$this->t3.'.repayment_id');

		return $this->db->count_all_results($this->t);
	}

	/**
	 * 统计总额
	 */
	public function countMoney($start_search_time,$end_search_time,$channel_id='',$statistics_id='',$employee_id='',$start_time='',$end_time='',$search_name='')
	{
		$field = $this->t.'.repayment_id';

		$this->db->select($field);

		$this->db->select($this->t.'.payment_money');
		if(!empty($channel_id)){
			$this->db->where($this->t2.'.consultant_channel_id',$channel_id);
		}
		if(!empty($statistics_id)){
			$this->db->where($this->t2.'.marketing_specialist_id',$statistics_id);
		}
		if(!empty($employee_id)){
			$this->db->where($this->t2.'.employee_id',$employee_id);
		}

		if($search_name != ''){
			$this->db->where($this->t2.'.consultant_name =',$search_name);
		}else{
			if(!empty($start_time)){
				if(!empty($start_time) && empty($end_time)){
					$this->db->where($this->t.'.already_paytime =',$start_time);
				}elseif(!empty($start_time) && !empty($end_time)){
					$this->db->where($this->t.'.already_paytime >=',$start_time);
					$this->db->where($this->t.'.already_paytime <=',$end_time);
				}
			}else{
				$this->db->where($this->t.'.already_paytime >=',$start_search_time);
				$this->db->where($this->t.'.already_paytime <=',$end_search_time);
			}
		}

		//$this->db->where($this->t3.'.is_fail',1);
		//$this->db->where($this->t.'.payment_status',1);
		$this->db->where_in($this->t.'.payment_type',array(0,2,3));
		//$this->db->join($this->t1,$this->t1.'.student_id='.$this->t.'.student_id');
		$this->db->join($this->t2,$this->t.'.consultant_id='.$this->t2.'.consultant_id');
		$this->db->join($this->t3,$this->t.'.repayment_id='.$this->t3.'.repayment_id');
		$data=$this->db->get($this->t);

		$result = $data->result_array();

		$count_money = 0;
		if(!empty($result)){
			//$repay_arr = array();
			foreach ($result as $key => $value) {
				$count_money += $value['payment_money'];	
				//$repay_arr[] = $value['repayment_id'];
			}

			#业绩统计 （要排除超出的金额：注意重复的repayment_id）
			/*$repay_arr = array_unique($repay_arr);
			$otherMoney = 0;
			foreach ($repay_arr as $key => $value) {
				#查账单表（处理超出的金额）
				$this->db->select('study_expense,already_payment')
			 	 ->where('repayment_id',$value);
			    $data= $this->db->get('student_repayment_bills');
			    $bills_info = $data->row_array();
			    if($bills_info['already_payment']>$bills_info['study_expense']){
			    	$otherMoney += $bills_info['already_payment'] - $bills_info['study_expense'];
			    }
			}
			    $count_money -= $otherMoney;*/
				
		}

		return $count_money;
	}

	/**
	 * 删除缴费记录
	 */
	public function deletePayment($where='')
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