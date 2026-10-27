<?php

class hattOptiontree
{
    public $theme;

    function __construct()
    {
        if(!class_exists('OT_Loader')) return;
        add_action( 'admin_init', array($this,'custom_theme_options') );

        $this->theme = wp_get_theme();

        add_filter('ot_header_version_text',array($this,'ot_header_version_text'));


        add_action( 'admin_init', array($this,'custom_meta_boxes') );

    }

    function ot_header_version_text($title)
    {
        $title=  esc_html(  $this->theme->display('Name') );
        $title.=' - '. sprintf(__('Version %s', HATT_TEXTDOMAIN), $this->theme->display('Version'));

        return $title;
    }

    function custom_theme_options()
    {

        /**
         * Get a copy of the saved settings array.
         */
        $saved_settings = get_option(ot_settings_id(), array());

        $custom_settings=array();

        if(file_exists(Hatt()->dir('ht-theme-options.php')))
        {
            include_once Hatt()->dir('ht-theme-options.php');
        }


        /* allow settings to be filtered before saving */
        $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );

        /* settings are not the same update the DB */
        if ( $saved_settings !== $custom_settings ) {
            update_option( ot_settings_id(), $custom_settings );
        }
    }

    function custom_meta_boxes()
    {
        $meta_box=array();

        if(file_exists(Hatt()->dir('ht-metabox.php')))
        {
            include_once Hatt()->dir('ht-metabox.php');
        }


        if(!empty($meta_box)){
            foreach($meta_box as $key=>$value){
                if ( function_exists( 'ot_register_meta_box' ) )
                    ot_register_meta_box( $value );
            }
        }
    }

}


new hattOptiontree();