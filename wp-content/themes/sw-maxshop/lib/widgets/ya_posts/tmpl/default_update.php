<?php
$instance = array();

// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );

// int or array
if ( array_key_exists('category', $new_instance) ){
	if ( is_array($new_instance['category']) ){
		$instance['category'] = array_map( 'intval', $new_instance['category'] );
	} else {
		$instance['category'] = intval( $new_instance['category'] );
	}
}

if ( array_key_exists('orderby', $new_instance) ){
	$instance['orderby'] = strip_tags( $new_instance['orderby'] );
}

if ( array_key_exists('order', $new_instance) ){
	$instance['order'] = strip_tags( $new_instance['order'] );
}

if ( array_key_exists('numberposts', $new_instance) ){
	$instance['numberposts'] = intval( $new_instance['numberposts'] );
}


if ( array_key_exists('include', $new_instance) ){
	$instance['include'] = strip_tags( $new_instance['include'] );
}


if ( array_key_exists('exclude', $new_instance) ){
	$instance['exclude'] = strip_tags( $new_instance['exclude'] );
}

if ( array_key_exists('length', $new_instance) ){
	$instance['length'] = intval( $new_instance['length'] );
}

$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );