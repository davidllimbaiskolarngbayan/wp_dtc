<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 5/29/2015
 * Time: 1:24 AM
 */
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
    <div class="content-media-centre">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                        if(have_posts()):
                        while(have_posts()):
                        the_post();
                        echo hatt()->load_template('stores/gird',false);
                        endwhile;
                        wp_reset_query();
                            echo '<div class="pagination_div font- text-center">';
                            echo ht_paging();
                            echo '</div>';
                        endif
                        ;?>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
