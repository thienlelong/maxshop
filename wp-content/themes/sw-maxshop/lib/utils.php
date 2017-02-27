<?php
/**
 * Theme wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */




/* Style Background */
function style_bg(){ 
	
	$img =  ya_options()->getCpanelValue('bg_img');
	$color = ya_options()->getCpanelValue('bg_color');
	$repeat = ya_options()->getCpanelValue('bg_repeat');
	$layout = ya_options()->getCpanelValue('layout');
	$bg_image = ya_options()->getCpanelValue('bg_box_img');
	$img = isset($img) ? $img : '';
	$color = isset($color) ? $color : '';
	$repeat = isset($repeat) ? 'repeat' : 'no-repeat';
	
	if ( !empty($img) && strpos($img, 'bg-demo') === false ) {
		
	} elseif ( !empty($img) && strpos($img, 'bg-demo') == 0 ) {
		$img = get_template_directory_uri() . '/assets/img/' . $img . '.png';
	}
	
	if (strpos($color, '#') != 0) {
		$color = '#' . $color;
	} 
	if( $img != '' || $layout == 'boxed' ){
	?>

	<style>
		body{
			background-image: url('<?php echo esc_attr( $img ); ?>');
			background-color: <?php echo esc_html( $color ); ?>;
			background-repeat: <?php echo esc_html( $repeat ); ?>;
			<?php if( $layout == 'boxed' ){ ?>
				background-image: url('<?php echo esc_attr( $bg_image ); ?>');
				background-position: top center; 
				background-attachment: fixed;					
			<?php }	?>
		}
	</style>
	
	<?php 
	}
	return '';
}
add_filter('wp_head', 'style_bg');


/**
 * Page titles
 */
function ya_title() {
	if (is_home()) {
		if (get_option('page_for_posts', true)) {
			echo get_the_title(get_option('page_for_posts', true));
		} else {
			_e('Latest Posts', 'maxshop');
		}
	} elseif (is_archive()) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if ($term) {
			echo $term->name;
		} elseif (is_post_type_archive()) {
			echo get_queried_object()->labels->name;
		} elseif (is_day()) {
			printf(__('Daily Archives: %s', 'maxshop'), get_the_date());
		} elseif (is_month()) {
			printf(__('Monthly Archives: %s', 'maxshop'), get_the_date('F Y'));
		} elseif (is_year()) {
			printf(__('Yearly Archives: %s', 'maxshop'), get_the_date('Y'));
		} elseif (is_author()) {
			printf(__('Author Archives: %s', 'maxshop'), get_the_author());
		} else {
			single_cat_title();
		}
	} elseif (is_search()) {
		printf(__('Search Results for <small>%s</small>', 'maxshop'), get_search_query());
	} elseif (is_404()) {
		_e('Not Found', 'maxshop');
	} else {
		the_title();
	}
}


/**
 * Return WordPress subdirectory if applicable
 */
