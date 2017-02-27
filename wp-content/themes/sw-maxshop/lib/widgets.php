<?php
/**
 * Register sidebars and widgets
 */
function unregister_default_widgets() {
	     unregister_widget('WC_Widget_Featured_Products');
		 unregister_widget('WC_Widget_Best_Sellers');
		 unregister_widget('WC_Widget_Top_Rated_Products');
}
 add_action('widgets_init', 'unregister_default_widgets', 11);
 
function ya_widgets_init() {
	// Sidebars
	global $widget_areas;
	$widget_areas = ya_widget_setup_args();
	if ( count($widget_areas) ){
		foreach( $widget_areas as $sidebar ){
			$sidebar_params = apply_filters('ya_sidebar_params', $sidebar);
			register_sidebar($sidebar_params);
		}
	}

	// Widgets
	register_widget('YA_Social_Widget');
	register_widget('YA_Posts_Widget');
	register_widget('YA_Vertical_Megamenu_Widget');
	register_widget('YA_Categories_Widget');
	register_widget('YA_Default_Widget');
	//register_widget('YA_Slider_Widget');
	register_widget('YA_Top_Widget');
	register_widget('YA_Top_Rate_Product');
	register_widget('YA_Best_Seller_Product');
	register_widget('YA_Related_Product_Widget');
	register_widget('YA_Category_List_Widget');
	register_widget('YA_Feature_Product_Widget');
	//register_widget('YA_Cpanel');
}
add_action('widgets_init', 'ya_widgets_init');

/**
 * Posts widget class
 *
 * @since 2.8.0
*/
class YA_Posts_Widget extends YA_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'ya_posts', 'description' => __('SW Posts', 'maxshop'));
		parent::__construct('ya_posts', __('SW Posts', 'maxshop'), $widget_ops);
		$this->base = dirname(__FILE__);
	}
	public function add_script_slideshow() {
		$script = '';
		$script .= '<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".da-slider").each(function(){
					$("#" + this.id).cslider();
				});
			});
		</script>';
		
		echo $script;
	}
}


class YA_Category_List_Widget extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_category_list', 'description' =>__('SW Category List header widget', 'maxshop'));
		parent::__construct('ya_category_list', __('SW List Category', 'maxshop'), $widget_ops);
	}
}
class YA_Vertical_Megamenu_Widget extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'vertical_megamenu', 'description' =>__('SW Vertical Mega Menu Widget', 'maxshop'));
		parent::__construct('vertical_megamenu', __('SW Vertical Mega Menu', 'maxshop'), $widget_ops);
	}
}


class YA_Top_Widget extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_top', 'description' =>__('SW top header widget', 'maxshop'));
		parent::__construct('ya_top', __('SW Top Widget', 'maxshop'), $widget_ops);
	}
}

class YA_Top_Rate_Product extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_top_rate_product woocommerce widget_top_rated_products', 'description' =>__('SW Top Rated Product Widget', 'maxshop'));
		parent::__construct('top_rated_product', __('SW Top Rated Product Widget', 'maxshop'), $widget_ops);
	}
}

class YA_Best_Seller_Product extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_best_seller_product', 'description' =>__('SW best seller product woocommerce', 'maxshop'));
		parent::__construct('ya_best_seller_product', __('SW best seller products', 'maxshop'), $widget_ops);
	}
}

class YA_Related_Product_Widget extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_relate_product', 'description' =>__('SW related products woocommerce', 'maxshop'));
		parent::__construct('ya_relate_product', __('SW related products', 'maxshop'), $widget_ops);
	}
	public function widget( $args, $instance ) {
		if( !is_singular( 'product' )){ return ''; }
		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		//if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		
		extract($instance);

		if ( !array_key_exists('widget_template', $instance) ){
			$instance['widget_template'] = 'default';
		}
		
		if ( $tpl = $this->getTemplatePath( $instance['widget_template'] ) ){ 
			$widget_id = $args['widget_id'];		
			include $tpl;
		}
				
		/* After widget (defined by themes). */
		echo $after_widget;
	}   
}

class YA_Categories_Widget extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_categories', 'description' =>__('SW Categories', 'maxshop'));
		parent::__construct('ya_categories', __('SW Catetories', 'maxshop'), $widget_ops);
	}
}

class YA_Feature_Product_Widget extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_feature_product', 'description' =>__('SW feature product woocommerce', 'maxshop'));
		parent::__construct('ya_feature_product', __('SW Feature Products', 'maxshop'), $widget_ops);
	}
}


class YA_Default_Widget extends YA_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_default', 'description' =>__('WP Default Widget', 'maxshop'));
		parent::__construct('ya_default', __('WP Default Widget', 'maxshop'), $widget_ops);
	}
}

class YA_Social_Widget extends WP_Widget{

	function __construct(){
		$widget_ops = array('classname' => 'ya_social', 'description' => __('SW Social Networks', 'maxshop'));
		parent::__construct('ya_social', __('SW Social', 'maxshop'), $widget_ops);
		$this->option_name='socials';
	}

