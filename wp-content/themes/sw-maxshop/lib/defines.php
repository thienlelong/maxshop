<?php

$lib_dir = trailingslashit( str_replace( '\\', '/', dirname(__FILE__) ) );
$lib_abs = trailingslashit( str_replace( '\\', '/', ABSPATH ) );

if( !defined('YA_DIR') ){
	define( 'YA_DIR', $lib_dir );
}

if( !defined('YA_URL') ){
	define( 'YA_URL', site_url( str_replace( $lib_abs, '', $lib_dir ) ) );
}

defined('__THEME__') or die;

if (!isset($content_width)) { $content_width = 940; }

define("PRODUCT_TYPE","product");
define("PRODUCT_DETAIL_TYPE","product_detail");

require_once( dirname( __FILE__ ) . '/options.php' );
function Ya_Options_Setup(){
	global $ya_options, $options, $options_args;
	$options = array();

	$options[] = array(
		'title' => __('About', 'maxshop'),
		'desc' => __('<p class="description">SW Maxshop is an outstanding responsive WordPress theme for multipurpose store, this theme is suitable for any kind of online store that needs a feature rich and beautiful presence online.<br><br>
			Theme Name:         SW Maxshop<br>
			Theme URI:         <a href="http://magentech.com/">http://magentech.com/</a><br>
			Description:        Maxshop is an modern and powerful WooCommerce WordPress theme with multiple layouts for digital store, hitech store, watch store, men store, women store, clothing store, furniture store, book store, cosmetics shop, luxury jewelry and accessories store…<br>
			Version:            2.2.0<br>
			Author:             Magentech<br>
			Author URI:         <a href="http://magentech.com/">http://magentech.com/</a>
		</p>', 'maxshop'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
		'icon' => YA_URL.'/options/img/glyphicons/glyphicons_062_attach.png'
			//Lets leave this as a blank section, no options just some intro text set above.
			//'fields' => array()
		);

$options[] = array(
	'title' => __('General', 'maxshop'),
	'desc' => __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Start your own color scheme by selecting one of 5 predefined schemes. Upload new logo and favicon or get their URL.</p>', 'maxshop'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'scheme',
			'type' => 'radio_img',
			'title' => __('Color Scheme', 'maxshop'),
			'sub_desc' => __( 'Select one of 5 predefined schemes', 'maxshop' ),
			'desc' => '',
			'options' => array(
				'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
				'blue' => array('title' => 'Blue', 'img' => get_template_directory_uri().'/assets/img/blue.png'),
				'green' => array('title' => 'Green', 'img' => get_template_directory_uri().'/assets/img/green.png'),
				'orange' => array('title' => 'Orange', 'img' => get_template_directory_uri().'/assets/img/orange.png'),
				'cyan' => array('title' => 'Cyan', 'img' => get_template_directory_uri().'/assets/img/cyan.png'),
												),//Must provide key => value(array:title|img) pairs for radio options
			'std' => 'default'
			),

		array(
			'id' => 'bg_img',
			'type' => 'upload',
			'title' => __('Background Image', 'maxshop'),
			'sub_desc' => '',
			'std' => ''
			),
		array(
			'id' => 'bg_repeat',
			'type' => 'checkbox',
			'title' => __('Background Repeat', 'maxshop'),
			'sub_desc' => '',
			'desc' => '',
			'std' => '1'// 1 = on | 0 = off
			),
		array(
			'id' => 'favicon',
			'type' => 'upload',
			'title' => __('Favicon Icon', 'maxshop'),
			'sub_desc' => __( 'Use the Upload button to upload the new favicon and get URL of the favicon. To config Favicon in WordPress 4.3 upward, please go to Appearance -> Customize', 'maxshop' ),
			'std' => get_template_directory_uri().'/assets/img/favicon.ico'
			),					
		array(
			'id' => 'sitelogo',
			'type' => 'upload',
			'title' => __('Logo Image', 'maxshop'),
			'sub_desc' => __( 'Use the Upload button to upload the new logo and get URL of the logo', 'maxshop' ),
			'std' => get_template_directory_uri().'/assets/img/logo-default.png'
			),
		)
);

