<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 5/12/2015
 * Time: 2:39 PM
 */ ?>
<div class="box-colspace-learn detail-box clearfix">
    <h2 class="title"><a href="#"><?php the_title(); ?></a></h2>

    <div class="box-colspace-content-learn col-md-12 col-sm-12 col-xs-12 learn-pad-content">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 learn-left-content">
            <?php
            $list_q_a = get_post_meta(get_the_ID(), 'list_q_a', TRUE);
            if (!empty($list_q_a)):
                foreach ($list_q_a as $key => $val):?>
                    <!-- Content detail -->
                    <?php
                    if (($key + 1) == count($list_q_a)):?>
                        <div class="learn_detail" style="padding-bottom: 0px">
                    <?php else: ?>
                        <div class="learn_detail">
                    <?php endif;
                    ?>
                    <div class="learn_title"><?php echo esc_attr($val['title']);?></div>
                    <div class="learn_content"><?php _e($val['answer']);?></div>
                    </div>
                    <!-- End Content detail -->
                <?php endforeach;
            endif; ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"></div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <span class="cn-learn-right-content"><?php _e("Back to top",HATT_TEXTDOMAIN); ?></span>
        </div>
    </div>
</div>
