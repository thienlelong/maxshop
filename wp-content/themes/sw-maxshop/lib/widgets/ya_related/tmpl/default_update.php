<?php
$instance = array();

// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );

// int or array

if ( array_key_exists('showposts', $new_instance) ){
	$instance['showposts'] = intval( $new_instance['showposts'] );
}

if ( array_key_exists('length', $new_instance) ){
	$instance['length'] = intval( $new_instance['length'] );
}

$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );