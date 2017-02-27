<?php  
if (!isset($instance['categories'])){
	$instance['categories'] = array();
}
extract($instance);
if( count($categories) > 0 ){
?>
<div id="<?php echo $widget_id; ?>" class="list-product-slider carousel slide">
	<div class="carousel-inner">
		<?php 		
			$i = 0;
			foreach( $categories as $cat ){
				$term = get_term($cat, 'product_cat');
				//var_dump($term);
				$thumbnail_id 	= absint( get_woocommerce_term_meta( $category, 'thumbnail_id', true ) );
				$thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
				if( $i % 3 == 0 ){ 
		?>
			<div class="item <?php if( $i == 0 ){ echo 'active'; } ?>">
			<div class="row">
		<?php } ?>
				<div class="item-inner col-lg-4 col-md-4 col-sm-4">
					<?php if( $thumbnail_id != 0 ){ ?>
						<div class="item-content">
							<div class="item-img">
								<div class="item-img-info">
									<a href="<?php echo get_term_link( $cat, 'product_cat' ); ?>">
										<?php echo $thumb; ?>
									</a>
								</div>
							</div>
							<div class="item-info item-spotlight">
								<div class="item-title">
									<a class="a_category" href="<?php echo get_term_link( $cat, 'product_cat' ); ?>"><?php echo $term->name; ?></a>
									<br>
									<a class="a_shop" href="<?php echo get_term_link( $cat, 'product_cat' ); ?>" class="readmore"><?php _e('Shop Now', 'maxshop'); ?><i class="fa fa-circle-arrow-right"></i></a>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
		<?php if( ( $i+1 )%3==0 || ( $i+1 ) == count($categories) ){?> </div></div><?php } ?>
		<?php $i++; } ?>
	</div>
	<a href="#<?php echo $widget_id; ?>" data-slide="prev" class="list-product-nav list-product-prev"></a>
	<a href="#<?php echo $widget_id; ?>" data-slide="next" class="special-nav list-product-next"></a>
</div>
<?php
}