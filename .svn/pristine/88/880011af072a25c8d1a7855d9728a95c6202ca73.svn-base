<div class="nav-search" id="nav-search">

	<form name="advisory_search" class="form-search" action="" method="get">
		<span class="input-icon">
			<select class="form-control" name="key">
					<option <?php if(isset($admin_info['key']) && $admin_info['key'] == 'consultant_name'){echo 'selected=selected';}?> value="consultant_name">姓名</option>
					<option <?php if(isset($admin_info['key']) && $admin_info['key'] == 'qq'){echo 'selected=selected';}?> value="qq">QQ</option>
					<option <?php if(isset($admin_info['key']) && $admin_info['key'] == 'phones'){echo 'selected=selected';}?> value="phones">phone</option>
					<option <?php if(isset($admin_info['key']) && $admin_info['key'] == 'email'){echo 'selected=selected';}?> value="email">email</option>
					<option <?php if(isset($admin_info['key']) && $admin_info['key'] == 'consultant_education'){echo 'selected=selected';}?> value="consultant_education">学历</option>
					<option <?php if(isset($admin_info['key']) && $admin_info['key'] == 'consultant_school'){echo 'selected=selected';}?> value="consultant_school">学校</option>
					<option <?php if(isset($admin_info['key']) && $admin_info['key'] == 'consultant_specialty'){echo 'selected=selected';}?> value="consultant_specialty">专业</option>
			</select>
		</span>
		<span class="input-icon">
			<input type="text" name="search" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" value="<?php if(isset($admin_info['search']))echo $admin_info['search'];?>" />
			<i class="icon-search nav-search-icon"></i>
		</span>
		<span class="input-icon">
		<button class="btn btn-xs btn-primary">搜索</button>
		</span>
	</form>
</div><!-- #nav-search -->
<script>
	//搜索咨询者的相关信息
	jQuery(function($){
		
		var url='<?php echo site_url(module_folder(2).'/advisory/index/index/0');?>';
		$('form[name="advisory_search"]').submit(function(){
			var search=$.trim(this.elements['search'].value);

			if (search!='') {
				var key= $('select[name="key"] option:selected').val();
				window.location.href=url+'?key='+key+'&search='+search;

			};	
			return false;
		});

	});
</script>