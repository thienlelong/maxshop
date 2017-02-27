<?php
class Ya_Resmenu{
	function __construct(){
		add_filter( 'wp_nav_menu_args' , array( $this , 'Ya_MenuRes_AdFilter' ), 100 ); 
		add_filter( 'wp_nav_menu_args' , array( $this , 'Ya_MenuRes_Filter' ), 110 );	
		add_action( 'wp_footer', array( $this  , 'Ya_MenuRes_AdScript' ), 110 );	
	}
	function Ya_MenuRes_AdScript(){
		$html  = '<script type="text/javascript">';
		$html .= '(function($) {
			/* Responsive Menu */
			$(document).ready(function(){
				$( ".show-dropdown" ).each(function(){
					$(this).on("click", function(){
						$(this).toggleClass("show");
						var $element = $(this).parent().find( "> ul" );
						$element.toggle( 300 );
					});
});
});
})(jQuery);';
$html .= '</script>';
echo $html;
}
function Ya_MenuRes_AdFilter( $args ){
		// var_dump( $args['theme_location'] );
	$args['container'] = false;
	if( $args['theme_location'] != '' ) :
		if( isset( $args['ya_resmenu'] ) && $args['ya_resmenu'] == true ) {
			return $args;
		}		
		$ResNavMenu = $this->ResNavMenu( $args );
		$args['container'] = '';
		$args['container_class'].= '';	
		$args['menu_class'].= ($args['menu_class'] == '' ? '' : ' ') . 'flytheme-menures';			
		$args['items_wrap']	= '<ul id="%1$s" class="%2$s">%3$s</ul>'.$ResNavMenu;
		endif;
		return $args;
	}
	function ResNavMenu( $args ){
		$args['ya_resmenu'] = true;		
		$select = wp_nav_menu( $args );
		return $select;
	}
	function Ya_MenuRes_Filter( $args ){
		if( !isset( $args['ya_resmenu'] ) ){
			return $args;
		}
		$args['container'] = false;
		if( $args['theme_location'] != '' ) :
			$args['container'] = 'div';
		$args['container_class'].= 'resmenu-container';
		$args['items_wrap']	= '<div id="ResMenu_'.  $args['theme_location'] .'" class="menu-responsive-wrapper"><ul id="%1$s" class="%2$s">%3$s</ul></div>';	
		$args['menu_class'] = 'ya_resmenu';
		$args['walker'] = new ya_ResMenu_Walker();
		endif;
		return $args;
	}
}
class ya_ResMenu_Walker extends Walker_Nav_Menu {
	function check_current($classes) {
		return preg_match('/(current[-_])|active|dropdown/', $classes);
	}

	function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "\n<ul class=\"dropdown-resmenu\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$item_html = '';
		parent::start_el($item_html, $item, $depth, $args);
		if( !$item->is_dropdown && ($depth === 0) ){
			$item_html = str_replace('<a', '<a class="item-link"', $item_html);			
			$item_html = str_replace('</a>', '</a>', $item_html);			
		}
		if ( $item->is_dropdown ) {
			$item_html = str_replace('<a', '<a class="item-link dropdown-toggle"', $item_html);
			$item_html = str_replace('</a>', '</a>', $item_html);
			$item_html .= '<span class="show-dropdown"></span>';
		}
		$output .= $item_html;
	}

	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		$element->is_dropdown = !empty($children_elements[$element->ID]);
		if ($element->is_dropdown) {			
			$element->classes[] = 'res-dropdown';
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}
new Ya_Resmenu();