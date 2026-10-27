<?php
/**
 * Created by PhpStorm.
 * User: MrHa-jpt
 * Date: 3/2/2015
 * Time: 2:21 PM
 */
class HattSize {

	static function  init(){
        $labels = array(
            'name'               => __('Size',HATT_TEXTDOMAIN),
            'singular_name'      => __('Size',HATT_TEXTDOMAIN),
            'menu_name'          => __('Size',HATT_TEXTDOMAIN),
            'name_admin_bar'     => __('Size',HATT_TEXTDOMAIN),
            'add_new'            => __('Add New',HATT_TEXTDOMAIN),
            'add_new_item'       => __( 'Add New Size',HATT_TEXTDOMAIN ),
            'new_item'           => __( 'New Size', HATT_TEXTDOMAIN ),
            'edit_item'          => __( 'Edit Size', HATT_TEXTDOMAIN ),
            'view_item'          => __( 'View Size', HATT_TEXTDOMAIN ),
            'all_items'          => __( 'All Size', HATT_TEXTDOMAIN ),
            'search_items'       => __( 'Search Size', HATT_TEXTDOMAIN ),
            'parent_item_colon'  => __( 'Parent Size:', HATT_TEXTDOMAIN ),
            'not_found'          => __( 'No Size found.', HATT_TEXTDOMAIN ),
            'not_found_in_trash' => __( 'No Size found in Trash.', HATT_TEXTDOMAIN )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'size' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_icon'          =>'dashicons-admin-generic',
            'menu_position'      => 20,
            'supports'           => array( 'title' )
        );
        hattPosttype::register('size',$args);


        add_action('init',array(__CLASS__,'add_metabox'));
	}

	static function add_metabox()
	{
        $meta_box[]=array(
            'id'=>'size_options',
            'title'=>__('Size Information',HATT_TEXTDOMAIN),
            'pages'=>array('size'),
            'context'=>'normal',
            'priority'=>'high',
            'show_names'=>'true',
            'fields'        =>array(
	            array(
		            'label'       => __( 'Information', HATT_TEXTDOMAIN ),
		            'id'          => 'ht_size_tab',
		            'type'        => 'tab'
	            ),
	            array(
		            'label'       => __( 'Width', HATT_TEXTDOMAIN ),
		            'id'          => 'ht_size_width',
		            'type'        => 'text'
	            ),
	            array(
		            'label'       => __( 'Aspect Ratio', HATT_TEXTDOMAIN ),
		            'id'          => 'ht_size_ratio',
		            'type'        => 'text'
	            ),
                array(
                    'label'       => __( 'Rim Diameter', HATT_TEXTDOMAIN ),
                        'id'          => 'ht_size_diameter',
                    'type'        => 'text'
                ),
                array(
                    'label'       => __( 'Speed Ratio', HATT_TEXTDOMAIN ),
                        'id'          => 'ht_tyre_speed_ratio',
                    'type'        => 'text'
                ),
                array(
                    'label'       => __( 'Load Index', HATT_TEXTDOMAIN ),
                        'id'          => 'ht_tyre_load_index',
                    'type'        => 'text'
                ),
                array(
                    'label'       => __( 'Sidewall', HATT_TEXTDOMAIN ),
                        'id'          => 'ht_tyre_sidewall',
                    'type'        => 'text'
                ),
	            array(
		            'label'       => __( 'Tyre Code', HATT_TEXTDOMAIN ),
			            'id'          => 'ht_tyre_code',
		            'type'        => 'text'
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
}
HattSize::init();