<?php 
	get_theme_mod('select_blogsidebar') == 'sidebar-left' ? $layout_id = 'sidebar-content' : $layout_id = 'content-sidebar';
	get_theme_mod('select_bloglayout') == 'Blog Mansory' ? $layout_out = 'page-full-width' : $layout_out =  $layout_id;
	get_theme_mod('select_bloglayout') == 'Blog Mansory' ? $blog_col = 'third mansonry clearfix' : $blog_col = 'col-8';
	get_theme_mod('select_bloglayout') == 'Blog Medium' ? $blog_style = ' second' : $blog_style = '';
?>

<?php get_header();?>

	<?php get_template_part( 'heading' );?>

	<div id="<?php echo $layout_out; ?>">
		<div class="wrap">
			<div class="cols">
				<div class="<?php echo $blog_col.$blog_style; ?>" id="content">
					
					<?php if(get_theme_mod('select_bloglayout') == 'Blog Mansory') : ?>
					<div class="mansory">
					<?php endif;?>

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'blog' );?>
					<?php endwhile;?>

					<?php if(get_theme_mod('select_bloglayout') == 'Blog Mansory') : ?>
					</div>
					<?php endif;?>
					
					<?php er_leaf_pagenavi(); ?>
					
				</div> <!--// #content -->

				<?php if(get_theme_mod('select_bloglayout') != 'Blog Mansory') : ?>
					<?php get_sidebar();?>
				<?php endif; ?>

			</div><!--// .cols -->
		</div><!--// .wrap -->
	</div><!--// id -->

<?php get_footer();?>
