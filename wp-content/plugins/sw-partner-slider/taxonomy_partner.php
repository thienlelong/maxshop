<?php
add_action('init', 'partner_register');
function partner_register() {

	$labels = array(
		'name' => _x('Partner', 'post type general name'),
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
		'menu_icon' => 'dashicons-groups',
		'rewrite' =>  true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 4,
		'supports' => array('title','thumbnail','author','revisions')
	  );

	register_post_type( 'partner' , $args );

	register_taxonomy("partners", array("partner"), array("hierarchical" => false, "label" => "Categories Partner", "singular_label" => "partner", 'rewrite' => true));
}
add_action("admin_init", "partner_init");
function partner_init(){
	add_meta_box("Partner Detail", "Partner Detail", "partner_detail", "partner", "normal", "low");
	}
function partner_detail(){
	global $post;
	$link = get_post_meta( $post->ID, 'link', true );
	$target = get_post_meta( $post->ID, 'target', true );
	$description = get_post_meta( $post->ID, 'description', true );
	$tg_link = array( '_blank' => 'Blank', '_self' => 'Self', '_parent' => 'Parent', '_top' => 'Top' );
?>	
	<p><label><b><?php _e('Partner Link', 'yatheme'); ?>:</b></label><br/>
		<input type ="text" name = "link" value ="<?php echo $link;?>" size="100%" /></p>
	<p><label><b><?php _e('Partner Link Target', 'yatheme'); ?>:</b></label><br/>
		<select name="target">
			<?php
				$option ='';
				foreach ($tg_link as $value => $key) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $target){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
		</select>
	</p>
	<p><label><b><?php _e('Partner Description', 'yatheme'); ?>:</b></label><br/>
		<textarea type ="text" name = "description"rows="2" cols="100" /> <?php echo $description; ?></textarea></p>
<?php }
add_action( 'save_post', 'partner_save_meta', 10, 1 );
function partner_save_meta(){
	global $post;
	$list_meta = array('link', 'target', 'description');
	foreach( $list_meta as $meta ){
		if( isset( $_POST[$meta] ) && $_POST[$meta] != '' ){
			update_post_meta($post->ID, $meta, $_POST[$meta]);
		}
	}
}
?>