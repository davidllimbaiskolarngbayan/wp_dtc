<?php
    /**
     * Created by PhpStorm.
     * User: x
     * Date: 5/22/2015
     * Time: 2:57 PM
     */
    $brand = $model = $product_year = $get_tax_vehicle_product_year = $get_tax_vehicle_model = '';

    $get_tax_vehicle_brand = get_terms('vehicles_cat', array('parent' => 0, 'hide_empty' => 0));

    if (isset($_GET)) {
        if (isset($_GET['brand']) and !empty($_GET['brand'])) {
            $get_tax_vehicle_product_year = get_terms('vehicles_cat', array('parent' => $_GET['brand'], 'hide_empty' => 0));
            $brand = $_GET['brand'];
            if (isset($_GET['product_year']) and !empty($_GET['product_year'])) {
                $get_tax_vehicle_model = get_terms('vehicles_cat', array('parent' => $_GET['product_year'], 'hide_empty' => 0));
                $product_year = $_GET['product_year'];
                if (isset($_GET['model']) and $_GET['model']) {
                    $model = $_GET['model'];
                }
            }
        }

        $brand_name = get_term($brand, 'vehicles_cat');
        $disable_brand = $disable_model = $disable_year='';
        if (!is_wp_error($brand_name)) {
            $brand_name = $brand_name->name;
            $disable_brand='';
        } else {
            $disable_brand = 'ht_disable';
            $brand_name = __('Brand',HATT_TEXTDOMAIN);
        }
        $model_name = get_term($model, 'vehicles_cat');
        if (!is_wp_error($model_name)) {
            $disable_model = '';
            $model_name = $model_name->name;
        } else {
            $disable_model = 'ht_disable';
            $model_name = __('Model',HATT_TEXTDOMAIN);
        }
        $product_year_str = get_term($product_year, 'vehicles_cat');

        if (!is_wp_error($product_year_str)) {
            $disable_year = '';
            $product_year_str = $product_year_str->name;
        } else {
            $disable_year = 'ht_disable';
            $product_year_str = __('Product Year',HATT_TEXTDOMAIN);
        }

        if ($brand and $model and $product_year) {

        echo hatt()->load_template('tyres/find/find', 'recommendation', array('brand'            => $brand,
                          'model'            => $model,
                          'product_year'     => $product_year,
                          'brand_name'       => $brand_name,
                          'model_name'       => $model_name,
                          'product_year_str' => $product_year_str
            ));

            return;
        }

    }
?>
<div class="find-vehicle-mobile">
    <div class="box-colspace">
        <h2 class="title <?php echo esc_attr($disable_brand);?> box-close "><a href="#"><?php echo esc_attr($brand_name); ?></a></h2>
        <div class="box-colspace-content clearfix" style="display: none;">
            <?php
                if (!is_wp_error($get_tax_vehicle_brand)):
                    $attr = '';
                    if (!empty($get_tax_vehicle_brand)):
                        foreach ($get_tax_vehicle_brand as $val):
                            $attr = 'brand="' . $val->term_id . '" model="" product_year=""'; ?>
                            <div <?php echo $attr;?> class="col-xs-12 item item-vehicle <?php echo  $brand==$val->term_id?'active':'';?>">
                                <p><?php echo esc_attr($val->name);?></p>
                            </div>
                        <?php endforeach;
                    endif;endif; ?>
        </div>
    </div>
    <div class="box-colspace">
        <h2 class="title <?php echo esc_attr($disable_year);?> box-close"><a href="#"><?php echo esc_attr($product_year_str); ?></a></h2>

        <div class="box-colspace-content clearfix" style="display: none;">
            <?php
                if (!empty($get_tax_vehicle_product_year)):
                    if (!is_wp_error($get_tax_vehicle_product_year)):
                        $attr_year = '';
                        foreach ($get_tax_vehicle_product_year as $val_year):
                            $attr_year = 'brand="' . $brand . '" model="" product_year="' . $val_year->term_id . '"'; ?>
                            <div <?php echo $attr_year;?> class="col-xs-12 item item-vehicle <?php echo  $product_year==$val_year->term_id?'active':'';?>">
                                <p><?php echo esc_attr($val_year->name);?></p>
                            </div>
                        <?php endforeach;
                    endif;endif; ?>
        </div>
    </div>
    <div class="box-colspace">
        <h2 class="title <?php echo esc_attr($disable_model);?> box-close"><a href="#"><?php echo esc_attr($model_name); ?></a></h2>

        <div class="box-colspace-content clearfix" style="display: none;">
            <?php
                if (!empty($get_tax_vehicle_model)):
                    if (!is_wp_error($get_tax_vehicle_model)):
                        $attr_model = '';
                        foreach ($get_tax_vehicle_model as $val_model):
                            $attr_model = 'brand="' . $brand . '" model="' . $val_model->term_id . '" product_year="' . $product_year . '"'; ?>
                            <div <?php echo $attr_model;?> class="col-xs-12 item item-vehicle <?php echo  $model==$val_model->term_id?'active':'';?>">
                                <p><?php echo esc_attr($val_model->name);?></p>
                            </div>
                        <?php endforeach;
                    endif;endif; ?>
        </div>
    </div>
</div>