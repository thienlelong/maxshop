<?php 
	do_action( 'before' ); 
?>
<?php if ( (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) ) { ?>
<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
<?php } ?>