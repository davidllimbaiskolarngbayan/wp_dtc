<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 4/16/2015
 * Time: 1:51 PM
 */
global $page_size;

$argv = array(
    'post_type' => 'tyres',
    'posts_per_page' => -1
);


//param order names must be the same as the url get variable
$param_order = array('brand','product_year','model');	

if( SITE_LOCALE == "cn" ){
	$param_order = array('brand','car_maker','product_year','model');	
}

if( SITE_LOCALE == "kr" || SITE_LOCALE == "in"){
	$param_order = array('brand','model');	
}

if( SITE_LOCALE == "in" ){
	$param_order = array('brand','model','variant','product_year');	
}

$href_params = array('type'=>'vehicle');

foreach($param_order as $val) {
	$href_params[$val] = "";
}


/*$argv['tax_query'][] = array(
    'taxonomy' => 'vehicles_cat',
    'field'=>'ID',
    'terms' => ${end($param_order)}
);*/



?>


<h1>
	<?php _e('Here are our recommendations',HATT_TEXTDOMAIN); ?>
	</h1>
<div class="ht_find_vehicle">
    <!--<h2 class="hidden-xs">

  	<?php foreach($param_order as $key => $val)  : ?>

  		<span attr_id="<?php echo $$val ; ?>" class="<?php echo $val;?>"><?php echo ${$val.'_name'} ?></span> 

  		<?php echo ( end($param_order) != $val ) ? '<span class="selected">/</span>' : '';?>
  		
  	<?php endforeach;?>

       
    </h2>-->
    <div class="type-box type-box-filter visible-xs">

	  	<?php 
		  	$permalink = get_permalink(get_the_ID());

		  	foreach($param_order as $key => $val)  : 
		  		$href_params[$val] =  $$val;
	  	?>

	        <div class="find-type-filter-bar active">
	            <a href="<?php echo "{$permalink}?".http_build_query($href_params); ?>"><?php echo  ${$val.'_name'}; ?></a>
	        </div>

	  		<?php echo ( end($param_order) != $val ) ? '<span class="selected hidden-xs">/</span>' : '';?>

	  	<?php endforeach;?>


    </div>
</div>
<?php
	if ( !empty( $_GET['category']) && $_GET['category'] != 'all'  ) {
		$category             = $_GET['category'];
		$argv['tax_query'][] = array(
			'taxonomy' => 'tyres_cat',
			'field' => 'slug',
			'terms'    => explode( ',', $category )
		);
	}
	
?>
<div class="row recommendation_detail text-left">
	<div class="col-sm-12">
		<div role="tabpanel">
			<div class="tab-content">
				<div>
					<?php
						$query = new WP_Query( $argv );

						if ( $query->have_posts() ):
							 $page_size = true;
							while ( $query->have_posts() ):
								$query->the_post();
								echo Hatt()->load_template( 'tyres/rfq-gird', FALSE );
							endwhile;
							wp_reset_postdata();
						else: ?>
							<p class="text-center text-uppercase">
                                <?php 
                                if(SITE_LOCALE=="in"){
                                    _e('Oops ! At present , we do not have tires available for fitment in India.',HATT_TEXTDOMAIN);
                                }
                                else{
                                    _e('No results found',HATT_TEXTDOMAIN);    
                                }
                                ?>								
							</p>
						<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
<div class="col-md-10 col-sm-12 col-xs-12 type-right">&nbsp;</div>
<div class="col-md-2 col-sm-12 col-xs-12 type-right">
<p class="btn-find ">
	<a class="text-deco-none" href="<?php echo home_url(); ?>/request-for-quote">
		<?php _e( 'Continue', HATT_TEXTDOMAIN );  ?>
	</a>
</p>
</div>
</div>
<?php //echo hatt()->load_template('tyres/box', 'compare'); ?>
