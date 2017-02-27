<?php global $template;
$footer_style = ya_options() -> getCpanelValue( 'footer_style' );
?>
<?php
if($footer_style == 'default') {
	?>
	<?php
	if (is_active_sidebar_YA('above-footer')){
		$ya_copyright_text = ya_options()->getCpanelValue('footer_copyright');
		?>
		<div class="sidebar-above-footer theme-clearfix">
			<div class="container theme-clearfix">
				<?php dynamic_sidebar('above-footer'); ?>
			</div>
		</div>
		<?php } ?>
		<footer class="footer theme-clearfix">
			<div class="container theme-clearfix">
				<div class="row">
					<?php if (is_active_sidebar_YA('footer')){ ?>
					<?php dynamic_sidebar('footer'); ?>
					<?php } ?>
				</div>
			</div>
			<div class="copyright theme-clearfix">
				<div class="container clearfix">
					<div class="copyright-text pull-left">
						<?php if( $ya_copyright_text == '' ) : ?>
							<?php _e( "Copyright &copy; ", 'maxshop' )?><?php echo date('Y '); ?><?php echo 'SW MaxShop Store. All Rights Reserved. Design by <a href="http://www.smartaddons.com/" target="_blank" title="Wordpress Themes, Joomla Templates">Smartaddons.com</a>'?>
						<?php else : ?>
							<?php  echo wp_kses( $ya_copyright_text, array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array() ), 'p' => array()  ) ) ; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</footer>
		<?php
	} else {
		get_template_part('templates/footer', $footer_style);
	}
	?>
	<?php if (is_active_sidebar_YA('floating') ){ ?>
	<div class="floating theme-clearfix">
		<?php dynamic_sidebar('floating');  ?>
	</div>
	<?php } ?>
	<?php if(ya_options()->getCpanelValue('back_active') == '1') { ?>
	<a id="ya-totop" href="#" ></a>
	<?php }?>
</div>
<script type="text/javascript">
	/*** remove <p> *****/
	jQuery('.panel-group .panel-default br').remove();
</script>
<?php wp_footer(); ?>
