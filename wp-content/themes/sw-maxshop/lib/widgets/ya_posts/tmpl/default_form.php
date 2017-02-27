<?php
$categoryid = isset( $instance['category'] )    ? $instance['category'] : 0;
$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
$number     = isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
$include     = isset( $instance['include'] ) ? strip_tags($instance['include']) : 0;
$exclude     = isset( $instance['exclude'] ) ? strip_tags($instance['exclude']) : 0;
$length     = isset( $instance['length'] )      ? intval($instance['length']) : 25;

?>

<p>
	<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category Name', 'maxshop')?></label>
	<br />
	<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
</p>

<p>
	<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Orderby', 'maxshop')?></label>
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
	<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order', 'maxshop')?></label>
	<br />
	<select class="widefat"
		id="<?php echo $this->get_field_id('order'); ?>"
		name="<?php echo $this->get_field_name('order'); ?>">
		<option value="DESC" <?php if ($order=='DESC'){?> selected="selected"
		<?php } ?>>
			<?php _e('Descending', 'maxshop')?>
		</option>
		<option value="ASC" <?php if ($order=='ASC'){?> selected="selected"
		<?php } ?>>
			<?php _e('Ascending', 'maxshop')?>
		</option>
	</select>
</p>

<p>
	<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('numberposts'); ?>"
		name="<?php echo $this->get_field_name('numberposts'); ?>" type="text"
		value="<?php echo esc_attr($number); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('include'); ?>"><?php _e('Include Posts ID', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('include'); ?>"
		name="<?php echo $this->get_field_name('include'); ?>" type="text"
		value="<?php echo esc_attr($include); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Exclude Posts ID', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('exclude'); ?>"
		name="<?php echo $this->get_field_name('exclude'); ?>" type="text"
		value="<?php echo esc_attr($exclude); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('length'); ?>"
		name="<?php echo $this->get_field_name('length'); ?>" type="text"
		value="<?php echo esc_attr($length); ?>" />
</p>
