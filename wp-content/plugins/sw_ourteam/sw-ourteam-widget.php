<?php
/**
 * Plugin Name: SW Our Team Slider
 * Plugin URI: http://smartaddons.com
 * Description: A widget that serves as an slider for developing more advanced widgets.
 * Version: 1.0
 * Author: smartaddons.com
 * Author URI: http://smartaddons.com
 *
 * This Widget help you to show images of product as a beauty reponsive slider
 */
require_once( plugin_dir_path( __FILE__ ) . 'taxonomy_team.php' );

add_action( 'widgets_init', 'sw_ourteam' );

/**
 * Register our widget.
 * 'Slideshow_Widget' is the widget class used below.
 */
function sw_ourteam() {
	register_widget( 'sw_ourteam_slider_widget' );
}

/**
 * ya slideshow Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, display, and update.  Nice!
 */
class sw_ourteam_slider_widget extends WP_Widget {
	function __construct(){
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw_team_slider', 'description' => __('Sw Ourteam Slider', 'yatheme') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_team_slider' );

		/* Create the widget. */
		parent::__construct( 'sw_team_slider', __('Sw Ourteam Slider widget', 'yatheme'), $widget_ops, $control_ops );
		
		/* Create Shortcode */
		add_shortcode( 'ourteam', array( $this, 'OT_Shortcode' ) );
		
		/* Create Vc_map */
		if (class_exists('Vc_Manager')) {
			add_action( 'vc_before_init', array( $this, 'OT_integrateWithVC' ) );
		}
		
