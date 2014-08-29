<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>编辑课程</title>
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

							<li>
								<a href="<?php echo site_url(module_folder(1).'/curriculum_system/index');?>">课程管理</a>
							</li>
							<li class="active">编辑课程</li>
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" name="edit" role="form" method="post" action="<?php echo site_url(module_folder(1).'/curriculum_system/edit');?>">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 课程 </label>

										<div class="col-sm-3">
											<input type="text" value="<?php echo $info['curriculum_system_name'];?>" id="form-field-2" class="col-xs-10 col-sm-12" placeholder="请输入课程名称" name="curriculum_system_name">
										</div>
										<div class="col-sm-3 cname">
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 知识点 </label>
										
										<div class="col-sm-5">
										<?php foreach ($list as $key=>$value) { ?>
											<label><input type="checkbox" class="ace" name="knowledge_ids[]" value="<?php echo $key;?>" <?php foreach ($info['knowledge_id'] as $val) { if($key==$val){echo 'checked'; }}?> /><span class="lbl"> <?php echo $value;?></span></label>&nbsp;&nbsp;&nbsp;
										<?php }?>
										</div>
									</div>
									<div class="space-4"></div>
									<input type="hidden" name="id" value="<?php echo $info['curriculum_system_id'];?>">

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
	
		<!--时间选择需要的插件-->	
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>
		
		<!-- inline scripts related to this page -->
		<script>
 			jQuery(function($) {
 				$('form[name="edit"]').submit(function(){

 					//判断是否重复名
 					var result=true;
		        	var name=$.trim($('input[name="curriculum_system_name"]').val());
		        	var id=$('input[name="id"]').val();
		        	
						$.ajax({
							async: false,
						    type: "POST",
						    url: "<?php echo site_url(module_folder(1).'/curriculum_system/check');?>",
						    data: 'id='+id+'&value='+name,
						    dataType:'json',
						   	success: function(res){
					        	if (res.status===1) {
					        		$('.cname').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">'+name+'已存在</div>');
					        		result=false;
					        	}else if(res.status==0){
					        		$('.cname').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
					        	}
					        }
	   					});
						
					return result;

 				});
		    });
		</script>
</body>
</html>