function wp_base_dir() {
	preg_match('!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches);
	if (count($matches) === 3) {
		return end($matches);
	} else {
		return '';
	}
}

/**
 * Opposite of built in WP functions for trailing slashes
 */
function leadingslashit($string) {
	return '/' . unleadingslashit($string);
}

function unleadingslashit($string) {
	return ltrim($string, '/');
}

function add_filters($tags, $function) {
	foreach($tags as $tag) {
		add_filter($tag, $function);
	}
}

function is_element_empty($element) {
	$element = trim($element);
	return empty($element) ? false : true;
}

function is_customize(){
	return isset($_POST['customized']) && ( isset($_POST['customize_messenger_chanel']) || isset($_POST['wp_customize']) );
}

function is_ajax_ya(){
	return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

/**
 * Create HTML list checkbox of nav menu items.
 */

class YA_Menu_Checkbox extends Walker_Nav_Menu{
	
	private $menu_slug;
	//private $field_id;
	//private $field_value;
	//public static $menu_ids = array();
	
	public function __construct( $menu_slug = '') {
		$this->menu_slug = $menu_slug;
		//$this->field_name = $field_name;
		//$this->field_value = $field_value;
		
		//add_filter('wp_nav_menu', array($this, 'ya_wp_nav_menu'), 10, 2);
	}
	
	public function init($items, $args = array()) {
		$args = array( $items, 0, $args );
		
		return call_user_func_array( array($this, 'walk'), $args );
	}
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		
		//$field_id = $this->field_id . '-' . $item->ID ;
		//$field_name = $this->field_name . '[' . $item->ID . ']' ;
		
		//if ( isset($this->field_value[$item->ID]) ) {
			//$checked = 'checked="checked"';
		//} else $checked = '';post_name
		
		$item_output = '<label for="' . $this->menu_slug . '-' . $item->post_name . '-' . $item->ID . '">';
		$item_output .= '<input type="checkbox" name="' . $this->menu_slug . '_'  . $item->post_name .  '_' . $item->ID . '" ' . $this->menu_slug.$item->post_name.$item->ID . ' id="' . $this->menu_slug . '-'  . $item->post_name . '-' . $item->ID . '" /> ' . $item->title;
		$item_output .= '</label>';

		$output .= $item_output;
	}
	
	public function is_menu_item_active($menu_id, $item_ids) {
		global $wp_query;

		$queried_object = $wp_query->get_queried_object();
		$queried_object_id = (int) $wp_query->queried_object_id;
	
		$items = wp_get_nav_menu_items($menu_id);
		$items_current = array();
		$possible_object_parents = array();
		$home_page_id = (int) get_option( 'page_for_posts' );
		
		if ( $wp_query->is_singular && ! empty( $queried_object->post_type ) && ! is_post_type_hierarchical( $queried_object->post_type ) ) {
			foreach ( (array) get_object_taxonomies( $queried_object->post_type ) as $taxonomy ) {
				if ( is_taxonomy_hierarchical( $taxonomy ) ) {
					$terms = wp_get_object_terms( $queried_object_id, $taxonomy, array( 'fields' => 'ids' ) );
					if ( is_array( $terms ) ) {
						$possible_object_parents = array_merge( $possible_object_parents, $terms );
					}
				}
			}
		}
		
		foreach ($items as $item) {
			
			if (key_exists($item->ID, $item_ids)) {
				$items_current[] = $item;
			}
		}
		
		foreach ($items_current as $item) {
			
			if ( ($item->object_id == $queried_object_id) && (
						( ! empty( $home_page_id ) && 'post_type' == $item->type && $wp_query->is_home && $home_page_id == $item->object_id ) ||
						( 'post_type' == $item->type && $wp_query->is_singular ) ||
						( 'taxonomy' == $item->type && ( $wp_query->is_category || $wp_query->is_tag || $wp_query->is_tax ) && $queried_object->taxonomy == $item->object )
					)
				)
				return true;
			elseif ( $wp_query->is_singular &&
					'taxonomy' == $item->type &&
					in_array( $item->object_id, $possible_object_parents ) ) {
				return true;
			} elseif ( 'custom' == $item->object ) {
				$_root_relative_current = untrailingslashit( $_SERVER['REQUEST_URI'] );
				$current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_root_relative_current );
				$raw_item_url = strpos( $item->url, '#' ) ? substr( $item->url, 0, strpos( $item->url, '#' ) ) : $item->url;
				$item_url = untrailingslashit( $raw_item_url );
				$_indexless_current = untrailingslashit( preg_replace( '/index.php$/', '', $current_url ) );
	
				if ( $raw_item_url && in_array( $item_url, array( $current_url, $_indexless_current, $_root_relative_current ) ) )
					return true;
			}
		}
		
		return false;
	}
}
/**
 * Check widget display
 * */
