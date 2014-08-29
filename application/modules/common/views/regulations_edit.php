<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>修改<?php echo $regulation_type_name;?></title>
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

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<style type="text/css">
		
   		.question_file,.answer_file{
   			border: 1px solid #ccc;
		    width: 280px;
		    height: 30px;
   		}
   		.add_file{
   			width:750px;
   		}
		.add_file img{
			margin-bottom: 10px;
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
					<div class="breadcrumbs">
						<a type="button" href="<?php echo site_url(module_folder(5).'/regulations/index/'.$regulation_type);?>" class="btn btn-xs btn-primary" style="margin:0px 50px;"><?php echo $regulation_type_name;?>列表</a>
						<span style="font-size:16px;margin-left:70px;font-weight:bold;">|修改<?php echo $regulation_type_name;?>|</span>
					</div>

					<div class="page-content">
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" role="form" method="post">
									<input type="hidden" name="regulation_type" value="<?php echo $regulation_type;?>" />
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 标题： </label>

										<div class="col-sm-9">
											<input type="text" value="<?php echo $regulation_info['regulation_title'];?>" name="regulation_title" id="form-input-readonly" class="col-xs-10 col-sm-4">
											<!-- &nbsp;&nbsp;
											<button id="question_file_add" type="button" class="btn spinner-up btn-xs btn-success">
												<i class="icon-plus smaller-75">修改图片</i>
											</button> -->
											
											<!-- <br /><br />
											<div class="add_file">
												<img src="<?php //echo base_url('assets/images/gallery/image-1.jpg');?>" width="200px" height="100px"  />
												<img src="<?php //echo base_url('assets/images/gallery/image-1.jpg');?>" width="200px" height="100px"  />
											</div> -->
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1" > 内容： </label>

										<div class="col-sm-9">
											<textarea cols="50" rows="10" id="regulation_content" name="regulation_content" style="float:left;"><?php echo $regulation_info['regulation_content'];?></textarea>
											<!-- &nbsp;&nbsp;
											<button id="answer_file_add" type="button" class="btn spinner-up btn-xs btn-success">
												<i class="icon-plus smaller-75">修改图片</i>
											</button> -->

											<!-- <br /><br />
											<div class="add_file">
												<img src="<?php //echo base_url('assets/images/gallery/image-1.jpg');?>" width="200px" height="100px"  />
											</div> -->
										</div>
									</div>
									
									<div style="clear:both;"></div>
									
									<div class="clearfix">
										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" name="dosubmit">
												<i class="icon-ok bigger-110"></i>
												提交
											</button>
											<button class="btn btn-info" style="margin-left:30px">
												<i class="icon-remove bigger-110"></i>
												取消
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
		
		<!-- <textarea name="question_file" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-4">
					<input type="file" name="question_file_add[]" class="question_file col-xs-10 col-sm-10" type-data="true" />
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-5"></div>
			</div>
	 	</textarea>
	 	<textarea name="answer_file" style="display:none;">
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-4">
					<input type="file" name="answer_file_add[]" class="answer_file col-xs-10 col-sm-10" type-data="true" />
					<div class="spinner-buttons input-group-btn" style="text-align:center;">
						<button type="button" onclick="wdcrm.removeInput(this,3);" class="btn spinner-down btn-xs btn-danger">
							<i class="icon-minus smaller-75"></i>
						</button>
					</div>
				</div>
				<div class="col-sm-5"></div>
			</div>
	 	</textarea> -->
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
		<script type="text/javascript" src="<?php echo base_url('assets/editor/kindeditor.js'); ?>"></script>
		<script type="text/javascript">
			 // KindEditor.ready(function(K) {
			 //         window.editor = K.create('#answer');
			 // });

			 var editor;
				KindEditor.ready(function(K) {
					editor = K.create('textarea[name="regulation_content"]', {
						resizeType : 1,
						allowPreviewEmoticons : true,
						allowImageUpload : true,
						items : [
							'justifyleft', 'justifycenter', 'justifyright',
							'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
							'superscript', 'quickformat', 'selectall', '|', 'fullscreen', '|',
							'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
							'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|',
							'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
							'link', 'unlink', '|', 'about','image']
					});
				});
		</script>


		<script>
 			jQuery(function($) {
 				/*
	 			 * 添加问题和答案的输入框
	 			 * @param string 选中的元素 一个id值
	 			 * @param string 需要追加的内容，放置到了textarea里面
	 			 *
	 			 */
		 	// 	function AddInput(id,name){
		 	// 		var _this=this;
				// 	//给按钮绑定事件，实现追加
				// 	this.id=$(id);
				// 	//追加的内容
				// 	this.content=$('textarea[name="'+name+'"]').text();
				// 	//初始绑定,鼠标移开，校验数据
				// 	this.name=name;
				// 	$('input[name="consultant_'+name+'_number[]"]').bind('blur',function(){_this.blur_ajax(this);});
				// }

				// AddInput.prototype={

				// 	add:function(){
				// 		var _this=this;

				// 		_this.id.click(function(){ //绑定点击事件
				// 			var z=$(this).parent().parent();
				// 			z.after(_this.content);

				// 			//动态添加绑定
				// 			_this.add_blur();

				// 		});

				// 	},
				// }

	 		// 	new AddInput('#question_file_add','question_file').add();
	 		// 	new AddInput('#answer_file_add','answer_file').add();
		    });
		</script>
</body>
</html>
