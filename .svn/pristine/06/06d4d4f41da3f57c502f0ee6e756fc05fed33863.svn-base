<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 学生表模型
 */
class Advisory_student_model extends CI_Model 
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
		$this->t1=$this->db->dbprefix('employee');

		$this->p = getcookie_crm('employee_power');
		$this->employee_id= getcookie_crm('employee_id');
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

		}else if( $type == 'c' ){

			$this->curriculum_system_id=$id;

		}else if( $type=='status' ){

			if($id == 1){  #已读
				$this->status = array(1,2,3);
			}else if($id == 2){ #复读
				$this->status = array(2);
			}else{
				$this->status=$id; #未读
			}

		}
		
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
		if($this->p==2){#人事、就业
			return 1;
		}
		$this->db->select('employee_id');

		if($type=='in'){
			$this->db->where_in('student_id',$id);
		}else{
			$this->db->where('student_id',$id);
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

	/**
	 * 管理员与超级管理员的区别
	 */
	private function _power($type='')
	{
		//如果是普通管理员，只是查询出自己的咨询者
		if($this->p==0){
			$this->db->where('student.employee_id',$this->employee_id);
		}
		//管理员选择咨询师查看
		if($this->teach_id!=''){
			$this->db->where('student.employee_id',$this->teach_id);
		}

		// if($this->knowledge_id==0 && $this->curriculum_system_id==0){
		// 	$this->db->join('student_knowleage_relation', 'student_knowleage_relation.student_id='.$this->t.'.student_id','left');
		// }

		if($this->knowledge_id!=0){
			$this->db->join('student_knowleage_relation', 'student_knowleage_relation.student_id='.$this->t.'.student_id','left');
			$this->db->where('student_knowleage_relation.knowledge_id',$this->knowledge_id);
		}

		if($this->curriculum_system_id!=0){
			$this->db->join('student_knowleage_relation', 'student_knowleage_relation.student_id='.$this->t.'.student_id','left');
			$this->db->group_by('student_knowleage_relation.student_id');
			$this->db->where('student_knowleage_relation.curriculum_system_id',$this->curriculum_system_id);
		}


		if($this->status!= '' && $type==''){
			$this->db->join('student_knowleage_relation', 'student_knowleage_relation.student_id='.$this->t.'.student_id','left');
			if(is_array($this->status)){
				//$this->db->join('student_knowleage_relation', 'student_knowleage_relation.student_id='.$this->t.'.student_id','left');
				$this->db->where_in('student_knowleage_relation.study_status',$this->status);
				$this->db->group_by('student_knowleage_relation.student_id');//按学生进行分组，避免重复
			}else{
				$this->db->where('student_knowleage_relation.study_status',$this->status);
			}	

		}else if($this->status!= '' && $type!=''){
			$this->db->join('student_knowleage_relation', 'student_knowleage_relation.student_id='.$this->t.'.student_id','left');
			if(is_array($this->status)){
				//$this->db->join('student_knowleage_relation', 'student_knowleage_relation.student_id='.$this->t.'.student_id','left');
				$this->db->where_in('student_knowleage_relation.study_status',$this->status);
			}else{
				$this->db->where('student_knowleage_relation.study_status',$this->status);
			}	
		}
		
	}

	/**
	 *	查看学生的信息
	 */
	public function getStudentInfo($field,$where='')
	{
		$this->db->select($field);
		if(!empty($where)){
			$this->db->where($where);
		}
		$data = $this->db->get($this->t);
		return $data->row_array();		 
	}

	/**
	 *  更新意向课程
	 */
	public function editIntentionCourse($where,$data)
	{
		$this->db->where($where);
		$this->db->update($this->t,$data);		                               
	}

	/**
	 * 学生列表 查询
	 */
	public function select_index($start,$limit,$key,$like='',$start_time,$end_time,$order=0)
	{

		$field=$this->t.'.student_id,'.$this->t.'.student_name,'.$this->t.'.student_sex,'.$this->t.'.sign_up_date,'.$this->t.'.consultant_id,'.$this->t.'.employee_id,'.$this->t.'.student_number,'.$this->t.'.show_status,'.$this->t.'.old_employee_id';

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
		
		if ($order==1) {
			$this->db->order_by($this->t.'.sign_up_date ASC');
		}else{
			$this->db->order_by($this->t.'.sign_up_date DESC');
		}
		$this->db->limit($limit,$start);
		$this->db->where($this->t.'.show_status',1);

		$data=$this->db->get($this->t);

		return $data->result_array();

	}

	/**
	 * 学生分页统计
	 */
	public function select_index_count($key='',$like='',$start_time,$end_time)
	{
		//权限
		$this->_power('count');


		if ($like!='') {
			$this->db->like($key, $like); 
		}

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

		
		$this->db->where($this->t.'.show_status',1);
		return $this->db->count_all_results($this->t);
	}


		
	/**
	 *	分页查询，分资讯形式、渠道的不同查询
	 */
	public function consultate_channel($start,$limit,$arr,$start_time,$end_time,$order=0)
	{	
		
		$this->db->select($this->t.'.student_id,'.$this->t.'.student_sex,'.$this->t.'.student_name,'.$this->t.'.consultant_id,'.$this->t.'.sign_up_date,'.$this->t.'.employee_id,'.$this->t.'.student_number,'.$this->t.'.show_status,'.$this->t.'.old_employee_id')
			     ->from($this->t)
				 ->join('consultant', 'consultant.consultant_id='.$this->t.'.consultant_id','left');

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
		
		$this->db->where("consultant.$arr[0] =".$arr[1]);

		$this->_power();
		if ($order==1) {
			$this->db->order_by($this->t.'.sign_up_date ASC');
		}else{
			$this->db->order_by($this->t.'.sign_up_date DESC');
		}		 
		$this->db->limit($limit,$start);
		$this->db->where($this->t.'.show_status',1);

		$data = $this->db->get();

        return $data->result_array();
		
	}

	/**
	 * 咨询形式、渠道列表分页统计
	 */
	public function consultate_channel_count($arr,$start_time,$end_time)
	{	
		
		$this->db->join('consultant', 'consultant.consultant_id='.$this->t.'.consultant_id','left')
				 ->where("consultant.$arr[0] =".$arr[1]);

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
		$this->db->where($this->t.'.show_status',1);

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

		$this->db->select($this->t.'.student_id,'.$this->t.'.student_name,'.$this->t.'.student_sex,'.$this->t.'.consultant_id,'.$this->t.'.sign_up_date,'.$this->t.'.employee_id,'.$this->t.'.student_number,'.$this->t.'.show_status,'.$this->t.'.old_employee_id')
				 ->where_in($this->t.'.student_id',$data)
				 ->order_by($this->t.".sign_up_date",'DESC')
				 ->limit($limit,$start)
				 ->where($this->t.'.show_status',1);

		$data=$this->db->get($this->t);

		return $data->result_array();

	}

	/**
	 * 通过学生id获取到学生名字、咨询师id
	 */
	public function getInfo($id)
	{
		$this->db->select('consultant_id,student_name,employee_id')
				 ->where('student_id',$id);

		$data=$this->db->get($this->t);
		
		return $data->row_array();
	}

	/**
	 * 通过学生id获取到学生名字、咨询师名字
	 */
	public function studentEmployeeInfo($field,$where)
	{
		$this->db->select($field);
		$this->db->join($this->t1,$this->t1.'.employee_id='.$this->t.'.employee_id');
		$this->db->where($where);
		$data=$this->db->get($this->t);
		
		return $data->row_array();
	}

	/**
	 *	咨询回访查询列表
	 */
	public function select_record_time($start,$limit,$start_time,$end_time,$teach_id='')
	{
		
		$w=' 1 ';
		//超级管理员选择某个咨询师查看
		if($teach_id!==''){
			$w.="AND c.`employee_id`={$teach_id} ";
		}

		if($this->p==0){
			$w.="AND c.`employee_id`=".$this->employee_id;
		}

       	//搜索日期
		if($start_time!='' && $end_time!=''){
       		$w.=" AND r.`consultant_record_time` >= {$start_time} AND r.`consultant_record_time` <= {$end_time}";
       	}else if($start_time!='' && $end_time==''){
			$w.=" AND r.`consultant_record_time` = {$start_time}";
		}

		$id=$this->employee_id;
		
		if($this->p==0){//如果是普通的员工
			$sql="SELECT r.`consultant_id`, r.`consultant_record_time`, c.* FROM `crm_consultant_record` r left join crm_student c on r.`consultant_id`=c.`consultant_id` WHERE c.`show_status`=1 and c.`employee_id`={$id}  AND {$w} group by r.`consultant_id` LIMIT $start,$limit";
		}else{
			$sql="SELECT r.`consultant_id`, r.`consultant_record_time`, c.* FROM `crm_consultant_record` r left join crm_student c on r.`consultant_id`=c.`consultant_id` WHERE c.`show_status`=1 and {$w} group by r.`consultant_id` LIMIT $start,$limit";

		}

		$data= $this->db->query($sql);

        return $data->result_array();

	}
	/**
	 *	咨询回访总数
	 */
	public function select_record_time_count($start_time,$end_time,$teach_id='')
	{
		$w=' 1 ';
		//超级管理员选择某个咨询师查看
		if($teach_id!==''){
			$w.="AND employee_id={$teach_id} ";
		}

		if($this->p==0){
			$w.="AND employee_id=".$this->employee_id;
		}

       	//搜索日期
		if($start_time!='' && $end_time!=''){
       		$w.=" AND r.`consultant_record_time` >= {$start_time} AND r.`consultant_record_time` <= {$end_time}";
       	}else if($start_time!='' && $end_time==''){
			$w.=" AND r.`consultant_record_time` = {$start_time}";
		}

		$id=$this->employee_id;

		if($this->p==0){//如果是普通的员工
			$sql="SELECT COUNT( DISTINCT r.`consultant_id`) as l FROM `crm_consultant_record` r left join crm_student c on r.`consultant_id`=c.`consultant_id` WHERE c.`show_status`=1 and c.`employee_id`={$id} AND {$w}";
		}else{
			$sql="SELECT COUNT( DISTINCT r.`consultant_id`) as l FROM `crm_consultant_record` r left join crm_student c on r.`consultant_id`=c.`consultant_id` WHERE c.`show_status`=1 and {$w}";

		}

		$data = $this->db->query($sql);
		$a = $data->row_array();

		return $a['l'];
	}

	/**
	 * 查询学生报读的知识点的就读情况
	 */
	public function getKnowleage($where,$where_in=''){

		$field='knowledge.knowledge_id,knowledge.knowledge_name,student_knowleage_relation.study_status';

		$this->db->select($field)
				 ->join('knowledge','knowledge.knowledge_id=student_knowleage_relation.knowledge_id','left')
				 ->where($where);
		$this->db->order_by('student_knowleage_relation.knowledge_id','asc');

		if($where_in){
			$this->db->where_in('study_status',$where_in);
		}		

		$data=$this->db->get('student_knowleage_relation');

		return $data->result_array();
	}

	/**
	 * 更新学生报读的知识点的就读情况
	 */
	public function updateKnowleage($data,$where,$where_in){
		$this->db->where($where);
		$this->db->where_in('knowledge_id', $where_in);
		$this->db->update('student_knowleage_relation',$data);
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
}