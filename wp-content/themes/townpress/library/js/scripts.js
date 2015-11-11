/* -----------------------------------------------------------------------------

	TABLE OF CONTENTS

	1.) General
	2.) Components
	3.) Header
	4.) Core
	5.) Widgets
	6.) Sidebar
	7.) Other
	8.) Style Switcher

----------------------------------------------------------------------------- */

(function($){ "use strict";
$(document).ready(function(){

/* -----------------------------------------------------------------------------

	1.) GENERAL

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		CHECK FOR TOUCH DISPLAY
	------------------------------------------------------------------------- */

	$( 'body' ).one( 'touchstart', function(){
		$(this).addClass( 'm-touch' );
	});

	/* -------------------------------------------------------------------------
		INIT PAGE
	------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrInitPage ) {
		$.fn.lsvrInitPage = function( element ){

			var $element = $( element );

			// FLUID MEDIA
			if ( $.fn.lsvrFluidEmbedMedia ){
				$element.lsvrFluidEmbedMedia();
			}

			// LIGHTBOXES
			if ( $.fn.lsvrInitLightboxes ) {
				$element.lsvrInitLightboxes();
			}

			// LOAD HIRES IMAGES FOR HiDPI SCREENS
			if ( $.fn.lsvrLoadHiresImages ) {
				$element.lsvrLoadHiresImages();
			}

		};
	}
	$.fn.lsvrInitPage( 'body' );

	/* -------------------------------------------------------------------------
		MEDIA QUERY BREAKPOINT
	------------------------------------------------------------------------- */

	var mediaQueryBreakpoint;
	if ( $.fn.lsvrGetMediaQueryBreakpoint ) {
		mediaQueryBreakpoint = $.fn.lsvrGetMediaQueryBreakpoint();
		$( document ).on( 'screenTransition', function(){
			mediaQueryBreakpoint = $.fn.lsvrGetMediaQueryBreakpoint();
		});
	}
	else {
		mediaQueryBreakpoint = $(window).width();
	}


/* -----------------------------------------------------------------------------

	2.) COMPONENTS

----------------------------------------------------------------------------- */

	if ( ! $.fn.lsvrInitComponents ) {
		$.fn.lsvrInitComponents = function( element ){

			var $element = $( element );

			/* -------------------------------------------------------------------------
				ACCORDION
			------------------------------------------------------------------------- */

			if ( $.fn.lsvrAccordion ) {
				$element.find( '.c-accordion' ).each(function(){
					$(this).lsvrAccordion();
				});
			}

			/* -------------------------------------------------------------------------
				ALERT MESSAGE
			------------------------------------------------------------------------- */

			if ( $.fn.lsvrAlertMessage ) {
				$element.find( '.c-alert-message' ).each(function(){
					$(this).lsvrAlertMessage();
				});
			}

			/* -------------------------------------------------------------------------
				GALLERY
			------------------------------------------------------------------------- */

			if ( $.fn.masonry && $.fn.lsvrImagesLoaded ) {
				$( '.c-gallery .gallery-images.m-layout-masonry' ).each(function(){
					var $this = $(this);
					$this.lsvrImagesLoaded(function(){
						$this.masonry();
						$this.removeClass( 'm-loading' );
					});
				});
			}
			else {
				$( '.c-gallery .gallery-images.m-layout-masonry.m-loading' ).each(function(){
					$(this).removeClass( 'm-loading' );
				});
			}

			/* -------------------------------------------------------------------------
				GOOGLE MAP
			------------------------------------------------------------------------- */

			if ( $.fn.lsvrLoadGoogleMaps && $element.find( '.gmap-canvas' ).length > 0 ) {
				$.fn.lsvrLoadGoogleMaps();
			}

			/* -------------------------------------------------------------------------
				PROGRESS BAR
			------------------------------------------------------------------------- */

			if ( $.fn.lsvrProgressBar ) {
				$element.find( '.c-progress-bar' ).each(function(){
					$(this).lsvrProgressBar();
				});
			}

			/* -------------------------------------------------------------------------
				SLIDER
			------------------------------------------------------------------------- */

			if ( $.fn.lsvrSlider ) {
				$element.find( '.c-slider' ).each(function(){
					$(this).lsvrSlider();
				});
			}

			/* -------------------------------------------------------------------------
				TABS
			------------------------------------------------------------------------- */

			if ( $.fn.lsvrTabs ) {
				$element.find( '.c-tabs' ).each(function(){
					$(this).lsvrTabs();
				});
			}

		};
	}
	$.fn.lsvrInitComponents( 'body' );


/* -----------------------------------------------------------------------------

	3.) HEADER

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		GMAP SWITCHER
	------------------------------------------------------------------------- */

	$( '.header-gmap-switcher' ).each(function(){

		var $this = $(this);
		$this.click(function(){

			// OPEN MAP
			if ( ! $this.hasClass( 'm-active' ) ) {

				$( '.header-gmap-switcher' ).addClass( 'm-active' );
				$( 'body' ).addClass( 'm-header-map-active' );
				$.event.trigger({
					type: 'headerMapOpened',
					message: 'Header map opened.',
					time: new Date()
				});

				// HIDE LOGO ON MOBILE
				if ( mediaQueryBreakpoint <= 991 ) {
					$( '.header-branding' ).slideUp(300);
				}

			}

			// CLOSE MAP
			else {

				$( '.header-gmap-switcher' ).removeClass( 'm-active' );
				$( 'body' ).removeClass( 'm-header-map-active' );
				$.event.trigger({
					type: 'headerMapClosed',
					message: 'Header map closed.',
					time: new Date()
				});

				// SHOW LOGO ON MOBILE
				if ( mediaQueryBreakpoint <= 991 ) {
					$( '.header-branding' ).slideDown(300);
				}

			}

		});

		// RESET ON SCREEN TRANSITION
		$( document ).on( 'screenTransition', function(){
			$( '.header-gmap-switcher' ).removeClass( 'm-active' );
			$( 'body' ).removeClass( 'm-header-map-active' );
			$( '.header-branding' ).removeAttr( 'style' );
		});

	});

	/* -------------------------------------------------------------------------
		IMAGE SLIDESHOW
	------------------------------------------------------------------------- */

	$( '.header-image' ).each(function(){
		if ( mediaQueryBreakpoint > 991 && $.timer && $(this).data( 'autoplay' ) && $(this).find( '.image-layer' ).length > 1 ) {

			var $this = $(this),
				layers = $this.find( '.image-layer' ),
				interval = parseInt( $this.data( 'autoplay' ) ),
				timer;

			layers.filter( ':eq(0)' ).addClass( 'm-active' );
			layers.filter( ':eq(1)' ).addClass( 'm-next' );

			interval = interval < 1 ? 0 : interval * 1000;

			if ( interval > 0 ) {

				// START SLIDESHOW
				timer = $.timer( interval, function(){
					layers.filter( '.m-active' ).fadeOut( 900, function(){
						$(this).removeClass( 'm-active' ).css( 'display', '' );
						layers.filter( '.m-next' ).addClass( 'm-active' ).removeClass( 'm-next' );
						if ( layers.filter( '.m-active' ).is( ':last-child' ) ) {
							layers.filter( ':eq(0)' ).addClass( 'm-next' );
						}
						else {
							layers.filter( '.m-active' ).next().addClass( 'm-next' );
						}
					});
				});

				// PAUSE WHEN MAP IS OPENED
				$( document ).on( 'headerMapOpened', function(){
					timer.pause();
				});

				// RESUME WHEN MAP IS CLOSED
				$( document ).on( 'headerMapClosed', function(){
					timer.resume();
				});

			}

		}
	});

	/* -------------------------------------------------------------------------
		HEADER TOGGLE
	------------------------------------------------------------------------- */

	$( '.header-toggle' ).each(function(){

		var $this = $(this);
		$this.click( function(){

			// HIDE
			if ( $( '.header-tools' ).is( ':visible') ) {
				$this.removeClass( 'm-active' );
				$( '.header-menu, .header-tools' ).slideUp(300);
			}
			// SHOW
			else {
				$this.addClass( 'm-active' );
				$( '.header-menu, .header-tools' ).slideDown(300);
			}

		});

		// RESET ON SCREEN TRANSITION
		$( document ).on( 'screenTransition', function(){
			$this.removeClass( 'm-active' );
			$( '.header-menu, .header-tools' ).removeAttr( 'style' );
		});

	});

	/* -------------------------------------------------------------------------
		HEADER MENU
	------------------------------------------------------------------------- */

	$( '.header-menu ul > li:last-child' ).prev().addClass( 'm-penultimate' );
	$( '.header-menu ul > li:last-child' ).addClass( 'm-last' );

	if ( ! $.fn.lsvrHeaderMenuSubmenu ) {
		$.fn.lsvrHeaderMenuSubmenu = function(){

			var	$this = $(this),
				$parent = $this.parent();

			$parent.addClass( 'm-has-submenu' );

			// HOVER
			$parent.hover(function(){
				if ( mediaQueryBreakpoint > 991 && ! $( 'body' ).hasClass( 'm-touch' ) ) {
					$parent.addClass( 'm-hover' );
					$this.show().addClass( 'animated fadeInDown' );
				}
			}, function(){
				if ( mediaQueryBreakpoint > 991 && ! $( 'body' ).hasClass( 'm-touch' ) ) {
					$parent.removeClass( 'm-hover' );
					$this.hide().removeClass( 'animated fadeInDown' );
				}
			});

			// CLICK ON TOUCH DISPLAY
			$parent.find( '> a' ).click(function(){
				if ( mediaQueryBreakpoint > 991 && ! $parent.hasClass( 'm-hover' ) ) {

					if ( $(this).parents( 'ul' ).length < 2 ) {
						$( '.header-menu li.m-hover' ).each(function(){
							$(this).removeClass( 'm-hover' );
							$(this).find( '> ul' ).hide();
						});
					}

					$parent.addClass( 'm-hover' );
					$this.show().addClass( 'animated fadeInDown' );

					$( 'html' ).on( 'touchstart', function(e) {
						$parent.removeClass( 'm-hover' );
						$this.hide().removeClass( 'animated fadeInDown' );
					});

					$parent.on( 'touchstart' ,function(e) {
						e.stopPropagation();
					});

					return false;

				}
			});

			// CREATE TOGGLES
			if ( $parent.find( '> .toggle' ).length < 1 ) {
				$parent.append( '<button class="submenu-toggle" type="button"><i class="fa"></i></button>' );
			}
			var $toggle = $parent.find( '> .submenu-toggle' );

			// TOGGLE
			$toggle.click( function(){

				// close
				if ( $(this).hasClass( 'm-active' ) ) {
					$toggle.removeClass( 'm-active' );
					$this.slideUp( 300 );
				}

				// open
				else {

					// deactivate others
					if ( $(this).parents( 'ul' ).length < 2 ) {
						$( '.header-menu nav > ul > li > .submenu-toggle.m-active' ).each(function(){
							$(this).removeClass( 'm-active' );
							$(this).parent().find( '> ul' ).slideUp( 300 );
						});
					}

					// activate this
					$toggle.addClass( 'm-active' );
					$this.slideDown( 300 );

				}

			});

			// HIDE ON SCREEN TRANSITION
			$( document ).on( 'screenTransition', function(){
				$toggle.removeClass( 'm-active' );
				$this.removeAttr( 'style' );
			});

		};

		$( '.header-menu ul > li > ul' ).each(function(){
			if ( ! $(this).is( ':visible' ) ) {
				$(this).lsvrHeaderMenuSubmenu();
			}
		});

	}



/*
	// SUB MENU
	if ( ! $.fn.lsvrSideMenuSubmenu ) {
		$.fn.lsvrSideMenuSubmenu = function(){

			var	$this = $(this),
				$parent = $this.parent();

			$parent.addClass( 'm-has-submenu' );

			// HOVER
			$parent.hover(function(){
				if ( mediaQueryBreakpoint > 991 && ! $( 'body' ).hasClass( 'm-touch' ) ) {
					$parent.addClass( 'm-hover' );
					$this.show().addClass( 'animated fadeInDown' );
				}
			}, function(){
				if ( mediaQueryBreakpoint > 991 && ! $( 'body' ).hasClass( 'm-touch' ) ) {
					$parent.removeClass( 'm-hover' );
					$this.hide().removeClass( 'animated fadeInDown' );
				}
			});

			// CLICK ON TOUCH DISPLAY
			$parent.find( '> a' ).click(function(){
				if ( mediaQueryBreakpoint > 991 && ! $parent.hasClass( 'm-hover' ) ) {

					if ( $(this).parents( 'ul' ).length < 2 ) {
						$( '.side-menu li.m-hover' ).each(function(){
							$(this).removeClass( 'm-hover' );
							$(this).find( '> ul' ).hide();
						});
					}

					$parent.addClass( 'm-hover' );
					$this.show().addClass( 'animated fadeInDown' );

					$( 'html' ).on( 'touchstart', function(e) {
						$parent.removeClass( 'm-hover' );
						$this.hide().removeClass( 'animated fadeInDown' );
					});

					$parent.on( 'touchstart' ,function(e) {
						e.stopPropagation();
					});

					return false;

				}
			});

		};

		$( '.side-menu ul > li > ul' ).each(function(){
			if ( ! $(this).parent().is( '.current-menu-ancestor, .current_page_ancestor, .current_page_parent, .current_page_item, .current-menu-item' ) ) {
				$(this).lsvrSideMenuSubmenu();
			}
		});

	}
	*/


/* -----------------------------------------------------------------------------

	4.) CORE

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		ARTICLE COMMENTS
	------------------------------------------------------------------------- */

	$( '#commentform' ).each(function(){

		var $form = $(this);
		$form.addClass( 'default-form' );

		// VALIDATE
		if ( $.fn.lsvrIsFormValid ) {
			$form.find( '.required' ).addClass( 'm-required' );
			$form.find( '.email' ).addClass( 'm-email' );
			$form.submit(function(){
				if ( ! $form.lsvrIsFormValid() ) {
					$form.find( '.m-validation-error' ).slideDown( 300 );
					return false;
				}
			});
		}

		// EDIT SUBMIT BTN
		$form.find( '#submit' ).addClass( 'c-button' );

	});


/* -----------------------------------------------------------------------------

	5.) WIDGETS

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		LSVR LOCALE INFO
	------------------------------------------------------------------------- */

	// WEATHER
	var lsvrWeatherIcons = { i01d: 'tp tp-sun', i01n: 'tp tp-sun'/* moon */, i02d: 'tp tp-cloud-sun', i02n: 'tp tp-cloud', i03d: 'tp tp-cloud', i03n: 'tp tp-cloud',
		i04d: 'tp tp-cloud', i04n: 'tp tp-cloud', i09d: 'tp tp-cloud-rain', i09n: 'tp tp-cloud-rain', i10d: 'tp tp-cloud-rain', i10n: 'tp tp-cloud-rain',
		i11d: 'tp tp-cloud-lightning', i11n: 'tp tp-cloud-lightning', i13d: 'tp tp-cloud-snow', i13n: 'tp tp-cloud-snow', i50d: 'tp tp-cloud-fog', i50n: 'tp tp-cloud-fog' };

	$( '.widget.lsvr-locale-info .local-weather-holder' ).each(function(){

		var $this = $(this),
			data = { action: 'lsvr_local_weather' },
			type = $this.data( 'type' ) ? $this.data( 'type' ) : 'current',
			unitsFormat = $this.data( 'units-format' ) ? $this.data( 'units-format' ) : 'metric',
			forecastIndex = $this.attr( 'data-forecast-index' ) ? parseInt( $this.data( 'forecast-index' ) ) : false,
			parent = $this.parents( 'li.m-loading' ).first(),
			json, json_main, json_wind, json_weather, wind_speed = '', temperature = '', icon = '';

		// determine weather type, either current or forecast
		data.weather_type = type === 'forecast' ? 'forecast' : 'current';

		// request json
		$.post( lsvrMainScripts.ajaxurl, data, function( response ) {

			// proceed to parse
			if ( response !== 'error' ) {

				json = JSON.parse( response );

				// FORECAST
				if ( type === 'forecast' && 'list' in json ) {

					// save response location name
					if ( 'city' in json && 'name' in json.city ) {
						$this.attr( 'data-location-response', json.city.name );
					}

					// resave json
					if ( forecastIndex ) {
						json = json.list[forecastIndex];
					}
					else {
						json = json.list[0];
					}

					// temperature
					if ( 'temp' in json && 'day' in json.temp ) {
						temperature = json.temp.day;
						temperature = String( Math.round( temperature ) );
						temperature += unitsFormat === 'imperial' ? '&deg;F' : '&deg;C';
					}

					// wind data
					if ( 'speed' in json ) {
						wind_speed = Math.floor( json.speed );
						wind_speed += 'm/s';
					}

					// ico data
					if ( 'weather' in json ) {
						json_weather = json.weather;

						if ( $.isArray( json_weather ) ) {
							json_weather = json_weather[0];
						}

						// get ico id
						if ( ( 'icon' in json_weather ) && ( 'i' + json_weather.icon in lsvrWeatherIcons ) ) {
							icon = lsvrWeatherIcons[ 'i' + json_weather.icon ];
						}

					}

				}
				// CURRENT
				else {

					// save response location name
					if ( 'name' in json ) {
						$this.attr( 'data-location-response', json.name );
					}

					// main data
					if ( 'main' in json ) {

						json_main = json.main;

						// temperature
						if ( 'temp' in json_main ) {
							temperature = json_main.temp;
							temperature = String( Math.round( temperature ) );
							temperature += unitsFormat === 'imperial' ? '&deg;F' : '&deg;C';
						}

					}

					// wind data
					if ( 'wind' in json ) {
						json_wind = json.wind;

						// get wind speed
						if ( 'speed' in json_wind ) {
							wind_speed = Math.floor( json_wind.speed );
							wind_speed += 'm/s';
						}

					}

					// ico data
					if ( 'weather' in json ) {
						json_weather = json.weather;

						if ( $.isArray( json_weather ) ) {
							json_weather = json_weather[0];
						}

						// get ico id
						if ( ( 'icon' in json_weather ) && ( 'i' + json_weather.icon in lsvrWeatherIcons ) ) {
							icon = lsvrWeatherIcons[ 'i' + json_weather.icon ];
						}

					}

				}

				// generate output
				if ( icon !== '' ) {
					$this.find( '.local-icon' ).addClass( icon );
				}
				if ( wind_speed !== '' ) {
					$this.find( '.local-wind-speed' ).html( wind_speed );
				}
				if ( temperature !== '' ) {
					$this.find( '.local-temperature' ).html( temperature );
					parent.find( '.fa-spinner' ).fadeOut( 150, function(){
						parent.find( '.row-title, .row-value' ).fadeIn( 500, function(){
							parent.removeClass( 'm-loading' );
						});
						$(this).remove();
					});
				}
				else {
					parent.slideUp( 300 );
				}

				// if message
				if ( 'message' in json ) {
					$this.attr( 'data-response-message', json.message );
				}

			}

			// hide on error
			else {

				parent.slideUp( 300 );

			}
		});

	});

	/* -------------------------------------------------------------------------
		SUBSCRIBE WIDGET
	------------------------------------------------------------------------- */

	if ( $.fn.lsvrMailchimpSubscribeForm ) {
		$( '.widget.lsvr-mailchimp-subscribe' ).each(function(){
			$(this).lsvrMailchimpSubscribeForm();
		});
	}



/* -----------------------------------------------------------------------------

	6.) SIDEBAR

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		SIDE MENU
	------------------------------------------------------------------------- */

	// FIX ANCESTRY
	$( '.side-menu a[title*="lsvr"]' ).each(function(){
		$(this).removeAttr();
	});
	$( '.current-menu-item, .current_page_item' ).each(function(){
		$(this).parents( 'li' ).addClass( 'current-menu-ancestor' );
	});

	// SUB MENU
	if ( ! $.fn.lsvrSideMenuSubmenu ) {
		$.fn.lsvrSideMenuSubmenu = function(){

			var	$this = $(this),
				$parent = $this.parent();

			$parent.addClass( 'm-has-submenu' );

			// HOVER
			$parent.hover(function(){
				if ( mediaQueryBreakpoint > 991 && ! $( 'body' ).hasClass( 'm-touch' ) ) {
					$parent.addClass( 'm-hover' );
					$this.show().addClass( 'animated fadeInDown' );
				}
			}, function(){
				if ( mediaQueryBreakpoint > 991 && ! $( 'body' ).hasClass( 'm-touch' ) ) {
					$parent.removeClass( 'm-hover' );
					$this.hide().removeClass( 'animated fadeInDown' );
				}
			});

			// CLICK ON TOUCH DISPLAY
			$parent.find( '> a' ).click(function(){
				if ( mediaQueryBreakpoint > 991 && ! $parent.hasClass( 'm-hover' ) ) {

					if ( $(this).parents( 'ul' ).length < 2 ) {
						$( '.side-menu li.m-hover' ).each(function(){
							$(this).removeClass( 'm-hover' );
							$(this).find( '> ul' ).hide();
						});
					}

					$parent.addClass( 'm-hover' );
					$this.show().addClass( 'animated fadeInDown' );

					$( 'html' ).on( 'touchstart', function(e) {
						$parent.removeClass( 'm-hover' );
						$this.hide().removeClass( 'animated fadeInDown' );
					});

					$parent.on( 'touchstart' ,function(e) {
						e.stopPropagation();
					});

					return false;

				}
			});

		};

		$( '.side-menu ul > li > ul' ).each(function(){
			if ( ! $(this).parent().is( '.current-menu-ancestor, .current_page_ancestor, .current_page_parent, .current_page_item, .current-menu-item' ) ) {
				$(this).lsvrSideMenuSubmenu();
			}
		});

	}


/* -----------------------------------------------------------------------------

	7.) OTHER

----------------------------------------------------------------------------- */

	/* -------------------------------------------------------------------------
		bbPRESS
	------------------------------------------------------------------------- */

	// ADD MOBILE LABELS
	if ( $( '#bbpress-forums' ).length > 0 ) {
		$( '.bbp-body .bbp-forum-topic-count' ).prepend( '<span class="mobile-label">' + $( '.js-labels' ).data( 'bbp-topics' ) + '</span> ' );
		$( '.bbp-body .bbp-forum-reply-count' ).prepend( '<span class="mobile-label">' + $( '.js-labels' ).data( 'bbp-posts' ) + '</span> ' );
		$( '.bbp-body .bbp-forum-freshness' ).prepend( '<span class="mobile-label">' + $( '.js-labels' ).data( 'bbp-freshness' ) + '</span>' );
		$( '.bbp-body .bbp-topic-voice-count' ).prepend( '<span class="mobile-label">' + $( '.js-labels' ).data( 'bbp-voices' ) + '</span> ' );
		$( '.bbp-body .bbp-topic-reply-count' ).prepend( '<span class="mobile-label">' + $( '.js-labels' ).data( 'bbp-posts' ) + '</span> ' );
		$( '.bbp-body .bbp-topic-freshness' ).prepend( '<span class="mobile-label">' + $( '.js-labels' ).data( 'bbp-freshness' ) + '<br></span>' );
	}

	/* -------------------------------------------------------------------------
		SCROLL ANIMATION
	------------------------------------------------------------------------- */

	$( 'a[href^="#"]' ).each(function(){

		var $this = $(this),
			element = $this.attr( 'href' );

		if ( $( element ).length > 0 ) {
			$this.click(function(e){
				$( 'html, body' ).animate({
					'scrollTop' : $( element ).offset().top - 95
				}, 500);
				return false;
			});
		}

	});

});
})(jQuery);


