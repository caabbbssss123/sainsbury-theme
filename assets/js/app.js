$ = jQuery;

function initSwipers() {

	const jsSwipers = document.querySelectorAll('.js-swiper');

	if (jsSwipers == null)
		return;
	
	jsSwipers.forEach((jsSwiper) => {
		
		let parentSection = jsSwiper.closest('header, section');
		
		let _effect = (jsSwiper.getAttribute('data-effect')) ? jsSwiper.getAttribute('data-effect') : 'fade',
			_direction = (jsSwiper.getAttribute('data-direction')) ? jsSwiper.getAttribute('data-direction') : 'horizontal',
			_verticalRatio = (jsSwiper.getAttribute('data-verticalRatio')) ? jsSwiper.getAttribute('data-verticalRatio') : 'landscape',
			_autoplay = (jsSwiper.getAttribute('data-autoplay')) ? Number(jsSwiper.getAttribute('data-autoplay')) : 1,
			_autoplayDelay = (jsSwiper.getAttribute('data-autoplayDelay')) ? Number(jsSwiper.getAttribute('data-autoplayDelay')) : 5000,
			_pauseOnMouseEnter = (jsSwiper.getAttribute('data-pauseOnMouseEnter')) ? Number(jsSwiper.getAttribute('data-pauseOnMouseEnter')) : 1,
			_speed = (jsSwiper.getAttribute('data-speed')) ? Number(jsSwiper.getAttribute('data-speed')) : 1000,
			_slidesPerView = (jsSwiper.getAttribute('data-slidesPerView')) ? jsSwiper.getAttribute('data-slidesPerView') : 1,
			_spaceBetween = (jsSwiper.getAttribute('data-spaceBetween')) ? jsSwiper.getAttribute('data-spaceBetween') : 0,		
			_centeredSlides = (jsSwiper.getAttribute('data-centeredSlides')) ? jsSwiper.getAttribute('data-centeredSlides') : false,
			_loop = (jsSwiper.getAttribute('data-loop')) ? jsSwiper.getAttribute('data-loop') : false;
		
			//_centeredSlidesBounds = (jsSwiper.getAttribute('data-startSlide')) ? jsSwiper.getAttribute('data-startSlide') : 'false',
		
		let paginationEl = parentSection.querySelector('.swiper-pagination'),
			navigationNext = parentSection.querySelector('.swiper-next'),
			navigationPrev = parentSection.querySelector('.swiper-prev');
		
		let jsSwiperOptions = {
			effect: _effect,
			fadeEffect: {
				crossFade: false
			},
			direction: _direction,
			speed: _speed,
			draggable: true,
			//mousewheel: true,
			//centeredSlidesBounds: _centeredSlidesBounds,
			loop: _loop,
			pagination: {
				el: paginationEl,
				clickable: true,
			},
			navigation: {
				nextEl:  navigationNext,
				prevEl:  navigationPrev
			},
			centeredSlides: _centeredSlides,
			spaceBetween: _spaceBetween,
			slidesPerView: _slidesPerView,
			on: {
				init: function(swiper) {
					if (swiper.params.direction == 'vertical') {
						jsSwiper.classList.add('swiper-vertical--' + _verticalRatio)
					}
					if (swiper.params.slidesPerView != 1) {
						jsSwiper.classList.add('swiper--boxder-box')
					}
				},
				activeIndexChange: function (swiper) {
					if (swiper.params.effect == 'fade') {
						swiper.slides[swiper.activeIndex].style.opacity = 1;
					}
				},
				/*slidesUpdated: function (swiper) {
					if (swiper.params.spaceBetween > 0) {
						swiper.slides.forEach((slide) => {
							slide.style.removeProperty('margin-right')
							slide.style.removeProperty('margin-bottom')
						})
						
					}
				},*/
		  	}
		};
		
		if (_autoplay == 1) {
			jsSwiperOptions['autoplay'] = {
				delay: _autoplayDelay,
				pauseOnMouseEnter: _pauseOnMouseEnter,
				disableOnInteraction: false
			}	
		}
		
		var swiper = new Swiper(jsSwiper, jsSwiperOptions);

		
		/*
		animation: _animation ? _animation : 'fade',
			controlNav: _controlNav === 'false' ? false : true,
			directionNav: _directionNav === 'true' ? true : false,
			prevText: '<span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span>',
			nextText: '<span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span>', 
			controlsContainer: $(this).parents('section').find('.slider-pagination'),
			customDirectionNav: $(this).parents('section').find('.slider-controls a'),
			manualControls: $(this).parents('section').find('.manual-controls a'),
			animationLoop: _animationLoop === 'false' ? false : true,
			pauseOnAction: _pauseOnAction === 'false' ? false : true,
			pauseOnHover: _pauseOnHover === 'true' ? true : false,
			startAt: _startAt ? _startAt : 0,
			slideshow: _slideshow === 'false' ? false : true,
			slideshowSpeed: _slideshowSpeed ? _slideshowSpeed : 7500,
			animationSpeed: _animationSpeed ? _animationSpeed : 1000,
			*/
		
		/*let swiperSlides = swiper.slides,
			_slidesPerView = Number(swiper.el.dataset.slidesperview);

		swiper.params.slidesPerView = (isNaN(_slidesPerView)) ? 'auto' : _slidesPerView;
		if (isNaN(_slidesPerView)) {
			if (swiperSlides != null) {
				for (var s = 0; s < swiperSlides.length; s++) {
					swiperSlides[s].style.width = null;
				}
			}
		}

		swiper.update();*/
	})
}

