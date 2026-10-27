<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 3/31/2015
 * Time: 2:55 PM
 */
class Ht_learn extends  HTBaseShortcode{
    function __construct()
    {
        parent::__construct();
    }
    function content($attrs = array(), $content = false)
    {
        $default = array(
            'ht_learn_category'=>'',
            'post_per_page'=>'',
            'post_per_row'=>'',
            'category'=>'',
            'order'=>'',
            'orderby'=>'',
            );
        $data  = wp_parse_args($attrs,$default);
        return hatt()->load_template('learn/loop',false,array('data'=>$data,'content'=>$content));
    }
}
new Ht_learn();

vc_map( array(
    "name" => __("Learn", HATT_TEXTDOMAIN),
    "base" => "ht_learn",
    "content_element" => true,
    "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
    "category"=>"HTFramework",
    "params" => array(
        array(
            'type'=>'checkbox',
            'holder'=>'div',
            'heading'=>__('Select Category',HATT_TEXTDOMAIN),
            'param_name'=>'category',
            'value'=>btp_get_list_taxonomy('learn_cat'),
        ),
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
            "heading"          => __("Post per row", HATT_TEXTDOMAIN),
            "param_name"       => "post_per_row",
            "value"            => '3',
            "description"      => __("Post per row", HATT_TEXTDOMAIN),
            'edit_field_class' => 'vc_col-sm-6'
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