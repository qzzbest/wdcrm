<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 学生表模型
 */
class Teaching_student_model extends CI_Model 
{

	private $t;#表名
	private $employee_id;#员工id
	private $p; #员工的权限
	private $teach_id;#超级管理员选择的咨询师
	private $knowledge_id;#咨询师、管理员选择的知识点
	private $status = '';#学生知识点就读状态

	function __construct()
	{
		parent::__construct();
		$this->t=$this->db->dbprefix('student');
	}
	
	/**
	 * 初始化一下,辅助构造函数。
	 */
	public function init($id,$type='')
	{
		if( $type == '' ){

			$this->teach_id=$id;

		}else if( $type == 'k' ){

			$this->knowledge_id=$id;

		}else if( $type=='status' ){

			$this->status=$id;

		}
		
	}

	/**
	 * 管理员与超级管理员的区别
	 */
	private function _power()
	{
		//如果是普通管理员，只是查询出自己的咨询者
		/*if($this->p==0){
			$this->db->where('student.employee_id',$this->employee_id);
		}
		//管理员选择咨询师查看
		if($this->teach_id!=''){
			$this->db->where('student.employee_id',$this->teach_id);
		}*/

		if ($this->knowledge_id!=0||$this->status!='') {
			$this->db->join('student_knowleage_relation', 'student_knowleage_relation.student_id='.$this->t.'.student_id','left');
			$this->db->group_by('student_knowleage_relation.student_id');//按学生进行分组，避免重复
		}

		if($this->knowledge_id!=0){
			
			$this->db->where('student_knowleage_relation.knowledge_id',$this->knowledge_id);
		}


		if($this->status!= ''){

			$this->db->where('student_knowleage_relation.study_status',2);

		}
		
	}

	/**
	 * 学生列表 查询
	 */
	public function select_index($start,$limit,$key,$like='',$start_time='',$end_time='',$teach_id='',$where_other='')
	{

		$field=$this->t.'.student_id,'.$this->t.'.student_name,'.$this->t.'.student_sex,'.$this->t.'.sign_up_date,'.$this->t.'.consultant_id,'.$this->t.'.employee_id,'.$this->t.'.student_number,'.$this->t.'.student_status';

		$this->db->select($field);

		//权限
		$this->_power();

		//搜索
		if ($key !='' && $like !='') {
			$this->db->like($key,$like);
		}
		//上门日期
		if($start_time != '' && $end_time==''){
			$this->db->where($this->t.'.sign_up_date =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where($this->t.'.sign_up_date >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where($this->t.'.sign_up_date <=',$end_time);
	       	}
		}

		if(!empty($where_other)){
			$field .= 'student_knowleage_relation.*';
			if($where_other['select_type']==1){
				$this->db->where('student_knowleage_relation.study_status =',0);	
			}else if($where_other['select_type']==2){
				$this->db->where('student_knowleage_relation.study_status =',2);	
			}
			$this->db->where('student_knowleage_relation.knowledge_id =',$where_other['knownledge_id']);
			$this->db->join('student_knowleage_relation','student_knowleage_relation.student_id='.$this->t.'.student_id','left');
		}

		$this->db->order_by($this->t.'.student_number DESC');
		$this->db->order_by($this->t.'.sign_up_date DESC');
		$this->db->limit($limit,$start);
		$this->db->where($this->t.'.show_status',1);

		if($teach_id!==''){
			$this->db->where($this->t.'.employee_id =',$teach_id);
		}

		$data=$this->db->get($this->t);

		return $data->result_array();

	}
	/**
	 * 学生分页统计
	 */
	public function select_index_count($key='',$like='',$start_time='',$end_time='',$where_other='')
	{

		if ($like!='') {
			$this->db->like($key, $like); 
		}
		//上门日期
		if($start_time != '' && $end_time==''){
			$this->db->where($this->t.'.sign_up_date =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where($this->t.'.sign_up_date >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where($this->t.'.sign_up_date <=',$end_time);
	       	}
		}
		
		if(!empty($where_other)){
			if($where_other['select_type']==1){
				$this->db->where('student_knowleage_relation.study_status =',0);	
			}else if($where_other['select_type']==2){
				$this->db->where('student_knowleage_relation.study_status =',2);	
			}
			$this->db->where('student_knowleage_relation.knowledge_id =',$where_other['knownledge_id']);
			$this->db->join('student_knowleage_relation','student_knowleage_relation.student_id='.$this->t.'.student_id','left');
		}

		$this->db->where($this->t.'.show_status',1);

		//权限
		$this->_power();

		return $this->db->count_all_results($this->t);
	}
	/**
	 *  通过先查找学生的id得到后，在查找学生的数据，并分页
	 *	@param array $data  学生id的一维数组
	 *	@param int   $start 偏移量
	 *  @param int   $limit 每页显示多少条
	 */
	public function select_contact_like($data,$start,$limit)
	{

		$this->db->select($this->t.'.student_id,'.$this->t.'.student_name,'.$this->t.'.student_sex,'.$this->t.'.consultant_id,'.$this->t.'.sign_up_date,'.$this->t.'.employee_id,'.$this->t.'.student_number,'.$this->t.'.student_status')
				 ->where_in($this->t.'.student_id',$data)
				 ->order_by($this->t.".sign_up_date",'DESC')
				 ->limit($limit,$start)
				 ->where($this->t.'.show_status',1);

		$data=$this->db->get($this->t);

		return $data->result_array();

	}

	/**
	 * 通过学生 查询班级
	 */
	public function select_student_class($id)
	{
		$field='classroom.classroom_id,classroom.classroom_name,classroom.open_classtime,classroom.close_classtime';

		$this->db->select($field)
				 ->join('classroom','classroom.classroom_id=student_classroom_relation.classroom_id','left')
				 ->where('student_id',$id);

		$data=$this->db->get('student_classroom_relation');

		return $data->result_array();

	}
	/**
	 * 查询预学号
	 */
	public function select_number()
	{
		$field='student_number';

		$this->db->select($field);

		$this->db->order_by('student_number DESC');

		$this->db->limit(1,0);
		$this->db->where('show_status',1);

		$data=$this->db->get($this->t);

		return $data->result_array();
	
	}
	/**
	 * 检测身份证重复
	 */
	public function check($certificate,$id=false)
	{
		$this->db->where('certificate', $certificate);
		
		if($id){
			$this->db->where('student_id !=', $id);
		}

		$data=$this->db->get($this->t);

		return $data->row_array();
	}
}