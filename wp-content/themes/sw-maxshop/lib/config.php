<?php
/**
 * Enable theme features
 */
// add_theme_support('root-relative-urls');    // Enable relative URLs
// add_theme_support('rewrites');              // Enable URL rewrites
// add_theme_support('h5bp-htaccess');         // Enable HTML5 Boilerplate's .htaccess
// add_theme_support('bootstrap-top-navbar');  // Enable Bootstrap's top navbar
add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
// add_theme_support('nice-search');           // Enable /?s= to /search/ redirect
add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN

/**
 * Configuration values
 */
define('POST_EXCERPT_LENGTH', 40);

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 940px is the default Bootstrap container width.
 */
if (!isset($content_width)) { $content_width = 940; }

$add_query_vars = array( 'scheme', 'text_direction', 'menu_type' );

$customize_types = array(
		'general' => array(
				'type' => 'section',
				'title' => __('General', 'maxshop')
		),

		'scheme' => array(
				'type' => 'select',
				'label' => __('Color Scheme', 'maxshop'),
				'choices' => array(
						'default' => __('Green',  'maxshop'),
						'blue'    => __('Blue',   'maxshop'),
						'orange'  => __('Orange', 'maxshop'),
						'pink'    => __('Pink',   'maxshop'),
						'purple'  => __('Purple', 'maxshop'),
						'red'  => __('Red', 'maxshop')
				)
		),

		'favicon' => array(
				'type' => 'image',
				'label' => __('Favicon Icon', 'maxshop')
		),

		'text_direction' => array(
				'type' => 'select',
				'label' => __('Text Direction', 'maxshop'),
				'choices' => array(
						'auto' => __('Auto',          'maxshop'),
						'ltr'  => __('Left to Right', 'maxshop'),
						'rtl'  => __('Right to Left', 'maxshop')
				)
		),

		'responsive_support' => array(
				'type' => 'checkbox',
				'label' => __('Responsive Support', 'maxshop')
		),

		'sitelogo' => array(
				'type' => 'image',
				'label' => __('Logo Image', 'maxshop')
		),
		
		'navbar-options' => array(
				'type' => 'section',
				'title' => __('Navbar Options', 'maxshop')
		),
		'navbar_position' => array(
				'type' => 'select',
				'label' => __('Navbar Position', 'maxshop'),
				'choices' => array(
					'static' => 'Static',
					'top-fixed' => 'Top Fixed',
					'bottom-fixed' => 'Bottom Fixed'
				)
		),
		'navbar_inverse' => array(
				'type' => 'checkbox',
				'label' => __('Navbar Inverse Color', 'maxshop')
		),
		'navbar_branding' => array(
				'type' => 'checkbox',
				'label' => __('Display Branding', 'maxshop')
		),
		
		'navbar_logo' => array(
				'type' => 'image',
				'label' => __('Use Logo for Branding', 'maxshop')
		),
		
		'menu_type' => array(
			'type' => 'select',
			'label' => __('Menu Type', 'maxshop'),
			'choices' => array(
				'dropdown' => 'Dropdown Menu',
				'mega' => 'Mega Menu'
			)
		),

		'yatheme-layouts' => array(
				'type' => 'section',
				'title' => __('Layout', 'maxshop')
		),
		

		'sidebar_primary_expand' => array(
				'type' => 'select',
				'label' => __('Primary Sidebar Expand', 'maxshop'),
				'choices' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12'
				)
		),
		
		'sidebar_left_expand' => array(
				'type' => 'select',
				'label' => __('Left Sidebar Expand', 'maxshop'),
				'choices' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12'
				)
		),

		'sidebar_right_expand' => array(
				'type' => 'select',
				'label' => __('Left Right Expand', 'maxshop'),
				'choices' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12'
				)
		),
		'blog_layout' => array(
				'type' => 'select',
				'label' => __('Layout blog', 'maxshop'),
				'choices' => array(
						'column1' => 'Layout 1',
						'column2' => 'Layout 2',
						
				)
		),
		'blog_column' => array(
				'type' => 'select',
				'label' => __('Blog column', 'maxshop'),
				'choices' => array(
						'2' => '2 column',
						'3' => '3 column',
						'4' => '4 column',
						'6' => '6 column',			
				)
		),
		'typography' => array(
				'type' => 'section',
				'title' => __('Typography', 'maxshop')
		),

		'google_webfonts' => array(
				'type' => 'text',
				'label' => __('Use Google Webfont', 'maxshop')
		),

		'webfonts_weight' => array(
				'type' => 'select',
				'label' => __('Webfont Weight', 'maxshop'),
				'choices' => array(
						'200' => '200',
						'300' => '300',
						'400' => '400',
						'600' => '600',
						'700' => '700',
						'800' => '800',
						'900' => '900'
				)
		),

		'webfonts_character_set' => array(
				'type' => 'select',
				'label' => __('Webfont Character Set',    'maxshop'),
				'choices' => array(
						'cyrillic'     => __( 'Cyrillic',          'maxshop' ),
						'cyrillic-ext' => __( 'Cyrillic Extended', 'maxshop' ),
						'greek'        => __( 'Greek',             'maxshop' ),
						'greek-ext'    => __( 'Greek Extended',    'maxshop' ),
						'latin'        => __( 'Latin',             'maxshop' ),
						'latin-ext'    => __( 'Latin Extended',    'maxshop' ),
						'vietnamese'   => __( 'Vietnamese',        'maxshop' )
				)
		),

		'webfonts_assign' => array(
				'type' => 'select',
				'label' => __('Webfont Assign to', 'maxshop'),
				'choices' => array(
						'headers' => __( 'Headers',    'maxshop' ),
						'all'     => __( 'Everywhere', 'maxshop' ),
						'custom'  => __( 'Custom',     'maxshop' )
				)
		),

		'webfonts_custom' => array(
				'type' => 'text',
				'label' => __('Webfont Custom Selector', 'maxshop')
		),

		'advanced' => array(
				'type' => 'section',
				'title' => __('Advanced', 'maxshop')
		),
		
		'developer_mode' => array(
				'type' => 'checkbox',
				'label' => __('Developer Mode', 'maxshop')
		),
		
		'google_analytics_id' => array(
				'type' => 'text',
				'label' => __('Google Analytics ID', 'maxshop')
		),
		
		'advanced_head' => array(
				'type' => 'textarea',
				'label' => __('Custom CSS/JS', 'maxshop')
		)

);

