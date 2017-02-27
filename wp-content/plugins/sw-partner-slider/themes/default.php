<?php 
	if( $category != 0 ){
		$default = array(
			'post_type' => 'partner',
			'tax_query'	=> array(
			array(
				'taxonomy'	=> 'partners',
				'field'		=> 'id',
				'terms'		=> $category)),
			'orderby' => $orderby,
			'order' => $order,
			'include' => $include,
			'exclude' => $exclude,
			'post_status' => 'publish',
			'showposts' => $numberposts
		);
	}else{
		$default = array(
			'post_type' => 'partner',
			'orderby' => $orderby,
			'order' => $order,
			'post_status' => 'publish',
			'showposts' => $numberposts
		);
	}
	$list = new WP_Query( $default );
if ( count($list) > 0 ){
$tag_id ='sw_partner_slider_'.rand().time();
?>
	<div id="<?php echo $tag_id; ?>" class="sw-partner-container-slider" style="<?php if( $anchor == "bottom" ){ echo "margin-bottom:40px;"; }?>">
			<?php if($anchor =="top"){?>
			<div class="page-button <?php echo $anchor;?>">
				<ul class="control-button preload">
					<li class="preview"></li>
					<li class="next"></li>
				</ul>		
			</div>
			<?php }?>
		
		<?php 
		$count_items = 0;
		if($numberposts >= $list->found_posts){$count_items = $list->found_posts; }else{$count_items = $numberposts;}
		//var_dump($list);
		if($columns > $count_items){
			$columns = $count_items;
		}
		
		if($columns1 > $count_items){
			$columns1 = $count_items;
		}
		
		if($columns2 > $count_items){
			$columns2 = $count_items;
		}
		
		if($columns3 > $count_items){
			$columns3 = $count_items;
		}
		
		if($columns4 > $count_items){
			$columns4 = $count_items;
		}
		
		$deviceclass_sfx = 'preset01-'.$columns.' '.'preset02-'.$columns1.' '.'preset03-'.$columns2.' '.'preset04-'.$columns3.' '.'preset05-'.$columns4;
		
		?>
		<div class="slider not-js cols-6 <?php echo $deviceclass_sfx; ?>">
			<div class="vpo-wrap">
				<div class="vp">
					<div class="vpi-wrap">
					<?php 
						while($list->have_posts()): $list->the_post();
						global  $post;
						$link = get_post_meta( $post->ID, 'link', true );
						$target = get_post_meta( $post->ID, 'target', true );
						$description = get_post_meta( $post->ID, 'description', true );
					?>
						<div class="item">
							<div class="item-wrap">							
								<?php if(has_post_thumbnail()){ ?>
									<div class="item-img item-height">
										<div class="item-img-info">
											<a href="<?php echo $link; ?>" title="<?php the_title_attribute();?>" target="<?php echo $target; ?>">
												<?php the_post_thumbnail();?>
											</a>
										</div>
									</div>
								<?php }else{ ?>
									<div class="item-img item-height">
										<div class="item-img-info">
											<a href="<?php echo $link; ?>" title="<?php the_title_attribute();?>" target="<?php echo $target; ?>">
												<img src="<?php get_template_directory_uri(); ?>'/assets/img/placeholder/thumbnail.png" alt="No thumb">;
											</a>
										</div>
									</div>
								<?php } ?>
								<?php if( $description != '' ){ ?>
									<div class="item-desc">
										<?php echo $description; ?>
									</div>		
								<?php } ?>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata();?>
					</div>
				</div>
			</div>
		</div>
		
		<?php if($anchor !="top"){?>			
			<div class="page-button <?php echo $anchor;?>">
				<ul class="control-button preload">
					<li class="preview">Prev</li>
					<li class="next">Next</li>
				</ul>		
			</div>
		<?php }?>
		
	</div>
	<script type="text/javascript">
		//<![CDATA[
			jQuery(document).ready(function($){
				;(function(element){
					var $element = $(element);
					var $slider = $('.slider', $element)
					jQuery('.slider', $element).responsiver({
						interval: <?php echo $interval; ?>,
						speed: <?php echo $speed; ?>,
						start: <?php echo $start-1; ?>,	
						step: <?php echo $scroll; ?>,
						circular: true,
						preload: true,
						fx: '<?php echo $effect; ?>',
						pause: '<?php echo $hover; ?>',
						control:{
							prev: '#<?php echo $tag_id;?> .control-button li[class="preview"]',
							next: '#<?php echo $tag_id;?> .control-button li[class="next"]'
						},
						getColumns: function(element){
							var match = $(element).attr('class').match(/cols-(\d+)/);
							if (match[1]){
								var column = parseInt(match[1]);
							} else {
								var column = 1;
							}
							if (!column) column = 1;
							return column;
						}          
					});
						<?php if($swipe == 'yes') {	?>
							$slider.touchSwipeLeft(function(){
								$slider.responsiver('next');
								}
							);
							$slider.touchSwipeRight(function(){
								$slider.responsiver('prev');
								}
							);
						<?php } ?>
					$('.control-button',$element).removeClass('preload');
				})('#<?php echo $tag_id; ?>');
			});
		//]]>
		</script>
<?php
}
?>