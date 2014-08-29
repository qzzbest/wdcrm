<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>客户列表</title>
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
										<option <?php if(isset($select_day) && $select_day==1) { echo 'selected'; }?> value="1">接单日期</option>
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
							<?php echo $admin_info['count'];?>
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
							<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(2).'/client/changeStatus');?>" name="delete">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php 
								$login_job = getcookie_crm('employee_job_id');
								$employee_arr = array(2,11);
								?>
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<?php if(in_array($login_job, $employee_arr)){?>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<?php }?>
														<th class="center">序号</th>
														<th class="center">接单日期</th>
														<th class="center">姓名</th>
														<th class="center">性别</th>
														<th class="center hidden-480">手机</th>
														<th class="center">QQ</th>
														<th class="center">邮箱</th>
														<?php if(in_array($login_job, $employee_arr)){?>
														<th>操作</th>
														<?php }?>
														<th>状态</th>
														<?php if(getcookie_crm('employee_power')==1){?>
														<th>咨询师</th>
														<?php }?>
													</tr>
												</thead>

												<tbody>
												<?php foreach($admin_info['list'] as $item){ ?>
													<tr>
														<?php if(in_array($login_job, $employee_arr)){?>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" name="checkbox_consultant[]" value="<?php echo $item['consultant_id'];?>" />
																<span class="lbl"></span>
															</label>
														</td>
														<?php }?>
														<td class="center"><?php echo $item['serial_number'];?></td>
														
														<td class="center">
															<?php 
															if($changeType=='consultant_set_view'&&$changeData=='1'){
																echo date('Y-m-d',$item['consultant_set_view_time']);
															}else{
																if(!empty($item['consultant_firsttime']) ){
																	echo date('Y-m-d',$item['consultant_firsttime']);
																}
															}
															?>
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
															<?php
																if( !empty($item['email']) ){
																	foreach ($item['email'] as $key => $value) {
																		echo $value.'<br />';
																	}
																}
															?>
														</td>
														
														<?php if(in_array($login_job, $employee_arr)){?>
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a class="btn btn-xs btn-primary" href="<?php echo site_url(module_folder(2).'/consultant_record/index/'.$item['consultant_id'].'/client');?>" role="button">咨询记录</a>
																<a class="btn btn-xs" href="<?php echo site_url(module_folder(2).'/consultant_record/add/'.$item['consultant_id'].'/client');?>" role="button">添加咨询记录</a>
																<?php if(!empty($item['message'])){?>
																<a class="btn btn-xs btn-info consultant_remind_edit" role="button" data-target="#remindModal" data-toggle="modal" onclick="wdcrm.set_id('remind_consultant_id',<?php echo $item['consultant_id']?>)"  data="<?php echo $item['consultant_id'];?>">查看提醒</a>
																<?php }else{?>
																	<a class="btn btn-xs btn-info consultant_remind_add" role="button" data-target="#remindModal" data-toggle="modal" data="<?php echo $item['consultant_id'];?>" onclick="wdcrm.set_id('remind_consultant_id',<?php echo $item['consultant_id']?>)">添加提醒</a>
																<?php }?>
																
																<a href="<?php echo site_url(module_folder(2).'/client_project/index/'.$item['consultant_id']);?>" class="btn btn-xs btn-purple" role="button">项目情况</a>
																<a href="<?php echo site_url(module_folder(2).'/project_payment/index/'.$item['consultant_id']);?>" class="btn btn-xs btn-success" role="button">缴费记录</a>

																<button type="button" class="btn btn-xs btn-warning advisory_info" data-toggle="modal" data-target="#advisory_info" data="<?php echo $item['consultant_id'];?>">详细信息</button>
																<!-- <button type="button" data="<?php //echo $item['consultant_id'];?>" class="btn btn-xs btn-info consultant_edit">编辑</button> -->
																
																
															</div>

															<div class="visible-xs visible-sm hidden-md hidden-lg">
																<div class="inline position-relative">
																	<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
																		<i class="icon-cog icon-only bigger-110"></i>
																	</button>

																	<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
																		<li>
																			<a href="#" class="tooltip-info" data-rel="tooltip" title="View">
																				<span class="blue">
																					<i class="icon-zoom-in bigger-120"></i>
																				</span>
																			</a>
																		</li>

																		<li>
																			<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
																				<span class="green">
																					<i class="icon-edit bigger-120"></i>
																				</span>
																			</a>
																		</li>

																		<li>
																			<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
																				<span class="red">
																					<i class="icon-trash bigger-120"></i>
																				</span>
																			</a>
																		</li>
																	</ul>
																</div>
															</div>
														</td>
														<?php }?>

														<td>
															<?php if($item['refund']==1){
																echo '<font color="red" style="font-weight:bold;">退费</font>';
															}else{
																echo '&nbsp;';
															}?>
														</td>	

														<?php if(getcookie_crm('employee_power')==1){?>
														<td><b><?php echo $item['employee_name']['employee_name'];?></b></td>
														<?php }?>
													</tr>
													<?php }?>

												</tbody>
											</table>
											<?php if(in_array($login_job, $employee_arr)){?>
											<a class="btn btn-xs btn-danger" id="delete_consultant_all" role="button">删除</a>
											<?php }?>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $admin_info['page'];?>
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

		<!--模态框（弹出提醒信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="remindModal" style="display: none;">
		  	<div class="modal-dialog" style="width:586px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">提醒<span style="float:right;padding-right:10px;" class="del_remind"></span></h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(2).'/remind/consultantRemind');?>" method="post" id="con_remind">
			          	<input type="hidden" id="remind_consultant_id" name="remind_consultant_id" value="" />
			          	<input type="hidden" class="time_remind_id" name="time_remind_id" value="" />
			      		<input type="hidden" class="client" name="client" value="client" />

						<div class="modal-body ">
						<div class="cinfo" style="padding:0px 20px 20px 13px; font-size:13px;"></div>
						<table cellpadding="5px">
							<tr>
								<td class="col-sm-2">提醒内容</td>
								<td class="col-sm-8">
									<textarea style="height:100px;" id="remind_content" class="form-control" name="remind_content" placeholder="请输入提醒内容" required oninvalid="setCustomValidity('请输入提醒内容');" oninput="setCustomValidity('');"></textarea>
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">提醒时间</td>
								<td>
									<div class="col-sm-6">
										<div class="input-group">
											<input class="form-control date-picker" id="id-date-picker-1" type="text" name="remind_date" data-date-format="yyyy-mm-dd" />
											<span class="input-group-addon">
												<i class="icon-calendar bigger-110"></i>
											</span>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="input-group bootstrap-timepicker">
											<input id="timepicker1" type="text" name="remind_time" class="form-control"/>
											<span class="input-group-addon">
												<i class="icon-time bigger-110"></i>
											</span>
										</div>
									</div>
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
		<!--模态框（弹出 咨询者的详细信息信息）-->
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="advisory_info" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="youModalLabel" class="modal-title">客户信息</h4>
		          	</div>
		          	<div class="modal-body">    
		          	</div>
		          	<div style="padding-left:20px;" id="ad_info"></div>
		          	<div class="modal-footer">
			            <button data-dismiss="modal" class="btn btn-info" type="button">确定</button>
			        </div>
		        </div>
		  	</div>
		</div>

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
				$("#delete_consultant_all").on(ace.click_event, function() {
					//检测有多少个被选中了，0个删除不弹出确定框。
					var length= $('input[name="checkbox_consultant[]"]:checked').length;
					if(length>0){
						bootbox.confirm("你确定删除吗?", function(result) {
							if(result) {
								document.forms['delete'].submit();
							}
						});
					}
				});
			});

		//----------------------------------------------------------------	

			jQuery(function($){

				//ajax获取用户信息		
				$('.advisory_info').click(function(){
					var consultant_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/client/info');?>",
				        data: "id="+consultant_id,
				        dataType:'json',
				        success: function(res){
				        	//如果结果不对，不处理
				        	if(res.status==0){return ;}

				       		$("#advisory_info").find('.modal-body').html(res.data);
				       		$("#ad_info").html('<a href="'+res.info_url+'">修改客户信息 >></a>'); 
				        }
			   		});
				});

				//ajax获取提醒信息		
				$('.consultant_remind_edit').click(function(){
					var consultant_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/remind/remindConsultantInfo/client');?>",
				        data: "id="+consultant_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==0){return ;}
				       		$("#remind_content").html(res.data['time_remind_content']);
				       		$("#id-date-picker-1").val(res.data['day']);
				       		$("#timepicker1").val(res.data['time']); 
				       		$(".del_remind").html(res.str); 
				       		$(".time_remind_id").val(res.data['time_remind_id']);
				       		$(".cinfo").html(res.consultantinfo).show(); 
				        }
			   		});
				});

				//添加提醒清空
				$('.consultant_remind_add').click(function(){

					var consultant_id=parseInt($(this).attr("data"));
					var con_remind = document.getElementById('con_remind');
				    con_remind.reset();
				    $("#id-date-picker-1").val("<?php echo date('Y-m-d');?>");
				    $("#timepicker1").val("<?php echo date('H:i:s');?>");	
				    $(".del_remind").html(""); 
					$("#remind_content").html("");		       		
		       		$(".time_remind_id").val("");
		       		$(".cinfo").html("");	

		       		$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/advisory/consultantInfo');?>",
				        data: "con_id="+consultant_id,
				        dataType:'json',
				        success: function(res){
				        	$(".cinfo").html(res.info);
				        }
			   		});				
				});

				//点击跳转到编辑页面
				$('.consultant_edit').click(function(){
					var edit_id=$(this).attr('data');
					window.location.href="<?php echo site_url(module_folder(2).'/advisory/edit');?>"+'/'+edit_id;
				});

				//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
					$('.datepicker').css('z-index',1060);
				
				});
				$('#id-date-picker-1').focus(function(){
					$('.datepicker').css('z-index',1060);

				});
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
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

				/**
	 			 * 添加应缴和已缴学费输入框
	 			 * @param string 选中的元素 一个id值
	 			 * @param string 需要追加的内容，放置到了textarea里面
	 			 *
	 			 */

	 			function checkTotal(name){
		 			var _this=this;

					//初始绑定,鼠标移开，校验数据
					this.name=name;
					$('input[name="'+name+'"]').bind('blur',function(){_this.blur_check(this);});
				}
				
			});

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
						ur='<?php echo site_url(module_folder(2).'/client/index/index/0');?>';
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
			//搜索咨询者的相关信息
			jQuery(function($){
				
				var url='<?php echo site_url(module_folder(2).'/client/index/index/0');?>';
				$('form[name="advisory_search"]').submit(function(){
					var search=$.trim(this.elements['search'].value);

					if (search!='') {
						var key= $('select[name="key"] option:selected').val();
						window.location.href=url+'?key='+key+'&search='+search;

					};	
					return false;
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