function ya_optionsx(){
	return YA_Config::setVariables(
			wp_parse_args(
					get_option('ya_options'),
					ya_default_options()
			)
	);
}

function ya_default_options(){
	$default_theme_options = array(
			'scheme'                 => 'default',
			'favicon'                => get_template_directory_uri().'/assets/img/favicon.ico',
			'text_direction'         => 'ltr',
			'responsive_support'     => true,

			'display_searchform'     => true,
			'display_socials'        => true,
			'sitelogo'               => get_template_directory_uri().'/assets/img/logo.png',
			
			'navbar_position'        => 'static',
			'navbar_inverse'		 => false,
			'navbar_branding'	     => true,
			'navbar_logo'            => get_template_directory_uri().'/assets/img/logo.png',
			'navbar_searchform'      => true,
			'menu_type'              => 'dropdown',
			
			'theme_sidebar'          => 'primary',
			'sidebar_primary_expand' => 4,
			'sidebar_left_expand'    => 4,
			'sidebar_right_expand'   => 4,
			'blog_layout'			 => 'column1',

			'google_webfonts'        => '',
			'webfonts_weight'        => '400',
			'webfonts_character_set' => 'latin',
			'webfonts_assign'        => 'custom',
			'webfonts_custom'        => '',

			'advanced_head'          => '',
			'google_analytics_id'    => '',
			'developer_mode'         => false

	);
	return apply_filters( 'theme_default_options', $default_theme_options );
}