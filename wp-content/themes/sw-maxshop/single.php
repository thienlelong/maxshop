
<?php get_template_part('header'); ?>
<?php $sidebar_template = ya_options()->getCpanelValue('sidebar_blog') ;?>
	<div class="container">
		<div class="row">
<?php if ( is_active_sidebar_YA('left-blog') && $sidebar_template != 'right_sidebar' && $sidebar_template !='full' ):
	$left_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_left_expand');
	$left_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_left_expand_sm');
?>
<aside id="left" class="sidebar <?php echo esc_attr($left_span_class); ?>">
	<?php dynamic_sidebar('left-blog'); ?>
</aside>

<?php endif; ?>

<div class="single main <?php ya_content_blog(); ?>" >
	<?php 
	get_template_part('templates/content', 'single');
	?>
</div>
<?php if ( is_active_sidebar_YA('right-blog') && $sidebar_template !='left_sidebar' && $sidebar_template !='full' ):
	$right_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_right_expand');
	$right_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_right_expand_sm');
?>
<aside id="right" class="sidebar <?php echo esc_attr($right_span_class); ?>">
	<?php dynamic_sidebar('right-blog'); ?>
</aside>
<?php endif; ?>
</div>	
</div>
</div>
<?php get_template_part('footer'); ?>
