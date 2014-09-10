<div class="row layout">
	<div class="col-xs-12">
		<div class="table-responsive">
			<div style="margin-bottom:15px">
				<table>
					<tr>
						<td><span>选择班级:</span></td>
						<td>
							<select name="selectClass" id="" style="width:70px;">
								<option value="">请选择</option>
								<?php foreach ($class as $value) {?>
									<option <?php if($value['classroom_id']==$selectClass){echo 'selected';} ?> value="<?php echo $value['classroom_id']; ?>"><?php echo $value['classroom_name']; ?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
				</table>
			</div>
			<table id="sample-table-1" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center">知识点</th>
						<th class="center">分数</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($all_exam as $value) {?>
					<tr>
						<td class="center">
							<?php echo $value['exam_name'];?>
						</td>
						<td class="center">
							<?php 
								foreach($stu_exam as $val){
									if($value['exam_id']==$val['exam_id']){
										echo $val['student_score'].'分';
									}
								}
							?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div><!-- /.table-responsive -->
	</div><!-- /span -->
	<div class="col-sm-12">
		<div class="dataTables_paginate paging_bootstrap">
			
		</div>
	</div>
</div><!-- /row -->