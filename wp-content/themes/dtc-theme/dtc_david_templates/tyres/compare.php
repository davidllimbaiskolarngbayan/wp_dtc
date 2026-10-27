<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/22/2015
	 * Time: 1:41 PM
	 */
?>
<?php
	$data =$list_item='';
	if (isset($_GET['tyre']) and !empty($_GET['tyre'])):
	$list_item = $_GET['tyre'];
	$data = explode(',', $_GET['tyre']);
	if (count($data) < 2) {
//					echo '<script type="text/javascript">alert("Min tyre to compare 2");window.location.href =("'.get_home_url("/").'") </script>';
		echo '<script type="text/javascript">alert("Min tyre to compare 2");window.history.back() </script>';
	}
	$url = hatt()->get_option('header_browser_tyre_url',false);
	if($url){
		$url=get_permalink($url);
		if(isset($_GET['tyre']) and !empty($_GET['tyre'])){
			$url_fix =  add_query_arg(array('compare_item_return'=>$_GET['tyre']),$url);
		}else{
			$url_fix=$url;
		};
	}else{
		$url_fix='#';
	}
	;?>

<script type="text/javascript">
	var max_height = '';
	var max_height_img = '';
	var count_compare = $('.compare-top-box-desc').length;
	$('.compare-top-box-desc').each(function (i) {
		var height_cur = $('.heightCompare' + i).height();
		var height_img_cur = $('.heightCompareImg' + i).height();
		if (height_cur > max_height) {
			max_height = height_cur;
		} else {
			max_height = max_height;
		}

		if (height_img_cur > max_height_img) {
			max_height_img = height_img_cur;
		} else {
			max_height_img = max_height_img;
		}

	});
	$('.compare-top-box-desc').find('.find-store').css({
		height: max_height + 'px'
	});
	$('.compare-top-box-desc').find('.compare-image').css({
		height: max_height_img + 'px'
	});
</script>	

<div class="information" attr_url="<?php echo $url;?>" attr_id="<?php echo $list_item;?>"></div>
<div id="content">
	<div class="content-compare">
		<div class="container">
			<h1 class="text-center">
				<?php _e('Compare',HATT_TEXTDOMAIN); ?>
						</h1>

			

			<div class="compare-top">
				<div class="flex-wrap">
				<?php 
					//create compare ids for RFQ
					$tyreids = "";
					// print_r($data);
					foreach ($data as $key => $val){
						$tyreids .= $val.",";
					}
					$tyreids= rtrim($tyreids, ",");
					// print_r($tyreids);
				?>
				<?php foreach ($data as $key => $val): ?>



					<div class="col-xs-4 compare-top-box have_tyre <?php echo 'compare_box_id_' . $val;?>">

						<div class="compare-top-box-desc">
							<div class="compare-image heightCompareImg<?php echo $key+1; ?>" style="height: 400px;">
								
								<div class="visible-xs">
									<div attr_id="<?php echo esc_attr($val);?>" class="compare-close">REMOVE</div>

									<div class="<?php echo 'tyre_title_id_' . $val;?>">
										<div class="if-have-tyre tyre-compare-container">										
											<h4 class="tyre-compare-title"><?php echo get_the_title($val); ?></h4>
										</div>
									</div>
								</div>

								<div class="compare-image-thumbnail">
									<div class="compare-image-thumbnail-wrapper">
									<?php
										if (has_post_thumbnail($val)) {
											echo get_the_post_thumbnail($val, 'full', array('class' => 'img-responsive'));
										}
									?>
									</div>
									<!-- <div class="find-store-toggle-arrow visible-xs"></div> -->
								</div>
								<div class="find-store heightCompare<?php echo $key+1; ?> clearfix">
									<div class="if-no-tyre">
										<h2 class="text-center"><?php _e('You can compare up to 3 tyres at a time',HATT_TEXTDOMAIN); ?>
										</h2>
										<a href="<?php echo $url_fix; ?>" class="return-url btn-find-store btn-add-tyre"><?php _e('ADD A TYRE',HATT_TEXTDOMAIN); ?></a>


									</div>

									<div class="if-have-tyre text-center ">
										<h2 class="tyre-title"><?php echo get_the_title($val); ?></h2>

