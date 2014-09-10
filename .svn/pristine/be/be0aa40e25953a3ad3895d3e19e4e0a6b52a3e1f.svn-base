<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>评分标准列表</title>
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

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="<?php echo base_url('assets/js/ace-extra.min.js');?>"></script>
		<style type="text/css">
			.blue{color:#438eb9;font-size:16px;}
		
		</style>

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
						<span style="font-size:16px;margin-left:70px;font-weight:bold;">|评分标准列表|</span>
					</div>
				

					<div class="page-content">
						<form name="f5" id="f5" method="post" action="<?php echo site_url(module_folder(5).'/marking/move_stan');?>">
							<table class="table table-striped table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
											
											<th colspan='2'>评分标准</th>
											<th style="width:300px;">备注</th>
											<th style="width:200px;">操作</th>
											
										</tr>
									</thead>
									<!-- data list -->
									<tr><td width="50px"><input type="checkbox" name='group0'/></td><th colspan='3' class="blue">评分总则</th></tr>
									<tbody>
										
										<?php 
										if(!empty($stand[0])){ ?>
										<?php foreach($stand[0] as $key=>$item){ ?>
										
										<tr>
											<td><input type="checkbox" name='son0[]' value="<?php echo $item['id'];?>"/></td>
											<td colspan='2'>
												<?php echo $item['content']; ?>
											</td>
										
											<td>
												<a href="<?php echo site_url(module_folder(5).'/marking/edit_stand/'.$item['id']);?>" >编辑</a>|
												<a href="<?php echo site_url(module_folder(5).'/marking/del_stand/'.$item['id']);?>" onClick="return cfm()" >删除</a>
												<?php } ?>
												
											</td>
										</tr>


										<?php } ?>

										<tr><td><input type="checkbox" name='group1' /></td><th colspan='3' class="blue">加分细则</th></tr>
										<?php 
										if(!empty($stand[1])){ ?>
										<?php foreach($stand[1] as $key=>$item){ ?>
										
										<tr>
											<td><input type="checkbox" name='son1[]' value="<?php echo $item['id'];?>" /></td>
											<td>
												<?php echo $item['content']; ?>
											</td>
											<td>
												<?php echo $item['remark']; ?>
											</td>
										
											<td>
												<a href="<?php echo site_url(module_folder(5).'/marking/edit_stand/'.$item['id']);?>" >编辑</a>|
												<a href="<?php echo site_url(module_folder(5).'/marking/del_stand/'.$item['id']);?>" onClick="return cfm()" >删除</a>
												<?php } ?>
												
											</td>
										</tr>

										<?php } ?>

										<tr><td><input type="checkbox" name='group2' /></td><th colspan='3' class="blue">减分细则</th></tr>
										<?php 
										if(!empty($stand[2])){ ?>
										<?php foreach($stand[2] as $key=>$item){ ?>
										
										<tr>
											<td><input type="checkbox" name='son2[]' value="<?php echo $item['id'];?>"/></td>
											<td>
												<?php echo $item['content']; ?>
											</td>
											<td>
												<?php echo $item['remark']; ?>
											</td>
										
											<td>
												<a href="<?php echo site_url(module_folder(5).'/marking/edit_stand/'.$item['id']);?>" >编辑</a>|
												<a href="<?php echo site_url(module_folder(5).'/marking/del_stand/'.$item['id']);?>" onClick="return cfm()" >删除</a>
												<?php } ?>
												
											</td>
										</tr>


										<?php } ?>

									</tbody>
									<!-- data list -->

								</table>
								<script type="text/javascript">
									for(i=0;i<3;i++){
										var group=document.getElementsByName("group"+i)[0];
										group.index=i;
										group.onclick=function(){
											var num=this.index;
											var son=document.getElementsByName("son"+num+"[]");
											console.log(son);
											if(this.checked==true){
												for(j=0;j<son.length;j++){
												son[j].checked=true;
												}
											}else{
												for(j=0;j<son.length;j++){
												son[j].checked=false;
												}											
											}
										}									
									}
								
								</script>
								<input type="hidden" id="sheet" name="sheet" />
								<span style="font-size:15px;padding:3px">移动到:</span><select name="type" id='type'>
												<option value='-1'>请选择</option>
												<option value='0'>评分总则</option>
												<option value='1'>加分细则</option>
												<option value='2'>减分细则</option>
											</select>
								</form>
								<script type="text/javascript">
									$("#type").change(function(){
										var sheet=$("input:checked");
										var nums="";
										for(i=0;i<sheet.length;i++){
											if(sheet[i].value!="on"){
												var nums=nums+sheet[i].value+",";
											}
										}
										$("#sheet").val(nums);
										if(nums!=""){
										$("#f5").submit();
										}
									});
								</script>
								<button class="btn btn-info" style="float:right;margin-right:30px;" onclick="fanhui()">
									<i class="icon-ok bigger-110"></i>
												返回
								</button>

								<button class="btn btn-info" style="float:right;margin-right:30px;" onclick="addone()">
									<i class="icon-ok bigger-110"></i>
												添加一条
								</button>
						
						
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

		<!-- inline scripts related to this page -->
		<?php 
			$url = unserialize(getcookie_crm('url'));
			$fanhui_url = $url[1];
		?>
		<script>
 			
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

		function addone(){
			window.location.href="<?php echo site_url(module_folder(5).'/marking/add_stand'); ?>";
		}

		</script>
</body>
</html>
