/*Include function and libraries*/
function include(url){document.write('<script src="/'+url+'"></script>');return false;}
/*Include other plugins*/
include('js/jquery.bxslider.min.js');
include('js/owl.carousel.min.js');
include('js/modernizr.min.js');
include('js/jquery.magnific-popup.min.js');
include('js/album-gallery.min.js');
/*==========================*/

$(window).on('load', function () {
	var ajh = $('.promo-car-item').outerHeight();
	$('.ajax-load').height(ajh);
	$('.ajax-load').delay(1000).fadeOut('fast');
	$('#promo-cars-carousel').removeClass('preload-slider')
});
$(function(){
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
	
	$('select').material_select();
	
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

	
	/*Safari fix*/
	$('#datepick').focus( function() {
    	$(this).siblings('label').addClass('active');
		return false;
	});
/*==========================*/
/*Navigation*/
/*==========================*/
    $('.profile-btn, .profile-name').sideNav({
      edge: 'right',
      closeOnClick: true
    });
	
	$('.menu-btn').sideNav({
      edge: 'right',
      closeOnClick: true
    });
	/*Tabs*/
	$('ul.utabs').tabs();
	$('ul.htabs').tabs();
/*==========================*/

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

/*==========================*/
/*Search*/
/*==========================*/  
	$('#top-search').click(function(e) {
		$('.overlay').addClass('overlay-open');
		e.preventDefault();
	});

	$('#close-search').click(function() {
		$('.overlay').removeClass('overlay-open'); 
	});
/*==========================*/

/*==========================*/
/*Cars slider*/
/*==========================*/ 	
	$('#promo-cars-carousel').owlCarousel({
		navigation : true,
		navigationText: ['<span class="ico-left-arrow"></span>','<span class="ico-right-arrow"></span>'],
		pagination : false,
		autoPlay : false,
		itemsCustom : [
        [320, 1],
		[480, 2],
        [768, 2],
        [1000, 3],
        [1200, 4],
        [1400, 5],
        [1800, 6]
      ]
	  });
/*==========================*/

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
$('.popup-youtube').magnificPopup({
	disableOn: false,
	type: 'iframe',
	mainClass: 'mfp-fade',
	removalDelay: 160,
	preloader: false,
	fixedContentPos: false
});
/*Custom close button*/
$('.add-video .heading button').click(function() {
	$.magnificPopup.close();
});
$('.dialog-pop .heading button, .close-dialog').click(function() {
	$.magnificPopup.close();
});
/*==========================*/
/*Video background*/
/*==========================*/  
var deviceAgent = navigator.userAgent.toLowerCase();
var isTouchDevice = Modernizr.touchevents || (deviceAgent.match(/(iphone|ipod|ipad)/) || deviceAgent.match(/(android)/)  || deviceAgent.match(/(iemobile)/) || deviceAgent.match(/iphone/i) || deviceAgent.match(/ipad/i) || deviceAgent.match(/ipod/i) || deviceAgent.match(/blackberry/i) || deviceAgent.match(/bada/i));
	if(!isTouchDevice){
		$('.video-bg').prepend('<video id="video_background" loop="loop" autoplay muted="muted"><source src="video/video.mp4" type="video/mp4"></video>');
	}
	else{
		$('.video-bg').css({'background-image':'url(images/video-cover.jpg)'});
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
	$('.new-entry').click(function() {
		$('.new-entry-wrap').slideToggle('fast');
	});
	
	$('.sel-photo, .sel-message').each(function() {
		$(this).click(function() {
			$(this).toggleClass('active');
		});
	});
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
		console.log(this);
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


/*	$('.edit-entry a').each(function() {
		var $dropdown1 = $(this),
			$div1 = $dropdown1.next('.entry-content');
		$dropdown1.click(function() {
			$div1.toggleClass('hide');
			return false;
		});

	});*/
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
/*==========================*/
/*Promo toggle block*/
/*==========================*/		
	$('#promote').click(function(e) {
		$(this).toggleClass('btn-gray');
		$('.promo-toggle').slideToggle('fast');
		$('.promo-toggle .p-box').css('height','auto');
		$('.promo-toggle .p-box').equalHeights();
		e.preventDefault();
	});
/*==========================*/
	
	$('a[href="#addcar"]').on('click', function(){
		$.getJSON('/api/v1/catalogs/get-car-brands', function (cars) {
			var result = '<option value="" disabled="" selected="">Brand</option>';
			$.each(cars.brands, function(i, brand){
				result += '<option value="'+brand.brand+'" >'+brand.brand.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } )+'</option>';
			});
			$('#brand').html(result);
			$('#brand').material_select();
		});
	});

});
  
