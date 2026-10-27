<?php
$oe_sizes_arr = array();
if(isset($oetyre_size_array) && !empty($oetyre_size_array)){
	foreach($oetyre_size_array as $oe_size){
		$oe_sizes_arr[] = $oe_size->combi_size_id;
	}
}

if(isset($all_size_array) && !empty($all_size_array)){
?>
	<div class="vedd-vsize-box text-left">
		<div class="vsize-leftbox">
			<div class="vsize-desc"><?php _e("The following tyre sizes were found for your vehicle’s model.",HATT_TEXTDOMAIN); ?></div>
			<div class="vsize-selects">
				<?php foreach($all_size_array as $size){ ?>
					<div class="vsize-item" data-size="<?php echo $size->post_id; ?>"><?php echo $size->post_title; ?></div>
				<?php } ?>
			</div>
		</div>
		<div class="vsize-rightbox">
			<div class="vsize-desc"><?php _e("To find out which is the right one for your vehicle, check the details on your original tyre or refer to your vehicle's documentation.",HATT_TEXTDOMAIN); ?></div>
			<div class="vsize-image">
				<img src="<?php echo esc_url( get_template_directory_uri() ) . '/images/tyres/tyre_size_code.png'; ?>" alt="" />
			</div>
		</div>
	</div>
<?php

	//Mobile view
	$html = '<div id="oesizedd_sample" class="oesize-label" style="display: none;">';
	$html .= '<h4 class="oesize-head">'.__('Your Selected Size',HATT_TEXTDOMAIN).'</h4>';
	$html .= '<select id="oesize-filter-mobile">';
	if(sizeof($oe_sizes_arr) > 0){
		$oetyre_size_opt = '';
		$other_size_opt = '';
		//$html .= '<option value="-1">'.__('Choose a size',HATT_TEXTDOMAIN).'</option>';
		foreach($all_size_array as $size){
			$option_sel = ($dd_selected_size==$size->post_id)? 'selected':'';
			if(in_array($size->post_id,$oe_sizes_arr)){
				$oetyre_size_opt .= '<option value="'.$size->post_id.'" '.$option_sel.'>'. $size->post_title .'</option>';
			}else{
				$other_size_opt .= '<option value="'.$size->post_id.'" '.$option_sel.'>'. $size->post_title .'</option>';
			}
		}

		if($oetyre_size_opt !=''){
			$html .= '<optgroup label="'.__('OE tyre size(s)',HATT_TEXTDOMAIN).'">'.$oetyre_size_opt.'</optgroup>';
		}
		if($other_size_opt !=''){
			$html .= '<optgroup label="'.__('Other tyre size(s)',HATT_TEXTDOMAIN).'">'.$other_size_opt.'</optgroup>';
		}
	}else{
		//$html .= '<option value="-1">'.__('Choose a size',HATT_TEXTDOMAIN).'</option>';
		foreach($all_size_array as $size){
			$option_sel = ($dd_selected_size==$size->post_id)? 'selected':'';
			$html .= '<option value="'.$size->post_id.'" '.$option_sel.'>'. $size->post_title .'</option>';
		}
	}
	$html .= '</select></div>';
	echo $html;
}
?>
