<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>员工评分</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="<?php echo base_url('assets/css/bootstrap.min.css" rel="stylesheet');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- fonts -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/google.css');?>" />

		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace.min.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace-rtl.min.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace-skins.min.css');?>" />
		
		<!--时间选择（时-分-秒）-->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/datepicker.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-timepicker.css');?>" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="<?php echo base_url('assets/js/ace-extra.min.js');?>"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<!--头部信息-->
		<?php $this->load->view('header');?>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<!--菜单列表-->
				<?php echo $this->load->view('menu');?>

				<div class="main-content">
					<div class="breadcrumbs">
						<script type="text/javascript" id="breadcrumbs">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo site_url(module_folder(1).'/index/index');?>">主页</a>
							</li>
							<?php foreach(unserialize(getcookie_crm('url')) as $item){?>
							<li>
								<a href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
							</li>
						<?php }?>
						</ul>

						<button type="button" onclick="change()" class="btn btn-xs btn-primary" style="margin:0px 50px;">评分标准</button>
						<span style="font-size:16px;margin-left:70px;font-weight:bold;">|员工评分|</span>

					</div>
					<div id="biaozhun" style="width:1000px;height:auto;background-color:#f2f2f2;position:absolute;top:50px;left:200px;border:2px solid #6fb3e0; display:none;z-index:99;margin-bottom:100px;">
					<h3 style="text-align:center;">员工评分标准</h3>
					<!-- table开始 -->
					<table class="table table-striped table-bordered ">
					<tr>
					<th colspan='2'>
					评分总则
					</th>
					</tr>
					<?php if(isset($stand_list[0])){
							foreach($stand_list[0] as $item){	?>
					<tr>
					<td colspan='2' height="30px"><?php	echo $item['content']; ?></td>
					</tr>
					<?php } }  ?>

					<tr>
					<th colspan='2'>
					加分细则
					</th>
					</tr>
					<tr>
					<td>项目</td><td>备注</td>			
					</tr>
					<?php if(isset($stand_list[1])){
							foreach($stand_list[1] as $item){	?>
					<tr>
					<td><?php echo $item['content']; ?></td><td><?php echo $item['remark']; ?></td>		
					</tr>
					<?php } }  ?>

					<tr>
					<th colspan='2'>
					减分细则
					</th>
					</tr>
					<tr>
					<td width="60%">项目</td><td>备注</td>			
					</tr>

					<?php if(isset($stand_list[2])){
							foreach($stand_list[2] as $item){	?>
					<tr>
					<td><?php echo $item['content']; ?></td><td><?php echo $item['remark']; ?></td>		
					</tr>
					<?php } }  ?>
					</table>
					<!-- table结束 -->
					<?php $power=getcookie_crm('mark_power');
						if($power==2){
					?>
					<button type="button" class="btn btn-xs btn-primary" onclick="edit()">编辑评分标准</button>
					<?php } ?>
					<button type="button" class="btn btn-xs btn-primary" style="float:right;" onclick="closen()">关闭</button>
					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(5).'/marking/edit');?>">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户名 </label>

										<div class="col-sm-9">
											<input type="text" value="<?php echo $info['admin_name'];?>" id="form-input-readonly" class="col-xs-10 col-sm-4" readonly="">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 真实姓名 </label>


										<div class="col-sm-9">
											<input type="text" value="<?php echo $info['employee_name'];?>" id="form-input-readonly" class="col-xs-10 col-sm-4" readonly="">
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 本次评分 </label>

										<div class="col-sm-9">
											<input type="text" value="" name="integral" class="col-xs-10 col-sm-4">
											<span class="cur_inte">
												<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">（评分不能超过小数点后一位）</div>
											</span>
										</div>
										
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 评分时间 </label>

										<div class="col-sm-2">
											<div class="input-group">
												<input class="form-control date-picker" id="id-date-picker-1" type="text" name="integral_date" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d');?>" />
												<span class="input-group-addon">
													<i class="icon-calendar bigger-110"></i>
												</span>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="input-group bootstrap-timepicker">
												<input id="timepicker1" type="text" name="integral_time" class="form-control" />
												<span class="input-group-addon">
													<i class="icon-time bigger-110"></i>
												</span>
											</div>
										</div>
										
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1" > 评分理由 </label>

										<div class="col-sm-9">
											<textarea cols="50" rows="10" name="message"></textarea><span class="cur_msg"></span>
										</div>
									</div>

									<input type="hidden" value="<?php echo $info['employee_id'];?>" name="mark_id" />

									<input type="hidden" value="<?php echo getcookie_crm('employee_id');?>" name="employee_id" />

									<div class="clearfix">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" name="dosubmit">
												<i class="icon-ok bigger-110"></i>
												提交
											</button>
											<button class="btn btn-info" style="margin-left:30px" onclick="return quxiao()">
												<i class="icon-remove bigger-110"></i>
												取消
											</button>
										</div>
									</div>
								</form>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->

				<?php echo $this->load->view('site');?>
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo base_url();?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/typeahead-bs2.min.js');?>"></script>

		<!-- ace scripts -->

		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>

		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>

		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
	 			//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					
					$(this).prev().focus();
				
				});

				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				//$('#timepicker1').val('');
			});	

 			jQuery(function($) {
 				//评分只能为数字
 				$('input[name="integral"]').blur(function () {
		        	
		        	var p = $.trim($(this).val());    
       				var preg=/^(-+)?\d+(\.\d)?$/;//判断小数点后只能有1位数


		            if (p=='' ) {
	                   	$('.cur_inte').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">评分不能为空</div>');
	                }else if(!preg.test(p)){
						$('.cur_inte').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请正确填写评分</div>');
					}else{
						 $('.cur_inte').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
					}
	                
		        });
 				

		        
				$('.form-horizontal').submit(function () {

					var p=$.trim($('input[name="integral"]').val()); 
					var v=$.trim($('textarea[name="message"]').val());   

					var preg=/^(-+)?\d+(\.\d)?$/;//判断小数点后只能有1位数

		            if (p=='' ) {
	                   	$('.cur_inte').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">评分不能为空</div>');
	                   	return false;
	                }else if(!preg.test(p)){
						$('.cur_inte').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请正确填写评分</div>');
						return false;
					}else{
						 $('.cur_inte').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
						 if(v=='') {
		                   	$('.cur_msg').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">评论理由不能为空</div>');
							return false;
		                }else{
							$('.cur_msg').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
							return true;
						}
					}

		            
				});
		    });

			
		</script>
		<?php 
			$url = unserialize(getcookie_crm('url'));
			$fanhui_url = $url[1];
		?>
		<script>
		function quxiao(){
			var url = "<?php echo $fanhui_url[1];?>";
			window.location.href=url;
			return false;
		}

		function change(){
			$("#biaozhun").show();
		}

		function closen(){
			$("#biaozhun").hide();
		}

		function edit(){
			window.location.href="<?php echo site_url(module_folder(5).'/marking/standard'); ?>";
		}
		
		</script>
</body>
</html>
