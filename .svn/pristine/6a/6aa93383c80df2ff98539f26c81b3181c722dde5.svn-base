<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>咨询记录</title>
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
							<?php $this->load->view('url');?>
							
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>

					</div>

					<div class="page-content">
						<div class="page-header">
							<h3 style="margin-top:0px;margin-bottom:0px;">
								学生姓名:<?php echo $list[0]['student_name'].'&nbsp;&nbsp;&nbsp;';?>
								<small>
								<?php
								echo '手机号码：';
								if(isset($info['phone_infos']) && !empty($info['phone_infos'])){
									foreach ($info['phone_infos'] as $key => $value) {
										echo $value['phone_number'] .'&nbsp;';
									}
								}
								
								echo '&nbsp;&nbsp;&nbsp;QQ号码：';
								if(isset($info['qq_infos']) && !empty($info['qq_infos'])){
									foreach ($info['qq_infos'] as $key => $value) {
										echo $value['qq_number'] .'&nbsp;';
									}
								}	
								?>
								<a data-target="#student_info" data-toggle="modal" class="btn btn-xs btn-info student_info" type="button" data="<?php echo $list[0]['student_id'];?>" data-toggle="modal">详细信息</a>

								&nbsp;&nbsp;&nbsp;
								<a class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(2).'/student_record/add/'.$list[0]['consultant_id']);?>">添加咨询记录</a>
							</small>
							</h3>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<form action="<?php echo site_url(module_folder(2).'/student_record/delete');?>" method="post" name="delete">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th>
														序号
														</th>
														<th>日期</th>
														<th>咨询效果</th>
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($list as $key=>$value) {?>	
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" name="id[]" value="<?php echo $value['consultant_record_id'];?>"/>
																<span class="lbl"></span>
															</label>
														</td>
														<td data-event="changeTooltip"><?php echo $value['serial_number']; ?></td>
														<td><?php echo date("Y-m-d",$value['consultant_record_time']); ?></td>
														<td>
														<a role="button" class="tooltip-info" data-rel="tooltip" data-placement="bottom"  title="<?php echo $value['consultant_record_desc'];?>"><?php echo sub_str($value['consultant_record_desc'],50); ?></a></td>
														
														<td>									
															<a class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(2).'/student_record/edit/'.$value['consultant_id'].'/'.$value['consultant_record_id']); ?>" role="button">编辑</a>
														<?php if (isset($set_view_time['consultant_set_view_time']) && date("Y-m-d",$set_view_time['consultant_set_view_time'])==date("Y-m-d",$value['consultant_record_time'])) { ?>
															<a class="btn btn-xs" role="button">已上门</a>
														<?php }?>
														<?php if (isset($signup['sign_up_date']) && date("Y-m-d",$signup['sign_up_date'])==date("Y-m-d",$value['consultant_record_time'])) { ?>
															<a class="btn btn-xs" role="button">已报名</a>
														<?php }?>
														</td>
													</tr>
													<?php } ?>	  
												</tbody>
											</table>
											<input type="hidden" value="<?php echo $list[0]['student_id'];?>" name="uid">
											<input type="hidden" value="<?php echo $list[0]['consultant_id'];?>" name="cid">
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

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
		<!--模态框（弹出学员详细信息）-->
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="student_info" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		            	<h4 id="youModalLabel" class="modal-title">学生信息</h4>
		          	</div>
		          	<div class="modal-body">    
		          	</div>
		          	<div style="padding-left:20px;" id="stu_info"></div>
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

		<!-- inline scripts related to this page -->
		
		<!--时间选择需要的插件-->
		
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>
	

		<script type="text/javascript">
			jQuery(function($) {
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
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
				//ajax获取用户信息	
				$('.student_info').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student/info');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				       		$("#student_info").find('.modal-body').html(res.data); 
				       		$("#stu_info").html('<a href="'+res.info_url+'">修改学员信息 >></a>'); 
				        }
			   		});
				});
			});
			
		</script>
		<script>
			//修改鼠标滑过文字显示信息的效果。
			jQuery(document).ready(function($){
				
				$('td[data-event="changeTooltip"]').each(function(){

					var num=  $(this).parent().index();
					
					var z= $(this).next().next().find('a');
					
					if(num<=4){
						var options={placement:'bottom'};
					}else{
						var options={placement:'top'};
					}
					z.tooltip(options);

				});
			
			});
		</script>
</body>
</html>