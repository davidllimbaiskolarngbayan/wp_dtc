<?php

	/**
	 * Created by PhpStorm.
	 * User: MrHa-jpt
	 * Date: 3/2/2015
	 * Time: 2:21 PM
	 */
	class HattTyre {

		static function  init() {

			$labels = array(
				'name'               => __( 'Tyres', HATT_TEXTDOMAIN ),
				'singular_name'      => __( 'Tyre', HATT_TEXTDOMAIN ),
				'menu_name'          => __( 'Tyres', HATT_TEXTDOMAIN ),
				'name_admin_bar'     => __( 'Tyres', HATT_TEXTDOMAIN ),
				'add_new'            => __( 'Add New', HATT_TEXTDOMAIN ),
				'add_new_item'       => __( 'Add New Tyre', HATT_TEXTDOMAIN ),
				'new_item'           => __( 'New Tyre', HATT_TEXTDOMAIN ),
				'edit_item'          => __( 'Edit Tyre', HATT_TEXTDOMAIN ),
				'view_item'          => __( 'View Tyre', HATT_TEXTDOMAIN ),
				'all_items'          => __( 'All Tyre', HATT_TEXTDOMAIN ),
				'search_items'       => __( 'Search Tyre', HATT_TEXTDOMAIN ),
				'parent_item_colon'  => __( 'Parent Tyre:', HATT_TEXTDOMAIN ),
				'not_found'          => __( 'No Tyre found.', HATT_TEXTDOMAIN ),
				'not_found_in_trash' => __( 'No Tyre found in Trash.', HATT_TEXTDOMAIN )
			);

			$args = array(
				'labels'             => $labels,
				'public'             => TRUE,
				'publicly_queryable' => TRUE,
				'show_ui'            => TRUE,
				'show_in_menu'       => TRUE,
				'query_var'          => TRUE,
				'rewrite'            => array( 'slug' => 'tyres' ),
				'capability_type'    => 'post',
				'has_archive'        => TRUE,
				'hierarchical'       => FALSE,
				'menu_icon'          => 'dashicons-sos',
				'menu_position'      => 20,
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comment' )

			);
			hattPosttype::register( 'tyres', $args );

			$labels = array(
				'name'              => _x( 'Tyre Features', 'taxonomy general name', HATT_TEXTDOMAIN ),
				'singular_name'     => _x( 'Tyre Feature', 'taxonomy singular name', HATT_TEXTDOMAIN ),
				'search_items'      => __( 'Search Tyre Features', HATT_TEXTDOMAIN ),
				'all_items'         => __( 'All Tyre Features', HATT_TEXTDOMAIN ),
				'parent_item'       => __( 'Parent Tyre Feature', HATT_TEXTDOMAIN ),
				'parent_item_colon' => __( 'Parent Tyre Feature:', HATT_TEXTDOMAIN ),
				'edit_item'         => __( 'Edit Tyre Feature', HATT_TEXTDOMAIN ),
				'update_item'       => __( 'Update Tyre Feature', HATT_TEXTDOMAIN ),
				'add_new_item'      => __( 'Add New Tyre Feature', HATT_TEXTDOMAIN ),
				'new_item_name'     => __( 'New Tyre Feature Name', HATT_TEXTDOMAIN ),
				'menu_name'         => __( 'Tyre Feature', HATT_TEXTDOMAIN ),
			);
			$args   = array(
				'hierarchical'      => TRUE,
				'labels'            => $labels,
				'show_ui'           => TRUE,
				'show_admin_column' => TRUE,
				'query_var'         => TRUE,
				'rewrite'           => array( 'slug' => 'tyres_feature' ),
			);
			hattTaxonomy::register( 'tyres_feature', array( 'tyres' ), $args );

//			$labels = array(
//				'name'              => _x( 'Tyre Weather', 'taxonomy general name', HATT_TEXTDOMAIN ),
//				'singular_name'     => _x( 'Tyre Weather', 'taxonomy singular name', HATT_TEXTDOMAIN ),
//				'search_items'      => __( 'Search Tyre Weather', HATT_TEXTDOMAIN ),
//				'all_items'         => __( 'All Tyre Weather', HATT_TEXTDOMAIN ),
//				'parent_item'       => __( 'Parent Tyre Weather', HATT_TEXTDOMAIN ),
//				'parent_item_colon' => __( 'Parent Tyre Weather:', HATT_TEXTDOMAIN ),
//				'edit_item'         => __( 'Edit Tyre Weather', HATT_TEXTDOMAIN ),
//				'update_item'       => __( 'Update Tyre Weather', HATT_TEXTDOMAIN ),
//				'add_new_item'      => __( 'Add New Tyre Weather', HATT_TEXTDOMAIN ),
//				'new_item_name'     => __( 'New Tyre Weather ', HATT_TEXTDOMAIN ),
//				'menu_name'         => __( 'Tyre Weather', HATT_TEXTDOMAIN ),
//			);
//			$args   = array(
//				'hierarchical'      => TRUE,
//				'labels'            => $labels,
//				'show_ui'           => TRUE,
//				'show_admin_column' => TRUE,
//				'query_var'         => TRUE,
//				'rewrite'           => array( 'slug' => 'tyres_weather' ),
//			);
//			hattTaxonomy::register( 'tyres_weather', array( 'tyres' ), $args );

//			$labels = array(
//				'name'              => _x( 'Tyre Technology', 'taxonomy general name', HATT_TEXTDOMAIN ),
//				'singular_name'     => _x( 'Tyre Technology', 'taxonomy singular name', HATT_TEXTDOMAIN ),
//				'search_items'      => __( 'Search Tyre Technology', HATT_TEXTDOMAIN ),
//				'all_items'         => __( 'All Tyre Technology', HATT_TEXTDOMAIN ),
//				'parent_item'       => __( 'Parent Tyre Technology', HATT_TEXTDOMAIN ),
//				'parent_item_colon' => __( 'Parent Tyre Technology:', HATT_TEXTDOMAIN ),
//				'edit_item'         => __( 'Edit Tyre Technology', HATT_TEXTDOMAIN ),
//				'update_item'       => __( 'Update Tyre Technology', HATT_TEXTDOMAIN ),
//				'add_new_item'      => __( 'Add New Tyre Technology', HATT_TEXTDOMAIN ),
//				'new_item_name'     => __( 'New Tyre Technology Name', HATT_TEXTDOMAIN ),
//				'menu_name'         => __( 'Tyre Technology', HATT_TEXTDOMAIN ),
//			);
//			$args   = array(
//				'hierarchical'      => TRUE,
//				'labels'            => $labels,
//				'show_ui'           => TRUE,
//				'show_admin_column' => TRUE,
//				'query_var'         => TRUE,
//				'rewrite'           => array( 'slug' => 'tyres_technology' ),
//			);
//			hattTaxonomy::register( 'tyres_technology', array( 'tyres' ), $args );

			$labels = array(
				'name'              => _x( 'Tyre Categories', 'taxonomy general name', HATT_TEXTDOMAIN ),
				'singular_name'     => _x( 'Tyre Category', 'taxonomy singular name', HATT_TEXTDOMAIN ),
				'search_items'      => __( 'Search Tyre Categories', HATT_TEXTDOMAIN ),
				'all_items'         => __( 'All Tyre Categories', HATT_TEXTDOMAIN ),
				'parent_item'       => __( 'Parent Tyre Category', HATT_TEXTDOMAIN ),
				'parent_item_colon' => __( 'Parent Tyre Category:', HATT_TEXTDOMAIN ),
				'edit_item'         => __( 'Edit Tyre Category', HATT_TEXTDOMAIN ),
				'update_item'       => __( 'Update Tyre Category', HATT_TEXTDOMAIN ),
				'add_new_item'      => __( 'Add New Tyre Category', HATT_TEXTDOMAIN ),
				'new_item_name'     => __( 'New Tyre Category Name', HATT_TEXTDOMAIN ),
				'menu_name'         => __( 'Tyre Category', HATT_TEXTDOMAIN ),
			);
			$args   = array(
				'hierarchical'      => TRUE,
				'labels'            => $labels,
				'show_ui'           => TRUE,
				'show_admin_column' => TRUE,
				'query_var'         => TRUE,
				'rewrite'           => array( 'slug' => 'tyres_cat' ),
			);
			hattTaxonomy::register( 'tyres_cat', array( 'tyres' ), $args );
			add_action( 'init', array( __CLASS__, 'add_metabox' ) );
			self::add_feature_taxmeta();
			self::add_category_taxmeta();
//			self::add_weather_taxmeta();
			self::add_technology_icons();

/*			add_action( 'add_meta_boxes', array( __CLASS__, '_add_select_size_metabox' ) );
			add_action( 'save_post', array( __CLASS__, '_save_select_size_metabox' ) );
			add_action( 'wp_ajax_add_compare', array( __CLASS__, '_add_compare' ) );
			add_action('wp_ajax_nopriv_add_compare',array(__CLASS__,'_add_compare'));
            add_action( 'wp_ajax_add_select_type_admin', array( __CLASS__, '_add_select_size' ) );
			add_action('wp_ajax_nopriv_add_select_type_admin',array(__CLASS__,'_add_select_size'));*/

			//OE tyre
			//add_action( 'add_meta_boxes', array( __CLASS__, '_add_select_oetyre_metabox' ) );
			//add_action( 'save_post', array( __CLASS__, '_save_select_oetyre_metabox' ) );
			//add_action( 'wp_ajax_add_select_oetyre_admin', array( __CLASS__, '_add_select_oetyre_action' ) );
			//add_action( 'wp_ajax_nopriv_add_select_oetyre_admin',array(__CLASS__,'_add_select_oetyre_action'));


		}


		static function _add_compare() {
			if ( $_POST ) {

				if(!isset($_SESSION['compare'])){
					$_SESSION['compare'] = array();
				}


				$id = $_POST['id'];
				if($_POST['status'] == 'add'){
					if(count($_SESSION['compare'])>=3 ){
						echo json_encode(array('status'=>0,'message'=>'Max tyre to compare: 3'));
						die();

					}else{
                        $_SESSION['compare'][]=$id;
                        echo json_encode(array('status'=>1,'message'=>'add done'));
                        die();
                    }
				}else{
					foreach($_SESSION['compare'] as  $key =>$val){
                        if($val==$id){
							unset($_SESSION['compare'][$key]);
                            echo json_encode(array('status'=>1,'message'=>'remove done'));
                            die();
						}
					}

				}

			}
		}
        static  function _add_select_size(){
            $sizes = get_posts( array( 'post_type' => 'size', "posts_per_page" => - 1 ) );
            $html= '';
            if(!empty($sizes)){
                foreach ( $sizes as $k => $val ) {
                    if ($k == 0) {
                        $html .= '<div class="size_item"><span class="ht_delete"></span><select class="select_size" name="ht_select_size_customa[]">';
                    }
                    $html.='<option value="'.$val->ID.'">'.$val->post_title.'</option>';
                    if (($k+1) == count($sizes) ){
                        $html.="</select></div>";
                    }
                }
            }
            echo json_encode(array('status'=>1,'html'=>$html));
            die();
        }
		static function _add_select_size_metabox() {

			$screens = array( 'tyres' );

			foreach ( $screens as $screen ) {

				add_meta_box(
					'myplugin_sectionid',
					__( 'Select Size', HATT_TEXTDOMAIN ),
					array( __CLASS__, '_add_select_size_metabox_html' ),
					$screen
				);
			}
		}

		static function _add_select_size_metabox_html() {

			$html  = '';
			$sizes = get_posts( array( 'post_type' => 'size', "posts_per_page" => - 1 ) );
			$selected = get_post_meta( get_the_ID(), 'ht_select_size_customa' );
			if ( ! empty( $sizes ) ) {
                $html = '<div style="text-align: right"> <span class="ht_add_new_size"><img src="'.get_stylesheet_directory_uri().'/admin/images/ajax-loader.gif">Add New</span></div>
<div class="list_size_tyre">';
                if(!empty($selected) and is_array($selected)){
                    foreach($selected as $key =>$val_selected){
                        foreach ( $sizes as $k => $val ) {
                            if ($val->ID == $val_selected) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            if ($k == 0) {
                                $html .= '<div class="size_item"><span class="ht_delete"></span><select class="select_size" name="ht_select_size_customa[]">';
                            }
                            $html.='<option '.$checked.' value="'.$val->ID.'">'.$val->post_title.'</option>';
                            if (($k+1) == count($sizes) ){
                                $html.="</select></div>";
                            }
                        }
                    }
                }

                $html.='</div>';
			}
			echo $html;
		}

		static function _save_select_size_metabox( $post_id ) {
//			$my_data = sanitize_text_field( $_POST['ht_select_size_customa'] );
			if ( isset( $_POST['ht_select_size_customa'] ) ) {
				$selected = $_POST['ht_select_size_customa'];
				delete_post_meta( $post_id, 'ht_select_size_customa' );
				if ( ! empty( $selected ) and is_array( $selected ) ) {
					foreach ( $selected as $key ) {
						add_post_meta( $post_id, 'ht_select_size_customa', $key );
					}
				}
			}
		}

		static function add_metabox() {

			$meta_box[] = array(
				'id'         => 'tyre_options',
				'title'      => __( 'Tyre Information', HATT_TEXTDOMAIN ),
				'pages'      => array( 'tyres' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => 'true',
				'fields'     => array(
					array(
						'label' => __( 'Information', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_tab',
						'type'  => 'tab'
					),
					array(
						'label' => __( 'Tyre code', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_code',
						'type'  => 'text',
					),
					array(
						'label' => __( 'Run On Flat', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_rof',
						'type'  => 'on-off',
						'std'   => 'off'
					),
					array(
						'label' => __( 'Worry Free Assurance', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_dtc',
						'type'  => 'on-off',
						'std'   => 'off'
					),
					array(
						'label' => __( 'Tyre Brochure URL', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_brochure',
						'type'  => 'text'
					),
					array(
						'label' => __( 'Sort Order', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_order',
						'type'  => 'text',
					),array(
						'label' => __( 'Information', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_information',
						'type'  => 'textarea',
					),array(
						'label' => __( 'Custom template', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_custom_template',
						'type'  => 'text',						
					),array(
						'label' => __( 'Rating', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_rating_tab',
						'type'  => 'tab'
					),array(
						'label' => __( 'Ratings <br/> <span style="font-size: 14px;"><strong>Format:</strong> <i>feature_label: score</i> <br/>Enter one or multiple feature, one per line. Set the max score to 5 and min score to 1.</span>', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_ratings',
						'placeholder' =>  'Feature: 5 ',

						'type'  => 'textarea',
					),
					array(
						'label' => __( 'Price', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_price_tab',
						'type'  => 'tab'
					),
					array(
						'label' => __( 'Show Pricing', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_price_show',
						'type'  => 'on-off',
						'std'   => 'on'
					),
					array(
						'label'     => __( 'Price', HATT_TEXTDOMAIN ),
						'id'        => 'ht_tyre_price',
						'type'      => 'text',
						'condition' => 'ht_tyre_price_show:is(on)'
					),array(
						'label'     => __( 'Select', HATT_TEXTDOMAIN ),
						'id'        => 'ht_tyre_price_type',
						'type'      => 'select',
                        'std'   => '3',
						'condition' => 'ht_tyre_price_show:is(off)',
                        'choices'=>array(


                            array(
                                'value'       => '中高档轿车胎',
                                'label'       => __( '中高档轿车胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '中高档轿车胎',
                                'label'       => __( '中高档轿车胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '中高档轿车胎/中高档SUV胎',
                                'label'       => __( '中高档轿车胎/中高档SUV胎', 'theme-text-domain' ),
                               // 'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '中长途卡客车驱动轴专用轮胎',
                                'label'       => __( '中长途卡客车驱动轴专用轮胎', 'theme-text-domain' ),
                                'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '长途高速卡客车驱动轴专用轮胎',
                                'label'       => __( '长途高速卡客车驱动轴专用轮胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'

                            ),
                            array(
                                'value'       => '经济型轿车胎',
                                'label'       => __( '经济型轿车胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '豪华型轿车胎',
                                'label'       => __( '豪华型轿车胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '缺气保用轮胎',
                                'label'       => __( '缺气保用轮胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '中高档运动胎/中高档SUV胎',
                                'label'       => __( '中高档运动胎/中高档SUV胎', 'theme-text-domain' ),
                               // 'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '豪华型运动胎',
                                'label'       => __( '豪华型运动胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '豪华型SUV胎',
                                'label'       => __( '豪华型SUV胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '豪华型SUV胎/豪华型运动胎/豪华型轿车胎',
                                'label'       => __( '豪华型SUV胎/豪华型运动胎/豪华型轿车胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '中高档/豪华型轿车胎',
                                'label'       => __( '中高档/豪华型轿车胎', 'theme-text-domain' ),
                               // 'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '豪华型轿车胎/豪华型SUV胎',
                                'label'       => __( '豪华型轿车胎/豪华型SUV胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '中高档/豪华型SUV胎',
                                'label'       => __( '中高档/豪华型SUV胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'

                            ),
                            array(
                                'value'       => '中高档SUV胎',
                                'label'       => __( '中高档SUV胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => 'SUV冬季胎',
                                'label'       => __( 'SUV冬季胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '轿车冬季胎',
                                'label'       => __( '轿车冬季胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '缺气保用冬季胎',
                                'label'       => __( '缺气保用冬季胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '高里程运输系列轮胎',
                                'label'       => __( '高里程运输系列轮胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '中长途挂车轴专用宽基子午线轮胎',
                                'label'       => __( '中长途挂车轴专用宽基子午线轮胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '中长途卡客车全轮位轮胎',
                                'label'       => __( '中长途卡客车全轮位轮胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '城际及城市道路中型巴士全轮位轮胎',
                                'label'       => __( '城际及城市道路中型巴士全轮位轮胎', 'theme-text-domain' ),
                               // 'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '中高档越野胎',
                                'label'       => __( '中高档越野胎', 'theme-text-domain' ),
                               // 'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '豪华型越野胎',
                                'label'       => __( '豪华型越野胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                            array(
                                'value'       => '越野冬季胎',
                                'label'       => __( '越野冬季胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '经济型越野胎',
                                'label'       => __( '经济型越野胎', 'theme-text-domain' ),
                                //'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '豪华型专业越野胎',
                                'label'       => __( '豪华型专业越野胎', 'theme-text-domain' ),
                               // 'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '平直高速公路系列',
                                'label'       => __( '平直高速公路系列', 'theme-text-domain' ),
                               // 'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),

                            array(
                                'value'       => '高速公路国道系列',
                                'label'       => __( '高速公路国道系列', 'theme-text-domain' ),
                               // 'src'         => get_template_directory_uri().'/admin/images/premium.png'
                            ),
                        )
					),
					/*array(
						'label' => __( 'Store', HATT_TEXTDOMAIN ),
						'id'    => 'ht_tyre_store_tab',
						'type'  => 'tab'
					),
					array(
						'label'     => __( 'Store', HATT_TEXTDOMAIN ),
						'id'        => 'ht_tyre_store_select',
						'type'      => 'custom-post-type-checkbox',
						'post_type' => 'store',
					),*/
				)
			);

			$meta_box[] = array(
				'id'         => 'tyre_specifications',
				'title'      => __( 'AVAILABLE SIZES', HATT_TEXTDOMAIN ),
				'pages'      => array( 'tyres' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => 'true',
				'fields'     => array(
					array(
						'id'   => 'ht_tyre_specifications',
						'std'  => '',
						'type' => 'textarea',
					),
				)
			);

			$meta_box[] = array(
				'id'         => 'buy_lazada',
				'title'      => __( 'BUY ON LAZADA', HATT_TEXTDOMAIN ),
				'pages'      => array( 'tyres' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => 'true',
				'fields'     => array(
					array(
						'id'   => 'ht_buy_lazada',
						'std'  => '',
						'type' => 'text',
					),
				)
			);
			
			$meta_box[] = array(
				'id'         => 'tyre_options_media',
				'title'      => __( 'Tyre Media', HATT_TEXTDOMAIN ),
				'pages'      => array( 'tyres' ),
				'context'    => 'normal',
				'priority'   => 'high',
				'show_names' => 'true',
				'fields'     => array(
					array(
						'id'    => 'ht_tyre_gallery',
						'label' => __( 'Gallery', HATT_TEXTDOMAIN ),
						'std'   => '',
						'type'  => 'gallery',
					),
					array(
						'id'       => 'ht_tyre_video',
						'label'    => __( 'Video url', HATT_TEXTDOMAIN ),
						'std'      => '',
						'type'     => 'list-item',
						'settings' => array(

							array(
								'id'    => 'link',
								'type'  => 'text',
								'label' => __( 'Url', HATT_TEXTDOMAIN ),
								'desc'  => __( 'Only youtube url', HATT_TEXTDOMAIN )
							)
						)
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
		}

		static function add_feature_taxmeta() {

			if ( is_admin() ) {
				$config  = array(
					'id'             => 'tyres_feature_meta_box',
					// meta box id, unique per meta box
					'title'          => 'Tyre Feature Meta Box',
					// meta box title
					'pages'          => array( 'tyres_feature' ),
					// taxonomy name, accept categories, post_tag and custom taxonomies
					'context'        => 'normal',
					// where the meta box appear: normal (default), advanced, side; optional
					'fields'         => array(),
					// list of meta fields (can be added by field arrays)
					'local_images'   => FALSE,
					// Use local or hosted images (meta box images for add/remove)
					'use_with_theme' => get_template_directory_uri() . '/dtc_david_hattframework/plugins/Tax-meta-class'
					//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
					,
				);
				$my_meta = new Tax_Meta_Class( $config );
				$my_meta->addImage( 'tyre_feature_image', array( 'name' => __( 'Feature Image ', HATT_TEXTDOMAIN ) ) );
				$my_meta->Finish();
			}
		}
//        static function add_weather_taxmeta() {
//
//			if ( is_admin() ) {
//				$config  = array(
//					'id'             => 'tyres_weather_meta_box',
//					// meta box id, unique per meta box
//					'title'          => 'Tyre Weather Meta Box',
//					// meta box title
//					'pages'          => array( 'tyres_weather' ),
//					// taxonomy name, accept categories, post_tag and custom taxonomies
//					'context'        => 'normal',
//					// where the meta box appear: normal (default), advanced, side; optional
//					'fields'         => array(),
//					// list of meta fields (can be added by field arrays)
//					'local_images'   => FALSE,
//					// Use local or hosted images (meta box images for add/remove)
//					'use_with_theme' => get_template_directory_uri() . '/dtc_david_hattframework/plugins/Tax-meta-class'
//					//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
//					,
//				);
//				$my_meta = new Tax_Meta_Class( $config );
//				$my_meta->addImage( 'tyre_weather_image', array( 'name' => __( 'Weather Image ', HATT_TEXTDOMAIN ) ) );
//				$my_meta->Finish();
//			}
//		}

		static function add_technology_icons() {

			if ( is_admin() ) {
				$config  = array(
					'id'             => 'tyres_technology_meta_box',
					// meta box id, unique per meta box
					'title'          => 'Tyre Technology Meta Box',
					// meta box title
					'pages'          => array( 'tyres_technology' ),
					// taxonomy name, accept categories, post_tag and custom taxonomies
					'context'        => 'normal',
					// where the meta box appear: normal (default), advanced, side; optional
					'fields'         => array(),
					// list of meta fields (can be added by field arrays)
					'local_images'   => FALSE,
					// Use local or hosted images (meta box images for add/remove)
					'use_with_theme' => get_template_directory_uri() . '/dtc_david_hattframework/plugins/Tax-meta-class'
					//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
					,
				);
				$my_meta = new Tax_Meta_Class( $config );
				$my_meta->addImage( 'tyre_technology_image', array( 'name' => __( 'Technology Icon ', HATT_TEXTDOMAIN ) ) );
				$my_meta->Finish();
			}
		}

		static function add_category_taxmeta() {

			if ( is_admin() ) {
				$config  = array(
					'id'             => 'tyres_cat_meta_box',
					// meta box id, unique per meta box
					'title'          => 'Tyre Category Meta Box',
					// meta box title
					'pages'          => array( 'tyres_cat' ),
					// taxonomy name, accept categories, post_tag and custom taxonomies
					'context'        => 'normal',
					// where the meta box appear: normal (default), advanced, side; optional
					'fields'         => array(),
					// list of meta fields (can be added by field arrays)
					'local_images'   => FALSE,
					// Use local or hosted images (meta box images for add/remove)
					'use_with_theme' => get_template_directory_uri() . '/dtc_david_hattframework/plugins/Tax-meta-class'
					//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
					,
				);
				$my_meta = new Tax_Meta_Class( $config );
				$my_meta->addImage( 'tyre_cat_image', array( 'name' => __( 'Category Image ', HATT_TEXTDOMAIN ) ) );
				$my_meta->Finish();
			}
		}

		//OE tyre
		static function _add_select_oetyre_metabox() {
			$screens = array( 'tyres' );
			foreach ( $screens as $screen ) {
				add_meta_box(
					'myplugin_sectionid_oetyre',
					__( 'OE Tyres', HATT_TEXTDOMAIN ),
					array( __CLASS__, '_add_select_oetyre_metabox_html' ),
					$screen
				);
			}
		}

		static function _add_select_oetyre_metabox_html() {
			$html  = '';

			$selected_combi = get_post_meta( get_the_ID(), 'ht_select_oetyre_combi' );

			//prepare list of Vehicle category
			$list_oetyre_vehicle = self::oetyre_list_category( get_the_ID() );

			if ( !empty( $list_oetyre_vehicle ) ) {

				$html = '<input type="hidden" id="ajax-nonce" value="'.wp_create_nonce( 'inno-tyrenonce' ).'" />';
				$html .= '<div style="text-align: right"> <span class="ht_add_new_oetyre"><img src="'.get_stylesheet_directory_uri().'/admin/images/ajax-loader.gif">Add New</span></div>
	<div class="list_oetyre_box">';

				if(!empty($selected_combi) and is_array($selected_combi)){
					foreach($selected_combi as $key =>$val_selected){
						list($sel_cate_id, $sel_size_id) = explode('_',$val_selected);

						//prepare list of Sizes
						$list_oetyre_sizes = self::oetyre_list_size( get_post($post)->post_name , $sel_cate_id);
						//start to draw each combi
						$html .= '<div class="ht_oetyre_item"><span class="ht_oetyre_delete"></span><div class="ht_oetyre_dd">';
						$html .= self::oetyre_draw_category( get_the_ID() , $list_oetyre_vehicle , $sel_cate_id );
						$html .= '<span> + </span>';
						$html .= self::oetyre_draw_size( get_post($post)->post_name , $list_oetyre_sizes , $sel_size_id, array('no_item' => '-- No size found --'));
						$html .= '</div></div>';
					}
				}
				$html.='</div>';

				//start to draw sample combi
				$combi_sample  = '<div class="ht_sample_oetyre_item" style="display:none">';
				$combi_sample .= '<div class="ht_oetyre_item"><span class="ht_oetyre_delete"></span><div class="ht_oetyre_dd">';
				$combi_sample .= self::oetyre_draw_category( get_the_ID() , $list_oetyre_vehicle , 0 , array('class' => 'sample_oecate', 'name' => '') );
				$combi_sample .= '<span> + </span>';
				$combi_sample .= self::oetyre_draw_size( get_post($post)->post_name , false , 0 , array('class' => 'sample_oesize', 'name' => '') );
				$combi_sample .= '</div></div>';
				$combi_sample .= '</div>';

				//to draw sample
				$html .= $combi_sample;

			}
			else{
				$html = 'Vehicle category cannot be empty. Besides, please ensure you customize at least one size to this tyre';
			}
			echo $html;
		}

		static function _save_select_oetyre_metabox( $post_id ) {
			if ( isset( $_POST['ht_select_oetyre_vehicle'] ) ) {
				$selected_vehi = $_POST['ht_select_oetyre_vehicle'];
				$selected_size = $_POST['ht_select_oetyre_size'];

				//delete all combi before update
				delete_post_meta( $post_id, 'ht_select_oetyre_combi' );

				if ( ! empty( $selected_vehi ) and is_array( $selected_vehi )
					and ! empty( $selected_size ) and is_array( $selected_size ) ) {

					foreach ( $selected_vehi as $key => $veh_val ) {
						if(!empty($veh_val) && !empty($selected_size[$key])){
							$new_combi = $veh_val.'_'.$selected_size[$key];
							add_post_meta( $post_id, 'ht_select_oetyre_combi', $new_combi );
						}
					}
				}
			}
		}

		//Prepare Lists
		static function oetyre_category_parent( $category_id ) {
			//get 'Year' Category
			$parent = get_term( $category_id, 'vehicles_cat' );
			if(!empty($parent)){
				$parent_name = trim($parent->name); //remove spaces
				$parent_name = (int)$parent_name; //convert into integer
				if(strlen($parent_name)==4 ){
					return ' ('.$parent_name.')';
				}
			}
		}
		static function oetyre_list_category( $post_id ) {
			//list selected categories of the post
			global $wpdb;
			$query = "SELECT t.term_id, t.name, tt.parent FROM hatt_terms AS t
LEFT OUTER JOIN hatt_term_taxonomy AS tt ON t.term_id = tt.term_id
LEFT OUTER JOIN hatt_term_relationships AS tr ON tr.term_taxonomy_id = tt.term_taxonomy_id
WHERE tt.taxonomy IN ('vehicles_cat') AND tr.object_id IN (".(int)$post_id.")
ORDER BY t.name ASC";
			return $wpdb->get_results($query);
		}
		static function oetyre_list_size( $post_name, $sel_cate_id ) {
			if(empty($post_name) || empty($sel_cate_id))
				return false;

			global $wpdb;
			//list sizes that 'belongs' to the tyre by category
			$query = "SELECT DISTINCT(e.`post_id`) as ID, d.post_title FROM hatt_terms a
LEFT OUTER JOIN hatt_term_taxonomy b ON a.`term_id` = b.`term_id` AND b.`taxonomy` = 'vehicles_cat'
LEFT OUTER JOIN hatt_term_relationships c ON b.`term_taxonomy_id` = c.`term_taxonomy_id`
LEFT OUTER JOIN hatt_posts d ON d.`ID` = c.`object_id` AND d.`post_type` = 'size'
LEFT OUTER JOIN `hatt_postmeta` e ON e.`post_id` = d.`ID`
LEFT OUTER JOIN `hatt_postmeta` f ON f.`post_id` = d.`ID` AND f.`meta_key` = 'ht_tyre_code'
WHERE a.`term_id`= '{$sel_cate_id}'
AND e.`post_id` IS NOT NULL
AND f.`meta_value` IN ('{$post_name}')";
			return $wpdb->get_results($query);
		}

		static function oetyre_draw_category( $post_id, $category_array = array(), $sel_cate_id = 0, $elem_arr = array() ) {
			//Draw category dropdown
			if(!is_array($category_array) || empty($category_array)){
				$category_array = self::oetyre_list_category($post_id);
			}

			$elements = array_merge(
				array(
					'class' => 'oetyre_vehcat_dd',
					'name' => 'ht_select_oetyre_vehicle[]',
				),
				$elem_arr
			);

			$html = '<select class="'.$elements['class'].'" name="'.$elements['name'].'">';
			$html.='<option value="0">-- Choose a vehicle --</option>';
			foreach($category_array as $category){
				$checked = ($category->term_id == $sel_cate_id)? 'selected':'';
				$html.='<option '.$checked.' value="'.$category->term_id.'">'.$category->name . self::oetyre_category_parent($category->parent).'</option>';
			}
			$html .= '</select>';
			return $html;
		}

		static function oetyre_draw_size( $post_name, $sizes_array, $sel_size_id = 0, $elem_arr = array() ){

			$elements = array_merge(
				array(
					'class' => 'oetyre_size_dd',
					'name' => 'ht_select_oetyre_size[]',
					'no_item' => '-- Choose a size --',
					'default_item' => '-- Choose a size --',
				),
				$elem_arr
			);

			$html = '<select class="'.$elements['class'].'" name="'.$elements['name'].'">';
			if(empty($sizes_array)){
				$html.='<option value="0">'.$elements['no_item'].'</option>';
			}else{
				$html.='<option value="0">'.$elements['default_item'].'</option>';
				foreach ( $sizes_array as $k => $size_val ) {
					$checked = ($size_val->ID == $sel_size_id)? 'selected':'';
					$html.='<option '.$checked.' value="'.$size_val->ID.'">'.$size_val->post_title.'</option>';
				}
			}
			$html .= '</select>';
			return $html;
		}

		static function _add_select_oetyre_action(){

			check_ajax_referer('inno-tyrenonce','security');

			$cur_post_id = $_POST['post_id'];
			$sel_cate_id = $_POST['veh_id'];

			$content_post = get_post($cur_post_id);
			$content_postname = $content_post->post_name;

			$sizes_array = self::oetyre_list_size( $content_postname, $sel_cate_id );
			//draw options
			if(empty($sizes_array)){
				$combi_sample ='<option value="0">-- No size found --</option>';
			}else{
				$combi_sample ='<option value="0">-- Choose a size --</option>';
				foreach ( $sizes_array as $k => $size_val ) {
					$combi_sample.='<option value="'.$size_val->ID.'">'.$size_val->post_title.'</option>';
				}
			}

			echo json_encode(array('status'=>1,'html'=>$combi_sample));
			die();
		}
}

	HattTyre::init();
