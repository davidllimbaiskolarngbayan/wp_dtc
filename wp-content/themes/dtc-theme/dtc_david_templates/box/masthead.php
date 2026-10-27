<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 3/31/2015
	 * Time: 2:59 PM
	 */
	if ( is_array( $data ) and ! empty( $data ) ):
		var_dump( $data );

		extract( $data );
		if ( $ht_align !== 'left' ) {
			$ht_align_class = 'text-' . $ht_align;
			$ht_align_float = 'pull-' . $ht_align;
		} else {
			$ht_align_class = $ht_align_float = '';
		}
		$title    = vc_build_link( $ht_title );
		$category = vc_build_link( $ht_category );
		?>

		<div class="blade-box <?php echo esc_attr( $ht_align_class );?>">
			<?php
				if ( $ht_img ):
					$img_url = wp_get_attachment_image_src( $ht_img, 'full' );
					if ( $img_url[0] ):;?>
						<img src="<?php echo $img_url[0];?>" alt="slide1" class="img-responsive">
					<?php endif;endif;?>
			<div class="blade-box-wap">
				<div class="container blade-box-info">
					<div class="blade-box-content">
						<?php if ( ! empty( $category['url'] ) ):; ?>
							<p class="cate"><a target="<?php echo esc_attr( $title['target'] ); ?>"
							                   href="<?php echo esc_url( $title['url'] ); ?>"><?php echo esc_html( $title['title'] ); ?></a>
							</p>
						<?php else:; ?>
							<p class="category"><?php echo esc_html( $title['title'] ); ?></p>
						<?php endif;?>

                        <?php
                            ;?>
						<?php if ( ! empty( $title['url'] ) ):; ?>
							<a target="<?php echo esc_attr( $title['target'] ); ?>"
							   href="<?php echo esc_url( $title['url'] ); ?>">
								<h2><?php echo esc_html( $title['title'] ); ?></h2></a>

						<?php else:; ?>

							<h2><?php echo esc_html( $title['title'] ); ?></h2>
						<?php endif;?>
						<?php if ( ! empty( $ht_sub_title ) ):; ?>
							<p><?php echo esc_html( $ht_sub_title ); ?></p>
						<?php endif;?>
						<div class="<?php echo esc_attr( $ht_align_float );?>">
							<?php echo do_shortcode( $content );?>
						</div>
					</div>
				</div>
			</div>
			<?php if ( $ht_srcolldown ):; ?>
				<div class="scroll-down">
					<a href="#<?php echo $ht_srcolldown_id; ?>">向下浏览 <span
							class="glyphicon glyphicon-menu-down"
							aria-hidden="true"></span></a>
				</div>
			<?php endif;?>
		</div>
	<?php endif; ?>