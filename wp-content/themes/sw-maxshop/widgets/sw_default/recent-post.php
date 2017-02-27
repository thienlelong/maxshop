<?php  
extract($instance);

$default = array(
	'order' => $order,
	'post_status' => 'publish',
	'numberposts' => $number
);

$list = get_posts($default);
//var_dump($list);
if (count($list) > 0){
?>
<div class="sw-recent">
	<?php foreach ($list as $posts){ ?>
	<div class="sw-recent-content">
		<img src="<?php echo get_template_directory_uri().'/assets/img/icon-edit.png'; ?>" alt="<?php echo get_the_title($posts->ID); ?>"/>
		<div class="sw-recent-detail">
			<div class="item-title">
				<a href="<?php echo get_the_permalink($posts->ID); ?>" title="<?php the_title_attribute();?>"><?php echo get_the_title($posts->ID); ?></a>
			</div>
			<div class="item-date">
				<?php echo date('l j F Y', strtotime( $posts->post_date )); ?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<?php }?>