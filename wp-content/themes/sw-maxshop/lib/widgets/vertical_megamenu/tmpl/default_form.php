<?php

$menu_locate      = isset( $instance['menu_locate'] )       ? strip_tags($instance['menu_locate']) : '';
$menu_locations = wp_get_nav_menus();	
?>

<p>
	<label for="<?php echo $this->get_field_id('menu_locate'); ?>"><?php _e('Menu Name', 'maxshop')?></label>
	<br />
	<select class="widefat"
		id="<?php echo $this->get_field_id('menu_locate'); ?>"
		name="<?php echo $this->get_field_name('menu_locate'); ?>">
		<option value=""><?php _e( 'Select Menu Name', 'maxshop' ); ?></option>
		<?php foreach( $menu_locations as $menu_location ){?>
			<option value="<?php echo $menu_location -> name; ?>" <?php if ( $menu_locate == ( $menu_location -> name ) ){?> selected="selected"
			<?php } ?>>
				<?php echo $menu_location -> name; ?>
			</option>
		<?php } ?>
	</select>
</p>