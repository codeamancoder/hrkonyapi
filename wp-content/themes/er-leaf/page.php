<?php get_header();?>
	
	<?php
		$slider = rwmb_meta('er_leaf_revolutionslider');
		if($slider && $slider == 'Flex Slider'){
			er_leaf_show_slide();
		}

		elseif($slider && $slider != 'Flex Slider' && $slider != 'No Slider'){ ?>
	<div class="slide">
		<?php putRevSlider( $slider ); ?>
	</div>
	<?php		
			}
	?>

	<?php echo rwmb_meta('er_leaf_page_heading') == '1' ? get_template_part( 'heading' ) : '<div class="no-heading"></div>' ; ?>
	
	<div id="<?php echo rwmb_meta('er_leaf_page_sidebar') ? rwmb_meta('er_leaf_page_sidebar') : 'content-sidebar' ;?>">
		<div class="wrap">
			<div class="cols">
				<div class="col-<?php echo rwmb_meta('er_leaf_page_sidebar') == 'fullwidth' ? '12' : '8' ;?>" id="content">
					<article id="page-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>

						<div class="blog-item-content">

							<?php while ( have_posts() ) : the_post(); ?>
							
							<?php if(rwmb_meta('er_leaf_page_title') == '1') : ?>
							<h1 class="entry-title">
								<?php the_title(); ?>
							</h1>
							<?php endif; ?>

							<div class="entry-content clearfix">
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'er_leaf' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
							</div>

							<?php edit_post_link(__('Edit','er_leaf'), '<span class="edit clearfix">', '</span>'); ?>

							<?php rwmb_meta('er_leaf_page_share') == '1' ? er_post_share() : '' ; ?>
							
							<?php endwhile; ?>

						</div><!-- // .blog-item-content -->

					</article>
					<?php comments_template(); ?>
				</div><!-- // #content -->

				<?php echo rwmb_meta('er_leaf_page_sidebar') == 'fullwidth' ? '' : get_sidebar(); ?>
				
			</div>
		</div>
	</div>
<?php get_footer();?>