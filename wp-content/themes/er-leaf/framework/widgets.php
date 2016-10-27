<?php
/**
 * eNews and Updates Wigets
 *
 * @since 1.0
 */
class ER_Leaf_eNews_Updates extends WP_Widget {

	protected $defaults;
	
	function __construct() {

		$this->defaults = array(
			'title'       => '',
			'text'        => '',
			'id'          => '',
			'input_text'  => '',
			'button_text' => '',
		);

		$widget_ops = array(
			'classname'   => 'enews-widget',
			'description' => __( 'Displays Feedburner email subscribe form', 'er_leaf' ),
		);

		$this->WP_Widget( 'enews', __( 'ER Leaf - eNews and Updates', 'er_leaf' ), $widget_ops );

	}

	function widget( $args, $instance ) {

		extract( $args );

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget . '<div class="enews">';

			if ( ! empty( $instance['title'] ) )
				echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

			echo wpautop( $instance['text'] ); // We run KSES on update

			if ( ! empty( $instance['id'] ) ) : ?>
			<form id="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open( 'http://feedburner.google.com/fb/a/mailverify?uri=<?php echo esc_js( $instance['id'] ); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<input type="text" value="<?php echo esc_attr( $instance['input_text'] ); ?>" id="subbox" onfocus="if ( this.value == '<?php echo esc_js( $instance['input_text'] ); ?>') { this.value = ''; }" onblur="if ( this.value == '' ) { this.value = '<?php echo esc_js( $instance['input_text'] ); ?>'; }" name="email" />
				<input type="hidden" name="uri" value="<?php echo esc_attr( $instance['id'] ); ?>" />
				<input type="hidden" name="loc" value="<?php echo esc_attr( get_locale() ); ?>" />
				<input type="submit" value="<?php echo esc_attr( $instance['button_text'] ); ?>" id="subbutton" />
			</form>
			<?php endif;

		echo '</div>' . $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		$new_instance['title'] = strip_tags( $new_instance['title'] );
		$new_instance['text']  = wp_kses( $new_instance['text'], er_leaf_formatting_allowedtags() );
		return $new_instance;

	}

	function form( $instance ) {

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'er_leaf' ); ?>:</label><br />
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text To Show', 'er_leaf' ); ?>:</label><br />
			<textarea id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" class="widefat" rows="6" cols="4"><?php echo htmlspecialchars( $instance['text'] ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Google/Feedburner ID', 'er_leaf' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $instance['id'] ); ?>" class="widefat" />
		</p>

		<p>
			<?php $input_text = empty( $instance['input_text'] ) ? __( 'Your Email', 'er_leaf' ) : $instance['input_text']; ?>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Input Text', 'er_leaf' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'input_text' ); ?>" name="<?php echo $this->get_field_name( 'input_text' ); ?>" value="<?php echo esc_attr( $input_text ); ?>" class="widefat" />
		</p>

		<p>
			<?php $button_text = empty( $instance['button_text'] ) ? __( 'Go', 'er_leaf' ) : $instance['button_text']; ?>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text', 'er_leaf' ); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" value="<?php echo esc_attr( $button_text ); ?>" class="widefat" />
		</p>

	<?php
	}

}
/**
 * Get Flickr widget class.
 *
 * @since 1.0
 */
