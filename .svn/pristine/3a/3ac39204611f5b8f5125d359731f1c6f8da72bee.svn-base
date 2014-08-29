<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>咨询提醒</title>
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
							<?php foreach(unserialize(getcookie_crm('url')) as $key=>$item){
								if($key != count(unserialize(getcookie_crm('url')))-1){?>
							<li>
								<a href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
							</li>
							<?php }else{ ?>
							<li>
								<?php echo $item[0];?>
							</li>
							<?php } }?>
							<!-- <li>
								<a href="<?php echo site_url(module_folder(6).'/remind/index');?>">咨询提醒管理</a>
							</li>
							<li class="active">咨询提醒列表</li> -->
						</ul><!-- .breadcrumb -->
						<div style="position:absolute;right:28%;top:6px;line-height:24px;">	
							<table>
								<tr>
									<td>提醒日期&nbsp;</td>
									<td>
										<div class="input-form">
											<input class="form-control date-picker" style="width:100px" type="text" name="start_time" value="<?php echo isset($_GET['start_time']) ? $_GET['start_time'] : '';?>" data-date-format="yyyy-mm-dd" />
										</div>
									</td>
									<td>至</td>
									<td>
										<div class="input-form">
											<input class="form-control date-picker" style="width:100px" type="text" name="end_time" value="<?php echo isset($_GET['end_time']) ? $_GET['end_time'] : '';?>" data-date-format="yyyy-mm-dd" />
										</div>
									</td>
									<td>
										<button type="button" data-event="searchTime" class="btn btn-xs btn-primary">搜索</button>
									</td>
								</tr>
							</table>
						</div>
						<div class="nav-search" id="nav-search">

						<!-- <form name="advisory_search" class="form-search" action="" method="get">
							<span class="input-icon">
								<select class="form-control" name="key">
										<option <?php if(isset($key) && $key == 'consultant_name'){echo 'selected=selected';}?> value="consultant_name">姓名</option>
										<option <?php if(isset($key) && $key == 'qq'){echo 'selected=selected';}?> value="qq">QQ</option>
										<option <?php if(isset($key) && $key == 'phones'){echo 'selected=selected';}?> value="phones">phone</option>
								</select>
							</span>
							<span class="input-icon">
								<input type="text" name="search" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" value="<?php if(isset($search))echo $search;?>" />
								<i class="icon-search nav-search-icon"></i>
							</span>
							<span class="input-icon">
							<button class="btn btn-xs btn-primary">搜索</button>
							</span>
						</form> -->
					</div><!-- #nav-search --> 
					</div>

					<div class="page-content">
						<div class="page-header">
							<small>
								<a class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(6).'/remind/add');?>">添加咨询提醒</a>
							</small>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<form name="all" id="all" action="" method="post">
											<input type="hidden" name="status" value="del_all">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center" width="68px">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th width="45px">序号</th>
														<th width="86px">提醒时间</th>
															
														<th>提醒内容</th>
														<th>提醒备注</th>
														<!-- <th width="74px">提醒状态</th> -->
														<th width="190px">操作</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($list as $key=>$value) {
													?>	
													<tr>
														<td class="center">
															<label>
																<?php if($value['is_important'] == 1){?>
																<img src="<?php echo base_url('assets/images/0111336.png');?>" width="20" height="20" />
																<?php }?>
																&nbsp;
																<input type="checkbox" class="ace" name="id[]" value="<?php echo $value['time_remind_id'];?>"/>
																<span class="lbl"></span>
															</label>
														</td>
														<td data-event="changeTooltip"><?php echo $value['serial_number'];?></td>
														<td><?php echo date("Y-m-d H:i:s",$value['time_remind_time']); ?></td>
														
														<td>
															<a role="button" class="tooltip-info" data-rel="tooltip" data-placement="bottom"  title="<?php echo $value['time_remind_content'];?>"><?php echo sub_str($value['time_remind_content'],50); ?></a>
														</td>
	
														<td>
															<a role="button" class="tooltip-info" data-rel="tooltip" data-placement="bottom"  title="<?php echo $value['remind_remark'];?>"><?php echo sub_str($value['remind_remark'],50); ?></a>
														</td>
														<!-- <td><?php if($value['time_remind_status']==0){echo '提醒';}else{echo '不提醒';} ?></td> -->
														<td>									
															<a class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(6).'/remind/edit/'.$value['time_remind_id']); ?>" role="button" data-rel="tooltip" title="修改">修改</a>

															

															<a class="btn btn-xs btn-danger one_delete" data-del="<?php echo $value['time_remind_id'];?>" role="button" data-rel="tooltip" title="删除">删除</a>
														</td>
													</tr>
													<?php } ?>	  
												</tbody>
											</table>
											<a class="btn btn-xs btn-danger all_ignore" role="button">删除</a>
											<a class="btn btn-xs btn-info all_edit" role="button">批量修改</a>
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


		<!-- ace scripts 弹出确认框样式 -->
		<script src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>
		
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>

		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">

			jQuery(function($) {
				//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					
					$(this).prev().focus();
				
				});
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null, null,
				  { "bSortable": false }
				] } );
				
				//列表全选、反选功能
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
				
				//一条删除功能
				$(".one_delete").on(ace.click_event, function() {
					var data_del = $(this).attr('data-del');
					bootbox.confirm("你确定删除提醒吗?", function(result) {
						if(result) {
							$.ajax({
						        type: "POST",
						        url: "<?php echo site_url(module_folder(6).'/remind/deleteRemind');?>",
						        data: "id="+data_del,
						        dataType:'json',
						        success: function(res){
						        	if(res.status==1){
						        		alert('删除成功！');
						        		window.location.reload();
						        	}
						       		
						        }
					   		});
						}
					});

				});

				//多条删除功能
				$(".all_ignore").on(ace.click_event, function() {
					$("#all").attr("action","<?php echo site_url(module_folder(6).'/remind/ignore');?>");
					//检测有多少个被选中了，0个删除不弹出确定框。
					var length= $('input[name="id[]"]:checked').length;
					if(length>0){
						bootbox.confirm("你确定删除提醒吗?", function(result) {
							if(result) {
								document.forms['all'].submit();
							}
						});
					}

				});

				//批量修改
				$(".all_edit").click(function() {
					$("#all").attr("action","<?php echo site_url(module_folder(6).'/remind/allEdit');?>");
					
					//检测有多少个被选中了
					var length= $('input[name="id[]"]:checked').length;
					if(length>0){
						document.forms['all'].submit();
					}

				});

			});
			jQuery(function($){
				//咨询日期
				$('button[data-event="searchTime"]').click(function(){

					var start_time= $('input[name="start_time"]').val();

					var end_time  = $('input[name="end_time"]').val();

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
					//干掉开始时间，结束时间
					delete arr.start_time;
					delete arr.end_time;
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'start_time='+start_time+'&end_time='+end_time;
					

					window.location.href=z;


				});

			});
			//搜索咨询者的相关信息
			jQuery(function($){
				
				var url="<?php echo site_url(module_folder(6).'/remind/index');?>";
				$('form[name="advisory_search"]').submit(function(){
					var search=$.trim(this.elements['search'].value);

					if (search!='') {
						var key= $('select[name="key"] option:selected').val();
						window.location.href=url+'?key='+key+'&search='+search;

					};	
					return false;
				});

			});

		</script>

		<script>
			//修改鼠标滑过文字显示信息的效果。
			jQuery(document).ready(function($){
				
				$('td[data-event="changeTooltip"]').each(function(){

					var num=  $(this).parent().index();
					
					var z= $(this).parent().find('.tooltip-info');

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