$options[] = array(
	'title' => __('Layout', 'maxshop'),
	'desc' => __('<p class="description">Ya Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'maxshop'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_319_sort.png',
			//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'layout',
			'type' => 'select',
			'title' => __('Box Layout', 'maxshop'),
			'sub_desc' => __( 'Select Layout Box or Wide', 'maxshop' ),
			'options' => array(
				'full' => 'Wide',
				'boxed' => 'Boxed'
				),
			'std' => 'wide'
			),
		array(
			'id' => 'bg_box_img',
			'type' => 'upload',
			'title' => __('Background Box Image', 'maxshop'),
			'sub_desc' => '',
			'std' => ''
			),
		array(
			'id' => 'sidebar_left_expand',
			'type' => 'select',
			'title' => __('Left Sidebar Expand', 'maxshop'),
			'options' => array(
				'2' => '2/12',
				'3' => '3/12',
				'4' => '4/12',
				'5' => '5/12', 
				'6' => '6/12',
				'7' => '7/12',
				'8' => '8/12',
				'9' => '9/12',
				'10' => '10/12',
				'11' => '11/12',
				'12' => '12/12'
				),
			'std' => '3',
			'sub_desc' => __( 'Select width of left sidebar.', 'maxshop' ),
			),

		array(
			'id' => 'sidebar_right_expand',
			'type' => 'select',
			'title' => __('Right Sidebar Expand', 'maxshop'),
			'options' => array(
				'2' => '2/12',
				'3' => '3/12',
				'4' => '4/12',
				'5' => '5/12',
				'6' => '6/12',
				'7' => '7/12',
				'8' => '8/12',
				'9' => '9/12',
				'10' => '10/12',
				'11' => '11/12',
				'12' => '12/12'
				),
			'std' => '3',
			'sub_desc' => __( 'Select width of right sidebar medium desktop.', 'maxshop' ),
			),
		array(
			'id' => 'sidebar_left_expand_md',
			'type' => 'select',
			'title' => __('Left Sidebar Medium Desktop Expand', 'maxshop'),
			'options' => array(
				'2' => '2/12',
				'3' => '3/12',
				'4' => '4/12',
				'5' => '5/12',
				'6' => '6/12',
				'7' => '7/12',
				'8' => '8/12',
				'9' => '9/12',
				'10' => '10/12',
				'11' => '11/12',
				'12' => '12/12'
				),
			'std' => '4',
			'sub_desc' => __( 'Select width of left sidebar medium desktop.', 'maxshop' ),
			),
		array(
			'id' => 'sidebar_right_expand_md',
			'type' => 'select',
			'title' => __('Right Sidebar Medium Desktop Expand', 'maxshop'),
			'options' => array(
				'2' => '2/12',
				'3' => '3/12',
				'4' => '4/12',
				'5' => '5/12',
				'6' => '6/12',
				'7' => '7/12',
				'8' => '8/12',
				'9' => '9/12',
				'10' => '10/12',
				'11' => '11/12',
				'12' => '12/12'
				),
			'std' => '4',
			'sub_desc' => __( 'Select width of right sidebar.', 'maxshop' ),
			),
		array(
			'id' => 'sidebar_left_expand_sm',
			'type' => 'select',
			'title' => __('Left Sidebar Tablet Expand', 'maxshop'),
			'options' => array(
				'2' => '2/12',
				'3' => '3/12',
				'4' => '4/12',
				'5' => '5/12',
				'6' => '6/12',
				'7' => '7/12',
				'8' => '8/12',
				'9' => '9/12',
				'10' => '10/12',
				'11' => '11/12',
				'12' => '12/12'
				),
			'std' => '4',
			'sub_desc' => __( 'Select width of left sidebar tablet.', 'maxshop' ),
			),
		array(
			'id' => 'sidebar_right_expand_sm',
			'type' => 'select',
			'title' => __('Right Sidebar Tablet Expand', 'maxshop'),
			'options' => array(
				'2' => '2/12',
				'3' => '3/12',
				'4' => '4/12',
				'5' => '5/12',
				'6' => '6/12',
				'7' => '7/12',
				'8' => '8/12',
				'9' => '9/12',
				'10' => '10/12',
				'11' => '11/12',
				'12' => '12/12'
				),
			'std' => '4',
			'sub_desc' => __( 'Select width of right sidebar tablet.', 'maxshop' ),
			),				

		)
);
$options[] = array(
	'title' => __('Header & Footer', 'maxshop'),
	'desc' => __('<p class="description">Ya Framework comes with a header &footer setting that allows you to build style header.</p>', 'maxshop'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_336_read_it_later.png',
			//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'header_style',
			'type' => 'select',
			'title' => __('Header Style', 'maxshop'),
			'sub_desc' => __( 'Select Header style', 'maxshop' ),
			'options' => array(
				'style1'  => 'Style 1',
				'style2'  => 'Style 2',
				'style3'  => 'Style 3',
				'style4'  => 'Style 4',
				'style5'  => 'Style 5',
				'style6'  => 'Style 6',
				'style7'  => 'Style 7',
				'style8'  => 'Style 8',
				'style9'  => 'Style 9',						
				),
			'std' => 'style1'
			),
		array(
			'id' => 'footer_style',
			'type' => 'select',
			'title' => __('Footer Style', 'maxshop'),
			'sub_desc' => 'Select Footer style',
			'options' => array(
				'default' => 'Default',
				'style8'  => 'Style 8',
				'style9'  => 'Style 9',         
				),
			'std' => 'default'
			),
		array(
			'id' => 'phone',
			'type' => 'text',
			'title' => __('Phone number', 'maxshop'),
			'sub_desc' => __( 'Fill here your phone number to be displayed in header.', 'maxshop' ),
			'std' => ''
			),
		array(
			'id' => 'search',
			'title' => __( 'Search form', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => __( 'Hide or show search form', 'maxshop' ),
			'desc' => '',
			'std' => '1'
			),
		
		array(
			'id' => 'footer_copyright',
			'type' => 'editor',
			'sub_desc' => '',
			'title' => __( 'Copyright text', 'maxshop' ),
			'std' => ''
			),	

		)
);
$options[] = array(
	'title' => __('Navbar Options', 'maxshop'),
	'desc' => __('<p class="description">If you got a big site with a lot of sub menus we recommend using a mega menu. Just select the dropbox to display a menu as mega menu or dropdown menu.</p>', 'maxshop'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'menu_type',
			'type' => 'select',
			'title' => __('Menu Type', 'maxshop'),
			'options' => array( 'dropdown' => 'Dropdown Menu', 'mega' => 'Mega Menu' ),
			'std' => 'mega'
			),
		array(
			'id' => 'sticky_menu',
			'type' => 'checkbox',
			'title' => esc_html__('Active sticky menu', 'maxshop'),
			'sub_desc' => '',
			'desc' => '',
				'std' => '0'// 1 = on | 0 = off
				),
		)
	);
