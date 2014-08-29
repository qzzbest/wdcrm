<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>添加新项目</title>
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
							<li class="active">添加新项目</li>
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>
					</div>

					<div class="page-content">

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" action="<?php echo site_url(module_folder(2).'/client_project/add');?>" method="post" id="setClient">
									<div class="form-group">
										<label class="col-sm-4 control-label" style="text-align:left;">
											客户姓名:<?php echo $name['consultant_name'];?>
										</label>
									</div>
						          	<input type="hidden" id="consultant_id" name="consultant_id" value="<?php echo $uid;?>" />
						          	<table cellpadding="5px" style="margin: 20px 10px 0px; width:593px;">
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
											<td>
												<span style=" float:left;">
													<input type="text" name="project_total_money" id="project_total_money" placeholder="请输入项目总费用" /> 元
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
											<td valign="top" align="right">特殊情况备注：</td>
											<td width="300px">
												<textarea style="width: 500px;height: 119px;" name="project_payment_remark" class="form-control" id="form-field-8" placeholder="针对客户的情况备注信息"></textarea>
											</td>
										</tr>
									</table>

									<div class="clearfix">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit">
												<i class="icon-ok bigger-110"></i>
												提交
											</button>

											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="icon-undo bigger-110"></i>
												重置
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

			//添加还款与放款输入框
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

						if($(obj).attr('name') == 'project_already_total'){
							if(isNaN($(obj).val()) || $(obj).val() == ''){
								$(obj).parent().parent().find(':last-child').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请正确输入应缴费用</div>');
								$(obj).attr('type-data','false');
							}else{
								$(obj).parent().parent().find(':last-child').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline"></div>');
								$(obj).attr('type-data','true');
							}

						}
						
					}

				}

				new checkTotal('project_name').add_blur();
				new checkTotal('project_total_money').add_blur();
				new checkTotal('project_already_total').add_blur();

			});


			//缴费类型选项卡
			jQuery(function($){	

				$('input[data-target="payment_type_id"]').click(function(){

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

			//添加还款与放款输入框
			jQuery(function($){
				$('input[data-target="#dateShow"]').datepicker();

				$('input[data-target="#dateShow"]').focus(function(){

					$('.dropdown-menu').css('z-index',1060);

				});

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
			
			/**
			 * 数据校验
			 */
			jQuery(function($){
					
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
		</script>
</body>
</html>
