<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/8/2015
	 * Time: 12:27 AM
	 */
	global $ht_store_search;

	error_reporting(E_ALL);

	// get total result and store results in js for maps data
	$term = array();
	$html = '';
	$arg  = array(
		'post_type' => 'store',
		'posts_per_page'=>"-1",
	);
	// $arg1  = array(
	// 	'post_type' => 'store',
	// 	'posts_per_page'=>"-1",
	// );
	// $arg2  = array(
	// 	'post_type' => 'store',
	// 	'posts_per_page'=>"-1",
	// );
	if ( isset( $_GET['category'] ) and ! empty( $_GET['category'] ) ) {
		$category           = $_GET['category'];
		$arg['tax_query']['relation'] = 'OR';
		$arg['tax_query'][] = array(
			'taxonomy' => 'store_cat',
			'terms'    => explode(',',$category)
		);
		// $arg1['tax_query']['relation'] = 'OR';
		// $arg1['tax_query'][] = array(
		// 	'taxonomy' => 'store_cat',
		// 	'terms'    => explode(',',$category)
		// );
		// $arg2['tax_query']['relation'] = 'OR';
		// $arg2['tax_query'][] = array(
		// 	'taxonomy' => 'store_cat',
		// 	'terms'    => explode(',',$category)
		// );
	}

	if ( isset( $_GET['tyre_id'] ) and ! empty( $_GET['tyre_id'] ) ) {
		$tyre_id         = $_GET['tyre_id'];
		$list_store      = get_post_meta( $tyre_id, 'ht_tyre_store_select', TRUE );
		$arg['post__in'] = $list_store;
		// $arg1['post__in'] = $list_store;
		// $arg2['post__in'] = $list_store;
	}

	// query 1, search title	
	// query 2, filters
	if(!empty($ht_store_search)){
		// $arg['s'] = $ht_store_search;

		$arg['post_title_address_like']=$ht_store_search;
		add_filter('posts_distinct', 'search_distinct'); //return distinct results only
		add_action('posts_join','rc_filter_join1');
		// add_action('posts_where','address_like_posts_where');

		// $arg['meta_query']['relation'] ="OR";
		// $arg['meta_query'][] = array(
		// 	'key' => 'ht_store_address',
		// 	'value' => $ht_store_search,
		// 	'compare' => 'LIKE'
		// );
		// $arg['post_title_like']= $ht_store_search;
		//this does intersection between metaquery and post title, so it returns 0 results

		/*$arg1['s'] = $ht_store_search;
		$arg2['meta_query'][] = array(
			'key' => 'ht_store_address',
			'value' => $ht_store_search,
			'compare' => 'LIKE'
		);
		$query1 = new WP_Query( $arg1 );
		$query2 = new WP_Query( $arg2 );*/
		
		// $test = new WP_Query( $arg );
		// $arg['meta_query']['relation'] ="OR";
		// $arg['meta_query'][] = array(
		// 	'key' => 'ht_store_address',
		// 	'value' => $ht_store_search,
		// 	'compare' => 'LIKE',
		// );
		// $arg['meta_query'][] = array(
		// 	'key' => 'title',
		// 	'value' => $ht_store_search,
		// 	'compare' => 'LIKE',
		// );
	}
	if (isset($_GET['resultwithin']) && !empty($_GET['resultwithin'])){
		add_action('posts_where','rc_filter_where');
		add_action('posts_join','rc_filter_join1');
		add_action('posts_join','rc_filter_join2');
	}

	$query = new WP_Query( $arg );
	// $query = new WP_Query();
	// $query->posts = array_unique( array_merge( $query1->posts, $query2->posts ), SORT_REGULAR );
	// $query->post_count = count( $query->posts );

	// $test = new WP_Query($arg);

	// echo count($test->posts)."<br>";
	// echo count($query1->posts)."<br>";
	// echo count($query2->posts)."<br>";
	// echo count($query->posts)."<br>";
	// echo "<pre>";
	// print_r($test->posts);
	// print_r($query1->posts);
	// print_r($query2->posts);
	// print_r($query->posts);
	// echo "</pre>";

	// $num_posts = $query->post_count;
	$num_posts = $query->found_posts;
	// print_r("num post".$num_posts);
	if ($num_posts == 0){
	// 	print_r('0 result, search title only');
		$arg['meta_query'] = NULL;
		$query = new WP_Query( $arg );
	}

	if(SITE_LOCALE=='cn'){
		$markerimgurl="";
	}else{
		$markerimgurl=get_template_directory_uri(). "/images/GoogleMarker.png";
	}
	// $markerimgurl=get_template_directory_uri(). "/images/GoogleMarker.png";
	// for maps info
	while ( $query->have_posts() ){
		$query->the_post();
		$store_title = get_the_title();
		$store_lat = get_post_meta( get_the_ID(), 'ht_store_map_lat', TRUE );
		$store_lon = get_post_meta( get_the_ID(), 'ht_store_map_long', TRUE );
		$store_address = get_post_meta( get_the_ID(), 'ht_store_address', TRUE );
		$store_postal_code = get_post_meta( get_the_ID(), 'ht_store_postal_code', TRUE );
		$store_phone = get_post_meta( get_the_ID(), 'ht_store_phone', TRUE );
		$store_email = get_post_meta( get_the_ID(), 'ht_store_email', TRUE );

		$store_description = '<div class="info_content"><h3>' . $store_title . '</h3><p>' . $store_address .  '</p><p>Phone: ' . $store_phone . ' | Email: ' . $store_email . '</p></div>';

		$stores_loc[] = [$store_title, $store_lat, $store_lon, $markerimgurl];
		$stores_desc[] = [$store_description];
	}












	// --------------------------------- RESET -----------------------------------

	wp_reset_query();

	if (isset($_GET['resultwithin']) && !empty($_GET['resultwithin'])){
		remove_action('posts_where','rc_filter_where');
		remove_action('posts_join','rc_filter_join1');
		remove_action('posts_join','rc_filter_join2');
	};

	unset($html);
	unset($term);
	// unset($arg1);
	// unset($arg2);
	unset($arg);

	// --------------------------------- QUERY 2 ---------------------------------

	if($_GET and isset($_GET['post_per_page']) and $_GET['post_per_page']){
		$post_per_page = $_GET['post_per_page'];
	}else{
		$post_per_page =10;
	}

	//start new query
	$term = array();
	$html = '';
	$arg  = array(
		'post_type' => 'store',
		'posts_per_page'=>$post_per_page,
		'paged'     => get_query_var( 'paged' ),
		'orderby' => 'title',
		'order'   => 'ASC'
	);
	// $arg1  = array(
	// 	'post_type' => 'store',
	// 	'posts_per_page'=>$post_per_page,
	// 	'paged'     => get_query_var( 'paged' ),
	// 	'orderby' => 'title',
	// 	'order'   => 'ASC'
	// );
	// $arg2  = array(
	// 	'post_type' => 'store',
	// 	'posts_per_page'=>$post_per_page,
	// 	'paged'     => get_query_var( 'paged' ),
	// 	'orderby' => 'title',
	// 	'order'   => 'ASC'
	// );

	if ( isset( $_GET['category'] ) and ! empty( $_GET['category'] ) ) {
		$category           = $_GET['category'];
		$arg['tax_query']['relation'] = 'OR';
		$arg['tax_query'][] = array(
			'taxonomy' => 'store_cat',
			'terms'    => explode(',',$category)
		);
		// $arg1['tax_query']['relation'] = 'OR';
		// $arg1['tax_query'][] = array(
		// 	'taxonomy' => 'store_cat',
		// 	'terms'    => explode(',',$category)
		// );
		// $arg2['tax_query']['relation'] = 'OR';
		// $arg2['tax_query'][] = array(
		// 	'taxonomy' => 'store_cat',
		// 	'terms'    => explode(',',$category)
		// );
	}

	if ( isset( $_GET['tyre_id'] ) and ! empty( $_GET['tyre_id'] ) ) {
		$tyre_id         = $_GET['tyre_id'];
		$list_store      = get_post_meta( $tyre_id, 'ht_tyre_store_select', TRUE );
		$arg['post__in'] = $list_store;
		// $arg1['post__in'] = $list_store;
		// $arg2['post__in'] = $list_store;
	}
	if(!empty($ht_store_search)){
		// $arg['meta_query']['relation'] ="OR";
		// $arg1['s'] = $ht_store_search;
		// $arg2['meta_query'][] = array(
		// 	'key' => 'ht_store_address',
		// 	'value' => $ht_store_search,
		// 	'compare' => 'LIKE',
		// );

		$arg['post_title_address_like']=$ht_store_search;
		add_filter('posts_distinct', 'search_distinct'); //return distinct results only
		add_action('posts_join','rc_filter_join1');

		// $arg['meta_query'][] = array(
		// 	'key' => 'ht_store_address',
		// 	'value' => $ht_store_search,
		// 	'compare' => 'LIKE',
		// );
		// $arg['meta_query'][] = array(
		// 	'key' => 'title',
		// 	'value' => $ht_store_search,
		// 	'compare' => 'LIKE',
		// );
	}

    if(isset($_GET['zpo']) && ($_GET['zpo']=='on')){
        $zpo_state = 'on';

		 $arg['meta_query'][] = array(
		 	'key' => 'ht_dtc_zero_percent_outlet',
		 	'value' => $zpo_state,
		 	'compare' => 'LIKE',
		 );		

	}	
	
    if(isset($_GET['uhp_rof']) && ($_GET['uhp_rof']=='on')){
        $uhp_rof_state = 'on';

		 $arg['meta_query'][] = array(
		 	'key' => 'ht_uhp_rof_tyre_available',
		 	'value' => $uhp_rof_state,
		 	'compare' => 'LIKE',
		 );		

    }

	if ($num_posts == 0){
		$arg['meta_query'] = NULL;
		// $arg1['meta_query'] = NULL;
		// $arg2['meta_query'] = NULL;
	}
