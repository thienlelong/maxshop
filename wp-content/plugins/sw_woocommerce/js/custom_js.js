/*
	** Custom JS for vc
	** Version: 1.0.0
*/
(function ($) {
	function RespSlider1( $id, $append, $target ){
		var $col_lg = $id.data('lg');
		var $col_md = $id.data('md');
		var $col_sm = $id.data('sm');
		var $col_xs = $id.data('xs');
		var $col_mobile = $id.data('mobile');
		var $speed = $id.data('speed');
		var $interval = $id.data('interval');
		var $scroll = $id.data('scroll');
		var $autoplay = $id.data('autoplay');
		var $rtl = $id.data('rtl');
		var $fade 		= ( typeof( $id.data('fade') != "undefined" ) ) ? $id.data('fade') : false;
		var $dots 		= ( typeof( $id.data('dots') != "undefined" ) ) ? $id.data('dots') : false;
		$target.slick({
		  appendArrows: $append,
		  prevArrow: '<span data-role="none" class="res-button slick-prev" aria-label="previous"></span>',
		  nextArrow: '<span data-role="none" class="res-button slick-next" aria-label="next"></span>',
		  dots: $dots,
		  infinite: true,
		  speed: $speed,
		  slidesToShow: $col_lg,
		  slidesToScroll: $scroll,
		  autoplay: false,
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
			// You can unslick at a given breakpoint now by adding:
			// settings: "unslick"
			// instead of a settings object
		  ]
		});
		$id.fadeIn(1000, function() {
			$(this).removeClass("loading");
		});
	}
	window.InlineShortcodeView_woo_tab_slider = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_woo_tab_slider.__super__.render.call( this );
			var $id 	= this.$el.find( '.responsive-slider' );	
			var $target = this.$el.find( '.responsive' );
			var $append = $id;
			vc.frame_window.vc_iframe.addActivity( function () {
				RespSlider1( $id, $append, $target );
			} );
			return this;
		}
	} );
	window.InlineShortcodeView_woo_tab_cat_slider = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_woo_tab_cat_slider.__super__.render.call( this );
			var $el 	= this.$el.find( '.sw-woo-tab-cat' );
			var $id 	= this.$el.find( '.responsive-slider' );	
			var $target = this.$el.find( '.responsive' );
			var $append = $id;
			vc.frame_window.vc_iframe.addActivity( function () {
				RespSlider1( $id, $append, $target );
				$el.removeClass( 'loading' );
			} );
			return this;
		}
	} );
	window.InlineShortcodeView_woo_slide = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_woo_slide.__super__.render.call( this );
			var $id 	= this.$el.find( '.responsive-slider' );
			var $target = this.$el.find( '.responsive' );
			var $append = $id;
			vc.frame_window.vc_iframe.addActivity( function () {
				RespSlider1( $id, $append, $target );
			} );
			return this;
		}
	} );
	window.InlineShortcodeView_woo_slide_countdown = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_woo_slide_countdown.__super__.render.call( this );
			var $id 	= this.$el.find( '.responsive-slider' );
			var $target = this.$el.find( '.responsive' );
			var $append = $id;
			vc.frame_window.vc_iframe.addActivity( function () {
				RespSlider1( $id, $append, $target );
			} );
			return this;
		}
	} );
	window.InlineShortcodeView_woocat_slide = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_woocat_slide.__super__.render.call( this );
			var $id 	= this.$el.find( '.responsive-slider' );
			var $target = this.$el.find( '.responsive' );
			var $append = $id;
			vc.frame_window.vc_iframe.addActivity( function () {
				RespSlider1( $id, $append, $target );
			} );
			return this;
		}
	} );
	window.InlineShortcodeView_total_sale = window.InlineShortcodeView.extend( {
		render: function () {
			window.InlineShortcodeView_total_sale.__super__.render.call( this );
			var $id 	= this.$el.find( '.responsive-slider' );
			var $target = this.$el.find( '.responsive' );
			var $append = $id;
			vc.frame_window.vc_iframe.addActivity( function () {
				RespSlider1( $id, $append, $target );
			} );
			return this;
		}
	} );
})(jQuery);