<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 5/12/2015
	 * Time: 2:39 PM
	 */ ?>

<?php

	$class = 'video-item col-xs-12 no_padding col-sm-4 ' . ($query->post_count == 1? ' video-only-one ' : '');
	if ($query->current_post == 0) {
		$class .= ' first_video_item ';
	}
	$i = $query->post_count % 3;
	if ($i == 1) {
		if ($query->current_post == $query->post_count - 1) {
			// $class .= 'col-sm-push-4 ml-4';
		}
	}
	if ($i == 2) {
		if ($query->current_post == $query->post_count - 1) {
			$class .= 'col-sm-push-2';
		}
		if ($query->current_post == $query->post_count - 2) {
			$class .= 'col-sm-push-2 ml-2';
		}
	}
	
	if(!my_wp_is_mobile()) {
		$class .= ' iphone ';
	}
	
	if(my_wp_is_iPhone() || my_wp_is_mobile() ) {
		$class .= ' iphone ';
	}


	if (($query->current_post + 1) % 3 == 1) {
		echo '<div class="row_video_item">';
	}; ?>

<div class="<?php echo esc_attr($class); ?>">

	<?php 
	$video_id =  get_field("video_id", get_the_ID());
	$event_cat =  get_field("tracking_code", get_the_ID());
	//$video_thumbnail =  get_post_meta(get_the_ID(), 'ht_banner', TRUE);
	//$video_thumbnail = "https://img.youtube.com/vi/" . $video_id . "/maxresdefault.jpg";
	$video_thumbnail = "https://img.youtube.com/vi/" . $video_id . "/0.jpg";
	
	$thumbbg="";
	if ($video_thumbnail) {
		$thumbbg = ' style="background-image:url(' . $video_thumbnail . ');"';    
	}
	
	$curr_term = get_the_terms( get_the_ID(), "video_cat" );
	$share_link = str_replace("%video_cat%",  $curr_term[0]->slug, get_permalink(get_the_ID()));
	?>

	<div class="banner_feature baner-box">	
	<?php  if(my_wp_is_iPhone() || my_wp_is_mobile() ): ?>
	<iframe id="ytplayer" frameborder="0" allowfullscreen="1" title="YouTube video player" width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $video_id ?>?autoplay=1&amp;rel=0&amp;enablejsapi=1&amp;modestbranding=1&amp;origin=http%3A%2F%2Fgy.in.isobarhub.com&amp;widgetid=4"></iframe>
	
	<div class="baner-box-detail-mb visible-xs mb-only">
		<h4 class="title"><?php echo the_title(); ?></h4>
	</div>
		<div id="wcp-share-<?php echo get_the_ID(); ?>" class="wcp-share"></div>
		<div class="wcp-share-btn"><a href="javascript:void(0)" class="video-share" data-shareid="wcp-share-<?php echo get_the_ID(); ?>" data-shareurl="<?php echo $share_link;?>"><img src="/wp-content/plugins/wcp-video/img/share-btn.png"></a></div>
		
	<?php else: ?>
		<a href="#video-modal" class="thumb-link popup" data-video="<?php echo $video_id; ?>" data-event_cat="<?php echo $event_cat  ;?>" <?php echo $thumbbg ?> >
		<img src="/wp-content/plugins/wcp-video/img/video-play-btn.png">
		</a>
 
		<div class="baner-box-detail-vid hidden-xs">
			<h4 class="title"><a href="#video-modal" class="popup " data-video="<?php echo $video_id; ?>" data-event_cat="<?php echo $event_cat  ;?>"><?php echo the_title(); ?></a></h4>
			<div class="ht_content_banner_feature hidden-xs"></div>
		</div>
		<div class="baner-box-detail-mb-vid visible-xs">
			<h4 clasas="title"><a href="#video-modal" class="popup" data-video="<?php echo $video_id; ?>" data-event_cat="<?php echo $event_cat  ;?>"><?php echo the_title(); ?></a></h4>
		</div>
		
		<div id="wcp-share-<?php echo get_the_ID(); ?>" class="wcp-share"></div>
		<div class="wcp-share-btn"><a href="javascript:void(0)" class="video-share" data-shareid="wcp-share-<?php echo get_the_ID(); ?>" data-shareurl="<?php echo $share_link;?>" data-video="<?php echo $video_id; ?>"><img src="/wp-content/plugins/wcp-video/img/share-btn.png"></a></div>
		
	</div>
	<?php endif; ?>
	
</div>
<?php
	if (($query->current_post + 1) % 3 == 0 or $query->current_post == $query->post_count - 1) {
		echo '<div class="clearfix"></div></div>';
	}; ?>
