<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 11/26/14
 * Time: 4:57 PM
 */
if(!class_exists('Woocommerce')) return;

global $woocommerce;
?>
<div class="hatt-wrap-mini">
    <a href="" class="btn btn-primary btn-cart-info"><i class="ion ion-bag"><span class="total-item">
            <?php $total =$woocommerce->cart->cart_contents_count;
            echo '('.$total.')';
            ?>
    </span></i> <?php printf(__('Cart - %s',HATT_TEXTDOMAIN),$woocommerce->cart->get_cart_total())?> </a>
    <?php
echo "<div class='hatt-mini-cart'>";
if(function_exists('woocommerce_mini_cart'))
{
    woocommerce_mini_cart();
}
echo "</div>";
echo "</div>";

do_action('hatt_mini_cart');