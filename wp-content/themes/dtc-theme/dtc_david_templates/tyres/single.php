<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/8/2015
 * Time: 3:48 PM
 */

global $wpdb;
?>

<!-- <div class=""> -->
    <div class="detail-top">
        <div class="inner-detail-top">
        <div class="col-md-5 left">
            <?php

				function get_attachment_info($attachment_id) {  // to get attachment info
					$attachment = get_post($attachment_id);
					return array(
						'alt' => get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
						'caption' => $attachment->post_excerpt,
						'description' => $attachment->post_content,
						'href' => get_permalink($attachment->ID),
						'src' => $attachment->guid,
						'title' => $attachment->post_title
					);
				}

				// Photo gallery for tyre
				$gallery = get_post_meta(get_the_ID(), 'ht_tyre_gallery', TRUE);

				// Download brochure link


				if (!empty($gallery)) {

					// Ensure $gallery is a string before using explode
					if (is_array($gallery)) {
						// If $gallery is an array, convert it to a string
						$gallery = implode(',', $gallery);
					}

					// If $gallery is a string, proceed with explode
					if (is_string($gallery)) {
						$gallery = explode(',', $gallery);

						if (is_array($gallery)) {
							$html_slider = "";
							$htmlthumb_slider = "";

							foreach ($gallery as $k => $var) {
								$media = get_attachment_info($var);
								$vidx = strpos($media["description"], ".mp4");

								if ($vidx > -1) {
									$html_slider .= '<li style="text-align:center"><video width="100%" height="360" playsinline autoplay muted loop><source src="' . $media["description"] . '" type="video/mp4"></video></li>';
									$htmlthumb_slider .= '<li><img src="' . wp_get_attachment_url($var) . '" alt="' . $media["alt"] . '" /></li>';
								} else {
									// Handle YouTube videos
									$event_cat = "David Tyre Company Tyre Page Video";
									if (preg_match("/[youtube video]/i", $media["description"])) {
										$html_slider .= '<li class="ytvideo-holder">' . do_shortcode('[wcp_video_prod player_id=ytplayer height=239 width=425]') . '</li>';
										$htmlthumb_slider .= '<li class="ytrigger-prod" data-event_cat="' . $event_cat . '"><img alt="' . the_title('', '', false) . '" src="' . wp_get_attachment_url($var) . '" /></li>';
									} else {
										$html_slider .= '<li><img src="' . wp_get_attachment_url($var) . '" alt="' . $media["alt"] . '" /></li>';
										$htmlthumb_slider .= '<li><img src="' . wp_get_attachment_url($var) . '" alt="' . $media["alt"] . '" /></li>';
									}
								}
							}
							?>
							
							<div id="slider" class="flexslider">
								<ul class="slides">
									<?php echo ($html_slider); ?>
								</ul>
							</div>

							<div id="carousel" class="flexslider">
								<ul class="slides">
									<?php echo ($htmlthumb_slider); ?>
								</ul>
							</div>

							<?php
							$tyre_brochure = get_post_meta(get_the_ID(), 'ht_tyre_brochure', true);
							if ($tyre_brochure): ?>
								<div class="brochure-download">
									<a href="<?php echo esc_url($tyre_brochure); ?>" target="_blank">Download Brochure</a>
								</div>
							<?php endif;
						}
					}
				}
				
			?>

        </div>
        <div class="col-md-7 right">
            <h1><?php the_title(); ?></h1>
            <div class="description">
            <?php echo get_post_meta(get_the_ID(),'ht_tyre_information',true);?>
            </div>
            
            <div class="icon-box single-tyres-icon-box">
                <?php echo ht_get_image_terms( 'tyres_feature', 'tyre_feature_image', true ); ?>
                <?php //echo ht_get_image_terms( 'tyres_weather', 'tyre_weather_image', true ); ?>

                <?php if(get_post_meta(get_the_ID(), 'ht_tyre_rof', true)=='on'): ?>
                <span class="rof-logo">
                    <div><?php _e( 'Also available in:', HATT_TEXTDOMAIN ); ?></div>
<?php 
    $rofImageUrl='/images/tyres/run_on_flat_logo-rsz.png';
    if(SITE_LOCALE == "cn") { $rofImageUrl='/images/tyres/run_on_flat_logo_cn.png'; }
