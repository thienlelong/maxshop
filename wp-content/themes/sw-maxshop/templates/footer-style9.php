<?php global $template;
$footer_style = ya_options() -> getCpanelValue( 'footer_style' );
?>
<footer class="footer theme-clearfix footer-<?php echo $footer_style; ?>" role="contentinfo">
	<div class="footer-in theme-clearfix">
		<div class="container theme-clearfix">
			<div class="row">
				<?php if (is_active_sidebar_YA('footer-style9-left')){ ?>
				<div class="col-lg-3 col-md-3 col-sm-12 sidebar-footer-style9-left">					
					<?php dynamic_sidebar('footer-style9-left'); ?>
				</div>
				<?php } ?>
				<div class="col-lg-9 col-md-9 col-sm-12 sidebar-footer-style9-right">
					<?php if (is_active_sidebar_YA('footer-style9-right1')){ ?>					
						<?php dynamic_sidebar('footer-style9-right1'); ?>
					<?php } ?>
					<?php if (is_active_sidebar_YA('footer-style9-right2')){ ?>	
					<div class="sidebar-footer-style9-right2 clearfix">				
						<?php dynamic_sidebar('footer-style9-right2'); ?>
					</div>
					<?php } ?>
				</div>
				
			</div>
		</div>
	</div>
	<div class="copyright9 theme-clearfix">
		<div class="container clearfix">
			<?php if (is_active_sidebar_YA('footer-copyright9')){ ?>
			<div class="sidebar-copyright9">					
				<?php dynamic_sidebar('footer-copyright9'); ?>
			</div>
			<?php } ?>
		</div>
	</div>
</footer>
