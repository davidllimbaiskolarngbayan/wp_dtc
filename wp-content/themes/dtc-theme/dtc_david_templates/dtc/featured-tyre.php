<?php
extract($data);
$post = get_post( $tyre_id ); 
?>
<a href="<?php echo get_permalink(  $tyre_id );?>" target="_blank">
	<div class="row text-center tyre-container">

		<div class="col-md-12 hidden-xs">
			<?php echo get_the_post_thumbnail(  $tyre_id, 'medium', array('class'=>'img-responsive center-block') );?>
			<div class="tyre-banner">
				<?php  echo $post->post_title;?>
			</div>
		</div>

		<div class="col-xs-4 visible-xs">
			<?php echo get_the_post_thumbnail(  $tyre_id, 'medium', array('class'=>'img-responsive center-block') );?>
		</div>
		<div class="col-xs-7 visible-xs tyre-label-container" >
			<h3 class="tyre-label"><?php  echo $post->post_title;?></h3>
		</div>
	</div>
</a>
