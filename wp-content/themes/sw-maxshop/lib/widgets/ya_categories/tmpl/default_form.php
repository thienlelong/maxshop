<?php
$categoriesid = isset( $instance['categories'] )    ? $instance['categories'] : array();
$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
$number     = isset( $instance['number'] ) ? intval($instance['number']) : 5;
$exclude    = isset( $instance['exclude'] ) ? strip_tags($instance['exclude']) : 0;

?>

<p>
	<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Categories Name', 'maxshop')?></label>
	<br />
	<?php echo $this->category_select('categories', array('allow_select_all' => true, 'multiple' => true), $categoriesid); ?>
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
	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Categories', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('number'); ?>"
		name="<?php echo $this->get_field_name('number'); ?>" type="text"
		value="<?php echo esc_attr($number); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('exclude'); ?>"><?php _e('Exclude', 'maxshop')?></label>
	<br />
	<input class="widefat"
		id="<?php echo $this->get_field_id('exclude'); ?>"
		name="<?php echo $this->get_field_name('exclude'); ?>" type="text"
		value="<?php echo esc_attr($exclude); ?>" />
</p>