<!DOCTYPE html>
<html lang="en-MY" >
	<head>
		<!-- TODO: show site verification based on site locale -->
		<!-- <meta name="google-site-verification" content="CeRcTVRQNFEEM6rMmLS7sPCqu4_gASIwQH1tD9XpzRc" /> -->
		<meta name="facebook-domain-verification" content="5uzcptwuym4fyqt9o2tcak8e041b13" />
		<meta name="baidu-site-verification" content="9rcOJxv5jO" />
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title><?php wp_title('|', true, 'right'); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		
		
			
		
		<?php wp_head(); ?>
		<script type="text/javascript">
		var _hmt = _hmt || [];
		var gapi_loaded = false;
		</script>
		<?php if(SITE_LOCALE=="cn") { ?>
		<script src='//d3c3cq33003psk.cloudfront.net/opentag-134589-2049145.js' async defer></script>
		<?php } ?>

		<script>
		/*
			(function() {
				var _fbq = window._fbq || (window._fbq = []);
				if (!_fbq.loaded) {
					var fbds = document.createElement('script');
					fbds.async = true;
					fbds.src = '//connect.facebook.net/en_US/fbds.js';
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(fbds, s);
					_fbq.loaded = true;
				}
				_fbq.push(['addPixelId', '260813590941626']);
				
				var path = window.location.pathname;
				if (path.indexOf('request-for-quote') == -1 ||
					path.indexOf('request-for-quote-form') >= 0) {
					pixel();
				}
			})();
			*/
		</script>
		<script>window.dataLayer = window.dataLayer || [];</script>
	</head>
	<body <?php body_class(array(SITE_LOCALE, SITE_LANG) ); ?> data-spy="scroll" data-target=".navbar" data-offset="75">

	

	<?php if( SITE_LOCALE != 'in' ){ ?>
	<div class="preload" style="display:none">
		<!-- <img src="<?php echo esc_url( get_template_directory_uri() ) .'/images/preloader.gif';?>" alt="" /> -->
		<div class="preload-tyre"></div>
		<span class="preload-brand">David Tyres Company</span>
	</div>
	<?php } ?>
	
	<?php get_template_part('template-parts/header', 'site'); ?>
	<div id="ie_eos" style="display:none;border-color: rgb(235, 204, 209); padding: 20px 18px; text-align: center; color: rgb(169, 68, 66); font-weight: bold; background-color: rgb(242, 222, 222); position:absolute; width:100%; top:4.6em; z-index:1000;"></div> 
	<?php do_action('ht_banner_before_content'); ?>
	<div id="wapper" class="main-wrapper <?php echo $post->post_name ?? ''; ?>">
	
<script>

	function updateDisplay() {
		var element = document.getElementById('social-item-cooper');
		if (!element) { return; }
		if (window.innerWidth > 768) {
		element.style.display = 'none';
			} 
	   else {
				element.style.display = 'list-item'; }
} updateDisplay();
   window.onresize = updateDisplay;
   
</script>
