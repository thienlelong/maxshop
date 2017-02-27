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

if ( array_key_exists('orderby', $new_instance) ){
	$instance['orderby'] = strip_tags( $new_instance['orderby'] );
}

if ( array_key_exists('order', $new_instance) ){
	$instance['order'] = strip_tags( $new_instance['order'] );
}

if ( array_key_exists('number', $new_instance) ){
	$instance['number'] = intval( $new_instance['number'] );
}

if ( array_key_exists('exclude', $new_instance) ){
	$instance['exclude'] = strip_tags( $new_instance['exclude'] );
}

$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );