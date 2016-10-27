<?php $custom_class= ''; get_theme_mod('select_bloglayout') == 'Blog Mansory' ? $custom_class = ' col-4' : ''; ?>

<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item bb'.$custom_class); ?>>

	<?php do_action( 'er_before_post') ;?>

	<div class="blog-item-content">
		<h4 class="entry-title">
			<a rel="bookmark" title="<?php the_title(__(' ','er_leaf')); ?>" href="<?php the_permalink();?>"><?php the_title();?></a>
		</h4><!--// .entry-title -->

		<?php er_post_info('entry-meta separate');?>

		<div class="entry-summary">
			<?php the_excerpt();?>
		</div><!--// .entry-summary -->

		<a rel="bookmark" href="<?php the_permalink();?>" title="<?php the_title(__(' ','er_leaf')); ?>" class="button"><?php _e('Devamı','er_leaf');?></a>
	</div><!--// .blog-item-content -->

	<?php do_action( 'er_after_post' ) ;?>

</div><!--// .blog-item.bb -->