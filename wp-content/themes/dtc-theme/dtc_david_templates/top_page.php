<?php
	/**
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/18/15
	 * Time: 7:34 PM
	 */

	$page_banner = apply_filters( 'bt_page_banner', get_the_ID() );

	if ( $page_banner ) {
		$class = HTAssets::build_css_class( 'background-image:url(\'' . $page_banner . '\')' );
	} else {
		$class = '';
	}
?>
<div class="top-section <?php echo esc_attr( $class ) ?>">
	<div class="top-page bt-css-parallax">
		<div class="bt-overlay"></div>
		<div class="container">
			<h1 class="tp-title"><?php echo apply_filters( 'hatt_blog_title', __( 'Blog', HATT_TEXTDOMAIN ) ) ?></h1>

			<p class="tp-subtitle"><?php echo apply_filters( 'hatt_blog_subtitle', __( 'Read our glory stories', HATT_TEXTDOMAIN ) ) ?></p>
		</div>

	</div>
</div>