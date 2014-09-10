<style type="text/css">
	.font_red{
		color:red;
	}
	.font_blue{
		color:blue;
	}
</style>
<div class="row layout">
	<div class="col-xs-12">
		<div class="table-responsive">	
			<div style="margin-bottom:15px">
				<table>
					<tr>
						<td><span>班级类型:</span></td>
						<td>
							<select class="form-control" id="classtype" name="classroom_type">
								<option value="">请选择</option>
								<?php foreach ($classroom_type as $key => $value) { ?>
									<option <?php if ($value['classroom_type_id']==$classroom_type_id) { echo 'selected'; }?> value="<?php echo $value['classroom_type_id']; ?>"><?php echo $value['classroom_type_name'];?></option>
								<?php } ?>
							</select>
						</td>
						<td>&nbsp;&nbsp;</td>
						<td><span>班级状态:</span></td>
						<td>
							<select class="form-control" id="stu_state" name="classroom_type">
								<option value="">请选择</option>
								<option <?php if ($state==1) { echo 'selected'; }?> value="1">进行中</option>
								<option <?php if ($state==2) { echo 'selected'; }?> value="2">已结课</option>
							</select>
						</td>
						<!-- <td>&nbsp;&nbsp;</td>
						<td>
							<a href="<?php echo site_url(module_folder(2).'/student_course/index/'.$student_id);?>" target="_blank" class="btn btn-xs btn-purple" role="button">已报课程</a>
						</td> -->
						
					</tr>
				</table>
			</div>

			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center">序号</th>
						<th class="center">就读班级</th>
						<th class="center">班级群号</th>
						<th class="center">讲师</th>
						<th class="center">开班时间</th>
						<th class="center">结课时间</th>
						<th class="center">课程类型</th>
						<th class="center">知识点<span style="color:red;">（黑色：已读；蓝色：正在读；红色：未读）</span></th>
						<th class="center">就读状态</th>
					</tr>
				</thead>
				<!--
				按照开班时间排序，
				如果是要复读的，显示浅蓝色背景
				-->
				<tbody>
					<?php foreach ($cls_stu_info as $key => $value) {?>
						<tr align="center">
							<td class="center"><?php echo $value['serial_number'];?></td>
							<td><?php echo $value['classroom_name'];?></td>
							<td><?php echo $value['classroom_group'];?></td>
							<td><?php echo $value['employee_info']['employee_name'];?></td>
							<td><?php echo $value['open_classtime'];?></td>
							<td><?php echo $value['close_classtime'];?></td>
							<td><?php echo $value['classroom_type_name'];?></td>
							<td width="350px">
								<?php
									if(!empty($value['cls_known'])){
										$str = '';
										foreach ($value['cls_known'] as $k => $v) {
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
							</td>
							<td>
								<?php
									if($value['class_status']==1){
										echo '正在上课';
									}else if($value['class_status']==2){
										echo '已结课';
									}
								?>
							</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</div><!-- /.table-responsive -->
	</div><!-- /span -->
	<div class="col-sm-12">
		<div class="dataTables_paginate paging_bootstrap">
			
		</div>
	</div>
</div><!-- /row -->
<script type="text/javascript">
	$('#classtype').change(function(){

		var classroom_type_id= this.value;
		
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
		//干掉知识点
		delete arr.classroom_type_id;
	
		var par='';
		for(var k in arr){
			par+=k+'='+arr[k]+'&';
		}
		
		var res= url+'?'+par;
		
		var z=res+'classroom_type_id='+classroom_type_id;
		
		window.location.href=z;


	});

	$('#stu_state').change(function(){

		var state= this.value;
		
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
		//干掉知识点
		delete arr.state;
	
		var par='';
		for(var k in arr){
			par+=k+'='+arr[k]+'&';
		}
		
		var res= url+'?'+par;
		
		var z=res+'state='+state;
		
		window.location.href=z;


	});
</script>