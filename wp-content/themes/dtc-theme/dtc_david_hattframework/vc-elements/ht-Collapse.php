<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/17/2015
	 * Time: 1:48 PM
	 */
	if(!class_exists('Ht_collapse')){
		class Ht_collapse extends  HTBaseShortcode{
			function __construct()
			{
				parent::__construct();
			}
			function content($attrs = array(), $content = false)
			{
				$default = array(
					'ht_collapse_title'=>'',
                    'ht_collapse_open'=>''
				);
				$data  = wp_parse_args($attrs,$default);
				extract($data);
				return hatt()->load_template('element/collapse',false,array('title'=>$ht_collapse_title,'open'=>$ht_collapse_open,'content'=>$content));
			}
		}
		new Ht_collapse();

		vc_map( array(
			"name" => __("Collapse", HATT_TEXTDOMAIN),
			"base" => "ht_collapse",
			"content_element" => true,
			"icon" => get_template_directory_uri() . "/images/logo_hatt.PNG",
			"category"=>"HTFramework",
			"params" => array(
                array(
                    'type'=>'dropdown',
                    'holder'=>'div',
                    'heading'=>__('Open/Close',HATT_TEXTDOMAIN),
                    'param_name'=>'ht_collapse_open',
                    'value' => array(__('Open', HATT_TEXTDOMAIN) => 'yes', __('Close', HATT_TEXTDOMAIN) => 'no'),
                    'std' => 'no',
                ),
				array(
					'type'=>'textfield',
					'holder'=>'div',
					'heading'=>__('Title',HATT_TEXTDOMAIN),
					'param_name'=>'ht_collapse_title',
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