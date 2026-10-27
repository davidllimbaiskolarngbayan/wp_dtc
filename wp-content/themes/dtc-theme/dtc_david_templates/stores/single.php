<?php
    if(SITE_LOCALE=='cn'){
        wp_enqueue_script( "baidu.api");
        wp_enqueue_script( "baidu-texticon");
        wp_enqueue_script( "baidu-cluster");
        wp_enqueue_script( "baidu.area.restrict");
    }else{
        wp_enqueue_script( "google-map");
        wp_enqueue_script( "google-map-clustering");
    }
?>
<div class="store-map">
<div class="detail">
    <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">

                <?php 

                    $ht_store_address = get_post_meta( get_the_ID(), 'ht_store_address', TRUE );
                    $lat = get_post_meta(get_the_ID(),'ht_store_map_lat',true);
                    $long = get_post_meta(get_the_ID(),'ht_store_map_long',true);
                    $uhp_rof = get_post_meta(get_the_ID(),'ht_uhp_rof_tyre_available',true);
                    $zpo = get_post_meta(get_the_ID(),'ht_dtc_zero_percent_outlet',true);
                    
                    if(SITE_LOCALE=="cn") {
                        // $mapurl='http://map.baidu.com/?l=&s=s%26wd%3D';
                        $mapurl='http://map.baidu.com/?l=&s=s%26wd%3D'.urlencode($ht_store_address);
                    }else{
                        $mapurl='http://maps.google.com/?q='.urlencode(get_the_title() . " " . $ht_store_address);
                    }

                    ?>
                     <p class="address">
                          <strong><?php echo the_title(); ?></strong><br/>
                          <span style="font-weight: normal;"><?php echo esc_attr($ht_store_address); ?></span>
                          <br />
                     </p>
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                     <p class="phone hidden-xs">
                        <?php 
								$phone = get_post_meta( get_the_ID(), 'ht_store_phone', true ); 
								 $slug  = urldecode( get_post_field( 'post_name', get_the_ID() ) );
								if ( $phone ) {
									echo '<a href="tel:' . esc_attr( $phone ) . '" class="storelocator-phone" data-qa-id="' . esc_attr( $slug ) . '">
											<span style="font-weight:bold; text-decoration: underline;">' . esc_html( $phone ) . '</span>
										</a>';
								}
							?>
                     </p>
                     <?php if(get_post_meta( get_the_ID(), 'ht_store_email', TRUE )) :?>
                <p class="email">
                          <i class="fa fa-envelope"></i>
                          <a href="mailto:<?php echo get_post_meta( get_the_ID(), 'ht_store_email', TRUE ); ?>">
                          <?php echo get_post_meta( get_the_ID(), 'ht_store_email', TRUE ); ?>
                          </a>
                </p>
                <?php endif;?>
                
                <?php if(get_post_meta( get_the_ID(), 'ht_whatsapp_link', TRUE )) :?>
                <p>
                          <a href="<?php echo get_post_meta( get_the_ID(), 'ht_whatsapp_link', TRUE ); ?>" target="_blank">
                          <img src="/wp-content/themes/dtc-theme/images/WhatsApp_Logo_1.png" height="45">
                          </a>
                </p>
                <?php endif;?>              
                </div>
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <?php
                        $terms = wp_get_post_terms( get_the_ID(), 'store_cat' );
                        if ( ! is_wp_error( $terms ) ):
                        foreach ( $terms as $key => $val ):
                            $img = get_tax_meta( $val->term_id, 'store_cat_image' );
                            if ( $img ): ?>
                                 <p><img style="max-width: 50%;margin: auto;" class="img-responsive"
                                            src="<?php echo esc_attr( $img['url'] );?>" alt="" /></p>
                    <?php else: ?>
                                 <p>
                                     <!-- <a href="<?php echo get_term_link( $val->term_id, 'store_cat' ); ?>"><?php echo esc_attr( $val->name ) ?></a> -->
                                      <?php echo esc_attr( $val->name ) ?>
                                 </p>

                    <?php endif;endforeach;endif ?>

                </div>

                <div class="col-lg-3 col-sm-6 col-xs-12">
                        <?php
                         global $post;
                         $page_slug = $post->post_name;
                         $registration_url = function_exists('dtc_registration_url_for_store_slug')
                             ? dtc_registration_url_for_store_slug($page_slug)
                             : home_url('/register-your-tyres/');
                         $url = function_exists('dtc_registration_qr_image_url')
                             ? dtc_registration_qr_image_url($registration_url, 500)
                             : '';
                         $thumb = function_exists('dtc_registration_qr_image_url')
                             ? dtc_registration_qr_image_url($registration_url, 150)
                             : '';
                    ?>
                     <?php if ($url && $thumb) : ?>
                     <div class="hidden-xs dtc-store-registration-qr" style="text-align:center">
                        Register your tyres
                        <div style="margin-bottom: -10px;">
                            <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" referrerpolicy="no-referrer">
                                <img src="<?php echo esc_url($thumb); ?>" alt="QR code linking to the DTC tyre registration form" loading="lazy" width="150" height="150"><br>
                                <small>Click to enlarge</small>
                            </a>
                        </div>
                     </div>
                     <?php endif; ?>

                </div>

                <div class="col-lg-12 col-sm-12 col-xs-12">
                <?php if($uhp_rof == "on" || $zpo == "on"): ?>
                <div class="col-lg-12 col-sm-12 col-xs-12 store-zpo-uhp"><p><strong>Available Here:</strong></p></div>
                <?php if($zpo == "on"): ?>
                <div class="col-lg-4 col-sm-12 col-xs-12 store-zpo"><div class="col-sm-5"><p><img src="/wp-content/uploads/zpo.png" alt="0% interest payment plans"></p></div><div class="col-sm-7" style="padding-right:5px">0% interest installment plan<p></p></div></div>
                <?php endif; ?>
                <?php if($uhp_rof == "on"): ?>
                <div class="col-sm-12 col-lg-5 store-uhp"><div class="col-sm-5"><p><img src="/wp-content/uploads/uhp-rof.png" alt="David Tyre Company UHP Tires and Run-On-Flat Tires"></p></div><div class="col-sm-7">David Tyre Company UHP Tires and Run-On-Flat Tires<p></p></div></div>                           
                <?php endif; ?>
                <?php endif; ?>
                
                <?php if( SITE_LOCALE != "in") :?>
                <div class="row">
                <div class="col-sm-12"><p class="get-direction"><a href="<?php echo $mapurl; ?>" target="_blank"><?php _e('Get Directions',HATT_TEXTDOMAIN); ?></a></div>
                </div>
                <?php endif;?>
                </div>  
                <div class="col-lg-3 col-sm-6 col-xs-12">
                  <p class="phone visible-xs">
                  <?php $storephone=get_post_meta( get_the_ID(), 'ht_store_phone', TRUE ); 
							$slug  = urldecode( get_post_field( 'post_name', get_the_ID() ) );?>
					<script>console.log("0");</script>
					<a class="storelocator-phone" href="tel:<?php echo $storephone; ?>" data-qa-id="<?php echo esc_attr( $slug ) ?>">
					<span style="font-weight:bold"><?php echo $storephone; ?></span>
					</a>
                  </p>
                  </div>
                

          </div>

          </div>



     </div>



     
     <?php       

    if($lat and $long): ?>
    
    <div style="min-height: 300px; margin-top:0px" id="google-map-store" class="google-map"></div>
 
        <?php 
        // echo ">".empty($cookielasttyre)."<";
		$cookielasttyre = $_COOKIE['last_tyre'] ?? "";
        $cookielasttyre = preg_replace("/[^0-9]+/", " ", $cookielasttyre);
        if( empty($cookielasttyre) ){
            $cookielasttyre="null";
        }

        ?>

        <script type="text/javascript">
            var check = <?php echo esc_html($cookielasttyre); ?>;
            if ( check != null) {
                 jQuery(document).ready(function ($) {
                      $('.show-alert').css('display','block');
                 });
            }
            var mlat=<?php echo $lat; ?>;
            var mlong=<?php echo $long; ?>;
            var SITE_LOCALE="<?php echo SITE_LOCALE; ?>";

            function initBaiduMap() {
                console.log("baidu");
                var map = new BMap.Map("google-map-store");
                map.centerAndZoom(new BMap.Point(mlong, mlat), 15);  
                // map.addControl(new BMap.MapTypeControl());  
                map.addControl(new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT}));  
                map.enableScrollWheelZoom(true); 
                // map.setCurrentCity("北京");
                // add marker
                // translate google coord to baidu coord 
                var ggPoint=new BMap.Point(mlong, mlat);
                var marker = new BMap.Marker(ggPoint);
                map.addOverlay(marker);
                    console.log("original",ggPoint);

                /*setTimeout(function(){ 
                BMap.Convertor.translate(ggPoint,2,function(point){
                    var marker2 = new BMap.Marker(point);
                    map.addOverlay(marker2);
                    console.log("converted",point);
                });
                }, 2000);*/
                
                // var marker = new BMap.Marker(new BMap.Point (116.403884,39.914887));  
                var contentString = "<p><?php echo the_title();?></p>" +
                  "<?php echo $ht_store_address ?>";
                var opts1 = {width: 300};
                var infoWindow = new BMap.InfoWindow (contentString, opts1);  
                marker.openInfoWindow (infoWindow);  
                marker.addEventListener ('click', function () {
                    marker.openInfoWindow (infoWindow);
                });


            }

            function initialize() {
                console.log("gmap");
                 var myLatlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $long;?>);
                 var iconmarker = "<?php echo get_stylesheet_directory_uri().'/images/GoogleMarker.png';?>";
                 var mapOptions = {
                      zoom: 17,
                      center: myLatlng
                 }
                 var contentString = "<p><?php echo the_title();?></p>" +
                      "<?php echo $ht_store_address ?>";
                 var infowindow = new google.maps.InfoWindow({
                      content: contentString
                 });
                 var map = new google.maps.Map(document.getElementById('google-map-store'), mapOptions);
                 var marker = new google.maps.Marker({
                      position: myLatlng,
                      map: map,
                      title: '<?php echo  get_the_title();?>',
                      icon:iconmarker,
                      draggable:true,
                      animation: google.maps.Animation.DROP
                 });
                 google.maps.event.addListener(marker, 'click', function() {
                      infowindow.open(map,marker);
                 });
            }

            function baiduCallback(){
                if(SITE_LOCALE=='cn') { 
                    initBaiduMap();
                }
            }

            if(SITE_LOCALE=='cn') {             
                setTimeout(function(){
                    initBaiduMap();
                },1000);
            }else{
                jQuery(document).ready(function(){
                    initialize();
                });
            }

                

        </script>
    <?php endif;?>
