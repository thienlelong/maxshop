<?php
/**
 * Plugin Name: SW Responsive Slider Widget
 * Plugin URI: http://flytheme.com
 * Description: A widget that serves as an slideshow for developing more advanced widgets.
 * Version: 1.0
 * Author: flytheme.com
 * Author URI: http://flytheme.com
 *
 * This Widget help you to show images of product as a beauty reponsive slideshow
 */

add_action( 'widgets_init', 'sw_responsive_slider' );

/**
 * Register our widget.
 * 'Slideshow_Widget' is the widget class used below.
 */
function sw_responsive_slider() {
	register_widget( 'sw_resp_slider' );
}
 
/**
 * ya slideshow Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, display, and update.  Nice!
 */
class sw_resp_slider extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw_resp_slider', 'description' => __('Sw Responsive Slider Widget', 'yatheme') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_resp_slider' );

		/* Create the widget. */
		parent::__construct( 'sw_resp_slider', __('Sw Responsive Slider Widget', 'yatheme'), $widget_ops, $control_ops );
		
		/* Create Shortcode */
		add_shortcode( 'respost_slide', array( $this, 'RP_Shortcode' ) );
		
		/* Create Vc_map */
		if (class_exists('Vc_Manager')) {
			add_action( 'vc_before_init', array( $this, 'RP_integrateWithVC' ) );
		}
	}
	
	/**
	* Add Vc Params
	**/
	function RP_integrateWithVC(){
		$link_category = array( __( 'All Category', 'js_composer' ) => '' );
		$link_cats     = get_categories();
		if ( is_array( $link_cats ) ) {
			foreach ( $link_cats as $link_cat ) {
				$link_category[ $link_cat->name ] = $link_cat->term_id;
			}
		}
		vc_map( array(
		  "name" => __( "YA Responsive Post Slider", "flytheme" ),
		  "base" => "respost_slide",
		  "icon" => "icon-wpb-ytc",
		  "class" => "",
		  "category" => __( "SW Core", "flytheme"),
		  "params" => array(
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Title", "flytheme" ),
				"param_name" => "title2",
				"value" => __( "", "flytheme" ),
				"description" => __( "Title", "flytheme" )
			 ),
			 array(
			'param_name'    => 'category',
			'type'          => 'dropdown',
			'value'         => $link_category, // here I'm stuck
			'heading'       => __('Category filter:', 'flytheme'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
			 ),
			 array(
				'type' => 'textfield',
				'heading' => __( 'Excerpt length (in words)', 'js_composer' ),
				'param_name' => 'length',
				'description' => __( 'Excerpt length (in words).', 'js_composer' )
			),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Order By", "flytheme" ),
				"param_name" => "orderby",
				"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Title' => 'title', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
				"description" => __( "Order By", "flytheme" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Order", "flytheme" ),
				"param_name" => "order",
				"value" => array('Descending' => 'DESC', 'Ascending' => 'ASC'),
				"description" => __( "Order", "flytheme" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number Of Post", "flytheme" ),
				"param_name" => "numberposts",
				"value" => 5,
				"description" => __( "Number Of Post", "flytheme" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns >1200px: ", "flytheme" ),
				"param_name" => "columns",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns >1200px:", "flytheme" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 992px to 1199px:", "flytheme" ),
				"param_name" => "columns1",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 992px to 1199px:", "flytheme" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 768px to 991px:", "flytheme" ),
				"param_name" => "columns2",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 768px to 991px:", "flytheme" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 480px to 767px:", "flytheme" ),
				"param_name" => "columns3",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 480px to 767px:", "flytheme" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns in 480px or less than:", "flytheme" ),
				"param_name" => "columns4",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns in 480px or less than:", "flytheme" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Speed", "flytheme" ),
				"param_name" => "speed",
				"value" => 1000,
				"description" => __( "Speed Of Slide", "flytheme" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Auto Play", "flytheme" ),
				"param_name" => "autoplay",
				"value" => array( 'True' => 'true', 'False' => 'false' ),
				"description" => __( "Auto Play", "flytheme" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Interval", "flytheme" ),
				"param_name" => "interval",
				"value" => 5000,
				"description" => __( "Interval", "flytheme" )
			 ),
			  array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Layout", "flytheme" ),
				"param_name" => "layout",
				"value" => array( 'Layout Default' => '1'),
				"description" => __( "Layout", "flytheme" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Total Items Slided", "flytheme" ),
				"param_name" => "scroll",
				"value" => 1,
				"description" => __( "Total Items Slided", "flytheme" )
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function RP_Shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title2' => '',
				'header_style' => '',
				'category' => '',
				'orderby' => '',
				'order'	=> '',
				'numberposts' => 5,
				'length' => 25,
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,
				'speed' => 1000,
				'autoplay' => 'true',
				'interval' => 5000,
				'layout'  => 1,
				'scroll' => 1
			), $atts )
		);
		ob_start();		
		if( $layout == 1 ){
			include( 'themes/default.php' );
		}
		
		$content = ob_get_clean();
		
		return $content;
	}
	
	public function ya_trim_words( $text, $num_words = 30, $more = null ) {
		$text = strip_shortcodes( $text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		return wp_trim_words($text, $num_words, $more);
	}
	/**
	 * Display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		wp_reset_postdata();
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
		$description1 = apply_filters( 'widget_description', empty( $instance['description1'] ) ? '' : $instance['description1'], $instance, $this->id_base );
		echo $before_widget;
		if ( !empty( $title ) && !empty( $description1 ) ) { echo $before_title . $title . $after_title . '<h5 class="category_description clearfix">' . $description1 . '</h5>'; }
		else if (!empty( $title ) && $description1==NULL ){ echo $before_title . $title . $after_title; }
		
		if (!isset($instance['category'])){
			$instance['category'] = 0;
		}
		extract($instance);

		if ( !array_key_exists('widget_template', $instance) ){
			$instance['widget_template'] = 'default';
		}
		
		if ( $tpl = $this->getTemplatePath( $instance['widget_template'] ) ){ 
			$link_img = plugins_url('images/', __FILE__);
			$widget_id = $args['widget_id'];		
			include $tpl;
		}
				
		/* After widget (defined by themes). */
		echo $after_widget;
	}    

	protected function getTemplatePath($tpl='default', $type=''){
		$file = '/'.$tpl.$type.'.php';
		$dir =realpath(dirname(__FILE__)).'/themes';
		
		if ( file_exists( $dir.$file ) ){
			return $dir.$file;
		}
		
		return $tpl=='default' ? false : $this->getTemplatePath('default', $type);
	}
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// strip tag on text field
		$instance['title2'] = strip_tags( $new_instance['title2'] );
		$instance['description'] = strip_tags( $new_instance['description'] );
		// int or array
		if ( array_key_exists('category', $new_instance) ){
			if ( is_array($new_instance['category']) ){
				$instance['category'] = array_map( 'intval', $new_instance['category'] );
			} else {
				$instance['category'] = intval($new_instance['category']);
			}
		}
		
		if ( array_key_exists('orderby', $new_instance) ){
			$instance['orderby'] = strip_tags( $new_instance['orderby'] );
		}

		if ( array_key_exists('order', $new_instance) ){
			$instance['order'] = strip_tags( $new_instance['order'] );
		}

		if ( array_key_exists('numberposts', $new_instance) ){
			$instance['numberposts'] = intval( $new_instance['numberposts'] );
		}

		if ( array_key_exists('length', $new_instance) ){
			$instance['length'] = intval( $new_instance['length'] );
		}
		
		if ( array_key_exists('columns', $new_instance) ){
			$instance['columns'] = intval( $new_instance['columns'] );
		}
		if ( array_key_exists('columns1', $new_instance) ){
			$instance['columns1'] = intval( $new_instance['columns1'] );
		}
		if ( array_key_exists('columns2', $new_instance) ){
			$instance['columns2'] = intval( $new_instance['columns2'] );
		}
		if ( array_key_exists('columns3', $new_instance) ){
			$instance['columns3'] = intval( $new_instance['columns3'] );
		}
		if ( array_key_exists('columns4', $new_instance) ){
			$instance['columns4'] = intval( $new_instance['columns4'] );
		}		
		if ( array_key_exists('interval', $new_instance) ){
			$instance['interval'] = intval( $new_instance['interval'] );
		}
		if ( array_key_exists('speed', $new_instance) ){
			$instance['speed'] = intval( $new_instance['speed'] );
		}
		if ( array_key_exists('start', $new_instance) ){
			$instance['start'] = intval( $new_instance['start'] );
		}
		if ( array_key_exists('scroll', $new_instance) ){
			$instance['scroll'] = intval( $new_instance['scroll'] );
		}	
		if ( array_key_exists('autoplay', $new_instance) ){
			$instance['autoplay'] = strip_tags( $new_instance['autoplay'] );
		}
        $instance['widget_template'] = strip_tags( $new_instance['widget_template'] );
        
					
        
		return $instance;
	}

	function category_select( $field_name, $opts = array(), $field_value = null ){
		$default_options = array(
				'multiple' => false,
				'disabled' => false,
				'size' => 5,
				'class' => 'widefat',
				'required' => false,
				'autofocus' => false,
				'form' => false,
		);
		$opts = wp_parse_args($opts, $default_options);
	
		if ( (is_string($opts['multiple']) && strtolower($opts['multiple'])=='multiple') || (is_bool($opts['multiple']) && $opts['multiple']) ){
			$opts['multiple'] = 'multiple';
			if ( !is_numeric($opts['size']) ){
				if ( intval($opts['size']) ){
					$opts['size'] = intval($opts['size']);
				} else {
					$opts['size'] = 5;
				}
			}
		} else {
			// is not multiple
			unset($opts['multiple']);
			unset($opts['size']);
			if (is_array($field_value)){
				$field_value = array_shift($field_value);
			}
			if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
				unset($opts['allow_select_all']);
				$allow_select_all = '<option value="0">All Categories</option>';
			}
		}
	
		if ( (is_string($opts['disabled']) && strtolower($opts['disabled'])=='disabled') || is_bool($opts['disabled']) && $opts['disabled'] ){
			$opts['disabled'] = 'disabled';
		} else {
			unset($opts['disabled']);
		}
	
		if ( (is_string($opts['required']) && strtolower($opts['required'])=='required') || (is_bool($opts['required']) && $opts['required']) ){
			$opts['required'] = 'required';
		} else {
			unset($opts['required']);
		}
	
		if ( !is_string($opts['form']) ) unset($opts['form']);
	
		if ( !isset($opts['autofocus']) || !$opts['autofocus'] ) unset($opts['autofocus']);
	
		$opts['id'] = $this->get_field_id($field_name);
	
		$opts['name'] = $this->get_field_name($field_name);
		if ( isset($opts['multiple']) ){
			$opts['name'] .= '[]';
		}
		$select_attributes = '';
		foreach ( $opts as $an => $av){
			$select_attributes .= "{$an}=\"{$av}\" ";
		}
		
		$categories = get_categories();
		//print '<pre>'; var_dump($categories);
		// if (!$templates) return '';
		$all_category_ids = array();
		foreach ($categories as $cat) $all_category_ids[] = (int)$cat->term_id;
		
		$is_valid_field_value = is_numeric($field_value) && in_array($field_value, $all_category_ids);
		if (!$is_valid_field_value && is_array($field_value)){
			$intersect_values = array_intersect($field_value, $all_category_ids);
			$is_valid_field_value = count($intersect_values) > 0;
		}
		if (!$is_valid_field_value){
			$field_value = '0';
		}
	
		$select_html = '<select ' . $select_attributes . '>';
		if (isset($allow_select_all)) $select_html .= $allow_select_all;
		foreach ($categories as $cat){
			$select_html .= '<option value="' . $cat->term_id . '"';
			if ($cat->term_id == $field_value || (is_array($field_value)&&in_array($cat->term_id, $field_value))){ $select_html .= ' selected="selected"';}
			$select_html .=  '>'.$cat->name.'</option>';
		}
		$select_html .= '</select>';
		return $select_html;
	}
	

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults ); 		
		         
		$title2 = isset( $instance['title2'] )    ? 	strip_tags($instance['title2']) : '';
		$description = isset( $instance['description'] )    ? 	strip_tags($instance['description']) : '';
		$categoryid = isset( $instance['category'] )    ? $instance['category'] : 0;
		$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
		$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
		$number     = isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
        $length     = isset( $instance['length'] )      ? intval($instance['length']) : 25;
		$columns     = isset( $instance['columns'] )      ? intval($instance['columns']) : '';
		$columns1     = isset( $instance['columns1'] )      ? intval($instance['columns1']) : '';
		$columns2     = isset( $instance['columns2'] )      ? intval($instance['columns2']) : '';
		$columns3     = isset( $instance['columns3'] )      ? intval($instance['columns3']) : '';
		$columns4     = isset( $instance['columns4'] )      ? intval($instance['columns4']) : '';
		$autoplay     = isset( $instance['autoplay'] )      ? strip_tags($instance['autoplay']) : 'true';
		$interval     = isset( $instance['interval'] )      ? intval($instance['interval']) : 5000;
		$speed     = isset( $instance['speed'] )      ? intval($instance['speed']) : 1000;
		$scroll     = isset( $instance['scroll'] )      ? intval($instance['scroll']) : 1;
		$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
                   
                 
		?>		
        </p> 
          <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
        </p>
		
		<p>
			<label for="<?php echo $this->get_field_id('title2'); ?>"><?php _e('Title', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>"
				type="text"	value="<?php echo esc_attr($title2); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"
				type="text"	value="<?php echo esc_attr($description); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category ID', 'flytheme')?></label>
			<br />
			<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'flytheme')?></label>
			<br />
			<?php $allowed_keys = array('name' => 'Name', 'author' => 'Author', 'date' => 'Date', 'title' => 'Title', 'modified' => 'Modified', 'parent' => 'Parent', 'ID' => 'ID', 'rand' =>'Rand', 'comment_count' => 'Comment Count'); ?>
			<select class="widefat"
				id="<?php echo $this->get_field_id('orderby'); ?>"
				name="<?php echo $this->get_field_name('orderby'); ?>">
				<?php
				$option ='';
				foreach ($allowed_keys as $value => $key) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $orderby){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'flytheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
				<?php } ?>>
					<?php _e('Descending', 'flytheme')?>
				</option>
				<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
					<?php _e('Ascending', 'flytheme')?>
				</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
				type="text"	value="<?php echo esc_attr($number); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'flytheme')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
				value="<?php echo esc_attr($length); ?>" />
		</p>  
		<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6); ?>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'flytheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns'); ?>"
				name="<?php echo $this->get_field_name('columns'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', 'flytheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns1'); ?>"
				name="<?php echo $this->get_field_name('columns1'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns1){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', 'flytheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns2'); ?>"
				name="<?php echo $this->get_field_name('columns2'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns2){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'flytheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns3'); ?>"
				name="<?php echo $this->get_field_name('columns3'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns3){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', 'flytheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns4'); ?>"
				name="<?php echo $this->get_field_name('columns4'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns4){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', 'yatheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
				<option value="false" <?php if ($autoplay=='false'){?> selected="selected"
				<?php } ?>>
					<?php _e('False', 'yatheme')?>
				</option>
				<option value="true" <?php if ($autoplay=='true'){?> selected="selected"	<?php } ?>>
					<?php _e('True', 'yatheme')?>
				</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
				type="text"	value="<?php echo esc_attr($interval); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
				type="text"	value="<?php echo esc_attr($speed); ?>" />
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'flytheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
				type="text"	value="<?php echo esc_attr($scroll); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'flytheme')?></label>
			<br/>			
			<select class="widefat"	id="<?php echo $this->get_field_id('widget_template'); ?>" name="<?php echo $this->get_field_name('widget_template'); ?>">
				<option value="default" <?php if ($widget_template=='default'){?> selected="selected" <?php } ?>> <?php _e('Default', 'flytheme')?>	</option>
				<option value="theme1" <?php if ($widget_template=='theme1'){?> selected="selected" <?php } ?>> <?php _e('Theme1', 'flytheme')?></option>
				<option value="theme2" <?php if ($widget_template=='theme2'){?> selected="selected" <?php } ?>><?php _e('Theme2', 'flytheme')?></option>				
			</select>
		</p>           
	<?php
	}	
}
?>