<?php
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_ht_dtc_store extends WPBakeryShortCodesContainer
    {
        protected function content($attrs = array(), $content = false)
        {
            $default = array(
                'ht_title',
                'ht_sub_title',
                'autocate_category',
            );
            $data = wp_parse_args($attrs, $default);
            return hatt()->load_template('dtc/store-selection', 'element', array( 'data' => $data, 'content' => $content));
        }
    }

}


vc_map(
    array(
        "name" => __("DTC Stores", HATT_TEXTDOMAIN),
        "base" => "ht_dtc_store",
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
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'heading' => __('Autocare Category Name', HATT_TEXTDOMAIN),
                'param_name' => 'autocate_category',
            ),
        )
    )
);
