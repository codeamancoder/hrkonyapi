	<div id="portfolio-<?php the_ID(); ?>" class="portfolio-item">
		<div class="portfolio-content">

			<div class="portfolio-link" >
				<?php if(er_leaf_get_firt_meta_image('er_leaf_project_images')): ?>
				<a href="<?php echo er_leaf_get_firt_meta_image('er_leaf_project_images');?>" class="image-link"><i class="icon-zoom-in"></i></a>
				<?php endif; ?>
				<a href="<?php the_permalink();?>" class="detail-link"><i class="icon-link"></i></a>
			</div><!--// portfolio-link -->

			<div class="portfolio-title">
				<h5><?php the_title();?></h5>
				<span><?php echo er_leaf_custom_taxonomies_terms_links('portfolio_category');?></span>
			</div><!--// portfolio-title -->

		</div><!--// portfolio-content -->

		<div class="portfolio-image">
			<?php the_post_thumbnail('portfolio');?>
		</div><!--// portfolio-image -->

	</div><!--// portfolio-item -->