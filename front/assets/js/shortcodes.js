jQuery(document).ready(function($){
	var $body = $('body');

	/*----set style----*/

	(function(){
		$('.set-style').each(function(){
			var $this = $(this);

			$this.css($this.data());
		});
	})();

	/*----section triangle----*/
	
	(function(){
		var $head = $body;
		$('.section-triangle').each(function(){
			var $this = $(this);
			var bg_color = $this.css('background-color');
			var this_class = $this.attr('class').replace(new RegExp(" ", "g"),'.');

			$head.prepend("<style>."+this_class+":before{ border-top-color:"+bg_color+"; }</style>");
			console.log('asd',this_class)
		});
	})();

	/*----image background----*/

	(function(){
		$('.bg-image').each(function(){
			var $this = $(this);
			var $options = {};

			if($this.data('bg-image')!=null){ $options['background-image'] = 'url('+$this.data('bg-image')+')'; }
			if($this.data('bg-position')!=null){ $options['background-position'] = $this.data('bg-position'); }
			if($this.data('bg-repeat')!=null){ $options['background-repeat'] = $this.data('bg-repeat'); }
			if($this.data('bg-size')!=null){ $options['background-size'] = $this.data('bg-size'); }
			if($this.data('bg-alpha')!=null){ $options['opacity'] = $this.data('bg-alpha'); }
			if($this.data('bg-attachment')!=null){ $options['background-attachment'] = $this.data('bg-attachment'); }

			$this.css($options);
		});
	})();

	/*----video background----*/

	(function(){
		var $bg_video = $('.bg-video');

		$bg_video.find('> video').attr('width','1920').attr('height','1080');
	})();

	/*----map background----*/

	(function(){
		var $bg_map = $('.bg-map');

		$bg_map.each(function(){
			var $this = $(this);
			var parent_height = $this.closest('.page-section').outerHeight();

			$this.height(parent_height);
		})
	})();

	/*----section overlay----*/

	(function(){
		$('.section-overlay').siblings('.container').css('position','relative');
	})();


	/*----widget affix----*/
	(function(){
		$('.widget-affix').each(function(){
			var $this = $(this);
			var $target = $($this.data('limit'));
			var offset = 0;

			if($target.length){
				offset = $body.height() - $target.offset().top;
			}

			offset += $this.height() + 15;

			console.log('offset', offset)

			$this.affix({
				'offset': {
					'top': 100,
					'bottom': offset
				}
			});
		});


		$('.widget-affix').on('affix.bs.affix', function () { 
			var $this = $(this);

			$this.attr('style','').css({
				'top': 100,
				'width': $(this).outerWidth() 
			});
		}).on('affix-bottom.bs.affix', function () {
			var $this = $(this);
			var this_top = $this.css('top');

			$this.css({
				'top': this_top,
				'bottom' : 'auto',
				'position': 'fixed'
			}); 
		});


	})();

	/*----magnific-popup----*/

	(function(){
		if(typeof $.fn.magnificPopup === 'undefined'){ return false; }

		var $magnific_link = $('.magnific-link');
		$magnific_link.each(function(){
			var $this = $(this);
			var $options ={
				type: ($this.data('mfp-type')!=undefined) ? $this.data('mfp-type') : 'image',
			}

			$this.magnificPopup($options);
		});

		var $magnific_gallery = $('.magnific-gallery');
		$magnific_gallery.each(function(){
			var $this = $(this);
			var $options ={
				type: ($this.data('mfp-type')!=undefined) ? $this.data('mfp-type') : 'image',
				delegate: '.magnific-item',
				gallery: {
					enabled: true
				}
			}

			$this.magnificPopup($options);
		});
	})();

	/*----flexslider----*/

	(function(){
		if(typeof $.fn.flexslider === 'undefined'){ return false; }

		$('.flexslider').each(function(){
			var $this = $(this);
			var flex_item_col = ($this.data('flex-item-col')!=null) ? $this.data('flex-item-col') : null;

			var $options = {};			
			var $data = {
				animation: $this.data('flex-anim') || 'slide',
				animationLoop: ($this.data('flex-loop')!=undefined) ? $this.data('flex-loop') : true,
				controlNav: ($this.data('flex-control-nav')!=undefined) ? $this.data('flex-control-nav') : true,
				directionNav: ($this.data('flex-direction-nav')!=undefined) ? $this.data('flex-direction-nav') : true,
				itemWidth: $this.data('flex-item-width'),
				itemMargin: $this.data('flex-item-margin'),
				minItems: $this.data('flex-min-items'),
				maxItems: $this.data('flex-max-items'),
				slideshow: $this.data('flex-slideshow'), 
			    slideshowSpeed: $this.data('flex-speed') || 5000,
			    pauseOnHover: $this.data('flex-pause-hover'),
			   	asNavFor: $this.data('flex-nav-for'),
			    sync: $this.data('flex-sync')
			}

			if(flex_item_col){
				$data.itemMargin = ($data.itemMargin!=undefined) ? $data.itemMargin : 30;
				$data.itemMargin = (flex_item_col>1) ? $data.itemMargin : 0;
				$data.itemWidth = ($this.outerWidth()-1-((flex_item_col-1)*$data.itemMargin))/flex_item_col;
			}

			if($data.itemWidth<100){
				flex_item_col = 2;
				$data.itemWidth = ($this.outerWidth()-1-((flex_item_col-1)*$data.itemMargin))/flex_item_col;
				$data.directionNav = true;
			}

			$this.find('.slides > li').css({'margin-right':$data.itemMargin});

			$.each($data, function(key, value){
				if(value!=undefined){
					if(key=='asNavFor'||key=='sync'){
						value = '#'+value;
					}
					$options[key] = value;

					if(key=='sync'){
						$options['animationLoop'] = false;
					}

					if(key=='asNavFor'){
						$this.addClass('flex-thumb-nav');
					}
				}
			});

			$this.flexslider($options);
		});

	})();

	/*----progress bar----*/

	(function(){
		$('.progress').not('.progress-anim').each(function(){
			var $this = $(this);
			var $bar = $this.find('.progress-bar');

			$bar.each(function(){
				var $each_bar = $(this);

				var bar_min = ($each_bar.attr('aria-valuemin')!=null) ? $each_bar.attr('aria-valuemin') : 0;
				var bar_max = ($each_bar.attr('aria-valuemax')!=null) ? $each_bar.attr('aria-valuemax') : 100;
				var bar_now = parseFloat($each_bar.attr('aria-valuenow'));

				bar_min = parseFloat(bar_min);
				bar_max = parseFloat(bar_max);

				var bar_total = bar_max - bar_min;
				var bar_value = bar_now - bar_min;
			
				$each_bar.css({
					visibility: '',
					width: (bar_value/bar_total*100)+'%'
				});
			});
		});

		$('.progress-anim').each(function(){
			var $this = $(this);
			var $bar = $this.find('.progress-bar');

			$bar.css({
				visibility: 'hidden',
				width: 0
			});
		});

		$('.progress-anim')
		.bind('inview', function(event, visible){
			var $this = $(this);
			var $bar = $this.find('.progress-bar');

			$bar.each(function(){
				var $each_bar = $(this);

				var bar_min = ($each_bar.attr('aria-valuemin')!=null) ? $each_bar.attr('aria-valuemin') : 0;
				var bar_max = ($each_bar.attr('aria-valuemax')!=null) ? $each_bar.attr('aria-valuemax') : 100;
				var bar_now = parseFloat($each_bar.attr('aria-valuenow'));

				bar_min = parseFloat(bar_min);
				bar_max = parseFloat(bar_max);

				var bar_total = bar_max - bar_min;
				var bar_value = bar_now - bar_min;
			
				if(visible) {
					setTimeout(function(){
						$each_bar.css({
							visibility: '',
							width: (bar_value/bar_total*100)+'%'
						});
					}, 500)
				}
			});
		});
		$('.progress-anim').trigger('inview');
	})();

	/*----progress ring----*/

	(function(){
		if(typeof $.fn.knob === 'undefined'){ return false; }

		$('.progress-ring').each(function(){
			var $this = $(this);
			var $ring = $this.find('input');
			
			if($this.data('linecap')!=null){
				$ring.data('linecap', $this.data('linecap'));
			}

			$ring.knob({
				min: ($this.data('min')!=null) ? $this.data('min') : 0,
				max: ($this.data('max')!=null) ? $this.data('max') : 100,
				step: ($this.data('step')!=null) ? $this.data('step') : 0.1,
				angleOffset: ($this.data('angle-offset')!=null) ? $this.data('angle-offset') : 0,
				angleArc: ($this.data('angle-arc')!=null) ? $this.data('angle-arc') : 360,
				stopper: ($this.data('stopper')!=null) ? $this.data('stopper') : true,
				readOnly: ($this.data('readonly')!=null) ? $this.data('readonly') : true,
				cursor: ($this.data('cursor')!=null) ? $this.data('cursor') : 0,
				thickness: ($this.data('thickness')!=null) ? $this.data('thickness') : 0.1,
				linecap: ($this.data('linecap')!=null) ? $this.data('linecap') : 'butt',
				width: ($this.data('width')!=null) ? $this.data('width') : '100%',
				displayInput: ($this.data('display-input')!=null) ? $this.data('display-input') : true,
				displayPrevious: ($this.data('display-previous')!=null) ? $this.data('display-previous') : false,
				fgColor: ($this.data('fg-color')!=null) ? $this.data('fg-color') : '#27ccc0',
				bgColor: ($this.data('bg-color')!=null) ? $this.data('bg-color') : '#eee',
				inputColor: ($this.data('input-color')!=null) ? $this.data('input-color') : '#555',
				font: ($this.data('font')!=null) ? $this.data('font') : '"Open Sans", Arial',
				fontWeight: ($this.data('font-weight')!=null) ? $this.data('font-weight') : 'bold',
			});

		});

		$('.progress-ring-anim')
		.bind('inview', function(event, visible){
			var $this = $(this);
			var $ring = $this.find('input');
			var prefix = ($this.data('prefix')!=null) ? $this.data('prefix') : '';
			var suffix = ($this.data('suffix')!=null) ? $this.data('suffix') : '';
			var ring_val = $ring.val();

			if(visible) {
				setTimeout(function(){
					$({value: 0}).animate({value: ring_val}, {
					    duration: 2000,
					    easing:'swing',
					    step: function() 
					    {
					        $ring.val(Math.floor(this.value))
					        .trigger('change')
					        .val(prefix+Math.floor(this.value)+suffix);
					    },
					    complete: function(){
					    	$ring.val(prefix+ring_val+suffix);
					    }
					});
				}, 500);
				$(this).unbind('inview');
			}
		});
		$('.progress-ring-anim').trigger('inview');
	})();

	/*----progress counter----*/

	(function(){
		if(typeof $.fn.counterUp === 'undefined'){ return false; }

		$('.progress-counter').counterUp({
			delay: 10,
			time: 3000
		});
		
	})();


	/*----google maps----*/

	(function(){
		function sg_gmap(div_id, data_attr, center){
			var mapDiv = document.getElementById(div_id);	
			var mapCenter = new google.maps.LatLng(center.lat, center.long);

			var map = new google.maps.Map(mapDiv, {
				center: mapCenter,
				zoom: data_attr.zoom,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scrollwheel: false,
			    navigationControl: false,
			    mapTypeControl: false,
			    scaleControl: false,
			    draggable: true
			});

			var image = {
				url: 'wp-content/themes/wpsg_choices/assets/images/marker.png'
			};

			var marker = new google.maps.Marker({
			    position: mapCenter,
			    icon: image,
			    animation: google.maps.Animation.DROP
			});

			setTimeout(function(){
				marker.setMap(map);
			}, 2000);
		}

		$('.gmap').each(function(index){
			var $this = $(this);
			var geocoder = new google.maps.Geocoder();
			var this_address = $this.data('address');
			var this_location = $this.data('location');
			var this_id = this.id;
			var data_attr = {
				zoom : $this.data('zoom')
			};

			if($this.data('height')!=null){
				$this.height($this.data('height'));
			}

			if(this_location != null){
				var location = this_location.split(',');
				var center = { lat: $.trim(location[0]), long: $.trim(location[1]) }

				sg_gmap(this_id, data_attr, center);
			}
			else if(this_address != null){
				geocoder.geocode({address: this_address, region: ''}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						var	location = results[0].geometry.location,
							center = { lat:location.lat(), long:location.lng() };
						
						sg_gmap(this_id, data_attr, center);
					}
				});
			}	
		});
	})();

	/*----sequence slider----*/

	(function(){

		var $sequence = new Array();

		$('.sequence-slider').each(function(idx){
			var $this = $(this);
			var this_nav = $this.data('seq-nav');
			var this_pause = $this.data('seq-pause');
			var html_append = '';

			if(this_nav!=null && this_nav!='false'){
				html_append = '<div class="sequence-nav"><a class="sequence-prev"></a> <a class="sequence-next"></a> <a class="sequence-pause"></a></div>'; }
			//append html control
			$this.append(html_append);

			var $options = {
				//General Settings
				startingFrameID: $this.data('seq-start-frame'),
				cycle: $this.data('seq-cycle') || true, 
				animateStartingFrameIn: $this.data('seq-start-frame-anim'),
				transitionThreshold: $this.data('seq-trans-threshold'), 

				//Autoplay Settings
				autoPlay: $this.data('seq-autoplay') || true,
				autoPlayDelay: $this.data('seq-delay') | 3000, 

				//Frame Skipping Settings
				navigationSkip: $this.data('seq-nav-skip'),
				navigationSkipThreshold: $this.data('seq-nav-skip-threshold'),
				preventReverseSkipping: $this.data('seq-start-frame'), 

				//Next/Prev Button Settings
				nextButton: this_nav || true, 
				prevButton: this_nav || true,

				//Pause Settings
				pauseButton: this_nav || true, //".sequence-pause"
				pauseOnHover: $this.data('seq-pause-hover') || false,
				pauseIcon: $this.data('seq-pause-icon') || false, 	//".sequence-pause-icon"

				//Pagination Settings
				pagination: $this.data('seq-pagination'), 

				//Preloader Settings
				preloader: $this.data('seq-preload'),
				preloadTheseFrames: $this.data('seq-preload-frame'),
			};

			var $temp_options = {}
			$.each($options, function(key, value){
				if(value!=undefined){
					$temp_options[key] = value;
				}
			});
			$options = $temp_options;

			try{
				$sequence[idx] = $this.sequence($options).data("sequence");
			}
			catch(err){}
		});

	})();

});
