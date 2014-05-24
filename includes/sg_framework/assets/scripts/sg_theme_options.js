jQuery(document).ready(function($){
	
	var $to_content = $('.to-content');
	var $to_expand_btn = $('.to-expand');
		
	$to_expand_btn.click(function(event){
		var $this = $(this);
				
		if($this.hasClass('collapse')){
			$this.removeClass('collapse');
			$to_content.removeClass('collapse');
		}
		else{
			$this.addClass('collapse');
			$to_content.addClass('collapse');
		}
	});
			
	//save form
	$('.to-save').click(function(event){		
		//$sg_form.submit_form($(this));
		//event.preventDefault();
	});	
	
	//reset form
	$('.to-reset').click(function(event){
		var response = confirm('Click OK to reset. Current setting will be replaced by default');
		
		if(!response){
			return false;
		}
		else{
			$().toastmessage('showWarningToast', 'Settings will be reseted.');
		}
	});
	
});