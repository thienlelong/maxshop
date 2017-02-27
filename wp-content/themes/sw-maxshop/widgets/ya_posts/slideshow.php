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
<div id="<?php echo esc_attr( $widget_id ); ?>" class="carousel slide content" data-ride="carousel">
  <div class="carousel-inner">
  <?php foreach( $list as $i => $item ){  	?>
    <div class="item<?php if( $i == 0 ){ echo ' active'; }?>">
     

      <div class="carousel-caption">
      	<div class="carousel-caption-inner">
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
  <!-- Controls -->
  	<div class="carousel-cl">
		<a class="left carousel-control" href="#<?php echo esc_attr( $widget_id ); ?>" role="button" data-slide="prev"></a>
		<a class="right carousel-control" href="#<?php echo esc_attr( $widget_id ); ?>" role="button" data-slide="next"></a>
	</div>
</div>
<?php } ?>