	function widget($args, $instance){
		$socials  = isset($instance['socials']) && is_array($instance['socials']) ? $instance['socials'] : array();
		extract($args);
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ($title){
			echo $before_title . $title . $after_title;
		}
		?>
		<ul>
			<?php foreach ($socials as $social){?>
			<?php preg_match('/fa-.*?/', $social['icon'], $match); ?>
			<li><a href="<?php echo esc_url( $social['link'] ); ?>"
				title="<?php if (empty($match)) echo esc_attr( $social['icon'] ); ?>"> <?php if (empty($match)) echo esc_html( $social['icon'] ); else { ?>
					<i class="fa <?php echo esc_attr( $social['icon'] )?>"></i> <?php }?>
			</a></li>
			<?php } ?>
		</ul>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$socials = array();
		foreach ($new_instance['socials'] as $i => $social){
			if (isset($social['icon'])){
				$icon = trim(strip_tags($social['icon']));
				if ( !empty($icon) ){
					$link = trim(strip_tags($social['link']));
					if ( empty($link) ){
						$link = '#';
					}
					$socials[]= array( 'icon' => $icon, 'link' => $link );
				}
			}
		}
		$instance['socials'] = $socials;
		return $instance;
	}

	function form($instance){ //var_dump($instance);
		$title   = isset($instance['title']) ? sanitize_title($instance['title']) : '';
		$socials = isset($instance['socials']) && is_array($instance['socials']) ? $instance['socials'] : array();

		?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title: ', 'maxshop'); ?>
	</label> <input class="widefat"
		id="<?php echo $this->get_field_id('title'); ?>"
		name="<?php echo $this->get_field_name('title'); ?>" type="text"
		value="<?php echo esc_attr($title); ?>" />
</p>

<?php //var_dump($socials);
		// if saved data
		foreach ($socials as $j => $social){

			$name_j = $this->get_field_name($this->option_name).'['.$j.']';
			$id_j = $this->get_field_id($this->option_name).'_'.$j;

			$name_j_icon = $name_j.'[icon]';
			$id_j_icon = $id_j.'_icon';

			$name_j_link = $name_j.'[link]';
			$id_j_link = $id_j.'_link';
			?>
<p>
	<strong><?php echo __( 'Social', 'maxshop' ). ' ' .$j+1; ?>
	</strong><br>
	<?php if (key_exists('icon', $social)){?>
	<label for="<?php echo esc_attr( $id_j_icon ); ?>"><?php _e('fa-* | title', 'maxshop')?>
	</label> <input class="widefat" id="<?php echo esc_attr( $id_j_icon );?>"
		name="<?php echo esc_attr($name_j_icon); ?>" type="text"
		value="<?php echo esc_attr( $social['icon'] ); ?>"><br>
	<?php }?>
	<label for="<?php echo esc_attr( $id_j_link ); ?>"><?php _e('Link ', 'maxshop')?> </label>
	<input class="widefat" id="<?php echo esc_attr( $id_j_link );?>"
		name="<?php echo esc_attr($name_j_link); ?>" type="text"
		value="<?php echo esc_attr( $social['link'] ); ?>">
</p>
<?php
		}

		// blank fields for add new social network
		$i = (is_array($socials) && count($socials)) ? count($socials) : 0;

		$name_i = $this->get_field_name($this->option_name).'['.$i.']';
		$id_i = $this->get_field_id($this->option_name).'_'.$i;

		$name_i_icon = $name_i.'[icon]';
		$id_i_icon = $id_i.'_icon';

		$name_i_link = $name_i.'[link]';
		$id_i_link = $id_i.'_link';

		?>
<p>
	<strong><?php _e( 'Add a new social network', 'maxshop' ) ?></strong><br> <label
		for="<?php echo esc_attr( $id_i_icon ); ?>"><?php _e('Classname for Icon or Title', 'maxshop'); ?>
	</label> <input class="widefat" id="<?php echo esc_attr( $id_i_icon ); ?>"
		name="<?php echo $name_i_icon; ?>" type="text" value=""
		placeholder="Enter Font Awesome icon or Title" /> <span><?php _e( 'If using as
		icon, please choose class name in Font Awesome. This is required.', 'maxshop' ) ?></span>
	<label for="<?php echo esc_attr( $id_i_link ); ?>"><?php _e('Link ', 'maxshop')?> </label>
	<input class="widefat" id="<?php echo esc_attr( $id_i_link ); ?>"
		name="<?php echo esc_attr( $name_i_link ); ?>" type="text" value=""
		placeholder="#" />
</p>
<?php
	}

}

class YA_Cpanel extends WP_Widget{

	public function __construct(){
		$widget_opts = array( 'classname' => 'cpanel', 'description' => __('Theme Options on Frontend', 'maxshop') );
		parent::__construct('cpanel', __('YA cPanel', 'maxshop'), $widget_opts);
	}

	public function widget( $args, $instance ){
		
		if ( function_exists('ya_options') ){
			$options = ya_options();
			$options->cpanel();
		}
	}
	
	public function update( $new_instance, $old_instance ){
		
	}
	
	public function form( $instance ){
		
	}
}

class YA_Widgets{

	protected $dir = null;
	protected $url = null;
	protected $styles = null;
	
