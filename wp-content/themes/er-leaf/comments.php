<?php
if ( post_password_required() )
	return;
?>

<div id="comments" class="comment-list">

	<?php if ( have_comments() ) : ?>

		<div class="heading-block">
			<h4><?php _e('Yorumlar','er_leaf');?></h4>
			<div class="right-content comment-cound">
				<span><i class="icon-comments"></i> <?php echo get_comments_number();?></span>
				<i class="icon-plus-sign"></i>
				<a href="#add-comment"><?php _e('Yorum Ekle','er_leaf');?></a>
			</div>
		</div>
		
		<ul class="commentlist">
			 <?php wp_list_comments(array( 'callback' => 'er_leaf_comment' )); ?>
		</ul><!-- .comment-list -->

		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentythirteen' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentythirteen' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'twentythirteen' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

</div><!-- #comments -->

<?php if ( comments_open() ) : ?>
<div id="add-comment" class="comment-form">
	<div class="heading-block">
		<h4><?php _e('Yorum Ekle','er_leaf');?></h4>
	</div>

	<?php
	
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		//Custom Fields
		$fields =  array(
			'author'=> '<div class="field"><i class="icon-user"></i><input name="author" type="text" value="' . __('İsim (gerekli)', 'er_leaf') . '" size="30"' . $aria_req . ' /></div>',
			
			'email' => '<div class="field"><i class="icon-envelope"></i><input name="email" type="text" value="' . __('E-Mail (gerekli)', 'er_leaf') . '" size="30"' . $aria_req . ' /></div>',
			
			'url' 	=> '<div class="field no-margin"><i class="icon-home"></i><input name="url" type="text" value="' . __('Website', 'er_leaf') . '" size="30" /></div>',
		);

		//Comment Form Args
        $comments_args = array(
			'fields' => $fields,
			'comment_notes_after' => ' ',
			'title_reply'=>'',
			'comment_field' => '<div id="respond-textarea"><textarea id="comment" name="comment" aria-required="true" cols="58" rows="10" tabindex="4"></textarea></div>',
			'label_submit' => __('Gönder','er_leaf')
		);
		
		// Show Comment Form
		comment_form($comments_args); 
	?>

</div>
<?php endif; ?>