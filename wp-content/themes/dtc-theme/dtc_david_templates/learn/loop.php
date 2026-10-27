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
    'post_type' => 'learn',
    'posts_per_page' => $post_per_page,
    'orderby' => $orderby,
    'order' => $order,
);
if ($category != '0' && $category != '') {
    $category_array = explode(',', $category);
    if(!in_array(0,$category_array))
    $query['tax_query'][] = array(
        'taxonomy' => 'learn_cat',
        'terms' => explode(',', $category)
    );
}
$query_learn = new WP_Query($query);
if ($query_learn->have_posts()):?>
    <div class="ht_custom_learn">
        <?php
    while ($query_learn->have_posts()):
        $query_learn->the_post();?>
            <?php echo hatt()->load_template('learn/loop', 'item',array('post_per_row'=>$post_per_row,'query'=>$query_learn));?>
    <?php endwhile; wp_reset_query();?>
    </div>
<?php
        endif;?>