$options[] = array(
	'title' => __('Blog Options', 'maxshop'),
	'desc' => __('<p class="description">Select layout in blog listing page.</p>', 'maxshop'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_155_show_thumbnails.png',
		//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'sidebar_blog',
			'type' => 'select',
			'title' => __('Sidebar Blog Layout', 'maxshop'),
			'options' => array(
				'full' => 'Full Layout',		
				'left_sidebar'	=> 'Left Sidebar',
				'right_sidebar' =>'Right Sidebar',
				'lr_sidebar'   =>'Left Right Sidebar'						
				),
			'std' => 'left_sidebar',
			'sub_desc' => __( 'Select style sidebar blog', 'maxshop' ),
			),
		array(
			'id' => 'blog_layout',
			'type' => 'select',
			'title' => __('Layout blog', 'maxshop'),
			'options' => array(
				'default' => 'Default',
				'list'	=> 'List Layout',
				'grid' => 'Grid Layout'								
				),
			'std' => 'default',
			'sub_desc' => __( 'Select style layout blog', 'maxshop' ),
			),
		array(
			'id' => 'blog_column',
			'type' => 'select',
			'title' => __('Blog column', 'maxshop'),
			'options' => array(								
				'2' => '2 columns',
				'3' => '3 columns',
				'4' => '4 columns'								
				),
			'std' => '2',
			'sub_desc' => __( 'Select style number column blog', 'maxshop' ),
			),
		)
);	
$options[] = array(
	'title' => __('Product Options', 'maxshop' ),
	'desc' => __( '<p class="description">Select layout in product listing page.</p>', 'maxshop' ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_155_show_thumbnails.png',
		//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'product_col_large',
			'type' => 'select',
			'title' => __('Product Listing column Desktop', 'maxshop'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',							
				'6' => '6'							
				),
			'std' => '4',
			'sub_desc' => __( 'Select number of column on Desktop Screen', 'maxshop' ),
			),
		array(
			'id' => 'product_col_medium',
			'type' => 'select',
			'title' => __('Product Listing column Medium Desktop', 'maxshop'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',							
				'6' => '6'							
				),
			'std' => '3',
			'sub_desc' => __( 'Select number of column on Medium Desktop Screen', 'maxshop' ),
			),
		array(
			'id' => 'product_col_sm',
			'type' => 'select',
			'title' => __('Product Listing column Tablet', 'maxshop'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',							
				'6' => '6'							
				),
			'std' => '2',
			'sub_desc' => __( 'Select number of column on Tablet Screen', 'maxshop' ),
			),
		array(
			'id' => 'sidebar_product',
			'type' => 'select',
			'title' => __('Sidebar Product Layout', 'maxshop'),
			'options' => array(
				'left'	=> 'Left Sidebar',
				'full' => 'Full Layout',		
				'right' =>'Right Sidebar',
				'lr'   =>'Left Right Sidebar'						
				),
			'std' => 'left',
			'sub_desc' => __( 'Select style sidebar product', 'maxshop' ),
			),
		array(
			'id' => 'quickview_enable',
			'title' => __( 'Enable Quickview', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => __( 'Turn On or Off product quickview', 'maxshop' ),
			'std' => '1'
			),
		array(
			'id' => 'product_number',
			'type' => 'text',
			'title' => __('Product Listing Number', 'maxshop'),
			'sub_desc' => __( 'Show number of product in listing product page.', 'maxshop' ),
			'std' => 16
			),
		array(
			'id' => 'product_banner',
			'type' => 'upload',
			'title' => __('Product Banner', 'maxshop'),
			'sub_desc' => __( 'Use the Upload button to upload the new product banner', 'maxshop' ),
			'std' => get_template_directory_uri().'/assets/img/banner-default.png'
			),
		)
);	
$options[] = array(
	'title' => __('Typography', 'maxshop'),
	'desc' => __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'maxshop'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'google_webfonts',
			'type' => 'text',
			'title' => __('Use Google Webfont', 'maxshop'),
			'sub_desc' => __( 'Insert font style that you actually need on your webpage.', 'maxshop' ),
			'std' => ''
			),
		array(
			'id' => 'webfonts_weight',
			'type' => 'multi_select',
			'sub_desc' => __( 'For weight, see Google Fonts to custom for each font style.', 'maxshop' ),
			'title' => __('Webfont Weight', 'maxshop'),
			'options' => array(
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900'
				),
			'std' => ''
			),
		array(
			'id' => 'webfonts_assign',
			'type' => 'select',
			'title' => __( 'Webfont Assign to', 'maxshop' ),
			'sub_desc' => __( 'Select the place will apply the font style headers, every where or custom.', 'maxshop' ),
			'options' => array(
				'headers' => __( 'Headers',    'maxshop' ),
				'all'     => __( 'Everywhere', 'maxshop' ),
				'custom'  => __( 'Custom',     'maxshop' )
				)
			),
		array(
			'id' => 'webfonts_custom',
			'type' => 'text',
			'sub_desc' => __( 'Insert the places will be custom here, after selected custom Webfont assign.', 'maxshop' ),
			'title' => __( 'Webfont Custom Selector', 'maxshop' )
			),
		)
);

