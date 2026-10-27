<?php
/**
 * Template Name: About Us//News (MRM)
 * Created by MRM.
 * User: Adrian Tee
 * Date: 5 Jun 2015
 */
 
$args = array(
	'cat' => 'news',
	'post_type' => 'post',
	'paged' => get_query_var('paged')
);

$query = new WP_Query( $args );
 
get_header();
?>
<div id="content">
	<div class="content-media-centre">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
<?php
	if (have_posts()):while (have_posts()):
		the_post();
		the_content();

		?>
		
		</div>
		</div>

		<?php

		if ( $query->have_posts() ) { ?>
			<div class="row body-area">
				<div class="col-sm-12">
				<?php while ( $query->have_posts() ) {
					$query->the_post();

					if ( ($query->current_post == 0) && ($args['paged']==0) ) {
						$col ='col-sm-5 big_image page-'.$args['paged'];
						$col2 = 'col-sm-7';
					} else {
						$col  = 'col-sm-3 small_img';
						$col2 = 'col-sm-9';
					}
					?>
					<div <?php post_class( array( 'media-centre-box' ) ) ?>>
						<div class="row">
							<div class="<?php echo esc_attr( $col ); ?>">
								<?php echo Hatt()->load_template( 'loop/format' ) ?>
								<!--            <img src="images/media-centre-img2.jpg" class="img-responsive">-->
							</div>
							<div class="<?php echo esc_attr( $col2 ); ?>">
								<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
								<p class="date"><?php echo  get_the_date( 'd M Y' ,get_the_ID()); ?></p>
								<p><?php echo get_the_excerpt(); ?> <a href="<?php the_permalink(); ?>" class="more">
									<?php _e( 'Read More', HATT_TEXTDOMAIN );	?>
								</a></p>
							</div>
						</div>
					</div>
				<?php } // end while
					echo '<div class="pagination_div font- text-center">';
					echo ht_paging($query);
					echo '</div>';
					wp_reset_query();
				?>
				</div>
			</div>
		<?php } // end if
			endwhile;endif?>

				<!-- </div> -->
			<!-- </div> -->
		</div>
	</div>
</div>
<?php
get_footer();
?>