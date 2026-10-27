<?php

    /**
     * Created by PhpStorm.
     * User: me664
     * Date: 1/18/15
     * Time: 11:38 PM
     */
    class HTLayout
    {
        static function  init()
        {
            $labels = array(
                'name'               => __('Layouts', HATT_TEXTDOMAIN),
                'singular_name'      => __('Layout', HATT_TEXTDOMAIN),
                'menu_name'          => __('Layouts', HATT_TEXTDOMAIN),
                'name_admin_bar'     => __('Layout', HATT_TEXTDOMAIN),
                'add_new'            => __('Add New', HATT_TEXTDOMAIN),
                'add_new_item'       => __('Add New Layout', HATT_TEXTDOMAIN),
                'new_item'           => __('New Layout', HATT_TEXTDOMAIN),
                'edit_item'          => __('Edit Layout', HATT_TEXTDOMAIN),
                'view_item'          => __('View Layout', HATT_TEXTDOMAIN),
                'all_items'          => __('All Layouts', HATT_TEXTDOMAIN),
                'search_items'       => __('Search Layouts', HATT_TEXTDOMAIN),
                'parent_item_colon'  => __('Parent Layouts:', HATT_TEXTDOMAIN),
                'not_found'          => __('No Layouts found.', HATT_TEXTDOMAIN),
                'not_found_in_trash' => __('No Layouts found in Trash.', HATT_TEXTDOMAIN)
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'ht_layout'),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_icon'          => 'dashicons-schedule',
                'menu_position'      => null,
                'supports'           => array('title', 'editor')
            );
            hattPosttype::register('ht_layout', $args);
        }

    }

    HTLayout::init();