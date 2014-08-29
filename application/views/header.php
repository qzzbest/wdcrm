<?php 
$CI =& get_instance();
$where = array('employee_id'=>getcookie_crm('employee_id'));
$data = $CI->main_data_model->getOne($where,'remind_time','employee');

?>
<style type="text/css">
	.ace-nav li a [class^="icon-"]{
		margin-left: 7px;
	} 
	.ace-nav li:last-child a [class^="icon-"]{		
		width:auto;
	}
	.ace-nav li:last-child a{
		color: #555;
	}
	.bigger-120{
		font-size:140%;
	}
	.modal-body{
		padding-bottom:40px;
	}
	.yellow{
		background-color:yellow;
		width:80px;
		margin-right:2px;
	}
	b, strong{
		font-family:Microsoft Yahei;
		font-size: 14px;
	}
	.ace-nav>li>a{
		padding:0 5px;
	}
	b, strong{
		font-size: 13px;
	}
</style>
<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-leaf"></i>
							文豆CRM管理系统
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<?php
						$admin_job = array(11,19);#超管
						$advisory_job = array(2,11,19);#咨询师、超管
						$teacher_job = array(1,11,12,19);#讲师、助教、超管
						$teach_job = array(4,5,11,19); #教务、超管
						$employment_job = array(8,11,19); #人事就业、超管

						if( in_array(getcookie_crm('employee_job_id'),$admin_job) ){
							$target = " target='_blank' ";
						}else{
							$target = " target='_self' ";
						}
						?>
						<?php if( in_array(getcookie_crm('employee_job_id'),$advisory_job) ){?>
						<li class="green">
							<a class="label" style="background:#f56b9f !important;" <?php echo $target;?> href="<?php echo site_url(module_folder(5).'/regulations/index/4');?>"><b>先就业后付款申请注意事项</b></a>
						</li>
						<?php }?>

						<li class="green">
							<a class="label" style="background:#f7793f !important;" <?php echo $target;?> href="<?php echo site_url(module_folder(5).'/regulations/index/1');?>"><b>公司行政管理制度</b></a>
						</li>
						
						<?php if( in_array(getcookie_crm('employee_job_id'),$teacher_job) ){?>
						<li class="green">
							<a class="label" style="background:#f8d539 !important;" <?php echo $target;?> href="<?php echo site_url(module_folder(5).'/regulations/index/2');?>"><b style="color:#408;">讲师岗位制度</b></a>
						</li>
						<?php }?>

						<?php if( in_array(getcookie_crm('employee_job_id'),$advisory_job) ){?>	
						<li class="green">
							<a class="label" style="background:#ace735 !important;" <?php echo $target;?> href="<?php echo site_url(module_folder(5).'/regulations/index/3');?>"><b style="color:#345;">咨询师岗位规范</b></a>
						</li>
						<li class="green" id="yellow">
							<a class="label" style="background:#42cfe0 !important;" <?php echo $target;?> href="<?php echo site_url(module_folder(5).'/consulting_questions/index');?>"><b>咨询技巧常见问题</b></a>
						</li>
						<?php }?>

						<?php if( in_array(getcookie_crm('employee_job_id'),$teach_job) ){?>
						<li class="green">
							<a class="label" style="background:#E19D80 !important;" <?php echo $target;?> href="<?php echo site_url(module_folder(5).'/regulations/index/6');?>"><b style="color:#345;">行政教务岗位规范</b></a>
						</li>
						<?php }?>

						<?php if( in_array(getcookie_crm('employee_job_id'),$employment_job) ){?>
						<li class="green">
							<a class="label" style="background:#E6E6E6; !important;" <?php echo $target;?> href="<?php echo site_url(module_folder(5).'/regulations/index/5');?>"><b style="color:#345;">人事就业岗位规范</b></a>
						</li>
						<?php }?>

						<?php if( in_array(getcookie_crm('employee_job_id'),$advisory_job) ){?>
						<li class="green" id="yellow">
								<a style="background:#4197ec !important;" target="_blank" href="<?php echo site_url(module_folder(2).'/achieve_statistics/index');?>"><b>业绩统计</b></a>
						</li>
						<?php }?>

						<?php if( in_array(getcookie_crm('employee_job_id'),$teach_job) ){?>
						<li class="green" id="yellow">
								<a style="background:#4197ec !important;" target="_blank" href="<?php echo site_url(module_folder(4).'/teaching_statistics/index');?>"><b>来访统计</b></a>
						</li>
						<?php }?>

						<li class="yellow" id="yellow">
								<a style="background:#0960f5 !important;" target="_blank" href="<?php echo site_url(module_folder(5).'/marking/index');?>"><b>评分管理</b></a>
						</li>
						<li class="purple" id="purple">
							
						</li>

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<span class="user-info">
									<small>欢迎光临,</small>
									<?php echo getcookie_crm('username');?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							
								<li class="divider"></li>

								<li>
									<a href="<?php echo site_url('login/logout');?>#">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
