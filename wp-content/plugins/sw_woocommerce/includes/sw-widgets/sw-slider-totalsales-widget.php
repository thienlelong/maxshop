<?php
/**
 * SW Woocommerce Total Sales Slider
 * Plugin URI: http://flytheme.com
 * This Widget help you to show top total sales on period of time.
 */
if ( !class_exists('sw_woott_slider_widget') ) {
	class sw_woott_slider_widget extends WP_Widget {
		/**
		 * Widget setup.
		 */
		function __construct(){
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'sw_woott_slider_content', 'description' => __('SW Woocommerce Total Sales', 'sw_woocommerce') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_woott_slider_content' );

			/* Create the widget. */
			parent::__construct( 'sw_woott_slider_content', __('SW Woocommerce Total Sales widget', 'sw_woocommerce'), $widget_ops, $control_ops );
					
			/* Add shortcode */
			add_shortcode( 'total_sale', array( $this, 'CD_Shortcode' ) );
			
			/* Create Vc_map */
			if (class_exists('Vc_Manager')) {
				add_shortcode_param( 'date', array( $this, 'ya_date_vc_setting' ) );
				add_action( 'vc_before_init', array( $this, 'CD_integrateWithVC' ) );
			}
			
		}
		/**
		*
		**/
		function GetTopSalesProducts( $from_date = '', $to_date = '', $numberposts ){
			global $wpdb;
			print '<pre>'; var_dump( $wpdb ); print '</pre>';
			$query            = array();
			$query['fields']  = "select SUM( order_item_meta.meta_value ) as qty, order_item_meta_2.meta_value as product_id
				FROM {$wpdb->posts} as posts";
			$query['join']    = "INNER JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON posts.ID = order_id ";
			$query['join']   .= "INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id ";
			$query['join']   .= "INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS order_item_meta_2 ON order_items.order_item_id = order_item_meta_2.order_item_id ";
			$query['where']   = "WHERE posts.post_type IN ( '" . implode( "','", wc_get_order_types( 'order-count' ) ) . "' ) ";
			$query['where']  .= "AND posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ) ) . "' ) ";
			$query['where']  .= "AND order_item_meta.meta_key = '_qty' ";
			$query['where']  .= "AND order_item_meta_2.meta_key = '_product_id' ";
			if( $from_date != '' ){
				$query['where']  .= "AND posts.post_date >= '" . date( 'Y-m-d', strtotime( $from_date ) ) . "' ";
			}
			if( $to_date != '' ){
				$query['where']  .= "AND posts.post_date <= '" . date( 'Y-m-d', strtotime( $to_date ) ) . "' ";
			}
			$query['groupby'] = "GROUP BY product_id";
			$query['orderby'] = "ORDER BY qty DESC";
			$query['limits']  = "LIMIT $numberposts";
			$top_seller = $wpdb->get_results( implode( ' ', apply_filters( 'woocommerce_dashboard_status_widget_top_seller_query', $query ) ) );
			/* 	add_filter(  'posts_where', 'ya_filter_where' );
			function ya_filter_where( $where ) {
				$where .= " AND post_date >= '2015-07-29' AND post_date <= '2015-08-01'";
				return $where;
			}
			$query = new wp_query( array( 'post_type' => 'shop_order', 'post_status' => 'wc-on-hold' ) );
			print '<pre>';var_dump( $top_seller ); print '</pre>';
			remove_filter( 'posts_where', 'ya_filter_where' ); */
			return $top_seller;
		}
		/**
		* Add Vc Params
		**/
		function ya_date_vc_setting( $settings, $value ) {
		   return '<div class="vc_date_block">'
					 .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
					 esc_attr( $settings['param_name'] ) . ' ' .
					 esc_attr( $settings['type'] ) . '_field" type="date" value="' . esc_attr( $value ) . '" placeholder="dd-mm-yyyy"/>' .
					'</div>'; 
		}
		function CD_integrateWithVC(){	
			$terms = get_terms( 'product_cat', array( 'parent' => '', 'hide_emty' => false ) );
			if( count( $terms ) == 0 ){
				return ;
			}
			$term = array( __( 'All Categories', 'sw_woocommerce' ) => '' );
			foreach( $terms as $cat ){
				$term[$cat->name] = $cat -> slug;
			}
			vc_map( array(
			  "name" => __( "SW Woocommerce Total Sales Slider", 'sw_woocommerce' ),
			  "base" => "total_sale",
			  "icon" => "icon-wpb-ytc",
			  "class" => "",
			  "category" => __( "SW Shortcodes", 'sw_woocommerce'),
			  "params" => array(
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Title", 'sw_woocommerce' ),
					"param_name" => "title1",
					"value" => '',
					"description" => __( "Title", 'sw_woocommerce' )
				 ),	
					array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Category", 'sw_woocommerce' ),
					"param_name" => "category",
					"value" => $term,
					"description" => __( "Select Categories", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number Of Product", 'sw_woocommerce' ),
					"param_name" => "numberposts",
					"value" => 5,
					"description" => __( "Number Of Product", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "date",
					"holder" => "div",
					"class" => "",
					"heading" => __( "From Date", 'sw_woocommerce' ),
					"param_name" => "from_date",
					"value" => '',
					"description" => __( "From Date", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "date",
					"holder" => "div",
					"class" => "",
					"heading" => __( "To Date", 'sw_woocommerce' ),
					"param_name" => "to_date",
					"value" => '',
					"description" => __( "To Date", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns >1200px: ", 'sw_woocommerce' ),
					"param_name" => "columns",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns >1200px:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' ),
					"param_name" => "columns1",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' ),
					"param_name" => "columns2",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' ),
					"param_name" => "columns3",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' ),
					"param_name" => "columns4",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Speed", 'sw_woocommerce' ),
					"param_name" => "speed",
					"value" => 1000,
					"description" => __( "Speed Of Slide", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Auto Play", 'sw_woocommerce' ),
					"param_name" => "autoplay",
					"value" => array( 'False' => 'false', 'True' => 'true' ),
					"description" => __( "Auto Play", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Interval", 'sw_woocommerce' ),
					"param_name" => "interval",
					"value" => 5000,
					"description" => __( "Interval", 'sw_woocommerce' )
				 ),
				  array(
					"type" => "dropdown",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Layout", 'sw_woocommerce' ),
					"param_name" => "layout",
					"value" => array( 'Layout Default' => 'default' ),
					"description" => __( "Layout", 'sw_woocommerce' )
				 ),
				 array(
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Total Items Slided", 'sw_woocommerce' ),
					"param_name" => "scroll",
					"value" => 1,
					"description" => __( "Total Items Slided", 'sw_woocommerce' )
				 ),
			  )
		   ) );
		}
		/**
			** Add Shortcode
		**/
		function CD_Shortcode( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1' 		=> '',
					'category'	=> '',
					'numberposts' 	=> 5,
					'from_date'		=> '',
					'to_date'		=> '',
					'columns' 		=> 4,
					'columns1' 		=> 4,
					'columns2' 		=> 3,
					'columns3' 		=> 2,
					'columns4' 		=> 1,
					'speed' 		=> 1000,
					'autoplay' 		=> 'false',
					'interval' 		=> 5000,
					'layout'  		=> 'default',
					'scroll' 		=> 1
				), $atts )
			);
			ob_start();			
			include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-total-sales-widget/default.php' );
			$content = ob_get_clean();
			
			return $content;
		}
		/**
			* Cut string
		**/
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
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$description1 = apply_filters( 'widget_description', empty( $instance['description1'] ) ? '' : $instance['description1'], $instance, $this->id_base );
			echo $before_widget;
			if ( !empty( $title ) && !empty( $description1 ) ) { echo $before_title . $title . $after_title . '<h5 class="category_description clearfix">' . $description1 . '</h5>'; }
			else if (!empty( $title ) && $description1==NULL ){ echo $before_title . $title . $after_title; }
			
			if ( !isset($instance['category']) ){
				$instance['category'] = array();
			}
			$id = $this -> number;
			extract($instance);

			if ( !array_key_exists('widget_template', $instance) ){
				$instance['widget_template'] = 'default';
			}
			if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
				_e('Please active woocommerce plugin or install woomcommerce plugin first', 'sw_woocommerce');
				return false;
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
			$dir = plugin_dir_path(dirname(__FILE__)).'/themes/sw-total-sales-widget';
			
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
			$instance['title1'] = strip_tags( $new_instance['title1'] );

			if ( array_key_exists('numberposts', $new_instance) ){
				$instance['numberposts'] = intval( $new_instance['numberposts'] );
			}
			if ( array_key_exists('from_date', $new_instance) ){
				$instance['from_date'] = strip_tags( $new_instance['from_date'] );
			}
			if ( array_key_exists('to_date', $new_instance) ){
				$instance['to_date'] = strip_tags( $new_instance['to_date'] );
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

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		public function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array();
			$instance = wp_parse_args( (array) $instance, $defaults ); 		
					 
			$title1 			= isset( $instance['title1'] )    		? strip_tags($instance['title1']) : '';
			$number     		= isset( $instance['numberposts'] ) 	? intval($instance['numberposts']) : 5;
			$from_date     		= isset( $instance['from_date'] ) 		? strip_tags($instance['from_date']) : '';
			$to_date     		= isset( $instance['to_date'] ) 		? strip_tags($instance['to_date']) : '';
			$length     		= isset( $instance['length'] )      	? intval($instance['length']) : 25;
			$item_row     		= isset( $instance['item_row'] )      	? intval($instance['item_row']) : 1;
			$columns     		= isset( $instance['columns'] )      	? intval($instance['columns']) : 1;
			$columns1     		= isset( $instance['columns1'] )      	? intval($instance['columns1']) : 1;
			$columns2     		= isset( $instance['columns2'] )      	? intval($instance['columns2']) : 1;
			$columns3     		= isset( $instance['columns3'] )      	? intval($instance['columns3']) : 1;
			$columns4     		= isset( $instance['columns'] )      	? intval($instance['columns4']) : 1;
			$autoplay     		= isset( $instance['autoplay'] )      	? strip_tags($instance['autoplay']) : 'true';
			$interval     		= isset( $instance['interval'] )      	? intval($instance['interval']) : 5000;
			$speed     			= isset( $instance['speed'] )      		? intval($instance['speed']) : 1000;
			$scroll     		= isset( $instance['scroll'] )      	? intval($instance['scroll']) : 1;
			$widget_template   	= isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
					   
					 
			?>		
			</p> 
			  <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
					type="text"	value="<?php echo esc_attr($title1); ?>" />
			</p>					

			<p>
				<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
					type="text"	value="<?php echo esc_attr($number); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('from_date'); ?>"><?php _e('From Date( dd-mm-yyyy )', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('from_date'); ?>" name="<?php echo $this->get_field_name('from_date'); ?>"
					type="text"	value="<?php echo esc_attr($from_date); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('to_date'); ?>"><?php _e('To Date( dd-mm-yyyy )', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('to_date'); ?>" name="<?php echo $this->get_field_name('to_date'); ?>"
					type="text"	value="<?php echo esc_attr($to_date); ?>" />
			</p>
			
			<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6); ?>
			<p>
				<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', 'sw_woocommerce')?></label>
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
				<label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php _e('Auto Play', 'sw_woocommerce')?></label>
				<br />
				<select class="widefat"
					id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>">
					<option value="false" <?php if ($autoplay=='false'){?> selected="selected"
					<?php } ?>>
						<?php _e('False', 'sw_woocommerce')?>
					</option>
					<option value="true" <?php if ($autoplay=='true'){?> selected="selected"	<?php } ?>>
						<?php _e('True', 'sw_woocommerce')?>
					</option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('interval'); ?>"><?php _e('Interval', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>"
					type="text"	value="<?php echo esc_attr($interval); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('speed'); ?>"><?php _e('Speed', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>"
					type="text"	value="<?php echo esc_attr($speed); ?>" />
			</p>
			
			
			<p>
				<label for="<?php echo $this->get_field_id('scroll'); ?>"><?php _e('Total Items Slided', 'sw_woocommerce')?></label>
				<br />
				<input class="widefat" id="<?php echo $this->get_field_id('scroll'); ?>" name="<?php echo $this->get_field_name('scroll'); ?>"
					type="text"	value="<?php echo esc_attr($scroll); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'sw_woocommerce')?></label>
				<br/>
				
				<select class="widefat"
					id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
					<option value="default" <?php if ($widget_template=='default'){?> selected="selected"
					<?php } ?>>
						<?php _e('Default', 'sw_woocommerce')?>
					</option>	
				</select>
			</p>  
		<?php
		}	
	}
}
?>