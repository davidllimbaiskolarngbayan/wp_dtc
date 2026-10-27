<?php
    /**
     * Template Name: Full width
     * Created by PhpStorm.
     * User: me664
     * Date: 1/5/15
     * Time: 11:45 PM
     */
    get_header();
?>
<?php
    if (have_posts()):while (have_posts()):
        the_post();
        the_content();

    endwhile;endif?>

<?php get_footer();