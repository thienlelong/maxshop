<div class="top-form top-search pull-left">
	<div class="topsearch-entry">
	<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { ?>
		<form role="search" method="get" id="searchform_special" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
			<div>
				<?php
				$args = array(
				'type' => 'product',
				'parent' => 0,
				'orderby' => 'id',
				'order' => 'ASC',
				'hide_empty' => false,
				'hierarchical' => 1,
				'exclude' => '',
				'include' => '',
				'number' => '',
				'taxonomy' => 'product_cat',
				'pad_counts' => false,

				);
				$product_categories = get_categories($args);
				if( count( $product_categories ) > 0 ){
				?>
				<div class="cat-wrapper">
					<label class="label-search">
						<select name="search_category" class="s1_option">
							<option value=""><?php _e( 'All Categories', 'maxshop' ) ?></option>
							<?php foreach( $product_categories as $cat ) {
								$selected = ( isset($_GET['search_category'] ) && ($_GET['search_category'] == $cat->term_id )) ? 'selected=selected' : '';
							echo '<option value="'. esc_attr( $cat-> term_id ) .'" '.$selected.'>' . esc_html( $cat->name ). '</option>';
							}
							?>
						</select>
					</label>
				</div>
				<?php } ?>
				<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e( 'Search for products', 'maxshop' ); ?>" />
				<button type="submit" title="Search" class="fa fa-search button-search-pro form-button"></button>
				<input type="hidden" name="search_posttype" value="product" />
			</div>
		</form>
		<?php }else{ ?>
			<?php get_template_part('templates/searchform'); ?>
		<?php } ?>
	</div>
</div>
