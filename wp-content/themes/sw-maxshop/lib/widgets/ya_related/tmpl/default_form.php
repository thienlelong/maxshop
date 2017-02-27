<?php
$showposts    		= isset( $instance['showposts'] ) ? intval($instance['showposts']) : 5;
$length    		= isset( $instance['length'] ) ? intval($instance['length']) : 25;
?>

<p>
	<label for="<?php echo $this->get_field_id('showposts'); ?>"><?php _e('Number of Posts', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('showposts'); ?>"name="<?php echo $this->get_field_name('showposts'); ?>" type="text"
		value="<?php echo esc_attr($showposts); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Length of excerpt', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('length'); ?>"name="<?php echo $this->get_field_name('length'); ?>" type="text"
		value="<?php echo esc_attr($length); ?>" />
</p>
