<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 5/19/2015
 * Time: 3:30 PM
 */

session_start();
		

if(!isset($_SESSION['items'])){
	$_SESSION['items'] = array();
}else{
	unset($_SESSION['last_vehicle_name']);
}




extract( $data_header );
?>
<h1><?php echo esc_attr($ht_title);?></h1>

<!--<p><?php echo esc_attr( $ht_sub_title );?></p>-->

<div class="col-sm-12">	
	<?php echo do_shortcode( $content );?>
</div>