	protected $widget = null;
	protected $enqueues = array();
	protected $fields = array(
			'ya_before_widget' => 'Before Widget',
			'ya_after_widget'  => 'After Widget',
			'ya_before_title'  => 'Before Title',
			'ya_after_title'   => 'After Title',
			'ya_display_conditions' => 'Display Conditions',
			'_widget_style' => 'Widget Style:'
	);
			
	public function __construct(){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		// filters
		add_filter('in_widget_form', array($this, 'in_widget_form'), 10, 3);
		add_filter('widget_update_callback', array($this, 'widget_update_callback'), 10, 3);
		add_filter('widget_display_callback', array($this, 'widget_display_callback'), 10, 3);

		// enqueue
		add_filter('admin_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		$this->getWidgetStyles();
	}

	public function widget_display_callback( $instance, $widget, $args ){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		//Logger::log( array_merge( array('instance' => get_class($widget)), $instance) );
		//Widget Display
		$widget_display = isset($instance['widget_display']) ? $instance['widget_display'] : array();
		
		if ( check_wdisplay($widget_display) == false ) return false;
		
		if ( $style = $this->getStyleIn($instance) ){
			if ( isset($style['before_widget']) && !empty($style['before_widget'])){
				// Substitute HTML id and class attributes into before_widget
				global $wp_registered_widgets;
				$classname_ = '';
				foreach ( (array) $wp_registered_widgets[$widget->id]['classname'] as $cn ) {
					if ( is_string($cn) )
						$classname_ .= '_' . $cn;
					elseif ( is_object($cn) )
					$classname_ .= '_' . get_class($cn);
				}
				$classname_ = ltrim($classname_, '_');
				$args['before_widget'] = sprintf($style['before_widget'], $widget->id, $classname_);
			}
			if ( isset($style['after_widget']) ){
				$args['after_widget'] = $style['after_widget'];
			}
			if ( isset($style['before_title']) || isset($style['after_title']) ){
				$args['before_title'] = $style['before_title'];
				$args['after_title'] = $style['after_title'];
			}
			//var_dump($args);
			$widget->widget($args, $instance);
			
			return false;
		}

		return $instance;
	}

	public function widget_update_callback( $instance, $new, $old ){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		//$instance_new['widget_class_suffix'] = isset($new['widget_class_suffix']) ? strip_tags($new['widget_class_suffix']) : '';
		$instance_new['widget_style'] = isset($new['widget_style']) ? $new['widget_style'] : 'inherit';
		$instance_new['adoptions'] = isset($new['adoptions']) ? $new['adoptions'] : false;
		
		//Widget Display
		$instance_new['widget_display'] = isset($new['widget_display']) ? $new['widget_display'] : array();
		return wp_parse_args($instance_new, $instance);
	}
	
	public function in_widget_form($widget, $r = null, $instance = array() ){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		//Logger::log( array_merge( array('instance' => get_class($widget)), $instance) );
		
		$widget_advanced = ya_options()->getCpanelValue('widget-advanced');
		if ( !$widget_advanced ) return ;

		$this->widget = &$widget;
		//$widget_class_suffix = isset($instance['widget_class_suffix']) ? $instance['widget_class_suffix'] : '';
		$widget_style = isset($instance['widget_style']) ? trim($instance['widget_style']) : '';
		$adoptions = isset( $instance['adoptions'] ) ? $instance['adoptions'] : false;
		$adoptions_checked = $adoptions ? 'checked="checked"' : '';
		$adoptions_on_class = $adoptions ? 'on' : '';
		
		//Widgets Style
		$styles = $this->getWidgetStyles();
		$styles = array_merge(array('default' => 'Default'), $styles);
		$styles = array_unique($styles);
		//Widget Display
		$widget_display = isset($instance['widget_display']) ? $instance['widget_display'] : array();
		?>

		<div class="advanced-opt <?php echo $adoptions_on_class; ?>">
			<div class="advanced-opt-controls" >
				<label class="button toggle" for="<?php echo $widget->get_field_id('adoptions'); ?>">Advanced Options
					<input type="checkbox" class="pane-toggler" <?php echo $adoptions_checked; ?> style="display: none;" name="<?php echo $widget->get_field_name('adoptions'); ?>" id="<?php echo $widget->get_field_id('adoptions'); ?>">
				</label>
			</div>
			<div class="advanced-opt-pane">
				<div class="advanced-opt-pane-inner">
					<div class="pane-content">
						<div class="pane-left">
							<p>
								<label for="<?php echo $widget->get_field_id('widget_style'); ?>"><?php _e( 'Widget Style', 'maxshop' ) ?>
								</label> <select class="widefat"
									id="<?php echo $widget->get_field_id('widget_style'); ?>"
									name="<?php echo $widget->get_field_name('widget_style'); ?>">
									<?php foreach ( $styles as $key => $value ){
										$selected = '';
													if ($key == $widget_style) $selected = 'selected="selected"'; ?>
									<option <?php echo 'value="'.$key.'" '.$selected ; ?>>
										<?php echo $value; ?>
									</option>
									<?php }	?>
								</select>
							</p>
							<?php echo $this->render_wdisplay($widget_display); ?>
						</div>
						<div class="pane-right"></div>
					</div>
				</div>
			</div>
			<br class="clear">
		</div>

	<?php
	}

	public function wp_enqueue_scripts(){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);

		if (!isset($this->_enqueue)){
			$this->initialize();
			wp_enqueue_style('widget-options', $this->url . 'admin/css/widget-options.css', array(), null);
			wp_enqueue_script('widget-options', $this->url . 'admin/js/widget-options.js', false, null, false);
			$this->_enqueue = true;
		}
	}

