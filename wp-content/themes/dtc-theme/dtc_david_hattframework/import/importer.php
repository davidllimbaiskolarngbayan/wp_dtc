<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/4/15
 * Time: 9:49 AM
 */

if(class_exists('hattImporter'))
{
    class FlatxImporter extends  hattImporter
    {
        static function init()
        {
            add_action('admin_init',array(__CLASS__,'_do_import'));
        }

        static function _do_import()
        {
            if(isset($_REQUEST['hatt_do_import']) and $_REQUEST['hatt_do_import'])
            {

                //Check Permission
                if(!current_user_can('manage_options')){
                    echo json_encode(array('status'=>0,'message'=>__('You do not have permission to do this',HATT_TEXTDOMAIN)));die;
                }

                self::load_lib();

                //Check Importer Plugins was installed
                if ( !class_exists( 'WP_Importer' ) or ! class_exists( 'WP_Import' ) ){
                    echo json_encode(array('status'=>0,'message'=>__('Importer Class Was Not Installed',HATT_TEXTDOMAIN)));die;
                }
                $hatt_import_config=array(
                    'homepage_default'=>'',
                    'blogpage_default'=>'',
                    'menu_locations'           =>array(),
                    'use_woocommerce'=>false,
                    'use_revslider'=>false
                );

                //Load import config
                $import_config=self::$_import_path.'/config.php';
                if(file_exists($import_config)){
                    include_once $import_config;
                }

                extract($hatt_import_config);


                $step =isset($_REQUEST['step'])? $_REQUEST['step']:1;

                $data_dir=self::$_import_path.'/'.self::$_package;
                $data_url=self::$_import_url.'/'.self::$_package;

                $package=self::$_package;

                if($step==1) {

                    //Update theme_options
                    $data_json = $data_url . '/theme_options.json';
                    $data_res = wp_remote_get($data_json);
                    if(!is_wp_error($data_res))
                    {
                        $data_body = $data_res['body'];
                        $options=unserialize(ot_decode($data_body)); // unserialize

                        if(!empty($options)){

                            if(!function_exists('ot_options_id'))
                            {
                                echo json_encode( array(
                                        'status'   =>0,
                                        'messenger'=>__("<span class='red'>Plugin: Option Tree must be installed first. Stop working!</span>",HATT_TEXTDOMAIN),
                                        'next_url' => ''
                                    )
                                );
                                die;
                            }

                            update_option( ot_options_id(), $options ); // and overwrite the current theme-options
                            echo json_encode( array(
                                    'status'   =>"ok",
                                    'messenger'=>__("Importing the demo theme options... <span>DONE!</span><br>",HATT_TEXTDOMAIN),
                                    'next_url' =>  admin_url(self::$_import_page."&hatt_do_import=1&package={$package}&step=" . ($step + 1))
                                )
                            );
                        }else{
                            echo json_encode( array(
                                    'status'   =>0,
                                    'messenger'=>__("<span class='red'>File: theme_options.json contain NULL content. Stop working!</span>",HATT_TEXTDOMAIN),
                                    'next_url' => ''
                                )
                            );
                        }

                    }else{
                        echo json_encode( array(
                                'status'   =>0,
                                'messenger'=>__("<span class='red'>Can not read theme_options.json<br>File:{$data_json}<br>. Stop working!</span>",HATT_TEXTDOMAIN),
                                'next_url' => ''
                            )
                        );
                        die;
                    }

                }

                //Update Widgets
                if($step==2){

                    // Add data to widgets
                    $json_file = $data_url .'/widget.json'; // widgets data file
                    $widgets_json = wp_remote_get( $json_file );
                    $widget_data = $widgets_json['body'];
                    $data_object=json_decode($widget_data);

                    $import_widgets =self::wie_import_data( $data_object );
                    echo json_encode( array(
                            'status'   =>1,
                            'messenger'=>__("Importing the demo widgets... <span>DONE!</span>.<br>",HATT_TEXTDOMAIN),

                            'next_url' => admin_url(self::$_import_page."&hatt_do_import=1&package={$package}&step=" . ($step + 1)),
                        )
                    );
                }

                //Import XML

                if($step==3){

                    $stt_file=isset($_REQUEST['file_number'])?$_REQUEST['file_number']:0;
                    $ds_file=array_filter(glob($data_dir.'/data/*'),'is_file');

                    $file_name=isset($ds_file[$stt_file])?$ds_file[$stt_file]:false;

                    if(!$file_name){
                        echo json_encode( array(
                                'status'   =>0,
                                'messenger'=>__("<span class='red'>File Not Found. Stop working!</span>",HATT_TEXTDOMAIN),
                                'next_url' => ''
                            )
                        );
                        die;
                    }

                    $nexturl=admin_url(self::$_import_page."&hatt_do_import=1&package={$package}&step=" . ($step).'&file_number='.($stt_file+1));

                    if($stt_file>=count($ds_file)-1){
                        $nexturl=admin_url(self::$_import_page."&hatt_do_import=1&package={$package}&step=" . ($step+1));
                    }

                    ob_start();
                    $importer = new WP_Import();
                    $theme_xml = $file_name;
                    $importer->fetch_attachments = true;
                    $importer->import($theme_xml);
                    @ob_clean();
                    echo json_encode( array(
                            'status'   =>1,
                            'messenger'=>__("Importing data: ".basename($file_name)." ".($stt_file+1)." of ".(count($ds_file)-1)."... <span>DONE!</span><br>",HATT_TEXTDOMAIN),
                            'next_url' => $nexturl,
                            'file'     => $ds_file,
                        )
                    );
                }

                // Set Up Menu Theme Location

                if($step==4) {
                    //  Set imported menus to registered theme locations
                    $locations = get_theme_mod('nav_menu_locations'); // registered menu locations in theme
                    $menus = wp_get_nav_menus(); // registered menus
                    if ($menus) {
                        foreach ($menus as $menu) { // assign menus to theme locations
                            if (!empty($menu_locations))
                                foreach ($menu_locations as $key => $st_over_menu) {
                                    if ($menu->name == $key) {
                                        $locations[$st_over_menu] = $menu->term_id;
                                    }
                                }
                        }
                    }
                    set_theme_mod('nav_menu_locations', $locations); // set menus to locations

                    $nexturl = admin_url(self::$_import_page . "&hatt_do_import=1&package={$package}&step=" . ($step+1) );
                    echo json_encode(array(
                            'status' => 1,
                            'messenger' => __("Importing menu settings ... <span>DONE!</span><br>", HATT_TEXTDOMAIN),
                            'next_url' => $nexturl,
                        )
                    );
                }

                // Set reading options
                if($step == '5'){
                    // Set reading options
                    if($homepage_default != ""){
                        $homepage = get_page_by_title( $homepage_default );
                        if($homepage->ID) {
                            update_option('show_on_front', 'page');
                            update_option('page_on_front', $homepage->ID); // Front Page
                        }
                    }
                    if($blogpage_default != ""){
                        $homepage = get_page_by_title( $blogpage_default );
                        if($homepage->ID) {
                            update_option('show_on_front', 'page');
                            update_option('page_for_posts', $homepage->ID); // Blog Page
                        }
                    }

                    echo json_encode( array(
                            'status'   =>"ok",
                            'messenger'=>__("Setting reading options... <span>DONE!</span><br/><span>All Done! Have Fun</span>",HATT_TEXTDOMAIN),
                            'next_url' => '',
                        )
                    );


                }

                die;
            }
        }
    }

    FlatxImporter::init();
}
