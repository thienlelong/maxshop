<?php
	/**
		** Tab Upsell & Related
	**/
	if( !is_singular( 'product' ) ){
		return '';
	}
	global $product;
	$related = $product->get_related( $numberposts );
	$upsells = $product->get_upsells();
	if( count( $related ) > 0 || count( $upsells ) > 0 ){
?>
<div id="<?php echo 'reup_'.esc_attr( $widget_id ); ?>" class="product-ur">
	<div id="tab_<?php echo esc_attr( $widget_id ); ?>" class="tabbable tabs">
		<ul class="nav nav-tabs">
		<?php if( count( $related ) > 0 ){ ?>
			<li class="active">
				<a href="#single_related" data-toggle="tab"><?php _e( 'Related Products', 'sw_woocommerce' ); ?></a>
			</li>
		<?php } ?>
		<?php if( count( $upsells ) > 0 ){ ?>
			<li>
				<a href="#single_upsell" data-toggle="tab"><?php _e( 'Upsell Products', 'sw_woocommerce' ); ?></a>
			</li>
		<?php } ?>
		</ul>
		<div class="tab-content">
		<?php if( count( $related ) > 0 ){ ?>
			<div id="single_related" class="tab-pane active">
				<?php include( 'related.php' ); ?>
			</div>
		<?php } ?>
		<?php if( count( $upsells ) > 0 ){ ?>
			<div id="single_upsell" class="tab-pane">
				<?php include( 'upsell.php' ); ?>
			</div>
		<?php } ?>
		</div>
	</div>
</div>
<?php }else{ ?>
	<div class="alert alert-warning">
		<button class="close" data-dismiss="alert" type="button">×</button>
		<?php esc_html_e( 'This product not have upsell or related!', 'sw_woocommerce' ); ?>
	</div>
<?php } ?>