<?php if (!have_posts()) : ?>
	<?php get_template_part('templates/no-results'); ?>
<?php endif; ?>
<div class="blog-full-list">
	<?php 
	while (have_posts()) : the_post(); 
	$post_format = get_post_format();
	?>
	<div id="post-<?php the_ID();?>" <?php post_class( 'theme-clearfix' ); ?>>
		<div class="entry">
			<?php if (get_the_post_thumbnail()){?>
			<div class="entry-thumb pull-left">
				<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">			
					<?php the_post_thumbnail("large")?>
				</a>
			</div>
			<?php }?>
			<div class="entry-content">
				<span class="entry-date">
					<?php echo ( get_the_title() ) ? date( 'l, F j, Y',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'l, F j, Y',strtotime($post->post_date)).'</a>'; ?>
				</span>
				<span class="entry-category">
					<?php the_category(', '); ?>
				</span>
				<div class="title-blog">
					<h3>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
					</h3>
				</div>
				<div class="entry-description">
					<?php 
					the_content('...');						
					?>
					<?php the_tags( '<div class="entry-meta-tag"><span class="fa fa-tag"></span>', ', ', '</div>' ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'maxshop' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
				</div>					
			</div>
		</div>
	</div>
<?php endwhile; ?>
</div>
<div class="clearfix"></div>
