<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/15/15
 * Time: 6:36 PM
 */
if(!class_exists('HattPosttype'))
{
    class HattPosttype
    {
        private static $_all_post_types;

        static function init()
        {
            add_action('init',array(__CLASS__,'do_register'));
        }

        static function do_register()
        {
            self::$_all_post_types=apply_filters('ht_all_post_types',self::$_all_post_types);

            if(!empty(self::$_all_post_types))
            {
                foreach(self::$_all_post_types as $key=>$value)
                {
                    register_post_type( $key, $value );
                }
            }
        }

        static function register($post_type,$arg){
            self::$_all_post_types[$post_type]=$arg;
        }
    }

    HattPosttype::init();
}
