<?php

/**
* Get custom CSS data
*
*/
	function hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   return $rgb; 
	}

	function rgb2hex($r, $g, $b) {
		$hex = "#";
		$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
		$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
		 
		return $hex;
	}

	function er_leaf_custom_style(){ 
		$color = get_theme_mod('color_general');
		$color_aj = hex2rgb($color);
	?>
/* Custom Font */

<?php echo er_leaf_google_font(); ?>

/* Background */

body{
<?php if(get_theme_mod('select_layoutstyle') == 'Boxed Layout') { ?>

	<?php if(get_theme_mod('color_bg')): ?>
	background-color: <?php echo get_theme_mod('color_bg');?>;
	<?php endif;?>
	<?php if(get_theme_mod('media_bg')): ?>
	background: url('<?php echo do_shortcode(get_theme_mod('media_bg'));?>');
	<?php endif;?>

	<?php if(get_theme_mod('select_bg') == 'Stretch Image'):?>
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	<?php else: ?>
	background-repeat: <?php echo get_theme_mod('select_bg');?>;
	<?php endif;?>


<?php } ?>

<?php 
	$body_font = get_theme_mod('font_body');

	$heading1 = get_theme_mod('font_h1');
	$heading2 = get_theme_mod('font_h2');
	$heading3 = get_theme_mod('font_h3');
	$heading4 = get_theme_mod('font_h4');
	$heading5 = get_theme_mod('font_h5');
	$heading6 = get_theme_mod('font_h6');

	$widget_title_font = get_theme_mod('font_widget_title');
	$widget_border = get_theme_mod('border_top_widget_title');
	$widget_content = get_theme_mod('font_sidebar_widget');
	$footer_widget = get_theme_mod('font_footerheadline');
	$font_nav = get_theme_mod('font_nav');
	$callus_font = get_theme_mod('font_callus');
	$top_widget = get_theme_mod('font_top_widget_heading');
?>

<?php if( $body_font['face'] || $body_font['size'] || $body_font['style'] || $body_font['color'] ) { ?>
	<?php if($body_font['face']): ?>
	font-family: <?php echo $body_font['face']; ?>;
	<?php endif;?>
	<?php if($body_font['size']): ?>
	font-size: <?php echo $body_font['size']; ?>; 
	<?php endif;?>
	<?php if($body_font['style']): ?>
	font-weight: <?php echo $body_font['style']; ?>; 
	<?php endif;?>
	<?php if($body_font['color']): ?>
	color: <?php echo $body_font['color']; ?>;
	<?php endif; ?>

<?php } ?>

}


/* Style Generation */
a:hover{
	color: <?php echo $color; ?>
}
header{
	border-top-color: <?php echo $color; ?>;
}
header #header .site-menu ul > li.sfHover > a,
header #header .site-menu ul > li.current-menu-item > a,
header #header .site-menu ul > li > a:hover{
	color: <?php echo $color; ?>;
	border-bottom-color: <?php echo $color; ?>;
}
.top-widget .actions-top-widget a{
	border-top-color: <?php echo $color; ?>;
}
.top-widget.active .actions-top-widget a{
	border-bottom-color: <?php echo $color; ?>;
}
.callout.color{
	background: <?php echo $color; ?>;
	border-color: <?php echo rgb2hex($color_aj[0]+'3',$color_aj[1]+'3',$color_aj[2]+'3');?>;
	background: -webkit-linear-gradient(top, <?php echo $color; ?> 0%, rgba(<?php echo $color_aj[0].','.$color_aj[1].','.$color_aj[2];?>,0.5) 100%);?> /* Chrome 10+, Safari 5.1+ */
	background:   linear-gradient(to bottom, <?php echo $color; ?> 0%, rgba(<?php echo $color_aj[0].','.$color_aj[1].','.$color_aj[2];?>,0.5) 100%);?> /* W3C */
}
.menu-vertical ul li:hover a{
	background: <?php echo $color; ?>;
	border-color: <?php echo $color; ?>;
}
footer .widget.widget_tag_cloud a:hover,
.flickr-widget clearfix a:hover {
	border-color: <?php echo $color; ?>;
}
.user:hover{
	background: <?php echo $color; ?>;
	border-color: <?php echo rgb2hex($color_aj[0]+'3',$color_aj[1]+'3',$color_aj[2]+'3');?>;
}
footer button:hover,
footer input[type=submit]:hover,
.pagenavi span.current,
.button.color{
	background: <?php echo $color; ?>;
	border-color:<?php echo rgb2hex($color_aj[0]+'5',$color_aj[1]+'5',$color_aj[2]+'5');?>;
	background: -webkit-linear-gradient(top, rgba(<?php echo $color_aj[0]+'5'.','.$color_aj[1].','.$color_aj[2];?>) 0%, <?php echo $color; ?> 100%); /* Chrome 10+, Safari 5.1+ */
	background:   linear-gradient(to bottom, rgba(<?php echo $color_aj[0]+'5'.','.$color_aj[1].','.$color_aj[2];?>) 0%, <?php echo $color; ?> 100%); /* W3C */
}
.button.color:hover{
	background: <?php echo $color; ?>;
	background: -webkit-linear-gradient(top, <?php echo rgb2hex($color_aj[0]-'5',$color_aj[1]-'5',$color_aj[2]-'5');?>;) 0%, <?php echo $color; ?> 100%); /* Chrome 10+, Safari 5.1+ */
	background:   linear-gradient(to bottom, <?php echo rgb2hex($color_aj[0]-'5',$color_aj[1]-'5',$color_aj[2]-'5');?>;) 0%, <?php echo $color; ?> 100%); /* W3C */
	border-color: <?php echo rgb2hex($color_aj[0]-'5',$color_aj[1]-'5',$color_aj[2]-'5');?>;
}
footer .widget.widget_tag_cloud a:hover,
.portfolio-item .portfolio-link a:hover,
.blog-item .blog-item-image-cover .blog-item-image-cover-link a:hover,
.slide li .slide-content h4,
.content-slider .flex-direction-nav a:hover,
.portfolio-item .portfolio-title,
.portfolio-item .portfolio-link a:hover,
.skill-bar .skill-bar-content,
.blog-item .blog-item-image-cover .blog-item-image-cover-link a:hover,
footer .twitter-bar{
	background: <?php echo $color; ?>;
}

