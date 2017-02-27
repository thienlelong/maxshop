<?php
/**
 * Enqueue scripts and stylesheets
 *
 */

function ya_scripts() {	
	$scheme = ya_options()->getCpanelValue('scheme');
	if ($scheme){
		$app_css = get_template_directory_uri() . '/css/app-'.$scheme.'.css';
	} else {
		$app_css = get_template_directory_uri() . '/css/app-default.css';
	}
	wp_register_style('custom_css', get_template_directory_uri() . '/style.css', array(), null);
	wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), null);
	wp_register_style('ya_photobox_css', get_template_directory_uri() . '/css/photobox.css', array(), null);	
	//wp_register_style('layout_css', get_template_directory_uri() . '/css/isotope.css', array(), null);
	wp_register_style('rtl_css', get_template_directory_uri() . '/css/rtl.css', array(), null);
	wp_register_style('yatheme_css', $app_css, array(), null);
    wp_register_style('flexslider_css', get_template_directory_uri() . '/css/flexslider.css', array(), null);
	 wp_register_style('slick_css', get_template_directory_uri() . '/css/slick.css', array(), null);
	wp_register_style('lightbox_css', get_template_directory_uri() . '/css/jquery.fancybox.css', array(), null);
	wp_register_style('yatheme_responsive_css', get_template_directory_uri() . '/css/app-responsive.css', array('yatheme_css'), null);
	/* register script */

	wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', false, null, false);
	wp_register_script('scroll_js', get_template_directory_uri() . '/js/scrollReveal.js', false, null, true);
	wp_register_script('bootstrap_js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);
	wp_register_script('gallery_load_js', get_template_directory_uri() . '/js/load-image.min.js', array('bootstrap_js'), null, true);
	wp_register_script('bootstrap_gallery_js', get_template_directory_uri() . '/js/bootstrap-image-gallery.min.js', array('gallery_load_js'), null, true);
    wp_register_script('flexslider_js', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), null, true);
	wp_register_script('photobox_js', get_template_directory_uri() . '/js/photobox.js', array('jquery'), null, true);
	wp_register_script('plugins_js', get_template_directory_uri() . '/js/plugins.js', array('jquery'), null, true);	
	wp_register_script('lightbox_js', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array('jquery'), null, true);
    wp_register_script( 'ya_circle_skill', get_template_directory_uri() .'/js/jquery.circliful.min.js',array(), null, true );
    wp_register_script('ya_accordion',get_template_directory_uri().'/js/jquery.accordion.js',array(),null,true);
	wp_register_script('ya_countup',get_template_directory_uri().'/js/jquery.counterup.js',array(),null,true);
	wp_register_script('slick_slider_js',get_template_directory_uri().'/js/slick.min.js',array(),null,true);
	wp_register_script( 'woo_countdown_js', get_template_directory_uri(). '/js/jquery.countdown.min.js',array(), null, true );	
	wp_localize_script( 'woo_countdown_js', 'countdown_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_register_script('megamenu_js', get_template_directory_uri() . '/js/megamenu.js', array(), null, true);
	wp_register_script( 'cloud-zoom', get_template_directory_uri(). '/js/cloud-zoom.1.0.2.min.js',array(), null, true );
	wp_register_script('masonry_js', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array('jquery'), null, true);
	wp_register_script('number_js', get_template_directory_uri() . '/js/number-polyfill.min.js', array('jquery'), null, true);
    wp_register_script('quantity_js', get_template_directory_uri() . '/js/wc-quantity-increment.min.js', array('jquery'), null, true);
	wp_register_script('yatheme_js', get_template_directory_uri() . '/js/main.js', array('bootstrap_js', 'plugins_js'), null, true);
	/* enqueue script & style */
	if ( !is_admin() ){			
		wp_dequeue_style('tabcontent_styles');
		wp_enqueue_style('bootstrap');	
		if( is_rtl() || ya_options()->getCpanelValue('direction') == 'rtl' ){
			wp_enqueue_style('rtl_css');
		}
		wp_dequeue_style('fontawesome_css');
		wp_enqueue_script( 'woo_countdown_js' );
		wp_enqueue_script('lightbox_js');
		wp_enqueue_script('lightbox_js');
		wp_enqueue_script('ya_circle_skill');
		wp_enqueue_script('ya_countup');
		wp_enqueue_style('flexslider_css');
		 wp_enqueue_style('custom_css');
		wp_enqueue_style('slick_css');
		wp_enqueue_style('lightbox_css');
		wp_enqueue_style('yatheme_css');			
		wp_enqueue_script('flexslider_js');
		wp_enqueue_script('slick_slider_js');
		wp_enqueue_script('masonry_js');
		wp_enqueue_script('cloud-zoom');
		wp_enqueue_script('number_js');
		wp_enqueue_script('quantity_js');
		
		/*	wp_enqueue_style('bootstrap_responsive_css'); */
		wp_enqueue_style('yatheme_responsive_css');
		
		/* Load style.css from child theme */
		if (is_child_theme()) {
			wp_enqueue_style('yatheme_child_css', get_stylesheet_uri(), false, null);
		}
	}
	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}		
	
	$is_category = is_category() && !is_category('blog');
	if ( !is_admin() ){
		wp_enqueue_script('modernizr');
		wp_enqueue_script('yatheme_js');
	}
	if( ya_options()-> getCpanelValue( 'menu_type' ) == 'mega' ){
		wp_enqueue_script('megamenu_js');	
	}
}
add_action('wp_enqueue_scripts', 'ya_scripts', 100);

function ya_google_analytics() { ?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo esc_attr( ya_options()->getCpanelValue('google_analytics_id') ); ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();   
</script>
<?php }
if ( ya_options()->getCpanelValue('google_analytics_id') ) {
	add_action('wp_footer', 'ya_google_analytics', 20);
}
