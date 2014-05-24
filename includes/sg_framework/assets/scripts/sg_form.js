var $sg_form = {};

jQuery(document).ready(function($){
	
	var all_input = ':input:not(input[type=button],input[type=submit],button)';
	
	/*----forms----*/
	
	$sg_form.submit_form = function($element){
		var $form = $element.closest('form');
				
		$.ajax({  
			type: "POST", 
			url: $form.attr('action'),  
			data: $form.serialize(),
			beforeSend: function(){
				$('body').css('cursor','wait');
			},
			success: function(data) {
				$().toastmessage('showSuccessToast', 'Settings has been updated.');
			},
			error: function(data) {
				$().toastmessage('showErrorToast', 'Settings update failed.');
			},
			complete: function(){
				$('body').css('cursor','auto');	
			}
		});
	}
		
	$sg_form.init_form = function(){
					
		$('.ui-slider').each(function(){
			var $this = $(this);
			var $this_input = $this.siblings('input[type=text]');
			
			$this.slider({ 
				range: 'min',
				slide: function( event, ui ) {
					$this_input.val(ui.value); 
				} 
			}); 		
		});	
		
		$('.color-button').each(function(){
			var $this = $(this);
			var $this_input = $this.siblings('.color-value');
			var $this_preview = $this.siblings('.color-placeholder').find('.color-preview');
			
			$this_preview.css('backgroundColor', $this_input.val());
			
			$this.ColorPicker({
				color: $this_input.val(),
				onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
				},
				onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					$this_input.change();
					return false;
				},
				onChange: function (hsb, hex, rgb) {
					$this_input.val('#'+hex);
					$this_preview.css('backgroundColor', '#'+hex);
				}
			});	
		});
		
		/*
		$('.media-upload-button').on('click',function(event) {
			var $upload_field = $(this).siblings('.media-upload-url');
			var form_field = $upload_field.attr('name');
			tb_show('', 'media-upload.php?type=image&amp;tab=library&amp;TB_iframe=true');
			event.preventDefault();		
		
			window.send_to_editor = function(html) {
				var imgurl = $('img',html).attr('src');
				$upload_field.val(imgurl);
				$upload_field.siblings('.media-upload-preview').html('<img src="'+$upload_field.val()+'" />');
				tb_remove();
				$sg_form.submit_form($upload_field);
			}
		});
		*/		
		
		$('.select-image-item').on('click',function(event){
			$(this).addClass('selected').siblings().removeClass('selected');
		});
		
		$('.select-select2').select2();
		
		// tell Select2 to use the property name for the text
    function format(item) { return item.name; };

    var names = [{"id":"1","name":"Adair,James"}
             , {"id":"2","name":"Anderson,Peter"}
             , {"id":"3","name":"Armstrong,Ryan"}]
/*
    $(".select-font").select2({
            data:{ results: names, text: 'name' },
            formatSelection: format,
            formatResult: format                        
    });	
	*/	
		
		$('.select-font').select2({ 
			data: $font_google
		});
		
	};
	
	$sg_form.init_form();
	
	/*----repeats----*/
	
	$sg_form.clean_clone = function($field){
		//find all element that has name and ++ the counter
		$field.find(all_input).filter('[name]').attr('name', function(index, name) {  
			return name.replace(/(\d+)/, function(fullMatch, n) {  
				return Number(n) + 1;  
			});  
		});
		
		//find all element that has id and ++ the counter
		$field.find('div,'+all_input).filter('[id]').attr('id', function(index, id) { 
			return id.replace(/(\d+)/, function(fullMatch, n) {  
				return Number(n) + 1;  
			});  
		})
		
		//reset input element
		$field.find(all_input).filter(':not(input[type=radio],input[type=checkbox])').val('');
		$field.find('input[type=radio],input[type=checkbox]').removeAttr('checked');
		
		//reset all non-form element
		$field.find('.media-upload-preview').html('');
		$field.find('.color-preview').css('background-color','#fff');
		$field.find('.select-image-item').removeClass('selected');
	}
	
	$('.repeat-btn').click(function(event) {  
		var $parent = $(this).closest('.controls');
		var $field = $parent.find('.repeat-list li:last').clone();  
		var $field_location = $parent.find('.repeat-list li:last'); 
		
		$sg_form.clean_clone($field);
		
		//insert clone element
		$field.insertAfter($field_location) ;
		
		//reinit form
		$sg_form.init_form();
		
		event.preventDefault();
	});  
	  
	$('.repeat-list').on('click','.repeat-delete',function(){ 
		var $this_parent = $(this).parent();
		
		if($this_parent.siblings().length>0){
			$this_parent.remove(); 
		}
		else{
			$sg_form.clean_clone($this_parent);
		}
		return false;  
	});  
		  
	$('.repeat-list').sortable({  
		opacity: 0.6,  
		revert: true,  
		cursor: 'move',  
		handle: '.repeat-sort'  
	});  
	
	/*----events----*/

	var $sg_form_container = $('.sg-form-container');
	var $sg_form_trigger =  $sg_form_container.find('.trigger');
	$sg_form_trigger = $sg_form_trigger.add($sg_form_trigger.find(':input'));
	$sg_form_trigger = $sg_form_trigger.filter(':input');

	$sg_form.trigger = function($element){
		var $this = $element;
		var this_val = $this.val();
		var this_rel = ($this.attr('rel')) ? $this.attr('rel') : $this.parent().attr('rel');		
		var this_slug = strToSlug(this_rel);
		
		$('.bind-'+this_slug).each(function(idx){
			var $each_this = $(this);
			if($each_this.hasClass(this_val)){
				$each_this.fadeIn();
			}
			else{
				$each_this.hide();
			}
		});
	}

	//run onload on all element
	$sg_form_container.find('[onload]').each(function(){
		var fn = $(this).attr('onload');
		eval(fn);	
	});
	
	$sg_form_trigger.click(function(){
		$sg_form.trigger($(this));
	});

	$sg_form_trigger.on('change', function(){
		$sg_form.trigger($(this));
	});
	
	$(window).on('resize', function(){
		$sg_form_trigger.filter(':checked').trigger('click');
		$sg_form_trigger.filter(':not(:radio,:checkbox)').trigger('change');
	});

	$(window).on('load', function(){
		$(this).resize();
	})

	
});