<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>评分管理</title>
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
					<div class="breadcrumbs">
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
							</ul>
							<button type="button" onclick="change()" class="btn btn-xs btn-primary" style="margin:0px 50px;">评分标准</button>
						<span style="font-size:16px;margin-left:70px;font-weight:bold;">|员工列表|</span>
			
						<?php $this->load->view('search_content');?>	
					</div>
					<div id="biaozhun" style="width:1000px;height:auto;background-color:#f2f2f2;position:absolute;top:50px;left:200px;border:2px solid #6fb3e0; display:none;z-index:99;margin-bottom:100px;">
					<h3 style="text-align:center;">员工评分标准</h3>
					<!-- table开始 -->
					<table class="table table-striped table-bordered ">
					<tr>
					<th colspan='2'>
					评分总则
					</th>
					</tr>
					<?php if(isset($stand_list[0])){
							foreach($stand_list[0] as $item){	?>
					<tr>
					<td colspan='2' height="30px"><?php	echo $item['content']; ?></td>
					</tr>
					<?php } }  ?>

					<tr>
					<th colspan='2'>
					加分细则
					</th>
					</tr>
					<tr>
					<td>项目</td><td>备注</td>			
					</tr>
					<?php if(isset($stand_list[1])){
							foreach($stand_list[1] as $item){	?>
					<tr>
					<td><?php echo $item['content']; ?></td><td><?php echo $item['remark']; ?></td>		
					</tr>
					<?php } }  ?>

					<tr>
					<th colspan='2'>
					减分细则
					</th>
					</tr>
					<tr>
					<td width="60%">项目</td><td>备注</td>			
					</tr>

					<?php if(isset($stand_list[2])){
							foreach($stand_list[2] as $item){	?>
					<tr>
					<td><?php echo $item['content']; ?></td><td><?php echo $item['remark']; ?></td>		
					</tr>
					<?php } }  ?>
					</table>
					<!-- table结束 -->
					<?php $power=getcookie_crm('mark_power');
						if($power==2){
					?>
					<button type="button" class="btn btn-xs btn-primary" onclick="edit()">编辑评分标准</button>
					<?php } ?>
					<button type="button" class="btn btn-xs btn-primary" style="float:right;" onclick="closen()">关闭</button>
					</div>

					<div class="page-content">
						<div class="page-header" style="padding-bottom:40px;">
							
							<div style="float:right;margin-right:30px;">		
								<span>职位:</span>
								<select name="teach" id="changejob" style="width:91px;">
									<option value=" ">全部</option>
									<?php foreach($employee_job as $item){ ?>
									<option  <?php 
										if ($item['employee_job_id']==$selected_job) {
											echo 'selected';
										}

									?>  value="<?php echo $item['employee_job_id'];?>"><?php echo $item['employee_job_name'];?></option>
									<?php } ?>
								</select>
							</div>

							<div style="float:right;margin-right:30px;">		
								<span>查询日期:</span>
								<select name="selectYear" id="selectYear" style="width:70px;">
									
								</select>年
								
								<select name="selectMonth" id="selectMonth" style="width:70px;">
									
								</select>月
								<span class="input-icon">
									<button data-event="searchDate" class="btn btn-xs btn-primary">搜索</button>
								</span>
							</div>
					
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<form  name="delete" action="<?php echo site_url(module_folder(1).'/admin/delete');?>" method="post">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
												
														<th>用户名</th>
														<th>所属角色</th>
														<th>本月累计积分</th>
														<th>
															<i class="icon-time bigger-110"></i>
															最后评分时间
														</th>
														<th>真实姓名</th>
														<th>操作</th>
													</tr>
												</thead>

												<tbody>
												<?php foreach ($list as $value) {?>		
													<?php $item=$value['state']['s']; 
														if($item>0){
															echo "<tr class='imp'>";
														}else{
															echo "<tr>";
														}
												?>	
														<td>
															<a href="#" role="button" data-target="#youModal" data-toggle="modal" class="userinfo" uid="<?php echo $value['employee_id'];?>"><?php echo $value['admin_name'];?></a>
														</td>
														<td><?php echo $value['employee_job_name'];?></td>
														<td><?php echo isset($value['inte']['c']) ? $value['inte']['c'] : '0';?></td>
														<td><?php echo isset($value['last_mark']['t']) ? date("Y-m-d H:i:s",$value['last_mark']['t']) : '';?></td>
														<td><?php echo $value['employee_name'];?></td>
														<td>		
															<?php 
															$power=getcookie_crm('mark_power');
															$employee_power=getcookie_crm('employee_power');
															if($employee_power==$value['employee_power'] || $employee_power == 1){
																	if($power>0){
																?>
																<a class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(5).'/marking/edit/'.$value['employee_id']);?>" role="button">评分</a>
												
																<?php }	?>
																<a class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(5).'/marking/detail/'.$value['employee_id']);?>" role="button">积分详情</a>
															<?php }?>
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
			});

			jQuery(function($){
				//搜索班级
				$('button[data-event="searchDate"]').click(function(){

					var selectYear = $('select[name="selectYear"] option:selected').val();

					var selectMonth = $('select[name="selectMonth"] option:selected').val();

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

					delete arr.selectYear;
					delete arr.selectMonth;
					if(arr.per_page){
						delete arr.per_page;
					}
					var z=url+'?year='+selectYear+'&month='+selectMonth;
					
					window.location.href=z;
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
		<script>
		function change(){
			$("#biaozhun").show();
		}

		function closen(){
			$("#biaozhun").hide();
		}

		function edit(){
			window.location.href="<?php echo site_url(module_folder(5).'/marking/standard'); ?>";
		}
		</script>
</body>
</html>
