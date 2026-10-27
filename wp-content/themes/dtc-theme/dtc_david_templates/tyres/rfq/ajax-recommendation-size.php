<?php
	$postin = array();
	if ( $all_sizes ) {
		foreach ( $all_sizes as $value ) {
			$postin[] = $value->post_id;
		}
	}
	$argv = array(
		'post_type'      => 'tyres',
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'     => 'ht_select_size_customa',
				'value'   => $postin,
				'compare' => 'IN',
			)
		),

	);

	//
	//
	//
	//
	//if($all_sizes){
	//	foreach ( $all_sizes as  $value ) {
	//		$argv['meta_query' ][] =
	//			array(
	//				'key'     => 'ht_tyre_size_select',
	//				'value'   => $value->post_id,
	//				'compare' => 'IN',
	//			);
	//}};


?>
<h1>
	<?php _e('Here are our recommendations',HATT_TEXTDOMAIN); ?>
</h1>
<p><?php _e('Select the tyre(s) to request a quote.',HATT_TEXTDOMAIN); ?></p>

<?php
	if ( !empty( $_GET['category']) && $_GET['category'] != 'all'  ) {
		$category             = $_GET['category'];
		$argv['tax_query'][] = array(
			'taxonomy' => 'tyres_cat',
			'field' => 'slug',
			'terms'    => explode( ',', $category )
		);
	}
?>
<div class="row recommendation_detail text-left">
	<div class="col-sm-12">
		<div role="tabpanel">
			<!-- rfq/ajax-recommendation -->
			<div class="tab-content">
			<div class="rof_box">
				<label><input id="findtyre_rof" type="checkbox" /> <?php _e('Show only Run On Flat',HATT_TEXTDOMAIN); ?></label>
			</div>
			<div id="findtyre_items">
				<?php
					$query = new WP_Query( $argv );
					if ( $query->have_posts() ):
                         global $page_size ;
                         $page_size = true;
						while ( $query->have_posts() ):
							$query->the_post();
							echo Hatt()->load_template( 'tyres/rfq/rfq', 'grid' );
						endwhile;
						wp_reset_postdata();
					else: ?>
						<p class="text-center text-uppercase">
							<?php _e('No results found',HATT_TEXTDOMAIN); ?>
						</p>
					<?php endif; ?>
			</div>
			</div>
		</div>
	</div>

</div>

<div class="row">
    <div class="col-md-12 text-right  ">
        <div class="apply-today hidden-xs"> 
            <a class="text-deco-none rfq-continue" href="<?php echo home_url().'/request-for-quote-form';?>"><?php _e( 'Continue', HATT_TEXTDOMAIN );  ?></a>
        </div>
        <div class="apply-today visible-xs" style="margin: 0 -15px;"> 
            <a class="text-deco-none rfq-continue" href="<?php echo home_url().'/request-for-quote-form';?>"><?php _e( 'Continue', HATT_TEXTDOMAIN );  ?></a>
        </div>
    </div>
</div>