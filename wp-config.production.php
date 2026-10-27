<?php
require_once __DIR__ . '/wp-config.common.php';

$site_home = dtc_get_optional_env( 'WP_HOME' );

if ( null === $site_home ) {
	$hostname   = dtc_get_optional_env( 'WEBSITE_HOSTNAME' );
	$site_home = null === $hostname ? 'https://davidtyre.com' : 'https://' . $hostname;
}

define( 'WP_HOME', $site_home );
define( 'WP_SITEURL', dtc_get_optional_env( 'WP_SITEURL' ) ?? $site_home );
define( 'SITE_LOCALE', 'en' );
define( 'SITE_LANG', 'en' );
