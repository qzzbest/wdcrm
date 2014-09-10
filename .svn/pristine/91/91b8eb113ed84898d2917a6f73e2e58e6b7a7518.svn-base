<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 */
class Market_market_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
		$this->main_data_model->setTable('market');
		$this->load->model('market_model','market');
	}

	public function index()
	{

		$data['cur_pag']=$page=$this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit = 20;
		$start = ($page-1) * $limit;

		#导航条处理
		$this->menuProcess();
		#市场专员
		$this->load->model('employee_model');
		$data['marketing_specialist'] = $this->employee_model->selectEmployee(18);

		#搜索
		$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
		$param_url['search']=$search;

		#搜索分类
		$key= $this->input->get('key')?$this->input->get('key'):'school';
		$param_url['key']=$key;

		//日期排序
		$data['order']=$order=trim($this->input->get('order'))!=''?trim($this->input->get('order')):'';
		$param_url['order']=$order;
		#接收日期
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

		#市场专员
		$data['statistics_id']=$statistics_id=trim($this->input->get('statistics_id'))!=''?trim($this->input->get('statistics_id')):'';
		$param_url['statistics_id']=$statistics_id;

		if(getcookie_crm('employee_power')==0 && $statistics_id!=''){
			show_message('权限不对!');
		}
		$this->market->init($statistics_id);
		#查询班级列表和班级总数
		$market = $this->market->select_index($start,$limit,$order,$start_time,$end_time,$statistics_id,$key,$search);
		$count = $this->market->select_index_count($start_time,$end_time,$statistics_id,$key,$search);
		
		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数
		$number = array();
		for($i=$begin;$i<=$total;$i++){
				$number[]=$i;//当前页的每个值赋给数组
		}

		foreach($market as $k=>$v){
			#序号
			$market[$k]['serial_number']=$number[$k];	

			$market[$k]['employee'] = $this->main_data_model->setTable('employee')->getOne(array('employee_id'=>$v['employee_id']),'employee_name');

			#提醒
			$tmp= $this->main_data_model->setTable('time_remind')
										->select('*',array('market_id'=>$v['market_id'],'time_remind_status !='=>-1));	
			$market[$k]['message']=$this->_dataProcess($tmp,'market_id');
		}

		#分页类
		$this->load->library('pagination');
		
		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url);

		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 

		$config['num_links'] = 5;
		$config['page_query_string'] = true;
		
		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$data['market_info']=array(
			'count'=>$count,
			'list'=>$market,
			'page'=>$page,
			'page'=>$create_page,
			'search'=>$search
		);
		$this->load->view('market_list',$data);
	}

	public function add()
	{
		$check=array(
			array('school','学校机构'),
		);
		check_form($check);
		
		if ($this->form_validation->run() == FALSE){

			$this->load->model('employee_model');
			$data['marketing_specialist'] = $this->employee_model->selectEmployee(18);

			$this->load->view('market_add',$data);
	  	}else{
	  		//接收联系人资料
			$contanct_people = $this->input->post("contanct_people");
	  		$role = $this->input->post("role");
	  		$phone_number = $this->input->post("phone_number");
	  		$telephone = $this->input->post("telephone");
	  		$qq = $this->input->post("qq_number");
	  		$email = $this->input->post("email_number");

	  		//接收基本信息
	  		$data = array();
	  		$data['school']  	= $this->input->post("school");#学校
			$data['login_date'] = strtotime($this->input->post("login_date"));#登记日期
			$data['education']  = $this->input->post("education");#学历性质
			$data['term']       = $this->input->post("term");#学期分配
			$data['area']       = $this->input->post("area");#区域
			$data['website'] 	= $this->input->post("website");#学校介绍/网址
			$data['address']	= $this->input->post("address");#校区地址
			$data['route']    	= $this->input->post("route");#乘车路线

			//如果接收到 员工id，则表示是超级管理员
			$employee=$this->input->post("employee_id");
			if($employee){
				$data['employee_id'] = $employee;
			}else{
				$data['employee_id'] = getcookie_crm('employee_id');#员工ID
			}
			#返回插入的id
	  		$res = $this->main_data_model->insert($data,'market');

	  		//联系人资料
	  		$contact=array();
	  		foreach($contanct_people as $k=>$v){
	  			$contact[]=array(
  					'market_id'	=>$res,
  					'person_name'=>$contanct_people[$k],
  					'role'=>$role[$k],
  					'mobilephone'=>$phone_number[$k],
  					'telephone'=>$telephone[$k],
  					'qq'=>$qq[$k],
  					'email'=>$email[$k]
  				);
	  		}
	  		$this->main_data_model->insert_batch($contact,'market_person');

	  		if($res>0){
	  			show_message('添加成功！',site_url(module_folder(6).'/market/index'));
	  		}else{
	  			show_message('添加失败');
	  		}
		}

	}

	public function edit()
	{
		$edit = $this->uri->segment(5,0);
		if ($edit==0) {
			show_message('无效的参数!',site_url(module_folder(6).'/market/index'));			
		}

		//检查学生所属者
		$this->_checkPower($edit);

		$check=array(
			array('school','学校机构'),
		);
		check_form($check);
		
		if ( $this->form_validation->run() == FALSE){
			//获取信息
			$where=array('market_id'=>$edit);
			$data['market'] = $market = $this->main_data_model->getOne($where);

			//联系人信息
			$contact_info = $this->main_data_model->getOtherAll('*',$where,'market_person');
			$data['contact_info1']   =array_shift($contact_info);
			$data['contact_info']    =$contact_info;

			//市场专员
			if(getcookie_crm('employee_power')==1){
				$this->load->model('employee_model');
				$data['marketing_specialist'] = $this->employee_model->selectEmployee(18);
			}
			//跳转地址
			if(isset($_SERVER['HTTP_REFERER'])){
				$data['location']=$_SERVER['HTTP_REFERER'];//跳转地址
			}else{
				$data['location']=site_url(module_folder(6).'/market/index');	
			}	

			$this->load->view('market_edit',$data);
	  	}else{
	  		//接收跳转地址
			$location=$this->input->post('location');

			//接收联系人资料
			$contanct_people = $this->input->post("contanct_people");
	  		$role = $this->input->post("role");
	  		$phone_number = $this->input->post("phone_number");
	  		$telephone = $this->input->post("telephone");
	  		$qq = $this->input->post("qq_number");
	  		$email = $this->input->post("email_number");

			
			$update_contanct_people = $this->input->post("update_contanct_people");
	  		$update_role = $this->input->post("update_role");
	  		$update_phone_number = $this->input->post("update_phone_number");
	  		$update_telephone = $this->input->post("update_telephone");
	  		$update_qq = $this->input->post("update_qq_number");
	  		$update_email = $this->input->post("update_email_number");

	  		//接收基本信息
	  		$data = array();
	  		$data['school']  	= $this->input->post("school");#学校
			$data['login_date'] = strtotime($this->input->post("login_date"));#登记日期
			$data['education']  = $this->input->post("education");#学历性质
			$data['term']       = $this->input->post("term");#学期分配
			$data['area']       = $this->input->post("area");#区域
			$data['website'] 	= $this->input->post("website");#学校介绍/网址
			$data['address']	= $this->input->post("address");#校区地址
			$data['route']    	= $this->input->post("route");#乘车路线

			$employee=$this->input->post("employee_id");
			if($employee){
				$data['employee_id'] = $employee;
			}else{
				$data['employee_id'] = getcookie_crm('employee_id');#员工ID
			}

			$where=array('market_id'=>$edit);
			$res= $this->main_data_model->update($where,$data,'market');

			//更新联系人资料
			if($update_contanct_people && !empty($update_contanct_people)){
				foreach($update_contanct_people as $k=>$v){
					$v= trim($v);
					$where_contact = array('person_id'=>$k);
					if($v!=''){
			  			$update_contact=array(
		  					'person_name'=>$update_contanct_people[$k],
		  					'role'=>$update_role[$k],
		  					'mobilephone'=>$update_phone_number[$k],
		  					'telephone'=>$update_telephone[$k],
		  					'qq'=>$update_qq[$k],
		  					'email'=>$update_email[$k]
		  				);
						$res1 = $this->main_data_model->update($where_contact,$update_contact,'market_person');
					}else{
						//如果为空，就删除
						//$this->main_data_model->delete($where_contact,1,'market_person');
					}
				}
			}
			
			//插入联系人资料
			if($contanct_people && !empty($contanct_people)){
	  			$contanct_people=array_unique($contanct_people);
				foreach($contanct_people as $k=>$v){
					$v= trim($v);
					if($v!=''){
						$insert_contact=array(
		  					'market_id'=>$edit,
		  					'person_name'=>$contanct_people[$k],
		  					'role'=>$role[$k],
		  					'mobilephone'=>$phone_number[$k],
		  					'telephone'=>$telephone[$k],
		  					'qq'=>$qq[$k],
		  					'email'=>$email[$k]
		  				);
						$res1 = $this->main_data_model->insert($insert_contact,'market_person');
					}

				}
			}
			
	  		if($res||$res1){
	  			show_message('编辑成功！',$location);
	  		}else{
	  			redirect($location);
	  		}
			
		}

	}

	/**
	 * 虚拟删除咨询者，同步删除学员、客户（一般都是误操作）
	 */
	public function changeStatus()
	{
		//获取跳转地址
		$url=unserialize(getcookie_crm('url'));

		$location=$url[1][1];
		$dele_arr= $this->input->post('checkbox_market');

		//检查咨询者所属者
		$this->_checkPower($dele_arr,'in');

		$where = $remind_where = db_create_in($dele_arr,'market_id');
		#修改咨询者状态
		$status = array('show_status'=>0);
		$result = $this->main_data_model->update($where,$status,'market');

		if($result>0){
  			show_message('删除成功!',$location);	
  		}else{
  			show_message('操作失败!');
  		}
	}

	public function info()
	{
		header("Content-Type:text/html;charset=utf-8");
		#接收
		$id = $this->input->post("id");

		//检查咨询者所属者
		$check_result = $this->_checkPower($id,'','ajax');	

		if(!$check_result){ //如果返回的是 0,这个
			$res['status']=0;
			echo json_encode($res);
			exit;
		}

		$where = array('market_id'=>$id);
		//市场列表
		$market = $this->main_data_model->getOne($where,'','market');
		#联系人信息
		$contact = $this->main_data_model->setTable('market_person')->select('*',$where);
		
		$str='<table border="1" width="100%">';
		$str.="<tr>";
		$str.="<td width='23%'>学校</td><td colspan='2'>".$market['school']."</td>";
		$str.="</tr>";

		#登记日期
		$str.="<tr>";
		$str.="<td>登记日期</td><td colspan='2'>".date('Y-m-d',$market['login_date'])."</td>";
		$str.="</tr>";
		

		#学历性质
		if($market['education'] != ''){
			$str.="<tr>";
			$str.="<td>学历性质</td><td colspan='2'>".$market['education']."</td>";
			$str.="</tr>";
		}		
		#联系人
		if($contact){
			foreach($contact as $item){
				$str.="<tr>";
				$str.="<td rowspan='6'>联系人</td><td>姓名</td><td>".$item['person_name']."</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<td>职责</td><td>".$item['role']."</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<td>手机号码</td><td>".$item['mobilephone']."</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<td>固定电话</td><td>".$item['telephone']."</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<td>QQ</td><td>".$item['qq']."</td>";
				$str.="</tr>";
				$str.="<tr>";
				$str.="<td>邮箱</td><td>".$item['email']."</td>";
				$str.="</tr>";
			}
		}
		#学期分配
		if($market['term'] != ''){
			$str.="<tr>";
			$str.="<td>学期分配</td><td colspan='2'>".$market['term']."</td>";
			$str.="</tr>";
		}
		
		#区域
		if(trim($market['area'])!=''){
			$str.="<tr>";
			$str.="<td>区域</td><td colspan='2'>".$market['area']."</td>";
			$str.="</tr>";
		}

		#学校介绍、网址
		if(trim($market['website'])!=''){
			$str.="<tr>";
			$str.="<td>学校介绍、网址</td><td colspan='2'>".$market['website']."</td>";
			$str.="</tr>";
		}

		#校区地址
		if(trim($market['address'])!=''){
			$str.="<tr>";
			$str.="<td>校区地址</td><td colspan='2'>".$market['address']."</td>";
			$str.="</tr>";
		}

		#乘车路线
		if(trim($market['route'])!=''){
			$str.="<tr>";
			$str.="<td>乘车路线</td><td colspan='2'>".$market['route']."</td>";
			$str.="</tr>";
		}


		$str.="</table>";

		$res['data'] = $str;
		$res['info_url'] = site_url(module_folder(6).'/market/edit/'.$id);
		$res['status']=1;
		
		echo json_encode($res);
		exit;

	}
	//ajax删除联系人
	public function deletePerson()
	{
		header("Content-Type:text/html;charset=utf-8");

		$person_id = $this->input->post('pid');

		$where=array('person_id'=>$person_id);	
		$res=$this->main_data_model->delete($where,1,'market_person');

		if($res){
			echo json_encode(array('status'=>1));
		}else{
			echo json_encode(array('status'=>0));
		}
		exit;
	}
	/**
	 * 建立url地址
	 */
	private function _buildUrl($arr)
	{

		$param_url = "";
		foreach($arr as $key=>$val){
			if(trim($val)!=''){
				$param_url .= $key."=".$val."&";	
			}
		}
		$param_url = rtrim($param_url, "&");
		
		
		$urls =site_url(module_folder(6)."/market/index?".$param_url);
		
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
	private function menuProcess()
	{	
		$url[0]=array('市场列表', site_url(module_folder(6).'/market/index'));
		$per_page = $this->input->get('per_page')?$this->input->get('per_page'):'1';

		#搜索
		$search= trim($this->input->get('search'))!=''?trim($this->input->get('search')):'';
		#搜索分类
		$key= $this->input->get('key')?$this->input->get('key'):'school';
		
		if($search!=''){
			$url[1]=array('市场搜索',site_url(module_folder(6).'/market/index?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));	
		}else{
			$url[1]=array('市场分页',site_url(module_folder(6).'/market/index?'.'search='.$search.'&key='.$key.'&per_page='.$per_page));
		}
		

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
			show_message('权限不对',site_url(module_folder(6).'/market/index'));
		}

		$this->load->model('market_model');

		$res= $this->market_model->checkData($id,$type);

		
		if ($res===0) {
			if($is_ajax=='ajax'){
				return 0;//表示操作了非法数据	
			}else{
				show_message('权限不对',site_url(module_folder(6).'/market/index'));
			}
		
		}else{
			return 1;
		}

	}

	/**
	 * 获取学员信息
	 */
	public function marketInfo(){

		$where_id = array('market_id'=>$_POST['market_id']);
		#查询咨询者的姓名,手机,QQ加入到提醒内容		
		$market_info = $this->main_data_model->getOne($where_id,'school,market_id','market');

		if( !empty($market_info) ){
			$marketinfo = "学校: ".$market_info['school'];
		}else{
			$marketinfo = '';
		}

		echo json_encode(array('info'=>$marketinfo));
		exit;
	}
}