?>
<?php if(SITE_LOCALE == "cn") { ?>
    <a href="<?php echo home_url('/learn/dtc-innovation#rof'); ?>" target="_blank">
<?php } ?>
                                <img src="<?php echo esc_url( get_template_directory_uri() ) . $rofImageUrl ; ?>" alt="RunOnFlat Technology" />
<?php if(SITE_LOCALE == "cn") { ?>
                        </a>
<?php } ?>
                </span>
                <?php endif;?>
    <?php if(get_post_meta(get_the_ID(), 'ht_tyre_dtc', true)=='on'): 
      $dtcImageUrl='/images/tyres/worry-free-assurance-logo-123x50-min.png'; ?>
      <span class="rof-logo">
      <img src="<?php echo esc_url( get_template_directory_uri() ) . $dtcImageUrl; ?>" alt="Worry Free Assurance" />
      </span>
        <?php endif;?>
        <?php if($tyre_brochure != ""): ?>
        <div style="position: relative; text-align: left;padding: 0 5px; margin-top: 15px" class="visible-xs-block">
            <a href="<?php echo $tyre_brochure; ?>" style="text-decoration:underline; color: #013A82 !important;" target="_blank"  class="downloadbrochure">
                    <span class="glyphicon glyphicon-download-alt" style="margin-right:5px; width: auto"></span>Download Product Brochure
            </a>
        </div>
        <?php endif;?>
        </div>



           <div class="visible-xs line"></div>
            <div class="type-right  type_border">
                <!--<?php echo ht_get_price_tyre();?>-->
                <p class="btn-find"><a href="<?php echo esc_url(ht_get_url_find_store()); ?>">
                  <?php _e('Find a Store',HATT_TEXTDOMAIN); ?></a>
                </p>

