<?php
/**
 * Clean up wp_head()
 *
 * Remove unnecessary <link>'s
 * Remove inline CSS used by Recent Comments widget
 * Remove inline CSS used by posts with galleries
 * Remove self-closing tag and change ''s to "'s on rel_canonical()
 */
/* Function title tag */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function ya_render_title() {
?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'ya_render_title' );
} 

function ya_head_cleanup() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

	add_filter('use_default_gallery_style', '__return_null');

	if (!class_exists('WPSEO_Frontend')) {
		remove_action('wp_head', 'rel_canonical');
		add_action('wp_head', 'ya_rel_canonical');
	}
}

function ya_rel_canonical() {
	global $wp_the_query;

	if (!is_singular()) {
    	return;
	}

	if (!$id = $wp_the_query->get_queried_object_id()) {
		return;
	}

	$link = get_permalink($id);
	echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}
add_action('init', 'ya_head_cleanup');

/**
 * Remove the WordPress version from RSS feeds
 */
add_filter('the_generator', '__return_false');

/**
 * Clean up language_attributes() used in <html> tag
 *
 * Change lang="en-US" to lang="en"
 * Remove dir="ltr"
 */
/*********************** Change direction RTL *************************************/
if( !is_admin() ){
	add_filter( 'language_attributes', 'ya_direction', 20 );
	function ya_direction( $doctype = 'html' ){
		$ya_direction = ya_options()->getCpanelValue( 'direction' );
		if ( ( function_exists( 'is_rtl' ) && is_rtl() ) || $ya_direction == 'rtl' )
			$ya_attribute[] = 'dir="rtl"';
		( $ya_direction === 'rtl' ) ? $lang = 'ar' : $lang = get_bloginfo('language');
		if ( $lang ) {
		if ( get_option('html_type') == 'text/html' || $doctype == 'html' )
			$ya_attribute[] = "lang=\"$lang\"";

		if ( get_option('html_type') != 'text/html' || $doctype == 'xhtml' )
			$ya_attribute[] = "xml:lang=\"$lang\"";
		}
		$ya_attribute[] = 'xmlns="http://www.w3.org/1999/xhtml"';
		$ya_output = implode(' ', $ya_attribute);
		return $ya_output;
	}
}
/* Layout box and wide */
add_filter('body_class','ya_layout_class');
function ya_layout_class($classes) {
	$header = ya_options()->getCpanelValue('box_layout');
	if($header == 'box'){
		$classes[] = 'boxed';
	}
	// return the $classes array
	return $classes;
}
/**
 * Clean up output of stylesheet <link> tags
 */
function ya_clean_style_tag($input) {
	preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
	// Only display media if it's print
	$media = $matches[3][0] === 'print' ? ' media="print"' : '';
	return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'ya_clean_style_tag');

/**
 * Add and remove body_class() classes
 */
function ya_body_class($classes) {
	$direction = ya_options()->getCpanelValue('direction');
	if( $direction == 'rtl' ){
		$classes[] = 'rtl';
	}
	// Add post/page slug
	if (is_single() || is_page() && !is_front_page()) {
		$classes[] = basename(get_permalink());
	}
	
	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option('page_on_front');
	$remove_classes = array(
			'page-template-default',
			$home_id_class
	);
	$classes = array_diff($classes, $remove_classes);
	return $classes;
}
add_filter('body_class', 'ya_body_class');

/**
 * Root relative URLs
 *
 * WordPress likes to use absolute URLs on everything - let's clean that up.
 * Inspired by http://www.456bereastreet.com/archive/201010/how_to_make_wordpress_urls_root_relative/
 *
 * You can enable/disable this feature in config.php:
 * current_theme_supports('root-relative-urls');
 *
 * @author Scott Walkinshaw <scott.walkinshaw@gmail.com>
 */
function ya_root_relative_url($input) {
	$output = preg_replace_callback(
			'!(https?://[^/|"]+)([^"]+)?!',
			create_function(
					'$matches',
					// If full URL is home_url("/") and this isn't a subdir install, return a slash for relative root
					'if (isset($matches[0]) && $matches[0] === home_url("/") && str_replace("http://", "", home_url("/", "http"))==$_SERVER["HTTP_HOST"]) { return "/";' .
					// If domain is equal to home_url("/"), then make URL relative
					'} elseif (isset($matches[0]) && strpos($matches[0], home_url("/")) !== false) { return $matches[2];' .
					// If domain is not equal to home_url("/"), do not make external link relative
					'} else { return $matches[0]; };'
			),
			$input
	);

	return $output;
}

