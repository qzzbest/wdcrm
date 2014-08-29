<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>班级列表</title>
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
			.font_red{color:red;}
			.font_blue{color:blue;}
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
						
						<div style="position:absolute;right:25%;top:6px;line-height:24px;">
							<span>班级类型:</span>
							<span class="input-icon">
								<select class="form-control" id="classtype" name="classroom_type">
									<option value="">请选择班级类型</option>
									<?php foreach ($classroom_type as $key => $value) { ?>
										<option <?php if ($value['classroom_type_id']==$classroom_info['select_type']) { echo 'selected'; }?> value="<?php echo $value['classroom_type_id']; ?>"><?php echo $value['classroom_type_name'];?></option>
									<?php } ?>
								</select>
							</span>
						</div>
						<div class="nav-search" id="nav-search">	
							<form name="classroom_search" class="form-search" action="" method="get">
								<span class="input-icon">
									<input type="text" name="search" placeholder="搜索班级名称" class="nav-search-input" id="nav-search-input" autocomplete="off" value="" />
									<i class="icon-search nav-search-icon"></i>
								</span>
								<span class="input-icon">
								<button class="btn btn-xs btn-primary">搜索</button>
								</span>
							</form>
						</div><!-- #nav-search -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<?php 
								$login_job = getcookie_crm('employee_job_id');
								$teaching_job = array(4,5,11);
								if(in_array($login_job, $teaching_job)){
							?>
							<a role="button" class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(4).'/classroom/add');?>">添加班级</a>
							<?php }?>

							<span>班级总数:共<em style="color:red"><?php echo $classroom_info['count'];?></em>个班</span>
							<div style="float:right;margin-right:30px;">	
								<span>请选择:</span>
								<span class="input-icon">
									<select class="form-control" name="class_status">
										<option value="">全部</option>
										<option <?php if(isset($classroom_info['status']) && $classroom_info['status'] == 1){ echo 'selected=selected';}?> value="1">正在上课</option>
										<option <?php if(isset($classroom_info['status']) && $classroom_info['status'] == 2){ echo 'selected=selected';}?> value="2">已结课</option>
									</select>
								</span>
								<span>讲师:</span>
								<span class="input-icon">
									<select class="form-control" name="teacher">
										<option value="">请选择讲师</option>
										<?php foreach ($teach as $key => $value) { ?>
											<option <?php if ($value['employee_id']==$teacher) {echo 'selected';}?> value="<?php echo $value['employee_id']; ?>"><?php echo $value['employee_name'];?></option>
										<?php } ?>
									</select>
								</span>
								<span>开班年月:</span>
								<select name="selectYear" id="selectYear" style="width:70px;">
									
								</select>年
								
								<select name="selectMonth" id="selectMonth" style="width:70px;">
									
								</select>月
								<span class="input-icon">
									<button data-event="searchClass" class="btn btn-xs btn-primary">搜索</button>
								</span>
							</div>	
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="tagMenu">
									<ul class="menu">
										<li <?php echo $type=='index' ? 'class="current"': '' ?>><a href="<?php echo site_url(module_folder(4).'/classroom/index/index') ?>">全部班级</a></li>
										<?php foreach ($all_type as $value) { ?>
											<li <?php echo $type==$value['classroom_type_id'] ? 'class="current"': '' ?>><a href="<?php echo site_url(module_folder(4).'/classroom/index/'.$value['classroom_type_id'])?>"><?php echo $value['classroom_type_name']; ?></a></li>
										<?php } ?>
									</ul>
							    </div>
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">序号</th>
														<th class="center">班级名称</th>
														<th class="center">班级群号</th>
														<th class="center">讲师</th>
														<th class="center">上课地点</th>
														<th class="center">上课时间</th>
														<th class="center">开班日期</th>
														<th class="center">结课日期</th>
														<?php if(in_array($login_job, array(2))){?>
														<th class="center">课程进度</th>
														<?php } ?>
														<th class="center">学生总数</th>
														<th class="center">操作</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($classroom_info['list'] as $key => $value) {?>
													
													<tr>
														<td class="center">
															<?php echo $value['serial_number']; ?>
														</td>
														<td class="center">
															<?php echo $value['classroom_name']; ?>
														</td>
														<td class="center">
															<?php echo $value['classroom_group']; ?>
														</td>
														<td class="center">
															<?php echo $value['employee']['employee_name'];?>
														</td>
														<td class="center">
															<?php echo $value['class_address']; ?>
														</td>
														<td class="center"> 
															<?php echo $value['class_time']; ?>
														</td>
														<td class="center">
															<?php echo date('Y-m-d',$value['open_classtime']); ?>
														</td>
														<td class="center">
															<?php echo isset($value['close_classtime']) ? date('Y-m-d',$value['close_classtime']) : ''; ?>
														</td>
														<?php if(in_array($login_job, array(2))){?>
														<td class="center">
															<?php
																if(!empty($value['cls_known'])){
																	$str = '';
																	foreach ($value['cls_known'] as $k => $v) {
																		if($v['schedule_state']==0){
																			$str .= '<span class="font_red">'.$v['knowledge_name'].'</span>';
																			$str .= '&nbsp;&nbsp;&nbsp;';
																		}else if($v['schedule_state']==1){
																			$str .= '<span class="font_blue">'.$v['knowledge_name'].'</span>';
																			$str .= '&nbsp;&nbsp;&nbsp;';
																		}else if($v['schedule_state']==2){
																			$str .= '<span>'.$v['knowledge_name'].'</span>';
																			$str .= '&nbsp;&nbsp;&nbsp;';
																		}
																	}
																	echo $str;
																}
															?>			
														</td>
														<?php } ?>
														<td class="center">
															<?php echo $value['student_count'];?>
														</td>
														
														<td class="center">
															<a href="<?php echo site_url(module_folder(4).'/classroom/classroomStudent/index/'.$value['classroom_id']); ?>" class="btn btn-xs btn-warning" role="button">学生列表</a>
															<?php if(in_array($login_job, $teaching_job)){?>
															<?php if ($value['class_status']==1) {?>
																<a href="" class="btn btn-xs btn-pink" role="button" data-toggle="modal" data-target="#upgradeClass" onclick="wdcrm.set_id('upclass_id',<?php echo $value['classroom_id']?>)">升级班级</a>
															<?php } ?>	
															<?php if ($value['class_status']==2) {?>
																<a href="" class="btn btn-xs" role="button">已结课</a>
															<?php }else{ ?>
															<a href="" class="btn btn-xs btn-purple" role="button" data-toggle="modal" data-target="#close_class" onclick="wdcrm.set_id('classroom_id',<?php echo $value['classroom_id']?>)">结课</a>
															<?php }?>
															<a href="<?php echo site_url(module_folder(4).'/classroom/edit/'.$value['classroom_id']); ?>" class="btn btn-xs btn-info" role="button">修改</a>
															<?php }?>
														</td>
													</tr>
												<?php } ?>	
												</tbody>
											</table>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $classroom_info['page'];?>
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
		
		<!--模态框（弹出升级班级信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="upgradeClass" style="display: none;">
		  	<div class="modal-dialog">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">升级班级</h4>
		          	</div>
		          	<form name="upgrade" action="<?php echo site_url(module_folder(4).'/classroom/upgradeClass');?>" method="post">
		          		<input type="hidden" id="upclass_id" name="upclass_id" value="" />
						<div class="modal-body">
							<table cellpadding="5px">
								<tr>
									<td class="col-sm-2">升级班级名称:</td>
									<td class="col-sm-8">
										<input type="text" name="upgrade_name" placeholder="请输入班级名称" required>
										<span id="showname"></span>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">班级类型:</td>
									<td class="col-sm-8">
										<select class="form-control" name="classroom_type_id" required style="width:187px;">
											<option value="">请选择班级类型</option>
											<?php foreach ($classroom_type as $key => $value) { ?>
												<option <?php if ($value['classroom_type_id']==$classroom_info['select_type']) { echo 'selected'; }?> value="<?php echo $value['classroom_type_id']; ?>"><?php echo $value['classroom_type_name'];?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
							</table>
						</div>
			          	<div class="modal-footer"> 
			          		<input class="btn btn-info" type="submit" value="提交" />
				            <button data-dismiss="modal" class="btn" type="button">取消</button>
				        </div>
			        </form>
		        </div>
		  	</div>
		</div>

		<!--模态框（弹出结课时间信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="close_class" style="display: none;">
		  	<div class="modal-dialog">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">结课</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(4).'/classroom/closeClass');?>" method="post">
		          		<input type="hidden" id="classroom_id" name="classroom_id" value="" />
						<div class="modal-body ">
							<p>是否确定要结课</p>
							<table cellpadding="5px">
								<tr>
									<td class="col-sm-2">结课时间:</td>
									<td class="col-sm-8">
										<input class="form-control date-picker"  data-target="#dateShow" style="width:150px" type="text" name="close_classtime" value="<?php echo date('Y-m-d');?>" data-date-format="yyyy-mm-dd" />
									</td>
								</tr>
							</table>
						</div>
			          	<div class="modal-footer"> 
			          		<input class="btn btn-info" type="submit" value="提交" />
				            <button data-dismiss="modal" class="btn" type="button">取消</button>
				        </div>
			        </form>
		        </div>
		  	</div>
		</div>

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
			jQuery(function($){	
	            //选项卡
	            $('.menu').find('li').click(function(){
	                $('.menu').find('li').removeClass('current');		
	                $(this).addClass('current');			
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
			//搜索班级名称
			jQuery(function($){

				var url='<?php echo site_url(module_folder(4).'/classroom/index/index');?>';

				$('form[name="classroom_search"]').submit(function(){
					var search=$.trim(this.elements['search'].value);

					if (search!='') {
						//var key= $('select[name="key"] option:selected').val();
						window.location.href=url+'?search='+search;
					};	
					return false;
				});

			});
			jQuery(function($){
				//搜索班级
				$('button[data-event="searchClass"]').click(function(){

					var class_status = $('select[name="class_status"] option:selected').val();

					var teacher = $('select[name="teacher"] option:selected').val();

					var selectYear = $('select[name="selectYear"] option:selected').val();

					var selectMonth = $('select[name="selectMonth"] option:selected').val();

					//var url= window.location.href;
					var url='<?php echo site_url(module_folder(4).'/classroom/index/index');?>';
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

					delete arr.class_status;
					delete arr.teacher;
					delete arr.selectYear;
					delete arr.selectMonth;
					if(arr.per_page){
						delete arr.per_page;
					}
					var z=url+'?status='+class_status+'&teacher='+teacher+'&year='+selectYear+'&month='+selectMonth;
					
					window.location.href=z;
				});

			});
		//搜索班级类型
		jQuery(function($){

			$('#classtype').change(function(){

				var type_id= this.value;
				//var url= window.location.href;
				var url='<?php echo site_url(module_folder(4).'/classroom/index/index');?>';
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
				delete arr.classtype;
				if(arr.per_page){
					delete arr.per_page;
				}
				var par='';
				for(var k in arr){
					par+=k+'='+arr[k]+'&';
				}
				
				var res= url+'?'+par;
				
				var z=res+'classtype='+type_id;
				window.location.href=z;

			});

		});

		jQuery(function(){
			$('form[name="upgrade"]').submit(function(){

 					//判断是否重复名
 					var result=true;
		        	var name=$.trim($('input[name="upgrade_name"]').val());
		        	
						$.ajax({
							async: false,
						    type: "POST",
						    url: "<?php echo site_url(module_folder(4).'/classroom/check');?>",
						    data: 'value='+name,
						    dataType:'json',
						   	success: function(res){
					        	if (res.status===1) {
					        		$('#showname').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">班级'+name+'已存在</div>');
					        		result=false;
					        	}else if(res.status==0){
					        		$('#showname').html('');
					        	}
					        }
	   					});
					return result;
 				});	
 		});	
		jQuery(function(){

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