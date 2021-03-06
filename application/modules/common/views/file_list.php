<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>简历下载</title>
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
		<style>
			.tagMenu {border-bottom: 1px solid #ddd;height: 30px;position: relative;margin-bottom: 15px;}
			.tagMenu ul {list-style: none;bottom: -1px; height: 18px;position: absolute;}
			.tagMenu ul li {background-color:#ccc;border: 1px solid #ddd;color: #999; cursor: pointer;float: left;height: 28px;line-height: 29px;margin-left: 4px;text-align: center;width: 108px;border-radius:5px 5px 0 0;}
			.tagMenu li.current {background-color:#fff;border-color: #ddd;border-style: solid solid none;color: #6c6c6c;border-radius:5px 5px 0 0;cursor: pointer;height: 29px;line-height: 29px;}
			.tagMenu ul li a{display:block;text-decoration: none;}
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
							<?php foreach(unserialize(getcookie_crm('url')) as $item){?>
								<li>
									<a href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
								</li>
							<?php }?>
						</ul><!-- .breadcrumb -->
						
					</div>

					<div class="page-content">
						<div class="page-header">
							<?php if(getcookie_crm('employee_power')==1){?>
							<a role="button" class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(5).'/file/add');?>">上传简历</a>
							<?php } ?>
							<span>未下载文件:<em style="color:red"><?php echo $nodown_count;?></em>个 已下载文件:<em style="color:red"><?php echo $down_count;?></em>个</span>	
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="tagMenu">
									<ul class="menu">
										<li <?php echo $file_status=='1' ? 'class="current"': '' ?>><a href="<?php echo site_url(module_folder(5).'/file/index/1');?>">未下载</a></li>
										<li <?php echo $file_status=='2' ? 'class="current"': '' ?>><a href="<?php echo site_url(module_folder(5).'/file/index/2');?>">已下载</a></li>
									</ul>
							    </div>
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(5).'/file/delFile');?>" name="delete">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<?php if(getcookie_crm('employee_power')==1){?>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<?php }?>
														<th class="center">序号</th>
														<th class="center">文件名称</th>
														<th class="center">文件大小</th>
														<th class="center">上传人</th>
														<th class="center">上传时间</th>
														<th class="center">状态</th>
														<th class="center">下载人</th>
														<th class="center">下载时间</th>
														<th class="center">下载次数</th>
														<th>操作</th>
														
													</tr>
												</thead>

												<tbody>
													<?php foreach ($file_info['list'] as $key => $value) {?>
													<tr>
														<?php if(getcookie_crm('employee_power')==1){?>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" name="id[]" value="<?php echo $value['upload_file_id'];?>" />
																<span class="lbl"></span>
															</label>
														</td>
														<?php }?>
														<td class="center" data-event="changeTooltip">
															<?php echo $value['serial_number']; ?>
														</td>
														<td class="center">
															<a class="tooltip-info" data-rel="tooltip" data-placement="bottom" title="<?php echo $value['file_name']; ?>"><?php echo $value['file_name']; ?></a>
														</td>
														<td class="center">
															<?php echo $value['file_size']; ?>
														</td>
														<td class="center">
															<?php echo $value['upload']['employee_name']; ?>
														</td>
														<td class="center"> 
															<?php echo date('Y-m-d H:i:s',$value['upload_time']); ?>
														</td>
														<td class="center"> 
															<span class="down"><?php if($value['file_status']==2){
																echo '已下载';
															}?></span>
														</td>
														<td class="center"> 
															<span class="downname"><?php echo isset($value['download']['employee_name']) ? $value['download']['employee_name'] : ''; ?>
															</span>
														</td>
														<td class="center"> 
															<span class="downtime"><?php echo isset($value['download_time']) ? date('Y-m-d H:i:s',$value['download_time']) : ''; ?>
															</span>
														</td>
														<td class="center">
															<span class="number"><?php echo $value['download_number']; ?></span>
														</td>
														<td class="center">
															<!-- <a class="btn btn-xs btn-info download" role="button" data="<?php echo $value['upload_file_id'];?>">下载</a> -->
															<a class="btn btn-xs btn-info download" role="button" href="<?php echo site_url(module_folder(5).'/file/downloadFile/'.$value['upload_file_id']);?>">下载</a>
														</td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
											<?php if(getcookie_crm('employee_power')==1){?>
											<a class="btn btn-xs btn-danger" id="delete_all" role="button">删除</a>
											<?php }?>
											</form>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $file_info['page'];?>
											<div style="float:right;">
												<input type="text" name="pagetiao" id="pagetiao" style="width:30px;text-align:center;" value="<?php if(isset($cur_pag)){echo $cur_pag;}?>">
												<input type="button" class="btn btn-sm btn-info" id="tiaozhuan" value="跳转">
											</div>
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
	
		<!--[if !IE]> -->
	
		<script src="<?php echo base_url('assets/js/jquery-2.0.3.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/jquery-1.8.3.min.js');?>"></script><!--针对课程全选反选功能-->

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
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->


		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo base_url('assets/js/jquery.mobile.custom.min.js');?>'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/typeahead-bs2.min.js');?>"></script>

		<!-- page specific plugin scripts -->

		<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.dataTables.bootstrap.js');?>"></script>

		<!-- ace scripts 弹出确认框样式 -->
		<script src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace-elements.min.js')?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>

		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>
		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {

				//列表全选，批量删除
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
				//点击弹出确定框，确定就批量删除咨询者
				$("#delete_all").on(ace.click_event, function() {
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

			jQuery(function($){
				//时间控件
				$('.date-picker').datepicker({
					autoclose:true,	
				}).next().on(ace.click_event, function(){		
					$(this).prev().focus();
				});
				$('input[data-target="#dateShow"]').datepicker();

				$('input[data-target="#dateShow"]').focus(function(){

					$('.dropdown-menu').css('z-index',1060);

				});
			});	
			jQuery(function($) {	
				//页码输入跳转
				$('#tiaozhuan').click(function(){
					if($('#pagetiao').val()==""){
						alert("请输入要跳转的页码");
						return false;
					}
					var address="<?php echo $tiao;?>"+"&per_page="+parseInt($('#pagetiao').val());
					location.href=address;
				});
			});	
			/*jQuery(function($) {
				//下载
				$('.download').on(ace.click_event, function() {
			
					var _this=this;
					var brother = $(_this).parent().siblings()
					var download_id=parseInt($(this).attr("data"));
					bootbox.confirm("是否要下载该文件?", function(result) {
						if(result) {
							//location.href='<?php echo site_url(module_folder(5).'/file/downloadFile/');?>?download='+download_id;
							//window.location.reload();
							$.ajax({
						        type: "POST",
						        url: "<?php echo site_url(module_folder(5).'/file/downloadUpdate');?>",
						        data: "id="+download_id,
						        dataType:'json',
						        success: function(res){
						       		if (res.status==1) {
						       			
						       			//下载次数加1
						       			$(brother).children('.downname').html(res.downname);
						       			$(brother).children('.downtime').html(res.downtime);
						       			$(brother).children('.down').html(res.filestatus);
						       			$(brother).children('.number').html(res.downnumber);
						       			//跳转下载地址下载
						       			location.href='<?php echo site_url(module_folder(5).'/file/downloadFile/');?>?download='+download_id;
						       		};
						        }
					   		});
						}
					});
					
				});
			});*/
			//修改鼠标滑过文字显示信息的效果。
			jQuery(document).ready(function($){
				$('td[data-event="changeTooltip"]').each(function(){

					var num =  $(this).parent().index();
					var z = $(this).parent().find('.tooltip-info');

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