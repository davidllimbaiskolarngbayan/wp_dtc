<?php

$tyreact = $_POST['tyreact'];
$ajax_array =array();


function ft_get_size_field2($data){
    global $wpdb;
    $query = "SELECT pm2.* FROM {$wpdb->postmeta} AS pm1
              INNER JOIN {$wpdb->postmeta} AS pm2 ON pm1.post_id = pm2.post_id
              WHERE (pm1.meta_key = 'ht_size_width' AND pm1.meta_value = ".esc_sql($data['veh_size_field_1'])." )
              AND pm2.meta_key = 'ht_size_ratio'
              GROUP BY pm2.meta_value
              ORDER BY pm2.meta_value * 1 ASC";
    $size_options = $wpdb->get_results($query);

    //prepare list options
    $list_content = '';
    foreach ($size_options as $value) {
        $list_content .= '<option value="'.$value->meta_value.'" '.$selected.'>'.$value->meta_value.'</option>';
    }
    return $list_content;
}
function ft_get_size_field3($data){
    global $wpdb;
    $query = "SELECT pm3.* FROM {$wpdb->postmeta} AS pm1
              INNER JOIN {$wpdb->postmeta} AS pm2 ON pm1.post_id = pm2.post_id
              INNER JOIN {$wpdb->postmeta} AS pm3 ON pm1.post_id = pm3.post_id
              WHERE (pm1.meta_key = 'ht_size_width' AND pm1.meta_value = ".esc_sql($data['veh_size_field_1'])." )
              AND (pm2.meta_key = 'ht_size_ratio' AND pm2.meta_value = ".esc_sql($data['veh_size_field_2'])." )
              AND pm3.meta_key = 'ht_size_diameter'
              GROUP BY pm3.meta_value
              ORDER BY pm3.meta_value * 1 ASC";
    $size_options = $wpdb->get_results($query);

    //prepare list options
    $list_content = '';
    foreach ($size_options as $value) {
        $list_content .= '<option value="'.$value->meta_value.'" '.$selected.'>'.$value->meta_value.'</option>';
    }
    return $list_content;
}
function ft_get_size_posts($data){
    global $wpdb;
    $query = "SELECT pm3.* FROM {$wpdb->postmeta} AS pm1
              INNER JOIN {$wpdb->postmeta} AS pm2 ON pm1.post_id = pm2.post_id
              INNER JOIN {$wpdb->postmeta} AS pm3 ON pm1.post_id = pm3.post_id
              WHERE (pm1.meta_key = 'ht_size_width' AND pm1.meta_value = ".esc_sql($data['veh_size_field_1'])." )
              AND (pm2.meta_key = 'ht_size_ratio' AND pm2.meta_value = ".esc_sql($data['veh_size_field_2'])." )
              AND (pm3.meta_key = 'ht_size_diameter' AND pm3.meta_value = ".esc_sql($data['veh_size_field_3'])." )

              ORDER BY pm3.meta_value * 1 ASC";
    $size_posts = $wpdb->get_results($query);
    return $size_posts;
}
function ft_get_size_field_speed($data){
    global $wpdb;
    $query = "SELECT pm4.* FROM {$wpdb->postmeta} AS pm1
              INNER JOIN {$wpdb->postmeta} AS pm2 ON pm1.post_id = pm2.post_id
              INNER JOIN {$wpdb->postmeta} AS pm3 ON pm1.post_id = pm3.post_id
              INNER JOIN {$wpdb->postmeta} AS pm4 ON pm1.post_id = pm4.post_id
              WHERE (pm1.meta_key = 'ht_size_width' AND pm1.meta_value = ".esc_sql($data['veh_size_field_1'])." )
              AND (pm2.meta_key = 'ht_size_ratio' AND pm2.meta_value = ".esc_sql($data['veh_size_field_2'])." )
              AND (pm3.meta_key = 'ht_size_diameter' AND pm3.meta_value = ".esc_sql($data['veh_size_field_3'])." )
              AND pm4.meta_key = 'ht_tyre_speed_ratio'
              GROUP BY pm4.meta_value
              ORDER BY pm4.meta_value * 1 ASC";
    $speed_options = $wpdb->get_results($query);

    //prepare list options
    $list_content = '';
    foreach ($speed_options as $value) {
        $list_content .= '<option value="'.$value->meta_value.'" '.$selected.'>'.$value->meta_value.'</option>';
    }
    return $list_content;
}
function ft_get_size_field_load($data){
    global $wpdb;
    $query = "SELECT pm4.* FROM {$wpdb->postmeta} AS pm1
              INNER JOIN {$wpdb->postmeta} AS pm2 ON pm1.post_id = pm2.post_id
              INNER JOIN {$wpdb->postmeta} AS pm3 ON pm1.post_id = pm3.post_id
              INNER JOIN {$wpdb->postmeta} AS pm4 ON pm1.post_id = pm4.post_id
              WHERE (pm1.meta_key = 'ht_size_width' AND pm1.meta_value = ".esc_sql($data['veh_size_field_1'])." )
              AND (pm2.meta_key = 'ht_size_ratio' AND pm2.meta_value = ".esc_sql($data['veh_size_field_2'])." )
              AND (pm3.meta_key = 'ht_size_diameter' AND pm3.meta_value = ".esc_sql($data['veh_size_field_3'])." )
              AND pm4.meta_key = 'ht_tyre_load_index'
              GROUP BY pm4.meta_value
              ORDER BY pm4.meta_value ASC";
    $speed_options = $wpdb->get_results($query);

    //prepare list options
    $list_content = '';
    foreach ($speed_options as $value) {
        $list_content .= '<option value="'.$value->meta_value.'" '.$selected.'>'.$value->meta_value.'</option>';
    }
    return $list_content;
}


