<?php

/**
 * Custom Expcerpt Length
 *
 * @since ER-Leaf 1.0
 */
function er_leaf_excerpt_length( $length ) {
	get_theme_mod('text_excerptlength') ? $lg = get_theme_mod('text_excerptlength') : $lg = 30;
	return $lg;
}
add_filter( 'excerpt_length', 'er_leaf_excerpt_length', 999 );
function er_leaf_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', 'er_leaf_excerpt_more');

function er_leaf_custom_excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}

/**
 * Get meta post info
 *
 * @since ER-Leaf 1.0
 */
function er_post_info($class,$time=true,$author=true,$category=true){ ?>
	<div class="<?php echo $class; ?>">
		
		<?php if($time == "true"): ?>
		<time class="published updated" datetime="<?php echo get_the_date( 'c' );?> ">
			<i class="icon-time"></i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?> 
		</time>
		<?php endif; ?>

		<?php
			if ( 'post' == get_post_type() && $author == "true" ) {
				printf( '<span class="author vcard"><i class="icon-pencil"></i><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( sprintf( __( 'View all posts by %s', 'er_leaf' ), get_the_author() ) ),
					get_the_author()
				);
			}
		?>
		
		<?php if($category == "true"): ?>
		<span>
			<i class="icon-th-list"></i><?php the_category( ', ' ); ?>
		</span>
		<?php endif; ?>

		<?php edit_post_link(__('Edit','er_leaf'), '<span>', '</span>'); ?>

	</div>
<?php }

/**
 * Get post tags
 *
 * @since ER-Leaf 1.0
 */
function er_post_tags(){ 
	if(has_tag()) :
?>
	<div class="entry-info">
		<div class="tags">
			<?php the_tags('',' '); ?>
		</div>
	</div>
<?php endif ; }

/**
 * Author Box
 *
 * @since ER-Leaf 1.0
 */
function er_author_box(){ ?>
	<div class="authorbox">
		<div class="cols">
			<div class="col-1 avatar">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 180 ); ?>
			</div>

			<div class="col-7 author-info">
				<h4><?php the_author_meta( 'user_nicename' ); ?></h4>
				<p><?php the_author_meta( 'user_description' ); ?></p>
				<div class="author-social-profile">
					<ul class="social">
						<?php if(get_user_meta(get_the_author_meta('ID') , 'facebook', true)) : ?><li class="facebook"><a href="<?php echo get_user_meta(get_the_author_meta('ID') , 'facebook', true);?>"><i class="icon-facebook"></i></a></li><?php endif; ?>
						<?php if(get_user_meta(get_the_author_meta('ID') , 'twitter', true)) : ?><li class="twitter"><a href="<?php echo get_user_meta(get_the_author_meta('ID') , 'twitter', true);?>"><i class="icon-twitter"></i></a></li><?php endif; ?>
						<?php if(get_user_meta(get_the_author_meta('ID') , 'googleplus', true)) : ?><li class="googleplus"><a href="<?php echo get_user_meta(get_the_author_meta('ID') , 'googleplus', true);?>"><i class="icon-google-plus"></i></a></li><?php endif; ?>
						<?php if(get_user_meta(get_the_author_meta('ID') , 'pinterest', true)) : ?><li class="pinterest"><a href="<?php echo get_user_meta(get_the_author_meta('ID') , 'pinterest', true);?>"><i class="icon-pinterest"></i></a></li><?php endif; ?>
					</ul>
				</div>
			</div>

		</div>
	</div>
<?php }

/**
 * Relate Posts
 *
 * @since ER-Leaf 1.0
 */
function er_relates_post(){ 
	global $post, $post_id;
	$relates_posts = array(   
    	'post__not_in' => array($post->ID),
    	'showposts'=> 4,
    	'ignore_sticky_posts' => 1
    );
    $relates_query = new WP_Query( $relates_posts );
    if( $relates_query->have_posts() ) :
?>

	<div class="relate-posts">
		<div class="heading-block">
			<h4><?php _e('You may also interested','er_leaf');?></h4>
		</div>

		<ul class="cols">
			<?php while ( $relates_query->have_posts() ) :$relates_query->the_post(); ?>
			<li class="col-2 related-post-item">
				<?php if(has_post_thumbnail()): ?>
				<a rel="bookmark" title="<?php the_title();?>" href="<?php the_permalink();?>"><?php the_post_thumbnail( 'relates-post' );?></a>
				<?php endif; ?>
				<h3 class="entry-title">
					<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title();?>"><?php the_title();?></a>
				</h3>
			</li>
			<?php endwhile; wp_reset_query(); ?>
		</ul>
	</div>

<?php endif; }

