<?php
	// Author: Adrian Tee
	// Email: adrian.tee@mrm-mccann.com
	// Date: 29 Jul 2015
?>
<div class="detail-top">

	<!-- SOCIAL banner_before_content.php -->
	<div class="social_bar clearfix text-right">
		<span class="twitter">
				<a target="_blank" href="https://twitter.com/home?status=<?php the_permalink();?>"><i class="fa fa-twitter"></i>Twitter</a></span>
		<!-- <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon-twitter.png');?>"> -->
		<span class="facebook">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>"><i class="fa fa-facebook"></i>Facebook</a></span>
		<!-- <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon-facebook.png');?>"> -->
		<!--<span class="email">
				<a href="mailto:?subject=Share&body=<?php echo $sharetitle ?? "";?>%0D%0A<?php the_permalink();?>"><i class="fa fa-envelope"></i>Email</a></span>
		<span class="weibo">
				<a target="_blank" href="http://service.weibo.com/share/share.php?url=<?php the_permalink();?>&title=<?php echo $sharetitle ?? "";?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/cn/icon-weibo.png');?>"> <?php _e('Weibo',HATT_TEXTDOMAIN); ?></a></span>-->
		<!-- <span class="wechat">
				<a target="_blank" href="<?php echo esc_url(get_template_directory_uri() . '/images/cn/WeChat_QR_Code_Consumer.jpg'); ?>" rel="prettyPhoto"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/cn/icon-wechat.png');?>">Wechat</a></span> -->
		<!--<span class="print hidden-xs"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon-print.png');?>"> <?php _e('print page',HATT_TEXTDOMAIN); ?></span>-->
	</div>

	<div class="row">
		<div class="col-sm-12">
			<?php 

				$promobanner = get_post_meta( get_the_ID(), 'ht_offer_promo_banner', TRUE );
				if($promobanner) {
					echo '<img class="img-responsive hero-image" src="'.$promobanner.'" alt="" />';
				}
				$promoinfo = get_post_meta( get_the_ID(), 'ht_offer_promo_info', TRUE );
				if($promoinfo){
					echo '<p>'.$promoinfo.'</p>';
				}
			?>
		</div>
	</div>
</div>

<div class="detail">	
	<?php the_content(); ?>
</div>


<?php

// check if there is store services
if( !empty(get_post_meta( get_the_ID(), 'ht_offer_terms', TRUE )) && ( get_post_meta( get_the_ID(), 'ht_offer_terms_show', TRUE ) == "on")) {


?>

<div class="box-colspace box-open">
	 <h2 class="title box-open"><a href="#"><?php _e( 'TERMS AND CONDITIONS', HATT_TEXTDOMAIN ) ?></a></h2>

	 <div class="box-colspace-content">
		  <div class="row">
				<?php echo get_post_meta( get_the_ID(), 'ht_offer_terms', TRUE ); ?>
		  </div>
	 </div>

</div>


<?php

}
