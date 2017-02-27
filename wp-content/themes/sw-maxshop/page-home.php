<?php 
/*
Template Name: Page Home
*/
?>

<?php get_template_part('header'); ?>
	<div class="container">
		<div class="row">
			 <div id="contents" class="col-lg-12 col-md-12 col-sm-12">
				<?php
				get_template_part('templates/content', 'page')
				?>
			</div>
		</div>
		
	</div>
</div>
<?php get_template_part('footer'); ?>

