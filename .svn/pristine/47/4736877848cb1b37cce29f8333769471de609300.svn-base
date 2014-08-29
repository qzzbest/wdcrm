<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 客户信息
 */
class Advisory_client_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('consultant');

	}

	public function index()
	{
		#咨询师
		$this->load->model('employee_model');
		$data['teach']= $this->employee_model->selectDepartment();

		//多个查询参数处理
		$param_url=array();

		//超级管理员选中的咨询师
		$data['selected_teach']=$selected_teach=trim($this->input->get('teach'))!=''?trim($this->input->get('teach')):'';

		$param_url['teach']=$selected_teach;

		//权限限制,如果不是超级管理员，而又选中了某位咨询师，属于不合理状态
		if(getcookie_crm('employee_power')==0 && $selected_teach!=''){
			show_message('权限不对!');
		}

		//接单日期排序(升序、降序)
		$data['order']=$order=trim($this->input->get('order'))!=''?trim($this->input->get('order')):'';
		$param_url['order']=$order;

		#接收分类
		$data['changeType']= $type = $this->uri->segment(5, 'index');
		$data['changeData']= $type_data = $this->uri->segment(6, 0);

		#导航栏处理
		$this->menuProcess($type,$type_data);		

		#当前页码
		$data['cur_pag']= $page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		#搜索
		$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
		
		$param_url['search']=$search;

		#搜索分类
		$key= $this->input->get('key')?$this->input->get('key'):'consultant_name';

		$param_url['key']=$key;

		$limit=20;#每页显示多少条
		
		$start=($page-1)*$limit;

		//接收日期类型
		$data['select_day']=$select_day=trim($this->input->get('select_day'))!=''?trim($this->input->get('select_day')):'';
		$param_url['select_day']=$select_day;

		#接单日期
		$starttime = $this->input->get('start_time') ? $this->input->get('start_time'):'';
		$endtime = $this->input->get('end_time') ? $this->input->get('end_time'):'' ;

		if(!empty($starttime)){
			$start_time = strtotime($starttime);
		}else{
			$start_time = $starttime;
		}

		if(!empty($endtime)){
			$end_time = strtotime($endtime.'23:59:59');
		}else{
			$end_time = $endtime;
		}

		$param_url['start_time']=$starttime;
		$param_url['end_time']=$endtime;

		$consultant_id = $this->input->get('consultant_id') ? $this->input->get('consultant_id'):'' ;
		$param_url['consultant_id']=$consultant_id;

		#加载咨询者模型
		$this->load->model('consultant_model','consultant');
		$this->consultant->init($selected_teach);

		if ($type=='index') {//咨询者列表
			$search_key_type=array('consultant_name','consultant_education','consultant_school','consultant_specialty');
			if (in_array($key,$search_key_type)) {
				if($select_day==2){
					//回访记录查询列表和总数
					$consultant=$this->consultant->select_record_time($start,$limit,$start_time,$end_time,$selected_teach,'client');
					$count=$this->consultant->select_record_time_count($start_time,$end_time,$selected_teach,'client');
				}else{
					$where = array('is_client'=>1);
					$consultant=$this->consultant->select_index($start,$limit,$key,$search,$start_time,$end_time,$consultant_id,$order,$where);
					$count=$this->consultant->select_index_count($key,$search,$start_time,$end_time,$consultant_id,$where);
				}
				
			}else{
				//联系方式查找
				$model="consul_stu_{$key}_model";
				$this->load->model($model,'contact');
				
				$data_s=$this->contact->select($search,1);
				$data_s=$this->_dataProcess($data_s,'consultant_id');
				$count=count($data_s);
			
				$data_s[]=0;  //因搜索关键字查到咨询者删除记录跳转出现重复，所以直接显示空数据，不做提示
				
				$consultant=$this->consultant->select_contact_like($data_s,$start,$limit);
				
			}
			
			
		//咨询者咨询形式、咨询渠道
		}else if(in_array($type, array('consultant_channel_id','consultant_consultate_id'))){

			$tmp=array($type,$type_data);
			$consultant=$this->consultant->consultate_channel($start,$limit,$tmp,$start_time,$end_time,$order,$selected_teach,1);

			$count=$this->consultant->consultate_channel_count($tmp,$start_time,$end_time,1);
		
		}else{
			die;
		}
		
		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数

		//$total_page = floor($count/$limit) != 0 ? floor($count/$limit) : 1;//总共多少页

		$number = array();
		for($i=$begin;$i<=$total;$i++){
			$number[]=$i;//当前页的每个值赋给数组
		}

		foreach($consultant as $k=>$v){
			#序号
			$consultant[$k]['serial_number']=$number[$k];//每条数据对应当前页的每一个值
			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('consultant_id'=>$v['consultant_id']));
		
			
			$consultant[$k]['phone']=$this->_dataProcess($tmp,'phone_number');
			
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('consultant_id'=>$v['consultant_id']));
			
			
			$consultant[$k]['qq']=$this->_dataProcess($tmp,'qq_number');

			#email
			$tmp= $this->main_data_model->setTable('consul_stu_email')
										->select('email',array('consultant_id'=>$v['consultant_id']));
			
			
			$consultant[$k]['email']=$this->_dataProcess($tmp,'email');

			#提醒
			$tmp= $this->main_data_model->setTable('time_remind')
										->select('*',array('consultant_id'=>$v['consultant_id'],'consultant_record_id'=>0,'student_id'=>0,'time_remind_status'=>0,'is_client'=>1)
											);
			
			$consultant[$k]['message']=$this->_dataProcess($tmp,'consultant_id');

		}

		#分页类
		$this->load->library('pagination');

		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url,$type,$type_data);
	
		$config['total_rows'] =$count;
		$config['per_page']   = $limit; 

		$config['uri_segment']= 5;
		$config['num_links']  = 5;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();
		
		#统计咨询者各个咨询形式、渠道的人数
		$tmps=array($type,$type_data);
		if(in_array($type, array('consultant_channel_id','consultant_consultate_id'))){
			$arr=array('consultant_channel_id'=>'consultant_channel_model',
				   'consultant_consultate_id'=>'counselor_consultate_modus_model'
				   );
			$this->load->model($arr[$type],'consultate_channel');
			$consultate_channel_name= $this->consultate_channel->getName($type_data);
			$data['member']=sprintf('<span>%s人数:<em style="color:red">%d</em>人</span>',$consultate_channel_name,$count);
			
		}

		#学生总数
		if ($type==='index') {
			$consultate_channel_name='客户';
		}else{
			$arr=array('consultant_channel_id'=>'consultant_channel_model',
				   'consultant_consultate_id'=>'counselor_consultate_modus_model'
				   );
			$this->load->model($arr[$type],'consultate_channel');
			$consultate_channel_name= $this->consultate_channel->getName($type_data);
			
		}
		$count=sprintf('<span>%s人数:<em style="color:red">%d</em>人</span>',$consultate_channel_name,$count);

		foreach ($consultant as $k => $value) {
			$consultant[$k]['employee_name'] = $this->main_data_model->setTable('employee')->getOne(array('employee_id'=>$value['employee_id']),'employee_name');

			$where_repayment=array('consultant_id' => $value['consultant_id'],'is_fail' => 1,'is_project'=>1);
			$res=$this->main_data_model->count($where_repayment,'student_repayment_bills');
			if($res<=0){
				$consultant[$k]['refund'] = 1;
			}else{
				$consultant[$k]['refund'] = 0;
			}
		}
		
		#赋值
		$data['admin_info']=array(
			'count'=>$count,
			'list'=>$consultant,
			'page'=>$page,
			'key'=>$key,
			'search'=>$search
		);

		#指定模板
		$this->load->view('client_list',$data);
	}
	/**
	 * 建立url地址
	 */
	private function _buildUrl($arr,$type,$type_data)
	{

		$param_url = "";
		foreach($arr as $key=>$val){
			if(trim($val)!=''){
				$param_url .= $key."=".$val."&";	
			}
		}
		$param_url = rtrim($param_url, "&");
		
		
		$urls =site_url(module_folder(2)."/client/index/$type/$type_data?".$param_url);
		
		return $urls;
	}

	/**
	 * qq与phone的数据简单处理
	 */
	private  function _dataProcess($arr,$str){
		$data=array();
		foreach ($arr as $key => $value) {
			$data[]=$value[$str];
		}
		return $data;
	}
	/**
	 * 导航条处理
	 */
	private function menuProcess($type,$type_data)
	{	
		$url[0]=array('客户列表', site_url(module_folder(2).'/client/index/index/0'));

		$per_page= $this->input->get('per_page')?$this->input->get('per_page'):'1';
		
		if($type=='index'){
			#搜索
			$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
			#搜索分类
			$key= $this->input->get('key')?$this->input->get('key'):'consultant_name';
			
			if($search!=''){
				$url[1]=array('客户搜索',site_url(module_folder(2).'/client/index/index/0?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));	
			}else{
				$url[1]=array('客户分页',site_url(module_folder(2).'/client/index/index/0?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));
			}

		}elseif(in_array($type, array('consultant_channel_id','consultant_consultate_id'))){
		
			$arr=array('consultant_channel_id'=>'consultant_channel_model',
			   'consultant_consultate_id'=>'counselor_consultate_modus_model'
			   );
			$this->load->model($arr[$type],'consultate_channel');
			$consultate_channel_name= $this->consultate_channel->getName($type_data);
			
			$url[1]=array($consultate_channel_name.'分页',site_url(module_folder(2).'/client/index/'.$type.'/'.$type_data.'?per_page='.$per_page));
			
		}
		
		//之前是这么做
		//$_COOKIE['url']=serialize($url);
		//加密处理
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');
		
		setcookie_crm('url',serialize($url));

	}
	/**
	 * 添加咨询者的时候修改面包屑导航
	 */
	private function _addUrl()
	{
		$url[0]=array('客户列表', site_url(module_folder(2).'/client/index/index/0'));
		$url[1]=array('客户分页',site_url(module_folder(2).'/client/index/index/0?'.'per_page=1'));
		
		//之前是这么做
		//$_COOKIE['url']=serialize($url);
		//加密处理
		$_COOKIE['url']= authcode(serialize($url),'ENCODE');

		setcookie_crm('url',serialize($url));
	}

	/**
	 * 检查该咨询者是否是该咨询师的
	 * @param $id int 接收一个咨询者id
	 * @param $type 默认空，如果为in,则表示查询多个id
	 * @param $is_ajax 是否是ajax
	 */
	private function _checkPower($id,$type='',$is_ajax='')
	{

		if(!$id){
			show_message('权限不对',site_url(module_folder(2).'/client/index/index/0'));
		}

		$this->load->model('consultant_model');

		$res= $this->consultant_model->checkData($id,$type);

		
		if ($res===0) {
			if($is_ajax=='ajax'){
				return 0;//表示操作了非法数据	
			}else{
				show_message('权限不对',site_url(module_folder(2).'/client/index/index/0'));
			}
		
		}else{
			return 1;
		}

	}

	/**
	 * 修改咨询者的信息、顺带修改学生的信息
	 */
	private function _editStudentInfo($stu,$edit)
	{

		$where=array('consultant_id'=>$edit);
		$this->main_data_model->update($where,$stu,'consultant');

	}

	/**
	 * 虚拟删除客户，更新咨询者客户状态（一般都是误操作）
	 */
	public function changeStatus()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));
		$location=$url[1][1];
		
		$dele_arr= $this->input->post('checkbox_consultant');

		//检查咨询者所属者
		$this->_checkPower($dele_arr,'in');

		$where = $remind_where = db_create_in($dele_arr,'consultant_id');

		#修改咨询者状态
		$status = array('is_client'=>0);
		$result = $this->main_data_model->update($where,$status,'consultant');

		#如果删除客户，就把记录（项目，缴费记录，缴费账单，提醒记录）全部删除
		$con_cur_where = array('consultant_id',$dele_arr);//refund_loan_time表中要保证student_id是null
		$this->main_data_model->delete($con_cur_where,2,'client_project_record');

		$this->load->model('student_repayment_bills_model','student_repayment_bills');
		$del_where1 = $where." and student_id is null ";
		$this->student_repayment_bills->deleteRepaymentBills($del_where1);

		$this->load->model('refund_loan_time_model','refund_loan_time');
		$del_where2 = $where." and student_id is null ";
		$this->refund_loan_time->deletePayment($del_where2);

		$this->load->model('time_remind_model');
		$del_where3 = $where." and is_client=1 ";
		$this->time_remind_model->deleteTimeRemind($del_where3);	


		// $repayment_status = array('is_fail'=>0);
		// $this->main_data_model->update($where,$repayment_status,'student_repayment_bills');	

		// //更改咨询者的提醒（设置不提醒）
		// $remind_data = array('time_remind_status'=>-1);
		// $remind_where = $remind_where." AND `is_client`=1 ";
		// $this->main_data_model->update($remind_where,$remind_data,'time_remind');

		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}
	}

	/**
	 * 删除咨询者，顺带删除咨询者的phone跟qq，如果是已经成为学员的，不删除qq、phone
	 */
	/*public function delete()
	{	
		$delete = $this->uri->segment(5,0);

		#删除咨询者
		$where=array('consultant_id'=>$delete);
		$result= $this->main_data_model->delete($where,1,'consultant');

		#删除qq与phone
		$student=array('is_student'=>0);
		$where=$where+$student;
		$this->main_data_model->delete($where,1,'consul_stu_phones');
		$this->main_data_model->delete($where,1,'consul_stu_qq');
		$this->main_data_model->delete($where,1,'consul_stu_email');

		if($result>0){
  			show_message('删除成功!',site_url(module_folder(2).'/advisory/index'));	
  		}else{
  			show_message('操作失败!');
  		}
	}*/
	

	/**
	 * 批量删除咨询者
	 */
	/*public function deleteAll()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));

		
		$location=$url[1][1];

		$dele_arr= $this->input->post('checkbox_consultant');

		#批量删除咨询者
		$where = $remind_where = db_create_in($dele_arr,'consultant_id');

		$result= $this->main_data_model->delete($where,1,'consultant');

		#删除qq与phone
		$where="`is_student` = '0' AND ".db_create_in($dele_arr,'consultant_id');

		$this->main_data_model->delete($where,1,'consul_stu_phones');
		$this->main_data_model->delete($where,1,'consul_stu_qq');
		$this->main_data_model->delete($where,1,'consul_stu_email');

		//更改咨询者的提醒（设置不提醒）
		$remind_data = array('time_remind_status'=>-1);
		$this->main_data_model->update($remind_where,$remind_data,'time_remind');
		
		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}

	}*/

	/**
	 *  ajax获取更为详细的咨询者信息。
	 */
	public function info()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$id= $this->input->post("id");

		//检查咨询者所属者
		$check_result = $this->_checkPower($id,'','ajax');

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}

		$where=array('consultant_id'=>$id);
		#咨询者
		$consultant= $this->main_data_model->getOne($where,'','consultant');

		#咨询者phone
		$consultant_phone= $this->main_data_model->setTable('consul_stu_phones')->select('phone_number',$where);

		#咨询者qq
		$consultant_qq= $this->main_data_model->setTable('consul_stu_qq')->select('qq_number',$where);

		#咨询者email
		$consultant_email= $this->main_data_model->setTable('consul_stu_email')->select('email',$where);
		
		$str='<table border="1" width="100%">';
		$str.="<tr>";
		$str.="<td width='23%'>姓名</td><td>".$consultant['consultant_name']."</td>";
		$str.="</tr>";
	
		#phone
		if($consultant_phone){
			foreach($consultant_phone as $item){
				$str.="<tr>";
				$str.="<td>联系方式</td><td>".$item['phone_number']."</td>";
				$str.="</tr>";
			}
		}
		#qq
		if($consultant_qq){
			foreach($consultant_qq as $item){
				$str.="<tr>";
				$str.="<td>QQ</td><td>".$item['qq_number']."</td>";
				$str.="</tr>";
			}
		}
		#邮箱
		if($consultant_email){
			foreach($consultant_email as $item){
				$str.="<tr>";
				$str.="<td>邮箱</td><td>".$item['email']."</td>";
				$str.="</tr>";
			}
		}

		#其他联系方式
		if($consultant['consultant_other_contacts'] != ''){
			$str.="<tr>";
			$str.="<td>其他联系方式</td><td>".$consultant['consultant_other_contacts']."</td>";
			$str.="</tr>";
		}	

		#性别
		if ($consultant['consultant_sex']==1) {
			 	$sex = '男';
			}else if($consultant['consultant_sex']==2){
			 	$sex = '女';
			}else{
				$sex = '';
			}
		#性别
		$str.="<tr>";
		$str.="<td>性别</td><td>".$sex."</td>";
		$str.="</tr>";
		#添加时间
		$str.="<tr>";
		$str.="<td>添加时间</td><td>".date('Y-m-d',$consultant['consultant_firsttime'])."</td>";
		$str.="</tr>";
		
		#咨询形式
		if($consultant['consultant_consultate_id']!=0 && $consultant['consultant_consultate_id']!=6){	 //其他咨询形式
			$where=array('consultant_consultate_id'=>$consultant['consultant_consultate_id']);
			$tmp= $this->main_data_model->getOne($where,'consultant_consultate_name','counselor_consultate_modus');
			$str.="<tr>";
			$str.="<td>咨询形式</td><td>".$tmp['consultant_consultate_name']."</td>";
			$str.="</tr>";

		}else{
			$str.="<tr>";
			$str.="<td>咨询形式</td><td>".$consultant['consultant_consultate_other']."</td>";
			$str.="</tr>";			
		}

		#咨询形式备注
		if($consultant['consultant_consultate_remark'] != ''){
			$str.="<tr>";
			$str.="<td>咨询形式备注</td><td>".$consultant['consultant_consultate_remark']."</td>";
			$str.="</tr>";
		}		

		#渠道
		if($consultant['consultant_channel_id']!=0 && $consultant['consultant_channel_id']!=12){    //其他咨询渠道
			$where=array('consultant_channel_id'=>$consultant['consultant_channel_id']);
			$tmp=$this->main_data_model->getOne($where,'consultant_channel_name	','consultant_channel');
			
			$str.="<tr>";
			$str.="<td>渠道</td><td>".$tmp['consultant_channel_name']."</td>";
			$str.="</tr>";

		}else{
			$str.="<tr>";
			$str.="<td>渠道</td><td>".$consultant['consultant_channel_other']."</td>";
			$str.="</tr>";			
		}

		#渠道备注
		if($consultant['consultant_channel_remark'] != ''){
			$str.="<tr>";
			$str.="<td>渠道备注</td><td>".$consultant['consultant_channel_remark']."</td>";
			$str.="</tr>";
		}

		#市场专员
		$where=array('marketing_specialist_id'=>$consultant['marketing_specialist_id']);
		$tmp= $this->main_data_model->getOne($where,'marketing_specialist_name','marketing_specialist');
		if(!empty($tmp)){
			$str.="<tr>";
			$str.="<td>市场专员</td><td>".$tmp['marketing_specialist_name']."</td>";
			$str.="</tr>";
		}
		
		#咨询者其他信息
		if(trim($consultant['consultant_otherinfo'])!=''){
			$str.="<tr>";
			$str.="<td>咨询者其他信息</td><td>".$consultant['consultant_otherinfo']."</td>";
			$str.="</tr>";
		}

		#学历
		if(trim($consultant['consultant_education'])!=''){
			$str.="<tr>";
			$str.="<td>学历</td><td>".$consultant['consultant_education']."</td>";
			$str.="</tr>";
		}
		#毕业学校
		if(trim($consultant['consultant_school'])!=''){
			$str.="<tr>";
			$str.="<td>毕业学校</td><td>".$consultant['consultant_school']."</td>";
			$str.="</tr>";
		}
		#就读专业
		if(trim($consultant['consultant_specialty'])!=''){
			$str.="<tr>";
			$str.="<td>就读专业</td><td>".$consultant['consultant_specialty']."</td>";
			$str.="</tr>";
		}


		$str.="</table>";

		$res['data'] = $str;
		$res['info_url'] = site_url(module_folder(2).'/advisory/edit/'.$id.'/1');
		$res['status']=1;
		
		echo json_encode($res);
		exit;

	}

	/**
	 * ajax校验咨询者名称
	 */
	public function checkInfo()
	{
		$type = $this->input->post('type');
		$value= $this->input->post('value');

		if( $type == 'consultant_name' ){
			$where=array('consultant_name'=>trim($value),'show_status'=>1);
			$table = 'consultant';
		}
		
		$num= $this->main_data_model->count($where,$table);

		if ($num>0) {
			$res['status'] = 1;
			echo json_encode($res);
		}else{
			//此咨询者不在表中
			$res['status'] = 2;
			echo json_encode($res);
		}
		die;
	}
	
	/**
	 * ajax校验qq、手机号、邮箱
	 */
	public function checked()
	{ 
		$id=$this->uri->segment(5, 0);
		$type = $this->input->post('type');
		$value= $this->input->post('value');
		$arr=array('qq','phones','email');
		if (!in_array($type,$arr)) {
			//ajax过来的数据错误
			$res['status'] = 0;
			echo json_encode($res);
			die;
		}

		$table='consul_stu_'.$type;
		
		if($type=='qq'){
			//$where=array('qq_number'=>trim($value));
			$where_join = $table.".qq_number = '".trim($value)."'";
		}else if($type=='phones'){
			//$where=array('phone_number'=>trim($value));	
			$where_join = $table.".phone_number = '".trim($value)."'";
		}else{
			//$where=array('email'=>trim($value));
			$where_join = $table.".email = '".trim($value)."'"; 		
		}
		
		//如果是编辑
		if ($id!=0) {
			//$where+=array($table.'.consultant_id != '=>$id);			
			$where_join.=" AND crm_".$table.".consultant_id != ".$id;	
		}
		$where_join.=" AND crm_consultant.show_status = 1";

		//$num= $this->main_data_model->count($where,$table);
		
		//查询记录
		$join = array('*','consultant','consultant.consultant_id = '.$table.'.consultant_id','left');
		$res['con_info'] = $list = $this->main_data_model->select('*',$where_join,0,0,0,$join,$table);

		if(isset($list[0]['employee_id'])){
			//咨询师名字
			$where=array('employee_id'=>$list[0]['employee_id']);
			$teach= $this->main_data_model->getOne($where,'admin_name','employee');

			$res['teach']=isset($teach['admin_name'])?$teach['admin_name']:'';
		
		}

		//if ($num>0) {
		if ($list) {
			$res['status'] = 1;
			echo json_encode($res);
		}else{
			//此咨询者不在表中
			$res['status'] = 2;
			echo json_encode($res);
		}
		die;
	}

	/**
	 * 咨询者渠道、咨询者咨询形式数据的获取
	 */
	private function _pubilcData()
	{

		#咨询者渠道
		$where=array('consultant_channel_status'=>1);
		$consultant_channel=$this->main_data_model->getOtherAll('consultant_channel_id,consultant_channel_name',$where,'consultant_channel');
		
		#咨询者咨询形式
		$where=array('consultant_consultate_status'=>1);
		$consultant_consultate=$this->main_data_model->getOtherAll('consultant_consultate_id,consultant_consultate_name',$where,'counselor_consultate_modus');

		#咨询者市场专员
		$where=array('marketing_specialist_status'=>1);
		$marketing_specialist=$this->main_data_model->getOtherAll('marketing_specialist_id,marketing_specialist_name',$where,'marketing_specialist');
		
		#赋值到模板
		$data=array(
			'consultant_consultate'=>$consultant_consultate,
			'consultant_channel'   =>$consultant_channel,
			'marketing_specialist'   =>$marketing_specialist
		);

		return $data;
	}
	/**
	 * 获取侧边栏咨询形式、
	 */
	public function menuConsultate()
	{
		$this->load->model('counselor_consultate_modus_model','counselor_consultate_modus');
		
		return $this->counselor_consultate_modus->getAll();
	}
	/**
	 * 咨询渠道的信息
	 */
	public function menuChannel()
	{
		$this->load->model('consultant_channel_model','consultant_channel');

		return  $this->consultant_channel->getAll();
	}

	public function deleteQQ()
	{
		header("Content-Type:text/html;charset=utf-8");

		$qq_id = $this->input->post('qid');

		$where=array('qq_id'=>$qq_id);	
		$res=$this->main_data_model->delete($where,1,'consul_stu_qq');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	public function deleteEmail()
	{
		header("Content-Type:text/html;charset=utf-8");

		$email_id = $this->input->post('eid');

		$where=array('email_id'=>$email_id);	
		$res=$this->main_data_model->delete($where,1,'consul_stu_email');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	public function deletePhone()
	{
		header("Content-Type:text/html;charset=utf-8");

		$phone_id = $this->input->post('pid');

		$where=array('phone_id'=>$phone_id);	
		$res=$this->main_data_model->delete($where,1,'consul_stu_phones');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}

	public function check_info($data,$type,$id)
	{

		$data=array_unique($data);

		foreach ($data as $value) {
			$value= trim($value);
			if($value!=''){

				$table='consul_stu_'.$type;
				if($type=='qq'){
					$where_join = $table.".qq_number = '".trim($value)."'";
					$typename = 'QQ';
				}else if($type=='phones'){	
					$where_join = $table.".phone_number = '".trim($value)."'";
					$typename = '手机号码';
				}else{
					$where_join = $table.".email = '".trim($value)."'"; 	
					$typename = '邮箱';	
				}	

				//如果是编辑
				if ($id!=0) {
					$where_join.=" AND crm_".$table.".consultant_id != ".$id;				
				}

				$where_join.=" AND crm_consultant.show_status = 1";

				//查询记录
				$join = array('*','consultant','consultant.consultant_id = '.$table.'.consultant_id','left');
				$res['con_info'] = $list = $this->main_data_model->select('*',$where_join,0,0,0,$join,$table);

				if(isset($list[0]['employee_id'])){
					//咨询师名字
					$where=array('employee_id'=>$list[0]['employee_id']);
					$teach= $this->main_data_model->getOne($where,'admin_name','employee');
					$teach_name=isset($teach['admin_name'])?$teach['admin_name']:'';
				}

				if ($list) {
					$res['type'] = $typename;
					$res['teach_name'] = $teach_name;
					return $res;
					//break;
				}

			}else{
				$res = array();
			}

		}
	}

}