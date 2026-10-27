<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 5/12/2015
 * Time: 2:29 PM
 */
//$default = array(
//    'ht_learn_category'=>'',
//    'post_per_page'=>'',
//    'post_per_row'=>'',
//    'order'=>'',
//    'orderby'=>'',
//);
extract($data);
$query = array(
    'post_type' => 'faq',
    'posts_per_page' => $post_per_page,
    'orderby' => $orderby,
    'order' => $order,
);
if (!empty($custom_id)) {
    $custom_id_array = explode(',', $custom_id);
    if ($custom_id_array)
        $query['post__in'] = $custom_id_array;
}

$query_learn = new WP_Query($query);
if ($query_learn->have_posts()):?>
    <div class="ht_custom_faq">
        <?php
        while ($query_learn->have_posts()):
            $query_learn->the_post();?>
            <?php echo hatt()->load_template('faq/loop', 'item', array('query' => $query_learn));?>
        <?php endwhile;
        wp_reset_query();?>
    </div>
<?php endif; ?>
