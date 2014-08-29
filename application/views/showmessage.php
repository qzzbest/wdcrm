<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>提示信息</title>
	<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
</head>
<script>
var ms=<?php echo $ms;?>;
function jin(){
	location.href = "<?php echo $url_forward;?>";
}
function tui(){
	history.go(-1);
}
</script>
<body>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="myModal" style="display: block;">
  	<div class="modal-dialog" style="width:500px;padding-top:100px;">
        <div class="modal-content">
         	<div class="modal-header">
            	<h4 id="myModalLabel" class="modal-title">提示信息</h4>
          	</div>
          	<div class="modal-body">
            	<p><?php echo $msg?></p>
          	</div>
          	<div class="modal-footer">
          	<?php if(!empty($url_forward)){?>
	            <button data-dismiss="modal" class="btn btn-default" type="button" onclick="jin()">确定</button>
              <script>setTimeout(jin,ms);</script>
            <?php }else{?>
	        	  <button data-dismiss="modal" class="btn btn-default" type="button" onclick="tui()">返回</button>
              <script>setTimeout(tui,ms);</script>
	        <?php }?>    
	        </div>
        </div>
  	</div>
</div>
</body>
</html>
<?php exit;?>