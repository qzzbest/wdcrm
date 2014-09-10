<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>评分详情</title>
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
		<style type="text/css">
		#biaozhun{
		width:1000px;
		height:auto;
		background-color:#f2f2f2;
		position:absolute;
		top:50px;left:200px;
		border:2px solid #6fb3e0; 
		display:none;
		margin-bottom:100px;
		}	
		</style>
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
					<div class="breadcrumbs">
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
						</ul>
						<button type="button" onclick="change()" class="btn btn-xs btn-primary" style="margin:0px 50px;">评分标准</button>
						<span style="font-size:16px;margin-left:70px;font-weight:bold;">| <span style="color:blue; font-size:20px;"><?php echo $info['employee_name'];?> </span>评分详情|</span>
					</div>
	
					<h3 class="main-content"></h3>

					<div id="biaozhun">
					<h3 style="text-align:center;">员工评分标准</h3>
					<!-- table开始 -->
					<table class="table table-striped table-bordered ">
					<tr>
					<th colspan='2'>
					评分总则
					</th>
					</tr>
					<?php if(isset($stand_list[0])){
							foreach($stand_list[0] as $item){	?>
					<tr>
					<td colspan='2' height="30px"><?php	echo $item['content']; ?></td>
					</tr>
					<?php } }  ?>

					<tr>
					<th colspan='2'>
					加分细则
					</th>
					</tr>
					<tr>
					<td>项目</td><td>备注</td>			
					</tr>
					<?php if(isset($stand_list[1])){
							foreach($stand_list[1] as $item){	?>
					<tr>
					<td><?php echo $item['content']; ?></td><td><?php echo $item['remark']; ?></td>		
					</tr>
					<?php } }  ?>

					<tr>
					<th colspan='2'>
					减分细则
					</th>
					</tr>
					<tr>
					<td width="60%">项目</td><td>备注</td>			
					</tr>

					<?php if(isset($stand_list[2])){
							foreach($stand_list[2] as $item){	?>
					<tr>
					<td><?php echo $item['content']; ?></td><td><?php echo $item['remark']; ?></td>		
					</tr>
					<?php } }  ?>
					</table>
					<!-- table结束 -->
					<?php $power=getcookie_crm('mark_power');
						if($power==2){
					?>
					<button type="button" class="btn btn-xs btn-primary" onclick="edit()">编辑评分标准</button>
					<?php } ?>
					<button type="button" class="btn btn-xs btn-primary" style="float:right;" onclick="closen()">关闭</button>
					</div>

					<div class="page-content">
						<form class="form-horizontal" role="form" method="post" action="<?php echo site_url(module_folder(5).'/marking/actionPassAll');?>" name="actionPass">
						<input type="hidden" name="action_type" value="" />
						<?php  $power=getcookie_crm('mark_power');?>
						<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											<?php if($power==2){?>
											<th class="center">
												<label>
													<input type="checkbox" class="ace" />
													<span class="lbl"></span>
												</label>
											</th>
											<?php }?>
											<th>评分时间</th>
											<th>获得积分</th>
											<th>评分人</th>
											<th width="50%">评分理由</th>
											<th>积分状态</th>
											
											<th style="width:200px;">操作</th>
											
										</tr>
									</thead>
									<!-- data list -->
										
									<tbody>
										
										<?php 
										//判断有无积分列表
										if(!empty($integral)){ ?>
										<?php foreach($integral as $key=>$item){ ?>
										
										<tr>	
											<?php if($power==2){?>
											<td class="center">
												<?php if($item['state'] == 0){?>
												<label>
													<input type="checkbox" class="ace" name="ids[]" value="<?php echo $item['id'];?>" />
													<span class="lbl"></span>
												</label>
												<?php }else{?>
												&nbsp;
												<?php }?>
											</td>
											<?php }?>
											<td>
												<?php echo date('Y-m-d H:i',$item['date']);
												?>
											</td>

											<td>
												<?php echo $item['integral']; ?>
												
											</td>

											<td>
												<?php echo $item['employee_name']; ?>
												
											</td>

											<td>
												<?php echo $item['message']; ?>
											</td>
											
											<td>
												 
												<?php 
												if($item['state']=='0'){
													echo "未审核";
												}else if($item['state']=='1'){
													echo "审核通过";
												}else{
													echo "审核不通过";
												} ?>
											</td>
										
											<td>
												<?php
													if($power==2){
														if($item['state']=='0'){
												?>
												<a href="#" onclick="pass(<?php echo $item['id']; ?>)">通过审核</a>|<a href="#" onclick="no_pass(<?php echo $item['id']; ?>)">不通过审核</a>|
												<a href="<?php echo site_url(module_folder(5).'/marking/del_onemark/'.$item['id']);?>" onClick="return cfm()" >删除</a> 

												<?php } 
													}else if($item['employee_id']==getcookie_crm('employee_id')&&$item['state']!='1'){ ?>
												<a href="<?php echo site_url(module_folder(5).'/marking/del_onemark/'.$item['id']);?>" onClick="return cfm()" >删除</a> 	
										
												<?php }else{echo "无操作"; }?>
												
											</td>
										</tr>


										<?php } ?>

										<?php } ?>
										
										
									</tbody>
									<!-- data list -->

								</table>
								<?php
								//审核权
								if($power==2){?>
								<a class="btn btn-xs btn-danger actionAll" role="button" action-type="1">通过审核</a>
								<a class="btn btn-xs btn-danger actionAll" role="button" action-type="2">不通过审核</a>
								<a class="btn btn-xs btn-danger actionAll" role="button" action-type="3">删除</a>
								<?php }?>
								<a class="btn btn-info" style="float:right;margin-right:30px;" onclick="fanhui()">
									<i class="icon-ok bigger-110"></i>
												返回
								</a>
						
						
						</ul>

						
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

		<!-- ace scripts -->

		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>

		<!--弹出确定框需要的js-->
		<script src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>

		<!-- inline scripts related to this page -->
		<?php 
			$url = unserialize(getcookie_crm('url'));
			$fanhui_url = $url[1];
		?>
		<script>
 		//列表全选，批量删除
		$('table th input:checkbox').on('click' , function(){
			var that = this;
			$(this).closest('table').find('tr > td:first-child input:checkbox')
			.each(function(){
				this.checked = that.checked;
				$(this).closest('tr').toggleClass('selected');
			});
				
		});

		//点击删除弹出确认框
		function cfm()
		{
			return window.confirm('您确定要删除吗');
		}

		function fanhui(){
			var url = "<?php echo $fanhui_url[1];?>";
			window.location.href=url;
		}

		function change(){
			$("#biaozhun").show();
		}

		function closen(){
			$("#biaozhun").hide();
		}

		function edit(){
			window.location.href="<?php echo site_url(module_folder(5).'/marking/standard'); ?>";
		}

		//点击弹出确定框，确定就批量删除咨询者
		$(".actionAll").click(function() {
			//检测有多少个被选中了，0个删除不弹出确定框。
			var length= $('input[name="ids[]"]:checked').length;
			var type = $(this).attr('action-type');
			if(length>0){
				bootbox.confirm("你确定通过审核吗?", function(result) {
					if(result) {
						$('input[name="action_type"]').val(type);
						document.forms['actionPass'].submit();
					}
				});
			}
		});

		function pass(id){
			 if (confirm("是否确认通过")){
				$.post("<?php echo site_url(module_folder(5).'/marking/pass'); ?>"+"/"+id, { Action: "pass" },     
				   function (data){        
					if(data==1){
						location.reload();
					}else{
						alert("操作失败");
					}
					}, "json");
			 } 
		}

		function no_pass(id){
			 if (confirm("改评分不通过审核?")){
				$.post("<?php echo site_url(module_folder(5).'/marking/pass'); ?>"+"/"+id, { Action: "no_pass" },     
				   function (data){        
					if(data==1){
						location.reload();
					}else{
						alert("操作失败");
					}
					}, "json");
			 } 
		}
		</script>
</body>
</html>