function check_wdisplay ($widget_display){
	$widget_display = json_decode(json_encode($widget_display), true);
	$YA_Menu_Checkbox = new YA_Menu_Checkbox;
	if ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'all' ) {
		return true;
	}else{
	if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
		if(  isset($widget_display['display_language']) && strcmp($widget_display['display_language'], ICL_LANGUAGE_CODE) != 0  ){
			return false;
		}
	}
	if ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'if_selected' ) {
		
		if (isset($widget_display['checkbox'])) {
			
			if (isset($widget_display['checkbox']['users'])) {
				global $user_ID;
				
				foreach ($widget_display['checkbox']['users'] as $key => $value) {
					
					if ( ($key == 'login' && $user_ID) || ($key == 'logout' && !$user_ID) ){
						
						if (isset($widget_display['checkbox']['general'])) {
							foreach ($widget_display['checkbox']['general'] as $key => $value) {
								$is = 'is_'.$key;
								if ( $is() === true ) return true;
							}
						}
						
						if (isset($widget_display['taxonomy-slugs'])) {
							
							$taxonomy_slugs = preg_split('/[\s,]/', $widget_display['taxonomy-slugs']);
							foreach ($taxonomy_slugs as $slug) {is_post_type_archive('product_cat');
								if (!empty($slug) && is_tax($slug) === true) {
									return true;
								}
							}
						
						}
						
						if (isset($widget_display['post-type'])) {
							$post_type = preg_split('/[\s,]/', $widget_display['post-type']);
							
							foreach ($post_type as $type) {
								if(is_archive()){
									if (!empty($type) && is_post_type_archive($type) === true) {
										return true;
									}
								}
								
								if($type!=PRODUCT_TYPE)
								{
									if(!empty($type) && $type==PRODUCT_DETAIL_TYPE && is_single() && get_post_type() != 'post'){
										return true;
									}else if (!empty($type) && is_singular($type) === true) {
										return true;
									}
									
								}	
							}
						}
						
						if (isset($widget_display['catid'])) {
							$catid = preg_split('/[\s,]/', $widget_display['catid']);
							foreach ($catid as $id) {
								if (!empty($id) && is_category($id) === true) {
									return true;
								}
							}
								
						}
						
						if (isset($widget_display['postid'])) {
							$postid = preg_split('/[\s,]/', $widget_display['postid']);
							foreach ($postid as $id) {
								if (!empty($id) && (is_page($id) === true || is_single($id) === true) ) {
									return true;
								}
							}
						
						}
						
						if (isset($widget_display['checkbox']['menus'])) {
							
							foreach ($widget_display['checkbox']['menus'] as $menu_id => $item_ids) {
								
								if ( $YA_Menu_Checkbox->is_menu_item_active($menu_id, $item_ids) ) return true;
							}
						}
					}
				}
			}
			
			return false;
			
		} else return false ;
		
	} elseif ( isset($widget_display['display_select']) && $widget_display['display_select'] == 'if_no_selected' ) {
		
		if (isset($widget_display['checkbox'])) {
			
			if (isset($widget_display['checkbox']['users'])) {
				global $user_ID;
				
				foreach ($widget_display['checkbox']['users'] as $key => $value) {
					if ( ($key == 'login' && $user_ID) || ($key == 'logout' && !$user_ID) ) return false;
				}
			}
			
			if (isset($widget_display['checkbox']['general'])) {
				foreach ($widget_display['checkbox']['general'] as $key => $value) {
					$is = 'is_'.$key;
					if ( $is() === true ) return false;
				}
			}

			if (isset($widget_display['taxonomy-slugs'])) {
				$taxonomy_slugs = preg_split('/[\s,]/', $widget_display['taxonomy-slugs']);
				foreach ($taxonomy_slugs as $slug) {
					if (!empty($slug) && is_tax($slug) === true) {
						return false;
					}
				}
			
			}
			
			if (isset($widget_display['post-type'])) {
				$post_type = preg_split('/[\s,]/', $widget_display['post-type']);
				
				foreach ($post_type as $type) {
					if(is_archive()){
						if (!empty($type) && is_post_type_archive($type) === true) {
							return true;
						}
					}
					
					if($type!=PRODUCT_TYPE)
					{
						if(!empty($type) && $type==PRODUCT_DETAIL_TYPE && is_single() && get_post_type() != 'post'){
							return true;
						}else if (!empty($type) && is_singular($type) === true) {
							return true;
						}
						
					}	
				}
			}
			
			
			
			if (isset($widget_display['catid'])) {
				$catid = preg_split('/[\s,]/', $widget_display['catid']);
				foreach ($catid as $id) {
					if (!empty($id) && is_category($id) === true) {
						return false;
					}
				}
					
			}
			
			if (isset($widget_display['postid'])) {
				$postid = preg_split('/[\s,]/', $widget_display['postid']);
				foreach ($postid as $id) {
					if (!empty($id) && (is_page($id) === true || is_single($id) === true)) {
						return false;
					}
				}
			
			}
			
			if (isset($widget_display['checkbox']['menus'])) {
							
				foreach ($widget_display['checkbox']['menus'] as $menu_id => $item_ids) {
					
					if ( $YA_Menu_Checkbox->is_menu_item_active($menu_id, $item_ids) ) return false;
				}
			}			
		} else return false ;
	}
	}
	return true ;
}


/**
 *  Is active sidebar
 * */
