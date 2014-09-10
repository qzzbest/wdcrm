<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>提示信息</title>
	<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
</head>
<script>
var type=parseInt(<?php echo $type;?>);
function jin(){
  if(type==1){
	 location.href = "<?php echo site_url(module_folder(2).'/student_record/add/'.$uid);?>";
  }else if(type==3){
    location.href = "<?php echo site_url(module_folder(2).'/consultant_record/add/'.$uid.'/client');?>";
  }else if(type==4){
    location.href = "<?php echo site_url(module_folder(6).'/market_record/add/'.$uid);?>";
  }else{
    location.href = "<?php echo site_url(module_folder(2).'/consultant_record/add/'.$uid);?>";
  }
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
            	<h4 id="myModalLabel" class="modal-title">温馨提示<span style="font-size:14px;float:right" id="redirectionMsg"></span></h4>
          	</div>
          	<div class="modal-body">
            	<p><?php echo $msg?></p>
          	</div>
          	<div class="modal-footer">
	            <button data-dismiss="modal" class="btn btn-info" type="button" onclick="jin()">添加咨询记录</button>
	        	  <button data-dismiss="modal" class="btn btn-info" type="button" onclick="tui()">确定</button>
	        </div>
        </div>
  	</div>
</div>
</body>
</html>
<script type="text/javascript">
var t = 20; 
var time = document.getElementById("redirectionMsg"); 
function tiao(){
  time.innerHTML="<span style='font-size:16px;color:red'>"+t+"</span>"+" 秒之后自动返回"; 
  t--; 
  time.value = t;
  if(t>0){
    setTimeout("tiao()",1000); 
  }else if(t<=0){ 
    history.go(-1);
    clearInterval(inter); 
  } 
} 
tiao(); 
</script>
<?php exit;?>