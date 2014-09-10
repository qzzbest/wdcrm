<div class="row layout">
	<div class="col-xs-12">
		<div class="table-responsive">
			<?php
			$login_job = getcookie_crm('employee_job_id'); 
			if(!in_array($login_job, array(2))){?>
			<div style="margin-bottom:15px">
				<table>
					<tr>
						<td><span>查询日期:</span></td>
						<td>
							<div class="input-form">
								<input class="form-control date-picker" style="width:100px" type="text" name="hw_day" value="<?php if($workday){echo $workday;}else{echo date('Y-m-d');} ?>" data-date-format="yyyy-mm-dd" />
							</div>
						</td>
						<!-- <td>
							<button type="button" id="searchHome" class="btn btn-xs btn-primary">搜索</button>
						</td> -->
					</tr>
				</table>
			</div>
			<?php }?>
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center">序号</th>
						<th class="center">学号</th>
						<th class="center">姓名</th>
						<th class="center">性别</th>
						<th class="center">作业评分</th>
						<th class="center">备注</th>
						<th>操作</th>
						
					</tr>
				</thead>

				<tbody>
				<?php foreach ($class_student_info['list'] as $key => $value) { ?>
					<tr>
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
							<span class="homework" style="display: inline;">
								<?php
									if(!empty($value['homework']['student_score'])){
										echo $value['homework']['student_score'];
									}
								 ?>
							</span>
						    <span class="hwInput" style="display: none;">
						        <input type="hidden" name="student_hwid" value="<?php echo $value['student_id']?>">
						        <input type="hidden" name="classroom_hwid" value="<?php echo $classroom_info['classroom_id'];?>">
						        <input name="hw_score" type="text" value="" class="hw_score">
						    </span>
						</td>
						<td class="center">
							<span class="show_hwremark" style="display: inline;">
								<?php
									if(!empty($value['homework']['student_score_desc'])){
										echo $value['homework']['student_score_desc'];
									}
								 ?>
							 </span>
							<span class="hwText" style="display: none;">
								<textarea class="hwr" name="hw_remark"></textarea>
							</span>
						</td>
						<td class="center">
							<?php if(!in_array($login_job, array(2))){?>
							<a class="btn btn-xs btn-success record_hw" role="button">记录作业</a>
							<span style="display: none;">
								<a class="btn btn-xs btn-warning save_hw" role="button">保存</a>
							</span>
							<?php }?>
							<a href="<?php echo site_url(module_folder(4).'/student_attendance/index/'.$value['student_id'].'?selectClass='.$classroom_id);?>" class="btn btn-xs btn-purple" role="button">作业详情</a>
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