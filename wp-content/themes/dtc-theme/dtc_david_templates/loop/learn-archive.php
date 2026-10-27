<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/6/2015
	 * Time: 4:40 PM
	 */
	global $wp_query;
	if ( $wp_query->current_post == 0 ) {
		$class = 'box-open';
	} else {
		$class = 'box-close';
	}
?>

<div class="box-colspace <?php echo esc_attr( $class ); ?>">
	<h2 class="title "><a
			href="#"><?php the_title(); ?></a></h2>

	<div class="box-colspace-content">
		<div class="row">
			<div class="col-sm-9 left">
				<?php the_content(); ?>
			</div>
			<div class="col-sm-3 right">
				<p class="backtotop text-right"><img
						src="<?php echo esc_url( get_template_directory_uri() ) . '/images/backtotop.PNG'; ?>" alt="" />
					back to top</p>
			</div>
		</div>
	</div>
</div>