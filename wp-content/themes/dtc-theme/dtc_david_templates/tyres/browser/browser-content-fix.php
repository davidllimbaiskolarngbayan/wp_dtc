<?php
    /**
     * Created by PhpStorm.
     * User: x
     * Date: 4/8/2015
     * Time: 12:27 AM
     */

    $class = '';
    $term = array();
    $html = '';
    $arg = array(
        'post_type'      => 'tyres',
        'posts_per_page' => 10,
        'paged'          => get_query_var('paged')
    );
    $checkall = FALSE;

    unset($_SESSION['rfq-vehicle-list'] );
    unset($_SESSION['rfq-last-selected-id'] );
    unset($_SESSION['items'] );

?>

<!-- Nav tabs -->
<div class="tab-content-fix tab-content">

    <?php
    $rof_on = 'off';
    $rof_checked = '';
    if(isset($_GET['rof']) && ($_GET['rof']=='on')){
        $rof_on = 'on';
        $rof_checked = 'checked';
    }
    ?>
    <div class="rof_box">
        <label><input name="filtertyre_rof" id="filtertyre_rof" type="checkbox" <?php echo $rof_checked; ?> /> <?php _e('Show only Run On Flat',HATT_TEXTDOMAIN); ?></label>
    </div><div></div>


    <?php


        $arg = array(
            'post_type'      => 'tyres',
            'posts_per_page' => -1,
            'tax_query' => array('relation' => 'AND')
        );

        if($rof_on=='on'){
            $arg['meta_query'][] = array(
                'key'     => 'ht_tyre_rof',
                'value'   => 'on',
                'compare' => 'IN'
            );
        }

        //default to first item
        $categories = get_terms( 'tyres_cat', array('orderby' => 'term_order') );
        $default_category =  $categories[0]->slug;
        // echo "defaul:".$categories[0]->slug;
        // echo "cat:".$_GET['category'];

        $query_category =  ( !empty($_GET['category']) ) ? $_GET['category'] : $default_category;

        $arg['tax_query'][] = array(
            'taxonomy' => 'tyres_cat',
            'field'    => 'slug',
            'terms'    => explode(',', $query_category),
        );

        if (isset($_GET['feature']) and !empty($_GET['feature'])) {
            $feature = $_GET['feature'];
            $feature = explode(',', $feature);

            $arg['tax_query'][] = array(
                'taxonomy' => 'tyres_feature',
                'field'    => 'slug',
                'terms'    => $feature
            );
        }

        $query = new WP_Query($arg);
        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                echo Hatt()->load_template('tyres/gird', FALSE, array('browse_tyre' => 'true'));
            endwhile;
        else: ?>
            <p id="noresult-fix" class="text-center text-uppercase">
                <?php _e('No results found',HATT_TEXTDOMAIN); ?>
            </p>
        <?php endif;
        wp_reset_query();

    ?>

</div>
