<?php

/**
 * Created by PhpStorm.
 * User: MrHa-jpt
 * Date: 3/2/2015
 * Time: 2:21 PM
 */
class HattVehicle
{

    static function  init()
    {


        $labels = array(
            'name' => _x('Vehicle', 'taxonomy general name', HATT_TEXTDOMAIN),
            'singular_name' => _x('Vehicle', 'taxonomy singular name', HATT_TEXTDOMAIN),
            'search_items' => __('Search Vehicle', HATT_TEXTDOMAIN),
            'all_items' => __('All Vehicle', HATT_TEXTDOMAIN),
            'parent_item' => __('Parent Vehicle', HATT_TEXTDOMAIN),
            'parent_item_colon' => __('Parent Vehicle:', HATT_TEXTDOMAIN),
            'edit_item' => __('Edit Vehicle', HATT_TEXTDOMAIN),
            'update_item' => __('Update Vehicle', HATT_TEXTDOMAIN),
            'add_new_item' => __('Add New Vehicle', HATT_TEXTDOMAIN),
            'new_item_name' => __('New Vehicle Name', HATT_TEXTDOMAIN),
            'menu_name' => __('Vehicle', HATT_TEXTDOMAIN),
        );
        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'vehicles_cat'),
            'meta_box_cb'   => false,
        );

        hattTaxonomy::register('vehicles_cat', array('tyres'), $args);

//        $labels = array(
//            'name' => _x('Vehicle Engine', 'taxonomy general name', HATT_TEXTDOMAIN),
//            'singular_name' => _x('Vehicle Engine', 'taxonomy singular name', HATT_TEXTDOMAIN),
//            'search_items' => __('Search Vehicle Engine', HATT_TEXTDOMAIN),
//            'all_items' => __('All Vehicle Engine', HATT_TEXTDOMAIN),
//            'edit_item' => __('Edit Vehicle Engine', HATT_TEXTDOMAIN),
//            'update_item' => __('Update Vehicle Engine', HATT_TEXTDOMAIN),
//            'add_new_item' => __('Add New Vehicle Engine', HATT_TEXTDOMAIN),
//            'new_item_name' => __('New Vehicle Engine Name', HATT_TEXTDOMAIN),
//            'menu_name' => __('Vehicle Engine', HATT_TEXTDOMAIN),
//        );
//        $args = array(
//            'hierarchical' => false,
//            'labels' => $labels,
//            'show_ui' => true,
//            'show_admin_column' => true,
//            'query_var' => true,
//            'rewrite' => array('slug' => 'vehicles_engine'),
//        );
//        hattTaxonomy::register('vehicles_engine', array('tyres'), $args);

//        $labels = array(
//            'name' => _x('Vehicle Year', 'taxonomy general name', HATT_TEXTDOMAIN),
//            'singular_name' => _x('Vehicle Year', 'taxonomy singular name', HATT_TEXTDOMAIN),
//            'search_items' => __('Search Vehicle Year', HATT_TEXTDOMAIN),
//            'all_items' => __('All Vehicle Year', HATT_TEXTDOMAIN),
//            'edit_item' => __('Edit Vehicle Year', HATT_TEXTDOMAIN),
//            'update_item' => __('Update Vehicle Year', HATT_TEXTDOMAIN),
//            'add_new_item' => __('Add New Vehicle Year', HATT_TEXTDOMAIN),
//            'new_item_name' => __('New Vehicle Year Name', HATT_TEXTDOMAIN),
//            'menu_name' => __('Vehicle Year', HATT_TEXTDOMAIN),
//        );
//        $args = array(
//            'hierarchical' => false,
//            'labels' => $labels,
//            'show_ui' => true,
//            'show_admin_column' => true,
//            'query_var' => true,
//            'rewrite' => array('slug' => 'vehicles_year'),
//        );
//        hattTaxonomy::register('vehicles_year', array('tyres'), $args);
    }
}

HattVehicle::init();