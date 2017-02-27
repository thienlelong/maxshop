<?php 
/*
Template Name: Page No Title
*/
?>

<?php get_template_part('header'); ?>
	<div class="container">
		<div class="row">
			 <div id="contents" role="main" class="col-lg-12 col-md-12 col-sm-12">
				<?php if(have_posts()):
					while (have_posts()) : the_post(); ?>
						<div <?php post_class(); ?>>							
							<div class="entry-content">
							  <?php the_content(); ?>
							  <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'maxshop' ), 'after' => '</div>' ) ); ?>
							</div>
							<?php comments_template('/templates/comments.php'); ?>
						</div>
						<?php
					endwhile;
				else:
					get_template_part('templates/no-results');
				endif;
			?>
			</div>
		</div>
		
	</div>
</div>
<?php get_template_part('footer'); ?>

