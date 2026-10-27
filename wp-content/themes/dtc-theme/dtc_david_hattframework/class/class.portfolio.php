<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/18/15
 * Time: 11:38 PM
 */
class BTPortfolio{

    static function  init(){
//        $labels = array(
//            'name'               => __('Portfolios',HATT_TEXTDOMAIN),
//            'singular_name'      => __('Portfolio',HATT_TEXTDOMAIN),
//            'menu_name'          => __('Portfolios',HATT_TEXTDOMAIN),
//            'name_admin_bar'     => __('Portfolio',HATT_TEXTDOMAIN),
//            'add_new'            => __('Add New',HATT_TEXTDOMAIN),
//            'add_new_item'       => __( 'Add New Portfolio',HATT_TEXTDOMAIN ),
//            'new_item'           => __( 'New Portfolio', HATT_TEXTDOMAIN ),
//            'edit_item'          => __( 'Edit Portfolio', HATT_TEXTDOMAIN ),
//            'view_item'          => __( 'View Portfolio', HATT_TEXTDOMAIN ),
//            'all_items'          => __( 'All Portfolios', HATT_TEXTDOMAIN ),
//            'search_items'       => __( 'Search Portfolios', HATT_TEXTDOMAIN ),
//            'parent_item_colon'  => __( 'Parent Portfolios:', HATT_TEXTDOMAIN ),
//            'not_found'          => __( 'No Portfolios found.', HATT_TEXTDOMAIN ),
//            'not_found_in_trash' => __( 'No Portfolios found in Trash.', HATT_TEXTDOMAIN )
//        );
//
//        $args = array(
//            'labels'             => $labels,
//            'public'             => true,
//            'publicly_queryable' => true,
//            'show_ui'            => true,
//            'show_in_menu'       => true,
//            'query_var'          => true,
//            'rewrite'            => array( 'slug' => 'portfolio' ),
//            'capability_type'    => 'post',
//            'has_archive'        => true,
//            'hierarchical'       => false,
//            'menu_position'      => null,
//            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
//        );
//        hattPosttype::register('portfolio',$args);
//
//        $labels = array(
//            'name' => _x('Portfolio Categories', 'taxonomy general name',HATT_TEXTDOMAIN),
//            'singular_name' => _x('Portfolio Category', 'taxonomy singular name',HATT_TEXTDOMAIN),
//            'search_items' => __('Search Portfolio Categories',HATT_TEXTDOMAIN),
//            'all_items' => __('All Portfolio Categories',HATT_TEXTDOMAIN),
//            'parent_item' => __('Parent Portfolio Category',HATT_TEXTDOMAIN),
//            'parent_item_colon' => __('Parent Portfolio Category:',HATT_TEXTDOMAIN),
//            'edit_item' => __('Edit Portfolio Category',HATT_TEXTDOMAIN),
//            'update_item' => __('Update Portfolio Category',HATT_TEXTDOMAIN),
//            'add_new_item' => __('Add New Portfolio Category',HATT_TEXTDOMAIN),
//            'new_item_name' => __('New Portfolio Category Name',HATT_TEXTDOMAIN),
//            'menu_name' => __('Portfolio Category',HATT_TEXTDOMAIN),
//        );
//
//        $args = array(
//            'hierarchical' => true,
//            'labels' => $labels,
//            'show_ui' => true,
//            'show_admin_column' => true,
//            'query_var' => true,
//            'rewrite' => array('slug' => 'portfolio_cat'),
//        );
//
//        hattTaxonomy::register('portfolio_cat', array('portfolio'), $args);
//
//        add_action('init',array(__CLASS__,'add_metabox'));
    }

    static function add_metabox()
    {
//        $meta_box[]=array(
//            'id'=>'portfolio_options',
//            'title'=>__('Portfolio Infomation',HATT_TEXTDOMAIN),
//            'pages'=>array('portfolio'),
//            'context'=>'normal',
//            'priority'=>'high',
//            'show_names'=>'true',
//            'fields'        =>array(
//                array(
//                    'id'            =>'post_format',
//                    'label'         =>__('Porfolio Type',HATT_TEXTDOMAIN),
//                    'desc'          =>__('Porfolio Type',HATT_TEXTDOMAIN),
//                    'type'          =>'radio',
//                    'choices'       =>array(
//                        array(
//                            'value'     =>'',
//                            'label'     =>__('Standard',HATT_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'audio',
//                            'label'     =>__('Audio',HATT_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'video',
//                            'label'     =>__('Video',HATT_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'image',
//                            'label'     =>__('Image',HATT_TEXTDOMAIN)
//                        ),
//                        array(
//                            'value'     =>'gallery',
//                            'label'     =>__('Gallery',HATT_TEXTDOMAIN)
//                        ),
//                    ),
//                    'std'           =>''
//                ),
//                array(
//                    'id'            =>'media_url',
//                    'label'         =>__('Media URL',HATT_TEXTDOMAIN),
//                    'desc'          =>__('Use youtube or vimeo URL',HATT_TEXTDOMAIN),
//                    'type'          =>'text',
//                    'condition'     =>'post_format:is(audio),post_format:is(video)',
//                    'operator'      =>'or'
//                ),
//                array(
//                    'id'            =>'gallery',
//                    'label'         =>__('Gallery',HATT_TEXTDOMAIN),
//                    'desc'          =>__('Multiselect images',HATT_TEXTDOMAIN),
//                    'type'          =>'gallery',
//                    'condition'     =>'post_format:is(gallery)',
//                    'operator'      =>'or'
//                ),
//                array(
//                    'id'            =>'demo_link',
//                    'label'         =>__('Live Demo URL',HATT_TEXTDOMAIN),
//                    'desc'          =>__('Example: http://domain.com/new-demo',HATT_TEXTDOMAIN),
//                    'type'          =>'text'
//                )
//            )
//        );
//        if(!empty($meta_box)){
//            foreach($meta_box as $key=>$value){
//                if ( function_exists( 'ot_register_meta_box' ) )
//                    ot_register_meta_box( $value );
//            }
//        }
    }
}
BTPortfolio::init();