		/* Add Script */
		add_action('wp_enqueue_scripts', array( $this, 'load_team_slider_script' ), 100);
	}
	public function load_team_slider_script(){		
		wp_register_script( 'slick_slider_js', plugins_url( 'js/slick.min.js', __FILE__ ),array(), null, false );		
		if (!wp_script_is('slick_slider_js')) {
			wp_enqueue_script('slick_slider_js');
		}  
	}
	/**
		* Add Vc Params
	**/
	function OT_integrateWithVC(){
		vc_map( array(
		  "name" => __( "Our Team", "smartaddons" ),
		  "base" => "ourteam",
		  'icon' => get_template_directory_uri() . "/assets/img/icon_vc.png",
		  "class" => "",
		  "category" => __( "Ya Shortcode", "smartaddons"),
		  "params" => array(
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Title", "smartaddons" ),
				"param_name" => "title",
				"value" => __( "", "smartaddons" ),
				"description" => __( "Title", "smartaddons" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Order By", "smartaddons" ),
				"param_name" => "orderby",
				"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Title' => 'title', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
				"description" => __( "Order By", "smartaddons" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Order", "smartaddons" ),
				"param_name" => "order",
				"value" => array('Descending' => 'DESC', 'Ascending' => 'ASC'),
				"description" => __( "Order", "smartaddons" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number Of Post", "smartaddons" ),
				"param_name" => "numberposts",
				"value" => 5,
				"description" => __( "Number Of Post", "smartaddons" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns >1200px: ", "smartaddons" ),
				"param_name" => "columns",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns >1200px:", "smartaddons" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 992px to 1199px:", "smartaddons" ),
				"param_name" => "columns1",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 992px to 1199px:", "smartaddons" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 768px to 991px:", "smartaddons" ),
				"param_name" => "columns2",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 768px to 991px:", "smartaddons" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 480px to 767px:", "smartaddons" ),
				"param_name" => "columns3",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 480px to 767px:", "smartaddons" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns in 480px or less than:", "smartaddons" ),
				"param_name" => "columns4",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns in 480px or less than:", "smartaddons" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Speed", "smartaddons" ),
				"param_name" => "speed",
				"value" => 1000,
				"description" => __( "Speed Of Slide", "smartaddons" )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Auto Play", "smartaddons" ),
				"param_name" => "autoplay",
				"value" => array( 'True' => 'true', 'False' => 'false' ),
				"description" => __( "Auto Play", "smartaddons" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Interval", "smartaddons" ),
				"param_name" => "interval",
				"value" => 5000,
				"description" => __( "Interval", "smartaddons" )
			 ),
			  array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Layout", "smartaddons" ),
				"param_name" => "layout",
				"value" => array( 'Layout Default' => '1', 'Layout 1' => 'layout1' ),
				"description" => __( "Layout", "smartaddons" )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Total Items Slider", "smartaddons" ),
				"param_name" => "scroll",
				"value" => 1,
				"description" => __( "Total Items Slider", "smartaddons" )
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function OT_Shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title' => '',
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
				'autoplay' => 'false',
				'interval' => 5000,
				'layout'  => 1,
				'scroll' => 1
			), $atts )
		);
		ob_start();		
		if( $layout == 1 ){
			include( 'includes/default.php' );
		}else{
			include( 'includes/team-style1.php' );
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
		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		
		extract($instance);

		if ( !array_key_exists('widget_template', $instance) ){
			$instance['widget_template'] = 'default';
		}
		
		if( $instance['widget_template'] == 'default' ){
			include( 'includes/default.php' );
		}else{
			include( 'includes/team-style1.php' );
		}
				
		/* After widget (defined by themes). */
		echo $after_widget;
	}    
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// strip tag on text field
		$instance['title'] = strip_tags( $new_instance['title'] );
		
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
		if ( array_key_exists('scroll', $new_instance) ){
			$instance['scroll'] = intval( $new_instance['scroll'] );
		}
		if ( array_key_exists('effect', $new_instance) ){
			$instance['effect'] = strip_tags( $new_instance['effect'] );
		}
		if ( array_key_exists('autoplay', $new_instance) ){
			$instance['autoplay'] = strip_tags( $new_instance['autoplay'] );
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
		$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
		$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
		$number     = isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
        $length     = isset( $instance['length'] )      ? intval($instance['length']) : 25;
		$columns     = isset( $instance['columns'] )      ? intval($instance['columns']) : '';
		$columns1     = isset( $instance['columns1'] )      ? intval($instance['columns1']) : '';
		$columns2     = isset( $instance['columns2'] )      ? intval($instance['columns2']) : '';
		$columns3     = isset( $instance['columns3'] )      ? intval($instance['columns3']) : '';
		$columns4     = isset( $instance['columns'] )      ? intval($instance['columns4']) : '';
		$interval     = isset( $instance['interval'] )      ? intval($instance['interval']) : 5000;
		$autoplay     = isset( $instance['autoplay'] )      ? strip_tags($instance['autoplay']) : 'true';
		$speed     = isset( $instance['speed'] )      ? intval($instance['speed']) : 1000;
		$scroll     = isset( $instance['scroll'] )      ? intval($instance['scroll']) : 1;
		$effect     = isset( $instance['effect'] )      ? strip_tags($instance['effect']) : 'slide';
		$hover     = isset( $instance['hover'] )      ? strip_tags($instance['hover']) : '';
		$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
                   
                 
		?>
        </p> 
          <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'smartaddons')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
				type="text"	value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'smartaddons')?></label>
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
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'smartaddons')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
				<?php } ?>>
					<?php _e('Descending', 'smartaddons')?>
				</option>
				<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
					<?php _e('Ascending', 'smartaddons')?>
				</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'smartaddons')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
				type="text"	value="<?php echo esc_attr($number); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'smartaddons')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
				value="<?php echo esc_attr($length); ?>" />
		</p>  
		<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' =>  7, '8' => 8); ?>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'smartaddons')?></label>
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
			<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', 'smartaddons')?></label>
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
			<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', 'smartaddons')?></label>
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
			<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'smartaddons')?></label>
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
			<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', 'smartaddons')?></label>
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
			<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'smartaddons')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
				type="text"	value="<?php echo esc_attr($interval); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'smartaddons')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
				type="text"	value="<?php echo esc_attr($speed); ?>" />
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'smartaddons')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
				type="text"	value="<?php echo esc_attr($scroll); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'smartaddons')?></label>
			<br/>
			
			<select class="widefat"
				id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
				<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
				<?php } ?>>
					<?php _e('Default', 'smartaddons')?>
				</option>
				<option value="theme1" <?php if ($widget_template=='theme1'){?> selected="selected"
				<?php } ?>>
					<?php _e('Theme 1', 'smartaddons')?>
				</option>				
			</select>
		</p>               
	<?php
	}	
}
?>