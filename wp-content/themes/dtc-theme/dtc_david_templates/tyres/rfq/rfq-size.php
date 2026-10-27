<?php
//FIRST NUMBER / SECOND NUMBER / THIRD NUMBER
$ht_size_width = $ht_size_ratio = $ht_size_diameter = '';

$ht_size_width_base = __('FIRST NUMBER',HATT_TEXTDOMAIN);
$ht_size_ratio_base = __('SECOND NUMBER',HATT_TEXTDOMAIN);
$ht_size_diameter_base = __('THIRD NUMBER',HATT_TEXTDOMAIN);
$ht_size_load_index = __('Load Index',HATT_TEXTDOMAIN);
$ht_size_speed_index = __('Speed Index',HATT_TEXTDOMAIN);
$ht_size_optional = __('Optional',HATT_TEXTDOMAIN);

//Prepare dropdown lists (for 1st number)
global $wpdb;
$query = "SELECT pm.* FROM {$wpdb->postmeta} AS pm
          WHERE pm.meta_key = 'ht_size_width'
          GROUP BY pm.meta_value
          ORDER BY pm.meta_value * 1 ASC";
$size_options = $wpdb->get_results($query);
?>

<?php echo hatt()->load_template('tyres/rfq/rfq', 'header', array('data_header' => $data_header, 'content' => $content_header)); ?>

<p class="subdesc"><?php _e('Check your current tyres or your vehicle’s documentation for details about your tyres and enter them in the fields below.',HATT_TEXTDOMAIN); ?></p>

<div class="findtyre_canvas">
    <div id="findtyre_loading" class="preload" style="display: none">
        <div class="preload-tyre"></div>
        <img src="<?php echo esc_url( get_template_directory_uri() ) .'/images/logo-preload.png';?>" alt="" />
    </div>
    <div class="ht_find_vehicle">
        <input type="hidden" id="ajax-nonce" value="<?php echo wp_create_nonce( 'inno-tyrenonce' ); ?>" />
        <form id="vehform" class="veh_size_form">
            <div class="vehdd_size">
                <div class="sizefield">
                    <div>
                        <div class="sizebox_1">
                            <select name="veh_size_field_1" class="vehsize">
                                <option value=""><?php echo $ht_size_width_base; ?></option>
                                <?php
                                foreach ($size_options as $value) {
                                    echo '<option value="'.$value->meta_value.'" '.$selected.'>'.$value->meta_value.'</option>';
                                } ?>
                            </select>
                        </div>

                        <span class='vehslash'> / </span>

                        <div class="sizebox_2">
                            <select name="veh_size_field_2" class="vehsize">
                                <option value=""><?php echo $ht_size_ratio_base; ?></option>
                            </select>
                        </div>

                        <span class='vehslash'> / </span>

                        <div class="sizebox_3">
                            <select name="veh_size_field_3" class="vehsize">
                                <option value=""><?php echo $ht_size_diameter_base; ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="sizeoption">
                    <span><?php echo $ht_size_optional; ?></span>
                    <div>
                        <select name="veh_size_opt_load" class="vehsize vehsize_opt">
                            <option value=""><?php echo $ht_size_load_index; ?></option>
                        </select>

                        <select name="veh_size_opt_speed" class="vehsize vehsize_opt">
                            <option value=""><?php echo $ht_size_speed_index; ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <div class="findtyre_sizeimg">
            <div class="box_left">
                <img id="sizeimg_left" src="<?php echo esc_url( get_template_directory_uri() ) . '/images/tyres/size_left-1.png'; ?>" alt="" />
            </div>
            <div class="box_right">
                <img id="sizeimg_right" src="<?php echo esc_url( get_template_directory_uri() ) . '/images/tyres/size_right-1.png'; ?>" alt="" />
            </div>
            <div class="img_or">
                <img src="<?php echo esc_url( get_template_directory_uri() ) . '/images/tyres/size-or.png'; ?>" alt="" />
            </div>
        </div>
    </div>
    <div id="findtyre_output"></div>
</div>

<?php
if(isset($_GET['compare_item_return']) && !empty($_GET['compare_item_return']) && isset($_COOKIE['findtyre']) && $_COOKIE['findtyre'] == 'size') {
    if(!empty($_COOKIE['ftsize']['size1']) && !empty($_COOKIE['ftsize']['size2']) && !empty($_COOKIE['ftsize']['size3'])){
?>
<div id="preload_findtyre" data-type="size"></div>
<?php
    }
}
?>