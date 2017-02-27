<?php 

/**
	* Layout Child Category 1
	* @version     1.0.0
**/

if( $category == '' ){
	return '<div class="alert alert-warning alert-dismissible" role="alert">
		<a class="close" data-dismiss="alert">&times;</a>
		<p>'. esc_html__( 'Please select a category for SW Woocommerce Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
	</div>';
}
$widget_id = isset( $widget_id ) ? $widget_id : 'sw_woo_slider_'.rand().time();

$default = array();
if( $category != '' ){
	$default = array(
		'post_type' => 'product',
		'tax_query' => array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category ) ),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
}
$term = get_term_by( 'slug', $category, 'product_cat' );	
$list = new WP_Query( $default );
if ( $list -> have_posts() ){ ?>
	<div id="<?php echo 'slider_' . $widget_id; ?>" class="responsive-slider woo-slider-default sw-child-cat loading" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title clearfix">
			<h2 class="page-title-slider"><?php echo $term->name; ?></h2>
			<?php echo ( $description != '' ) ? '<div class="slider-description">'. $description .'</div>' : ''; ?>
			<button class="button-collapse collapsed pull-right" type="button" data-toggle="collapse" data-target="#<?php echo 'child_' . $widget_id; ?>"  aria-expanded="false">
				<span><?php esc_html_e( 'More', 'sw_woocommerce' ); ?></span>				
			</button>
		</div>
		<div class="childcat-slider-content clearfix">
		<?php 
			$termchild = get_term_children( $term->term_id, 'product_cat' );
			if( count( $termchild ) > 0 ){
		?>			
			<div class="childcat-content pull-left"  id="<?php echo 'child_' . $widget_id; ?>">
			
			<?php 
				$termchild 		= get_term_children( $term->term_id, 'product_cat' );
				echo '<ul>';
				foreach ( $termchild as $key => $child ) {
					$term = get_term_by( 'id', $child, 'product_cat' );
					if( $key == 6 ){
						break;
					}
					echo '<li><a href="' . get_term_link( $child, 'product_cat' ) . '">' . $term->name . '</a></li>';
				}
				echo '</ul>';
			?>
			</div>
			<?php } ?>
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
					<?php $i++; endwhile; wp_reset_postdata();?>
				</div>
			</div> 
		</div>
	</div>
	<?php
	}
?>