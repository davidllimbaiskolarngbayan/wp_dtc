<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 3/31/2015
 * Time: 2:55 PM
 */
class Ht_dtc_featured_vehicle extends  HTBaseShortcode{
    function __construct()
    {
        parent::__construct();
    }
    function content($attrs = array(), $content = false)
    {
        $default = array(

            'ht_img'=>'#',
            'ht_title'=>'',
            'ht_description'=>'#',
            );
        $data  = wp_parse_args($attrs,$default);
        return hatt()->load_template('dtc/featured-vehicle',false,array('data'=>$data,'content'=>$content));
    }
}
new Ht_dtc_featured_vehicle();

vc_map( array(
    "name" => __("DTC Featured Vehicle", HATT_TEXTDOMAIN),
    "base" => "ht_dtc_featured_vehicle",
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
            'type'=>'textarea',
            'holder'=>'div',
            'heading'=>__('Description',HATT_TEXTDOMAIN),
            'param_name'=>'ht_description',
        )

    )
) );