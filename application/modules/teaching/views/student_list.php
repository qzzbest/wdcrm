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
		<style>
			.tagMenu {border-bottom: 1px solid #ddd;height: 30px;position: relative;margin-bottom: 15px; margin-top:20px;}
			.tagMenu ul {list-style: none;bottom: -1px; height: 18px;position: absolute;}
			.tagMenu ul li {background-color:#ccc;border: 1px solid #ddd;color: #999; cursor: pointer;float: left;height: 28px;line-height: 29px;margin-left: 4px;text-align: center;width: 108px;border-radius:5px 5px 0 0;}
			.tagMenu li.current {background-color:#fff;border-color: #ddd;border-style: solid solid none;color: #6c6c6c;border-radius:5px 5px 0 0;cursor: pointer;height: 29px;line-height: 29px;}
			.tagMenu ul li a{display:block;text-decoration: none;}
			.font_red{color:red;}
			.font_blue{color:blue;}
			.cls_known th{ text-align: center; height: 30px;}
			.cls_known tr{ height: 30px;}
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
							<?php foreach(unserialize(getcookie_crm('url')) as $item){?>
								<li>
									<a href="<?php echo $item[1];?>"><?php echo $item[0];?></a>
								</li>
							<?php }?>
						</ul><!-- .breadcrumb -->
						<div style="position:absolute;right:28%;top:6px;line-height:24px;">	
							<table>
								<tr>
									<td>
										<span>报名日期:</span>
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

					<div class="tagMenu">
						<ul class="menu">
							<li <?php echo $type=='index' ? 'class="current"': '' ?> ><a href="<?php echo site_url(module_folder(4).'/student/index/index');?>">学生列表</a></li>
		                    <li <?php echo $type=='repeat' ? 'class="current"': '' ?> ><a href="<?php echo site_url(module_folder(4).'/student/repeatReadStudent/repeat');?>">复读学生</a></li>
						</ul>
				    </div>
					<?php switch ($type) {
		                case 'index':
		                    echo $this->load->view('student_list_all');
		                    break;
		                case 'repeat':
		                    echo $this->load->view('read_student_list');
		                    break;
		                case 'exam':
		                    echo $this->load->view('exam_snippet');
		                    break;
		            } ?>
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

		<!--模态框（弹出 咨询者的详细信息信息）-->
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="course_info" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		            	<h4 id="youModalLabel" class="modal-title">报读课程</h4>
		          	</div>
		          	<div class="modal-body">    
		          	</div>
		          	<div class="modal-footer">
			            <button data-dismiss="modal" class="btn btn-info" type="button">确定</button>
			        </div>
		        </div>
		  	</div>
		</div>

		<!--模态框（弹出 学员的要复读知识点）-->
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="repeatKnowledge" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		            	<h4 id="youModalLabel" class="modal-title"><span id="stu_name" style="color:blue;"></span> 要复读知识点</h4>
		          	</div>
		          	<div class="modal-body">    
		          	</div>
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
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close hidesel">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">班级安排</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(4).'/student/arrangeClass')?>" method="post" name="arrclass">
		          		<input type="hidden" id="student_id" name="student_id" value="" />
						<div class="modal-body">
							<table cellpadding="5px">
								<!-- <tr>
									<td class="col-sm-2">班级名称</td>
									<td class="col-sm-8" id="sel_class">
									</td>
								</tr> -->
								<tr>
									<td>
										请选择班级<span style="color:red;">（橙色：未读；红色：正在读；蓝色：已读完；）</span>
									</td>
								</tr>
								<tr>
									<td id="sel_class">
									</td>
								</tr>
							</table>
							<div id="showsel" style="color:#ff0000;"></div>
						</div>
			          	<div class="modal-footer">
			          		<input class="btn btn-info" type="submit" value="提交" />
				            <button data-dismiss="modal" class="btn hidesel" type="button">取消</button>
				        </div>
			        </form>
		        </div>
		  	</div>
		</div>
	
		<!--模态框（弹出批量班级安排信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="allclassModal" style="display: none;">
		  	<div class="modal-dialog">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close allhidesel">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">班级安排</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(4).'/student/allArrangeClass')?>" method="post" name="allarrclass">
		          		<input type="hidden" name="all_student" value="" id="all_student">
						<div class="modal-body">
							<table cellpadding="5px">
								<!-- <tr>
									<td class="col-sm-2">班级名称</td>
									<td class="col-sm-8">
										<select class="form-control" name="allclass" required>
											<option value="">请选择班级</option>
											<?php foreach ($classroom_list as $value) { ?>
												<option value="<?php echo $value['classroom_id']; ?>"><?php echo $value['classroom_name']; ?></option>
											<?php } ?>
										</select>	
									</td>
								</tr> -->
								<tr>
									<td>请选择班级<span style="color:red;">（橙色：未读；红色：正在读；蓝色：已读完；）</span></td>
								</tr>
								<tr>
									<td>
										<?php foreach ($classroom_list as $value) { ?>
										<div>
										<label>
											<input type="checkbox" class="ace" name="allclass[]" value="<?php echo $value['classroom_id']; ?>"  />
											<span class="lbl"><?php echo $value['classroom_name']; ?></span>
											<span class="lbl"><font color="blue"><?php echo $value['knowledge']; ?></font></span>
										</label>
										</div>
										<?php } ?>
									</td>
								</tr>
							</table>
							<div id="allshowsel" style="color:#ff0000;"></div>
						</div>
			          	<div class="modal-footer">
			          		<input class="btn btn-info" type="submit" value="提交" />
				            <button data-dismiss="modal" class="btn allhidesel" type="button">取消</button>
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
		<!--模态框（弹出预分配学号信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="pre_allot" style="display: none;">
		  	<div class="modal-dialog">
		        <div class="modal-content">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">预分配学号</h4>
		          	</div>
		          	<form action="<?php echo site_url(module_folder(4).'/student/preNumberAdd')?>" method="post" name="prenumber">
						<div class="modal-body">
							<table cellpadding="5px">
								<tr>
									<td class="col-sm-3" align="right">手机号码</td>
									<td>
										<input type="text" class="con_stu_phone" name="con_stu_phone" placeholder="手机号码" value="" />
									</td>
									<td><div class="phonemessage"></div></td>
								</tr>
								<tr>
									<td class="col-sm-3" align="right">QQ</td>
									<td>
										<input type="text" class="con_stu_qq" name="con_stu_qq" placeholder="QQ" value="" />
									</td>
									<td><div class="qqmessage"></div></td>
								</tr>
								<tr>
									<td class="col-sm-3" align="right">姓  名</td>
									<td>
										<input type="text" class="con_stu_name" name="con_stu_name" placeholder="姓名" value="" />
									</td>
									<td></td>
								</tr>
							</table>
							<div class="return_check"></div>
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
			jQuery(function($){
				//时间控件
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){		
					$(this).prev().focus();
				});
			
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});

				//列表全选、反选功能
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});

				$(".all_arrange").click(function() {
				
					//检测有多少个被选中了，0个删除不弹出确定框。
					var length= $('input[name="id[]"]:checked').length;

					if(length>0){
						var arr_check = new Array(); 
						$('input[name="id[]"]:checked').each(function(i){
							if($(this).val!=''){
								arr_check[i] = $(this).val(); 
							}
			                 
			            });
						$('#all_student').val(arr_check);

						$(".all_arrange").attr('data-target','#allclassModal');
						$(".all_arrange").attr('data-toggle','modal');
					}else{
						$(".all_arrange").attr('data-target','');
						$(".all_arrange").attr('data-toggle','');
						alert('请选择要安排班级的学生');
						return false;
					}
				});
			});	
			jQuery(function($){
				//报名日期
				$('button[data-event="searchTime"]').click(function(){

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
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'&start_time='+start_time+'&end_time='+end_time;
					
						window.location.href=z;

				});

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
					//干掉老师id
					delete arr.knowledge_id;
					if(arr.per_page){
						delete arr.per_page;
					}
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
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'teach='+teach_id;
					
					window.location.href=z;

				});

				$('button[data-event="searchKnownledge"]').click(function(){

					var select_type = $('select[name="select_type"]').val();
					var knowledge_id = $('#changeKnowledge').val();

					if(knowledge_id != ""){

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
						//干掉开始参数
						delete arr.select_type;
						delete arr.knowledge_id;

						if(arr.per_page){
							delete arr.per_page;
						}
						var par='';
						for(var k in arr){
							par+=k+'='+arr[k]+'&';
						}
						
						var res= url+'?'+par;
						
						var z=res+'select_type='+select_type+'&knowledge_id='+knowledge_id;
						
						window.location.href=z;
					}else{
						alert('请选择知识点！');
					}

					

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

				//ajax获取学员要复读知识点
				$('.repeatKnowledge').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(4).'/student/repeatKnowledge');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==1){
				        		$('#stu_name').html(res.stu_name);
				        		$("#repeatKnowledge").find('.modal-body').html(res.data);
				       		}
				        }
			   		});
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
				//ajax获取课程信息		
				$('.course_info').click(function(){
					var repayment_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(4).'/student/courseInfo');?>",
				        data: "id="+repayment_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==0){ return ;}
				       		$("#course_info").find('.modal-body').html(res.data);
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
			//预学号js验证
			jQuery(function($) {
				$('input[name="con_stu_phone"]').blur(function () {
		        	var cp = $.trim($(this).val());             
		            if (cp=='') {
		            	$('.phonemessage').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请输入手机号码</div>');
	                } else {
		                
		                $.ajax({
					        type: "POST",
					        url: "<?php echo site_url(module_folder(4).'/student/checkType');?>",
					        data: 'type=phones'+"&value="+cp,
					        dataType:'json',
					        success: function(res){
					        	if (res.status===1) {
					        		$('.con_stu_name').val(res.consultant_name);
					        	}else if(res.status===2){

					        	}
					        }
	   					});
	   					$('.phonemessage').html('');
	                }
		        });
		        $('input[name="con_stu_qq"]').blur(function () {
		        	var cq = $.trim($(this).val());             
		            if (cq=='') {
		            	$('.qqmessage').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请输入QQ</div>');
	                } else {
	                	$.ajax({
					        type: "POST",
					        url: "<?php echo site_url(module_folder(4).'/student/checkType');?>",
					        data: 'type=qq'+"&value="+cq,
					        dataType:'json',
					        success: function(res){
					        	if (res.status===1) {
					        		$('.con_stu_name').val(res.consultant_name);
					        	}else if(res.status===2){
					        		
					        	}
					        }
	   					});
		                $('.qqmessage').html('');
	                }
		        });

				$('form[name="prenumber"]').submit(function () {
					var p=$.trim($('.con_stu_phone').val());
					var q=$.trim($('.con_stu_qq').val());
					//至少要输入手机或者QQ的一种
					if (p!='' || q!='') {
		               	 return true;
	                }else{
	                	$('.return_check').html('<div style="color: rgb(209, 110, 108);" class="help-block col-xs-12 col-sm-reset inline">请输入手机或QQ其中一种,以保证数据的准确</div>');
	                	return false;
	                }
				});  
			});
			//安排班级，批量安排班级js验证
			jQuery(function($) {
				$('form[name="arrclass"]').submit(function () {
					var obj = document.getElementsByName('class[]');  
					var count=obj.length;  
					var j=0;  
					for(var i=0;i<count;i++){  
					   if (obj[i].checked && !obj[i].disabled){  
					       j++;  
					   	}  
					}  
					if(j==0){       
					   $('#showsel').html('请至少选择一个班级');
					   return false;  
					}  
	       		});
	       		$('.hidesel').click(function(){
	       			$('#showsel').html('');
	       		});
	       		$('form[name="allarrclass"]').submit(function () {
					if ($("input[name='allclass[]']:checked").length < 1) {
			            $('#allshowsel').html('请至少选择一个班级');
			            return false;  
			        }
	       		});
	       		$('.allhidesel').click(function(){
	       			$('#allshowsel').html('');
	       		});
			});
		</script>
</body>
</html>