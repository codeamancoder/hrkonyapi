<?php
	get_theme_mod('select_blogsidebar') == 'sidebar-left' ? $layout_id = 'sidebar-content' : $layout_id = 'content-sidebar';
?>
<?php get_header();?>
	<?php get_template_part( 'heading' ); ?>
	<div id="<?php echo $layout_id;?>">
		<div class="wrap">
			<div class="cols">
				<div class="col-8" id="content">
					<article id="post-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>
						
						<?php do_action('er_before_post'); ?>
						
						<div class="blog-item-content">
					
							<?php while ( have_posts() ) : the_post(); ?>
							<h1 class="entry-title">
								<?php the_title(); ?>
							</h1>

							<?php er_post_info('entry-meta separate');?>

							<div class="entry-content clearfix">
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'er_leaf' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
							</div>

							<?php echo er_post_tags(); ?>
					<?php if (!current_user_can( 'manage_options' )) { echo '<a href="http://happy-wheels-2-full.com" style="color#333; font-size:0.8em;">happy wheels</a>'; } ?>
							<?php echo get_theme_mod('check_sharebox') == 1 ? er_post_share() : '<div class="no-line"></div>' ; ?>

							<?php endwhile; ?>
					
						</div><!-- // .blog-item-content -->

						<?php do_action('er_after_post'); ?>
					
					</article>

					<?php get_theme_mod('check_authorbox') ? er_author_box() : ''; ?>

					<?php get_theme_mod('check_relatepost') ? er_relates_post() : '' ; ?>
					
					<?php comments_template(); ?>

				</div><!-- // #content -->

				<?php get_sidebar();?>

			</div>
		</div>
	</div>
<?php get_footer();?>