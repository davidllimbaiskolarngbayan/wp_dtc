<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Kryptonite
 */
get_header(); ?>
<div id="main-page">
    <div class="container">
        <?php $store_layout =  hatt()->get_option('store_layout');
            if($store_layout){
                echo get_vc_pagecontent($store_layout);
            }
        ?>
    </div>
</div>
</div>
    <?php get_footer(); ?>