initSwipers();

const rtwocswiper = new Swiper('.swiper--responsive-two-column', {
  // Default parameters
  //idesPerView: 1,
  //spaceBetween: 0,
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
      spaceBetween: 32
    },
    // when window width is >= 768px
    768: {
      slidesPerView: 2,
      spaceBetween: 30
    }
    // when window width is >= 1024px
    //1024: {
    //  slidesPerView: 4,
    //   spaceBetween: 30
	//}
  }
});

const rthreecswiper = new Swiper('.swiper--responsive-three-column', {
  // Default parameters
  //idesPerView: 1,
  //spaceBetween: 0,
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 2,
      spaceBetween: 7
    },
    // when window width is >= 768px
    768: {
      slidesPerView: 3,
      spaceBetween: 30
    }
    // when window width is >= 1024px
    //1024: {
    //  slidesPerView: 4,
    //   spaceBetween: 30
	//}
  }
});


jQuery(document).ready(function($) {
	
	/*
	 * Site Notice
	 */
	if(sessionStorage.visited) {
		// Retrieve data
		console.log("Visit = " + sessionStorage.visited);
	} else {
		sessionStorage.visited = true;
		if ($('.js-site-notice').length > 0) {
			$('body').addClass('locked');
			$('.js-site-notice').addClass('popup--active');
			$('.js-site-notice.popup--active').find('.popup__content').addClass('popup__content--active');
		}
	}
	
	/*
	 * Sliders
	 */
	var $window = $(window),
        flexslider = {
        	vars: {}
        };
	
	defaultSlider('.flexslider:not([data-columnSlider])');
	
	columnSlider('.flexslider[data-columnSlider="large"]', largeColumnSize());
	columnSlider('.flexslider[data-columnSlider="small"]', smallColumnSize());
	columnSlider('.flexslider[data-columnSlider]', 1);

	/*
	 * Resize/load functions
	 */
	
	// Chooses how many thumbnails to show depending on screen size.
	function largeColumnSize() {
		return (window.innerWidth <= 639) ? 1 : 2;
	}
	function smallColumnSize() {
		return (window.innerWidth <= 639) ? 1 :
		(window.innerWidth <= 1023) ? 2 : 3; 
	}
	
	$(window).bind('resize load', function() {
		
		resizeElements();
		
		if ($('.flexslider[data-columnSlider="large"]').length > 0) {
			var _largeColumnSize = largeColumnSize();

			$('.flexslider[data-columnSlider="large"]').data("flexslider").vars.minItems = _largeColumnSize;
			$('.flexslider[data-columnSlider="large"]').data("flexslider").vars.maxItems = _largeColumnSize;
			$('.flexslider[data-columnSlider="large"]').data("flexslider").vars.move = _largeColumnSize;
		}
		if ($('.flexslider[data-columnSlider="small"]').length > 0) {
			var _smallColumnSize = smallColumnSize();

			$('.flexslider[data-columnSlider="small"]').data("flexslider").vars.minItems = _smallColumnSize;
			$('.flexslider[data-columnSlider="small"]').data("flexslider").vars.maxItems = _smallColumnSize;
			$('.flexslider[data-columnSlider="small"]').data("flexslider").vars.move = _smallColumnSize;
		}
		
	});
	
	/*
	 * Set up device menu
	 */
	$('.site-navigation__navigation > ul > li:not(.current_page_item):not(.current_page_ancestor):not(.current-page-ancestor) > ul.sub-menu').hide();
	$('.site-navigation__navigation > ul > li.current_page_item > .js-menu-expand.menu-arrow--closed, .site-navigation__navigation > ul > li.current_page_ancestor > .js-menu-expand.menu-arrow--closed, .site-navigation__navigation > ul > li.current-page-ancestor > .js-menu-expand.menu-arrow--closed').removeClass('menu-arrow--closed').addClass('menu-arrow--open');
	
	$(document).on('click', '.js-menu-expand.menu-arrow--closed', function(e) {
		e.preventDefault();
		$(this).parent('nav').find('.js-menu-expand.menu-arrow--open').removeClass('menu-arrow--open').addClass('menu-arrow--closed');
		$(this).parent('nav').find('.site-navigation__navigation ul.sub-menu').slideUp(250);
		$(this).removeClass('menu-arrow--closed').addClass('menu-arrow--open');
		$(this).parent('li').find('ul.sub-menu:first').slideDown(250);
	});
	
	$(document).on('click', '.js-menu-expand.menu-arrow--open', function(e) {
		e.preventDefault();
		$(this).removeClass('menu-arrow--open').addClass('menu-arrow--closed');
		$(this).parent('li').find('ul.sub-menu:first').slideUp(250);
	});
	
	/*
	 * Menu show/hide
	 */
	$(document).on('click', '.js-menu-trigger.menu-button--closed', function(e) {
		
		e.preventDefault();
		
		$(this).removeClass('menu-button--closed').addClass('menu-button--open');
		$('body').addClass('locked');
		$('.top-bar').addClass('top-bar--nav-open');
		$('.site-navigation').addClass('site-navigation--visible');
		
		if ($('.top-bar').css('position') != 'fixed') {
			$('html,body').animate({
				scrollTop: 0
			}, 250);
		}
		
	});
	
	$(document).on('click', '.js-menu-trigger.menu-button--open', function(e) {
		
		e.preventDefault();
		
		$(this).removeClass('menu-button--open').addClass('menu-button--closed');
		$('body').removeClass('locked');
		$('.top-bar').removeClass('top-bar--nav-open');
		$('.site-navigation').removeClass('site-navigation--visible');
		
		if ($('.top-bar').css('position') != 'fixed') {
			$('html,body').animate({
				scrollTop: 0
			}, 250);
		}
		
	});
	
	/*
	 * Next Section
	 */
	$(document).on('click', '.js-next-section', function(e) {
		
		e.preventDefault();
		
		var scroll_target = $(this).parents('header, section').next('section').offset().top,
			top_bar_height = $('.top-bar').outerHeight();
		
		if ($('.top-bar').css('position') == 'fixed') {
			$('html,body').animate({
				scrollTop: scroll_target - top_bar_height
			}, 1000);
		} else {
			$('html,body').animate({
				scrollTop: scroll_target
			}, 1000);
		}
		
	});
	
	/*
	 * Anchor Link
	 */
	$(document).on('click', '.js-anchor-link', function(e) {
		
		e.preventDefault();
		
		var scroll_target = $(this).attr('data-target'),
			top_bar_height = $('.top-bar').outerHeight();
		
		if ($('.top-bar').css('position') == 'fixed') {
			$('html,body').animate({
				scrollTop: $('#' + scroll_target).offset().top - top_bar_height
			}, 1000);
		} else {
			$('html,body').animate({
				scrollTop: $('#' + scroll_target).offset().top
			}, 1000);
		}
	});
	
	/*
	 * Popups
	 */
	$(document).on('click', '.js-popup-trigger', function (e) {
		e.preventDefault();
		var data_trigger = $(this).attr('data-trigger');
		$('body').addClass('locked');
		$('.js-popup[data-target=' + data_trigger + ']').addClass('popup--active');
		$('.js-popup[data-target=' + data_trigger + ']').find('.popup__content').addClass('popup__content--active');
	});
	
	// AJAX popup
	$(document).on('click', '.js-ajax-trigger', function (e) {
		e.preventDefault();
		var target_content	= $(this).attr('href');
		
		$('.js-ajax-popup').addClass('popup--active');
		
		$('.js-ajax-loader').empty().load(target_content + ' .js-ajax-content', function(responseTxt, statusTxt, xhr){
			if(statusTxt === "success") {
				$('body').addClass('locked');
				$('.js-ajax-popup.popup--active').find('.popup__content').addClass('popup__content--active');
			}
			if(statusTxt === "error") {
				alert("Error: " + xhr.status + ": " + xhr.statusText);
				$('.js-ajax-popup').removeClass('popup--active');
			}
		});
	});

	$(document).on('click', '.js-close-trigger', function (e) {
		
		e.preventDefault();
		
		$('body').removeClass('locked');
		$(this).parents('.popup').removeClass('popup--active');
		$(this).parents('.popup').find('.popup__content').removeClass('popup__content--active');
		
	});
	
	/*
	 * Accordion
	 */
	$('.accordion__panel--closed .panel__content').hide();
	$(document).on('click', '.accordion__panel--closed > .panel__title', function (e) {
		
		e.preventDefault();
		
		$(this).parent('.accordion__panel').siblings('.accordion__panel--open').find('.panel__content').each(function () {
			$(this).slideUp(500);
			$(this).parent('.accordion__panel').removeClass('accordion__panel--open').addClass('accordion__panel--closed');
			$(this).parent('.accordion__panel').parent('.accordion').find('.accordion__panel--open .panel__content').each(function () {
				$(this).slideUp(500);
				$(this).parent('.accordion__panel').removeClass('accordion__panel--open').addClass('accordion__panel--closed');
			});
		});
		$(this).parent('.accordion__panel').removeClass('accordion__panel--closed').addClass('accordion__panel--open');
		
		$(this).parent('.accordion__panel').children('.panel__content').slideDown(500, function () {
			
			var top_bar_height = $('.top-bar').outerHeight();
			
			if ($('.top-bar').css('position') == 'fixed') {
				$('html,body').animate({
					scrollTop: $(this).parent('.accordion__panel').offset().top - top_bar_height
				}, 500);
			} else {
				$('html,body').animate({
					scrollTop: $(this).parent('.accordion__panel').offset().top
				}, 500);
			}
			
		});
		
	});
	$(document).on('click', '.accordion__panel--open > .panel__title', function (e) {
		
		e.preventDefault();
		
		$(this).parent('.accordion__panel').removeClass('accordion__panel--open').addClass('accordion__panel--closed');
		$(this).parent('.accordion__panel').find('.panel__content').slideUp(500);
		$(this).parent('.accordion__panel').find('.accordion__panel--open .panel__content').each(function () {
			$(this).slideUp(500);
			$(this).parent('.accordion__panel').removeClass('accordion__panel--open').addClass('accordion__panel--closed');
		});
		
	});
		
	/*
	 * Video polyfill
	 */
	$('video').each(function () {
		enableInlineVideo(this, {
			iPad: true
		});
	});
		
	/*
	 * Wrap iFrames
	 */
	if ($('iframe[src*="youtube"], iframe[src*="vimeo"]').length > 0) {
		$('iframe[src*="youtube"], iframe[src*="vimeo"]').each(function() {
			$(this).wrap('<div class="object-embed">');
		});
	}
		
	/*
	 * Fancybox
	 * DOCS: https://obu.edu/_resources/ldp/galleries/fancybox/
	 */
	var bodyStyles		= window.getComputedStyle(document.body),
		colorPrimary	= bodyStyles.getPropertyValue('--vimeo-controls-color'),
		cleanColor		= colorPrimary.replace(' #', '');
	
	$('[data-fancybox], a[href$=".gif"], a[href$=".jpg"], a[href$=".png"], a[href$=".bmp"]').fancybox({
		infobar : false,
		buttons : [
			'close'
		],
		animationEffect : 'fade',
		loop : true,
		beforeShow: function () {
			if ($('.flexslider').length >= 1) {
				$('.flexslider').each(function () {
					var slider = $(this).data('flexslider');
					slider.pause();
				})
			}
			if ($('video').length >= 1) {
				$('video').each(function () {
					var video = $(this).get(0);
					if (!video.paused) {
						video.pause();
					}
				})
			}
		},
		afterClose: function () {
			if ($('.flexslider').length >= 1) {
				$('.flexslider').each(function () {
					var slider = $(this).data('flexslider');
					slider.play();
				});
			}
			if ($('video').length >= 1) {
				$('video').each(function () {
					var video = $(this).get(0);
					if (video.paused) {
						video.play();
					}
				})
			}
			$('main').animate({ scrollLeft: 0 }, 100);
		},
		vimeo : {
			color : cleanColor
		},
		btnTpl: {
			close: '<a href="#" data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}">'
				+ '<span class="link-icon link-icon--white"><i class="fa-regular fa-xmark"></i></span>'
				+ "</a>",
			arrowLeft: '<a href="#" data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">'
				+ '<span class="link-icon link-icon--white"><i class="fa-regular fa-arrow-left"></i></span>'
				+ "</a>",
			arrowRight: '<a href="#" data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">'
				+ '<span class="link-icon link-icon--white"><i class="fa-regular fa-arrow-right"></i></span>'
				+ "</a>",
		}
	});
	
	/* 
	 * Forms
	 */
	
	/** Date Formatting **/
	if ($('.gform_wrapper').length >= 1) {
		gform.addFilter( 'gform_datepicker_options_pre_init', function( optionsObj, formId, fieldId ) {
			optionsObj.dateFormat = "dd/mm/yy";
			optionsObj.changeMonth = false;
			optionsObj.changeYear = false;
			optionsObj.nextText = 'Next';
			optionsObj.prevText = 'Prev';
			return optionsObj;
		});
	}
	
	/** Custom Select **/
	jcf.setOptions('Select', {
		wrapNative: false,
		wrapNativeOnMobile: true,
		fakeDropInBody: false,
		maxVisibleItems: 6
	});
	jcf.replace($('select'));
	$(document).bind('gform_page_loaded', function(){
		jcf.replace($('select'));
	});
	$(document).bind('gform_post_render', function(){
		jcf.replace($('select'));
	});
	
	/*
	 * Scroll to section
	 */
	if (getParameterByName('target_area')) {
		
		var top_bar_height = $('.top-bar').outerHeight();
		
		if ($('.top-bar').css('position') == 'fixed') {
			$('html,body').delay(500).animate({
				scrollTop: $('#' + getParameterByName('target_area')).offset().top - top_bar_height
			}, 1000);
		} else  {
			$('html,body').delay(500).animate({
				scrollTop: $('#' + getParameterByName('target_area')).offset().top
			}, 1000);
		}

		if ($('#' + getParameterByName('target_area')).hasClass('accordion__panel--closed')) {
			$('#' + getParameterByName('target_area') + '.accordion__panel--closed').removeClass('accordion__panel--closed').addClass('accordion__panel--open').children('.panel__content').slideDown(500);
		}
		
	}
	
});

