<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 5/12/2015
	 * Time: 2:39 PM
	 */ ?>

<?php

	$class = 'learn-item col-xs-12 no_padding col-sm-4 ';
	if ($query->current_post == 0) {
		$class .= ' first_learn_item ';
	}
	$i = $query->post_count % 3;
	if ($i == 1) {
		if ($query->current_post == $query->post_count - 1) {
			// $class .= 'col-sm-push-4 ml-4';
		}
	}
	if ($i == 2) {
		if ($query->current_post == $query->post_count - 1) {
			$class .= 'col-sm-push-2';
		}
		if ($query->current_post == $query->post_count - 2) {
			$class .= 'col-sm-push-2 ml-2';
		}
	}


	if (($query->current_post + 1) % 3 == 1) {
		echo '<div class="row_learn_item">';
	}; ?>

<div class="<?php echo esc_attr($class); ?>">

	<?php 

	$thumbbg="";
	if (has_post_thumbnail(get_the_ID())) {
		$thumbbg = ' style="background-image:url(' . wp_get_attachment_url( get_post_thumbnail_id(get_the_ID() )) . ');"';    
	}
	

	?>

	<div class="banner_feature baner-box">
		<a href="<?php the_permalink(); ?>" class="thumb-link" <?php echo $thumbbg ?> >
			<?php
				// if (has_post_thumbnail(get_the_ID())) {
				//     the_post_thumbnail();
				// } 
			?>
		</a>
		<div class="baner-box-detail hidden-xs">
			<h4 class="title"><a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h4>
			<div class="ht_content_banner_feature hidden-xs"><?php the_excerpt() ?></div>
		</div>
		<div class="baner-box-detail-mb visible-xs">
			<h4 class="title"><a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></h4>
		</div>
	</div>
</div>

<?php
	if (($query->current_post + 1) % 3 == 0 or $query->current_post == $query->post_count - 1) {
		echo '<div class="clearfix"></div></div>';
	}; ?>
