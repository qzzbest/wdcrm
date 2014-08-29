<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>编辑员工</title>
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

							<li>
								<a href="<?php echo site_url(module_folder(1).'/admin/index');?>">员工管理</a>
							</li>
							<li class="active">编辑员工</li>
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(1).'/admin/edit');?>">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户名 </label>

										<div class="col-sm-9">
											<input type="text" value="<?php echo $info['admin_name'];?>" id="form-input-readonly" class="col-xs-10 col-sm-4" readonly="">
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 密码 </label>
									
										<div class="col-sm-9" style="width:312px;">
											<input type="password" id="form-field-2" placeholder="请输入密码" class="col-xs-10 col-sm-4" name="password" style="width:280px;"/>
										</div>
										<div class="col-sm-3 cur_pwd" style="width:280px;">
											<div style="color: rgb(114, 114, 114);" class="help-block col-xs-12 col-sm-reset inline">不修改密码请留空</div>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 确认密码 </label>

										<div class="col-sm-9" style="width:312px;">
											<input  type="password" id="form-field-2" placeholder="请输入确认密码" class="col-xs-10 col-sm-4" name="pwdnew" style="width:280px;"/>
										</div>
										<div class="col-sm-3 con_pwd" style="width:280px;">
											<div style="color: rgb(114, 114, 114);" class="help-block col-xs-12 col-sm-reset inline">不修改密码请留空</div>
										</div>
									</div>

									<div class="space-4"></div>


									<!-- <div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 确认密码 </label>
									
										<div class="col-sm-9" style="width:312px;">
											<input type="password" id="form-field-2" placeholder="请输入确认新密码" class="col-xs-10 col-sm-4" name="pwdconfirm" style="width:280px;"/>
										</div>
										<div class="col-sm-3 con_pwd" style="width:280px;">
									
										</div>
									</div>
									
									<div class="space-4"></div> -->
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 真实姓名 </label>

										<div class="col-sm-9">
											<input type="text" id="form-field-2" placeholder="请输入姓名" class="col-xs-10 col-sm-4" value="<?php echo $info['employee_name'];?>" name="pname" />
										</div>
									</div>

									<div class="space-4"></div>
									<input type="hidden" name="id" value="<?php echo $info['employee_id'];?>">

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 所属角色 </label>
										<?php if(!empty($role)){?>
										<div class="col-sm-9">
											<select id="form-field-select-1" class="col-sm-2" name="role">
											<?php foreach ($role as $key => $value) {?>
												<option value="<?php echo $value['employee_job_id'];?>" <?php if($info['employee_job_id']==$value['employee_job_id']){?> selected="selected"<?php }?>><?php echo $value['employee_job_name'];?></option>
											<?php }?>
											</select>
										</div>
										<?php }else if($info['employee_job_id']==8){?>
										<div class="col-sm-9">
											<div style="font-size:16px;line-height:30px;">管理员</div>
										</div>
										<?php }else{?>
										<div class="col-sm-9">
											<div style="font-size:16px;line-height:30px;">超级管理员</div>
										</div>
										<?php }?>
									</div>
									
									<?php 
									$login_job = getcookie_crm('employee_job_id');
									$employee_arr = array(11);
									if(in_array($login_job, $employee_arr)){?>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 评分权限 </label>
										<div class="col-sm-9">
											<input type="radio" <?php if($info['mark_power']==1){echo 'checked=checked';}?> name="mark_power" value="1" />评分权
											&nbsp;&nbsp;
											<input type="radio" <?php if($info['mark_power']==2){echo 'checked=checked';}?> name="mark_power" value="2" />审核和添加标准等所有权
										</div>
									</div>
									<?php }?>

									<div class="clearfix">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" name="dosubmit">
												<i class="icon-ok bigger-110"></i>
												提交
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

		<!-- inline scripts related to this page -->
		<script>
 			jQuery(function($) {
 				//密码焦点
 				$('input[name="password"]').blur(function () {
		        	var v=$.trim($('input[name="pwdnew"]').val());
		        	var p = $.trim($(this).val());             
		            if (p!='' ) {
		                $('.cur_pwd').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
	                } else {
	                   	$('.cur_pwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请输入密码</div>');
	                }
	                //密码与确认密码是否一致
	                if(p!=v){
	                   	 $('.con_pwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">密码和确认密码不一致</div>');
	                } else if(p!='' && v!='' && p==v){
	                   	$('.con_pwd').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
	                }
		        });
 				//确认密码焦点
		        $('input[name="pwdnew"]').blur(function () {
		        	var p=$.trim($('input[name="password"]').val());
		        	var v = $.trim($(this).val());
		        	//确认密码不为空，密码为空                 
		            if (v!='' && p=='' ) {
		                $('.cur_pwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请输入密码</div>');
	                }
	                //密码与确认密码是否一致
	                if (v=='' && p!='') {
		                $('.con_pwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请输入确认密码</div>');
	                } else if (p!=v) {
		                $('.con_pwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">密码和确认密码不一致</div>');
	                } else if (p==v && p!=''){
	                   	$('.con_pwd').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
	                }
		        });

		        /*$('input[name="pwdconfirm"]').blur(function () {
		        	var v=$.trim($('input[name="pwdnew"]').val());
		        	var c = $.trim($(this).val());          
		            if (v!=c ) {
		                $('.con_pwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">密码和确认密码不一致</div>');
	                } else {
	                   	$('.con_pwd').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
	                }
		        });*/
				$('.form-horizontal').submit(function () {
					var p=$.trim($('input[name="password"]').val());
					var v=$.trim($('input[name="pwdnew"]').val());
					 if (v!='' && p=='' ) {
		                $('.cur_pwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline"><b>请输入密码</b></div>');
		                return false;
	                }
	                if (p!=v) {
		                $('.con_pwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline"><b>密码和确认密码不一致</b></div>');
		                return false;
	                }
				});
		    });
		</script>
</body>
</html>
