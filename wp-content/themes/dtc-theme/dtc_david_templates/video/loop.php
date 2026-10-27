<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 5/12/2015
 * Time: 2:29 PM
 */
//$default = array(
//    'ht_video_category'=>'',
//    'post_per_page'=>'',
//    'post_per_row'=>'',
//    'order'=>'',
//    'orderby'=>'',
//);
//extract($data);

$args = shortcode_atts( $data , '', '');

$post_per_page = (int) $args['post_per_page'];
$orderby = esc_attr( $args['orderby'] );
$order = esc_attr( $args['order'] );
$category = esc_attr( $args['category'] );
$post_per_row  = (int) $args['post_per_row'];


if($orderby == "none") {
	$orderby = "date";
}

if($order == "none") {
	$order = "ASC";
}

$query = array(
    'post_type' => 'video',
    'posts_per_page' => $post_per_page,
    'orderby' => $orderby,
    'order' => $order,
);

$cur_term_id = "";

if(isset(get_queried_object()->term_id)){
	$cur_term_id = get_queried_object()->term_id;
}



if ($cur_term_id != '0' && $cur_term_id != '') {
    $category_array = explode(',', $cur_term_id);
    if(!in_array(0,$category_array))
    $query['tax_query'][] = array(
        'taxonomy' => 'video_cat',
        'terms' => explode(',', $cur_term_id)
    );
}

$tax_terms = get_terms('video_cat', array('hide_empty' => false,  'orderby' => 'term_order'));


$query_video = new WP_Query($query);
if ($query_video->have_posts()):?>
    <div class="ht_custom_video">
	<div class="cat-menu-page">
	<ul class="cat-menu menu  video-menu">
	<li class="menu-item"><a onClick="load_video_category('/video')" class="btn btn-primary btn-sm <?php echo  (!$cur_term_id? 'active' : ''); ?>">All</a></li>
	<?php
	foreach ($tax_terms as $tax_term) {
	
	$url = "/learn/video/" . esc_attr($tax_term->slug) ;
	//echo '<li class="menu-item">' . '<a href="/learn/video/' . esc_attr($tax_term->slug) . '" class="btn btn-primary btn-sm  '.  ($cur_term_id == $tax_term->term_id ? 'active' : '') .'">' . $tax_term->name.'</a></li>';
	echo '<li class="menu-item">' . '<a onClick="load_video_category(\''.$url.'\' )" class="btn btn-primary btn-sm  '.  ($cur_term_id == $tax_term->term_id ? 'active' : '') .'">' . $tax_term->name.'</a></li>';
	}
	?>
	</ul>
	</div>
	
	
	<div class="video-list">
    <?php
    while ($query_video->have_posts()):
        $query_video->the_post();?>
            <?php echo hatt()->load_template('video/loop', 'item',array('post_per_row'=>$post_per_row,'query'=>$query_video));?>
    <?php endwhile; wp_reset_query();?>
	</div>
	
    </div>
	<?php if(!my_wp_is_mobile()):    //if(!my_wp_is_iPhone()) : ?>
	<script type="text/javascript">
	var player_id='ytplayer';var ytvideoId;var autoplay=true;
	</script>
	<div id="video-modal" class="white-popup-block mfp-hide flexi"><div class="gy-wing-icon"></div><div id="ytplayer"></div></div>
	<?php endif; ?>
<?php
        endif;?>
		<script>
		 jQuery(function($) {
			$("#menu-item-4752").addClass("current-menu-item");
		});	
		</script>
		<script type="text/javascript" src="/wp-content/plugins/wcp-video/js/wcp-video.js"></script>
		
