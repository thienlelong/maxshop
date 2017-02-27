<?php 
	$widget_id = isset( $widget_id ) ? $widget_id : 'sw_brand_'.rand().time();
	$term_brands = array();
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
	if( count( $category ) == 1 && $category[0] == '' ){
		$terms = get_terms( 'product_brand', array( 'parent' => '', 'hide_empty' => 0, 'number' => $numberposts ) );
		foreach( $terms as $key => $cat ){
			$term_brands[$key] = $cat -> slug;
		}
	}else{
		$term_brands = $category;
	}
	
?>
	<div id="<?php echo esc_attr( $widget_id ) ?>" class="responsive-slider sw-brand-container-slider loading clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<?php if( $title1 != '' ) : ?>
			<div class="title-home"><h2><?php echo esc_html( $title1 ); ?></h2></div>
		<?php endif; ?>
		<div class="resp-slider-container">
			<div class="slider responsive">
				<?php 
					foreach( $term_brands as $term_brand ) {
						$term = get_term_by( 'slug', $term_brand, 'product_brand' );	
						$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_bid', true ) );
						$thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
				?>
					<div class="item item-brand-cat">					
						<div class="item-image">
							<?php echo '<a href="'. get_term_link( $term->term_id, 'product_brand' ).'">'.$thumb .'</a>'; ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
