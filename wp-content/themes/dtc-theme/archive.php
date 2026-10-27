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
 ?>
<?php if(get_query_var( 'taxonomy' ) == 'video_cat'): ?>

<div class="content-news video-archive">
<div id="main-page">
		<?php $video_layout =  hatt()->get_option('video_layout');
			if($video_layout){
				echo get_vc_pagecontent($video_layout);
			}
		?>
</div>
</div>
<?php else: ?>

<?php get_header(); ?>

<div id="content">
    <div class="content-media-centre">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <?php if (have_posts()) { 
						if(is_post_type_archive('career')){
							get_template_part('loop-career');
						}else{
							if(is_post_type_archive('learn')){
								get_template_part('loop-learn');
							}else{
									get_template_part('loop');
							}
						}
                        echo '<div class="pagination_div font- text-center">';
	                    echo ht_paging();
	                    echo '</div>';
                    } else {
                        get_template_part('loop', 'none');
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php get_footer(); ?>
<?php endif; ?>
