
<?php do_action( 'before' ); ?>
<?php if ( class_exists( 'WooCommerce' ) ) { ?>
<?php global $woocommerce; ?>
<div class="top-login pull-right">
	<?php if ( ! is_user_logged_in() ) {  ?>
	<ul>
		<li>
		<?php echo ' <a href="javascript:void(0);" data-toggle="modal" data-target="#login_form"><span>'.__('Login', 'maxshop').'</span></a> '; ?>
		</li>
	</ul>
	<?php } else{?>
		<div class="div-logined">
			<?php 
				$user_id = get_current_user_id();
				$user_info = get_userdata( $user_id );	
			?>
			<a href="<?php echo wp_logout_url( home_url() ); ?>" title="<?php esc_attr_e( 'Logout', 'maxshop' ) ?>" class="logout"><?php _e('Logout', 'maxshop'); ?></a>
		</div>
	<?php } ?>
</div>
<?php } ?>
