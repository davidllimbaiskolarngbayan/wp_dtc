<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/3/2015
	 * Time: 2:07 PM
	 */ ?>
<?php

	$title = $img = $class = $id = $img_mb = '';
	if (is_archive()) {
		if (is_category() or is_tag()) {
			$queried_object = get_queried_object();
			if (isset($queried_object->term_id)) {
				$term_id = $queried_object->term_id;
				$banner = get_tax_meta($term_id, 'cat_image');
				if (!empty($banner) and $banner['url']) {
					$img = $banner['url'];
					$title = $queried_object->name;
				}
			}
		} else {
			if (is_tax()) {
				$the_tax = $wp_query->get_queried_object();
				$title = $the_tax->name; 
				$term_name = $title;
				$img = get_tax_meta($the_tax->term_id, 'store_cat_image');
				
				if($the_tax->taxonomy == "video_cat") {
					$post_type = $wp_query->query;
					$post_type['post_type'] = "video";
					$img = hatt()->get_option('video_banner', FALSE);
					if (hatt()->get_option('video_banner_title', FALSE)) {
						$title = hatt()->get_option('video_banner_title', FALSE);
					} else {
						$title = get_post_type_object($post_type['post_type']);
						$title = ($title->labels->singular_name);
					}
					$cat_name  = $title;
				}
			} else {
				$post_type = $wp_query->query;
				if(isset($post_type['post_type'])) {
					switch ($post_type['post_type']) {
						case 'career':
							$img = hatt()->get_option('career_banner', FALSE);
							$title = get_post_type_object($post_type['post_type']);
							$title = ($title->labels->singular_name);
							break;
						case 'learn':
							$img = hatt()->get_option('learn_banner', FALSE);
							if (hatt()->get_option('learn_banner_title', FALSE)) {

								$title = hatt()->get_option('learn_banner_title', FALSE);
							} else {
								$title = get_post_type_object($post_type['post_type']);
								$title = ($title->labels->singular_name);

							}
							break;
						case 'store':
							$img = hatt()->get_option('store_banner', FALSE);
							if (hatt()->get_option('learn_banner_title', FALSE)) {

								$title = hatt()->get_option('store_banner_title', FALSE);
							} else {
								$title = get_post_type_object($post_type['post_type']);
								$title = ($title->labels->singular_name);
							}
							break;
						case 'video':
							$img = hatt()->get_option('video_banner', FALSE);
							if (hatt()->get_option('video_banner_title', FALSE)) {

								$title = hatt()->get_option('video_banner_title', FALSE);
							} else {
								$title = get_post_type_object($post_type['post_type']);
								$title = ($title->labels->singular_name);
							}
							break;						
						default :
							$img = '';
							$title = get_the_title();
					}
				}
			}

		}
	}

	if (is_page()) {
		$img = get_post_meta(get_the_ID(), 'ht_page_banner');
		$title_page = get_post_meta(get_the_ID(), 'ht_page_banner_title', true);
		if (isset($img[0]) and !empty($img[0])) {
			$img = $img[0];
			if ($title_page) {
				$title = $title_page;
			} else {
				$title = get_the_title();
			}
		}
	}
	if (is_search()) {
		$title = "";
	}
	$sharetitle="";

	if (is_single()) {
		if (is_singular('store') or  is_singular('learn')) {
			$title_page = get_post_meta(get_the_ID(), 'ht_page_banner_title', true);
			if ($title_page) {
				$title = $title_page;
			} else {
				$title = get_the_title(get_the_ID());
			}
		}
		$sharetitle=$title;

		if(is_singular('learn')){
			if(get_post_meta(get_the_ID(),'ht_title_banner_off',true)=='off'){
				$title='';
			}
		}
		$img = get_post_meta(get_the_ID(), 'ht_banner', TRUE);
		// Check if img is image ID rather than url string
		if(is_numeric($img)) {
			$img = get_field("ht_banner");
		}
	};
	$img_mb = get_post_meta(get_the_ID(), 'ht_page_banner_mobile', TRUE);
	// Check if img is image ID rather than url string
	if(is_numeric($img_mb)) {
		$img_mb = get_field("ht_page_banner_mobile");
	}


