<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/8/2015
	 * Time: 12:27 AM
	 */

	$class    = '';
	$term     = array();
	$html     = '';
	$arg      = array(
		'post_type'      => 'tyres',
		'posts_per_page' => 10,
		'paged'          => get_query_var( 'paged' )
	);
	$checkall = FALSE;
	$array    = explode( ',', $category );
	if ( in_array( '0', $array ) or $category = '0' ) {
		$checkall = TRUE;
		$term     = get_terms( 'tyres_cat', array( 'hide_empty' => FALSE ) );
	} else {
        $arg['tax_query'][] = array(
			'taxonomy' => 'tyres_cat',
			'terms'    => $array,
		);
		foreach ( $array as $k => $val ) {
			$term[ $k ] = get_term( $val, 'tyres_cat' );
		}
	}

	if ( isset( $_GET['feature'] ) and ! empty( $_GET['feature'] ) ) {
		$feature            = $_GET['feature'];
		$arg['tax_query'][] = array(
			'taxonomy' => 'tyres_feature',
			'terms'    => array( $feature )
		);
	}

//	if ( isset( $_GET['weather'] ) and ! empty( $_GET['weather'] ) ) {
//		$weather            = $_GET['weather'];
//		$arg['tax_query'][] = array(
//			'taxonomy' => 'tyres_weather',
//			'terms'    => array( $weather )
//		);
//	}
?>
<div role="tabpanel">

	<!-- Nav tabs -->
	<?php
		if ( ! empty( $term ) ):
            $select ='<select name="ht_custom_select_tab" class="ht_custom_select_tab visible-xs">';

            $tabul =  '<ul class="type-menu hidden-xs nav nav-pills nav-justified ">';
			if ( $checkall ):
                $tabul .= '<li role="presentation" class="active"><a href="#all" aria-controls="profile" role="tab" data-toggle="tab">All</a></li>';
                $select .= '<option value="all" selected >All</li>';
			endif;
			foreach ( $term as $k => $cat ):
				if ( ! $checkall ) {
					if ( $k == 0 ) {
						$class = 'active';
					} else {
						$class = '';
					}
				}
                $tabul .='<li role="presentation" class=" category_item '.$class.'"><a
						href="#'. $cat->slug .'" aria-controls="profile" role="tab"
						data-toggle="tab">'.esc_attr( $cat->name ).'</a></li>' ;
                $select .= '<option value="'. $cat->slug .'" >'.esc_attr( $cat->name ).'</li>';
            endforeach;
            $tabul.='</ul>';
            $select.='</select>';
            echo  $tabul .$select
			?>

			<!-- Tab panes -->
			<div class="tab-content">

				<?php if ( ! empty( $term ) ):
					if ( $checkall ):?>
						<div role="tabpanel" class="tab-pane ht_custom_tab active" id="all">
							<?php
								$all = array(
									'post_type'      => 'tyres',
									'posts_per_page' => 10,
									'paged'          => get_query_var( 'paged' )
								);
								if ( isset( $_GET['feature'] ) and ! empty( $_GET['feature'] ) ) {
									$feature_all = $_GET['feature'];
									$feature_all = explode( ',', $feature_all );
                                    $all['tax_query'][]['relation']="OR";
									$all['tax_query'][][] = array(
										'taxonomy' => 'tyres_feature',
										'terms'    => $feature_all
									);
								}

//								if ( isset( $_GET['weather'] ) and ! empty( $_GET['weather'] ) ) {
//									$weather            = $_GET['weather'];
//									$weather            = explode( ',', $weather );
//                                    $arg['tax_query'][]['relation']="OR";
//                                    $arg['tax_query'][][] = array(
//										'taxonomy' => 'tyres_weather',
//										'terms'    => $weather
//									);
//								}

                            $query = new WP_Query( $all );
								if ( $query->have_posts() ):
									while ( $query->have_posts() ):
										$query->the_post();
										echo Hatt()->load_template( 'tyres/gird', FALSE );
									endwhile;
									echo '<div class="pagination_div font- text-center">';
									ht_paging($query);
									echo '</div>';
								else:
									echo 'No results found';
								endif;
								wp_reset_query();
							?>
						</div>
					<?php endif;?>
					<?php foreach ( $term as $k => $cat ):
					if ( ! $checkall ) {
						if ( $k == 0 ) {
							$class = 'active';
						} else {
							$class = '';
						}
					}
					?>
					<div role="tabpanel" class="tab-pane ht_custom_tab <?php echo esc_attr( $class );?>"
					     id="<?php echo esc_attr( $cat->slug ); ?>">
						<?php
							$arg = array(
								'post_type'      => 'tyres',
								'posts_per_page' => 10,
								'paged'          => get_query_var( 'paged' )

							);
							if ( isset( $_GET['feature'] ) and ! empty( $_GET['feature'] ) ) {
								$feature            = $_GET['feature'];
								$feature            = explode( ',', $feature );
                                $arg['tax_query'][]['relation']="OR";
                                $arg['tax_query'][][] = array(
									'taxonomy' => 'tyres_feature',
									'terms'    => $feature
								);
							}
//							if ( isset( $_GET['weather'] ) and ! empty( $_GET['weather'] ) ) {
//								$weather            = $_GET['weather'];
//								$weather            = explode( ',', $weather );
//                                $arg['tax_query'][]['relation']="OR";
//                                $arg['tax_query'][][] = array(
//									'taxonomy' => 'tyres_weather',
//									'terms'    => $weather
//								);
//							}
							$arg_cat = array(
								'taxonomy' => 'tyres_cat',
								'terms'    => array( $cat->term_id )
							);

							$arg['tax_query'][] = $arg_cat;
							$query              = new WP_Query( $arg );
							if ( $query->have_posts() ):
								while ( $query->have_posts() ):
									$query->the_post();
									echo Hatt()->load_template( 'tyres/gird', FALSE );
								endwhile;
								echo '<div class="pagination_div font- text-center">';
								ht_paging($query);
								echo '</div>';
								unset( $arg );
							else:
								echo 'No results found';
							endif;
							wp_reset_query();
						?>
					</div>
				<?php endforeach;
				endif;?>
			</div>
		<?php endif; ?>

</div>