/**
 * Terrible workaround to remove the duplicate subfolder in the src of <script> and <link> tags
 * Example: /subfolder/subfolder/css/style.css
 */
function ya_fix_duplicate_subfolder_urls($input) {
	$output = ya_root_relative_url($input);
	preg_match_all('!([^/]+)/([^/]+)!', $output, $matches);

	if (isset($matches[1][0]) && isset($matches[2][0])) {
		if ($matches[1][0] === $matches[2][0]) {
			$output = substr($output, strlen($matches[1][0]) + 1);
		}
	}

	return $output;
}

function ya_enable_root_relative_urls() {
	return !(is_admin() && in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) && current_theme_supports('root-relative-urls');
}

if (ya_enable_root_relative_urls()) {
	$root_rel_filters = array(
			'bloginfo_url',
			'theme_root_uri',
			'stylesheet_directory_uri',
			'template_directory_uri',
			'plugins_url',
			'the_permalink',
			'wp_list_pages',
			'wp_list_categories',
			'wp_nav_menu',
			'the_content_more_link',
			'the_tags',
			'get_pagenum_link',
			'get_comment_link',
			'month_link',
			'day_link',
			'year_link',
			'tag_link',
			'the_author_posts_link'
	);

	add_filters($root_rel_filters, 'ya_root_relative_url');

	add_filter('script_loader_src', 'ya_fix_duplicate_subfolder_urls');
	add_filter('style_loader_src', 'ya_fix_duplicate_subfolder_urls');
}

/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function ya_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
	$cache = preg_replace('/width="(.*?)?"/', 'width="100%"', $cache);
	return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'ya_embed_wrap', 10, 4);
add_filter('embed_googlevideo', 'ya_embed_wrap', 10, 2);

/**
 * Add class="thumbnail" to attachment items
 */
function ya_attachment_link_class($html) {
	$postid = get_the_ID();
	$html = str_replace('<a', '<a class="thumbnail"', $html);
	return $html;
}
add_filter('wp_get_attachment_link', 'ya_attachment_link_class', 10, 1);

/**
 * Add Bootstrap thumbnail styling to images with captions
 * Use <figure> and <figcaption>
 *
 * @link http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
 */
function ya_caption($output, $attr, $content) {
	if (is_feed()) {
		return $output;
	}

	$defaults = array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => ''
	);

	$attr = shortcode_atts($defaults, $attr);

	// If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
	if ($attr['width'] < 1 || empty($attr['caption'])) {
		return $content;
	}

	// Set up the attributes for the caption <figure>
	$attributes  = (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
	$attributes .= ' style="width: ' . esc_attr($attr['width']) . 'px"';

	$output  = '<figure' . $attributes .'>';
	$output .= do_shortcode($content);
	$output .= '<figcaption class="caption wp-caption-text">' . esc_html( $attr['caption'] ) . '</figcaption>';
	$output .= '</figure>';

	return $output;
}
add_filter('img_caption_shortcode', 'ya_caption', 10, 3);


/**
 * Clean up gallery_shortcode()
 *
 * Re-create the [gallery] shortcode and use thumbnails styling from Bootstrap
 *
 * @link http://twitter.github.com/bootstrap/components.html#thumbnails
 */
