<?php
/*
 *
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 * Also if running on windows you may have url problems, which can be fixed by defining the framework url first
 *
 */
//define('YA_OPTIONS_URL', site_url('path the options folder'));
if(!class_exists('YA_Options')){
	require_once( dirname( __FILE__ ) . '/options/options.php' );
}

function add_field_rights($field, $options){
	// var_dump($id , $options->options);
	
	if ( key_exists( $field['id'], array( 'show-cpanel' => '1', 'widget-advanced' => '1' )) || key_exists( $field['type'], array( 'upload' => '1' )) ) {
		return;
	}
	
	// build id for customize_right
	// get value from $options->options[ id ]
	$customize = array(
			'id' => $field['id'].'_customize_allow',
			'type' => 'checkbox',
			'title' => 'x',
			'sub_desc' => '',
  			'desc' => '',
			'sub_option' => true
			);
	$options->_field_input($customize);
	
	// build id for cpanel right
		
//		$default = '';
//		if ( key_exists( $field['id'], array( 'scheme' => '1', 'responsive_support' => '1', 'menu_type' => '1', 'theme_layout' => '1', 'sidebar_left_expand' => '1', 'sidebar_right_expand' => '1' )) )  {
//			$default = 1;
//		}
		
		$cpanel = array(
			'id' => $field['id'].'_cpanel_allow',
			'type' => 'checkbox',
			'title' => 'x',
			'sub_desc' => '',
  			'desc' => '',
			'std' => false,
			'sub_option' => true
			);
		$options->_field_input($cpanel);
		
}
if ( is_admin()){
	add_filter('ya-opts-rights', 'add_field_rights', 10, 2);
}

function ya_options(){
	global $ya_options;
	return $ya_options;
}

$add_query_vars = array();
function ya_query_vars( $qvars ){
	global $options, $add_query_vars;
	
	foreach ($options as $option) {
		if (isset($option['fields'])) {
			
			foreach ($option['fields'] as $field) {
				$add_query_vars[] = $field['id'];
			}
		}
	}
	
	if ( is_array($add_query_vars) ){
		foreach ( $add_query_vars as $field ){
			$qvars[] = $field;
		}
	}
	
	return $qvars;
}

function ya_parse_request( &$wp ){
	global $add_query_vars, $options_args;
	
	if ( is_array($add_query_vars) ){
		foreach ( $add_query_vars as $field ){
			if ( array_key_exists($field, $wp->query_vars) ){
				$current_value = ya_options()->get($field);
				$request_value = $wp->query_vars[$field];
				$field_name = $options_args['opt_name'] . '_' . $field;
				if ($request_value != $current_value){
					setcookie(
						$field_name,
						$request_value,
						time() + 86400,
						'/',
						COOKIE_DOMAIN,
						0
					);
					if (!isset($_COOKIE[$field_name]) || $request_value != $_COOKIE[$field_name]){
						$_COOKIE[$field_name] = $request_value;
					}
					
					//$url = curPageURL();
					//header("Refresh: 0; url=$url");
					//exit();
				}
			}
		}
	}
}

function curPageURL() {
	$pageURL = 'http';
	
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	return $pageURL;
}

if (!is_admin()){
	add_filter('query_vars', 'ya_query_vars');
	add_action('parse_request', 'ya_parse_request');
}
?>