	public function initialize(){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);

		$this->dir = trailingslashit(str_replace('\\','/',dirname(__FILE__)));
		$abs = trailingslashit(str_replace('\\','/',ABSPATH));
		$this->url = site_url(str_replace( $abs, '', $this->dir ));

	}
	
	private $menu_assignment_tpl = null;
	private $menu_assignments = array();
	private $display_select_tpl = null;
	private $display_select_options = array();
	private $display_language_options = array();
	private $display_language_tpl = null;
	
	private $display_checkbox_users_tpl = null;
	private $display_checkbox_users = null;
	
	private $display_checkbox_general_tpl = null;
	private $display_checkbox_general = null;
	
	private $display_checkbox_menus = null;
	
//	private function getMenuAssignmentTemplate(){
//		if ( is_null($this->menu_assignment_tpl) ){
//			// content of menus width checkbox
//		}
//		return $this->menu_assignment_tpl;
//	}
	
	private function menu_assignment( $widget_display = array() ){
		
//		$hash = md5( serialize($widget_display) );
//		if ( !isset($this->menu_assignments[$hash]) ){
//			$menu_assignment_tpl = &$this->getMenuAssignmentTemplate();
//			$menu_key_checked = array();
//			$search = array_keys($menu_key_checked);
//			$replace = array_values($menu_key_checked);
//			$this->menu_assignments[$hash] = str_replace($search, $replace, $menu_assignment_tpl); // ?
//		}
//		return $this->menu_assignments[$hash];
		$html = '';
		
		$display_select = &$this->getDisplaySelectOptions();
		$display_language = &$this->getDisplayLanguage();
		$display_checkbox_users = &$this->getDisplayCheckboxUsers();
		$menu_assignment_tpl = &$this->getMenuAssignmentTemplate();
		
		$html .= $display_language;
		$html .= $display_select;
		$html .= '<div class="widefat adoptions-display-content">';
		$html .= $display_checkbox_users;
		$html .= $menu_assignment_tpl;
		$html .= '</div>';
		
		$display_id = $this->widget->get_field_id('widget_display');
		$display_name = $this->widget->get_field_name('widget_display');
		
		$display_language_value = isset($widget_display['display_language']) ? $widget_display['display_language'] : '';
		$display_select_value = isset($widget_display['display_select']) ? $widget_display['display_select'] : '';
		$menus_values = isset($widget_display['checkbox']['menus']) ? $widget_display['checkbox']['menus'] : array();
		$display_checkbox_users_value = isset($widget_display['checkbox']['users']) ? $widget_display['checkbox']['users'] : array();
		
		$menu_key_checked = array();
		
		// Display select
		$menu_key_checked['id-display-select'] = $display_id . '-display-select';
		$menu_key_checked['name-display-select'] = $display_name . '[display_select]';
		$menu_key_checked['id-display-language'] = $display_id . '-display-language';
		$menu_key_checked['name-display-language'] = $display_name . '[display_language]';
		
		foreach ($this->display_select_options as $key => $value) {
			if ($key == $display_select_value) {
				$menu_key_checked['display-select-' . $key] = 'selected="selected"';
			} else $menu_key_checked['display-select-' . $key] = '';
		}
		
		foreach ($this->display_language_options as $key => $value) {
			if ($key == $display_language_value) {
				$menu_key_checked['display-language-' . $key] = 'selected="selected"';
			} else $menu_key_checked['display-language-' . $key] = '';
		}
		
		// Checkbox User
		foreach ($this->display_checkbox_users as $key => $value) {
			$menu_key_checked['id-display-checkbox-user-' . $key] = $display_id . '-users-' . $key;
			$menu_key_checked['name-display-checkbox-user-' . $key] = $display_name . '[checkbox][users][' . $key . ']';
		
			if (array_key_exists($key, $display_checkbox_users_value)) {
				$menu_key_checked['checked-display-checkbox-user-'. $key] = 'checked="checked"';
			} else $menu_key_checked['checked-display-checkbox-user-'. $key] = '';
		}
		
		// Menu assignments
		foreach ($this->menu_assignments as $menu_slug => $menu) {
			foreach ($menu as $item) {
				$menu_key_checked[ $menu_slug . '-' . $item->ID ] = $display_id . '-' . $menu_slug . '-' . $item->ID;
				$menu_key_checked[ $menu_slug . '_' . $item->ID ] = $display_name . '[checkbox][menus][' . $menu_slug . '][' . $item->ID . ']';
				
				if (isset($menus_values[$menu_slug]) && array_key_exists($item->ID, $menus_values[$menu_slug])) {
					$menu_key_checked[$menu_slug . $item->ID ] = 'checked="checked"';
				} else {
					$menu_key_checked[$menu_slug . $item->ID] = '';
				}
			}
		}
		
		return str_replace( array_keys($menu_key_checked), array_values($menu_key_checked), $html);
	}
	
