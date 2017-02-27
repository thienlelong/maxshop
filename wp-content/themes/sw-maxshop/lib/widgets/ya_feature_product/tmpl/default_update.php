<?php
$instance = array();

// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );

$instance['attribute'] 		= strip_tags( $new_instance['attribute'] );

$instance['length'] 		= intval( $new_instance['length'] );
// int or array

if ( array_key_exists('numberposts', $new_instance) ){
	$instance['numberposts'] = intval( $new_instance['numberposts'] );
}

$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );