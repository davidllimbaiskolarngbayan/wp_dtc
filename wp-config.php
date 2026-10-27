<?php
// Default to production.
$env = 'production';

if ( file_exists( __DIR__ . '/wp-config.local.php' ) ) {
	$env = 'local';
}

require_once __DIR__ . "/wp-config.{$env}.php";

/** Disable the theme and plugin editor in the WordPress admin. */
define( 'DISALLOW_FILE_EDIT', true );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
