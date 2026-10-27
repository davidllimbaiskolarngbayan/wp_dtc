<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 11/26/14
 * Time: 5:02 PM
 */
?>
<form class="header-search" method="get" action="<?php echo home_url('/')?>">
    <div class="select-cat">
        <?php
        if(function_exists('wc_product_dropdown_categories'))
        {
            wc_product_dropdown_categories();
        }?>
    </div>
    <input  class="hatt-search-input" placeholder="<?php _e('What are you looking for?',HATT_TEXTDOMAIN)?>" name="s" value="<?php echo esc_attr(get_query_var('s'))?>">
    <input type="hidden" name="post_type" value="product">
    <button class="btn btn-search">Search</button>
    <?php wp_nonce_field('hatt-search-box')?>
</form>