<div class="row layout">
	<div class="col-xs-12">
		<div class="table-responsive">
			<form  name="delete" action="<?php echo site_url(module_folder(4).'/classroom/deleteClassroomStudent');?>" method="post">
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<?php 
						$login_job = getcookie_crm('employee_job_id');
						if(!in_array($login_job, array(2))){?>
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
						<th>操作</th>
					</tr>
				</thead>

				<tbody>
				<?php foreach ($class_student_info['list'] as $key => $value) { ?>
					<tr <?php if($value['is_first']==2){echo 'style="background-color:#d6487e"';}?>>
						<?php if(!in_array($login_job, array(2))){?>
						<td class="center">
							<label>
								<input type="checkbox" class="ace" name="id[]" value="<?php echo $value['student_id'];?>"/>
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
							<a href="" class="btn btn-xs btn-primary videoInfo" data-target="#videoInfo" data-toggle="modal" role="button" data="<?php echo $value['student_id'];?>">视频录制详情</a>
							<?php 
							if(!in_array($login_job, array(2))){?>
							<?php if($value['is_computer']==1){?>
								<a href="" class="btn btn-xs btn-warning" role="button" data-toggle="modal" data-target="#computer" data="<?php echo $value['student_id'];?>" computer="0">有电脑</a>
							<?php }elseif($value['is_computer']==0){?>
								<a href="" class="btn btn-xs btn-purple" role="button" data-toggle="modal" data-target="#computer" data="<?php echo $value['student_id'];?>"  computer="1">无电脑</a>
							<?php }?>
							<a href="" class="btn btn-xs btn-success change_class" role="button"  data-toggle="modal" data-target="#change_class" data="<?php echo $value['student_id'];?>"  onclick="wdcrm.set_id('student_id',<?php echo $value['student_id']?>)">转班</a>
							<?php }?>
						</td>
					</tr>
				<?php } ?>	
				</tbody>
			</table>
			<?php if(!in_array($login_job, array(2))){?>
			<input type="hidden" name="class_id" value="<?php echo $classroom_id; ?>">
			<a class="btn btn-xs btn-danger all_del" role="button">删除</a>
			<?php }?>
			</form>
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