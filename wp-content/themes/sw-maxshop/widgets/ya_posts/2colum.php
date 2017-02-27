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
	<?php if ( $key == 0 && get_the_post_thumbnail( $post->ID ) ) {?>
		<li class="widget-post item-<?php echo $key;?>">
			<div class="widget-post-inner">
				
				<div class="widget-thumb">
					<a href="<?php echo get_permalink($post->ID)?>" title="<?php echo esc_attr( $post->post_title );?>"><?php echo get_the_post_thumbnail($post->ID, 'medium');?></a>
				</div>
				
				<div class="widget-caption">
					<div class="item-title">
						<h4><a href="<?php echo get_permalink($post->ID)?>" title="<?php echo esc_attr( $post->post_title );?>"><?php echo esc_html( $post->post_title );?></a></h4>
						<div class="entry-meta">
					<span class="entry-time">
						<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?>
					</span>
					<span class="entry-comment">
						<?php echo '<i class="fa fa-comment"></i>'.$post->comment_count .'<span>'. __(' comments', 'maxshop').'</span>'; ?>
					</span>
					<span class="entry-author">
						<i class="fa fa-user"></i> <?php the_author_posts_link(); ?>
					</span>				
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
							echo esc_html( $content );
						?>
					</div>
				</div>
			</div>
		</li>
		<?php } else {?>
		<li class="widget-post item-<?php echo $key;?>">
			<div class="widget-post-inner">
					<div class="widget-caption">
					<div class="item-title">
						<h4><a href="<?php echo get_permalink($post->ID)?>" title="<?php echo esc_attr( $post->post_title );?>"><?php echo esc_html( $post->post_title );?></a></h4>
						<div class="item-publish">
							<?php echo human_time_diff(strtotime($post->post_date), current_time('timestamp') ) . ' ago'; ?>
						</div>
					</div>
				</div>
			</div>
		</li>
		<?php } ?>
		<?php }?>
	</ul>
</div>
<?php }?>