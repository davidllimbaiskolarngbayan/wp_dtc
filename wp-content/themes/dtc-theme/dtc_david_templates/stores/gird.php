<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/8/2015
	 * Time: 1:58 PM
	 */ ?>
<div class="store-box">
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="row">
		<div class="col-sm-4">
            <?php
            $ht_store_address = get_post_meta( get_the_ID(), 'ht_store_address', TRUE );
            ;?>
			<p class="address">
				<?php echo esc_attr($ht_store_address); ?>
				<br />
                <a href="<?php  echo (SITE_LOCALE=="cn") ?  'http://map.baidu.com/?l=&s=s%26wd%3D' : 'http://maps.google.com/?q=';  ?><?php echo  esc_attr($ht_store_address); ?>" target="_blank"><?php _e('Get Directions',HATT_TEXTDOMAIN); ?></a>
            </p>
		</div>
		<div class="col-sm-4">
			<p class="phone hidden-xs"><span
					style="font-weight:bold"></span><?php echo get_post_meta( get_the_ID(), 'ht_store_phone', TRUE ); ?></p>
            <p class="phone visible-xs">
            <a href="tel:<?php echo get_post_meta( get_the_ID(), 'ht_store_phone', TRUE ); ?>">
            <!-- <span style="font-weight:bold">+65</span> -->
            <?php echo str_replace("","", get_post_meta( get_the_ID(), 'ht_store_phone', TRUE )); ?>
            </a></p>

<!--			<p class="email"><i class="fa fa-envelope"></i><a-->
<!--					href="mailto:--><?php //echo get_post_meta( get_the_ID(), 'ht_store_email', TRUE ); ?><!--">--><?php //echo get_post_meta( get_the_ID(), 'ht_store_email', TRUE ); ?><!--</a>-->
<!--			</p>-->
		</div>
		<div class="col-sm-4 hidden-xs">
            <?php
            $terms = wp_get_post_terms( get_the_ID(), 'store_cat' );
            if ( ! is_wp_error( $terms ) ):
                foreach ( $terms as $key => $val ):
                    $img = get_tax_meta( $val->term_id, 'store_cat_image' );
                   if ( $img ):;?>
                        <p><img style="max-width: 50%;" class="detail-logo img-responsive"
                                    src="<?php echo esc_attr( $img['url'] );?>" alt="" /></p>
                    <?php else:; ?>
                        <p>
                            <?php echo esc_attr( $val->name ) ?>
                        </p>
                    <?php endif; endforeach; endif ?>
<!--			<div class="rating">-->
<!--				<img src="--><?php //echo esc_url( get_template_directory_uri() ); ?><!--/images/rating.jpg" class="hidden-xs">-->
<!---->
<!--				<p>(2 ratings)</p>-->
<!--			</div>-->
		</div>
	</div>
</div>



