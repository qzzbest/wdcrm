<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>面试咨询者来访统计表</title>
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

						<span style="font-size:16px;margin-left:70px;font-weight:bold;">|面试咨询者来访统计表|</span>
						
					</div>
					
					<div class="page-content">

						<div class="page-header" style="padding-bottom:38px">

							<!-- <div style="float:left;margin-right:10px;">	
								
								<span>月份查询:</span>
								<select name="selectYear" id="selectYear" style="width:91px;">
									
								</select>年
								
								<select name="selectMonth" id="selectMonth" style="width:91px;">
									
								</select>月

								<select name="selectDay	" id="selectDay" style="width:91px;">
									
								</select>天

							</div> -->
							
							

							<div style="float:left; margin-right:30px;">
								<table>
									<tr>
										<td>
											<span>日期查询:</span>
											
										</td>
										<td>
											<div class="input-form">
												<input class="form-control date-picker" style="width:150px" type="text" name="start_time"  value="<?php echo !empty($starttime) ? $starttime : '';?>" data-date-format="yyyy-mm-dd" />
											</div>
										</td>
										<!-- <td>至</td>
										<td>
											<div class="input-form">
												<input class="form-control date-picker" style="width:100px" type="text" name="end_time" value="<?php echo !empty($endtime) ? $endtime : '';?>" data-date-format="yyyy-mm-dd" />
											</div>
										</td> -->
										<td>
											<button type="button" data-event="searchTime" class="btn btn-xs btn-primary">搜索</button>
										</td>
									</tr>
								</table>
							</div>

							<div style="float:left;margin-right:30px;">		
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

							<div class="nav-search" id="nav-search"  style="float:left;margin-right:30px; position:static;">
								<span class="input-icon">
									<select class="form-control" name="key" id="key">
										<option <?php if(isset($adviachieve_info['type']) && $adviachieve_info['type'] == 'consultant_name'){echo 'selected=selected';}?> value="consultant_name">姓名</option>
										<option <?php if(isset($adviachieve_info['type']) && $adviachieve_info['type'] == 'qq'){echo 'selected=selected';}?> value="qq">QQ</option>
										<option <?php if(isset($adviachieve_info['type']) && $adviachieve_info['type'] == 'phones'){echo 'selected=selected';}?> value="phones">phone</option>
									</select>
								</span>
								<span class="input-icon">
									<input type="text" name="search_name" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" value="<?php echo !empty($search_name) ? $search_name : '';?>" />
									<i class="icon-search nav-search-icon"></i>
								</span>
								<span class="input-icon">
								<button type="button" data-event="searchName" class="btn btn-xs btn-primary">搜索</button>
								</span>
							</div><!-- #nav-search -->
							
						</div>
						
						<div class="row">
							<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(2).'/advisory/changeStatus');?>" name="delete">
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
														<th class="center">手机号码</th>
														<th class="center">QQ</th>
														<th class="center">提醒备注</th>
														<th class="center">咨询师</th>
													</tr>
												</thead>

												<tbody>
													<?php foreach($adviachieve_info['list'] as $item){ ?>
													<tr>
														<td class="center" data-event="changeTooltip"><?php echo $item['serial_number'];?></td>
														<td class="center">
															<?php 
																if(!empty($item['consultant_name'])){
																	echo $item['consultant_name'];
																}
															?>
														</td>
														<td class="center hidden-480">
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
															<a role="button" class="tooltip-info" data-rel="tooltip" data-placement="bottom"  title="<?php echo $item['remind_remark'];?>">
															<?php echo sub_str($item['remind_remark'],50);?></a>
														</td>
														<td class="center">
															<?php 
																if(!empty($item['employee_name'])){
																	echo $item['employee_name'];
																}
															?>
														</td>
													</tr>
													<?php }?>
												</tbody>
											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $adviachieve_info['page'];?>
											<div style="float:right;">
												<input type="text" name="pagetiao" id="pagetiao" style="width:30px;text-align:center;" value="<?php if(!empty($cur_pag)){echo $cur_pag;}?>">
												<input type="button" class="btn btn-sm btn-info" id="tiaozhuan" value="跳转">
											</div>
										</div>
									</div>
								</div><!-- /row -->
								
								

							</div><!-- /.col -->
							</form><!-- /批量删除咨询者 -->
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
		//----------------------------------------------------------------	

			jQuery(function($){
				//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
					$('.datepicker').css('z-index',1060);
				
				});

				//咨询日期
				$('button[data-event="searchTime"]').click(function(){

					var start_time = $('input[name="start_time"]').val();

					//var end_time  = $('input[name="end_time"]').val();

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
					delete arr.start_time;
					//delete arr.end_time;
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					//var z=res+'&start_time='+start_time+'&end_time='+end_time;
					var z=res+'&start_time='+start_time;

					ur="<?php echo site_url(module_folder(4).'/teaching_statistics/index/0');?>";
						window.location.href=ur+'?start_time='+start_time;			
				});

				//学生姓名
				$('button[data-event="searchName"]').click(function(){

					var key = $('#key').val();
					var search_name = $('input[name="search_name"]').val();

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
					delete arr.key;
					delete arr.search_name;

					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'&key='+key+'&search_name='+search_name;
					
					//ur="<?php echo site_url(module_folder(4).'/teaching_statistics/index/0');?>";
						//window.location.href=ur+'?search_name='+search_name+'&key='+key;
					window.location.href=z;
				});

			});

			jQuery(function(){
				$('#changeChannel').change(function(){

					var channel_id= this.value;
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
					delete arr.channel_id;
					//初始分页为第一页
					if(arr.per_page){
						delete arr.per_page;
					}
					
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'channel_id='+channel_id

					 ;
					
					window.location.href=z;
					
				});

				$('#changeStatistics').change(function(){

					var statistics_id= this.value;
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
					delete arr.statistics_id;
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'statistics_id='+statistics_id;
					
					window.location.href=z;
					
				});


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
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'teach='+teach_id;
					
					window.location.href=z;
					
				});

				$('#selectYear').change(function(){


					var selectYear= this.value;
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
					delete arr.selectYear;
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					ur="<?php echo site_url(module_folder(4).'/teaching_statistics/index/0');?>";
						window.location.href=ur+'?selectYear='+selectYear;
					
				});

				$('#selectMonth').change(function(){


					var selectMonth= this.value;
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
					delete arr.selectMonth;
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					ur="<?php echo site_url(module_folder(4).'/teaching_statistics/index/0');?>";
						window.location.href=ur+'?selectMonth='+selectMonth;
					
				});

				$('#selectDay').change(function(){


					var selectDay= this.value;
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
					delete arr.selectDay;
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					ur="<?php echo site_url(module_folder(4).'/teaching_statistics/index/0');?>";
						window.location.href=ur+'?selectDay='+selectDay;
					
				});

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
