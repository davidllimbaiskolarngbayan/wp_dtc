<?php
global $page_size, $ajax_param, $ajax_oe_param;

$argv = array(
    'post_type' => 'tyres',
	'post_status' => 'publish', //display published post only
    'posts_per_page' => -1 		//display all in one page
);
if(isset($selected_oe_size) && ($selected_oe_size>0) ){
	$vehicle_size_combi = $last_veh_cat_id.'_'.$selected_oe_size;

	//for template 'gird.php'
	$ajax_oe_param = array(
			'combi' => $vehicle_size_combi,
			'vehicle'=> $last_veh_cat_id,
			'size' 	=> $selected_oe_size
		);


	//list items by size instead of by OEtyre
	$argv['tax_query'][] = array(
		'taxonomy' => 'vehicles_cat',
		'field'=>'ID',
		'terms' => $last_veh_cat_id
	);
	$argv['meta_query'] = array(
		'relation' => 'OR',
		array(
			'key'     => 'ht_select_size_customa',
			'value'   => $selected_oe_size,
			'compare' => 'IN'
		),
		array(
			'key'     => 'ht_select_oetyre_combi',
			'value'   => $vehicle_size_combi,
			'compare' => 'IN'
		)
	);

}else{
	$argv['tax_query'][] = array(
		'taxonomy' => 'vehicles_cat',
		'field'=>'ID',
		'terms' => $last_veh_cat_id
	);
}


/** SETTINGS *************************************************************/
//param order names must be the same as the url get variable
$param_order = array('brand','product_year','model');

if( SITE_LOCALE == "cn" ){
	$param_order = array('brand','car_maker','product_year','model');
}

if( SITE_LOCALE == "in" ||  SITE_LOCALE == "kr" ){
	$param_order = array('brand','model');
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
if($include_side_cat==1){

	if(isset($oetyre_size_one) && !empty($oetyre_size_one)){
		$oesize_html = '<div class="oesize-label">';
		$oesize_html .= '<h4 class="oesize-head">'.__('Your Selected Size',HATT_TEXTDOMAIN).'</h4>';
		$oesize_html .= '<span class="oesize-text">'.get_the_title( $oetyre_size_one ).'</span>';
		$oesize_html .= '</div>';
	}

	//$learnmore_url = get_permalink(754);
	$learnmore_url = site_url( '/learn/original-equipment/');

?>
	<h1>
		<?php _e('Here are our recommendations',HATT_TEXTDOMAIN); ?>
	</h1>
	<div id="findtyre_vehicle_cate" class="row recommendation_detail text-left">
	<?php 
		if(!isset($_POST['rfq'])){
	?>
		<!-- RFQ -->	
		<div class="col-sm-3 hidden-xs">
			<?php echo hatt()->load_template('tyres/find/ajax', 'category'); ?>
		</div>
		<div class="col-sm-9">
			<div role="tabpanel">
				<div class="tab-content">
					<!-- find/ajax-recommendation -->
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
	<?php
		} else{
	?>
		<!-- OE -->
		<div class="col-sm-3">
			<div id="findtyre_sizedd" class="hidden-xs">
				<?php echo $oesize_html; ?>
			</div>
			<div id="findtyre_catedd" class="hidden-xs">
				<?php echo hatt()->load_template('tyres/find/ajax', 'category'); ?>
			</div>
		</div>
		<div id="sizedd_mobile" class="visible-xs">
			<?php echo $oesize_html; ?>
		</div>
		<div class="col-sm-9">
			<div role="tabpanel">
				<div class="tab-content">
					<div class="rof_box">
						<label><input id="findtyre_rof" type="checkbox" /> <?php _e('Show only Run On Flat',HATT_TEXTDOMAIN); ?></label>
					</div>
					<div id="findtyre_result_oetyre" class="tyre-box-feature-txt">
						<div class="box-colspace">
							<h2 class="title box-open"><a href="#"><?php _e('ORIGINAL EQUIPMENT TYRE',HATT_TEXTDOMAIN); ?></a></h2>
							<div class="box-colspace-content" style="display: block;">
								<div class="box-colspace-desc">
									<?php printf( __( 'OE tyres are selected by the manufacturer to provide optimum performance based on your vehicle\'s characteristics.<br>Learn more about OE tyres <a href="%1$s">here</a>.', 'kryptonite' ), esc_url( $learnmore_url ) ); ?>
								</div>
							</div>
						</div>
						<div class="box-colspace-content-result">
							<div class="box-colspace-result"></div>
							<p id="noresult-oetyre" class="text-center text-uppercase" style="display:none">
								<?php _e('No results found',HATT_TEXTDOMAIN); ?>
							</p>
						</div>
					</div>
					<div id="findtyre_result_other" class="result-desc-other">
						<h2 class="title box-open"><?php _e('OTHER COMPATIBLE TYRES',HATT_TEXTDOMAIN); ?></h2>
					</div>
					<div id="findtyre_items">
						<?php
							//draw filtered tyre(s)
							loadTyres($argv);
						?>
						<p id="noresult-ajax" class="text-center text-uppercase" style="display: none">
							<?php _e('No results found',HATT_TEXTDOMAIN); ?>
						</p>
					</div>
				</div>
			</div>
		</div>

		<?php				
			}
		?>

	</div>
	<?php echo hatt()->load_template('tyres/box', 'compare', array('ajax_param'=>$ajax_param)); ?>
<?php
}else{
	//draw filtered tyre(s)
	loadTyres($argv);
}
?>