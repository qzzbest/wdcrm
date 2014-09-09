<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 咨询者表
 */
class Advisory_consultant_model extends CI_Model 
{
	private $t;#表名
	private $employee_id;#员工id
	private $p; #员工的权限
	private $teach_id;#超级管理员选择的咨询师
	function __construct()
	{
		parent::__construct();
		
		$this->t = $this->db->dbprefix('consultant'); 
		$this->t1 = $this->db->dbprefix('consultant_channel');
		$this->t2 = $this->db->dbprefix('marketing_specialist');

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
	 *	查看咨询者的信息
	 */
	public function getConsultantInfo($field,$where='')
	{
		$this->db->select($field);
		if($where !== ''){
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
			$this->db->where_in('consultant_id',$id);
		}else{
			$this->db->where('consultant_id',$id);
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
	 * 咨询者列表 查询
	 */
	public function select_index($start,$limit,$key='',$like='',$start_time,$end_time,$consultant_id='',$order=0,$where='',$statistics_id='')
	{
		$field='consultant_id,consultant_name,consultant_sex,consultant_set_view,is_student,consultant_firsttime,employee_id,is_client,show_status,old_employee_id';

		$this->db->select($field);

		//权限限制
		$this->_power();


		//搜索
		if ($key !='' && $like !='') {

			$this->db->like($key,$like);
	
		}
		//搜索日期
		if($start_time != '' && $end_time==''){
			$this->db->where('consultant_firsttime =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where('consultant_firsttime >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where('consultant_firsttime <=',$end_time);
	       	}
		}
		
		if($order==1){
			$this->db->order_by('consultant_firsttime ASC');
		}else{
			$this->db->order_by('consultant_firsttime DESC');
		}
		if($consultant_id!=''){
			$this->db->where('consultant_id',$consultant_id);
		}

		if($where!=''){
			$this->db->where($where);
		}

		if($statistics_id!=''){
			$this->db->where('marketing_specialist_id',$statistics_id);
		}
		$this->db->where('show_status',1);
		$this->db->limit($limit,$start);
		

		$data=$this->db->get($this->t);

		return $data->result_array();
	
	}

	/**
	 * 咨询列表分页统计
	 */
	public function select_index_count($key='',$like='',$start_time,$end_time,$consultant_id,$where='',$statistics_id='')
	{

		//权限
		$this->_power();

		if ($like!='') {
			$this->db->like($key, $like); 
		}
		
		if($start_time != '' && $end_time==''){
			$this->db->where('consultant_firsttime =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where('consultant_firsttime >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where('consultant_firsttime <=',$end_time);
	       	}
		}
		
       	if($consultant_id!=''){
			$this->db->where('consultant_id',$consultant_id);
		}
		if($where!=''){
			$this->db->where($where);
		}
		if($statistics_id!=''){
			$this->db->where('marketing_specialist_id',$statistics_id);
		}
		$this->db->where('show_status',1);

		return $this->db->count_all_results($this->t);
	}

	/**
	 * 通过学生id获取到学生名字、咨询师id
	 */
	public function getInfo($id)
	{
		$this->db->select('consultant_id,consultant_name,employee_id,is_client')
				 ->where('consultant_id',$id);

		$data=$this->db->get($this->t);
		
		return $data->row_array();
	}
		
	/**
	 *	分页查询，分资讯形式、咨询渠道不同查询查询
	 */
	public function consultate_channel($start,$limit,$arr,$start_time,$end_time,$order=0,$teach_id='',$is_client=0)
	{	
		$t=$this->t;
		
		$w=' 1 ';

		//超级管理员选择某个咨询师查看
		if($teach_id!==''){
			$w.="AND employee_id={$teach_id} ";
		}

		if($this->p==0){
			$w.="AND employee_id=".$this->employee_id;
		}

		if($is_client==1){
			if($order==1){
				$a='ORDER BY consultant_firsttime ASC';
			}else{
				$a='ORDER BY consultant_firsttime DESC';
			}
		}else{
			if($order==1){
				$a='ORDER BY consultant_firsttime ASC,consultant_set_view ASC,consultant_set_view_time ASC';
			}else{
				$a='ORDER BY consultant_firsttime DESC,consultant_set_view DESC,consultant_set_view_time DESC';
			}
		}
		
		$w1= " AND $arr[0]=$arr[1]";	

		if($start_time != '' && $end_time==''){
			$w.=" AND consultant_firsttime = {$start_time}";
		}else{
			if($start_time!=''){
	       		$w.=" AND consultant_firsttime >= {$start_time}";
	       	}
	       	if($end_time!=''){
	       		$w.=" AND consultant_firsttime <= {$end_time}";
	       	}
		}
				
		if($is_client){
			$w.=" AND is_client=1 ";
		}

		$id=$this->employee_id;

		$filed='consultant_id,consultant_firsttime,consultant_set_view_time,consultant_name,consultant_sex,consultant_set_view,is_student,employee_id,is_client,show_status,old_employee_id';
		
		if($this->p==0){//如果是普通的员工
			if($is_client==0){
				$sql="SELECT {$filed} FROM {$t} WHERE employee_id={$id} AND show_status=1 AND {$w} {$w1} {$a} LIMIT $start,$limit";
			}else{
				$sql="SELECT {$filed} FROM {$t} WHERE employee_id={$id} AND show_status=1 AND {$w} {$w1} {$a} LIMIT $start,$limit";
			}
		}else{
			if($is_client==0){
				$sql="SELECT {$filed} FROM {$t} WHERE show_status=1 AND {$w} {$w1} {$a} LIMIT $start,$limit";
			}else{
				$sql="SELECT {$filed} FROM {$t} WHERE show_status=1 AND {$w} {$w1} {$a} LIMIT $start,$limit";
			}
		}

		
		$data= $this->db->query($sql);

        return $data->result_array();
		
	}

	/**
	 * 咨询形式、咨询渠道列表分页统计
	 */
	public function consultate_channel_count($arr,$start_time,$end_time,$is_client=0)
	{	

		//权限
		$this->_power();
		
		$this->db->where($arr[0],$arr[1]);

		if($start_time != '' && $end_time==''){
			$this->db->where('consultant_firsttime =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where('consultant_firsttime >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where('consultant_firsttime <=',$end_time);
	       	}
		}
		
		$this->db->where('show_status',1);
		
		if($is_client){
			$this->db->where('is_client',1);
		}

		return $this->db->count_all_results($this->t);
	}


	/**
	 *	分页查询，上门与未上门
	 *
	 */
	public function select_view($start,$limit,$type_data,$start_time,$end_time,$order=0)
	{
		$filed='consultant_id,consultant_firsttime,consultant_name,consultant_set_view_time,is_student,consultant_sex,consultant_set_view,employee_id,is_client,show_status,old_employee_id';

		$this->db->select($filed);

		if($start_time != '' && $end_time==''){
			$this->db->where('consultant_firsttime =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where('consultant_firsttime >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where('consultant_firsttime <=',$end_time);
	       	}
		}
		
		//权限
		$this->_power();

		$this->db->where('consultant_set_view',$type_data);

		if ($type_data==0) {
			$this->db->where('is_student',0);
			if($order==1){
				$this->db->order_by('consultant_firsttime ASC');
			}else{
				$this->db->order_by('consultant_firsttime DESC');
			}
		}else if($type_data==1){
			if($order==1){
				$this->db->order_by('consultant_set_view_time ASC');
			}else{
				$this->db->order_by('consultant_set_view_time DESC');
			}
		}else{
			die;
		}

		$this->db->limit($limit,$start);
		$this->db->where('show_status',1);

		$data=$this->db->get($this->t);

		return $data->result_array();


	}
	/**
	 * 未上门已上门统计
	 */
	public function select_view_count($type_data,$start_time,$end_time)
	{
		//权限
		$this->_power();

		if($start_time != '' && $end_time==''){
			$this->db->where('consultant_firsttime =',$start_time);
		}else{
			if($start_time!=''){
	       		$this->db->where('consultant_firsttime >=',$start_time);
	       	}
	       	if($end_time!=''){
	       		$this->db->where('consultant_firsttime <=',$end_time);
	       	}
		}
		
		if ($type_data==1) {

			$this->db->where('consultant_set_view',$type_data);
			
		}else if($type_data==0){ //未上门的学生不要

			$this->db->where('is_student', 0);
			$this->db->where('consultant_set_view',$type_data);
		}else{
			die;
		}

		$this->db->where('show_status',1);

		return $this->db->count_all_results($this->t);

	}

	/**
	 * 通过联系方式查找到的咨询者
	 */
	public function select_contact_like($data,$start,$limit)
	{

		$this->db->select('consultant_id,consultant_name,is_student,consultant_sex,consultant_set_view,consultant_firsttime,employee_id,is_client,show_status,old_employee_id')
				 ->where_in('consultant_id',$data);

		$this->_power();

		$this->db->order_by("consultant_firsttime",'desc')
				 ->limit($limit,$start)
				 ->where('show_status',1);

		$data=$this->db->get($this->t);

		return $data->result_array();

	}
	/**
	 * 通过咨询者咨询时间获取到咨询者
	 */
	public function get_time($start_time,$end_time,$start,$limit)
	{
		$this->db->select('*')
				 ->where('consultant_firsttime >=',$start_time)
				 ->where('consultant_firsttime <=',$end_time)
				 ->limit($limit,$start)
				 ->where('show_status',1);
				 
		$data=$this->db->get($this->t);

        return $data->result_array();
	}
	/**
	 * 咨询者分页统计
	 */
	public function get_time_count($start_time,$end_time)
	{
		$this->_power();

		$this->db->where('consultant_firsttime >=',$start_time)
			 	 ->where('consultant_firsttime <=',$end_time);
		$this->db->where('show_status',1);
		
		return $this->db->count_all_results($this->t);
	}

	/**
	 *	咨询回访查询列表
	 */
	public function select_record_time($start,$limit,$start_time,$end_time,$teach_id='',$where='')
	{
		
		$w=' c.show_status=1 ';
		//超级管理员选择某个咨询师查看
		if($teach_id!==''){
			$w.="AND c.employee_id={$teach_id} ";
		}

		if($this->p==0){
			$w.="AND c.employee_id=".$this->employee_id;
		}

       	//搜索日期
		if($start_time!='' && $end_time!=''){
       		$w.=" AND r.consultant_record_time >= {$start_time} AND r.consultant_record_time <= {$end_time}";
       	}else if($start_time!='' && $end_time==''){
			$w.=" AND r.consultant_record_time = {$start_time}";
		}

		$id=$this->employee_id;
		
		if($where!=''){
			$w.= " AND r.is_client = 1 ";
		}

		if($this->p==0){//如果是普通的员工
			$sql="SELECT r.`consultant_id`, r.`consultant_record_time`, c.* FROM `crm_consultant_record` r left join crm_consultant c on r.`consultant_id`=c.`consultant_id` WHERE employee_id={$id} AND show_status=1 AND {$w} group by r.`consultant_id` LIMIT $start,$limit";
		}else{
			$sql="SELECT r.`consultant_id`, r.`consultant_record_time`, c.* FROM `crm_consultant_record` r left join crm_consultant c on r.`consultant_id`=c.`consultant_id` WHERE show_status=1 AND {$w} group by r.`consultant_id` LIMIT $start,$limit";

		}

		$data= $this->db->query($sql);

        return $data->result_array();

	}
	/**
	 *	咨询回访总数
	 */
	public function select_record_time_count($start_time,$end_time,$teach_id='',$where='')
	{
		$w=' c.show_status=1 ';
		//超级管理员选择某个咨询师查看
		if($teach_id!==''){
			$w.="AND c.employee_id={$teach_id} ";
		}

		if($this->p==0){
			$w.="AND c.employee_id=".$this->employee_id;
		}

       	//搜索日期
		if($start_time!='' && $end_time!=''){
       		$w.=" AND r.consultant_record_time >= {$start_time} AND r.consultant_record_time <= {$end_time}";
       	}else if($start_time!='' && $end_time==''){
			$w.=" AND r.consultant_record_time = {$start_time}";
		}

		$id=$this->employee_id;

		if($where!=''){
			$w.= " AND  r.is_client=1 ";
		}

		if($this->p==0){//如果是普通的员工
			$sql="SELECT COUNT( DISTINCT r.`consultant_id`) as l FROM `crm_consultant_record` r left join crm_consultant c on r.`consultant_id`=c.`consultant_id` WHERE employee_id={$id} AND show_status=1 AND {$w}";
		}else{
			$sql="SELECT COUNT( DISTINCT r.`consultant_id`) as l FROM `crm_consultant_record` r left join crm_consultant c on r.`consultant_id`=c.`consultant_id` WHERE show_status=1 AND {$w}";

		}

		$data = $this->db->query($sql);
		$a = $data->row_array();

		return $a['l'];
	}

	/**
	 *	回访记录未上门已上门人数
	 */
	public function select_record_view_count($type_data,$start_time,$end_time,$teach_id='')
	{
		$w=' 1 ';
		//超级管理员选择某个咨询师查看
		if($teach_id!==''){
			$w.="AND c.employee_id={$teach_id} ";
		}

		if($this->p==0){
			$w.="AND c.employee_id=".$this->employee_id;
		}

       	//搜索日期
		if($start_time!='' && $end_time!=''){
       		$w.=" AND r.consultant_record_time >= {$start_time} AND r.consultant_record_time <= {$end_time}";
       	}else if($start_time!='' && $end_time==''){
			$w.=" AND r.consultant_record_time = {$start_time}";
		}
		
		//统计未上门,已上门人数	
		$w.=" AND c.consultant_set_view = {$type_data}";

		$id=$this->employee_id;

		if($this->p==0){//如果是普通的员工
			$sql="SELECT COUNT( DISTINCT r.`consultant_id`) as l FROM `crm_consultant_record` r left join crm_consultant c on r.`consultant_id`=c.`consultant_id` WHERE employee_id={$id} AND show_status=1 AND {$w}";
		}else{
			$sql="SELECT COUNT( DISTINCT r.`consultant_id`) as l FROM `crm_consultant_record` r left join crm_consultant c on r.`consultant_id`=c.`consultant_id` WHERE show_status=1 AND {$w}";

		}

		$data = $this->db->query($sql);
		$a = $data->row_array();

		return $a['l'];
	}

	/**
	 *	通过咨询者ID查渠道
	 */
	public function consultantChannel($field,$where)
	{
		$this->db->select($field);
		$this->db->join($this->t1,$this->t1.'.consultant_channel_id='.$this->t.'.consultant_channel_id');
		$this->db->where($where);
		$data=$this->db->get($this->t);
		
		return $data->row_array();
	}

	/**
	 *	通过咨询者ID查市场专员
	 */
	public function consultantMarketing($field,$where)
	{
		$this->db->select($field);
		$this->db->join($this->t2,$this->t2.'.marketing_specialist_id='.$this->t.'.marketing_specialist_id');
		$this->db->where($where);
		$data=$this->db->get($this->t);
		
		return $data->row_array();
	}
	/**
	 * 查询最大预学号
	 */
	public function select_number()
	{
		$field='pre_number';

		$this->db->select($field);

		$this->db->order_by('pre_number DESC');

		$this->db->limit(1,0);
		$this->db->where('show_status',1);

		$data=$this->db->get($this->t);

		return $data->result_array();
	
	}
	/**
	 * 查询咨询者的id和员工的id
	 */
	public function select_id()
	{
		/**
		 * 1、查询每个咨询者咨询记录（is_student=0）1.1连表查询获得最大的时间，先查咨询者循环出来在用
		 * 2、获取咨询记录最大的时间(空的咨询记录就不要去算了)
		 * 3、最大时间和当前时间比相差一个月就得到该资源
		 */
		$field='consultant_id,employee_id';
		$this->db->select($field)
				 ->where('show_status',1)
				 ->where('is_student',0);
				 //->limit($limit,$start)

		$data=$this->db->get($this->t);

		return $data->result_array();		 
	}
	/**
	 * 查询公共资源的咨询者
	 */
	public function select_common($start,$limit)
	{
		/**
		 * 1、查询每个咨询者咨询记录（is_student=0）1.1连表查询获得最大的时间，先查咨询者循环出来在用
		 * 2、获取咨询记录最大的时间
		 * 3、最大时间和当前时间比相差一个月就得到该资源
		 */
		$field='consultant_id,consultant_name,consultant_sex,consultant_set_view,is_student,consultant_firsttime,employee_id,is_client,show_status,old_employee_id';
		$this->db->select($field)
				 ->where('show_status',1)
				 ->where('is_student',0)
				 ->where('employee_id',0)
				 ->limit($limit,$start);

		$data=$this->db->get($this->t);

		return $data->result_array();		 

	
	}
	/**
	 * 公共资源的咨询者统计
	 */
	public function select_common_count()
	{

		//权限
		//$this->_power();

		$this->db->where('show_status',1);
		$this->db->where('employee_id',0);

		return $this->db->count_all_results($this->t);
	}
}