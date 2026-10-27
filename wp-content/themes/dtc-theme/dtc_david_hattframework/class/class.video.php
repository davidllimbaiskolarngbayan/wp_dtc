<?php

    /**
     * Created by PhpStorm.
     * User: me664
     * Date: 1/18/15
     * Time: 11:38 PM
     */
    class HTVideo
    {

        static function  init()
        {
            $labels = array(
                'name'               => __('Video', HATT_TEXTDOMAIN),
                'singular_name'      => __('Video', HATT_TEXTDOMAIN),
                'menu_name'          => __('Video', HATT_TEXTDOMAIN),
                'name_admin_bar'     => __('Video', HATT_TEXTDOMAIN),
                'add_new'            => __('Add New', HATT_TEXTDOMAIN),
                'add_new_item'       => __('Add New Video', HATT_TEXTDOMAIN),
                'new_item'           => __('New Video', HATT_TEXTDOMAIN),
                'edit_item'          => __('Edit Video', HATT_TEXTDOMAIN),
                'view_item'          => __('View Video', HATT_TEXTDOMAIN),
                'all_items'          => __('All Videos', HATT_TEXTDOMAIN),
                'search_items'       => __('Search Video', HATT_TEXTDOMAIN),
                'parent_item_colon'  => __('Parent Video:', HATT_TEXTDOMAIN),
                'not_found'          => __('No Videos found.', HATT_TEXTDOMAIN),
                'not_found_in_trash' => __('No Videos found in Trash.', HATT_TEXTDOMAIN)
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'video', 'slug' => 'learn/video/%video_cat%'),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_icon'          => 'dashicons-list-view',
                'menu_position'      => null,
                'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
				'taxonomies' => array( 'category', 'post_tag' )
            );
            hattPosttype::register('video', $args);

            $labels = array(
                'name'              => _x('Video Categories', 'taxonomy general name', HATT_TEXTDOMAIN),
                'singular_name'     => _x('Video Category', 'taxonomy singular name', HATT_TEXTDOMAIN),
                'search_items'      => __('Search Video Categories', HATT_TEXTDOMAIN),
                'all_items'         => __('All Video Categories', HATT_TEXTDOMAIN),
                'parent_item'       => __('Parent Video Category', HATT_TEXTDOMAIN),
                'parent_item_colon' => __('Parent Video Category:', HATT_TEXTDOMAIN),
                'edit_item'         => __('Edit Video Category', HATT_TEXTDOMAIN),
                'update_item'       => __('Update Video Category', HATT_TEXTDOMAIN),
                'add_new_item'      => __('Add New Video Category', HATT_TEXTDOMAIN),
                'new_item_name'     => __('New Video Category Name', HATT_TEXTDOMAIN),
                'menu_name'         => __('Video Category', HATT_TEXTDOMAIN),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'video_cat', 'slug' => 'learn/video'),
            );

            hattTaxonomy::register('video_cat', array('video'), $args);

            add_action('init', array(__CLASS__, 'add_metabox'));
        }

        static function add_metabox()
        {
            $meta_box[] = array(
                'id'         => 'Video_options',
                'title'      => __('VIDEO RELATED ARTICLES', HATT_TEXTDOMAIN),
                'pages'      => array('video'),
                'context'    => 'side',
                'priority'   => 'high',
                'show_names' => 'true',
                'fields'     => array(
                    array(
                        'id'    => 'video_related_article_show',
                        'label' => __('Show', HATT_TEXTDOMAIN),
                        'type'  => 'on-off',
                        'std'   => 'on'
                    )

                )
            );

            $meta_box[] = array(
                'id' => 'Banner',
                'title' => __('Banner', HATT_TEXTDOMAIN),
                'pages' => array('video'),
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

    HTVideo::init();