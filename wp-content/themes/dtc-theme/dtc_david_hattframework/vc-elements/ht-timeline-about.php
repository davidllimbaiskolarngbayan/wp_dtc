<?php

/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/4/2015
 * Time: 2:56 PM
 */
if (class_exists('WPBakeryShortCodesContainer')) {

}

class WPBakeryShortCode_ht_timeline_about_us extends WPBakeryShortCodesContainer
{
    protected function content($attrs = array(), $content = false)
    {
        $default = array(
            'ht_time_line_title',
            'ht_time_line_desc',
        );
        $data = wp_parse_args($attrs, $default);
        return hatt()->load_template('about-us/list', 'time', array('data' => $data, 'content' => $content));
    }
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_ht_timeline_about_us_item extends WPBakeryShortCode
    {
        protected function content($attrs = array(), $content = false)
        {
            $default = array(
                'ht_item_time',
                'ht_item_image',
	            'ht_item_desc'
            );
            $data = wp_parse_args($attrs, $default);
            extract($data);
	        return hatt()->load_template('about-us/item',false, array('data' => $data, 'content' => $content));
        }
    }
}
vc_map(array(
    "name" => __("TimeLine About us", HATT_TEXTDOMAIN),
    "base" => "ht_timeline_about_us",
    "as_parent" => array('only' => 'ht_timeline_about_us_item'),
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
            'param_name' => 'ht_time_line_title',
        ),
        array(
            'type' => 'textarea',
            'holder' => 'div',
            'heading' => __('Description', HATT_TEXTDOMAIN),
            'param_name' => 'ht_time_line_desc',
        ),
    )
));

vc_map(array(
    "name" => __("Timeline Item", HATT_TEXTDOMAIN),
    "base" => "ht_timeline_about_us_item",
    "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
    "as_child" => array('only' => 'ht_timeline_about_us'),
    "params" => array(
        array(
            'type' => 'textfield',
            'holder' => 'div',
            'heading' => __('Time', HATT_TEXTDOMAIN),
            'param_name' => 'ht_item_time',
        ),
        array(
            'type' => 'attach_image',
            'holder' => 'div',
            'heading' => __('Image timeline', HATT_TEXTDOMAIN),
            'param_name' => 'ht_item_image',
        ),array(
            'type' => 'textarea',
            'holder' => 'div',
            'heading' => __('Item Description', HATT_TEXTDOMAIN),
            'param_name' => 'ht_item_desc',
            'std' => 'By Vehicle',
        ),
    )));
