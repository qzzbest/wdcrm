<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>市场列表</title>
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
										<span>登记日期:</span>
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
						<div class="nav-search" id="nav-search">
							<form name="market_search" class="form-search" action="" method="get">
								<span class="input-icon">
									<select class="form-control" name="key">
										<option <?php if(isset($market_info['key']) && $market_info['key'] == 'school'){echo 'selected=selected';}?> value="school">学校</option>
									</select>
								</span>
								<span class="input-icon">
									<input type="text" name="search" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" value="<?php if(isset($market_info['search']))echo $market_info['search'];?>" />
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
							<a role="button" class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(6).'/market/add');?>">添加市场资源</a>
							<span>总数：<em style="color:red; font-size:16px; font-weight:bold;"><?php echo $market_info['count'];?></em></span>
							&nbsp;&nbsp;&nbsp;
							<div style="display: inline-block;margin-left:20px;">
								<span>日期:</span>
								<label><input type="radio" value="0" name="order" <?php if(isset($order) && $order == 0){echo 'checked=checked';}?> class="sel_order ace" /><span class="lbl">升序</span></label>
								<label><input type="radio" value="1" name="order" <?php if(isset($order) && $order == 1){echo 'checked=checked';}?> class="sel_order ace" /><span class="lbl">降序</span></label>
							</div>
							<?php if(getcookie_crm('employee_power')==1){?>
							<div style="float:right;margin-right:28px;">		
								<span>市场专员:</span>
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
							<?php } ?>
						</div>
						<div class="row">
							<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(6).'/market/changeStatus');?>" name="delete">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th class="center">序号</th>
														<th class="center">登记日期</th>
														<th class="center">学校</th>
														<th class="center">学历性质</th>
														<th class="center">学期分配</th>
														<th class="center">区域</th>
														<th class="center">校区地址</th>
														<th>操作</th>
														<?php if(getcookie_crm('employee_power')==1){?>
														<th>市场专员</th>
														<?php } ?>

													</tr>
												</thead>

												<tbody>
												<?php foreach ($market_info['list'] as $key => $value) { ?>
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" name="checkbox_market[]" value="<?php echo $value['market_id'];?>" />
																<span class="lbl"></span>
															</label>
														</td>
														<td class="center"><?php echo $value['serial_number']; ?></td>
														<td class="center"><?php echo date('Y-m-d',$value['login_date']); ?></td>
														<td class="center"><?php echo $value['school']; ?></td>
														<td class="center"><?php echo $value['education']; ?></td>
														<td class="center"><?php echo $value['term']; ?></td>
														<td class="center"><?php echo $value['area']; ?></td>
														<td class="center"><?php echo $value['address']; ?></td>
														
														<td>
															<a class="btn btn-xs btn-primary" href="<?php echo site_url(module_folder(6).'/market_record/index/'.$value['market_id']); ?>" role="button">咨询记录</a>
															<a class="btn btn-xs" href="<?php echo site_url(module_folder(6).'/market_record/add/'.$value['market_id']); ?>" role="button">添加咨询记录</a>
															<?php if(!empty($value['message'])){?>
															<a class="btn btn-xs btn-info market_remind_edit" role="button" data-target="#remindModal" data-toggle="modal" onclick="wdcrm.set_id('market_id',<?php echo $value['market_id']?>)"  data="<?php echo $value['market_id'];?>">查看提醒</a>
															<?php }else{?>
																<a class="btn btn-xs btn-info market_remind_add" role="button" data-target="#remindModal" data-toggle="modal" onclick="wdcrm.set_id('market_id',<?php echo $value['market_id']?>)" data="<?php echo $value['market_id'];?>">添加提醒</a>
															<?php }?>
															<!-- <a class="btn btn-xs btn-success" role="button" data-target="" data-toggle="modal" >设为客户</a> -->
															<a class="btn btn-xs btn-warning market_info" role="button" data-toggle="modal" data-target="#market_info" data="<?php echo $value['market_id'];?>">详细信息</a>
														</td>
														<?php if(getcookie_crm('employee_power')==1){?>
														<td><?php echo $value['employee']['employee_name'];?></td>
														<?php }?>
													</tr>
												<?php } ?>	
												</tbody>
											</table>
											<a class="btn btn-xs btn-danger" id="delete_market_all" role="button">删除</a>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $market_info['page'];?>
											<div style="float:right;">
												<input type="text" name="pagetiao" id="pagetiao" style="width:30px;text-align:center;" value="<?php if(!empty($cur_pag)){echo $cur_pag;}?>">
												<input type="button" class="btn btn-sm btn-info" id="tiaozhuan" value="跳转">
											</div>
										</div>
									</div>
								</div><!-- /row -->
								
								

							</div><!-- /.col -->
							</form><!-- /批量删除 -->
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
		          	<form action="<?php echo site_url(module_folder(6).'/remind/marketRemind');?>" method="post" id="market_remind">
			          	<input type="hidden" id="market_id" name="market_id" value="" />
			          	<input type="hidden" class="time_remind_id" name="time_remind_id" value="" />
			      						
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
								<td class="col-sm-2">提醒备注</td>
								<td class="col-sm-8">
									<textarea style="width:419px; height:50px;" class="remind_remark" id="form-field-1" name="remind_remark" placeholder="请输入提醒备注"></textarea>
								</td>
							</tr>

							<!--<tr>
								<td class="col-sm-2">&nbsp;</td>
								<td class="col-sm-8">
									 <label>
									<input type="checkbox" name="check_set_view" value="1" class="ace" />
									<span class="lbl">要上门的</span>
									<input type="hidden" name="is_set_view" value="0" />
									</label>
									&nbsp;&nbsp;&nbsp; 
									<label>
									<input type="checkbox" name="check_important" value="1" class="ace" />
									<span class="lbl">重点跟进的</span>
									<input type="hidden" name="is_important" value="0" />
									</label>
								</td>
							</tr>-->

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

		<!--模态框（弹出详细信息）-->
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="market_info" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="youModalLabel" class="modal-title">详细信息</h4>
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
			//搜索
			jQuery(function($){
				
				var url='<?php echo site_url(module_folder(6).'/market/index');?>';
				$('form[name="market_search"]').submit(function(){
					var search=$.trim(this.elements['search'].value);

					if (search!='') {
						var key= $('select[name="key"] option:selected').val();
						window.location.href=url+'?key='+key+'&search='+search;

					};	
					return false;
				});

			});
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
				$("#delete_market_all").on(ace.click_event, function() {
					//检测有多少个被选中了，0个删除不弹出确定框。
					var length= $('input[name="checkbox_market[]"]:checked').length;
					if(length>0){
						bootbox.confirm("你确定删除吗?", function(result) {
							if(result) {
								document.forms['delete'].submit();
							}
						});
					}
				});
				//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					
					$(this).prev().focus();
					$('.datepicker').css('z-index',1060);
				
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
				//ajax获取用户信息		
				$('.market_info').click(function(){
					var market_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(6).'/market/info');?>",
				        data: "id="+market_id,
				        dataType:'json',
				        success: function(res){
				        	//如果结果不对，不处理
				        	if(res.status==0){return ;}

				       		$("#market_info").find('.modal-body').html(res.data);
				       		$("#ad_info").html('<a href="'+res.info_url+'">修改信息 >></a>'); 
				        }
			   		});
				});

				//ajax获取提醒信息		
				$('.market_remind_edit').click(function(){
					var market_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(6).'/remind/remindMarketInfo');?>",
				        data: "id="+market_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==0){return ;}
				       		$("#remind_content").html(res.data['time_remind_content']);
				       		$("#id-date-picker-1").val(res.data['day']);
				       		$("#timepicker1").val(res.data['time']); 
				       		$(".del_remind").html(res.str); 
				       		$(".time_remind_id").val(res.data['time_remind_id']);
				       		$(".remind_remark").val(res.data['remind_remark']); 

				       		// if(res.data['is_set_view'] == 1){
				       		// 	$('input[name="is_set_view"]').val(1);
				       		// 	$('input[name="check_set_view"]').prop('checked',true);
				       		// }

				       		if(res.data['is_important'] == 1){
				       			$('input[name="is_important"]').val(1);
				       			$('input[name="check_important"]').prop('checked',true);
				       		}

				       		$(".cinfo").html(res.marketinfo).show(); 
				        }
			   		});
				});
				//添加提醒清空
				$('.market_remind_add').click(function(){

					var market_id=parseInt($(this).attr("data"));
					var market_remind = document.getElementById('market_remind');
				    market_remind.reset();
					$(".del_remind").html(""); 
					$("#remind_content").html("");
		       		$("#id-date-picker-1").val("<?php echo date('Y-m-d');?>");
		       		$("#timepicker1").val("<?php echo date('H:i:s');?>");
		       		$(".time_remind_id").val("");
				    $(".cinfo").html("");

				    // $('input[name="is_set_view"]').val(0);
		       		$('input[name="is_important"]').val(0);

				    $.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(6).'/market/marketInfo');?>",
				        data: "market_id="+market_id,
				        dataType:'json',
				        success: function(res){
				        	$(".cinfo").html(res.info);
				        }
			   		});

				});

				$('#remindModal').on('click','input[name="check_important"]',function() {
					if(this.checked){
						$(this).siblings('input[name="is_important"]').val(1);
					}else{
						$(this).siblings('input[name="is_important"]').val(0);
					}
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
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'&start_time='+start_time+'&end_time='+end_time;
					
					window.location.href=z;
									
				});

			});

			jQuery(function($){
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
			});
		</script>
</body>
</html>
