/*Include function and libraries*/
function include(url){document.write('<script src="'+url+'"></script>');return false;}
/*Include other plugins
include('arba-assets/js/jquery.bxslider.min.js');
include('arba-assets/js/owl.carousel.min.js');
include('arba-assets/js/modernizr.min.js');
include('arba-assets/js/jquery.magnific-popup.min.js');
include('arba-assets/js/album-gallery.min.js');
/*==========================*/

/*==========================*/
/*Promo toggle block*/
/*==========================*/		
$(document).on('click', '#promote', function(e) {
	$(this).toggleClass('btn-gray');
	$('.promo-toggle').slideToggle('fast');
	$('.promo-toggle .p-box').css('height','auto');
	$('.promo-toggle .p-box').equalHeights();
	e.preventDefault();
});


$(document).on('change', '#category', function () {
	var selected = $('#category option[label=people]:selected').length;
	if (selected > 0){
		$('.search-box').find('.s-results-wrap').addClass('hide');
		$('.search-box').find('.users').removeClass('hide');
	}else{
		$('.search-box').find('.s-results-wrap').removeClass('hide');
		$('.search-box').find('.users').addClass('hide');
	}
});

/*Custom close button*/
$(document).on('click', '.add-video .heading button', function() {
	$.magnificPopup.close();
});
$(document).on('click', '.dialog-pop .heading button, .close-dialog', function() {
	$.magnificPopup.close();
});

/*==========================*/
/*Search*/
/*==========================*/  
$(document).on('click', '#top-search', function(e) {
	$('.overlay').addClass('overlay-open');
	e.preventDefault();
});

$(document).on('click', '#close-search', function() {
	$('.overlay').removeClass('overlay-open'); 
});
/*==========================*/
$(document).on('click', '.new-entry', function() {
	$('.new-entry-wrap').slideToggle('fast');
});

$(document).on('click', '#toggle-votes', function() {
	$('.toggle-votes-wrap').slideToggle('fast');
});

$(document).on('click', '.sel-photo, .sel-message', function() {
	$(this).toggleClass('active');
});

window.homeNonRegSlider = function(){
	/*==========================*/
	/*Slider*/
	/*==========================*/  
	$('.slider').slider({
		full_width: true,
		transition: 1000,
		interval: 8000
	});
	
	/*==========================*/
	/*Popup form*/
	/*==========================*/
	$('.popup-form').magnificPopup({
		type: 'inline',
		preloader: false,
		mainClass: 'mfp-fade',
		removalDelay: 500,
		fixedContentPos: false,
		closeBtnInside: true
	});
}
	
window.promoItems = function(){

	/*==========================*/
	/*Cars slider*/
	/*==========================*/ 	
	$('#promo-cars-carousel').owlCarousel({
		navigation : true,
		navigationText: ['<span class="ico-left-arrow"></span>','<span class="ico-right-arrow"></span>'],
		pagination : false,
		autoPlay : false,
		itemsCustom : [
	    [0, 1],
		[480, 2],
	    [768, 2],
	    [1000, 3],
	    [1200, 4],
	    [1400, 5],
	    [1800, 6]
	  ]
	});
	/*==========================*/

	/*var ajh = $('.promo-car-item').outerHeight();
	$('.ajax-load').height(ajh);
	$('.ajax-load').delay(1000).fadeOut('fast');
	$('#promo-cars-carousel').removeClass('preload-slider');*/
}

window.initArbaScriptsHome = function(){

/*==========================*/
/*City slider*/
/*==========================*/ 	
	$('#city-wrap').owlCarousel({
		navigation : true,
		navigationText: ['<span class="ico-left-arrow"></span>','<span class="ico-right-arrow"></span>'],
		pagination : false,
		autoPlay : false,
		items : 5,
		itemsDesktop : [1200,4],
		itemsDesktopSmall : [992,3],
		itemsTablet: [768,2],
		itemsMobile : [480,1]
	  });
/*==========================*/
}

