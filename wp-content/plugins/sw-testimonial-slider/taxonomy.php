<?php
add_action('init', 'testimonial_register');
function testimonial_register() {

	$labels = array(
		'name' => _x('Testimonial', 'post type general name'),
		'singular_name' => _x('News Item', 'post type singular name'),
		'add_new' => _x('Add New', 'News item'),
		'add_new_item' => __('Add New News Item'),
		'edit_item' => __('Edit News Item'),
		'new_item' => __('New News Item'),
		'view_item' => __('View News Item'),
		'search_items' => __('Search News'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
        'has_archive' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => 'dashicons-welcome-write-blog',
		'rewrite' =>  true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'menu_position' => 4,
		'supports' => array('title','thumbnail','revisions','editor')
	  );

	register_post_type( 'testimonial' , $args );
}
add_action("admin_init", "testimonial_init");
function testimonial_init(){
	add_meta_box("Testimonial Options", "Testimonial Options", "testimonial_detail", "testimonial", "normal", "low");
	}
function testimonial_detail(){
	global $post;
	$au_name = get_post_meta( $post->ID, 'au_name', true );
	$au_url  = get_post_meta( $post->ID, 'au_url', true );
	$au_info = get_post_meta( $post->ID, 'au_info', true );
?>	
	<p><label><b><?php _e('Author Name', 'yatheme'); ?>:</b></label><br/>
		<input type ="text" name = "au_name" value ="<?php echo $au_name;?>" size="70%" /></p>
	<p><label><b><?php _e('Author URL', 'yatheme'); ?>:</b></label><br/>
		<input type ="text" name = "au_url" value ="<?php echo $au_url;?>" size="70%" /></p>
	<p><label><b><?php _e('Author Infomation', 'yatheme'); ?>:</b></label><br/>
		<input type ="text" name = "au_info" value ="<?php echo $au_info;?>" size="70%" /></p>
<?php }
add_action( 'save_post', 'testimonial_save_meta', 10, 1 );
function testimonial_save_meta(){
	global $post;
	$list_meta = array('au_name', 'au_url', 'au_info');
	foreach( $list_meta as $meta ){
		if( isset( $_POST[$meta] ) && $_POST[$meta] != '' ){
			update_post_meta($post->ID, $meta, $_POST[$meta]);
		}
	}
}
?>