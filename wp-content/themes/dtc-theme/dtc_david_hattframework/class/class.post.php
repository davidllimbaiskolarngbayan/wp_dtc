<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/23/15
 * Time: 12:45 AM
 */
class BTPost
{

    static function init(){
        add_action('init',array(__CLASS__,'add_metabox'));
        add_action('init',array(__CLASS__,'add_category_taxmeta'));

    }

    static function  add_metabox()
    {
        $meta_box[]=array(
            'id'=>'post_infomation_meta',
            'title'=>__('Post Infomation',HATT_TEXTDOMAIN),
            'pages'=>array('post'),
            'context'=>'normal',
            'priority'=>'high',
            'show_names'=>'true',
            'fields'        =>array(

                array(
                    'id'            =>'social_banner_show',
                    'label'         =>__('Social Banner',HATT_TEXTDOMAIN),
                    'desc'          =>__('Show social share banner',HATT_TEXTDOMAIN),
                    'type'          =>'on-off',
                    'std'   => 'on'
                ),

            )
        );

        if(!empty($meta_box)){
            foreach($meta_box as $key=>$value){
                if ( function_exists( 'ot_register_meta_box' ) )
                    ot_register_meta_box( $value );
            }
        }


    }
    static function add_category_taxmeta(){
        if (is_admin()){
            $config = array(
                'id' => 'tyres_cat_meta_box',          // meta box id, unique per meta box
                'title' => 'Category Meta Box',          // meta box title
                'pages' => array('category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
                'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
                'fields' => array(),            // list of meta fields (can be added by field arrays)
                'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
                'use_with_theme' => get_template_directory_uri().'/dtc_david_hattframework/plugins/Tax-meta-class'          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
            ,
            );
            $my_meta =  new Tax_Meta_Class($config);
            $my_meta->addImage('cat_image',array('name'=> __('Category Image ',HATT_TEXTDOMAIN)));
            $my_meta->Finish();
        }
    }
}
BTPost::init();