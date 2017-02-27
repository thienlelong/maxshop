<?php  
extract($instance);

$default = array(
	'order' => $order,
	'number' => $number,
	'status' => 'approve', 
	'post_status' => 'publish'
);

$list = get_comments($default);
//var_dump($list);
if (count($list) > 0){
?>
<div class="ya-comments">
	<?php foreach ($list as $comment){ ?>
	<div class="ya-comment">
		<div class="sw-content"><?php echo self::ya_trim_words($comment->comment_content, $length)?></div>
		<div class="comment-author">
			<span><?php _e('Written by', 'maxshop');?></span>: <a href="<?php echo get_comment_author_link( $comment->comment_ID ); ?>"><?php echo get_comment_author( $comment->comment_ID );?></a>
		</div>
	</div>
	<?php } ?>
</div>
<?php }?>