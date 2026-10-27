<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 3/31/2015
 * Time: 2:55 PM
 */
class Ht_banner_feature extends  HTBaseShortcode{
    function __construct()
    {
        parent::__construct();
    }
    function content($attrs = array(), $content = false)
    {
        $default = array(

            'ht_title'=>'',
            'ht_sub_title'=>'',
            'ht_img'=>'#',
            'ht_href'=>'#',
            );
        $data  = wp_parse_args($attrs,$default);
        return hatt()->load_template('banner/feature',false,array('data'=>$data,'content'=>$content));
    }
}
new Ht_banner_feature();

vc_map( array(
    "name" => __("Banner Feature", HATT_TEXTDOMAIN),
    "base" => "ht_banner_feature",
    "content_element" => true,
    "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
    "category"=>"HTFramework",
    "params" => array(

        array(
            'type'=>'attach_image',
            'holder'=>'div',
            'heading'=>__('Image Backgroup',HATT_TEXTDOMAIN),
            'param_name'=>'ht_img'
        ),
        array(
            'type'=>'textfield',
            'holder'=>'div',
            'heading'=>__('Title',HATT_TEXTDOMAIN),
            'param_name'=>'ht_title',
        ),
        array(
            'type'=>'textfield',
            'holder'=>'div',
            'heading'=>__('Sub Title',HATT_TEXTDOMAIN),
            'param_name'=>'ht_sub_title',
        ),
        array(
            'type'=>'textfield',
            'holder'=>'div',
            'heading'=>__('Link',HATT_TEXTDOMAIN),
            'param_name'=>'ht_href',
        ),
        array(
            'type'=>'textarea_html',
            'holder'=>'div',
            'heading'=>__('Description',HATT_TEXTDOMAIN),
            'param_name'=>'content',
        ),

    )
) );