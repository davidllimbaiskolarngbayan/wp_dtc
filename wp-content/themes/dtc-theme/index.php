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
get_header(); ?>

<div id="main-page">
	<div class="container">
		<div class="row">


			<div class="col-sm-<?php echo (($sidebar_pos ?? 'no')=='no')?12:8  ?>">

				<?php

				if(have_posts()){

					get_template_part('loop');

					ht_paging();

				}else{

					get_template_part('loop','none');
				}?>

			</div>
		</div>

	</div>

</div>
<?php get_footer(); ?>