<?php if(SITE_LOCALE=='in' || SITE_LOCALE=='ph' || SITE_LOCALE=='my' ){ 
                // for RFQ countries only
?>
                <p class="btn-find ">
                    <?php
                       
                        if( isset($_COOKIE['findtyre']) && $_COOKIE['findtyre'] == 'size'  ){
                            $edit_url = 'compare_item_return='.get_the_ID().'&type=size#tf';
                        }else{
                            $edit_url = 'rfq_req_tyre='.get_the_ID().'&type=vehicle#tf';
                        }

                        $form_url = (SITE_LOCALE=='in') ? 'tyre/request-for-quote?' : 'filter-tyre/request-for-quote?';
                       

                    ?>
                   <a class="text-deco-none" href="<?php echo home_url().'/'.$form_url. $edit_url ; ?>">
                        <?php _e( 'Request for quote', HATT_TEXTDOMAIN );  ?>
                    </a> 
                     <!-- BUY ON LAZADA -->
                    <?php
                     $lazada = get_post_meta(get_the_ID(), 'ht_buy_lazada', TRUE);
                     if(isset($lazada) && $lazada != '') {
                        echo '<a class="text-deco-none" href="'.$lazada.'" target="_blank"  style="margin-top: 10px;">';
                        echo 'BUY ON LAZADA';
                        echo '</a>';
                     }
                     ?>
                </p>
<?php } ?>

            <?php if($tyre_brochure != ""): ?>
                <div style="position: relative; text-align: left;padding: 0 0;height:65%" class="hidden-xs">
                    <div style="position:absolute;bottom:0;left:0">
                        <a href="<?php echo $tyre_brochure; ?>" style="text-decoration:underline; color: #013A82 !important;" target="_blank"  class="downloadbrochure">
                                <span class="glyphicon glyphicon-download-alt" style="margin-right:5px; width: auto"></span>Download Product Brochure
                        </a>
                    </div>
                </div>
            <?php endif;?>

            </div>
        </div>
        <div class="clearfix"></div>    
        </div>
        <!-- //inner-detail-top -->
    </div>
    <?php if(isset($_GET['checksize']) and !empty($_GET['checksize'])):

        $html_size_desktop =  $html_size_mobile='';

        $size_selected = get_post_meta( get_the_ID(), 'ht_select_size_customa' );
        
         $tyre_details =  get_post(  get_the_ID() ) ;
        //if the user came from find tyre by size
        if( !empty($_SESSION['ht_size_width']) && !empty($_SESSION['ht_size_ratio']) && !empty($_SESSION['ht_size_diameter']) && empty($_SESSION['vehicle_term']) ) {
           
            $size_selected = array();


            if(!empty($_SESSION['ht_size_opt_speed'])){
                $meta_speed_join = " LEFT OUTER JOIN {$wpdb->postmeta} AS e ON a.post_id = e.post_id";
                $meta_speed = " AND (e.meta_key = 'ht_tyre_speed_ratio' AND e.meta_value = '".$_SESSION['ht_size_opt_speed']."')";
            }

            if(!empty($_SESSION['ht_size_opt_load'])){
                $meta_load_join = " LEFT OUTER JOIN {$wpdb->postmeta} AS f ON a.post_id = f.post_id";
                $meta_load = " AND (f.meta_key = 'ht_tyre_load_index' AND f.meta_value = '".$_SESSION['ht_size_opt_load']."')";
            }


            $sql = "SELECT
                        *
                     FROM hatt_postmeta a 
                        LEFT OUTER JOIN hatt_postmeta b
                            ON a.`post_id` = b.`post_id`
                        LEFT OUTER JOIN hatt_postmeta c
                            ON a.`post_id` = c.`post_id`
                        LEFT OUTER JOIN hatt_postmeta d
                            ON a.`post_id` = d.`post_id`
                        {$meta_speed_join}
              {$meta_load_join}
                    WHERE 
                        (a.meta_key = 'ht_size_width'  AND a.`meta_value` = ".$_SESSION['ht_size_width']." ) 
                        AND (b.meta_key = 'ht_size_ratio'  AND b.`meta_value`   = ".$_SESSION['ht_size_ratio']." ) 
                        AND (c.meta_key = 'ht_size_diameter'  AND c.`meta_value` = ".$_SESSION['ht_size_diameter']." ) 
                        AND (d.meta_key = 'ht_tyre_code'  AND d.`meta_value` = '{$tyre_details->post_name}' )
                        {$meta_speed}
              {$meta_load}
                        ";

            $query_size = $wpdb->get_results($sql);

            if( $query_size){
                foreach( $query_size as $tyre_sizes ){
                    $size_selected[] = $tyre_sizes->post_id;
                }
            }else{
                 unset($size_selected);
            }
       }

       if(!empty($_SESSION['vehicle_term'])){
            
            $size_selected = array();
            $show_oetyre_table = 0;

            if(!empty($_SESSION['oecombi_set'])){
                //OEtyre
                //check if this tyre has the vehicle combi
                $sql = "SELECT a.`ID`
                FROM hatt_posts a
                    INNER JOIN hatt_postmeta b
                        ON a.`ID` = b.`post_id`
                    WHERE
                     a.ID = '".get_the_ID()."'
                     AND (b.`meta_key` = 'ht_select_oetyre_combi'  AND b.`meta_value` = '".$_SESSION['oecombi_set']."' )";

                $total_query = $wpdb->get_results($sql);
                if(sizeof($total_query) > 0){
                    list($oetyre_vehicle,$oetyre_size) = explode('_',$_SESSION['oecombi_set']);
                    $size_selected[] = $oetyre_size;

                    //current selected tyre is OE tyre
                    $show_oetyre_table = 1;
                }else{
                    unset($size_selected);
                }
            }


            if($show_oetyre_table == 0){
                $sql = "SELECT DISTINCT(e.`post_id`)
                FROM hatt_terms a
                    LEFT OUTER JOIN hatt_term_taxonomy b
                        ON a.`term_id` = b.`term_id` AND b.`taxonomy` = 'vehicles_cat'
                    LEFT OUTER JOIN hatt_term_relationships c
                        ON b.`term_taxonomy_id` = c.`term_taxonomy_id`
                    LEFT OUTER JOIN hatt_posts d
                        ON d.`ID` = c.`object_id` AND d.`post_type` = 'size'
                    LEFT OUTER JOIN `hatt_postmeta` e
                        ON e.`post_id` = d.`ID`
                    LEFT OUTER JOIN `hatt_postmeta` f
                        ON f.`post_id` = d.`ID` AND f.`meta_key` = 'ht_tyre_code'
                    WHERE
                    a.`slug`= '".$_SESSION['vehicle_term']."'
                     AND e.`post_id` IS NOT NULL
                     AND f.`meta_value` = '{$tyre_details->post_name}'";

                $query_size = $wpdb->get_results($sql);

                if( $query_size){
                    foreach( $query_size as $tyre_sizes ){
                        $size_selected[] = $tyre_sizes->post_id;
                    }
                }else{
                    unset($size_selected);
                }
            }
       }

        $show_ratio_load_table = false;
        
        if(isset($size_selected) and !empty($size_selected)):

            $size_a = array('post_type'=>'size','post__in'=>$size_selected);
            $query_size = new WP_Query($size_a);
    
            if($query_size->have_posts()):

                while ($query_size->have_posts()):
                    $query_size->the_post();

                    $ht_tyre_title = get_the_title(get_the_ID());
                    $ht_tyre_speed_ratio = get_post_meta(get_the_ID(),'ht_tyre_speed_ratio',true);
                    $ht_tyre_load_index = get_post_meta(get_the_ID(),'ht_tyre_load_index',true);
                    $ht_tyre_sidewall = get_post_meta(get_the_ID(),'ht_tyre_sidewall',true);

                    list($size, $rating, $loadindex) = explode(' ', $ht_tyre_title);
                    
                    $html_size_desktop.=' <tr>
                            <td>'.$size.'</td>
                            <td>'. $ht_tyre_speed_ratio.'</td>
                            <td>'.$ht_tyre_load_index.'</td>
                            <td>'.$ht_tyre_sidewall.'</td>
                        </tr>';
                    $html_size_mobile .='<div class="item row">
                            <div class="col-xs-5 title">
                                <div class="col-xs-12 table-mobile-box">'.__('Tyre Size',HATT_TEXTDOMAIN).'</div>
                                <div class="col-xs-12 table-mobile-box">'.__('Speed Rating',HATT_TEXTDOMAIN).'</div>
                                <div class="col-xs-12 table-mobile-box">'.__('Load Index',HATT_TEXTDOMAIN).'</div>
                                <div class="col-xs-12 table-mobile-box">'.__('Sidewall',HATT_TEXTDOMAIN).'</div>
                            </div>
                            <div class="col-xs-7">
                                <div class="col-xs-12 table-mobile-box">'.$size.'</div>
                                <div class="col-xs-12 table-mobile-box">'.$ht_tyre_speed_ratio.'</div>
                                <div class="col-xs-12 table-mobile-box">'.$ht_tyre_load_index.'</div>
                                <div class="col-xs-12 table-mobile-box">'.$ht_tyre_sidewall.'</div>
                            </div>
                        </div>';

                    if($ht_tyre_speed_ratio && $ht_tyre_load_index && $ht_tyre_sidewall){
                        $show_ratio_load_table = true;
                    }

                endwhile;
                wp_reset_query();

            endif;
        endif;
        ;?>
        <?php if( !empty($size_selected) && $show_ratio_load_table ) : ?>
            <?php if($show_oetyre_table==1){
                //$learnmore_url = get_permalink(754);
                $learnmore_url = site_url( '/learn/original-equipment/');
            ?>
            <div class="single-oetyre-box">
                <div class="single-oetyre-desc">
                    <div><?php printf( __( 'This is the Original Equipment (OE) tyre* that came with your vehicle. <a href="%1$s">Learn more</a> about OE tyres.', 'kryptonite' ), esc_url( $learnmore_url ) ); ?></div>
                    <div><?php _e('*David Tyre Company supplies this tyre for certain variants of this car model on a non-exclusive basis',HATT_TEXTDOMAIN);?></div>
                </div>
                <?php
                if(!empty($_SESSION['oecombi_label'])){
                    $labels_oecombi = unserialize($_SESSION['oecombi_label']);
                    if(is_array($labels_oecombi)){
                        echo '<div class="single-oetyre-model">';
                        echo '<div class="label-vehicle">'.__('Vehicle Model - ',HATT_TEXTDOMAIN).'</div>';
                        echo '<div class="label-cates">';
                        foreach($labels_oecombi as $clabel){
                            echo '<span>'.$clabel.'</span>';
                            echo ( end($labels_oecombi) != $clabel )? ' / ': '' ;
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <?php } ?>
            <div class="size-rating-index-sidewall">
                <table width="100%" class="table-destop hidden-xs">
                    <tbody>
                    <tr>
                        <th> <?php _e('Tyre Size',HATT_TEXTDOMAIN);?></th>
                        <th> <?php _e('Speed Rating',HATT_TEXTDOMAIN);?></th>
                        <th> <?php _e('Load Index',HATT_TEXTDOMAIN); ?></th>
                        <th> <?php _e('Sidewall',HATT_TEXTDOMAIN); ?></th>
                    </tr>
                    <?php echo ($html_size_desktop);?>
                    </tbody>
                </table>
                <div class="table-mobile visible-xs owl-carousel">
                    <?php echo ($html_size_mobile);?>
                </div>
            </div>

        <?php endif;?>

    <?php endif;?>

    <?php
     $ratings = get_post_meta( get_the_ID(), 'ht_tyre_ratings',true );

     if($ratings != '') :
    ?>

    <div class="box-colspace detail-box tyre-box-feature-txt">
        <h2 class="title box-open"><a href="#">
          <?php _e('Performance Ratings',HATT_TEXTDOMAIN); ?>*               
        </a></h2>

        <div class="box-colspace-content" style="display: block;">
            <div class="row">
                    <?php  
                      
                        $features = explode(PHP_EOL,  trim($ratings) );
                        
                        foreach ($features as $key => $feature) :
                
                            list($feature_label, $feature_score)  = explode(':', $feature);
                    ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-8 ">
                                        <?php echo $feature_label;?>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-4 text-left">
                                       <?php echo do_shortcode('[usr '.trim($feature_score).' text="false"]'); ?>
                                </div>
                            </div>  
                        </div>
                        
                    <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php endif;?>


    <div class="box-colspace detail-box tyre-box-feature-txt">
        <h2 class="title box-open"><a href="#">
          <?php _e('FEATURES AND BENEFITS',HATT_TEXTDOMAIN); ?>                 
        </a></h2>

        <div class="box-colspace-content" style="display: block;">
            <div class="row">
                <div class="col-sm-12">
                    <?php the_content()?>

                </div>
            </div>
        </div>
    </div>


    <?php
    $spec = get_post_meta(get_the_ID(), 'ht_tyre_specifications', TRUE);
    if ($spec and SITE_LOCALE!="kr"): //added the site local condition to remove this feature on korea site only ?>
    <div class="box-colspace detail-box tyre-box-spec-txt">
        <h2 class="title box-open"><a href="#">
            <?php _e('Available sizes',HATT_TEXTDOMAIN); ?>
          </a></h2>
        <div class="box-colspace-content">

            <div class="row">
                <div class="col-sm-12"><?php echo ($spec); ?></div>
            </div>
        </div>
    </div>
    <?php endif; ?>




    <?php 
    if($ratings != '') :
    ?>
    <div class="prating-disclaimer" style="display: block;">
        <div class="row">
        <div class="col-xs-12">
            <p>*This rating tool provides rating of parameters which are determined through generic profiling and internal assessments done by David Tyre Company India Limited (GIL) Associates.</p>
             
            <p>The ratings are merely directional and the tool is developed with the objective of aiding the customers/consumers in making an informed choice / decision and the same shall not be construed to be an expert’s advice.</p>
             
            <p>The performance of the tyre may vary from the rating provided on the website as the same is dependent on various variables associated with the car. David Tyre Company India Limited (GIL) and any of its affiliates etc. shall not be responsible for any such difference or variation in the performance etc. of the tyre.</p>
             
            <p>For any customized advise, specific to the car, please contact the nearest David Tyre Company Authorized Dealer.</p>
        </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        jQuery(document).ready(function ($){
            //call to action layer
            var $rightDiv = $('.type-right.type_border');

            function AdjustCallToActionLayerHeight(){
                var $leftHeight = $('.icon-box.single-tyres-icon-box').height();
                var $rightHeight = $rightDiv.height();

                //adjust based on left if longer
                if ($(document).width() >= 768 && $leftHeight > $rightHeight){
                    $rightDiv.attr("style","height:" + $leftHeight + "px !important");
                }
            }

            $(window).resize(function(){
                if ($(document).width() < 768){
                    //remove height if mobile view
                    $rightDiv.removeAttr("style"); 
                }
                else{
                    AdjustCallToActionLayerHeight();
                }
            });

            //makes left layer and right layer height the same
            AdjustCallToActionLayerHeight()
        });
    </script>

<!-- </div> -->
<!-- end container -->