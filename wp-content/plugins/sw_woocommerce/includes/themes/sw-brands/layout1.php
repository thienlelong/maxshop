<?php 
	$widget_id = isset( $widget_id ) ? $widget_id : 'sw_brand_'.rand().time();
	$term_brands = array();
	if( !is_array( $category ) ){
		$category = explode( ',', $category );
	}
	if( count( $category ) == 1 && $category[0] == '' ){
		$terms = get_terms( 'product_brand', array( 'parent' => '', 'hide_empty' => 0 ) );
		foreach( $terms as $key => $cat ){
			$term_brands[$key] = $cat -> slug;
		}
	}else{
		$term_brands = $category;
	}
	
?>
	<div id="<?php echo esc_attr( $widget_id ) ?>" class="bran2-layout-slider loading clearfix" data-number="<?php echo esc_attr( $numberposts ); ?>">
		<?php if( $title1 != '' ) : ?>
			<div class="block-title title1 clearfix">
				<h2><span><?php echo esc_html( $title1 ); ?></span></h2>
				<a href="javascript:void(0)" class="view-all-brand pull-right"><?php esc_html_e( 'View All', 'sw_woocommerce' ) ?></a>			
			</div>
		<?php endif; ?>
		<div class="bran2-slider">
			<ul class="bran2">
				<?php 
					foreach( $term_brands as $term_brand ) {
						$term = get_term_by( 'slug', $term_brand, 'product_brand' );	
						$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_bid', true ) );
						$thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
				?>
					<li class="item item-brand-cat">					
						<div class="item-image">
							<?php echo '<a href="'. get_term_link( $term->term_id, 'product_brand' ).'">'.$thumb .'</a>'; ?>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
