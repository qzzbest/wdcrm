

<div class="page-content">
	<div class="page-header">
		<span>学员人数:<em style="color:red"><?php echo $student_info['count'];?></em>人</span>
		<div style="display: inline-block;margin-left:20px;">
		
			<!-- <span>班级:</span>
			<label><input type="radio" value="0" name="arrange" <?php if(isset($order) && $order == 0){echo 'checked=checked';}?> class="sel_order ace" /><span class="lbl">已安排</span></label>
			<label><input type="radio" value="1" name="arrange" <?php if(isset($order) && $order == 1){echo 'checked=checked';}?> class="sel_order ace" /><span class="lbl">未安排</span></label> -->

			<!-- <span>
				<a href="<?php echo site_url(module_folder(4).'/student/repeatReadStudent');?>" class="btn btn-xs btn-primary">要复读的学生</a>
			</span> -->
			<span>
				<a href="" data-toggle="modal" data-target="#pre_allot" class="btn btn-xs btn-primary">预分配学号</a>
			</span>
			<span>
				<a href="<?php echo site_url(module_folder(4).'/student/preNumberList');?>" class="btn btn-xs btn-primary">已分配学号列表</a>
			</span>
		</div>
		
			<div style="float:right;margin-right:30px;">	
			<table>
				<tr>
					<td>
						<span>查询条件:</span>
						<select name="select_type">
							<option <?php if(isset($select_type) && $select_type==1) { echo 'selected'; }?> value="1">未读知识点</option>
							<option <?php if(isset($select_type) && $select_type==2) { echo 'selected'; }?> value="2">要复读知识点</option>
						</select>&nbsp;
					</td>
					
					<td>
						<select name="teach" id="changeKnowledge" style="width:102px;">
							<option value="">全部</option>
			                <?php foreach ($knowledge_info as $key => $value) { ?>
							<option <?php 
									if ($value['knowledge_id']==$selected_knownledge) {
										echo 'selected';
									}

								?> value="<?php echo $value['knowledge_id'];?>"><?php echo $value['knowledge_name'];?></option>
							<?php }?>
						</select>
					</td>
					<td>
						<button type="button" data-event="searchKnownledge" class="btn btn-xs btn-primary">搜索</button>
					</td>
				</tr>
			</table>
		</div>

		<div style="float:right;margin-right:30px;">	
	
			<span>咨询师:</span>
			<select name="teach" id="changeTeach" style="width:91px;">
				<option value=" ">全部</option>
				<?php foreach($teach as $item){ ?>
				<option <?php 
					if ($item['employee_id']==$selected_teach) {
						echo 'selected';
					}

				?> value="<?php echo $item['employee_id'];?>"><?php echo $item['employee_name'];?></option>
				<?php } ?>
			</select>	
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->

			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
						<table id="sample-table-1" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th class="center">
										<label>
											<input type="checkbox" class="ace" />
											<span class="lbl"></span>
										</label>
									</th>
									<th class="center">序号</th>
									<th class="center">学号</th>
									<th class="center">报名日期</th>
									<th class="center">姓名</th>
									<th class="center">性别</th>
									<th class="center">手机</th>
									<th class="center">QQ</th>
									<th class="center">目前就读班级</th>
									<th class="center">咨询师</th>
									<th class="center">学员状态</th>
									<th>操作</th>
									
								</tr>
							</thead>

							<tbody>
								<?php foreach ($student_info['list'] as $key => $value) {?>
								<tr>
									<td class="center">
										<label>
											<input type="checkbox" class="ace" name="id[]" value="<?php echo $value['student_id'];?>" />
											<span class="lbl"></span>
										</label>
									</td>
									<td class="center">
										<?php echo $value['serial_number'];?>
									</td>
									<td class="center">
										<?php echo $value['student_number'];?>
									</td>
									<td class="center">
										<?php echo date('Y-m-d',$value['sign_up_date']);?>
									</td>
									<td class="center">
										<?php echo $value['student_name'];?>
									</td>
									<td class="center">
										<?php
										 if ($value['student_sex']==1) {
										 	echo '男';
										 }else if($value['student_sex']==2){
										 	echo '女';
										 }else{
										 	echo '';
										 }
										?>
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
											if( !empty($value['class']) ){
												foreach ($value['class'] as $item) {
													echo $item.'<br />';
												}
											}
										?>
									</td>
									<td class="center">
										<?php echo $value['employee']['employee_name'];?>
									</td>
									<td class="center">
										<?php
											if($value['student_status']==1){
												echo '就读';
											}else if ($value['student_status']==2) {
												echo '毕业';
											}else if ($value['student_status']==0) {
												echo '休学';
											}
										?>
									</td>
									<td class="center">
										<?php if($select_type==2){?>
										<a href="" class="btn btn-xs btn-purple repeatKnowledge" role="button" data-toggle="modal" data-target="#repeatKnowledge" data="<?php echo $value['student_id'];?>">要复读知识点</a>
										<?php }?>
										<a href="" class="btn btn-xs btn-warning student_info" role="button" data-toggle="modal" data-target="#student_info" data="<?php echo $value['student_id'];?>">基本信息</a>
										<a href="" class="btn btn-xs btn-purple course_info" role="button" data-toggle="modal" data-target="#course_info" data="<?php echo $value['student_id'];?>">已报课程</a>
										<a href="" class="btn btn-xs btn-success student_class" role="button" data-target="#classModal" data-toggle="modal" data="<?php echo $value['student_id'];?>" onclick="wdcrm.set_id('student_id',<?php echo $value['student_id']?>)">安排班级</a>
										<a href="" class="btn btn-xs btn-primary student_status" role="button" data-target="#statusModal" data-toggle="modal" data="<?php echo $value['student_id'];?>" onclick="wdcrm.set_id('student_statusid',<?php echo $value['student_id']?>)">修改学员状态</a>
										<!-- <a href="<?php echo site_url(module_folder(4).'/student/edit/'.$value['student_id'])?>" class="btn btn-xs btn-info" role="button">修改</a> -->
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<a href="" class="btn btn-xs btn-success all_arrange">安排班级</a>
					</div><!-- /.table-responsive -->
				</div><!-- /span -->
				<div class="col-sm-12">
					<div class="dataTables_paginate paging_bootstrap">
						<?php echo $student_info['page'];?>
						<div style="float:right;">
							<input type="text" name="pagetiao" id="pagetiao" style="width:30px;text-align:center;" value="<?php if(isset($cur_pag)){echo $cur_pag;}?>">
							<input type="button" class="btn btn-sm btn-info" id="tiaozhuan" value="跳转">
						</div>
					</div>
				</div>
			</div><!-- /row -->							
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->