// echo "<br>TITLE:".$sharetitle;
// echo "<br>TITLE:".$title_page;
// echo "<br>TITLE:".get_post_meta(get_the_ID(), 'ht_page_banner_title', true);
// echo "<br>TITLE:".get_the_title(get_the_ID());


?>




<!-- removed commented out code -->
<?php
	if (isset($_GET['compare_true']) and !empty($_GET['compare_true'])) {
		$title = '';
		$img = '';
	}
	if (get_the_ID() == hatt()->get_option('header_find_store_url', true)) {
		$class = 'ht_page_store';
	} else {
		$class = '';
		// $post = get_post(hatt()->get_option('header_find_store_url', true));
		// $post = get_post(get_the_ID());
		// $class = $post->post_name;
		// if($post_type['post_type']){
		if($post_type){
			if(is_array($post_type)){
				$class = $post_type['post_type'];
			}else{
				$class = $post_type;
			}
		}
		// hatt()->get_option('header_find_store_url', true) . " ".get_the_ID() . " ".
		global $post;
		$slug = isset($post) ? get_post($post)->post_name : "";
		$pid=get_the_ID();
		$postcat = get_the_terms($pid, $class.'_cat'); //get category (for learn social btn)
		if(is_array($postcat)){
			if(sizeof($postcat)>0){
				$postcat=$postcat[0]->taxonomy;
			}else{
				$postcat="";
			}
		}else{
			$postcat="";
		}
		// echo "postcat:";
		// print_r($postcat);
		// print_r(get_taxonomies());

		if (isset($_GET['compare_true']) and !empty($_GET['compare_true'])) {
			$class .=" compare";
		}

	}; 
	?>


	<?php
		
	$custom_banner_class="empty";
	if (isset($img[0]) and !empty($img[0])) {
		if ($img[0] == "") $img = "";
	}

	if (wp_is_mobile()) { 

		if (!empty($img_mb)) {		
			$custom_banner_class="non-empty mobile";

			echo "<style>";
			
			if($post_type && isset($post_type['post_type']) && $post_type['post_type']== "video") {
				echo ".custom_banner { background-image: url(".$img.")};";
			}
			else {
				echo ".custom_banner { background-image: url(".$img_mb.")};";
			}
			
			echo "</style>";			
		} else if (!empty($img)) {
			$custom_banner_class="non-empty mobile";	

			echo "<style>";
			echo ".custom_banner { background-image: url(".$img.")};";
			echo "</style>";		
		} else if(is_singular('store')) {
			
			$custom_banner_class="non-empty mobile";
			$upload_dir = wp_upload_dir();

			echo "<style>";
			echo ".custom_banner { background-image: url(".$upload_dir['baseurl']."/2015/04/high_pro12405606.jpg)};";
			echo "</style>";
		
		} else {
			$custom_banner_class="empty mobile";
			
		}
	} else {	//desktop
	
		if (!empty($img)) { 
			echo "<style>";
			echo ".custom_banner { background-image: url(".$img.")};";
			echo "</style>";

			$custom_banner_class="non-empty";				
		}

		if(is_singular('store')){
			$upload_dir = wp_upload_dir();

			echo "<style>";
			echo ".custom_banner { background-image: url(".$upload_dir['baseurl']."/2015/04/high_pro12405606.jpg)};";
			echo "</style>";

			$custom_banner_class="non-empty";	
		}
	} 
 
 ?>



