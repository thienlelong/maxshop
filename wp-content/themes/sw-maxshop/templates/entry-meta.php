<div class="meta-inner">
	<?php $category = get_the_category();?>
	<ul>
		<li class="single-author"><?php _e('Author', 'maxshop'); ?>: <?php the_author_posts_link(); ?></li>
		<li class="single-publish"><?php _e('Published', 'maxshop'); ?>: <?php echo date( 'd F Y',strtotime($post->post_date)); ?></li> 
		<li class="single-category"><?php _e('Category', 'maxshop'); ?>: <?php foreach($category as $cat){ echo '<a href="'.get_category_link( $cat->term_id ).'">'.esc_html($cat->name).'</a>'; }?></li>
	</ul>
</div>