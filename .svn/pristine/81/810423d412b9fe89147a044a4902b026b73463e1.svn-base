<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>学生编辑</title>
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
							<li class="active">学员编辑</li>
						</ul><!-- .breadcrumb -->
						<?php $this->load->view('search_student');?>
					</div>

					<div class="page-content">
						
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<form class="form-horizontal" role="form" method="post" action="">
									<input type="hidden" name="consultant_id" value="<?php echo $consultant['consultant_id'];?>" />
									<input type="hidden" name="student_id" value="<?php echo $student['student_id'];?>" />
						  			<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 学号</label>

										<div class="col-sm-4">
											<input type="text" value="<?php echo $student['student_number']; ?>" name="student_number" id="form-field-1" class="col-xs-10 col-sm-10" readonly/>
										</div>
									</div>
									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 姓名</label>

										<div class="col-sm-4">
											<input type="text" required value="<?php echo $student['student_name']; ?>" name="student_name" id="form-field-1" placeholder="请输入学员姓名" class="col-xs-10 col-sm-10" />
										</div>
										<div></div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-4"> 性别</label>

										<div class="col-sm-9">
											<div class="radio">
												<label style="padding-right:20px;">
													<input name="sex" <?php if ($student['student_sex']==1) {echo "checked";} ?> type="radio" value="1" class="ace" /><span class="lbl"> 男</span>
												</label>
												<label>
													<input name="sex" <?php if ($student['student_sex']==2) {echo "checked";} ?> type="radio" value="2" class="ace" /><span class="lbl"> 女</span>
												</label>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 手机号码</label>

										<div class="col-sm-4">
										<?php if(empty($consultant_phone1['phone_number'])){ ?>
											<input type="text" name="add_phone[<?php echo $consultant_phone1['phone_id'];?>]" id="form-field-2" placeholder="手机号码" class="student_phone col-xs-10 col-sm-10" />
										<?php }else{?>
											<input type="text" name="update_phone[<?php echo $consultant_phone1['phone_id'];?>]" value="<?php echo $consultant_phone1['phone_number'];?>" id="form-field-2" placeholder="手机号码" class="student_phone col-xs-10 col-sm-10" />
										<?php }?>

											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button id="phone_add" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
												</button>
											</div>
										</div>
									</div>
									<?php foreach($consultant_phone as $item){ ?>
									<div class="form-group">
										<div class="col-sm-3"></div>
										<div class="col-sm-4">
											<input type="text" name="update_phone[<?php echo $item['phone_id'];?>]" value="<?php echo $item['phone_number'];?>"  placeholder="手机号码" class="student_phone col-xs-10 col-sm-10" />
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button type="button" onclick="wdcrm.removeInput(this,3);" class="del_phone btn spinner-down btn-xs btn-danger" pid="<?php echo $item['phone_id'];?>">
													<i class="icon-minus smaller-75"></i>
												</button>
											</div>
										</div>
									</div>
									<?php } ?>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> QQ</label>

										<div class="col-sm-4">
										<?php if(empty($consultant_qq1['qq_number'])){ ?>
											<input type="text" name="add_qq[]" id="form-field-2" placeholder="QQ" class="student_qq col-xs-10 col-sm-10" />
										<?php }else{?>
											<input type="text" name="update_qq[<?php echo $consultant_qq1['qq_id'];?>]" value="<?php echo $consultant_qq1['qq_number'];?>" id="form-field-2" placeholder="QQ" class="student_qq col-xs-10 col-sm-10" />
										<?php }?>
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button id="qq_add" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
												</button>
											</div>
										</div>	
									</div>
									<?php foreach($consultant_qq as $item){ ?>
									<div class="form-group">
										<div class="col-sm-3"></div>
										<div class="col-sm-4">
											<input type="text" name="update_qq[<?php echo  $item['qq_id'];?>]" value="<?php echo $item['qq_number'];?>" id="form-field-2" placeholder="QQ" class="student_qq col-xs-10 col-sm-10" />
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button type="button" onclick="wdcrm.removeInput(this,3);" class="del_qq btn spinner-down btn-xs btn-danger"  qid="<?php echo $item['qq_id'];?>">
													<i class="icon-minus smaller-75"></i>
												</button>
											</div>
										</div>
									</div>
									<?php }?>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 邮箱</label>

										<div class="col-sm-4">
										<?php if(empty($consultant_email1['email'])){ ?>
											<input type="text" name="add_email[]" id="form-field-2" placeholder="邮箱" class="student_email col-xs-10 col-sm-10" />
										<?php }else{?>
											<input type="text" name="update_email[<?php echo  $consultant_email1['email_id'];?>]" value="<?php echo $consultant_email1['email'];?>" id="form-field-3" placeholder="邮箱" class="student_email col-xs-10 col-sm-10" />
										<?php }?>
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button id="email_add" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
												</button>
											</div>
										</div>
									</div>
									<?php foreach($consultant_email as $item){ ?>
									<div class="form-group">
										<div class="col-sm-3"></div>
										<div class="col-sm-4">
											<input type="text" name="update_email[<?php echo  $item['email_id'];?>]" value="<?php echo $item['email'];?>" id="form-field-2" placeholder="邮箱" class="student_email col-xs-10 col-sm-10" />
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button type="button" onclick="wdcrm.removeInput(this,3);" class="del_email btn spinner-down btn-xs btn-danger"  eid="<?php echo $item['email_id'];?>">
													<i class="icon-minus smaller-75"></i>
												</button>
											</div>
										</div>
									</div>
									<?php }?>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"> 其他联系方式</label>
										<div class="col-sm-4">
											<input type="text" name="student_other_contacts" placeholder="其他联系方式" value="" class="col-xs-10 col-sm-10" />				
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 身份证</label>

										<div class="col-sm-4">
											<input type="text" value="<?php echo $student['certificate'];?>" name="certificate" id="form-field-1" placeholder="请输入身份证" class="col-xs-10 col-sm-10"/>
										</div>
										<span id="showcert" style="color: rgb(209, 110, 108);"></span>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-8">学员其他信息</label>
										<div class="col-sm-4">
											<textarea class="form-control" name="student_otherinfo" id="form-field-8" placeholder="这里可以填写关于学员备注信息"><?php echo $student['student_otherinfo'];?></textarea>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right"> 学历</label>
										<div class="col-sm-3">
											<select class="form-control" name="student_education">
												<option <?php if($student['student_education']=='请选择学历'){echo 'selected';} ?> value="">请选择学历</option>
												<option <?php if($student['student_education']=='初中'){echo 'selected';} ?> value="初中">初中</option>
												<option <?php if($student['student_education']=='高中'){echo 'selected';} ?> value="高中">高中</option>
												<option <?php if($student['student_education']=='中技'){echo 'selected';} ?> value="中技">中技</option>
												<option <?php if($student['student_education']=='高技'){echo 'selected';} ?> value="高技">高技</option>
												<option <?php if($student['student_education']=='大专'){echo 'selected';} ?> value="大专">大专</option>
												<option <?php if($student['student_education']=='本科'){echo 'selected';} ?> value="本科">本科</option>
												<option <?php if($student['student_education']=='研究生'){echo 'selected';} ?> value="研究生">研究生</option>
												<option <?php $education=array('请选择学历','初中','高中','中技','高技','大专','本科','研究生');
													if(!in_array($student['student_education'], $education)){
														echo 'selected';
													} ?> value="其他">其他</option>
											</select>
										</div>
										<div class="col-sm-6"></div>
									</div>
									<div style="display:<?php $education=array('请选择学历','初中','高中','中技','高技','大专','本科');
										if(!in_array($student['student_education'], $education)){
											echo '';
										}else{
											echo 'none';
										} ?>" class="form-group" data-target="#student_education_other">
										<div class="col-sm-3"></div>
										<div class="col-sm-3">
											<input type="text" name="student_education_other" value="" placeholder="请输入学历" class="col-xs-10 col-sm-12" />
										</div>
										<div class="col-sm-6"></div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 毕业院校</label>

										<div class="col-sm-4">
											<input type="text" name="student_school" value="<?php echo $student['student_school'];?>" id="form-field-2" placeholder="学员毕业院校" class="col-xs-10 col-sm-10" />
										</div>
									</div>
									<div class="space-4"></div>
									
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 就读专业</label>

										<div class="col-sm-4">
											<input type="text" name="student_specialty" value="<?php echo $student['student_specialty'];?>" id="form-field-2" placeholder="学员就读专业" class="col-xs-10 col-sm-10" />
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> </label>

										<div class="col-sm-9">
											<label><input class="ace" <?php if($student['is_card']==1){echo 'checked';}?> type="checkbox" name="student_card" value="1">
											<span class="lbl">是否领学生证</span></label>
											<label><input class="ace" <?php if($student['is_material']==1){echo 'checked';}?> type="checkbox" name="material" value="1">
											<span class="lbl">是否领教材</span></label>
											<label><input class="ace" <?php if($student['is_computer']==1){echo 'checked';}?> type="checkbox" name="computer" value="1">
											<span class="lbl">是否自带电脑</span></label>
										</div>
									</div> 
									<div class="space-4"></div> 

									<div class="clearfix form-actions">
										<div class="col-md-offset-3 col-md-9">
											<input type="hidden" name="location" value="<?php echo $location;?>" />
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
		<!-- 添加咨询者的phone需要的静态html -->
	 	<textarea name="phone" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-4">
					<input type="text" name="add_phone[]" placeholder="手机号码" class="student_phone col-xs-10 col-sm-10" />
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-5"></div>
			</div>
	 	</textarea>
	 	<!-- 添加咨询者的qq需要的静态html -->
	 	<textarea name="qq" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-4">
					<input type="text" name="add_qq[]" placeholder="QQ" class="student_qq col-xs-10 col-sm-10" />
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-5"></div>
			</div>
	 	</textarea>
	 	<!-- 添加咨询者的email需要的静态html -->
	 	<textarea name="email" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-4">
					<input type="text" name="add_email[]" placeholder="邮箱" class="student_email col-xs-10 col-sm-10" />
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-5"></div>
			</div>
	 	</textarea>
	 	<!-- 添加咨询者的学历需要的静态html -->
		<textarea name="education" style="display:none;">
			
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
				//检测表单元素的内容
	 			function checkInput(name,num){
	 				var _this = this;
	 				this.name = name;
	 				if(num == 1){
	 					$('input[name="'+name+'"]').bind('blur',function () {
		 					_this.blur_ajax(this);
		 				});
	 				}else if(num == 2){
	 					$('input[name="'+name+'"]').bind('blur',function () {
		 					_this.blur_ajax2(this);
		 				});
	 				}
	 				
	 			}

	 			checkInput.prototype = {

	 				add_blur:function(){
						var _this=this;
						$('input[name="'+name+'"]').unbind();
						$('input[name="'+name+'"]').bind('blur',function(){_this.blur_ajax(this);});
					},

					blur_ajax:function(obj){

						var k=obj.name;
						var v= $.trim(obj.value);
						var name = "<?php echo $student['student_name'];?>";

						if( v != ''){
							if( v != name ){
								$.ajax({
							    type: "POST",
							    url: "<?php echo site_url(module_folder(2).'/advisory/checkInfo');?>",
							    data: 'type='+k+"&value="+v,
							    dataType:'json',
							   	success: function(res){

							        	if (res.status===1) {

							        		$(obj).parent().next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">'+v+'已存在</div>');

							        	}else if(res.status==2){

							        		$(obj).parent().next().html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');

							        	}
							        }
	   							});
							}
							
						}else{

					 		$(obj).parent().next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请输入姓名！</div>');

						}
					},
	 			}

	 			new checkInput('student_name',1).add_blur();

	 			/*
	 			 * 添加phone与qq输入框
	 			 * @param string 选中的元素 一个id值
	 			 * @param string 需要追加的内容，放置到了textarea里面
	 			 *
	 			 */
		 		function AddInput(id,name){
		 			var _this=this;
					//给按钮绑定事件，实现追加
					this.id=$(id);
					//追加的内容
					this.content=$('textarea[name="'+name+'"]').text();

					//初始绑定,鼠标移开，校验数据
					this.name=name;
					$('.student_'+this.name).bind('blur',function(){_this.blur_ajax(this);});
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

					add_blur:function(){
						var _this=this;
						$('.student_'+this.name).unbind();
						$('.student_'+this.name).bind('blur',function(){_this.blur_ajax(this);});
					},
					blur_ajax:function(obj){

					 	var v= $.trim(obj.value);
					 	var k=obj.name;
					 	var name;
					 	
					 	if(k.indexOf('qq')!==-1){ k='qq';}
					 	if(k.indexOf('phone')!==-1) {k='phones'};
					 	if(k.indexOf('email')!==-1) {k='email'};

					 	switch(k){
					 		case 'qq':
					 			name = 'QQ';
					 		break;

					 		case 'phones':
					 			name = '手机号码';
					 		break;

					 		case 'email':
					 			name = '邮箱';
					 		break;
					 	}

					 	//如果值为空，不处理
					 	if (v==='') {
					 		$(obj).attr('type-data','true');
					 		return 
					 	}

					 	
					 	//检查是否有字段值是重复的
					 	var i=0;
					 	$('.student_'+this.name).each(function(){
					 		if(this.value===v){
					 			i++;
					 		}
					 	});
					 	//如果有重复的值，就不做ajax
					 	if(i>1){
					 		$(obj).parent().next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">该值已经存在!</div>');	
					 		$(obj).attr('type-data','false');
					 	}else{

					 		$.ajax({
							        type: "POST",
							        url: "<?php echo site_url(module_folder(2).'/advisory/checked/'.$consultant['consultant_id']);?>",
							        data: 'type='+k+"&value="+v,
							        dataType:'json',
							        success: function(res){
							        	if (res.status===1) {

							        		$(obj).parent().next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">'+res.con_info[0].consultant_name+'已使用此'+name+'(咨询师:'+res.teach+')'+'</div>');
							        		$(obj).attr('type-data','false');

							        	}else if(res.status==2){

							        		$(obj).parent().next().html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
							        		$(obj).attr('type-data','true');

							        	}

							        }
			   					});
					 	}
						
					}

				}

	 			new AddInput('#phone_add','phone').add();
	 			new AddInput('#qq_add','qq').add();
	 			new AddInput('#email_add','email').add();

	 			/**
	 			 * 学生学历
	 			 */
	 			var OhterAdd=function(obj,other){
	 				this.obj=$('select[name="'+obj+'"]');
	 				this.other=$('div[data-target="#'+other+'"]');
	 			}
	 			OhterAdd.prototype={
	 					change:function(){
	 						var _this=this;

	 						this.obj.change(function(){

	 							var index=this.selectedIndex;
								var text=this.options[index].text;
								if (text=='其他') {
									_this.other.show();
								}else{
									_this.other.hide();
								}
	 						});

	 					}
	 			}

	 			new OhterAdd('student_education','student_education_other').change();

	 			$('.form-horizontal').submit(function () {

	 				//检测phone、qq、email是否存在
	 				var phone = $('.student_phone');
	 				var qq = $('.student_qq');
	 				var email = $('.student_email');

	 				var _phonenum = 0;
	 				var _qqnum = 0;
	 				var _emailnum = 0;
	 				phone.each(function(){

	 					var z = $(this).attr('type-data');
	 					if(z=='false'){

	 						_phonenum ++;
	 					}
	 				});

	 				qq.each(function(){

	 					var z = $(this).attr('type-data');
	 					if(z=='false'){

	 						_qqnum ++;
	 					}
	 				});

	 				email.each(function(){

	 					var z = $(this).attr('type-data');
	 					if(z=='false'){

	 						_emailnum ++;
	 					}
	 				});

	 				if(_phonenum > 0){

	 					return false;
	 				}
	 				if(_qqnum > 0){
	 					return false;
	 				}
	 				if(_emailnum > 0){
	 					return false;
	 				}

	 				var cert = $.trim($("input[name='certificate']").val());
	 				var id = $('input[name="student_id"]').val();
	 				var result=true;
	 				//验证身份证长度
	 				if(cert !='' && !cert.match(/^(\d{18,18}|\d{15,15}|\d{17,17}x)$/)){ 
						$("#showcert").html('身份证格式不正确！请重新输入'); 
						return false; 
					}
					//验证身份证是否唯一
					$.ajax({
						async: false,
					    type: "POST",
					    url: "<?php echo site_url(module_folder(4).'/student/checkCert');?>",
					    data: 'id='+id+'&value='+cert,
					    dataType:'json',
					   	success: function(res){
				        	if (res.status===1) {
				        		$('#showcert').html('此身份证号码已存在');
				        		result = false;
				        	}else if(res.status==0){
				        		$('#showcert').html('');
				        	}
				        }
   					});
					return result;
	 			});	
	 		})

	 		jQuery(function($){

				//ajax删除QQ	
				$('.del_qq').click(function(){
					var qid=parseInt($(this).attr("qid"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student/deleteQQ');?>",
				        data: "qid="+qid,
				        dataType:'json',
				        success: function(res){
				       		if(res.status==1){
				       			//alert("成功");
				       		}else if(res.status==0){
				       			//alert("失败");
				       		}	
				        }
			   		});
				});
				//ajax删除email	
				$('.del_email').click(function(){
					var eid=parseInt($(this).attr("eid"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student/deleteEmail');?>",
				        data: "eid="+eid,
				        dataType:'json',
				        success: function(res){
				       		if(res.status==1){
				       			//alert("成功");
				       		}else if(res.status==0){
				       			//alert("失败");
				       		}	
				        }
			   		});
				});
				//ajax删除phone
				$('.del_phone').click(function(){
					var pid=parseInt($(this).attr("pid"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student/deletePhone');?>",
				        data: "pid="+pid,
				        dataType:'json',
				        success: function(res){
				       		if(res.status==1){
				       			//alert("成功");
				       		}else if(res.status==0){
				       			//alert("失败");
				       		}	
				        }
			   		});
				});
			});	
	 	</script>

	</body>
</html>