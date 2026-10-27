<?php
	/**
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/23/15
	 * Time: 12:06 AM
	 */

	$main_color = Hatt()->get_option( 'main_color' );

	$sub_font = Hatt()->get_option( 'style_subfont1' );

	$body_style = Hatt()->get_option( 'style_bodyfont', array() );
	$ft_bg      = Hatt()->get_option( 'ft_background', array() );


?>



<?php echo Hatt()->get_option( 'style_custom_css' ); ?>