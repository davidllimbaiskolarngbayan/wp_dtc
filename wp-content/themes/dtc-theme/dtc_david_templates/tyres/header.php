<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 5/19/2015
 * Time: 3:30 PM
 */
extract( $data_header );
?>

<p id="find-tyre-title"><?php echo esc_attr($ht_title);?></p>

<!--<p><?php echo esc_attr( $ht_sub_title );?></p>-->
<?php
echo do_shortcode( $content );;?>