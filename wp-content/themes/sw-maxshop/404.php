<?php get_template_part('header'); ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="col-1-wrapper">
				<div class="std"><div class="wrapper_404page">
					<div class="col-lg-7 col-md-7">
						<div class="content-404page">
							<p class="top-text"><?php _e( "Don't worry you will be back on track in no time!", 'maxshop' )?></p>
							<p class="img-404"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/404-img-text.png" alt=""></p>
							<p class="bottom-text"><?php _e( "Page doesn't exist or some other error occured. Go to our home page or go back previous page", 'maxshop' )?></p>
							<div class="button-404">
								<a href="javascript:void(0);" onclick="goBack()" class="btn-404 prev-page-btn" title="PREVIOUS PAGE"><?php _e( "PREVIOUS PAGE", 'maxshop' )?></a>
								<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-404 back2home" title="BACK TO HOMEPAGE"><?php _e( "BACK TO HOMEPAGE", 'maxshop' )?></a>
							</div>
						</div>
					</div>
					
					<div class="col-lg-5 col-md-5">
						<div class="img-right-404">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/img/404-image.png" alt="">
						</div>
					</div>
					<div style="clear:both; height:0px">&nbsp;</div>
					<script>
						function goBack() {
							window.history.back()
						}
					</script>
				</div>
			</div>   
		</div>
	</div>
</div>
</div>
<?php get_template_part('footer'); ?>