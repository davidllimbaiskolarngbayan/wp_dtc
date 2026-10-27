<?php

session_start();

/** SETTINGS *************************************************************/
    //default labels
    $labels = array(
        'brand'     => __('Brand',HATT_TEXTDOMAIN),
        'model'     => __('Model',HATT_TEXTDOMAIN),
        'car_maker' => __('Car Maker',HATT_TEXTDOMAIN),
        'product_year'      => __('Product Year',HATT_TEXTDOMAIN)
    );

    //param order names must be the same as the url get variable
    $param_order = array('brand','product_year','model');

    if( SITE_LOCALE == "cn" ){
        $param_order = array('brand','car_maker','product_year','model');
    }

    if( SITE_LOCALE == "kr" ){
        $param_order = array('brand','model');
    }

    if( SITE_LOCALE == "in" ){
        $param_order = array('brand','model','variant','product_year');
    }

    if( SITE_LOCALE == "my" ){
        $param_order = array('brand','model','variant','product_year');
    }
    

/** SETTINGS *************************************************************/
function findtyre_getterms($parent_id, $order_by, $sort_order){
    /*
    - get_terms has error on 'orderby' which is force to orderby 'term_order' due to plugin 'taxonomy-terms-order' and line 145 at 'plugins/taxonomy-terms-order/taxonomy-terms-order.php'
    - this is because this file is calling by ajax (admin-ajax.php)
    - hence, we have to create the SQL query
    */
    //$data = get_terms( 'vehicles_cat', array( 'parent' => $parent_id , 'hide_empty' => 0 , 'orderby' => $order_by, 'order' => $sort_order) );

    global $wpdb;
    $query = "SELECT t.*, tt.* FROM {$wpdb->terms} AS t"
              ." INNER JOIN {$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id"
              ." WHERE tt.taxonomy IN ('vehicles_cat') AND tt.parent = ".esc_sql($parent_id)
              ." ORDER BY t.{$order_by} {$sort_order}";
    $data = $wpdb->get_results($query);

    return $data;
}
function draw_findtyre_optionlist($cat_options,$has_optgroup=0){
    //prepare list options
    $list_content = '';
    if(!empty($cat_options)){
        $optgroup = '';
        foreach($cat_options as $cat_value){
            $starter = substr($cat_value->slug,0,1);

            if($has_optgroup==1 && $optgroup!='' && $optgroup!=$starter){
                $list_content .= '</optgroup>';
            }
            if($has_optgroup==1 && $optgroup!=$starter){
                $list_content .= '<optgroup label="'.strtoupper($starter).'">';
                $optgroup = $starter;
            }

            $list_content .= '<option value="'.$cat_value->term_id.'" '.$selected.'>'.$cat_value->name.'</option>';

        }
        if($has_optgroup==1 && $optgroup!=''){
            $list_content .= '</optgroup>';
        }
    }

    return $list_content;
}

