<?php
add_action('init', 'team_register');
function team_register() {

	$labels = array(
		'name' => _x('Our Team', 'post type general name'),
		'singular_name' => _x('News Item', 'post type singular name'),
		'add_new' => _x('Add New', 'Team item'),
		'add_new_item' => __('Add New Team Item'),
		'edit_item' => __('Edit Team Item'),
		'new_item' => __('New Team Item'),
		'view_item' => __('View Team Item'),
		'search_items' => __('Search Team'),
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
		'menu_icon' => 'dashicons-id',
		'rewrite' =>  true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 4,
		'supports' => array('title','thumbnail','author','revisions','editor')
	  );

	register_post_type( 'team' , $args );
}
add_action("admin_init", "team_init");
function team_init(){
	add_meta_box("Our Team Detail", "Our Team Detail", "team_detail", "team", "normal", "low");
	}
function team_detail(){
	global $post;
	$facebook = get_post_meta( $post->ID, 'facebook', true );	
	$twitter = get_post_meta( $post->ID, 'twitter', true );
	$gplus = get_post_meta( $post->ID, 'gplus', true );
	$linkedin = get_post_meta( $post->ID, 'linkedin', true );
	$team_info = get_post_meta( $post->ID, 'team_info', true );
?>	
	<div>
	<h3><?php _e( 'Social', 'yatheme' ); ?></h3>
		<p><label><b><?php _e('Facebook', 'yatheme'); ?>:</b></label><br/>
			<input type ="text" name = "facebook" value ="<?php echo esc_attr( $facebook );?>" size="80%" />
		</p>
		<p><label><b><?php _e('Twitter', 'yatheme'); ?>:</b></label><br/>
			<input type ="text" name = "twitter" value ="<?php echo esc_attr( $twitter );?>" size="80%" />
		</p>
		<p><label><b><?php _e('Google Plus', 'yatheme'); ?>:</b></label><br/>
			<input type ="text" name = "gplus" value ="<?php echo esc_attr( $gplus );?>" size="80%" />
		</p>
		<p><label><b><?php _e('Linkedin', 'yatheme'); ?>:</b></label><br/>
			<input type ="text" name = "linkedin" value ="<?php echo esc_attr( $linkedin );?>" size="80%" />
		</p>
	</div>
	<div>
		<p><label><b><?php _e('Member Infomation', 'yatheme'); ?>:</b></label><br/>
			<input type ="text" name = "team_info" value ="<?php echo esc_attr( $team_info );?>" size="80%" />
		</p>
	</div>
<?php }
add_action( 'save_post', 'team_save_meta', 10, 1 );
function team_save_meta(){
	global $post;
	$list_meta = array('facebook', 'twitter', 'gplus', 'linkedin', 'team_info');
	foreach( $list_meta as $meta ){
		if( isset( $_POST[$meta] ) && $_POST[$meta] != '' ){
			update_post_meta($post->ID, $meta, $_POST[$meta]);
		}
	}
}
?>