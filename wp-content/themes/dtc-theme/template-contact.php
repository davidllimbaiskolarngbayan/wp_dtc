<?php
	/**
	 * Template Name: Contact
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/5/15
	 * Time: 11:45 PM
	 */
	get_header();
?>
<div id="main-page">
	<div class="container">
		<div class="content-contact">
			<?php if ( have_posts() ) {
	get_template_part( 'content', 'page' );
} else {
	get_template_part( 'content', 'none' );
} ?>
		</div>
	</div>
</div>
</div>
<?php get_footer(); ?>