?>



<?php
	if (isset($_GET['resultwithin']) && !empty($_GET['resultwithin'])){
		add_action('posts_where','rc_filter_where');
		add_action('posts_join','rc_filter_join1');
		add_action('posts_join','rc_filter_join2');
	}

	// $query1 = new WP_Query( $arg1 );
	// $query2 = new WP_Query( $arg2 );
	// $query = new WP_Query();
	$query = new WP_Query( $arg );


	// echo "<pre>";
	// print_r($test->posts);
	// print_r($query1->posts);
	// print_r($query2->posts);
	// print_r($query->posts);
	// echo "</pre>";
	
	// $query->posts = array_unique( array_merge( $query1->posts, $query2->posts ), SORT_REGULAR );
	// $query->post_count = count( $query->posts );

	if ( $query->have_posts() ):?>
		<div class="result">
			<p class="pull-left result-left result-found stores-result-found"><strong><?php echo esc_attr( $query->found_posts );?></strong> 
			<!-- <p class="pull-left result-left result-found stores-result-found"><strong><?php echo esc_attr( $query->post_count );?></strong>  -->
				<?php _e('results found',HATT_TEXTDOMAIN); ?>
			</p>
			<form method="post" class="pull-right result-right">
				<lable>
				<?php _e('Numbers of results per page',HATT_TEXTDOMAIN); ?>
				</lable>
				<select  class="year post_per_page">
					<option <?php if($post_per_page==10) echo 'selected';?> value="10">10</option>
					<option <?php if($post_per_page==15) echo 'selected';?> value="15">15</option>
					<option <?php if($post_per_page==20) echo 'selected';?> value="20">20</option>
				</select>
			</form>
			<?php if(isset($_GET['search'])): ;?>
				<form method="post" class="visible-xs resultwithinform form-horizontal">
					<div class="form-group">
						<label class="col-xs-4 control-label">
						<?php _e('Show results',HATT_TEXTDOMAIN); ?>
						</label>
						<div class="col-xs-8">
							<select class="year resultwithin">
								<option value="0">
								<?php _e('-- Select distance --',HATT_TEXTDOMAIN); ?>
								</option>
								<option <?=(isset($_GET['resultwithin'])&&$_GET['resultwithin']=="3")?"selected":""?> value="3">
								<?php _e('Within 3km',HATT_TEXTDOMAIN); ?>
																</option>
								<option <?=(isset($_GET['resultwithin'])&&$_GET['resultwithin']=="4")?"selected":""?> value="4">
								<?php _e('Within 4km',HATT_TEXTDOMAIN); ?>
																</option>
								<option <?=(isset($_GET['resultwithin'])&&$_GET['resultwithin']=="5")?"selected":""?> value="5">
								<?php _e('Within 5km',HATT_TEXTDOMAIN); ?>
																</option>
								<option <?=(isset($_GET['resultwithin'])&&$_GET['resultwithin']=="6")?"selected":""?> value="6">
								<?php _e('Within 6km',HATT_TEXTDOMAIN); ?>
								</option>
								<option <?=(isset($_GET['resultwithin'])&&$_GET['resultwithin']=="7")?"selected":""?> value="7">
								<?php _e('Within 7km',HATT_TEXTDOMAIN); ?>
								</option>
								<option <?=(isset($_GET['resultwithin'])&&$_GET['resultwithin']=="8")?"selected":""?> value="8">
								<?php _e('Within 8km',HATT_TEXTDOMAIN); ?>
																</option>
							</select>
						</div>
					</div>
				</form>
			<?php endif ;?>
			<div class="clearfix"></div>
		</div>
		<?php

		while ( $query->have_posts() ):

			$query->the_post();

			echo Hatt()->load_template( 'stores/gird', FALSE );
		endwhile;
		wp_reset_query();
		echo '<div class="pagination_div font- text-center">';
		ht_paging($query);
		echo '</div>';
		if (isset($_GET['resultwithin']) && !empty($_GET['resultwithin'])){
			remove_action('posts_where','rc_filter_where');
			remove_action('posts_join','rc_filter_join1');
			remove_action('posts_join','rc_filter_join2');
		};
	else:?>
