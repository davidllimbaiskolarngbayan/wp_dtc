<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 3/31/2015
 * Time: 2:55 PM
 */
if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Ht_masthead_clickable extends WPBakeryShortCode
    {
        function content($attrs = array(), $content = false)
        {
            $default = array(
                'ht_title' => '',
                'ht_css' => '',
                'ht_sub_title' => '',
                'ht_category' => '',
                'ht_img' => '#',
                'ht_img_mobile' => '#',
                'ht_mobile' => '',
                'ht_srcolldown' => '',
                'ht_srcolldown_id' => '',
                'ht_align' => 'left'
            );
            $data = wp_parse_args($attrs, $default);
            $ht_css = '';
            extract($data);
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $ht_css, ' ' ), $this->settings['base'], $data );
            return hatt()->load_template('element/masthead_clickable', false, array('data' => $data, 'content' => $content,'css_class'=>$css_class));
        }
    }
}
    vc_map(array(
        "name" => __("Masthead Clickable", HATT_TEXTDOMAIN),
        "base" => "ht_masthead_clickable",
        "content_element" => true,
        "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
        "category" => "HTFramework",
        "params" => array(
            array(
                "type" => "textfield",
                'hodler' => 'div',
                'heading' => __('CSS class', HATT_TEXTDOMAIN),
                'param_name' => 'ht_masthead_css_class',
            ),
            array(
                'type' => 'checkbox',
                'holder' => 'div',
                'heading' => __('Show content on mobile', HATT_TEXTDOMAIN),
                'param_name' => 'ht_mobile',
                'value' => array(__('Show', HATT_TEXTDOMAIN) => 'show'),
            ),
            array(
                'type' => 'attach_image',
                'holder' => 'div',
                'heading' => __('Image background', HATT_TEXTDOMAIN),
                'param_name' => 'ht_img'
            ), array(
                'type' => 'attach_image',
                'holder' => 'div',
                'heading' => __('Image background mobile', HATT_TEXTDOMAIN),
                'param_name' => 'ht_img_mobile'
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'heading' => __('Banner Link', HATT_TEXTDOMAIN),
                'param_name' => 'ht_banner_link',
            ),
            array(
                'type' => 'dropdown',
                'holder' => 'div',
                'heading' => __('Banner Link Target', HATT_TEXTDOMAIN),
                'param_name' => 'ht_banner_target',
                'value' => array(
                    __('Active window', HATT_TEXTDOMAIN) => '',
                    __('New window', HATT_TEXTDOMAIN) => '_blank'
                ),
            ),
            array(
                'type' => 'textarea',
                'holder' => 'div',
                'heading' => __('Title', HATT_TEXTDOMAIN),
                'param_name' => 'ht_title',
            ),
            array(
                'type' => 'textarea',
                'holder' => 'div',
                'heading' => __('Sub Title', HATT_TEXTDOMAIN),
                'param_name' => 'ht_sub_title',
            ),
            array(
                'type' => 'vc_link',
                'holder' => 'div',
                'heading' => __('Category name', HATT_TEXTDOMAIN),
                'param_name' => 'ht_category',
            ),
            array(
                'type' => 'dropdown',
                'holder' => 'div',
                'heading' => __('Align content', HATT_TEXTDOMAIN),
                'param_name' => 'ht_align',
                'value' => array(
                    __('Left', HATT_TEXTDOMAIN) => 'left',
                    __('Right', HATT_TEXTDOMAIN) => 'right'
                ),
            ),

            array(
                'type' => 'checkbox',
                'holder' => 'div',
                'heading' => __('Add Scroll to', HATT_TEXTDOMAIN),
                'param_name' => 'ht_srcolldown',
                'value' => array(__('Show', HATT_TEXTDOMAIN) => 'show'),
            ),
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'heading' => __('Id row want srcoll to', HATT_TEXTDOMAIN),
                'param_name' => 'ht_srcolldown_id',
                'dependency' => array('element' => 'ht_srcolldown', 'value' => array('show')),
                "description" => __("This id row your want scroll to .", HATT_TEXTDOMAIN)

            ),
            array(
                'type' => 'textarea_html',
                'holder' => 'div',
                'heading' => __('Button Shortcode', HATT_TEXTDOMAIN),
                'param_name' => 'content',
                "description" => __("Enter your Button.", HATT_TEXTDOMAIN)
            ),
            array(
                'type' => 'css_editor',
                'holder' => 'div',
                'heading' => __('CSS', HATT_TEXTDOMAIN),
                'param_name' => 'ht_css',
                'group' => __('Design options', HATT_TEXTDOMAIN),
            ),

        )
    ));
