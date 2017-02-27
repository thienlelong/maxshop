<?php 
add_action( 'vc_before_init', 'my_shortcodeVC' );
function my_shortcodeVC(){
$target_arr = array(
	__( 'Same window', 'maxshop' ) => '_self',
	__( 'New window', 'maxshop' ) => "_blank"
);
$link_category = array( __( 'All Categories', 'maxshop' ) => '' );
$link_cats     = get_categories();
if ( is_array( $link_cats ) ) {
	foreach ( $link_cats as $link_cat ) {
		$link_category[ $link_cat->name ] = $link_cat->term_id;
	}
}		
$args = array(
			'type' => 'post',
			'child_of' => 0,
			'parent' => 0,
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false,
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'number' => '',
			'taxonomy' => 'product_cat',
			'pad_counts' => false,

		);
		$product_categories_dropdown = array( __( 'Select Category', 'maxshop' ) => '' );
		$ya_categories_countdown = array( __( 'All Categories', 'maxshop' ) => '' );
		$categories = get_categories( $args );
		foreach($categories as $category){
			$product_categories_dropdown[$category->name] = $category -> term_id;
			$ya_categories_countdown[$category->name] = $category -> term_id;
		}		
		
$menu_locations_array = array( __( 'All Categories', 'maxshop' ) => '' );
$menu_locations = wp_get_nav_menus();	
foreach ($menu_locations as $menu_location){
	$menu_locations_array[$menu_location->name] = $menu_location -> term_id;
}

/* YTC VC */
//YTC post
vc_map( array(
	'name' => __( 'YA POSTS', 'maxshop' ),
	'base' => 'ya_post',
    'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display posts-seclect category', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'Select style for widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'description' =>__( 'Select style for title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Layout post style', 'maxshop' ),
			'param_name' => 'type',
			'value' => array(
				'Select type',
				__( 'The blog', 'maxshop' ) => 'the_blog',
				__( '2 column', 'maxshop' ) => '2_column',
				__( 'Slideshow', 'maxshop' ) => 'slide_show',
				__( 'Middle right', 'maxshop' ) => 'middle_right',
				__( 'Our Member', 'maxshop' ) => 'indicators'
			),
			'description' => sprintf( __( 'Select different style posts.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'param_name'    => 'category_id',
			'type'          => 'dropdown',
			'value'         => $link_category, // here I'm stuck
			'heading'       => __('Category filter:', 'maxshop'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'maxshop' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Excerpt length (in words)', 'maxshop' ),
			'param_name' => 'length',
			'description' => __( 'Excerpt length (in words).', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),
			

		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'maxshop' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'maxshop' ) => 'DESC',
				__( 'Ascending', 'maxshop' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'maxshop' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'maxshop' ) => 'date',
				__( 'ID', 'maxshop' ) => 'ID',
				__( 'Author', 'maxshop' ) => 'author',
				__( 'Title', 'maxshop' ) => 'title',
				__( 'Modified', 'maxshop' ) => 'modified',
				__( 'Random', 'maxshop' ) => 'rand',
				__( 'Comment count', 'maxshop' ) => 'comment_count',
				__( 'Menu order', 'maxshop' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
			
	)
) );

// ytc tesminial

vc_map( array(
	'name' =>  __( 'Ya Testimonial Slide', 'maxshop' ),
	'base' => 'testimonial_slide',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'The tesminial on your site', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'maxshop' ) => 'title1',
				__( 'Style title 2', 'maxshop' ) => 'title2',
				__( 'Style title 3', 'maxshop' ) => 'title3',
				__( 'Style title 4', 'maxshop' ) => 'title4'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'maxshop' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Excerpt length (in words)', 'maxshop' ),
			'param_name' => 'length',
			'description' => __( 'Excerpt length (in words).', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'maxshop' ),
			'param_name' => 'type',
			'value' => array(
			    __('Indicators Up','maxshop') => 'indicators_up',
				__( 'indicators', 'maxshop' ) => 'indicators',
				__( 'Slide Style 1', 'maxshop' ) => 'slide1',
				__('Slide Style 2','maxshop') => 'slide2'
			),
			'description' => sprintf( __( 'Chose template for testimonial', 'maxshop' ) )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'maxshop' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'maxshop' ) => 'DESC',
				__( 'Ascending', 'maxshop' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'maxshop' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'maxshop' ) => 'date',
				__( 'ID', 'maxshop' ) => 'ID',
				__( 'Author', 'maxshop' ) => 'author',
				__( 'Title', 'maxshop' ) => 'title',
				__( 'Modified', 'maxshop' ) => 'modified',
				__( 'Random', 'maxshop' ) => 'rand',
				__( 'Comment count', 'maxshop' ) => 'comment_count',
				__( 'Menu order', 'maxshop' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
			
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		)
	)
) );
//ytc our brand
vc_map( array(
	'name' => __( 'Ya Brand', 'maxshop' ),
	'base' => 'OurBrand',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Our Brand', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'maxshop' ) => 'title1',
				__( 'Style title 2', 'maxshop' ) => 'title2',
				__( 'Style title 3', 'maxshop' ) => 'title3',
				__( 'Style title 4', 'maxshop' ) => 'title4'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'maxshop' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'maxshop' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'maxshop' ) => 'DESC',
				__( 'Ascending', 'maxshop' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'maxshop' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'maxshop' ) => 'date',
				__( 'ID', 'maxshop' ) => 'ID',
				__( 'Author', 'maxshop' ) => 'author',
				__( 'Title', 'maxshop' ) => 'title',
				__( 'Modified', 'maxshop' ) => 'modified',
				__( 'Random', 'maxshop' ) => 'rand',
				__( 'Comment count', 'maxshop' ) => 'comment_count',
				__( 'Menu order', 'maxshop' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Speed slide', 'maxshop' ),
			'param_name' => 'interval',
			'description' => __( 'Speed for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
		    'heading' => __( 'Effect slide', 'maxshop' ),
			'param_name' => 'effect',
			'value' => array(
				__( 'Slide', 'maxshop' ) => 'slide',
				__( 'Fade', 'maxshop' ) => 'fade',
			),
				'description' => __( 'Effect for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
		    'heading' => __( 'Hover slide', 'maxshop' ),
			'param_name' => 'hover',
			'value' => array(
				__( 'Yes', 'maxshop' ) => 'hover',
				__( 'No', 'maxshop' ) => '',
			),
				'description' => __( 'Hover for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
		    'heading' => __( 'Swipe slide', 'maxshop' ),
			'param_name' => 'swipe',
			'value' => array(
				__( 'Yes', 'maxshop' ) => 'yes',
				__( 'No', 'maxshop' ) => 'no',
			),
				'description' => __( 'Swipe for slide', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns >1200px:', 'maxshop' ),
			'param_name' => 'columns',
			'description' => __( 'Number colums you want display  > 1200px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 768px to 1199px:', 'maxshop' ),
			'param_name' => 'columns1',
			'description' => __( 'Number colums you want display  on 768px to 1199px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 480px to 767px:', 'maxshop' ),
			'param_name' => 'columns2',
			'description' => __( 'Number colums you want display  on 480px to 767px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 321px to 479px:', 'maxshop' ),
			'param_name' => 'columns3',
			'description' => __( 'Number colums you want display  on 321px to 479px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns in 320px or less than:', 'maxshop' ),
			'param_name' => 'columns4',
			'description' => __( 'Number colums you want display  in 320px or less than.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		)
	)
) );
// ytc post slide
vc_map( array(
	'name' => __( 'YA SLIDE POSTS', 'maxshop' ),
	'base' => 'postslide',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display posts-seclect category', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'maxshop' ) => 'title1',
				__( 'Style title 2', 'maxshop' ) => 'title2',
				__( 'Style title 3', 'maxshop' ) => 'title3',
				__( 'Style title 4', 'maxshop' ) => 'title4'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Type post', 'maxshop' ),
			'param_name' => 'type',
			'value' => array(
				'Select type',
				__( 'bottom', 'maxshop' ) => 'bottom',
				__( 'right', 'maxshop' ) => 'right',
				__( 'left', 'maxshop' ) => 'left',
				__( 'out', 'maxshop' ) => 'out'
			),
			'description' => sprintf( __( 'Select different style posts.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'param_name'    => 'categories',
			'type'          => 'dropdown',
			'value'         => $link_category, // here I'm stuck
			'heading'       => __('Category filter:', 'maxshop'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'maxshop' ),
			'param_name' => 'limit',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Excerpt length (in words)', 'maxshop' ),
			'param_name' => 'length',
			'description' => __( 'Excerpt length (in words).', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Speed slide', 'maxshop' ),
			'param_name' => 'interval',
			'description' => __( 'Speed slide', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),
			

			
	)
) );
//// vertical mega menu
vc_map( array(
	'name' => __( 'Ya vertical mega menu', 'maxshop' ),
	'base' => 'ya_mega_menu',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display vertical mega menu', 'maxshop' ),
	'params' => array(
	    array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),	   
		array(
			'type' => 'dropdown',
			'heading' => __( 'Theme shortcode want display', 'maxshop' ),
			'param_name' => 'widget_template',
			'value' => array(
				__( 'default', 'maxshop' ) => 'default',
			),
			'description' => sprintf( __( 'Select different style menu.', 'maxshop' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),			
	)
));
///// Gallery 
vc_map( array(
	'name' => __( 'Ya Gallery', 'maxshop' ),
	'base' => 'gallerys',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'description' => __( 'Animated carousel with images', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'maxshop' )
		),
		array(
			'type' => 'attach_images',
			'heading' => __( 'Images', 'maxshop' ),
			'param_name' => 'ids',
			'value' => '',
			'description' => __( 'Select images from media library.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Gallery size', 'maxshop' ),
			'param_name' => 'size',
			'description' => __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size. If used slides per view, this will be used to define carousel wrapper size.', 'maxshop' )
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Gallery caption', 'maxshop' ),
			'param_name' => 'caption',
			'value' => array(
				__( 'true', 'maxshop' ) => 'true',
				__( 'false', 'maxshop' ) => 'false'
			),
			'description' => __( 'Images display caption true or false', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Gallery type', 'maxshop' ),
			'param_name' => 'type',
			'value' => array(
				__( 'column', 'maxshop' ) => 'column',
				__( 'slide', 'maxshop' ) => 'slide',
				__( 'flex', 'maxshop' ) => 'flex'
			),
			'description' => __( 'Images display type', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Gallery columns', 'maxshop' ),
			'param_name' => 'columns',
			'description' => __( 'Enter gallery columns. Example: 1,2,3,4 ... Only use gallery type="column".', 'maxshop' ),
		    'dependency' => array(
				'element' => 'type',
				'value' => 'column',
			)),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Slider speed', 'maxshop' ),
			'param_name' => 'interval',
			'value' => '5000',
			'description' => __( 'Duration of animation between slides (in ms)', 'maxshop' ),
		    'dependency' => array(
				'element' => 'type',
				'value' => array('slide','flex')
			)),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Gallery event', 'maxshop' ),
			'param_name' => 'event',
			'value' => array(
				__( 'slide', 'maxshop' ) => 'slide',
			),
			'description' => __( 'event slide images', 'maxshop' ),
		 'dependency' => array(
				'element' => 'type',
				'value' => array('slide','flex')
			)),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		)
		)
) );
/////////////////// best sale /////////////////////
vc_map( array(
	'name' => __( 'Ya Best Sale', 'maxshop' ),
	'base' => 'BestSale',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display bestseller', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'maxshop' ),
			'param_name' => 'template',
			'value' => array(
				'Select type',
				__( 'Default', 'maxshop' ) => 'default',
				__( 'Slide', 'maxshop' ) => 'slide',
			),
			'description' => sprintf( __( 'Select different style best sale.', 'maxshop' ) )
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'maxshop' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),	
	)
) );
/////////////////// ya woocommerce slider/////////////////////
vc_map( array(
	'name' => __( 'Ya Woocommerce Slider', 'maxshop' ),
	'base' => 'ya_woocommerce_slider',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display slider product', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'maxshop' ) => 'title1',
				__( 'Style title 2', 'maxshop' ) => 'title2',
				__( 'Style title 3', 'maxshop' ) => 'title3',
				__( 'Style title 4', 'maxshop' ) => 'title4'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
		"type" => "4k_icon",
			"class" => "",
			"heading" => __("Select Icon:", 'maxshop'),
			"param_name" => "icon",
			"admin_label" => true,
			"value" => "android",
			"description" => __("Select the icon from the list.", 'maxshop'),		
			'dependency' => array(
				'element' => 'style_title',
				'value' => 'title4',
			),
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'maxshop' ),
			'param_name' => 'image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'maxshop' )
		),
		array(
			'param_name'    => 'category_id',
			'type'          => 'dropdown',
			'value'         => $product_categories_dropdown, // here I'm stuck
			'heading'       => __('Category filter:', 'maxshop'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of product to show', 'maxshop' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Column', 'maxshop' ),
			'param_name' => 'item_row',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns >1200px:', 'maxshop' ),
			'param_name' => 'col_lg',
			'description' => __( 'Number colums you want display  > 1200px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 768px to 1199px:', 'maxshop' ),
			'param_name' => 'col_md',
			'description' => __( 'Number colums you want display  on 768px to 1199px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 480px to 767px:', 'maxshop' ),
			'param_name' => 'col_sm',
			'description' => __( 'Number colums you want display  on 480px to 767px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 321px to 479px:', 'maxshop' ),
			'param_name' => 'col_xs',
			'description' => __( 'Number colums you want display  on 321px to 479px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns in 320px or less than:', 'maxshop' ),
			'param_name' => 'col_moble',
			'description' => __( 'Number colums you want display  in 320px or less than.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Speed slide', 'maxshop' ),
			'param_name' => 'speed',
			'description' => __( 'Speed for slide', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Interval slide', 'maxshop' ),
			'param_name' => 'interval',
			'description' => __( 'Interval for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Autoplay for slider', 'maxshop' ),
			'param_name' => 'autoplay',
			'value' => array(
				'Select type',
				__( 'Yes', 'maxshop' ) => 'true',
				__( 'No', 'maxshop' ) => 'false',
			),
			'description' => sprintf( __( 'Select autoplay slider or not autoplay slider.', 'maxshop' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number Slider', 'maxshop' ),
			'param_name' => 'number_slided',
			'description' => __( 'Number Slided for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Layout Style', 'maxshop' ),
			'param_name' => 'layout',
			'value' => array(
				'Select layout',
				__( 'Default', 'maxshop' ) => 'default',
				__( 'Child categories product', 'maxshop' ) => 'child-cate',
				__('Left Child Cat','maxshop' )             => 'child-cate-left',
			),
			'description' => sprintf( __( 'Select different style posts.', 'maxshop' ) )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'maxshop' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'maxshop' ) => 'DESC',
				__( 'Ascending', 'maxshop' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'maxshop' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'maxshop' ) => 'date',
				__( 'ID', 'maxshop' ) => 'ID',
				__( 'Author', 'maxshop' ) => 'author',
				__( 'Title', 'maxshop' ) => 'title',
				__( 'Modified', 'maxshop' ) => 'modified',
				__( 'Random', 'maxshop' ) => 'rand',
				__( 'Comment count', 'maxshop' ) => 'comment_count',
				__( 'Menu order', 'maxshop' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),	
	)
) );
/////////////////// Woocommerce Countdown Slider/////////////////////
vc_map( array(
	'name' => __( 'Ya Woocommerce Countdown Slider', 'maxshop' ),
	'base' => 'ya_countdown_slider',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Woocommerce Countdown Slider', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'maxshop' ) => 'title1',
				__( 'Style title 2', 'maxshop' ) => 'title2',
				__( 'Style title 3', 'maxshop' ) => 'title3',
				__( 'Style title 4', 'maxshop' ) => 'title4'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
		"type" => "4k_icon",
			"class" => "",
			"heading" => __("Select Icon:", 'maxshop'),
			"param_name" => "icon",
			"admin_label" => true,
			"value" => "android",
			"description" => __("Select the icon from the list.", 'maxshop'),		
			'dependency' => array(
				'element' => 'style_title',
				'value' => 'title4',
			),
		),
		array(
			'param_name'    => 'category_id',
			'type'          => 'dropdown',
			'value'         => $ya_categories_countdown, // here I'm stuck
			'heading'       => __('Category filter:', 'maxshop'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of product to show', 'maxshop' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns >1200px:', 'maxshop' ),
			'param_name' => 'col_lg',
			'description' => __( 'Number colums you want display  > 1200px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 768px to 1199px:', 'maxshop' ),
			'param_name' => 'col_md',
			'description' => __( 'Number colums you want display  on 768px to 1199px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 480px to 767px:', 'maxshop' ),
			'param_name' => 'col_sm',
			'description' => __( 'Number colums you want display  on 480px to 767px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 321px to 479px:', 'maxshop' ),
			'param_name' => 'col_xs',
			'description' => __( 'Number colums you want display  on 321px to 479px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns in 320px or less than:', 'maxshop' ),
			'param_name' => 'col_moble',
			'description' => __( 'Number colums you want display  in 320px or less than.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Speed slide', 'maxshop' ),
			'param_name' => 'speed',
			'description' => __( 'Speed for slide', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Interval slide', 'maxshop' ),
			'param_name' => 'interval',
			'description' => __( 'Interval for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Autoplay for slider', 'maxshop' ),
			'param_name' => 'autoplay',
			'value' => array(
				'Select type',
				__( 'True', 'maxshop' ) => 'true',
				__( 'False', 'maxshop' ) => 'false',
			),
			'description' => sprintf( __( 'Select autoplay slider or not autoplay slider.', 'maxshop' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number Slided', 'maxshop' ),
			'param_name' => 'number_slided',
			'description' => __( 'Number Slided for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'maxshop' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'maxshop' ) => 'DESC',
				__( 'Ascending', 'maxshop' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'maxshop' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'maxshop' ) => 'date',
				__( 'ID', 'maxshop' ) => 'ID',
				__( 'Author', 'maxshop' ) => 'author',
				__( 'Title', 'maxshop' ) => 'title',
				__( 'Modified', 'maxshop' ) => 'modified',
				__( 'Random', 'maxshop' ) => 'rand',
				__( 'Comment count', 'maxshop' ) => 'comment_count',
				__( 'Menu order', 'maxshop' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),	
	)
) );
/////////////////// ya uspell product slider/////////////////////
vc_map( array(
	'name' => __( 'Ya Upsell product slider', 'maxshop' ),
	'base' => 'uspell_product_slider',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Upsell product slider', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'maxshop' ),
			'param_name' => 'image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'maxshop' )
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of product to show', 'maxshop' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns >1200px:', 'maxshop' ),
			'param_name' => 'col_lg',
			'description' => __( 'Number colums you want display  > 1200px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 768px to 1199px:', 'maxshop' ),
			'param_name' => 'col_md',
			'description' => __( 'Number colums you want display  on 768px to 1199px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 480px to 767px:', 'maxshop' ),
			'param_name' => 'col_sm',
			'description' => __( 'Number colums you want display  on 480px to 767px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 321px to 479px:', 'maxshop' ),
			'param_name' => 'col_xs',
			'description' => __( 'Number colums you want display  on 321px to 479px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns in 320px or less than:', 'maxshop' ),
			'param_name' => 'col_moble',
			'description' => __( 'Number colums you want display  in 320px or less than.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Speed slide', 'maxshop' ),
			'param_name' => 'speed',
			'description' => __( 'Speed for slide', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Interval slide', 'maxshop' ),
			'param_name' => 'interval',
			'description' => __( 'Interval for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Autoplay for slider', 'maxshop' ),
			'param_name' => 'autoplay',
			'value' => array(
				'Select type',
				__( 'True', 'maxshop' ) => 'true',
				__( 'False', 'maxshop' ) => 'false',
			),
			'description' => sprintf( __( 'Select autoplay slider or not autoplay slider.', 'maxshop' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number Slided', 'maxshop' ),
			'param_name' => 'number_slided',
			'description' => __( 'Number Slided for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'maxshop' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'maxshop' ) => 'date',
				__( 'ID', 'maxshop' ) => 'ID',
				__( 'Author', 'maxshop' ) => 'author',
				__( 'Title', 'maxshop' ) => 'title',
				__( 'Modified', 'maxshop' ) => 'modified',
				__( 'Random', 'maxshop' ) => 'rand',
				__( 'Comment count', 'maxshop' ) => 'comment_count',
				__( 'Menu order', 'maxshop' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),	
	)
) );
/////////////////// ya related_product_slider/////////////////////
vc_map( array(
	'name' => __( 'Ya Related Product Slider', 'maxshop' ),
	'base' => 'related_product_slider',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Related Product Slider', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'attach_image',
			'heading' => __( 'Image', 'maxshop' ),
			'param_name' => 'image',
			'value' => '',
			'description' => __( 'Select image from media library.', 'maxshop' )
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of product to show', 'maxshop' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns >1200px:', 'maxshop' ),
			'param_name' => 'col_lg',
			'description' => __( 'Number colums you want display  > 1200px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 768px to 1199px:', 'maxshop' ),
			'param_name' => 'col_md',
			'description' => __( 'Number colums you want display  on 768px to 1199px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 480px to 767px:', 'maxshop' ),
			'param_name' => 'col_sm',
			'description' => __( 'Number colums you want display  on 480px to 767px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 321px to 479px:', 'maxshop' ),
			'param_name' => 'col_xs',
			'description' => __( 'Number colums you want display  on 321px to 479px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns in 320px or less than:', 'maxshop' ),
			'param_name' => 'col_moble',
			'description' => __( 'Number colums you want display  in 320px or less than.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Speed slide', 'maxshop' ),
			'param_name' => 'speed',
			'description' => __( 'Speed for slide', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Interval slide', 'maxshop' ),
			'param_name' => 'interval',
			'description' => __( 'Interval for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Autoplay for slider', 'maxshop' ),
			'param_name' => 'autoplay',
			'value' => array(
				'Select type',
				__( 'True', 'maxshop' ) => 'true',
				__( 'False', 'maxshop' ) => 'false',
			),
			'description' => sprintf( __( 'Select autoplay slider or not autoplay slider.', 'maxshop' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number Slided', 'maxshop' ),
			'param_name' => 'number_slided',
			'description' => __( 'Number Slided for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'maxshop' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'maxshop' ) => 'date',
				__( 'ID', 'maxshop' ) => 'ID',
				__( 'Author', 'maxshop' ) => 'author',
				__( 'Title', 'maxshop' ) => 'title',
				__( 'Modified', 'maxshop' ) => 'modified',
				__( 'Random', 'maxshop' ) => 'rand',
				__( 'Comment count', 'maxshop' ) => 'comment_count',
				__( 'Menu order', 'maxshop' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),	
	)
) );

/////////////////// Our Brand slider/////////////////////
vc_map( array(
	'name' => __( 'Ya Our Brand Slider', 'maxshop' ),
	'base' => 'our_brand_slider',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Our Brand Slider', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'maxshop' ) => 'title1',
				__( 'Style title 2', 'maxshop' ) => 'title2',
				__( 'Style title 3', 'maxshop' ) => 'title3',
				__( 'Style title 4', 'maxshop' ) => 'title4'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of post to show', 'maxshop' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns >1200px:', 'maxshop' ),
			'param_name' => 'col_lg',
			'description' => __( 'Number colums you want display  > 1200px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 768px to 1199px:', 'maxshop' ),
			'param_name' => 'col_md',
			'description' => __( 'Number colums you want display  on 768px to 1199px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 480px to 767px:', 'maxshop' ),
			'param_name' => 'col_sm',
			'description' => __( 'Number colums you want display  on 480px to 767px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 321px to 479px:', 'maxshop' ),
			'param_name' => 'col_xs',
			'description' => __( 'Number colums you want display  on 321px to 479px.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns in 320px or less than:', 'maxshop' ),
			'param_name' => 'col_moble',
			'description' => __( 'Number colums you want display  in 320px or less than.', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Speed slide', 'maxshop' ),
			'param_name' => 'speed',
			'description' => __( 'Speed for slide', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Interval slide', 'maxshop' ),
			'param_name' => 'interval',
			'description' => __( 'Interval for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Autoplay for slider', 'maxshop' ),
			'param_name' => 'autoplay',
			'value' => array(
				'Select type',
				__( 'True', 'maxshop' ) => 'true',
				__( 'False', 'maxshop' ) => 'false',
			),
			'description' => sprintf( __( 'Select autoplay slider or not autoplay slider.', 'maxshop' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number Slided', 'maxshop' ),
			'param_name' => 'number_slided',
			'description' => __( 'Number Slided for slide', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Layout shortcode want display', 'maxshop' ),
			'param_name' => 'layout',
			'value' => array(
				'Select layout',
				__( 'Default', 'maxshop' ) => 'default',
			),
			'description' => sprintf( __( 'Select different style posts.', 'maxshop' ) )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'maxshop' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'maxshop' ) => 'DESC',
				__( 'Ascending', 'maxshop' ) => 'ASC'
			),
			'description' => sprintf( __( 'Designates the ascending or descending order. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'maxshop' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'maxshop' ) => 'date',
				__( 'ID', 'maxshop' ) => 'ID',
				__( 'Author', 'maxshop' ) => 'author',
				__( 'Title', 'maxshop' ) => 'title',
				__( 'Modified', 'maxshop' ) => 'modified',
				__( 'Random', 'maxshop' ) => 'rand',
				__( 'Comment count', 'maxshop' ) => 'comment_count',
				__( 'Menu order', 'maxshop' ) => 'menu_order'
			),
			'description' => sprintf( __( 'Select how to sort retrieved posts. More at %s.', 'maxshop' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'maxshop' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'maxshop' )
		),	
	)
) );
/////////////////// Pricing Table/////////////////////
vc_map( array(
	'name' => __( 'Ya Pricing Table', 'maxshop' ),
	'base' => 'pricing',
	'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
	'category' => __( 'Ya Shortcode', 'maxshop' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Pricing Table', 'maxshop' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'maxshop' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'maxshop' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'maxshop' ) => 'title1',
				__( 'Style title 2', 'maxshop' ) => 'title2',
				__( 'Style title 3', 'maxshop' ) => 'title3',
				__( 'Style title 4', 'maxshop' ) => 'title4'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'maxshop' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'style for table', 'maxshop' ),
			'param_name' => 'style',
			'value' => array(
				'Select style',
				__('Pricing table','maxshop') => 'vprice'
			),
			'description' => sprintf( __( 'Select style for table.', 'maxshop' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Description for table', 'maxshop' ),
			'param_name' => 'description',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Plan or title', 'maxshop' ),
			'param_name' => 'plan',
			'description' => __( 'Plan or title of table', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Cost', 'maxshop' ),
			'param_name' => 'cost',
			'description' => __( 'Cost of table', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Currency', 'maxshop' ),
			'param_name' => 'currency',
			'description' => __( 'Currency of cost on table', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Percent of MONTH', 'maxshop' ),
			'param_name' => 'per',
			'description' => __( 'Percent of MONTH', 'maxshop' )
		),
		array(
		    'type'=>'textarea_html',
			'heading' => __('Content need show','maxshop'),
			'param_name' => 'content',
			'description' => __( 'Display content', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Button link', 'maxshop' ),
			'param_name' => 'button_url',
			'description' => __( 'Button link', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'button text', 'maxshop' ),
			'param_name' => 'button_text',
			'description' => __( 'Button text', 'maxshop' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'button target', 'maxshop' ),
			'param_name' => 'button_target',
			'description' => __( 'Display button target', 'maxshop' )
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'button rel', 'maxshop' ),
			'param_name' => 'button_rel',
			'description' => __( 'button rel', 'maxshop' )
		),
			
	)
) );
}
?>