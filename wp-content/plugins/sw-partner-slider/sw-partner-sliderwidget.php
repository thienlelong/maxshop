<?php
/**
 * Plugin Name: SW Partner Slider Widget
 * Plugin URI: http://www.magentech.com
 * Description: A widget that serves as an slider for developing more advanced widgets.
 * Version: 1.0
 * Author: magentech
 * Author URI: http://www.magentech.com
 *
 * This Widget help you to show images of product as a beauty reponsive slider
 */
require_once( plugin_dir_path( __FILE__ ) . 'taxonomy_partner.php' );

add_action( 'widgets_init', 'sw_partner' );

/**
 * Register our widget.
 * 'Slideshow_Widget' is the widget class used below.
 */
function sw_partner() {
	register_widget( 'sw_partner_slider_widget' );
}

/**
 * Load script (css, js).
 * 
 */
 
function load_partner_slider_script(){
    
    }
add_action('wp_enqueue_scripts', 'load_partner_slider_script', 11);
/**
 * ya slideshow Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, display, and update.  Nice!
 */
class sw_partner_slider_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw_partner_slider', 'description' => __('Sw Partner Slider', 'yatheme') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_partner_slider' );

		/* Create the widget. */
		parent::__construct( 'sw_partner_slider', __('Sw Partner Slider widget', 'yatheme'), $widget_ops, $control_ops );
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
		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		
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
		$instance['title'] = strip_tags( $new_instance['title'] );

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
		if ( array_key_exists('anchor', $new_instance) ){
			$instance['anchor'] = strip_tags( $new_instance['anchor'] );
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
		if ( array_key_exists('effect', $new_instance) ){
			$instance['effect'] = strip_tags( $new_instance['effect'] );
		}
		if ( array_key_exists('hover', $new_instance) ){
			$instance['hover'] = strip_tags( $new_instance['hover'] );
		}
		if ( array_key_exists('swipe', $new_instance) ){
			$instance['swipe'] = strip_tags( $new_instance['swipe'] );
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
		
		$categories = get_terms('partners');
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
		$title    = isset( $instance['title'] )     ? strip_tags($instance['title']) : '';      
		$categoryid = isset( $instance['category'] )    ? $instance['category'] : 0;
		$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
		$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
		$number     = isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
        $length     = isset( $instance['length'] )      ? intval($instance['length']) : 25;
		$columns     = isset( $instance['columns'] )      ? intval($instance['columns']) : '';
		$columns1     = isset( $instance['columns1'] )      ? intval($instance['columns1']) : '';
		$columns2     = isset( $instance['columns2'] )      ? intval($instance['columns2']) : '';
		$columns3     = isset( $instance['columns3'] )      ? intval($instance['columns3']) : '';
		$columns4     = isset( $instance['columns'] )      ? intval($instance['columns4']) : '';
		$anchor     = isset( $instance['anchor'] )      ? strip_tags($instance['anchor']) : '';
		$interval     = isset( $instance['interval'] )      ? intval($instance['interval']) : 5000;
		$speed     = isset( $instance['speed'] )      ? intval($instance['speed']) : 1000;
		$start     = isset( $instance['start'] )      ? intval($instance['start']) : 1;
		$scroll     = isset( $instance['scroll'] )      ? intval($instance['scroll']) : 1;
		$effect     = isset( $instance['effect'] )      ? strip_tags($instance['effect']) : 'slide';
		$hover     = isset( $instance['hover'] )      ? strip_tags($instance['hover']) : '';
		$swipe     = isset( $instance['swipe'] )      ? strip_tags($instance['swipe']) : 'true';
		$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
                   
                 
		?>
        </p> 
          <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'yatheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
				type="text"	value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category ID', 'yatheme')?></label>
			<br />
			<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'yatheme')?></label>
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
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'yatheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
				<?php } ?>>
					<?php _e('Descending', 'yatheme')?>
				</option>
				<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
					<?php _e('Ascending', 'yatheme')?>
				</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'yatheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
				type="text"	value="<?php echo esc_attr($number); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'yatheme')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
				value="<?php echo esc_attr($length); ?>" />
		</p>  
		<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6); ?>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'yatheme')?></label>
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
			<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 768px to 1199px: ', 'yatheme')?></label>
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
			<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'yatheme')?></label>
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
			<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 321px to 479px: ', 'yatheme')?></label>
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
			<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 320px or less than: ', 'yatheme')?></label>
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
			<label for="<?php echo $this->get_field_id('anchor'); ?>"><?php _e('Control button position: ', 'yatheme')?></label>
			<br />
			<?php $arr_anchor = array('Top' => 'top', 'Bottom' => 'bottom');?>
			<select class="widefat"
				id="<?php echo $this->get_field_id('anchor'); ?>"
				name="<?php echo $this->get_field_name('anchor'); ?>">
				<?php
				$option ='';
				foreach ($arr_anchor as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $anchor){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'yatheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
				type="text"	value="<?php echo esc_attr($interval); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'yatheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
				type="text"	value="<?php echo esc_attr($speed); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('start'); ?>"><?php _e('Starting Item', 'yatheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('start'); ?>" name="<?php echo $this->get_field_name('start'); ?>"
				type="text"	value="<?php echo esc_attr($start); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'yatheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
				type="text"	value="<?php echo esc_attr($scroll); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('effect'); ?>"><?php _e('Effect', 'yatheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('effect'); ?>" name="<?php echo $this->get_field_name('effect'); ?>">
				<option value="slide" <?php if ($effect=='slide'){?> selected="selected"
				<?php } ?>>
					<?php _e('Slide', 'yatheme')?>
				</option>
				<option value="fade" <?php if ($effect=='fade'){?> selected="selected"	<?php } ?>>
					<?php _e('Fade', 'yatheme')?>
				</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('hover'); ?>"><?php _e('Stop when hover', 'yatheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('hover'); ?>" name="<?php echo $this->get_field_name('hover'); ?>">
				<option value="hover" <?php if ($hover=='hover'){?> selected="selected"
				<?php } ?>>
					<?php _e('yes', 'yatheme')?>
				</option>
				<option value="" <?php if ($hover==''){?> selected="selected"	<?php } ?>>
					<?php _e('No', 'yatheme')?>
				</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('swipe'); ?>"><?php _e('Swipe', 'yatheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('swipe'); ?>" name="<?php echo $this->get_field_name('swipe'); ?>">
				<option value="yes" <?php if ($swipe=='yes'){?> selected="selected"
				<?php } ?>>
					<?php _e('Yes', 'yatheme')?>
				</option>
				<option value="no" <?php if ($swipe=='no'){?> selected="selected"	<?php } ?>>
					<?php _e('No', 'yatheme')?>
				</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'yatheme')?></label>
			<br/>
			
			<select class="widefat"
				id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
				<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
				<?php } ?>>
					<?php _e('Theme1', 'yatheme')?>
				</option>
			</select>
		</p>           
	<?php
	}	
}
?>