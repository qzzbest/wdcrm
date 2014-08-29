<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>客户缴费记录列表</title>
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
		

		<link rel="stylesheet" href="<?php echo base_url('assets/css/datepicker.css');?>" />
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="<?php echo base_url('assets/js/ace-extra.min.js');?>"></script>

		<!--时间选择（时-分-秒）-->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/datepicker.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-timepicker.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/daterangepicker.css');?>" />

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<style type="text/css">
		.life_info th{
			text-align: center;
		}
		.weight{
			font-weight: bold;
		}
		.right{
			float: right;
			margin-bottom:5px;
			margin-right:5px;
		}
		.none{
			display: none;
		}
		.smaller-75{
			font-size: 14px;
		}
		.addpay{
			margin-left: 277px;
		}
		.width145{
			width: 138px;
		}
		.width167{
			width: 167px;
		}
		.modal-dialog{
			width: 720px;
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
								<a href="#">主页</a>
							</li>
							<?php $this->load->view('url');?>
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>

						
					</div>

					<div class="page-content">
						<small>
							<h4 class="weight">客户姓名:<?php echo $consultant_info['consultant_name'];?>
								<a class="btn btn-xs btn-info" role="button" href="<?php echo site_url(module_folder(2).'/client_project/index/'.$consultant_info['consultant_id']);?>">项目列表</a>
							</h4>
						</small>
					
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<?php foreach ($list as $key => $value) { ?>
											<div style="border:1px dashed #999; padding:20px; margin-bottom:20px;">
												<?php if($value['is_fail'] == 1){?>
												<div style="float:right;">
												<button class="btn btn-xs btn-purple" data-toggle="modal" data-target="#delete_pay" action_type=2 data-id="<?php echo $value['repayment_id'];?>" data-money="<?php echo $value['already_payment'];?>">退费</button>
												</div>
												<?php }?>
												<?php
												$project_name = isset($value['project_info']['project_name']) ? $value['project_info']['project_name'] : '';
												$project_url = isset($value['project_info']['project_url']) ? $value['project_info']['project_url'] : '';
												$project_remark = isset($value['project_info']['project_remark']) ? $value['project_info']['project_remark'] : '';

													$str =  '项目名称：'.$project_name.'<br />';
													$str .=  '项目参考网址：<a href="'.$project_url.'" target="_blank">'.$project_url.'</a><br />';
													$str .=  '项目备注：'.$project_remark.'<br />';
													$str .= '缴费类型：'.$value['payment_type_name'];
													$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
													$str .= '项目总费用：'.$value['study_expense'].' 元';
													$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
													$str .= '已缴费用是：'.$value['already_payment'].' 元';
													$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

													if($value['pay_money'] < 0){
														$str .= '您现在的费用超出金额 '.abs($value['pay_money']).' 元';
													}else{
														$str .= '还需要缴费的金额是：'.$value['pay_money'].' 元';
													}
													$str .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
													//是否缴清情况
													if($value['payment_status'] == 1){
														$str .= '<font color="green" size="4"><b>已缴清</b></font>';
													}elseif($value['payment_status'] == 2){
														$str .= '<font color="blue" size="4"><b>已超额</b></font>';
													}else{
														$str .= '<font color="red" size="4"><b>未缴清</b></font>';
													}
													echo $str;
												?>	
												<?php if($value['is_fail'] == 1){?>
												<a class="btn btn-xs btn-warning course_info right" href="<?php echo site_url(module_folder(2).'/client_project/edit/'.$value['consultant_id'].'/'.$value['repayment_id']);?>">修改项目</a>
												<?php }?>
											<?php if($value['payment_type_id'] == 1){ ?>
												<!-- 一次性付款 -->
												<?php if($value['is_fail'] == 1){?>
												<button data-toggle="modal" data-target="#disposable_pay" type="button" data-paydisid="<?php echo $value['repayment_id'];?>"  class="btn btn-xs btn-primary right">添加项目费用</button>
												<?php }?>
												<div class="table-responsive">
												<table id="sample-table-1" class="table table-striped table-bordered table-hover table-condensed">
													<thead>
														<tr>
															<th class="center">序号</th>
															<th class="center hidden-480">项目总费用(元)</th>
															<th class="center hidden-480">项目备注</th>
															<th class="center hidden-480">缴费金额(元)</th>
															<th class="center hidden-480">完成缴费日期</th>
															<th class="center">缴费类型</th>
															<th class="center">操作</th>
														</tr>
													</thead>
													<tbody>
														<?php foreach($value['refund_loan_time'] as $k=>$item){ 
															if($value['repayment_id'] == $item['repayment_id']){
															?>
															<tr>
																<td class="center">
																	<?php echo $item['serial_number'];?>
																</td>

																<td class="center">
																	<?php echo $value['study_expense'];?>
																</td>

																<td class="center">

																	<?php
																		echo $item['payment_desc'];
																	?>

																</td>
																
																<td class="center">
																	<?php echo $item['payment_money'];?>
																</td>

																<td class="center">
																	<?php

																		if(!empty($item['already_paytime'])){
																			echo date('Y-m-d',$item['already_paytime']);
																		}else{
																			echo '';
																		}
																		
																	?>
																	
																</td>
																<td class="center">
																	<?php 
																		if($item['payment_status']==2){
																			echo "退费";
																		}else{
																			echo $item['payment_type_name'];
																		}
																	?>
																</td>

																<td class="center">
																<?php if($item['payment_status']!=2 && $value['is_fail'] == 1){?>
																	<button class="btn btn-xs btn-purple" data-toggle="modal" data-target="#edit_pay_one" data-id="<?php echo $item['id'];?>">修改</button>
																	<button class="btn btn-xs btn-purple" data-toggle="modal" data-target="#delete_pay" action_type=1 data-id="<?php echo $item['id'];?>">退费</button>
																<?php }?>
																<?php if($value['is_fail'] == 1){?>
																<button class="btn btn-xs btn-purple" data-toggle="modal" data-target="#delete_pay2" action_type=3 data-id="<?php echo $item['id'];?>">删除</button>
																<?php }?>	
																</td>
															</tr>
														<?php }
														}?>
													</tbody>
												</table>


												</div><!-- /.table-responsive -->
											<?php }else if($value['payment_type_id'] == 2){ ?>
											
											<!-- 分期付款 -->
											<?php if($value['is_fail'] == 1){?>
											<button data-toggle="modal" data-target="#editmoney_content" type="button" data-payid="<?php echo $value['repayment_id'];?>"  class="btn btn-xs btn-primary right">添加分期付款</button>
											<?php }?>
											<div class="table-responsive">
												<table id="sample-table-1" class="table table-striped table-bordered table-hover">
													<thead>	
														<tr>
															<th class="center">序号</th>
															<th class="center">项目总费用(元)</th>
															<th class="center">项目备注</th>
															<th class="center">应缴费金额(元)</th>
															<th class="center">应缴费用日期</th>
															<th class="center">完成缴费日期</th>
															<th class="center">是否按时</th>
															<th class="center">缴费类型</th>
															<th class="center">操作</th>
														</tr>
													</thead>

													<tbody>
													<?php foreach($value['refund_loan_time'] as $k=>$item){ 
														if($value['repayment_id'] == $item['repayment_id']){
														?>
														<tr>
															<td class="center">
																<?php echo $item['serial_number'];?>
															</td>


															<td class="center">
																<?php echo $value['study_expense'];?>
															</td>

															<td class="center">

																<?php
																	echo $item['payment_desc'];
																?>

															</td>
															
															<td class="center">
																<?php echo $item['payment_money'];?>
															</td>
															
															<td class="center">
																<?php
																	if(!empty($item['payment_time'])){
																		echo date('Y-m-d',$item['payment_time']);
																	}else{
																		echo '无';
																	}
																?>
															</td>
																											
															<td class="center">
																<?php
																	if(!empty($item['already_paytime'])){
																		echo date('Y-m-d',$item['already_paytime']);
																	}else{
																		echo '无';
																	}
																?>
															</td>

															<td class="center">
																<?php
																	if( empty($item['payment_time']) || empty($item['already_paytime']) ){
																		echo '无';
																	}else{
																		
																		if($item['payment_time'] >= $item['already_paytime']){
																			echo '√';
																		}else{
																			echo '×';
																		}
																	}
																?>
																
															</td>
															<td class="center">
																<?php 
																	echo $item['payment_type_name'];
																	if($item['payment_type'] == 0){
																		echo '（学费）';
																	}
																?>
															</td>
															<!-- <td class="center">
																<?php if($item['payment_status'] == 0){
																	echo '未完成缴费';
																}else{
																	echo '已完成缴费';
																}?>
															</td> -->
															<td class="center">
																<?php if($item['payment_status'] == 0){?>
																<button class="btn btn-xs btn-purple" data-toggle="modal" data-target="#complete_pay" data-money="<?php echo $item['payment_money'];?>" data-id="<?php echo $item['repayment_id'];?>" pay-id="<?php echo $item['id'];?>" type-id="<?php echo $item['payment_type_id'];?>">完成缴费</button>
																<?php }?>
																<button class="btn btn-xs btn-purple" data-toggle="modal" data-target="#edit_pay_two" data-money="<?php echo $item['payment_money'];?>" data-id="<?php echo $item['repayment_id'];?>" pay-id="<?php echo $item['id'];?>">修改</button>
																<?php if($item['payment_status'] != 0){?>
																<button class="btn btn-xs btn-purple" data-toggle="modal" data-target="#delete_pay" action_type=1 data-money="<?php echo $item['payment_money'];?>" data-id="<?php echo $item['id'];?>">退费</button>
																<?php }?>

																<?php if($value['is_fail'] == 1){?>
																<button class="btn btn-xs btn-purple" data-toggle="modal" data-target="#delete_pay2" action_type=1 data-money="<?php echo $item['payment_money'];?>" data-id="<?php echo $item['id'];?>">删除</button>
																<?php }?>
															</td>
														</tr>
													<?php }
													}?>

													</tbody>
												</table>
											</div><!-- /.table-responsive -->
											<?php }?>
											</div>
										<?php }?>	
									</div><!-- /span -->
									<div class="col-sm-12">
										<div class="dataTables_paginate paging_bootstrap">
											<?php echo $page;?>
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
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		
		<div class="modal fade" id="disposable_pay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
		        <h4 class="modal-title">添加新项目</h4>

		      </div>
		      <form action="<?php echo site_url(module_folder(2).'/project_payment/installDisposable');?>" method="post"  id="installmentsEdit">
		      <div class="modal-body" id="modal-disbody">
		       	
		      </div>	
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		        <button type="submit" class="btn btn-primary">保存</button>
		      </div>
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- 分期付款弹出框	  -->
		<div class="modal fade" id="editmoney_content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
		        <h4 class="modal-title" id="myModalLabel">添加分期缴费</h4>

		      </div>
		      <form action="<?php echo site_url(module_folder(2).'/project_payment/installmentsEdit');?>" method="post" id="installmentAjax">
		      <div class="modal-body" id="modal-body">
		       	
		      </div>	
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		        <button type="submit" class="btn btn-primary">保存</button>
		      </div>
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- 完成缴费确认框 -->
		<div class="modal fade" id="complete_pay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
		        <h4 class="modal-title">请完成缴费</h4>

		      </div>
		      <form action="" method="post" id="complete_form">
		      <input type="hidden" id="payment_id" name="payment_id" value="" />
		      <input type="hidden" id="money" name="money" value="" />
		      <input type="hidden" id="time_id" name="time_id" value="" />
		       <input type="hidden" id="payment_type_id" name="payment_type_id" value="" />
		      <div class="modal-body" id="modal-combody">
		      	<div>您需要缴<span id="complete_money"></span>元，请确认完成缴费！</div><br />
		      	<div>请确认缴费日期：<input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="" name="already_paytime" placeholder="缴费日期"></div>
		      </div>	
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		        <button type="button" class="btn btn-primary" id="complete_submit">保存</button>
		      </div>
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- 删除缴费确认框 -->
		<div class="modal fade" id="delete_pay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
		        <h4 class="modal-title">请选择删除缴费时间</h4>

		      </div>
		      <form action="" method="post" id="delete_form">
		      <input type="hidden" id="payment_id" name="payment_id" value="" />
		      <input type="hidden" id="action_type" name="action_type" value="" />
		      <div class="modal-body" id="modal-combody">
		        <div id="delete_paymoney" style="display:none;margin-bottom:10px;">请填写退费金额：<input type="text" value="" name="delete_paymoney" placeholder="请填写退费金额" id="payment_money" /> 元</div>
		      	<div>请确认删除日期：<input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="" name="delete_paytime" placeholder="删除缴费日期"></div>
		      </div>	
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		        <button type="button" class="btn btn-primary" id="delete_submit">保存</button>
		      </div>
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- 修改缴费确认框 -->
		<div class="modal fade" id="edit_pay_one" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
		        <h4 class="modal-title">请修改缴费</h4>

		      </div>
		      <form action="" method="post" id="pay_one_form">
		      <!-- <input type="hidden" id="one_payment_id" name="payment_id" value="" />
		      <div class="modal-body" id="modal-body_one">
		      	<table style="margin: 0px auto;">
				<tr>
					<th class="center">缴费日期</th>
					<th class="center">缴费金额(元)</th>
					<th class="center">学费说明</th>
				</tr>
				<tr>
					<td><input type="text" class="date-picker col-xs-12" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="" name="payment_time" placeholder="缴费日期" /></td>
					<td><input type="text" class="col-xs-12" value="" name="payment_money" placeholder="缴费金额" /></td>
					<td><input type="text" class="col-xs-12" name="payment_desc" value="" placeholder="学费说明" /></td>
				</tr>
				</table>
				<input type="hidden" name="payment_type_id" value="" />
		      </div>	
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		        <button type="button" class="btn btn-primary" id="pay_one_submit">保存</button>
		      </div> -->
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<!-- 修改分期缴费确认框（two） -->
		<div class="modal fade" id="edit_pay_two" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
		        <h4 class="modal-title">请修改缴费</h4>

		      </div>
		      <form action="" method="post" id="pay_two_form">
			    
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- 修改分期缴费确认框（three） -->
		<div class="modal fade" id="edit_pay_three" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				
		        <h4 class="modal-title">请修改缴费</h4>

		      </div>
		      <form action="" method="post" id="pay_three_form">
		      <input type="hidden" id="three_payment_id" name="payment_id" value="" />
		      <div class="modal-body" id="modal-body_three">
		      	<table style="margin: 0px auto;">
				<tr>
					<th class="center">缴费日期</th>
					<th class="center">缴费金额(元)</th>
					<th class="center">提醒时间</th>
					<th class="center">学费说明</th>
				</tr>
				<tr>
					<td><input type="text" class="date-picker col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="" name="payment_time" placeholder="缴费日期" /></td>
					<td><input type="text" class="col-xs-12 width145" value="" name="payment_money" placeholder="缴费金额" /></td>
					<td><input type="text" class="col-xs-12 width145" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time" value="" placeholder="提醒时间" /></td>
					<td><input type="text" class="col-xs-12 width145" name="payment_desc" value="" placeholder="学费说明" /></td>
				</tr>
				</table>
				<input type="hidden" name="payment_type_id" value="" />
		      </div>	
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		        <button type="button" class="btn btn-primary" id="pay_three_submit">保存</button>
		      </div>
		      </form>
		    </div><!-- /	.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- 弹出框(次性付款、先就业后付款(包吃住)、先就业后付款(不包吃住)) -->
		<textarea name="disposable" style="display:none;">
			<tr>
		 		<td><input type="text" data-target="#dateShow" class="col-xs-12 width145" data-date-format="yyyy/mm/dd" name="payment_time[]" placeholder="缴费日期" /></td>
  		 		<td><input type="text" name="payment_money[]" class="col-xs-12 width145" placeholder="缴费金额" /></td>
  		 		<td><input type="text" class="col-xs-12 width145" name="payment_desc[]" placeholder="学费说明" /></td>
  		 		<td>
  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
						<i class="icon-minus smaller-75"></i>
					</button>
				</td>
  		 	</tr>
		</textarea>
		<!-- 分期付款输入框 -->
		<textarea name="installments"style="display:none;">
			<tr>
		 		<td><input type="text" data-target="#dateShow" class="col-xs-12 width145" data-date-format="yyyy/mm/dd" name="payment_time[]" placeholder="应缴费日期" /></td>
  		 		<td><input type="text" name="payment_money[]" class="col-xs-12 width145" placeholder="应缴费金额" /></td>
  		 		<td><input type="text" data-target="#dateShow" class="col-xs-12 width145" data-date-format="yyyy/mm/dd" name="remind_time[]" placeholder="提醒时间" /></td>
  		 		<td><input type="text" class="col-xs-12 width145" name="payment_desc[]" placeholder="缴费说明" /></td>
  		 		<td>
  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
						<i class="icon-minus smaller-75"></i>
					</button>
				</td>
  		 	</tr>
		</textarea>

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
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>

		<!--弹出确定框需要的js-->
		<script src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
	
		
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			

				$('.icon-edit').click(function(){
					window.location.href="<?php echo site_url(module_folder(2).'/client_project/edit');?>";
				});
				
			
				//折叠
				$("#menu ul").attr("style","display:none;");
				function zd(obj){
					if($(obj).siblings('ul').attr("style")=="display:none;"){
						$(obj).siblings('ul').attr("style","display:block;");
					}else{
						$(obj).siblings('ul').attr("style","display:none;");
					}
				}

				
	
				$(".delete_consultant").on(ace.click_event, function() {
					bootbox.confirm("Are you sure?", function(result) {
						if(result) {
							window.location.href="<?php echo site_url(module_folder(2).'/advisory/delete');?>";
						}
					});
				});

				//ajax获取用户信息		
				$('.life_help_info').click(function(){
					var repayment_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student_payment/info');?>",
				        data: "repayment_id="+repayment_id,
				        dataType:'json',
				        success: function(res){
				       		$("#life_help_info").find('.modal-body').html(res.data); 
				        }
			   		});
				});

				$('input[data-target="#dateShow"]').datepicker();

				$('input[data-target="#dateShow"]').focus(function(){

					$('.dropdown-menu').css('z-index',1060);

				});
			

			});	
	
		/**
		 *	分期付款/先就业后付款(包吃住)
		 *
		 */
		jQuery(function($){
				/**
				 * 添加分期付款输入框
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
						
						$('input[data-target="#dateShow"]').datepicker();

						$('input[data-target="#dateShow"]').focus(function(){

							$('.dropdown-menu').css('z-index',1060);

						});

						_this.id.click(function(){ //绑定点击事件
							var z=$(this).next('table').children('tbody');

							z.append(_this.content);

							$('input[data-target="#dateShow"]').datepicker();

							$('input[data-target="#dateShow"]').focus(function(){

								$('.dropdown-menu').css('z-index',1060);

							});
						});
						
					}
				}


				$('button[data-target="#disposable_pay"]').click(function(){
				
					var paydisid=parseInt($(this).attr("data-paydisid"));

					var consultant_id = "<?php echo $consultant_info['consultant_id'];?>";
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/project_payment/disposableAjax');?>",
				        data: "id="+paydisid+"&consultant_id="+consultant_id,
				        dataType:'json',
				        success: function(res){
				       		if(res.status==0){return ;}
				       		$('#modal-disbody').html(res.data);
				       		new AddInput('#moneyAdd',res.content).add();


				        }
			   		});
				});

				$('button[data-target="#editmoney_content"]').click(function(){
				
					var payid=parseInt($(this).attr("data-payid"));

					var consultant_id = <?php echo $consultant_info['consultant_id'];?>;
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/project_payment/installmentAjax');?>",
				        data: "id="+payid+"&consultant_id="+consultant_id,
				        dataType:'json',
				        success: function(res){
				       		if(res.status==0){return ;}
				       		$('#modal-body').html(res.data);
				       		
				       		new AddInput('#moneyAdd',res.content).add();

				        }
			   		});
				});

				//点击弹出确定框，确定完成缴费
				$('button[data-target="#complete_pay"]').click(function(){
					var complete_money = $(this).attr('data-money');
					var payment_id = $(this).attr('pay-id');
					var payment_type_id = $(this).attr('type-id');
					$('#payment_id').val(payment_id);
					$('#time_id').val(payment_id);
					$('#money').val(complete_money);
					$('#complete_money').html(complete_money);
					$('#payment_type_id').val(payment_type_id);
					$('input[name="already_paytime"]').val("<?php echo date('Y/m/d',time());?>");
				});

				//点击弹出确定框，修改缴费
				$('button[data-target="#edit_pay_one"]').click(function(){
					var applyid = $(this).attr('data-id');
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/project_payment/payinfoAjax');?>",
				        data: "id="+applyid,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==0){return ;}
				        	$('#pay_one_form').html(res.str);        	
				        }
			   		});

				});

				//点击弹出确定框，修改分期缴费
				$('button[data-target="#edit_pay_two"]').click(function(){
					var applyid = $(this).attr('pay-id');
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/project_payment/payinfoAjax');?>",
				        data: "id="+applyid,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==0){return ;}
				        	
				        	if(res){
				        		$('#pay_two_form').html(res.str);
				        	}
				        	        	
				        }
			   		});
				});

				//点击弹出确定框，确定就批量删除咨询者
				$('button[data-target="#delete_pay"]').click( function() {
					var payment_id = $(this).attr('data-id');
					var payment_money = $(this).attr('data-money');
					var action_type = $(this).attr('action_type');
					$('#payment_id').val(payment_id);
					$('#payment_money').val(payment_money);
					$('#action_type').val(action_type);
					if(action_type==1){
						$('#delete_paymoney').css('display','none');
					}else if(action_type==2){
						$('#delete_paymoney').css('display','block');
					}
					$('input[name="delete_paytime"]').val("<?php echo date('Y/m/d',time());?>");
				});

				//完成分期付款操作
				$('#delete_submit').click(function () {			
					var payment_id = $('#payment_id').val();
					var action_type = $('#action_type').val();
					var delete_paytime = $('input[name="delete_paytime"]').val();
					var delete_paymoney = $('input[name="delete_paymoney"]').val();

					if(action_type==1){
						var url = "<?php echo site_url(module_folder(2).'/project_payment/delete');?>";
					}else if(action_type==2){
						if(delete_paymoney==''){
							alert("请填写退费金额");
							return false;
						}else{
							var url = "<?php echo site_url(module_folder(2).'/project_payment/delete_paycord');?>";
						}
					}
					$.ajax({
				        type: "POST",
				        url: url,
				        data: "payment_id="+payment_id+"&paytime="+delete_paytime+"&delete_paymoney="+delete_paymoney,
				        dataType:'json',
				        success: function(res){
				        	if(res.data == 1){
				        		alert('退费成功！');
				       			location.reload();
				       		}else{
				       			alert('退费金额超过已缴金额！');
				       			//location.reload();
				       		}
				        }
			   		});
				});

				//弹出框(处理 一次性付款、先就业后付款(包吃住)、先就业后付款(不包吃住))
				$('#pay_one_submit').click(function () {
					
					var payment_id = $('#one_payment_id').val();
					var payment_time = $('#pay_one_form input[name="payment_time"]').val();
					var payment_money = $('#pay_one_form input[name="payment_money"]').val();
					var payment_desc = $('#pay_one_form input[name="payment_desc"]').val();
					var payment_type_id = $('#pay_one_form input[name="payment_type_id"]').val();
					
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student_payment/actionPayment');?>",
				        data: "payment_id="+payment_id+"&payment_time="+payment_time+"&payment_money="+payment_money+"&payment_desc="+payment_desc+"&type=one&payment_type_id="+payment_type_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.data == 1){
				       			location.reload();
				       		}
				        }
			   		});
				});

				

				//完成分期付款操作
				$('#complete_submit').click(function () {
					
					var payment_id = $('#payment_id').val();
					var time_id = $('#time_id').val();
					var money = $('#money').val();
					var already_paytime = $('input[name="already_paytime"]').val();
					var payment_type_id = $('input[name="payment_type_id"]').val();

					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/project_payment/actionPayment');?>",
				        data: "payment_id="+payment_id+"&time_id="+time_id+"&money="+money+"&paytime="+already_paytime+"&payment_type_id="+payment_type_id+"&type=two",
				        dataType:'json',
				        success: function(res){
				        	if(res.data == 1){
				       			location.reload();
				       		}else if(res.data == 'no'){ //暂时处理
				       			alert('该记录有问题，暂时不能处理！');
				       			location.reload();
				       		}
				        }
			   		});
				});

				$('button[data-target="#delete_pay2"]').click( function() {

					var pay_id = parseInt($(this).attr("data-id"));

					bootbox.confirm("你确定删除该缴费记录吗?", function(result) {
						if(result) {
							$.ajax({
						        type: "POST",
						        url: "<?php echo site_url(module_folder(2).'/project_payment/delete_pay');?>",
						        data: "pay_id="+pay_id,
						        dataType:'json',
						        success: function(res){
						        	if(res.data == 1){
						        		alert('删除成功！');
						       			location.reload();
						       		}
						        }
					   		});
						}
					});
				});

		});

		</script>
</body>
</html>