/* Heading */
h1{ font-family: <?php echo $heading1['face']; ?>, Arial, Helvetica, sans-serif; font-size: <?php echo $heading1['size']; ?>; font-weight: <?php echo $heading1['style']; ?>; color: <?php echo $heading1['color']; ?>; }
h2{ font-family: <?php echo $heading2['face']; ?>, Arial, Helvetica, sans-serif; font-size: <?php echo $heading2['size']; ?>; font-weight: <?php echo $heading2['style']; ?>; color: <?php echo $heading2['color']; ?>; }
h3{ font-family: <?php echo $heading3['face']; ?>, Arial, Helvetica, sans-serif; font-size: <?php echo $heading3['size']; ?>; font-weight: <?php echo $heading3['style']; ?>; color: <?php echo $heading3['color']; ?>; }
h4{ font-family: <?php echo $heading4['face']; ?>, Arial, Helvetica, sans-serif; font-size: <?php echo $heading4['size']; ?>; font-weight: <?php echo $heading4['style']; ?>; color: <?php echo $heading4['color']; ?>; }
h5{ font-family: <?php echo $heading5['face']; ?>, Arial, Helvetica, sans-serif; font-size: <?php echo $heading5['size']; ?>; font-weight: <?php echo $heading5['style']; ?>; color: <?php echo $heading5['color']; ?>; }
h6{ font-family: <?php echo $heading6['face']; ?>, Arial, Helvetica, sans-serif; font-size: <?php echo $heading6['size']; ?>; font-weight: <?php echo $heading6['style']; ?>; color: <?php echo $heading6['color']; ?>; }

/* Link */
a{color:<?php echo get_theme_mod('color_link'); ?>; }
a:hover{ color: <?php echo get_theme_mod('color_hover'); ?>; }


/* Topbar Widget */
.top-widget{
	background: <?php echo get_theme_mod('background_top_widget'); ?>;
	color: <?php echo get_theme_mod('color_hover'); ?>;
}

