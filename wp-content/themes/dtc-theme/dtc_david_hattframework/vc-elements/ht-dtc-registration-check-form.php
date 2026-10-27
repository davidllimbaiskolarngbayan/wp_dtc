<?php
if (class_exists('WPBakeryShortCodesContainer')) {

    class WPBakeryShortCode_ht_dtc_register_check_form extends WPBakeryShortCodesContainer
    {
        protected function content($attrs = array(), $content = false)
        {
            return hatt()->load_template('dtc/check-registration', 'element', array(  'content' => $content ));
        }

    }

}

vc_map(
    array(
        "name" => __("DTC Check Registration", HATT_TEXTDOMAIN),
        "base" => "ht_dtc_register_check_form",
        "content_element" => true,
        "show_settings_on_create" => false,
        "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
        "category" => "HTFramework",
        "js_view" => 'VcColumnView',
    )
);
 
