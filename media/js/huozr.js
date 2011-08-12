$(function(){
	//-------------------- Notification --------------------
	c = $('#notification-icon');
	d = $('#notification');
	c.click(function(){
		c.toggleClass('active');
		d.toggle().children('div').children('ul').css('max-height', $(window).height()-90);
		return false;
	})
	d.click(function(e){
		return false;
	})
	$(document).click(function(){
		c.removeClass('active');
		d.hide();
	});	
	//-------------------- Huozr-More --------------------
	a = $('#huozr-more-icon');
	b = $('#huozr-more');
	a.click(function(){
		a.toggleClass('active');
		b.toggle();
		return false;
	})
	b.click(function(e){
		return false;
	})
	$(document).click(function(){
		a.removeClass('active');
		b.hide();
	});
	//-------------------- Input-Select --------------------
	$('div.input-select').delegate('ul > li', 'click', function(){
		$(this).parent().hide().siblings('input[type="text"]').val($(this).text());
	}).find('ul').hide().end().find('input').focus(function(){
		$(this).parent().find('ul').show();
	})
})