<?php
	/**
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/22/15
	 * Time: 11:16 AM
	 */
	$post_format = get_post_meta( get_the_ID(), 'post_format', TRUE );
	$demo_link   = get_post_meta( get_the_ID(), 'demo_link', TRUE );
?>
<div <?php post_class( 'single-portfolio' ) ?> >
	<div class="row">
		<div class="col-md-8" id="primary">
			<?php switch ( $post_format ) {
				case "gallery":
					$ids = get_post_meta( get_the_ID(), 'gallery', TRUE );
					$gallery = explode( ',', $ids );
					?>
					<div class="slider_container">
						<ul class="slides">
							<?php if ( ! empty( $gallery ) ):
								foreach ( $gallery as $key => $value ) {
									echo "<li><a/>" . wp_get_attachment_image( $value, array(
											640,
											427,
											'bfi_thumb' => TRUE
										) ) . "</a></li>";
								}
							endif;
							?>
							<?php ?>

						</ul>
					</div>
					<?php
					break;
				case "audio":
				case "video":
					$media_url = get_post_meta( get_the_ID(), 'media_url', TRUE );
					?>
					<div class="media-responsive">
						<?php echo wp_oembed_get( $media_url ) ?>
					</div>

					<?php
					break;
				default:
					the_post_thumbnail( get_the_ID(), array( 640, 427, 'bfi_thumb' => TRUE ) );
					break;
			}
			?>
		</div>

		<div class="col-md-4" id="secondary">
			<!-- Project Summary -->
			<div class="project-desc">
				<h3><?php the_title() ?></h3>

				<div class="line-strong"></div>
				<ul class="list-details">
					<li><i class="fa fa-calendar"></i><?php the_time( get_option( 'date_format' ) ) ?></li>
					<li><i class="fa fa-tag"></i> <?php the_terms( get_the_ID(), 'portfolio_cat' ) ?></li>
					<?php if ( $demo_link ): ?>
						<li><i class="fa fa-globe"></i><a href="<?php echo esc_url( $demo_link ) ?>"
						                                  target="_blank"><?php _e( 'Live Demo', HATT_TEXTDOMAIN ) ?></a>
						</li>
					<?php endif; ?>
				</ul>
				<div class="post-content">
					<?php while ( have_posts() ) {
						the_post();
						the_content();
					} ?>
				</div>

			</div>
			<!-- End Project Summary -->
		</div>
	</div>
	<!-- End .row -->
</div>