<?php 
	if ( get_theme_mod('select_portfolio_archive') == "2 Columns" ){
		$col = '6';
	} elseif (get_theme_mod('select_portfolio_archive') == "3 Columns" ){
		$col = '4';
	} else {
		$col = '3';
	}; 
?>
<?php get_header();?>
	<?php get_template_part( 'heading' );?>
	<div id="content-full-width">
		<div class="wrap">
			<div id="content" class="portfolio-archive">
				<div class="cols">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="col-<?php echo $col; ?>">
					<?php get_template_part( 'content', 'portfolio' );?>
					</div>
				<?php endwhile;?>
				</div>
			</div><!--// #content -->
		</div><!--// .wrap -->
	</div><!--// #content-full-width -->
<?php get_footer();?>