<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce; ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>

<div class="register-form">

	<form action="<?php echo get_permalink( woocommerce_get_page_id( 'myaccount' ) ); ?>" method="post" class="register">
		<?php do_action( 'woocommerce_register_form_start' ); ?>

		<?php if ( get_option( 'woocommerce_registration_email_for_username' ) == 'no' ) : ?>

			<div class="input-group">
<!--				<span class="input-group-addon"><img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/icon-user.png" alt="user"/></span>-->
				<input type="text" class="form-control input-text" placeholder="User name" name="username" id="reg_username" value="<?php if (isset($_POST['username'])) echo esc_attr($_POST['username']); ?>" />
			</div>
		<?php else : ?>
			

		<?php endif; ?>
		<div class="input-group">
            <span class="input-group-addon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-user.png" alt="user"/></span>
			<input type="email" class="form-control input-text" placeholder="Email" name="email" id="reg_email" value="<?php if (isset($_POST['email'])) echo esc_attr($_POST['email']); ?>" />
		</div>
		<div class="clear"></div>
		<div class="input-group">
			<span class="input-group-addon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-key.png" alt="password"/></span>
			<input type="password" class="form-control input-text" placeholder="Password" name="password" id="reg_password" value="<?php if (isset($_POST['password'])) echo esc_attr($_POST['password']); ?>" />
		</div>
		<div class="input-group">
			<span class="input-group-addon"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-key.png" alt="password"/></span>
			<input type="password" class="form-control input-text" placeholder="Retype Password" name="password2" id="reg_password2" value="<?php if (isset($_POST['password2'])) echo esc_attr($_POST['password2']); ?>" />
		</div>
		<div class="clear"></div>

		<!-- Spam Trap -->
		<div style="left:-999em; position:absolute;"><label for="trap">Anti-spam</label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

		<?php do_action( 'register_form' ); ?>

		<p class="form-row">
			<?php wp_nonce_field( 'woocommerce-register' ); ?>
			<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'maxshop' ); ?>" />
		</p>
		<?php do_action( 'woocommerce_register_form_end' ); ?>
	</form>

</div>

<?php endif; ?>
<?php do_action('woocommerce_after_customer_login_form'); ?>