/*
 * Get URL parameters by name
 */
function getParameterByName(name, url) {
	if (!url) url = window.location.href;
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
		results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';

	return decodeURIComponent(results[2].replace(/\+/g, " "));
}
	
/*
 * Set Banner Video Sizes
 */
$.fn.resizeVideo = function() {
  
	//Gather browser and current image size
	var srcWidth			= $(this).prop('videoWidth'),
	srcHeight			= $(this).prop('videoHeight'),
	containerWidth		= $(this).parent().outerWidth(),
	containerHeight		= $(this).parent().outerHeight(),
	ratio				= srcHeight / srcWidth;

	//Resize image to proper ratio
	if ((containerHeight / containerWidth) > ratio){
		$(this).css({height:containerHeight});
		$(this).css({width:containerHeight / ratio});
	} else {
		$(this).css({width:containerWidth});
		$(this).css({height:containerWidth * ratio});
	}
	
	return false;
};

function resizeElements() {
	"use strict";
	
	setTimeout(function() { 
		$("video.js-banner-video").each(function () {
			$(this).resizeVideo();
			$(this).addClass("js-banner-video--active");
		})
	}, 500);
}

/*
 * Flexsliders
 * DOCS: https://github.com/woocommerce/FlexSlider/wiki/FlexSlider-Properties
 */
