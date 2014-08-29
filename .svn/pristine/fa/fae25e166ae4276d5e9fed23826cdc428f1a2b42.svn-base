<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>添加市场资源</title>
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
								<a href="<?php echo site_url(module_folder(1).'/index/index');?>">主页</a>
							</li>
							<?php foreach(unserialize(getcookie_crm('url')) as $item){?>
								<li>
									<a href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
								</li>
							<?php }?>
							<li class="active">添加市场资源</li>
						</ul><!-- .breadcrumb -->
						
					</div>

					<div class="page-content">
						
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" name="add" role="form" method="post" action="">
									<?php if(getcookie_crm('employee_power')==1){?>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 市场专员 </label>
										<div class="col-sm-3">
											<select class="form-control" name="employee_id" required>
												<option value="">请选择市场专员</option>
												<?php foreach($marketing_specialist as $item){?>
													<option value="<?php echo $item['employee_id'];?>"><?php echo $item['employee_name'];?></option>
												<?php }?>
											</select>
										</div>
									</div>
									<?php }?>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 机构学校 </label>
										<div class="col-sm-3">
											<input type="text" required id="form-field-2" class="col-xs-10 col-sm-12" placeholder="请输入机构学校" required name="school"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 登记日期 </label>
										<div class="col-sm-3">
											<div class="input-group">
												<input class="form-control date-picker" required id="id-date-picker-1" type="text" value="<?php echo date('Y-m-d')?>" name="login_date" data-date-format="yyyy-mm-dd" />
												<span class="input-group-addon">
													<i class="icon-calendar bigger-110"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 学历性质 </label>
										<div class="col-sm-3">
											<input type="text" id="form-field-2" class="col-xs-10 col-sm-12" placeholder="学历性质" name="education"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 学期分配 </label>
										<div class="col-sm-3">
											<input type="text" id="form-field-2" class="col-xs-10 col-sm-12" placeholder="学期分配" name="term"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 区域 </label>
										<div class="col-sm-3">
											<input type="text" id="form-field-2" class="col-xs-10 col-sm-12" placeholder="区域" name="area"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 学校介绍/网址 </label>
										<div class="col-sm-3">
											<input type="text" id="form-field-2" class="col-xs-10 col-sm-12" placeholder="学校介绍/网址" name="website"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 联系人信息 </label>
										<div class="col-sm-4">
											<input type="text" name="contanct_people[]" placeholder="联系人" class="col-xs-10 col-sm-9" />
											<input type="text" name="role[]" placeholder="职责" class="col-xs-10 col-sm-9"  />
											<input type="text" name="phone_number[]" placeholder="手机号码" class="col-xs-10 col-sm-9"  />
											<input type="text" name="telephone[]" placeholder="固定电话" class="col-xs-10 col-sm-9"  />
											<input type="text" name="qq_number[]" placeholder="QQ" class="col-xs-10 col-sm-9" />
											<input type="text" name="email_number[]" placeholder="邮箱" class="col-xs-10 col-sm-9" />
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button id="person_add" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
												</button>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 校区地址 </label>
										<div class="col-sm-4">
											<textarea class="form-control" name="address" id="form-field-8" placeholder="校区地址"></textarea>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 乘车路线 </label>
										<div class="col-sm-4">
											<textarea class="form-control" name="route" id="form-field-8" placeholder="乘车路线"></textarea>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<input type="hidden" name="location" value="" />
											<button class="btn btn-info" type="submit">
												<i class="icon-ok bigger-110"></i>
												提交
											</button>
										</div>
									</div>

								</form>
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
	 	
	 	<textarea name="person" style="display:none;">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 联系人信息 </label>
				<div class="col-sm-4">
					<input type="text" name="contanct_people[]" placeholder="联系人" class="col-xs-10 col-sm-9" />
					<input type="text" name="role[]" placeholder="职责" class="col-xs-10 col-sm-9"  />
					<input type="text" name="phone_number[]" placeholder="手机号码" class="col-xs-10 col-sm-9" />
					<input type="text" name="telephone[]" placeholder="固定电话" class="col-xs-10 col-sm-9"  />
					<input type="text" name="qq_number[]" placeholder="QQ" class="col-xs-10 col-sm-9" />
					<input type="text" name="email_number[]" placeholder="邮箱" class="col-xs-10 col-sm-9" />
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-5"></div>
			</div>
	 	</textarea>
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
		<!-- inline scripts related to this page -->
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>

		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		
	 	<script type="text/javascript">
	 		jQuery(function($){
	 			//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();				
				});
				function AddInput(id,name){
		 			var _this=this;
					//给按钮绑定事件，实现追加
					this.id=$(id);
					//追加的内容
					this.content=$('textarea[name="'+name+'"]').text();
					//初始绑定,鼠标移开，校验数据
					this.name=name;
					$('input[name="consultant_'+name+'_number[]"]').bind('blur',function(){_this.blur_ajax(this);});
				}

				AddInput.prototype={

					add:function(){
						var _this=this;

						_this.id.click(function(){ //绑定点击事件
							var z=$(this).parent().parent().parent();
							z.after(_this.content);

							//动态添加绑定
							_this.add_blur();

						});

					},

				}

	 			new AddInput('#person_add','person').add();
			});
	 	</script>

	</body>
</html>