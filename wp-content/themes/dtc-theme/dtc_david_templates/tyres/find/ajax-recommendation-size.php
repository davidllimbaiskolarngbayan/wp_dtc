<?php
global $page_size, $ajax_param;
$ajax_param = array('is_ajax' => 1, 'count_tyre' => 0);

//if include filter by speed index/load index, filter 'size' post with selected speed index/load index
if(!empty($option_speed) || !empty($option_load)){

	$str_postin = '';
	if ( $all_sizes ) {

		global $wpdb;

		foreach ( $all_sizes as $value ) {
			$postin_size[] = $value->post_id;
		}
		$str_postin = "'".implode("','",$postin_size)."'";

		if(!empty($option_speed)){
			$meta_speed_join = " INNER JOIN {$wpdb->postmeta} AS m2 ON m1.ID = m2.post_id";
			$meta_speed = " AND (m2.meta_key = 'ht_tyre_speed_ratio' AND m2.meta_value = '{$option_speed}')";
		}

		if(!empty($option_load)){
			$meta_load_join = " INNER JOIN {$wpdb->postmeta} AS m3 ON m1.ID = m3.post_id";
			$meta_load = " AND (m3.meta_key = 'ht_tyre_load_index' AND m3.meta_value = '{$option_load}')";
		}

		$query_1 = "SELECT m1.ID as post_id FROM {$wpdb->posts} AS m1
					{$meta_speed_join}
					{$meta_load_join}
					WHERE 1=1
					AND ( CAST(m1.ID AS CHAR) IN ( {$str_postin} ) )
					{$meta_speed}
					{$meta_load}
					AND m1.post_type = 'size'
					AND m1.post_status = 'publish'
					GROUP BY m1.ID";
		$size_posts = $wpdb->get_results($query_1);

		if(empty($size_posts)){ //to prevent error
			$size_posts[0] = new stdClass();
			$size_posts[0]->post_id = -1;
		}

		//replace $all_sizes value
		$all_sizes = $size_posts;
	}
}

//use default
$argv = array(
	'post_type'      => 'tyres',
	'post_status' => 'publish', //display published post only
	'posts_per_page' => - 1		//display all in one page
);
$postin = array();
if ( $all_sizes ) {
	foreach ( $all_sizes as $value ) {
		$postin[] = $value->post_id;
	}
	$argv['meta_query'][] = array(
		'key'     => 'ht_select_size_customa',
		'value'   => $postin,
		'compare' => 'IN'
	);
}

function loadTyres($argv){
	global $ajax_param;

	$query = new WP_Query( $argv );

	$ajax_param['count_tyre'] = $query->post_count;

	if ( $query->have_posts() ):
		global $page_size ;
		$page_size = true;
		while ( $query->have_posts() ):
			$query->the_post();
			echo Hatt()->load_template( 'tyres/gird', FALSE, array('load_cat' => TRUE) );
		endwhile;
		wp_reset_postdata();
	else: ?>
		<p id="noresult-fix" class="text-center text-uppercase">
			<?php 
				if(SITE_LOCALE == 'in'){
					_e('We are sorry! We do not have tires for this model available for fitment in India at present.',HATT_TEXTDOMAIN);
				}else{
					_e('No results found',HATT_TEXTDOMAIN); 	
				}
			 ?>
		</p>
	<?php endif;
}
?>

<?php
if($include_side_cat==1) {
?>
	<h1>
		<?php _e('Here are our recommendations',HATT_TEXTDOMAIN); ?>
	</h1>
	<div id="findtyre_size_cate" class="row recommendation_detail text-left">
		<div class="col-sm-3 hidden-xs">
			<?php echo hatt()->load_template('tyres/find/ajax', 'category-size'); ?>
		</div>
		<div class="col-sm-9">
			<div role="tabpanel">
				<div class="tab-content">
					<div class="rof_box">
						<label><input id="findtyre_rof" type="checkbox" /> <?php _e('Show only Run On Flat',HATT_TEXTDOMAIN); ?></label>
					</div>
					<div id="findtyre_items">
						<?php
						//draw filtered tyre(s)
						loadTyres($argv);
						?>
					</div>
					<p id="noresult-ajax" class="text-center text-uppercase" style="display: none">
						<?php _e('No results found',HATT_TEXTDOMAIN); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<?php echo hatt()->load_template('tyres/box', 'compare', array('ajax_param'=>$ajax_param)); ?>

<?php
}else{

	//draw filtered tyre(s)
	loadTyres($argv);
}
?>