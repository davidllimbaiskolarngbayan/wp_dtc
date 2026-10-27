<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/17/2015
	 * Time: 1:49 PM
	 */ ?>

<?php
//	$default = array(
//		'ht_corporate_title'=>'',
//		'ht_corporate_right'=>'',
//		'ht_corporate_button'=>'#'
//	);
	extract($data);
	;?>
<div class="content-corporate">
<div class="corporate-box">
	<div class="row">
		<div class="col-sm-9 col-xs-12 left ">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo do_shortcode($content);?>
                </div>
            </div>
		</div>
		<div class="col-sm-3 col-xs-12 right ">
			<div class="row content-corprate-right">
				<div class="col-xs-12"><?php echo ($ht_corporate_right);?></div>
			</div>
			<?php
				$href = vc_build_link($ht_corporate_button);
				if(!empty($href['title'])):
				;?>
			<p class="apply-today">
				<a target="<?php _e($href['target']);?>" href="<?php _e($href['url']);?>"><?php _e($href['title']);?></a>
			</p>
			<?php endif;?>
		</div>
        <?php if($ht_corporate_back_top_top=='yes'):;?>
            <div class="col-sm-9  hiddent-xs  col-xs-12 left "></div>
            <div class="col-sm-3 col-xs-12 hiddent-xs right "><div class="corporate_back_to_top">
            <?php _e("Back to top",HATT_TEXTDOMAIN); ?>
            </div></div>
        <?php endif;?>
	</div>
</div>
</div>