</div>
<!-- html5 加载音乐播放标签 -->
<audio id="audio_player">
	<source src="<?php echo base_url();?>assets/mp3/music.mp3" >
</audio>
<!--模态框（弹出 提醒信息）-->
<style type="text/css">
	.modal-header{
		padding: 10px;
	}
</style>
<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="autoRemind" style="display: none;">
	<div class="modal-dialog" style="width:645px;padding-top:100px;">
    	<div class="modal-content">
    		<div class="modal-header">
         		<button type="button" data-dismiss="modal" class="bootbox-close-button close" id="close_remind">×</button>
            	<h4 class="modal-title">请处理您的提醒信息<span style="float:right;" class="del_remind"></span></h4>
          	</div>
     		<div id="accordion" class="accordion-style1 panel-group">

			</div> 
        </div>
  	</div>
</div>

<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="youModal" style="display: none;">
  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
        <div class="modal-content">
         	<div class="modal-header">
         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
            	<h4 id="youModalLabel" class="modal-title">提醒信息</h4>
          	</div>
          	<div class="modal-body" id="info">    
          	</div>
          	<div class="modal-footer">
	            <button data-dismiss="modal" class="btn btn-info" type="button">确定</button>
	        </div>
        </div>
  	</div>
</div>





<!--模态框（弹出提醒信息）-->
<?php 
//渠道经理、市场专员
$market_job = array(18);
if( !in_array(getcookie_crm('employee_job_id'),$market_job) ){?>
<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="_action_remind" style="display: none;">
  	<div class="modal-dialog" style="width:586px;padding-top:100px;">
        <div class="modal-content">
         	<div class="modal-header">
         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
            	<h4 class="modal-title">添加提醒<span style="float:right;padding-right:10px;" id="del_remind"></span></h4>
          	</div>
          	<form action="<?php echo site_url(module_folder(2).'/remind/actionSelfRemind');?>" method="post"  id="form_remind">			
          	<input	type="hidden" name="time_remind_id" id="time_remind_id" value="" />
          	<input	type="hidden" name="consultant_id" id="consultant_id" value="" />
				<div class="modal-body">
					<div id="consultant_info" style="padding:0px 20px 20px 24px; font-size:13px;"></div>
					<table cellpadding="5px" id="remind_info">
						<tr>
							<td class="col-sm-2" align="right">姓  名</td>
							<td>
								<input type="text" name="con_stu_name" value="" />
							</td>
						</tr>
						<tr>
							<td class="col-sm-2" align="right">
								手机号码
							</td>
							<td>
								<input type="text" name="con_stu_phone" value="" />
								QQ：<input type="text" name="con_stu_qq" value="" />
							</td>
							
						</tr>
						<tr>
							<td class="col-sm-2" align="right">提醒内容</td>
							<td>
								<textarea style="height:100px;" class="form-control remind_content" name="remind_content" placeholder="请输入提醒内容" required oninvalid="setCustomValidity('请输入提醒内容');" oninput="setCustomValidity('');"></textarea>
							</td>
						</tr>

						<tr>
							<td class="col-sm-2" align="right">提醒备注</td>
							<td>
								<textarea style="width:427px; height:50px;" class="remind_remark" id="form-field-1" name="remind_remark" placeholder="请输入提醒备注"></textarea>
							</td>
						</tr>

						<tr>
							<td class="col-sm-2" align="right">&nbsp;</td>
							<td>
								<label>
								<input type="checkbox" name="check_set_view" value="1" class="ace" />
								<span class="lbl">要上门的</span>
								<input type="hidden" name="is_set_view" value="0" />
								</label>
								&nbsp;&nbsp;&nbsp;
								<label>
								<input type="checkbox" name="check_important" value="1" class="ace" />
								<span class="lbl">重点跟进的</span>
								<input type="hidden" name="is_important" value="0" />
								</label>
							</td>
						</tr>

						<tr>
							<td class="col-sm-2" align="right">提醒时间</td>
							<td>
								<div class="col-sm-6">
									<div class="input-group">
										<input class="form-control date-picker remind_date" data-event="add_msg" type="text" name="remind_date" data-date-format="yyyy-mm-dd" />
										<span class="input-group-addon">
											<i class="icon-calendar bigger-110"></i>
										</span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group bootstrap-timepicker">
										<input type="text" data-event="add_msg_time"  name="remind_time" class="form-control remind_time"/>
										<span class="input-group-addon">
											<i class="icon-time bigger-110"></i>
										</span>
									</div>
								</div>
							</td>
						</tr>
					</table>	
				</div>
	          	<div class="modal-footer">
	          		<input class="btn btn-info" type="submit" value="提交" />
		            <button data-dismiss="modal" class="btn" type="button">取消</button>
		        </div>
	        </form>
        </div>
  	</div>
</div>
<?php }else{?>
<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="_action_remind" style="display: none;">
  	<div class="modal-dialog" style="width:586px;padding-top:100px;">
        <div class="modal-content">
         	<div class="modal-header">
         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
            	<h4 class="modal-title">添加提醒<span style="float:right;padding-right:10px;" id="del_remind"></span></h4>
          	</div>
          	<form action="<?php echo site_url(module_folder(6).'/remind/actionSelfRemind');?>" method="post"  id="form_remind">			
          	<input	type="hidden" name="time_remind_id" id="time_remind_id" value="" />
				<div class="modal-body">
					<div id="consultant_info" style="padding:0px 20px 20px 24px; font-size:13px;"></div>
					<table cellpadding="5px" id="remind_info">
						<tr>
							<td class="col-sm-2" align="right">提醒内容</td>
							<td>
								<textarea style="height:100px;" class="form-control remind_content" name="remind_content" placeholder="请输入提醒内容" required oninvalid="setCustomValidity('请输入提醒内容');" oninput="setCustomValidity('');"></textarea>
							</td>
						</tr>

						<tr>
							<td class="col-sm-2" align="right">提醒备注</td>
							<td>
								<textarea style="width:427px; height:50px;" class="remind_remark" id="form-field-1" name="remind_remark" placeholder="请输入提醒备注"></textarea>
							</td>
						</tr>

						<!-- <tr>
							<td class="col-sm-2" align="right">&nbsp;</td>
							<td>
								<label>
								<input type="checkbox" name="check_important" value="1" class="ace" />
								<span class="lbl">重点跟进的</span>
								<input type="hidden" name="is_important" value="0" />
								</label>
							</td>
						</tr>
						 -->
						<tr>
							<td class="col-sm-2" align="right">提醒时间</td>
							<td>
								<div class="col-sm-6">
									<div class="input-group">
										<input class="form-control date-picker remind_date" data-event="add_msg" type="text" name="remind_date" data-date-format="yyyy-mm-dd" />
										<span class="input-group-addon">
											<i class="icon-calendar bigger-110"></i>
										</span>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group bootstrap-timepicker">
										<input type="text" data-event="add_msg_time"  name="remind_time" class="form-control remind_time"/>
										<span class="input-group-addon">
											<i class="icon-time bigger-110"></i>
										</span>
									</div>
								</div>
							</td>
						</tr>
					</table>	
				</div>
	          	<div class="modal-footer">
	          		<input class="btn btn-info" type="submit" value="提交" />
		            <button data-dismiss="modal" class="btn" type="button">取消</button>
		        </div>
	        </form>
        </div>
  	</div>
</div>
<?php }?>
<script type="text/javascript">
	window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>
