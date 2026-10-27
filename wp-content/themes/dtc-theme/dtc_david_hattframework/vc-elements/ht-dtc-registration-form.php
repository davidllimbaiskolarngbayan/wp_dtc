<?php
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_ht_dtc_register_form extends WPBakeryShortCodesContainer
    {
        protected function content($attrs = array(), $content = false)
        {
            $default = array(
                'ht_tyres_category',
                'ht_dtc_tyres'
            );
			
            $data = wp_parse_args($attrs, $default);
			
			$product_model = $this->getProductModel($data);

            $vehicles_dropdowns = array(
                'vehicle_options' => $this->getVehicleParentOptions(),
                'product_model' => $product_model
            );
			
			foreach($product_model as $key => $value) {
				if (strpos($key, "R") !== false) {
					//select all with R = ROF
					//if (strpos(str_replace('R', '', $key), $data['ht_dtc_tyres']) !== false) {
						//echo $key."-" . $data['ht_dtc_tyres'];
					//} else {
						//echo $key."<";
					//}
					if ((strpos($data['ht_dtc_tyres'], str_replace('R', '', $key))) !== false) {
						$data['ht_dtc_tyres'] = $data['ht_dtc_tyres']. ",". $key;
					}
					
					
					//$data['ht_dtc_tyres'] = $data['ht_dtc_tyres']. ",". $key;
				}
			}
			
            return hatt()->load_template('dtc/register-form', 'element', array( 'data' => $data, 'content' => $content, 'dropdowns' => $vehicles_dropdowns ));
        }

        /** generate vehicles dropdown **/
        function getVehicleParentOptions(){

            //get parent vehicles
            $parent_vehicle_option = get_terms( 'vehicles_cat', array( 'orderby' => 'name', 'parent' => 0,'hide_empty' => 0 ) );
            
            //prep data by first letter
            $option_groups = array();
            foreach($parent_vehicle_option as $vehicle){
                $option_groups_label = strtoupper(substr($vehicle->slug,0,1));

                if( !isset($option_groups[$option_groups_label])){
                    $option_groups[$option_groups_label] = array();
                }
                $option_groups[$option_groups_label][] = array('term_id' =>$vehicle->term_id, 'name' =>$vehicle->name );
            }
            // ./end prep


            //create html options for the first dropdown
            $parent_vehicle_option_html = "";
            foreach( $option_groups as $option_group => $options) {
                $parent_vehicle_option_html .= "<optgroup label='$option_group'>";
                foreach ($options as $option ) {
                    $parent_vehicle_option_html .= "<option value='{$option['term_id']}|{$option['name']}'>{$option['name']}</option>";
                }
                $parent_vehicle_option_html .= "</optgroup>";
            }

            return $this->drawOptions($parent_vehicle_option_html);

            // ./end html options
        }

        function drawOptions($parent_vehicle_option_html){
            $html = '';
            $labels = array(
                    'brand' 	=> __('BRAND/Jenama',HATT_TEXTDOMAIN),
                    'model' 	=> __('Model',HATT_TEXTDOMAIN),
                    'car_maker' => __('Car Maker',HATT_TEXTDOMAIN),
                    'product_year' 		=> __('Product Year',HATT_TEXTDOMAIN),
                    'variant' => __('Variant',HATT_TEXTDOMAIN)
            );

            //param order names must be the same as the url get variable
            $param_order = array('brand','model','product_year');

            if( SITE_LOCALE == "cn" ){
                $param_order = array('brand','car_maker','product_year','model');
            }

            if( SITE_LOCALE == "kr" ){
                $param_order = array('brand','model');
            }

            if( SITE_LOCALE == "my" ){
                $param_order = array('brand','model');
            }

            if( SITE_LOCALE == "in" ){
                $param_order = array('brand','model','variant','product_year');
            }

            foreach($param_order as $order_no => $dropdown_name) :

                $disabled = ($order_no != 0)  ? 'disabled' : '';

                //$required = ($order_no + 1 != count($param_order) )  ? 'required' : '';
				switch ($order_no) {
                    case 0:
                        $required = "required data-parsley-required-message='Please select your vehicle brand'";
                        break;
                    case 1:
                        $required = "required data-parsley-required-message='Please select your vehicle model'";
                        break;
					case 2:
                        $required = "required data-parsley-required-message='Please select your vehicle variant'";
                        break;
                    case 3:
                        $required = "required data-parsley-required-message='Please select your vehicle product year'";
                        break;
                    default:
                        # code...
                        break;
                }

                $html .= "<select name='{$dropdown_name}' id='dtc-vehicle-{$order_no}' {$disabled} class='wpcf7-form-control wpcf7-text wpcf7-validates-as-required dtc-select' {$required}>";
                if( $dropdown_name != 'product_year' ){
                    $html .= "<option value=''>* {$labels[$dropdown_name]}</option>";
                } else {
                    $html .= "<option value=''>{$labels[$dropdown_name]}</option>";
                }
                $html .=  ($order_no == 0)  ? $parent_vehicle_option_html : "";
                $html .=  "</select>";
            endforeach;
            return $html;
        }

        function getProductModel($data){
            $tyreCategory = explode(',', $data['ht_tyres_category']);

			$dtcTyres = explode(',', $data['ht_dtc_tyres']); 

            $type = 'tyres';
            $args = [
                'post_type' => $type,
                'post_status' => array('publish', 'draft'),
                //'tax_query' => array(
                //    array(
                //        'taxonomy' => 'tyres_cat',
                //        'field' => 'id',
                //        'terms' => $tyreCategory
                //    )
                //),
                'posts_per_page' => -1,
                'orderby' => ['post_title' => 'ASC'],
            ];
            $my_query = null;
            $my_query = new WP_Query($args);

            // The Loop
            if ( $my_query->have_posts() ) {
                while ( $my_query->have_posts() ) {
                    $my_query->the_post();
                    $id = get_the_ID();
					$rof = (get_post_meta(get_the_ID(), 'ht_tyre_rof', true)=='on');
                
					/* return  DTC tyres only */
					if (in_array($id, $dtcTyres)) {
					
                    //if (strpos(get_the_title(), 'David Tyre Company') !== false) {
                        //$product_model[$id] = ( $rof ) ? get_the_title().' (ROF)' : get_the_title();
                        //echo $id.'--';

						$product_model[$id] = get_the_title();
						
						if ($rof) {
							$product_model[$id] = get_the_title();
							$product_model[$id."R"] = get_the_title() .' (ROF) ';
							
						} else {
							$product_model[$id] = get_the_title();
						}
                    }
                }
                return $product_model;
            } else {
                // no posts found
            }

            /* Restore original Post Data */
            wp_reset_postdata();

        }

    }

}


function serializeArray($data){
    foreach ($data as $key => $value) {
        $data[$key] = $key;
    }
    return $data;
}

// Serialize the dtc tyres
$dtcTyres = getAllTyres();
unset($dtcTyres['-Select Tyre-']);

vc_map(
    array(
        "name" => __("DTC Registration Form", HATT_TEXTDOMAIN),
        "base" => "ht_dtc_register_form",
        "content_element" => true,
        "show_settings_on_create" => true,
        "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
        "category" => "HTFramework",
        "js_view" => 'VcColumnView',
        "params" => array(
            array(
                'type'=>'checkbox',
                'holder'=>'div',
                'heading'=>__('Select Tyre Category',HATT_TEXTDOMAIN),
                'param_name'=>'ht_tyres_category',
                'value'=> btp_get_list_taxonomy('tyres_cat'),
            ),
            array(
                'type'=>'checkbox',
                'holder'=>'div',
                'heading'=>__('Select DTC Tyres',HATT_TEXTDOMAIN),
                'param_name'=>'ht_dtc_tyres',
                'value'=> $dtcTyres,
            ),
        )
    )
);
