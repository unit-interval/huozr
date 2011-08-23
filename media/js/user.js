$(function(){
	//-------------------- Index Page --------------------
	$('#index div.arrow-nav a').click(function(){
		a = $(this);
		b = a.parent().prev();
		c = a.siblings();
		if (a.hasClass('up')){
			b.animate({scrollTop: "-=200px"}, function(){
				if (b.scrollTop() == 0) a.addClass('up-inactive');
				c.removeClass('down-inactive');
			})
		}
		else if (a.hasClass('down')){
			b.animate({scrollTop: "+=200px"}, function(){
				if (b.scrollTop() + c.parent().height() <= b.get(0).scrollHeight) a.addClass('down-inactive');
				c.removeClass('up-inactive');
			})
		}
		return false;
	})
	//-------------------- Login Page --------------------
	$('#login #signup > button').click(function(){
		$(this).parents('#login-here').hide().next().show();
	})
	//-------------------- HOME Page --------------------
	$('#home #flow li').click(function(){
		if ($(this).hasClass('disabled') == false) new_order($(this).index());
	});
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
			$('#home #sub-menu').css('width', '250px');
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