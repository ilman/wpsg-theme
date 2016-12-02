jQuery(document).ready(function($){

	var $window = $(window);
	var mobile_breakpoint = 768;

	(function(){
		if($window.width() >= 640){
			var this_height = $window.height() - $('#header').height() - 200;
			$('.home #subheader .container').height(this_height);
		}
	})();


	/*----choices form----*/
	(function(){
		$('.gform_footer').prepend('<p class="cform-link"><a href="http://choicesdemo.co.uk/privacy-policy">Privacy Policy</a></p>')
	})();

	/*----stick footer----*/
	$window.load(function(){
		var $footer = $('#footer');
		var $offset = $footer.offset();

		if($footer.length < 1){ return false; }

		if(($footer.height() + $offset.top) < $window.height()){
			$footer.css({
				'margin-top' : $window.height() - ($footer.height() + $offset.top) - 1
			});
		}
	});

	/*----input select2-----*/
	(function(){
		if(typeof $.fn.select2 === 'undefined'){ return false; }
		$('.input-select2').select2();
	})();

	/*----tooltip----*/
	(function(){
		if(typeof $.fn.tooltip === 'undefined'){ return false; }
		$('.bs-tooltip').tooltip();
	})();

	/*----scroll to element----*/
	function scroll_to_el(el){
		var el_pos = 0;
		
		if($(el).length > 0){
			el_pos = $(el).offset().top;
		}


		$('html,body').delay(200).animate({
			scrollTop: el_pos
		}, 1000, function(){
			window.location.hash = el;
		});
	}

	(function(){
		var $nav_one_page = $('.nav-one-page');

		$nav_one_page.find('a[href^="#"]').click(function(e) {    
	        e.preventDefault();
	        var target = this.hash;
         	scroll_to_el(target);         	
		});
	})();

	/*----menu tree----*/
	(function(){
		$('.widget-nav-menu').on('click','.menu-item-has-children > a', function(e){
			e.preventDefault();
			var $this = $(this);
			var $this_parent = $this.parent();

			$this_parent.toggleClass('open');
		})
	})();

	/*----back to top----*/
	(function(){

		var $to_top = $('<div id="btn-to-top"><a class="btn btn-primary"><i class="fa fa-angle-up"></i></a></div>')

		$('body').append($to_top);

		$window.scroll(function(){
			if($window.scrollTop() > 10){
				$to_top.show();
			}
			else{
				$to_top.hide();
			}
		});

		$to_top.click(function(e) {
			e.preventDefault();
			scroll_to_el();
		});
	})();

	/*----navbar form----*/
	(function(){
		$('.section-navigation').find('.navbar-form').each(function(){
			var $this = $(this);

			$this.closest('.section-navigation').addClass('contain-form');
		});
	})();

	/*----fixed section----*/
	(function(){
		var $section = $('.page-section.header-fixed, .page-section.fixed');

		$section.each(function(){
			var $this = $(this);

			var section_class = $this.attr('class');
			var section_pos = $this.position().top;
			var section_height = $this.outerHeight();

			$window.scroll(function(){
				if($window.scrollTop() > section_pos){
					$this.addClass('scrolled text-default').removeClass('bg-none border-none text-white');
					if($this.hasClass('header-fixed')){
						$this.addClass('fixed');
					}
				}
				else{
					$this.attr('class', section_class);
				}
			});
		});
	})();

	/*----media element----*/
	// $('audio,video').mediaelementplayer();
	
	/*----hero----*/
	(function(){
		var on_resize = function(){
			var window_height = $(window).height();
			var ref_height = $('#header').height() + $('#footer').height();
			$('.hero-window').css({'min-height': window_height-ref_height});
		}
		
		on_resize();

		$window.on('resize', function(){
			on_resize();
		});
	})();

	/*----bootstrap accordion----*/
	(function(){
		if(typeof $.fn.collapse === 'undefined'){ return false; }
		$('.accordion-group').collapse();
	})();
	
	/*----infinite scroll----*/
	
	var $infinite_scroll = {
		loading: {
			img: '/images/ajax-loader.gif',
			msgText: 'Loading the next set of posts...',
			finishedMsg: 'All posts loaded.'
		},
		"nextSelector":".content-main .nav-load-more a",
		"navSelector":".content-main .nav-load-more",
		"itemSelector":".content-main .post-item",
		"contentSelector":".content-main .post-list"
	};
	//$($infinite_scroll.contentSelector).infinitescroll($infinite_scroll);
	
	/*----isotope init----*/	
	(function(){
		if(typeof $.fn.imagesLoaded === 'undefined'){ return false; }

		//init
		var $isotope_options = {
			itemSelector : '.post-item',
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false,
			},
			resizeable: false
		};

		var $list_masonry = $('.list-masonry');

		function init_masonry($el, $options){
			$options.masonry = {};

			$options.masonry.columnWidth = $el.find('.isotope-item').outerWidth();

			if($el.data('masonry-width')!=null){
				$options.masonry.columnWidth = $el.data('masonry-width');
			}

			$el.isotope($options);
		}

		$list_masonry.each(function(){
			var $this = $(this);	
			var $options = $isotope_options;

			$this.imagesLoaded( function(){
				init_masonry($this, $options);
			});
		});

		$window.smartresize(function(){
			$list_masonry.each(function(){
				var $this = $(this);	
				var $options = $isotope_options;

				$this.imagesLoaded( function(){
					init_masonry($this, $options);
				});
			});
		});


		//filter
		$('.filter-masonry').find('a').click(function(event){
			var $this = $(this);
			var $options = $isotope_options;

			var $isotope_filter = $this.closest('.filter-masonry');
			var $target = $('#'+$isotope_filter.data('target'));
			var $parent = $this.closest('li');
			var filter = $this.data('filter');

			if(filter!=null){ 
				$options.filter = filter;
			}

			if($parent.hasClass('active') || !filter){ 
				return false;
			}

			init_masonry($target, $options);

			$parent.addClass('active').siblings().removeClass('active');

			event.preventDefault();
		});
	})();

	/*----dropdown menu----*/
	(function(){
		//overide bootstrap dropdown for desktop user
		$('.no-touch').find('#header [data-toggle="dropdown"], #header .dropdown').click(function(event){
			if($window.width()>mobile_breakpoint){
				event.stopPropagation();
			}
		});

		//enable multi level dropdown menu for bootstrap3
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
		    // Avoid following the href location when clicking
		    event.preventDefault(); 

		    // Avoid having the menu to close when clicking
		    event.stopPropagation(); 
		    // If a menu is already open we close it
		    //$('ul.dropdown-menu [data-toggle=dropdown]').parent().removeClass('open');
		    // opening the one you clicked on
		    $(this).parent().addClass('open');

		    var menu = $(this).parent().find("ul");
		    var menupos = menu.offset();
		  
		    if ((menupos.left + menu.width()) + 30 > $(window).width()) {
		        var newpos = - menu.width();      
		    } else {
		        var newpos = $(this).parent().width();
		    }
		    menu.css({ left:newpos });
		});


	})();

	/*----mega menu----*/
	(function(){
		//specify max-width for mega menu to follow parent container
		//or calculated by total columns in it
		var $mega_menu = $('.mega-menu');
		var on_resize = function($el){
			var $this = $el;
			var $child_column = $this.find('.row > div');
			var cont_width = $(this).closest('.container').width();
			var menu_width = cont_width;
			var child_column_total = $child_column.length;
			var calc_cont_width = cont_width / child_column_total;
			var child_column_height = 0;

			if(calc_cont_width > 200){
				menu_width = 200 * child_column_total;
			}

			$this.css('cssText', 'max-width: ' + menu_width + 'px !important');

			if($window.width()>mobile_breakpoint){
				$child_column.each(function(){
					var $each_this = $(this);

					if($each_this.height()>=child_column_height){
						child_column_height = $each_this.height();
					}
				});
				$child_column.height(child_column_height);
			}
		}

		$mega_menu.each(function(){
			on_resize($(this))
		});

		$window.on('resize', function(){
			$mega_menu.each(function(){
				on_resize($(this))
			});
		});
	})();
	

	/*----even height-----*/
	$window.load(function(){
		var $even_height = $('.even-height');
		var temp_height = {};

		$even_height.each(function(idx){
			var $this = $(this);
			var this_rel = $this.attr('rel');
			var this_height = $this.height();

			if(typeof temp_height[this_rel] == 'undefined'){
				temp_height[this_rel] = 0;
			}

			if(this_height>temp_height[this_rel]){
				temp_height[this_rel] = this_height;
				console.log('>', temp_height[this_rel], this_height);
			}

		});

		$even_height.each(function(idx){
			var $this = $(this);
			var this_rel = $this.attr('rel');
			var this_class = $this.attr('class');

			if($window.width()<mobile_breakpoint && this_class.indexOf("col-xs") == -1){
				return;
			}

			$this.height(temp_height[this_rel]);
		});
	});

	/*----remove empty p----*/
	(function(){
		$('p:empty').remove();
		$('.even-height-alt, .even-height').siblings('br').remove();
	})();

	/*----even height alt----*/
	(function(){
		if(typeof $.fn.matchHeight === 'undefined'){ return false; }
		$('.even-height-alt').matchHeight({
          byRow: true
      });
	})();
});