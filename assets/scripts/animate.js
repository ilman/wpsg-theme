jQuery(document).ready(function($){

	var anim_end = 'webkitAnimationEnd oAnimationEnd transitionEnd webkitTransitionEnd';
	
	function anim_run($el, trigger, direction){
		if(typeof direction == 'undefined'){
			direction = 'in';
		}

		var $this = $el;

		if($this.hasClass('inview-parent')){
			$this.find('.inview-child').each(function(){
				var $each_this = $(this);
				anim_run($each_this, trigger, direction);
			});
		}
		else{
			var anim = $this.data('anim');			
			var anim_delay = $this.data('anim-delay');
			var anim_duration = $this.data('anim-duration');
			var anim_data = '';

			/*----get anim type----*/
			anim_data = $this.data('anim-'+trigger);
			if(anim_data){ anim = anim_data; }

			anim_data = $this.data('anim-'+trigger+'-'+direction);
			if(anim_data){ 
				anim = anim_data;
			}
			else{
				if(direction=='out'){
					return;
				}
			}

			/*----set animation delay----*/
			anim_data = $this.data('anim-'+trigger+'-delay');
			if(anim_data){ anim_delay = anim_data }

			if(anim_delay){
				anim_delay = anim_delay+'s';
				$this.css({
					'-webkit-animation-delay': anim_delay,
					'-moz-animation-delay': anim_delay,
					'-o-animation-delay': anim_delay,
					'animation-delay': anim_delay,
				});
			}

			/*----set animation duration----*/
			anim_data = $this.data('anim-'+trigger+'-duration');
			if(anim_data){ anim_duration = anim_data }

			if(anim_duration){
				anim_duration = anim_duration+'s';
				$this.css({
					'-webkit-animation-duration': anim_duration,
					'-moz-animation-duration': anim_duration,
					'-o-animation-duration': anim_duration,
					'animation-duration': anim_duration,
				});
			}

			/*----begin animated by adding class----*/
			$this.addClass('animated '+anim).one(anim_end, function(){
				if(direction=='out'){
					$this.css({opacity:0});
				}

				$this.removeClass('animated '+anim);

				//clear delay variable
				$this.css({
					'-webkit-animation-delay': '',
					'-moz-animation-delay': '',
					'-o-animation-delay': '',
					'animation-delay': '',
				});
				
			});

			if(direction=='in'){
				$this.css({opacity:1});
			}
		}
	}

	function is_hidden($el){
		if($el.is(':hidden') || $el.css('opacity') == 0){
			return true;
		}
		else{
			return false;
		}
	}

	/*----trigger inview----*/
	var $anim_inview = $('.anim-inview');

	$anim_inview
	.bind('inview', function(event, visible){
		var $this = $(this);
		var anim = $this.data('anim');
		var anim_data = $this.data('anim-inview');

		if(anim_data){ anim = anim_data }

		if(visible) {
			if(is_hidden($this)){
				anim_run($this,'inview');
			}
			if($this.hasClass('inview-parent')){
				$this.css({opacity:1});
			}
		}
		else{
			if($this.hasClass('bind-always')){
				$this.removeClass('animated '+anim).css({opacity:0});
			}
		}
	});
	$anim_inview.removeClass('animated').css({opacity:0});


	/*----trigger hover----*/
	$('.anim-js-hover')
	.bind('mouseenter', function(event){
		anim_run($(this), 'hover');
	})
	.bind('mouseleave', function(event){
		anim_run($(this), 'hover', 'out');
	});

	

});