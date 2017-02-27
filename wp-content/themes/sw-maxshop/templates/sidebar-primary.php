<?php if ( is_active_sidebar_YA('primary') ):
	$primary_span_class = 'span'.ya_options()->getCpanelValue('sidebar_primary_expand');
?>
<aside id="primary" class="sidebar <?php echo esc_attr($primary_span_class); ?>">
	<?php dynamic_sidebar('primary'); ?>
</aside>
<?php endif; ?>