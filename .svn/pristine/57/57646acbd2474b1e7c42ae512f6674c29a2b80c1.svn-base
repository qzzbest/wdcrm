<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>学生就读情况</title>
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
							<h3 style="margin-top:0px;margin-bottom:0px;">
								学生姓名:<?php echo $student['student_name'].'&nbsp;&nbsp;&nbsp;';?>
								<small>
								<?php
								echo '手机号码：';
								if(isset($phone_infos) && !empty($phone_infos)){
									foreach ($phone_infos as $key => $value) {
										echo $value['phone_number'] .'&nbsp;';
									}
								}
								
								echo '&nbsp;&nbsp;&nbsp;QQ号码：';
								if(isset($qq_infos) && !empty($qq_infos)){
									foreach ($qq_infos as $key => $value) {
										echo $value['qq_number'] .'&nbsp;';
									}
								}	
								?>
								<a data-target="#student_info" data-toggle="modal" class="btn btn-xs btn-info student_info" type="button" data="<?php echo $student_id;?>" data-toggle="modal">详细信息</a>
								
							</small>
							</h3>
						</div>

						<!-- <div class="page-header">
							<span>
								学生姓名:<?php echo $student['student_name'];?>
							</span>
						</div> -->
		
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="tagMenu">
									<ul class="menu">
										<li <?php echo $act=='index' ? 'class="current"': '' ?> ><a href="<?php echo site_url(module_folder(2).'/student_study/index/index/'.$student_id);?>">就读课程</a></li>
					                    <li <?php echo $act=='attendance' ? 'class="current"': '' ?> ><a href="<?php echo site_url(module_folder(2).'/student_study/index/attendance/'.$student_id);?>">考勤作业</a></li>
					                    <li <?php echo $act=='exam' ? 'class="current"': '' ?> ><a href="<?php echo site_url(module_folder(2).'/student_study/index/exam/'.$student_id);?>">考试成绩</a></li>
									</ul>
							    </div>
							     <?php switch ($act) {
					                case 'index':
					                    echo $this->load->view('course_snippet');
					                    break;
					                case 'attendance':
					                    echo $this->load->view('attendance_snippet');
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

		<!--模态框（弹出学员详细信息）-->
		<div aria-hidden="true" aria-labelledby="youModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="student_info" style="display: none;">
		  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
		        <div class="modal-content">
		         	<div class="modal-header">
		            	<h4 id="youModalLabel" class="modal-title">学生信息</h4>
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

		<!-- basic scripts -->
	
		<!--[if !IE]> -->
	
		<script src="<?php echo base_url('assets/js/jquery-2.0.3.min.js');?>"></script><!--针对课程全选反选功能-->

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

				//ajax获取用户信息	
				$('.student_info').click(function(){
					var student_id=parseInt($(this).attr("data"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(2).'/student/info');?>",
				        data: "id="+student_id,
				        dataType:'json',
				        success: function(res){
				       		$("#student_info").find('.modal-body').html(res.data); 
				       		$("#stu_info").html('<a href="'+res.info_url+'">修改学员信息 >></a>'); 
				        }
			   		});
				});
			
			});
			//考勤作业操作
			jQuery(function($){

				$('#selectYear').change(function(){

						var selectYear= this.value;
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
						
						delete arr.selectYear;
						if(arr.per_page){
							delete arr.per_page;
						}
						var par='';
						for(var k in arr){
							par+=k+'='+arr[k]+'&';
						}
						
						var res= url+'?'+par;
						var z=res+'selectYear='+selectYear;
						window.location.href=z;
						
				});

				$('#selectMonth').change(function(){


					var selectMonth= this.value;
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
					
					delete arr.selectMonth;
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					var z=res+'selectMonth='+selectMonth;
					window.location.href=z;
					
				});
				$('select[name="selectClass"]').change(function(){
				//$('#selectClass').change(function(){


					var selectClass= this.value;
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
					
					delete arr.selectClass;
					if(arr.per_page){
						delete arr.per_page;
					}
					var par='';
					for(var k in arr){
						par+=k+'='+arr[k]+'&';
					}
					
					var res= url+'?'+par;
					var z=res+'selectClass='+selectClass;
					window.location.href=z;
					
				});
			});
		</script>
</body>
</html>