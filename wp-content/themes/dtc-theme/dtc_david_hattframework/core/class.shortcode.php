<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/18/15
 * Time: 11:44 PM
 */


if(!class_exists('HTBaseShortcode'))
{

    class HTBaseShortcode
    {
        function __construct()
        {
            $className=get_class($this);
            $className=mb_strtolower($className);
            add_shortcode($className,array($this,'content'));
        }
        function content($attrs,$content=false)
        {

        }

    }

}