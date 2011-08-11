$(function(){
	//-------------------- Notification --------------------
	$('#notification-icon').click(function(){
		$('#notification-icon').toggleClass('active');
		$('#notification').toggleClass('active').children('div').children('ul').css('max-height', $(window).height()-90);
	})
	//-------------------- Huozr-More --------------------
	$('#huozr-more-icon').click(function(){
		$('#huozr-more-icon').toggleClass('active');
		$('#huozr-more').toggleClass('active');
	})
	//-------------------- Input-Select --------------------
	$('div.input-select').delegate('ul > li', 'click', function(){
		$(this).parent().hide().siblings('input[type="text"]').val($(this).text());
	}).find('ul').hide().end().find('input').focus(function(){
		$(this).parent().find('ul').show();
	})
})