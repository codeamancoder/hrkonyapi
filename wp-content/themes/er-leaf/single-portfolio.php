<?php get_header();?>
<?php get_template_part( 'heading' ); ?>
<div id="content-sidebar">
		<div class="wrap">
			
			<?php while ( have_posts() ) : the_post(); ?>
			
			<?php if(rwmb_meta( 'er_leaf_project_images', 'type=file' )): ?>
			<div class="portfolio-slide">
				<div class="slider flexslider">
				  	<ul class="slides">
				  		<?php
				  			$count = '';
				  			$out = '';     
				  			$portfolio_images = rwmb_meta( 'er_leaf_project_images', 'type=file' );
						    foreach ( $portfolio_images as $slides ) {
						    	if($slides['url'] != '')
						    	$out .=  '<li><img src="'.$slides['url'].'"/></li>';
						    	$count++;
						    };
						    echo $out;
						?>
				  	</ul>
				</div>
			</div><!-- // .portfolio-slide -->
			<?php endif; ?>
			
			<div class="cols">

				<div class="col-7" id="content">
					<div class="heading-block">
						<h4><?php _e('Proje açıklama','er_leaf');?></h4>
					</div><!-- // .heading-block -->
					<?php echo rwmb_meta('er_leaf_project_detail');?>
				</div><!-- // .content -->

				<div class="col-4 offset-1" id="sidebar">
					<div class="heading-block">
						<h4><?php _e('Proje detay','er_leaf');?></h4>
					</div><!-- // .heading-block -->
					<ul class="portfolio-infomations">
						<li>
							<span class="title">
								<?php _e('Kategori','er_leaf');?>
							</span>
							<span class="info">
								<?php echo er_leaf_custom_taxonomies_terms_links('portfolio_category');?>
							</span>
						</li>
						<li>
							<span class="title">
								<?php _e('Etiket','er_leaf');?>
							</span>
							<span class="info">
								<?php echo er_leaf_custom_taxonomies_terms_links('portfolio_tag');?>
							</span>
						</li>
						<?php if(rwmb_meta('er_leaf_project_release_date')): ?>
						<li>
							<span class="title">
								<?php _e('Yapım tarihi','er_leaf');?>
							</span>
							<span class="info">
								<?php echo rwmb_meta('er_leaf_project_release_date');?>
							</span>
						</li>
						<?php endif; ?>

						<?php if(rwmb_meta('er_leaf_project_author')): ?>
						<li>
							<span class="title">
								<?php _e('Firma','er_leaf');?>
							</span>
							<span class="info">
								<?php echo rwmb_meta('er_leaf_project_author');?>
							</span>
						</li>
						<?php endif; ?>

						<?php if(rwmb_meta('er_leaf_project_partner')): ?>
						<li>
							<span class="title">
								<?php _e('Yatırımcı','er_leaf');?>
							</span>
							<span class="info">
								<?php echo rwmb_meta('er_leaf_project_partner');?>
							</span>
						</li>
						<?php endif;?>

						<?php if(rwmb_meta('er_leaf_project_customer')): ?>
						<li>
							<span class="title">
								<?php _e('Müşteri','er_leaf');?>
							</span>
							<span class="info">
								<?php echo rwmb_meta('er_leaf_project_customer');?>
							</span>
						</li>
						<?php endif; ?>

						<?php echo rwmb_meta('er_leaf_project_custom_field') ? apply_filters( 'the_content', rwmb_meta('er_leaf_project_custom_field') ) : '' ; ?>

					</ul><!-- // .portfolio-infomations -->
					
					<?php if(rwmb_meta('er_leaf_project_link')): ?>
					<div class="top-10 portfolio-single-link">

						<a class="button color" href="<?php echo rwmb_meta('er_leaf_project_link');?>">View Project</a>
						
					</div><!-- // .portfolio-single-link -->
					<?php endif; ?>

				</div><!-- // #sidebar -->
			</div><!-- // .cols -->
			
			<?php if ( get_the_content() ): ?>
			<div class="project-custom-info">
				<div class="heading-block">
					<h4><?php _e('Proje detay','er_leaf');?></h4>
				</div><!-- // .heading-block -->

				<?php the_content();?>

			</div><!-- // .project-custom-info -->
			<?php endif; ?>

			<?php endwhile; ?>

			<?php
				$relates_project = array(   
			    	'post__not_in' => array($post->ID),
			    	'showposts'=> 8,
			    	'post_type' => 'portfolio'
			    );
			    $relates = new WP_Query( $relates_project );
			    if($relates->have_posts()) :
			?>	

			<div class="recent-projects">
				<div class="heading-block">
					<h4><?php _e('Diğer Projeler','er_leaf'); ?></h4>
					<div class="button-area">
						<a href="#" class="prev" id="rp_prev"><i class="icon-angle-left"></i></a>
						<a href="#" class="next" id="rp_next"><i class="icon-angle-right"></i></a>
					</div>
				</div><!-- // .heading-block -->

				<div class="cols portfolio-cr recent-portfolio" id="recent-portfolio">
					<?php while($relates->have_posts()):$relates->the_post();?>
						<div class="col-3">
						<?php get_template_part( 'content','portfolio' ); ?>
						</div>
					<?php endwhile;?>
				</div><!-- // #recent-portfolio -->

			</div><!-- // .recent-projects -->

			<script type="text/javascript">
				jQuery(document).ready(function($){
					function imageCarousel() {

						var carousel =  $('.portfolio-cr');
						var width = $(window).width();
						if(width <=220) {
						     carousel.trigger('destroy');
						}
						else {
							carousel.carouFredSel({
								auto: false,
								responsive: false,
								height : 'auto',
								scroll: {
								    items : 1
								},
								prev	: {
									button	: "#rp_prev",
									key		: "left",
									items   : 1
								},
								next	: {
									button	: "#rp_next",
									key		: "right",
									items   : 1
								},
								items : {
								    visible     : 4,
								    width       : "100%"
								},
							    onCreate : function () {
							        carousel.parent().add(carousel).css('height', carousel.children().first().height() + 'px');
							    }
							});
						}
					};

						var resizeTimer;

						$(window).resize(function() {
						    clearTimeout(resizeTimer);
						    resizeTimer = setTimeout(imageCarousel, 0);
						}).resize();
					});
				</script>

			<?php endif; wp_reset_query(); ?>

		</div><!-- // .wrap -->
	</div><!-- // #content-sidebar -->
<?php get_footer();?>