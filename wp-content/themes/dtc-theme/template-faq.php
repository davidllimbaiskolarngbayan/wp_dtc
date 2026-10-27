<?php
	/**
	 * Template Name: Learn
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/5/15
	 * Time: 11:45 PM
	 */
	get_header();
?>
<div class="page_learn">
	<div class="learn_tab text-center hidden-xs">
		<!-- Nav tabs -->
		<a href="#technology" aria-controls="technology" role="tab" data-toggle="tab">David Tyre Company Technology</a>
		<a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">Tyre Basics</a>
		<a href="#driving" aria-controls="driving" role="tab" data-toggle="tab">Driving and Safety tips</a>
		<a href="#faqs" class="learn_tab_active" aria-controls="faqs" role="tab" data-toggle="tab">Faqs</a>
	</div>
	<div class="learn_tab text-center visible-xs">
		<!-- Nav tabs -->
		<ul>
			<li><a href="#technology" aria-controls="technology" role="tab" data-toggle="tab">David Tyre Company Technology</a>
			</li>
			<li><a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">Tyre Basics</a></li>
			<li><a href="#driving" aria-controls="driving" role="tab" data-toggle="tab">Driving and Safety tips</a></li>
			<li><a href="#faqs" class="learn_tab_active" aria-controls="faqs" role="tab" data-toggle="tab">Faqs</a></li>
		</ul>
	</div>
	<!-- Tab panes -->
	<div class="tab-content learn-tab-content container">
		<div role="tabpanel" class="tab-pane fade" id="technology">21312</div>
		<div role="tabpanel" class="tab-pane fade" id="basic">..tyj.</div>
		<div role="tabpanel" class="tab-pane fade" id="driving">eeeqweq</div>
		<div role="tabpanel" class="tab-pane fade active in" id="faqs">
			<?php
				$argv     = array(
					'post_type'      => 'faq',
					'posts_per_page' => - 1,
				);
				$ht_query = new WP_Query( $argv );
				if ($ht_query->have_posts()):
				while ($ht_query->have_posts()):
				$ht_query->the_post();; ?>
			<div class="box-colspace-learn detail-box">
				<h2 class="title"><a href="#"><?php the_title();?></a></h2>

				<div class="box-colspace-content-learn col-md-12 col-sm-12 col-xs-12 learn-pad-content">
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 learn-left-content">
						<?php
							$list_q_a = get_post_meta( get_the_ID(), 'list_q_a', TRUE );
							if ( ! empty( $list_q_a )):
							foreach ($list_q_a as $key => $val):?>
						<!-- Content detail -->
						<?php
							if (( $key + 1 ) == count( $list_q_a )):;?>
						<div class="learn_detail" style="padding-bottom: 0px">
							<?php else:; ?>
							<div class="learn_detail">

								<?php endif;
								?>
								<div class="learn_title"><?php echo esc_attr($val['title']);?></div>
								<div class="learn_content">
									<?php echo esc_attr($val['answer']);?>
								</div>
							</div>
							<!-- End Content detail -->
							<?php
								endforeach;
								endif;
							?>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						</div>
						<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"></div>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 learn-right-content">
							Back to top
						</div>
					</div>
				</div>
				<?php endwhile;
					wp_reset_query();
					endif ?>
			</div>
		</div>
	</div>
	<?php get_footer(); ?>

	<style type="text/css">
		#main {
			margin-bottom: 0px;
		}
	</style>