<div class="custom_banner post-id-<?php echo (isset($pid)? $pid : '') . " " . $class . " " . (isset($slug)? $slug : '') . " ". (isset($postcat)? $postcat : '') ." " . $custom_banner_class; ?>">
	

	<div class="container">
	
	    <?php if( isset($the_tax->taxonomy) && $the_tax->taxonomy == "video_cat"): ?>
		<?php echo the_breadcrumb_for_video($cat_name, $term_name ); ?>
		<?php else: ?>
		<?php echo the_breadcrumb(); ?>
		<?php endif; ?>
		
		
		<?php if (!empty($title)):; ?>
			<?php
				if(is_page('tyre') && SITE_LOCALE == "in"){
					global $wp_query;
					$cat = isset($wp_query->query_vars['category']) ? $wp_query->query_vars['category'] : null;
    				$seo_title =  str_replace('-', ' ', $cat) ;
    				$title = ( $seo_title == 'all' ||  $seo_title == '' ) ? __($title) : $seo_title ;
				}
			?>
			<h1 class="ht_title_banner"><?php _e($title) ?> </h1>
		<?php endif;; ?>
		<?php
			if (is_post_type_archive('store')):
				;?>
				<form method="get" action="<?php echo esc_url(ht_get_url_find_store(true));?>"
					  class="store-search hidden-xs">
					<input type="text" name="search" class="store-input-search store-seach-place" placeholder="<?php _e('SEARCH FOR LOCATION',HATT_TEXTDOMAIN); ?>">
					<input type="submit" value="">

					<div class="location-me">
						<a href="javascript:currentloc();">
							<?php 

							_e('LOCATE ME',HATT_TEXTDOMAIN);

							?>
						</a>
					</div>
				</form>
			<?php endif; ?>
		<?php 
			if (is_single() and !is_singular('store') and !is_singular('tyres') and !is_singular('offer')):
					 if ((get_post_meta(get_the_ID(), 'social_banner_show', true)) == 'on' || (($post_type=='learn') && (isset($postcat)) )) :
					;?>

						<!-- SOCIAL banner_before_content.php -->
					<div class="social_bar clearfix text-right">
						<span class="twitter">
								<a target="_blank" href="https://twitter.com/home?status=<?php the_permalink();?>"><i class="fa fa-twitter"></i>X</a></span>
						<!-- <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon-twitter.png');?>"> -->
						<span class="facebook">
								<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>"><i class="fa fa-facebook"></i>Facebook</a></span>
						<!-- <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon-facebook.png');?>"> -->
						<!--<span class="email">
								<a href="mailto:?subject=Share&body=<?php echo $sharetitle;?>%0D%0A<?php the_permalink();?>"><i class="fa fa-envelope"></i>Email</a></span>
						<span class="weibo">
								<a target="_blank" href="http://service.weibo.com/share/share.php?url=<?php the_permalink();?>&title=<?php echo $sharetitle;?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/cn/icon-weibo.png');?>"> <?php _e('Weibo',HATT_TEXTDOMAIN); ?></a></span>-->
						<!-- <span class="wechat">
								<a target="_blank" href="<?php echo esc_url(get_template_directory_uri() . '/images/cn/WeChat_QR_Code_Consumer.jpg'); ?>" rel="prettyPhoto"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/cn/icon-wechat.png');?>">Wechat</a></span> -->
						<!--<span class="print hidden-xs"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon-print.png');?>"> <?php _e('print page',HATT_TEXTDOMAIN); ?></span>-->
					</div>


				<?php endif; endif; ?>

	</div>
</div>
<?php
	if(isset($_COOKIE['last_tyre'])){
		$cookielasttyre = preg_replace("/[^0-9]+/", " ", $_COOKIE['last_tyre']);
	}
	$get_browser_tyre = hatt()->get_option('header_browser_tyre_url',false);
	if( ( is_post_type_archive('store') or get_the_ID()==$get_browser_tyre or is_singular('store') ) && ( isset($_GET['compare_true']) && $_GET['compare_true'] != 1) ):
		if(isset($cookielasttyre)):
//        if(isset($_GET['tyre_id']) and  !empty($_GET['tyre_id'])):
	;?>


		
	<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="container">
			<div class="row last-search-bar">
				<?php _e('Welcome back! Your last search was for ',HATT_TEXTDOMAIN); ?>
				<strong><a href="<?php echo  get_permalink($cookielasttyre);?>"><?php echo get_the_title($cookielasttyre);?></a>
			</div>
		</div>
	</div>
		
	



<?php endif ;
//    endif;
	endif;?>



<?php if(is_single() && is_singular('store')) :?>
	<div class="container print-widget">
		<div class="social_bar clearfix text-right">
			<span class="print hidden-xs"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icon-print.png');?>"> <?php _e('print page', HATT_TEXTDOMAIN); ?></span>
		</div>
	</div>
<?php endif;?><!-- 
<?php 
//for translation that can't be detected in header.php by poedit:
_e("Find My Tyres",HATT_TEXTDOMAIN); 
_e('Find a store',HATT_TEXTDOMAIN);
_e('Follow us',HATT_TEXTDOMAIN);
_e("No results found.",HATT_TEXTDOMAIN);
?> 
-->
