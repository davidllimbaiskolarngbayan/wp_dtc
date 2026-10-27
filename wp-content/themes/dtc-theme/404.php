<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Kryptonite
 */

	$sidebar_pos=apply_filters('hatt_sidebar_blog','right');
	get_header(); ?>
	<div id="main-page">


		<div class="container">

			<div class="row">
				<?php if($sidebar_pos=='left'):get_sidebar();endif; ?>
				<div class="col-sm-<?php echo ($sidebar_pos=='no')?12:8  ?>">
					<div class="alert-404 alert alert-danger">
						<?php
						
						_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', HATT_TEXTDOMAIN );
						
						?>
					</div>
					<br/>

					<?php get_search_form(); ?>
					<br/>
					<?php the_widget( 'WP_Widget_Recent_Posts', array('title'=>__( 'Recent Posts' , HATT_TEXTDOMAIN )) ); ?>

				</div>
				<?php if($sidebar_pos=='right'):get_sidebar();endif; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>