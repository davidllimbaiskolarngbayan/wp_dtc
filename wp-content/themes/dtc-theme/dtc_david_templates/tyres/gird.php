<?php
    /**
     * Created by PhpStorm.
     * User: x
     * Date: 4/8/2015
     * Time: 1:58 PM
     */ ?>
<?php
    global $page_size, $ajax_oe_param ;
    if($page_size){
        $permalink = add_query_arg(array('checksize'=>1),get_the_permalink());
    }else{
        $permalink = get_the_permalink();
    }

    $data_filter = '';
    if(isset($load_cat) && $load_cat === TRUE){
        $postterms = get_the_terms( get_the_ID(), 'tyres_cat' );
        foreach($postterms as $term){
            $data_filter .= '|category_'.$term->term_id;
        }
        $data_filter .= '|';
    }

    $is_rof = (get_post_meta(get_the_ID(), 'ht_tyre_rof', true)=='on')? 'on':'off';
    $is_dtc = (get_post_meta(get_the_ID(), 'ht_tyre_dtc', true)=='on')? 'on':'off';
    $tyre_brochure = get_post_meta(get_the_ID(), 'ht_tyre_brochure', true);

    //prepare OE tyre data
    $data_oesize = '';
    $is_oetyre = 0;
    if(isset($ajax_oe_param) && !empty($ajax_oe_param['combi'])){
        $oetyres = get_post_meta(get_the_ID(), 'ht_select_oetyre_combi');
        foreach((array)$oetyres as $oetyre){
            list($oev,$oes) = explode('_',$oetyre);
            if($oev==$ajax_oe_param['vehicle'] && $oes==$ajax_oe_param['size']){
                //$data_oesize .= '|'.$oes;  //skip this as we use AJAX to assign item to OEbox instead of use js
                $is_oetyre = 1;
            }
        }
        $data_oesize .= '|';
    }
?>
<div class="type-box" data-cat-filter="<?php echo $data_filter; ?>" data-rof="<?php echo $is_rof; ?>" data-isoe="<?php echo $is_oetyre; ?>" data-oe-size="<?php echo $data_oesize; ?>">
    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12 type-left">
            <div class="row tyre-first-row">
                <div class="col-xs-5 col-sm-4 tyre_thumbail">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php echo esc_url($permalink) ?>" title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class=" col-xs-7 col-sm-8 tyre_title">
                    <h4><a class="text-deco-none" href="<?php echo esc_url($permalink)?>"><?php the_title(); ?></a></h4>
                    <?php if($tyre_brochure != ""): ?>
                    <a href="<?php echo $tyre_brochure; ?>" style="text-decoration:underline" target="_blank" class="downloadbrochure">
                        <p class="brochure">
                            <span class="glyphicon glyphicon-download-alt" style="margin-right:5px"></span>Download Product Brochure
                        </p>
                    </a>
                    <?php endif;?>
                    <div class="hidden-xs">
                        <?php echo get_the_excerpt(); ?>&nbsp;&nbsp;  
                        <a href="<?php echo esc_url($permalink) ?>" class="more-detail">
                        <?php _e( 'More details', HATT_TEXTDOMAIN ); ?>
                        </a>
                    </div>

                    <div class="icon-box hidden-xs itemtoleft">
                        <?php echo ht_get_image_terms( 'tyres_feature', 'tyre_feature_image', FALSE ); ?>
                        
                        <?php //echo ht_get_image_terms( 'tyres_weather', 'tyre_weather_image', FALSE ); ?>

                        <?php if($is_rof=='on'): ?>
                            <span class="rof-logo">
                                <div><?php _e( 'Also available in:', HATT_TEXTDOMAIN ); ?></div>
<?php 
    $rofImageUrl='/images/tyres/run_on_flat_logo-rsz.png';
    if(SITE_LOCALE == "cn") { $rofImageUrl='/images/tyres/  run_on_flat_logo_cn.png';  }
?>
<?php if(SITE_LOCALE == "cn") { ?>
    <a href="<?php echo home_url('/learn/dtc-innovation#rof'); ?>" target="_blank">
<?php } ?>
                                <img src="<?php echo esc_url( get_template_directory_uri() ) . $rofImageUrl ; ?>" alt="" />
