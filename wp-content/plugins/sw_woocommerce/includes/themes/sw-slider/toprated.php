<?php 

/**
	* Layout Top Rated
	* @version     1.0.0
**/

$term_name = esc_html__( 'Top Rated Products', 'sw_woocommerce' );
$default = array(
	'post_type'		=> 'product',		
	'post_status' 	=> 'publish',
	'no_found_rows' => 1,					
	'showposts' 	=> $numberposts						
);
if( $category != '' ){
	$term = get_term_by( 'slug', $category, 'product_cat' );	
	$term_name = $term->name;
	$default['tax_query'] = array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'		=> 'slug',
			'terms'		=> $category,
			'operator' 	=> 'IN'
		)
	);
}
$default['meta_query'] = WC()->query->get_meta_query();
add_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
$id = 'sw_toprated_'.rand().time();
$list = new WP_Query( $default );
do_action( 'before' ); 
if ( $list -> have_posts() ){
?>
	<div id="<?php echo $id; ?>" class="sw-woo-container-slider  responsive-slider toprated-product clearfix loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="order-title">
			<?php
				$titles = strpos($title1, ' ');
				$title = ($titles !== false) ? '<span>' . substr($title1, 0, $titles) . '</span>' .' '. substr($title1, $titles + 1): $title1 ;
				echo '<h2><strong>'. $title .'</strong></h2>';
			?>
				
			<?php if( $image_icon != '' ) { ?>
				<div class="order-icon">
					<?php 
						$image_thumb = wp_get_attachment_image( $image_icon, 'thumbnail' );
						echo $image_thumb; 
					 ?>
				</div>
			<?php } ?>

			<?php echo ( $description != '' ) ? '<div class="order-desc">'. $description .'</div>' : ''; ?>
		</div>
		<div class="resp-slider-container">			
			<div class="slider responsive">			
			<?php 
				$count_items 	= 0;
				$numb 			= ( $list->found_posts > 0 ) ? $list->found_posts : count( $list->posts );
				$count_items 	= ( $numberposts >= $numb ) ? $numb : $numberposts;
				$i 				= 0;
				while($list->have_posts()): $list->the_post();global $product, $post;
				$class = ( $product->get_price_html() ) ? '' : 'item-nonprice';
				if( $i % $item_row == 0 ){
			?>
				<div class="item <?php echo esc_attr( $class )?>">
			<?php } ?>
					<?php include( WCTHEME . '/default-item.php' ); ?>
				<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
			<?php 
				$i++; endwhile;
				remove_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
				wp_reset_postdata();
			?>
			</div>
		</div>					
	</div>
<?php
}	
?>