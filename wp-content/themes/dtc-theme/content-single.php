<?php
    /**
     * @package Kryptonite
     */
	 
	$custom_template = "";
	$custom_template = get_post_meta(get_the_ID(),'ht_tyre_custom_template',true);
	 
    $class = '';
    if (is_singular('stores')) {
        $class = 'content-store-single';
    } elseif (is_singular('tyres')) {
        $class = 'content-type-detail';
    } elseif (is_singular('offer')) {
        $class = 'content-type-offer';
    } else {
        $class = 'news-box';
    }
?>
<div class="<?php echo esc_attr($class); ?>">
    <?php while (have_posts()) {
        the_post();
        if (is_singular('store')) {
            echo Hatt()->load_template('stores/single');
        } elseif (is_singular('tyres')) {
			if($custom_template){
				echo Hatt()->load_template('tyres/custom/' . $custom_template);
			}
			else{
				echo Hatt()->load_template('tyres/single');
			}
			
        } elseif (is_singular('offer')) {
            echo Hatt()->load_template('offer/single');
        } else {
            ?>
            <div <?php post_class() ?>>
                <h1 class="text-center title"><?php the_title(); ?></h1>
    <?php
            if(get_post_meta(get_the_ID(),'social_banner_show',true)=='on'):
    ;?>
                <p class="text-center date"><?php the_date('d M y'); ?></p>
            <?php endif;?>
                <?php //echo Hatt()->load_template('loop/format') ?>
                <div class="content-new">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php

            wp_link_pages();
        }

    } ?>
</div>

