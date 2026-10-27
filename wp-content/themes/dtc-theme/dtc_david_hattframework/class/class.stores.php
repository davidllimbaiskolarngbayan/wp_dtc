<?php

/**
 * Created by PhpStorm.
 * User: x
 * Date: 3/2/2015
 * Time: 2:21 PM
 */
class HattStores
{

    static function  init()
    {
        $labels = array(
            'name' => __('Store', HATT_TEXTDOMAIN),
            'singular_name' => __('Store', HATT_TEXTDOMAIN),
            'menu_name' => __('Store', HATT_TEXTDOMAIN),
            'name_admin_bar' => __('Store', HATT_TEXTDOMAIN),
            'add_new' => __('Add New', HATT_TEXTDOMAIN),
            'add_new_item' => __('Add New Store', HATT_TEXTDOMAIN),
            'new_item' => __('New Store', HATT_TEXTDOMAIN),
            'edit_item' => __('Edit Store', HATT_TEXTDOMAIN),
            'view_item' => __('View Store', HATT_TEXTDOMAIN),
            'all_items' => __('All Stores', HATT_TEXTDOMAIN),
            'search_items' => __('Search Store', HATT_TEXTDOMAIN),
            'parent_item_colon' => __('Parent Store:', HATT_TEXTDOMAIN),
            'not_found' => __('No Store found.', HATT_TEXTDOMAIN),
            'not_found_in_trash' => __('No Stores found in Trash.', HATT_TEXTDOMAIN)
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'store'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_icon' => 'dashicons-store',
            'menu_position' => 20,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
        );
        hattPosttype::register('store', $args);

        $labels = array(
            'name' => _x('Store Categories', 'taxonomy general name', HATT_TEXTDOMAIN),
            'singular_name' => _x('Store Category', 'taxonomy singular name', HATT_TEXTDOMAIN),
            'search_items' => __('Search Store Categories', HATT_TEXTDOMAIN),
            'all_items' => __('All Store Categories', HATT_TEXTDOMAIN),
            'parent_item' => __('Parent Store Category', HATT_TEXTDOMAIN),
            'parent_item_colon' => __('Parent Store Category:', HATT_TEXTDOMAIN),
            'edit_item' => __('Edit Store Category', HATT_TEXTDOMAIN),
            'update_item' => __('Update Store Category', HATT_TEXTDOMAIN),
            'add_new_item' => __('Add New Store Category', HATT_TEXTDOMAIN),
            'new_item_name' => __('New Store Category Name', HATT_TEXTDOMAIN),
            'menu_name' => __('Store Category', HATT_TEXTDOMAIN),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'store_cat'),
        );

        hattTaxonomy::register('store_cat', array('store'), $args);
        add_action('init', array(__CLASS__, 'add_metabox'));
        self::add_category_taxmeta();


