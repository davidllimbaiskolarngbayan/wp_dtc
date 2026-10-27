<?php

	/**
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/18/15
	 * Time: 11:38 PM
	 */
	class HTFAQ {

		static function  init() {

			$labels = array(
				'name'               => __( 'FAQ', HATT_TEXTDOMAIN ),
				'singular_name'      => __( 'FAQ', HATT_TEXTDOMAIN ),
				'menu_name'          => __( 'FAQ', HATT_TEXTDOMAIN ),
				'name_admin_bar'     => __( 'FAQ', HATT_TEXTDOMAIN ),
				'add_new'            => __( 'Add New', HATT_TEXTDOMAIN ),
				'add_new_item'       => __( 'Add New FAQ', HATT_TEXTDOMAIN ),
				'new_item'           => __( 'New FAQ', HATT_TEXTDOMAIN ),
				'edit_item'          => __( 'Edit FAQ', HATT_TEXTDOMAIN ),
				'view_item'          => __( 'View FAQ', HATT_TEXTDOMAIN ),
				'all_items'          => __( 'All FAQ', HATT_TEXTDOMAIN ),
				'search_items'       => __( 'Search FAQ', HATT_TEXTDOMAIN ),
				'parent_item_colon'  => __( 'Parent FAQ:', HATT_TEXTDOMAIN ),
				'not_found'          => __( 'No FAQ found.', HATT_TEXTDOMAIN ),
				'not_found_in_trash' => __( 'No FAQ found in Trash.', HATT_TEXTDOMAIN )
			);

			$args = array(
				'labels'             => $labels,
				'public'             => TRUE,
				'publicly_queryable' => TRUE,
				'show_ui'            => TRUE,
				'show_in_menu'       => TRUE,
				'query_var'          => TRUE,
				'rewrite'            => array( 'slug' => 'faq' ),
				'capability_type'    => 'post',
				'has_archive'        => TRUE,
				'hierarchical'       => FALSE,
				'menu_icon'          => 'dashicons-editor-help',
				'menu_position'      => null,
				'supports'           => array( 'title', 'author' )
			);
			hattPosttype::register( 'faq', $args );

			add_action( 'init', array( __CLASS__, 'add_metabox' ) );
		}

		static function add_metabox() {

			$meta_box[] = array(
				'id'         => 'faq_option',
				'title'      => __( 'Content', HATT_TEXTDOMAIN ),
				'pages'      => array( 'faq' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => 'true',
				'fields'     => array(
					array(
						'id'       => 'list_q_a',
						'label'    => __( 'Questions and answers', HATT_TEXTDOMAIN ),
						'type'     => 'list-item',
						'settings' => array(
							array(
								'id'    => 'answer',
								'label' => __( 'Answer', HATT_TEXTDOMAIN ),
								'type'  => 'textarea'
							),
						)
					),
				)
			);
			if ( ! empty( $meta_box ) ) {
				foreach ( $meta_box as $key => $value ) {
					if ( function_exists( 'ot_register_meta_box' ) ) {
						ot_register_meta_box( $value );
					}
				}
			}
		}
	}

	HTFAQ::init();