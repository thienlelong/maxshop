<?php
/**
 * Currency Converter Widget
 *
 * @package		WooCommerce
 * @category	Widgets
 * @author		WooThemes
 */
class WooCommerce_Widget_Currency_Converter extends WP_Widget {

	/** Variables to setup the widget. */
	var $woo_widget_cssclass;
	var $woo_widget_description;
	var $woo_widget_idbase;
	var $woo_widget_name;

	/** constructor */
	function WooCommerce_Widget_Currency_Converter() {

		/* Widget variable settings. */
		$this->woo_widget_cssclass = 'widget_currency_converter';
		$this->woo_widget_description = __( 'Allow users to choose a currency for prices to be displayed in.', 'maxshop' );
		$this->woo_widget_idbase = 'woocommerce_currency_converter';
		$this->woo_widget_name = __('WooCommerce Currency Converter', 'maxshop' );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->woo_widget_cssclass, 'description' => $this->woo_widget_description );

		/* Create the widget. */
		parent::__construct($this->woo_widget_idbase, $this->woo_widget_name, $widget_ops);
	}

	/** @see WP_Widget */
	function widget( $args, $instance ) {
		extract($args);

		$title   = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		$show_reset   = $instance['show_reset'];

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title;

		?>
		<form method="post" class="currency_converter" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			
			<ul class="currency_w">
				
				<?php					

					$currencies = array_map( 'trim', array_filter( explode( "\n", $instance['currency_codes'] ) ) );

					if ( $currencies ) {
						echo '<li><a href="#" class="" >' . esc_attr($currencies[0]) . '</a>';
						echo '<ul class="currency_switcher">';
						$i = 0;
						foreach ( $currencies as  $currency  ) {
							
							$class    = '';

							if ( $currency == get_option( 'woocommerce_currency' ) ){
								$class = 'reset default';
							}
							echo '<li><a href="#" class="' . esc_attr( $class ) . '" data-currencycode="' . esc_attr( $currency ) . '">' . esc_attr( $currency ) . '</a></li>';
							$i++;
						}
						echo '</ul></li>';
						if ( $show_reset )
							echo '<li><a href="#" class="reset">' . __('Reset', 'maxshop') . '</a></li>';

						
						
					}
				?>
				
			</ul>
		</form>
		<?php

		echo $after_widget;
	}

	/** @see WP_Widget->update */
	function update( $new_instance, $old_instance ) {
		$instance['title']          = empty( $new_instance['title'] ) ? '' : strip_tags(stripslashes($new_instance['title']));
		$instance['currency_codes'] = empty( $new_instance['currency_codes'] ) ? '' : strip_tags(stripslashes($new_instance['currency_codes']));
		$instance['show_reset']     = empty( $new_instance['show_reset'] ) ? '' : strip_tags(stripslashes($new_instance['show_reset']));
		return $instance;
	}

	/** @see WP_Widget->form */
	function form( $instance ) {
		global $wpdb;
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'maxshop') ?></label>
		<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} else {echo __('Currency converter', 'maxshop');} ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('currency_codes'); ?>"><?php _e('Currency codes:', 'maxshop') ?> <small>(<?php _e('1 per line', 'maxshop') ?>)</small></label>
		<textarea class="widefat" rows="5" cols="20" name="<?php echo $this->get_field_name('currency_codes'); ?>" id="<?php echo $this->get_field_id('currency_codes'); ?>"><?php if ( ! empty( $instance['currency_codes'] ) ) echo esc_attr( $instance['currency_codes'] ); else echo "USD\nEUR"; ?></textarea>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('show_reset'); ?>"><?php _e('Show reset link:', 'maxshop') ?></label>
		<input type="checkbox" class="" id="<?php echo esc_attr( $this->get_field_id('show_reset') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_reset') ); ?>" value="1" <?php if (isset($instance['show_reset'])) checked($instance['show_reset'], 1); ?> /></p>
		<?php
	}
}