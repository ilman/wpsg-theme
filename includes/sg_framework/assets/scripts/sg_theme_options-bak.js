jQuery(document).ready(function($){
	
	var $to_content = $('.to-content');
	var $to_expand_btn = $('.to-expand');
	var $to_tab_group = $('.to-tab-group.collapse');
	var $to_tab_nav = $('.to-tab-nav');
	var $to_tab_nav_li = $to_tab_nav.find('li');
	var $to_tab_nav_a = $to_tab_nav.find('a');
	var $to_tab_nav_current = $to_tab_nav.find('.current');
	var $to_tab_nav_cookie = $.cookie('sg_theme_options');
	var $to_trigger = $('.trigger').find(':input');
		
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
	
	/*----tabs navigation----*/
	
	//get active tab nav from cookie	
	if($to_tab_nav_cookie!='undefined'){
		$to_tab_nav_current = $('.'+$to_tab_nav_cookie);
	}
	
	//get active tab nav
	if($to_tab_nav_current.length == 0){
		$to_tab_nav_current = $to_tab_nav_li.eq(0);
	}
	
	//add current class to active tab nav
	$to_tab_nav_current.addClass('current');
		
	//add current class to active tab parent
	var $to_tab_nav_current_parent = $to_tab_nav_current.parent().closest('li');
	if($to_tab_nav_current_parent.length>0){
		$to_tab_nav_current_parent.addClass('current');
	}
		
	//hide non active tabs
	var active_tab = $to_tab_nav_current.find('a').attr('href');	
	$(active_tab).show().siblings('.sg-form-tab-item').hide();
	
	//tab nav click
	$to_tab_nav_a.click(function(event){
		var $this = $(this);
		if($this.filter('[href]').length>0){
			var active_tab = $this.attr('href');
		}
		else{
			var $first_a_child = $this.parent().find('li a').eq(0);
			var active_tab = $first_a_child.attr('href');
			$first_a_child.addClass('current');
		}
				
		$(active_tab).siblings().hide().end().fadeIn();
			
		//set cookie
		$.cookie('sg_theme_options', active_tab.replace('#',''));
		
		//set hash
		if(history.pushState) {
			window.history.pushState(null, null, active_tab);
		}
		else {
			window.location.hash = active_tab;
		}

		$this.parent().addClass('current').siblings().removeClass('current');		
		event.preventDefault();
	});

	/*----event trigger----*/	
	
	
	
	/*----ajaxify form----*/
		
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