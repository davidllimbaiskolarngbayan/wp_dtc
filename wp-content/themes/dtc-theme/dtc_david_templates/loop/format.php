<?php
	/**
	 * Created by PhpStorm.
	 * User: me664
	 * Date: 1/23/15
	 * Time: 12:38 AM
	 */
?>
<?php switch ( $post_format = get_post_format() ) {
	case "gallery":
		$ids = get_post_meta( get_the_ID(), 'gallery', TRUE );
		$gallery = explode( ',', $ids );
		?>
		<div class="slider_container">
			<ul class="slides ">
				<?php if ( ! empty( $gallery ) ):
					foreach ( $gallery as $key => $value ) {
						echo "<li><a/>" . wp_get_attachment_image( $value, array(
								640,
								427,
								'bfi_thumb' => TRUE
							) ) . "</a></li>";
					}
				endif;
				?>
				<?php ?>
			</ul>
		</div>
		<?php
		break;
	case "audio":
	case "video":
		$media_url = get_post_meta( get_the_ID(), 'media_url', TRUE );
		if ( wp_oembed_get( $media_url ) ):
			?>
			<div class="media-responsive">
				<?php echo wp_oembed_get( $media_url ) ?>
			</div>

		<?php
		endif;
		break;
	default:
		echo '<div class="thumbnail_blog text-center">';
		the_post_thumbnail( 'full',array('class'=>'img-responsive') );
		echo '</div>';
		break;
}
?>