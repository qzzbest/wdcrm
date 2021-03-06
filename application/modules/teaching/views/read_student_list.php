<div class="page-content">
	<div class="page-header">
		<span>学员人数:<em style="color:red"><?php echo $student_info['count'];?></em>人</span>

		<div style="float:right;margin-right:30px;">	
			<span>知识点:</span>
			<select name="teach" id="changeKnowledge" style="width:102px;">
				<option value=" ">全部</option>
                <?php foreach ($knowledge_info as $key => $value) { ?>
				<option <?php 
						if ($value['knowledge_id']==$selected_knownledge) {
							echo 'selected';
						}

					?> value="<?php echo $value['knowledge_id'];?>"><?php echo $value['knowledge_name'];?></option>
				<?php }?>
			</select>

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
									<th class="center">姓名</th>
									<th class="center">目前就读班级</th>
									<th class="center">咨询师</th>
									<th class="center">就读状态</th>
									<th class="center">复读知识点</th>
									<th>操作</th>
									
								</tr>
							</thead>

							<tbody>
								<?php foreach ($student_info['list'] as $key => $value) {?>
								<tr>
									<td class="center">
										<label>
											<input type="checkbox" class="ace" name="id[]" value="" />
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
										<?php echo $value['student_name'];?>
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
									<td>
										<?php 
										if(!empty($value['read_knowledge'])){
											$read_knowledge = '';
											foreach ($value['read_knowledge'] as $key => $value) {
												$read_knowledge .= $value['knowledge_name'].'，';
											}
											echo rtrim($read_knowledge,'，');
										}
										?>
									</td>
									<td class="center">
										<a href="" class="btn btn-xs btn-warning student_info" role="button" data-toggle="modal" data-target="#student_info" data="<?php echo $value['student_id'];?>">详细信息</a>
										<a href="" class="btn btn-xs btn-success student_class" role="button" data-target="#classModal" data-toggle="modal" data="<?php echo $value['student_id'];?>" onclick="wdcrm.set_id('student_id',<?php echo $value['student_id']?>)">复读</a>
									</td>
								</tr>
								<?php }?>
							</tbody>
						</table>
						<!-- 批量复读 -->
						<?php if(!empty($student_info['list'])){?>
						<a href="javascript:void(0);" class="btn btn-xs btn-danger repeatRead" role="button" data-target="#classModal" data="<?php echo $value['student_id'];?>" onclick="wdcrm.set_id('student_id',<?php echo $value['student_id']?>)">复读</a>
						<?php }?>
						<!-- <a class="btn btn-xs btn-danger repeatRead" role="button">复读</a> -->
					</div><!-- /.table-responsive -->
				</div><!-- /span -->
				<div class="col-sm-12">
				<?php if(!empty($student_info['list'])){?>
					<div class="dataTables_paginate paging_bootstrap">
						<?php echo $student_info['page'];?>
						<div style="float:right;">
							<input type="text" name="pagetiao" id="pagetiao" style="width:30px;text-align:center;" value="<?php if(isset($cur_pag)){echo $cur_pag;}?>">
							<input type="button" class="btn btn-sm btn-info" id="tiaozhuan" value="跳转">
						</div>
					</div>
					<?php }?>
				</div>
			</div><!-- /row -->							
		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->