<?php if(SITE_LOCALE == "cn") { ?>
                        </a>
<?php } ?>
                            </span>
                        <?php endif;?>
                        <?php if($is_dtc=='on'): 
                            $dtcImageUrl='/images/tyres/worry-free-assurance-logo-123x50-min.png'; ?>
                        <span class="rof-logo">
                            <img src="<?php echo esc_url( get_template_directory_uri() ) . $dtcImageUrl; ?>" alt="" />
                        </span>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-xs-12 visible-xs">
                <p>
                    <?php echo get_the_excerpt(); ?>&nbsp;&nbsp;  
                    <a href="<?php echo esc_url($permalink) ?>" class="more-detail">
                         <?php _e( 'More details', HATT_TEXTDOMAIN ); ?>
                    </a>
                </p>
                <?php if($is_rof=='on'): ?>
                    <span class="rof-logo">
                        <div><?php _e( 'Also available in:', HATT_TEXTDOMAIN ); ?></div>
                        <?php 
                        $rofImageUrl='/images/tyres/run_on_flat_logo-rsz.png';
                        if(SITE_LOCALE == "cn") { $rofImageUrl='/images/tyres/run_on_flat_logo_cn.png'; }
                        ?>
                        <a href="<?php echo home_url('/learn/dtc-innovation#rof'); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri() ) . $rofImageUrl ; ?>" alt="" /></a>
                    </span>
            <?php endif;?>
                <?php if($is_dtc=='on'): 
                    $dtcImageUrl='/images/tyres/worry-free-assurance-logo-123x50-min.png'; ?>
                    <span class="rof-logo">
                        <img src="<?php echo esc_url( get_template_directory_uri() ) . $dtcImageUrl; ?>" alt="" />
                    </span>
                <?php endif;?>
             </div>
                <div class="line visible-sm visible-xs"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 type-right">
            <?php 

            //all dont have except CN
            if(SITE_LOCALE=="cn"){
                echo ht_get_price_tyre();
            }else{              
                //echo ht_get_price_tyre();
            }

            ?>
            <p class="btn-find ">
                <a class="text-deco-none" href="<?php echo ( ht_get_url_find_store() ); ?>">
                    <?php _e( 'Find a Store', HATT_TEXTDOMAIN );  ?>
                </a>
            </p>

<?php if(SITE_LOCALE=='in' || SITE_LOCALE == 'ph' || SITE_LOCALE == 'my') { 
    // FOR RFQ countries only

    ?>

            <p class="btn-find ">
                <?php

                    if (isset($browse_tyre)) {
                        unset($_COOKIE['findtyre']);
                        unset($_SESSION['items']);
                        unset($_SESSION['rfq-last-selected-id']);
                        unset($_SESSION['rfq-vehicle-list']);
                    }

                    if(  isset($_COOKIE['findtyre']) && $_COOKIE['findtyre']  == 'size' ) {
         
                        $rfq_url = "compare_item_return=".get_the_ID()."&type=size";

                    }else{
                        //var_dump($_SESSION['last_selected_vehicle']);

                        if(isset($_SESSION['last_selected_vehicle'])){
                            $compare_item_return = "&compare_item_return=".$_SESSION['last_selected_vehicle'];
                        }

                        $tf = ($browse_tyre) ? '' : '#tf';

                        $rfq_url = "rfq_req_tyre=".get_the_ID()."&type=vehicle".$tf;
                    } 
                ?>
                <a class="text-deco-none" href="<?php echo home_url(); ?>/filter-tyre/request-for-quote?<?php echo $rfq_url; ?>">
                    <?php _e( 'Request for quote', HATT_TEXTDOMAIN );  ?>
                </a> 
                     <!-- BUY ON LAZADA -->
                    <?php
                     $lazada = get_post_meta(get_the_ID(), 'ht_buy_lazada', TRUE);
                     if(isset($lazada) && $lazada != '') {
                        echo '<a class="text-deco-none" href="'.$lazada.'" target="_blank" style="margin-top: 10px;">';
                        echo 'Buy On Lazada';
                        echo '</a>';
                     }
                    ?>
            </p>
<?php } ?>

            <div class="check">
                <input type="checkbox">
                <label attr_thumb="<?php echo wp_get_attachment_thumb_url( get_post_thumbnail_id( get_the_ID() ) ); ?>"
                       attr_title="<?php the_title() ?>" attr_id="<?php the_ID(); ?>" class="input_checkbox">
                    <div class="<?php echo ht_check_compare( get_the_ID() ) . ' ' . 'button_compare_' . get_the_ID(); ?> "></div>
                    <?php echo _e( 'Compare', HATT_TEXTDOMAIN ); ?></label>
                    <div class="compare-warning"><?php echo _e( 'You can compare up to 3 tyres at a time', HATT_TEXTDOMAIN ); ?></div>
            </div>
        </div>
    </div>
</div>