.top-widget h4{
	font-family: <?php echo $top_widget['face']; ?>, Arial, Helvetica, sans-serif; 
	font-size: <?php echo $top_widget['size']; ?>; 
	font-weight: <?php $top_widget['style']; ?>; 
	color: <?php echo $top_widget['color']; ?>;
}
.top-widget textarea,
.top-widget input{
	border-color: <?php echo get_theme_mod('color_top_widget_form_border'); ?>;
}
.top-widget textarea:focus,
.top-widget input:focus{
	border-color: <?php echo get_theme_mod('color_focus_top_widget_form_border'); ?>;
}
.top-widget label{
	color: <?php echo get_theme_mod('color_label_top_widget');?>
}
.top-widget .quick-search input{
	background: <?php echo get_theme_mod('background_top_search_input');?>;
	color: <?php echo get_theme_mod('color_top_search_input');?>;
}
.top-widget .quick-search input:focus{
	background: <?php echo get_theme_mod('background_focustop_search_input_focus'); ?>
}

/* Header */
header{
	border-top-color: <?php echo get_theme_mod('color_header_boder_top'); ?>
	background-color: <?php echo get_theme_mod('color_header_background_color'); ?>
	height: <?php echo get_theme_mod('style_headerheight'); ?>
}
header #top-info,
.header-widget .contact-widget{
	font-family: <?php echo $callus_font['face']; ?>, Arial, Helvetica, sans-serif; 
	font-size: <?php echo $callus_font['size']; ?>; 
	font-weight: <?php echo $callus_font['style']; ?>; 
	color: <?php echo $callus_font['color']; ?>;
}

/* Logo */
header #header .logo .site-title a{
	margin-top: <?php echo get_theme_mod('style_logotopmargin'); ?>;
	margin-bottom: <?php echo get_theme_mod('style_logobottommargin'); ?>;
}
/* Navigation */
header #header .site-menu ul li a{
	font-family: <?php echo $font_nav['face']; ?>, Arial, Helvetica, sans-serif; 
	font-size: <?php echo $font_nav['size']; ?>; 
	font-weight: <?php echo $font_nav['style']; ?>; 
	color: <?php echo $font_nav['color']; ?>;
}
header #header .site-menu ul li a:hover{
	color: <?php echo get_theme_mod('color_navlinkhover'); ?>;
}
header #header .site-menu ul > li.sfHover > a,
header #header .site-menu ul > li.current-menu-item > a{
	color: <?php echo get_theme_mod('color_navlinkactive'); ?>;
}
header #header .site-menu .sf-menu ul {
	background: <?php echo get_theme_mod('color_submenubg');?>;
}
header #header .site-menu .sf-menu ul li{
	border-bottom-color: <?php echo get_theme_mod('color_submenuborder'); ?>;
}
header #header .site-menu .sf-menu ul li a{
	color : <?php echo get_theme_mod('color_submenulink'); ?>;
}
header #header .site-menu .sf-menu ul li a:hover{
	color : <?php echo get_theme_mod('color_submenulinkhover'); ?>;
	background : <?php echo get_theme_mod('color_submenubghover'); ?>;
}

/* Portfolio */
.portfolio-item .portfolio-title,
.portfolio-item .portfolio-link a:hover{
	background: <?php echo get_theme_mod('color_portfolio_title_background'); ?>;
}
.portfolio-item .portfolio-title h5{
	color: <?php echo get_theme_mod('color_portfolio_title'); ?>;
}
.portfolio-item .portfolio-title a{
	color: <?php echo get_theme_mod('color_portfolio_category'); ?>;
}
.portfolio-item .portfolio-title a:hover{
	color: <?php echo get_theme_mod('color_hover_portfolio_category'); ?>;
}
/* Widget */
.widget .widget-title{
	font-family: <?php echo $widget_title_font['face']; ?>, Arial, Helvetica, sans-serif; 
	font-size: <?php echo $widget_title_font['size']; ?>; 
	font-weight: <?php echo $widget_title_font['style']; ?>; 
	color: <?php echo $widget_title_font['color']; ?>;
	border-top: <?php echo $widget_border['width']; ?> <?php echo $widget_border['style']; ?> <?php echo $widget_border['color']; ?>; 
	border-bottom: <?php echo $widget_border['width']; ?> <?php echo $widget_border['style']; ?> <?php echo $widget_border['color']; ?>; 
}
.widget .widget-content{
	font-family: <?php echo $widget_content['face']; ?>, Arial, Helvetica, sans-serif; 
	font-size: <?php echo $widget_content['size']; ?>; 
	font-weight: <?php echo $widget_content['style']; ?>; 
	color: <?php echo $widget_content['color']; ?>;
}
.widget .widget-content a{
	color: <?php echo get_theme_mod('color_link_sidebar_widget'); ?>;
}
.widget .widget-content a:hover{
	color: <?php echo get_theme_mod('color_link_hover_sidebar_widget'); ?>;
}

