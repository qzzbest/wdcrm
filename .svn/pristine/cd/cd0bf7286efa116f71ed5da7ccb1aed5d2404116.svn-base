<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 面试咨询者来访统计表
 */
class Teaching_teaching_statistics_module extends CI_Module {

	public function __construct()
	{
		parent::__construct();
		check_login();
	}

	/*
	 * 面试咨询者来访统计表
	 */
	public function index()
	{

		$this->load->model('teaching_specialist_model');

		#当前页码
		$data['cur_pag']= $page = $this->input->get('per_page') ? $this->input->get('per_page'):1;

		$limit=20;#每页显示多少条
		
		$start=($page-1)*$limit;

		//多个查询参数处理
		$param_url=array();

		#年份ID
		$selectYear=trim($this->input->get('selectYear'))!=''?trim($this->input->get('selectYear')):'';

		#月份ID
		$selectMonth=trim($this->input->get('selectMonth'))!=''?trim($this->input->get('selectMonth')):'';

		#天数ID
		$selectDay=trim($this->input->get('selectDay'))!=''?trim($this->input->get('selectDay')):'';

		#学生姓名
		$data['search_name']=$search_name=trim($this->input->get('search_name'))!=''?trim($this->input->get('search_name')):'';
		$param_url['search_name']=$search_name;
		//echo $data['search_name'];

		#咨询师
		$data['selected_teach']=$selected_teach=trim($this->input->get('teach'))!=''?trim($this->input->get('teach')):'';

		#搜索分类
		$type= $this->input->get('key')?$this->input->get('key'):'consultant_name';
		$param_url['key']=$type;

#start 没用
		// if(!empty($selectYear) && !empty($selectMonth)){
		// 	$data['selectYear'] = $selectYear;
		// 	$data['selectMonth'] = $selectMonth;
		// }else if(!empty($selectYear) && empty($selectMonth)){
		// 	$data['selectYear'] = $selectYear;
		// 	$data['selectMonth'] = date('m',time());
		// }else if(empty($selectYear) && !empty($selectMonth)){
		// 	$data['selectYear'] = date('Y',time());
		// 	$data['selectMonth'] = $selectMonth;
		// }else{
		// 	$data['selectYear'] = date('Y',time());
		// 	$data['selectMonth'] = date('m',time());
		// }

		// $date = $data['selectYear'].'-'.$data['selectMonth'];
		// $arr = AssignTabMonth($date,0);

		// $start_search_time = strtotime($arr['first_date']);		
		// $end_search_time = strtotime($arr['last_date']);		

		$param_url['teach']=$selected_teach;
		// $param_url['selectYear']=$data['selectYear'];
		// $param_url['selectMonth']=$data['selectMonth'];

		#接收日期
		$data['starttime'] = $starttime = $this->input->get('start_time') ? $this->input->get('start_time'):'';
		//$data['endtime'] = $endtime = $this->input->get('end_time') ? $this->input->get('end_time'):'' ;

		$start_time = strtotime($starttime.'00:00:00');
		$param_url['start_time']=$starttime;

		$end_time = strtotime($starttime.'23:59:59');

#end 没用
		#咨询师
		$this->load->model('p_employee_model');
		$data['teach']= $this->p_employee_model->selectDepartment();
		
		// $data['count_money'] = $this->loan_time_model->countMoney($start_search_time,$end_search_time,$channel_id,$statistics_id,$selected_teach,$start_time,$end_time,$search_name);

		$teaching_info = $this->teaching_specialist_model->getAll($start,$limit,$selected_teach,$start_time,$end_time,$search_name,$type);

		$count = $this->teaching_specialist_model->info_count($selected_teach,$start_time,$end_time,$search_name,$type);

		#翻页序号
		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数

		//$total_page = floor($count/$limit) != 0 ? floor($count/$limit) : 1;//总共多少页

		$number = array();
		for($i=$begin;$i<=$total;$i++){
			$number[]=$i;//当前页的每个值赋给数组
		}

		foreach ($teaching_info as $key => $value) {
			#序号
			$teaching_info[$key]['serial_number']=$number[$key];//每条数据对应当前页的每一个值

			#查询咨询师信息
			$employee_info = $this->p_employee_model->selectEmployee($value['employee_id']);
 			$teaching_info[$key]['employee_name'] = $employee_info['employee_name'];

 			#手机号
			$tmp= $this->main_data_model->setTable('consul_stu_phones')
										->select('phone_number',array('consultant_id'=>$value['consultant_id']));
		
			
			$teaching_info[$key]['phone']=$this->_dataProcess($tmp,'phone_number');
			
			#qq
			$tmp= $this->main_data_model->setTable('consul_stu_qq')
										->select('qq_number',array('consultant_id'=>$value['consultant_id']));
			
			
			$teaching_info[$key]['qq']=$this->_dataProcess($tmp,'qq_number');
		}

		

		#分页类
		$this->load->library('pagination');

		$data['tiao']=$config['base_url']=$this->_buildUrl($param_url);
	
		$config['total_rows'] = $count;
		$config['per_page']   = $limit; 

		$config['uri_segment']= 5;
		$config['num_links']  = 5;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$page= $this->pagination->create_links();

		#赋值
		$data['adviachieve_info']=array(
			'list'=>$teaching_info,
			'page'=>$page,
			'type'=>$type
		);

		#指定模板
		$this->load->view('teaching_statistic_list',$data);
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
		
		$urls =site_url(module_folder(2)."/achieve_statistics/index?".$param_url);
		
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
}