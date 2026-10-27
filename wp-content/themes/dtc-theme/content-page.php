<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Kryptonite
 */
?>


<div id="post-<?php the_ID(); ?>" <?php post_class(array('news-box'));?>>
    <?php while (have_posts()) {
        the_post();
            ?>
                <div class="content-new">
                    <?php the_content(); ?>
                </div>
            <?php } ?>
</div>