<?php if(SITE_LOCALE=='in' || SITE_LOCALE=='ph' || SITE_LOCALE=='my' ){  
	//for RFQ countries only ?>

	<?php 

	// show the 2 buttons in the middle box
	if($key == 1) {
		?>

		<div class="row hidden-xs hidden-sm">
		<div class="col-md-12">
			<p class="btn-find">
				<a class="btn-find-store text-deco-none" href="<?php echo home_url(); ?>/store"><?php _e( 'Find a store', HATT_TEXTDOMAIN );  ?></a>
				<a class="btn-find-store text-deco-none" href="<?php echo home_url(); ?>/request-for-quote-form?item=<?php echo $tyreids; ?>"><?php _e( 'Request for quote', HATT_TEXTDOMAIN );  ?></a>
			</p>
		</div>
		</div>

		<?php
	}

	?>

	<?php
}else {
	?>	

	<a href="<?php echo ht_get_url_find_store(false,$val); ?>" class="btn-find-store hidden-xs">
		<?php _e('Find a Store',HATT_TEXTDOMAIN); ?>
	</a>

<?php } ?>							
										

										



									</div>
								</div>
							</div>
							<div class="text-center tyre-desc container-fluid hidden-xs">
								<br/><?php echo do_shortcode(get_post_meta($val, 'ht_tyre_information', true));?>
							</div>
							<img attr_id="<?php echo esc_attr($val);?>" class="compare-close hidden-xs" src="<?php echo esc_url(get_template_directory_uri()) . '/images/store-main-close.png';?>">
						</div>
					</div>
					<?php
					if (count($data) < 3 && count($data) == $key + 1) :
					?>
						<div class="col-xs-4 compare-top-box <?php echo 'compare_box_id_' . $val;?>">
							<div class="compare-top-box-desc">
								<div class="compare-image" style="height: 400px;">
									<div class="visible-xs">
										<a href="<?php echo $url_fix; ?>" class="return-url btn-find-store btn-add-tyre text-center" style="margin:-10px 5px !important; padding: 10px 0 7px 20px !important;"><?php _e('ADD A TYRE',HATT_TEXTDOMAIN); ?></a>
										<div class="compare-close compare-empty">&nbsp;</div>
									</div>

									<div class="compare-image-thumbnail">
										<div class="compare-image-thumbnail-wrapper"></div>
										<!-- <div class="find-store-toggle-arrow visible-xs"></div> -->
									</div>
									<div class="find-store clearfix">
										<h2 class="text-center">
											<?php _e('You can compare up to 3 tyres at a time',HATT_TEXTDOMAIN); ?>
										</h2>
										<div class="hidden-xs">
											<a href="<?php echo $url_fix; ?>" class="btn-find-store btn-add-tyre">
												<?php _e('ADD A TYRE',HATT_TEXTDOMAIN); ?>
												</a>
										</div>
									</div>
								</div>
								<div class="text-center container-fluid  hidden-xs"></div>
							</div>
						</div>
					<?php
					endif;
					?>
				<?php endforeach; ?>
				</div>
			</div>

			<!-- end compare-top -->
			<div class="box-colspace">
				<h2 class="title box-open"><a style="text-transform: uppercase!important;" href="#">
					<?php _e('Weather conditions and Features',HATT_TEXTDOMAIN); ?>
					</a></h2>
				<div class="box-colspace-content clearfix" style="display: none;">
					<div class="flex-wrap">
					<?php
						$has_ratings = false;
						foreach ($data as $key => $val):;?>
						<div class="col-xs-4 text-center compare-top-box <?php echo 'compare_box_id_' . $val;?>">
							<div class="row">
							
							<?php
							 	$ratings = get_post_meta( $val, 'ht_tyre_ratings',true );
							 	if( $ratings != '' ) $has_ratings = true;

								$terms_feature = wp_get_post_terms($val, 'tyres_feature');
								if (!empty($terms_feature) and is_array($terms_feature)) {
									foreach ($terms_feature as $k2 => $term_feature) {
										$img = get_tax_meta($term_feature, 'tyre_feature_image');
										if ($img) {
											echo '<div class="col-feature">';
											echo '<p class="hidden-xs"><img style="padding-right: 10px;" src="' . esc_attr($img['url']) . '"></br>' . $term_feature->name . '</p>';					
											echo '</div>';
											echo '<p class="visible-xs"><img style="padding-right: 10px;" src="' . esc_attr($img['url']) . '"></br>'. $term_feature->name . '</p>';		
										}
									}
								}else{
										echo 'N/A';
								};?>
							</div> <!-- .row -->
						</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		
			<?php if( $has_ratings ) :?>
			<!-- end compare-top -->
			<div class="box-colspace visible-xs">
				<h2 class="title box-open"><a style="text-transform: uppercase!important;" href="#">
					<?php _e('Performance Ratings',HATT_TEXTDOMAIN); ?>*
					</a></h2>
				<div class="box-colspace-content clearfix" style="display: none;">

		  		    <?php  
		  		    	$features_score = array();

		  		     	foreach ($data as $key => $val){
	                        $ratings = get_post_meta( $val, 'ht_tyre_ratings',true );
	                        $features = explode(PHP_EOL,  trim($ratings) );

	                        foreach ($features as $key => $feature) {
	                           	list($feature_label, $feature_score)  = explode(':', $feature);

	                           	if( trim($feature_label) != '' )
	                         		$features_score[trim($feature_label)][$val] = $feature_score;
	                        }
	                    }
                    ?>


					
					<?php foreach ($features_score as $feature => $scores): ;?>

							<div class="row">
								<div class="col-md-12 text-center" style="padding: 10px; background-color: #fd0; "> <?php echo $feature;?> </div>
							</div>

							<div class="flex-wrap">  
			
								<?php foreach ($scores as $tyre_id => $score) :?>
									<div class="text-center col-md-4 col-xs-4 col-sm-4  compare-top-box <?php echo 'compare_box_id_' . $tyre_id;?>">
										<?php echo $score;?> / 5 
									</div>
								<?php endforeach;?>

								<?php for( $i = count($scores); $i < 3; $i++): ?>
									<div class="text-center col-md-4 col-xs-4 col-sm-4  compare-top-box">
										-
									</div> 

								<?php endfor ?>
					
							</div>

					<?php endforeach;?>

				</div>
			</div>

            <!-- end compare-top -->
            <div class="box-colspace hidden-xs">
                <h2 class="title box-open"><a style="text-transform: uppercase!important;" href="#">
                    <?php _e('Performance Ratings',HATT_TEXTDOMAIN); ?>*
                    </a></h2>
                <div class="box-colspace-content clearfix" style="display: none;">
                      <div class="flex-wrap">  

                    
                    <?php foreach ($data as $key => $val): ;?>
                        <div class="col-xs-4  compare-top-box <?php echo 'compare_box_id_' . $val;?>">


                            <?php  
                                $ratings = get_post_meta( $val, 'ht_tyre_ratings',true );
                                $features = explode(PHP_EOL,  trim($ratings) );
                                
                                foreach ($features as $key => $feature) :
                        
                                    list($feature_label, $feature_score)  = explode(':', $feature);

                                	if($ratings != ''):
                            ?>
                           
                                    <div class="row">
                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                                <?php echo $feature_label;?>
                                        </div>
                                        <div class="col-md-5 col-sm-12 col-xs-12">
                                               <?php echo do_shortcode('[usr '.trim($feature_score).' text="false"]'); ?>
                                        </div>
                                    </div>  
                    
                            <?php
                            		endif;
                            	 endforeach; 
                            ?>

                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        
        	<?php endif;?>

			




			<!-- end compare-top -->
			<div class="box-colspace">
				<h2 class="title box-open"><a style="text-transform: uppercase!important;" href="#">
					<?php _e('Available sizes',HATT_TEXTDOMAIN); ?>
				  </a></h2>
				<div class="box-colspace-content clearfix" style="display: none;">
				  <div class="flex-wrap">  
					<?php foreach ($data as $key => $val): ?>
						<div class="col-xs-4 text-center compare-top-box <?php echo 'compare_box_id_' . $val;?>">
						<?php 

							$spec = get_post_meta($val, 'ht_tyre_specifications', TRUE);

							echo  ( $spec ) ?  $spec : _e('No available data',HATT_TEXTDOMAIN) ;
 
						?>
						 </div>
					<?php endforeach;?>
				  </div>
				</div>
			</div>


