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
    global $wp_query;
    $total_results = $wp_query->found_posts;

    global $query_string;
    $query_split = array();
    $query_args = explode("&", $query_string);
    $search_query = array();
    foreach($query_args as $key => $string) {
        $query_split = explode("=", $string);
        $search_query[$query_split[0]] = urldecode($query_split[1]);
    } // foreach



    $sidebar_pos = apply_filters( 'hatt_sidebar_blog', 'right' );
    get_header(); ?>
<div id="content">
    <div class="content-media-centre">
        <div class="container">
            <div class="row">
                <?php if ( $sidebar_pos == 'left' ):get_sidebar();endif; ?>
                <div class="col-sm-<?php echo ( $sidebar_pos == 'no' ) ? 12 : 8 ?>">
                    <?php if ( have_posts() ) {
                        echo "<div class='content-media-centre'>";
                    ?>
                    <div class="list_search">

                        <div class="header-search media-centre-box">
                            <h1><?php _e('Search Results',HATT_TEXTDOMAIN); ?></h1>
                            <p>
                            <?php 

                            if(SITE_LANG == "cn"){
                                 echo '你查找的关键字 “<b>' . esc_html(urldecode($query_split[1])) . '</b>” 获得约 ';
                                 echo esc_attr( $total_results );
                                 echo __('matches were found.',HATT_TEXTDOMAIN);

                            }else if(SITE_LANG == "kr"){
                                // echo __('You searched for the text', HATT_TEXTDOMAIN) . ' “' . urldecode($query_split[1] ) . "“ ". __('and', HATT_TEXTDOMAIN);
                                // esc_attr( $total_results )
                                // __('matches were found.',HATT_TEXTDOMAIN)

                                $result_txt = sprintf(__( 'You searched for the text “%s“ and %s matches were found.', HATT_TEXTDOMAIN ), esc_html(urldecode($query_split[1])), esc_attr($total_results) );

                                echo $result_txt;

                            }else{
                                echo __('You searched for the text', HATT_TEXTDOMAIN) . ' “' . esc_html(urldecode($query_split[1] )) . "“ ". __('and', HATT_TEXTDOMAIN) . " ".esc_attr( $total_results ) . " ".__('matches were found.',HATT_TEXTDOMAIN);
                            } ?>
                            
                           </p>
                            <div  class="hidden-xs custom_search_page">
                                <?php echo get_search_form();?>
                            </div>
                        </div>

                        <?php

                            while ( have_posts() ) {
                                the_post();
                                echo Hatt()->load_template( 'loop/content', 'search' );
                            }
                            echo '</div>';
                            echo '<div class="pagination_div font- text-center">';
                            echo ht_paging();
                            echo '</div>';
                            } else {
                            get_template_part( 'loop', 'none' );
                        } ?>
                    </div>

                </div>
                <?php if ( $sidebar_pos == 'right' ):get_sidebar();endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
