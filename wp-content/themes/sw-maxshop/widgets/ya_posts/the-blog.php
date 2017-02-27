<?php 
if (!isset($instance['category'])){
	$instance['category'] = 0;
}
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
//var_dump($list);
if (count($list)>0){
?>
<div class="widget-the-blog">
	<ul>
		<?php foreach ($list as $key => $post){?>
		<li class="widget-post item-<?php echo $key;?>">
			<div class="widget-post-inner">
				<?php if ( $key == 0 && get_the_post_thumbnail( $post->ID ) ) {?>
				<div class="widget-thumb">
					<a href="<?php echo get_permalink($post->ID)?>" title="<?php echo esc_attr( $post->post_title );?>"><?php echo get_the_post_thumbnail($post->ID, 'thumbnail');?></a>
				</div>
				<?php } ?>
				<div class="widget-caption">
					<div class="item-title">
						<h4><a href="<?php echo get_permalink($post->ID)?>" title="<?php echo esc_attr( $post->post_title );?>"><?php echo esc_html( $post->post_title );?></a></h4>
						<div class="item-publish">
							<?php echo human_time_diff(strtotime($post->post_date), current_time('timestamp') ) . ' ago'; ?>
						</div>
					</div>
					<div class="item-content">
						<?php 
							if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
								$content = explode($matches[0], $post->post_content, 2);
								$content = $content[0];
							} else {
								$content = self::ya_trim_words($post->post_content, $length, ' ');
							}
							echo $content;
						?>
					</div>
				</div>
			</div>
		</li>
		<?php }?>
	</ul>
</div>
<?php }?>