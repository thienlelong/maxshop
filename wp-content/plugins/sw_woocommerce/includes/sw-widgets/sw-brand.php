<?php
/**
 * Name: SW Brand
 * Description: A widget that serves as an slider for developing more advanced widgets.
 */
 
class sw_brand_slider_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct(){
		/* Add Taxonomy and Post type */
		add_action( 'init', array( $this, 'brand_register' ), 5 );
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'sw_brand', 'description' => __('Sw Brand', 'sw_woocommerce') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'sw_brand' );

		/* Create the widget. */
		parent::__construct( 'sw_brand', __('Sw brand widget', 'sw_woocommerce'), $widget_ops, $control_ops );
		
		/* Create Shortcode */
		add_shortcode( 'sw_brand', array( $this, 'PB_Shortcode' ) );
		
		/* Create Vc_map */
		if (class_exists('Vc_Manager')) {
			add_action( 'vc_before_init', array( $this, 'PB_integrateWithVC' ), 10 );
		}
		
		/* Add Custom field to category product */
		add_action( 'product_brand_add_form_fields', array( $this, 'add_category_fields' ), 100 );
		add_action( 'product_brand_edit_form_fields', array( $this, 'edit_category_fields' ), 100 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
		
		// Add columns
		add_filter( 'manage_edit-product_brand_columns', array( $this, 'product_brand_columns' ) );
		add_filter( 'manage_product_brand_custom_column', array( $this, 'product_brand_column' ), 10, 3 );
	}
	function brand_register() {

		register_taxonomy( 'product_brand', array( 'product' ), array( 'hierarchical' => true, 'label' =>  __( ' Brand Categories', 'sw_woocommerce' ), 'singular_label' => __( 'Brand Category', 'sw_woocommerce' ), 'rewrite' => true ) );
	}
	/**
	* Add Vc Params
	**/
	function PB_integrateWithVC(){
		$terms = get_terms( 'product_brand', array( 'parent' => '', 'hide_empty' => 0 ) );
		$term = array( __( 'All Categories', 'sw_woocommerce' ) => '' );
		if( count( $terms ) > 0 ){			
			foreach( $terms as $cat ){
				$term[$cat->name] = $cat -> slug;
			}
		}
		vc_map( array(
		  "name" => __( "Sw Brand", 'sw_woocommerce' ),
		  "base" => "sw_brand",
		  "icon" => "icon-wpb-ytc",
		  "class" => "",
		  "category" => __( "SW Shortcodes", 'sw_woocommerce' ),
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
					"type" => "checkbox",
					"holder" => "div",
					"class" => "",
					"heading" => __( "Category", 'sw_woocommerce' ),
					"param_name" => "category",
					"value" => $term,
					"description" => __( "Select Categories", 'sw_woocommerce' )
				 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Order By", 'sw_woocommerce' ),
				"param_name" => "orderby",
				"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
				"description" => __( "Order By", 'sw_woocommerce' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Order", 'sw_woocommerce' ),
				"param_name" => "order",
				"value" => array('Descending' => 'DESC', 'Ascending' => 'ASC'),
				"description" => __( "Order", 'sw_woocommerce' )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number Of Post", 'sw_woocommerce' ),
				"param_name" => "numberposts",
				"value" => 5,
				"description" => __( "Number Of Post", 'sw_woocommerce' )
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number row per column", 'sw_woocommerce' ),
				"param_name" => "item_row",
				"value" =>array(1,2,3),
				"description" => __( "Number row per column", 'sw_woocommerce' ),
				'dependency' => array(
					'element' => 'layout',
					'value' => 'default' 
				),
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns >1200px: ", 'sw_woocommerce' ),
				"param_name" => "columns",
				"value" => array(1,2,3,4,5,6,7,8,9,10),
				"description" => __( "Number of Columns >1200px:", 'sw_woocommerce' ),
				'dependency' => array(
					'element' => 'layout',
					'value' => 'default' 
				),
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' ),
				"param_name" => "columns1",
				"value" => array(1,2,3,4,5,6,7,8),
				"description" => __( "Number of Columns on 992px to 1199px:", 'sw_woocommerce' ),
				'dependency' => array(
					'element' => 'layout',
					'value' => 'default' 
				),
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' ),
				"param_name" => "columns2",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 768px to 991px:", 'sw_woocommerce' ),
				'dependency' => array(
					'element' => 'layout',
					'value' => 'default' 
				),
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' ),
				"param_name" => "columns3",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 480px to 767px:", 'sw_woocommerce' ),
				'dependency' => array(
					'element' => 'layout',
					'value' => 'default' 
				),
			 ),
			 array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' ),
				"param_name" => "columns4",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns in 480px or less than:", 'sw_woocommerce' ),
				'dependency' => array(
					'element' => 'layout',
					'value' => 'default' 
				),
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
				"value" => array( 'True' => 'true', 'False' => 'false' ),
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
				"value" => array( 'Layout Default' => 'default', 'Layout1' => 'layout1' ),
				"description" => __( "Layout", 'sw_woocommerce' )
			 ),
			 array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __( "Total Items Slided", 'sw_woocommerce' ),
				"param_name" => "scroll",
				"value" => 1,
				"description" => __( "Total Items Slided", 'sw_woocommerce' ),
				'dependency' => array(
					'element' => 'layout',
					'value' => 'default' 
				),
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function PB_Shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',
				'category' => '',
				'orderby' => 'name',
				'order'	=> 'DESC',
				'numberposts' => 5,
				'length' => 25,
				'item_row'=> 1,
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,
				'speed' => 1000,
				'autoplay' => 'true',
				'interval' => 5000,
				'scroll' => 1,			
				'layout'  => 'default'
			), $atts )
		);
		ob_start();		
		if( $layout == 'default' ){
			include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-brands/default.php' );
		}elseif( $layout == 'layout1' ){
			include( plugin_dir_path(dirname(__FILE__)).'/themes/sw-brands/layout1.php' );			
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
		*	Add Custom field on category product
		**/
		public function add_category_fields() { 
	?>
			<div class="form-field">
				<label><?php _e( 'Thumbnail', 'sw_woocommerce' ); ?></label>
				<div id="product_brand_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_brand_thumbnail_id" name="product_brand_thumbnail_id" />
					<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'sw_woocommerce' ); ?></button>
					<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'sw_woocommerce' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( ! jQuery( '#product_brand_thumbnail_id' ).val() ) {
						jQuery( '.remove_image_button' ).hide();
					}

					// Uploading files
					var file_frame;

					jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( "Choose an image", 'sw_woocommerce' ); ?>',
							button: {
								text: '<?php _e( "Use image", 'sw_woocommerce' ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							var attachment = file_frame.state().get( 'selection' ).first().toJSON();
							
							jQuery( '#product_brand_thumbnail_id' ).val( attachment.id );
							jQuery( '#product_brand_thumbnail > img' ).attr( 'src', attachment.sizes.thumbnail.url );
							jQuery( '.remove_image_button' ).show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery( document ).on( 'click', '.remove_image_button', function() {
						jQuery( '#product_brand_thumbnail img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
						jQuery( '#product_brand_thumbnail_id' ).val( '' );
						jQuery( '.remove_image_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</div>
			<?php
		}
		
		public function edit_category_fields( $term ) {

			$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_bid', true ) );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = wc_placeholder_img_src();
			}
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label><?php _e( 'Thumbnail', 'sw_woocommerce' ); ?></label></th>
				<td>
					<div id="product_brand_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
					<div style="line-height: 60px;">
						<input type="hidden" id="product_brand_thumbnail_id" name="product_brand_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
						<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'sw_woocommerce' ); ?></button>
						<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'sw_woocommerce' ); ?></button>
					</div>
					<script type="text/javascript">

						// Only show the "remove image" button when needed
						if ( '0' === jQuery( '#product_brand_thumbnail_id' ).val() ) {
							jQuery( '.remove_image_button' ).hide();
						}

						// Uploading files
						var file_frame;

						jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

							event.preventDefault();

							// If the media frame already exists, reopen it.
							if ( file_frame ) {
								file_frame.open();
								return;
							}

							// Create the media frame.
							file_frame = wp.media.frames.downloadable_file = wp.media({
								title: '<?php _e( "Choose an image", 'sw_woocommerce' ); ?>',
								button: {
									text: '<?php _e( "Use image", 'sw_woocommerce' ); ?>'
								},
								multiple: false
							});

							// When an image is selected, run a callback.
							file_frame.on( 'select', function() {
								var attachment = file_frame.state().get( 'selection' ).first().toJSON();

								jQuery( '#product_brand_thumbnail_id' ).val( attachment.id );
								jQuery( '#product_brand_thumbnail img' ).attr( 'src', attachment.sizes.thumbnail.url );
								jQuery( '.remove_image_button' ).show();
							});

							// Finally, open the modal.
							file_frame.open();
						});

						jQuery( document ).on( 'click', '.remove_image_button', function() {
							jQuery( '#product_brand_thumbnail img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
							jQuery( '#product_brand_thumbnail_id' ).val( '' );
							jQuery( '.remove_image_button' ).hide();
							return false;
						});

					</script>
					<div class="clear"></div>
				</td>
			</tr>
			<?php
		}
		public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
			if ( isset( $_POST['product_brand_thumbnail_id'] ) && 'product_brand' === $taxonomy ) {
				update_woocommerce_term_meta( $term_id, 'thumbnail_bid', absint( $_POST['product_brand_thumbnail_id'] ) );
			}
		}
	
	/**
	 * Thumbnail column added to category admin.
	 *
	 * @param mixed $columns
	 * @return array
	 */
	public function product_brand_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = __( 'Image', 'sw_woocommerce' );

		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Thumbnail column value added to category admin.
	 *
	 * @param string $columns
	 * @param string $column
	 * @param int $id
	 * @return array
	 */
	public function product_brand_column( $columns, $column, $id ) {

		if ( 'thumb' == $column ) {

			$thumbnail_id = get_woocommerce_term_meta( $id, 'thumbnail_bid', true );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = wc_placeholder_img_src();
			}

			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: http://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'sw_woocommerce' ) . '" class="wp-post-image" height="48" width="48" />';

		}

		return $columns;
	}
	
	/**
	 * Display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		
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
		$dir = plugin_dir_path( dirname(__FILE__) ).'/themes/sw-brands';
		
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

		// str or array
		if ( array_key_exists('category', $new_instance) ){
			if ( is_array($new_instance['category']) ){
				$instance['category'] = $new_instance['category'] ;
			} else {
				$instance['category'] = strip_tags( $new_instance['category'] );
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
		if ( array_key_exists('item_row', $new_instance) ){
			$instance['item_row'] = intval( $new_instance['item_row'] );
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

	function category_select( $field_name, $opts = array(), $field_value = null ){
		$default_options = array(
				'multiple' => true,
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
			if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
				unset($opts['allow_select_all']);
				$allow_select_all = '<option value="">All Categories</option>';
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
				$allow_select_all = '<option value="">All Categories</option>';
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
		
		$categories = get_terms( 'product_brand', array( 'hide_empty' => 0 ) );
		$all_category_ids = array();
		foreach ($categories as $cat) $all_category_ids[] = $cat->slug;
		$is_valid_field_value = in_array($field_value, $all_category_ids);
		if (!$is_valid_field_value && is_array($field_value)){
			$intersect_values = array_intersect($field_value, $all_category_ids);
			$is_valid_field_value = count($intersect_values) > 0;
		}
		if (!$is_valid_field_value){
			$field_value = '';
		}
	
		$select_html = '<select ' . $select_attributes . '>';
		if (isset($allow_select_all)) $select_html .= $allow_select_all;
		foreach ($categories as $cat){			
			$select_html .= '<option value="' . $cat->slug . '"';
			if ($cat->slug == $field_value || (is_array($field_value)&&in_array($cat->slug, $field_value))){ $select_html .= ' selected="selected"';}
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
		$defaults 		= array();
		$instance 		= wp_parse_args( (array) $instance, $defaults ); 		
		$title1    		= isset( $instance['title1'] )     	? strip_tags($instance['title1']) : '';      
		$categoryid 	= isset( $instance['category']  ) 	? $instance['category'] : null;
		$orderby    	= isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
		$order      	= isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
		$number     	= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
		$length    	 	= isset( $instance['length'] )      ? intval($instance['length']) : 25;
		$item_row     = isset( $instance['item_row'] )    ? intval($instance['item_row']) : 1;
		$columns     	= isset( $instance['columns'] )     ? intval($instance['columns']) : '';
		$columns1     = isset( $instance['columns1'] )    ? intval($instance['columns1']) : '';
		$columns2     = isset( $instance['columns2'] )    ? intval($instance['columns2']) : '';
		$columns3     = isset( $instance['columns3'] )    ? intval($instance['columns3']) : '';
		$columns4     = isset( $instance['columns'] )     ? intval($instance['columns4']) : '';
		$interval     = isset( $instance['interval'] )    ? intval($instance['interval']) : 5000;
		$autoplay     = isset( $instance['autoplay'] )    ? strip_tags($instance['autoplay']) : 'true';
		$speed     		= isset( $instance['speed'] )      	? intval($instance['speed']) : 1000;
		$scroll     	= isset( $instance['scroll'] )      ? intval($instance['scroll']) : 1;
		$effect     	= isset( $instance['effect'] )      ? strip_tags($instance['effect']) : 'slide';
		$hover     		= isset( $instance['hover'] )      	? strip_tags($instance['hover']) : '';
		$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';
                   
                 
		?>
        </p> 
          <div style="background: Blue; color: white; font-weight: bold; text-align:center; padding: 3px"> * Data Config * </div>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'sw_woocommerce')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
				type="text"	value="<?php echo esc_attr($title1); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category ID', 'sw_woocommerce')?></label>
			<br />
			<?php echo $this->category_select('category', array( 'allow_select_all' => true ), $categoryid); ?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'sw_woocommerce')?></label>
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
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'sw_woocommerce')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
				<?php } ?>>
					<?php _e('Descending', 'sw_woocommerce')?>
				</option>
				<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"	<?php } ?>>
					<?php _e('Ascending', 'sw_woocommerce')?>
				</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'sw_woocommerce')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
				type="text"	value="<?php echo esc_attr($number); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'sw_woocommerce')?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
				value="<?php echo esc_attr($length); ?>" />
		</p>
		<?php $row_number = array('1' => 1, '2' => 2, '3' => 3); ?>
		<p>
			<label for="<?php echo $this->get_field_id('item_row'); ?>"><?php _e('Number row per column:  ', 'sw_woocommerce')?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('item_row'); ?>"
				name="<?php echo $this->get_field_name('item_row'); ?>">
				<?php
				$option ='';
				foreach ($row_number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $item_row){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p>
		
		<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' =>  7, '8' => 8); ?>
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
				<option value="layout1" <?php if ($widget_template=='layout1'){?> selected="selected"
				<?php } ?>>
					<?php _e('Layout 1', 'sw_woocommerce')?>
				</option>				
			</select>
		</p>               
	<?php
	}	
}
?>