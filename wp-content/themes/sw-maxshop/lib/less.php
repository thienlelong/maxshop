<?php
require_once locate_template('/lib/3rdparty/lessc.inc.php');

if ( class_exists('lessc') && ya_options()->getCpanelValue('developer_mode') ){
	define('LESS_PATH', get_template_directory().'/assets/less');
	define('CSS__PATH', get_template_directory().'/css');
	
	$scheme = ya_options()->getCpanelValue('scheme');
	$ya_direction = ya_options()->getCpanelValue( 'direction' );
	$scheme_vars = get_template_directory().'/templates/presets/default.php';
	$output_cssf = CSS__PATH.'/app-default.css';
	if ( $scheme && file_exists(get_template_directory().'/templates/presets/'.$scheme.'.php') ){
		$scheme_vars = get_template_directory().'/templates/presets/'.$scheme.'.php';
		$output_cssf = CSS__PATH."/app-{$scheme}.css";
	}
	if ( file_exists($scheme_vars) ){
		include $scheme_vars;
		try {
			
			$less = new lessc();			
			
			$less->setImportDir( array(LESS_PATH.'/app/', LESS_PATH.'/bootstrap/') );
			
			$less->setVariables($less_variables);
			
			$cache = $less->cachedCompile(LESS_PATH.'/app.less');
			file_put_contents($output_cssf, $cache["compiled"]);
			/* RTL Language */
			if ( is_rtl() || $ya_direction == 'rtl'  ){
				$rtl_cache = $less->cachedCompile(LESS_PATH.'/app/rtl.less');
				file_put_contents(CSS__PATH.'/rtl.css', $rtl_cache["compiled"]);
			}
			
			$responsive_cache = $less->cachedCompile(LESS_PATH.'/app-responsive.less');
			file_put_contents(CSS__PATH.'/app-responsive.css', $responsive_cache["compiled"]);

		} catch (Exception $e){
			var_dump($e); exit;
		}
	}
}