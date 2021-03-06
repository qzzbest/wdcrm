<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>咨询者列表</title>
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
							<a role="button" class="btn btn-xs btn-info" href="<?php echo site_url(module_folder(2).'/advisory/add');?>">添加咨询者</a>
							<?php }?>

							<span>总人数是：<em style="color:red; font-size:16px; font-weight:bold;"><?php echo $admin_info['count'];?></em> 人</span>
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
							<?php }?>
							
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
														<?php if(in_array($login_job, $employee_arr)){?>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<?php }?>
														<th class="center">序号</th>
														<th class="center">
															<?php if($changeType=='consultant_set_view'&&$changeData=='1'){?>
															上门日期
															<?php }else{ ?>
															咨询日期
															<?php }?>
														</th>
														<th class="center">姓名</th>
														<th class="center">性别</th>
														<th class="center hidden-480">手机</th>
														<th class="center">QQ</th>
														<th class="center">邮箱</th>
														<?php if(in_array($login_job, $employee_arr)){?>
														<th>操作</th>
														<?php }?>
														<th>咨询师</th>
														<?php //if(getcookie_crm('employee_power')==1){?>
														
														<?php //}?>

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
																<a class="btn btn-xs btn-primary" href="<?php echo site_url(module_folder(2).'/consultant_record/index/'.$item['consultant_id']);?>" role="button">咨询记录</a>
																<a class="btn btn-xs" href="<?php echo site_url(module_folder(2).'/consultant_record/add/'.$item['consultant_id']);?>" role="button">添加咨询记录</a>
																<?php if(!empty($item['message'])){?>
																<a class="btn btn-xs btn-info consultant_remind_edit" role="button" data-target="#remindModal" data-toggle="modal" onclick="wdcrm.set_id('remind_consultant_id',<?php echo $item['consultant_id']?>)"  data="<?php echo $item['consultant_id'];?>">查看提醒</a>
																<?php }else{?>
																	<a class="btn btn-xs btn-info consultant_remind_add" role="button" data-target="#remindModal" data-toggle="modal" data="<?php echo $item['consultant_id'];?>" onclick="wdcrm.set_id('remind_consultant_id',<?php echo $item['consultant_id']?>)">添加提醒</a>
																<?php }?>
																<!-- 点击弹出一个确定框，点击确定就是上门(如果是设为学员了，那么就没有这项) -->
																<?php if($item['is_student'] == 0){?>
																	<a class="btn btn-xs btn-pink" role="button" data-target="#setView" data-toggle="modal" data="<?php echo $item['consultant_id'];?>">
																		<?php
																			if ($item['consultant_set_view']==0) {
																				echo '未上门';
																			}else{
																				echo '已上门';
																			}
																		?>
																	</a>
																<?php }?>
																
																<?php if($item['is_student'] == 0){?>
																	<a class="btn btn-xs " role="button" data-target="#inputModal" data-toggle="modal" onclick="wdcrm.set_id('consultant_id',<?php echo $item['consultant_id']?>)">设为学员</a>
																<?php }?>
																
																<?php if($item['is_client'] == 0){?>
																<a class="btn btn-xs btn-success" role="button" data-target="#client_inputModal" data-toggle="modal" onclick="wdcrm.set_id('consultant_id',<?php echo $item['consultant_id']?>)">设为客户</a>
																<?php }?>

																<button type="button" class="btn btn-xs btn-warning advisory_info" data-toggle="modal" data-target="#advisory_info" data="<?php echo $item['consultant_id'];?>">详细信息</button>
																<!-- <button type="button" data="<?php //echo $item['consultant_id'];?>" class="btn btn-xs btn-info consultant_edit">编辑</button> -->
																
																
															</div>

															<!-- <div style="clear:both;"></div>
															<br />
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<button class="btn btn-xs btn-info" role="button" data-target="#intentionCourse" data-toggle="modal" data_type="4" con_id="<?php echo $item['consultant_id'];?>">意向课程</button>
															</div> -->

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
														<?php if(getcookie_crm('employee_power')==1){?>
														<td><b>
														<?php 
														echo $item['employee_name']['employee_name'];
														if(!empty($item['old_employee_name'])){
															echo "（<font color='red'>".$item['old_employee_name']."</font>）";
														}
														?>
														</b></td>
														<?php }else{?>
														<td><b><font color="red"><?php echo $item['old_employee_name'];?></font></b></td>
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
												<input type="text" name="pagetiao" id="pagetiao" style="width:45px;text-align:center;" value="<?php if(!empty($cur_pag)){echo $cur_pag;}?>">
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
		
		<!--模态框（弹出 选课程、缴费信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="inputModal" style="display: none;">
		  	<div class="modal-dialog" style="width:870px;padding-top:100px;padding-bottom:180px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">亲，请先进行缴费</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(2).'/advisory/setStudent');?>" method="post" id="setStudent">
		          	<input type="hidden" id="consultant_id" name="consultant_id" value="" />
		          	<div class="modal-body"><span id="course">选择课程：</span><span style="color: rgb(209, 110, 108); float:right;"></span>
		          			<div>
								<ul id="menu" class="tree-folder-header tree">
									<?php foreach ($course as $key => $value) { ?>
										
										<li>
											<?php if(!empty($value['course_name'][0]['knowledge_name'])){?>

												<i class="icon-plus"></i>
												<input type="checkbox" name="course_name[]"  class="ace" value="<?php echo $value['curriculum_system_id'];?>" id="c_<?php echo $key;?>"  />
												
												<span class="lbl"><label style="cursor:pointer;" for="c_<?php echo $key;?>"> <?php echo $value['curriculum_system_name'];?></label> </span>

											<?php }?>
												
											
											<?php if(!empty($value['course_name'][0]['knowledge_name'])){?>
									    	<ul>
												<?php foreach ($value['course_name'] as $k => $v) {?>
									        		<li class="second">
									        			<input type="checkbox" class="ace" name="knowledge_name[<?php echo $value['curriculum_system_id'];?>][]" value="<?php echo $v['knowledge_id'];?>" />
									        			
									        			<span class="lbl" data-event="click"> <?php echo $v['knowledge_name'];?> </span>
									        		</li>
												<?php }?>
												<div class="clear"></div>
									        </ul>
											<?php }?>
									    </li>

									<?php }?>
								</ul>
							</div>
							
		          	</div>
		          	<div class="modal-body">课程备注：
		          		<!-- <input type="text" name="course_remark" placeholder="根据选择的课程，可添加课程备注" /> -->
		          		<textarea name="course_remark" class="form-control" id="form-field-8" placeholder="根据选择的课程，可添加课程备注"></textarea>
		          	</div>
						
					<div class="modal-body">应缴学费：
			      		<input type="text" name="tuition_total" placeholder="请输入应缴学费"  id="tuition_total" type-data="false" /> 元
			      		<div class="col-sm-5" style="float:right; width:57%"></div>
		  			</div>
					
					<div class="modal-body">学费说明：
						<input type="text" name="payment_desc" placeholder="学费说明" />
		  			</div>
					
					<div class="modal-body">缴费日期：
						<input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="course_payment_time" value="<?php echo date('Y/m/d');?>" placeholder="缴费日期" />
		  			</div>

		  			<div class="modal-body">
		  				<select name="select_type">
							<option value="0">学 费</option>
							<option value="1">定位费</option>
						</select>
		      			<input type="text" name="already_total" placeholder="请输入学费"  id="already_total" /> 元
		      			<div class="col-sm-5" style="margin-right:70px; float:right;">				
						</div>
					</div>

					<div class="modal-body">缴费类型：

						<?php foreach ($payment_type_info as $key => $value) { ?>
							<label style="padding-right:10px;">
								<input name="payment_type_id" data-target="payment_type_id" type="radio" value="<?php echo $value['payment_type_id'];?>" class="ace" />
								<span class="lbl"> <?php echo $value['payment_type_name'];?></span>
							</label>
						<?php } ?>
		          		
		          	</div>
		          	<div class="modal-body" data-target="tabChange" id="tabChange">
						<table style="display:none; margin: 0 auto;" id="payment_two">
							<tr>
								<th class="center">应缴费日期</th>
								<th class="center">应缴费金额(元)</th>
								<th class="center">提醒时间</th>
								<th class="center">学费说明</th>
								<th>&nbsp;</th>	
							</tr>
						 	<tr>
						 		<td><input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time1[]" placeholder="应缴费日期" /></td>
						 		<td><input type="text" name="payment_money1[]" placeholder="应缴费金额" />元</td>
						 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time1[]" placeholder="提醒时间" /></td>
						 		<td><input type="text" name="payment_desc1[]" placeholder="学费说明" /></td>
						 		<td>
						 			<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success">
									<i class="icon-plus smaller-75"></i>
								</button>
							</td>
						 	</tr>
						</table>
						<table style="display:none; margin: 0 auto;" id="payment_three">
							<tr>
								<th class="center">申请额度</th>
								<th class="center">机构代还时间段</th>
								<th class="center">开始还款日期</th>
								<th class="center">备注</th>
								<th></th>
							</tr>
							<tr>
								<td><input type="text" name="apply_money1" placeholder="申请额度" /></td>
								<td><input type="text" data-date-format="yyyy/mm/dd" name="organization_paydate1" placeholder="机构代还时间段" /></td>
								<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="student_start_paydate1" placeholder="开始还款日期" /></td>
								<td><input type="text" name="apply_desc1" placeholder="备注" /></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="4" align="center"><h4 style="font-weight:bold;">生活补贴</h4></td>
							</tr>
							<tr>
								<th class="center">补贴日期</th>
									<th class="center">补贴金额(元)</th>
									<th class="center">提醒时间</th>
									<th class="center">补贴说明</th>
									<th></th>
							</tr>
							<tr>
							 	<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time2[]" placeholder="补贴日期" /></td>
							 		<td><input type="text" name="payment_money2[]" placeholder="补贴金额" />元</td>
							 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time2[]" placeholder="提醒时间" /></td>
							 		<td><input type="text" name="payment_desc2[]" placeholder="补贴说明" /></td>
							 		<td>
							 			<button data-target="#employment_credit" type="button" class="btn spinner-up btn-xs btn-success">
										<i class="icon-plus smaller-75"></i>
									</button>
								</td>
							</tr>
						</table>
						<table style="display:none; margin: 0 auto;">
							<tr>
								<th class="center">申请额度</th>
								<th class="center">机构代还时间段</th>
								<th class="center">开始还款日期</th>
								<th class="center">备注</th>
							</tr>
							<tr>
								<td><input type="text" name="apply_money2" placeholder="申请额度" /></td>
								<td><input type="text" name="organization_paydate2" placeholder="机构代还时间段" /></td>
								<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="student_start_paydate2" placeholder="开始还款日期" /></td>
								<td><input type="text" name="apply_desc2" placeholder="备注" /></td>
							</tr>
						</table>
						<table style="display:none; margin: 0 auto;">
							<tr>
								<th class="center">申请额度</th>
								<th class="center">机构代还时间段</th>
								<th class="center">开始还款日期</th>
								<th class="center">备注</th>
								<th></th>
							</tr>
							<tr>
								<td><input type="text" name="apply_money3" placeholder="申请额度" /></td>
								<td><input type="text" data-date-format="yyyy/mm/dd" name="organization_paydate3" placeholder="机构代还时间段" /></td>
								<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="student_start_paydate3" placeholder="开始还款日期" /></td>
								<td><input type="text" name="apply_desc3" placeholder="备注" /></td>
								<td></td>
							</tr>
							<tr>
								<td colspan="4" align="center"><h4 style="font-weight:bold;">工资补贴</h4></td>
							</tr>
							<tr>
								<th class="center">补贴日期</th>
									<th class="center">补贴金额(元)</th>
									<th class="center">提醒时间</th>
									<th class="center">补贴说明</th>
									<th></th>
							</tr>
							<tr>
							 	<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time3[]" placeholder="补贴日期" /></td>
							 		<td><input type="text" name="payment_money3[]" placeholder="补贴金额" />元</td>
							 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time3[]" placeholder="提醒时间" /></td>
							 		<td><input type="text" name="payment_desc3[]" placeholder="补贴说明" /></td>
							 		<td>
							 			<button data-target="#wage" type="button" class="btn spinner-up btn-xs btn-success">
										<i class="icon-plus smaller-75"></i>
									</button>
								</td>
							</tr>
						</table>
		          	</div>
					<div class="col-sm-5" style="float:right; clear: both;"></div>

		          	<div class="modal-body" style="padding:42px 10px 0px; "><lebal>特殊情况备注：</lebal>
		          		<textarea name="special_payment_remark" class="form-control" id="form-field-8" placeholder="针对咨询者的情况备注信息"></textarea>
		          	</div>

		          	<div class="modal-footer">
		          		<input class="btn btn-info" type="submit" value="提交" />
			            <button data-dismiss="modal" class="btn" type="button">取消</button>
			        </div>
		        	<input type="hidden" name="fqmoneyall" id="fqmoneyall" value="" />
			        </form>
		        </div>
		  	</div>
		</div>

		<!--模态框（弹出 选课程、缴费信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="client_inputModal" style="display: none;">
		  	<div class="modal-dialog" style="width:870px;padding-top:100px;padding-bottom:180px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">亲，请设为客户</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(2).'/advisory/setClient');?>" method="post" id="setClient">
		          	<input type="hidden" id="consultant_id" name="consultant_id" value="" />
					
					<table cellpadding="5px" style="margin:20px 10px 0px; width:700px; ">
						<tr>
							<td align="right">项目名称：</td>
							<td width="490px">
								<input type="text" name="project_name" placeholder="请输入项目名称" id="project_name" type-data="false" style=" float:left;" />
								<div class="col-sm-5" style="float:left;"></div>
							</td>
						</tr>
						
						<tr>
							<td align="right">项目参考网址：</td>
							<td width="490px">
								<input type="text" name="project_url" placeholder="请输入项目参考网址" id="project_url" type-data="false" style=" float:left;" />
								<div class="col-sm-5" style="float:left;"></div>
							</td>
						</tr>

						<tr>
							<td align="right">项目总费用：</td>
							<td width="490px">
								<span style=" float:left;">
									<input type="text" name="project_total_money" id="project_total_money" placeholder="请输入项目总费用" style=" float:left;" /> 元
								</span>
								<div class="col-sm-5" style=" float:left;"></div>
							</td>
						</tr>

						<tr>
							<td align="right">缴费日期：</td>
							<td width="490px">
								<input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="project_payment_time" value="<?php echo date('Y/m/d');?>" placeholder="缴费日期" />
							</td>
						</tr>
						
						<tr>
							<td align="right">缴费：</td>
							<td width="490px">
								<span style=" float:left;">
									<input type="text" name="project_already_total" placeholder="请输入费用"  id="project_already_total" /> 元
								</span>
								<div class="col-sm-5" style="float:left;"></div>
							</td>
						</tr>

						<tr>
							<td align="right">缴费类型：</td>
							<td>
								<?php 
								$payment_type_arr = array(1,2);
								foreach ($payment_type_info as $key => $value) { 
										if(in_array($value['payment_type_id'], $payment_type_arr)){
									?>
									<label style="padding-right:10px;">
										<input name="payment_type_id" data-target="payment_type_id" type="radio" value="<?php echo $value['payment_type_id'];?>" class="ace" />
										<span class="lbl"> <?php echo $value['payment_type_name'];?></span>
									</label>
								<?php }
								} ?>
							</td>
						</tr>
					</table>
						
					<div class="modal-body" style="padding:0px;padding-bottom:0px;" data-target="projectChange" id="projectChange">
						<table style="display:none; margin: 0 auto;" id="payment_two">
							<tr>
								<th class="center">应缴费日期</th>
								<th class="center">应缴费金额(元)</th>
								<th class="center">提醒时间</th>
								<th class="center">费用说明</th>
								<th>&nbsp;</th>	
							</tr>
						 	<tr>
						 		<td><input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="pro_payment_time[]" placeholder="应缴费日期" /></td>
						 		<td><input type="text" name="pro_payment_money[]" placeholder="应缴费金额" />元</td>
						 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="pro_remind_time[]" placeholder="提醒时间" /></td>
						 		<td><input type="text" name="pro_payment_desc[]" placeholder="费用说明" /></td>
						 		<td>
						 			<button data-target="#projectMoneyAdd" type="button" class="btn spinner-up btn-xs btn-success">
									<i class="icon-plus smaller-75"></i>
								</button>
							</td>
						 	</tr>
						</table>
		          	</div>
					<div class="col-sm-5" style="float:right; clear: both;"></div>
					
					<table cellpadding="5px" style="margin: 20px 10px 0px;">
						<tr>
							<td valign="top" width="210px" align="right">特殊情况备注：</td>
							<td width="300px">
								<textarea style="width: 500px;height: 119px;" name="project_payment_remark" class="form-control" id="form-field-8" placeholder="针对客户的情况备注信息"></textarea>
							</td>
						</tr>
					</table>

		          	<div class="modal-footer">
		          		<input class="btn btn-info" type="submit" value="提交" />
			            <button data-dismiss="modal" class="btn" type="button">取消</button>
			        </div>
		        	<input type="hidden" name="fqmoneyall" id="fqmoneyall" value="" />
			        </form>
		        </div>
		  	</div>
		</div>

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

							<tr>
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
		            	<h4 id="youModalLabel" class="modal-title">咨询者信息</h4>
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

		<!-- 模态框（意向课程） -->
		<div class="modal fade" id="intentionCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					
			        <h4 class="modal-title">请选择意向课程</h4>
			      </div>
			  
				  <form action="<?php echo site_url(module_folder(2).'/advisory/actionIntentionCourse');?>" method="post">
				  	<input type="hidden" name="consultant_id" value="" />
			      	<div id="intentionKnowleage" style="padding:20px;">
						
				  	</div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			        <input type="submit" class="btn btn-primary" id="" value="保存" />
			      </div>
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- 临时数据存储地 ，（学费）分期付款 start -->
		<textarea name="installments" cols="30" rows="10" style="display:none;">
			<tr>
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time1[]" placeholder="应缴费日期" /></td>
  		 		<td><input type="text" name="payment_money1[]" placeholder="应缴费金额" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time1[]" placeholder="提醒时间" /></td>
  		 		<td><input type="text" name="payment_desc1[]" placeholder="学费说明" /></td>
  		 		<td>
  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
						<i class="icon-minus smaller-75"></i>
					</button>
				</td>
  		 	</tr>
		</textarea>
		<!-- 分期付款 end -->

		<!-- 临时数据存储地 ，（项目）分期付款 start -->
		<textarea name="proinstallments" cols="30" rows="10" style="display:none;">
			<tr>
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="pro_payment_time[]" placeholder="应缴费日期" /></td>
  		 		<td><input type="text" name="pro_payment_money[]" placeholder="应缴费金额" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="pro_remind_time[]" placeholder="提醒时间" /></td>
  		 		<td><input type="text" name="pro_payment_desc[]" placeholder="费用说明" /></td>
  		 		<td>
  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
						<i class="icon-minus smaller-75"></i>
					</button>
				</td>
  		 	</tr>
		</textarea>
		<!-- 分期付款 end -->

		<!-- 先就业后付款(包吃住) start-->
		<textarea name="employment_credit" cols="30" rows="10" style="display:none;">
			<tr>
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time2[]" placeholder="补贴日期" /></td>
  		 		<td><input type="text" name="payment_money2[]" placeholder="补贴金额" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time2[]" placeholder="提醒时间" /></td>
  		 		<td><input type="text" name="payment_desc2[]" placeholder="补贴说明" /></td>
  		 		<td>
  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
						<i class="icon-minus smaller-75"></i>
					</button>
				</td>
  		 	</tr>
		</textarea>
		<!-- 先就业后付款(包吃住) end -->
		<!-- 先就业后付款(工资方案) start-->
		<textarea name="wage" cols="30" rows="10" style="display:none;">
			<tr>
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time3[]" placeholder="补贴日期" /></td>
  		 		<td><input type="text" name="payment_money3[]" placeholder="补贴金额" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time3[]" placeholder="提醒时间" /></td>
  		 		<td><input type="text" name="payment_desc3[]" placeholder="补贴说明" /></td>
  		 		<td>
  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
						<i class="icon-minus smaller-75"></i>
					</button>
				</td>
  		 	</tr>
		</textarea>
		<!-- 先就业后付款(工资方案) end -->
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
				//设置未上门、已上门
				$('a[data-target="#setView"]').on(ace.click_event, function() {
					
				
					if ($.trim(this.innerHTML)=='已上门'){ return false; }
					
					var _this=this;
					var consultant_id=parseInt($(this).attr("data"));
						bootbox.confirm("你确定设为已上门吗?", function(result) {
							if(result) {
								$.ajax({
							        type: "POST",
							        url: "<?php echo site_url(module_folder(2).'/advisory/setView');?>",
							        data: "id="+consultant_id,
							        dataType:'json',
							        success: function(res){
							       		if (res.status==1) {
							       			_this.innerHTML='已上门';
							       			$('#visit').html(res.visit);
							       			$('#notvisit').html(res.notvisit);

							       			//给已上门，加背景颜色
							       			$(_this).parent().parent()
													.css('background-color','#7DD136')
													.siblings()
													.css('background-color','#7DD136');
							       		};
							        }
						   		});
							}
						});
					
				});

				function set_view_bg(){
					//设置背景颜色
					$('#sample-table-1').find('a').each(function(){
						var str=this.innerHTML;
						if(str.trim()=='已上门'){
							$(this).parent().parent()
											.css('background-color','#7DD136')
											.siblings()
											.css('background-color','#7DD136');
						}
						
						

					});

				}
				set_view_bg();

				//ajax获取用户信息		
				$('.advisory_info').click(function(){
					var consultant_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/advisory/info');?>",
				        data: "id="+consultant_id,
				        dataType:'json',
				        success: function(res){
				        	//如果结果不对，不处理
				        	if(res.status==0){return ;}

				       		$("#advisory_info").find('.modal-body').html(res.data);
				       		$("#ad_info").html('<a href="'+res.info_url+'">修改咨询者信息 >></a>'); 
				        }
			   		});
				});

				//ajax获取提醒信息		
				$('.consultant_remind_edit').click(function(){
					var consultant_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/remind/remindConsultantInfo');?>",
				        data: "id="+consultant_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==0){return ;}
				       		$("#remind_content").html(res.data['time_remind_content']);
				       		$("#id-date-picker-1").val(res.data['day']);
				       		$("#timepicker1").val(res.data['time']); 
				       		$(".del_remind").html(res.str); 
				       		$(".time_remind_id").val(res.data['time_remind_id']);
				       		$(".remind_remark").val(res.data['remind_remark']); 

				       		if(res.data['is_set_view'] == 1){
				       			$('input[name="is_set_view"]').val(1);
				       			$('input[name="check_set_view"]').prop('checked',true);
				       		}

				       		if(res.data['is_important'] == 1){
				       			$('input[name="is_important"]').val(1);
				       			$('input[name="check_important"]').prop('checked',true);
				       		}

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

		       		$('input[name="is_set_view"]').val(0);
		       		$('input[name="is_important"]').val(0);
		       		
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

				//设为学员模态框
				$('#inputModal .modal-body').css('padding','20px 10px 0px');

				$('.date-picker').focus(function(){
					var obj=$('.datepicker');
						obj.css({'z-index':1060});
					
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

				checkTotal.prototype={


					add_blur:function(){
						var _this=this;
						$('input[name="'+this.name+'"]').unbind();
						$('input[name="'+this.name+'"]').bind('blur',function(){_this.blur_check(this);});
					},

					blur_check:function (obj) {

						//判断是否是数字
						if($(obj).attr('name') == 'tuition_total'){
							if(isNaN($(obj).val()) || $(obj).val() == ''){
								$(obj).parent().find(':last-child').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请正确输入应缴学费</div>');
								$(obj).attr('type-data','false');
							}else{
								$(obj).parent().find(':last-child').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline"></div>');
								$(obj).attr('type-data','true');
							}

						}

						if($(obj).attr('name') == 'project_name'){
							if($(obj).val() == ''){
								$(obj).parent().find(':last-child').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请正确输入项目名称</div>');
								$(obj).attr('type-data','false');
							}else{
								$(obj).parent().find(':last-child').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline"></div>');
								$(obj).attr('type-data','true');
							}

						}

						if($(obj).attr('name') == 'project_total_money'){
							if(isNaN($(obj).val()) || $(obj).val() == ''){
								$(obj).parent().parent().find(':last-child').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请正确输入项目总费用</div>');
								$(obj).attr('type-data','false');
							}else{
								$(obj).parent().parent().find(':last-child').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline"></div>');
								$(obj).attr('type-data','true');
							}

						}

						//判断是否是数字
						if($(obj).attr('name') == 'already_total'){
							if(isNaN($(obj).val()) || $(obj).val() == ''){
								$(obj).next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请正确输入学费或定位费</div>');
								$(obj).attr('type-data','false');
							}else{
								$(obj).next().html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline"></div>');
								$(obj).attr('type-data','true');
							}

						}

						if($(obj).attr('name') == 'project_already_total'){
							if(isNaN($(obj).val()) || $(obj).val() == ''){
								$(obj).parent().next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请正确输入应缴费用</div>');
								$(obj).attr('type-data','false');
							}else{
								$(obj).parent().next().html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline"></div>');
								$(obj).attr('type-data','true');
							}

						}
						
					}

				}

				new checkTotal('tuition_total').add_blur();
				new checkTotal('already_total').add_blur();

				new checkTotal('project_name').add_blur();
				new checkTotal('project_total_money').add_blur();
				new checkTotal('project_already_total').add_blur();

				
				<?php if($set_stu_bg===1){?>
					(function(){
						//如果是已上门的，给背景颜色
						var data='<?php echo $stu_consultant_id;?>';
						var stu_consultant_id=JSON.parse(data);

						
						$('#sample-table-1').find('td').each(function(){
							this.style.backgroundColor='#f5f5f5';
						});

						$('input[name="checkbox_consultant[]"]').each(function(){
							var res=wdcrm.in_array(this.value,stu_consultant_id);

								if (res) {
									$(this).parent().parent()
										   .css('backgroundColor','#7EC6F7')
										   .siblings()
										   .css('backgroundColor','#7EC6F7');
								};
						});

					})();
						
				<?php }?>

				<?php if($set_stu_bg===2){?>
					(function(){

						var data='<?php echo $stu_consultant_id;?>';
						var stu_consultant_id=JSON.parse(data);
						
						$('input[name="checkbox_consultant[]"]').each(function(){
							var res=wdcrm.in_array(this.value,stu_consultant_id);

								if (res) {
									$(this).parent().parent()
										   .css('backgroundColor','#7EC6F7')
										   .siblings()
										   .css('backgroundColor','#7EC6F7');
								};

						});

					})();
						
				<?php }?>

				//选择判断类型“已缴学费”和“定位费”
				$('select[name="select_type"]').on('change',function(){
					if( $(this).val() == 0 ){
						$('input[name="already_total"]').attr('placeholder','请输入学费');
					}else{
						$('input[name="already_total"]').attr('placeholder','请输入定位费');
					}
				});
				
			});
			
			//课程列表折叠、全选、反选
			jQuery(function($){	

				//课程列表折叠
				$("#menu ul").attr("style","display:none;");
				$('.icon-plus').click(function () {
					if($(this).siblings('ul').attr("style")=="display:none;"){
						$(this).siblings('ul').attr("style","display:block; padding-left: 20px;");
						$(this)[0].className = 'icon-minus';
					}else{
						$(this).siblings('ul').attr("style","display:none;");
						$(this)[0].className = 'icon-plus';
					}
				});

				var $p_input = $('#menu').children('li').css({'cursor':'pointer'}).children('input:checkbox');
				var $c_input = $p_input.siblings('ul').find('li input:checkbox');

				//课程的全选、反选
				$p_input.on('click',function () {

					var other_that = this;

					$(this).siblings('ul').find('li input:checkbox').each(function (){

						this.checked = other_that.checked;
						this.disabled=false;

						//start，点击课程，把其他课程里面的知识点(一样的设为禁用状态)
						var html=$.trim($(this).next().html());
						var _this=this;

						$c_input.each(function(){

					 		if(this==_this){
					 			return;
					 		}

					 		if($.trim($(this).next().html())==html){

					 			$(this).prop('disabled',other_that.checked);
					 			if(other_that.checked){
					 				$(this).prop('checked',false);
					 			}
					 			
					 		}

						 });
						//end
					
					});

					$('input[name="course_name[]"]').each(function(){
						var l= $(this).next().next().find('input:checked').length;
						if(l==0){
							this.checked=false;
						}

					});

				});

				//选择知识点=>选中课程
				$c_input.on('click',function () {

					var $p = $(this).parents('ul').siblings(':checkbox');
					var c_len = $(this).parent().parent().find(':checkbox').filter(':checked').length;

					if(c_len == 0){
						$p.prop('checked',false);
					}else{
						$p.prop('checked',true);
					}

					var _this=this;
					var html=$.trim($(this).next().html());
					var status=this.checked; //只要是选中了,就不能同一个的
					 $c_input.each(function(){

					 		if(this==_this){
					 				return;
					 		}

					 		if($.trim($(this).next().html())==html){

					 			$(this).prop('disabled',status);					 			

					 		}
					 });

				});
				
				//点击文字，触发旁边的点击事件
				$('span[data-event="click"]').click(function(){ 
						
						var z= $(this).prev();
						
						z[0].click(); 

				});
		
			});



			//缴费类型选项卡
			jQuery(function($){	

				$('#setStudent input[data-target="payment_type_id"]').click(function(){

						var type=$.trim($(this).next().html());
						var index;
						if(type=='一次性付款'){
							$('div[data-target="tabChange"]').find('table').hide();
						}else if(type=='分期付款'){
							index=0;
						}else if(type=='先就业后付款(包吃住)'){
							index=1;
						}else if(type=='先就业后付款(不包吃住)'){
							index=2;
						}else if(type=='先就业后付款(工资方案)'){
							index=3;
						}else{
							return ;
						}

						var z=$('div[data-target="tabChange"]').find('table').eq(index);
						z.show().siblings().hide();
				});

				$('#setClient input[data-target="payment_type_id"]').click(function(){

						var type=$.trim($(this).next().html());
						var index;
						if(type=='一次性付款'){
							$('div[data-target="projectChange"]').find('table').hide();
						}else if(type=='分期付款'){
							index=0;
						}else{
							return ;
						}

						var z=$('div[data-target="projectChange"]').find('table').eq(index);
						z.show().siblings().hide();
				});

			});

			jQuery(function($){
				/**
				 * 添加还款与放款输入框
				 * @param string 选中的元素 
				 * @param string 需要追加的内容，放置到了textarea里面
				 *
				 */
				function AddInput(id,name){
						var _this=this;
					//给按钮绑定事件，实现追加
					this.id=$('button[data-target="'+id+'"]');
					
					//追加的内容
					this.content=$('textarea[name="'+name+'"]').text();
				}

				AddInput.prototype={
					
					add:function(){
						var _this=this;
					
						_this.id.click(function(){ //绑定点击事件
							var z=$(this).parent().parent().parent();

							z.append(_this.content);

							$('input[data-target="#dateShow"]').datepicker();

							$('input[data-target="#dateShow"]').focus(function(){

								$('.dropdown-menu').css('z-index',1060);

							});
						});
						
					}
				}

				new AddInput('#moneyAdd','installments').add();
				new AddInput('#projectMoneyAdd','proinstallments').add();
				new AddInput('#employment_credit','employment_credit').add();
				new AddInput('#wage','wage').add();			
			});

			jQuery(function($){
				//时间选择插件
				$('input[data-target="#dateShow"]').datepicker();
				$('input[data-target="#dateShow"]').focus(function(){

					$('.dropdown-menu').css('z-index',1060);

				});

				function start_end_time(obj){

					$('input[name='+obj+']').daterangepicker(
						{
							format: 'YYYY/MM/DD',
							locale: {
		                        applyLabel: '确定',
		                        cancelLabel: '取消',
		                        fromLabel: '开始',
		                        toLabel: '结束',
		                        customRangeLabel: 'Custom',
		                        daysOfWeek: ['周日', '周一', '周二', '周三', '周四', '周五','周六'],
		                        monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
		                        firstDay: 1
		                    }
							
						});

					$('input[name='+obj+']').focus(function(){

							$('.daterangepicker').css('z-index',1060);

					});

				}
				start_end_time('organization_paydate1');
				start_end_time('organization_paydate2');
				start_end_time('organization_paydate3');
			});

			/**
			 * 数据校验
			 */
			jQuery(function($){
				
				//设为学员					
				$('#setStudent').submit(function () {
					var num = 0;
					var fqtime = 0;
					var fqmoney = 0;
					var fqmoneyall = 0;
					var btmoneyall = 0;
					var payment_money;

					var course_length = $('input[name="course_name[]"]').length;
					var knowledge_length = $('input[name="knowledge_name[]"]').length;

					var type = $('input[name="payment_type_id"]').filter(':checked');

					for(var i=0; i<course_length; i++){
						if($('input[name="course_name[]"]')[i].checked){
							num ++;
						}
					}

					for(var i=0; i<knowledge_length; i++){
						if($('input[name="knowledge_name[]"]')[i].checked){
							num ++;
						}
					}

					if(num == 0){

						$('#course').next().html('请选择课程');
						return false;
					}
						
					$('#course').next().html('');

					//主动触发让应缴、应缴学费失去焦点
					$('#tuition_total').blur();
					$('#already_total').blur();

					if( $('#tuition_total').attr('type-data') == 'false' ){
						return false;
					}
					if( $('#already_total').attr('type-data') == 'false' ){
						return false;
					}

					//根据用户选择的缴费类型做不同的数据校验
					if(type.length == 0){

						$('#tabChange').next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请选择缴费类型</div>');
						return false;
					}

					$('#tabChange').next().html('');

					//一次性付款（省略）

					//分期付款
					if( type.val() == 2 ){	

						//提醒,暂时不写
						//var two_remind_length = $('#payment_two input[name="remind_time[]"]').length;

						//把先就业跟后付款(包吃住吃住的)日期金额提醒干掉(不让他提交到数据库中)
						//$('#payment_three').find('input').val('');
					
					}

					//先就业后付款(包吃住)
					if( type.val() == 3 ){

						var apply_money1 = $('input[name="apply_money1"]').val();
						if( apply_money1 == '' ){
							$('#tabChange').next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请填写申请额度！</div>');
							return false;
						}				

						//是否要对缴费金额和生活补贴与申请额度比较？

						//提醒暂时不处理
						//var three_remind_length = $('#payment_three input[name="remind_time[]"]').length;

					}

					//先就业后付款(不包吃住)
					if( type.val() == 4 ){

						var apply_money2 = $('input[name="apply_money2"]').val();
						if( apply_money2 == '' ){
							$('#tabChange').next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请填写申请额度！</div>');
							return false;
						}
					}	

					//先就业后付款(工资方案)
					if( type.val() == 5 ){

						var apply_money3 = $('input[name="apply_money3"]').val();
						if( apply_money3 == '' ){
							$('#tabChange').next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请填写申请额度！</div>');
							return false;
						}				

					}
					
				});

			});

			jQuery(function ($) {

				//设为客户
				$('#setClient').submit(function () {
					var fqtime = 0;
					var fqmoney = 0;
					var fqmoneyall = 0;
					var btmoneyall = 0;
					var payment_money;

					var type = $('input[name="payment_type_id"]').filter(':checked');

					//主动触发让应缴、应缴学费失去焦点
					$('#project_name').blur();
					$('#project_total_money').blur();
					$('#project_already_total').blur();

					if( $('#project_name').attr('type-data') == 'false' ){
						return false;
					}
					if( $('#project_total_money').attr('type-data') == 'false' ){
						return false;
					}
					if( $('#project_already_total').attr('type-data') == 'false' ){
						return false;
					}

					//根据用户选择的缴费类型做不同的数据校验
					if(type.length == 0){

						$('#projectChange').next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请选择缴费类型</div>');
						return false;
					}

					$('#projectChange').next().html('');

					//一次性付款（省略）

					//分期付款
					if( type.val() == 2 ){	

						//提醒,暂时不写
						//var two_remind_length = $('#payment_two input[name="remind_time[]"]').length;

						//把先就业跟后付款(包吃住吃住的)日期金额提醒干掉(不让他提交到数据库中)
						//$('#payment_three').find('input').val('');
					
					}
					
				});

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
			//搜索咨询者的相关信息
			jQuery(function($){
				
				var url='<?php echo site_url(module_folder(2).'/advisory/index/index/0');?>';
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
			<?php }?>

			jQuery(function($){
				//处理意向课程
				$('button[data-target="#intentionCourse"]').click(function(){				
					var consultant_id = $(this).attr('con_id');			
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/advisory/intentionKnowleage');?>",
				        data: "consultant_id="+consultant_id,
				        dataType:'json',
				        success: function(res){
				        	$('#intentionCourse input[name="consultant_id"]').val(consultant_id);

				        	$('#intentionKnowleage').html(res.str);
				        	//返回数据之后再隐藏内容
				        	$("#menu_course ul").attr("style","display:none;");

				        	var $ps_input = $('#menu_course').children('li').css({'cursor':'pointer'}).children('input:checkbox');
							var $cs_input = $ps_input.siblings('ul').find('li input:checkbox');

							//课程的全选、反选
							$ps_input.on('click',function () {

								var other_that = this;

								$(this).siblings('ul').find('li input:checkbox').each(function (){

									this.checked = other_that.checked;
									this.disabled=false;
								});

							});

							//选择知识点=>选中课程
							$cs_input.on('click',function () {

								var $p = $(this).parents('ul').siblings(':checkbox');
								var c_len = $(this).parent().parent().find(':checkbox').filter(':checked').length;

								if(c_len == 0){
									$p.prop('checked',false);
								}else{
									$p.prop('checked',true);
								}

								var _this=this;
								var html=$.trim($(this).next().html());
								var status=this.checked; //只要是选中了,就不能同一个的
								 $c_input.each(function(){

								 		if(this==_this){
								 				return;
								 		}

								 		if($.trim($(this).next().html())==html){

								 			$(this).prop('disabled',status);					 			

								 		}
								 });

							});

							$('input[name="course_type[]"]').each(function(){
								var l= $(this).next().next().find('input:checked').length;
								if(l==0){
									this.checked=false;
								}else{
									this.checked=true;
								}

							});
			       		
				        }
			   		});
			   		
				});

				//课程列表折叠
				$('#intentionKnowleage').on('click','.icon-plus',function () {
					if($(this).siblings('ul').attr("style")=="display:none;"){
						$(this).siblings('ul').attr("style","display:block;");
						$(this)[0].className = 'icon-minus';
					}
				});

				$('#intentionKnowleage').on('click','.icon-minus',function () {
					if($(this).siblings('ul').attr("style")=="display:block;"){
						$(this).siblings('ul').attr("style","display:none;");
						$(this)[0].className = 'icon-plus';
					}
				});

				//操作“要上门的”和“重点跟进的”
				$('#con_remind').on('click','input[name="check_set_view"]',function() {
					if(this.checked){
						$(this).siblings('input[name="is_set_view"]').val(1);
					}else{
						$(this).siblings('input[name="is_set_view"]').val(0);
					}
				});

				$('#con_remind').on('click','input[name="check_important"]',function() {
					if(this.checked){
						$(this).siblings('input[name="is_important"]').val(1);
					}else{
						$(this).siblings('input[name="is_important"]').val(0);
					}
				});
			});
		</script>
</body>
</html>
