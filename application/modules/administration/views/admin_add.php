<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>添加员工</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="<?php echo base_url('assets/css/bootstrap.min.css" rel="stylesheet');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/datepicker.css');?>" />
		<!-- fonts -->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/google.css');?>" />
		<!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" /> 加载http外部的文件-->


		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace.min.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace-rtl.min.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace-skins.min.css');?>" />

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

							<li>
								<a href="<?php echo site_url(module_folder(1).'/admin/index');?>">员工管理</a>
							</li>
							<li class="active">添加员工</li>
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" name="add" role="form" method="post" action="<?php echo site_url(module_folder(1).'/admin/add');?>">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户名 </label>
										<div class="col-sm-4">
											<input type="text" id="form-field-1" placeholder="请输入用户名" class="col-xs-10 col-sm-10" name="username" required oninvalid="setCustomValidity('请输入用户名');" oninput="setCustomValidity('');" />
										</div>
										<div class="col-sm-3 cname">
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 密 码 </label>
										<div class="col-sm-4">
											<input required type="password" id="form-field-2" placeholder="请输入密码" class="col-xs-10 col-sm-10" name="password" oninvalid="setCustomValidity('请输入密码');" oninput="setCustomValidity('');"/>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 确认密码 </label>
										<div class="col-sm-4">
											<input required type="password" id="form-field-2" placeholder="请输入确认密码" class="col-xs-10 col-sm-10" name="pwdconfirm" oninvalid="setCustomValidity('请输入确认密码');" oninput="setCustomValidity('');" />
										</div>
										<div class="col-sm-3 cpwd">
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 真实姓名 </label>
										<div class="col-sm-4">
											<input type="text" id="form-field-2" placeholder="请输入姓名" class="col-xs-10 col-sm-10" name="pname" />
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 所属部门 </label>
										<div class="col-sm-9">
											<select class="col-sm-4" name="department" required>
												<option value="">请选择所属部门</option>
											<?php foreach ($department as $key => $value) {?>
												<option value="<?php echo $value['department_id'];?>"><?php echo $value['department_name'];?></option>
											<?php }?>			
											</select>
										</div>
									</div>
									<div class="space-4"></div>
										
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 所属职位 </label>
										<div class="col-sm-9">
											<select class="col-sm-4" name="role" required>
												<option value="">请选择所属职位</option>
											<?php foreach ($role as $key => $value) {?>
												<option value="<?php echo $value['employee_job_id'];?>"><?php echo $value['employee_job_name'];?></option>
											<?php }?>	
											</select>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 电话号码 </label>
										<div class="col-sm-4">
											<input type="text" id="form-field-2" placeholder="电话号码" class="col-xs-10 col-sm-10" name="telephone" />
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 手机 </label>
										<div class="col-sm-5">
											<input type="text" id="form-field-2" placeholder="手机号码" class="col-xs-10 col-sm-8" name="employee_phone[]" type-data="true"/>
											<label style="float:left;margin-left:15px;">
												<input type="checkbox" class="ace" onclick="hit(this)"/>
												<span class="lbl">工作手机</span>
											</label>
											<input type="hidden" name="phone_hide[]" value="0">
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button id="phone_add" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
												</button>
											</div>
										</div>
										<div class="col-sm-3">

										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> QQ </label>
										<div class="col-sm-5">
											<input type="text" id="form-field-2" placeholder="QQ" class="col-xs-10 col-sm-8" name="employee_qq[]" type-data="true"/>
										
											<label style="float:left;margin-left:15px;">
												<input type="checkbox" class="ace" onclick="hit(this)" />
												<span class="lbl">工作QQ</span>
											</label>
											<input type="hidden" name="qq_hide[]" value="0">
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button id="qq_add" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
												</button>
											</div>
										</div>
										<div class="col-sm-3">

										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 邮箱 </label>
										<div class="col-sm-5">
											<input type="text" id="form-field-2" placeholder="邮箱" class="col-xs-10 col-sm-8" name="employee_email[]" type-data="true"/>
											<label style="float:left;margin-left:15px;">
												<input type="checkbox" class="ace" onclick="hit(this)" />
												<span class="lbl">工作邮箱</span>
											</label>
											<input type="hidden" name="email_hide[]" value="0">
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button id="email_add" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
												</button>
											</div>
										</div>
										<div class="col-sm-3">

										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 微信 </label>
										<div class="col-sm-4">
											<input type="text" id="form-field-2" placeholder="微信" class="col-xs-10 col-sm-10" name="employee_weixin[]" type-data="true"/>
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button id="weixin_add" type="button" class="btn spinner-up btn-xs btn-success">
													<i class="icon-plus smaller-75"></i>
												</button>
											</div>
										</div>
										<div class="col-sm-3">

										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-4"> 性别</label>
										<div class="col-sm-9">
											<div class="radio">
												<label style="padding-right:20px;">
													<input name="sex"  type="radio" value="1" class="ace" />
													<span class="lbl"> 男</span>
												</label>
												<label>
													<input name="sex" checked value="2" type="radio" class="ace" />
													<span class="lbl"> 女</span>
												</label>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 身份证 </label>
										<div class="col-sm-4">
											<input type="text" id="form-field-2" placeholder="请输入身份证" class="col-xs-10 col-sm-10" name="id_card" />
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 出生日期 </label>
										<div class="col-sm-3">
											<select name="selectYear" id="selectYear" style="width:70px;">
									
											</select>年
											
											<select name="selectMonth" id="selectMonth" style="width:70px;">
												
											</select>月
											<select name="selectDay" id="selectDay" style="width:70px;">
												
											</select>日
										</div>
										<div class="col-sm-5">
											<button type="button" class="btn btn-xs btn-warning advisory_info" data-toggle="modal" data-target="#advisory_info" >生日提醒</button>
											<span id="remind_people"></span>
											<input type="hidden" name="remind_peopleid" id="remind_peopleid">
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 籍贯 </label>
										<div class="col-sm-4">
											<select name="province" id="province">
										    	<option value="0">请选择</option>
										    	<?php foreach ($province as $item){?>
										    		<option value="<?php echo $item['region_id'];?>"><?php echo $item['region_name'];?></option>
										    	<?php }?>
										    </select>省
											<select name="city" id="city">
										    	<option value="0">请选择</option>
										    </select>市    
											<select name="sc" id="sc">
										    	<option value="0">请选择</option>
										    </select>区/县
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 婚姻状况 </label>
										<div class="col-sm-4">
											<div class="radio">
												<label style="padding-right:20px;">
													<input class="ace" checked type="radio" name="is_marry" value="0">
													<span class="lbl" style="z-index:9;">未婚</span>
												</label>
												<label>
													<input class="ace" type="radio" name="is_marry" value="1">
													<span class="lbl" style="z-index:9;">已婚</span>
												</label>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 学历 </label>
										<div class="col-sm-3">
											<select class="form-control" name="education">
												<option value="">请选择学历</option>
												<option value="小学及以下">小学及以下</option>
												<option value="初中">初中</option>
												<option value="高中">高中</option>
												<option value="中技">中技</option>
												<option value="高技">高技</option>
												<option value="大专">大专</option>
												<option value="本科">本科</option>
												<option value="研究生">研究生</option>
												<option value="博士及以上">博士及以上</option>
												<option value="其他">其他</option>
											</select>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 专业 </label>
										<div class="col-sm-4">
											<input type="text" id="form-field-2" placeholder="请输入专业" class="col-xs-10 col-sm-10" name="specialty" />
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 毕业学院 </label>
										<div class="col-sm-4">
											<input type="text" id="form-field-2" placeholder="请输入毕业学院" class="col-xs-10 col-sm-10" name="school" />
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 入职时间 </label>
										<div class="col-sm-3">
											<div class="input-group">
												<input class="form-control date-picker" id="id-date-picker-1" type="text" name="entry_time" data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d');?>" />
												<span class="input-group-addon">
													<i class="icon-calendar bigger-110"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="space-4"></div>

									<?php 
									$login_job = getcookie_crm('employee_job_id');
									$employee_arr = array(11);
									if(in_array($login_job, $employee_arr)){?>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 评分权限 </label>
										<div class="col-sm-9">
											<label>
												<input type="radio" name="mark_power" class="ace" value="1" />
												<span class="lbl" style="z-index:9;">评分权</span>
											</label>
											&nbsp;&nbsp;
											<label>
												<input type="radio" name="mark_power" class="ace" value="2" />
												<span class="lbl" style="z-index:9;">审核和添加标准等所有权</span>
											</label>
										</div>
									</div>
									<?php }?>

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
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="advisory_info" style="display: none;">
		  	<div class="modal-dialog">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="youModalLabel" class="modal-title">选择提醒人</h4>
		          	</div>
		          	<div class="modal-body">
						<ul id="menu" class="tree-folder-header tree">
							<?php foreach ($remind as $key => $value) { ?>	
							<li>
								<?php if(!empty($value['employee'][0]['employee_name'])){?>
									<i class="icon-plus"></i>
									<input type="checkbox" name="employee[]"  class="ace" value="<?php echo $value['department_id'];?>" id="c_<?php echo $key;?>"  />
									<span class="lbl">
										<label style="cursor:pointer;" for="c_<?php echo $key;?>"> <?php echo $value['department_name'];?></label> 
									</span>
								<?php }?>
									
								<?php if(!empty($value['employee'][0]['employee_name'])){?>
						    	<ul>
									<?php foreach ($value['employee'] as $k => $v) {?>
						        		<li class="second">
						        			<input type="checkbox" class="ace" name="employee_name[]" value="<?php echo $v['employee_id'];?>" />
						        			
						        			<span class="lbl" data-event="click"> <?php echo $v['employee_name'];?></span>
						        		</li>
									<?php }?>
									<div class="clear"></div>
						        </ul>
								<?php }?>
						    </li>
							<?php }?>
						</ul>
					</div>    
		          	<div class="modal-footer">
			            <button data-dismiss="modal" class="sure btn btn-info" type="button">确定</button>
			        </div>
		        </div>
		  	</div>
		</div>
		<textarea name="phone" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-5">
					<input type="text" name="employee_phone[]" placeholder="手机号码" class="col-xs-10 col-sm-8" type-data="true" />
					<label style="float:left;margin-left:15px;">
						<input type="checkbox" class="ace" onclick="hit(this)" />
						<span class="lbl">工作手机</span>
					</label>
					<input type="hidden" name="phone_hide[]" value="0">
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
	 	</textarea>
	 	<textarea name="qq" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-5">
					<input type="text" name="employee_qq[]" placeholder="QQ" class="col-xs-10 col-sm-8" type-data="true"/>
					<label style="float:left;margin-left:15px;">
						<input type="checkbox" class="ace" onclick="hit(this)" />
						<span class="lbl">工作QQ</span>
					</label>
					<input type="hidden" name="qq_hide[]" value="0">
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
	 	</textarea>
	 	<textarea name="email" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-5">
					<input type="text" name="employee_email[]" placeholder="邮箱" class="col-xs-10 col-sm-8" type-data="true"/>
					<label style="float:left;margin-left:15px;">
						<input type="checkbox" class="ace" onclick="hit(this)" />
						<span class="lbl">工作邮箱</span>
					</label>
					<input type="hidden" name="email_hide[]" value="0">
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
	 	</textarea>
	 	<textarea name="weixin" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-4">
					<input type="text" name="employee_weixin[]" placeholder="微信" class="col-xs-10 col-sm-10" type-data="true"/>
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-3"></div>
			</div>
	 	</textarea>
		<!-- basic scripts -->

		<!--[if !IE]> -->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url();?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
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
		<script src="<?php echo base_url('assets/js/ajax_class.js');?>"></script>
		<!-- inline scripts related to this page -->
		<script>
			function hit(obj){
				if($(obj).prop('checked')==true){
					$(obj).parent().next().val(1);
				}else{
					$(obj).parent().next().val(0);
				}
			}
			jQuery(function($){	
				//ajax获取员工信息		
				$('.sure').click(function(){
					var employee_id = new Array(); 
				  	$('input[name="employee_name[]"]:checked').each(function(){ 
				    	employee_id.push($(this).val()); //往数组里面推值
				  	}); 
					if (employee_id.length > 0){//如果有选中值就提交ajax
						$("#remind_peopleid").val(employee_id);//隐藏域接收
					    $.ajax({
					        type: "POST",
					        url: "<?php echo site_url(module_folder(1).'/admin/birthdayRemind');?>",
					        data: "id="+employee_id.join('|'),
					        dataType:'json',
					        success: function(res){
					        	//如果结果不对，不处理
					        	if(res.status==0){return ;}
					       		$("#remind_people").html(res.data);
					        }
				   		});
					}else{
						$("#remind_people").html(''); 
						$("#remind_peopleid").val(''); 
					}
				});
			});
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

				});
				
				//点击文字，触发旁边的点击事件
				$('span[data-event="click"]').click(function(){ 
						
						var z= $(this).prev();
						
						z[0].click(); 

				});
		
			});
 			jQuery(function($) {
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
					this.name=name;
					$('input[name="employee_'+name+'[]"]').bind('blur',function(){_this.blur_ajax(this);});
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
						$('input[name="employee_'+this.name+'[]"]').unbind();
						$('input[name="employee_'+this.name+'[]"]').bind('blur',function(){_this.blur_ajax(this);});
					},
					
					blur_ajax:function(obj){

					 	var v= $.trim(obj.value);
					 	var k=obj.name;
					 	var name;

					 	if(k.indexOf('qq')!==-1){ k='qq';}
					 	if(k.indexOf('phone')!==-1) {k='phone'};
					 	if(k.indexOf('email')!==-1) {k='email'};
					 	if(k.indexOf('weixin')!==-1) {k='weixin'};

					 	switch(k){
					 		case 'qq':
					 			name = 'QQ';
					 		break;

					 		case 'phone':
					 			name = '手机号码';
					 		break;

					 		case 'email':
					 			name = '邮箱';
					 		break;

					 		case 'weixin':
					 			name = '微信';
					 		break;
					 	}

					 	//如果值为空，不处理
					 	if (v==='') {return }


					 	//检查是否有字段值是重复的
					 	var i=0;
					 	$('input[name="'+obj.name+'"]').each(function(){
					 		if(this.value===v){
					 			i++;
					 		}
					 	});

					 	//如果有重复的值，就不做ajax
					 	if(i>1){
				 			$(obj).parent().next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">该值已经存在!</div>');
				 			$(obj).attr('type-data','false');
					 	}else{

					 		if( wdcrm.isCheck($(obj).val(),k) ){
								$.ajax({
								    type: "POST",
								    url: "<?php echo site_url(module_folder(1).'/admin/checkContact');?>",
								    data: 'type='+k+"&value="+v,
								    dataType:'json',
								   	success: function(res){
								        	if (res.status===1) {

								        		$(obj).parent().next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">'+res.con_info[0].employee_name+'已使用此'+name+'</div>');
								        		$(obj).attr('type-data','false');

								        	}else if(res.status==2){

								        		$(obj).parent().next().html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
								        		$(obj).attr('type-data','true');

								        	}
								        }
				   					});

							    }else{

						 			$(obj).parent().next().html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">此'+name+'不正确!</div>');

					 			}
							}

					}	
				}

	 			new AddInput('#phone_add','phone').add();
	 			new AddInput('#qq_add','qq').add();
	 			new AddInput('#email_add','email').add();
	 			new AddInput('#weixin_add','weixin').add();
			});
			jQuery(function(){

				function DateSelector(selYear, selMonth, selDay)
				{
				    this.selYear = selYear;
				    this.selMonth = selMonth;
				    this.selDay = selDay;
				    this.selYear.Group = this;
				    this.selMonth.Group = this;
				    // 给年份、月份下拉菜单添加处理onchange事件的函数
				    if(window.document.all != null) // IE
				    {
				        this.selYear.attachEvent("onchange", DateSelector.Onchange);
				        this.selMonth.attachEvent("onchange", DateSelector.Onchange);
				    }
				    else // Firefox
				    {
				        this.selYear.addEventListener("change", DateSelector.Onchange, false);
				        this.selMonth.addEventListener("change", DateSelector.Onchange, false);
				    }

				    if(arguments.length == 4) // 如果传入参数个数为4，最后一个参数必须为Date对象
				        this.InitSelector(arguments[3].getFullYear(), arguments[3].getMonth() + 1, arguments[3].getDate());
				    else if(arguments.length == 6) // 如果传入参数个数为6，最后三个参数必须为初始的年月日数值
				        this.InitSelector(arguments[3], arguments[4], arguments[5]);
				    else // 默认使用当前日期
				    {
				        var dt = new Date();
				        this.InitSelector(dt.getFullYear(), dt.getMonth() + 1, dt.getDate());
				    }
				}

				// 增加一个最大年份的属性
				DateSelector.prototype.MinYear = 1900;

				// 增加一个最大年份的属性
				DateSelector.prototype.MaxYear = (new Date()).getFullYear();

				// 初始化年份
				DateSelector.prototype.InitYearSelect = function()
				{
				    // 循环添加OPION元素到年份select对象中
				    for(var i = this.MaxYear; i >= this.MinYear; i--)
				    {
				        // 新建一个OPTION对象
				        var op = window.document.createElement("OPTION");
				        
				        // 设置OPTION对象的值
				        op.value = i;
				        
				        // 设置OPTION对象的内容
				        op.innerHTML = i;
				        
				        // 添加到年份select对象
				        this.selYear.appendChild(op);
				    }
				}

				// 初始化月份
				DateSelector.prototype.InitMonthSelect = function()
				{
				    // 循环添加OPION元素到月份select对象中
				    for(var i = 1; i < 13; i++)
				    {
				        // 新建一个OPTION对象
				        var op = window.document.createElement("OPTION");
				        
				        // 设置OPTION对象的值
				        op.value = i;
				        
				        // 设置OPTION对象的内容
				        op.innerHTML = i;
				        
				        // 添加到月份select对象
				        this.selMonth.appendChild(op);
				    }
				}

				// 根据年份与月份获取当月的天数
				DateSelector.DaysInMonth = function(year, month)
				{
				    var date = new Date(year, month, 0);
				    return date.getDate();
				}

				// 初始化天数
				DateSelector.prototype.InitDaySelect = function()
				{
				    // 使用parseInt函数获取当前的年份和月份
				    var year = parseInt(this.selYear.value);
				    var month = parseInt(this.selMonth.value);
				    
				    // 获取当月的天数
				    var daysInMonth = DateSelector.DaysInMonth(year, month);
				    
				    // 清空原有的选项
				    this.selDay.options.length = 0;
				    // 循环添加OPION元素到天数select对象中
				    for(var i = 1; i <= daysInMonth ; i++)
				    {
				        // 新建一个OPTION对象
				        var op = window.document.createElement("OPTION");
				        
				        // 设置OPTION对象的值
				        op.value = i;
				        
				        // 设置OPTION对象的内容
				        op.innerHTML = i;
				        
				        // 添加到天数select对象
				        this.selDay.appendChild(op);
				    }
				}

				// 处理年份和月份onchange事件的方法，它获取事件来源对象（即selYear或selMonth）
				// 并调用它的Group对象（即DateSelector实例，请见构造函数）提供的InitDaySelect方法重新初始化天数
				// 参数e为event对象
				DateSelector.Onchange = function(e)
				{
				    var selector = window.document.all != null ? e.srcElement : e.target;
				    selector.Group.InitDaySelect();
				}

				// 根据参数初始化下拉菜单选项
				DateSelector.prototype.InitSelector = function(year, month, day)
				{
				    // 由于外部是可以调用这个方法，因此我们在这里也要将selYear和selMonth的选项清空掉
				    // 另外因为InitDaySelect方法已经有清空天数下拉菜单，因此这里就不用重复工作了
				    this.selYear.options.length = 0;
				    this.selMonth.options.length = 0;
				    
				    // 初始化年、月
				    this.InitYearSelect();
				    this.InitMonthSelect();
				    
				    // 设置年、月初始值
				    this.selYear.selectedIndex = this.MaxYear - year;
				    this.selMonth.selectedIndex = month - 1;
				    
				    // 初始化天数
				    this.InitDaySelect();
				    
				    // 设置天数初始值
				    this.selDay.selectedIndex = day - 1;
				}
				var selYear = window.document.getElementById("selectYear");
				var selMonth = window.document.getElementById("selectMonth");
				var selDay = window.document.getElementById("selectDay");

				// 新建一个DateSelector类的实例，将三个select对象传进去
				new DateSelector(selYear, selMonth ,selDay, <?php echo date('Y');?>, <?php echo date('m');?>, <?php echo date('d');?>);
		        
			});	
			//联动菜单
 			jQuery(function($) {
 				var province = document.getElementById("province");
				var city = document.getElementById("city");
				var sc = document.getElementById("sc");
					
				province.onchange = get_city; 
				city.onchange = get_sc;
					
				function get_city(){
					city.length = 1;
					sc.length = 1;
					
					var ajax = new AJAXRequest();
					ajax.method = "get";
					ajax.url = "<?php echo site_url(module_folder(1).'/admin/region?region_id=');?>" + this.value;
					ajax.callback = show_city;
					
					ajax.send();	
				}

				function show_city(obj){
					var list = eval(obj.responseText);	
					for(var i=0; i< list.length; i++){
						city[i + 1] = new Option(list[i].region_name, list[i].region_id);	
					}
				}

				function get_sc(){
					sc.innerHTML = '<option value="0">请选择</option>';
					var ajax = new AJAXRequest();
					ajax.method = "get";
					ajax.url = "<?php echo site_url(module_folder(1).'/admin/region?region_id=');?>" + this.value;
					ajax.callback = show_sc;
					ajax.send();	
				}

				function show_sc(obj){
					var list = eval(obj.responseText);			
					for(var i=0; i< list.length; i++){			
						sc[i + 1] = new Option(list[i].region_name, list[i].region_id);			
					}
				}
			});	
 			jQuery(function($) {
 				$('form[name="add"]').submit(function(){

 					//判断是否重复名
 					var result=true;
		        	var name=$.trim($('input[name="username"]').val());
		        	
						$.ajax({
							async: false,
						    type: "POST",
						    url: "<?php echo site_url(module_folder(1).'/admin/check');?>",
						    data: 'value='+name,
						    dataType:'json',
						   	success: function(res){
					        	if (res.status===1) {
					        		$('.cname').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">'+name+'已存在</div>');
					        		result=false;
					        	}else if(res.status==0){
					        		$('.cname').html('<div style="color: rgb(123, 160, 101);" class="help-block col-xs-12 col-sm-reset inline">成功</div>');
					        	}
					        }
	   					});
	   					var p=$.trim($('input[name="password"]').val());
						var v=$.trim($('input[name="pwdconfirm"]').val());
		                if (p!=v) {
			                $('.cpwd').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline"><b>密码和确认密码不一致</b></div>');
			                return false;
		                }
		                //主动触发姓名、手机号码、QQ、email失去焦点
						$('input[name="employee_phone[]"]').blur();
						$('input[name="employee_qq[]"]').blur();
						$('input[name="employee_email[]"]').blur();
						$('input[name="employee_weixin[]"]').blur();

		 				//检测phone、qq、email是否存在
		 				var phone = $('input[name="employee_phone[]"]');
		 				var qq = $('input[name="employee_qq[]"]');
		 				var email = $('input[name="employee_email[]"]');
		 				var weixin = $('input[name="employee_weixin[]"]');

		 				var _phonenum = 0;
		 				var _qqnum = 0;
		 				var _emailnum = 0;
		 				var _weixinnum = 0;
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

		 				weixin.each(function(){

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
		 				if(_weixinnum > 0){
		 					return false;
		 				}
					return result;
 				});	
		    });
		</script>
</body>
</html>
