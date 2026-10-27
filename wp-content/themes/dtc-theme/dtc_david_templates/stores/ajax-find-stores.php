<?php 
header('Content-Type: text/html; charset=utf-8');
require_once(  '../../../../../wp-load.php' );

$stores = array();

$start = microtime(true);

//$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
//$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

foreach ($_GET as $key => $value) {
    $_GET[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

foreach ($_POST as $key => $value) {
    $_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}


/** all stores - only use on first load **/
$all_stores = array();
$all_categories = array();
$all_specialty = array();

if( $_POST['all_stores'] == 1  ){
	$args = array(
		'post_type'  => 'store',
		'posts_per_page' => -1 ,
		'orderby' => 'name',
		'order' => 'ASC',
		'tax_query' => array(
			array(
				'taxonomy' => 'store_visib',
				'field'    => 'slug',
				'terms'    =>  'Find Store',
			),
		),

	);	

	$query = new WP_Query( $args );
	
	
	if ( $query->have_posts() ) {
		foreach ($query->posts as $post) {
		// for ($i=0;$i<2000; $i++) {
			$store_post = $post;
			// $store_post = $query->posts[$i];
			// print_r($store_post);
			$meta = get_post_meta( $store_post->ID );
			$all_stores[] =  array(
							'title' => $store_post->post_title,
							'ht_store_email' => $meta['ht_store_email'][0] ?? '',
							'ht_store_address' => $meta['ht_store_address'][0] ?? '',
							'ht_store_postal_code' => $meta['ht_store_postal_code'][0]  ?? '',
							'ht_store_area' => $meta['ht_store_area'][0] ?? '' ,
							'ht_store_state' => $meta['ht_store_state'][0] ?? '' ,
							'ht_store_phone' => $meta['ht_store_phone'][0] ?? '' ,
							'ht_whatsapp_link' => $meta['ht_whatsapp_link'][0] ?? '' ,
							'ht_store_map_long' => $meta['ht_store_map_long'][0] ?? '' ,
							'ht_store_map_lat' => $meta['ht_store_map_lat'][0] ?? ''
						);

			// this function (wp_get_post_terms) IS slow:
			// unless we query another way, or hardcode it!!!
			// $sc_args=array('fields' => 'names');
			// $sc_args=array();
			// $store_cat = wp_get_post_terms($store_post->ID, 'store_cat', $sc_args);
			// print_r($store_cat);
			// $all_categories[$store_cat[0]->name] = array(
			// 						'id' => $store_cat[0]->term_id,
			// 						'name' => $store_cat[0]->name,
			// 						'slug' => $store_cat[0]->slug
			// 					);

			//3. GET UNIQUE store_specialty_cat
			// print_r($meta['ht_store_specialty_cat'][0]);
			if($meta['ht_store_specialty_cat'][0] ?? null != null){
				if(!in_array($meta['ht_store_specialty_cat'][0], $all_specialty) ){
					$all_specialty[] = $meta['ht_store_specialty_cat'][0];
				}
			}



		}
	}

	/*
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {			
			$store_post = $query->the_post();			
			$meta = get_post_meta( get_the_ID() );
			$all_stores[] =  array(
							'title' => get_the_title(),
							'ht_store_email' => $meta['ht_store_email'][0] ,
							'ht_store_address' => $meta['ht_store_address'][0] ,
							'ht_store_postal_code' => $meta['ht_store_postal_code'][0] ,
							'ht_store_area' => $meta['ht_store_area'][0] ,
							'ht_store_state' => $meta['ht_store_state'][0] ,
							'ht_store_phone' => $meta['ht_store_phone'][0] ,
							'ht_store_map_long' => $meta['ht_store_map_long'][0] ,
							'ht_store_map_lat' => $meta['ht_store_map_lat'][0]
						);
			// $store_cat = wp_get_post_terms(get_the_ID(), 'store_cat');
			// $all_categories[$store_cat[0]->name] = array(
			// 						'id' => $store_cat[0]->term_id,
			// 						'name' => $store_cat[0]->name,
			// 						'slug' => $store_cat[0]->slug
			// 					); 
			if(!in_array($meta['ht_store_specialty_cat'][0], $all_specialty)){
				$all_specialty[] = $meta['ht_store_specialty_cat'][0];
			}
		}
	}*/

	//2. GET UNIQUE store_cat
	// more OPTIMIZED version of getting wp _get_post_terms for every post
	$storeterms =get_terms('store_cat', 'orderby=id&hide_empty=1');
	// print_r($storeterms);
	foreach ($storeterms as $st) {
		$all_categories[$st->name]=array(
				'id'=> $st->term_id,
				'name'=> $st->name,
				'slug'=> $st->slug,
			);
	}
	// print_r($all_categories);

/*
	$all_categories['服务中心'] = array(
									'id' => 1365,
									'name' => '服务中心',
									'slug' => '%e6%9c%8d%e5%8a%a1%e4%b8%ad%e5%bf%83'
								); 
	$all_categories['招牌升级店'] = array(
									'id' => 1366,
									'name' => '招牌升级店',
									'slug' => '%e6%8b%9b%e7%89%8c%e5%8d%87%e7%ba%a7%e5%ba%97'
								); 
	$all_categories['旗舰店'] = array(
									'id' => 1367,
									'name' => '旗舰店',
									'slug' => '%e6%97%97%e8%88%b0%e5%ba%97'
								); 
	$all_categories['超级旗舰店'] = array(
									'id' => 1369,
									'name' => '超级旗舰店',
									'slug' => '%e8%b6%85%e7%ba%a7%e6%97%97%e8%88%b0%e5%ba%97'
								); */

	wp_reset_postdata();

	sort($all_specialty);

	$stores['all_stores'] = $all_stores;
	$stores['all_categories'] = $all_categories;
	$stores['all_specialty'] = $all_specialty;
}
/** ./all stores **/
// echo "-----------------------------\n";
// print_r($stores['all_stores']);
// print_r($stores['all_categories']);
// print_r($stores['all_specialty']);

$time_elapsed_secs = microtime(true) - $start;
// echo "elapsed: ".$time_elapsed_secs." secs\n";

$meta_queries = array('relation' => 'AND');

$current_page = (!empty($_POST['current_page'])) ? $_POST['current_page'] : 0;
$posts_per_page = (!empty($_POST['post_per_page'])) ? $_POST['post_per_page'] : 207;

set_query_var( 'paged' , $current_page);


//default args
$args = array(
	'post_type'  => 'store',
	'paged' => $current_page,
	'posts_per_page' => $posts_per_page,
	'orderby' => 'name',
	'order' => 'ASC',
	'tax_query' => array(
		array(
			'taxonomy' => 'store_visib',
			'field'    => 'slug',
			'terms'    =>  'Find Store',
		),
	),

);


//metaquery 
if(!empty($_POST['state'])){
	$meta_queries[] =   array(
						'key'     => 'ht_store_state',
						'value'   => urldecode($_POST['state'])
					);
}

if(!empty($_POST['area'])){
	$meta_queries[] =   array(
						'key'     => 'ht_store_area',
						'value'   => urldecode($_POST['area'])
					);
}

if(!empty($_POST['category'])){
	$meta_queries[] =   array(
						'key'     => 'ht_store_cat',
						'value'   => urldecode($_POST['category'])
					);
}

if(!empty($_POST['specialty'])){
	$meta_queries[] =   array(
						'key'     => 'ht_store_specialty_cat',
						'value'   => urldecode($_POST['specialty'])
					);
}

if(!empty($_POST['dtc_zero_percent'])){
    if($_POST['dtc_zero_percent']=='on'){
		$meta_queries[] =   array(
						'key'     => 'ht_dtc_zero_percent_outlet',
						'value'   => 'on'
					);
	}
}

if(!empty($_POST['uhp_rof_tyre_available'])){
    if($_POST['uhp_rof_tyre_available']=='on'){
		$meta_queries[] =   array(
						'key'     => 'ht_uhp_rof_tyre_available',
						'value'   => 'on'
					);
	}
}

$args['meta_query'] =  $meta_queries;




function store_where_filter( $where ) {

	$range = (empty($_POST['range']) ? 10 : (int)$_POST['range']);

	$lat = isset($_POST['coordinates']['latitude'])?$_POST['coordinates']['latitude']:"0";
	$lon = isset($_POST['coordinates']['longitude'])?$_POST['coordinates']['longitude']:"0";
	$where .= " AND ( meta_lat.meta_key = 'ht_store_map_lat' AND meta_long.meta_key = 'ht_store_map_long')
	AND  ( 6371 * acos( cos( radians( $lat ) ) * cos( radians( meta_lat.meta_value ) ) * cos( radians(  meta_long.meta_value ) - radians( $lon ) ) + sin( radians( $lat) ) * sin( radians(  meta_lat.meta_value ) ) ) )  < " . $range;

	return $where;
}


function store_filter_join1( $join ) {
	$join .= " INNER JOIN hatt_postmeta AS meta_lat ON ( hatt_posts.ID = meta_lat.post_id ) ";
	return $join;
}

function store_filter_join2( $join ) {
	$join .= " INNER JOIN hatt_postmeta AS meta_long ON ( hatt_posts.ID = meta_long.post_id ) ";
	return $join;
}


function store_filter_order($orderby_statement) {

	$lat = isset($_POST['coordinates']['latitude'])?$_POST['coordinates']['latitude']:"0";
	$lon = isset($_POST['coordinates']['longitude'])?$_POST['coordinates']['longitude']:"0";
	$orderby_statement = " ( 6371 * acos( cos( radians( $lat ) ) * cos( radians( meta_lat.meta_value ) ) * cos( radians(  meta_long.meta_value ) - radians( $lon ) ) + sin( radians( $lat) ) * sin( radians(  meta_lat.meta_value ) ) ) ) ASC ";
	return $orderby_statement;
}


if( !empty($_POST['coordinates']['latitude']) && !empty($_POST['coordinates']['longitude'])  ) {
	add_filter('posts_where','store_where_filter');
	add_filter('posts_join','store_filter_join1');
	add_filter('posts_join','store_filter_join2');
	add_filter('posts_orderby', 'store_filter_order');
}


//var_dump($args);

//default query
$query = new WP_Query( $args );







$start = microtime(true);







// The Loop
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		
		$store_post = $query->the_post();		
		$meta = get_post_meta( get_the_ID() );
		$terms = wp_get_post_terms( get_the_ID(), 'store_cat' );

        if ( ! is_wp_error( $terms ) ){
            foreach ( $terms as $key => $val ){
                $img = get_tax_meta( $val->term_id, 'store_cat_image' );
                $category_img =  esc_attr( $val->name );
              	if ( $img ) $category_img = esc_attr( $img['url'] );              	
          	} 
	    }

	    $stores['stores'][] = array(
							'id' => get_the_ID(),
							'title' => get_the_title(),
							'slug' => $post->post_name,
							'ht_store_cat' => $meta['ht_store_cat'][0] ?? '',
							'ht_store_email' => $meta['ht_store_email'][0] ?? '' ,
							'ht_store_address' => $meta['ht_store_address'][0] ?? '' ,
							'ht_store_postal_code' => $meta['ht_store_postal_code'][0] ?? '' ,
							'ht_store_area' => $meta['ht_store_area'][0] ?? '' ,
							'ht_store_state' => $meta['ht_store_state'][0] ?? '' ,
							'ht_store_phone' => $meta['ht_store_phone'][0] ?? '' ,
							'ht_whatsapp_link' => $meta['ht_whatsapp_link'][0] ?? '' ,
							'ht_store_map_long' => $meta['ht_store_map_long'][0] ?? '' ,
							'ht_store_map_lat' => $meta['ht_store_map_lat'][0] ?? '' ,
							'ht_store_specialty_cat' => $meta['ht_store_specialty_cat'][0] ?? '',
							'ht_store_services' => $meta['ht_store_services'][0] ?? '',
							'ht_uhp_rof_tyre_available' => $meta['ht_uhp_rof_tyre_available'][0] ?? '',
							'ht_dtc_zero_percent_outlet' => $meta['ht_dtc_zero_percent_outlet'][0] ?? '',
							'category_img' => $category_img ?? ''
						);
	}

} 