function is_active_sidebar_YA($index) {
	global $wp_registered_widgets;
	
	$index = ( is_int($index) ) ? "sidebar-$index" : sanitize_title($index);
	$sidebars_widgets = wp_get_sidebars_widgets();
	if (!empty($sidebars_widgets[$index])) {
		foreach ($sidebars_widgets[$index] as $i => $id) {
			$id_base = preg_replace( '/-[0-9]+$/', '', $id );
			
			if ( isset($wp_registered_widgets[$id]) ) {
				$widget = new WP_Widget($id_base, $wp_registered_widgets[$id]['name']);

				if ( preg_match( '/' . $id_base . '-([0-9]+)$/', $id, $matches ) )
					$number = $matches[1];
					
				$instances = get_option($widget->option_name);
				
				if ( isset($instances) && isset($number) ) {
					$instance = $instances[$number];
					
					if ( isset($instance['widget_display']) && check_wdisplay($instance['widget_display']) == false ) {
						unset($sidebars_widgets[$index][$i]);
					}
				}
			}
		}
		
		if ( empty($sidebars_widgets[$index]) ) return false;
		
	} else return false;
	
	return true;
}	
	
/**
 * Get Social share
 * */
    function get_social() {
	global $post;
	
	$social['social-share'] = ya_options()->getCpanelValue('social-share');
	$social['social-share-fb'] = ya_options()->getCpanelValue('social-share-fb');
	$social['social-share-tw'] = ya_options()->getCpanelValue('social-share-tw');
	$social['social-share-in'] = ya_options()->getCpanelValue('social-share-in');
	$social['social-share-go'] = ya_options()->getCpanelValue('social-share-go');
	//$social['social-share-pi'] = ya_options()->getCpanelValue('social-share-pi');
	
	if (!$social['social-share']) return false;
	
	//$options = $this->get_wp_social_share_options();
	$permalinked = urlencode(get_permalink($post->ID));
	$spermalink = get_permalink($post->ID);
	$title = urlencode($post->post_title);
	$stitle = $post->post_title;
	
	$data = '<div class="social-share">';
	$data .= '<style type="text/css">
				.social-share{
					display: table;
				    margin: 5px;
				    width: 100%;
				}
				.social-share iframe{
					max-width: none;
					z-index: 10;
				}
				.social-share-item{
					float: left;
				}
				.social-share-fb{
					margin-right: 25px;
                }
			</style>';
	
	if ($social['social-share-fb']) {
		$data .='<div class="social-share-fb social-share-item" >';
		$data .= '<div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, \'script\', \'facebook-jssdk\'));</script>';
		$data .= '<div class="fb-like" data-href="'.$spermalink.'" data-send="true" data-layout="button_count" data-width="200" data-show-faces="false"></div>';
		$data .= '</div> <!--Facebook Button-->';
	}
		
	if ($social['social-share-tw']) {
		$data .='<div class="social-share-twitter social-share-item" >
					<a href="https://twitter.com/share" class="twitter-share-button" data-url="'. $spermalink .'" data-text="'.$stitle.'" data-count="horizontal">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
				</div> <!--Twitter Button-->';
	}
	
	if ($social['social-share-go']) {
		$data .= '<div class="social-share-google-plus social-share-item">
					<!-- Place this tag where you want the +1 button to render -->
					<div class="g-plusone" data-size="medium" data-href="'. $permalinked .'"></div>
		
					<!-- Place this render call where appropriate -->
					<script type="text/javascript">
					  (function() {
						var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
						po.src = "https://apis.google.com/js/plusone.js";
						var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
				</div> <!--google plus Button-->';
	}
	
	if ($social['social-share-in']) {
		$data .= '<div class="social-share-linkedin social-share-item">
					<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
					<script type="IN/Share" data-url="'. $permalinked .'" data-counter="right"></script>
				</div> <!--linkedin Button-->';
	}

//	if ($social['social-share-pi']) {
//		$data .= '<div class="social-share-pinterest social-share-item">
//					<a href="//pinterest.com/pin/create/button/?url='.$permalinked.'" data-pin-do="buttonPin" data-pin-config="beside"><img src="#" alt="test"></a>
//					<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
//				</div> <!--pinterest Button-->';
//	}
	$data .= '</div>';
	echo $data;

}


/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://twitter.github.com/bootstrap/components.html#media
 */

function ya_get_avatar($avatar) {
	$avatar = str_replace("class='avatar", "class='avatar pull-left media-object", $avatar);
	return $avatar;
}
add_filter('get_avatar', 'ya_get_avatar');

function ya_custom_direction(){
	global $wp_locale;
	$opt_direction = ya_options()->getCpanelValue('text_direction');
	$opt_direction = strtolower($opt_direction);
	if ( in_array($opt_direction, array('ltr', 'rtl')) ){
		$wp_locale->text_direction = $opt_direction;
	} else {
		// default by $wp_locale->text_direction;
	}
}
add_filter( 'wp', 'ya_custom_direction' );

function ya_navbar_class(){
	$classes = array( 'navbar' );

	if ( 'static' != ya_options()->getCpanelValue('navbar_position') )
		$classes[]	=	ya_options()->getCpanelValue('navbar_position');

	if ( ya_options()->getCpanelValue('navbar_inverse') )
		$classes[]	=	'navbar-inverse';

	apply_filters( 'ya_navbar_classes', $classes );

	echo 'class="' . join( ' ', $classes ) . '"';
}

function ya_content_product(){
	    $left_span_class 		= ya_options()->getCpanelValue('sidebar_left_expand');
	    $left_span_md_class 	= ya_options()->getCpanelValue('sidebar_left_expand_md');
	    $left_span_sm_class 	= ya_options()->getCpanelValue('sidebar_left_expand_sm');
		$right_span_class 		= ya_options()->getCpanelValue('sidebar_right_expand');
	    $right_span_md_class 	= ya_options()->getCpanelValue('sidebar_right_expand_md');
	    $right_span_sm_class 	= ya_options()->getCpanelValue('sidebar_right_expand_sm');
		$sidebar 				= ya_options()->getCpanelValue('sidebar_product');
    if(is_active_sidebar_YA('left-product') && is_active_sidebar_YA('right-product') && $sidebar =='lr'){
		$content_span_class 	= 12 - ( $left_span_class + $right_span_class );
		$content_span_md_class 	= 12 - ( $left_span_md_class +  $right_span_md_class );
		$content_span_sm_class 	= 12 - ( $left_span_sm_class + $right_span_sm_class );
	} elseif(is_active_sidebar_YA('left-product') && $sidebar =='left') {
		$content_span_class 	= 12 - $left_span_class ;
		$content_span_md_class 	= 12 - $left_span_md_class ;
		$content_span_sm_class 	= 12 - $left_span_sm_class ;
	}elseif(is_active_sidebar_YA('right-product') && $sidebar =='right') {
		$content_span_class 	= 12 - $right_span_class;
		$content_span_md_class 	= 12 - $right_span_md_class ;
		$content_span_sm_class 	= 12 - $right_span_sm_class ;
	}else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( 'content' );
	
		$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class;
	
	echo 'class="' . join( ' ', $classes ) . '"';
}
function ya_content_detail_product(){
	    $left_span_class 		= ya_options()->getCpanelValue('sidebar_left_expand');
	    $left_span_md_class 	= ya_options()->getCpanelValue('sidebar_left_expand_md');
	    $left_span_sm_class 	= ya_options()->getCpanelValue('sidebar_left_expand_sm');
		$right_span_class 		= ya_options()->getCpanelValue('sidebar_right_expand');
	    $right_span_md_class 	= ya_options()->getCpanelValue('sidebar_right_expand_md');
	    $right_span_sm_class 	= ya_options()->getCpanelValue('sidebar_right_expand_sm');
		$sidebar 				= ya_options()->getCpanelValue('sidebar_product');
    if(is_active_sidebar_YA('left-detail-product') && is_active_sidebar_YA('right-detail-product') && $sidebar =='lr'){
		$content_span_class 	= 12 - ( $left_span_class + $right_span_class );
		$content_span_md_class 	= 12 - ( $left_span_md_class +  $right_span_md_class );
		$content_span_sm_class 	= 12 - ( $left_span_sm_class + $right_span_sm_class );
	} elseif(is_active_sidebar_YA('left-detail-product') && $sidebar =='left') {
		$content_span_class 	= 12 - $left_span_class ;
		$content_span_md_class 	= 12 - $left_span_md_class ;
		$content_span_sm_class 	= 12 - $left_span_sm_class ;
	}elseif(is_active_sidebar_YA('right-detail-product') && $sidebar =='right') {
		$content_span_class 	= 12 - $right_span_class;
		$content_span_md_class 	= 12 - $right_span_md_class ;
		$content_span_sm_class 	= 12 - $right_span_sm_class ;
	}else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( 'content' );
	
		$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class . ' col-xs-12';
	echo 'class="' . join( ' ', $classes ) . '"';
}
function ya_content_blog(){
	    $left_span_class 		= ya_options()->getCpanelValue('sidebar_left_expand');
	    $left_span_md_class 	= ya_options()->getCpanelValue('sidebar_left_expand_md');
	    $left_span_sm_class 	= ya_options()->getCpanelValue('sidebar_left_expand_sm');
		$right_span_class 		= ya_options()->getCpanelValue('sidebar_right_expand');
	    $right_span_md_class 	= ya_options()->getCpanelValue('sidebar_right_expand_md');
	    $right_span_sm_class 	= ya_options()->getCpanelValue('sidebar_right_expand_sm');
		$sidebar_template 		= ya_options() -> getCpanelValue('sidebar_blog');
    if($sidebar_template =='lr_sidebar' && is_active_sidebar_YA('left-blog') && is_active_sidebar_YA('right-blog')){
		$content_span_class 	= 12 - ($left_span_class + $right_span_class);
		$content_span_md_class 	= 12 - ( $left_span_md_class +  $right_span_md_class );
		$content_span_sm_class 	= 12 - ($left_span_sm_class + $right_span_sm_class);
	} elseif($sidebar_template =='left_sidebar'&& is_active_sidebar_YA('left-blog')) {
		$content_span_class 	= 12 - $left_span_class ;
		$content_span_md_class 	= 12 - $left_span_md_class ;
		$content_span_sm_class 	= 12 - $left_span_sm_class ;
	}elseif($sidebar_template =='right_sidebar'&& is_active_sidebar_YA('right-blog')) {
		$content_span_class 	= 12 - $right_span_class;
		$content_span_md_class 	= 12 - $right_span_md_class ;
		$content_span_sm_class 	= 12 - $right_span_sm_class ;
	}else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( '' );
	
		$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class;
	
	echo  join( ' ', $classes ) ;
}

function ya_typography_css(){
	$styles = '';
	if ( ya_options()->getCpanelValue('google_webfonts') ):
		
		$webfonts_assign = ya_options()->getCpanelValue('webfonts_assign');
		$styles = '<style>';
		if ( $webfonts_assign == 'headers' ){
			$styles .= 'h1, h2, h3, h4, h5, h6 {';
		} else if ( $webfonts_assign == 'custom' ){
			$custom_assign = ya_options()->getCpanelValue('webfonts_custom');
			$custom_assign = trim($custom_assign);
			if (!$custom_assign) return '';
			$styles .= $custom_assign . ' {';
		} else {
			$styles .= 'body, input, button, select, textarea, .search-query {';
		}
		$styles .= 'font-family: ' . ya_options()->getCpanelValue('google_webfonts') . ' !important;}</style>';
	endif;
	return $styles;
}

function ya_typography_css_cache(){
	$data = get_transient( 'ya_typography_css' );
	//if ( $data === false ) {
		$data = ya_typography_css();
		set_transient( 'ya_typography_css', $data, 3600 * 24 );
	//}
	echo $data;
}
add_action( 'wp_head', 'ya_typography_css_cache', 12, 0 );

function ya_typography_css_cache_reset(){
	delete_transient( 'ya_typography_css' );
	ya_typography_css_cache();
}
//add_action( 'customize_preview_init', 'ya_typography_css_cache_reset' );


function ya_typography_webfonts(){
	if ( ya_options()->getCpanelValue('google_webfonts') ):
		$webfont_weight = array();
		$webfont				= ya_options()->getCpanelValue('google_webfonts');
		$webfont_weight			= ya_options()->getCpanelValue('webfonts_weight');
		$font_weight = '';
		if( empty($webfont_weight) ){
			$font_weight = '400';
		}
		else{
			foreach( $webfont_weight as $i => $wf_weight ){
				( $i < 1 )?	$font_weight .= '' : $font_weight .= ',';
				$font_weight .= $wf_weight;
			}
		}
		$f = strlen($webfont);
		if ($f > 3){
			$webfontname = str_replace( ' ', '+', $webfont );
			return '<link href="http://fonts.googleapis.com/css?family=' . $webfontname . ':' . $font_weight . '" rel="stylesheet">';
		}
	endif;
}

function ya_typography_webfonts_cache(){
	$data = get_transient( 'ya_typography_webfont' );
	//if ( $data === false ) {
		$data = ya_typography_webfonts();
		set_transient( 'ya_typography_webfont', $data, 0 );
	//}
	echo $data;
}
add_action( 'wp_head', 'ya_typography_webfonts_cache', 11, 0 );


function ya_typography_webfonts_cache_reset(){
	delete_transient( 'ya_typography_webfont' );
	ya_typography_webfonts_cache();
}
//add_action( 'customize_preview_init', 'ya_typography_webfonts_cache_reset' );


function ya_custom_header_scripts() {
	if ( ya_options()->getCpanelValue('advanced_head') ){
		echo ya_options()->getCpanelValue('advanced_head');
	}
}
add_action( 'wp_head', 'ya_custom_header_scripts', 200 );

function add_favicon(){
	if ( ya_options()->getCpanelValue('favicon') ){
		echo '<link rel="shortcut icon" href="' . ya_options()->getCpanelValue('favicon') . '" />';
	}
}
add_action('wp_head', 'add_favicon');
/* Get video or iframe from content */
function get_entry_content_asset( $post_id ){
	global $post;
	$post = get_post( $post_id );
	
	$content = apply_filters ("the_content", $post->post_content);
	//print_r($content);
	
	$value=preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU',$content,$results);
	if($value){
		return $results[0];
	}else{
		return '';
	}
}
function excerpt($limit) {
  $excerpt = explode(' ', get_the_content(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}
/*Product Meta*/
add_action("admin_init", "post_init");
add_action( 'save_post', 'ya_product_save_meta', 10, 1 );
function post_init(){
	add_meta_box("ya_product_meta", "Product Meta", "ya_product_meta", "product", "normal", "low");
}	
function ya_product_meta(){
	global $post;
	$value = get_post_meta( $post->ID, 'new_product', true );
	$recommend_product = get_post_meta( $post->ID, 'recommend_product', true );
?>
	<p><label><b><?php esc_html_e( 'Recommend Product', 'maxshop' ) ?>:</b></label> &nbsp;&nbsp;
	<input type="checkbox" name="recommend_product" value="yes" <?php if(esc_attr($recommend_product) == 'yes'){ echo "CHECKED"; }?> /></p>
<?php }
function ya_product_save_meta(){
	global $post;
	if( isset( $_POST['recommend_product'] ) && $_POST['recommend_product'] != '' ){
		update_post_meta($post->ID, 'recommend_product', $_POST['recommend_product']);
	}else{
		return;
	}
}
/*end product meta*/
remove_action( 'get_product_search_form', 'get_product_search_form', 10);
add_action('get_product_search_form', 'ya_search_product_form', 10);
function ya_search_product_form( ){
	//do_action( 'get_product_search_form'  );
	$search_form_template = locate_template( 'product-searchform.php' );
	if ( '' != $search_form_template  ) {
		require $search_form_template;
		return;
	}

	$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div class="product-search">
			<div class="product-search-inner">
				<input type="text" class="search-text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search for products', 'maxshop' ) . '" />
				<input type="submit" class="search-submit" id="searchsubmit" value="'. esc_attr__( 'Go', 'maxshop' ) .'" />
				<input type="hidden" name="post_type" value="product" />
			</div>
		</div>
	</form>';

	return apply_filters( 'ya_search_product_form', $form );
}

add_filter( 'widget_tag_cloud_args', 'ya_tag_clound' );
function ya_tag_clound($args){
	$args['largest'] = 8;
	return $args;
}
/* Fix login header */
if( class_exists( 'WooCommerce' ) ){
	add_action( 'wp_footer', 'Ya_Login_Popup', 100 );
	function Ya_Login_Popup(){
		ob_start();		
?>
		<div class="modal fade" id="login_form" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog block-popup-login">
				<a href="javascript:void(0)" title="<?php esc_attr_e( 'Close', 'maxshop' ) ?>" class="close close-login" data-dismiss="modal"><?php esc_html_e( 'Close', 'maxshop' ) ?></a>
				<div class="tt_popup_login"><strong><?php _e('Sign in Or Register', 'maxshop'); ?></strong></div>
				<?php get_template_part('woocommerce/myaccount/login-form'); ?>
			</div>
		</div>
<?php
		$content = ob_get_clean();
		echo $content;
	}
}
