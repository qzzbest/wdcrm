<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>编辑咨询记录</title>
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
		<link rel="stylesheet" href="<?php echo base_url('assets/css/daterangepicker.css');?>" />
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
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo site_url(module_folder(1).'/index/index');?>">主页</a>
							</li>
							<?php $this->load->view('url');?>
							<li class="active">编辑咨询记录</li>
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>

					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(2).'/student_record/edit');?>">
									<div class="form-group">
									<input type="hidden" name="employee_id" value="<?php echo $name['employee_id'];?>" />
										<label class="col-sm-4 control-label">
											学生姓名: <?php echo $name['student_name'];?>
										</label>
									</div>

									<?php if($record_info){?>
									<input type="hidden" name="record_id" value="<?php echo $record_info['record_id'];?>">
									<?php }else{?>
									<input type="hidden" name="record_id" value="">
									<?php }?>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2">日期</label>

										<div class="col-sm-4">
											<div class="input-group">
												<input class="form-control date-picker" id="id-date-picker-1" type="text" name="day" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d',$list['consultant_record_time']); ?>"/>
												<span class="input-group-addon">
													<i class="icon-calendar bigger-110"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">咨询效果</label>

										<div class="col-sm-4">
											<textarea id="form-field-1" style="height:314px;width:501px;" class="form-control" name="description" placeholder="请输入咨询效果" required oninvalid="setCustomValidity('请输入咨询效果');" oninput="setCustomValidity('');"><?php echo $list['consultant_record_desc']; ?></textarea>
										</div>
									</div>
									<div class="space-4"></div>
						
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> </label>

										<div class="col-sm-9">
											
										<?php 
											if($viewtime['consultant_set_view']==1){ 
												if(date("Y-m-d",$list['consultant_record_time'])>date("Y-m-d",$viewtime['consultant_set_view_time'])){
										?>
											<span style="font-size:14px;">已上门</span>
											<?php }else if(date("Y-m-d",$viewtime['consultant_set_view_time'])==date("Y-m-d",$list['consultant_record_time'])){?>
												<label><input class="ace" checked type="radio" name="visit" value="1">
												<span class="lbl" style="z-index:9;">已上门</span></label>
												<label><input class="ace" type="radio" name="visit" value="2">
												<span class="lbl" style="z-index:9;">未上门</span></label>
											<?php }else{ ?>
												<span style="font-size:14px;">未上门</span>
										<?php 
												}
											}else if($viewtime['consultant_set_view']==0){ ?>
												<label><input class="ace" type="radio" name="visit" value="1">
												<span class="lbl" style="z-index:9;">已上门</span></label>
												<label><input class="ace" checked type="radio" name="visit" value="2">
												<span class="lbl" style="z-index:9;">未上门</span></label>
										<?php }?>

										<?php 
											if($viewtime['is_student']==1){
												if(isset($signup['sign_up_date']) && date("Y-m-d",$list['consultant_record_time'])>=date("Y-m-d",$signup['sign_up_date'])){
										?>
												<span style="font-size:14px;">&nbsp;&nbsp;&nbsp;已报名</span>
										<?php 	}
											}
										?>
										</div>
									</div> 
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	提醒备注 </label>

										<div class="col-sm-9">
											<textarea style="width:505px; height:77px;" id="form-field-1" name="remind_remark" placeholder="请输入提醒备注"><?php echo $rem['remind_remark']; ?></textarea>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	提醒类型</label>
										<div class="col-sm-9">
											<label>
											<?php if($rem['is_set_view']==1){?>
											<input type="checkbox" name="check_set_view" checked value="1" class="ace" />
											<span class="lbl">要上门的</span>
											<input type="hidden" name="is_set_view" value="1" />
											<?php }else{?>
											<input type="checkbox" name="check_set_view" value="0" class="ace" />
											<span class="lbl">要上门的</span>
											<input type="hidden" name="is_set_view" value="0" />
											<?php }?>
											</label>
											&nbsp;&nbsp;&nbsp;
											<label>
											<?php if($rem['is_important']==1){?>
											<input type="checkbox" name="check_important" checked value="1" class="ace" />
											<span class="lbl">重点跟进的</span>
											<input type="hidden" name="is_important" value="1" />
											<?php }else{?>
											<input type="checkbox" name="check_important" value="0" class="ace" />
											<span class="lbl">重点跟进的</span>
											<input type="hidden" name="is_important" value="0" />
											<?php }?>
											</label>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2" > 提醒时间 </label>

										<div class="col-sm-2">
											<div class="input-group">
												<input class="form-control date-picker" id="id-date-picker-1" type="text" name="remind_date" data-date-format="yyyy-mm-dd" value="<?php echo isset($rem['time_remind_time']) && $rem['time_remind_time']!=0 ? date('Y-m-d',$rem['time_remind_time']) : '';?>" />
												<span class="input-group-addon">
													<i class="icon-calendar bigger-110"></i>
												</span>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="input-group bootstrap-timepicker">
												<input id="timepicker1" type="text" name="remind_time" class="form-control" value="<?php echo isset($rem['time_remind_time']) && $rem['time_remind_time']!=0 ? date('H:i:s',$rem['time_remind_time']) : '';?>" />
												<span class="input-group-addon">
													<i class="icon-time bigger-110"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div> 

									<input type="hidden" name="id" value="<?php echo $list['consultant_record_id'];?>">
									<input type="hidden" name="uid" value="<?php echo $uid?>">

									<div class="clearfix">
										<div class="col-md-offset-3 col-md-9">
											<input type="hidden" name="location" value="<?php echo $location;?>">
											<button class="btn btn-info" type="submit">
												<i class="icon-ok bigger-110"></i>
												提交
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="icon-undo bigger-110"></i>
												重置
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

				//操作“要上门的”和“重点跟进的”
				$('.form-horizontal').on('click','input[name="check_set_view"]',function() {
					if(this.checked){
						$(this).siblings('input[name="is_set_view"]').val(1);
					}else{
						$(this).siblings('input[name="is_set_view"]').val(0);
					}
				});

				$('.form-horizontal').on('click','input[name="check_important"]',function() {
					if(this.checked){
						$(this).siblings('input[name="is_important"]').val(1);
					}else{
						$(this).siblings('input[name="is_important"]').val(0);
					}
				});
			});	
		</script>
</body>
</html>
