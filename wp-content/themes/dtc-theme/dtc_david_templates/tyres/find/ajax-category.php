<?php

		//only list categories that has post(s)
		global $wpdb;

		//get all categories
		$term = get_terms( 'tyres_cat' , array('orderby' => 'term_order','hide_empty'=>false));

		//default select
		$checkin = (int)$term[0]->term_id;


		$filter_category = _x('Filter by category','browser-category',HATT_TEXTDOMAIN);

		$html = '<h4 class="hidden-xs">' . $filter_category . '</h4><ul class="type-cate hidden-xs">';

		foreach ( $term as $key => $value ) {

			if ( $value->term_id == $checkin ) {
				$checked = 'checked=checked';
				$class   = "type_checked";
			} else {
				$checked = '';
				$class   = '';
			}

			$img = get_tax_meta( $value->term_id, 'tyre_cat_image' );

			if ( $img ) {
				$html .= '
			<li data-filter="category-'.$value->term_id.'">
				<label class="' . $class . '" for="category_' . $value->term_id . '">
				<span>' . $value->name . 'assdsa</span>
				</label>
			</li>';

			} else {

				$html .= '
			<li class="' . $class . '">
				<label for="category_' . $value->term_id . '">
				<span>' . $value->name . '</span></label>
			</li>';

			}

		}
		$html .= '</ul>';


		$html .= '<select class="visible-xs" id="category-filter-mobile">';
		foreach ( $term as $key => $value ) {

			if ( $value->term_id == $checkin ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}

			$html .= '<option value="'.$value->slug.'" '.$selected.'>'. $value->name .'</option>';
		}
		$html .= '</select> <br/> ';

		echo $html;

