<?php

/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/4/2015
 * Time: 2:56 PM
 */
if (class_exists('WPBakeryShortCodesContainer')) {

}

class WPBakeryShortCode_ht_find_tyres extends WPBakeryShortCodesContainer
{
    protected function content($attrs = array(), $content = false)
    {
        $default = array(
            'ht_title',
            'ht_sub_title',
        );
        $data = wp_parse_args($attrs, $default);
        return hatt()->load_template('tyres/find/find', 'element', array('data' => $data, 'content' => $content));
    }
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_ht_find_tyre_type extends WPBakeryShortCode
    {
        protected function content($attrs = array(), $content = false)
        {
            $default = array(
                'ht_type',
                'ht_type_name'
            );
            $data = wp_parse_args($attrs, $default);
            extract($data);
	        $active_vehicle = $active_size='';
            if(isset($_GET['type']) and !empty($_GET['type']) ){
                if($_GET['type'] ==='vehicle' or $_GET['type']==='rfq'){
                    $active_vehicle='active';
                }if($_GET['type'] ==='size'){
                    $active_size='active';
                }

            }
			$html = "";
            $html = '<div class="btn-group" role="group">';
            if ($ht_type == 'vehicle') {
                $html .= '<a  href="'.add_query_arg(array('type'=>'vehicle'),get_the_permalink()).'" class="btn btn-type '.$active_vehicle.'">'.$ht_type_name.'</a>';
            }
            if ($ht_type == 'size') {
                $html .= '<a href="'.add_query_arg(array('type'=>'size'),get_the_permalink()).'" class="btn btn-type '.$active_size.'">'.$ht_type_name.'</a>';
            }
            $html .= '</div>';
            return $html;
        }
    }
}
vc_map(array(
    "name" => __("Find Tyres", HATT_TEXTDOMAIN),
    "base" => "ht_find_tyres",
    "as_parent" => array('only' => 'ht_find_tyre_type'),
    "content_element" => true,
    "show_settings_on_create" => true,
    "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
    "category" => "HTFramework",
    "js_view" => 'VcColumnView',
    "params" => array(
        array(
            'type' => 'textfield',
            'holder' => 'div',
            'heading' => __('Title', HATT_TEXTDOMAIN),
            'param_name' => 'ht_title',
        ),
        array(
            'type' => 'textfield',
            'holder' => 'div',
            'heading' => __('Sub Title', HATT_TEXTDOMAIN),
            'param_name' => 'ht_sub_title',
        ),
    )
));

vc_map(array(
    "name" => __("Find tyres type", HATT_TEXTDOMAIN),
    "base" => "ht_find_tyre_type",
    "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
    "as_child" => array('only' => 'ht_find_tyres'),
    "params" => array(
        array(
            'type' => 'dropdown',
            'holder' => 'div',
            'heading' => __('Show Filter Feature on sidebar', HATT_TEXTDOMAIN),
            'param_name' => 'ht_type',
            'value' => array(__('By size', HATT_TEXTDOMAIN) => 'size', __('By vehicle', HATT_TEXTDOMAIN) => 'vehicle'),
            'std' => 'vehicle',
        ),
        array(
            'type' => 'textfield',
            'holder' => 'div',
            'heading' => __('Type name', HATT_TEXTDOMAIN),
            'param_name' => 'ht_type_name',
            'std' => 'By Vehicle',
        ),
    )));
