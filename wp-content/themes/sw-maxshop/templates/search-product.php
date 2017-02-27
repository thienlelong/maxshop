<?php
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$product_cat = isset( $_GET['search_category'] ) ? $_GET['search_category'] : '';
	$s = $_GET['s'];	
	$args_product = array(
		's' => $s,
		'post_type'	=> 'product',
		'posts_per_page' => 8,
		'paged' => $paged
	);
	if( $product_cat != '' ){
		$args_product['tax_query'] = array(
			array(
				'taxonomy'	=> 'product_cat',
				'field'		=> 'id',
				'terms'	=> $product_cat				
			)
		);
	}
?>
<div class="content-list-category container">
	<div class="content_list_product">
		<div class="products-wrapper">		
		<?php
			$product_query = new wp_query( $args_product );
			if( $product_query -> have_posts() ){
			?>
			<ul id="loop-products" class="products-loop row clearfix grid-view grid">
			<?php
				while( $product_query -> have_posts() ) : $product_query -> the_post();
					get_template_part( 'woocommerce/content', 'product' );
				endwhile;				
			?>
			</ul>
			<!--Pagination-->
						<?php if ($product_query->max_num_pages > 1) : ?>
						<div class="pag-search ">
						<div class="pagination nav-pag pull-right">
							<ul class="list-inline">
								<?php if (get_previous_posts_link()) : ?>
								 <li class="prev"><?php previous_posts_link(__('<i class="fa fa-caret-left"></i>', 'maxshop')); ?></li>
								<?php else: ?>
									<li class="disabled prev"><a><?php _e('<i class="fa fa-caret-left"></i>', 'maxshop'); ?></a></li>
								<?php endif; ?>

								<?php 
	      	if ($paged < 3){
	      		$i = 1;
	      	}
	      	elseif ($paged < $product_query->max_num_pages - 2){
	      		$i = $paged -1 ;
	      	}
	      	else {
	      		$i = $product_query->max_num_pages - 3;
	      	}
	      	 
	      	if ($product_query->max_num_pages > $i + 3){
				$max = $i + 2;
			}
			else $max = $product_query->max_num_pages;
	
			if ($paged > 3 && $product_query->max_num_pages > 4) {?>
								<li><a href="<?php echo get_pagenum_link('1')?>">1</a></li>
								<li><a>...</a></li>
								<?php }
	      	for ($i = 1; $i<= $max ; $i++){?>
								<?php if (($paged == $i) || ( $paged ==1 && $i==1)){?>
								<li class="disabled"><a><?php echo $i?> </a></li>
								<?php } else {?>
								<li><a href="<?php echo get_pagenum_link($i)?>"><?php echo $i?>
								</a></li>
								<?php }?>
								<?php }?>

								<?php if ($max < $product_query->max_num_pages) {?>
								<li><a>...</a></li>
								<li><a
									href="<?php echo get_pagenum_link($product_query->max_num_pages)?>"><?php echo $product_query->max_num_pages?>
								</a></li>
								<?php }?>

								<?php if (get_next_posts_link()) : ?>
								<li class="pagination"><?php next_posts_link(__('<i class="fa fa-caret-right"></i>', 'maxshop')); ?>
								</li>
								<?php else: ?>
								<li class="disabled pagination"><a><?php _e('<i class="fa fa-caret-right"></i>', 'maxshop'); ?>
								</a></li>
								<?php endif; ?>
							</ul>
						</div>
						</div>
						<?php endif; ?>
						<!--End Pagination-->
		<?php 
			}else{
		?>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<a class="close" data-dismiss="alert">&times;</a>
				<p><?php _e('No product found.', 'maxshop'); ?></p>
			</div>
		<?php
			}
		?>
		</div>
	</div>
</div>