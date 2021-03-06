<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>上传简历</title>
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
		<!-- page specific plugin styles -->
		

		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace.min.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace-rtl.min.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/ace-skins.min.css');?>" />
		<!--时间选择（时-分-秒）-->
		<link rel="stylesheet" href="<?php echo base_url('assets/css/datepicker.css');?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-timepicker.css');?>" />
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
							<li class="active">上传简历</li>
						</ul><!-- .breadcrumb -->

					</div>

					<div class="page-content">
					

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<form class="form-horizontal" id="uploadForm" role="form" method="post" enctype="multipart/form-data">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 上传简历 </label>
										<div class="col-sm-3">
											<input name="fileToUpload" multiple="true" id="fileToUpload" required type="file">
										</div>
										<div class="col-sm-3">
											<button type="button" class="btn btn-xs btn-primary" id="subBtn">立即上传</button>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-2 control-label no-padding-right" for="form-field-2"></label>
										<div class="col-sm-6">
											<div class="file-list" id="fileList"></div>
										</div>
									</div>
									<div class="space-4"></div>
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
		<!-- ace scripts -->

		<script src="<?php echo base_url('assets/js/ace-elements.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/ace.min.js');?>"></script>

		<!-- 公共的wdcrm对象 -->
		<script src="<?php echo base_url('assets/js/common.js');?>"></script>
		<!--时间选择需要的插件-->
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url('assets/js/date-time/bootstrap-timepicker.min.js');?>"></script>
		<script type="text/javascript">
			jQuery(function($) {
	 			//时间选择控件
	 			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					
					$(this).prev().focus();
				
				});
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false,
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			});	
			//简历上传
			jQuery(function($) {
				$('#fileToUpload').ace_file_input({
					no_file:'请选择要上传的简历',
					btn_choose:'选择简历',
					btn_change:'添加简历',
					droppable:false,
					onchange:null,
					thumbnail:false,
					icon_remove:"",
				});
			});

			//多简历上传
			jQuery(function($) {
				var files = [];
			    var $uploadForm = $('#uploadForm');
			    var $fileToUpload = $('#fileToUpload');
			    var $fileList = $('#fileList');
			    var $barList = null;
			    var index = 0;
			    function fileSelected() {
			        var fs = $fileToUpload.get(0).files;
			        var html = '';
			        for(var i = 0; i < fs.length; i++) {
			            var file = fs[i];
			            files.push(file);
			            var fileSize = 0;
			            if (file.size > 1024 * 1024) {
			                fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
			            } else {
			                fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
			            }
			            html += '<div class="file-item well"><div class="progress"><div class="bar" style="text-align: left;">0%</div></div>' +
			                    '<div><div class="span2">'+ file.name +'</div>' +
			                    '<div class="span2">'+ fileSize +'</div>' +
			                    '<div class="span2">'+ file.type +'</div></div></div>';
			        }
			        $fileList.append(html);
			        $barList = $('.bar');
			    }
			    function uploadFile() {
			        var xhr = new XMLHttpRequest();
			        xhr.upload.addEventListener("progress", uploadProgress, false);
			        xhr.addEventListener("load", uploadComplete, false);
			        xhr.addEventListener("error", uploadFailed, false);
			        xhr.addEventListener("abort", uploadCanceled, false);
			        xhr.open("POST", "<?php echo site_url(module_folder(5).'/file/uploadFile');?>", true); 
			        var fd = new FormData();
			        fd.append("fileToUpload", files[index]);

			        xhr.send(fd);
			    }
			    function uploadProgress(evt) {
			        if (evt.lengthComputable) {
			            var percentComplete = Math.round(evt.loaded * 100 / evt.total) +'%';
			            $barList.get(index).innerHTML = percentComplete;
			            $barList.get(index).style.width = percentComplete;
			        }
			    }
			    function uploadComplete(evt) {
			        if(index === files.length - 1) {
			           	function jin(){
			           		alert('上传成功');
							location.href='<?php echo site_url(module_folder(5).'/file/index/1');?>';
						}
			            setTimeout(jin,1250);
			            //return;
			        }
			        index++;
			        uploadFile();
			    }

			    function uploadFailed(evt) {
			        //alert("上传失败.");
			    }
			    function uploadCanceled(evt) {
			        //alert("上传成功."); /*上载已取消由用户或浏览器丢弃的连接*/
			    }
			    $fileToUpload.change(function() {
			        fileSelected();
			    });
			    //点击触发
			    $('#subBtn').click(function() {
			        uploadFile();
			    });
			});	
		</script>
</body>
</html>