window.initArbaScripts = function() { 
'use strict';
/*==========================*/
/*Stock functions*/
/*==========================*/

	/*Forms*/
	$('#ab-text').characterCounter();

	$('.ddate').pickadate({
		selectMonths: true,
		selectYears: 100
	});
	
	//$('select').material_select();
	
	$('.autocomplete').autocomplete({
	data: {
	  "Moscow": null,
	  "Abu Dhabi": null,
	  "Dubai": null
	}
	});
	$('.collapsible').collapsible({
		duration: 1000
	});
	$('.arch-acc').collapsible({
		duration: 0
	});
	
	/*Safari fix*/
	$('#datepick').focus( function() {
		$(this).siblings('label').addClass('active');
		if( !this.value ) {
			$(this).siblings('label').removeClass('active');
		}
		return false;
	});

/*==========================*/
/*Candidats slider*/
/*==========================*/
	$('.candidats-slider').bxSlider({
        mode: 'vertical',
        slideMargin: 30,
		minSlides: 3,
        auto: false,
        pause: 7000,
        autoControls: false,
        controls: true,
        pager: false
    });
/*==========================*/

$('.popup-youtube').magnificPopup({
	disableOn: false,
	type: 'iframe',
	mainClass: 'mfp-fade',
	removalDelay: 160,
	preloader: false,
	fixedContentPos: false
});
/*==========================*/
/*Video background*/
/*==========================*/  
var deviceAgent = navigator.userAgent.toLowerCase();
var isTouchDevice = Modernizr.touchevents || (deviceAgent.match(/(iphone|ipod|ipad)/) || deviceAgent.match(/(android)/)  || deviceAgent.match(/(iemobile)/) || deviceAgent.match(/iphone/i) || deviceAgent.match(/ipad/i) || deviceAgent.match(/ipod/i) || deviceAgent.match(/blackberry/i) || deviceAgent.match(/bada/i));
	if(!isTouchDevice){
		$('.video-bg').prepend('<video id="video_background" loop="loop" autoplay muted="muted"><source src="arba-assets/video/video.mp4" type="video/mp4"></video>');
	}
	else{
		$('.video-bg').css({'background-image':'url(arba-assets/images/video-cover.jpg)'});
		$('.album-item-wrap').removeAttr('onclick');
	}
/*==========================*/
/*EqualHeight for blocks*/
/*==========================*/
	$.fn.equalHeights = function() {
		var maxHeight = 0,
			$this = $(this);

		$this.each( function() {
			var height = $(this).innerHeight();

			if ( height > maxHeight ) { maxHeight = height; }
		});

		return $this.css('height', maxHeight);
	};

	$('[data-equal]').each(function(){
		var $this = $(this),
			target = $this.data('equal');
		$this.find(target).equalHeights();
	});

	$('.company .company-wrap .block-padding').equalHeights();
	$('.promo-wrap .block-padding').equalHeights();
	$('.big-community').equalHeights();
	
	$(window).resize(function(){
		$('.company .company-wrap .block-padding').css('height','auto');
		$('.company .company-wrap .block-padding').equalHeights();
		$('.promo-wrap .block-padding').css('height','auto');
		$('.promo-wrap .block-padding').equalHeights();
		$('.big-community').css('height','auto');
		$('.big-community').equalHeights();
		$('.promo-toggle .p-box').css('height','auto');
		$('.promo-toggle .p-box').equalHeights();
	});
/*==========================*/
/*Show/hide full entry text*/
/*==========================*/	
	$('.entry .more').each(function() {
		$(this).click(function() {
			$(this).addClass('hide');
			$(this).siblings('.full-post').toggle();
		});
	});
/*==========================*/
/*Show/hide full achivements list*/
/*==========================*/	
	$('.garage-car .see-all').each(function() {
		$(this).click(function() {
			$(this).addClass('hide');
			$(this).siblings('.full').removeClass('hide');
		});
	});
/*==========================*/
/*Show/hide answer block*/
/*==========================*/	
	$('.answer').each(function() {
		$(this).click(function() {
			$(this).parent().next('.bottom-entry').slideToggle();
		});
	});
/*==========================*/
/*Car's slider*/
/*==========================*/	
	$('#car-slider').bxSlider({
        mode: 'horizontal',
        slideMargin: 0,
        auto: false,
        autoControls: false,
        controls: true,
        pager: true,
		pagerCustom: '#car-pager'
    });
/*==========================*/
/*Anchor links*/
/*==========================*/	
    $('.sticky-item .edit-menu a').click(function() {
    	$('html, body').animate({
    		scrollTop: $($(this).attr('href')).offset().top - 50 + 'px'
    	}, {
    		duration: 800
    	});
    	return false;
    });
/*==========================*/
/*==========================*/
/*Notice messages*/
/*==========================*/  
if ($('.not-mes-wrap').length > 0){
	$(function noticem() {
	    var h_mrg = 50, 
			h_def = -300,
			elem = $('.not-mes-wrap');
		if ($(window).scrollTop()>='500') elem.css('top', (h_mrg))
			$(window).scroll(function(){
				if ($(window).scrollTop()<='500') elem.css('top', (h_def))
				else elem.css('top', (h_mrg))
			});
	});
}
/*==========================*/
/*To top button*/
/*==========================*/  
	if ($('.to-top').length > 0){
		$('.to-top').click(function () {
			$('body, html').animate({scrollTop: 0}, 400); 
			return false;
		});
	}
/*==========================*/
/*Remove avatar & cover photo example*/
/*==========================*/  	
	if ($('#deletephoto').length > 0){
		$('#deletephoto').click(function() {
			$('.community-cover').remove();
			$('.cphoto').removeClass('hide');
			$.magnificPopup.close();
		});
	}
	if ($('#deleteavatar').length > 0){
		$('#deleteavatar').click(function() {
			$('.community-avatar-wrap').remove();
			$('.cavatar').removeClass('hide');
			$.magnificPopup.close();
		});
	}
/*==========================*/
/*Show/hide community's members actions*/
/*==========================*/	
if ($('.c-menu-wrap').length > 0){
	$('.c-menu-wrap').each(function() {
		var $dropdown = $(this),
			$div = $dropdown.siblings('.c-menu-actions');
		$dropdown.click(function() {
			$div.toggleClass('hide');
			$('.c-menu-actions').not($div).addClass('hide');
			return false;
		});

	});
	$(window).click(function(event){
		if( $(event.target).closest('.c-menu-wrap').length) return;
		$('.c-menu-actions').addClass('hide');
		event.stopPropagation();
	});
}
/*==========================*/
/*Edit post*/
/*==========================*/	
$('.entry').each(function() {
	var $ed = $(this).find('.ed-post');
	var $ed2 = $(this).find('.edit-entry-wrap');
	var $ed3 = $(this).find('.edit-entry-content');
	$ed.each(function() {
		var $dropdown1 = $(this);
		$dropdown1.click(function() {
			$ed2.toggleClass('hide');
			$ed3.toggleClass('hide');
			return false;
		});
	});
});
/*==========================*/
/*Currency value select*/
/*==========================*/	
$('#currency').change(function() {
	var cur = $(this).val();
	$('.cur-adr-prefix').text(cur);
});
/*==========================*/
/*Min height of 404 wrapper*/
/*==========================*/	
    var h_hght2 = $('.main-menu').outerHeight();
    var h_hght3 = $('.breadcrumbs').outerHeight();
    var nfound = $('.not-found');
    var nwindow = $(window).height();
	if ( $('.breadcrumbs').css('display') == 'none' ){
		var nheight = nwindow - h_hght2;
	}
	else{
		var nheight = nwindow - h_hght2 - h_hght3;
	}
    nfound.css('min-height', (nheight));
	
	if ($('.sticky-nav').length > 0){
		var ww = $(window).width();
		if (ww > 992 ) {
			$(window).scroll(function(){
				var scroll1 = $('.sticky-wrap').offset().top,
					lineTopTop = scroll1 + $('.sticky-wrap').outerHeight(),
					awidth = $('.sticky-wrap aside').outerWidth(),
					sticky = $('.sticky-nav');
				$(window).resize(function(){
					sticky.css({'width' : awidth});
				});
				if ($(window).scrollTop()-28 > scroll1 ) {

					sticky.addClass('pinned');
					sticky.css({'width' : awidth});
					
				var stickablePosition = sticky.offset().top + sticky.outerHeight();
				
					if ( stickablePosition > lineTopTop ) {
						sticky.removeClass('pinned');
					};

				} else if ( scroll1 > $(window).scrollTop()-28 ) {
					sticky.removeClass('pinned');

				};
			});
		}
	}
/*==========================*/
};