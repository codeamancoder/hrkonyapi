	<?php global $post, $post_id; ?>
	<div id="heading">
		<?php if(rwmb_meta('er_leaf_heading_bg'))  : ?>
		<div class="heading-images">
			<?php
	  			$out = '';     
	  			$heading_images = rwmb_meta( 'er_leaf_heading_bg', 'type=file' );
			    foreach ( $heading_images as $img ) {
			    	if($img['url'] != '')
			    	$out .=  '<img src="'.$img['url'].'"/>';
			    	$count++;
			    };
			    echo $out;
			?>
		</div><!--// .heading-images -->
		<?php endif; ?>
		
		<?php if(rwmb_meta('er_leaf_heading_custom_code')) : ?>
		<div class="heading-custom">
			<?php echo apply_filters( 'the_content', rwmb_meta('er_leaf_heading_custom_code') ); ?>
		</div>
		<?php endif; ?>

		<div class="wrap">
			<div class="cols">
				<div class="col-6" id="sub-title">

					<h2 class="page-sub-title">
						<?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: %s', 'er_leaf' ), get_the_date() );
							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: %s', 'er_leaf' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'er_leaf' ) ) );
							elseif ( is_year() ) :
								printf( __( 'Yearly Archives: %s', 'er_leaf' ), get_the_date( _x( 'Y', 'yearly archives date format', 'er_leaf' ) ) );
							elseif ( is_singular() ) :
								echo rwmb_meta('er_leaf_heading_title') ? rwmb_meta('er_leaf_heading_title') : the_title('', '', $echo = false ) ;
							elseif ( is_category() ) :
								printf( __( 'Category Archives: %s', 'er_leaf' ), single_cat_title( '', false ) );
							elseif ( is_tag() ) :
								printf( __( 'Tag Archives: %s', 'er_leaf' ), single_tag_title( '', false ) );
							elseif ( is_search() ) :
								printf( __( 'Arama sonuçları: %s', 'er_leaf' ), get_search_query() );
							elseif ( is_tax() ) :
								printf( __( 'Projeler: %s', 'er_leaf' ), single_cat_title( '', false ) );
							else :
								_e( 'Duyurular', 'er_leaf' );
							endif;
						?>
					</h2>
					
				</div><!--// #sub-title -->
				<div class="col-6" id="breadcrumb">
					<?php er_leaf_breadcrumb(); ?>
				</div><!--// #breadcrumb -->
			</div><!--// .cols -->
		</div><!--// .wrap -->
	</div><!--// #heading -->

	