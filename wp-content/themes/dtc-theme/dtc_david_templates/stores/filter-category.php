<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/8/2015
	 * Time: 12:03 AM
	 */
	$term    = array();
	$html    = '';
	$checkin = array();
	if ( isset( $_GET['category'] ) ) {
		$checkin = explode( ',', $_GET['category'] );
	}
	$array = explode( ',', $category );
	if ( in_array( '0', $array ) ) {
		$term = get_terms( 'store_cat' );
	} else {
		foreach ( $array as $k => $val ) {
			$term[ $k ] = $val;
		}
	}

	//sort array of objects based on property of obj (term_order)
	function cmp($a, $b) {
		return strcmp($a->term_order, $b->term_order);
	}
	usort($term, "cmp");
	echo "<!-- ".print_r($term,true)." -->";	
	
	$filter_category = __('Filter by category',HATT_TEXTDOMAIN);
	$filter_all = __('All',HATT_TEXTDOMAIN);
	
	$html = '<h3><b>' . $filter_category . '</b></h3><ul class="type-cate">';
 	

	if(trim($_GET['category']) == '' ||  !$_GET['category']){
		$all_class= "type_checked";
	}

	
 	$html .= '<li class="' . $all_class . '">
            <label for="category_">
            <span>' . $filter_all . '</span></label>
            </li>';

	foreach ( $term as $key => $value ) {
		if ( in_array( $value->term_id, $checkin ) ) {
			$checked = 'checked=checked';
			$class   = "type_checked";
		} else {
			$checked = '';
			$class   = '';
		}

		$img = get_tax_meta( $value->term_id, 'store_cat_image' );
		if ( $img ) {
//			$html .= '<li>
//            <label class="' . $class . '" for="category_' . $value->term_id . '">
//            <span>                <img src="' . esc_attr( $img['url'] ) . '">' . $value->name . '
//</span></label>
//            </li>';
            $html .= '<li class="' . $class . '">
            <label for="category_' . $value->term_id . '">
            <span>' . $value->name . '</span></label>
            </li>';
		} else {

			$html .= '<li class="' . $class . '">
            <label for="category_' . $value->term_id . '">
            <span>' . $value->name . '</span></label>
            </li>';
		}
	}
	$html .= '</ul>';

	echo $html;

