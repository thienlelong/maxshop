<?php 
if (!isset($instance['category'])){
	$instance['category'] = 0;
}

$instance['interval'] = isset($instance['interval']) ? intval($instance['interval']) : 5000;

extract($instance);

$default = array(
	'category' => $category,
	'orderby' => $orderby,
	'order' => $order,
	'include' => $include,
	'exclude' => $exclude,
	'post_status' => 'publish',
	'numberposts' => $numberposts
);

$list = get_posts($default);
if( count($list) > 0 ){ ?>
<div class="label-offer-slider">
<?php _e('This Week','maxshop') ?>
</div>
<div id="<?php echo esc_attr( $widget_id ); ?>" class="carousel slide content" data-ride="carousel">
  <div class="carousel-inner">
  <?php foreach( $list as $i => $item ){  	?>
    <div class="item<?php if( $i == 0 ){ echo ' active'; }?>">
      <div class="blog-caption">
      	<div class="blog-caption-inner">
      		<a href="<?php echo get_permalink($item->ID)?>"><?php echo esc_html( $item->post_title ); ?></a>
      		 <div class="item-description">
        	<?php 
				if ( preg_match('/<!--more(.*?)?-->/', $item->post_content, $matches) ) {
					$content = explode($matches[0], $item->post_content, 2);
					$content = $content[0];
				} else {
					$content = self::ya_trim_words($item->post_content, $length, ' ');
				}
				echo $content;
				?>
			</div>	 
		</div>		
      </div>
    </div>
    <?php } ?>
  </div>
</div>
<?php } ?>