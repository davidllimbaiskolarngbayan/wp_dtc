<?php
	/**
	 * The template for displaying all single posts.
	 *
	 * @package Kryptonite
	 */

	$sidebar_pos = apply_filters('hatt_sidebar_blog', 'right');

	get_header(); ?>
	
<div class="content-news">

	<!-- <div class=""> -->
		<!-- <div class=""> -->
			<?php if (have_posts()) {
				get_template_part('content', 'single-learn');
			} else {
				get_template_part('content', 'none');
			} ?>

			<?php

				if (get_post_meta(get_the_ID(), 'learn_realted_article_show', true) == 'on'):

					;?>
					<div class="container">
					<div class="row">
					<div class="col-sm-12">
					<?php
					$data_cate = [];
					$category = get_the_terms( get_the_ID(),'learn_cat');
					if(!is_wp_error($category)){
						foreach ($category as $val){
							$data_cate[]=$val->term_id;
						}
					}
					$argv = array('post_type' => "learn",
								  'post__not_in' => array(get_the_ID()),
								  'posts_per_page' => 3, 'orderby' => 'rand',
					'tax_query' => array(
					array(
						'taxonomy' => 'learn_cat',
						'field'    => 'id',
						'terms'    => $data_cate,
					),
				));

					$learns_related = new WP_Query($argv);
					if ($learns_related->have_posts()):?>
						<div class="clearfix"></div>
						<div class="ht_custom_learn learn_related">
							<h2 style="text-align: center;padding: 20px;"><span
									style="color: #000000;"><?php _e("Related Articles", HATT_TEXTDOMAIN); ?></span></h2>

							<?php
								while ($learns_related->have_posts()):
									$learns_related->the_post();?>

									<?php
										$thumbbg="";
										if (has_post_thumbnail(get_the_ID())) {
											$thumbbg = ' style="background-image:url(' . wp_get_attachment_url( get_post_thumbnail_id(get_the_ID() )) . ');"';    
										}

										// echo "current_post:".$learns_related->current_post;
										$class="";
										if ($learns_related->current_post == 0) {
											$class .= ' first_learn_item ';
										}

									?>

									<div class="learn-item col-xs-12 no_padding col-sm-4 <?php echo $class; ?>">
										<div class="banner_feature baner-box">
											<a href="<?php the_permalink(); ?>" class="thumb-link" <?php echo $thumbbg ?> >
												<!-- <span class=""> -->
												<?php
													// if (has_post_thumbnail(get_the_ID())) {
													// 	the_post_thumbnail();
													// } 
												?>
												<!-- </span> -->
											</a>

											<div class="baner-box-detail hidden-xs">
												<h4 class="title"><a
														href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a>
												</h4>

												<div
													class="ht_content_banner_feature hidden-xs"><?php the_excerpt() ?></div>
											</div>
											<div class="baner-box-detail-mb visible-xs">
												<h4 class="title"><a
														href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a>
												</h4>
											</div>
										</div>
									</div>
								<?php
								endwhile;
								wp_reset_query(); 
							?>
						</div>
						<!-- .ht_custom_learn learn_related -->
						</div>
						</div>
					<?php endif;?>
				<?php endif; ?>
		</div>
	<!-- </div> -->
</div>
</div>
<?php get_footer(); ?>
