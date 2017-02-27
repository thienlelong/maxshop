<?php  
if (!isset($instance['categories'])){
	$instance['categories'] = array();
}
extract($instance);

$categories = implode(',', $categories);
$default = array(
	'orderby' => $orderby,
	'order' => $order,
	'number' => $number,
	'include' => $categories,
	'exclude' => $exclude
);

$list = get_categories($default);

if (count($list) > 0){
?>
<div class="ya-categories">
	<ul>
		<?php foreach ($list as $category){?>
			<li><a href="<?php echo get_category_link($category->term_id)?>" ><?php echo ucfirst($category->name); ?></a></li>
		<?php } ?>
	</ul>
</div>
<?php }?>