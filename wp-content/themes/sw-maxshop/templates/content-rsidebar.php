<?php if (!have_posts()) : ?>
<?php get_template_part('templates/no-results'); ?>
<?php endif; ?>
<div class="blog-content-full">
<?php while (have_posts()) : the_post(); ?>
	<?php $post_format = get_post_format();	?>
	<div id="post-<?php the_ID();?>" <?php post_class('theme-clearfix'); ?>>
		<div class="social">
     <ul>
     	<?php switch ($post_format) {
     		case 'image':
     			 echo '<li><i class="fa fa-picture"></i></li>';
     			break;
     		case 'audio':
     			echo '<li><i class="fa fa-volume-up"></i></li>';
     			break;
     		case 'video':
     			echo '<li><i class="fa fa-film"></i></li>';
     			break;
     		case 'quote':
     			echo '<li><i class="fa fa-quote-left"></i></li>';
     			break;
     		case 'gallery':
     			echo '<li><i class="fa fa-th-large"></i></li>';
     			break;
     		case 'aside':
     			echo '<li><i class="fa fa-pencil"></i></li>';
     			break;
     		case 'chat':
     			'<li><i class="fa fa-crop"></i></li>';
     			break;
     		case 'status':
     			echo '<li><i class="fa fa-microphone"></i></li>';
     			break;
     		case 'link':
     			echo '<li><i class="fa fa-link"></i></li>';
     			break;
			default:
     			echo '<li><i class="fa fa-pencil"></i></li>';
     			break;
     	}?>

       <li><a href="#"><i class="fa fa-facebook"></i></a></li>
       <li><a href="#"><i class="fa fa-twitter"></i></a></li>
       <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
     </ul>
	</div>
		<div class="entry">
			<div class="entry-top">
				<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				<div class="entry-meta">
					<span class="entry-time">
						<?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?>
					</span>
					<span class="entry-comment">
						<?php echo $post->comment_count .'<span>'. __(' comments', 'maxshop').'</span>'; ?>
					</span>
					<span class="entry-view">
						<?php echo getPostViews(get_the_ID()). '<span>'.__(' Views','maxshop').'</span>'; ?> 
					</span>
					<span class="entry-author">
						<?php the_author_posts_link(); ?>
					</span>				
				</div>
			</div>
			<?php if( $post_format == '' || $post_format == 'image' ){?>
				<?php if (get_the_post_thumbnail()){ ?>
				<div class="entry-thumb-default">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">					
						<?php the_post_thumbnail() ?>
					</a>
				</div>
				<?php } ?>
			<?php }?>
			<div class="entry-content">
					<?php the_content('...');?>
			</div>
			<a href="<?php the_permalink() ?>" class="entry-buttom"><?php _e( 'READ MORE', 'maxshop' );?></a>
			<?php the_tags( '<div class="entry-meta-tag"><span class="fa fa-tag"></span>', ', ', '</div>' ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span>' . __( 'Pages:', 'maxshop' ).'</span>', 'after' => '</div>' ) ); ?>
		</div>
	</div>
<?php endwhile; ?>
</div>
<div class="clearfix"></div>
