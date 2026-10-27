<div class="row">
<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/7/2015
	 * Time: 11:48 PM
	 */

	if(SITE_LOCALE == 'in' ){
    	global $wp_query;
    	$_GET['category'] = $wp_query->query_vars['category'] ;
	}

	if ( is_array( $data ) and ! empty( $data ) ):
		extract( $data );
        if ( isset( $_GET['compare_true'] ) and ! empty( $_GET['compare_true'] ) ) {
            echo hatt()->load_template( 'tyres/compare', FALSE );
            return;
        }


		if ( $ht_filter_position == 'left' ):?>
			<div class="col-sm-3 hidden-xs">
				<?php
                    if (isset($ht_show_filter_category) and $ht_show_filter_category == 'show'):
                        echo hatt()->load_template('tyres/browser/browser', 'category', array('category' => $ht_filter_category));
                    endif;
//					if (isset($ht_show_filter_features) and $ht_show_filter_features == 'show' ):
//						echo hatt()->load_template( 'tyres/browser/browser', 'feature', array( 'feature' => $ht_filter_features ) );
//					endif;
//					if (isset($ht_show_filter_weather) and  $ht_show_filter_weather == 'show' ):
//						echo hatt()->load_template( 'tyres/browser/browser', 'weather', array( 'weather' => $ht_filter_weather ) );
//					endif;
				?>
			</div>

			<!-- show dropdown on mobile -->
			<div class="col-sm-12 visible-xs">
				<?php 
					if (isset($ht_show_filter_category) and $ht_show_filter_category == 'show' ):
						echo hatt()->load_template( 'tyres/browser/browser', 'category', array( 'category' => $ht_filter_category) );
					endif;
				?>
			</div>

		<?php endif;
		if ( $ht_show_filter_features and  $ht_show_filter_features == 'show' ) {
			echo '<div class="col-sm-9 col-xs-12">';
		} else {
			echo '<div class="col-sm-12 col-xs-12">';
		};
		echo hatt()->load_template( 'tyres/browser/browser', 'content-fix', array( 'category' => $ht_filter_category,'ht_show_filter_category'=>$ht_show_filter_category ) );
		echo '</div>';

		if ( $ht_filter_position and  $ht_filter_position == 'right' ):?>
			<div class="col-sm-3 hidden-xs">
				<?php
                    if (isset($ht_show_filter_category) and $ht_show_filter_category == 'show'):
                        echo hatt()->load_template('tyres/browser/browser', 'category', array('category' => $ht_filter_category));
                    endif;
					if ( $ht_show_filter_features == 'show' ):
						echo hatt()->load_template( 'tyres/browser/browser', 'feature', array( 'feature' => $ht_filter_features ) );
					endif;
//					if ( $ht_show_filter_weather == 'show' ):
//						echo hatt()->load_template( 'tyres/browser/browser', 'weather', array( 'weather' => $ht_filter_weather ) );
//					endif;
				?>
			</div>
		<?php endif;?>

	<?php endif; ?>
    <div class="clearfix"></div>
</div>
<div class="ht_custom_sticky_compare_box">
    <br/>
    <?php echo hatt()->load_template('tyres/box', 'compare'); ?>
</div>