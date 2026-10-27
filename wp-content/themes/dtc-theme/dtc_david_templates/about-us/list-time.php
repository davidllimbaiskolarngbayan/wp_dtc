<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 5/12/2015
 * Time: 12:50 AM
 */
//	$default = array(
//		'ht_time_line_title',
//		'ht_time_line_desc',
//	);

extract($data);
global $stt,$last;
	$stt=0;
   $last = substr_count($content,'[ht_timeline_about_us_item');
?>
<div class="aboutus-tab-content ">
<div class="text-center">
	<p class="about_dtc_title"><?php echo $ht_time_line_title;?></p>
	<!-- <div style="padding: 10px;" class=""> -->
	<?php echo  $ht_time_line_desc;?>
	<!-- </div> -->
	<div class="aboutus-timeline-title hidden-xs">
		<?php _e("Scroll down to <br>explore our timeline", HATT_TEXTDOMAIN) ?><br>		
	</div>

	<div class="timeline">
		<div class="blow-fixed hidden-xs"></div>

		<?php echo do_shortcode($content);?>
		<?php unset( $stt)?>
	</div>
</div>
</div>