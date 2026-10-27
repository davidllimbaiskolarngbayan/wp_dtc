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

	$is_rof = (get_post_meta(get_the_ID(), 'ht_tyre_rof', true)=='on')? 'on':'off';

	//prepare OE tyre data
	$data_oesize = '';
	$is_oetyre = 0;
	if(isset($ajax_oe_param) && !empty($ajax_oe_param['combi'])){
		$oetyres = get_post_meta(get_the_ID(), 'ht_select_oetyre_combi');
		foreach((array)$oetyres as $oetyre){
			list($oev,$oes) = explode('_',$oetyre);
			if($oev==$ajax_oe_param['vehicle'] && $oes==$ajax_oe_param['size']){
				//$data_oesize .= '|'.$oes;  //skip this as we use AJAX to assign item to OEbox instead of use js
				$is_oetyre = 1;
			}
		}
		$data_oesize .= '|';
	}

?>
	<div class="row type-box"  data-cat-filter="<?php echo $data_filter; ?> " data-rof="<?php echo $is_rof; ?>" data-isoe="<?php echo $is_oetyre; ?>" data-oe-size="<?php echo $data_oesize; ?>">
		<div class="col-md-3 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-4 col-xs-5 text-center tyre_thumbail">
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo esc_url($permalink) ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( array(200, 200)); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="col-sm-8 col-xs-7 hidden-md hidden-lg text-left">
					<h4 class="grid-tyre-title"><a class="text-deco-none" href="<?php echo esc_url($permalink)?>"><?php the_title(); ?></a></h4>
				</div>
			</div>
		</div>
		<div class="col-md-9 text-left ">
			<h4 class="hidden-xs hidden-sm grid-tyre-title">
				<a class="text-deco-none" href="<?php echo esc_url($permalink)?>"><?php the_title(); ?></a>
			</h4>
			<p>
				<?php echo get_the_excerpt(); ?>&nbsp;&nbsp;  
				<a href="<?php echo esc_url($permalink) ?>" class="more-detail">
				<?php _e( 'More details', HATT_TEXTDOMAIN ); ?>
				</a>
			</p>

			<div class="check">
				<input type="checkbox" class="rfq-item">
				<?php 


					$id = get_the_ID(); 
					if($id == $_GET['rfq_req_tyre'] || $id == $_GET['compare_item_return'] || $id == $_REQUEST['tyre_compare']  ){
						add_tyre_on_list( get_the_title($id) ,$id);
					}
				?>
				<label attr_thumb="<?php echo wp_get_attachment_thumb_url( get_post_thumbnail_id( get_the_ID() ) ); ?>"  attr_title="<?php the_title() ?>" attr_id="<?php the_ID(); ?>" class="input_checkbox" <?php echo checkifselected($id,1); ?>>
				<div class="<?php echo 'button_compare_' . get_the_ID(); ?> <?php echo checkifselected($id,2); ?>"></div>
				<?php echo _e( 'Select', HATT_TEXTDOMAIN ); ?></label>

			</div>

			<?php if($is_rof=='on'): ?>
				<span class="rof-logo">
					<div><?php _e( 'Also available in:', HATT_TEXTDOMAIN ); ?></div>
<?php 
	$rofImageUrl='/images/tyres/run_on_flat_logo.png';
	if(SITE_LOCALE == "cn") { $rofImageUrl='/images/tyres/run_on_flat_logo_cn.png'; }
?>
<?php if(SITE_LOCALE == "cn") { ?>
	<a href="<?php echo home_url('/learn/dtc-innovation#rof'); ?>" target="_blank">
<?php } ?>
								<img src="<?php echo esc_url( get_template_directory_uri() ) . $rofImageUrl ; ?>" alt="" />
<?php if(SITE_LOCALE == "cn") { ?>
						</a>
<?php } ?>
				</span>
			<?php endif;?>

			
		</div>
	</div>

