<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/17/2015
 * Time: 1:48 PM
 */
if(!class_exists('Ht_corporate')){
    class Ht_corporate extends  HTBaseShortcode{
        function __construct()
        {
            parent::__construct();
        }
        function content($attrs = array(), $content = false)
        {
            $default = array(
                'ht_corporate_title'=>'',
	            'ht_corporate_right'=>'',
	            'ht_corporate_back_to_top'=>'',
	            'ht_corporate_button'=>'#'
            );
            $data  = wp_parse_args($attrs,$default);
            return hatt()->load_template('element/corporate',false,array('data'=>$data,'content'=>$content));
        }
    }
    new Ht_corporate();

    vc_map( array(
        "name" => __("Corporate", HATT_TEXTDOMAIN),
        "base" => "ht_corporate",
        "content_element" => true,
        "icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
        "category"=>"HTFramework",
        "params" => array(
            array(
                'type'=>'textfield',
                'holder'=>'div',
                'heading'=>__('Title',HATT_TEXTDOMAIN),
                'param_name'=>'ht_corporate_title',
            ),
            array(
	            'type'=>'textarea',
	            'holder'=>'div',
	            'heading'=>__('Content Right',HATT_TEXTDOMAIN),
	            'param_name'=>'ht_corporate_right',
            ),
            array(
                'type'=>'dropdown',
                'holder'=>'div',
                'heading'=>__('Back To Top',HATT_TEXTDOMAIN),
                'param_name'=>'ht_corporate_back_top_top',
                'value' => array(__('Show', HATT_TEXTDOMAIN) => 'yes', __('Not Show', HATT_TEXTDOMAIN) => 'no'),
                'std' => 'no',
            ),
            array(
	            'type'=>'vc_link',
	            'holder'=>'div',
	            'heading'=>__('Button',HATT_TEXTDOMAIN),
	            'param_name'=>'ht_corporate_button',
            ),
            array(
                'type'=>'textarea_html',
                'holder'=>'div',
                'heading'=>__('Description',HATT_TEXTDOMAIN),
                'param_name'=>'content',
            ),

        )
    ) );

}