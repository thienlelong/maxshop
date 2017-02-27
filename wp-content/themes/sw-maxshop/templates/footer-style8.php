<?php global $template;
$footer_style = ya_options() -> getCpanelValue( 'footer_style' );
?>
<footer class="footer theme-clearfix footer-<?php echo $footer_style; ?>" role="contentinfo">
	<div class="footer-in theme-clearfix">
		<div class="container theme-clearfix">
			<div class="row">
				<?php if (is_active_sidebar_YA('footer-style8')){ ?>
				<div class="col-lg-12 col-md-12 col-sm-12 sidebar-footer-style8">					
					<?php dynamic_sidebar('footer-style8'); ?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="copyright8 theme-clearfix">
		<div class="clearfix">
			<?php if (is_active_sidebar_YA('footer-copyright8')){ ?>
			<div class="sidebar-copyright">					
				<?php dynamic_sidebar('footer-copyright8'); ?>
			</div>
			<?php } ?>
		</div>
	</div>
</footer>
