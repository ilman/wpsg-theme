function preview_color_set(element_id){
	var $ = jQuery;
	var $preview = $('#'+element_id);
	var $iframe = $preview.find('iframe');
	var $iframe_content = $iframe.contents();
	var $fieldset = $preview.closest('.section-set');
	var $style = $('<style />');
	var fieldset_prefix = $fieldset.attr('rel');
	var prefix = theme_option_prefix+'-'+fieldset_prefix+'-';
	
	$iframe_content.find('body').css({
		background: $('#'+prefix+'background-color').val(),
		color: $('#'+prefix+'text-color').val(),
	});
	$iframe_content.find('h3').css({
		color: $('#'+prefix+'heading-color').val(),
	});	
	$iframe_content.find('a').css({
		color: $('#'+prefix+'accent-color').val(),
	});	
	$iframe_content.find('hr').css({
		'border-color': $('#'+prefix+'line-color').val(),
	});	
	$iframe_content.find('.input').css({
		'border-color': $('#'+prefix+'line-color').val(),
		'background-color': $('#'+prefix+'base-color').val(),
	});
	$iframe_content.find('.button').css({
		'background-color': $('#'+prefix+'accent-color').val(),
	});
}

function preview_font_set(element_id, param){
	var $ = jQuery;
	var $preview = $('#'+element_id);
	var $iframe = $preview.find('iframe');
	var $iframe_content = $iframe.contents();
	var $fieldset = $preview.closest('.section-set');
	var $style = $('<style />');
	var fieldset_prefix = $fieldset.attr('rel');
	var prefix = theme_option_prefix+'-'+fieldset_prefix+'-';
	
	if(typeof param == 'undefined' || param == ''){
		param = 'body';	
	}
	
	$iframe_content.find(param).css({
		'font-family': $('#'+prefix+'font-family').val(),
		'font-style': $('.'+prefix+'font-style').find('[type=radio]:checked').val(),
		'font-weight': $('.'+prefix+'font-weight').find('[type=radio]:checked').val(),
		'font-size': $('#'+prefix+'font-size').val()+'px',
		'line-height': $('#'+prefix+'line-height').val()+'px',
		'text-transform': $('#'+prefix+'text-transform').val(),
	});
}