<?php 
// for RFQ countries only
if(SITE_LOCALE=='in' || SITE_LOCALE=='ph' || SITE_LOCALE=='my'){   
?>
	
			
	<div class="row compare-blue-bar rfq-blue-bar">
		<div class="col-md-4 col-sm-12 col-xs-12 type-right">&nbsp;</div>
		<div class="col-md-4 col-sm-12 col-xs-12 type-right">
			<div class="row">
				<div class="col-lg-6  col-md-6 col-sm-6">
					<p class="btn-find">
						<a class="text-deco-none" href="<?php echo home_url(); ?>/store"><?php _e( 'Find a store', HATT_TEXTDOMAIN );  ?></a>
					</p>
				</div>
				<div class="col-lg-6  col-md-6 col-sm-6">
					<p class="btn-find">
						<a class="text-deco-none" href="<?php echo home_url(); ?>/request-for-quote-form?item=<?php echo $tyreids; ?>"><?php _e( 'Request for quote', HATT_TEXTDOMAIN );  ?></a>
					</p>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12 type-right">&nbsp;</div>
	</div>


<?php } else { ?>

	<div class="row compare-blue-bar visible-xs">
		<div class="col-md-4 col-sm-12 col-xs-12 type-right">&nbsp;</div>
		<div class="col-md-4 col-sm-12 col-xs-12 type-right">
			<div class="row">

				<div class="col-md-12">
					<p class="btn-find">
						<a href="<?php echo home_url(); ?>/store" class="btn-find-store">
							 <?php _e('Find a store',HATT_TEXTDOMAIN); ?>
						  </a>
					</p>
				</div>
			</div>
		</div>
	</div>

<?php } ?>



		<?php endif; ?>


		<?php 
		if($has_ratings != '') :
		?>
		<div class="prating-disclaimer" style="display: block;">
		    <div class="row">
		    <div class="col-xs-12">
		        <p>*This rating tool provides rating of parameters which are determined through generic profiling and internal assessments done by David Tyre Company India Limited (GIL) Associates.</p>
		         
		        <p>The ratings are merely directional and the tool is developed with the objective of aiding the customers/consumers in making an informed choice / decision and the same shall not be construed to be an expert’s advice.</p>
		         
		        <p>The performance of the tyre may vary from the rating provided on the website as the same is dependent on various variables associated with the car. David Tyre Company India Limited (GIL) and any of its affiliates etc. shall not be responsible for any such difference or variation in the performance etc. of the tyre.</p>
		         
		        <p>For any customized advise, specific to the car, please contact the nearest David Tyre Company Authorized Dealer.</p>
		    </div>
		    </div>
		</div>
		<?php endif; ?>



	</div>
</div>
