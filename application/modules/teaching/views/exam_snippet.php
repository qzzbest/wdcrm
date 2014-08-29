<div class="row layout">
	<div class="col-xs-12">
		<div class="table-responsive">
			<?php
			$login_job = getcookie_crm('employee_job_id'); 
			if(!in_array($login_job, array(2))){?>
			<div style="margin-bottom:10px">
				<span>知识点成绩</span>
				<select name="score" id="select_knowledge">
					<option value="">请选择知识点</option>
					<?php foreach ($all_exam as $value) {?>
						<option <?php if($value['exam_id']==$exam){echo 'selected';} ?> value="<?php echo $value['exam_id']; ?>"><?php echo $value['exam_name']; ?></option>
					<?php } ?>
				</select>&nbsp;&nbsp;
				<span style="font-size:16px;">平均分: <em style="color:red;"><?php echo isset($average)?$average:''; ?></em> 分 (注：不包括复读生)</span>
			</div>
			<?php }?>
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center">序号</th>
						<th class="center">姓名</th>
						<th class="center">性别</th>
						<th class="center">成绩(分数)</th>
					</tr>
				</thead>

				<tbody>
				<?php foreach ($class_student_info['list'] as $key => $value) { ?>
					<tr>
						<td class="center">
							<?php echo $value['serial_number']; ?>
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
								if(!in_array($login_job, array(2))){
									$str = '暂无成绩,点击输入';
								}else{
									$str = '暂无成绩';
								}
							?>
							<span class="price" style="display: inline;"><?php if( !empty($value['score']) ){echo $value['score']['student_score'];}else{echo $str;}?></span>
						    <span class="textInput" style="display: none;">
						        <input type="hidden" name="student_id" value="<?php echo $value['student_id']?>">
						        <input type="hidden" name="classroom_id" value="<?php echo $classroom_info['classroom_id'];?>">
						        <input type="hidden" name="exam_id" class="exam" value="">
						        <input name="student_score" type="text" value="<?php if( !empty($value['score']) ){echo $value['score']['student_score'];}?>" class="score">
						    </span>
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