<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 3/31/2015
 * Time: 2:55 PM
 */
class Ht_faq extends  HTBaseShortcode{
    function __construct()
    {
        parent::__construct();
    }
    function content($attrs = array(), $content = false)
    {
        $default = array(
            'post_per_page'=>'',
            'order'=>'',
            'orderby'=>'',
            'custom_id'=>'',
            );
        $data  = wp_parse_args($attrs,$default);
        return hatt()->load_template('faq/loop',false,array('data'=>$data,'content'=>$content));
    }
}
new Ht_faq();

vc_map( array(
    "name" => __("FAQ", HATT_TEXTDOMAIN),
    "base" => "ht_faq",
    "content_element" => true,
    "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
    "category"=>"HTFramework",
    "params" => array(

        array(
            "type"             => "textfield",
            "holder"           => "div",
            "heading"          => __("Post per page", HATT_TEXTDOMAIN),
            "param_name"       => "post_per_page",
            "value"            => '-1',
            "description"      => __("Post per page", HATT_TEXTDOMAIN),
            'edit_field_class' => 'vc_col-sm-6'
        ),
        array(
            "type"             => "textfield",
            "holder"           => "div",
            "heading"          => __("Custom Id Post", HATT_TEXTDOMAIN),
            "param_name"       => "custom_id",
            "value"            => '',
            'edit_field_class' => 'vc_col-sm-6',
            "description"      => __("Custom Id (1,2,3)", HATT_TEXTDOMAIN)

        ),

        array(
            "type"             => "dropdown",
            "holder"           => "div",
            "heading"          => __("Order", HATT_TEXTDOMAIN),
            "param_name"       => "order",
            'value'            => array(
                __('Asc', HATT_TEXTDOMAIN)  => 'asc',
                __('Desc', HATT_TEXTDOMAIN) => 'desc'
            ),
            'edit_field_class' => 'vc_col-sm-6',
            "description"      => __("Order", HATT_TEXTDOMAIN)
        ),
        array(
            "type"             => "dropdown",
            "holder"           => "div",
            "heading"          => __("Order By", HATT_TEXTDOMAIN),
            "param_name"       => "orderby",
            "value"            => ht_vc_get_order_list(),
            'edit_field_class' => 'vc_col-sm-6',
            "description"      => __("Order By", HATT_TEXTDOMAIN)
        ),


    )
) );