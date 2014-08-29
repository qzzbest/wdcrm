<?php
/*

在每一个页面底部，加上这句话，为了让侧边栏的效果能够显示出来。
$('.submenu').find('a').each(function(){

	var checked= $(this).attr('href');

	var url= window.location.href;
	var arr= url.split('/');
		arr.length=8;
	var current=arr.join('/');

	
	if (checked===current){

		//给父亲加样式
		$(this).parent().addClass('active');
		$(this).parent().parent().css('display','block');
		$(this).parent().parent().parent().css('display','open');
	};
});