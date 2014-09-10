<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $regulation_type_name;?>列表</title>
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
		<style>
			.imp td{
				background-color:#d7d7d7 !important;
			}
		</style>
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
					<div class="breadcrumbs" >
						<?php
						//咨询师
						$advisory_job = array(11);
						if( in_array(getcookie_crm('employee_job_id'),$advisory_job) ){?>
							<a type="button" href="<?php echo site_url(module_folder(5).'/regulations/add/'.$regulation_type);?>" class="btn btn-xs btn-primary" style="margin:0px 50px;">添加<?php echo $regulation_type_name;?></a>
						<?php }?>

						<span style="font-size:16px;margin-left:70px;font-weight:bold;">|<?php echo $regulation_type_name;?>|</span>

						<div class="nav-search" id="nav-search">
							<span class="input-icon">
									标题搜索：
								</span>
								<span class="input-icon">
									<input type="text" name="search" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" value="<?php echo isset($_GET['search_title']) ? $_GET['search_title'] : '';?>" />
									<i class="icon-search nav-search-icon"></i>
								</span>
								<span class="input-icon">
								<button type="button" data-event="searchTitle" class="btn btn-xs btn-primary">搜索</button>
							</span>
						</div><!-- #nav-search -->
					</div>

					<div class="page-content">
						<div class="page-header">
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<form  name="delete" action="<?php echo site_url(module_folder(1).'/admin/delete');?>" method="post">
											<?php foreach ($list as $key => $value) {?>
												<table id="sample-table-1" class="table table-striped table-bordered table-hover">
													<tbody>
														<tr class="title" title="请点击后显示内容">
															<td width="6%" align="right">标题：</td>
															<td>
																<?php echo $value['regulation_title'];?>
																
																<?php if( in_array(getcookie_crm('employee_job_id'),$advisory_job) ){?>
																	<a type="button" href="javascript:void(0)" class="btn btn-xs btn-primary delete" style="float:right;" data-id="<?php echo $value['regulation_id'];?>">删除</a>
																
																	<span style="float:right;">&nbsp;</span>

																	<a type="button" href="<?php echo site_url(module_folder(5).'/regulations/edit/'.$value['regulation_id'].'/'.$regulation_type);?>" class="btn btn-xs btn-primary" style="float:right; margin-right:2px;">修改</a>
																<?php }?>

															</td>
														</tr>
														<tr>
															<td align="right">内容：</td>
															<td>
																<?php echo $value['regulation_content'];?>
															</td>
														</tr>
													</tbody>
												</table>
											<?php }?>	
											
											</form>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $create_page;?>
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
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="youModal" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		            	<h4 id="youModalLabel" class="modal-title">用户信息</h4>
		          	</div>
		          	<div class="modal-body" id="info">    
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
			jQuery(function($) {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null, null,
				  { "bSortable": false }
				] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
			jQuery(function($){

				//获取用户信息		
				$('.userinfo').click(function(){
					var userid=parseInt($(this).attr("uid"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(1).'/admin/info');?>",
				        data: "id="+userid,
				        dataType:'json',
				        success: function(res){
				       		$("#info").html(res.data); 
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

				//删除记录
				$(".delete").click(function() {
					var regulation_id = $(this).attr('data-id');
					var regulation_type = <?php echo $regulation_type;?>;
					bootbox.confirm("你确定删除吗?", function(result) {
						if(result) {
							location.href = "<?php echo site_url(module_folder(5).'/regulations/delete/');?>"+'/'+regulation_id+'/'+regulation_type;
						}
					});
				});
			});
			jQuery(function(){

				$('#changejob').change(function(){

					var job_id= this.value;
					var url= window.location.href;
				
					var search='';
					
					var num = url.match(/\?/g);   // 尝试匹配搜索字符串。
					if(num.length>1){
						var tmp=url.lastIndexOf('?');
						 	search=url.substr(tmp,url.length);
					 		url=url.substr(0,tmp);
					}
				
					var param_str=search.substr(1,search.length);
					var arr={};
					wdcrm.parse_str(param_str,arr);
					//干掉老师id
					delete arr.job;
					if(arr.per_page){
						delete arr.per_page;
					}
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'job='+job_id;
					window.location.href=z;

				});

			});

			jQuery(function($){
				//咨询日期
				$('button[data-event="searchTitle"]').click(function(){

					var search_title  = $('input[name="search"]').val();

					var url= window.location.href;
					var search='';
					
					var num = url.match(/\?/g);   // 尝试匹配搜索字符串。
					if(num.length>1){
						var tmp=url.lastIndexOf('?');
						 	search=url.substr(tmp,url.length);
					 		url=url.substr(0,tmp);
					}

					var param_str=search.substr(1,search.length);
					var arr={};
					wdcrm.parse_str(param_str,arr);
					//开始时间，结束时间
					delete arr.search_title;
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'search_title='+search_title;
					
					window.location.href=z;
					
				});

				//显示隐藏内容（规章制度）
				$('table .title').next().hide();

				$('table .title').css('cursor','pointer').click(function() {
					$(this).next().toggle(500);
				});

			});

		</script>
</body>
</html>
