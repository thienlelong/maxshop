<?php
global $woocommerce;
$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
$length    		= isset( $instance['length'] ) ? intval($instance['length']) : 25;
?>
<p>
	<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('numberposts'); ?>"name="<?php echo $this->get_field_name('numberposts'); ?>" type="text"
		value="<?php echo esc_attr($number); ?>" />
</p>