$options[] = array(
	'title' => __('Social share', 'maxshop'),
	'desc' => __('<p class="description">Social sharing is ready to use and built in. You can share your pages with just a click and your post can go to their wall and you can gain vistitors from Social Networks. Check Social Networks that you want to use.</p>', 'maxshop'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_222_share.png',
			//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'social-share',
			'title' => __( 'Social share', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => '',
			'std' => '0'
			),
		array(
			'id' => 'social-share-fb',
			'title' => __( 'Facebook', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => '',
			'std' => '1',
			),
		array(
			'id' => 'social-share-tw',
			'title' => __( 'Twitter', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => '',
			'std' => '1',
			),
		array(
			'id' => 'social-share-in',
			'title' => __( 'Linked_in', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => '',
			'std' => '1',
			),
		array(
			'id' => 'social-share-go',
			'title' => __( 'Google+', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => '',
			'std' => '1',
			),
	//				array(
	//						'id' => 'social-share-pi',
	//						'title' => '<div class="social-share">Pinterest</div>',//__( 'Facebook', 'maxshop' ),
	//						'type' => 'checkbox',
	//						'sub_desc' => '',
	//						'desc' => '',
	//						'std' => '1',
	//					)

		)
);

$options[] = array(
	'title' => __('Advanced', 'maxshop'),
	'desc' => __('<p class="description">Custom advanced with Cpanel, Widget advanced, Developer mode </p>', 'maxshop'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
	'icon' => YA_URL.'/options/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'show_cpanel',
			'title' => __( 'Show cPanel', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => __( 'Turn on/off Cpanel', 'maxshop' ),
			'desc' => '',
			'std' => ''
			),
		array(
			'id' => 'widget-advanced',
			'title' => __('Widget Advanced', 'maxshop'),
			'type' => 'checkbox',
			'sub_desc' => __( 'Turn on/off Widget Advanced', 'maxshop' ),
			'desc' => '',
			'std' => '1'
			),
		array(
			'id' => 'developer_mode',
			'title' => __( 'Developer Mode', 'maxshop' ),
			'type' => 'checkbox',
			'sub_desc' => __( 'Turn on/off preset', 'maxshop' ),
			'desc' => '',
			'std' => '0'
			),
		array(
			'id' => 'back_active',
			'type' => 'checkbox',
			'title' => __('Back to top', 'maxshop'),
			'sub_desc' => '',
			'desc' => '',
							'std' => '1'// 1 = on | 0 = off
							),			
		array(
			'id' => 'direction',
			'type' => 'select',
			'title' => __('Direction', 'maxshop'),
			'options' => array( 'ltr' => 'Left to Right', 'rtl' => 'Right to Left' ),
			'std' => 'ltr'
			),									
		array(
			'id' => 'google_analytics_id',
			'type' => 'text',
			'sub_desc' => __( 'Enter Google Analytics code', 'maxshop' ),
			'title' => __( 'Google Analytics ID', 'maxshop' ),
			),
		array(
			'id' => 'advanced_head',
			'type' => 'textarea',
			'sub_desc' => __( 'Insert your own CSS into this block. This overrides all default styles located throughout the theme', 'maxshop' ),
			'title' => __( 'Custom CSS/JS', 'maxshop' )
			)
		)
);

$options_args = array();

	//Setup custom links in the footer for share icons
$options_args['share_icons']['facebook'] = array(
	'link' => 'https://www.facebook.com/SmartAddons.page',
	'title' => 'Facebook',
	'img' => YA_URL.'/options/img/glyphicons/glyphicons_320_facebook.png'
	);
$options_args['share_icons']['twitter'] = array(
	'link' => 'https://twitter.com/smartaddons',
	'title' => 'Folow me on Twitter',
	'img' => YA_URL.'/options/img/glyphicons/glyphicons_322_twitter.png'
	);
$options_args['share_icons']['linked_in'] = array(
	'link' => 'http://www.linkedin.com/in/smartaddons',
	'title' => 'Find me on LinkedIn',
	'img' => YA_URL.'/options/img/glyphicons/glyphicons_337_linked_in.png'
	);

	//Choose to disable the import/export feature
	// $options_args['show_import_export'] = true;

	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$options_args['opt_name'] = __THEME__;

	$options_args['google_api_key'] = '';//must be defined for use with google webfonts field type

	//Custom menu icon
	//$options_args['menu_icon'] = '';

	//Custom menu title for options page - default is "Options"
	$options_args['menu_title'] = __('Theme Options', 'maxshop');

	//Custom Page Title for options page - default is "Options"
	$options_args['page_title'] = wp_get_theme()->get('Name') . ' ' . __( 'Theme Options', 'maxshop' );

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "ya_theme_options"
	$options_args['page_slug'] = 'ya_theme_options';

	//Custom page capability - default is set to "manage_options"
	//$options_args['page_cap'] = 'manage_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$options_args['page_type'] = 'submenu';

	//parent menu - default is set to "themes.php" (Appearance)
	//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	//$options_args['page_parent'] = 'themes.php';

	//custom page location - default 100 - must be unique or will override other items
	$options_args['page_position'] = 27;
	$ya_options = new YA_Options($options, $options_args);
}
add_action( 'admin_init', 'Ya_Options_Setup', 0 );
Ya_Options_Setup();
function ya_widget_setup_args(){
	$widget_areas = array(
		
		array(
			'name' => __('Sidebar Left Blog', 'maxshop'),
			'id'   => 'left-blog',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
			),
		array(
			'name' => __('Sidebar Right Blog', 'maxshop'),
			'id'   => 'right-blog',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
			),
		
		array(
			'name' => __('Top', 'maxshop'),
			'id'   => 'top',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		
		array(
			'name' => __('Sidebar Left Detail Product', 'maxshop'),
			'id'   => 'left-detail-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
			),
		array(
			'name' => __('Sidebar Right Detail Product', 'maxshop'),
			'id'   => 'right-detail-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
			),
		array(
			'name' => __('Sidebar Bottom Detail Product', 'maxshop'),
			'id'   => 'bottom-detail-product',
			'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		
		array(
			'name' => __('Sidebar Left Product', 'maxshop'),
			'id'   => 'left-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
			),
		
		array(
			'name' => __('Sidebar Right Product', 'maxshop'),
			'id'   => 'right-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
			),
		
		array(
			'name' => __('Above Footer', 'maxshop'),
			'id'   => 'above-footer',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		array(
			'name' => __('Footer', 'maxshop'),
			'id'   => 'footer',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		array(
			'name' => __('Footer Style 8', 'maxshop'),
			'id'   => 'footer-style8',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		array(
			'name' => __('Footer Copyright 8', 'maxshop'),
			'id'   => 'footer-copyright8',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		array(
			'name' => __('Banner Style 9', 'maxshop'),
			'id'   => 'banner-style9',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		array(
			'name' => __('Footer Style 9 Left', 'maxshop'),
			'id'   => 'footer-style9-left',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		array(
			'name' => __('Footer Style 9 Right1', 'maxshop'),
			'id'   => 'footer-style9-right1',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		array(
			'name' => __('Footer Style 9 Right2', 'maxshop'),
			'id'   => 'footer-style9-right2',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			),
		array(
			'name' => __('Footer Copyright 9', 'maxshop'),
			'id'   => 'footer-copyright9',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
			)
		);
return $widget_areas;
}
