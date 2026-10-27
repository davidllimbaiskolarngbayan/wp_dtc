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

<div class="content-news video-archive">
<div id="main-page">
		<?php $video_layout =  hatt()->get_option('video_layout');
			if($video_layout){
				echo get_vc_pagecontent($video_layout);
			}
		?>
</div>
</div>