function ya_gallery($attr) {
	$post = get_post();

	static $instance = 0;
	$instance++;

	if (!empty($attr['ids'])) {
		if (empty($attr['orderby'])) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$output = apply_filters('post_gallery', '', $attr);

	if ($output != '') {
		return $output;
	}

	if (isset($attr['orderby'])) {
		$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
		if (!$attr['orderby']) {
			unset($attr['orderby']);
		}
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => '',
		'icontag'    => '',
		'captiontag' => '',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
		), $attr)
	);

	$id = intval($id);

	if ($order === 'RAND') {
		$orderby = 'none';
	}

	if (!empty($include)) {
		$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

		$attachments = array();
		foreach ($_attachments as $key => $val) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif (!empty($exclude)) {
		$attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
	} else {
		$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
	}

	if (empty($attachments)) {
		return '';
	}

	if (is_feed()) {
		$output = "\n";
		foreach ($attachments as $att_id => $attachment) {
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		}
		return $output;
	}
	
	if (!wp_style_is('ya_photobox_css')){
		wp_enqueue_style('ya_photobox_css');
	}
	
	if (!wp_enqueue_script('photobox_js')){
		wp_enqueue_script('photobox_js');
	}
	
	$output = '<ul id="photobox-gallery-' . esc_attr( $instance ). '" class="thumbnails photobox-gallery gallery gallery-columns-'.esc_attr( $columns ).'">';

	$i = 0;
	$width = 100/$columns - 1;
	foreach ($attachments as $id => $attachment) {
		//$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		$link = '<a class="thumbnail" href="' . wp_get_attachment_url($id) . '">';
		$link .= wp_get_attachment_image($id);
		$link .= '</a>';
		
		$output .= '<li style="width: '.esc_attr( $width ).'%;">' . $link;
		$output .= '</li>';
	}

	$output .= '</ul>';
	
	add_action('wp_footer', 'add_script_gallery', 50);
	
	return $output;
}
if ( current_theme_supports('bootstrap-gallery') ) {
	remove_shortcode('gallery');
	add_shortcode('gallery', 'ya_gallery');
}

function add_script_gallery() {
	$script = '';
	$script .= '<script type="text/javascript">
				jQuery(document).ready(function($) {
					try{
						// photobox
						$(".photobox-gallery").each(function(){
							$("#" + this.id).photobox("li a");
							// or with a fancier selector and some settings, and a callback:
							$("#" + this.id).photobox("li:first a", { thumbs:false, time:0 }, imageLoaded);
							function imageLoaded(){
								console.log("image has been loaded...");
							}
						})
					} catch(e){
						console.log( e );
					}
				});
			</script>';
	
	echo $script;
}

/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function ya_remove_dashboard_widgets() {
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	remove_meta_box('dashboard_plugins',        'dashboard', 'normal');
	remove_meta_box('dashboard_primary',        'dashboard', 'normal');
	remove_meta_box('dashboard_secondary',      'dashboard', 'normal');
}
add_action('admin_init', 'ya_remove_dashboard_widgets');

/**
 * Clean up the_excerpt()
 */
function ya_excerpt_length($length) {
	return POST_EXCERPT_LENGTH;
}

function ya_excerpt_more($more) {
	//return;
	return ' &hellip; <a href="' . get_permalink() . '">' . __('Readmore', 'maxshop') . '</a>';
}
add_filter('excerpt_length', 'ya_excerpt_length');
add_filter('excerpt_more',   'ya_excerpt_more');

/**
 * Remove unnecessary self-closing tags
 */
function ya_remove_self_closing_tags($input) {
  return str_replace(' />', '>', $input);
}
add_filter('get_avatar',          'ya_remove_self_closing_tags'); // <img />
add_filter('comment_id_fields',   'ya_remove_self_closing_tags'); // <input />
add_filter('post_thumbnail_html', 'ya_remove_self_closing_tags'); // <img />

/**
 * Don't return the default description in the RSS feed if it hasn't been changed
 */
