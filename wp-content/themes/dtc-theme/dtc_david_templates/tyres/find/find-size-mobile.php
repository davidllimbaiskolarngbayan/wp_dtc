<?php
    /**
     * Created by PhpStorm.
     * User: x
     * Date: 5/22/2015
     * Time: 2:57 PM
     */
    $ht_size_width = $ht_size_ratio = $ht_size_diameter = $all_sizes = $all_sizes_first = $all_sizes_second =        $disable_width = $disable_ratio = $disable_diameter='';
    '';

    $ht_size_width_base = __('FIRST NUMBER',HATT_TEXTDOMAIN);
    $ht_size_ratio_base = __('SECOND NUMBER',HATT_TEXTDOMAIN);
    $ht_size_diameter_base = __('THIRD NUMBER',HATT_TEXTDOMAIN);

    global $wpdb;
    $all_sizes = $wpdb->get_results("SELECT * FROM " . $wpdb->postmeta . " where meta_key = 'ht_size_width' ORDER BY meta_value ASC");

    if (isset($_GET)) {
        if (isset($_GET['first_number']) and !empty($_GET['first_number'])) {

            $ht_size_width =$ht_size_width_base =$_GET['first_number'];
            $all_sizes_first = $wpdb->get_results($wpdb->prepare("SELECT
	*
FROM
	" . $wpdb->postmeta . "
INNER JOIN " . $wpdb->postmeta . " hatt_meta2 ON hatt_meta2.post_id = " . $wpdb->postmeta . ".post_id
AND hatt_meta2.meta_key = 'ht_size_ratio'
WHERE " . $wpdb->postmeta . ".meta_key = 'ht_size_width'
AND " . $wpdb->postmeta . ".meta_value = %d",
                $ht_size_width . " ORDER BY meta_value ASC"));

            if (isset($_GET['second_number']) and !empty($_GET['second_number'])) {
                $ht_size_ratio =$ht_size_ratio_base = $_GET['second_number'];
                $all_sizes_second = $wpdb->get_results($wpdb->prepare("SELECT
	*
FROM
	" . $wpdb->postmeta . "
INNER JOIN " . $wpdb->postmeta . " hatt_meta2 ON hatt_meta2.post_id = " . $wpdb->postmeta . ".post_id
AND hatt_meta2.meta_key = 'ht_size_ratio'
AND hatt_meta2.meta_value = %d
INNER JOIN " . $wpdb->postmeta . " hatt_meta3 ON hatt_meta3.post_id = " . $wpdb->postmeta . ".post_id
AND hatt_meta3.meta_key = 'ht_size_diameter'
WHERE
	" . $wpdb->postmeta . ".meta_key = 'ht_size_width'
	AND " . $wpdb->postmeta . ".meta_value = %d", $ht_size_ratio, $ht_size_width . " ORDER BY meta_value ASC"));

                if (isset($_GET['third_number']) and $_GET['third_number']) {
                    $ht_size_diameter = $_GET['third_number'];

                    echo hatt()->load_template('tyres/find/find', 'recommendation-size', array(
                        'first_number'  => $ht_size_width,
                        'second_number' => $ht_size_ratio,
                        'third_number'  => $ht_size_diameter,
                        'all_sizes'     => $all_sizes
                    ));

                    return;
                }
            }
        }

//		if ( $ht_size_width !== 'FIRST NUMBER' and $ht_size_ratio !== 'SECOND NUMBER' and $ht_size_diameter == 'THIRD NUMBER' ) {
//			echo hatt()->load_template( 'tyres/find/find', 'recommendation-size', array(
//				'ht_size_width'    => $ht_size_width,
//				'ht_size_ratio'    => $ht_size_ratio,
//				'ht_size_diameter' => $ht_size_diameter,
//				'all_sizes'        => $all_sizes
//			) );
//
//			return;
//		}

    }
    if (empty($all_sizes)){
        $disable_width ='ht_disable';
    }
    if (empty($all_sizes_first)){
        $disable_ratio = 'ht_disable';
    }
    if (empty($all_sizes_second)){
        $disable_diameter='ht_disable';
    }

?>
<div class="find-vehicle-mobile">
    <div class="box-colspace">
        <h2 class="title <?php echo esc_attr($disable_width); ?> box-close "><a
                href="#"><?php echo esc_attr($ht_size_width_base); ?></a></h2>

        <div class="box-colspace-content clearfix" style="display: none;">
            <?php
                $checkshow = array();
                if (!empty($all_sizes)):
                    $key = 0;
                    foreach ($all_sizes as $val):
                        if (!in_array($val->meta_value, $checkshow)):
                            $checkshow[] = $val->meta_value;
                            $attr = '';
                            if (isset($_GET['first_number']) and !empty($_GET['first_number'])) {
                                $ht_size_width = $_GET['first_number'];
                                $attr = 'first_number="' . $_GET['first_number'] . '" second_number="" third_number=""';
                            } else {
                                $attr = 'first_number="' . $val->meta_value . '" second_number="" third_number=""';
                            };?>
                            <div <?php echo $attr; ?> class="col-sm-2 item item-size <?php echo  $ht_size_width==$val->meta_value?'active':'';?>">
                                <p><?php echo esc_attr($val->meta_value);?></p>
                            </div>
                            <?php
                            $key++
                            ?>
                        <?php endif;?>
                    <?php endforeach;
                endif;
            ?>
        </div>
    </div>

    <div class="box-colspace">
        <h2 class="title <?php echo esc_attr($disable_ratio); ?> box-close "><a
                href="#"><?php echo esc_attr($ht_size_ratio_base); ?></a></h2>

        <div class="box-colspace-content clearfix" style="display: none;">
            <?php
                $checkshow_second = array();
                if (!empty($all_sizes_first)):
                    $key = 0;
                    foreach ($all_sizes_first as $val_second):
                        if (!in_array($val_second->meta_value, $checkshow_second)):
                            $checkshow_second[] = $val_second->meta_value;
                            $attr = '';
                            if (isset($_GET['second_number']) and !empty($_GET['second_number']) and isset($_GET['first_number']) and !empty($_GET['first_number'])) {
                                $ht_size_ratio = $_GET['second_number'];
                                $attr = 'first_number="' . $_GET['first_number'] . '" second_number="'.$_GET['second_number'].'" third_number=""';
                            } else {
                                $attr = 'first_number="' . $_GET['first_number'] . '" second_number="'.$val_second->meta_value.'" third_number=""';
                            };?>
                            <div <?php echo $attr; ?> class="col-sm-2 item item-size <?php echo  $ht_size_ratio==$val_second->meta_value?'active':'';?>">
                                <p><?php echo esc_attr($val_second->meta_value);?></p>
                            </div>
                            <?php
                            $key++
                            ?>
                        <?php endif;?>
                    <?php endforeach;
                endif;
            ?>
        </div>
    </div>
    <div class="box-colspace">
        <h2 class="title <?php echo esc_attr($disable_diameter); ?> box-close "><a
                href="#"><?php echo esc_attr($ht_size_diameter_base); ?></a></h2>

        <div class="box-colspace-content clearfix" style="display: none;">
            <?php
                $checkshow_third = array();
                if (!empty($all_sizes_second)):
                    $key = 0;
                    foreach ($all_sizes_second as $val_third):
                        if (!in_array($val_third->meta_value, $checkshow_third)):
                            $checkshow_third[] = $val_third->meta_value;
                            $attr = '';
                            if (isset($_GET['second_number']) and !empty($_GET['second_number']) and isset($_GET['first_number']) and !empty($_GET['first_number']) and  isset($_GET['third_number']) and !empty($_GET['third_number'])){
                                $ht_size_diameter = $_GET['third_number'];
                                $attr = 'first_number="' . $_GET['first_number'] . '" second_number="'.$_GET['second_number'].'" third_number="'.$_GET['third_number'].'"';
                            } else {
                                $attr = 'first_number="' . $_GET['first_number'] . '" second_number="'.$_GET['second_number'].'" third_number="'.$val_third->meta_value.'"';
                            };?>
                            <div <?php echo $attr; ?> class="col-sm-2 item item-size <?php echo  $ht_size_diameter==$val_third->meta_value?'active':'';?>">
                                <p><?php echo esc_attr($val_third->meta_value);?></p>
                            </div>
                            <?php
                            $key++
                            ?>
                        <?php endif;?>
                    <?php endforeach;
                endif;
            ?>
        </div>
    </div>
</div>