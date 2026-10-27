<?php
    /**
     * Template Name: Offer
     * Created by MRM.
     * User: Preston
     * Date: 27 Jul 2015
     */
    get_header();
?>
    <div id="content">
        <div class="content-media-centre">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                            if (have_posts()) {
                                while (have_posts()) {
                                    the_post();
                                    the_content();
                                }
                            }
                            echo '<div class="content-career">';

                            $html = '
                            <div class="carerr-box">
                                <div class="row">
                                    <div class="col-sm-8 left">
                                        <p>' . Hatt()->get_option('career_content', false) . '</p>
                                    </div>
                                    <div class="col-sm-4 right hidden-xs">
                                        <p><strong>'.__('Your role is not on the list?',HATT_TEXTDOMAIN).'</strong></p>
                                        <p>' . Hatt()->get_option('career_role', false) . '</p>
                                    </div>
                                </div>
                            </div>
                            ';
                            echo $html;

                            echo '</div>';

                            $career = array('post_type'=>'career','posts_per_page'=>-1);
                            $career_query =new WP_Query($career);
                            if($career_query->have_posts()){
                                while ($career_query->have_posts()) {
                                    $career_query->the_post();
                                    echo Hatt()->load_template('loop/career', 'archive');
                                }
                                wp_reset_query();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>