<div class="result">
	<p class="pull-left result-left result-found  stores-result-found"><strong><?=isset($stores_loc)?count($stores_loc):"0"?> </strong>
		<?php _e('results found',HATT_TEXTDOMAIN); ?>
	</p>
	</div>
<?php
	endif;
?>

<!-- Script google maps -->
<script>

	var SITE_LOCALE="<?php echo SITE_LOCALE; ?>";
	var lat=0;
	var lon=0;

	jQuery(function($) {

		function baiduCallback(){
			if(SITE_LOCALE=='cn') {	
				initBaiduMap();
			}
		}
		
		if(SITE_LOCALE=="cn") {

			setTimeout(function(){
				initBaiduMap();
			},1000);

		}else{
			// Asynchronously Load the map API
			var script = document.createElement('script');
			script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&callback=initialize";
			document.body.appendChild(script);
		}
		
	});

	<?php if ($num_posts == 0): ?>
	jQuery( document ).ready(function() {
		jQuery(".no-result-found").html("<?php _e('Sorry, no results found! Use the map below to find the nearest store.',HATT_TEXTDOMAIN); ?>")
	});
	<?php endif;?>























	// --------------------------------- JS --------------------------------------

	function successCallback(position)  {
		if(SITE_LOCALE == 'cn') {
			initialLocation = new BMap.Point(position.coords.latitude, position.coords.longitude);
		}else{
			initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);	
		}		
		// Set map center to current location
		// map.setCenter(initialLocation);
		lat = position.coords.latitude;
		lon = position.coords.longitude;
		console.log("latlon", lat, lon);
		url = jQuery(location).attr('pathname') + '?search=<?=$ht_store_search?$ht_store_search:''?>' + '&lat=' + lat + '&lon=' + lon + '&resultwithin=10';
		window.location.replace(url);
	}

	function errorCallback(error) {
		alert(error);
	}

	function currentloc(){
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
		} else {
			alert("Your browser is not support this feature.");
		}
	}






	// change result within dropdown
	jQuery(".resultwithin").change(function () {
		console.log("lat,lon", lat,lon);
		if (lat == 0){
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
			}
		} else {
			url = jQuery(location).attr('pathname') + '?search=<?=$ht_store_search?$ht_store_search:''?>' + '&lat=' + lat + '&lon=' + lon + '&resultwithin=' + this.value;
			window.location.replace(url);
		}


	});


	var markers = <?=isset($stores_loc)?json_encode($stores_loc):"[]" ?>;
	var infoWindowContent = <?=isset($stores_desc)?json_encode($stores_desc):"[]" ?>;


	function initBaiduMap(){
		console.log("baidu");

		var map;
		var bounds = new BMap.Bounds();
		map = new BMap.Map("map_canvas");
		map.centerAndZoom(new BMap.Point(lon, lat), 15);  
		map.addControl(new BMap.MapTypeControl());  
		// map.addControl(new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT}););  
		map.enableScrollWheelZoom(true); 
		
		console.log("markers len", markers.length);

		// convert more more points!
		// BMap.Convertor.transMore(points, 2, callback);
		// var start = new Date().getTime();
		var maxMarkerCount=20;
		var bmmarkers=[];

		// START ADDING MARKERS		
		for( i = 0; i < markers.length; i++ ) {
			var position = new BMap.Point(markers[i][2], markers[i][1]);
			// console.log('position',position);
			bounds.extend(position);
			var marker = new BMap.Marker(new BMap.Point (markers[i][2], markers[i][1]));
			bmmarkers.push(marker);
			// map.addOverlay(marker);
			var content = infoWindowContent[i][0];
			addClickHandler(content,marker);
		}

		var markerClusterer = new BMapLib.MarkerClusterer(map, {markers:bmmarkers});
		markerClusterer.setStyles([{
			url: "<?php echo get_template_directory_uri(). "/images/ClusterMarker.png" ?>",
			size: new BMap.Size(30,26),
			opt_anchor: [16,0],
			textColor:'#ffffff',
			opt_textSize: 10
		}]);
		// console.log("styles", markerClusterer.getStyles());

		// var end = new Date().getTime();
		// var time = end - start;
		// console.log('Execution time: ' + time);

		// get current pos
		// lon=lat=0;
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function (position) {
				// initialLocation = new BMap.Point(position.coords.latitude, position.coords.longitude);
				// Set map center to current location
				// map.setCenter(initialLocation);
				lat = position.coords.latitude;
				lon = position.coords.longitude;
				console.log("latlon", lat, lon);
				map.centerAndZoom(new BMap.Point(lon, lat), 15);  

				refreshBounds();

			}, handle_geo_error);
		}else{
			refreshBounds();
		}

		function handle_geo_error(){
			refreshBounds();
		}
		

		function refreshBounds(){
			console.log("refresh bounds");
			start = new Date().getTime();
			/*try {
				BMapLib.AreaRestriction.setBounds(map, bounds);	
			}catch(e) {
				console.log("bounds error",e);
			}*/
			// console.log("bounds",bounds);
			// console.log(bounds.getSouthWest(), bounds.getNorthEast());
			map.setViewport([bounds.getSouthWest(), bounds.getNorthEast() ]);

			end = new Date().getTime();
			time = end - start;
			console.log('Execution time: ' + time);
		}

		function addClickHandler(content,marker){
			marker.addEventListener("click",function(e){
				openInfo(content,e)}
			);
		}
		function openInfo(content,e){
			var opts = {width: 300};
			var p = e.target;
			var point = new BMap.Point(p.getPosition().lng, p.getPosition().lat);
			var infoWindow = new BMap.InfoWindow(content,opts);  // 创建信息窗口对象 
			map.openInfoWindow(infoWindow,point); //开启信息窗口
		}
	} //end baidu init
	



	function initialize() {
		console.log("gmap");
		var map;
		var bounds = new google.maps.LatLngBounds();
		var mapOptions = {
			mapTypeId: 'roadmap',
			scrollwheel: false,
			scaleControl: true
		};

		map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
		map.setTilt(45);

		// var markers = x
		// var infoWindowContent = x

		// Display multiple markers on a map
		var infoWindow = new google.maps.InfoWindow(), marker, i;

		// Loop through our array of markers & place each one on the map
		for( i = 0; i < markers.length; i++ ) {
			var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
			bounds.extend(position);
			marker = new google.maps.Marker({
				position: position,
				map: map,
				title: markers[i][0],
				icon: markers[i][3]
			});

			// Allow each marker to have an info window
			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					infoWindow.setContent(infoWindowContent[i][0]);
					infoWindow.open(map, marker);
				}
			})(marker, i));


		}
		map.fitBounds(bounds);

		// get current pos
		lat = 0;
		lon = 0;
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function (position) {
				initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				// Set map center to current location
				// map.setCenter(initialLocation);
				lat = position.coords.latitude;
				lon = position.coords.longitude;
			});
		}else{
			console.log('nav disabled');
		}
	} // end initialise


</script>

