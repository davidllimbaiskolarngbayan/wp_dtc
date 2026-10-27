<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 3/31/2015
	 * Time: 2:59 PM
	 */
	if ( is_array( $data ) and ! empty( $data ) ):
		extract( $data );
		/*if ( $ht_align !== 'left' ) {
			$ht_align_class = ' text-' . $ht_align;
			$ht_align_float = ' pull-' . $ht_align;
		} else {
			$ht_align_class = $ht_align_float = '';
		}*/
		$ht_align_class = ' text-' . $ht_align;
		$ht_align_float = ' pull-' . $ht_align;
			
		$category = vc_build_link( $ht_category );
		$button_name = vc_build_link( $ht_button_name );
		?>

		<div class="offers-box <?php echo !empty($ht_masthead_css_class) ?  $ht_masthead_css_class : ''; ?>">
			<?php
				if ( $ht_img ):
					$img_url = wp_get_attachment_image_src( $ht_img, 'full' );
					if ( $img_url[0] ):;?>
						<img src="<?php echo $img_url[0];?>" alt="slide1" class="img-responsive hidden-xs">
					<?php endif;endif;?><?php
				if ( $ht_img_mobile ):
					$img_url_mobile = wp_get_attachment_image_src( $ht_img_mobile, 'full' );
					if ( $img_url_mobile[0] ):;?>
						<img src="<?php echo $img_url_mobile[0];?>" alt="slide1" class="img-responsive visible-xs">
					<?php endif;endif;?>
			<div class="<?php if(!wp_is_mobile()) echo esc_attr($css_class);?> offers-box-info">
				<div class="container">
					<div class="offers-box-info-content">
						<div class="title <?php echo esc_attr( $ht_align_float . $ht_align_class );?>">
							<?php if ( ! empty( $category['url'] ) ):; ?>
								<p class="promo">
									<a target="<?php echo esc_attr( $category['target'] ); ?>"
									   href="<?php echo esc_url( $category['url'] ); ?>"><?php echo esc_html( $category['title'] ); ?></a>
								</p>
							<?php else:; ?>
								<p class="promo"><?php echo  $category['title'] ; ?></p>
							<?php endif;?>
							<h1><?php echo ( $ht_title); ?></h1>
						</div>
						<div class="content <?php echo esc_attr( $ht_align_float  .$ht_align_class);?>">
							<p class="offer_sub_title"><?php echo   $ht_sub_title; ?></p>

							<div class="check_pull_right <?php echo esc_attr( $ht_align_float );?>">
								<div class="more">
									<a target="<?php echo esc_attr( $button_name['target'] ); ?>"
								   href="<?php echo esc_url( $button_name['url'] ); ?>"><?php echo esc_html( $button_name['title'] ); ?></a>
								</div>

							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<?php if ( $ht_srcolldown ):; ?>
				<div class="scroll-down">
					<a href="#<?php echo $ht_srcolldown_id; ?>">
						<?php _e('Scroll down',HATT_TEXTDOMAIN); ?>
						<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
					</a>
				</div>
			<?php endif;?>
		</div>
	<?php endif; ?>