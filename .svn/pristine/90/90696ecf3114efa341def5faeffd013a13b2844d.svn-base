<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>学员已报课程</title>
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
		<style type="text/css">
		.right{
			float: right;
		}
		</style>
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
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>

					</div>

					<div class="page-content">
						<div class="page-header">
							<h3 style="margin-top:0px;margin-bottom:0px;">
								学生姓名:<?php echo $info['student_name'];?>
								<a class="btn btn-xs btn-info" role="button" href="<?php echo site_url(module_folder(2).'/student_course/add/'.$info['student_id']);?>">添加新课程</a>
								<a href="<?php echo site_url(module_folder(2).'/student_payment/index/'.$info['student_id']);?>" class="btn btn-xs btn-success" role="button">缴费记录</a>
							</h3>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<form name="delete" action="<?php echo site_url(module_folder(2).'/student_course/delete');?>" method="post">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th class="center">序号</th>
														<th class="center">报读课程</th>
														<th class="center">知识点</th>
														<th class="center">课程备注</th>
														<th class="center">操作</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($list as $key=>$value) {?>	
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" name="id[]" value="<?php echo $value['repayment_id'];?>" />
																<span class="lbl"></span>
															</label>
														</td>
														<td class="center"><?php echo $key+1; ?></td>
														<td class="center">
															<?php if(!empty($value['course_name'])){
															foreach ($value['course_name'] as $v) {
																echo $v."&nbsp;&nbsp;";
																}
															}?>
														</td>
														<td class="center"><?php if(!empty($value['knowledge_name'])){
															foreach ($value['knowledge_name'] as $v) {
																echo $v."&nbsp;&nbsp;";
																}
															}
															?>
														</td>
														<td class="center">
															<?php if(!empty($value['course_remark'])){
															echo $value['course_remark'];
															} ?>
														</td>
														<td class="center">
															<a class="btn btn-xs btn-info" role="button" href="<?php echo site_url(module_folder(2).'/student_course/edit/'.$value['student_id'].'/'.$value['repayment_id']);?>">修改课程</a>
															<a class="btn btn-xs btn-warning course_info" role="button" data-toggle="modal" data-target="#course_info" data="<?php echo $value['repayment_id'];?>">详细信息</a>
														</td>
													</tr>
													<?php } ?>	  
												</tbody>
											</table>
											<a class="btn btn-xs btn-danger all_del" role="button">删除</a>
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
			<!--模态框（弹出 咨询者的详细信息信息）-->
			<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="course_info" style="display: none;">
			  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
			        <div class="modal-content">
			         	<div class="modal-header">
			            	<h4 id="youModalLabel" class="modal-title">课程与缴费情况</h4>
			          	</div>
			          	<div class="modal-body">    
			          	</div>
			          	<div style="padding-left:20px;" id="payment_info"></div>
			          	<div class="modal-footer">
				            <button data-dismiss="modal" class="btn btn-info" type="button">确定</button>
				        </div>
			        </div>
			  	</div>
			</div>
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
							
				$('table th input:checkbox').on('click', function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
				//ajax获取课程信息		
				$('.course_info').click(function(){
					var repayment_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student_course/info');?>",
				        data: "id="+repayment_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==0){ return ;}
				       		$("#course_info").find('.modal-body').html(res.data);
				       		$("#payment_info").html('<a href="'+res.info_url+'">查看缴费记录 >></a>'); 
				        }
			   		});
				});

				//多条删除功能
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
		</script>
</body>
</html>