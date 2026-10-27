<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Kryptonite
 */
?>


<div id="post-<?php the_ID(); ?>" <?php post_class();?>>
    <?php while (have_posts()) {
        the_post();
            ?>
                <div class="content-learn">
                    <?php the_content(); ?>
                </div>
            <?php } ?>
</div>

