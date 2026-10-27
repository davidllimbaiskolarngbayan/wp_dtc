<?php
    /**
     * Template Name: About Us//Career
     * Created by MRM.
     * User: Adrian Tee
     * Date: 5 Jun 2015
     */
    get_header();
?>
    <div id="content">
        <div class="content-media-centre">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                            if (have_posts()) {
                                while (have_posts()) {
                                    the_post();
                                    the_content();
                                }
                            }
                            echo '<div class="content-career">';

                            $html = '
                            <div class="carerr-box">
                                <div class="row">
                                    <div class="col-sm-8 left">
					<div id="myCarousel" class="carousel slide row" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
						<li data-target="#myCarousel" data-slide-to="3"></li>
						<li data-target="#myCarousel" data-slide-to="4"></li>
						<li data-target="#myCarousel" data-slide-to="5"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img class="img-thumbnail" src="/wp-content/uploads/1-Raya2017-rs-min.jpg" alt="Raya Open House 2017">
						</div>
						<div class="item">
							<img class="img-thumbnail" src="/wp-content/uploads/2-FunRun-rs-min.jpg" alt="Fun Run">
						</div>
						<div class="item">
							<img class="img-thumbnail" src="/wp-content/uploads/3-GY-FUNRUN-rs-min.jpg" alt="Fun Run">
						</div>
						<div class="item">
                            <img class="img-thumbnail" src="/wp-content/uploads/4-A3-Launch-rs-min.jpg" alt="A3 Launch">
						</div>
						<div class="item">
                            <img class="img-thumbnail" src="/wp-content/uploads/5-2017-Futsal-rs-min.jpg" alt="2017 Futsal">
						</div>
						<div class="item">
                            <img class="img-thumbnail" src="/wp-content/uploads/6-Leadership-Training-rs-min.jpg" alt="Leadership Training">
						</div>
					</div>

					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" data-slide="prev" style="border-right: none;">
                        <span class="glyphicon glyphicon-chevron-left" style="color:#FD0;"></span>
                        <span class="sr-only">Previous</span>
                    </a>
					<a class="right carousel-control" href="#myCarousel" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" style="color:#FD0;"></span>
						<span class="sr-only">Next</span>
					</a>
					</div>
					<!--<div class="row hidden-sm hidden-xs">
						<div class="col-md-6">
							<img class="img-responsive img-thumbnail" src="/wp-content/uploads/1-Raya2017-rs-min.jpg" alt="Raya Open House 2017">
						</div>
						<div class="col-md-6">
							<img class="img-responsive img-thumbnail" src="/wp-content/uploads/2-FunRun-rs-min.jpg" alt="Fun Run">
						</div>
					</div>
					<div class="row hidden-sm hidden-xs">

						<div class="col-md-6 topmp2">
							<img class="img-responsive img-thumbnail" src="/wp-content/uploads/3-GY-FUNRUN-rs-min.jpg" alt="Fun Run">
						</div>
						<div class="col-md-6 topmp2">
							<img class="img-responsive img-thumbnail" src="/wp-content/uploads/4-A3-Launch-rs-min.jpg" alt="A3 Launch">
						</div>
					</div>
					<div class="row hidden-sm hidden-xs">

						<div class="col-md-6 topmp2">
							<img class="img-responsive img-thumbnail" src="/wp-content/uploads/5-2017-Futsal-rs-min.jpg" alt="2017 Futsal">
						</div>
						<div class="col-md-6 topmp2">
							<img class="img-responsive img-thumbnail" src="/wp-content/uploads/6-Leadership-Training-rs-min.jpg" alt="Leadership Training">
						</div>
					</div>-->

                                        <p>' . Hatt()->get_option('career_content', false) . '</p>
                                    </div>
                                    <div class="col-sm-4 right hidden-xs">
                                        <p><strong>'.__('Your role is not on the list?',HATT_TEXTDOMAIN).'</strong></p>
                                        <p>' . Hatt()->get_option('career_role', false) . '</p>
                                    </div>
                                </div>
                            </div>
                            ';
                            echo $html;

                            echo '</div>';

                            $career = array('post_type'=>'career','posts_per_page'=>-1);
                            $career_query =new WP_Query($career);
                            if($career_query->have_posts()){
                                while ($career_query->have_posts()) {
                                    $career_query->the_post();
                                    echo Hatt()->load_template('loop/career', 'archive');
                                }
                                wp_reset_query();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>