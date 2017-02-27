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
	<div class="container">
		<div class="top-header">
			<div class="ya-logo pull-left">
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
				</div>

				<div id="sidebar-top-header" class="sidebar-top-header">
					<?php if($phone != '') {?>
					<div class="box-contact-email-phone">
						<h2><?php _e('HOTLINE:','maxshop') ;?></h2>
						<a href="#" title="Call: <?php echo esc_attr( $phone ) ?>"><?php echo esc_html( $phone ) ?></a>
					</div>
					<?php }?>
					<?php get_template_part( 'woocommerce/minicart-ajax-style1' ); ?>
				</div>

			</div>
		</div>
		<div class="yt-header-under">
			<div class="container">
				<div class="row yt-header-under-wrap">
					<div class="yt-main-menu col-md-12">
						<?php if ( has_nav_menu('primary_menu') ) {?>
						<!-- Primary navbar -->
						<div id="main-menu" class="main-menu">
							<nav id="primary-menu" class="primary-menu" role="navigation">
								<div class="container">
									<div class="mid-header clearfix">
										<a href="javascript:void(0)" class="phone-icon-menu"></a>
										<div class="navbar-inner navbar-inverse">
											<?php
											$menu_class 	= 'nav nav-pills';
											if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
												$menu_class .= ' nav-mega';
											} else $menu_class .= ' nav-css';
											?>
											<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $menu_class)); ?>
										</div>
										<div id="sidebar-top-menu" class="sidebar-top-menu">
											<?php if($search !='') {?>
											<div class="widget ya_top-3 ya_top non-margin"><div class="widget-inner">
												<?php get_template_part( 'widgets/ya_top/searchcate' ); ?>
											</div></div>
											<?php }?>
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
</header>

