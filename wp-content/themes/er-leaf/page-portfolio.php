<?php
/*
Template Name: Portfolio
*/
	get_header();
	get_template_part( 'heading' );
?>
	<div id="fullwidth">
		<div class="wrap">
			<div class="cols">
				<div class="col-12 portfolio-archive" id="content">

					<?php if ( have_posts() ): ?>
					<article id="page-<?php the_ID(); ?>" <?php post_class('blog-item'); ?>>

						<div class="blog-item-content">

							<?php while ( have_posts() ) : the_post(); ?>

							<div class="entry-content">
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'er_leaf' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
							</div>

							<?php endwhile; wp_reset_query(); ?>

						</div><!-- // .blog-item-content -->

					</article>
					<?php endif; ?>
					
					<?php if(rwmb_meta('er_leaf_portfolio_enable_filter') == '1'): ?>
					<div class="portfolio-navigations">
						<ul data-option-key="filter" id="options" class="clearfix option-set">
							<li><a data-option-value="*" href="#filter" class="selected"><?php _e('Tümü','er_leaf');?></a></li>
							
							<?php
								$terms = get_terms('portfolio_category');
							    foreach ( $terms as $term ) {
							       echo '<li><a data-option-value=".'.$term->slug.'" href="#filter">' . $term->name . '</a></li>';
							    }
							?>

						</ul>
					</div>
					<?php endif;?>

					<div class="cols" id="<?php echo rwmb_meta('er_leaf_portfolio_enable_filter') == '1' ? 'portfolio-filter' : '' ;?>">
						<div class="clearfix">
					<?php
						global $wp_query;
						$portfolioitems = rwmb_meta('er_leaf_portfolio_item_per_page'); // Get Items per Page Value
						$columformat = rwmb_meta('er_leaf_portfolio_columns'); // Get Items Columns
						$paged = get_query_var('paged') ? get_query_var('paged') : 1;
						$args = array(
							'post_type' 		=> 'portfolio',
							'posts_per_page' 	=> $portfolioitems,
							'post_status' 		=> 'publish',
							'orderby' 			=> 'date',
							'order' 			=> 'DESC',
							'paged' 			=> $paged
						);
						
						$wp_query = new WP_Query($args);
						
						while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

							<div class="<?php echo $columformat; ?> element <?php echo er_leaf_custom_taxonomies_terms_slug('portfolio_category');?>">
								<?php get_template_part( 'content','portfolio' ); ?>
							</div><!-- // portfolio item -->

						<?php endwhile;?>

						</div>

					</div><!-- // #portfolio-filter -->

					<?php er_leaf_pagenavi();?>

				</div><!-- // #content -->
				
			</div><!-- // .cols -->
		</div><!-- // .wrap -->
	</div><!-- // #fullwidth -->
<?php get_footer();?>