class ER_Leaf_Flickr_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function ER_Leaf_Flickr_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-flickr flickr-widget', 'description' => 'Flickr images from a Flickr ID' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'er_leaf-flickr-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'er_leaf-flickr-widget', 'ER Leaf - Flickr', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$flickrID = $instance['flickrID'];
		$numberimages = $instance['numberimages'];
		$lightbox = isset( $instance['lightbox'] ) ? ($instance['lightbox'] == 'on' ? true : false ) : false;
		$interval = $instance['interval'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by theme). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		/* Display images */

		parse_flickr_cache_feed( $flickrID, $numberimages, $lightbox, $interval );

		/* After widget (defined by theme). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['lightbox'] = $new_instance['lightbox'];
		$instance['numberimages'] = strip_tags( $new_instance['numberimages'] );
		$instance['interval'] = strip_tags( $new_instance['interval'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'numberimages' => 9,
							'flickrID' => '',
							'lightbox' => '',
							'interval' => 1800 );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title','er_leaf'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
        
        <!-- Widget Flickr ID: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID','er_leaf'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" class="widefat" />
		</p>
        
		<!-- Widget Number of Images: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'numberimages' ); ?>"><?php _e('Number of images to show','er_leaf'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'numberimages' ); ?>" name="<?php echo $this->get_field_name( 'numberimages' ); ?>" value="<?php echo $instance['numberimages']; ?>" size="3" />
		</p>
		
		<!-- Widget Lightbox: Checkbox -->
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'lightbox' ); ?>" name="<?php echo $this->get_field_name( 'lightbox' ); ?>" class="checkbox" <?php checked( $instance['lightbox'], 'on' ); ?> />
			<label for="<?php echo $this->get_field_id( 'lightbox' ); ?>"><?php _e('Display in Lightbox?','er_leaf'); ?>:</label>
		</p>
        
        <!-- Widget Cache Interval: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'interval' ); ?>"><?php _e('Cache interval in seconds','er_leaf'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'interval' ); ?>" name="<?php echo $this->get_field_name( 'interval' ); ?>" value="<?php echo $instance['interval']; ?>" size="3" />
		</p>

	<?php
	}
}

function parse_flickr_cache_feed($flickrID, $numberimages, $lightbox, $interval){
	echo '<div class="clearfix"><script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count='.$numberimages.'&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user='.$flickrID.'"></script></div>';
}

/**
 * Recent Projects
 *
 * @since 1.0
 */
