jQuery(document).ready(function($){
	"use strict";

	$(window).load(function(){
		$('.bt-table').show();
	});

	$.fn.hasAttr = function(name) {  
	   return this.attr(name) !== undefined;
	};		
		
	$('.mega_menu').each(function(){
		if( $(window).width() > 770 ){
			var $this = $(this);
			$this.find( ' > li' ).css( 'width', $this.data('child-width')+'%' );
		}
	});

	/* NAVIGATION */
	function sticky_nav(){
		var $admin = $('#wpadminbar');
		if( $admin.length > 0 && $admin.css( 'position' ) == 'fixed' ){
			$sticky_nav.css( 'top', $admin.height() );
		}
		else{
			$sticky_nav.css( 'top', '0' );
		}
	}

	if( $('.navigation').length > 0 && $('.navigation').data('enable_sticky') == 'yes' ){
		var $navigation_bar = $('.navigation');
		var $sticky_nav = $navigation_bar.clone().addClass('sticky-nav');
		$('body').append( $sticky_nav );


		$(window).on('scroll', function(){
			sticky_nav()
			if( $(window).scrollTop() >= $navigation_bar.position().top + $navigation_bar.outerHeight(true) && $(window).width() > 769 ){
				$sticky_nav.show();
			}
			else{
				$sticky_nav.hide();
			}
		});	
		sticky_nav();
	}

	function handle_navigation(){
		if ($(window).width() >= 767) {
			$('ul.nav li.dropdown, ul.nav li.dropdown-submenu').hover(function () {
				$(this).addClass('open').find(' > .dropdown-menu').show();
			}, function () {
				$(this).removeClass('open').find(' > .dropdown-menu').hide();
	
			});
		}
		else{
			$('ul.nav li.dropdown, ul.nav li.dropdown-submenu').unbind('mouseenter mouseleave');
		}

		if ($(window).width() >= 767) {
			$('ul.nav li.mega_menu_li, ul.mega_menu').hover(function () {
				$(this).addClass('open').find(' > .mega_menu').stop(true, true).show();
			}, function () {
				$(this).removeClass('open').find(' > .mega_menu').stop(true, true).hide();
			});
		}
		else{
			$('ul.nav li.mega_menu_li, ul.mega_menu').unbind('mouseenter mouseleave');
			$('ul.nav li.mega_menu_li').click(function(){
				$(this).find('.mega_menu').slideToggle();
			});
		}

		if( $(window).width() >= 767 ){
			$('.category_mega_menu > li, .category_mega_menu_wrap').hover(function () {
				$(this).addClass('open').find(' > .category_mega_menu_wrap').stop(true, true).show();
			}, function () {
				$(this).removeClass('open').find(' > .category_mega_menu_wrap').stop(true, true).hide();
			});
		}
		else{
			$('.category_mega_menu > li, .category_mega_menu_wrap').unbind('mouseenter mouseleave');
			$('.category_mega_menu > li').click(function(){
				$(this).find('.category_mega_menu_wrap').slideToggle();
			});
		}
	}
	handle_navigation();
	
	$(document).on( 'click', 'a[data-toggle="dropdown"]',function(){
		if( $(this).attr( 'href' ).indexOf('http') > -1 ){
			window.location.href = $(this).attr('href');
		}
	});

	$(window).resize(function(){
		setTimeout(function(){
			handle_navigation();
		}, 200);
	});


	/* ADD BUTTON CLASS */
	$('input#submit').addClass('btn');

	/* SUBMIT FORMS */
	$('.form-submit').click(function(){
		$(this).parents('form').submit();
	});

	/* CATEGORIES AND LOCATIONS FILTER */
	function calculate_open_height(element){
			var $parent = $(element);
			$parent.css( 'overflow', 'visible' );
			$parent.css( 'height', 'auto' );
			var initial_height = $parent.height() + 10 ;
			var full_height = 0;
			$parent.height( initial_height );
			if( $parent.find(' > li.hidden').length == 0 ){
				full_height = initial_height;
			}
			else{
				$parent.find(' > li').each(function(){
					$(this).removeClass('hidden');
					full_height += $(this).outerHeight(true) + 10;
				});
			}
			$parent.css( 'overflow', 'hidden' );
			$parent.data('initial_height', initial_height);
			$parent.data('full_height', full_height);
	}
	if( $('.category-filter').length > 0 ){
		$('.category-filter, .brand-filter').each(function(){
			calculate_open_height(this);
		});


		$('.view-more').each(function(){
			var $this = $(this);
			var expand_text = $this.html();
			var collapse_text = $this.data('less')+'<i class="fa fa-angle-up">';
			var visible = $this.data('visible');
			var $target = $( $this.data('target') );
			if( $target.find(' > li').length > visible ){
				$this.removeClass('hidden');
				$this.click(function(e){
					e.preventDefault();
					var $this = $(this);
					
					var full_height = $target.data('full_height');
					var initial_height = $target.data('initial_height');
					var target_height;

					if( !$this.hasClass('closed') ){
						target_height = initial_height;
						$this.html( expand_text );
					}
					else{
						target_height = full_height;
						$this.html( collapse_text );
					}

					$target.animate({
						height: target_height
					},
					500,
					function(){
						$this.toggleClass('closed');
					});				
				});
			}
		});	
	}

	/* WIDGET SLIDER */
	$('.widget-slider').each(function(){
		var $this = $(this);
		var items = $this.data('visible-items');
		$this.owlCarousel({
			rtl: $('.rtl').length > 0 ? true : false,
			items: items,
			nav: false,
			dots: false,
			onInitialized: function(){
				$this.show();
				if( items >= $this.find('.owl-item').length ){
					$this.parents('.owl-parent').find('.list-left').hide();
					$this.parents('.owl-parent').find('.list-right').hide();
				}
			}
		});

	});

	/* FEATURED SLIDER */
	function start_featured_slider(){
		$('.featured-slider').owlCarousel({
			rtl: $('.rtl').length > 0 ? true : false,
			items: 1,
			nav: $('.featured-slider li').length > 1 ? true : false,
			navText: ['<i class="fa fa-angle-double-left"></i>','<i class="fa fa-angle-double-right"></i>'],
			dots: $('.featured-slider li').length > 1 ? true : false,
			onInitialize: function(){
				$('.featured-slider').hide();
				$('.featured-slider-loader').hide();
				$('.featured-slider').show();
			}
		});
	}
	start_featured_slider();

	/* PRODUCTS SLIDER */
	function start_product_sliders(){
		$('.products-slider').each(function(){
			var $this = $(this);
			var items = $this.data('visible_items');
			if( $this.parent().hasClass('active') ){
				$this.owlCarousel({
					rtl: $('.rtl').length > 0 ? true : false,
					margin: 30,
					dots: false,
					responsive:{
						0: {items : 1},
						600: {items: 2},
						900: {items: 3},
						990: {items: items},
					},
					onInitialized: function(){
						$this.show();
						if( items >= $this.find('.owl-item').length ){
							$this.parents('.owl-parent').find('.list-left').hide();
							$this.parents('.owl-parent').find('.list-right').hide();
						}
						else{
							$this.parents('.owl-parent').find('.list-left').hide();
							$this.parents('.owl-parent').find('.list-right').hide();
						}
					}					
				});
			}
		});
	}
	start_product_sliders();

	/* CATEGORIES SIDER*/
	$('.categories-slider').each(function(){
		var $this = $(this);
		var items = $this.data('visible_items');
		$this.owlCarousel({
			rtl: $('.rtl').length > 0 ? true : false,
			responsive:{
				0: {items : 1},
				600: {items: 2},
				900: {items: 3},
				990: {items: items},
			},
			margin: 0,
			onInitialized: function () {
				$this.show();
			    updateSize( $this );
				if( items >= $this.find('.owl-item').length ){
					$this.parents('.owl-parent').find('.list-left').hide();
					$this.parents('.owl-parent').find('.list-right').hide();
				}
			},
			onResized:function(){
			    updateSize( $this );
			}			
		});
	});
	function updateSize( $this ){
		var height = 0;
		$this.find('.category-item').css( 'height', 'auto');
		$this.find('.owl-item').each(function(){
	        var thisHeight = parseInt( $(this).css('height') );
	        height = height <= thisHeight ? thisHeight : height;
		});
	    $this.find('.category-item').css( 'height', height + 'px');
	    $this.find('.owl-stage-outer').css( 'height', height + 'px');
	}	

	/* BLOGS SLIDER */
	$('.blogs-slider').each(function(){
		var $this = $(this);
		var items = $this.data('visible_items');
		$this.owlCarousel({
			rtl: $('.rtl').length > 0 ? true : false,
			margin: 30,
			dots: false,
			responsive:{
				0: {items : 1},
				600: {items: 2},
				900: {items: items},
			},
			onInitialized: function () {
				$this.show();
				if( items >= $this.find('.owl-item').length ){
					$this.parents('.owl-parent').find('.list-left').hide();
					$this.parents('.owl-parent').find('.list-right').hide();
				}
			},
		})
	});

	/* SIMILAR PRODUCTS SLIDER */
	$('.similar-slider').each(function(){
		var $this = $(this);
		var items = $this.data('visible_items');
		$this.owlCarousel({
			rtl: $('.rtl').length > 0 ? true : false,
			margin: 30,
			dots: false,
			responsive:{
				0: {items : 1},
				600: {items: 2},
				900: {items: 3},
				990: {items: items},
			},
			onInitialized: function () {
				$this.show();
				if( items >= $this.find('.owl-item').length ){
					$this.parents('.owl-parent').find('.list-left').hide();
					$this.parents('.owl-parent').find('.list-right').hide();
				}
			},			
		});
	});	

	/* POST SLIDER */
	$('.post-slider').each(function(){
		var $this = $(this);
		$this.owlCarousel({
			rtl: $('.rtl').length > 0 ? true : false,
			items: 1,
			onInitialized: function () {
				$this.show();
			}
		});		
	});

	/* submit form */
	$('.submit-form').click(function(){
		$(this).parents('form').submit();
	});

	/* SEND CONTACT */
	$('.submit-form-contact').click(function(e){
		e.preventDefault();
		var $this = $(this);
		var initial_text = $this.html();
		$this.html( '<i class="fa fa-spin fa-spinner"></i>' );
		$.ajax({
			url: ajaxurl,
			method: "POST",
			data: $(this).parents('form').serialize(),
			dataType: "JSON",
			success: function( response ){
				if( !response.error ){
					$('.send_result').html( '<div class="alert alert-success" role="alert"><span class="fa fa-check-circle"></span> '+response.success+'</div>' );
				}
				else{
					$('.send_result').html( '<div class="alert alert-danger" role="alert"><span class="fa fa-times-circle"></span> '+response.error+'</div>' );				
				}
			},
			complete: function(){
				$this.html( initial_text );
			}
		})
	});

	/* CONTACT MAP */
	if( $('#map').length > 0 ){
		var markers = [];
		$('.contact_map_marker').each(function(){
			var temp = $(this).val().split(',');
			markers.push({
				longitude: temp[0].trim(),
				latitude: temp[1].trim()
			})
		});
		var markersArray = [];
		var bounds = new google.maps.LatLngBounds();
		var mapOptions = { 
			scrollwheel: $('.contact_map_scroll_zoom').length > 0 ? false: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP 
		};
		var map =  new google.maps.Map(document.getElementById("map"), mapOptions);
		var location;
		if( markers.length > 0 ){
			for( var i=0; i<markers.length; i++ ){
				location = new google.maps.LatLng( markers[i].longitude, markers[i].latitude );
				bounds.extend( location );

				var marker = new google.maps.Marker({
				    position: location,
				    map: map,
				});				
			}

			map.fitBounds( bounds );
			
		}
	}	


	/* EQUAL WIDGET HEIGHT FOR THE MEGAMENU */
	function is_ie(){

	        var ua = window.navigator.userAgent;
	        var msie = ua.indexOf("MSIE ");

	        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)){
	            return true;
	        }
	        else{
	            return false;
	        }
	}

	if( is_ie() && $(window).width() > 770 ){
		$(window).load(function(){
			$('.mega_menu').width( $('.navigation .pull-right').width() );
		});
	}

	function calculate_category_mega_menu(){
		var width = $('.search_bar form').width();
		$('.category_mega_menu_wrap').each(function(){
			$(this).outerWidth( width );
		});
	}
	calculate_category_mega_menu();

	$(window).resize(function(){
		calculate_category_mega_menu();
	});

	/* SUBSCRIBE */
    $('.subscribe').click(function() {
        var $this = $(this);
        var $parent = $this.parent().parent();
        $.ajax({
            url: ajaxurl,
            data: {
                action: 'subscribe',
                email: $parent.find('input').val(),
            },
            method: "POST",
            dataType: "JSON",
            success: function(response) {
                if (!response.error) {
                    $parent.find('.subscribe-result').after('<div class="alert alert-success">' + response.success + '</div>');
                } else {
                    $parent.find('.subscribe-result').after('<div class="alert alert-danger">' + response.error + '</div>');
                }
            }
        });
    });	

	
	$(document).on( 'click', 'a[data-toggle="dropdown"]',function(){
		if( $(this).attr( 'href' ).indexOf('http') > -1 ){
			window.location.href = $(this).attr('href');
		}
	});

	$(window).resize(function(){
		setTimeout(function(){
			handle_navigation();
		}, 200);
	});    

    /* INITIATE OWL ON TAB CHANGE */
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		start_product_sliders();
	});

	$('.list-left').click(function(){
		var $owl = $(this).parents('.owl-parent').find('.owl-carousel:visible');
		$owl.trigger('prev.owl.carousel');
	});

	$('.list-right').click(function(){
		var $owl = $(this).parents('.owl-parent').find('.owl-carousel:visible');
		$owl.trigger('next.owl.carousel');
	});	

	/* RATINGS */
	$('.comment-review .fa').hover(
		function(){
			var pos = $(this).index();
			var $parent = $(this).parents('.bottom-ratings');
			for( var i=0; i<=pos; i++ ){
				$parent.find('.fa:eq('+i+')').removeClass('fa-star-o').addClass('fa-star');
			}
		},
		function(){
			$(this).parents('.bottom-ratings').find('.fa').each(function(){
				if( !$(this).hasClass('clicked') ){
					$(this).removeClass('fa-star').addClass('fa-star-o');
				}
			});
		}
	);

	$('.comment-review .fa').click(function(){
		var value = $(this).index();
		var $parent = $(this).parents('.bottom-ratings');
		$('#review').val( value + 1 );
		$parent.find('.fa').removeClass('clicked');
		for( var i=0; i<=value; i++ ){
			$parent.find('.fa:eq('+i+')').removeClass('fa-star-o').addClass('fa-star').addClass('clicked');
		}
	});	

	/* AJAX SEARCH */
	function do_ajax_search( $form, hard_reset ){
		$.ajax({
			url: $form.attr('action'),
			data: hard_reset ? {} : $form.serialize(),
			success: function( response ){
				$('.ajax-container').html( $(response).find('.ajax-container').html() );
				$('.category-filter').html( $(response).find('.category-filter').html() );
				$('.breadcrumbs').html( $(response).find('.breadcrumbs').html() );
				calculate_open_height('.category-filter');
				if( !$('a[data-target=".category-filter"]' ).hasClass('closed') ){
					$('.category-filter').height( $('.category-filter').data('full_height') );
				}
				start_featured_slider();
			},
			complete: function(){
				$('.search-overlay').hide();
			}
		});
	}
	if( $('.search-filter').length > 0 ){
		var $form = $('.search-filter');
		$form.submit(function(e){
			e.preventDefault();
		});

		$form.on( 'change', 'input[type="checkbox"]', function(){
			$('.search-overlay.sidebar').show();
			do_ajax_search($form);
		});

		$form.on( 'change', 'select', function(){
			$('.search-overlay:not(.sidebar)').show();
			do_ajax_search($form);
		});		

		$form.on('keydown', 'input[type="text"]', function(event){
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if( keycode == 13 ){
				$('.search-overlay.sidebar').show();
				do_ajax_search($form);
			}
		});

		$form.on('click', '.view', function(){
			if( $('.no-results').length > 0 ){
				$('.search-overlay:not(.sidebar)').addClass('sidebar').show();
			}
			else{
				$('.search-overlay:not(.sidebar)').show();
			}			
			$('#product-view').val( $(this).attr('data-value') );
			do_ajax_search($form);
		});
	}

	$(document).on( 'click', '.reset_filter', function(){
		var $form = $('.search-filter');
		$form.find('input[type="text"]').val('');
		$form.find('input[type="checkbox"]').prop('checked', false);
		$('input[type="checkbox"]').removeAttr('checked');
		$form.find('select').val($form.find('select option:first').val());
		$form.trigger("reset");
		$('.search-overlay.sidebar').show();
		do_ajax_search( $form, true );
	});

	$(document).on('click', '.page-template-page-tpl_search .pagination a', function(e){
		if( $('.no-results').length > 0 ){
			$('.search-overlay:not(.sidebar)').addClass('sidebar').show();
		}
		else{
			$('.search-overlay:not(.sidebar)').show();
		}		
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			success: function( response ){
				$('.ajax-container').html( $(response).find('.ajax-container').html() );
				$('.category-filter').html( $(response).find('.category-filter').html() );
				calculate_open_height('.category-filter');
				if( !$('a[data-target=".category-filter"]' ).hasClass('closed') ){
					$('.category-filter').height($('.category-filter').data('full_height'));
				}
				start_featured_slider();				
			}
		});
	});

	if( $('.single-product').length > 0 && window.location.href.indexOf( '?' ) == -1 ){
		$.ajax({
			url: ajaxurl,
			method: 'POST',
			data: {
				action: 'register_click',
				post_id: $('.post-id').val()
			}
		});
	}


	/* PAYMENTS */
	$('.register-store, .contact-form').append('<input type="hidden" name="captcha" value="1"> ');

	/* submit store */
	$('.submit-form-store').click(function(e){
		e.preventDefault();
		var $this = $(this);
		var initial_text = $this.html();
		$this.html( '<i class="fa fa-spin fa-spinner"></i>' );
		$.ajax({
			url: ajaxurl,
			method: "POST",
			data: $(this).parents('form').serialize(),
			dataType: "JSON",
			success: function( response ){
				if( response.success ){
					$('.send_result').html( '<div class="alert alert-success" role="alert"><span class="fa fa-times-circle"></span> '+response.success+'</div>' )
				}
				else if( response.info ){
					$('.send_result').html( '<div class="alert alert-info" role="alert"><span class="fa fa-check-circle"></span> '+response.info+'</div>' )
					if( response.payments ){
						$('.payments').html( response.payments ).show();
						initiate_stripe();
					}					
				}
				else{
					$('input').removeClass('input-error');
					if( response.fields ){
						for( var i=0; i < response.fields.length; i++ ){
							$('input[name="'+response.fields[i]+'"]').addClass('input-error');
						}
					}
					$('.send_result').html( '<div class="alert alert-danger" role="alert"><span class="fa fa-times-circle"></span> '+response.error+'</div>' )
				}
			},
			complete: function(){
				$this.html( initial_text );
			}
		})
	});

	/* pay with stripe */
	function initiate_stripe(){
		if( $('.stripe-payment').length > 0 ){
			var store_id;
			var handler = StripeCheckout.configure({
			    key: $('.stripe-payment').attr('data-pk'),
			    token: function(token) {
					$('.send_result').html( '<div class="alert alert-info">'+$('.stripe-payment').data('genearting_string')+'</div>' )
			    	
					$.ajax({
						url: ajaxurl,
						method: 'POST',
						data: {
							action: 'pay_with_stripe',
							token: token,
							store_id: store_id,
						},
						success: function( response ){
							if( response.indexOf('stripe-complete') > -1 ){
								$('.register-store').hide();
								$('.payments').html('').show();
								$('.send_result').html( response );
							}
							else{
								$('.send_result').html( response );
							}
						}
					});
			    }
			});		
			$(document).on( 'click', '.stripe-payment', function(e){
				e.preventDefault();
				handler.open({
					name: $(this).attr('data-name'),
					description: $(this).attr('data-description'),
					amount: $(this).attr('data-amount'),
					currency: $(this).attr('data-currency')
				});
				store_id = $(this).attr('data-store_id');
			});	
			// Close Checkout on page navigation
			$(window).on('popstate', function() {
				handler.close();
			});		
		}
	}

	/* payment with skrill */
	$(document).on( 'click', '.skrill-payment', function(){
		$('.skrill-form').submit();
	});	

	if( window.location.hash.indexOf( 'comment' ) > -1 ){
		$('a[href="#reviews"]').click();
	}

	/* pay with ideal */
	$(document).on( 'click', '.submit-ideal-payment', function(){
		$.ajax({
			url: ajaxurl,
			method: 'POST',
			data: $('.ideal-payment').serialize(),
			success: function( response ){
				if( response.indexOf( 'http' ) > -1 ){
					window.location.href = response;
				}
				else{
					$('.send_result').html( response );
				}
			}
		})
	});

	$('[data-toggle="tooltip"]').tooltip()


	/* TOGGLE CATEGORIES */
	var $admin = $('#wpadminbar');
	function slides(){
		if( $admin.length > 0 && $admin.css( 'position' ) == 'fixed' && $(window).width() < 768 ){
			$('.toggle-categories').css( 'top', $admin.height() + 20 );
			$('.toggle-navigation').css( 'top', $admin.height() + 20 );
			$('.navigation .navbar').css( 'top', $admin.height() );
			$('.toggle-categories').next().css( 'top', $admin.height() );
		}
		else if( $admin.length > 0 && $admin.css( 'position' ) == 'absolute' && $(window).width() < 768 && $(window).scrollTop() == 0 ){
			$('.toggle-categories').css( 'top', $admin.height() + 20 );
			$('.toggle-navigation').css( 'top', $admin.height() + 20 );
			$('.navigation .navbar').css( 'top', $admin.height() );
			$('.toggle-categories').next().css( 'top', $admin.height() );
		}
		else{
			$('.toggle-categories').css( 'top', 20 );
			$('.toggle-navigation').css( 'top', 20 );
			$('.navigation .navbar').css( 'top', 0 );
			$('.toggle-categories').next().css( 'top', 0 );		
		}		
	}
	slides();
	$(window).scroll(function(){
		slides();
	});

	$('.toggle-categories').click(function(){
		$(this).next().addClass('always-open');
		$(this).toggleClass('categories-toggle-slide')
		$(this).next().toggleClass('categories-slide');

		$('.toggle-navigation').toggleClass('hide');
		$('.toggle-navigation').removeClass('navigation-slide-toggle');
		$('.navigation .navbar').removeClass( 'navigation-slide' );		
	});

	/* TOGGLE NAVIGATION */
	$('.toggle-navigation').click(function(){
		$(this).toggleClass('navigation-slide-toggle');
		$('.navigation .navbar').toggleClass( 'navigation-slide' );

		$('.toggle-categories').toggleClass('hide');
		$('.toggle-categories').removeClass('categories-toggle-slide')
		$('.toggle-categories').next().removeClass('categories-slide');
	});

	/* FILTER TOGGLE */
	$('.filter-collapse').click(function(){
		$(this).find( 'i' ).toggleClass( 'fa-angle-up fa-angle-down' );
		$('.filter-wrap').slideToggle();
	});

    /* MAGNIFIC POPUP FOR THE GALLERY */
    $('.gallery').each(function(){
        var $this = $(this);
        $this.magnificPopup({
            type:'image',
            delegate: 'a',
            gallery:{enabled:true},
        });
    });	
});