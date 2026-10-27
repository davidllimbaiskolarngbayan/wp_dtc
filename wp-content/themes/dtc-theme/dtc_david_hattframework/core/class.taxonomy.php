<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/15/15
 * Time: 6:42 PM
 */
if(!class_exists('HattTaxonomy'))
{

    class HattTaxonomy
    {
        private static $_all;

        static function init()
        {
            add_action('init',array(__CLASS__,'do_register'));
        }

        static function do_register()
        {
            self::$_all=apply_filters('ht_all_taxonomies',self::$_all);

            if(!empty(self::$_all))
            {
                foreach(self::$_all as $key=>$value)
                {
                    register_taxonomy( $key, $value['types'],$value['args'] );
                }
            }
        }

        static function register($tax,$types=array(),$arg){

            self::$_all[$tax]=array(
                'types'=>$types,
                'args'=>$arg
            );
        }
    }

    HattTaxonomy::init();

}