class ER_Leaf_Recent_Projects_Widget extends WP_Widget {
		/** constructor */	
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'recent_portfolio_widget', 
			'description' => __('Shows recent portfolio images in sidebar.','er_leaf')
		);
    	parent::__construct('er_leaf_recent_projects_widget', __('ER Leaf - Recent Projects','er_leaf'), $widget_ops);
	}
	function widget($args, $instance) {
           
			extract( $args );
			$cats = '';

			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Recent Projects' : $instance['title'], $instance, $this->id_base);	
			if ( ! $number = absint( $instance['number'] ) ) $number = 5;
			if( ! $cats = $instance["cats"] )  $cats='';

			$my_args=array(
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'post_type' => 'portfolio',
				'tax_query' => array(
					array(
						'taxonomy' => 'portfolio_category',
						'field' => 'id',
						'terms' => $cats
					)
				)
			);
			
			
			
			$adv_recent_posts = null;
			$adv_recent_posts = new WP_Query($my_args);

			echo $before_widget;
			echo $before_title;
			echo $instance["title"];
			echo '<div class="button-area">'."\n";
			echo '<a id="wp_prev" class="prev" href="#" style="display: inline-block;"><i class="icon-angle-left"></i></a>'."\n";
			echo '<a id="wp_next" class="next" href="#" style="display: inline-block;"><i class="icon-angle-right"></i></a>'."\n";
			echo '</div>'."\n";
			echo $after_title;
			echo '<div class="cols portfolio-widget">'."\n";
			$post_count = 0;
			while ( $adv_recent_posts->have_posts() ) : $adv_recent_posts->the_post();
				
			?>
				<div class="col-3">
				<?php get_template_part( 'content', 'portfolio' ); ?>
				</div>
		<?php 		 
			endwhile;
			echo '</div>'."\n";
			echo '<script type="text/javascript">
				jQuery(document).ready(function($){
					function imageCarousel() {

						var carousel =  $(".portfolio-widget");
						var width = $(window).width();
						if(width <=220) {
						     carousel.trigger("destroy");
						}
						else {
							carousel.carouFredSel({
								auto: false,
								responsive: false,
								height : "auto",
								scroll: {
								    items : 1
								},
								prev	: {
									button	: "#wp_prev",
									key		: "left",
									items   : 1
								},
								next	: {
									button	: "#wp_next",
									key		: "right",
									items   : 1
								},
								items : {
								    visible     : 4,
								    width       : "100%"
								},
							    onCreate : function () {
							        carousel.parent().add(carousel).css("height", carousel.children().first().height() + "px");
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
				</script>';
			wp_reset_query();
			echo $after_widget;
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['cats'] = $new_instance['cats'];
			$instance['number'] = absint($new_instance['number']);
			return $instance;
		}
		
		function form( $instance ) {
			$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Recent Projects';
			$number = isset($instance['number']) ? absint($instance['number']) : 5;
		?>
		
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of projects to show:','er_leaf'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
                
        <p>
            <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Categories:','er_leaf');?> 
                <?php
                     $categories =  get_terms('portfolio_category',array( 'parent' => 0 , 'hide_empty'    => false,));
                     echo "<br/>";
                     foreach ($categories as $cat) {
                         $option='<input type="checkbox" id="'. $this->get_field_id( 'cats' ) .'[]" name="'. $this->get_field_name( 'cats' ) .'[]"';
                            if (is_array($instance['cats'])) {
                                foreach ($instance['cats'] as $cats) {
                                    if($cats==$cat->term_id) {
                                         $option=$option.' checked="checked"';
                                    }
                                }
                            }
                            $option .= ' value="'.$cat->term_id.'" />';
                            $option .= $cat->name;
                            $option .= '<br />';
                            echo $option;
                         }
                    ?>
            </label>
        </p>
		
		<?php }
}


/**
 * Recent Post
 *
 * @since 1.0
 */
class ER_Leaf_Recent_Posts_Widget extends WP_Widget {
		/** constructor */	
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'recent_posts_widget recent-posts', 
			'description' => __('Shows recent posts in sidebar.','er_leaf')
		);
    	parent::__construct('er_leaf_recent_posts_widget', __('ER Leaf - Recent Posts','er_leaf'), $widget_ops);
	}
	function widget($args, $instance) {
           
			extract( $args );
			
			$cats = '';
			
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Recent Posts' : $instance['title'], $instance, $this->id_base);	
			if ( ! $number = absint( $instance['number'] ) ) $number = 5;
			if( ! $cats = $instance["cats"] )  $cats='';

			$my_args=array(
				'posts_per_page' => $number,
				'orderby' => 'date',
				'order' => 'DESC',
				'cat'	=> $cats,
				'ignore_sticky_posts' => 1
			);
			
			
			
			$adv_recent_posts = null;
			$adv_recent_posts = new WP_Query($my_args);

			echo $before_widget;
			echo $before_title;
			echo $instance["title"];
			echo $after_title;
			echo '<ul>'."\n";
			$post_count = 0;
			while ( $adv_recent_posts->have_posts() ) : $adv_recent_posts->the_post();
				
			?>
				<li id="widget-post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

					<?php if(has_post_thumbnail()): ?>
					<a rel="bookmark" href="<?php the_permalink();?>" title="<?php the_title();?>">
						<?php the_post_thumbnail('recent-post'); ?>
					</a>
					<?php endif;?>

					<div class="post-content">
						<h3 class="entry-title">
							<a rel="bookmark" title="<?php the_title();?>" href="<?php the_permalink();?>"><?php the_title();?></a>
						</h3>
						<div class="entry-meta">
							<time datetime="<?php echo get_the_date( 'c' );?> ">
								<i class="icon-time"></i><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . ' ago'; ?> 
							</time>
						</div>
					</div><!--// .post-content -->

				</li><!--// #post -->
		<?php 		 
			endwhile;
			echo '</ul>'."\n";
			wp_reset_query();
			echo $after_widget;
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['cats'] = $new_instance['cats'];
			$instance['number'] = absint($new_instance['number']);
			return $instance;
		}
		
		function form( $instance ) {
			$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Recent Projects';
			$number = isset($instance['number']) ? absint($instance['number']) : 5;
		?>
		
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:','er_leaf'); ?></label>
        <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
                
        <p>
            <label for="<?php echo $this->get_field_id('cats'); ?>"><?php _e('Categories:','er_leaf');?> 
                <?php
                	 $cats = '';
                     $categories =  get_terms('category',array( 'parent' => 0 , 'hide_empty'    => false,));
                     echo "<br/>";
                     foreach ($categories as $cat) {
                         $option='<input type="checkbox" id="'. $this->get_field_id( 'cats' ) .'[]" name="'. $this->get_field_name( 'cats' ) .'[]"';
                            if (is_array($instance['cats'])) {
                                foreach ($instance['cats'] as $cats) {
                                    if($cats==$cat->term_id) {
                                         $option=$option.' checked="checked"';
                                    }
                                }
                            }
                            $option .= ' value="'.$cat->term_id.'" />';
                            $option .= $cat->name;
                            $option .= '<br />';
                            echo $option;
                         }
                    ?>
            </label>
        </p>
		
		<?php }
}

/**
 * Category Listing Widget
 *
 * @since 1.0
 */
class ER_Leaf_Category_Widget extends WP_Widget {
		/** constructor */	
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'menu er_leaf_taxonomy_widget', 
			'description' => __('Shows category listing in sidebar.','er_leaf')
		);
    	parent::__construct('recent-posts-widget', __('ER Leaf - Category List','er_leaf'), $widget_ops);
	}
	function widget($args, $instance) {
           
			extract( $args );
		
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Category' : $instance['title'], $instance, $this->id_base);	
			
			echo $before_widget;
			echo $before_title;
			echo $instance["title"];
			echo $after_title;
			echo '<ul>'."\n";
			$args = array(
  				'orderby' => 'name',
  				'order' => 'ASC'
  			);
			$categories = get_categories($args);
			foreach($categories as $category) { 
				echo '<li class="clearfix">';
    			echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s",'er_leaf' ), $category->name ) . '" ' . '>' . $category->name.'</a>';
    			echo '<span>'.$category->count.'</span>';
    			echo '</li>';
			}
			?>
				
		<?php 		 
			echo '</ul>'."\n";
			echo $after_widget;
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}
		
		function form( $instance ) {
			$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Category';
		?>
		
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		
		<?php }
}
/**
 * Contact Widget.
 *
 * @since 1.0
 */
class ER_Leaf_Contact extends WP_Widget {
		/** constructor */	
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'er_leaf_contact_info', 
			'description' => __('Display contact infomations','er_leaf')
		);
    	parent::__construct('er_leaf_contact_info', __('ER Leaf - Contact Info','er_leaf'), $widget_ops);
	}
	function widget($args, $instance) {
			extract( $args );
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Contact Infomations' : $instance['title'], $instance, $this->id_base);	
			
			echo $before_widget.$before_title.$instance["title"].$after_title;
			echo '<div class="contact-info-wrap">'."\n";
			echo '<div class="contact-field"><i class="icon-map-marker"></i><strong>'.$instance["address"].'</strong></div>'."\n";
			echo '<div class="contact-field"><i class="icon-phone"></i><span>Phone:</span>'.$instance["phone"].'</div>'."\n";
			echo '<div class="contact-field"><i class="icon-reply"></i><span>Fax:</span>'.$instance["fax"].'</div>'."\n";
			echo '<div class="contact-field"><i class="icon-envelope"></i><span>Email:</span>'.$instance["email"].'</div>'."\n";
			echo '<div class="contact-field"><i class="icon-globe"></i><span>Website:</span>'.$instance["website"].'</div>'."\n";
			echo '</div>'."\n";
			echo $after_widget;
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['address'] = strip_tags($new_instance['address']);
			$instance['phone'] = strip_tags($new_instance['phone']);
			$instance['fax'] = strip_tags($new_instance['fax']);
			$instance['email'] = strip_tags($new_instance['email']);
			$instance['website'] = strip_tags($new_instance['website']);
			return $instance;
		}
		
		function form( $instance ) {
			$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Contact Infomations';
			$address = isset($instance['address']) ? esc_attr($instance['address']) : '';
			$phone = isset($instance['phone']) ? esc_attr($instance['phone']) : '';
			$fax = isset($instance['fax']) ? esc_attr($instance['fax']) : '';
			$email = isset($instance['email']) ? esc_attr($instance['email']) : '';
			$website = isset($instance['website']) ? esc_attr($instance['website']) : '';
		?>
		
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" type="text" value="<?php echo $address; ?>" size="3" /></p>
        
		<p><label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Phone:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo $phone; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id('fax'); ?>"><?php _e('Fax:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" type="text" value="<?php echo $fax; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>" size="3" /></p>

		<p><label for="<?php echo $this->get_field_id('website'); ?>"><?php _e('Website:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('website'); ?>" name="<?php echo $this->get_field_name('website'); ?>" type="text" value="<?php echo $website; ?>" size="3" /></p>

		<?php }
}
/**
 * Video Embed Widget.
 *
 * @since 1.0
 */
class ER_Leaf_Embed_Code extends WP_Widget {
		/** constructor */	
	function __construct() {
    	$widget_ops = array(
			'classname'   => 'er_leaf_video_embed', 
			'description' => __('Display video in Widget','er_leaf')
		);
    	parent::__construct('er_leaf_embed_code', __('ER Leaf - Video Embed','er_leaf'), $widget_ops);
	}
	function widget($args, $instance) {
			extract( $args );
			$title = apply_filters( 'widget_title', empty($instance['title']) ? 'Contact Infomations' : $instance['title'], $instance, $this->id_base);	
			
			echo $before_widget.$before_title.$instance["title"].$after_title;
			echo '<div class="embed_content">'."\n";
			echo $instance['embed_code'];
			echo '</div>'."\n";
			echo $after_widget;
		}
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['embed_code'] = strip_tags($new_instance['embed_code']);
			return $instance;
		}
		
		function form( $instance ) {
			$title = isset($instance['title']) ? esc_attr($instance['title']) : 'Contact Infomations';
			$embed_code = isset($instance['embed_code']) ? esc_attr($instance['embed_code']) : '';
		?>
		
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','er_leaf'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('embed_code'); ?>"><?php _e('Video Embed Code:','er_leaf'); ?></label>
        <textarea class="widefat" id="<?php echo $this->get_field_id('embed_code'); ?>" name="<?php echo $this->get_field_name('embed_code'); ?>"><?php echo $embed_code; ?></textarea></p>
        
		<?php }
}
/**
 * Tags Widget.
 *
 * @since 1.0
 */
function tcr_tag_cloud_filter($args = array()) {
    $args['smallest'] = 12;
    $args['largest'] = 12;
    $args['unit'] = 'px';
    return $args;
}
add_filter('widget_tag_cloud_args', 'tcr_tag_cloud_filter', 90);

/**
 * Register Widgets.
 *
 * @since 1.0
 */
function er_leaf_register_widgets() {
	register_widget( 'ER_Leaf_eNews_Updates' );
	register_widget( 'ER_Leaf_Flickr_Widget' );
	register_widget( 'ER_Leaf_Recent_Projects_Widget' );
	register_widget( 'ER_Leaf_Recent_Posts_Widget' );
	register_widget( 'ER_Leaf_Category_Widget' );
	register_widget( 'ER_Leaf_Embed_Code' );
	register_widget( 'ER_Leaf_Contact' );
}

add_action( 'widgets_init', 'er_leaf_register_widgets' );