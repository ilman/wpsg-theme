jQuery(document).ready(function($){
	
	var $sg_form_tab_group = $('.sg-form-tab-group');
	var $sg_form_tab_nav = $('.sg-form-tab-nav');
	var $sg_form_tab_nav_li = $sg_form_tab_nav.find('li');
	var $sg_form_tab_nav_a = $sg_form_tab_nav.find('a');
	var $sg_form_tab_nav_current = $sg_form_tab_nav.find('.current');
	var $sg_form_trigger = $('.trigger').find(':input');

	/*----tabs navigation----*/
	
	//tab nav click
	$sg_form_tab_nav_a.click(function(event){
		var $this = $(this);
		var $this_container = $this.closest('.sg-container');
		var this_container_id = $this_container.attr('id');

		if($this.filter('[href]').length>0){
			var active_tab = $this.attr('href');
		}
		else{
			var $first_a_child = $this.parent().find('li a').eq(0);
			var active_tab = $first_a_child.attr('href');
			$first_a_child.parent().addClass('current').siblings().removeClass('current');

		}
				
		$(active_tab).siblings().hide().end().fadeIn();
			
		//set cookie
		$.cookie(this_container_id, active_tab.replace('#',''));
		
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

	/*----get active tab----*/

	var $sg_container = $('.sg-container').filter('[id]');

	$sg_container.each(function(){
		var $this = $(this);
		var $this_tab_nav = $this.find('.sg-form-tab-nav');
		var this_id = $this.attr('id');
		var this_cookie = $.cookie(this_id);

		//get active tab nav from cookie	
		if(this_cookie!='undefined'){
			$this_tab_nav_current = $this_tab_nav.find('.'+this_cookie);
		}
	
		//get active tab nav
		if($this_tab_nav_current.length == 0){
			$this_tab_nav_current = $this_tab_nav.find('li').eq(0);
		}
		
		//add current class to active tab nav
		$this_tab_nav_current.addClass('current');
					
		//hide non active tabs
		var active_tab = $this_tab_nav_current.find('a').attr('href');	
		$this.find(active_tab).show().siblings('.sg-form-tab-item').hide();
			
		//add current class to active tab parent
		var $this_tab_nav_current_parent = $this_tab_nav_current.parent().closest('li');
		if($this_tab_nav_current_parent.length>0){
			$this_tab_nav_current_parent.addClass('current');
		}

		//trigger
		$this_tab_nav_current.find('> a').trigger('click');
	});

	
});