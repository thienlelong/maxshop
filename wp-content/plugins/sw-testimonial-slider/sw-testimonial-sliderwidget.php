<?php
/**
 * Plugin Name: SW Testimonial Slider Widget
 * Plugin URI: http://www.magentech.com
 * Description: A widget that serves as an slider for developing more advanced widgets.
 * Version: 1.0
 * Author: Magentech
 * Author URI: www.magentech.com
 *
 * This Widget help you to show images of product as a beauty reponsive slider
 */
require_once( plugin_dir_path( __FILE__ ) . 'taxonomy.php' );

add_action( 'widgets_init', 'sw_testimonial' );

/**
 * Register our widget.
 * 'Slideshow_Widget' is the widget class used below.
 */
function sw_testimonial() {
	register_widget( 'sw_testimonial_slider_widget' );
}

/**
 * Load script (css, js).
 * 
 */
 /*
function load_partner_slider_script(){
        if (!is_admin() && !defined('SW_PARTNER_SLIDER')) {      
            define('SW_PARTNER_SLIDER', 'ASSETS SW PARTNER SLIDER CONTENT');
			wp_register_style( 'partner-styles', plugins_url('css/slider.css', __FILE__) );
			wp_enqueue_style('partner-styles');
			
            wp_register_script( 'wooslider-js', plugins_url( '/js/slider.js', __FILE__ ),array(), null, true );		
            if (!wp_script_is('wooslider-js')) {
				wp_enqueue_script('wooslider-js');
			} 
			wp_register_script( 'swipe-js', plugins_url( '/js/jquery.cj-swipe.js', __FILE__ ),array(), null, true );	
			if (!wp_script_is('swipe-js')) {
				wp_enqueue_script('swipe-js');
			}               
        }
    }
add_action('wp_enqueue_scripts', 'load_partner_slider_script', 11); */
/**
 * ya slideshow Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, display, and update.  Nice!
 */
class sw_testimonial_slider_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw_testimonial_slider', 'description' => __('Sw Testimonial Slider', 'yatheme') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_testimonial_slider' );

		/* Create the widget. */
		parent::__construct( 'sw_testimonial_slider', __('Sw Testimonial Slider widget', 'yatheme'), $widget_ops, $control_ops );
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
        $instance['el_class']=strip_tags($new_instance['el_class']);
        $instance['style_title']=strip_tags($new_instance['style_title']);
		// int or array
		
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
		
        $instance['widget_template'] = strip_tags( $new_instance['widget_template'] );
        
					
        
		return $instance;
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
        $el_class  = isset( $instance['el_class'] )    ? 	strip_tags($instance['el_class']) : '';
        $style_title  = isset( $instance['style_title'] )    ? 	strip_tags($instance['style_title']) : '';		
		$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
		$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
		$number     = isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
        $length     = isset( $instance['length'] )      ? intval($instance['length']) : 25;
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
		<p>
			<label for="<?php echo $this->get_field_id('el_class'); ?>"><?php _e('El_class', 'yatheme')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('el_class'); ?>" name="<?php echo $this->get_field_name('el_class'); ?>"
				type="text"	value="<?php echo esc_attr($el_class); ?>" />
		</p>

<?php $style_title_name = array('title1' => 'title1', 'title2' => 'title2', 'title3' => 'title3', 'title4' => 'title4'); ?>
<p>
			<label for="<?php echo $this->get_field_id('style_title'); ?>"><?php _e('Style title ', 'yatheme')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('style_title'); ?>"
				name="<?php echo $this->get_field_name('style_title'); ?>">
				<?php
				$option ='';
				foreach ($style_title_name as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $style_title){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
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
				<option value="theme2" <?php if ($widget_template=='theme2'){?>
				<?php } ?>>
					<?php _e('Theme2', 'yatheme')?>
				</option>
			</select>
		</p>           
	<?php
	}	
}
?>