/**
 * Post Sharing
 *
 * @since ER-Leaf 1.0
 */

function er_post_share(){ ?>
	<div class="entry-share clearfix">
		<h5><?php _e('Paylaş','er_leaf');?></h5>
		<ul class="social">
			<li class="facebook"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php echo urlencode(get_the_title()); ?>"><i class="icon-facebook"></i><span>facebook</span></a></li>
			<li class="twitter"><a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title()); ?> <?php the_permalink(); ?>"><i class="icon-twitter"></i><span>twitter</span></a></li>
			<li class="linkedin"><a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink();?>&amp;title=<?php echo urlencode(get_the_title()); ?>"><i class="icon-linkedin"></i><span>linkedin</span></a></li>
			<li class="googleplus"><a href="http://google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink() ?>&amp;title=<?php echo urlencode(the_title('', '', false)) ?>"><i class="icon-google-plus"></i><span>google plus</span></a></li>
		</ul>
	</div>
<?php }


/**
*
* Add content to custom post format
*
* @since ER-Leaf 1.0
*/

function er_post_format(){ ?>
	
	<?php 
		global $post, $post_id;
		$post_format = get_post_format();
	?>
	
	<?php 
		// Check STANDARD post format & display custom image
		if( has_post_thumbnail() && $post_format == '' ): 
	?>

	<div class="blog-item-image">
		<div class="blog-item-image-cover">
			<div class="blog-item-image-cover-link">
				<a rel="bookmark" href="<?php the_permalink();?>" class=""><i class="icon-plus"></i></a>
			</div>
		</div>
		<?php the_post_thumbnail('post');?>
	</div><!-- .blog-item-image -->

	<?php 
		// Check VIDEO post format & display iframe video
		elseif( $post_format == "video" && get_post_meta($post->ID, '_format_video_embed', true) ): 
	?>
	
	<div class="blog-item-media">
		<?php echo get_post_meta($post->ID, '_format_video_embed', true); ?>
	</div>

	<?php 
		// Check VIDEO post format & display iframe audio
		elseif($post_format == "audio"): 
	?>
	
	<div class="blog-item-media">
		<?php echo get_post_meta($post->ID, '_format_audio_embed', true); ?>
	</div>

	<?php 
		// Check GALLERY post format & display slider
		elseif($post_format == "gallery" ): 
	?>
	
	<div class="blog-item-slide">
		<div class="flexslider slider">
			<?php if ( $images = get_children(array('post_parent' => get_the_ID(), 'post_type' => 'attachment', 'post_mime_type' => 'image' ))){ ?>
			<ul class="slides">
				<?php foreach( $images as $image ) :  ?>
					<li><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__('Permalink to %s', 'er_leaf'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php echo wp_get_attachment_image($image->ID,'post'); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php } ?>
		</div>
	</div>

	<?php endif; ?>

<?php }

add_action('er_before_post','er_post_format');

/**
*
* Post Comments
*/
function er_leaf_comment( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
   <div class="comment-body clearfix" id="comment-<?php comment_ID() ?>">
		<div class="avatar">
			<?php echo get_avatar( $comment,$size='50'); ?>
		</div>
		<div class="comment-text">
			<div class="author">
				<span><?php printf( __( '%s', 'er_leaf'), get_comment_author_link() ) ?></span>
				<div class="comment-meta">
					<time class="comment-date" datetime="<?php echo get_comment_date();?>"><?php printf(__('%1$s at %2$s', 'er_leaf'), get_comment_date(),  get_comment_time() ) ?>
					<?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?>
					<?php edit_comment_link( __( '(Edit)', 'er_leaf'),'  ','' ) ?>
				</div>
			</div>
			<div class="text">
				<p><?php comment_text() ?></p>
				<?php if ( $comment->comment_approved == '0' ) : ?>
		        	<em><?php _e( 'Your comment is awaiting moderation.', 'er_leaf' ) ?></em>
		      	<?php endif; ?>
			</div>
		</div>
	</div>
<?php
}

/**
*
* Post Shorten
*
*/
function er_leaf_post_short($custom_class){ 
	global $post, $post_id;
?>
	<div id="post-<?php the_ID(); ?>" <?php post_class('blog-item bb '.$custom_class); ?>>
      	
      	<?php do_action( 'er_before_post') ;?>

		<div class="blog-item-content">
			<h4 class="entry-title">
				<a rel="bookmark" title="<?php the_title(__('Permalink to: ','er_leaf')); ?>" href="<?php the_permalink();?>"><?php the_title();?></a>
			</h4>

			<?php er_post_info('entry-meta separate');?>

		</div>
	</div>
<?php }
