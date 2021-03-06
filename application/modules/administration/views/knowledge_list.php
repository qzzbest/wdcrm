<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>知识点列表</title>
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
							try{ace.settings.check('bresadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="<?php echo site_url(module_folder(1).'/index/index');?>">主页</a>
							</li>

							<li>
								<a href="<?php echo site_url(module_folder(1).'/knowledge/index');?>">知识点管理</a>
							</li>
							<li class="active">知识点列表</li>
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						<div class="page-header">
							<small>
							<a role="button" class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(1).'/knowledge/add');?>">添加知识点</a>
							</small>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<form  name="delete" action="<?php echo site_url(module_folder(1).'/knowledge/delete');?>" method="post">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th>知识点</th>
														<th>课时</th>
														<th>排序</th>	
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($list as $item) {?>				
													<tr>
														<td>
															<?php echo $item['knowledge_name'];?>
														</td>
														<td><?php echo $item['knowledge_lesson'];?></td>
														<td><?php echo $item['knowledge_order'];?></td>
														<td>									
															<a class="btn btn-xs btn-info knowledge_edit" href="<?php echo site_url(module_folder(1).'/knowledge/edit/'.$item['knowledge_id']);?>">编辑</a>
															<a class="btn btn-xs btn-pink" role="button" data-target="#change_status" data="<?php echo $item['knowledge_id'];?>">
															<?php if($item['knowledge_status']==0){ ?>	
																未启用
															<?php }else{ ?>
																已启用
															<?php }?>
															</a>
														</td>
													</tr>
													
												<?php }?>	
												</tbody>
											</table>
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
		<!--模态框（添加和修改知识点）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="editknowModal" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">修改知识点</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(1).'/knowledge/addEdit');?>" method="post">
			      	<input type="hidden" id="knowledge_id" name="knowledge_id" value="" />
					<div class="modal-body ">
						<table cellpadding="5px">
							<tr>
								<td class="col-sm-3">知识点</td>
								<td>
									<div class="col-sm-8">
										<input type="text" id="form-field-2" placeholder="请输入知识点名称" name="knowledge_name" />
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">课时</td>
								<td>
									<div class="col-sm-8">
										<input type="text" id="form-field-2" placeholder="请输入课时" name="knowledge_lesson"/>
									</div>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">排序</td>
								<td>
									<div class="col-sm-8">
										<input type="text" id="form-field-2" placeholder="请输入排序"  name="knowledge_order"/>
									</div>
								</td>
							</tr>
						</table>	
					</div>
		          	<div class="modal-footer">
		          		<input class="btn btn-info" type="submit" value="提交" name="addedit"/>
			            <button data-dismiss="modal" class="btn" type="button">取消</button>
			        </div>
			        </form>
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
							        url: "<?php echo site_url(module_folder(1).'/knowledge/changeStatus');?>",
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
