<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/18/15
 * Time: 11:38 PM
 */
class BTOffer{

    static function  init(){
        $labels = array(
            'name'               => __('Offers',HATT_TEXTDOMAIN),
            'singular_name'      => __('Offer',HATT_TEXTDOMAIN),
            'menu_name'          => __('Offers',HATT_TEXTDOMAIN),
            'name_admin_bar'     => __('Offer',HATT_TEXTDOMAIN),
            'add_new'            => __('Add New',HATT_TEXTDOMAIN),
            'add_new_item'       => __( 'Add New Offer',HATT_TEXTDOMAIN ),
            'new_item'           => __( 'New Offer', HATT_TEXTDOMAIN ),
            'edit_item'          => __( 'Edit Offer', HATT_TEXTDOMAIN ),
            'view_item'          => __( 'View Offer', HATT_TEXTDOMAIN ),
            'all_items'          => __( 'All Offers', HATT_TEXTDOMAIN ),
            'search_items'       => __( 'Search Offers', HATT_TEXTDOMAIN ),
            'parent_item_colon'  => __( 'Parent Offers:', HATT_TEXTDOMAIN ),
            'not_found'          => __( 'No Offers found.', HATT_TEXTDOMAIN ),
            'not_found_in_trash' => __( 'No Offers found in Trash.', HATT_TEXTDOMAIN )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'offer' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );
        hattPosttype::register('offer',$args);

        $labels = array(
            'name' => _x('Offer Categories', 'taxonomy general name',HATT_TEXTDOMAIN),
            'singular_name' => _x('Offer Category', 'taxonomy singular name',HATT_TEXTDOMAIN),
            'search_items' => __('Search Offer Categories',HATT_TEXTDOMAIN),
            'all_items' => __('All Offer Categories',HATT_TEXTDOMAIN),
            'parent_item' => __('Parent Offer Category',HATT_TEXTDOMAIN),
            'parent_item_colon' => __('Parent Offer Category:',HATT_TEXTDOMAIN),
            'edit_item' => __('Edit Offer Category',HATT_TEXTDOMAIN),
            'update_item' => __('Update Offer Category',HATT_TEXTDOMAIN),
            'add_new_item' => __('Add New Offer Category',HATT_TEXTDOMAIN),
            'new_item_name' => __('New Offer Category Name',HATT_TEXTDOMAIN),
            'menu_name' => __('Offer Category',HATT_TEXTDOMAIN),
        );

        $args = array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'offer_cat'),
        );

        hattTaxonomy::register('offer_cat', array('offer'), $args);

        add_action('init',array(__CLASS__,'add_metabox'));
    }

    static function add_metabox()
    {	
        $meta_box[] = array(
            'id' => 'Banner',
            'title' => __('Banner', HATT_TEXTDOMAIN),
            'pages'      => array( 'offer' ),
            'context' => 'side',
            'priority' => 'high',
            'show_names' => 'true',
            'fields' => array(
                array(
                    'id'            =>'ht_banner',
                    'label'         =>__('Banner Image',HATT_TEXTDOMAIN),
                    'type'          =>'upload',
                ),
                array(
                    'id'            =>'ht_page_banner_mobile',
                    'label'         =>__('Banner Image Mobile',HATT_TEXTDOMAIN),
                    'type'          =>'upload',
                )
            )
        );	
	    
	   	$meta_box[] = array(
				'id'         => 'offer_promotion',
				'title'      => __( 'PROMOTION', HATT_TEXTDOMAIN ),
				'pages'      => array( 'offer' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => 'true',
				'fields'     => array(
					array(
						'id'   => 'ht_offer_promo_banner',
						'std'  => '',
						'type' => 'upload',
					),
					array(
						'id'   => 'ht_offer_promo_info',
						'std'  => '',
						'type' => 'textarea',
					),
				)
			);
			$meta_box[] = array(
			    'id' => 'Social',
			    'title' => __('Social', HATT_TEXTDOMAIN),
			    'pages' => array('offer'),
			    'context' => 'side',
			    'priority' => 'high',
			    'show_names' => 'true',
			    'fields' => array(
			        array(
			            'id'            =>'social_banner_show',
			            'label'         =>__('Social Banner',HATT_TEXTDOMAIN),
			            'desc'          =>__('Show social share banner',HATT_TEXTDOMAIN),
			            'type'          =>'on-off',
			            'std'   => 'on'
			        )
			    )
			);
			
			/*$meta_box[] = array(
				'id'         => 'offer_content',
				'title'      => __( 'CONTENT', HATT_TEXTDOMAIN ),
				'pages'      => array( 'offer' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => 'true',
				'fields'     => array(
					array(
						'id'   => 'ht_offer_content',
						'std'  => '',
						'type' => 'textarea',
					),
				)
			);*/
			
			$meta_box[] = array(
				'id'         => 'offer_terms',
				'title'      => __( 'TERMS AND CONDITIONS', HATT_TEXTDOMAIN ),
				'pages'      => array( 'offer' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => 'true',
				'fields'     => array(
					array(
						'id'    => 'ht_offer_terms_show',
						'type'  => 'on-off',
						'std'   => 'on'
					),
					array(
						'id'        => 'ht_offer_terms',
						'type'      => 'textarea',
						'condition' => 'ht_offer_terms_show:is(on)'
					)
				)
			);



			

			
			if ( ! empty( $meta_box ) ) {
				foreach ( $meta_box as $key => $value ) {
					if ( function_exists( 'ot_register_meta_box' ) ) {
						ot_register_meta_box( $value );
					}
				}
			}

//        $meta_box[]=array(
//            'id'=>'Offer_options',
//            'title'=>__('Offer Infomation',HATT_TEXTDOMAIN),
//            'pages'=>array('Offer'),
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
BTOffer::init();