	private function getDisplaySelectOptions(){
		if ( is_null($this->display_select_tpl) ){
			$this->display_select_options = $display_select_options = array(
				'all' => __('All', 'maxshop'),
				'if_selected' => __('Only on selected', 'maxshop'),
				'if_no_selected' => __('Except selected', 'maxshop')
			);
			$html = '';
			$html .= '<p>';
			$html .= '<label for="id-display-select">'. __( 'Widget Display', 'maxshop' ) .  '</label>';
			
			$html .= '<select class="adoptions-display-select widefat " id="id-display-select" name="name-display-select">';
					
			foreach ( $display_select_options as $key => $value) {
				$html .= '<option value="' . $key . '" display-select-'. $key .'>' . $value . '</option>';
			}
			$html .= '</select>';
			$html .= '</p>';
			
			$this->display_select_tpl = $html;
		}
		
		return $this->display_select_tpl;
	}

	private function getDisplayCheckboxUsers(){
		if ( is_null($this->display_checkbox_users_tpl) ){
			$this->display_checkbox_users = $display_checkbox_users = array(
				'login' => __('Show only for login users' , 'maxshop'),
				'logout' => __('Show only for logout users' , 'maxshop')
			);
				
			$html = '';
			$html .='<p><strong>Users</strong><br/>';
					
			foreach ($display_checkbox_users as $key => $name) {
						
				$html .= '<label for="id-display-checkbox-user-' . $key . '">
						<input type="checkbox" id="id-display-checkbox-user-' . $key . '"
								name="name-display-checkbox-user-' . $key . '" checked-display-checkbox-user-'. $key .'/> ' . $name . 
					'</label> <br/>';
			}
			$html .= '</p>';
			
			$this->display_checkbox_users_tpl = $html;
		}
		
			
		return $this->display_checkbox_users_tpl;
	}
	private function getDisplayLanguage(){
		if ( !in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
			return ;
		}
		$language = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str');
		$this -> display_language_options = $language;
		$html = '';
		$html .= '<p>';
		$html .= '<label for="id-display-language">'. __( 'Language Display', 'maxshop' ) .  '</label>';
		
		$html .= '<select class="adoptions-display-language widefat " id="id-display-language" name="name-display-language">';
				
		foreach ( $language as $key => $value) {
			$html .= '<option value="' . $key . '" display-language-'. $key .'>' . $value['language_code'] . '</option>';
		}
		$html .= '</select>';
		$html .= '</p>';
		
		$this->display_language_tpl = $html;
		return $this->display_language_tpl;
	}
	private function getDisplayCheckboxGeneral(){
		if ( is_null($this->display_checkbox_general_tpl) ){
			$this->display_checkbox_general = $display_checkbox_general = array(
					'home' => __('Blog posts', 'maxshop'),
					'archive' => __('Archive page', 'maxshop'),
					'date' => __('Archive Date', 'maxshop'),
					'category' => __('Category archive', 'maxshop'),
					'tag' => __('Tag archive', 'maxshop'),
					'author' => __('Author archive', 'maxshop'),
					'search' => __('Search page', 'maxshop'),
					'single' => __('Single post', 'maxshop'),
					'page' => __('Page template', 'maxshop'),
					'404' => __('Page 404', 'maxshop')
				);
			$html = '';
			$html .='<p><strong>General</strong><br/>';
				
			foreach ($display_checkbox_general as $key => $name) {
	
				$html .= '<label for="id-display-checkbox-general-' . $key . '">
						<input type="checkbox" id="id-display-checkbox-general-' . $key . '"
								name="name-display-checkbox-general-' . $key . '" checked-display-checkbox-general-'. $key .'/> ' . $name .
									'</label> <br/>';
			}
		
			$html .= '</p>';
				
			$html .= '<p><label>' . __( 'Taxonomy slugs', 'maxshop' ) . '</label> <br/>';
			$html .= '<input type="text" id="id-display-taxonomy-slugs"
								name="name-display-taxonomy-slugs" value="value-display-taxonomy-slugs"/></p>';
			
			$html .= '<p><label>' . __( 'Posts type', 'maxshop' ) . '</label> <br/>';
			$html .= '<input type="text" id="id-display-post-type"
								name="name-display-post-type" value="value-display-post-type"/></p>';

			$html .= '<p><label>' . __( 'Categories ID', 'maxshop' ) . '</label> <br/>';
			$html .= '<input type="text" id="id-display-catid"
								name="name-display-catid" value="value-display-catid"/></p>';
				
			$html .= '<p><label>' . __( 'Posts ID', 'maxshop' ) . '</label> <br/>';
			$html .= '<input type="text" id="id-display-postid"
								name="name-display-postid" value="value-display-postid"/></p>';
				
			$this->display_checkbox_general_tpl = $html;
		}
	
			
		return $this->display_checkbox_general_tpl;
	}
	