function defaultSlider(sliderInstance) {
	"use strict";

	$(sliderInstance).each(function () {
		
		var _animation		= $(this).attr('data-animation'),
			_controlNav		= $(this).attr('data-controlNav'),
			_directionNav	= $(this).attr('data-directionNav'),
			_animationLoop	= $(this).attr('data-animationLoop'),
			_pauseOnAction	= $(this).attr('data-pauseOnAction'),
			_pauseOnHover	= $(this).attr('data-pauseOnHover'),
			_startAt		= $(this).attr('data-startAt'),
			_slideshow		= $(this).attr('data-slideshow'),
			_slideshowSpeed	= $(this).attr('data-slideshowSpeed'),
			_animationSpeed	= $(this).attr('data-animationSpeed'),
			_videoSlider	= false;
		
		if ($(this).is('[data-videoSlider]')) {
			_videoSlider	= true;
		}
		
		$(this).flexslider({
			animation: _animation ? _animation : 'fade',
			controlNav: _controlNav === 'false' ? false : true,
			directionNav: _directionNav === 'true' ? true : false,
			prevText: '<span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span>',
			nextText: '<span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span>', 
			controlsContainer: $(this).parents('section').find('.slider-pagination'),
			customDirectionNav: $(this).parents('section').find('.slider-controls a'),
			manualControls: $(this).parents('section').find('.manual-controls a'),
			animationLoop: _animationLoop === 'false' ? false : true,
			pauseOnAction: _pauseOnAction === 'false' ? false : true,
			pauseOnHover: _pauseOnHover === 'true' ? true : false,
			startAt: _startAt ? _startAt : 0,
			slideshow: _slideshow === 'false' ? false : true,
			slideshowSpeed: _slideshowSpeed ? _slideshowSpeed : 7500,
			animationSpeed: _animationSpeed ? _animationSpeed : 1000,
			start: function (slider) {
				
				slider.addClass('flexslider--ready');
				
				/** Control Videos **/
				if (_videoSlider === true) {
					if (_startAt == null) _startAt = 0;

					var first_slide = +_startAt + 1,
						current_slide = slider.find('li:nth-child(' + first_slide + ')');

					if ($(current_slide).find('video').length >= 1) {
						$(current_slide).find('video').get(0).currentTime = 0;
						$(current_slide).find('video').get(0).play();

						slider.pause();
					}
				}
				
			},
			before: function (slider) {
				
				/** Control Videos **/
				if (_videoSlider === true) {
					var next_slide_num = slider.getTarget('next') + 1,
						next_slide = slider.find('li:nth-of-type(' + (next_slide_num) + ')')[0];

					if ($(next_slide).find('video').length >= 1) {
						$(next_slide).find('video').get(0).currentTime = 0;
						$(next_slide).find('video').get(0).play();

						slider.pause();
					}
				}
				
				/** Stop iframes playing while slide not active **/
				if (slider.find('iframe').length >= 1) {
					slider.find('iframe').each(function () {
						var iframe_src	= $(this).attr('src');
						
						$(this).attr('src', ''); 
						$(this).attr('src', iframe_src);
					})
				}
				
				slider.resize();
				
			},
			after: function (slider) {
				
				slider.resize();
				
			}
		});
		
	});
}

