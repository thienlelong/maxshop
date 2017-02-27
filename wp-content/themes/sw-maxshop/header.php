<?php $box_layout = ya_options()->getCpanelValue('layout'); ?>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
	<div class="body-wrapper theme-clearfix<?php echo ( $box_layout == 'boxed' )? ' box-layout' : '';?> ">
		<?php 
		$colorset = ya_options()->getCpanelValue('scheme');
		$header_style = ya_options()->getCpanelValue('header_style');
		if ($header_style == 'default'){
			?>
			<header id="header" class="header">
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
							<?php if (is_active_sidebar_YA('top-header')) {?>
							<div id="sidebar-top-header" class="sidebar-top-header">
								<?php dynamic_sidebar('top-header'); ?>
							</div>
							<?php }?>
						</div>
					</div>
				</header>
				<?php if ( has_nav_menu('primary_menu') ) {?>
				<!-- Primary navbar -->
				<div id="main-menu" class="main-menu">
					<nav id="primary-menu" class="primary-menu">
						<div class="container">
							<div class="mid-header clearfix">
								<a href="#" class="phone-icon-menu"></a>
								<div class="navbar-inner navbar-inverse">
									<?php
									$menu_class = 'nav nav-pills';
									if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
										$menu_class .= ' nav-mega';
									} else $menu_class .= ' nav-css';
									?>
									<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $menu_class)); ?>
								</div>
								<?php if (is_active_sidebar_YA('top-menu')) {?>
								<div id="sidebar-top-menu" class="sidebar-top-menu">
									<?php dynamic_sidebar('top-menu'); ?>
								</div>
								<?php }?>
							</div>
						</div>
					</nav>
				</div>
				<!-- /Primary navbar -->
				<?php 
			}
		} else {
			echo '<div class="header-' . $header_style . '">';
			get_template_part('templates/header', $header_style);
			echo '</div>';
		}	
		?>

		<div id="main" class="theme-clearfix">
			<?php

			if (function_exists('ya_breadcrumb')){
				ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
			} 

			?>