<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>编辑评分标准</title>
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
					<div class="breadcrumbs">
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
						<span style="font-size:16px;margin-left:70px;font-weight:bold;">|编辑评分标准|</span>

					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form method="post" action="<?php echo site_url(module_folder(5).'/marking/edit_stand/'.$one_stand['id']);?>">

									<table>
										<tr>
											<td>类型：</td>
											<td>
											<select name="type">
												<option value='0'>评分总则</option>
												<option value='1'>加分细则</option>
												<option value='2'>减分细则</option>
											</select>
											</td>
										</tr>
										<script type="text/javascript">
											var ops=document.getElementsByName('type')[0].children;
											var num=<?php echo $one_stand['type']; ?>;
											ops[num].selected="selected";
						
										</script>

										<tr>
											<td>内容：</td>
											<td><textarea cols="60" rows="10" style="margin:5px 20px" name="content"><?php echo $one_stand['content']; ?></textarea><span class="cur_msg"></span></td>
										</tr>
										
										<tr>
											<td>备注：</td>
											<td><textarea cols="60" rows="6" style="margin:5px 20px" name="remark"><?php echo $one_stand['remark']; ?></textarea><span class="mark_msg"></span></td>
										</tr>
										
									<tr>
											<td>
											</td>
											<td>
											<button class="btn btn-info" type="submit">
												<i class="icon-ok bigger-110"></i>
												提交
											</button>
											<button class="btn btn-info" style="margin-left:30px" onclick="return quxiao()">
												<i class="icon-remove bigger-110"></i>
												取消
											</button>
											</td>
										</table>
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
 				//评分只能为数字
 				$('input[name="integral"]').blur(function () {
		        	
		        	var p = $.trim($(this).val());             
		            if (p=='' ) {
	                   	$('.cur_inte').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">评分不能为空</div>');
	                }else if(isNaN(p)){
						$('.cur_inte').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">评分只能为整数</div>');
					}else{
						 $('.cur_inte').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
					}
	                
		        });
 				

		        
				$('.form-horizontal').submit(function () {
					var p=$.trim($('input[name="integral"]').val()); 
					var v=$.trim($('textarea[name="message"]').val());   
		            if (p=='' ) {
		                $('.cur_inte').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">评分不能为空</div>');
						return false;
	                } else if(v=='') {
	                   	$('.cur_msg').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">评论理由不能为空</div>');
						return false;
	                }else{
						$('.cur_msg').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
						return true;
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
		  	var url = "<?php echo $fanhui_url[2];?>";
			window.location.href=url;
			return false;
		  }
		
		</script>
</body>
</html>