function columnSlider(sliderInstance, columnSize) {
	"use strict";
	
	$(sliderInstance).each(function () {
		
		var _animation		= $(this).attr('data-animation'),
			_controlNav		= $(this).attr('data-controlNav'),
			_directionNav	= $(this).attr('data-directionNav'),
			_animationLoop	= $(this).attr('data-animationLoop'),
			_pauseOnAction	= $(this).attr('data-pauseOnAction'),
			_pauseOnHover	= $(this).attr('data-pauseOnHover'),
			_startAt		= $(this).attr('data-startAt'),
			_slideshow		= $(this).attr('data-slideshow'),
			_slideshowSpeed	= $(this).attr('data-slideshowSpeed'),
			_animationSpeed	= $(this).attr('data-animationSpeed');
		
		$(this).flexslider({
			animation: 'slide',
			controlNav: _controlNav === 'false' ? false : true,
			directionNav: _directionNav === 'true' ? true : false,
			prevText: '<span class="link-icon"><i class="fa-regular fa-arrow-left"></i></span>',
			nextText: '<span class="link-icon"><i class="fa-regular fa-arrow-right"></i></span>', 
			controlsContainer: $(this).parents('section').find('.slider-pagination'),
			customDirectionNav: $(this).parents('section').find('.slider-controls a'),
			manualControls: $(this).parents('section').find('.manual-controls a'),
			animationLoop: _animationLoop === 'false' ? false : true,
			pauseOnAction: _pauseOnAction === 'false' ? false : true,
			pauseOnHover: _pauseOnHover === 'true' ? true : false,
			startAt: _startAt ? _startAt : 0,
			slideshow: _slideshow === 'false' ? false : true,
			slideshowSpeed: _slideshowSpeed ? _slideshowSpeed : 7500,
			animationSpeed: _animationSpeed ? _animationSpeed : 1000,
			itemWidth: 300,
			itemMargin: 0,
			minItems: columnSize,
			maxItems: columnSize,
			move: columnSize,
			start: function (slider) {
				
				slider.addClass('flexslider--ready');
				
				/** Set correct active slide for single column slider **/
				if (columnSize === 1) {
					if (_startAt == null) _startAt = 0;
					var first_slide		= +_startAt + 1,
						current_slide	= slider.find('li:nth-child(' + first_slide + ')');
					$(current_slide).addClass('flex-active-slide');
				}
				
			},
			before: function (slider) {	
				
				/** Stop iframes playing while slide not active **/
				if (slider.find('iframe').length >= 1) {
					slider.find('iframe').each(function () {
						var iframe_src	= $(this).attr('src');
						
						$(this).attr('src', ''); 
						$(this).attr('src', iframe_src);
					})
				}
				
				slider.resize();
				
			},
			after: function (slider) {
				
				/** Set correct active slide for single column slider **/
				if (columnSize === 1) {
					var current_slide	= slider.find('li:nth-of-type(' + (slider.currentSlide+1) + ')')[0];
					slider.find('.flex-active-slide').removeClass('flex-active-slide');
					$(current_slide).addClass('flex-active-slide');
				}
				
				slider.resize();
			}
		});
		
	});
}

