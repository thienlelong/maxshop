<?php

/**
 * Add Theme Options page.
 */
function ya_theme_admin_page(){
	add_theme_page(
		__('Theme Options', 'maxshop'),
		__('Theme Options', 'maxshop'),
		'manage_options',
		'ya_theme_options',
		'ya_theme_admin_page_content'
	);
}
add_action('admin_menu', 'ya_theme_admin_page', 49);

function ya_theme_admin_page_content(){ ?>
	<div class="wrap">
		<h2><?php _e( 'YA Advanced Options Page', 'maxshop' ); ?></h2>
		<?php do_action( 'ya_theme_admin_content' ); ?>
	</div>
<?php
}