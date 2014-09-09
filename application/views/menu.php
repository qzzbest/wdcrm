<div class="sidebar" id="sidebar">
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	</script>   
	<ul class="nav nav-list">
		<?php 
			#根据不同的职位显示不同的菜单栏
			$login_job = getcookie_crm('employee_job_id');
			$advisory_job = array(2,8,11);
			if(in_array($login_job, $advisory_job)){
				$menu1=$this->load->module('advisory/advisory/menuConsultate',array(),true);
				$menu2=$this->load->module('advisory/advisory/menuChannel',array(),true);
		?>
		<li>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> 咨询者管理 </span>

				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<?php if($login_job != 8){?>
				<li>
					<a href="<?php echo site_url(module_folder(2).'/advisory/add');?>">
						<i class="icon-double-angle-right"></i>
						添加咨询者
					</a>
				</li>
				<?php }?>
				<li>
					<a href="<?php echo site_url(module_folder(2).'/advisory/index/index/0');?>">
						<i class="icon-double-angle-right"></i>
						咨询者列表
					</a>
				</li>
				
				<li>
					<a href="#" class="dropdown-toggle">
						<i class="icon-double-angle-right"></i>
						咨询形式
						<b class="arrow icon-angle-down"></b>
					</a>
					
					<ul class="submenu">
						<?php foreach($menu1 as $item){?>
						<li>
							<a href="<?php echo site_url(module_folder(2).'/advisory/index/consultant_consultate_id/'.$item['consultant_consultate_id']);?>">
								<i class="icon-double-angle-right"></i>
								<?php echo $item['consultant_consultate_name'];?>
							</a>
						</li>
						<?php }?>
					</ul>
				</li>
				<li>
					<a href="#" class="dropdown-toggle">
						<i class="icon-double-angle-right"></i>
						咨询渠道
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<?php foreach($menu2 as $item){?>
						<li>
							<a href="<?php echo site_url(module_folder(2).'/advisory/index/consultant_channel_id/'.$item['consultant_channel_id']);?>">
								<i class="icon-double-angle-right"></i>
								<?php echo $item['consultant_channel_name'];?>
							</a>
						</li>
						<?php }?>
					</ul>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(2).'/advisory/index/consultant_set_view/0');?>">
						<i class="icon-double-angle-right"></i>
						未上门
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(2).'/advisory/index/consultant_set_view/1');?>">
						<i class="icon-double-angle-right"></i>
						已上门
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(2).'/advisory/commonResource');?>">
						<i class="icon-double-angle-right"></i>
						公共资源
					</a>
				</li>
			</ul>
		</li>
		
		<!-- <li>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> 咨询提醒管理 </span>
		
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li>
					<a href="<?php echo site_url(module_folder(2).'/consultant_remind/index');?>">
						<i class="icon-double-angle-right"></i>
						咨询提醒列表
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(2).'/consultant_remind/add');?>">
						<i class="icon-double-angle-right"></i>
						添加咨询提醒
					</a>
				</li>
			</ul>
		</li> -->
		<?php }?>

		<?php 
		$personnel_employ = array(2,8,11,19);
		if(in_array($login_job, $personnel_employ)){
			$menu1=$this->load->module('advisory/advisory/menuConsultate',array(),true);
			$menu2=$this->load->module('advisory/advisory/menuChannel',array(),true);
		?>
		<li>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> 学员管理 </span>

				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li>
					<a href="<?php echo site_url(module_folder(2).'/student/index/index/0');?>">
						<i class="icon-double-angle-right"></i>
						学员列表
					</a>
				</li>	
				<li>
					<a href="#" class="dropdown-toggle">
						<i class="icon-double-angle-right"></i>
						咨询形式
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<?php foreach($menu1 as $item){?>
						<li>
							<a href="<?php echo site_url(module_folder(2).'/student/index/consultant_consultate_id/'.$item['consultant_consultate_id']);?>">
								<i class="icon-double-angle-right"></i>
								<?php echo $item['consultant_consultate_name'];?>
							</a>
						</li>
						<?php }?>
					</ul>
				</li>
						
			   	<li class="submenu2">
					<a href="#" class="dropdown-toggle">
						<i class="icon-double-angle-right"></i>
						咨询渠道
						<b class="arrow icon-angle-down"></b>
					</a>
					<ul class="submenu">
						<?php foreach($menu2 as $item){?>
						<li>
							<a href="<?php echo site_url(module_folder(2).'/student/index/consultant_channel_id/'.$item['consultant_channel_id']);?>">
								<i class="icon-double-angle-right"></i>
								<?php echo $item['consultant_channel_name'];?>
							</a>
						</li>
						<?php }?>
					</ul>
				</li>		
			</ul>
		</li>
		<?php }?>
		
		<?php if(in_array($login_job, $advisory_job)){
		?>
			<li>
				<a href="#" class="dropdown-toggle">
					<i class="icon-list"></i>
					<span class="menu-text"> 客户管理 </span>

					<b class="arrow icon-angle-down"></b>
				</a>
				<ul class="submenu">
					<li>
						<a href="<?php echo site_url(module_folder(2).'/client/index/index/0');?>">
							<i class="icon-double-angle-right"></i>
							客户列表
						</a>
					</li>	
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-double-angle-right"></i>
							咨询形式
							<b class="arrow icon-angle-down"></b>
						</a>
						<ul class="submenu">
							<?php foreach($menu1 as $item){?>
							<li>
								<a href="<?php echo site_url(module_folder(2).'/client/index/consultant_consultate_id/'.$item['consultant_consultate_id']);?>">
									<i class="icon-double-angle-right"></i>
									<?php echo $item['consultant_consultate_name'];?>
								</a>
							</li>
							<?php }?>
						</ul>
					</li>
							
				   	<li class="submenu2">
						<a href="#" class="dropdown-toggle">
							<i class="icon-double-angle-right"></i>
							咨询渠道
							<b class="arrow icon-angle-down"></b>
						</a>
						<ul class="submenu">
							<?php foreach($menu2 as $item){?>
							<li>
								<a href="<?php echo site_url(module_folder(2).'/client/index/consultant_channel_id/'.$item['consultant_channel_id']);?>">
									<i class="icon-double-angle-right"></i>
									<?php echo $item['consultant_channel_name'];?>
								</a>
							</li>
							<?php }?>
						</ul>
					</li>		
				</ul>
			</li>
		
			<?php if(in_array($login_job, array(2))){?>
			<li>
				<a href="#" class="dropdown-toggle">
					<i class="icon-list"></i>
					<span class="menu-text"> 教务管理 </span>

					<b class="arrow icon-angle-down"></b>
				</a>
				<ul class="submenu">
					<li>
						<a href="<?php echo site_url(module_folder(4).'/classroom/index/index');?>">
							<i class="icon-double-angle-right"></i>
							班级列表
						</a>
					</li>
					<li>
						<a href="<?php echo site_url(module_folder(4).'/classroom_type/index');?>">
							<i class="icon-double-angle-right"></i>
							班级类型
						</a>
					</li>
				</ul>
			</li>
			<?php }?>

		<?php }?>

		<?php 
		$employee_id = getcookie_crm('employee_id');
		$employee_job = array(18,11);
		#$em_id = array(20,26,53);
			if(in_array($login_job, $employee_job)){?>
		<li>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> 市场管理 </span>
		
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li>
					<a href="<?php echo site_url(module_folder(6).'/market/index');?>">
						<i class="icon-double-angle-right"></i>
						市场列表
					</a>
				</li>
			</ul>
		</li>
		<?php } ?>
		<?php 
			//$login_job = getcookie_crm('employee_job_id');
			$teaching_job = array(4,5,11);
			if(in_array($login_job, $teaching_job)){
		?>
		
		<li>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> 教务管理 </span>

				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li>
					<a href="<?php echo site_url(module_folder(4).'/student/index');?>">
						<i class="icon-double-angle-right"></i>
						学员列表
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(4).'/classroom/index/index');?>">
						<i class="icon-double-angle-right"></i>
						班级列表
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(4).'/classroom_type/index');?>">
						<i class="icon-double-angle-right"></i>
						班级类型配置
					</a>
				</li>
			</ul>
		</li>
	
		<?php }?>
		<?php $employee_job = array(8,11);
			if(in_array($login_job, $employee_job)){?>
		<li>
			<a href="<?php echo site_url(module_folder(1).'/admin/index');?>" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> 系统管理 </span>

				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li>
					<a href="<?php echo site_url(module_folder(1).'/admin/index');?>">
						<i class="icon-double-angle-right"></i>
						员工列表
					</a>
				</li>
				<?php if($login_job!=8){?>
				<li>
					<a href="<?php echo site_url(module_folder(1).'/employee_job/index');?>">
						<i class="icon-double-angle-right"></i>
						员工职位
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(1).'/curriculum_system/index');?>">
						<i class="icon-double-angle-right"></i>
						课程列表
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(1).'/knowledge/index');?>">
						<i class="icon-double-angle-right"></i>
						知识点列表
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(1).'/counselor_consultate_modus/index');?>">
						<i class="icon-double-angle-right"></i>
						咨询形式
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(1).'/consultant_channel/index');?>">
						<i class="icon-double-angle-right"></i>
						咨询渠道
					</a>
				</li>
				<!-- <li>
					<a href="<?php echo site_url(module_folder(1).'/marketing_specialist/index');?>">
						<i class="icon-double-angle-right"></i>
						市场专员
					</a>
				</li> -->
				<li>
					<a href="<?php echo site_url(module_folder(2).'/remind/index');?>">
						<i class="icon-double-angle-right"></i>
						咨询提醒
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(5).'/contact/index');?>">
						<i class="icon-double-angle-right"></i>
						通讯录
					</a>
				</li>
				<?php }?>
			</ul>
		</li>
		<?php }?>
		<?php $employee_job = array(2,4,5,8,11,19);
			if(in_array($login_job, $employee_job)){
			#if(in_array($employee_id, $em_id)){?>
		<li>
			<a href="#" class="dropdown-toggle">
				<i class="icon-list"></i>
				<span class="menu-text"> 文件下载 </span>
		
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li>
					<a href="<?php echo site_url(module_folder(5).'/file/index');?>">
						<i class="icon-double-angle-right"></i>
						简历下载
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(module_folder(5).'/file_data/index');?>">
						<i class="icon-double-angle-right"></i>
						资料下载
					</a>
				</li>
			</ul>
		</li>
		<?php }?>
	</ul>
	<!-- /.nav-list -->

	<div class="sidebar-collapse" id="sidebar-collapse">
		<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
	</div>

	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
	</script>
</div>