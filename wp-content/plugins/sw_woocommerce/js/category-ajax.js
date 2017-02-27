/*
	** Category Ajax Js
	** Version: 1.0.0
*/
(function ($) {
	$(document).ready(function(){
		/* First Ajax */
		var el = $( '.active [data-catload=ajax]' );
		el.each( function(){
			var els = $(this);
			sw_click_ajax( els );
		});		
		$('.category-ajax-slider .tab-content').addClass( 'loading' );
		$('[data-catload=ajax]').on('click', function() {
			sw_click_ajax( $(this) );
		});
		function sw_click_ajax( element ) {			
			var ajaxurl 	= ya_catajax.ajax_url;
			var catid 		= element.data( 'catid' );
			var number 		= element.data( 'number' );
			var orderby 	= element.data( 'orderby' );
			var columns 	= element.data( 'lg' );
			var columns1 	= element.data( 'md' );
			var columns2 	= element.data( 'sm' );
			var columns3 	= element.data( 'xs' );
			var columns4 	= element.data( 'mobile' );
			var interval 	= element.data( 'interval' );
			var scroll 		= element.data( 'scroll' );
			var speed 		= element.data( 'speed' );
			var rtl = false;
			if( $( 'body' ).hasClass( 'rtl' ) ){
				rtl = true;
			}
			var autoplay 	= element.data( 'autoplay' );
			var id 			= $( "#category_ajax_" + catid );
			if( id.html() == '' ){
				id.parent().addClass( 'loading' );
				var data 		= {
					action: 'sw_category_callback',
					catid: catid,
					number: number,
					orderby: orderby,
					columns: columns,
					columns1: columns1,
					columns2: columns2,
					columns3: columns3,
					columns4: columns4,
					interval: interval,
					speed: speed,
					scroll: scroll,
					rtl: rtl,
					autoplay: autoplay,
				};
				jQuery.post(ajaxurl, data, function(response) {
					id.html(response);
					sw_slider_ajax(catid);
					id.parent().removeClass( 'loading' );
				});
			}
		}
		function sw_slider_ajax( catid ) {	
			var element 	= $('#category_ajax_slider_' + catid );
			var $col_lg 	= element.data('lg');
			var $col_md 	= element.data('md');
			var $col_sm 	= element.data('sm');
			var $col_xs 	= element.data('xs');
			var $col_mobile = element.data('mobile');
			var $speed 		= element.data('speed');
			var $interval 	= element.data('interval');
			var $scroll 	= element.data('scroll');
			var $autoplay 	= element.data('autoplay');
			var $rtl 		= element.data('rtl');
			$target = $('#category_ajax_slider_' + catid + ' .responsive');
			$target.slick({
			  appendArrows: $('#category_ajax_slider_' + catid ).parent(),
			  prevArrow: '<span data-role="none" class="res-button slick-prev" aria-label="previous"></span>',
			  nextArrow: '<span data-role="none" class="res-button slick-next" aria-label="next"></span>',
			  dots: false,
			  infinite: true,
			  speed: $speed,
			  slidesToShow: $col_lg,
			  slidesToScroll: $scroll,
			  autoplay: $autoplay,
			  autoplaySpeed: $interval,
			  rtl: $rtl,			  
			  responsive: [
				{
				  breakpoint: 1199,
				  settings: {
					slidesToShow: $col_md
				  }
				},
				{
				  breakpoint: 991,
				  settings: {
					slidesToShow: $col_sm
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: $col_xs
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: $col_mobile    
				  }
				}
			  ]
			});
			element.fadeIn(1000, function() {
				$(this).removeClass("loading");
			});
		}
	});
})(jQuery);