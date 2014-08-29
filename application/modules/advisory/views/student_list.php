<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>学员列表</title>
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
		<style type="text/css">
		.btn-xs{
			padding:1px 2px;
		}
		.tree:before{
			border-style:none;
		}
		#menu li,#menu_course li,#repeat_course li{
			list-style: none;
			line-height: 30px;
		}
		#menu li.second,#menu_course li.second,#repeat_course li.second{
			float:left;
			margin-right: 10px;
		}
		.clear{
			clear: both;
		}
		#menu li span.lbl,#menu_course li span.lbl,#repeat_course li span.lbl{
			line-height:21px;
		}
		.sel_course{
			float: left;
			border: 1px solid #ccc;
			width: 100px;
			height:30px;
			line-height: 30px;
			text-align: center;
			cursor: pointer;
		}
		.clear{
			clear: both;
		}
		.sel_bg{
			background: #ccc;
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
							<?php $this->load->view('url');?>
						</ul><!-- .breadcrumb -->
						<div style="position:absolute;right:33%;top:6px;line-height:24px;">	
							<table>
								<tr>
									<td>
										<span>查询条件:</span>
										<select name="select_day">
											<option <?php if(isset($select_day) && $select_day==1) { echo 'selected'; }?> value="1">报名日期</option>
											<option <?php if(isset($select_day) && $select_day==2) { echo 'selected'; }?> value="2">回访日期</option>
										</select>&nbsp;
									</td>
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
						<?php $this->load->view('search_student');?>
					</div>

					<div class="page-content">
						<div class="page-header">
							<?php echo $student_info['count'];?>
							<div style="display: inline-block;margin-left:20px;">
								<span>日期:</span>
								<label><input type="radio" value="0" name="order" <?php if(isset($order) && $order == 0){echo 'checked=checked';}?> class="sel_order ace" /><span class="lbl">升序</span></label>
								<label><input type="radio" value="1" name="order" <?php if(isset($order) && $order == 1){echo 'checked=checked';}?> class="sel_order ace" /><span class="lbl">降序</span></label>
							</div>
							<div style="float:right;">
								
								<?php if(getcookie_crm('employee_job_id')==2){?>
								<div style="float:left;margin-right:30px;">
									<span>班级类型:</span>
									<select id="curriculum_system" name="curriculum_system_id">
										<option value="">全部</option>
										<?php foreach ($curriculum_system as $key => $value) { ?>
											<option <?php if ($value['curriculum_system_id']==$curriculum_system_id) { echo 'selected'; }?> value="<?php echo $value['curriculum_system_id']; ?>"><?php echo $value['curriculum_system_name'];?></option>
										<?php } ?>
									</select>
								</div>

								<div style="float:left;margin-right:30px;">
									<span>知识点:</span>
									<select name="teach" id="changeKnowledge" style="width:102px;">
										<option value=" ">全部</option>
						                <?php foreach ($knowledge_info as $key => $value) { ?>
										<option <?php 
												if ($value['knowledge_id']==$selected_knownledge) {
													echo 'selected';
												}

											?> value="<?php echo $value['knowledge_id'];?>"><?php echo $value['knowledge_name'];?></option>
										<?php }?>
									</select>
									&nbsp;&nbsp;&nbsp;
									<label><input type="radio" value="0" <?php if(isset($study_status) && $study_status == 0){echo 'checked=checked';}?> name="study_status" class="select_status" />未读</label>
									&nbsp;
									<label><input type="radio" value="1" <?php if(isset($study_status) && $study_status == 1){echo 'checked=checked';}?> name="study_status" class="select_status" />已读</label>
									&nbsp;
									<label><input type="radio" value="2" <?php if(isset($study_status) && $study_status == 2){echo 'checked=checked';}?> name="study_status" class="select_status" />要复读</label>
								</div>
								<?php }?>

								<?php if(getcookie_crm('employee_power')==1 || getcookie_crm('employee_power')==2){?>
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
								<?php }?>
							</div>	
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<?php 
								$login_job = getcookie_crm('employee_job_id');
								$employee_arr = array(2,11);
								?>
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<form  name="delete" action="<?php echo site_url(module_folder(2).'/student/changeStatus');?>" method="post">
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
														<th class="center">学号</th>
														<th class="center">报名日期</th>
														<th class="center">姓名</th>
														<th class="center">性别</th>
														<th class="center hidden-480">手机</th>
														<th class="center">QQ</th>
														<th class="center">email</th>
														<?php if(in_array($login_job, $employee_arr)){?>
														<th>操作</th>
														<?php }?>
														<th>状态</th>
														<th>咨询师</th>
														<?php //if(getcookie_crm('employee_power')==1){?>
														
														<?php //}?>
													</tr>
												</thead>

												<tbody>
												<?php foreach($student_info['list'] as $item){ ?>
													<tr>	
														<?php if(in_array($login_job, $employee_arr)){?>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" name="id[]" value="<?php echo $item['student_id'];?>" />
																<span class="lbl"></span>
															</label>
														</td>
														<?php }?>
														<td class="center">
															<?php echo $item['serial_number'];?>
														</td>

														<td class="center">
															<?php echo $item['student_number'];?>
														</td>

														<td class="center">
															<?php echo date('Y-m-d',$item['sign_up_date']);?>
														</td>

														<td class="center">
															<?php echo $item['student_name'];?>
														</td>
														<td class="center"> 

															<?php
															 if ($item['student_sex']==1) {
															 	echo '男';
															 }else if($item['student_sex']==2){
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
																<a href="<?php echo site_url(module_folder(2).'/student_record/index/'.$item['consultant_id']);?>" class="btn btn-xs btn-primary" role="button">咨询记录</a>
																<a href="<?php echo site_url(module_folder(2).'/student_record/add/'.$item['consultant_id']);?>" class="btn btn-xs" role="button">添加咨询记录</a>
																<?php if(!empty($item['message'])){?>
																<a class="btn btn-xs btn-info consultant_remind_edit" role="button" data-target="#remindModal" data-toggle="modal" onclick="wdcrm.set_id('remind_student_id',<?php echo $item['student_id']?>)"  data="<?php echo $item['student_id'];?>">查看提醒</a>
																<?php }else{?>
																	<a class="btn btn-xs btn-info consultant_remind_add" role="button" data-target="#remindModal" data-toggle="modal" onclick="wdcrm.set_id('remind_student_id',<?php echo $item['student_id']?>)" data="<?php echo $item['student_id'];?>">添加提醒</a>
																<?php }?>
																<a href="<?php echo site_url(module_folder(2).'/student_course/index/'.$item['student_id']);?>" class="btn btn-xs btn-purple" role="button">已报课程</a>
																<a href="<?php echo site_url(module_folder(2).'/student_payment/index/'.$item['student_id']);?>" class="btn btn-xs btn-success" role="button">缴费记录</a>
																<button type="button" class="btn btn-xs btn-warning student_info" data-toggle="modal" data-target="#student_info" data="<?php echo $item['student_id'];?>">详细信息</button>
																

																<!-- <a role="button" class="btn btn-xs btn-pink" href="<?php echo site_url(module_folder(2).'/student_study/index/index/'.$item['student_id']);?>">就业情况</a> -->
																<!-- <button class="btn btn-xs btn-info">编辑</button> -->
		
																<!-- <a class="btn btn-xs btn-danger con_del" role="button" data="<?php //echo $item['student_id'];?>">删除</a> -->
																
															</div>
															<div style="clear:both;"></div>
															<br />
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<?php if($study_status != 0){?>
																<!-- <button class="btn btn-xs btn-info" role="button" data-target="#repeatRead" data-toggle="modal" stu_id="<?php echo $item['student_id'];?>" k_id="<?php echo $selected_knownledge;?>">要复读课程</button> -->
																<?php }?>

																<?php if($study_status != 0){?>
																<!-- <button class="btn btn-xs btn-info" role="button"  data-target="#studentReadKnowleage" data-toggle="modal" stu_id="<?php echo $item['student_id'];?>">就读情况</button> -->
																<?php }?>
																<button class="btn btn-xs btn-info" role="button" data-target="#intentionCourse" data-toggle="modal" stu_id="<?php echo $item['student_id'];?>">课程操作</button>
																<a role="button" class="btn btn-xs btn-pink" target="_blank" href="<?php echo site_url(module_folder(2).'/student_study/index/index/'.$item['student_id']);?>">就读课程</a>
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
																echo '<font color="red" style="font-weight:bold;">退学</font>';
															}else{
																echo '&nbsp;';
															}?>
														</td>	

														<?php if(getcookie_crm('employee_power')==1 || getcookie_crm('employee_power')==2){?>
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
											<a class="btn btn-xs btn-danger all_del" role="button">删除</a>
											<?php }?>
											
											<?php if(isset($study_status) && $study_status != 0 && $study_status != 2 && !empty($selected_knownledge)){?>
											<a class="btn btn-xs btn-danger repeatRead" role="button">要复读</a>
											<?php }?>
											<!-- <a class="btn btn-xs btn-danger" role="button">已复读</a>
											<a class="btn btn-xs btn-danger" role="button">已读</a> -->
											</form>
										</div><!-- /.table-responsive -->
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $student_info['page'];?>
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
		
		<!--模态框（弹出 选课程、缴费信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="inputModal" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		            	<h4 id="inputModalLabel" class="modal-title">亲，请先进行缴费</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(2).'/advisory/advisoryPayment');?>" method="post">
		          	<input type="hidden" id="student_id" name="student_id" value="" />
		          	<div class="modal-body" id="info">
		          			
							<ul id="menu">
								<?php foreach ($course as $key => $value) { ?>
									<li>
										<input type="checkbox" id="quan" onclick="selectAll(this,'<?php echo $key;?>[]')" /><a onclick="zd(this)" href="javascript:void(0)"><?php echo $value['curriculum_system_name'];?></a>
								    	<ul>
											<?php foreach ($value['course_name'] as $k => $v) {?>
								        		<li>
								        			<input type="checkbox" name="<?php echo $key;?>[]" value="<?php echo $v['knowledge_name'];?>" /><a href=""><?php echo $v['knowledge_name'];?></a>
								        		</li>
											<?php }?>
								        </ul>
								    </li>
								<?php }?>
							</ul>
							
		          	</div>
		          	<div class="modal-body">应缴学费：
		          		<input type="text" name="tuition_total" id="tuition_total">元
		          	</div>
					
					<div class="modal-body">缴费类型：
		          		<label style="padding-right:20px;">
							<input name="payment_type_id" checked type="radio" value="1" class="ace" />
							<span class="lbl"> 一次性付款</span>
						</label>
						<label>
							<input name="payment_type_id" value="2" type="radio" class="ace" />
							<span class="lbl"> 分期付款</span>
						</label>
						<label>
							<input name="payment_type_id" value="3" type="radio" class="ace" />
							<span class="lbl"> 贷款</span>
						</label>
		          	</div>
		          	<div class="modal-body">说明：
		          		<textarea name="payment_desc" class="form-control" id="form-field-8" placeholder="针对咨询者没有定时缴费，进行情况说明"></textarea>
		          	</div>

		          	<div class="modal-footer">
		          		<input class="btn" type="submit" value="提交" />
			            <button data-dismiss="modal" class="btn" type="button">取消</button>
			        </div>
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
		          	<form action="<?php echo site_url(module_folder(2).'/remind/studentRemind');?>" method="post" id="stu_remind">
			          	<input type="hidden" id="remind_student_id" name="remind_student_id" value="" />
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
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="student_info" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		            	<h4 id="youModalLabel" class="modal-title">学员信息</h4>
		          	</div>
		          	<div class="modal-body">    
		          	</div>
		          	<div style="padding-left:20px;" id="stu_info"></div>
		          	<div class="modal-footer">
			            <button data-dismiss="modal" class="btn btn-info" type="button">确定</button>
			        </div>
		        </div>
		  	</div>
		</div>


		<!--模态框（要复读）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="WillRepeatRead" style="display: none;">
		  	<div class="modal-dialog" style="width:586px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 class="modal-title">要复读课程</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(2).'/remind/studentRemind');?>" method="post">
			          	<input type="hidden" id="student_id" name="student_id" value="" />
			      						
						<div class="modal-body ">
						<div class="cinfo" style="display:none;"></div>
						<table cellpadding="5px">
							<tr>
								<td class="col-sm-2">请选择知识点</td>
								<td class="col-sm-8" id="WillReadKnowleage">
									
								</td>
							</tr>
							<tr>
								<td class="col-sm-2">备注</td>
								<td>
									<textarea style="height:100px;" class="form-control" name="remind_content"></textarea>
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
		
		<!-- 模态框（可复读） -->
		<!-- <div class="modal fade" id="repeatRead" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
		        <h4 class="modal-title">请选择要复读课程<span class="btn-xs" style="color:red;">（红色：已复读过的）</span></h4>
		      </div>

			 <form action="<?php echo site_url(module_folder(2).'/student/actionRepeatRead');?>" method="post">
				  	<input type="hidden" name="student_id" value="" />
			      	<div id="repeatReadKnowleage" style="padding:20px;">
						
				  	</div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			        <input type="submit" class="btn btn-primary" id="" value="保存" />
			      </div>
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div> --><!-- /.modal -->

		<!--模态框（就读情况）-->
		<!-- <div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="studentReadKnowleage" style="display: none;">
		  	<div class="modal-dialog" style="width:586px;padding-top:100px;">
		        <div class="modal-content" id="readKnowleageInfo">
		         	
		        </div>
		  	</div>
		</div> -->
		
		<!-- 模态框（意向课程） -->
		<div class="modal fade" id="intentionCourse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header"  style="padding-bottom:0px;">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
		        <div class="sel_course sel_bg">意向课程</div>
		        <div class="sel_course">复读课程</div>
		        <div class="clear"></div>
		      </div>

		      <div class="course" style="display:block;">
			      <span class="btn-xs" style="color:red;">（排除已经报读的课程）</span>
			      <form action="<?php echo site_url(module_folder(2).'/student/actionIntentionCourse');?>" method="post">
					  	<input type="hidden" name="student_id" value="" />
				      	<div id="intentionKnowleage" style="padding:20px;">
							
					  	</div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
				        <input type="submit" class="btn btn-primary" id="" value="保存" />
				      </div>
			      </form>
		      </div>

		      <div class="course" style="display:none;">
		      	<span class="btn-xs" style="color:red;">（红色：已复读过的）</span>
		      	<form action="<?php echo site_url(module_folder(2).'/student/actionRepeatRead');?>" method="post">
				  	<input type="hidden" name="student_id" value="" />
			      	<div id="repeatReadKnowleage" style="padding:20px;">
						
				  	</div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
			        <input type="submit" class="btn btn-primary" id="" value="保存" />
			      </div>
		      </form>
		      </div>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

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
			jQuery(function($) {
				//选项卡
				$('.sel_course').on('click',function() {
					var index = $(this).index();
					$(this).addClass('sel_bg').siblings().removeClass('sel_bg');
					$(this).parent().siblings('.course').eq(index-1).show().siblings('.course').hide();
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
				//单条删除功能
				$(".con_del").on(ace.click_event, function() {
					
					var delete_id=$(this).attr('data');

					bootbox.confirm("你确定删除吗?", function(result) {
						if(result) {
							window.location.href="<?php echo site_url(module_folder(2).'/student/delete');?>"+'/'+delete_id;
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
				//页码输入跳转
				$('#tiaozhuan').click(function(){
					if($('#pagetiao').val()==""){
						alert("请输入要跳转的页码");
						return false;
					}
					var address="<?php echo $tiao;?>"+"&per_page="+parseInt($('#pagetiao').val());
					location.href=address;
				});
				//ajax获取用户信息		
				$('.student_info').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student/info');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				        	//如果结果不对，不处理
				        	if(res.status==0){return ;}
				       		$("#student_info").find('.modal-body').html(res.data);
				       		$("#stu_info").html('<a href="'+res.info_url+'">修改学员信息 >></a>'); 

				        }
			   		});
				});
				//ajax获取提醒信息		
				$('.consultant_remind_edit').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/remind/remindStudentInfo');?>",
				        data: "id="+student_id,
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

					var student_id=parseInt($(this).attr("data"));
					var stu_remind = document.getElementById('stu_remind');
				    stu_remind.reset();
					$(".del_remind").html(""); 
					$("#remind_content").html("");
		       		$("#id-date-picker-1").val("<?php echo date('Y-m-d');?>");
		       		$("#timepicker1").val("<?php echo date('H:i:s');?>");
		       		$(".time_remind_id").val("");
				    $(".cinfo").html("");

				    $('input[name="is_set_view"]').val(0);
		       		$('input[name="is_important"]').val(0);

				    $.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student/studentInfo');?>",
				        data: "stu_id="+student_id,
				        dataType:'json',
				        success: function(res){
				        	$(".cinfo").html(res.info);
				        }
			   		});

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
			});

			jQuery(function($){

				$('#changeKnowledge').change(function(){

					var knowledge_id= this.value;
					
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
					//干掉知识点
					delete arr.knowledge_id;
					delete arr.curriculum_system_id;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'knowledge_id='+knowledge_id;
					
					window.location.href=z;
					//var ur='<?php echo site_url(module_folder(2).'/student/index/index/0');?>';
					//window.location.href=ur+'?knowledge_id='+knowledge_id;


				});

				$('#curriculum_system').change(function(){

					var curriculum_system_id= this.value;
					
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
					//干掉知识点
					delete arr.curriculum_system_id;
					delete arr.knowledge_id;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'curriculum_system_id='+curriculum_system_id;
					window.location.href=z;

					//var ur='<?php echo site_url(module_folder(2).'/student/index/index/0');?>';
					//window.location.href=ur+'?curriculum_system_id='+curriculum_system_id;


				});

				$('.select_status').click(function(){

					var study_status= this.value;
					
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
					//干掉知识点的状态
					delete arr.study_status;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'study_status='+study_status;
					
					window.location.href=z;

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
		//搜索学生的相关信息
		jQuery(function($){

			var url='<?php echo site_url(module_folder(2).'/student/index/index/0');?>';

			$('form[name="student_search"]').submit(function(){
				var search=$.trim(this.elements['search'].value);

				if (search!='') {
					var key= $('select[name="key"] option:selected').val();
					window.location.href=url+'?key='+key+'&search='+search;

				};	
				return false;
			});

		});


		jQuery(function($){
			//报名日期
			$('button[data-event="searchTime"]').click(function(){

				var select_day = $('select[name="select_day"]').val();

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
					ur='<?php echo site_url(module_folder(2).'/student/index/index/0');?>';
					//普通管理员地址
					window.location.href=ur+'?select_day='+select_day+'&start_time='+start_time+'&end_time='+end_time;
					//超级管理员地址
					<?php if(getcookie_crm('employee_power')==1 || getcookie_crm('employee_power')==2){?>
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
		if(getcookie_crm('employee_power')==1 || getcookie_crm('employee_power')==2){?>
		jQuery(function($){

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
		
		jQuery(function($){
			//处理要复读的课程
			$('button[data-target="#repeatRead"]').click(function(){				
				var student_id = $(this).attr('stu_id');
				var k_id = $(this).attr('k_id');
				
				$.ajax({
			        type: "POST",
			        url: "<?php echo site_url(module_folder(2).'/student/repeatReadKnowleage');?>",
			        data: "student_id="+student_id+"&k_id="+k_id,
			        dataType:'json',
			        success: function(res){
			        	$('#repeatRead input[name="student_id"]').val(student_id);
			        	$('#repeatReadKnowleage').html(res.str);
			       		//返回数据之后再隐藏内容
			        	$("#repeat_course ul").attr("style","display:none;");

			        	var $ps_input = $('#repeat_course').children('li').css({'cursor':'pointer'}).children('input:checkbox');
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

			//处理意向课程
			$('button[data-target="#intentionCourse"]').click(function(){				
				var student_id = $(this).attr('stu_id');
				var k_id = $(this).attr('k_id');
				
				$.ajax({
			        type: "POST",
			        url: "<?php echo site_url(module_folder(2).'/student/intentionKnowleage');?>",
			        data: "student_id="+student_id+"&k_id="+k_id,
			        dataType:'json',
			        success: function(res){
			        	$('#intentionCourse input[name="student_id"]').val(student_id);
			        	$('#intentionKnowleage').html(res.str);
			        	//返回数据之后再隐藏内容
			        	$("#menu_course ul").attr("style","display:none;");

			        	var $ps_input = $('#menu_course').children('li').css({'cursor':'pointer'}).children('input:checkbox');
						var $cs_input = $ps_input.siblings('ul').find('li input:checkbox');

						//课程的全选、反选
						$ps_input.on('click',function () {

							var other_that = this;

							$(this).siblings('ul').find('li input:checkbox').each(function (){
				
								if(other_that.checked && this.disabled==false){
									this.checked = true;
								}else{
									this.checked = false;
								}
								

								// if($(this).prop('disabled',true)){

								// 	other_that.checked = false;
								// }else{
									
								// }
								
								//this.disabled=false;
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
							var d= $(this).next().next().find('input[disabled="disabled"]').length;
							var i= $(this).next().next().find('input').length;

							if(d==i){
								$(this).prop('disabled',true);
							}

							if(l==0){
								this.checked=false;
							}else{
								this.checked=true;

								$(this).prev('i')[0].className = 'icon-minus';
								$(this).siblings('ul').css('display','block');
							}

						}); 

						//复读
						if(res.stat=='no'){
							$('.sel_course').eq(1).hide();
						}else{
							$('.sel_course').eq(1).show();
						}
						$('#repeatRead input[name="student_id"]').val(student_id);
						$('#repeatReadKnowleage').html(res.str1);
			        	
			       		//返回数据之后再隐藏内容
			        	$("#repeat_course ul").attr("style","display:none;");

			        	var $ps_input1 = $('#repeat_course').children('li').css({'cursor':'pointer'}).children('input:checkbox');
						var $cs_input1 = $ps_input1.siblings('ul').find('li input:checkbox');

						//课程的全选、反选
						$ps_input1.on('click',function () {

							var other_that = this;

							$(this).siblings('ul').find('li input:checkbox').each(function (){

								// this.checked = other_that.checked;
								// this.disabled=false;
								if(other_that.checked && this.disabled==false){
									this.checked = true;
								}else{
									this.checked = false;
								}
							});

						});

						//选择知识点=>选中课程
						$cs_input1.on('click',function () {

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

						$('input[name="course_type1[]"]').each(function(){
							var l= $(this).next().next().find('input:checked').length;
							var d= $(this).next().next().find('input[disabled="disabled"]').length;
							var i= $(this).next().next().find('input').length;

							if(d==i){
								$(this).prop('disabled',true);
							}
							
							if(l==0){
								this.checked=false;
							}else{
								this.checked=true;
								$(this).prev('i')[0].className = 'icon-minus';
								$(this).siblings('ul').css('display','block');
							}

						});   
							   		
			        }
		   		});
		   		
			});

			//就读情况(已读(正在读、已结课)、已复读信息)
			// $('button[data-target="#studentReadKnowleage"]').click(function(){
			// 	var student_id = $(this).attr('stu_id');
			// 	var str = '';
				
			// 	$.ajax({
			//         type: "POST",
			//         url: "<?php echo site_url(module_folder(2).'/student/getKnowleage');?>",
			//         data: "student_id="+student_id,
			//         dataType:'json',
			//         success: function(res){

			//         	$('#readKnowleageInfo').html(res.data);
			       		
			//         }
		 //   		});
		   		
			// });

			//操作“要复读”
			$(".repeatRead").on(ace.click_event, function() {
				//检测有多少个被选中了，0个删除不弹出确定框。
				var length= $('input[name="id[]"]:checked').length;
				if(length>0){
					var changeKnowledgeId = $('#changeKnowledge option:selected').val();
					var changeKnowledge = $('#changeKnowledge option:selected').html();
					var arr_check = new Array();
					$('input[name="id[]"]:checked').each(function(i){
						if($(this).val!=''){
							arr_check[i] = $(this).val(); 
						}
		                 
		            });
					bootbox.confirm("你确定要复读<em style='color:red;'>"+changeKnowledge+"</em>", function(result) {
						if(result) {
							$.ajax({
						        type: "POST",
						        url: "<?php echo site_url(module_folder(2).'/student/allRepeatKnowleage');?>",
						        data: 'changeKnowledgeId='+changeKnowledgeId+'&student_id='+arr_check,
						        dataType:'json',
						        success: function(res){
						        	if(res.status==1){
						        		alert("操作成功！");
						        		location.reload();
						        	}
						        	
						       		
						        }
					   		});
						}
					});
				}
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

			//课程列表折叠
			$('#repeatReadKnowleage').on('click','.icon-plus',function () {
				if($(this).siblings('ul').attr("style")=="display:none;"){
					$(this).siblings('ul').attr("style","display:block;");
					$(this)[0].className = 'icon-minus';
				}
			});

			$('#repeatReadKnowleage').on('click','.icon-minus',function () {
				if($(this).siblings('ul').attr("style")=="display:block;"){
					$(this).siblings('ul').attr("style","display:none;");
					$(this)[0].className = 'icon-plus';
				}
			});

			//操作“要上门的”和“重点跟进的”
			$('#remindModal').on('click','input[name="check_set_view"]',function() {
				if(this.checked){
					$(this).siblings('input[name="is_set_view"]').val(1);
				}else{
					$(this).siblings('input[name="is_set_view"]').val(0);
				}
			});

			$('#remindModal').on('click','input[name="check_important"]',function() {
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