<?php

/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/4/2015
 * Time: 2:56 PM
 */
class Ht_tyre_filter extends HTBaseShortcode
{
    function __construct()
    {
        parent::__construct();
    }

    function content($attrs = array(), $content = false)
    {
        $default = array(
            'ht_show_filter_features',
            'ht_show_filter_category',
//            'ht_show_filter_weather',
            'ht_filter_features',
//            'ht_filter_weather',
            'ht_filter_position',
            'ht_filter_category'
        );
        $data = wp_parse_args($attrs, $default);
        return hatt()->load_template('tyres/browser/browser','element',array('data' => $data, 'content' => $content));
    }
}
new Ht_tyre_filter();
vc_map(array(
    "name" => __("Browser tyre", HATT_TEXTDOMAIN),
    "base" => "ht_tyre_filter",
    "content_element" => true,
    "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
    "category" => "HTFramework",
    "params" => array(
        array(
            'type'=>'checkbox',
            'holder'=>'div',
            'heading'=>__('Show Filter category',HATT_TEXTDOMAIN),
            'param_name'=>'ht_show_filter_category',
            'value'=>array(__('Show',HATT_TEXTDOMAIN)=>'show'),
        ),array(
            'type'=>'checkbox',
            'holder'=>'div',
            'heading'=>__('Select Category',HATT_TEXTDOMAIN),
            'param_name'=>'ht_filter_category',
            'value'=>btp_get_list_taxonomy('tyres_cat'),
        ),
        array(
            'type'=>'checkbox',
            'holder'=>'div',
            'heading'=>__('Show Filter Feature on sidebar',HATT_TEXTDOMAIN),
            'param_name'=>'ht_show_filter_features',
            'value'=>array(__('Show',HATT_TEXTDOMAIN)=>'show'),
        ),
        array(
            'type'=>'checkbox',
            'holder'=>'div',
            'heading'=>__('Select Feature',HATT_TEXTDOMAIN),
            'param_name'=>'ht_filter_features',
            'value'=>btp_get_list_taxonomy('tyres_feature'),
            'dependency'=>array('element'=>'ht_show_filter_features','value'=>array('show')),
        ),

//        array(
//	        'type'=>'checkbox',
//	        'holder'=>'div',
//	        'heading'=>__('Show Filter Weather on sidebar',HATT_TEXTDOMAIN),
//	        'param_name'=>'ht_show_filter_weather',
//	        'value'=>array(__('Show',HATT_TEXTDOMAIN)=>'show'),
//        ),
//        array(
//	        'type'=>'checkbox',
//	        'holder'=>'div',
//	        'heading'=>__('Select Weather',HATT_TEXTDOMAIN),
//	        'param_name'=>'ht_filter_weather',
//	        'value'=>btp_get_list_taxonomy('tyres_weather'),
//	        'dependency'=>array('element'=>'ht_show_filter_weather','value'=>array('show')),
//        ),
        array(
            'type'=>'dropdown',
            'holder'=>'div',
            'heading'=>__('Show Filter on sidebar',HATT_TEXTDOMAIN),
            'param_name'=>'ht_filter_position',
            'value'=>array(__('Left',HATT_TEXTDOMAIN)=>'left',__('Right',HATT_TEXTDOMAIN)=>'right'),
            'std'=>'left',
            'dependency'=>array('element'=>'ht_show_filter_features','value'=>array('show')),
        ),


    )));