/* Twitter Bar */
footer .twitter-bar{
	background: <?php echo get_theme_mod('background_twitter_bar'); ?>;
	color: <?php echo get_theme_mod('color_twitter_bar'); ?>;
}
footer .twitter-bar a{
	color: <?php echo get_theme_mod('color_link_twitter_bar'); ?>;
}
footer .twitter-bar a:hover{
	color: <?php echo get_theme_mod('color_link_hover_twitter_bar'); ?>;
}

/* Footer Bar */
footer{
	background-color: <?php echo get_theme_mod('color_footerbg');?>;
}
footer .footer-widget-area,
footer .footer-widget-area p{
	color: <?php echo get_theme_mod('color_footertext');?>;
}
footer .footer-widget-area a{
	color: <?php echo get_theme_mod('color_footerlink');?>;
}
footer .footer-widget-area a:hover{
	color: <?php echo get_theme_mod('color_footerlinkhover');?>;
}
footer .widget h4.widget-title{
	font-family: <?php echo $footer_widget['face']; ?>, Arial, Helvetica, sans-serif; 
	font-size: <?php echo $footer_widget['size']; ?>; 
	font-weight: <?php $footer_widget['style']; ?>; 
	color: <?php echo $footer_widget['color']; ?>;
}

/* Copyright */
footer .credit{
	background-color: <?php echo get_theme_mod('color_copyrightbg');?>;
}
footer .credit p{
	color: <?php echo get_theme_mod('color_copyrighttext');?>;
}
footer .credit a{
	color: <?php echo get_theme_mod('color_copyrightlink');?>;
}
footer .credit a:hover{
	color: <?php echo get_theme_mod('color_copyrightlinkhover');?>;
}

/* Media Element Player */
.mejs-container .mejs-controls .mejs-time,
.mejs-container .mejs-controls .mejs-time span,
.mejs-controls .mejs-captions-button .mejs-captions-selector ul li,
.mejs-chapters .mejs-chapter .mejs-chapter-block,
.mejs-captions-layer,
.mejs-captions-layer  a,
.me-cannotplay a,
.mejs-contextmenu .mejs-contextmenu-item:hover,
.mejs-controls .mejs-sourcechooser-button .mejs-sourcechooser-selector ul li,
.mejs-postroll-close{
	color: <?php echo $color; ?>
}
.mejs-controls .mejs-time-rail .mejs-time-current,
.mejs-controls .mejs-time-rail .mejs-time-handle,
.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,
.mejs-contextmenu{
	background: <?php echo $color; ?>
}
.mejs-chapters{
	-xborder-right: solid 1px <?php echo $color; ?>;
}

<?php if(get_theme_mod('media_logo_retina') != ''): ?>
@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min-device-pixel-ratio: 2) {
	header #header .logo_retina{
		display: block;
	}
	header #header .logo_standard{
		display: none;
	}
}
<?php endif;?>
/* Custom CSS */
<?php echo get_theme_mod('textarea_csscode') ? get_theme_mod('textarea_csscode') : '' ; ?>

<?php }

add_filter('query_vars','er_leaf_query_trigger');
function er_leaf_query_trigger($vars) {
    $vars[] = 'load';
    return $vars;
}

add_action('template_redirect', 'er_leaf_trigger_check');
function er_leaf_trigger_check() {
	if(get_query_var('load') == 'custom.css') { 
		header('Content-type: text/css');header("Cache-Control: must-revalidate");
		er_leaf_custom_style();
	exit; }
}