	private function getMenuAssignmentTemplate(){
		
		if (count($this->menu_assignments) < 1) {
			$menu_locations = get_nav_menu_locations();
			if(count($menu_locations) == 0 )
			return ;
			foreach ($menu_locations as $menu){ 
				
					$menu = wp_get_nav_menu_object($menu);
					$this->menu_assignments[] = $menu;
					//$this->menu_assignments[$menu->slug] = $menu;
			}
		}
		
		if ( is_null($this->display_checkbox_menus) ){
			$menus = $this->menu_assignments;
			$html = '';
			$html .= '<div class="adoptions-display-menu">';
			
			foreach ( $menus as $menu ) {
				if(!isset($menu) || $menu != NULL || $menu != "")
					{
						$items = $this->menu_assignments[$menu->slug] = wp_get_nav_menu_items($menu);
						if (count($items) > 0) {
							$menu_checkbox = new YA_Menu_Checkbox( $menu->slug);
							$html .= '<strong>' . $menu->name . '</strong><span> (Menu)</span>';
							$html .= '<ul>';
							$html .= $menu_checkbox->init($items);
							$html .= '</ul>';
						}
					}
			}
			$html .= '</div>';
			$this->display_checkbox_menus = $html;
		}
		
		return $this->display_checkbox_menus;
	}

	private function render_wdisplay($widget_display){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		//Logger::log($widget_display);
		$widget_display = json_decode(json_encode($widget_display), true);
		$display_select_value = isset($widget_display['display_select']) ? $widget_display['display_select'] : '';
		$display_language_value = isset($widget_display['display_language']) ? $widget_display['display_language'] : '';
		$menus_values = isset($widget_display['checkbox']['menus']) ? $widget_display['checkbox']['menus'] : array();
		$display_checkbox_users_value = isset($widget_display['checkbox']['users']) ? $widget_display['checkbox']['users'] : array();
		$display_checkbox_general_value = isset($widget_display['checkbox']['general']) ? $widget_display['checkbox']['general'] : array();
		
		$taxonomy_slugs = isset($widget_display['taxonomy-slugs']) ? trim($widget_display['taxonomy-slugs']) : '';
		$post_type = isset($widget_display['post-type']) ? trim($widget_display['post-type']) : '';
		$catid = isset($widget_display['catid']) ? trim($widget_display['catid']) : '';
		$postid = isset($widget_display['postid']) ? trim($widget_display['postid']) : '';
		
		$html = '';
		
		$display_language = $this->getDisplayLanguage();
		$display_select = $this->getDisplaySelectOptions();
		$display_checkbox_users = $this->getDisplayCheckboxUsers();
		$display_checkbox_general = $this->getDisplayCheckboxGeneral();
		$menu_assignment_tpl = $this->getMenuAssignmentTemplate();
		$html .= $display_language;
		$html .= $display_select;
		$html .= '<div class="widefat adoptions-display-content" ';
		
		if ($display_select_value == 'all') {
			$html .= 'style="display: none;"';
		}
		$html .= '>';
		$html .= $display_checkbox_users;
		$html .= $display_checkbox_general;
		$html .= $menu_assignment_tpl;
		$html .= '</div>';
		
		$display_id = $this->widget->get_field_id('widget_display');
		$display_name = $this->widget->get_field_name('widget_display');
		
		$menu_key_checked = array();
		
		// Display select
		$menu_key_checked['id-display-select'] = $display_id . '-display-select';
		$menu_key_checked['name-display-select'] = $display_name . '[display_select]';
		$menu_key_checked['id-display-language'] = $display_id . '-display-language';
		$menu_key_checked['name-display-language'] = $display_name . '[display_language]';
		
		foreach ($this->display_select_options as $key => $value) {
			if ($key == $display_select_value) {
				$menu_key_checked['display-select-' . $key] = 'selected="selected"';
			} else $menu_key_checked['display-select-' . $key] = '';
		}
		
		foreach ($this->display_language_options as $key => $value) {
			if ($key == $display_language_value) {
				$menu_key_checked['display-language-'. $key] = 'selected="selected"';
			} else $menu_key_checked['display-language-'. $key] = '';
		}
		
		// Checkbox User
		foreach ($this->display_checkbox_users as $key => $value) {
			$menu_key_checked['id-display-checkbox-user-' . $key] = $display_id . '-users-' . $key;
			$menu_key_checked['name-display-checkbox-user-' . $key] = $display_name . '[checkbox][users][' . $key . ']';
		
			if (array_key_exists($key, $display_checkbox_users_value)) {
				$menu_key_checked['checked-display-checkbox-user-'. $key] = 'checked="checked"';
			} else $menu_key_checked['checked-display-checkbox-user-'. $key] = '';
		}
		
		// Checkbox General
		foreach ($this->display_checkbox_general as $key => $value) {
			$menu_key_checked['id-display-checkbox-general-' . $key] = $display_id . '-general-' . $key;
			$menu_key_checked['name-display-checkbox-general-' . $key] = $display_name . '[checkbox][general][' . $key . ']';
		
			if (array_key_exists($key, $display_checkbox_general_value)) {
				$menu_key_checked['checked-display-checkbox-general-'. $key] = 'checked="checked"';
			} else $menu_key_checked['checked-display-checkbox-general-'. $key] = '';
		}

		// Taxonomy slugs
		$menu_key_checked['id-display-taxonomy-slugs'] = $display_id . '-taxonomy-slugs';
		$menu_key_checked['name-display-taxonomy-slugs'] = $display_name . '[taxonomy-slugs]';
		$menu_key_checked['value-display-taxonomy-slugs'] = $taxonomy_slugs;
		
		// Posts type
		$menu_key_checked['id-display-post-type'] = $display_id . '-post-type';
		$menu_key_checked['name-display-post-type'] = $display_name . '[post-type]';
		$menu_key_checked['value-display-post-type'] = $post_type;
		
		// Categories ID
		$menu_key_checked['id-display-catid'] = $display_id . '-catid';
		$menu_key_checked['name-display-catid'] = $display_name . '[catid]';
		$menu_key_checked['value-display-catid'] = $catid;
		
		// Posts ID
		$menu_key_checked['id-display-postid'] = $display_id . '-postid';
		$menu_key_checked['name-display-postid'] = $display_name . '[postid]';
		$menu_key_checked['value-display-postid'] = $postid;
		
		// Menu assignments
		foreach ($this->menu_assignments as $menu_slug => $menu) {
			if(is_array($menu)){
				foreach ($menu as $item) {
					$menu_key_checked[ $menu_slug . '-' . $item->post_name . '-' . $item->ID ] = $display_id . '-' . $menu_slug . '-' . $item->post_name . '-' . $item->ID;
					$menu_key_checked[ $menu_slug . '_' . $item->post_name . '_' . $item->ID ] = $display_name . '[checkbox][menus][' . $menu_slug . '][' . $item->ID . ']';
					
					if (isset($menus_values[$menu_slug]) && array_key_exists($item->ID, $menus_values[$menu_slug])) {
						$menu_key_checked[$menu_slug . $item->post_name . $item->ID ] = 'checked="checked"';
					} else {
						$menu_key_checked[$menu_slug . $item->post_name . $item->ID] = '';
					}
				}
			}
		}
		
		return str_replace( array_keys($menu_key_checked), array_values($menu_key_checked), $html);
	}
	
