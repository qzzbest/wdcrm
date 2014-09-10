<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>公共资源</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
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
		<style type="text/css">
		.tree:before{
			border-style:none;
		}
		#menu li,#menu_course li{
			list-style: none;
			line-height: 30px;
		}
		#menu li.second,#menu_course li.second{
			float:left;
			margin-right: 10px;
		}
		.clear{
			clear: both;
		}
		#menu li span.lbl,#menu_course li span.lbl{
			line-height:21px;
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
							<?php foreach(unserialize(getcookie_crm('url')) as $item){?>
							<li>
								<a href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
							</li>
							<?php }?>
							
						</ul><!-- .breadcrumb -->
						<div style="position:absolute;right:33%;top:6px;line-height:24px;">
							<table>
								<tr>
									<td>
										<span>查询条件:</span>
										<select name="select_day">
											<option <?php if(isset($select_day) && $select_day==1) { echo 'selected'; }?> value="1">咨询日期</option>
											<option <?php if(isset($select_day) && $select_day==2) { echo 'selected'; }?> value="2">回访日期</option>
										</select>&nbsp;
									</td>
									<td>
										<div class="input-form">
											<input class="form-control date-picker" style="width:100px" type="text" name="start_time"  value="<?php echo isset($_GET['start_time']) ? $_GET['start_time'] : '';?>" data-date-format="yyyy-mm-dd" />
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
						<?php $this->load->view('search_consultant');?>
					</div>
					
					<div class="page-content">
						<div class="page-header">
							<?php 
							$login_job = getcookie_crm('employee_job_id');
							$employee_arr = array(2,11);
							if(in_array($login_job, $employee_arr)){?>	
							<!-- <a role="button" class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(2).'/advisory/add');?>">添加咨询者</a> -->
							<?php }?>
						
							<span>总人数是：<em style="color:red; font-size:16px; font-weight:bold;"><?php echo $advisory_info['count'];?></em> 人</span>
							&nbsp;&nbsp;&nbsp;
							<span><?php if(isset($member)){echo $member;}?></span>
						
							<div style="display: inline-block;margin-left:20px;">
								<span>日期:</span>
								<label><input type="radio" value="0" name="order" <?php if(isset($order) && $order == 0){echo 'checked=checked';}?> class="sel_order ace" /><span class="lbl">升序</span></label>
								<label><input type="radio" value="1" name="order" <?php if(isset($order) && $order == 1){echo 'checked=checked';}?> class="sel_order ace" /><span class="lbl">降序</span></label>
							</div>
						
							<?php if(getcookie_crm('employee_power')==1){?>
							<div style="float:right;margin-right:30px;">		
								<span>咨询师:</span>
								<select name="teach" id="changeTeach" style="width:91px;">
									<option value=" ">全部</option>
									<?php foreach($teach as $item){ ?>
									<option <?php 
										if ($item['employee_id']==$selected_teach) {
											echo 'selected';
										}
						
									?> value="<?php echo $item['employee_id'];?>"><?php echo $item['employee_name'];?></option>
									<?php } ?>
								</select>
							</div>
							<?php }?>
							
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
														<th class="center">咨询日期</th>
														<th class="center">姓名</th>
														<th class="center">性别</th>
														<th class="center hidden-480">手机</th>
														<th class="center">QQ</th>
														<th class="center">邮箱</th>
														<th>操作</th>
														<th>咨询师</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach($advisory_info['list'] as $item){ ?>
													<tr>
														<td class="center">
															<?php echo $item['serial_number'];?>
														</td>
														<td class="center">
															<?php echo date('Y-m-d',$item['consultant_firsttime']);?>
														</td>
														<td class="center">
															<?php echo $item['consultant_name'];?>
														</td>
														<td class="center">
															<?php
																if ($item['consultant_sex']==1) {
																	echo '男';
																}else if($item['consultant_sex']==2){
																	echo '女';
																}else{
																	echo '';
																}
															?>
														</td>
														<td class="center">
															<?php
																if( !empty($item['phone']) ){
																	foreach ($item['phone'] as $key => $value) {
																		echo $value.'<br />';
																	}
																}
															?>
														</td>
														<td class="center">
															<?php
																if( !empty($item['qq']) ){
																	foreach ($item['qq'] as $key => $value) {
																		echo $value.'<br />';
																	}
																}
															?>
														</td>
														<td class="center">
															<?php
																if( !empty($item['email']) ){
																	foreach ($item['email'] as $key => $value) {
																		echo $value.'<br />';
																	}
																}
															?>
														</td>
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a class="btn btn-xs btn-pink" role="button" data-target="#setView" data-toggle="modal" data="<?php echo $item['consultant_id'];?>">
																	<?php
																		if ($item['consultant_set_view']==0) {
																			echo '未上门';
																		}else{
																			echo '已上门';
																		}
																	?>
																</a>
																<button type="button" class="btn btn-xs btn-warning advisory_info" data-toggle="modal" data-target="#advisory_info" data="<?php echo $item['consultant_id'];?>">详细信息</button>
																<button type="button" class="btn btn-xs btn-info">认领</button>
															</div>
														</td>
														<td>
															<?php echo $value['old_employee'] ?>
														</td>
													</tr>
													<?php }?>

												</tbody>
											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $advisory_info['page'];?>
											<div style="float:right;">
												<input type="text" name="pagetiao" id="pagetiao" style="width:45px;text-align:center;" value="<?php if(!empty($cur_pag)){echo $cur_pag;}?>">
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

		<!-- ace scripts -->
		<script src="<?php echo base_url('assets/js/ace-elements.min.js')?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>

		<!-- inline scripts related to this page -->

		<!--弹出确定框需要的js-->
		<script src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>

		<!-- 树状图 -->
		<script src="<?php echo base_url('assets/js/fuelux/data/fuelux.tree-sampledata.js');?>"></script>
		<script src="<?php echo base_url('assets/js/fuelux/fuelux.tree.min.js');?>"></script>
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>
		
		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
			
		<script type="text/javascript">
		
			jQuery(function($) {

				//页码输入跳转
				$('#tiaozhuan').click(function(){
					if($('#pagetiao').val()==""){
						alert("请输入要跳转的页码");
						return false;
					}
					var address="<?php echo $tiao;?>"+"&per_page="+parseInt($('#pagetiao').val());
					window.location.href=address;
				});
			});

		//----------------------------------------------------------------	

			//日期排序
			jQuery(function($){

				
				$('.sel_order').click(function(){

					var order= this.value;
					
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
					//干掉排序的状态
					delete arr.order;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'order='+order;
					
					window.location.href=z;

				});


			});
		
			jQuery(function($){
				//咨询日期
				$('button[data-event="searchTime"]').click(function(){

					var select_day = $('select[name="select_day"]').val();

					var start_time = $('input[name="start_time"]').val();

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
					//开始时间，结束时间
					delete arr.select_day;
					delete arr.start_time;
					delete arr.end_time;
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'select_day='+select_day+'&start_time='+start_time+'&end_time='+end_time;
					
					if(select_day==2){
						ur='<?php echo site_url(module_folder(2).'/advisory/index/index/0');?>';
						window.location.href=ur+'?select_day='+select_day+'&start_time='+start_time+'&end_time='+end_time;
						//超级管理员地址
						<?php if(getcookie_crm('employee_power')==1){?>
							var teach_id = $('#changeTeach').val();
							window.location.href=ur+'?select_day='+select_day+'&start_time='+start_time+'&end_time='+end_time+'&teach='+teach_id;
						<?php }?>
					}else{
						window.location.href=z;
					}
									
				});

			});
				
			<?php 
			//超级管理员可以选择不同的咨询师查看
			if(getcookie_crm('employee_power')==1){?>
			jQuery(function(){

				$('#changeTeach').change(function(){

					var teach_id= this.value;
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
					delete arr.teach;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'teach='+teach_id;
					
					window.location.href=z;
					
				});

			});
			<?php }?>

		</script>
</body>
</html>