<!--时间选择需要的插件-->
<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
<!-- 公共的wdcrm对象 -->
<script src="<?php echo base_url('assets/js/common.js');?>"></script>
<script type="text/javascript">
//查询数据(注：因头部消息提醒涉及全部模块=》通过角色区分不同的身份)
jQuery(function($) {
	
	var T;
	var TT;
	//信息提醒
	function mes() {
		$.ajax({
	        type: "POST",
	        url: "<?php echo site_url(module_folder(5).'/message/index');?>",
	        data: "type=",
	        dataType:'json',
	        success: function(res){
	        	
	        	if( res.remind_count_one > 0 || res.remind_count_two > 0 ){

		        		//弹窗
		        		$('#autoRemind').show();
		        		$('#accordion').html(res.remind_data);
		        		$('body').append('<div class="modal-backdrop fade in"></div>').addClass('modal-open');

		        		//响铃
		        		var audio_player=$('#audio_player')[0]; //获取音乐
							audio_player.volume=0.5;//设置声音大小
						
						//播放音乐
						if(audio_player.paused){
						
							audio_player.play();
						}
					
						//chrome 桌面提醒
						notify('亲,您有新的提醒!');
					

						//清除定时器T
						window.clearInterval(T);

	        	}

	        }
		});
	}

	//警钟提醒
	function audio () {
		$.ajax({
	        type: "POST",
	        url: "<?php echo site_url(module_folder(5).'/message/index');?>",
	        data: "type=",
	        dataType:'json',
	        success: function(res){	

        		$('#icon-bell').addClass('icon-animated-bell');

        		var count = res.remind_count_one + res.remind_count_two;
        		<?php if( in_array(getcookie_crm('employee_job_id'),$market_job) ){?>
        		var url = "<?php echo site_url(module_folder(6).'/remind/index');?>";
        		<?php }else{?>
        		var url = "<?php echo site_url(module_folder(2).'/remind/index');?>";	
        		<?php }?>	
        		var info = res.remind_info;
	        	var con;
	        	var list = '<a data-toggle="dropdown" class="dropdown-toggle" href="#">'
	        			 + '<i id="icon-bell" class="icon-bell-alt"></i>'
	        			 + '<span class="badge badge-important">'+count+'</span>'
	        			 + '</a>'
	        			 + '<ul class="look_remind pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close" style="overflow-y: scroll;height: 242px;"><li class="dropdown-header">'
					     + '<i class="icon-warning-sign"></i>'
					 	 + '<span id="remind_number">'+count+'</span>条提醒<span style="float:right;"><a class="btn btn-xs btn-pink" href="'+url+'" target="_blank">提醒列表</a>&nbsp;&nbsp;&nbsp;<button class="btn btn-xs btn-pink" role="button" data-target="#_action_remind" data-toggle="modal" id="_add_remind">添加</button></span>'
					 	 + '<li>';



				for(var key in info){

	        		con = info[key].time_remind_content;

	    			list += '<li class="lookinfo">'
	    				 + '<a href="#" role="button" class="remindinfo" uid="'+info[key].time_remind_id+'">'
	    				 + '<div class="clearfix">'
	    				 + '<span class="pull-left">'
	    				 + '<i class="btn btn-xs no-hover btn-pink icon-comment"></i>'
	    				 + con.substr(0,9)
	    				 + '</span>'
	    				 + '<span style="float:right" class="_del_remind" data="'+info[key].time_remind_id+'">'
	    				 + '<i class="icon-trash bigger-120"></i>'
	    				 + '</span>'
	    				 + '<span style="float:right" class="_edit_remind" data-target="#_action_remind" data-toggle="modal" data="'+info[key].time_remind_id+'">'
	    				 + '<i class="icon-edit bigger-120"></i>'
	    				 + '</span>'
	    				 + '<span style="clear:both;"></span>'
	    				 + '</div>'
	    				 + '</a>'
	    				 + '</li>';		    		
  		
	        	}	


	        		var site_url = "<?php echo site_url(module_folder(2).'/consultant_remind/index');?>";
	        		
	        		//list += '<li><a href="'+site_url+'">查看所有通知<i class="icon-arrow-right"></i></a></li></ul>';

	        		$('#purple').html(list);
					
					if( res.remind_count_one > 0 || res.remind_count_two > 0 ){
						//这个是让导航的警告钟 动
						$('.icon-bell-alt').addClass('icon-animated-bell').next().html(count);

						//点击警告钟，会停止音乐
						$('.ace-nav .purple').click(function(){
							
							audio_player.pause();
						
						});
					}


					//去除警告钟 的动样式。
					setTimeout(function(){
					
						$('.icon-bell-alt').removeClass('icon-animated-bell');
						
					},2000);
					
	        }
		});
	}

	/*wdcrm.mes=mes;
	wdcrm.audio=audio;*/

	//获取提醒信息  on() 对动态内容进行绑定的
	/*$('#purple').on('click','.lookinfo',function(){
		var time_remind_id=parseInt($(this).find('.remindinfo').attr("uid"));
		$.ajax({
	        type: "POST",
	        url: "<?php echo site_url(module_folder(5).'/message/info');?>",
	        data: "id="+time_remind_id,
	        dataType:'json',
	        success: function(res){
	       		$("#info").html(res.data); 
	        }
   		});
	});*/
	$('#purple').on('click','#_add_remind',function () {
		var form_remind = document.getElementById('form_remind');
		form_remind.reset(); //重置表单

		$("#del_remind").parent().html('<h4 class="modal-title">添加提醒<span style="float:right;padding-right:10px;" id="del_remind"></span></h4>'); 
		$('#remind_info tr:lt(2)').show();
		$("#time_remind_id").val("");
		$(".del_remind").html(""); 
		$("#consultant_info").html("");
		$(".remind_content").val("");
   		$(".remind_date").val("<?php echo date('Y-m-d');?>");
   		$(".remind_time").val("<?php echo date('H:i:s');?>");

	});
<?php if( !in_array(getcookie_crm('employee_job_id'),$market_job) ){?>
	$('#purple').on('click','._edit_remind',function () {

		//ajax获取提醒信息		
		var time_remind_id=parseInt($(this).attr("data"));
		$.ajax({
	        type: "POST",
	        url: "<?php echo site_url(module_folder(2).'/remind/remindConsultantInfo');?>",
	        data: "id="+time_remind_id+"&type=self",
	        dataType:'json',
	        success: function(res){
	        	if(res.status==0){return ;}
	        	$("#del_remind").parent().html(res.str);
	       		$(".remind_content").val(res.data['time_remind_content']);
	       		$(".remind_date").val(res.data['day']);
	       		$(".remind_time").val(res.data['time']); 
	       		$("#time_remind_id").val(res.data['time_remind_id']);
	       		$(".remind_remark").val(res.data['remind_remark']); 
	       		$("#consultant_id").val(res.data['consultant_id']); 

	       		if(res.data['is_set_view'] == 1){
	       			$('input[name="is_set_view"]').val(1);
	       			$('input[name="check_set_view"]').prop('checked',true);
	       		}

	       		if(res.data['is_important'] == 1){
	       			$('input[name="is_important"]').val(1);
	       			$('input[name="check_important"]').prop('checked',true);
	       		}

	       		$('#remind_info tr:lt(2)').hide();
	       		$('#consultant_info').html(res.consultantinfo).show();
	       		
	        }
   		});

	}).on('click','._del_remind',function () {
	
		var _del_id = parseInt($(this).attr("data"));
		var url = "<?php echo site_url(module_folder(2).'/remind/deleteConsultantRemind');?>"+'/'+_del_id;

		bootbox.confirm("你确定删除提醒吗?", function(result) {
			if(result) {
				window.location.href = url;
			}
		});
	});
<?php }else{ ?>
	$('#purple').on('click','._edit_remind',function () {

		//ajax获取提醒信息		
		var time_remind_id=parseInt($(this).attr("data"));
		$.ajax({
	        type: "POST",
	        url: "<?php echo site_url(module_folder(6).'/remind/remindInfo');?>",
	        data: "id="+time_remind_id,
	        dataType:'json',
	        success: function(res){
	        	if(res.status==0){return ;}
	        	$("#del_remind").parent().html(res.str);
	       		$(".remind_content").val(res.data['time_remind_content']);
	       		$(".remind_date").val(res.data['day']);
	       		$(".remind_time").val(res.data['time']); 
	       		$("#time_remind_id").val(res.data['time_remind_id']);
	       		$(".remind_remark").val(res.data['remind_remark']);
	       		
	        }
   		});

	}).on('click','._del_remind',function () {
	
		var _del_id = parseInt($(this).attr("data"));
		var url = "<?php echo site_url(module_folder(6).'/remind/deleteMarketRemind');?>"+'/'+_del_id;

		bootbox.confirm("你确定删除提醒吗?", function(result) {
			if(result) {
				window.location.href = url;
			}
		});
	});
<?php } ?>
	$('#close_remind').click(function () {
		//关闭警告钟
		audio_player.pause();

		//关闭弹窗
		$('#autoRemind').hide();
		wdcrm.removeInput($('.modal-backdrop')[0],0);
		$('#accordion').html();
		$('body').removeClass('modal-open');

		$.ajax({
	        type: "POST",
	        url: "<?php echo site_url(module_folder(5).'/message/configAction');?>",
	        data: "type=settime",
	        dataType:'json',
	        success: function(res){
	        	if(res.status == 1){

	        		T = setInterval(mes,60*5*1000);
	        		TT = setInterval(audio,3000);

	        	}
	        }
	    });

	});
	
	T = setInterval(mes,"<?php echo $data['remind_time'];?>");
	//TT = setInterval(audio,3000);
	audio();

});

</script>
<script>
	//添加提醒

jQuery(document).ready(function(){

		//时间选择插件
		 $('input[data-event="add_msg"]').datepicker();
		 $('input[data-event="add_msg"]').on('focus',function(){
	
		 	$('.dropdown-menu').css('z-index',1060);

		 });

	 	$('input[data-event="add_msg_time"]').timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});

		//操作“要上门的”和“重点跟进的”
		$('#form_remind').on('click','input[name="check_set_view"]',function() {
			if(this.checked){
				$(this).siblings('input[name="is_set_view"]').val(1);
			}else{
				$(this).siblings('input[name="is_set_view"]').val(0);
			}
		});

		$('#form_remind').on('click','input[name="check_important"]',function() {
			if(this.checked){
				$(this).siblings('input[name="is_important"]').val(1);
			}else{
				$(this).siblings('input[name="is_important"]').val(0);
			}
		});

});

</script>