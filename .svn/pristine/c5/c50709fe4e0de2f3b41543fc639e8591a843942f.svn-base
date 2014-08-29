<div class="row layout">
	<div class="col-xs-12">
		<div class="table-responsive">
			<?php
			$login_job = getcookie_crm('employee_job_id'); 
			if(!in_array($login_job, array(2))){?>
			<div style="margin-bottom:15px">
				<table>
					<tr>
						<td>
							<a class="btn btn-xs btn-danger attendance" role="button"  data-toggle="modal" data-target="#attendance">批量操作考勤</a>
						</td>
						<td><span>查询日期:</span></td>
						<td>
							<div class="input-form">
								<input class="form-control date-picker" style="width:100px" type="text" name="checkday"  value="<?php if($checkday){echo $checkday;}else{echo date('Y-m-d');} ?>" data-date-format="yyyy-mm-dd" />
							</div>
						</td>
						<td>
							<select id="time" name="checktime">
								<option value="0">请选择</option>
								<option <?php if($checktime == 1){ echo 'selected=selected';}?> value="1">上午</option>
								<option <?php if($checktime == 2){ echo 'selected=selected';}?> value="2">下午</option>
								<option <?php if($checktime == 3){ echo 'selected=selected';}?> value="3">晚上</option>
							</select>
						</td>
					</tr>
				</table>
			</div>
			<?php }?>
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<?php if(!in_array($login_job, array(2))){?>
						<th class="center">
							<label>
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</th>
						<?php }?>
						<th class="center">序号</th>
						<th class="center">学号</th>
						<th class="center">姓名</th>
						<th class="center">性别</th>
						<th class="center">电话</th>
						<th class="center">QQ</th>
						<th class="center">考勤情况</th>
						<th class="center">备注</th>
						<th>操作</th>
						
					</tr>
				</thead>

				<tbody>
				<?php $attendance=array(1=>'出勤',2=>'请假',3=>'迟到',4=>'旷课',5=>'远程'); ?>
				<?php foreach ($class_student_info['list'] as $key => $value) { ?>
					<tr <?php if(!empty($value['attendance']['student_attendance_status'])){echo 'style="background-color:#7EC6F7"';}?>>
						<?php if(!in_array($login_job, array(2))){?>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" name="check_id[]" value="<?php echo $value['student_id'];?>"/>
								<span class="lbl"></span>
							</label>
						</td>
						<?php }?>
						<td class="center">
							<?php echo $value['serial_number']; ?>
						</td>
						<td class="center">
							<?php echo $value['student_number']; ?>
						</td>
						<td class="center"> 
							<?php echo $value['student_name']; ?>
						</td>
						<td class="center">
							<?php if ($value['student_sex']==1) {
							 	echo '男';
							 }else if($value['student_sex']==2){
							 	echo '女';
							 }else{
							 	echo '';
							 }?>
						</td>
						<td class="center">
							<?php
								if( !empty($value['phone']) ){
									foreach ($value['phone'] as $item) {
										echo $item.'<br />';
									}
								}
							?>
						</td>
						<td class="center">
							<?php
								if( !empty($value['qq']) ){
									foreach ($value['qq'] as $item) {
										echo $item.'<br />';
									}
								}
							?>
						</td>
						<td class="center">
							<?php 
								if(!empty($value['attendance']['student_attendance_status'])){
									echo $attendance[$value['attendance']['student_attendance_status']];
								}else{
									echo '没记录考勤';
								} 
							?>
						</td>
						<td class="center">
							<?php
								if(!empty($value['attendance']['student_attendance_desc'])){
									echo $value['attendance']['student_attendance_desc'];
								}else{
									echo '暂无备注';
								} 
							 ?>
						</td>
						<td class="center">
							<a href="<?php echo site_url(module_folder(4).'/student_attendance/index/'.$value['student_id'].'?selectClass='.$classroom_id);?>" class="btn btn-xs btn-purple" role="button">考勤详情</a>
						</td>
					</tr>
				<?php } ?>	
				</tbody>
			</table>
		</div><!-- /.table-responsive -->
	</div><!-- /span -->
	<!-- <div class="col-sm-12">
		<div class="dataTables_paginate paging_bootstrap">
			<?php echo $class_student_info['page'];?>
			<div style="float:right;">
				<input type="text" name="pagetiao" id="pagetiao" style="width:30px;text-align:center;" value="<?php if(isset($cur_pag)){echo $cur_pag;}?>">
				<input type="button" class="btn btn-sm btn-info" id="tiaozhuan" value="跳转">
			</div>
		</div>
	</div> -->
</div>


<!--模态框（弹出批量考勤操作）-->
<div aria-hidden="true" aria-labelledby="inputModalLabel" role="dialog" tabindex="-1" class="modal fade in" id="attendance" style="display: none;">
  	<div class="modal-dialog">
        <div class="modal-content">
         	<div class="modal-header">
         		<button type="button" data-dismiss="modal" class="bootbox-close-button close">×</button>
            	<h4 id="inputModalLabel" class="modal-title">考勤操作</h4>
          	</div>
          	<form name="kaoqin" action="<?php echo site_url(module_folder(4).'/classroom/attendanceAdd')?>" method="post">
          		<input type="hidden" id="check_student" name="check_student" value="">
          		<input type="hidden" id="check_day" name="check_day" value="">
          		<input type="hidden" id="check_time" name="check_time" value="">
          		<input type="hidden" name="classroom_id" value="<?php echo $classroom_info['classroom_id'];?>" />
          		<input type="hidden" name="location" value="<?php echo $location;?>" />
				<div class="modal-body" style="padding: 20px 30px 0px;">
					<label style="margin-right:20px;">
						<input name="check_status" checked type="radio" value="1" class="ace" />
						<span class="lbl">出勤</span>
					</label>
					<label style="margin-right:10px;">	
						<input name="check_status" type="radio" id="leave" value="2" class="ace" />
						<span class="lbl">请假</span>
					</label>
					<label style="margin-right:10px;">	
						<input name="check_status" type="radio" value="3" class="ace" />
						<span class="lbl">迟到</span>
					</label>
					<label style="margin-right:10px;">	
						<input name="check_status" type="radio" value="4" class="ace" />
						<span class="lbl">旷课</span>
					</label>
					<label style="margin-right:10px;">	
						<input name="check_status" type="radio" value="5" class="ace" />
						<span class="lbl">远程</span>
					</label>
				</div>
				<div class="modal-body" style="padding: 20px 30px 0px;">
					<table>
						<tr>
							<td>备注</td>
						</tr>
						<tr>
							<td><textarea style="width:315px;height:100px;" class="form-control" name="remark" placeholder="备注"></textarea></td>
						</tr>
					</table>
					<table style="display:none;" id="record_video">
						<tr>
							<td><input type="checkbox" class="video" value="1" name="record_video" />录制视频</td>
						</tr>
						<tr>
							<td>
								<div style="display:none;" class="show_video">
									<span>知识点&nbsp;<input type="text" name="record_knowledge" /></span>
									<span id="showrecord" style="color:#ff0000;"></span>
								</div>
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
<script>
	jQuery(function($) {
		$('form[name="kaoqin"]').submit(function(){
			if($('#leave').prop('checked')==true && $('input[name="record_video"]').prop('checked')==true && $('input[name="record_knowledge"]').val()==''){
				$('#showrecord').html('请输入录制的知识点');
				return false;
			}
		})
	})
</script>