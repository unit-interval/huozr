$(function(){
	if ($('#home #order ul.menu').length) view_orders(0);  
	else new_order(0);
	$('#home #flow li').click(function(){
		if ($(this).hasClass('disabled') == false) new_order($(this).index());
	});
	$('#home #history li').click(function(){
		view_orders($(this).index());
	});
});

function view_orders(n){
	$('#home #history > li:eq('+n+')').siblings().removeClass('active');
	$('#home #history > li:eq('+n+')').addClass('active');
	//TODO get orders with status n, place them in history-detail
	$('#home #order ul.menu li').click(function(){
		$(this).addClass('active');
		$(this).siblings().removeClass('active');
		view_order_detail($(this).data('oid'));
	});
	$('#home #history-detail').show();
	$('#home #order ul.menu li').removeClass('active');
	$('#home #order-detail').hide();
	$('#home #flow > li').removeClass('active');
	$('#home #flow > li:first-child').siblings().addClass('disabled');
	$('#home #flow-detail').hide();
}

function view_order_detail(n){
	//TODO get order_dtail of oid n, place them in order-detail
	$('#home #order-detail table tr:even').addClass('alt');
	$('#home #order-detail').slideDown(50);
}

function new_order(n){
	$('#home #history > li').removeClass('active');
	$('#home #history-detail').hide();
	$('#home #flow > li').removeClass('active').removeClass('disabled');
	$('#home #flow > li:eq('+n+')').addClass('active');
	$('#home #flow > li:gt('+n+')').addClass('disabled');
	switch (n){
		case 0:
			$('#home #store').slideDown(50);
			$('#home #service').hide();
			$('#home #upload').hide();
			$('#home #requirement').hide();
			//TODO get stores, and place them in div-store
			$('#home #store ul.menu li').slideDown(50).removeClass('active').click(function(){
				$(this).addClass('active');
				$(this).siblings().removeClass('active').slideUp(50);
				new_order(1);
			});
			break;
		case 1:
			$('#home #service').slideDown(50);
			$('#home #upload').hide();
			$('#home #requirement').hide();
			$('#home #service ul.menu li').slideDown(50).removeClass('active').click(function(){
				$(this).addClass('active');
				$(this).siblings().removeClass('active').slideUp(50);
				new_order(2);
			});
			break;
		case 2:
			set_upload_progress(-1);
			$('#home #upload').slideDown(50);
			$('#home #requirement').hide();
			$('#home #upload input[type="file"]').change(function(){
				if($(this).val() != ''){
					//TODO upload file
					new_order(3);					
				}
			});
			break;
		case 3: 
			//TODO get requiremtn form, and place them in #requirement
			set_default_requirement();
			$('#home #requirement').slideDown(50).find('ul.option > li').click(function(){
				$(this).addClass('active').siblings().removeClass('active');
				set_option_value($(this).parent());
			}).end().find('ul.multi-option > li').click(function(){
				$(this).toggleClass('active');
				set_option_value($(this).parent());
			})
			break;
	}
	$('#home #flow-detail').show();
}

function set_default_requirement(){
	//TODO...
}

function set_option_value(x){
	x.each(function(){
		var options = new Array();
		$(this).children('.active').each(function(){
			options.push($(this).text());
		})
		$(this).siblings('input[type="hidden"]').val(options.join('，'))
	})
}

function set_upload_progress(n){
	if (n < 0){
		// if n is less than 0, upload-progress is reset. else the range of n is between 0 and 100
		$('#home #upload-progress').hide().find('span').attr('width', 0);
		$('#home #upload input[type="file"]').replaceWith("<input type='file' name='file' />");
	}
	else $('#home #upload-progress').slideDown(50).find('span').animate({width: 2.45*n}, 50);
}