/* -----------------------------------------------------------------------------

	8.) STYLE SWITCHER

----------------------------------------------------------------------------- */

(function($){ "use strict";
$(document).ready(function(){

	var enableStyleSwitcher = $( 'body' ).hasClass( 'm-style-switcher' ),
		templateDirectoryUri = $( 'head' ).data( 'template-uri' );

	if ( enableStyleSwitcher && templateDirectoryUri ) {

		// CREATE STYLE SWITCHER
		var styleSwitcherHtml = '<div id="style-switcher"><button class="style-switcher-toggle"><i class="ico fa fa-tint"></i></button>';
			styleSwitcherHtml += '<div class="style-switcher-content"><ul class="skin-list">';
			styleSwitcherHtml += '<li><button class="skin-1 m-active" data-skin="red"></button></li>';
			styleSwitcherHtml += '<li><button class="skin-2" data-skin="blue"></button></li>';
			styleSwitcherHtml += '<li><button class="skin-3" data-skin="green"></button></li>';
			styleSwitcherHtml += '<li><button class="skin-4" data-skin="orange"></button></li>';
			styleSwitcherHtml += '<li><button class="skin-5" data-skin="bluegrey"></button></li>';
			styleSwitcherHtml += '</ul></div></div>';
		$( 'body' ).append( styleSwitcherHtml );

		// INIT SWITCHER
		$( '#style-switcher' ).each(function(){

			var switcher = $(this),
				toggle = switcher.find( '.style-switcher-toggle' ),
				skins = switcher.find( '.skin-list button' ),
				switches = switcher.find( '.switch-list button' );

			// TOGGLE SWITCHER
			toggle.click(function(){
				switcher.toggleClass( 'm-active' );
			});

			// SET SKIN
			skins.click(function(){
				skins.filter( '.m-active' ).removeClass( 'm-active' );
				$(this).toggleClass( 'm-active' );
				if ( $( 'head #skin-temp' ).length < 1 ) {
					$( 'head' ).append( '<link id="skin-temp" rel="stylesheet" type="text/css" href="' + templateDirectoryUri + '/library/css/skin/' + $(this).data( 'skin' ) + '.css">' );
				}
				else {
					$( '#skin-temp' ).attr( 'href',  templateDirectoryUri + '/library/css/skin/' + $(this).data( 'skin' ) + '.css' );
				}
			});

		});

	}

});
})(jQuery);