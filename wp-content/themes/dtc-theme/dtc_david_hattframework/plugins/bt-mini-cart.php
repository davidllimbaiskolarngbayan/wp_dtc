<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 11/30/14
 * Time: 6:46 PM
 */
class BTMiniCart
{
    function __construct()
    {

        add_filter( 'add_to_cart_fragments', array( $this, 'ajax_fragments' ) );
    }

    function ajax_fragments($f=array())
    {
        ob_start();
            get_template_part('header/mini-cart');

        $template=@ob_get_clean();

        $f['.hatt-wrap-mini']=$template;
        return $f;
    }

}
new BTMiniCart();