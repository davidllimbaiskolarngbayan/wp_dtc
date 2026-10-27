<?php

    /**
     * Created by PhpStorm.
     * User: me664
     * Date: 1/18/15
     * Time: 11:38 PM
     */
    class HTLearn
    {

        static function  init()
        {
            $labels = array(
                'name'               => __('Learn', HATT_TEXTDOMAIN),
                'singular_name'      => __('Learn', HATT_TEXTDOMAIN),
                'menu_name'          => __('Learn', HATT_TEXTDOMAIN),
                'name_admin_bar'     => __('Learn', HATT_TEXTDOMAIN),
                'add_new'            => __('Add New', HATT_TEXTDOMAIN),
                'add_new_item'       => __('Add New Learn', HATT_TEXTDOMAIN),
                'new_item'           => __('New Learn', HATT_TEXTDOMAIN),
                'edit_item'          => __('Edit Learn', HATT_TEXTDOMAIN),
                'view_item'          => __('View Learn', HATT_TEXTDOMAIN),
                'all_items'          => __('All Learns', HATT_TEXTDOMAIN),
                'search_items'       => __('Search Learn', HATT_TEXTDOMAIN),
                'parent_item_colon'  => __('Parent Learn:', HATT_TEXTDOMAIN),
                'not_found'          => __('No Learns found.', HATT_TEXTDOMAIN),
                'not_found_in_trash' => __('No Learns found in Trash.', HATT_TEXTDOMAIN)
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'learn'),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_icon'          => 'dashicons-list-view',
                'menu_position'      => null,
                'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
            );
            hattPosttype::register('learn', $args);

            $labels = array(
                'name'              => _x('Learn Categories', 'taxonomy general name', HATT_TEXTDOMAIN),
                'singular_name'     => _x('Learn Category', 'taxonomy singular name', HATT_TEXTDOMAIN),
                'search_items'      => __('Search Learn Categories', HATT_TEXTDOMAIN),
                'all_items'         => __('All Learn Categories', HATT_TEXTDOMAIN),
                'parent_item'       => __('Parent Learn Category', HATT_TEXTDOMAIN),
                'parent_item_colon' => __('Parent Learn Category:', HATT_TEXTDOMAIN),
                'edit_item'         => __('Edit Learn Category', HATT_TEXTDOMAIN),
                'update_item'       => __('Update Learn Category', HATT_TEXTDOMAIN),
                'add_new_item'      => __('Add New Learn Category', HATT_TEXTDOMAIN),
                'new_item_name'     => __('New Learn Category Name', HATT_TEXTDOMAIN),
                'menu_name'         => __('Learn Category', HATT_TEXTDOMAIN),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'learn_cat'),
            );

            hattTaxonomy::register('learn_cat', array('learn'), $args);

            add_action('init', array(__CLASS__, 'add_metabox'));
        }

        static function add_metabox()
        {
//        $meta_box[] = array(
//            'id' => 'Learn_options',
//            'title' => __('Learn Infomation', HATT_TEXTDOMAIN),
//            'pages' => array('learn'),
//            'context' => 'normal',
//            'priority' => 'high',
//            'show_names' => 'true',
//            'fields' => array(
//                array(
//                    'id' => 'job_info_tab',
//                    'label' => __('Job Accountabilities', HATT_TEXTDOMAIN),
//                    'type' => 'tab'
//                ),array(
//                    'id' => 'job_department',
//                    'label' => __('Job Department', HATT_TEXTDOMAIN),
//                    'type' => 'text'
//                ),
//                array(
//                    'id' => 'job_location',
//                    'label' => __('Job Localtion', HATT_TEXTDOMAIN),
//                    'type' => 'text'
//                ),array(
//                    'id' => 'job_type',
//                    'label' => __('Type of job', HATT_TEXTDOMAIN),
//                    'type' => 'text'
//                ),array(
//                    'id' => 'job_how_to_apply',
//                    'label' => __('How to apply', HATT_TEXTDOMAIN),
//                    'type' => 'text'
//                ),
//                array(
//                    'id' => 'job_content_tab',
//                    'label' => __('Job Content', HATT_TEXTDOMAIN),
//                    'type' => 'tab'
//                ),
//                array(
//                    'id' => 'job_accountabilities',
//                    'label' => __('Job Accountabilities', HATT_TEXTDOMAIN),
//                    'type' => 'textarea'
//                ),
//                array(
//                    'id' => 'job_requirement',
//                    'label' => __('Job Requirement', HATT_TEXTDOMAIN),
//                    'type' => 'textarea'
//                ),
//
//            )
//        );
            $meta_box[] = array(
                'id'         => 'Learn_options',
                'title'      => __('LEARN RELATED ARTICLES', HATT_TEXTDOMAIN),
                'pages'      => array('learn'),
                'context'    => 'side',
                'priority'   => 'high',
                'show_names' => 'true',
                'fields'     => array(
                    array(
                        'id'    => 'learn_realted_article_show',
                        'label' => __('Show', HATT_TEXTDOMAIN),
                        'type'  => 'on-off',
                        'std'   => 'on'
                    )

                )
            );

            $meta_box[] = array(
                'id' => 'Banner',
                'title' => __('Banner', HATT_TEXTDOMAIN),
                'pages' => array('learn'),
                'context' => 'side',
                'priority' => 'low',
                'show_names' => 'true',
                'fields' => array(
                    array(
                        'id'            =>'ht_title_banner_off',
                        'label'         =>__('Show/hide title banner',HATT_TEXTDOMAIN),
                        'type'          =>'on-off',
                        'std'=>"on"
                    ),
                    array(
                        'id'            =>'ht_page_banner_title',
                        'label'         =>__('Banner Title',HATT_TEXTDOMAIN),
                        'type'          =>'text',
                    ),
                    array(
                        'label' => __('Banner Image', HATT_TEXTDOMAIN),
                        'id' => 'ht_banner',
                        'type' => 'upload',
                    ),
                    array(
                        'id'            =>'ht_page_banner_mobile',
                        'label'         =>__('Banner Image Mobile',HATT_TEXTDOMAIN),
                        'type'          =>'upload',
                    )
                )
            );
            if (!empty($meta_box)) {
                foreach ($meta_box as $key => $value) {
                    if (function_exists('ot_register_meta_box'))
                        ot_register_meta_box($value);
                }
            }
        }
    }

    HTLearn::init();