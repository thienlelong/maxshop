<?php 
	$ya_direction = ya_options()->getCpanelValue( 'direction' );
	$default = array(
		'post_type' => 'team',
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	$id = $this -> number;
	$list = new WP_Query( $default );
if ( $list -> have_posts() ){
?>
<div id="sw_ourteam_<?php echo esc_attr( $id ) ?>" class="responsive-slider sw-ourteam-slider style1 loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-rtl="<?php echo ( is_rtl() || $ya_direction == 'rtl' )? 'true' : 'false';?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
	<div class="resp-slider-container">
		<div class="slider responsive">
		<?php 
			while($list->have_posts()): $list->the_post();
			global  $post;
			$facebook = get_post_meta( $post->ID, 'facebook', true );	
			$twitter = get_post_meta( $post->ID, 'twitter', true );
			$gplus = get_post_meta( $post->ID, 'gplus', true );
			$linkedin = get_post_meta( $post->ID, 'linkedin', true );
			$team_info = get_post_meta( $post->ID, 'team_info', true );
		?>
			<div class="item">
				<div class="item-wrap">							
				<?php if(has_post_thumbnail()){ ?>
					<div class="item-img item-height">
						<div class="item-img-info">				
							<?php the_post_thumbnail(); ?>							
						</div>
					</div>
				<?php } ?>					
					<div class="item-content">
						<h3><?php the_title(); ?></h3>
						<?php if( $team_info != '' ){ ?>
						<div class="team-info"><?php echo esc_html( $team_info ); ?></div>
						<?php } ?>
						<div class="item-desc">
							<?php 
								if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
									$content = explode($matches[0], $post->post_content, 2);
									$content = $content[0];
								} else {
									$content = self::ya_trim_words($post->post_content, $length, ' ');
								}
								echo esc_html( $content );
							?>
						</div>
						<?php if( $facebook != '' || $twitter != '' || $gplus != '' || $linkedin != '' ){?>																
							<div class="item-social">
								<?php if( $facebook != '' ){ ?>
								<div class="team-facebook">
									<a href="<?php echo esc_attr( $facebook ); ?>"><i class="fa fa-facebook"></i></a>
								</div>
								<?php } ?>
								<?php if( $twitter != '' ){ ?>
								<div class="team-twitter">
									<a href="<?php echo esc_attr( $twitter ); ?>"><i class="fa fa-twitter"></i></a>
								</div>
								<?php } ?>
								<?php if( $gplus != '' ){ ?>
								<div class="team-gplus">
									<a href="<?php echo esc_attr( $gplus ); ?>"><i class="fa fa-google-plus"></i></a>
								</div>
								<?php } ?>
								<?php if( $linkedin != '' ){ ?>
								<div class="team-linkedin">
									<a href="<?php echo esc_attr( $linkedin ); ?>"><i class="fa fa-linkedin"></i></a>
								</div>
								<?php } ?>									
							</div>
						<?php } ?>
					</div>		
				</div>
			</div>
		<?php endwhile; wp_reset_postdata();?>
		</div>
	</div>
</div>
<?php
}
?>