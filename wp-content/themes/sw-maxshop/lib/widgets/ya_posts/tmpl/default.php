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
if (count($list) > 0){
?>
<div class="widget-category">
	<ul>
		<?php foreach ($list as $post){?>
			<li><a href="<?php echo get_get_permalink($post->ID)?>" ><?php echo ucfirst($post->post_title); ?></a></li>
		<?php } ?>
	</ul>
</div>
<?php }?>