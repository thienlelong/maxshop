<?php
$instance = array();

// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );

// int or array
if ( array_key_exists('categories', $new_instance) ){
	if ( is_array($new_instance['categories']) ){
		$instance['categories'] = array_map( 'intval', $new_instance['categories'] );
	} else {
		$instance['categories'] = intval( $new_instance['categories'] );
	}
}

$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );