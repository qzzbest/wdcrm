<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>学员缴费记录编辑</title>
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
							<li class="active">缴费记录编辑</li>
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>

					</div>

					<div class="page-content">
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
							<form class="form-horizontal" name="changeMoney" role="form" method="post" action="">
								<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right"> 应缴学费</label>
										<div class="col-sm-2">
											<input type="text" required="" value="<?php echo $info['study_expense'];?>" placeholder="请输入应缴学费" name="tuition_total" class="col-xs-12">
										</div>
										<div class="col-sm-2 inline help-block">

										</div>
										<label class="col-sm-1 control-label no-padding-right"> 学费说明</label>
										<div class="col-sm-5">
											<input type="text" value="<?php echo $info['payment_desc'];?>" placeholder="学费说明" name="payment_desc" class="col-xs-10 col-sm-5">
										</div>
								</div>
								<div class="space-4"></div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-4"> 缴费类型</label>
									<div class="col-sm-9">
										<div class="radio">
											<?php foreach ($payment_type_info as $key => $value) { ?>
											<label style="padding-right:20px;">
												<input name="payment_type_id" data-target="payment_type_id" type="radio" value="<?php echo $value['payment_type_id'];?>" class="ace" />
												<span class="lbl"> <?php echo $value['payment_type_name'];?></span>
											</label>
										<?php } ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-2">
										&nbsp;
									</div>
									<div class="col-sm-10" data-target="tabChange">
										<table style="display:none;">
											<tr>
												<td>已缴学费</td>
												<td>
													<input type="text" name="already_total" placeholder="请输入已缴学费"  id="already_total" type-data="false" value="<?php if($payment_type_id==1){echo $info['already_payment'];}?>" />元
												</td>
												<td>&nbsp;</td>
											</tr>
										</table>
										<table style="display:none;" id="payment_two">
											<tr>
												<th class="center">日期</th>
												<th class="center">金额</th>
												<th class="center">提醒</th>
												<th>&nbsp;</th>	
											</tr>
										 	<tr>
										 		<td><input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="<?php if($payment_type_id==2){echo date('Y/m/d',$refund_loan_time['refund_loan1']['payment_time']); }?>" name="payment_time[]" placeholder="还款日期" /></td>
										 		<td><input type="text" value="<?php if($payment_type_id==2){echo $refund_loan_time['refund_loan1']['payment_money']; }?>" name="payment_money[]" placeholder="学费" />元</td>
										 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time[]" value="<?php if($payment_type_id==2){echo date('Y/m/d',$refund_loan_time['refund_loan1']['remind_time']); }?>" placeholder="提醒时间" /></td>
										 		<td>
										 			<button data-target="#moneyAdd" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
													</button>
												</td>
										 	</tr>
										 	<?php 
										 	if($payment_type_id==2){
										 	foreach($refund_loan_time['refund_loan'] as $item){?>
										 	<tr>
										 		<td><input type="text" class="date-picker" data-target="#dateShow" data-date-format="yyyy/mm/dd" value="<?php echo date('Y/m/d',$item['payment_time']);?>" name="payment_time[]" placeholder="还款日期" /></td>
										 		<td><input type="text" value="<?php echo $item['payment_money']; ?>" name="payment_money[]" placeholder="学费" />元</td>
										 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time[]" value="<?php echo date('Y/m/d',$item['remind_time']); ?>" placeholder="提醒时间" /></td>
										 		<td>
								  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
														<i class="icon-minus smaller-75"></i>
													</button>
												</td>
										 	</tr>
										 	<?php }}?>
										</table>
										<table style="display:none;" id="payment_three">
											<tr>
												<th class="center">申请额度</th>
												<th class="center">机构代还时间段</th>
												<th class="center">开始还款日期</th>
												<th></th>
											</tr>
											<tr>
												<td><input type="text" name="apply_money1" value="<?php if($payment_type_id==3){echo $info['apply_money'];}?>" placeholder="申请额度" /></td>
												<td><input type="text" data-date-format="yyyy/mm/dd" name="organization_paydate1" value="<?php if($payment_type_id==3){echo $info['organization_paydate'];}?>" placeholder="机构代还时间段" /></td>
												<td><input type="text" data-target="#dateShow" value="<?php if($payment_type_id==3){ 
												echo date('Y/m/d',$info['student_start_paydate']);}?>" data-date-format="yyyy/mm/dd" name="student_start_paydate1" placeholder="开始还款日期" /></td>
												<td></td>
											</tr>
											<tr>
												<td colspan="4">生活补贴</td>
											</tr>
											<tr>
												<th class="center">日期</th>
												<th class="center">金额</th>
												<th class="center">提醒</th>
												<th></th>
											</tr>
											<tr>
										 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time[]" value="<?php if($payment_type_id==3){echo date('Y/m/d',$refund_loan_time['refund_loan1']['payment_time']); }?>" placeholder="放款日期" /></td>
										 		<td><input type="text" value="<?php if($payment_type_id==3){echo $refund_loan_time['refund_loan1']['payment_money']; }?>" name="payment_money[]" placeholder="金额" />元</td>
										 		<td><input type="text" value="<?php if($payment_type_id==3){echo date('Y/m/d',$refund_loan_time['refund_loan1']['remind_time']); }?>" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time[]" placeholder="提醒时间" /></td>
										 		<td>
											 		<button data-target="#employment_credit" type="button" class="btn spinner-up btn-xs btn-success">
														<i class="icon-plus smaller-75"></i>
													</button>
												</td>
											</tr>
									<?php 
									 if($payment_type_id==3){
										 foreach($refund_loan_time['refund_loan'] as $item){?>
											<tr>
										 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time[]" value="<?php echo date('Y/m/d',$item['payment_time']);?>" placeholder="放款日期" /></td>
										 		<td><input type="text" value="<?php echo $item['payment_money'];?>" name="payment_money[]" placeholder="金额" />元</td>
										 		<td><input type="text" value="<?php echo date('Y/m/d',$item['remind_time']); ?>" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time[]" placeholder="提醒时间" /></td>
												<td>
								  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
														<i class="icon-minus smaller-75"></i>
													</button>
												</td>
											</tr>
									<?php }}?>
										</table>
										<table style="display:none;">
											<tr>
												<th class="center">申请额度</th>
												<th class="center">机构代还时间段</th>
												<th class="center">开始还款日期</th>
											</tr>
											<tr>
												<td><input type="text" name="apply_money2" value="<?php if($payment_type_id==4){echo $info['apply_money']; }?>" placeholder="申请额度" /></td>
												<td><input type="text" name="organization_paydate2" value="<?php if($payment_type_id==4){echo $info['organization_paydate']; }?>" placeholder="机构代还时间段" /></td>
												<td><input type="text" data-target="#dateShow" value="<?php if($payment_type_id==4){echo date('Y/m/d',$info['student_start_paydate']); }?>" data-date-format="yyyy/mm/dd" name="student_start_paydate2" placeholder="开始还款日期" /></td>
											</tr>
										</table>
									</div>
								</div>								
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-8">特殊情况备注</label>
									<div class="col-sm-6">
										<textarea class="form-control" name="special_payment_remark" id="form-field-8" placeholder="针对咨询者的情况备注信息"><?php echo $info['special_payment_remark'];?></textarea>
										<input type="hidden" name="student_id" value="<?php echo $info['student_id'];?>" />
									</div>
									<div class="col-sm-4">&nbsp;</div>
								</div>
								<div class="clearfix form-actions">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-info" type="submit">
											<i class="icon-ok bigger-110"></i>
											提交
										</button>
									</div>
								</div>

								<!-- PAGE CONTENT ENDS -->
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
		
		<!-- 临时数据存储地 ，分期付款 start -->
		<textarea name="installments" cols="30" rows="10" style="display:none;">
			<tr>
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time[]" placeholder="还款日期" /></td>
  		 		<td><input type="text" name="payment_money[]" placeholder="学费" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time[]" placeholder="提醒时间" /></td>
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
		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="payment_time[]" placeholder="放款日期" /></td>
  		 		<td><input type="text" name="payment_money[]" placeholder="金额" />元</td>
  		 		<td><input type="text" data-target="#dateShow" data-date-format="yyyy/mm/dd" name="remind_time[]" placeholder="提醒时间" /></td>
  		 		<td>
  		 			<button type="button" onclick="wdcrm.removeInput(this,2);" class="btn spinner-down btn-xs btn-danger">
						<i class="icon-minus smaller-75"></i>
					</button>
				</td>
  		 	</tr>
		</textarea>
		<!-- 先就业后付款(包吃住) end -->

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
		 window.jQuery || document.write("<script src='<?php echo base_url('assets/js/jquery-1.10.2.min.js');?>'>"+"<"+"/script>");
		</script>
		<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo base_url('assets/js/jquery.mobile.custom.min.js');?>'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/typeahead-bs2.min.js');?>"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->

		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>
	
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			//缴费类型选项卡
			jQuery(function($){
				$('input[data-target="payment_type_id"]').click(function(){

						var type=$.trim($(this).next().html());
						var index;
						if(type=='一次性付款'){
							index=0;
						}else if(type=='分期付款'){
							index=1;
						}else if(type=='先就业后付款(包吃住)'){
							index=2;
						}else if(type=='先就业后付款(不包吃住)'){
							index=3;
						}else{
							return ;
						}

						var z=$('div[data-target="tabChange"]').find('table').eq(index);
						z.show().siblings().hide();
				});
				//选中一个缴费类型
				$('input[data-target="payment_type_id"]').eq(<?php echo $payment_type_id-1;?>).click();

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


			});
			//给输入框添加时间选择插件
			jQuery(function($){

	 			//时间选择插件
	 			function start_end_time(obj){

					$('input[name='+obj+']').daterangepicker(
						{
							format: 'YYYY/MM/DD'
							
						});
				}
				//有开始跟结束时间的
				start_end_time('organization_paydate1');
				start_end_time('organization_paydate2');

				//时间选择插件
	 			$('input[data-target="#dateShow"]').datepicker();
			});

			jQuery(function($) {
				$('input[name="tuition_total"]').blur(function(){
					var v=this.value;
					var msg=$(this).parent().next();
					if(!$.isNumeric(v)){
						msg.html('亲,请输入一个数值!').css('color','rgb(209, 110, 108)');
						$(this).attr('type-data','false');
					}else{
						msg.html('成功!').css('color','rgb(123, 160, 101)');
					}
				});
			
				$('input[name="already_total"]').blur(function(){
					var v=this.value;
					var msg=$(this).parent().next();
					var money=$('input[name="tuition_total"]').attr('value');

					if(!$.isNumeric(v)){
						msg.html('亲,请输入一个数值!').css('color','rgb(209, 110, 108)');
						$(this).attr('type-data','false');
						return false;
					}
					//如果应缴学费是数值
					if ($.isNumeric(money)) {
						if(money<v){
							msg.html('已缴学费金额不能大于应缴学费');
							$(this).attr('type-data','false');
						}
					}
					msg.html('成功!').css('color','rgb(123, 160, 101)');
					$(this).attr('type-data','true');
				});

				$('form[name="changeMoney"]').submit(function(){
					
					var fqtime = 0;
					var fqmoney = 0;
					var fqmoneyall = 0;
					var payment_money;	

					if( $('input[name="tuition_total"]').attr('type-data') == 'false' ){
							alert('请填完整应缴学费！');
							return false;
					}
					
					//根据用户选择的缴费类型做不同的数据校验
					var type=$('input[data-target="payment_type_id"]:checked').val();

					//一次性付款
					if(type==1){
						//判断应缴学费是否符合要求
						if( $('#already_total').attr('type-data') == 'false' ){

							alert('请填完整已缴学费！');
							return false;
						}else{

							return true;
						}
					};

					//分期付款
					if(type==2){
					
							//日期
							var two_time_length = $('#payment_two input[name="payment_time[]"]').length;
	
							for(var j=0; j<two_time_length; j++){
								
								if( $('#payment_two input[name="payment_time[]"]').eq(j).val() == '' ){

									fqtime ++;
									
								}

							}
							if(fqtime > 0){
								alert('请填完整还款日期！');
								return false;
							}

							//金额
							var payment_money=$('#payment_two input[name="payment_money[]"]');
							 
						
							for(var j=0,l=payment_money.length; j<l; j++){
								var z= payment_money[j].value; //用户输入的金额
								if($.isNumeric(z)){
									fqmoneyall+=parseFloat(z);
								}else{
									alert('请填完整学费！');
									return false;
								}
							}
							
							var total=parseFloat($('input[name="tuition_total"]').val());
							
							if( fqmoneyall > total ){
								alert('分期付款金额不能大于应缴学费');
								return false;
							}

						//提醒,暂时不写
						//var two_remind_length = $('#payment_two input[name="remind_time[]"]').length;
						
						//把先就业跟后付款(包吃住吃住的)日期金额提醒干掉(不让他提交到数据库中)
						$('#payment_three').find('input').val('');
						

					};


					//先就业后付款(包吃住)
					if (type==3) {
						if( $('input[name="apply_money1"]').val() == '' ){
							alert('请填写申请额度！');
							return false;
						}
						
						if( $('input[name="organization_paydate1"]').val() == '' ){
							alert('请填写机构代还时间段！');
							return false;
						}

						if( $('input[name="student_start_paydate1"]').val() == '' ){
							alert('请填写开始还款日期！');
							return false;
						}

						//日期
						var payment_time = $('#payment_three input[name="payment_time[]"]');
						
						for(var j=0,l=payment_time.length; j<l; j++){
							//只要有一个日期是为空的
							if( $.trim(payment_time[j].value) == '' ){
								alert('请填完整放款日期！');
								return false;
							}

						}
						//金额
						var payment_money = $('#payment_three input[name="payment_money[]"]');
		
						for(var j=0,l=payment_money.length; j<l; j++){
							
							if($.trim(payment_money[j].value) == '' ){
								alert('请填金额！');
								return false;
							}

						}

						//提醒暂时不处理
						//var three_remind_length = $('#payment_three input[name="remind_time[]"]').length;

						//分期付款 日期金额提醒干掉(不让他提交到数据库中)
						$('#payment_two').find('input').val('');

					};

					
					//先就业后付款(不包吃住)
					if (type==4) {
						if( $('input[name="apply_money2"]').val() == '' ){
							alert('请填写申请额度！');
							return false;
						}
						if( $('input[name="organization_paydate2"]').val() == '' ){
							alert('请填写机构代还时间段！');
							return false;
						}
						if( $('input[name="student_start_paydate2"]').val() == '' ){
							alert('请填写开始还款日期！');
							return false;
						}

					}


				});
			});

		</script>
	</body>
</html>