//Change brand
$(document).on('change', '#brand', function(e) {
	var brand = $(this).val();
	
	$.getJSON('/api/v1/catalogs/get-car-models-by-brand?brand='+brand, function (models) {
		var result = '<option value="" disabled="" selected="">Model</option>';
		$.each(models.models, function(i, model){
			result += '<option value="'+model.model+'" >'+model.model+'</option>';
		});
		$('#model').html(result);
		$('#model').material_select();
	});
		
	$('#modification').html('<option value="" disabled="" selected="">Modification</option>');
	$('#modification').material_select();
	
	$('#modelYear').html('<option value="" disabled="" selected="">Use since</option>');
	$('#modelYear').material_select();
	
	$('#engine-size').html('<option value="" disabled="" selected="">Engine size</option>');
	$('#engine-size').material_select();
	
	$('#capacity').val('');
});

$(document).on('change', '#model', function(e) {
	var model = $(this).val();
	
	$.getJSON('/api/v1/catalogs/get-car-launch-year-by-model?model='+model, function (years) {
		if(years.launchYears && years.launchYears[0] && years.launchYears[0].launch_year){
			var year = years.launchYears[0].launch_year;
			$('input[name="Car[build_date]"]').val(year);
			
			$.getJSON('/api/v1/catalogs/get-car-modifications-and-build-dates?model='+model+'&launch_year='+year, function (modifications) {
				var result = '<option value="" disabled="" selected="">Modification</option>';
				$.each(modifications.modifications, function(i, modification){
					result += '<option value="'+modification+'" >'+modification+'</option>';
				});
				$('#modification').html(result);
				$('#modification').material_select();
				
				var buildDates = '<option value="" disabled="" selected="">Use since</option>';
				$.each(modifications.build_dates, function(i, build_date){
					buildDates += '<option value="'+build_date+'" >'+build_date+'</option>';
				});
				$('#modelYear').html(buildDates);
				$('#modelYear').material_select();
			});
		}
	});
	
	$('#engine-size').html('<option value="" disabled="" selected="">Engine size</option>');
	$('#engine-size').material_select();
	
	$('#capacity').val('');
});

$(document).on('change', '#modelYear', function(e) {
	var model = $('#model').val().trim();
	var year = $('input[name="Car[build_date]"]').val();
	
	$.getJSON('/api/v1/catalogs/get-car-engine-size?model='+model+'&launch_year='+year, function (engine) {
		var result = '<option value="" disabled="" selected="">Engine size</option>';
		$.each(engine.engine_size, function(i, engine_size){
			result += '<option value="'+engine_size.engine_size+'" >'+engine_size.engine_size+'</option>';
		});
		$('#engine-size').html(result);
		$('#engine-size').material_select();
	});
	
	$('#capacity').val('');
});

$(document).on('change', '#engine-size', function(e) {
	var model = $('#model').val().trim();
	var size = $(this).val();
	
	$.getJSON('/api/v1/catalogs/get-car-capacity?model='+model+'&engine_size='+size, function (capacitys) {
		var capacities = {};
		$.each(capacitys.capacity, function(i, capacity){
			capacities[capacity.capacity] = null;
		});
		$('#capacity').autocomplete({
			data: capacities
		});
	});
});

$(document).on('change', '#capacity', function(e) {
	var model = $('#model').val().trim();
	var size = $('#engine-size').val();
	var capacity = $(this).val();
	
	$.getJSON('/api/v1/catalogs/get-car-drive-type?model='+model+'&engine_size='+size+'&capacity='+capacity, function (type) {
		if(type.drive_type.length && type.drive_type[0] && type.drive_type[0] !== ''){
			$('input[name="Car[drive_type]"]').val(type.drive_type[0]);
		}
	});
});

