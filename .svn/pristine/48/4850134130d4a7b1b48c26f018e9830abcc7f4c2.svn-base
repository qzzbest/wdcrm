<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>班级类型列表</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
								<a href="<?php echo site_url(module_folder(4).'/classroom_type/index');?>">班级类型管理</a>
							</li>
							<li class="active">班级类型列表</li>
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>
					</div>

					<div class="page-content">
						<?php 
							$login_job = getcookie_crm('employee_job_id');
							$teaching_job = array(4,5,11);
							if(in_array($login_job, $teaching_job)){
						?>
						<div class="page-header">
							<small>
							<a role="button" class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(4).'/classroom_type/add');?>">添加班级类型</a>
							</small>
						</div>
						<?php }?>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
										<form  name="delete" action="<?php echo site_url(module_folder(4).'/classroom_type/delete');?>" method="post">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<!-- <th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th> -->
														<th>班级类型</th>
														<th>包括知识点</th>
														<?php if(in_array($login_job, $teaching_job)){?>
														<th>操作</th>
														<?php }?>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($list as $item) {?>				
													<tr>
														<!-- <td class="center">
															<label>
																<input type="checkbox" class="ace" name="id[]" value="<?php echo $item['classroom_type_id'];?>" />
																<span class="lbl"></span>
															</label>
														</td> -->
														<td>
															<?php echo $item['classroom_type_name'];?>
														</td>
														<td><?php foreach ($item['course_name'] as $value) {echo $value['knowledge_name'].'&nbsp;&nbsp;';}?></td>
														<?php if(in_array($login_job, $teaching_job)){?>
														<td>									
															<a class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(4).'/classroom_type/edit/'.$item['classroom_type_id']);?>" role="button">编辑</a>
															<a class="btn btn-xs btn-pink" role="button" data-target="#change_status" data="<?php echo $item['classroom_type_id'];?>">
															<?php if($item['type_status']==0){ ?>
																未启用
															<?php }else{ ?>
																已启用
															<?php }?>
															</a>	
														</td>
														<?php }?>
													</tr>	
												<?php }?>	
												</tbody>
											</table>
											<!-- <a class="btn btn-xs btn-danger all_del" role="button">删除</a> -->
										</form>	
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $page;?>
										</div>
									</div>
								</div><!-- /row -->
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

		<!-- page specific plugin scripts -->
	
		<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.dataTables.bootstrap.js');?>"></script>

		<!-- ace scripts -->
		<script src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>
		
		<!--时间选择需要的插件-->
		
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>
	

		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				$(".all_del").on(ace.click_event, function() {
					
					//检测有多少个被选中了，0个删除不弹出确定框。
					var length= $('input[name="id[]"]:checked').length;
					if(length>0){
						bootbox.confirm("你确定删除吗?", function(result) {
							if(result) {
								document.forms['delete'].submit();
							}
						});
					}
				});
			});
			jQuery(function($) {
				
				//设置启用、未启用
				$('a[data-target="#change_status"]').on(ace.click_event, function() {

					var msg,status;
					if ($.trim(this.innerHTML)=='已启用'){
						msg='您确定取消启用吗?';
						status=0;
					}else{
						msg='您确定启用吗?';
						status=1;
					}
					
					var _this=this;
					var id=parseInt($(this).attr("data"));
						bootbox.confirm(msg, function(result) {
							if(result) {
								$.ajax({
							        type: "POST",
							        url: "<?php echo site_url(module_folder(4).'/classroom_type/changeStatus');?>",
							        data: "id="+id+'&status='+status,
							        dataType:'json',
							        success: function(res){

							       		if (res.result==1&&status==1) {
							       			_this.innerHTML='已启用';
							       		}
							       		if (res.result==1&&status==0) {
							       			_this.innerHTML='未启用';
							       		}
							        }
						   		});
							}
						});
					
				});
		
			});			
		</script>
</body>
</html>
