<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/23/15
 * Time: 12:45 AM
 */
class BTPage
{

    static function init(){
        add_action('init',array(__CLASS__,'add_metabox'));

    }

    static function  add_metabox()
    {
        $meta_box[]=array(
            'id'=>'page_meta',
            'title'=>__('Page Banner',HATT_TEXTDOMAIN),
            'pages'=>array('page'),
            'context'=>'side',
            'priority'=>'high',
            'show_names'=>'true',
            'fields'        =>array(
                array(
                    'id'            =>'ht_page_banner_title',
                    'label'         =>__('Banner Title',HATT_TEXTDOMAIN),
                    'type'          =>'text',
                ),
                array(
                    'id'            =>'ht_page_banner',
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

        if(!empty($meta_box)){
            foreach($meta_box as $key=>$value){
                if ( function_exists( 'ot_register_meta_box' ) )
                    ot_register_meta_box( $value );
            }
        }


    }
}
BTPage::init();