<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 3/31/2015
	 * Time: 2:59 PM
	 */
	if ( is_array( $data ) and ! empty( $data ) ):
		extract( $data );
		?>
		<div class="banner_feature baner-box">
            <a href="<?php echo $ht_href;?>">
			<?php
				if ( $ht_img ):
					$img_url = wp_get_attachment_image_src( $ht_img, 'full' );
					if ( $img_url[0] ):;?>
						<img src="<?php echo $img_url[0];?>" alt="slide1" class="img-responsive">
					<?php endif;endif;?>
                </a>
			<!--<div class="baner-box-detail">

				<h3 class="cat"><a href="<?php echo $ht_href;?>"><?php echo $ht_sub_title;?></a></h3>
				<h4 class="title"><a href="<?php echo $ht_href;?>"><?php echo $ht_title;?></a></h4>

				<div class="ht_content_banner_feature"><?php echo $content;?></div>
			</div>-->
		</div>


        <div class="banner_feature baner-box hidden">
            <div class="baner-box-detail-mb">
                <!--<h3 class="cat"><a href="<?php echo $ht_href;?>"><?php echo $ht_sub_title;?></a></h3>-->
                <h4 class="title"><a href="<?php echo $ht_href;?>"><?php echo $ht_title;?></a></h4>
            </div>
        </div>
	<?php endif; ?>