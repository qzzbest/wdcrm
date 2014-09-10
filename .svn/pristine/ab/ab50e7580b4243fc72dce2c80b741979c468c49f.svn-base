<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>通讯录列表</title>
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
								<a href="<?php echo site_url(module_folder(1).'/admin/index');?>">通讯录管理</a>
							</li>
							<li class="active">通讯录列表</li>
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						<div class="page-header">
							<small>
							<?php if(getcookie_crm('employee_power')==1){?>
							<!-- <div style="float:right;margin-right:30px;">		
								<span>职位:</span>
								<select name="teach" id="changejob" style="width:91px;">
									<option value=" ">全部</option>
									<?php 
									foreach($employee_job as $item){ ?>
									<option  <?php 
										if ($item['employee_job_id']==$selected_job) {
											echo 'selected';
										}
							
									?>  value="<?php echo $item['employee_job_id'];?>"><?php echo $item['employee_job_name'];?></option>
									<?php } ?>
								</select>
							</div> -->
							<?php }?>
							</small>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">序号</th>
														<th class="center">姓名</th>
														<th class="center">性别</th>
														<th class="center">部门</th>
														<th class="center">职位</th>
														<th class="center">电话</th>
														<th class="center">手机</th>
														<th class="center">QQ</th>
														<th class="center">微信</th>
														<th class="center">邮箱</th>
													<?php if(getcookie_crm('employee_power')==1){?>
														<th>操作</th>
													<?php } ?>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($employee_info['list'] as $value) {?>				
													<tr>
														<td class="center">
															<?php echo $value['serial_number'];?>
														</td>
														<td class="center">
															<?php echo $value['employee_name'];?>
														</td>
														<td class="center">
															<?php
															 if ($value['employee_sex']==1) {
															 	echo '男';
															 }else if($value['employee_sex']==2){
															 	echo '女';
															 }else{
															 	echo '';
															 }
															?>
														</td>
														<td class="center">
															<?php echo isset($value['department']['department_name']) ? $value['department']['department_name'] : '';?>
														</td>
														<td class="center">
															<?php echo isset($value['employee']['employee_job_name']) ? $value['employee']['employee_job_name'] : '';?>
														</td>
														<td class="center">
															<?php echo $value['employee_telephone'];?>
														</td>
														<td class="center">
															<?php
																if( !empty($value['phone']) ){
																	foreach ($value['phone'] as $val) {
																		echo $val['employee_phone_number'].'&nbsp;';
																		if($val['is_workphone']==1){
																			echo '(工作)<br />';
																		}else{
																			echo '(私人)<br />';
																		}
																	}
																}
															?>
														</td>
														<td class="center">
															<?php
																if( !empty($value['qq']) ){
																	foreach ($value['qq'] as $val) {
																		echo $val['employee_qq'].'&nbsp;';
																		if($val['is_workqq']==1){
																			echo '(工作)<br />';
																		}else{
																			echo '(私人)<br />';
																		}
																	}
																}
															?>
														</td>
														<td class="center">
															<?php
																if( !empty($value['weixin']) ){
																	foreach ($value['weixin'] as $val) {
																		echo $val['employee_weixin_number'].'<br />';
																	}
																}
															?>
														</td>
														<td class="center">
															<?php
																if( !empty($value['email']) ){
																	foreach ($value['email'] as $val) {
																		echo $val['employee_email_number'].'&nbsp;';
																		if($val['is_workemail']==1){
																			echo '(工作)<br />';
																		}else{
																			echo '(私人)<br />';
																		}
																	}
																}
															?>
														</td>
													<?php if(getcookie_crm('employee_power')==1){?>
														<td>
															<button type="button" class="btn btn-xs btn-warning employee_info" data-toggle="modal" data-target="#employee_info" data="<?php echo $value['employee_id'];?>">详细信息</button>
														</td>
													<?php }?>	
													</tr>
												<?php }?>	
												</tbody>
											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $employee_info['create_page'];?>
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
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="employee_info" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		            	<h4 id="youModalLabel" class="modal-title">用户信息</h4>
		          	</div>
		          	<div class="modal-body" id="person_info">    
		          	</div>
		          	<div class="modal-footer">
			            <button data-dismiss="modal" class="btn btn-info" type="button">确定</button>
			        </div>
		        </div>
		  	</div>
		</div>
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
			jQuery(function($){
				//获取用户信息		
				$('.employee_info').click(function(){
					var userid=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(1).'/admin/info');?>",
				        data: "id="+userid,
				        dataType:'json',
				        success: function(res){
				       		$("#person_info").html(res.data); 
				        }
			   		});
				});
			});
		</script>
</body>
</html>
