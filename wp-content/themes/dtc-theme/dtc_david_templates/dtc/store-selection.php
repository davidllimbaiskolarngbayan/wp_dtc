<?php  extract($data); ?>

<div class="row dtc-store header">
	<div class="col-md-12 text-center">
		<?php if(isset($ht_title)): ?>
		<h2><?php echo $ht_title;?></h2>
		<?php endif; ?>
		<p><?php echo $ht_sub_title;?></p>
	</div>
</div>

<div class="row dtc-store-wrapper">
	<form action="<?php echo site_url('store');?>" method="GET">

		<div class="col-md-5 col-sm-5 text-center">
			<select class="states" name="state">
	        	<option value=""><?php echo _x('STATE','store-page', HATT_TEXTDOMAIN);?></option>
		    </select>
		</div>
		<div class="col-md-5 col-sm-5 text-center">
		    <select class="areas" name="area">
		        <option value=""><?php echo _x('AREA','store-page', HATT_TEXTDOMAIN);?></option>
		    </select>
		</div>
		<div class="col-md-2 col-sm-2">
			<input type="hidden" name="category" value="<?php echo $autocate_category;?>"> </input>
			<button type="submit" class="gy-btn yellow-btn hidden-xs"><?php echo _e('Search',HATT_TEXTDOMAIN);?></a>
		</div>

		<button type="submit" class="gy-btn yellow-btn visible-xs"><?php echo _e('Search',HATT_TEXTDOMAIN);?></a>
	</form>
</div>
