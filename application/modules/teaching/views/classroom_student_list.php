<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>班级学生列表</title>
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
			.tagMenu {border-bottom: 1px solid #ddd;height: 30px;position: relative;margin-bottom: 15px;}
			.tagMenu ul {list-style: none;bottom: -1px; height: 18px;position: absolute;}
			.tagMenu ul li {background-color:#ccc;border: 1px solid #ddd;color: #999; cursor: pointer;float: left;height: 28px;line-height: 29px;margin-left: 4px;text-align: center;width: 108px;border-radius:5px 5px 0 0;}
			.tagMenu li.current {background-color:#fff;border-color: #ddd;border-style: solid solid none;color: #6c6c6c;border-radius:5px 5px 0 0;cursor: pointer;height: 29px;line-height: 29px;}
			.tagMenu ul li a{display:block;text-decoration: none;}
			.font_red{color:red;}
			.font_blue{color:blue;}
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
						<?php $this->load->view('search_student');?>
					</div>

					<div class="page-content">
						
						<div class="page-header">
							<h3 style="font-size:20px;">
								班级名称：<em style="color:red;"><?php echo $classroom_info['classroom_name'];?></em>&nbsp;&nbsp;
								<?php if(!empty($classroom_info['old_classroom_name'])){?>
									升级前的班级：<em style="color:red;"><?php echo $classroom_info['old_classroom_name'];?></em>&nbsp;&nbsp;
								<?php } ?>
								开班时间：<em style="color:red;"><?php echo date('Y-m-d',$classroom_info['open_classtime']);?></em>&nbsp;&nbsp;
								上课时间：<em style="color:red;"><?php echo $classroom_info['class_time'];?></em>
							</h3>
							<h3>
								<span class="btn-xs">学员总数:<em style="color:red;"><?php echo $class_student_info['count'];?></em>人</span>	
								<!-- 此处要有一个班级知识点“配置表” ，查询调出班级对应知识点-->
								<span class="btn-xs">课程进度：
									<?php
										$login_job = getcookie_crm('employee_job_id'); 
										if(in_array($login_job, array(2))){?>
											<?php
												if(!empty($class_knownledge)){
													$str = '';
													foreach ($class_knownledge as $k => $v) {
														if($v['schedule_state']==0){
															$str .= '<span class="font_red">'.$v['knowledge_name'].'</span>';
															$str .= '&nbsp;&nbsp;&nbsp;';
														}else if($v['schedule_state']==1){
															$str .= '<span class="font_blue">'.$v['knowledge_name'].'</span>';
															$str .= '&nbsp;&nbsp;&nbsp;';
														}else if($v['schedule_state']==2){
															$str .= '<span>'.$v['knowledge_name'].'</span>';
															$str .= '&nbsp;&nbsp;&nbsp;';
														}
													}
													echo $str;
												}
											?>
									<?php }else{ ?>
											<?php foreach ($class_knownledge as $key => $value) {
											if($value['schedule_state'] == 2){
												?>
												<a href="" class="btn btn-xs btn-primary tooltip-info" style="margin-right:5px;" role="button" data-toggle="modal" data-target="#course_schedule" course_type="<?php echo $value['schedule_state'];?>" cls_konwid="<?php echo $value['id'];?>" course_id="<?php echo $value['knowledge_id'];?>" course_name="<?php echo $value['knowledge_name'];?>"  data-rel="tooltip" data-placement="bottom" title="<?php if($value['knowledge_lesson']){echo '总共有 '.$value['knowledge_lesson'].' 个课时';}else{echo '没有安排课时！';}?>"><?php echo $value['knowledge_name'];?></a>
											<?php }else if($value['schedule_state'] == 1){?> 
												<a href="" class="btn btn-xs btn-danger tooltip-info" style="margin-right:5px;" role="button" data-toggle="modal" data-target="#course_schedule" course_type="<?php echo $value['schedule_state'];?>" cls_konwid="<?php echo $value['id'];?>" course_id="<?php echo $value['knowledge_id'];?>" course_name="<?php echo $value['knowledge_name'];?>"  data-rel="tooltip" data-placement="bottom" title="<?php if($value['knowledge_lesson']){echo '总共有 '.$value['knowledge_lesson'].' 个课时';}else{echo '没有安排课时！';}?>"><?php echo $value['knowledge_name'];?></a>
											<?php }else{?> 
												<a href="" class="btn btn-xs btn-warning tooltip-info" style="margin-right:5px;" role="button" data-toggle="modal" data-target="#course_schedule" course_type="<?php echo $value['schedule_state'];?>" cls_konwid="<?php echo $value['id'];?>" course_id="<?php echo $value['knowledge_id'];?>" course_name="<?php echo $value['knowledge_name'];?>"  data-rel="tooltip" data-placement="bottom" title="<?php if($value['knowledge_lesson']){echo '总共有 '.$value['knowledge_lesson'].' 个课时';}else{echo '没有安排课时！';}?>"><?php echo $value['knowledge_name'];?></a>
											<?php }
											}?>
										<span style="color:red;">（橙色：未读；红色：正在读；蓝色：已读完；）</span>
									<?php }?>
								</span>
							</h3>
							<?php
							if(!in_array($login_job, array(2))){?>
							<span style="float:right;margin:-10px 10px 0 0">
								<a href="<?php echo site_url(module_folder(4).'/classroom/attendanceExport/'.$classroom_info['classroom_id']);?>" class="btn btn-xs btn-primary" role="button">导出考勤表</a>
							</span>
							<?php }?>
						</div>
		
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="tagMenu">
									<ul class="menu">
										<li <?php echo $act=='index' ? 'class="current"': '' ?>><a href="<?php echo site_url(module_folder(4).'/classroom/classroomStudent/index/'.$classroom_info['classroom_id']);?>">学生列表</a></li>
					                    <li <?php echo $act=='attendance' ? 'class="current"': '' ?>><a href="<?php echo site_url(module_folder(4).'/classroom/classroomStudent/attendance/'.$classroom_info['classroom_id']);?>">考勤记录</a></li>
					                    <li <?php echo $act=='homework' ? 'class="current"': '' ?>><a href="<?php echo site_url(module_folder(4).'/classroom/classroomStudent/homework/'.$classroom_info['classroom_id']);?>">作业记录</a></li>
					                    <li <?php echo $act=='exam' ? 'class="current"': '' ?>><a href="<?php echo site_url(module_folder(4).'/classroom/classroomStudent/exam/'.$classroom_info['classroom_id']);?>">成绩列表</a></li>
									</ul>
							    </div>
							     <?php switch ($act) {
					                case 'index':
					                    echo $this->load->view('student_snippet');
					                    break;
					                case 'attendance':
					                    echo $this->load->view('attendance_snippet');
					                    break;
					                case 'homework':
					                    echo $this->load->view('homework_snippet');
					                    break;
					                case 'exam':
					                    echo $this->load->view('exam_snippet');
					                    break;
					            } ?>

								<!-- /row -->							
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

		<!--模态框（弹出转班信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="change_class" style="display: none;">
		  	<div class="modal-dialog">
		        <div class="modal-content">
		        <form name="arrclass" action="<?php echo site_url(module_folder(4).'/classroom/changeClass')?>" method="post">
		         	<div class="modal-header">
		         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
		            	<h4 id="inputModalLabel" class="modal-title">转班信息</h4>
		          	</div>
		          		<input type="hidden" id="student_id" name="student_id" value="" />
		          		<input type="hidden" name="class_ago" value="<?php echo $classroom_info['classroom_id'];?>" />
						<div class="modal-body ">
							<table cellpadding="5px">
								<tr>
									<td class="col-sm-2">原来的班级:</td>
									<td class="col-sm-8">
										<input type="text" value="<?php echo $classroom_info['classroom_name'];?>" readonly id="form-input-readonly" class="col-xs-10 col-sm-5" >
									</td>
								</tr>
								<tr>
									<td class="col-sm-2">转班后的班级:</td>
									<td class="col-sm-8"  id="sel_class">
										

									</td>
								</tr>
								<tr>
									<td class="col-sm-2">事由:</td>
									<td class="col-sm-8">
										<textarea style="height:100px;"  class="form-control" name="change_reason" required placeholder="请输入转班原因" ></textarea>
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

		<!--模态框（弹出批量班级安排信息）-->
		<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="videoInfo" style="display: none;">
		  	<div class="modal-dialog" style="width:586px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
			     		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
			        	<h4 class="modal-title">视频录制</h4>
			      	</div>	
					<div class="modal-body">
						
					</div>
		          	<div class="modal-footer">
			            <button data-dismiss="modal" class="btn btn-info" type="button">确定</button>
			        </div>
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
	            //选项卡
	            $('.menu').find('li').click(function(){
	                $('.menu').find('li').removeClass('current');		
	                $(this).addClass('current');			
	                $('.layout').hide();			
	                $(".layout:eq("+$(this).index()+")").show();
	            });	
	       	});


			jQuery(function($){
				//全选
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});

				//时间控件
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){		
					$(this).prev().focus();
				});

				//多条删除功能
				$(".all_del").on(ace.click_event, function() {
				
					//检测有多少个被选中了，0个删除不弹出确定框。
					var length= $('input[name="id[]"]:checked').length;
					if(length>0){
						bootbox.confirm("你确定删除吗?", function(result) {
							if(result) {
								document.forms['delete'].submit();
							}
						});
					}
				});
			
			});
			//ajax获取视频列表
			jQuery(function($) {
				$('.videoInfo').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(4).'/classroom/studentVideo');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==1){
				       			$("#videoInfo").find('.modal-body').html(res.data);
							}else if(res.status==0){
								$("#videoInfo").find('.modal-body').html(res.data); 
							}
				        }
			   		});
				});
			});	
			/*jQuery(function($) {	
				//页码输入跳转
				$('#tiaozhuan').click(function(){
					if($('#pagetiao').val()==""){
						alert("请输入要跳转的页码");
						return false;
					}
					var address="<?php echo $tiao;?>"+"&per_page="+parseInt($('#pagetiao').val());
					location.href=address;
				});
			});	*/
			jQuery(function($) {	
				$('a[data-target="#computer"]').on(ace.click_event, function() {
					var _this=this;
					var student_id=parseInt($(this).attr("data"));
					var computer_id=parseInt($(this).attr("computer"));
					if(computer_id==1){
						var computer="有电脑";
					}else if(computer_id==0){
						var computer="无电脑";
					}
					bootbox.confirm(computer, function(result) {
						if(result) {
							$.ajax({
						        type: "POST",
						        url: "<?php echo site_url(module_folder(4).'/classroom/isComputer');?>",
						        data: "id="+student_id+"&is_computer="+computer_id,
						        dataType:'json',
						        success: function(res){
						       		if (res.status==1) {
						       			if(computer_id==1){
											$(_this).removeClass("btn-purple");
											$(_this).addClass("btn-warning");
											$(_this).attr("computer","0");
											_this.innerHTML='有电脑';
										}else if(computer_id==0){
											$(_this).removeClass("btn-warning");
											$(_this).addClass("btn-purple");
											$(_this).attr("computer","1");
											_this.innerHTML='无电脑';
										}
						       		};
						        }
					   		});
						}
					});
					
				});
				// 转班操作: ajax获取学生所在班级	
				$('.change_class').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(4).'/classroom/studentClass');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				        	if(res.status==1){
				        		$("#sel_class").html(res.data);
				        	}
				       		
				        }
			   		});
				});

				/**
				 * 操作课程进度
				 */
				$('a[data-target="#course_schedule"]').on(ace.click_event, function() {
					var cls_konwid = $(this).attr('cls_konwid');
					var course_name = $(this).attr('course_name');
					var course_id = $(this).attr('course_id');
					var course_type = $(this).attr('course_type');
					var classroom_id = <?php echo $classroom_id;?>;

					if(course_type == 0){ //未读
						var msg = "您确定该知识点正在读";
					}else if(course_type == 1){ //正在读
						var msg = "您确定该知识点已读";
					}else if(course_type == 2){ //已读
						var msg = "您确定该知识点未读";
					}

					bootbox.confirm(msg+"<em style='color:red;'>"+course_name+"？</em>", function(result) {
						if(result) {
							$.ajax({
						        type: "POST",
						        url: "<?php echo site_url(module_folder(4).'/classroom/classCourseSchedule');?>",
						        data: "cls_konwid="+cls_konwid+"&course_id="+course_id+"&classroom_id="+classroom_id+"&type="+course_type,
						        dataType:'json',
						        success: function(res){

						        	if(res.status == 1){
						        		alert('操作成功！');
						        		window.location.reload();
						        	}
						       		
						        }
					   		});
						}
					});	
					
				});
			});	

			//操作考勤
			$(".attendance").click(function() {
				
					//检测有多少个被选中了，0个删除不弹出确定框。
					var length= $('input[name="check_id[]"]:checked').length;
					var day= $('input[name="checkday"]').val();
					var time = $("#time option:selected").get(0).value;
					if(day=='' || time==0){
						alert('请选择考勤时间');
						return false;
					}
					if(length<=0){
						alert('请选择要操作考勤的学生');
						return false;
					}
					if(length>0 && day!='' && time!=0){
						var arr_check = new Array(); 
						$('input[name="check_id[]"]:checked').each(function(i){
							if($(this).val!=''){
								arr_check[i] = $(this).val(); 
							}
			                 
			            });
						$('#check_student').val(arr_check);
						$('#check_day').val(day);
						$('#check_time').val(time);
					}
				});
		    //搜索知识点
			jQuery(function($){


				$('#select_knowledge').change(function(){

					var exam_id= this.value;
					
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
					delete arr.exam;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'exam='+exam_id;
					window.location.href=z;

				});

			}); 
			jQuery(function($) {
			    $(".price").click(function(){
			    	var k_score = $('select[name="score"]').val();
			    	if(k_score==''){
			    		alert('请选择知识点');
			    	}else{
			    		$(this).hide();
			        	$(this).next().fadeIn('slow');
			        	$(this).next().children('.score').focus();
			    	}	
			    })
			    $(".score").blur(function(){
			        var thisScore = $(this);
			        var student_score = thisScore.parent().find('input[name="student_score"]').val();
			        var student_id = thisScore.parent().find('input[name="student_id"]').val();
			        var classroom_id = thisScore.parent().find('input[name="classroom_id"]').val();
			        var exam_id = $("#select_knowledge option:selected").get(0).value;
			        if(student_score==''){
			        	//alert('请输入成绩');
			        	thisScore.parent().hide();
			        	thisScore.parent().prev().html('暂无成绩,点击输入').fadeIn();
			        }else{
				        $.ajax({
					        type: "POST",
					        url: "<?php echo site_url(module_folder(4).'/classroom/studentScore');?>",
					        data: "student_score="+student_score+"&student_id="+student_id+"&classroom_id="+classroom_id+"&exam_id="+exam_id,
					        dataType:'json',
					        success: function(res){
					        	if(res.status==1){
					        		thisScore.parent().hide();
				                	thisScore.parent().prev().html(student_score).fadeIn();
					        	}else{
					        		thisScore.parent().hide();
					        		thisScore.parent().prev().html(student_score).fadeIn();
					                //thisScore.parent().html('保存失败');
					            }
					       		
					        }
				   		});
				    }
			    })
			})
			//操作作业
			jQuery(function($) {
			    $(".record_hw").click(function(){
			    	var hw_day = $('input[name="hw_day"]').val();
			    	if(hw_day==''){
			    		alert('请选择日期');
			    	}else{
			    		$(this).hide();
			        	$(this).next().fadeIn('slow');
			        	//备注
			        	$(this).parent().prev().children('.show_hwremark').hide();
			        	$(this).parent().prev().children('.hwText').fadeIn('slow');
			        	//分数
			        	$(this).parent().prev().prev().children('.homework').hide();
			        	$(this).parent().prev().prev().children('.hwInput').fadeIn('slow');
			        	$(this).parent().prev().prev().children().children('.hw_score').focus();
			    	}	
			    })
			    $(".save_hw").click(function(){
			        var thisScore = $(this);
			        var homework_score = thisScore.parent().parent().prev().prev().children('.hwInput').find('input[name="hw_score"]').val();
			        var student_id = thisScore.parent().parent().prev().prev().children('.hwInput').find('input[name="student_hwid"]').val();
			        var classroom_id = thisScore.parent().parent().prev().prev().children('.hwInput').find('input[name="classroom_hwid"]').val();
			        var hw_remark = thisScore.parent().parent().prev().children('.hwText').children('textarea[name="hw_remark"]').val();
			        var hw_day = $('input[name="hw_day"]').val();

			        if(homework_score=='' && hw_remark==''){
			        	thisScore.parent().hide();
			        	thisScore.parent().prev('.record_hw').fadeIn();

			        	thisScore.parent().parent().prev().children('.hwText').hide();
			        	//thisScore.parent().parent().prev().children('.show_hwremark').html('').fadeIn();
			        	thisScore.parent().parent().prev().prev().children('.hwInput').hide();
			        	//thisScore.parent().parent().prev().prev().children('.homework').html('').fadeIn();
			        }else{
				        $.ajax({
					        type: "POST",
					        url: "<?php echo site_url(module_folder(4).'/classroom/studentHomeworkScore');?>",
					        data: "homework_score="+homework_score+"&student_id="+student_id+"&classroom_id="+classroom_id+"&hw_remark="+hw_remark+"&hw_day="+hw_day,
					        dataType:'json',
					        success: function(res){
					        	if(res.status==1){
					        		thisScore.parent().hide();
			        				thisScore.parent().prev('.record_hw').fadeIn();
					        		thisScore.parent().parent().prev().prev().children('.hwInput').hide();
				                	thisScore.parent().parent().prev().prev().children('.homework').html(homework_score).fadeIn();
				                	thisScore.parent().parent().prev().children('.hwText').hide();
				                	thisScore.parent().parent().prev().children('.show_hwremark').html(hw_remark).fadeIn();
					        	}else{
					        		thisScore.parent().hide();
			        				thisScore.parent().prev('.record_hw').fadeIn();
					        		thisScore.parent().parent().prev().prev().children('.hwInput').hide();
				                	thisScore.parent().parent().prev().prev().children('.homework').html(homework_score).fadeIn();
				                	thisScore.parent().parent().prev().children('.hwText').hide();
				                	thisScore.parent().parent().prev().children('.show_hwremark').html(hw_remark).fadeIn();
					            }
					       		
					        }
				   		});
				    }
			    })
			})

			jQuery(function($){

				$('input[name="checkday"]').change(function(){

					var checkday= this.value;

					var checktime = $('select[name="checktime"]').val();
					if(checkday==''){
						alert('请选择查询日期');
						return false;
					}
					/*if(checktime==0){
						alert('请选择查询日期');
						return false;
					}*/
					
					var url = window.location.href;
				
					var search = '';
					
					var num = url.match(/\?/g);   // 尝试匹配搜索字符串。
					if(num.length>1){
						var tmp=url.lastIndexOf('?');
						 	search=url.substr(tmp,url.length);
					 		url=url.substr(0,tmp);
					}
				
					var param_str=search.substr(1,search.length);
					var arr={};
					wdcrm.parse_str(param_str,arr);

					delete arr.checkday;
					delete arr.checktime;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'checkday='+checkday+'&checktime='+checktime;
					window.location.href=z;

				});
				$('select[name="checktime"]').change(function(){

					var checkday= $('input[name="checkday"]').val();

					var checktime = this.value;
					if(checkday==''){
						alert('请选择查询日期');
						$("select[name='checktime'] option:first").attr("selected", true);
						return false;
					}
					
					var url = window.location.href;
				
					var search = '';
					
					var num = url.match(/\?/g);   // 尝试匹配搜索字符串。
					if(num.length>1){
						var tmp=url.lastIndexOf('?');
						 	search=url.substr(tmp,url.length);
					 		url=url.substr(0,tmp);
					}
				
					var param_str=search.substr(1,search.length);
					var arr={};
					wdcrm.parse_str(param_str,arr);

					delete arr.checkday;
					delete arr.checktime;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'checkday='+checkday+'&checktime='+checktime;
					window.location.href=z;

				});


			}); 

			jQuery(function($){

				$('input[name="hw_day"]').change(function(){

					var workday= $(this).val();

					if(workday==''){
						alert('请选择查询日期');
						return false;
					}
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
					delete arr.workday;
				
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					
					var z=res+'workday='+workday;
					window.location.href=z;

				});

			});

			jQuery(function($){	
		        $('input[name="check_status"]').change(function() {
		            if ($("#leave").attr("checked")) {
		                $("#record_video").css('display','block');
		            }else if(!$("#leave").attr("checked")){
		                $("#record_video").css('display','none');
		            }
		        });

				$(".video").attr("checked",false);
		        $(".video").change(function() {
		            if ($(".video").attr("checked")) {
		                $(".show_video").css('display','block');
		            }else if(!$(".video").attr("checked")){
		                $(".show_video").css('display','none');
		            }
		        });
			});
			//操作考勤成功后背景色
			jQuery(function($){	
				//把整行都变成同样的背景颜色
				$('input[name="check_id[]"]').each(function(){
					var bg = $(this).css('backgroundColor');
					$(this).parent().parent()
								   .css('backgroundColor',bg)
								   .siblings()
								   .css('backgroundColor',bg);
				})
			})	
			jQuery(function($){	
				//把整行都变成同样的背景颜色
				$('input[name="id[]"]').each(function(){
					var bg = $(this).css('backgroundColor');
					$(this).parent().parent()
								   .css('backgroundColor',bg)
								   .siblings()
								   .css('backgroundColor',bg);
				})
			})	
			
		</script>
		<script>
			//修改鼠标滑过文字显示信息的效果。
			jQuery(document).ready(function($){
				$('a[data-target="#course_schedule"]').each(function(){
					var z= $(this);			
					var options={placement:'bottom'};
					z.tooltip(options);

				});
			});
		</script>
</body>
</html>