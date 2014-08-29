<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>登录</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.10.2.min.js');?>"></script>
		<!-- basic styles -->

		<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
		<!-- fonts -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/google.css');?>" />

		<!-- page specific plugin styles -->

		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace.min.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace.min.css');?>" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-leaf green"></i>
									<!-- <span class="red">欢迎光临</span> -->
									<span class="white">文豆CRM管理系统</span>
								</h1>
								<h4 class="blue">&copy; 广州文豆网络科技有限公司</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												登 录
											</h4>

											<div class="space-6"></div>

											<form name="login" action="<?php echo site_url('login/index');?>" method="post">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="请输入用户名" name="username" oninvalid="setCustomValidity('请输入用户名');" oninput="setCustomValidity('');"required value="<?php echo getcookie_crm('name');?>" />
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="请输入密码" name="password" required oninvalid="setCustomValidity('请输入密码');" oninput="setCustomValidity('');" value="<?php echo getcookie_crm('pwd');?>" />
															<i class="icon-lock"></i>
														</span>
													</label>
													<input type="text" name="seccode" id='img_code' style="width:80px;" placeholder="验证码" required oninvalid="setCustomValidity('请输入验证码');" oninput="setCustomValidity('');"/>
		                    						<span class="register_pic"><img id='seccode' alt="换一张" src="<?php echo site_url('login/captcha')?>" style="cursor: pointer;" onclick="changeAuthCode();" /></span>
		                     						<a href="javascript:" onclick="changeAuthCode();">换一张</a>
													<script type="text/javascript">
														function changeAuthCode(){
															$('#seccode').attr('src','<?php echo site_url("login/captcha")?>'+'/'+Math.random());	
														}
													</script>

													<div class="space"></div>
													<div class="clearfix">
														<!-- <label class="inline">
															<?php if(getcookie_crm('remember') == 1){?>
																<input type="checkbox" class="ace" name="remember" value="1" checked>
															<?php }else if(getcookie_crm('remember') == ""){?>
																<input type="checkbox" class="ace" name="remember" value="1">
															<?php }?>
															<span class="lbl"> 记住用户名与密码 </span>
														</label> -->


														<button type="submit" class="width-35 pull-left btn btn-sm btn-primary">
															<i class="icon-key"></i>
															登录
														</button>&nbsp;&nbsp;&nbsp;&nbsp;
														<button type="button" name="add_chrome" class="btn btn-sm">添加桌面通知</button>
													</div>
													<div class="space-4"></div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->

										<!-- <div class="toolbar clearfix">
											<div>
												<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													忘记密码
												</a>
											</div>

											<div>
												<a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
													注册
													<i class="icon-arrow-right"></i>
												</a>
											</div>
										</div> -->
									</div><!-- /widget-body -->
								</div><!-- /login-box -->
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
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
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}

			jQuery(function($){

				$('button[name="add_chrome"]').click(function(){
					
					notify('亲,您添加成功!');
				});

			});

		</script>
</body>
</html>
