<?php

    /**
     * Created by PhpStorm.
     * User: me664
     * Date: 1/18/15
     * Time: 11:38 PM
     */
    class BTCareer
    {

        static function  init()
        {
            $labels = array(
                'name'               => __('Careers', HATT_TEXTDOMAIN),
                'singular_name'      => __('Careers', HATT_TEXTDOMAIN),
                'menu_name'          => __('Careers', HATT_TEXTDOMAIN),
                'name_admin_bar'     => __('Careers', HATT_TEXTDOMAIN),
                'add_new'            => __('Add New', HATT_TEXTDOMAIN),
                'add_new_item'       => __('Add New Career', HATT_TEXTDOMAIN),
                'new_item'           => __('New Career', HATT_TEXTDOMAIN),
                'edit_item'          => __('Edit Career', HATT_TEXTDOMAIN),
                'view_item'          => __('View Career', HATT_TEXTDOMAIN),
                'all_items'          => __('All Careers', HATT_TEXTDOMAIN),
                'search_items'       => __('Search Careers', HATT_TEXTDOMAIN),
                'parent_item_colon'  => __('Parent Careers:', HATT_TEXTDOMAIN),
                'not_found'          => __('No Careers found.', HATT_TEXTDOMAIN),
                'not_found_in_trash' => __('No Careers found in Trash.', HATT_TEXTDOMAIN)
            );

            $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'query_var'          => true,
                'rewrite'            => array('slug' => 'career'),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_icon'          => 'dashicons-id-alt',
                'menu_position'      => null,
                'supports'           => array('title', 'author', 'thumbnail', 'excerpt')
            );
            hattPosttype::register('career', $args);

            $labels = array(
                'name'              => _x('Career Categories', 'taxonomy general name', HATT_TEXTDOMAIN),
                'singular_name'     => _x('Career Category', 'taxonomy singular name', HATT_TEXTDOMAIN),
                'search_items'      => __('Search Career Categories', HATT_TEXTDOMAIN),
                'all_items'         => __('All Career Categories', HATT_TEXTDOMAIN),
                'parent_item'       => __('Parent Career Category', HATT_TEXTDOMAIN),
                'parent_item_colon' => __('Parent Career Category:', HATT_TEXTDOMAIN),
                'edit_item'         => __('Edit Career Category', HATT_TEXTDOMAIN),
                'update_item'       => __('Update Career Category', HATT_TEXTDOMAIN),
                'add_new_item'      => __('Add New Career Category', HATT_TEXTDOMAIN),
                'new_item_name'     => __('New Career Category Name', HATT_TEXTDOMAIN),
                'menu_name'         => __('Career Category', HATT_TEXTDOMAIN),
            );

            $args = array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'career_cat'),
            );

            hattTaxonomy::register('career_cat', array('career'), $args);

            add_action('init', array(__CLASS__, 'add_metabox'));
        }

        static function add_metabox()
        {
            $meta_box[] = array(
                'id'         => 'career_options',
                'title'      => __('Career Infomation', HATT_TEXTDOMAIN),
                'pages'      => array('career'),
                'context'    => 'normal',
                'priority'   => 'high',
                'show_names' => 'true',
                'fields'     => array(
                    array(
                        'id'    => 'job_info_tab',
                        'label' => __('Job Accountabilities', HATT_TEXTDOMAIN),
                        'type'  => 'tab'
                    ), array(
                        'id'    => 'job_department',
                        'label' => __('Job Department', HATT_TEXTDOMAIN),
                        'type'  => 'text'
                    ),
                    array(
                        'id'    => 'job_location',
                        'label' => __('Job Localtion', HATT_TEXTDOMAIN),
                        'type'  => 'text'
                    ), array(
                        'id'    => 'job_type',
                        'label' => __('Type of job', HATT_TEXTDOMAIN),
                        'type'  => 'text'
                    ), array(
                        'id'    => 'job_education',
                        'label' => __('Education', HATT_TEXTDOMAIN),
                        'type'  => 'text'
                    ),
                    array(
                        'id'    => 'job_experience',
                        'label' => __('Experience', HATT_TEXTDOMAIN),
                        'type'  => 'textarea'
                    ),
                    array(
                        'id'    => 'job_how_to_apply_mail',
                        'label' => __('Mail button apply', HATT_TEXTDOMAIN),
                        'type'  => 'text'
                    ),
                    array(
                        'id'    => 'job_content_tab',
                        'label' => __('Job Content', HATT_TEXTDOMAIN),
                        'type'  => 'tab'
                    ),
                    array(
                        'id'    => 'job_accountabilities',
                        'label' => __('Job Responsibilities', HATT_TEXTDOMAIN),
                        'type'  => 'textarea'
                    ),
                    array(
                        'id'    => 'job_requirement',
                        'label' => __('Job Requirement', HATT_TEXTDOMAIN),
                        'type'  => 'textarea'
                    ),

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

    BTCareer::init();