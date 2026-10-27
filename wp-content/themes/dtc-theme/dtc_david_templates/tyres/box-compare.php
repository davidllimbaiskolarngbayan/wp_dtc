<?php
    $compare_item_return = '';
    if (isset($_GET['compare_item_return']) and !empty($_GET['compare_item_return'])) {
        $compare_item_return = explode(',', $_GET['compare_item_return']);
    }
    elseif(isset($_POST['tyre_compare']) and !empty($_POST['tyre_compare'])){
        $compare_item_return = explode(',', $_POST['tyre_compare']);
    }
?>
<?php
if(isset($ajax_param) && $ajax_param['is_ajax']==1){
    if($ajax_param['count_tyre'] == 0){
        return; //do not show compare box if no item found
    }
}
?>
<div class="type-bottom-destop">
    <div class="ht_compare_center row">
        <?php
            for ($i = 0; $i <= 2; $i++):
                if (isset($compare_item_return[$i])):
                    ;?>
                    <div class="col-xs-2 col-sm-3">
                        <div
                            class="col-sm-4-box text-left compare_item">
                            <div class="default-text text-center"></div>
                            <div class="compare_item_content  <?php echo 'compare_add_'.$compare_item_return[$i];?>" attr_id="<?php echo $compare_item_return[$i];?>">
                                <p>
                                    <?php
                                        if (has_post_thumbnail($compare_item_return[$i])) {
                                            echo get_the_post_thumbnail($compare_item_return[$i], array(50, 50));
                                        };?>
                                    <span class="hidden-xs"><?php echo get_the_title($compare_item_return[$i]);?>
                                </p></span><span
                                    attr_id="<?php echo $compare_item_return[$i];?>" class="remove">x</span>
                            </div>
                        </div>
                    </div>
                <?php else:; ?>
                    <div class="col-xs-2  col-sm-3">
                        <div class="col-sm-4-box text-left compare_item">
                            <div class="default-text text-center">
	                            <?php _e('select a tyre to compare',HATT_TEXTDOMAIN); ?>
	                          </div>
                            <div class="compare_item_content"></div>
                        </div>
                    </div>
                <?php endif;
            endfor; ?>

        <div class="col-xs-6 col-sm-3 compare">
            <div class="compare-box">
                <a onclick="return false"
                   href="#" class="text-deco-none">
	                 <?php _e('compare',HATT_TEXTDOMAIN); ?>
	              </a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>