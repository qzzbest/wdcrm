<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_message_module extends CI_Module {

	function __construct()
	{
		parent::__construct();
		check_login();
	}
	
	//示例：信息获取未读信息(时时监听)
	public function index()
	{
		//通过角色判断当前是什么身份

		//咨询师消息提醒
		$employee_id = getcookie_crm('employee_id');
		$where = array('employee_id'=>$employee_id);
		$data = $this->main_data_model->getOne($where,'remind_time','employee');
		$auto_time = $data['remind_time'];

		//咨询者、学员咨询记录提醒
		$where_one = "time_remind_time != 0 and time_remind_time <= ".time()." AND employee_id = $employee_id AND consultant_record_id != 0 AND time_remind_status = 0";
		
		//一般提醒（咨询者、学员）
		$where_two = "time_remind_time != 0 and time_remind_time <= ".time()." AND employee_id = $employee_id AND consultant_record_id = 0 AND time_remind_status = 0";

		$count_one = $this->main_data_model->count($where_one,'time_remind' );
		$count_two = $this->main_data_model->count($where_two,'time_remind');

		$res['remind_count_one'] = $count_one;  //咨询者、学员咨询记录提醒数量
		$res['remind_count_two'] = $count_two; //一般提醒（咨询者、学员）数量

		//一次性查出所有的提醒信息
		$where = "time_remind_time != 0 and time_remind_time <= ".time()." AND employee_id = $employee_id AND time_remind_status = 0";
		//$remind_info = $this->main_data_model->select('*',$where,0,0,4,0,'time_remind');

		$remind_info = $this->main_data_model->select('*',$where,0,0,0,0,'time_remind');

		$res['remind_info'] = $remind_info;
		$res['remind_data'] = '';
		$num = 0;
		$url = site_url(module_folder(5).'/message/remindAction');
		$delay_url = site_url(module_folder(5).'/message/configAction');
		foreach ($remind_info as $key => $value) {
			
			#查询咨询者的姓名,手机,QQ加入到提醒内容
			$where_id = array('consultant_id'=>$value['consultant_id']);
			$consultant_info = $this->main_data_model->getOne($where_id,'consultant_name','consultant');
			$phone_infos = $this->main_data_model->getOtherAll('phone_number',$where_id,'consul_stu_phones');
			$qq_infos = $this->main_data_model->getOtherAll('qq_number',$where_id,'consul_stu_qq');
			//分割数组
			$phone=$this->_dataProcess($phone_infos,'phone_number');
			$phone=implode(',', $phone);
			$qq=$this->_dataProcess($qq_infos,'qq_number');
			$qq=implode(',', $qq);

			if( !empty($consultant_info) ){
				$consultantinfo = "咨询者姓名: ".$consultant_info['consultant_name']."&nbsp;&nbsp;手机号码: ".$phone."&nbsp;&nbsp;QQ号码: ".$qq.'<br /><br />';
			}else{
				$consultantinfo = '';
			}

			#获取学生ID
			$where_stuid = array('consultant_id'=>$value['consultant_id']);
			$student_info = $this->main_data_model->getOne($where_stuid,'student_id','student');
			
			#判断是否是“生活补贴”和“工资补贴”
			$payment_type = $value['payment_type'];
			if($payment_type == 1){ #生活补贴	
				$payment_address=site_url(module_folder(2).'/student_payment/index/'.$student_info['student_id']);	
				$payment_jump1='<a type="button" data_url="'.$payment_address.'" style="margin-left:20px" class="btn btn-xs btn-danger delay_remind">补贴领取</a>'; 
			}else{
				$payment_jump1='';
			}

			if($payment_type == 4){ #工资方案
				$payment_address=site_url(module_folder(2).'/student_payment/index/'.$student_info['student_id']);	
				$payment_jump2='<a type="button" data_url="'.$payment_address.'" style="margin-left:20px" class="btn btn-xs btn-danger delay_remind">工资领取</a>'; 
			}else{
				$payment_jump2='';
			}

			//是否是咨询者的提醒
			if(!empty($value['consultant_id'])){
				$address=site_url(module_folder(2).'/advisory/index/index/0?consultant_id='.$value['consultant_id']);
				$jump='<a type="button" data_url="'.$address.'" style="margin-left:20px" class="btn btn-xs btn-danger delay_remind">咨询者信息</a>'; 
			}else{
				$jump='';
			}
			

			$remind_content = $value['time_remind_content'];
			$time_date = date('Y-m-d',$value['time_remind_time']);
			$time_remind = date('H:i:s',$value['time_remind_time']);
			$remind_id = $value['time_remind_id'];
			$num = $key+1;
			$remind_time = '（'.date('Y-m-d H:i:s',$value['time_remind_time']).'）';

			$res['remind_data'] .= <<<ABC
			<style type="text/css">
				.panel-collapse .modal-body{
					padding:0px;
				}
				.panel-collapse .btn-info{
					padding:1px 10px;
				}
				
			</style>
			<div class="panel panel-default" style="overflow:inherit;">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse$num">
					
ABC;

				
			if($key == 0){

			$res['remind_data'] .= <<<ABCD
						<i class="icon-angle-down bigger-110" data-icon-hide="icon-angle-down" data-icon-show="icon-angle-right"></i>
							<span time-data="$remind_time">&nbsp;提醒 $num $remind_time </span>
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse in" id="collapse$num">
					<div class="panel-body">
						$consultantinfo
						<div class="modal-body">
							<table cellpadding="5px">
								<tbody>
									<tr>
										<td class="col-sm-2">提醒信息：</td>
										<td class="col-sm-8">
											<textarea style="height:100px;" class="form-control remind_content" name="remind_content" placeholder="请输入提醒内容" required="" oninvalid="setCustomValidity('请输入提醒内容');" oninput="setCustomValidity('');">$remind_content</textarea>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">提醒时间</td>
										<td>
											<div class="col-sm-6">
												<div class="input-group">
													<input class="form-control date-picker remind_date" data-event="add_msg" type="text" value="$time_date" name="remind_date" data-date-format="yyyy-mm-dd">
													<span class="input-group-addon">
														<i class="icon-calendar bigger-110"></i>
													</span>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="input-group bootstrap-timepicker">
													<input type="text" data-event="add_msg_time" name="remind_time" value="$time_remind" class="form-control remind_time">
													<span class="input-group-addon">
														<i class="icon-time bigger-110"></i>
													</span>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>	
						</div>
					</div>
		
ABCD;
			}else{

			$res['remind_data'] .= <<<ABCD
						<i class="bigger-110 icon-angle-right" data-icon-hide="icon-angle-down" data-icon-show="icon-angle-right"></i>
							<span time-data="$remind_time">&nbsp;提醒 $num $remind_time</span>
						</a>
					</h4>
				</div>
				<div class="panel-collapse collapse" id="collapse$num">
					<div class="panel-body">
						$consultantinfo
						<div class="modal-body">
							<table cellpadding="5px">
								<tbody>
									<tr>
										<td class="col-sm-2">提醒信息：</td>
										<td class="col-sm-8">
											<textarea style="height:100px;" class="form-control remind_content" name="remind_content" placeholder="请输入提醒内容" required="" oninvalid="setCustomValidity('请输入提醒内容');" oninput="setCustomValidity('');">$remind_content</textarea>
										</td>
									</tr>
									<tr>
										<td class="col-sm-2">提醒时间</td>
										<td>
											<div class="col-sm-6">
												<div class="input-group">
													<input class="form-control date-picker remind_date" data-event="add_msg" type="text" name="remind_date" value="$time_date" data-date-format="yyyy-mm-dd">
													<span class="input-group-addon">
														<i class="icon-calendar bigger-110"></i>
													</span>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="input-group bootstrap-timepicker">
													<input type="text" data-event="add_msg_time" name="remind_time" value="$time_remind" class="form-control remind_time">
													<span class="input-group-addon">
														<i class="icon-time bigger-110"></i>
													</span>
												</div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>	
						</div>
					</div>
					
ABCD;

			}

			$res['remind_data'] .= <<<ABCDE
				<div style="text-align:center; padding-bottom:15px;">
						<a data="$remind_id" data_type="editRemind" type="button" class="btn btn-xs btn-info edit_remind" data-toggle="modal">更改</a> &nbsp;&nbsp;&nbsp;&nbsp;
						<a data="$remind_id" data_type="noRemind" type="button" class="btn btn-xs btn-info noRemind" data-toggle="modal">忽略</a> &nbsp;&nbsp;&nbsp;&nbsp;
						<a data="$remind_id" data_type="ignore" type="button" class="btn btn-xs btn-info ignore_remind" data-toggle="modal" data-target="#ignore_remind$num">删除</a>
						$jump $payment_jump1 $payment_jump2
					</div>
				</div>
			</div>
ABCDE;
		}
		$res['remind_data'] .= <<<ABCDE
<script type="text/javascript">

jQuery(function($) {

	//时间选择控件
	$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
		$(this).prev().focus();
		$('.datepicker').css('z-index',1060);
	
	});

	$('.date-picker').focus(function(){
		$('.datepicker').css('z-index',1060);

	});

	$('.remind_time').timepicker({
		minuteStep: 1,
		showSeconds: true,
		showMeridian: false
	}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});

	$('.remind_time').focus(function(){
		$('.dropdown-menu').css('z-index',1060);

	});

	//ajax 处理删除提醒
	$('.ignore_remind').click(function(){
		var _this=this;
		var remind_id=parseInt($(this).attr("data"));
		var data_type=parseInt($(this).attr("data_type"));
		$.ajax({
	        type: "POST",
	        url: "$url",
	        data: "remind_id="+remind_id+"&data_type="+data_type,
	        dataType:'json',
	        success: function(res){
	       		if (res.status==0) {
	       			//删除该div
	       			wdcrm.removeInput(_this,3);
	       			
	       			if( $('.panel-default').length == 0 ){
						//关闭弹窗
						$('#autoRemind').hide();
						wdcrm.removeInput($('.modal-backdrop')[0],0);
						$('#accordion').html();
						$('body').removeClass('modal-open');

						//关闭桌面提醒
						
	       				//关闭警告钟
						audio_player.pause();

						//刷新页面
						//window.location.reload();
						wdcrm.mes();
						TT = setInterval(wdcrm.audio,3000);
					}

	       			$('.panel-title').find('span').each(function(i){

						this.innerHTML='提醒'+(i+1)+$(this).attr('time-data');

						//默认让第一个提醒内容显示
						if( i+1 == 1 ){
							$(this).parent().parent().parent().next().addClass('in');
							$(this).parent().parent().parent().next().css('height','auto');
						}
						
	       			});
	       		};
	        }
   		});
	});

	$('.edit_remind').on('click',function(){
		var remind_content = $(this).parent().prev().find('.remind_content').val();
		var remind_date = $(this).parent().prev().find('.remind_date').val();
		var remind_time = $(this).parent().prev().find('.remind_time').val();
		var _this=this;
		var remind_id=parseInt($(this).attr("data"));
		var data_type=$(this).attr("data_type");
		$.ajax({
	        type: "POST",
	        url: "$url",
	        data: "remind_id="+remind_id+"&remind_date="+remind_date+"&remind_time="+remind_time+"&remind_content="+remind_content+"&data_type="+data_type,
	        dataType:'json',
	        success: function(res){
	        	if(res.status==1){
	        		alert('您选择的时间应该大于当前时间！');
	        	}else if(res.status==0){
	        		alert('更改成功！');
	        		//删除该div
	       			wdcrm.removeInput(_this,3);

	       			if( $('.panel-default').length == 0 ){
						//关闭弹窗
						$('#autoRemind').hide();
						wdcrm.removeInput($('.modal-backdrop')[0],0);
						$('#accordion').html();
						$('body').removeClass('modal-open');

						//关闭桌面提醒
						
	       				//关闭警告钟
						audio_player.pause();

						//刷新页面
						//window.location.reload();
						wdcrm.mes();
						TT = setInterval(wdcrm.audio,3000);
					}

	       			$('.panel-title').find('span').each(function(i){
						this.innerHTML='提醒'+(i+1)+$(this).attr('time-data');
						//默认让第一个提醒内容显示
						if( i+1 == 1 ){
							$(this).parent().parent().parent().next().addClass('in');
						}						
	       			});
	        	}
	        }
   		});
	});

	$('.noRemind').on('click',function(){
		var _this=this;
		var remind_id=parseInt($(this).attr("data"));
		var data_type=$(this).attr("data_type");
		$.ajax({
	        type: "POST",
	        url: "$url",
	        data: "remind_id="+remind_id+"&data_type="+data_type,
	        dataType:'json',
	        success: function(res){
	        	if(res.status==0){
	        		alert('忽略成功，请查看提醒列表！');
	        		//删除该div
	       			wdcrm.removeInput(_this,3);

	       			if( $('.panel-default').length == 0 ){
						//关闭弹窗
						$('#autoRemind').hide();
						wdcrm.removeInput($('.modal-backdrop')[0],0);
						$('#accordion').html();
						$('body').removeClass('modal-open');

						//关闭桌面提醒
						
	       				//关闭警告钟
						audio_player.pause();

						//刷新页面
						//window.location.reload();
						wdcrm.mes();
						TT = setInterval(wdcrm.audio,3000);
					}

	       			$('.panel-title').find('span').each(function(i){
						this.innerHTML='提醒'+(i+1)+$(this).attr('time-data');
						//默认让第一个提醒内容显示
						if( i+1 == 1 ){
							$(this).parent().parent().parent().next().addClass('in');
						}						
	       			});
	        	}
	        }
   		});
	});

	//ajax 处理“咨询者信息”、“补贴领取”、“工资领取”
	$('.delay_remind').click(function () {
		//关闭警告钟
		audio_player.pause();
		var _this = this;
		//关闭弹窗
		$('#autoRemind').hide();
		wdcrm.removeInput($('.modal-backdrop')[0],0);
		$('#accordion').html();
		$('body').removeClass('modal-open');

		$.ajax({
	        type: "POST",
	        url: "$delay_url",
	        data: "type=setDelayTime",
	        dataType:'json',
	        success: function(res){
	        	if(res.status == 1){
	        		var pay_url = _this.getAttribute('data_url');
	        		window.location.href = pay_url;
	        	}
	        }
	    });

	});
	
});

