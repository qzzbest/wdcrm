<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>班级编辑</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- basic styles -->

		<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

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
							<?php foreach(unserialize(getcookie_crm('url')) as $item){?>
								<li>
									<a href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
								</li>
							<?php }?>
							<li class="active">班级编辑</li>
						</ul><!-- .breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" name="edit" role="form" method="post" action="<?php echo site_url(module_folder(4).'/classroom/edit');?>">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"> 班级类型</label>
										<div class="col-sm-3">
											<select class="form-control" name="classroom_type" required>
												<option value="">请选择班级类型</option>
												<?php foreach($classroom_type as $item){?>
													<option <?php if($classroom['classroom_type_id']==$item['classroom_type_id']){echo 'selected';} ?> value="<?php echo $item['classroom_type_id'];?>"><?php echo $item['classroom_type_name'];?></option>
												<?php }?>
											</select>
										</div>
										<div class="col-sm-6"></div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 班级名称 </label>
										<div class="col-sm-3">
											<input type="text" id="form-field-2" required class="col-xs-10 col-sm-12" placeholder="请输入班级名称" name="classroom_name" value="<?php echo $classroom['classroom_name']; ?>"/>
										</div>
										<div class="col-sm-5" id="showname">

										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 班级群号 </label>
										<div class="col-sm-3">
											<input type="text" id="form-field-2" class="col-xs-10 col-sm-12" placeholder="请输入班级群号" name="classroom_group" value="<?php echo $classroom['classroom_group']; ?>"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"> 讲师</label>
										<div class="col-sm-3">
											<select class="form-control" name="employee_id" required>
												<option value="">请选择讲师</option>
												<?php foreach($teach as $item){?>
													<option <?php if($classroom['employee_id']==$item['employee_id']){echo 'selected';} ?> value="<?php echo $item['employee_id'];?>"><?php echo $item['employee_name'];?></option>
												<?php }?>
											</select>
										</div>
										<div class="col-sm-6"></div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 上课地点 </label>
										<div class="col-sm-3">
											<input type="text" id="form-field-2" required class="col-xs-10 col-sm-12" placeholder="请输入上课地点" name="class_address" value="<?php echo $classroom['class_address']; ?>"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" required for="form-field-2"> 上课时间 </label>
										<div class="col-sm-3">
											<input type="text" id="form-field-2" class="col-xs-10 col-sm-12" placeholder="请输入上课时间" required name="class_time" value="<?php echo $classroom['class_time'] ?>"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 开班日期 </label>
										<div class="col-sm-3">
											<div class="input-group">
												<input class="form-control date-picker" required id="id-date-picker-1" type="text" value="<?php echo date('Y-m-d',$classroom['open_classtime']); ?>" name="open_classtime" data-date-format="yyyy-mm-dd" />
												<span class="input-group-addon">
													<i class="icon-calendar bigger-110"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 结课日期 </label>
										<div class="col-sm-3">
											<div class="input-group">
												<input class="form-control date-picker" id="id-date-picker-1" type="text" value="<?php echo isset($classroom['close_classtime']) ? date('Y-m-d',$classroom['close_classtime']) : ''; ?>" name="close_classtime" data-date-format="yyyy-mm-dd" />
												<span class="input-group-addon">
													<i class="icon-calendar bigger-110"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<input type="hidden" name="classroom_id" value="<?php echo $classroom['classroom_id']; ?>" />

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<input type="hidden" name="location" value="" />
											<button class="btn btn-info" type="submit">
												<i class="icon-ok bigger-110"></i>
												提交
											</button>
										</div>
									</div>

								</form>
								<!-- PAGE CONTENT ENDS -->
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

		<script src="<?php echo base_url('assets/js/jquery-2.0.3.min.js');?>"></script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<![endif]-->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url('assets/js/jquery-2.0.3.min.js');?>'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
		<script type="text/javascript">
		 window.jQuery || document.write("<script src='<?php echo base_url('assets/js/jquery-1.10.2.min.js');?>'>"+"<"+"/script>");
		</script>
		<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo base_url('assets/js/jquery.mobile.custom.min.js');?>'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/typeahead-bs2.min.js');?>"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->

		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>
		<!-- inline scripts related to this page -->
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>

		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		
	 	<script type="text/javascript">
	 		jQuery(function($){
	 			//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();				
				});
				$('form[name="edit"]').submit(function(){

 					//判断是否重复名
 					var result=true;
		        	var name=$.trim($('input[name="classroom_name"]').val());
		        	var id=$('input[name="classroom_id"]').val();
						$.ajax({
							async: false,
						    type: "POST",
						    url: "<?php echo site_url(module_folder(4).'/classroom/check');?>",
						    data: 'id='+id+'&value='+name,
						    dataType:'json',
						   	success: function(res){
					        	if (res.status===1) {
					        		$('#showname').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">班级'+name+'已存在</div>');
					        		result=false;
					        	}else if(res.status==0){
					        		$('#showname').html('');
					        	}
					        }
	   					});
					return result;
 				});	
			});
	 	</script>

	</body>
</html>