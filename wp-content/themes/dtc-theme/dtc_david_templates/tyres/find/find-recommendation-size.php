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
<div class="ht_find_vehicle">
	<h2 class="hidden-xs">
		<span attr_id="<?php echo esc_attr( $first_number ); ?>" class="first_number"><?php echo esc_attr( $first_number ); ?></span> <span class="selected">/</span>
		<span attr_id="<?php echo esc_attr( $second_number ); ?>" class="second_number"><?php echo esc_attr( $second_number ); ?></span> <span class="selected">/</span>
		<span attr_id="<?php echo esc_attr( $third_number ); ?>" class="third_number"><?php echo esc_attr( $third_number ); ?></span>
	</h2>
    <div class="type-box type-box-filter visible-xs">
        <?php
        $permalink = get_permalink(get_the_ID());
        ?>
        <div class="find-type-filter-bar active">
            <a href="<?php echo "{$permalink}?type=size&first_number=&second_number=&third_number="; ?>"><?php echo esc_attr($_GET['first_number']); ?></a>
        </div>
        <div class="find-type-filter-bar active">
            <a href="<?php echo "{$permalink}?type=size&first_number={$_GET['first_number']}&second_number=&third_number="; ?>"><?php echo esc_attr($_GET['second_number']); ?></a>
        </div>
        <div class="find-type-filter-bar active">
            <a href="<?php echo "{$permalink}?type=size&first_number={$_GET['first_number']}&second_number={$_GET['second_number']}&third_number="; ?>"><?php echo esc_attr($_GET['third_number']); ?></a>
        </div>
    </div>
</div>
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
	<div class="col-sm-3 hidden-xs">
		<?php

		echo hatt()->load_template('tyres/browser/browser', 'category', array('category' => $ht_filter_category));

		?>
	</div>
	<div class="col-sm-9">
		<div role="tabpanel">
			<div class="tab-content">
				<div>
					<?php
						$query = new WP_Query( $argv );
						if ( $query->have_posts() ):
                            global $page_size ;
                            $page_size = true;
							while ( $query->have_posts() ):
								$query->the_post();
								echo Hatt()->load_template( 'tyres/gird', FALSE );
							endwhile;
							wp_reset_postdata();
						else: ?>
							<p class="text-center text-uppercase">
								<?php 
									if(SITE_LOCALE == 'in'){
										_e('We are sorry! We do not have tires for this model available for fitment in India at present.',HATT_TEXTDOMAIN);
									}else{
										_e('No results found',HATT_TEXTDOMAIN); 	
									}
								 ?>
							</p>
						<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

</div>
<?php echo hatt()->load_template( 'tyres/box', 'compare' ); ?>

