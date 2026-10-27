<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 11/27/14
 * Time: 11:01 PM
 */

?>
<div class="main-menu">
    <label class="label-all"><?php _e('All Categories',HATT_TEXTDOMAIN)?>
        <i class="fa fa-chevron-down icon-menu-status"></i>
    </label>
    <div class="menu-dropdown">
        <?php
        if(has_nav_menu('primary'))
        {
            wp_nav_menu(array(
                'theme_location'=>'primary',
                'container'=>false
            ));
        }else{
            echo __('No menu selected',HATT_TEXTDOMAIN);
        } ?>
    </div>
</div>