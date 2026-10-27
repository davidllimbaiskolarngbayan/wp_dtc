<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 3/31/2015
 * Time: 2:15 PM
 */

class ht_button extends HTBaseShortcode
{
    function __construct()
    {
        parent::__construct();
    }
    function content($attrs = array(), $content = false)
    {
        $a = extract(shortcode_atts(array(
            'href' => '#',
            'target' => '_self',
            'class' =>'',
        ), $attrs));
        if(!empty($href)){
            $html = '<div class="more"><a class="'.$class.'" href="'.$href.'" target="'.$target.'">'.$content.'</a></div>';
        }else{
            $html = '<div class="more"><a class="'.$class.'" href="#" target="'.$target.'">'.$content.'</a></div>';
        }
        return $html;
    }
}
new ht_button();