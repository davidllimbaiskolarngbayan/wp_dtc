<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/8/2015
	 * Time: 12:03 AM
	 */
	$term     = array();
	$html     = '';
	$checkin  = array();
	$checkall = FALSE;
	$array    = explode( ',', $feature );
	$filter_features = '';

	$feature_filters = array();

  		$arg = array(
            'post_type'      => 'tyres',
            'posts_per_page' => -1,
            'tax_query' => array('relation' => 'AND')
        );

        //default to first item
        $categories = get_terms( 'tyres_cat' );
        $default_category =  array($categories[0]->slug);

        $query_category =  ( isset($_GET['category']) &&  !empty($_GET['category'])  ) ? $_GET['category'] :  $default_category;

        $arg['tax_query'][] = array(
            'taxonomy' => 'tyres_cat',
            'field'    => 'slug',
            'terms'    => $query_category,
        );

        if (isset($_GET['feature']) and !empty($_GET['feature'])) {
            $feature = $_GET['feature'];
            $feature = explode(',', $feature);

            $arg['tax_query'][] = array(
                'taxonomy' => 'tyres_feature',
                'field'    => 'slug',
                'terms'    => $feature
            );
        }

        $query = new WP_Query($arg);
        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                	
		
					$term_list = wp_get_post_terms(get_the_ID(), 'tyres_feature', array("fields" => "all"));
					foreach($term_list as $key => $tyre_feature){
						$feature_filters[$tyre_feature->slug] =  $tyre_feature->name;
					}
                
            endwhile;
        endif;
        wp_reset_query();

        asort($feature_filters);


   

	if( count($feature_filters) > 0 ){

		__('Filter by features',HATT_TEXTDOMAIN);
		
		$html = '<h4 class="hidden-xs">' . $filter_features . '</h4><ul class="type-cate">';
		foreach ( $feature_filters as $key => $value ) {


			if (  $key ==  $_GET['feature'] ) {
				$checked = 'checked=checked';
				$class   = "type_checked";
			} else {
				$checked = '';
				$class   = '';
			}

			$html .= 
					'<li>
	           			<label class="' . $class . '" for="feature_' . $key . '">
	            			<span>' . $value . '</span>
	            		</label>
	        		</li>';
			
		}
		$html .= '</ul>';
		echo $html;

	}
	

