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
	$array    = explode( ',', $weather );

	if ( ! empty( $array ) and is_array( $array ) ) {
		foreach ( $array as $value ) {
			if ( ! $value ) {
				$checkall = TRUE;
				break;
			}
		}
	}

	if ( $checkall ) {
		$term = get_terms( 'tyres_weather' );
	} else {
		foreach ( $array as $k => $val ) {
			$term[ $k ] = get_term( $val, 'tyres_weather' );
		}
	}
	if ( isset( $_GET['weather'] ) ) {
		$checkin = explode( ',', $_GET['weather'] );
	}

	$html = '';
	foreach ( $term as $key => $value ) {

		if ( in_array( $value->term_id, $checkin ) ) {
			$checked = 'checked=checked';
			$class   = "type_checked";
		} else {
			$checked = '';
			$class   = '';
		}
		$img = get_tax_meta( $value->term_id, 'tyre_weather_image' );
		if ( $img ) {
			$html .= '<li>
            <label class="' . $class . '" for="weather_' . $value->term_id . '">
            <span>                <img src="' . esc_attr( $img['url'] ) . '">' . $value->name . '
</span></label>
            </li>';
		} else {

			$html .= '<li class="' . $class . '">
            <label for="weather_' . $value->term_id . '">
            <span>' . $value->name . '</span></label>
            </li>';
		}
	}
	echo $html;

