<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>编辑课程</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="<?php echo base_url('assets/css/bootstrap.min.css" rel="stylesheet');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

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
		#menu li{
			list-style: none;
			line-height: 30px;
		}
		#menu li.second{
			float:left;
			margin-right: 10px;
		}
		.clear{
			clear: both;
		}
		#menu li span.lbl{
			line-height:21px;
		}
		#menu{margin:0px;}
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
							<li class="active">编辑课程</li>
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>
					</div>

					<div class="page-content">

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" action="<?php echo site_url(module_folder(2).'/student_course/edit');?>" method="post" id="setStudent">
									<input type="hidden" name="old_payment_type_id" value="<?php echo $list['payment_type_id'];?>" />
									<input type="hidden" name="old_id" value="<?php if(!empty($min_info)){echo $min_info[0]['id'];}?>" />
									<div class="form-group">
										<label class="col-sm-4 control-label">
											学生姓名:<?php echo $name['student_name'];?>
										</label>
									</div>
						          	<input type="hidden" id="student_id" name="student_id" value="<?php echo $uid;?>" />
						          	<input type="hidden" id="student_id" name="repayment_id" value="<?php echo $id;?>" />
						          	<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2" id="course">选择课程：</label><span style="color: rgb(209, 110, 108); float:right; padding-right:125px;"></span>
										<div class="col-sm-7">
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
												        			<input type="checkbox" class="ace" name="knowledge_name[<?php echo $value['curriculum_system_id'];?>][]" value="<?php echo $v['knowledge_id'];?>" data-invent="test" />
												        			
												        			<span class="lbl"> <?php echo $v['knowledge_name'];?> </span>
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
						          	<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">课程备注：</label>

										<div class="col-sm-6">
											<textarea name="course_remark" class="form-control" id="form-field-8" placeholder="根据选择的课程，可添加课程备注"><?php echo $list['course_remark'];?></textarea>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">应缴学费：</label>

										<div class="col-sm-6">
											<input type="text" name="tuition_total" placeholder="请输入应缴学费" value="<?php echo $list['study_expense'];?>" id="tuition_total" type-data="false" /> 元
											<div class="col-sm-5" style="float:right; width:57%"></div>
										</div>
										
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">已缴学费总额：</label>

										<div class="col-sm-2">
											<?php echo $list['already_payment'];?> 元
										</div>
										
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">学费说明：</label>

											<div class="col-sm-6">
							      				<input type="text" name="payment_desc" value="<?php if(!empty($min_info)){echo $min_info[0]['payment_desc'];}?>" placeholder="学费说明" />(注释： ....)
							      			</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">缴费日期：</label>
										<div class="col-sm-4">
											<input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="course_payment_time" value="<?php if(!empty($min_info)){echo date('Y/m/d',$min_info[0]['already_paytime']);}else{echo date('Y/m/d');}?>" placeholder="缴费日期" />
										</div>
						  			</div>
						  			<div class="space-4"></div>

						  			<div class="form-group">
						  				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">
						  					<select name="select_type">
						  						<?php 
						  							if(!empty($min_info) && $min_info[0]['payment_type'] == 0){
						  								echo '<option value="0" selected="selected">学 费</option><option value="1">定位费</option>';
						  							}elseif(!empty($min_info) && $min_info[0]['payment_type'] == 2){
						  								echo '<option value="0">学 费</option><option value="1" selected="selected">定位费</option>';
						  							}else{
						  								echo '<option value="0">学 费</option><option value="1">定位费</option>';
						  							}
						  						?>
											</select>
						  				</label>
						  				<div class="col-sm-6">
						      				<input type="text" name="already_total" value="<?php if(!empty($min_info) && $min_info[0]['payment_money'] != 0){echo $min_info[0]['payment_money'];}?>" placeholder="请输入学费"  id="already_total" /> 元
							      			<div class="col-sm-5" style="margin-right:70px; float:right;">		
											</div>
										</div>
									</div>
									<div class="space-4"></div>

						  			<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">缴费类型：</label>

										<div class="col-sm-7">
											<?php foreach ($payment_type_info as $key => $value) { ?>
											<label style="padding-right:20px;">
												<input name="payment_type_id" data-target="payment_type_id" type="radio" value="<?php echo $value['payment_type_id'];?>" class="ace" <?php if($value['payment_type_id'] == $list['payment_type_id']){echo 'checked=checked';}?> />
												<span class="lbl"> <?php echo $value['payment_type_name'];?></span>
											</label>
										<?php } ?>
										</div>
										<div class="modal-body" data-target="tabChange" id="tabChange" style="clear:both;">
											<table style="display:none; margin: 0 auto;" id="payment_two">
												<tr>
													<td colspan="5" align="center"><h4 style="font-weight:bold;"></h4>
														<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success">
																<i class="icon-plus">添加分期付款</i>
														</button>
													</td>
												</tr>
												
												<?php
												if(!empty($refund_loan_info) && $list['payment_type_id'] == 2){ ?>
												<tr>
													<th class="center">应缴费日期</th>
													<th class="center">应缴费金额(元)</th>
													<th class="center">提醒时间</th>
													<th class="center">学费说明</th>
													<th></th>	
												</tr>
												<?php foreach ($refund_loan_info as $key => $value) {
													if($value['payment_type_id'] == 2){
													?>
													<?php if($value['payment_status'] == 1){?>
												 	<tr>
												 		<td><input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time1[]" placeholder="应缴费日期" value="<?php if(!empty($value['payment_time'])){echo date('Y/m/d',$value['payment_time']);;}?>" disabled="disabled" /></td>
												 		<td><input type="text" name="payment_money1[]" placeholder="应缴费金额" value="<?php echo $value['payment_money'];?>" disabled="disabled" />元</td>
												 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time1[]" placeholder="提醒时间" value="<?php if(!empty($value['remind_time'])){echo date('Y/m/d',$value['remind_time']);}?>" disabled="disabled" /></td>
												 		<td><input type="text" name="payment_desc1[]" placeholder="学费说明" value="<?php echo $value['payment_desc'];?>" disabled="disabled" /></td>
												 		<td>
												 			已完成
														</td>
												 	</tr>
												 	<?php }else{?>
													<tr>
												 		<td><input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="update_payment_time1[<?php echo  $value['id'];?>]" placeholder="应缴费日期" value="<?php if(!empty($value['payment_time'])){echo date('Y/m/d',$value['payment_time']);;}?>" /></td>
												 		<td><input type="text" name="update_payment_money1[<?php echo  $value['id'];?>]" placeholder="应缴费金额" value="<?php echo $value['payment_money'];?>" />元</td>
												 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="update_remind_time1[<?php echo  $value['id'];?>]" placeholder="提醒时间" value="<?php if(!empty($value['remind_time'])){echo date('Y/m/d',$value['remind_time']);}?>" /></td>
												 		<td><input type="text" name="update_payment_desc1[<?php echo  $value['id'];?>]" placeholder="学费说明" value="<?php echo $value['payment_desc'];?>" /></td>
												 		<td>
															<button type="button" onclick="wdcrm.removeInput(this,2);" class="del_payment btn spinner-down btn-xs btn-danger" pid="<?php echo $value['id'];?>">
																<i class="icon-minus smaller-75"></i>
															</button>	
														</button>
														</td>
												 	</tr>
												 	<?php } }?>
											 	<?php }
											 	}?>
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
													<td><input type="text" name="apply_money1" placeholder="申请额度" value="<?php if(!empty($list['apply_money'])){echo $list['apply_money'];}?>" /></td>
													<td><input type="text" data-date-format="yyyy/mm/dd" name="organization_paydate1" placeholder="机构代还时间段" value="<?php echo $list['organization_paydate'];?>" /></td>
													<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="student_start_paydate1" placeholder="开始还款日期" value="<?php if(!empty($list['student_start_paydate'])){echo date('Y/m/d',$list['student_start_paydate']);}?>" /></td>
													<td><input type="text" name="apply_desc1" placeholder="备注" value="<?php echo $list['apply_desc'];?>" /></td>
													<td></td>
												</tr>
												<tr>
													<td colspan="4" align="center"><h4 style="font-weight:bold;">生活补贴</h4>
													<button data-target="#employment_credit" type="button" class="btn spinner-up btn-xs btn-success">
															<i class="icon-plus">添加生活补贴</i>
													</button>
													</td>
												</tr>
												
												<?php
												if(!empty($refund_loan_info)  && $list['payment_type_id'] == 3){?>
												<tr>
													<th class="center">补贴日期</th>
														<th class="center">补贴金额(元)</th>
														<th class="center">提醒时间</th>
														<th class="center">补贴说明</th>
													<th></th>
												</tr>

												<?php foreach ($refund_loan_info as $key => $value) {
													if($value['payment_type_id'] == 3){
													?>
													<?php if($value['payment_status'] == 1){?>
													<tr>
													 	<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time2[]" placeholder="补贴日期" value="<?php if(!empty($value['payment_time'])){echo date('Y/m/d',$value['payment_time']);}?>" disabled="disabled" /></td>
													 		<td><input type="text" name="payment_money2[]" placeholder="补贴金额" value="<?php echo $value['payment_money'];?>" disabled="disabled" />元</td>
													 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time2[]" placeholder="提醒时间" value="<?php if(!empty($value['remind_time'])){echo date('Y/m/d',$value['remind_time']);}?>" disabled="disabled" /></td>
													 		<td><input type="text" name="payment_desc2[]" placeholder="补贴说明" value="<?php echo $value['payment_desc'];?>" disabled="disabled" /></td>
													 		<td>
													 			已补贴
															</button>
														</td>
													</tr>
													<?php }else{?>
													<tr>
													 	<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="update_payment_time2[<?php echo  $value['id'];?>]" placeholder="补贴日期" value="<?php if(!empty($value['payment_time'])){echo date('Y/m/d',$value['payment_time']);}?>" /></td>
												 		<td><input type="text" name="update_payment_money2[<?php echo  $value['id'];?>]" placeholder="补贴金额" value="<?php echo $value['payment_money'];?>" />元</td>
												 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="update_remind_time2[<?php echo  $value['id'];?>]" placeholder="提醒时间" value="<?php if(!empty($value['remind_time'])){echo date('Y/m/d',$value['remind_time']);}?>" /></td>
												 		<td><input type="text" name="update_payment_desc2[<?php echo  $value['id'];?>]" placeholder="补贴说明" value="<?php echo $value['payment_desc'];?>" /></td>
												 		<td>
															<button type="button" onclick="wdcrm.removeInput(this,2);" class="del_refund btn spinner-down btn-xs btn-danger" pid="<?php echo $value['id'];?>">
																<i class="icon-minus smaller-75"></i>
															</button>
														</td>
													</tr>
													<?php } }?>
												<?php }
												}?>
											</table>
											<table style="display:none; margin: 0 auto;">
												<tr>
													<th class="center">申请额度</th>
													<th class="center">机构代还时间段</th>
													<th class="center">开始还款日期</th>
													<th class="center">备注</th>
												</tr>
												<tr>
													<td><input type="text" name="apply_money2" placeholder="申请额度" value="<?php if(!empty($list['apply_money'])){echo $list['apply_money'];}?>" /></td>
													<td><input type="text" name="organization_paydate2" placeholder="机构代还时间段"  value="<?php echo $list['organization_paydate'];?>" /></td>
													<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="student_start_paydate2" placeholder="开始还款日期" value="<?php if(!empty($list['student_start_paydate'])){echo date('Y/m/d',$list['student_start_paydate']);}?>" /></td>
													<td><input type="text" name="apply_desc2" placeholder="备注" value="<?php echo $list['apply_desc'];?>" /></td>
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
													<td><input type="text" name="apply_money3" placeholder="申请额度" value="<?php if(!empty($list['apply_money'])){echo $list['apply_money'];}?>" /></td>
													<td><input type="text" data-date-format="yyyy/mm/dd" name="organization_paydate3" placeholder="机构代还时间段" value="<?php echo $list['organization_paydate'];?>" /></td>
													<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="student_start_paydate3" placeholder="开始还款日期" value="<?php if(!empty($list['student_start_paydate'])){echo date('Y/m/d',$list['student_start_paydate']);}?>" /></td>
													<td><input type="text" name="apply_desc3" placeholder="备注" value="<?php echo $list['apply_desc'];?>" /></td>
													<td></td>
												</tr>
												<tr>
													<td colspan="4" align="center"><h4 style="font-weight:bold;">工资补贴</h4>
													<button data-target="#wage" type="button" class="btn spinner-up btn-xs btn-success">
															<i class="icon-plus">添加工资补贴</i>
													</button>
													</td>
												</tr>
												
												<?php
												if(!empty($refund_loan_info)  && $list['payment_type_id'] == 5){?>
												<tr>
													<th class="center">补贴日期</th>
														<th class="center">补贴金额(元)</th>
														<th class="center">提醒时间</th>
														<th class="center">补贴说明</th>
													<th></th>
												</tr>

												<?php foreach ($refund_loan_info as $key => $value) {
													if($value['payment_type_id'] == 5){
													?>
													<?php if($value['payment_status'] == 1){?>
													<tr>
													 	<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time3[]" placeholder="补贴日期" value="<?php if(!empty($value['payment_time'])){echo date('Y/m/d',$value['payment_time']);}?>" disabled="disabled" /></td>
													 		<td><input type="text" name="payment_money3[]" placeholder="补贴金额" value="<?php echo $value['payment_money'];?>" disabled="disabled" />元</td>
													 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time3[]" placeholder="提醒时间" value="<?php if(!empty($value['remind_time'])){echo date('Y/m/d',$value['remind_time']);}?>" disabled="disabled" /></td>
													 		<td><input type="text" name="payment_desc3[]" placeholder="补贴说明" value="<?php echo $value['payment_desc'];?>" disabled="disabled" /></td>
													 		<td>
													 			已补贴
															</button>
														</td>
													</tr>
													<?php }else{?>
													<tr>
													 	<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="update_payment_time3[<?php echo  $value['id'];?>]" placeholder="补贴日期" value="<?php if(!empty($value['payment_time'])){echo date('Y/m/d',$value['payment_time']);}?>" /></td>
												 		<td><input type="text" name="update_payment_money3[<?php echo  $value['id'];?>]" placeholder="补贴金额" value="<?php echo $value['payment_money'];?>" />元</td>
												 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="update_remind_time3[<?php echo  $value['id'];?>]" placeholder="提醒时间" value="<?php if(!empty($value['remind_time'])){echo date('Y/m/d',$value['remind_time']);}?>" /></td>
												 		<td><input type="text" name="update_payment_desc3[<?php echo  $value['id'];?>]" placeholder="补贴说明" value="<?php echo $value['payment_desc'];?>" /></td>
												 		<td>
															<button type="button" onclick="wdcrm.removeInput(this,2);" class="del_refund btn spinner-down btn-xs btn-danger" pid="<?php echo $value['id'];?>">
																<i class="icon-minus smaller-75"></i>
															</button>
														</td>
													</tr>
													<?php } }?>
												<?php }
												}?>
											</table>
							          	</div>
							          	<div class="col-sm-5" style="float:right; clear: both;"></div>
									</div>
									<div class="space-4"></div>	
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1">特殊情况备注：</label>

										<div class="col-sm-6">
											<textarea name="special_payment_remark" class="form-control" id="form-field-8" placeholder="针对咨询者的情况备注信息"><?php echo $list['special_payment_remark'];?></textarea>
										</div>
									</div>

									<div class="space-4"></div>

							        
									<div class="clearfix">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="icon-ok bigger-110"></i>
												提交
											</button>
										</div>
									</div>
								</form>
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
		<!-- 临时数据存储地 ，分期付款 start -->
	
		<textarea name="installments" cols="30" rows="10" style="display:none;">
			<tr>
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="add_payment_time1[]" placeholder="应缴费日期" /></td>
  		 		<td><input type="text" name="add_payment_money1[]" placeholder="应缴费金额" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="add_remind_time1[]" placeholder="提醒时间" /></td>
  		 		<td><input type="text" name="add_payment_desc1[]" placeholder="学费说明" /></td>
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
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="add_payment_time2[]" placeholder="补贴日期" /></td>
  		 		<td><input type="text" name="add_payment_money2[]" placeholder="补贴金额" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="add_remind_time2[]" placeholder="提醒时间" /></td>
  		 		<td><input type="text" name="add_payment_desc2[]" placeholder="补贴说明" /></td>
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
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="add_payment_time3[]" placeholder="补贴日期" /></td>
  		 		<td><input type="text" name="add_payment_money3[]" placeholder="补贴金额" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="add_remind_time3[]" placeholder="提醒时间" /></td>
  		 		<td><input type="text" name="add_payment_desc3[]" placeholder="补贴说明" /></td>
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


		<!-- ace scripts -->

		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>

		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		<!-- 树状图 -->
		<script src="<?php echo base_url('assets/js/fuelux/data/fuelux.tree-sampledata.js');?>"></script>
		<script src="<?php echo base_url('assets/js/fuelux/fuelux.tree.min.js');?>"></script>
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>
		<script type="text/javascript">
			jQuery(function($){
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
						
					}

				}

				new checkTotal('tuition_total').add_blur();
				new checkTotal('already_total').add_blur();

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

				//全选、反选
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

				//选择知识点 =》选中课程
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

				//让课程和知识点选中
				$('input[name="course_name[]"]').each(function () {
					
					var str = '<?php echo $knowledge_info;?>';
					var z = JSON.parse(str);

					for(var i=0; i<z.length; i++){

						$('input[name="course_name[]"]').each(function () {
							
							if( this.value == z[i]['curriculum_system_id'] ){

								this.checked = true;

								$(this).siblings('ul').children('li').find(':checkbox').each(function(){

									if( wdcrm.in_array( this.value, z[i]['g_k'] ) ){
										this.checked = true;
									}

								});

							}
							

						});

					}
					
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
				new AddInput('#employment_credit','employment_credit').add();
				new AddInput('#wage','wage').add();


			});

			//缴费类型选项卡
			jQuery(function($){	

				$('input[data-target="payment_type_id"]').click(function(){

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

				//默认显示的缴费类型
				var payment_type_id = "<?php echo $list['payment_type_id'];?>";
				if(payment_type_id == 2){
					var z = $('div[data-target="tabChange"]').find('table').eq(0);
				}else if(payment_type_id == 3){
					var z = $('div[data-target="tabChange"]').find('table').eq(1);
				}else if(payment_type_id == 4){
					var z = $('div[data-target="tabChange"]').find('table').eq(2);
				}else if(payment_type_id == 5){
					var z = $('div[data-target="tabChange"]').find('table').eq(3);
				}
				
				if(payment_type_id != 1){
					z.show().siblings().hide();
				}

			});

			//时间选择插件
			jQuery(function($){			
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

				});

			});

			jQuery(function($){	
				/**
				 * ajax删除分期付款
				 */
				$('.del_payment').click(function(){
					var pid=parseInt($(this).attr("pid"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student_course/deletePayRef');?>",
				        data: "pid="+pid,
				        dataType:'json',
				        success: function(res){
				       		if(res.status==1){
				       			//alert("成功");
				       		}else if(res.status==0){
				       			//alert("失败");
				       		}else if(res.status=='no'){ //暂时处理
				       			alert('该记录有问题，暂时不能处理！');
				       			window.location.reload();
				       		}	
				        }
			   		});
				});

				/**
				 * ajax删除生活补贴
				 */
				$('.del_refund').click(function(){
					var pid=parseInt($(this).attr("pid"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student_course/deletePayRef');?>",
				        data: "pid="+pid,
				        dataType:'json',
				        success: function(res){
				       		if(res.status==1){
				       			//alert("成功");
				       		}else if(res.status==0){
				       			//alert("失败");
				       		}else if(res.status=='no'){ //暂时处理
				       			alert('该记录有问题，暂时不能处理！');
				       			window.location.reload();
				       		}	
				        }
			   		});
				});
			}); 
		</script>
</body>
</html>
