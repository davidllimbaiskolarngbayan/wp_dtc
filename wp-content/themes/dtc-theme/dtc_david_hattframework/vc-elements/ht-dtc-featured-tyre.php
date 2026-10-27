<?php
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_ht_dtc_featured_tyre extends WPBakeryShortCodesContainer
    {
        protected function content($attrs = array(), $content = false)
        {
            $default = array(
                'tyre_id'
            );
            $data = wp_parse_args($attrs, $default);
            return hatt()->load_template('dtc/featured-tyre', 'element', array( 'data' => $data, 'content' => $content));
        }
    }

}


function getAllTyres(){

    $args = [
        'post_type' => 'tyres',
        'post_status' => array('publish', 'draft'),
        'posts_per_page' => -1,
        'orderby' => ['post_title' => 'ASC']
    ];

    $tyres  = array ('-Select Tyre-' => '');
    $my_query = new WP_Query($args);

    // The Loop
    if ( $my_query->have_posts() ) {
        while ( $my_query->have_posts() ) {
            $my_query->the_post();

            $tyres[get_the_title()] = get_the_ID();
          
        }
    }
    wp_reset_postdata();

    return $tyres;

}

vc_map(
    array(
        "name" => __("DTC Featured Tyre", HATT_TEXTDOMAIN),
        "base" => "ht_dtc_featured_tyre",
        "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
        "category" => "HTFramework",
        "js_view" => 'VcColumnView',
        "params" => array(
            array(
              "type"        => "dropdown",
              "heading"     => __("Select DTC Tyre"),
              "param_name"  => "tyre_id",
              "admin_label" => true,
              "value"       => getAllTyres(),
              "std"         => '',
            )
        )
    )
);
