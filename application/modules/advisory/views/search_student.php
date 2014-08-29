<div class="nav-search" id="nav-search">
	<form name="student_search" class="form-search" action="" method="get">
		<span class="input-icon">
			<select class="form-control" name="key">
					<option <?php if(isset($student_info['key']) && $student_info['key'] == 'student_name'){ echo 'selected=selected';}?> value="student_name">姓名</option>
					<option <?php if(isset($student_info['key']) && $student_info['key'] == 'qq'){ echo 'selected=selected';}?> value="qq">QQ</option>
					<option <?php if(isset($student_info['key']) && $student_info['key'] == 'phones'){ echo 'selected=selected';}?> value="phones">phone</option>
					<option <?php if(isset($student_info['key']) && $student_info['key'] == 'email'){ echo 'selected=selected';}?> value="email">email</option>
					<option <?php if(isset($student_info['key']) && $student_info['key'] == 'student_education'){echo 'selected=selected';}?> value="student_education">学历</option>
					<option <?php if(isset($student_info['key']) && $student_info['key'] == 'student_school'){echo 'selected=selected';}?> value="student_school">学校</option>
					<option <?php if(isset($student_info['key']) && $student_info['key'] == 'student_specialty'){echo 'selected=selected';}?> value="student_specialty">专业</option>	
			</select>
		</span>
		<span class="input-icon">
			<input type="text" name="search" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" value="<?php if(isset($student_info['search']))echo $student_info['search'];?>" />
			<i class="icon-search nav-search-icon"></i>
		</span>
		<span class="input-icon">
		<button class="btn btn-xs btn-primary">搜索</button>
		</span>
	</form>
</div><!-- #nav-search -->
<script>
	//搜索学生的相关信息
		jQuery(function($){

			var url='<?php echo site_url(module_folder(2).'/student/index/index/0');?>';

			$('form[name="student_search"]').submit(function(){
				var search=$.trim(this.elements['search'].value);

				if (search!='') {
					var key= $('select[name="key"] option:selected').val();
					window.location.href=url+'?key='+key+'&search='+search;

				};	
				return false;
			});

		});
</script>