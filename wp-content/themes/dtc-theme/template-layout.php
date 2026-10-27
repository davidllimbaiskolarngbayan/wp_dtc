<?php
/**
 * Template Name: Layout
 * Created by PhpStorm.
 * User: me664
 * Date: 1/5/15
 * Time: 11:45 PM
 */
?>
    <?php
    if (have_posts()):while (have_posts()):
        the_post();
        the_content();

         endwhile;endif?>