function ya_remove_default_description($bloginfo) {
	$default_tagline = 'Just another WordPress site';
	return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', 'ya_remove_default_description');

/**
 * Allow more tags in TinyMCE including <iframe> and <script>
 */
function ya_change_mce_options($options) {
	$ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

	if (isset($initArray['extended_valid_elements'])) {
		$options['extended_valid_elements'] .= ',' . $ext;
	} else {
		$options['extended_valid_elements'] = $ext;
	}

	return $options;
}
add_filter('tiny_mce_before_init', 'ya_change_mce_options');

/**
 * Add additional classes onto widgets
 *
 * @link http://wordpress.org/support/topic/how-to-first-and-last-css-classes-for-sidebar-widgets
 */
function ya_widget_first_last_classes($params) {
	global $my_widget_num;

	$this_id = $params[0]['id'];
	$arr_registered_widgets = wp_get_sidebars_widgets();

	if (!$my_widget_num) {
		$my_widget_num = array();
	}

	if (!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) {
		return $params;
	}

	if (isset($my_widget_num[$this_id])) {
		$my_widget_num[$this_id] ++;
	} else {
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . esc_attr( $my_widget_num[$this_id] ) . ' ';

	if ($my_widget_num[$this_id] == 1) {
		$class .= 'widget-first ';
	} elseif ($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) {
		$class .= 'widget-last ';
	}

	$params[0]['before_widget'] = preg_replace('/class=\"/', "$class", $params[0]['before_widget'], 1);

	return $params;
}
add_filter('dynamic_sidebar_params', 'ya_widget_first_last_classes');

/**
 * Redirects search results from /?s=query to /search/query/, converts %20 to +
 *
 * @link http://txfx.net/wordpress-plugins/nice-search/
 */
function ya_nice_search_redirect() {
	global $ya_rewrite;
	if (!isset($ya_rewrite) || !is_object($ya_rewrite) || !$ya_rewrite->using_permalinks()) {
		return;
	}

	$search_base = $ya_rewrite->search_base;
	if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
		wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
		exit();
	}
}
if (current_theme_supports('nice-search')) {
	add_action('template_redirect', 'ya_nice_search_redirect');
}

/**
 * Fix for empty search queries redirecting to home page
 *
 * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
 * @link http://core.trac.wordpress.org/ticket/11330
 */
function ya_request_filter($query_vars) {
  if (isset($_GET['s']) && empty($_GET['s'])) {
    $query_vars['s'] = ' ';
  }

  return $query_vars;
}
add_filter('request', 'ya_request_filter');

/**
 * Tell WordPress to use searchform.php from the templates/ directory
 */
function ya_get_search_form($argument) {
	if ($argument === '') {
		locate_template('/templates/searchform.php', true, false);
	}
}
add_filter('get_search_form', 'ya_get_search_form');

function ya_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'maxshop' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ya_wp_title', 10, 2 );


/**
 * Widget text do_shortcode();
 */
add_filter('widget_text', 'do_shortcode');


add_filter('wp_link_pages_args','add_next_and_number');

function add_next_and_number($args){
    if($args['next_or_number'] == 'next_and_number'){
        global $page, $numpages, $multipage, $more, $pagenow;
        $args['next_or_number'] = 'number';
        $prev = '';
        $next = '';
        if ( $multipage ) {
            if ( $more ) {
                $i = $page - 1;
                if ( $i && $more ) {
					$prev .='<p>';
                    $prev .= _wp_link_page($i);
                    $prev .= $args['link_before'].$args['previouspagelink'] . $args['link_after'] . '</a></p>';
                }
                $i = $page + 1;
                if ( $i <= $numpages && $more ) {
					$next .='<p>';
                    $next .= _wp_link_page($i);
                    $next .= $args['link_before']. $args['nextpagelink'] . $args['link_after'] . '</a></p>';
                }
            }
        }
        $args['before'] = $args['before'].$prev;
        $args['after'] = $next.$args['after'];    
    }
    return $args;
}
/* Menu Sticky */
add_action( 'wp_footer', 'ya_sticky_menu' );
function ya_sticky_menu(){
	$sticky_menu = ya_options()->getCpanelValue( 'sticky_menu' );
	$output = '';
	if( $sticky_menu ){
		$output .= '<script type="text/javascript">';
		$output .= '(function($) {';
		$output .= 'var sticky_navigation_offset = $("#primary-menu").offset();';
		$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
		$output .= 'var sticky_navigation = function(){';
		$output .= 'var scroll_top = $(window).scrollTop();';
		$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
		$output .= '$("#primary-menu").addClass("sticky-menu");';
		$output .= '$("#primary-menu").css({ "top":0, "left":0, "right" : 0 });';
		$output .= '} else {';
		$output .= '$("#primary-menu").removeClass("sticky-menu");';
		$output .= '}';
		$output .= '};';
		$output .= 'sticky_navigation();';
		$output .= '$(window).scroll(function() {';
		$output .= 'sticky_navigation();';
		$output .= '});';
		$output .= '}(jQuery));';
		$output .= '</script>';
		echo $output;
	}
}