	private function render_wdisplayxx($widget_display){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		//Logger::log($widget_display);
		
		$display_checkbox['users'] = array(
					'login' => __('Show only for login users' , 'maxshop'),
					'logout' => __('Show only for logout users' , 'maxshop')
				);
		$display_checkbox['general'] = array(
					'front_page' => __('Front page', 'maxshop'),
					'home' => __('Blog posts', 'maxshop'),
					'archive' => __('Archive page', 'maxshop'),
					'category' => __('Category archive', 'maxshop'),
					'tag' => __('Tag archive', 'maxshop'),
					'author' => __('Author archive', 'maxshop'),
					'search' => __('Search page', 'maxshop'),
					'page' => __('Pages', 'maxshop'),
					'single' => __('Single post page', 'maxshop')
				);
		//Get pages
		$pages = get_pages();
		$display_checkbox['pages'] = array();
		foreach ($pages as $page) {
			$display_checkbox['pages'][$page->ID] = $page->post_title;
		}
		
		//Get categories
		$cats = get_categories();
		$display_checkbox['cats'] = array();
		foreach ($cats as $cat) {
			$display_checkbox['cats'][$cat->cat_ID] = $cat->cat_name;
		}
				
		$display_select = array(
					'all' => __('All', 'maxshop'),
					'if_selected' => __('Only on selected', 'maxshop'),
					'if_no_selected' => __('Except selected', 'maxshop')
				);
				
		$display_name = $this->widget->get_field_name('widget_display');
		?>
		<p>
			<label
				for="<?php echo $this->widget->get_field_id('display_select'); ?>"><?php _e( 'Widget Display', 'maxshop' ) ?>
			</label>
			<select class="adoptions-display-select widefat "
				id="<?php echo $this->widget->get_field_id('display_select'); ?>"
				name="<?php echo esc_attr($display_name.'[display_select]'); ?>" >
				<?php foreach ( $display_select as $value => $name) { ?>
					<option value="<?php echo esc_attr( $value ); ?>"
						<?php if ( isset($widget_display['display_select']) && $widget_display['display_select'] == $value ) echo 'selected="selected"'; ?>>
						<?php echo esc_html( $name ) ?></option>
				<?php }?>
			</select>
		</p>
		
		<div class="widefat adoptions-display-content"
				style="<?php if ( !isset($widget_display['display_select']) || $widget_display['display_select'] == 'all' ) echo 'display: none;'; ?>">
		
		<p><strong>Users</strong><br/>
		<?php
		foreach ($display_checkbox['users'] as $value => $name) { ?>
			
			<input type="checkbox" id="<?php $this->widget->get_field_id($value)?>"
					name="<?php  echo esc_attr($display_name.'[checkbox][users]['.$value.']')?>"
					<?php if ( isset($widget_display['checkbox']['users'][$value]) ) echo 'checked="checked"'; ?>
				/>
			<label for="<?php echo $this->widget->get_field_id($value); ?>"><?php esc_html( $name );?></label><br/>
		<?php } ?>
		</p>
		<p><strong>General</strong><br/>
		<?php
		foreach ($display_checkbox['general'] as $value => $name) { ?>
			
			<input type="checkbox" id="<?php $this->widget->get_field_id($value)?>"
					name="<?php  echo esc_attr($display_name.'[checkbox][general]['.$value.']')?>"
					<?php if ( isset($widget_display['checkbox']['general'][$value]) ) echo 'checked="checked"'; ?>
				/>
			<label for="<?php echo $this->widget->get_field_id($value); ?>"><?php echo $name; ?></label><br/>
		<?php } ?>
		</p>
		<p><strong>Categories</strong><br/>
		<?php
		foreach ($display_checkbox['cats'] as $value => $name) { ?>
			
			<input type="checkbox" id="<?php $this->widget->get_field_id($value)?>"
					name="<?php  echo esc_attr($display_name.'[checkbox][cats]['.$value.']')?>"
					<?php if ( isset($widget_display['checkbox']['cats'][$value]) ) echo 'checked="checked"'; ?>
				/>
			<label for="<?php echo $this->widget->get_field_id($value); ?>"><?php esc_html($name) ?></label><br/>
		<?php } ?>
		</p>
				<p><strong>Pages</strong><br/>
		<?php
		foreach ($display_checkbox['pages'] as $value => $name) { ?>
			
			<input type="checkbox" id="<?php $this->widget->get_field_id($value)?>"
					name="<?php  echo esc_attr($display_name.'[checkbox][pages]['.$value.']')?>"
					<?php if ( isset($widget_display['checkbox']['pages'][$value]) ) echo 'checked="checked"'; ?>
				/>
			<label for="<?php echo $this->widget->get_field_id($value); ?>"><?phpesc_html( $name ) ?></label><br/>
		<?php } ?>
		</p>
		</div>
		<?php
	}

