<?php if (!have_posts()) : ?>
	<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p><?php _e('Sorry, no results were found.', 'maxshop'); ?></p>
	</div>
	<div class="no-result">
		<?php get_search_form(); ?>
	</div>
<?php endif; ?>