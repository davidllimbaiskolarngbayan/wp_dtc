<?php
global $page_size, $ajax_param;

$argv = array(
    'post_type' => 'tyres',
	'post_status' => 'publish', //display published post only
    'posts_per_page' => -1 		//display all in one page
);
$argv['tax_query'][] = array(
    'taxonomy' => 'vehicles_cat',
    'field'=>'ID',
	'terms' => $last_veh_cat_id
);

/** SETTINGS *************************************************************/
//param order names must be the same as the url get variable
$param_order = array('brand','product_year','model');	

if( SITE_LOCALE == "cn" ){
	$param_order = array('brand','car_maker','product_year','model');	
}

if( SITE_LOCALE == "in" ||  SITE_LOCALE == "kr" ){
	$param_order = array('brand','model');	
}

if( SITE_LOCALE == "in" ||  SITE_LOCALE == "kr" ){
	$param_order = array('brand','model');	
}

if( SITE_LOCALE == "my" ){
    $param_order = array('brand','model','variant','product_year'); 
}

/** SETTINGS *************************************************************/

function loadTyres($argv){
	global $page_size, $ajax_param;

	$query = new WP_Query( $argv );

	$ajax_param = array('is_ajax' => 1, 'count_tyre' => $query->post_count);

	if ( $query->have_posts() ):
		$page_size = true;
		while ( $query->have_posts() ):
			$query->the_post();
			echo Hatt()->load_template( 'tyres/rfq/rfq', 'grid', array('load_cat' => FALSE) );
		endwhile;
		wp_reset_postdata();
	else: ?>
		<p class="text-center text-uppercase">
			<?php _e('No results found',HATT_TEXTDOMAIN); ?>
		</p>
	<?php endif;
}

// Method that will check if there's a tyres result from dropdown queries
function isHaveTyres($argv){
	global $page_size, $ajax_param;

	$query = new WP_Query( $argv );

	$ajax_param = array('is_ajax' => 1, 'count_tyre' => $query->post_count);

	return $query->have_posts();
}
?>

<?php
if( $include_side_cat==1 && isHaveTyres($argv) ){
?>
	<h1>
		<?php _e('Here are our recommendations',HATT_TEXTDOMAIN); ?>
	</h1>

	<p><?php _e('Select the tyre(s) to request a quote.',HATT_TEXTDOMAIN); ?></p>

	<div id="findtyre_vehicle_cate" class="row recommendation_detail text-left">
		<div class="col-sm-12 hidden-xs">
			<div role="tabpanel">
				<!-- rfq/ajax-recommendation -->
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
				</div>
			</div>
		</div>
		<div class="row visible-xs">
			<div role="tabpanel">
				<!-- rfq/ajax-recommendation -->
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
				</div>
			</div>
		</div>
	</div>
	<div class="row">
	    <div class="col-md-12 text-right">
	            <div class="apply-today hidden-xs"> 
	                <a class="text-deco-none rfq-continue" href="<?php echo home_url().'/request-for-quote-form';?>"><?php _e( 'Continue', HATT_TEXTDOMAIN );  ?></a>
	            </div>
	            <div class="apply-today visible-xs" style="margin: 0 -15px;"> 
	                <a class="text-deco-none rfq-continue" href="<?php echo home_url().'/request-for-quote-form';?>"><?php _e( 'Continue', HATT_TEXTDOMAIN );  ?></a>
	            </div>
	    </div>
	</div>
<?php
}else{
	//draw filtered tyre(s)
	loadTyres($argv);
}
?>