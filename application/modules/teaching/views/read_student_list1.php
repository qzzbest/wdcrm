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
						</ul><!-- .breadcrumb -->
						<div class="nav-search" id="nav-search">
							<form name="student_search" class="form-search" action="" method="get">
								<span class="input-icon">
									<select class="form-control" name="key">
										<option <?php if(isset($student_info['key']) && $student_info['key'] == 'student_name'){ echo 'selected=selected';}?> value="student_name">姓名</option>
										<option <?php if(isset($student_info['key']) && $student_info['key'] == 'qq'){ echo 'selected=selected';}?> value="qq">QQ</option>
										<option <?php if(isset($student_info['key']) && $student_info['key'] == 'phones'){ echo 'selected=selected';}?> value="phones">phone</option>
										<option <?php if(isset($student_info['key']) && $student_info['key'] == 'email'){ echo 'selected=selected';}?> value="email">email</option>
										<option <?php if(isset($student_info['key']) && $student_info['key'] == 'student_education'){echo 'selected=selected';}?> value="student_education">学历</option>
										<option <?php if(isset($student_info['key']) && $student_info['key'] == 'student_school'){echo 'selected=selected';}?> value="student_school">学校</option>
										<option <?php if(isset($student_info['key']) && $student_info['key'] == 'student_specialty'){echo 'selected=selected';}?> value="student_specialty">专业</option>
									</select>
								</span>
								<span class="input-icon">
									<input type="text" name="search" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" value="<?php if(isset($student_info['search']))echo $student_info['search'];?>" />
									<i class="icon-search nav-search-icon"></i>
								</span>
								<span class="input-icon">
								<button class="btn btn-xs btn-primary">搜索</button>
								</span>
							</form>
						</div><!-- #nav-search -->
					</div>

					<div class="page-content">
						<div class="page-header">
							<span>学员人数:<em style="color:red"><?php echo $student_info['count'];?></em>人</span>
							
							<span>
								<a href="<?php echo site_url(module_folder(4).'/student/index');?>" class="btn btn-xs btn-primary">学生列表</a>
							</span>

							<div style="float:right;margin-right:30px;">	
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
						</div>
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table id="sample-table-1" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<th class="center">
															<label>
																<input type="checkbox" class="ace" />
																<span class="lbl"></span>
															</label>
														</th>
														<th class="center">序号</th>
														<th class="center">学号</th>
														<th class="center">姓名</th>
														<th class="center">目前就读班级</th>
														<th class="center">咨询师</th>
														<th class="center">就读状态</th>
														<th class="center">复读知识点</th>
														<th>操作</th>
														
													</tr>
												</thead>

												<tbody>
													<?php foreach ($student_info['list'] as $key => $value) {?>
													<tr>
														<td class="center">
															<label>
																<input type="checkbox" class="ace" name="id[]" value="" />
																<span class="lbl"></span>
															</label>
														</td>
														<td class="center">
															<?php echo $value['serial_number'];?>
														</td>
														<td class="center">
															<?php echo $value['student_number'];?>
														</td>
														<td class="center">
															<?php echo $value['student_name'];?>
														</td>
														<td class="center">
															<?php
																if( !empty($value['class']) ){
																	foreach ($value['class'] as $item) {
																		echo $item.'<br />';
																	}
																}
															?>
														</td>
														<td class="center">
															<?php echo $value['employee']['employee_name'];?>
														</td>
														<td class="center">
															<?php
																if($value['student_status']==1){
																	echo '就读';
																}else if ($value['student_status']==2) {
																	echo '毕业';
																}else if ($value['student_status']==0) {
																	echo '休学';
																}
															?>
														</td>
														<td>
															<?php 
															if(!empty($value['read_knowledge'])){
																$read_knowledge = '';
																foreach ($value['read_knowledge'] as $key => $value) {
																	$read_knowledge .= $value['knowledge_name'].'，';
																}
																echo rtrim($read_knowledge,'，');
																echo '<font color="red">（一般只有一次一个知识点）</font>';
															}
															?>
														</td>
														<td class="center">
															<a href="" class="btn btn-xs btn-warning student_info" role="button" data-toggle="modal" data-target="#student_info" data="<?php echo $value['student_id'];?>">详细信息</a>
															<a href="" class="btn btn-xs btn-success student_class" role="button" data-target="#classModal" data-toggle="modal" data="<?php echo $value['student_id'];?>" onclick="wdcrm.set_id('student_id',<?php echo $value['student_id']?>)">复读</a>
														</td>
													</tr>
													<?php }?>
												</tbody>
											</table>
											<!-- 批量复读 -->
											<a href="javascript:void(0);" class="btn btn-xs btn-danger repeatRead" role="button" data-target="#classModal" data="<?php echo $value['student_id'];?>" onclick="wdcrm.set_id('student_id',<?php echo $value['student_id']?>)">复读</a>
											<!-- <a class="btn btn-xs btn-danger repeatRead" role="button">复读</a> -->
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
		
		<!--模态框（弹出 学员的详细信息信息）-->
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

		<!--模态框（弹出班级安排信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="classModal" style="display: none;">
		  	<div class="modal-dialog">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">请选择复读班级</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(4).'/student/arrangeClass')?>" method="post">
		          		<input type="hidden" id="student_id" name="student_id" value="" />
						<div class="modal-body">
							<input type="radio" name="" value="" />A1401 -- 课程进度：html<br />
							<input type="radio" name="" value="" />A1402 -- 课程进度：css<br />
							<input type="radio" name="" value="" />A1403 -- 课程进度：javascript<br />
						</div>
						
						<div class="modal-body">
							备注：.......
						</div>

			          	<div class="modal-footer">
			          		<input class="btn btn-info" type="submit" value="提交" />
				            <button data-dismiss="modal" class="btn" type="button">取消</button>
				        </div>
			        </form>
		        </div>
		  	</div>
		</div>

		<!--模态框（弹出修改学员状态信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="statusModal" style="display: none;">
		  	<div class="modal-dialog">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">学员状态</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(4).'/student/editStudentStatus')?>" method="post">
		          		<input type="hidden" id="student_statusid" name="student_statusid" value="" />
						<div class="modal-body">
							<table cellpadding="5px">
								<tr>
									<td class="col-sm-2">学员状态</td>
									<td class="col-sm-8" id="student_status">
									<select class="form-control" name="student_status">';

										<option value="1">就读</option>
										<option value="2">毕业</option>
										<option value="0">休学</option>
									</select>
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">备注</td>
									<td class="col-sm-8">
										<textarea style="height:100px;" class="form-control" id="status_remark" name="status_remark" placeholder="状态备注"></textarea>
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
			//搜索学生的相关信息
			jQuery(function($){

				var url='<?php echo site_url(module_folder(4).'/student/index/index/0');?>';

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
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'knowledge_id='+knowledge_id;
					
					window.location.href=z;


				});

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

			jQuery(function($) {	
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
				        url: "<?php echo site_url(module_folder(4).'/student/info');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==1){
				        		$("#student_info").find('.modal-body').html(res.data);
				       			$("#stu_info").html('<a href="'+res.info_url+'">修改学员信息 >></a>');
				       		}
				        }
			   		});
				});
				//ajax获取学生所在班级	
				$('.student_class').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(4).'/student/studentClass');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==1){
				        		$("#sel_class").html(res.data);
				        	}
				       		
				        }
			   		});
				});
				//ajax获取学员状态	
				$('.student_status').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(4).'/student/studentStatus');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==1){
				        		$("#student_status").html(res.data);
				        		$("#status_remark").html(res.remark);
				        	}
				       		
				        }
			   		});
				});

			});	

			jQuery(function($){
				//操作“复读”
				$(".repeatRead").on(ace.click_event, function() {
					//检测有多少个被选中了，0个删除不弹出确定框。
					var length= $('input[name="id[]"]:checked').length;
					if(length>0){
						$('#classModal').show();
						/*var changeKnowledge = $('#changeKnowledge option:selected').html();
						changeKnowledge = changeKnowledge == '全部' ? '全部知识点' : changeKnowledge;

						bootbox.confirm("你确定复读<em style='color:red;'>"+changeKnowledge+"</em>", function(result) {
							if(result) {
								
							}
						});*/
					}
				});
			});	
		</script>
</body>
</html>