/*
 * Control sliders via video
 */
function resumeslider(sliderInstance) { 
	$(sliderInstance).flexslider('next');
	$(sliderInstance).flexslider('play');
}
function pauseslider(sliderInstance) { 
	$(sliderInstance).flexslider('pause');
}
function playslider(sliderInstance) { 
	$(sliderInstance).flexslider('play');
}

/*
 * Google Maps
 */	
const locationMaps = document.querySelectorAll('.location-map');

if (locationMaps != null) {
	locationMaps.forEach((locationMap) => {
    
		var coordLat = Number(locationMap.dataset.lat),
			coordLng = Number(locationMap.dataset.lng);

		var mapStyles = [];

		var myOptions = {
		  zoom: 16,
		  draggable: true,
		  scrollwheel: false,
		  mapTypeControl: false,
		  panControl: false,
		  streetViewControl: false,
		  fullscreenControl: false,
		  zoomControlOptions: false,
		  center: new google.maps.LatLng(coordLat,coordLng),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		}

		var map = new google.maps.Map(locationMap, myOptions);

		/*var templateUrl = themeurl.templateUrl;

		var image = templateUrl + '/img/svg/map-marker.svg';
		var marker = {
			url: image,
			size: new google.maps.Size(100, 150),
			origin: new google.maps.Point(0, 0),
			anchor: new google.maps.Point(25, 75),
			scaledSize: new google.maps.Size(50, 75)
		};*/

		var bodyStyles		= window.getComputedStyle(document.body),
			colorPrimary	= bodyStyles.getPropertyValue('--map-marker-color');

		var marker = {
			path: "M50,25c0,20-25,31.2-25,50C25,56.2,0,45.1,0,25C0,11.2,11.2,0,25,0S50,11.2,50,25z M25,18.8 c-3.5,0-6.2,2.8-6.2,6.2s2.8,6.2,6.2,6.2s6.2-2.8,6.2-6.2S28.5,18.8,25,18.8z",
			fillColor: colorPrimary,
			fillOpacity: 1,
			strokeWeight: 1,
			strokeColor: '#fff',
			rotation: 0,
			scale: 1,
			anchor: new google.maps.Point(25, 75),
		};

		var companyPos = new google.maps.LatLng(coordLat,coordLng);

		var companyMarker = new google.maps.Marker({
			position: companyPos,
			animation: google.maps.Animation.DROP,
			map: map,
			icon: marker,
			zIndex: 10
		});

		// Set style to map
		map.setOptions({styles: mapStyles});
		
		addEventListener('resize', (event) => {
			var center = new google.maps.LatLng(coordLat, coordLng);
			map.setCenter(center);
		});
		
	});
}


// acf JS admin render view equivalent to document.ready
if( window.acf ) {
	window.acf.addAction( 'render_block_preview', function($block, args){
        
        initSwipers();

        defaultSlider('.flexslider:not([data-columnSlider])');

   });
}