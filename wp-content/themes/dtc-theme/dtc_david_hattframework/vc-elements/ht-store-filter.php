<?php

/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/4/2015
 * Time: 2:56 PM
 */
class Ht_stores_filter extends HTBaseShortcode
{
    function __construct()
    {
        parent::__construct();
    }

    function content($attrs = array(), $content = false)
    {
        $default = array(
            'ht_show_filter_category',
            'ht_filter_position',
            'ht_filter_category'
        );
        $data = wp_parse_args($attrs, $default);
        return hatt()->load_template('stores/filter','element',array('data' => $data, 'content' => $content));
    }
}
new Ht_stores_filter();
vc_map(array(
    "name" => __("Filter Stores", HATT_TEXTDOMAIN),
    "base" => "ht_stores_filter",
    "content_element" => true,
    "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
    "category" => "HTFramework",
    "params" => array(
        array(
            'type'=>'checkbox',
            'holder'=>'div',
            'heading'=>__('Show Filter Category on sidebar',HATT_TEXTDOMAIN),
            'param_name'=>'ht_show_filter_category',
            'value'=>array(__('Show',HATT_TEXTDOMAIN)=>'show'),
        ),
        array(
            'type'=>'checkbox',
            'holder'=>'div',
            'heading'=>__('Select Store Category',HATT_TEXTDOMAIN),
            'param_name'=>'ht_filter_category',
            'value'=>btp_get_list_taxonomy('store_cat'),
            'dependency'=>array('element'=>'ht_show_filter_category','value'=>array('show')),
        ),
        array(
            'type'=>'dropdown',
            'holder'=>'div',
            'heading'=>__('Location Filter Category on sidebar',HATT_TEXTDOMAIN),
            'param_name'=>'ht_filter_position',
            'value'=>array(__('Left',HATT_TEXTDOMAIN)=>'left',__('Right',HATT_TEXTDOMAIN)=>'right'),
            'std'=>'left',
            'dependency'=>array('element'=>'ht_show_filter_category','value'=>array('show')),
        ),
    )));