/***************************************************************/

    //determine total dropdown list (category type)
    $total_cat_type = sizeof($param_order);

    $tyreact = $_POST['tyreact'];

    $ajax_array = array();
    $last_vehicle_term = '';

    //load vehicle list / filtered results
    if($tyreact == 'loadvehicle'){

        $vehicle_categories = $_POST['veh_cat'];
        $selected_category = $_POST['cat_no'];

        $ajax_array = array(
            'result' => 0,
            'total_cat' => $total_cat_type,
            'sel_cat'   => $selected_category,
            'html'      => '',
            'options'   => ''
        );

        if(empty($vehicle_categories[$selected_category])) {

            $ajax_array['result'] = 0;
            $ajax_array['options'] = '';

        }else{

            foreach ($param_order as $key => $value) {
                if($selected_category == $key){
                    if ( end($param_order) == $value )  {

                        unset($_SESSION['items']);
                        
                        //get name of selected ID
                        $term = get_term_by('id', $vehicle_categories[$key], 'vehicles_cat' );

                        //recommendation params
                        $recommendation_params = array();
                        $recommendation_params['include_side_cat'] = 1;
                        $recommendation_params['last_veh_cat_id'] = $term->term_id;

                        //prepare for session
                        $last_vehicle_term = $term->slug;

                        $ajax_array['result'] = 1;
                        $ajax_array['html'] = hatt()->load_template( 'tyres/rfq/ajax', 'recommendation', $recommendation_params);

                        break;

                    }else{

                        
                        //prepare child category
                        $sort_order  = 'ASC'; //($param_order[$key+1] == 'product_year' ) ? 'DESC' : 'ASC';
                        $order_by    = 'name'; //($param_order[$key+1] == 'product_year' ) ? 'name' : 'slug';
                        $has_optgroup = 0; //($param_order[$key+1] == 'product_year' ) ? 0 : 1;

                        //load child category options
                        $cat_options = findtyre_getterms($vehicle_categories[$key], $order_by, $sort_order);

                        //list options
                        $ajax_array['result'] = 0;
                        $ajax_array['options'] = draw_findtyre_optionlist($cat_options,$has_optgroup);

                        break;

                    }
                }
            }
        }
    }
    elseif($tyreact == 'loadvehicle_preload'){
        //load content by using cookie

        $vehicle_categories = $_POST['veh_cat'];

        $ajax_array['data_array'] = $_POST;
        $ajax_array['html'] = '';
        $ajax_array['debug']="rfq/ajax-vehicle";

        //load select options content
        $ajax_array['options_of'] = array();
        foreach ($param_order as $key => $value) {
            if(empty($vehicle_categories[$key])) {
                break;
            }

            if ( end($param_order) == $value ){

                //get name of selected ID
                $term = get_term_by('id', $vehicle_categories[$key], 'vehicles_cat' );

                //recommendation params
                $recommendation_params = array();
                $recommendation_params['include_side_cat'] = 1;
                $recommendation_params['last_veh_cat_id'] = $term->term_id;

                //prepare for session:store model to session
                $last_vehicle_term = $term->slug;

                $ajax_array['html'] = hatt()->load_template( 'tyres/rfq/ajax', 'recommendation', $recommendation_params);

            }else{
                //prepare child category
                $sort_order  = 'ASC'; //($param_order[$key+1] == 'product_year' ) ? 'DESC' : 'ASC';
                $order_by    = 'name'; //($param_order[$key+1] == 'product_year' ) ? 'name' : 'slug';
                $has_optgroup = 0; //($param_order[$key+1] == 'product_year' ) ? 0 : 1;

                //load child category options
                $cat_options = findtyre_getterms($vehicle_categories[$key], $order_by, $sort_order);

                //list options
                $ajax_array['options_of'][$key+1] = draw_findtyre_optionlist($cat_options,$has_optgroup);

            }
        }
    }


//set cookie
$cookie_expiry = strtotime('+10 days'); //time()+3600;
$cookie_path = "/";
$cookie_domain = $_SERVER['HTTP_HOST'];

setcookie("findtyre", 'vehicle', ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftveh[totalcat]",$total_cat_type, ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
for($i=0; $i<$total_cat_type; $i++){
    $v = (isset($_POST['veh_cat'][$i]))? $_POST['veh_cat'][$i] : '';
    setcookie("ftveh[vehcat][".$i."]",$v, ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);

    if(($i+1)==$total_cat_type){
        //store model to session
        $_SESSION['vehicle_term'] = $term->slug ;
    }

}
setcookie("ftsize[cat]",$_POST['tyrecate'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);


//remove session
unset($_SESSION['ht_size_width']);
unset($_SESSION['ht_size_ratio']);
unset($_SESSION['ht_size_diameter']);
unset($_SESSION['vehicle_term']);
//set session
if(!empty($last_vehicle_term)){
    $_SESSION['vehicle_term'] = $last_vehicle_term;
}


header( "Content-Type: application/json" );
echo json_encode($ajax_array);
exit;
?>