</div>








<?php 

if(!empty( the_content() )) {

?>

<div class="box-colspace">
     <h2 class="title "><a href="#">About this store</a></h2>

     <div class="box-colspace-content">
          <div class="row">
                <?php if ( has_post_thumbnail() ):; ?>
                     <div class="col-sm-4">
                          <div class="store-about-img">
                                <?php the_post_thumbnail( 'full' ); ?>
                          </div>
                     </div>
                     <div class="col-sm-8">
                          <?php the_content(); ?>
                     </div>
                <?php else: ?>
                     <div class="col-sm-8">
                          <?php the_content(); ?>
                     </div>
                <?php endif; ?>
          </div>
     </div>
</div>


<?php 

}

// check if there is store services
if( !empty(get_post_meta( get_the_ID(), 'ht_store_services', TRUE )) ) {


?>

<div class="box-colspace box-open">
     <h2 class="title box-open"><a href="#">Provided services</a></h2>

     <div class="box-colspace-content">
          <div class="row">
                <?php echo get_post_meta( get_the_ID(), 'ht_store_services', TRUE ); ?>
          </div>
     </div>

</div>


<?php

}

if( false ) {

?>


<div class="box-colspace store-review">
     <h2 class="title "><a href="#">Reviews</a></h2>

     <div class="box-colspace-content">
          <div class="row hidden-xs">
                <div class="col-sm-6">
                     <div class="store-review-box">
                          <div class="store-review-img">
                                <img
                                     src="<?php echo esc_url( get_template_directory_uri() ) . '/images/store-review-img1.jpg'; ?>">
                          </div>
                          <div class="store-review-box-head">
                                <div class="pull-left">
                                     <p class="name"><strong>Max Chen</strong></p>

                                     <p class="datetime">2 months ago</p>
                                </div>
                                <div class="pull-right">
                                     <img src="<?php echo esc_url( get_template_directory_uri() ) . '/images/rating.jpg'; ?>">

                                </div>
                          </div>
                          <div class="store-review-box-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
                                    Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar
                                    tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus
                                    mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus
                                    sapien nunc eget odio.</p>
                          </div>
                     </div>
                </div>
                <div class="col-sm-6">
                     <div class="store-review-box">
                          <div class="store-review-img">
                                <img
                                     src="<?php echo esc_url( get_template_directory_uri() ) . '/images/store-review-img2.jpg'; ?>">

                          </div>
                          <div class="store-review-box-head">
                                <div class="pull-left">
                                     <p class="name"><strong>Jason Yeo</strong></p>

                                     <p class="datetime">3 months ago</p>
                                </div>
                                <div class="pull-right">
                                     <img src="<?php echo esc_url( get_template_directory_uri() ) . '/images/rating.jpg'; ?>">
                                </div>
                          </div>
                          <div class="store-review-box-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
                                    Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar
                                    tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus
                                    mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus
                                    sapien nunc eget odio.</p>
                          </div>
                     </div>
                </div>
          </div>

          <div class="row visible-xs">
                                     <div class="col-sm-6 item">
                                          <div class="store-review-box">
                                                <div class="store-review-img">
                                                     <img src="images/store-review-img1.jpg">
                                                </div>
                                                <div class="store-review-box-head">
                                                     <div class="pull-left">
                                                          <p class="name"><strong>Max Chen</strong></p>

                                                          <p class="datetime">2 months ago</p>
                                                     </div>
                                                     <div class="pull-right">
                                                          <img src="images/rating.jpg">
                                                     </div>
                                                </div>
                                                <div class="store-review-box-content">
                                                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod
                                                         bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra
                                                         justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus
                                                         et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum,
                                                         nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus
                                                         sapien nunc eget odio.</p>
                                                </div>
                                          </div>
                                     </div>
                              
                                
                                     <div class="col-sm-6 item">
                                          <div class="store-review-box">
                                                <div class="store-review-img">
                                                     <img src="images/store-review-img2.jpg">
                                                </div>
                                                <div class="store-review-box-head">
                                                     <div class="pull-left">
                                                          <p class="name"><strong>Jason Yeo</strong></p>

                                                          <p class="datetime">3 months ago</p>
                                                     </div>
                                                     <div class="pull-right">
                                                          <img src="images/rating.jpg">
                                                     </div>
                                                </div>
                                                <div class="store-review-box-content">
                                                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod
                                                         bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra
                                                         justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus
                                                         et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum,
                                                         nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus
                                                         sapien nunc eget odio.</p>
                                                </div>
                                          </div>
                                     </div>
                            
                     </div>

  
                </div>
          </div>
     </div>

</div>

<?php

}

?>

<!-- ratings block moved to rating.html -->