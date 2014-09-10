<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>批量编辑咨询提醒</title>
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
								<a href="<?php echo site_url(module_folder(6).'/remind/index');?>">咨询提醒管理</a>
							</li>
							<li class="active">编辑咨询提醒</li> -->
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
						

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								

								<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(6).'/remind/allEdit');?>">
								<?php foreach ($list as $key => $value) {?>
								<div>
									<input type="hidden" name="id[]" value="<?php echo  $value['time_remind_id'];?>">
									<div class="form-group">

										<div style="padding: 10px 20px 15px 230px;font-size: 14px;">
											<?php echo $value['consultant_info'];?>
										</div>

										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 提醒内容 </label>

										<div class="col-sm-9">
											<textarea style="width:390px; height:150px;" id="form-field-1" name="remind_content[]" placeholder="请输入提醒内容"><?php echo $value['time_remind_content'];?></textarea>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	提醒备注 </label>

										<div class="col-sm-9">
											<textarea style="width:400px; height:50px;" id="form-field-1" name="remind_remark[]" placeholder="请输入提醒备注"><?php echo $value['remind_remark']?></textarea>
										</div>
									</div>

									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 提醒时间 </label>

										<div class="col-sm-4">
											<div class="input-group">
												<input class="form-control date-picker" id="id-date-picker-1" type="text" value="<?php echo date('Y-m-d',$value['time_remind_time']);?>" name="remind_date[]" data-date-format="yyyy-mm-dd" />
												<span class="input-group-addon">
													<i class="icon-calendar bigger-110"></i>
												</span>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="input-group bootstrap-timepicker">
												<input id="timepicker1" type="text" name="remind_time[]" class="form-control" value="<?php echo date('H:i:s',$value['time_remind_time']);?>" />
												<span class="input-group-addon">
													<i class="icon-time bigger-110"></i>
												</span>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="spinner-buttons input-group-btn" style="text-align:center;">
												<button type="button" onclick="wdcrm.removeInput(this,4);" class="del_remind btn spinner-down btn-sm btn-danger" rid="<?php echo $value['time_remind_id'];?>">
													删除
												</button>
											</div>									
										</div>
									</div>
									</div>
									<?php }?>
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
		<div name="remind" style="display:none;">
			<div>
			<input type="hidden" name="id[]" value="">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 	提醒内容 </label>

				<div class="col-sm-9">
					<textarea style="width:390px; height:150px;" id="form-field-1" name="remind_content[]" required oninvalid="setCustomValidity('请输入提醒内容');" oninput="setCustomValidity('');" placeholder="请输入提醒内容"></textarea>
				</div>
			</div>
			
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
						<input data-target="#timeShow" class="timepicker1 form-control" type="text" name="remind_time[]" class="form-control" />
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

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->

		<!-- ace scripts -->

		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>

		<!-- inline scripts related to this page -->

		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/moment.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/daterangepicker.min.js');?>"></script>

		<script type="text/javascript">
			jQuery(function($) {
				
				//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					
					$(this).prev().focus();
				
				});

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

			jQuery(function($){

				//ajax删除提醒
				$('.del_remind').click(function(){
					var id=parseInt($(this).attr("rid"));
					$.ajax({
				        type: "POST",
				        url: "<?php echo site_url(module_folder(6).'/remind/deleteRemind');?>",
				        data: "id="+id,
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
