<div id="top-widget" class="top-widget">
	<div class="wrap widget-content" style="height:0">
		<div class="top-widget-container">
			<div class="cols">

				<?php if ( get_theme_mod('topbar_widget_1_width') != 'Disable' ) : ?>
				<div id="top-widget-1" class="<?php echo get_theme_mod('topbar_widget_1_width');?>">
					<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Top Bar 1')); ?>
				</div>
				<?php endif; ?>

				<?php if ( get_theme_mod('topbar_widget_2_width') != 'Disable' ) : ?>
				<div id="top-widget-2" class="<?php echo get_theme_mod('topbar_widget_2_width');?>">
					<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Top Bar 2')); ?>
				</div>
				<?php endif; ?>

				<?php if ( get_theme_mod('topbar_widget_3_width') != 'Disable' ) : ?>
				<div id="top-widget-3" class="<?php echo get_theme_mod('topbar_widget_3_width');?>">
					<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Top Bar 3')); ?>
				</div>
				<?php endif; ?>

				<?php if ( get_theme_mod('topbar_widget_4_width') != 'Disable' ) : ?>
				<div id="top-widget-4" class="<?php echo get_theme_mod('topbar_widget_4_width');?>">
					<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Top Bar 4')); ?>
				</div>
				<?php endif; ?>

			</div><!-- // .cols -->

			<div class="divider"></div>

			<div class="quick-search">
				<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
					<input type="text" name="s" id="s" placeholder="Arama ..." />
				</form>
			</div><!-- // .quick-search -->
			
		</div><!-- // .top-widget-container -->
	</div><!-- // .widget-content -->

	<div class="actions-top-widget">
		<div class="wrap">
			<a href="#"><?php _e('Open','er_leaf');?></a>
		</div>
	</div><!-- // .actions-top-widget -->
</div><!-- // #top-widget -->