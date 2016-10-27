	
	<footer>
		<div class="wrap">
			
			<?php if(get_theme_mod("social_twitter") && get_theme_mod('check_footertweet')): ?>
			<div class="twitter-bar">
				<ul class="no-margin tweets-list-container" id="twitter-feed">
					
				</ul>
			
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#twitter-feed').tweet({
						    modpath: '<?php echo get_template_directory_uri();?>/js/twitter/',
						    count: 1,
						    username: '<?php echo get_theme_mod("social_twitter"); ?>',
						    loading_text: 'loading twitter feed...',
						    template: "{text}{time}{join}"
						});
					});
				</script>

			</div><!-- .twitter-bar -->
			<?php endif;?>
			
			<?php if(get_theme_mod('footer_widget_1_width') != 'Disable' && get_theme_mod('footer_widget_2_width') != 'Disable' && get_theme_mod('footer_widget_3_width') != 'Disable' && get_theme_mod('footer_widget_4_width') != 'Disable'  ) : ?>
			
			<?php if(!get_theme_mod("social_twitter")): ?>
			<div class="top-30"></div>
			<?php endif;?>
			
			<div class="footer-widget-area">
				<div class="cols">
					
					<?php if(get_theme_mod('footer_widget_1_width') != 'Disable' ) : ?>
					<div id="footer-widget-1" class="widget <?php echo get_theme_mod('footer_widget_1_width');?>">
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 1')); ?>
					</div><!-- // #footer-widget-1 -->
					<?php endif; ?>

					<?php if(get_theme_mod('footer_widget_2_width') != 'Disable' ) : ?>
					<div id="footer-widget-2" class="widget <?php echo get_theme_mod('footer_widget_2_width');?>">
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 2')); ?>
					</div><!-- // #footer-widget-2 -->
					<?php endif; ?>

					<?php if(get_theme_mod('footer_widget_3_width') != 'Disable' ) : ?>
					<div id="footer-widget-3" class="widget <?php echo get_theme_mod('footer_widget_3_width');?>">
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 3')); ?>
					</div><!-- // #footer-widget-3 -->
					<?php endif; ?>
					
					<?php if(get_theme_mod('footer_widget_4_width') != 'Disable' ) : ?>
					<div id="footer-widget-4" class="widget <?php echo get_theme_mod('footer_widget_4_width');?>">
						<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer 4')); ?>
					</div><!-- // #footer-widget-4 -->
					<?php endif; ?>

				</div><!-- .cols -->
			</div><!-- .footer-widget-area -->
			<?php endif;?>

		</div><!-- .wrap -->

		<div class="credit">
			<div class="wrap">
				<div class="cols">
					
					<div id="copyright" class="col-6 copyright">
						<p class="no-margin"><?php echo get_theme_mod('textarea_copyright') ? get_theme_mod('textarea_copyright') : 'Design by <a target="_blank" href="http://everislabs.com">EverisLabs</a>. Powered by <a target="_blank" href="http://wordpress.org">WordPress</a>.';?></p>
					</div><!-- // #copyright -->
					
					<div id="footer-menu" class="col-6">
						<nav class="footer-menu">
							<?php wp_nav_menu( array(
								'theme_location'  => 'footer',
								'container'       => 'ul', 
								'container_class' => 'menu-{menu slug}-container', 
								'depth'           => 1 ) );
							?>
						</nav>
					</div><!-- // #footer-menu -->

				</div><!-- // .col -->

			</div><!-- .wrap -->
		</div><!-- .credit -->
	</footer><!-- footer -->
</div><!-- .container -->
<?php wp_footer();?>
</body>
</html>