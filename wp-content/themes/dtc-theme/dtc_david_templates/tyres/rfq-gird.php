<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/8/2015
	 * Time: 1:58 PM
	 */ ?>
<?php
    global $page_size ;
    if($page_size){
        $permalink = add_query_arg(array('checksize'=>1),get_the_permalink());
    }else{
        $permalink = get_the_permalink();
    }

	$data_filter = '';
	if(isset($load_cat) && $load_cat === TRUE){
		$postterms = get_the_terms( $post->ID, 'tyres_cat' );
		foreach($postterms as $term){
			$data_filter .= '|category_'.$term->term_id;
		}
		$data_filter .= '|';
	}
?>
<div class="type-box" data-cat-filter="<?php echo $data_filter; ?>">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row tyre-first-row">
				<div class="col-xs-5 col-sm-4 tyre_thumbail">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo esc_url($permalink) ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('medium'); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class=" col-xs-7 col-sm-8 tyre_title">
					<h4><a class="text-deco-none" href="<?php echo esc_url($permalink)?>"><?php the_title(); ?></a></h4>
					<p class="hidden-xs">
						<?php echo get_the_excerpt(); ?>&nbsp;&nbsp;  
						<a href="<?php echo esc_url($permalink) ?>" class="more-detail">
						<?php _e( 'More details', HATT_TEXTDOMAIN ); ?>
						</a>
					</p>
					<div class="icon-box hidden-xs">
						<?php //echo ht_get_image_terms( 'tyres_feature', 'tyre_feature_image', FALSE ); ?>
						<div class="check">
							<input type="checkbox" class="rfq-item">
							<?php 
								$id = get_the_ID();
								$c1 = checkifselected($id,1);
								$c2 = checkifselected($id,2); 
								
								if(empty($c1)){
									if($id==$_GET['rfq_req_tyre']){
										$c1 = "checked='checked'";
									}
								}
								
								if(empty($c2) or $c2=="uncheck"){
									if($id==$_GET['rfq_req_tyre']){
										$c2 = "checked";
									}
								}
								
								$tyre_title = get_the_title($id);
								if(!empty($c1) and $c2=="checked"){
									add_tyre_on_list($tyre_title,$id);
								}
							?>
							
							<label attr_thumb="<?php echo wp_get_attachment_thumb_url( get_post_thumbnail_id( get_the_ID() ) ); ?>"
								   attr_title="<?php the_title() ?>" attr_id="<?php the_ID(); ?>" class="input_checkbox" <?php echo $c1; ?>>
								<div class="<?php echo 'button_compare_' . get_the_ID(); ?> <?php echo $c2; ?>"></div>
								<?php echo _e( 'Select', HATT_TEXTDOMAIN ); ?></label>
								<!--<div class="compare-warning"><?php echo _e( 'You can compare up to 3 tyres at a time', HATT_TEXTDOMAIN ); ?></div>-->
						</div>
					</div>
				</div>
			</div>
			<div class="row">
            <div class="col-xs-12 visible-xs">
             	<p>
             		<?php echo get_the_excerpt(); ?>&nbsp;&nbsp;  
             		<a href="<?php echo esc_url($permalink) ?>" class="more-detail">
                         <?php _e( 'More details', HATT_TEXTDOMAIN ); ?>
					</a>
                 </p>
             </div>
				<div class="line visible-sm visible-xs"></div>
			</div>
		</div>
	</div>
</div>
