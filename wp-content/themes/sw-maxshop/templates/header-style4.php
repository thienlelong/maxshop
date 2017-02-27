<?php 
$colorset = ya_options()->getCpanelValue('scheme');
$phone = ya_options() ->getCpanelValue('phone');
$search = ya_options()->getCpanelValue('search');
?>
<header id="header" role="banner" class="header">
	<div class="header-msg">
		<div class="container">
			<?php if (is_active_sidebar_YA('top')) {?>
			<div id="sidebar-top" class="sidebar-top">
				<?php dynamic_sidebar('top'); ?>
			</div>
			<?php }?>
		</div>
	</div>
	<div class="yt-header-middle">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 logo-wrapper">
					<h1>
						<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php if(ya_options()->getCpanelValue('sitelogo')){ ?>
							<img src="<?php echo esc_attr( ya_options()->getCpanelValue('sitelogo') ); ?>" alt="<?php bloginfo('name'); ?>"/>
							<?php }else{
								if ($colorset){$logo = get_template_directory_uri().'/assets/img/logo-'.$colorset.'.png';}
								else $logo = get_template_directory_uri().'/assets/img/logo-default.png';
								?>
								<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
								<?php } ?>
							</a>
						</h1>

					</div>

					<div class="col-lg-9 col-md-9 col-sm-6 col-xs-6">
						<div class="yt-header-under">
							<div class="yt-menu">

								<?php if ( has_nav_menu('primary_menu') ) {?>
								<!-- Primary navbar -->
								<div id="main-menu" class="main-menu">
									<nav id="primary-menu" class="primary-menu" role="navigation">
										<div class="container">
											<div class="mid-header clearfix">
												<a href="#" class="phone-icon-menu"></a>
												<div class="navbar-inner navbar-inverse">
													<?php
													$menu_class 	= 'nav nav-pills';
													if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
														$menu_class .= ' nav-mega';
													} else $menu_class .= ' nav-css';
													?>
													<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $menu_class)); ?>
												</div>
											</div>
										</div>
									</nav>
								</div>
								<!-- /Primary navbar -->
								<?php 
							} 
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="yt-header-under-2">
		<div class="container">
			<div class="row yt-header-under-wrap">
				<div class="yt-main-menu col-md-12">
					<div class="header-under-2-wrapper">
						<div class="yt-searchbox-vermenu">
							<div class="row">							
								<div id="sidebar-top-menu" class="sidebar-top-menu clearfix">
									<a href="javascript:void(0)" class="phone-icon-category" href="#" title="<?php esc_attr_e( 'Categories', 'maxshop' ) ?>"><span class="icon-category"></span><?php esc_html_e( 'Categories', 'maxshop' ) ?></a>
									<a class="phone-icon-search fa fa-search" href="#" title="<?php esc_attr_e( 'Search', 'maxshop' ) ?>"></a>
									<div class="col-lg-3 col-md-3 col-sm-6 vertical_megamenu-4 vertical_megamenu-header">
										<div class="button-ver-menu"><?php _e('All categories','maxshop')?></div>
										<?php echo do_shortcode('[ya_mega_menu menu_locate="left-menu-shop-5"]') ?>
									</div>
									<?php if($search !='') {?>
									<div class="widget ya_top-3 ya_top non-margin"><div class="widget-inner">
										<?php get_template_part( 'widgets/ya_top/searchcate' ); ?>
									</div></div>
									<?php }?>
									<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
									<?php get_template_part( 'widgets/ya_top/login-header4' ); ?>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>