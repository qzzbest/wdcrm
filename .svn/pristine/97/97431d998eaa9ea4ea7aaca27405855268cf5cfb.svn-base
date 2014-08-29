<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>业绩统计列表</title>
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

						<span style="font-size:16px;margin-left:70px;font-weight:bold;">|咨询师业绩统计列表|</span>

						<div style="position:absolute;right:28%;top:6px;line-height:24px;">
							<table>
								<tr>
									<td>
										<span>日期查询:</span>
										
									</td>
									<td>
										<div class="input-form">
											<input class="form-control date-picker" style="width:100px" type="text" name="start_time"  value="<?php echo !empty($starttime) ? $starttime : '';?>" data-date-format="yyyy-mm-dd" />
										</div>
									</td>
									<td>至</td>
									<td>
										<div class="input-form">
											<input class="form-control date-picker" style="width:100px" type="text" name="end_time" value="<?php echo !empty($endtime) ? $endtime : '';?>" data-date-format="yyyy-mm-dd" />
										</div>
									</td>
									<td>
										<button type="button" data-event="searchTime" class="btn btn-xs btn-primary">搜索</button>
									</td>
								</tr>
							</table>
						</div>

						<div class="nav-search" id="nav-search">
							<span class="input-icon">
								姓名查询:
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
					
					<div class="page-content">
						<div style="float:left; font-size:16px">
							统计：总共 <em id="visit" style="color:red"><b><?php echo $count_money;?></b></em> 元
						</div>

						<div class="page-header" style="padding-bottom:38px">
							<div style="float:right;margin-right:28px;">		
								<span>渠道经理:</span>
								<select name="achieve_statistics" id="changeStatistics" style="width:91px;">
									<option value="">全部</option>
									<?php foreach ($marketing_specialist as $key => $value) {
										if($value['employee_id'] == $statistics_id){
											$selected = 'selected="selected"';
										}else{
											$selected = '';
										}

										echo '<option '.$selected.' value="'.$value['employee_id'].'">'.$value['employee_name'].'</option>';
									}?>
								</select>
							</div>

							<div style="float:right;margin-right:10px;">		
								<span>渠道:</span>
								<select name="consultant_channel" id="changeChannel" style="width:91px;">
									<option value="">全部</option>
									<?php foreach ($consultant_channel as $key => $value) {
										if($value['consultant_channel_id'] == $channel_id){
											$selected = 'selected="selected"';
										}else{
											$selected = '';
										}
										
										echo '<option '.$selected.' value="'.$value['consultant_channel_id'].'">'.$value['consultant_channel_name'].'</option>';
									}?>
								</select>
							</div>
							
							<?php if(getcookie_crm('employee_power')==1){?>
							<div style="float:right;margin-right:10px;">		
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
							<?php }else{?>
							<div style="float:right;margin-right:10px;">		
								<span>咨询师:</span>
								<select name="teach" id="changeTeach" style="width:91px;">
									<option value=" ">全部</option>
									<option <?php 
										if (getcookie_crm('employee_id')==$selected_teach) {
											echo 'selected';
										}
									?> value="<?php echo getcookie_crm('employee_id');?>">当前咨询师</option>
								</select>
							</div>
							<?php }?>

							<div style="float:right;margin-right:10px;">	
								
								<span>月份查询:</span>
								<select name="selectYear" id="selectYear" style="width:91px;">
									
								</select>年
								
								<select name="selectMonth" id="selectMonth" style="width:91px;">
									
								</select>月
								<!-- <span>天数:</span>
								<select name="selectDay	" id="selectDay" style="width:91px;">
									
								</select> -->

							</div>
							
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
														<th class="center">日期</th>
														<th class="center">姓名</th>
														<th class="center" width="400px">课程/项目</th>
														<th class="center">应缴学费（元）</th>
														<th class="center"><font color="red">缴费金额（元）</font></th>
														<th class="center">是否缴清</th>
														<th class="center">咨询师</th>
														<th class="center">渠道</th>
														<th class="center">渠道经理</th>
													</tr>
												</thead>

												<tbody>
													<?php foreach($adviachieve_info['list'] as $item){ ?>
													<tr>
														<td class="center"><?php echo $item['serial_number'];?></td>
														<td class="center">
															<?php
																if(!empty($item['already_paytime'])){
																	echo date('Y-m-d',$item['already_paytime']);
																}?>
														</td>
														<td class="center">
															<?php 
																if(!empty($item['consultant_name'])){
																	echo $item['consultant_name'];
																}?>
														</td>
														<td class="left">
															<?php if(!empty($item['courseInfo'])){
																echo $item['courseInfo'];
															}elseif(!empty($item['projectInfo'])){
																echo $item['projectInfo'];
															 }?>
														</td>
														<td class="center">
															<?php 
																if(!empty($item['study_expense'])){
																	echo $item['study_expense'];
																}?>
														</td>
														<td class="center">
															<?php 
																if(!empty($item['payment_money'])){
																	echo $item['payment_money'];
																}?>
														</td>
														<td class="center">
															<?php 
															if($item['payment_money'] > 0){
																if($item['difference'] == 0){
																	echo '是';
																}elseif($item['difference'] > 0){
																	echo '还差'.$item['difference'].'元';
																}elseif($item['difference'] < 0){
																	echo '超出'.-$item['difference'].'元';
																}
															}else{
																echo '退了'.abs($item['payment_money']).'元';
															}
															?>
														</td>
														<td class="center">
															<?php 
																if(!empty($item['employee_name'])){
																	echo $item['employee_name'];
																}?>
														</td>
														<td class="center">
															<?php 
															if(!empty($item['consultant_channel_name'])){
																echo $item['consultant_channel_name'];
															}?>
														</td>
														<td class="center">
															<?php 
																if(!empty($item['marketing_specialist_name'])){
																	echo $item['marketing_specialist_name'];
																}?>
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
					delete arr.start_time;
					delete arr.end_time;
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'&start_time='+start_time+'&end_time='+end_time;
					
					ur='<?php echo site_url(module_folder(2).'/achieve_statistics/index/0');?>';
						window.location.href=ur+'?start_time='+start_time+'&end_time='+end_time;			
				});

				//学生姓名
				$('button[data-event="searchName"]').click(function(){

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
					delete arr.search_name;

					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'&search_name='+search_name;
					
					ur='<?php echo site_url(module_folder(2).'/achieve_statistics/index/0');?>';
						window.location.href=ur+'?search_name='+search_name;
					//window.location.href=z;
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
					
					ur='<?php echo site_url(module_folder(2).'/achieve_statistics/index/0');?>';
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
					
					ur='<?php echo site_url(module_folder(2).'/achieve_statistics/index/0');?>';
						window.location.href=ur+'?selectMonth='+selectMonth;
					
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

			jQuery(function(){
				
				//选择年、月、日
				function DateSelector(selYear, selMonth, selDay)
				{
				    this.selYear = selYear;
				    this.selMonth = selMonth;
				    this.selDay = selDay;
				    this.selYear.Group = this;
				    this.selMonth.Group = this;
				    // 给年份、月份下拉菜单添加处理onchange事件的函数
				    if(window.document.all != null) // IE
				    {
				        this.selYear.attachEvent("onchange", DateSelector.Onchange);
				        this.selMonth.attachEvent("onchange", DateSelector.Onchange);
				    }
				    else // Firefox
				    {
				        this.selYear.addEventListener("change", DateSelector.Onchange, false);
				        this.selMonth.addEventListener("change", DateSelector.Onchange, false);
				    }

				    if(arguments.length == 4) // 如果传入参数个数为4，最后一个参数必须为Date对象
				        this.InitSelector(arguments[3].getFullYear(), arguments[3].getMonth() + 1, arguments[3].getDate());
				    else if(arguments.length == 6) // 如果传入参数个数为6，最后三个参数必须为初始的年月日数值
				        this.InitSelector(arguments[3], arguments[4], arguments[5]);
				    else // 默认使用当前日期
				    {
				        var dt = new Date();
				        this.InitSelector(dt.getFullYear(), dt.getMonth() + 1, dt.getDate());
				    }
				}

				// 增加一个最大年份的属性
				DateSelector.prototype.MinYear = 1900;

				// 增加一个最大年份的属性
				DateSelector.prototype.MaxYear = (new Date()).getFullYear();

				// 初始化年份
				DateSelector.prototype.InitYearSelect = function()
				{
				    // 循环添加OPION元素到年份select对象中
				    for(var i = this.MaxYear; i >= this.MinYear; i--)
				    {
				        // 新建一个OPTION对象
				        var op = window.document.createElement("OPTION");
				        
				        // 设置OPTION对象的值
				        op.value = i;
				        
				        // 设置OPTION对象的内容
				        op.innerHTML = i;
				        
				        // 添加到年份select对象
				        this.selYear.appendChild(op);
				    }
				}

				// 初始化月份
				DateSelector.prototype.InitMonthSelect = function()
				{
				    // 循环添加OPION元素到月份select对象中
				    for(var i = 1; i < 13; i++)
				    {
				        // 新建一个OPTION对象
				        var op = window.document.createElement("OPTION");
				        
				        // 设置OPTION对象的值
				        op.value = i;
				        
				        // 设置OPTION对象的内容
				        op.innerHTML = i;
				        
				        // 添加到月份select对象
				        this.selMonth.appendChild(op);
				    }
				}

				// 根据年份与月份获取当月的天数
				DateSelector.DaysInMonth = function(year, month)
				{
				    var date = new Date(year, month, 0);
				    return date.getDate();
				}

				// 初始化天数
				DateSelector.prototype.InitDaySelect = function()
				{
				    // 使用parseInt函数获取当前的年份和月份
				    var year = parseInt(this.selYear.value);
				    var month = parseInt(this.selMonth.value);
				    
				    // 获取当月的天数
				    var daysInMonth = DateSelector.DaysInMonth(year, month);
				    
				    // 清空原有的选项
				   // this.selDay.options.length = 0;
				    // 循环添加OPION元素到天数select对象中
				    for(var i = 1; i <= daysInMonth ; i++)
				    {
				        // 新建一个OPTION对象
				        var op = window.document.createElement("OPTION");
				        
				        // 设置OPTION对象的值
				        op.value = i;
				        
				        // 设置OPTION对象的内容
				        op.innerHTML = i;
				        
				        // 添加到天数select对象
				        //this.selDay.appendChild(op);
				    }
				}

				// 处理年份和月份onchange事件的方法，它获取事件来源对象（即selYear或selMonth）
				// 并调用它的Group对象（即DateSelector实例，请见构造函数）提供的InitDaySelect方法重新初始化天数
				// 参数e为event对象
				DateSelector.Onchange = function(e)
				{
				    var selector = window.document.all != null ? e.srcElement : e.target;
				    selector.Group.InitDaySelect();
				}

				// 根据参数初始化下拉菜单选项
				DateSelector.prototype.InitSelector = function(year, month, day)
				{
				    // 由于外部是可以调用这个方法，因此我们在这里也要将selYear和selMonth的选项清空掉
				    // 另外因为InitDaySelect方法已经有清空天数下拉菜单，因此这里就不用重复工作了
				    this.selYear.options.length = 0;
				    this.selMonth.options.length = 0;
				    
				    // 初始化年、月
				    this.InitYearSelect();
				    this.InitMonthSelect();
				    
				    // 设置年、月初始值
				    this.selYear.selectedIndex = this.MaxYear - year;
				    this.selMonth.selectedIndex = month - 1;
				    
				    // 初始化天数
				    this.InitDaySelect();
				    
				    // 设置天数初始值
				    //this.selDay.selectedIndex = day - 1;
				}
				var selYear = window.document.getElementById("selectYear");
				var selMonth = window.document.getElementById("selectMonth");
				var selDay = window.document.getElementById("selectDay");

				// 新建一个DateSelector类的实例，将三个select对象传进去
				new DateSelector(selYear, selMonth ,selDay, <?php echo $selectYear;?>, <?php echo $selectMonth;?>, 29);
				// 也可以试试下边的代码
				// var dt = new Date(2004, 1, 29);
				// new DateSelector(selYear, selMonth ,selDay, dt);
		        
			});	
		</script>
</body>
</html>