wp_reset_postdata();

$stores['total_results'] =  $query->found_posts;

$time_elapsed_secs = microtime(true) - $start;
// echo "1-elapsed: ".$time_elapsed_secs." secs\n";

/*** pagination ***/
ob_start();
ht_paging($query);
$pagination_html = ob_get_contents();
ob_end_clean();
$stores['pagination'] = $pagination_html;


/*categories & specialty*/
if( $_POST['all_stores'] == 0  ){	
	$args['posts_per_page'] = $query->found_posts;
	$query = new WP_Query( $args );
	// The Loop
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {

			$store_post = $query->the_post();	

			$store_cat = wp_get_post_terms(get_the_ID(), 'store_cat');

			$all_categories[$store_cat[0]->name] = array(
															'name' => $store_cat[0]->name,
															'slug' => $store_cat[0]->slug
														); 

			if(!in_array($meta['ht_store_specialty_cat'][0], $all_specialty)){
				$all_specialty[] = $meta['ht_store_specialty_cat'][0];
			}
		}
	}

	// print_r($all_categories);

	// more OPTIMIZED version of getting wp _get_post_terms for every post
	/*$storeterms =get_terms('store_cat', 'orderby=id&hide_empty=1');
	// print_r($storeterms);
	foreach ($storeterms as $st) {
		$all_cat2[$st->name]=array(
				'id'=> $st->term_id,
				'name'=> $st->name,
				'slug'=> $st->slug,
			);
	}
	print_r($all_cat2);*/


	$stores['all_categories'] = $all_categories;
	$stores['all_specialty'] = $all_specialty;

}

wp_reset_postdata();


echo json_encode($stores,JSON_UNESCAPED_UNICODE);

// count exec time
$time_elapsed_secs = microtime(true) - $start;
// echo "2-elapsed: ".$time_elapsed_secs." secs\n";


?>

