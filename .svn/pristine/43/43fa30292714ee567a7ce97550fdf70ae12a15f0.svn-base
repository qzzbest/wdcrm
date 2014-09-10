<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>添加咨询提醒</title>
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


		<style type="text/css">
		.col-sm-4{
			width:200px;
		}
		.bootstrap-timepicker{
			width:200px;
		}
		.font14{
			font-size: 14px;
		}
		</style>

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
							<?php foreach(unserialize(getcookie_crm('url')) as $key=>$item){
								if($key != count(unserialize(getcookie_crm('url')))-1){?>
							<li>
								<a href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
							</li>
							<?php }else{ ?>
							<li>
								<?php echo $item[0];?>
							</li>
							<?php } }?>
							<!-- <li>
								<a href="<?php echo site_url(module_folder(2).'/remind/index');?>">咨询提醒管理</a>
							</li>
							<li class="active">添加咨询提醒</li> -->
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(2).'/remind/add');?>">
									<!-- <div>
										<table cellpadding="5px" style="margin-left: 200px;">
											<tr>
												<td class="col-sm-2 font14" align="right">姓  名</td>
												<td>
													<input type="text" name="con_stu_name[]" value="" style="float:left;" />
													<div style="float:left;"></div>
												</td>
											</tr>
											<tr>
												<td class="col-sm-2 font14" align="right">
													手机号码
												</td>
												<td>
													<input type="text" name="con_stu_phone[]" value="" />
													<span class="font14">QQ</span><input type="text" name="con_stu_qq[]" value="" />
												</td>
											</tr>
										</table>
									</div> -->


									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	姓  名 </label>

										<div class="col-sm-9">
											<input type="text" name="con_stu_name[]" value="" style="float:left;" />
											<div style="float:left;"></div>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	手机号码 </label>

										<div class="col-sm-9">
											<input type="text" name="con_stu_phone[]" value="" />
											<span class="font14">QQ</span><input type="text" name="con_stu_qq[]" value="" />
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	提醒内容 </label>

										<div class="col-sm-9">
											<textarea style="width:400px; height:150px;" id="form-field-1" name="remind_content[]" required oninvalid="setCustomValidity('请输入提醒内容');" oninput="setCustomValidity('');" placeholder="请输入提醒内容"></textarea>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	提醒备注 </label>

										<div class="col-sm-9">
											<textarea style="width:400px; height:50px;" id="form-field-1" name="remind_remark[]" placeholder="请输入提醒备注"></textarea>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	 </label>
										<div class="col-sm-9">
											<label>
											<input type="checkbox" name="check_set_view" value="1" class="ace" />
											<span class="lbl">要上门的</span>
											<input type="hidden" name="is_set_view[]" value="0" />
											</label>
											&nbsp;&nbsp;&nbsp;
											<label>
											<input type="checkbox" name="check_important" value="1" class="ace" />
											<span class="lbl">重点跟进的</span>
											<input type="hidden" name="is_important[]" value="0" />
											</label>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2" > 提醒时间 </label>

											<div class="col-sm-4">
												<div class="input-group">
													<input class="form-control date-picker" id="id-date-picker-1" type="text" name="remind_date[]" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d');?>" style="z-index:1060;"/>
													<span class="input-group-addon">
														<i class="icon-calendar bigger-110"></i>
													</span>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="input-group bootstrap-timepicker">
													<input id="timepicker1" type="text" name="remind_time[]" class="form-control" />
													<span class="input-group-addon">
														<i class="icon-time bigger-110"></i>
													</span>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="spinner-buttons input-group-btn" style="text-align:center;">
													<button id="remindAdd" type="button" class="btn spinner-up btn-sm btn-success">
														<i class="icon-plus smaller-75"></i>
													</button>
												</div>									
											</div>							
										</div>
												

									<div class="space-4"></div>

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

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<div name="remind" style="display:none;">
			<div>
				<div>
					<table cellpadding="5px" style="margin-left: 200px; margin-bottom:8px;">
						<tr>
							<td class="col-sm-2 font14" align="right">姓  名</td>
							<td>
								<input type="text" name="con_stu_name[]" value="" />
								<div></div>
							</td>
						</tr>
						<tr>
							<td class="col-sm-2 font14" align="right">
								手机号码
							</td>
							<td>
								<input type="text" name="con_stu_phone[]" value="" />
								<span class="font14">QQ</span><input type="text" name="con_stu_qq[]" value="" />
							</td>
						</tr>
					</table>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	提醒内容 </label>

					<div class="col-sm-9">
						<textarea style="width:400px; height:150px;" id="form-field-1" name="remind_content[]" required oninvalid="setCustomValidity('请输入提醒内容');" oninput="setCustomValidity('');" placeholder="请输入提醒内容"></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	提醒备注 </label>

					<div class="col-sm-9">
						<textarea style="width:400px; height:50px;" id="form-field-1" name="remind_remark[]" placeholder="请输入提醒备注"></textarea>
					</div>
				</div>

				<div class="space-4"></div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	 </label>
					<div class="col-sm-9">
						<label>
						<input type="checkbox" name="check_set_view" value="1" class="ace" />
						<span class="lbl">要上门的</span>
						<input type="hidden" name="is_set_view[]" value="0" />
						</label>
						&nbsp;&nbsp;&nbsp;
						<label>
						<input type="checkbox" name="check_important" value="1" class="ace" />
						<span class="lbl">重点跟进的</span>
						<input type="hidden" name="is_important[]" value="0" />
						</label>
					</div>
				</div>

				<div class="space-4"></div>

				<div class="space-4"></div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-2" > 提醒时间 </label>

					<div class="col-sm-4">
						<div class="input-group">
							<input class="form-control date-picker" data-target="#dateShow" type="text" name="remind_date[]" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d');?>" style="z-index:1060;"/>
							<span class="input-group-addon">
								<i class="icon-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group bootstrap-timepicker">
							<input data-target="#timeShow" class="form-control timepicker1" type="text" name="remind_time[]" class="form-control" />
							<span class="input-group-addon">
								<i class="icon-time bigger-110"></i>
							</span>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="spinner-buttons input-group-btn" style="text-align:center;">
							<button type="button" onclick="wdcrm.removeInput(this,4);" class="btn spinner-down btn-sm btn-danger">
								<i class="icon-minus smaller-75"></i>
							</button>
						</div>									
					</div>									
				</div>
			</div>
	 	</div>
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


		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->

		<!-- ace scripts -->

		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>

		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>
		<script type="text/javascript">
			jQuery(function($) {

				var con_date = "<?php echo date('Y-m-d',time());?>";
				//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
						
					$(this).prev().focus();
				
				}).end().val(con_date);


				$('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function(){
					$(this).next().focus();
				});

				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});

				//操作“要上门的”和“重点跟进的”
				$('.form-horizontal').on('click','input[name="check_set_view"]',function() {
					if(this.checked){
						$(this).siblings('input[name="is_set_view[]"]').val(1);
					}else{
						$(this).siblings('input[name="is_set_view[]"]').val(0);
					}
				});

				$('.form-horizontal').on('click','input[name="check_important"]',function() {
					if(this.checked){
						$(this).siblings('input[name="is_important[]"]').val(1);
					}else{
						$(this).siblings('input[name="is_important[]"]').val(0);
					}
				});
			});
			
			jQuery(function($){
				/**
				 * 
				 * @param string 选中的元素 
				 * @param string 需要追加的内容，放置到了textarea里面
				 *
				 */
				function AddInput(id,name){
		 			var _this=this;
					//给按钮绑定事件，实现追加
					this.id=$(id);
					//追加的内容
					this.content=$('div[name="'+name+'"]').html();
					//console.log(this.content);
				}

				AddInput.prototype={
					
					add:function(){
						var _this=this;
						
					
						_this.id.click(function(){ //绑定点击事件

							var z=$(this).parent().parent().parent();
							z.after(_this.content);

							$('input[data-target="#dateShow"]').datepicker();
							$('input[data-target="#timeShow"]').timepicker({
								minuteStep: 1,
								showSeconds: true,
								showMeridian: false
							}).next().on(ace.click_event, function(){
								$(this).prev().focus();
							});

							$('input[data-target="#dateShow"]').focus(function(){

								$('.dropdown-menu').css('z-index',1060);

							});

						});
						
					}
				}
				new AddInput('#remindAdd','remind').add();

			});
	
			//暂时不做
			// jQuery(function ($) {
			// 	/*
	 	// 		 * 添加phone与qq与email输入框
	 	// 		 * @param string 选中的元素 一个id值
	 	// 		 * @param string 需要追加的内容，放置到了textarea里面
	 	// 		 *
	 	// 		 */
		 // 		function checkInput(name){
		 // 			var _this=this;
			// 		//初始绑定,鼠标移开，校验数据
			// 		this.name=name;
			// 		$('input[name="'+name+'[]"]').bind('blur',function () {
	 	// 				_this.blur_ajax(this);
	 	// 			});
			// 	}

			// 	checkInput.prototype={

			// 		add:function(){
			// 			var _this=this;

			// 			//动态添加绑定
			// 			this.name=name;
			// 			$('input[name="'+name+'[]"]').bind('blur',function () {

		 // 					_this.blur_ajax(this);
		 // 				});

			// 		},

			// 		add_blur:function(){
				
			// 			var _this=this;
			// 			$('input[name="'+this.name+'[]"]').unbind();
			// 			$('input[name="'+this.name+'[]"]').bind('blur',function(){_this.blur_ajax(this);});
			// 		},
					
			// 		blur_ajax:function(obj){

			// 		 	var v= $.trim(obj.value);
			// 		 	var k=obj.name;
			// 		 	var name;

			// 		 	if(k.indexOf('con_stu_name')!==-1){ k='consultant_name';}
			// 		 	if(k.indexOf('con_stu_phone')!==-1) {k='phones'};
			// 		 	if(k.indexOf('con_stu_qq')!==-1) {k='qq'};

			// 		 	switch(k){
			// 		 		case 'consultant_name':
			// 		 			name = '姓名';
			// 		 		break;

			// 		 		case 'phones':
			// 		 			name = '手机号码';
			// 		 		break;

			// 		 		case 'qq':
			// 		 			name = '邮箱';
			// 		 		break;
			// 		 	}

			// 		 	//如果值为空，不处理
			// 		 	if (v==='') {return }


			// 		 	//检查是否有字段值是重复的
			// 		 	var i=0;
			// 		 	$('input[name="'+obj.name+'[]"]').each(function(){
			// 		 		if(this.value===v){
			// 		 			i++;
			// 		 		}
			// 		 	});

			// 		 	//如果有重复的值，就不做ajax
			// 		 	if(i>1){
			// 		 			$(obj).next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">该值已经存在!</div>');
			// 		 			$(obj).attr('type-data','false');

			// 		 	}else{

			// 		 		if( k == 'consultant_name'){
			// 					$.ajax({
			// 					    type: "POST",
			// 					    url: "<?php echo site_url(module_folder(2).'/advisory/checkInfo');?>",
			// 					    data: 'type='+k+"&value="+v,
			// 					    dataType:'json',
			// 					   	success: function(res){

			// 					        	if(res.status==2){

			// 					        		$(obj).next().html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">该'+name+'对应的咨询者/学员不存在</div>');
			// 					        		$(obj).attr('type-data','false');

			// 					        	}
			// 					        }
			// 	   					});

			// 				}else if(k!==''){
			// 					$.ajax({
			// 					    type: "POST",
			// 					    url: "<?php echo site_url(module_folder(2).'/advisory/checked');?>",
			// 					    data: 'type='+k+"&value="+v,
			// 					    dataType:'json',
			// 					   	success: function(res){

			// 					        	if(res.status==2){

			// 					        		$(obj).parent().next().html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">该'+name+'对应的咨询者/学员不存在</div>');
			// 					        		$(obj).attr('type-data','false');

			// 					        	}
			// 					        }
			// 	   					});
			// 				}
			// 			}
			// 		}

			// 	}

	 	// 		// new checkInput('con_stu_name').add();
	 	// 		// new checkInput('con_stu_phone').add();
	 	// 		// new checkInput('con_stu_qq').add();
			// });
		</script>
</body>
</html>
