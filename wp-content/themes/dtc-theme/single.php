<?php
/**
 * The template for displaying all single posts.
 *
 * @package Kryptonite
 */

$sidebar_pos=apply_filters('hatt_sidebar_blog','right');

get_header(); ?>



<?php if(is_single() && is_singular('store')) :?>
<div class="container">
	<div class="row">
		<?php if($sidebar_pos=='left'):get_sidebar();endif; ?>
				<div class="col-sm-<?php echo ($sidebar_pos=='no')?12:8  ?>">
					<?php if(have_posts()){
						get_template_part('content','single');
					}else{
						get_template_part('content','none');
					}?>
				</div>
		<?php if($sidebar_pos=='right'):get_sidebar();endif; ?>
	</div>
</div>

<?php else: ?>

<div class="content-news">
	<div class="container">
		<div class="row">
			<?php if($sidebar_pos=='left'):get_sidebar();endif; ?>
			<div class="col-sm-<?php echo ($sidebar_pos=='no')?12:8  ?>">
				<?php if(have_posts()){
					get_template_part('content','single');
				}else{
					get_template_part('content','none');
				}?>
			</div>
			<?php if($sidebar_pos=='right'):get_sidebar();endif; ?>
		</div>
	</div>
</div>

<?php endif;?>

<?php get_footer(); ?>