//actions
if($tyreact == 'loadsize_field2'){
    if(empty($_POST['veh_size_field_1'])){

        $ajax_array['options'] = '';

        $ajax_array['img_left'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-1.png';
        $ajax_array['img_right'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-1.png';

    }else{

        $ajax_array['options'] = ft_get_size_field2($_POST);

        if(strlen($_POST['veh_size_field_1'])>2){
            $ajax_array['img_left'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-2.png';
            $ajax_array['img_right'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-off.png';
        }else{
            $ajax_array['img_left'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-off.png';
            $ajax_array['img_right'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-2.png';
        }
    }
}elseif($tyreact == 'loadsize_field3'){

    if(empty($_POST['veh_size_field_2'])){

        $ajax_array['options'] = '';

        if(strlen($_POST['veh_size_field_1'])>2){
            $ajax_array['img_left'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-2.png';
            $ajax_array['img_right'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-off.png';
        }else{
            $ajax_array['img_left'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-off.png';
            $ajax_array['img_right'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-2.png';
        }
    }else{

        $ajax_array['options'] = ft_get_size_field3($_POST);

        if(strlen($_POST['veh_size_field_1'])>2){
            $ajax_array['img_left'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-3.png';
        }else{
            $ajax_array['img_right'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-3.png';
        }
    }
}
elseif($tyreact == 'loadsize_result'){

    if(empty($_POST['veh_size_field_3'])){
        $ajax_array['html'] = "";

        if(strlen($_POST['veh_size_field_1'])>2){
            $ajax_array['img_left'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-3.png';
        }else{
            $ajax_array['img_right'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-3.png';
        }

       

    }else{

         unset($_SESSION['items']);

        $size_posts = ft_get_size_posts($_POST);

        $ajax_array['html'] = hatt()->load_template('tyres/rfq/ajax', 'recommendation-size', array(
            'first_number'  => $_POST['veh_size_field_1'],
            'second_number' => $_POST['veh_size_field_2'],
            'third_number'  => $_POST['veh_size_field_3'],
            'all_sizes'     => $size_posts,
            'include_side_cat' => 0
        ));

        //get optional
        $ajax_array['has_optional'] = 0;
        $size_postin = array();
        foreach ( $size_posts as $value ) {
            $size_postin[] = $value->post_id;
        }
        if(!empty($size_postin)){
            $ajax_array['has_optional'] = 1;

            //get speed ratio
            $ajax_array['option_speed'] = ft_get_size_field_speed($_POST);

            //get load index
            $ajax_array['option_load'] = ft_get_size_field_load($_POST);
        }

        //image
        if(strlen($_POST['veh_size_field_1'])>2){
            $ajax_array['img_left'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-end.png';
        }else{
            $ajax_array['img_right'] = esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-end.png';
        }
    }

}
elseif($tyreact == 'loadsize_optional'){

    unset($_SESSION['items']);
    
    if(empty($_POST['veh_size_opt_speed']) && empty($_POST['veh_size_opt_load'])){

        $size_posts = ft_get_size_posts($_POST);

        $ajax_array['html'] = hatt()->load_template('tyres/rfq/ajax', 'recommendation-size', array(
            'first_number'  => $_POST['veh_size_field_1'],
            'second_number' => $_POST['veh_size_field_2'],
            'third_number'  => $_POST['veh_size_field_3'],
            'all_sizes'     => $size_posts,
            'include_side_cat' => 0
        ));

    }else{
        $size_posts = ft_get_size_posts($_POST);

        $ajax_array['html'] = hatt()->load_template('tyres/rfq/ajax', 'recommendation-size', array(
            'first_number'  => $_POST['veh_size_field_1'],
            'second_number' => $_POST['veh_size_field_2'],
            'third_number'  => $_POST['veh_size_field_3'],
            'option_speed'  => $_POST['veh_size_opt_speed'],
            'option_load'   => $_POST['veh_size_opt_load'],
            'all_sizes'     => $size_posts,
            'include_side_cat' => 0
        ));

    }
}
elseif($tyreact == 'loadsize_preload'){
    //load content by using cookie

    //pre-define values
    $ajax_array['data_array'] = $_POST;
    $ajax_array['options_size_2'] = '';
    $ajax_array['options_size_3'] = '';
    $ajax_array['option_speed'] = '';
    $ajax_array['option_load'] = '';
    $ajax_array['has_optional'] = 0;
    $ajax_array['html'] = '';

    if(!empty($_POST['veh_size_field_1'])){
        //get options of size 2
        $ajax_array['options_size_2'] = ft_get_size_field2($_POST);

        if(!empty($_POST['veh_size_field_2'])){
            //get options of size 3
            $ajax_array['options_size_3'] = ft_get_size_field3($_POST);

            if(!empty($_POST['veh_size_field_3'])){
                //get speed ratio
                $ajax_array['option_speed'] = ft_get_size_field_speed($_POST);

                //get load index
                $ajax_array['option_load'] = ft_get_size_field_load($_POST);

                //get tyres by size 1+2+3
                $size_posts = ft_get_size_posts($_POST);
                if(sizeof($size_posts) > 0){
                    $ajax_array['has_optional'] = 1;
                }

                $ajax_array['html'] = hatt()->load_template('tyres/rfq/ajax', 'recommendation-size', array(
                    'first_number'  => $_POST['veh_size_field_1'],
                    'second_number' => $_POST['veh_size_field_2'],
                    'third_number'  => $_POST['veh_size_field_3'],
                    'option_speed'  => $_POST['veh_size_opt_speed'],
                    'option_load'   => $_POST['veh_size_opt_load'],
                    'all_sizes'     => $size_posts,
                    'include_side_cat' => 0
                ));
            }
        }
    }

    //Assign images
    if (empty($_POST['veh_size_field_1'])) {
        $ajax_array['img_left'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_left-1.png';
        $ajax_array['img_right'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_right-1.png';
    } elseif (strlen($_POST['veh_size_field_1']) > 2) {
        $ajax_array['img_right'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_right-off.png';
        if (!empty($_POST['veh_size_field_3'])) {
            $ajax_array['img_left'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_left-end.png';
        } elseif (!empty($_POST['veh_size_field_2'])) {
            $ajax_array['img_left'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_left-3.png';
        } else {
            $ajax_array['img_left'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_left-2.png';
        }
    } else {
        $ajax_array['img_left'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_left-off.png';
        if (!empty($_POST['veh_size_field_3'])) {
            $ajax_array['img_right'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_right-end.png';
        } elseif (!empty($_POST['veh_size_field_2'])) {
            $ajax_array['img_right'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_right-3.png';
        } else {
            $ajax_array['img_right'] = esc_url(get_template_directory_uri()) . '/images/tyres/size_right-2.png';
        }
    }
}


//set cookie
$cookie_expiry = strtotime('+10 days'); //time()+3600;
$cookie_path = "/";
$cookie_domain = $_SERVER['HTTP_HOST'];

setcookie("findtyre", 'size', ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftsize[size1]",$_POST['veh_size_field_1'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftsize[size2]",$_POST['veh_size_field_2'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftsize[size3]",$_POST['veh_size_field_3'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftsize[size_speed]",$_POST['veh_size_opt_speed'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftsize[size_load]",$_POST['veh_size_opt_load'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);
setcookie("ftsize[cat]",$_POST['tyrecate'], ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);


//remove session
unset($_SESSION['ht_size_width']);
unset($_SESSION['ht_size_ratio']);
unset($_SESSION['ht_size_diameter']);
unset($_SESSION['vehicle_term']);
//set session
if(!empty($_POST['veh_size_field_1']) && !empty($_POST['veh_size_field_2']) && !empty($_POST['veh_size_field_3'])){
    $_SESSION['ht_size_width'] = $_POST['veh_size_field_1'];
    $_SESSION['ht_size_ratio'] = $_POST['veh_size_field_2'];
    $_SESSION['ht_size_diameter'] = $_POST['veh_size_field_3'];

    $selected_tyre_size = $_POST['veh_size_field_1'] . '/'.$_POST['veh_size_field_2'].'/'.$_POST['veh_size_field_3'];

    if( !empty($_POST['veh_size_opt_speed']) ) $selected_tyre_size .= '/'.$_POST['veh_size_opt_speed'];
    if( !empty($_POST['ht_size_opt_load']) ) $selected_tyre_size .= '/'.$_POST['ht_size_opt_load'];

    //$_SESSION['rfq-vehicle-list'] =  $selected_tyre_size ;
    setcookie("rfq-vehicle-list", $selected_tyre_size, ['expires' => $cookie_expiry,'path' => $cookie_path, 'domain' => $cookie_domain,'httponly' => true]);
    $_SESSION['rfq-last-selected-id'] =  $selected_tyre_size ;

}


header( "Content-Type: application/json" );
echo json_encode($ajax_array);
exit;

?>
