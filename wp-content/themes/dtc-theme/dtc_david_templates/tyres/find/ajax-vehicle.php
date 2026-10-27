<?php

/** SETTINGS *************************************************************/
    //default labels
    $labels = array(
        'brand' 	=> __('Brand',HATT_TEXTDOMAIN),
        'model' 	=> __('Model',HATT_TEXTDOMAIN),
        'car_maker' => __('Car Maker',HATT_TEXTDOMAIN),
        'product_year' 		=> __('Product Year',HATT_TEXTDOMAIN),
        'variant' => __('Variant',HATT_TEXTDOMAIN)
    );

    //param order names must be the same as the url get variable
    $param_order = array('brand','product_year','model');

    if( SITE_LOCALE == "cn" ){
        $param_order = array('brand','car_maker','product_year','model');
    }

    if( SITE_LOCALE == "kr" ){
        $param_order = array('brand','model');
    }
    
    if( SITE_LOCALE == "my" ){
        $param_order = array('brand','model','variant','product_year'); 
    }


    if( SITE_LOCALE == "in" ){
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

//OE Tyres
function findtyre_list_size_byvehicle($last_veh_cat_term, $str_tyre_names){
    //list all sizes of filtered tyre
    global $wpdb;
    $query = "SELECT DISTINCT(e.`post_id`), d.post_title
FROM hatt_terms a
LEFT OUTER JOIN hatt_term_taxonomy b
    ON a.`term_id` = b.`term_id` AND b.`taxonomy` = 'vehicles_cat'
LEFT OUTER JOIN hatt_term_relationships c
    ON b.`term_taxonomy_id` = c.`term_taxonomy_id`
LEFT OUTER JOIN hatt_posts d
    ON d.`ID` = c.`object_id` AND d.`post_type` = 'size'
LEFT OUTER JOIN `hatt_postmeta` e
    ON e.`post_id` = d.`ID`
LEFT OUTER JOIN `hatt_postmeta` f
    ON f.`post_id` = d.`ID` AND f.`meta_key` = 'ht_tyre_code'
WHERE
a.`slug`= '{$last_veh_cat_term}'
AND e.`post_id` IS NOT NULL
AND f.`meta_value` IN ({$str_tyre_names}) ";
    return $wpdb->get_results($query);
}
function findtyre_oetyre_size_byvehicle($last_veh_cat_id, $last_veh_cat_term, $str_tyre_postin, $str_tyre_names){
    //OEtyre size combi must match with tyre code + vehicle, otherwise, it won't be shown even if it's selected at the admin panel

    global $wpdb;

    //get OEtyre combination
    $query_1 = "SELECT pm1.* FROM {$wpdb->postmeta} AS pm1 "
        ." WHERE ( pm1.meta_key = 'ht_select_oetyre_combi' AND pm1.meta_value LIKE '".$last_veh_cat_id."_%' )"
        ." AND ( CAST(pm1.post_id AS CHAR) IN ( {$str_tyre_postin} ) )"
        ." GROUP BY pm1.meta_value";
    $oetyre_combi = $wpdb->get_results($query_1);

    if(empty($oetyre_combi)) {
        return false;
    }

    //prepare sizes
    $sizes_arr = array();
    foreach($oetyre_combi as $oe_combi){
        list($oe_vehicle, $oe_size) = explode('_',$oe_combi->meta_value);
        $sizes_arr[] = $oe_size;
    }
    $str_oe_sizes = "'".implode("','",$sizes_arr)."'";

    //check if size(s) in combinations are available in 'size + tyre_code + vehicle + tyre';
    $query_2 = "SELECT DISTINCT(e.`post_id`), d.post_title, e.post_id as combi_size_id
FROM hatt_terms a
LEFT OUTER JOIN hatt_term_taxonomy b
    ON a.`term_id` = b.`term_id` AND b.`taxonomy` = 'vehicles_cat'
LEFT OUTER JOIN hatt_term_relationships c
    ON b.`term_taxonomy_id` = c.`term_taxonomy_id`
LEFT OUTER JOIN hatt_posts d
    ON d.`ID` = c.`object_id` AND d.`post_type` = 'size'
LEFT OUTER JOIN `hatt_postmeta` e
    ON e.`post_id` = d.`ID`
LEFT OUTER JOIN `hatt_postmeta` f
    ON f.`post_id` = d.`ID` AND f.`meta_key` = 'ht_tyre_code'
WHERE
a.`slug`= '{$last_veh_cat_term}'
AND e.`post_id` IN ({$str_oe_sizes})
AND f.`meta_value` IN ({$str_tyre_names}) ";
    return $wpdb->get_results($query_2);
}
function oetyre_filtering($ajax_array, $recommendation_params){

    //filter tyre posts (get IDs)
    $argv = array(
        'post_type'     => 'tyres',
        'post_status'   => 'publish',
        'posts_per_page'=> -1
    );
    $argv['tax_query'][] = array(
        'taxonomy' => 'vehicles_cat',
        'field'=>'ID',
        'terms' => $recommendation_params['last_veh_cat_id']
    );

    $tyre_post_ids = array();
    $tyre_post_names = array();

    //get tyre post by vehicle
    $query = new WP_Query( $argv );
    if ( $query->have_posts() ){
        while ( $query->have_posts() ){
            $query->the_post();
            $tyre_post_ids[]= $query->post->ID;
            $tyre_post_names[]= $query->post->post_name;
        }
        wp_reset_postdata();

        $str_tyre_postin = "'".implode("','",$tyre_post_ids)."'";
        $str_tyre_names = "'".implode("','",$tyre_post_names)."'";

        //prepare list of size dropdown
        $recommendation_params['all_size_array'] = findtyre_list_size_byvehicle($recommendation_params['last_veh_cat_term'], $str_tyre_names);

        if(empty($recommendation_params['all_size_array'])){

            //we don't need the dropdown list anymore
            $recommendation_params['all_size_array'] = false;
            $recommendation_params['selected_oe_size'] = '-1'; //for tyre filtering
            $_POST['oe_size'] = '-1'; //to update cookies

        }elseif(sizeof($recommendation_params['all_size_array'])==1){

            $one_tyre_size = $recommendation_params['all_size_array'][0]->post_id;

            //we don't need the dropdown list anymore
            $recommendation_params['all_size_array'] = false;
            $recommendation_params['oetyre_size_one'] = $one_tyre_size;
            $recommendation_params['selected_oe_size'] = $one_tyre_size; //for tyre filtering

            $_POST['oe_size'] = $one_tyre_size; //to update cookies

        }else{

            if(!empty($_POST['oe_size'])){
                $recommendation_params['selected_oe_size'] = $_POST['oe_size']; //for tyre filtering
                $recommendation_params['dd_selected_size'] = $_POST['oe_size'];
            }else{
                $ajax_array['show_oesize'] = 1; //show OE size box
            }

            //get tyre sizes of OEtyre combi
            $oetyre_sizes = findtyre_oetyre_size_byvehicle($recommendation_params['last_veh_cat_id'], $recommendation_params['last_veh_cat_term'], $str_tyre_postin, $str_tyre_names);
            $recommendation_params['oetyre_size_array'] = $oetyre_sizes;

        }

        $ajax_array['html_oesize'] = hatt()->load_template( 'tyres/find/ajax', 'vehicle-size', $recommendation_params);

    }else{
        //no data
    }

    return array($ajax_array, $recommendation_params,$_POST);

}

/***************************************************************/

    //determine total dropdown list (category type)
    $total_cat_type = sizeof($param_order);

    $tyreact = $_POST['tyreact'];

    $ajax_array = array();
    //For sessions
    $last_vehicle_term = '';
    $ss_oetyre_combi = '';
    $ss_vehicle_label = false;

    //load vehicle list / filtered results
    if($tyreact == 'loadvehicle'){

        $vehicle_categories = $_POST['veh_cat'];
        $selected_category = $_POST['cat_no'];
        if(isset($_POST['filteroe']) && $_POST['filteroe']==1){
            end($vehicle_categories);
            $selected_category = key($vehicle_categories);
        }

        $ajax_array = array(
            'result' => 0,
            'total_cat' => $total_cat_type,
            'sel_cat'   => $selected_category,
            'html'      => '', //content
            'options'   => '', //dropdown list
            //OEtyres
            'show_oesize' => 0,
            'one_oesize' => 0,
            'html_oesize' => '', //content for size of OEtyre
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
                        $recommendation_params['last_veh_cat_term'] = $term->slug;

                        //prepare for session
                        $last_vehicle_term = $term->slug;

                        $ajax_array['result'] = 1;


                        //show OEtypre size filters (if any)
                        /*
                        //comment this out to enable OE size
                        if(!isset($_POST['oe_size']) or empty($_POST['oe_size'])){
                            list($ajax_array, $recommendation_params, $_POST) = oetyre_filtering($ajax_array, $recommendation_params);

                            if(empty($_POST['oe_size']) && $ajax_array['show_oesize']==0){$_POST['oe_size'] = '-1';}
                        }
                        */

                        if(empty($_POST['oe_size']) && $ajax_array['show_oesize']==0){$_POST['oe_size'] = '-1';}

                        if(isset($_POST['oe_size']) && !empty($_POST['oe_size'])){
                            //show filtering results
                            $recommendation_params['selected_oe_size'] = $_POST['oe_size'];
                            if($recommendation_params['selected_oe_size'] > 0){
                                //prepare for session
                                $ss_oetyre_combi = $recommendation_params['last_veh_cat_id'].'_'.$recommendation_params['selected_oe_size'];
                            }

                            $ajax_array['html'] .= hatt()->load_template( 'tyres/find/ajax', 'recommendation', $recommendation_params);

                            //prepare label session for single tyre page
                            reset($param_order);
                            foreach ($param_order as $key => $value) {
                                //get name of selected ID
                                $cat_term = get_term_by('id', $vehicle_categories[$key], 'vehicles_cat' );
                                $ss_vehicle_label[] = $cat_term->name;
                            }
                        }


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

        //Prepare
        $ajax_array = array(
            'html'      => '', //content
            'options'   => '', //dropdown list
            //OEtyres
            'show_oesize' => 0,
            'one_oesize' => 0,
            'html_oesize' => '' //content for size of OEtyre
        );
        $ajax_array['data_array'] = $_POST;
        $ajax_array['debug']="find/ajax-vehicle";

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
                $recommendation_params['last_veh_cat_term'] = $term->slug;
                $_SESSION['last_selected_vehicle'] = $term->term_id;

                //prepare for session:store model to session
                $last_vehicle_term = $term->slug;


                //OEtyre
                if(isset($_POST['tyre_oeset']) && !empty($_POST['tyre_oeset'])){
                    list($oeveh, $oesize) = explode('_',$_POST['tyre_oeset']);
                    $_POST['oe_size'] = $oesize;
                }
                //retrieve OEtypre size filters
                list($ajax_array, $recommendation_params, $_POST) = oetyre_filtering($ajax_array, $recommendation_params);

                if(empty($_POST['oe_size']) && $ajax_array['show_oesize']==0){$_POST['oe_size'] = '-1';}

                if(isset($_POST['oe_size']) && !empty($_POST['oe_size'])){
                    //show filtering results
                    $recommendation_params['selected_oe_size'] = $_POST['oe_size'];
                    if($recommendation_params['selected_oe_size'] > 0){
                        //prepare for session
                        $ss_oetyre_combi = $recommendation_params['last_veh_cat_id'].'_'.$recommendation_params['selected_oe_size'];
                    }

                    $ajax_array['html'] .= hatt()->load_template( 'tyres/find/ajax', 'recommendation', $recommendation_params);

                    //prepare label session for single tyre page
                    reset($param_order);
                    foreach ($param_order as $key => $value) {
                        //get name of selected ID
                        $cat_term = get_term_by('id', $vehicle_categories[$key], 'vehicles_cat' );
                        $ss_vehicle_label[] = $cat_term->name;
                    }
                }


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
    elseif($tyreact == 'loadvehicle_vehsize'){

        $vehicle_categories = $_POST['veh_cat'];
        $selected_category = $_POST['cat_no'];
        if(isset($_POST['filteroe']) && $_POST['filteroe']==1){
            end($vehicle_categories);
            $selected_category = key($vehicle_categories);
        }

        //get name of selected ID
        $term = get_term_by('id', $vehicle_categories[$selected_category], 'vehicles_cat' );

        //recommendation params
        $recommendation_params = array();
        $recommendation_params['include_side_cat'] = 0;
        $recommendation_params['last_veh_cat_id'] = $term->term_id;
        $recommendation_params['last_veh_cat_term'] = $term->slug;

        //prepare for session
        $last_vehicle_term = $term->slug;

        if(isset($_POST['oe_size']) && !empty($_POST['oe_size'])){
            $recommendation_params['selected_oe_size'] = $_POST['oe_size'];

            $ss_oetyre_combi = $recommendation_params['last_veh_cat_id'].'_'.$recommendation_params['selected_oe_size'];

            //prepare label session for single tyre page
            foreach ($param_order as $key => $value) {
                //get name of selected ID
                $cat_term = get_term_by('id', $vehicle_categories[$key], 'vehicles_cat' );
                $ss_vehicle_label[] = $cat_term->name;
            }
        }

        $ajax_array['side_html'] = hatt()->load_template('tyres/find/ajax', 'category');
        $ajax_array['html'] = hatt()->load_template( 'tyres/find/ajax', 'recommendation', $recommendation_params);

    }


//set cookie
$cookie_expiry = strtotime('+1 days');
$cookie_path = "/";
$cookie_domain = $_SERVER['HTTP_HOST'];

setcookie("findtyre", 'vehicle', ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftveh[totalcat]",$total_cat_type, ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
for($i=0; $i<$total_cat_type; $i++){
    $v = (isset($_POST['veh_cat'][$i]))? $_POST['veh_cat'][$i] : '';
    setcookie("ftveh[vehcat][".$i."]",$v, ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
}
setcookie("ftcate",$_POST['tyre_cate'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftrof",$_POST['tyre_rof'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftoeset",$ss_oetyre_combi, ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);


//remove session
unset($_SESSION['ht_size_width']);
unset($_SESSION['ht_size_ratio']);
unset($_SESSION['ht_size_diameter']);
unset($_SESSION['ht_size_opt_speed']);
unset($_SESSION['ht_size_opt_load']);
unset($_SESSION['vehicle_term']);
unset($_SESSION['oecombi_set']);
unset($_SESSION['oecombi_label']);
//set session
if(!empty($last_vehicle_term)){
    $_SESSION['vehicle_term'] = $last_vehicle_term;
}
if(!empty($ss_oetyre_combi)){
    $_SESSION['oecombi_set'] = $ss_oetyre_combi;
}
if(!empty($ss_vehicle_label) && is_array($ss_vehicle_label)){
    $_SESSION['oecombi_label'] = serialize($ss_vehicle_label);
}

header( "Content-Type: application/json" );
echo json_encode($ajax_array);
exit;
?>