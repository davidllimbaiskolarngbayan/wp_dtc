<?php
	/**
	 * Created by PhpStorm.
	 * User: x
	 * Date: 4/17/2015
	 * Time: 1:49 PM
	 */ ?>

<?php
    $class='';
    if(isset($open) and $open =="yes"){
        $class= 'box-open';
    }else{
        $class='box-close';
    }
    ;?>

<div class="box-colspace">
	<h2 class="title <?php echo esc_attr($class);?>"><a href="#"><?php echo esc_attr( $title ); ?></a></h2>

	<div class="box-colspace-content clearfix" style="display: none;">
		<?php echo do_shortcode( $content ); ?>
	</div>
</div>