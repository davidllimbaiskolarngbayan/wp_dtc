<?php
$uploads = wp_upload_dir();
$imagePath = sprintf("%s/%s",get_site_url(), "wp-content/themes/dtc-theme/images/dtc"); //esc_url( $uploads['baseurl'] );
?>
<div id="dtc-wrapper" class="panel-body" style="background-color: #FFF;">

    <div class="hidden-xs">
        <div class="row vehicle-header">
            <h2 class="thank-you-title text-center"><?php _e('David Tyre Company is peace of mind on the road', HATT_TEXTDOMAIN); ?></h2>
        </div> <!-- /.row .vehicle-header -->

        <div class="row vehicle-sub-header">
            <div class="col-sm-12">
                <p><?php _e('Drive in good company with David Tyre Company. With our tyres, your car is well taken care of, all you have to do is to enjoy the drive. ', HATT_TEXTDOMAIN); ?><br>          
                <?php _e('Starting from 1 July 2022, all purchase of David Tyre Company consumer tyres will enjoy these 3 benefits for added peace of mind on the road.', HATT_TEXTDOMAIN); ?></p>            
            </div> <!-- /.col-sm-12 -->
        </div> <!-- /.row vehicle-sub-header -->

        <div class="row">
            <div class="col-sm-4 vehicle-text">
                <div class="wpb_single_image wpb_content_element vc_align_center">
                    <div class="wpb_wrapper">
                        <div class="vc_single_image-wrapper vc_box_border_grey">
                            <img width="172" height="95" src="<?php echo $imagePath."/dtc_road_warranty.png"; ?>" class="vc_single_image-img attachment-full" alt="dtc-vehicle-1">
                        </div> <!-- /.vc_single_image-wrapper vc_box_border_grey -->
                    </div> <!-- /.wpb_wrapper -->
                </div> <!-- /.wpb_single_image wpb_content_element vc_align_center -->

                <h3><?php _e('1 YEAR ROAD HAZARD WARRANTY', HATT_TEXTDOMAIN); ?></h3>
                <p><?php _e('Free 1 to 1 exchange if damage by road hazards that is beyond repair', HATT_TEXTDOMAIN); ?></p>
            </div> <!-- /.col-sm-4 vehicle-text -->
            
            <div class="col-sm-4 vehicle-text">
                <div class="wpb_single_image wpb_content_element vc_align_center">
                    <div class="wpb_wrapper">
                        <div class="vc_single_image-wrapper vc_box_border_grey">
                            <img width="172" height="95" src="<?php echo $imagePath."/dtc_safety_check.png"; ?>" class="vc_single_image-img attachment-full" alt="dtc-vehicle-4">
                        </div> <!-- /.vc_single_image-wrapper vc_box_border_grey -->
                    </div> <!-- /.wpb_wrapper -->
                </div> <!-- /.wpb_single_image wpb_content_element vc_align_center -->
                <h3><?php _e('2 X FREE TYRE SAFETY CHECK', HATT_TEXTDOMAIN); ?></h3>
                <p><?php _e('Return to David Tyre Company Autocare that you purchased for tyre check after 6 months & 1 year.', HATT_TEXTDOMAIN); ?></p>
            </div> <!-- /.col-sm-4 vehicle-text -->

            <div class="col-sm-4 vehicle-text">
                <div class="wpb_single_image wpb_content_element vc_align_center">
                    <div class="wpb_wrapper">
                        <div class="vc_single_image-wrapper vc_box_border_grey">
                            <img width="172" height="95" src="<?php echo $imagePath."/dtc_warranty.png"; ?>" class="vc_single_image-img attachment-full" alt="dtc-vehicle-11">
                        </div> <!-- /.vc_single_image-wrapper vc_box_border_grey -->
                    </div> <!-- /.wpb_wrapper -->
                </div> <!-- /.wpb_single_image wpb_content_element vc_align_center -->
                <h3><?php _e('5 YEAR LIMITED WARRANTY', HATT_TEXTDOMAIN); ?></h3>
                <p><?php _e('Manufacturing warranty from date of purchase.', HATT_TEXTDOMAIN); ?></p>
            </div> <!-- /.col-sm-4 vehicle-text -->
        </div> <!-- /.row -->

        <div class="row">
            <div class="col-sm-12">
                <?php //echo do_shortcode('[vc_column_inner el_class="" width="1/3" ht_no_padding="no" ht_effect="item_none"]'); ?>
                <p style="font-style: italic; text-align: right;"><a style="color: #01518e; text-decoration: underline;" href="/warranty/worry-free-assurance/tnc">

                <?php _e('* Terms and conditions apply', HATT_TEXTDOMAIN );  ?></a></p>
            </div> <!-- /.col-sm-4 vehicle-text -->
        </div> <!-- /.row -->

        <div class="row" style="height: 5px;"></div>
    </div> <!-- /.hidden-xs -->

    <div class="visible-xs">
        <div class="row vehicle-header" style="margin: 0em -1.8em 0em !important;">
            <h2 class="thank-you-title text-center"><?php _e('David Tyre Company is peace of mind on the road', HATT_TEXTDOMAIN); ?></h2>
        </div> <!-- /.row .vehicle-header -->

        <div class="row vehicle-sub-header" style="margin: 0em -2em -0.5em !important">
            <div class="col-sm-12">
                <p><?php _e('Drive in good company with David Tyre Company. With your tyres, your car is well taken care of, all you have to do is to enjoy the drive.', HATT_TEXTDOMAIN); ?></p>
            </div> <!-- /.col-sm-12 -->
        </div> <!-- /.row vehicle-sub-header -->

        <?php 
            $vehicleInfo = [

                [
                    'image_name' => 'dtc_road_warranty.png',
                    'title' => _x('1 YEAR ROAD HAZARD WARRANTY', HATT_TEXTDOMAIN),
                    'content' => [
                        "<p>"._x('Free 1 to 1 exchange if damage by road hazards that is beyond repair', HATT_TEXTDOMAIN)."</p>",
                    ]
                ],

                [
                    'image_name' => 'dtc_safety_check.png',
                    'title' => _x('2 X FREE TYRE SAFETY CHECK', HATT_TEXTDOMAIN),
                    'content' => [
                        "<p>"._x('Return to David Tyre Company Autocare that you purchased for tyre check after 6 months & 1 year.', HATT_TEXTDOMAIN)."</p>"
                    ]
                ],

                [
                    'image_name' => 'dtc_warranty.png',
                    'title' => _x('5-YEAR LIMITED WARRANTY', HATT_TEXTDOMAIN),
                    'content' => [
                        "<p>"._x('Manufacturing warranty from date of purchase.', HATT_TEXTDOMAIN)."</p>"
                    ],
                ],
                
            ]
        ?>

        <div id="vehicle-info">
            <?php foreach ($vehicleInfo as $v) { ?>
                <div class="row">
                    <div class="box-colspace visible-xs">
                        <h2 class="title box-close"> <a href="#"> 
                            
                            <div class="row">
                                <div class="col-xs-4">
                                    <img src="<?php echo $imagePath."/".$v['image_name']; ?>" height="50" weight="70" class="img-responsive">
                                </div> <!-- /.col-xs-4 -->
                                <div class="col-xs-7">
                                    <?php _e($v['title'], HATT_TEXTDOMAIN); ?>
                                </div> <!-- /.col-xs-7 -->
                            </div> <!-- /.row -->
                        
                        </a></h2>
                        
                        <div class="box-colspace-content clearfix" style="display: none;">
                            <?php foreach ($v['content'] as $content) { 
                                echo $content;
                            } ?>
                        </div>
                    </div> <!-- /.box-colspace -->
                </div><!-- /.row -->
            <?php } ?>

            <div class="row text-center" style="padding: 15px 0px 5px;">
                <a style="color: #01518e; text-decoration: underline; font-style: italic;" href="/warranty/worry-free-assurance/tnc">
                <?php _e('* Terms and conditions apply', HATT_TEXTDOMAIN) ;  ?></a>
            </div>
            
        </div> <!-- /.vehicle-info -->
    </div> <!-- /.visible-xs -->
</div><!-- /.panel-body -->