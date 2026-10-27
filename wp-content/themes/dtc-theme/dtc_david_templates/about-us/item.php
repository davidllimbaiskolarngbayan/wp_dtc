<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 5/12/2015
 * Time: 12:53 AM
 */
//	$default = array(
//		'ht_item_time',
//		'ht_item_image',
//		'ht_item_desc'
//	);
	global $stt,$last;
	$class='';
	$img ='';
extract($data);
	if($stt==0){
		$class = 'timeline-active';
	}
    if($last-1==$stt){
        $class .=' last_item';
    }
	if(!empty($ht_item_image)){
		$img_url = wp_get_attachment_image_src( $ht_item_image, 'full' );
		if ( $img_url[0] ):
			$img = '<a class="ht_light_box" href="'.$img_url[0].'"><img src="'.$img_url[0].'" class="img-responsive"></a>';
		 endif;
	}
?>

<div class="timeline-detail col-sm-12 <?php echo esc_attr($class);?>" id="<?php echo 'timeline'.$stt ;?>">
    <div class="hidden-xs">
        <?php if(($stt+1)%2==0):?>
            <div  class="timeline-detail-left col-sm-6 text-right"></div>
            <div class="timeline-detail-right col-sm-6 text-left border-left">
                <div class="timeline-blow"></div>
                <div class="timeline-effect">
                    <div class="col-sm-8 col-md-8 col-lg-8">
                        <div class="timeline-date col-sm-12"><?php echo esc_attr($ht_item_time);?></div>
                        <div class="col-sm-12 font-arial">
                            <?php echo esc_attr($ht_item_desc);?>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 aboutus-avatar">
                        <?php echo $img;?>
                    </div>
                </div>
            </div>
        <?php else:;?>
            <div class="timeline-detail-left col-sm-6 text-right border-right">
                <div class="timeline-blow"></div>
                <div class="timeline-effect">
                    <div class="col-sm-4 col-md-4 col-lg-4 aboutus-avatar">
                        <?php echo $img;?>
                    </div>
                    <div class="col-sm-8 col-md-8 col-lg-8">
                        <div class="timeline-date col-sm-12"><?php echo esc_attr($ht_item_time);?></div>
                        <div class="col-sm-12 font-arial">
                            <?php echo esc_attr($ht_item_desc);?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="timeline-detail-right col-sm-6 text-left "></div>
        <?php endif;?>
    </div>
    <div class="visible-xs" style="padding: 0 20px;">
        <div  class="timeline-detail-left col-sm-6 text-right"></div>
        <div class="timeline-detail-right col-sm-6 text-left border-left">
            <div class="timeline-blow"></div>
            <div class="timeline-effect">
                <div class="col-sm-8 col-md-8 col-lg-8">
                    <div class="timeline-date col-sm-12"><?php echo esc_attr($ht_item_time);?></div>
                    <div class="col-sm-12 font-arial">
                        <?php echo esc_attr($ht_item_desc);?>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 aboutus-avatar">
                    <?php echo $img;?>
                </div>
            </div>
        </div>
    </div>

</div>
<!--<div class="timeline-detail-mobile text-left visible-xs col-sm-12">-->
<!--    <p class="timeline-date">--><?php //echo esc_attr($ht_item_time);?><!--</p>-->
<!--    <div class="font-arial">-->
<!--        --><?php //echo esc_attr($ht_item_desc);?>
<!--    </div>-->
<!--</div>-->
<?php $stt++;?>