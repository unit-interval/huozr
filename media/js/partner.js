$(function(){
	//-------------------- Huozr-More --------------------
	$('#huozr-more-icon').click(function(){
		$('#huozr-more-icon').toggleClass('active');
		$('#huozr-more').toggleClass('active');
	})
	//-------------------- HOME Page --------------------
	$('#home #category').delegate('li', 'click', function(){
		$(this).addClass('active').siblings().removeClass('active');		
		view_orders($(this).index());
	});
	$('#home #order-list').delegate('span', 'click', function(){
		$(this).addClass('active').siblings().removeClass('active');
		view_orders($(this).data('oid'));
	});
	$('#home #detail-wrapper').height($(window).height()-130);
	$(window).resize(function(){
		$('#home #detail-wrapper').height($(window).height()-130);
	})
	//-------------------- SETTING Page --------------------
	$('#setting #set-password').hide().next().hide();
	if ($('#setting #username').find('input').val() == '') $('#setting #username').find('button.button-blue').hide();
	else $('#setting #username').find('button.button-orange').hide();
	$('#setting #username').find('button.button-orange').click(function(){
		$(this).hide().next().show().parent().find('input').removeClass('disabled').attr('disabled', '')
		.closest('tr').next().show().find('input').removeClass('disabled').attr('disabled', '')
		.end().next().show().find('input').removeClass('disabled').attr('disabled', '');
	}).end().find('button.button-blue').click(function(){
		$(this).hide().next().show()
		.closest('tr').next().show().find('input').removeClass('disabled').attr('disabled', '')
		.end().next().show().find('input').removeClass('disabled').attr('disabled', '');
	})
	$('#setting table tr:gt(2)').find('button.button-blue').click(function(){
		$(this).hide().next().show().parent().find('input').removeClass('disabled').attr('disabled', '').focus();
	}).end().find('button.button-green').click(function(){
		//TODO update personal info
		$(this).hide().prev().show().parent().find('input').addClass('disabled').attr('disabled', 'disabled').end().find('ul').hide();
	})
	$('#setting #content table').find('input.input-text').attr('disabled', 'disabled').addClass('disabled')
	.end().find('button.button-green').hide()
	.find('button.button-blue').click(function(){
		$(this).prev('input.input-text').removeClass('disabled')
	});
	
});
//-------------------- HOME Function --------------------
function view_orders(n){
	//TODO get orders with status n, place them in order-list
	$('#home #order ul.menu li').removeClass('active').click(function(){
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		view_order_detail($(this).data('oid'));
	});
}

function view_order_detail(n){
	//TODO get order_detail of oid n, place them in order-detail
}