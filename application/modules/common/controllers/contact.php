<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 通讯录操作
 */
class Common_contact_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login(); 
	}

	/**
	 * 通讯录页面
	 */
	public function index()
	{
		$page = $this->input->get('per_page') ? $this->input->get('per_page'):1;
		$limit=10;
		$start=($page-1)*$limit;
		$field='*';

		$this->load->model('employee_model');
		//查询管理员列表
		$list= $this->employee_model->select_contact($start,$limit);
		$count= $this->employee_model->select_contact_count();

		$begin = ($page-1)*$limit+1;//当前页第几条开始
		$total = $page*$limit;//每页总数

		$number = array();
		for($i=$begin;$i<=$total;$i++){
			$number[]=$i;//当前页的每个值赋给数组
		}

		foreach ($list as $k => $v) {
			#序号
			$list[$k]['serial_number']=$number[$k];//每条数据对应当前页的每一个值

			#部门
			$list[$k]['department']=$this->main_data_model->setTable('department')->getOne(array('department_id'=>$v['department_id']),'department_name');

			#职位
			$list[$k]['employee']=$this->main_data_model->setTable('employee_job')->getOne(array('employee_job_id'=>$v['employee_job_id']),'employee_job_name');

			#手机
			$list[$k]['phone']= $this->main_data_model->setTable('employee_phone')->getOtherAll('employee_phone_number,is_workphone',array('employee_id'=>$v['employee_id']));

			#电话
			
			#QQ
			$list[$k]['qq']= $this->main_data_model->setTable('employee_qq')->getOtherAll('employee_qq,is_workqq',array('employee_id'=>$v['employee_id']));

			#邮箱
			$list[$k]['email']= $this->main_data_model->setTable('employee_email')->getOtherAll('employee_email_number,is_workemail',array('employee_id'=>$v['employee_id']));
			
			#微信
			$list[$k]['weixin']= $this->main_data_model->setTable('employee_weixin')->getOtherAll('employee_weixin_number',array('employee_id'=>$v['employee_id']));
		}

		#分页类
		$this->load->library('pagination');
		$config['base_url'] = site_url(module_folder(5).'/contact/index?');
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['num_links'] = 4;
		$config['page_query_string']=true;

		$this->pagination->initialize($config);
		$create_page= $this->pagination->create_links();

		$data['employee_info']=array(
			'list'=>$list,
			'create_page'=>$create_page,
			);
		$this->load->view('contact_list',$data);
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

