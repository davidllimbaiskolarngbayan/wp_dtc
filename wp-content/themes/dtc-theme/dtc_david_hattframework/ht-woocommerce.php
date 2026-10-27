<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 12/18/14
 * Time: 8:25 PM
 */


if(!function_exists('hatt_woocommerce_product_tabs'))
{
    function hatt_woocommerce_product_tabs($tabs=array())
    {
        //Add Icon for Default Tabs
        if(isset($tabs['description'])) $tabs['description']['icon']='fa-info-circle';
        if(isset($tabs['reviews'])) $tabs['reviews']['icon']='fa-comments';

        //Theme options extra tabs
        $options=Hatt()->get_option('shop_extra_tab');
        if(!empty($options))
        {
            foreach($options as $key=>$value)
            {
                $tabs[sanitize_title($value['title'])]=array(
                    'title'=>$value['title'],
                    'icon'=>$value['icon'],
                    'priority'=>$value['order'],
                    'callback'=>'hatt_custom_product_tab',
                    'content'=>$value['content']
                );
            }
        }


        //Metabox extra tabs
        if(is_singular('product'))
        {
            $meta=get_post_meta(get_the_ID(),'custom_tab',true);
            if(!empty($meta))
            {
                foreach($meta as $key=>$value)
                {
                    $tabs[sanitize_title($value['title'])]=array(
                        'title'=>$value['title'],
                        'icon'=>$value['icon'],
                        'priority'=>$value['order'],
                        'callback'=>'hatt_custom_product_tab',
                        'content'=>$value['content']
                    );
                }
            }
        }



        foreach($tabs as $key=>$value){
            add_filter('woocommerce_product_' . $key . '_tab_title','hatt_show_tab_icon',10,3);
        }

        return $tabs;
    }
}
if(!function_exists('hatt_custom_product_tab'))
{
    function hatt_custom_product_tab($key,$tab=array())
    {
        if(isset($tab['content'])){
            echo do_shortcode($tab['content']);
        }
    }
}

if(!function_exists('hatt_show_tab_icon'))
{
    function hatt_show_tab_icon($title,$tab_id,$tab=array())
    {
        if(isset($tab['icon']) and $tab['icon']);
        $title=hatt_get_icon($tab['icon']).' '.$title;
        return $title;
    }
}

if(!function_exists('hatt_add_col'))
{
    function hatt_add_col()
    {
        $sidebar_pos=apply_filters('hatt_shop_sidebar_pos','left');

        if($sidebar_pos=='left')
        {
            /**
             * woocommerce_sidebar hook
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            do_action( 'woocommerce_sidebar' );
        }


        //We moved the sidebar to left, now remove the sidebar on right side
        remove_all_actions('woocommerce_sidebar');

        $product_col='9';
        if($sidebar_pos=='no'){
            $product_col='12';
        }
        echo "<!--Begin Product Col--><div class='col-sm-{$product_col}'>";
    }
}

if(!function_exists('hatt_add_close_col'))
{
    function hatt_add_close_col()
    {
        echo "</div><!--End Product Col-->";
    }
}
if(!function_exists('hatt_sidebar_col'))
{
    function hatt_sidebar_col()
    {
        echo "<!--Begin Sidebar Col--><div class='col-sm-3'>";
    }
}

if(!function_exists('hatt_sidebar_close_col'))
{
    function hatt_sidebar_close_col()
    {
        echo "</div><!--End Sidebar Col-->";
    }
}

if(!function_exists('hatt_shop_sidebar_pos'))
{
    function hatt_shop_sidebar_pos($sidebar_pos)
    {
        if(is_singular('product'))
        {
            $sidebar_pos=Hatt()->get_option('product_sidebar_pos','left');

            if($meta=get_post_meta(get_the_ID(),'sidebar_pos',true)){
                $sidebar_pos=$meta;
            }
        }else{
            $sidebar_pos=Hatt()->get_option('shop_sidebar_pos','left');
        }

        return $sidebar_pos;
    }
}

if(!function_exists('hatt_woocommerce_related_products_args')){
    function hatt_woocommerce_related_products_args($arg=array())
    {
        $relate_num=Hatt()->get_option('shop_relate_number',4);

        $arg['posts_per_page']=$relate_num;

        return $arg;
    }
}
if(!function_exists('hatt_product_class'))
{
    function hatt_product_class($class=array())
    {

        if(!is_single(get_the_ID()) and get_post_type()=='product')
        {
            $product_per_row=Hatt()->get_option('product_per_row',4);

            switch($product_per_row){
                case 1: $class[]='col-sm-12';
                    break;
                case 2: $class[]='col-sm-6';
                    break;
                case 3: $class[]='col-sm-4';
                    break;
                case 4: $class[]='col-sm-3';
                    break;
                case 6: $class[]='col-sm-2';
                    break;
                case 12: $class[]='col-sm-1';
                    break;
            }
        }


        return $class;
    }
}
if(!function_exists('hatt_breadcrumb_defaults'))
{
    function hatt_breadcrumb_defaults($arg=array())
    {
        return $arg;
    }
}
//Custom Woocommerce
add_filter('woocommerce_breadcrumb_defaults','hatt_breadcrumb_defaults');
add_filter('post_class','hatt_product_class');
add_filter('woocommerce_related_products_args','hatt_woocommerce_related_products_args');
add_filter('hatt_shop_sidebar_pos','hatt_shop_sidebar_pos');
add_filter('woocommerce_product_tabs','hatt_woocommerce_product_tabs');
add_action('woocommerce_before_main_content','hatt_add_col',1);
add_action('woocommerce_after_main_content','hatt_add_close_col',100);
add_action('woocommerce_sidebar','hatt_sidebar_col',1);
add_action('woocommerce_sidebar','hatt_sidebar_close_col',100);