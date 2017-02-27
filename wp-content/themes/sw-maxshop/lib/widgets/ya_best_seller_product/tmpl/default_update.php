<?php
$instance = array();

// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );
$instance['el_class']=strip_tags($new_instance['el_class']);
$instance['style_title']=strip_tags($new_instance['style_title']);
// int or array

if ( array_key_exists('numberposts', $new_instance) ){
	$instance['numberposts'] = intval( $new_instance['numberposts'] );
}

$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );