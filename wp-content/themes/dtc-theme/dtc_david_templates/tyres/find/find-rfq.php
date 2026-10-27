<?php
	//default labels
	$labels = array(
					'brand' 	=> __('Brand',HATT_TEXTDOMAIN),
					'model' 	=> __('Model',HATT_TEXTDOMAIN),
					'car_maker' => __('Car Maker',HATT_TEXTDOMAIN),
					'product_year' => __('Product Year',HATT_TEXTDOMAIN),
                    'variant' => __('Variant',HATT_TEXTDOMAIN)
				);

	//param order names must be the same as the url get variable
	$param_order = array('brand','product_year','model');

	if( SITE_LOCALE == "cn" ){
		$param_order = array('brand','car_maker','product_year','model');
	}

    if( SITE_LOCALE == "kr" ){
        $param_order = array('brand','model');
    }

    if( SITE_LOCALE == "in" ){
        $param_order = array('brand','model','variant','product_year');
    }

    if( SITE_LOCALE == "my" ){
        $param_order = array('brand','model','variant','product_year'); 
    }

    //determine total dropdown list (category type)
    $total_cat_type = sizeof($param_order);

    //Prepare dropdown lists
    $cat_options = array();
    $cat_selected_value = array();

    foreach ($param_order as $key => $value) {

        $sort_order  = ($value == 'product_year' ) ? 'DESC' : 'ASC';
        $order_by    = ($value == 'product_year' ) ? 'name' : 'slug';

        if($key == 0){
            //get parent option (1st dropdown)
            $cat_options[$key] = get_terms( 'vehicles_cat', array( 'parent' => 0, 'hide_empty' => 0, 'orderby' => $order_by, 'order' => $sort_order ) );
        }
    }
?>

<?php echo hatt()->load_template('tyres/header', false, array('data_header' => $data_header, 'content' => $content_header)); ?>

<p class="subdesc"><?php _e('Find the size of tyres that originally came with your car by selecting the manufacturer and model.',HATT_TEXTDOMAIN); ?></p>
<div class="findtyre_canvas">
    <div id="findtyre_loading" class="preload" style="display: none">
        <div class="preload-tyre"></div>
        <img src="<?php echo esc_url( get_template_directory_uri() ) .'/images/logo-preload.png';?>" alt="" />
    </div>
    <div class="ht_find_vehicle">
        <input type="hidden" id="ajax-nonce" value="<?php echo wp_create_nonce( 'inno-tyrenonce' ); ?>" />
        <div class="vehdd_vehicle">
            <form id="vehform">
                    <?php
                    reset($param_order);
                    foreach ($param_order as $key => $value) {
                        $has_optgroup = ($value == 'brand' ) ? 1 : 0;
                        $is_end = (end($param_order) == $value)? 1:0;
                        ?>
                        <select name="veh_cat[<?php echo $key; ?>]" class="vehcat-rfq" data-no="<?php echo $key; ?>" data-label="<?php echo $value; ?>" data-end="<?php echo $is_end; ?>">
                            <option value=""><?php echo $labels[$value]; ?></option>
                            <?php
                            if(!empty($cat_options[$key])){
                                $optgroup = '';
                                foreach($cat_options[$key] as $cat_value){
                                    echo $starter = substr($cat_value->slug,0,1);

                                    if($has_optgroup==1 && $optgroup!='' && $optgroup!=$starter){
                                        echo '</optgroup>';
                                    }
                                    if($has_optgroup==1 && $optgroup!=$starter){
                                        echo '<optgroup label="'.strtoupper($starter).'">';
                                        $optgroup = $starter;
                                    }

                                    $selected = ($cat_selected_value[$key]==$cat_value->term_id)? 'selected':'';

                                    echo '<option value="'.$cat_value->term_id.'" '.$selected.'>'.$cat_value->name.'</option>';

                                }
                                if($has_optgroup==1 && $optgroup!=''){
                                    echo '</optgroup>';
                                }
                            }
                            ?>
                        </select>
                        <?php
                        //get lastkey - remove trailing slash
                        echo ( end($param_order) != $value ) ?  "<span class='vehslash'> / </span>" : " ";
                    }
                    ?>
                </form>
        </div>

    </div>
    <div id="findtyre_output"></div>
	<div id="findtyre-rfq-initial">
		<?php if(isset($_GET['rfq']) and $_GET['rfq']=="true"){ ?>
			<?php echo hatt()->load_template('tyres/find/rfq-find-recommendation', false, array('data_header' => $data_header, 'content' => $content_header)); ?>
		<?php } ?>
	</div>
</div>
<?php
if(isset($_GET['compare_item_return']) && !empty($_GET['compare_item_return']) && isset($_COOKIE['findtyre']) && $_COOKIE['findtyre'] == 'vehicle') { ?>
    <div id="preload_findtyre" data-type="vehicle"></div>
<?php } ?>