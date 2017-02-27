<?php
$instance = array();

// strip tag on text field
$instance['title'] = strip_tags( $new_instance['title'] );

// int or array

if ( array_key_exists('menu_locate', $new_instance) ){
	$instance['menu_locate'] = strip_tags( $new_instance['menu_locate'] );
}
$instance['widget_template'] = strip_tags( $new_instance['widget_template'] );