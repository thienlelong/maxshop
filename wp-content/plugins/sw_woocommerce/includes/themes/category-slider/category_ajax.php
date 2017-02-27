<?php 
if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
	</div>';
}
if( !is_array( $category ) ){
	$category = explode( ',', $category );
}
$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.rand().time();
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="category-ajax-slider">
    <div class="top-tab-slider">
		<div class="order-title">
			<?php
				$titles = strpos($title1, ' ');
				$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
				echo '<h2><strong>'. $title .'</strong></h2>';
			?>
		</div>
	</div>	
	<div id="<?php echo 'tab_' . $widget_id; ?>" class="sw-tab-slider responsive-slider" data-lg="<?php echo count( $category ) ?>" data-md="<?php echo count( $category ) - 2; ?>" data-sm="<?php echo count( $category ) - 3 ?>" data-xs="3" data-mobile="2" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="1" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="false">
		<ul class="nav nav-tabs slider responsive">
		<?php
			foreach( $category as $key => $cat ){
				$term = get_term_by('slug', $cat, 'product_cat');							
				$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ));
				$thumbnail_id1 	=absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id1', true ));
				$thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
				$thumb1 = wp_get_attachment_image( $thumbnail_id1, array(350, 230) );
		?>
			<li class="<?php if( ( $key + 1 ) == $tab_active ){echo 'active'; }?>">
				<a href="#<?php echo 'category_ajax_'. esc_attr( $term->term_id ); ?>" data-toggle="tab" data-catid="<?php echo esc_attr( $term->term_id ); ?>" data-catload="ajax" data-number="<?php echo esc_attr( $numberposts ); ?>" data-orderby="<?php echo esc_attr( $orderby ); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
					<div class="item-image">
						<?php echo $thumb1; ?>
					</div>
					<div class="item-content">
						<h3><?php echo esc_html( $term->name ); ?></h3>
					</div>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<div class="tab-content">
	<?php
	foreach( $category as $key => $cat ){
		$term = get_term_by('slug', $cat, 'product_cat');	
	?>
		<div id="<?php echo 'category_ajax_'. esc_attr( $term->term_id ); ?>" class="tab-pane fade in <?php if( ( $key + 1 ) == $tab_active ){echo 'active'; }?>"></div>
	<?php } ?>
	</div>
</div>	