	/**
	 * Scans a directory for files of a certain extension.
	 *
	 * @since 3.4.0
	 * @access private
	 *
	 * @param string $path Absolute path to search.
	 * @param mixed  Array of extensions to find, string of a single extension, or null for all extensions.
	 * @param int $depth How deep to search for files. Optional, defaults to a flat scan (0 depth). -1 depth is infinite.
	 * @param string $relative_path The basename of the absolute path. Used to control the returned path
	 * 	for the found files, particularly when this function recurses to lower depths.
	 */
	protected function scandir( $path, $extensions = null, $depth = 0, $relative_path = '' ) {
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		
		if ( ! is_dir( $path ) )
			return false;

		if ( $extensions ) {
			$extensions = (array) $extensions;
			$_extensions = implode( '|', $extensions );
		}

		$relative_path = trailingslashit( $relative_path );
		if ( '/' == $relative_path )
			$relative_path = '';

		$results = scandir( $path );
		$files = array();

		foreach ( $results as $result ) {
			if ( '.' == $result[0] )
				continue;
			if ( is_dir( $path . '/' . $result ) ) {
				if ( ! $depth || 'CVS' == $result )
					continue;
				$found = self::scandir( $path . '/' . $result, $extensions, $depth - 1 , $relative_path . $result );
				$files = array_merge_recursive( $files, $found );
			} elseif ( ! $extensions || preg_match( '~\.(' . $_extensions . ')$~', $result ) ) {
				$files[ $relative_path . $result ] = $path . '/' . $result;
			}
		}

		return $files;
	}

	protected function getWidgetStyles(){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		
		if ( is_null($this->styles) ){
			$tmp = array();
			if ( $_core_styles = $this->scandir(YA_DIR.'/widgets/_styles', 'php') )
			foreach( $_core_styles as $f ){
				$alias = basename($f, '.php');
				$name  = ucfirst($alias);
				$tmp[ $alias ] = $name;
			}

			if ( $_theme_styles = $this->scandir(get_template_directory().'/widgets/_styles') )
			foreach( $_theme_styles as $f ){
				$alias = basename($f, '.php');
				$name  = ucfirst($alias);
				$tmp[ $alias ] = $name;
			}
			
			$this->styles = $tmp;
		}
		return $this->styles;
	}
	
	protected function getStyleIn( $instance = array(), $load_style = true ){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		//Logger::log($instance);
		//Logger::log($load_style);
		
		$styles = $this->getWidgetStyles();
		$current_style = isset( $instance['widget_style'] ) ? trim($instance['widget_style']) : '';
		//var_dump($current_style);
		if ( !empty($current_style) && isset($styles[$current_style]) ){
			
		} else {
			$current_style = '';
		}
		return $load_style ? $this->loadStyle($current_style) : $current_style;
	}
	
	protected function loadStyle( $style = '' ){
		//Logger::log(__CLASS__.'::'.__FUNCTION__);
		//Logger::log(__CLASS__.'::'.__FUNCTION__.' args: ' . $style);
		
		if ( !empty($style) ){

			$_theme_style = get_template_directory().'/widgets/_styles/'.$style.'.php';
			
			if ( file_exists($_theme_style) ){
				require $_theme_style;
				return @$ws[$style];
			}
			
			$_core_style = YA_DIR.'/widgets/_styles/'.$style.'.php';
			if ( file_exists($_core_style) ){
				require $_core_style;
				return @$ws[$style];
			}
			
			if ( $style != 'default' ){
				return $this->loadStyle('default');
			}
			
		}
		return false;
	}
}

$widgets = new YA_Widgets;