 	$labels = array(
            'name' => _x('Store Visibility', 'taxonomy general name', HATT_TEXTDOMAIN),
            'singular_name' => _x('Store Visibility', 'taxonomy singular name', HATT_TEXTDOMAIN),
            'search_items' => __('Search Store Visibility', HATT_TEXTDOMAIN),
            'all_items' => __('All Store Categories', HATT_TEXTDOMAIN),
            'parent_item' => __('Parent Store Visibility', HATT_TEXTDOMAIN),
            'parent_item_colon' => __('Parent Store Visibility:', HATT_TEXTDOMAIN),
            'edit_item' => __('Edit Store Visibility', HATT_TEXTDOMAIN),
            'update_item' => __('Update Store Visibility', HATT_TEXTDOMAIN),
            'add_new_item' => __('Add New Store Visibility', HATT_TEXTDOMAIN),
            'new_item_name' => __('New Store Visibility Name', HATT_TEXTDOMAIN),
            'menu_name' => __('Store Visibility', HATT_TEXTDOMAIN),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'store_visib'),
        );

        hattTaxonomy::register('store_visib', array('store'), $args);
        add_action('init', array(__CLASS__, 'add_metabox'));
        self::add_category_taxmeta();

    }

    static function add_metabox()
    {
        $meta_box[] = array(
            'id' => 'Store_options',
            'title' => __('Store Information', HATT_TEXTDOMAIN),
            'pages' => array('store'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => 'true',
            'fields' => array(
                array(
                    'label' => __('Information', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_tab',
                    'type' => 'tab'
                ),
                array(
                    'label' => __('Address', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_address',
                    'type' => 'text'
                ),
                array(
                    'label' => __('Area', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_area',
                    'type' => 'text'
                ),
                array(
	                'label' => __('State/Province', HATT_TEXTDOMAIN),
	                'id' => 'ht_store_state',
	                'type' => 'text'
                ),
                array(
	                'label' => __('Postal Code', HATT_TEXTDOMAIN),
	                'id' => 'ht_store_postal_code',
	                'type' => 'text'
                ),
                array(
                    'label' => __('Phone', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_phone',
                    'type' => 'text'
                ),
                array(
                    'label' => __('Email', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_email',
                    'type' => 'text'
                ),
                array(
                    'label' => __('Whatsapp Link', HATT_TEXTDOMAIN),
                    'id' => 'ht_whatsapp_link',
                    'type' => 'text'
                ),
                array(
                    'label' => __('Store Cat', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_cat',
                    'type' => 'text'
                ),
                array(
                    'label' => __('Specialty Cat', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_specialty_cat',
                    'type' => 'text'
                ),
                array(
                    'label' => __('Map', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_map',
                    'type' => 'tab'
                ),
                array(
                    'label' => __('Store Latitudes', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_map_lat',
                    'type' => 'text'
                ),
                array(
                    'label' => __('Store Longitudes', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_map_long',
                    'type' => 'text'
                ),


                array(
                    'label' => __('Store Provided services', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_services',
                    'type' => 'tab'
                ),
                array(
                    'label' => __('Store Provided services', HATT_TEXTDOMAIN),
                    'id' => 'ht_store_services',
                    'type' => 'textarea',
                    'rows' => '5',
                ),
                array(
                    'label' => __( 'UHP and ROF Available', HATT_TEXTDOMAIN ),
                    'id'    => 'ht_uhp_rof_tyre_available',
                    'type'  => 'on-off',
                    'std'   => 'off'
                ),
                array(
                    'label' => __( 'DTC 0% Outlet', HATT_TEXTDOMAIN ),
                    'id'    => 'ht_dtc_zero_percent_outlet',
                    'type'  => 'on-off',
                    'std'   => 'off'
                ),
            )
        );

        $meta_box[] = array(
            'id' => 'Banner',
            'title' => __('Banner', HATT_TEXTDOMAIN),
            'pages' => array('store'),
            'context' => 'side',
            'priority' => 'low',
            'show_names' => 'true',
            'fields' => array(
                array(
                    'id'            =>'ht_page_banner_title',
                    'label'         =>__('Banner Title',HATT_TEXTDOMAIN),
                    'type'          =>'text',
                ),
                array(
                    'label' => __('Banner title', HATT_TEXTDOMAIN),
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

    static function add_category_taxmeta(){
        if (is_admin()){
            $config = array(
                'id' => 'stores_cat_meta_box',          // meta box id, unique per meta box
                'title' => 'Stores Category Meta Box',          // meta box title
                'pages' => array('store_cat'),        // taxonomy name, accept categories, post_tag and custom taxonomies
                'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
                'fields' => array(),            // list of meta fields (can be added by field arrays)
                'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
                'use_with_theme' => get_template_directory_uri().'/dtc_david_hattframework/plugins/Tax-meta-class'          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
            ,
            );
            $my_meta =  new Tax_Meta_Class($config);
            $my_meta->addImage('store_cat_image',array('name'=> __('Category Image ',HATT_TEXTDOMAIN)));
            $my_meta->Finish();
        }
    }

}

HattStores::init();