</script>
ABCDE;
		//教务消息提醒

		//就业消息提醒

		echo json_encode($res);
		exit;
		
	}

	public function remindAction()
	{
		$remind_id = $this->input->post('remind_id');
		$data_type = $this->input->post('data_type');

		$where = array('time_remind_id'=>$remind_id);

		if($data_type == 'editRemind'){  //修改提醒
			$remind_content = $this->input->post('remind_content');
			$remind_date = $this->input->post('remind_date');
			$remind_time = $this->input->post('remind_time');
			$time = strtotime($remind_date.' '.$remind_time);

			if($time <= time()){echo json_encode(array('status'=>1));exit;}

			$data = array('time_remind_content'=>$remind_content,'time_remind_time'=>$time);

		}else if($data_type == 'noRemind'){  //忽略提醒（不删除、不弹窗、在提醒列表照常显示）

			$data = array('time_remind_status'=>1);
			
		}else{

			$data = array('time_remind_status'=>-1);
		}

		$this->main_data_model->update($where,$data,'time_remind');	
		echo json_encode(array('status'=>0));
		exit;

	}

	public function configAction()
	{
		$type = $this->input->post('type');
		$where = array('employee_id'=>getcookie_crm('employee_id'));

		if($type == 'settime'){
			$data = array('remind_time'=>60*5*1000);		
		}elseif($type == 'setDelayTime'){
			$data = array('remind_time'=>60*3*1000);
		}
		$this->main_data_model->update($where,$data,'employee');

		echo json_encode(array('status'=>1));
	}

	public function info()
	{
		header("Content-Type:text/html;charset=utf-8");
		//header("Cache-Control:no-cache");
		$id = $_POST["id"];
		$where = array('time_remind_id'=>$id);
		$res=$this->main_data_model->getOne($where,'*','time_remind');
		$remind_content = $res['time_remind_content'];
		$url = site_url(module_folder(5).'/message/remindAction');
		$str=<<<HTML
		<div>
			<div class="panel-body">
				$remind_content
			</div>
			<div style="float:right;">
	
					<a data="$id" data_type="ignore" type="button" class="btn btn-xs btn-info ignore_remind" data-toggle="modal" data-target="#ignore_remind">删除</a> 
				</div>
			</div>
		</div>

<script type="text/javascript">

jQuery(function($) {

	//ajax 处理删除提醒
	$('.ignore_remind').click(function(){
		var _this=this;
		var remind_id=parseInt($(this).attr("data"));
		var data_type=parseInt($(this).attr("data_type"));
		$.ajax({
	        type: "POST",
	        url: "$url",
	        data: "remind_id="+remind_id+"&data_type="+data_type,
	        dataType:'json',
	        success: function(res){
	       		if (res.status==0) {

	       			//关闭弹窗
					$('#youModal').hide();
					$('body').removeClass('modal-open');
					wdcrm.removeInput($('.modal-backdrop')[0],0);
					
	  
	       		};
	        }
   		});
	});
	$('.close').click(function(){
		
	});
});

</script>
HTML;
		echo json_encode(array('data'=>$str));
		exit;
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