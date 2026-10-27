<?php
	/**
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/17/15
	 * Time: 12:10 PM
	 */
?>
<form action="<?php echo home_url('/', 'relative' ); ?>" method="get">
	<div class="input-group">
		<input class="ht_custom_search" value="<?php echo esc_html(get_query_var( 's' )) ?>" placeholder="<?php _e( 'Search...', HATT_TEXTDOMAIN ) ?>"
		       type="text" name="s" class="form-control">
		<input type="hidden" value="post,page,stores,tyres" name="post_type" id="post_type" />
<!--                              <span class="input-group-btn">-->
<!--                                <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>-->
<!--                                  <input type="hidden" name="post_type" value="post">-->
<!--                              </span>-->
	</div>
</form>