<div class="siberlef_category">	
	<ul class="list-unstyled">
	<?php
		foreach( $categories as $cat )
		{
			$term = get_term($cat, 'product_cat');
			
			
	?>
		<li>
			<a href="<?php echo get_term_link( $cat, 'product_cat' ); ?>">
				<?php echo esc_html($term->name); ?>
			</a>
		</li>
	<?php } ?>	
	</ul>
</div>