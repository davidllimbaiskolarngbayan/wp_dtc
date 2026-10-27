<?php
/**
 * Shared WordPress settings and environment-based credentials.
 */
$env_file = __DIR__ . '/.env';

if ( file_exists( $env_file ) ) {
	if ( ! is_readable( $env_file ) ) {
		throw new RuntimeException( 'The WordPress .env file is unreadable.' );
	}

	$env_values = parse_ini_file( $env_file, false, INI_SCANNER_RAW );

	if ( false === $env_values ) {
		throw new RuntimeException( 'The WordPress .env file could not be parsed.' );
	}

	foreach ( $env_values as $name => $value ) {
		if ( ! preg_match( '/\A[A-Z_][A-Z0-9_]*\z/', $name ) || ! is_string( $value ) ) {
			throw new RuntimeException( sprintf( 'Invalid environment variable in .env: "%s".', $name ) );
		}

		if ( false === getenv( $name ) && ! isset( $_ENV[ $name ] ) && ! isset( $_SERVER[ $name ] ) ) {
			$_ENV[ $name ]    = $value;
			$_SERVER[ $name ] = $value;
			putenv( $name . '=' . $value );
		}
	}
}

if ( ! function_exists( 'dtc_get_optional_env' ) ) {
	function dtc_get_optional_env( $name ) {
		$value = $_ENV[ $name ] ?? $_SERVER[ $name ] ?? getenv( $name );

		return false === $value || null === $value || '' === $value ? null : $value;
	}
}

if ( ! function_exists( 'dtc_get_required_env' ) ) {
	function dtc_get_required_env( $name, $allow_empty = false ) {
		$value = $_ENV[ $name ] ?? $_SERVER[ $name ] ?? getenv( $name );

		if ( false === $value || null === $value || ( ! $allow_empty && '' === $value ) ) {
			throw new RuntimeException( sprintf( 'Required environment variable "%s" is not set.', $name ) );
		}

		return $value;
	}
}

/** Database settings */
define( 'DB_NAME', dtc_get_required_env( 'DB_NAME' ) );
define( 'DB_USER', dtc_get_required_env( 'DB_USER' ) );
define( 'DB_PASSWORD', dtc_get_required_env( 'DB_PASSWORD', true ) );
define( 'DB_HOST', dtc_get_required_env( 'DB_HOST' ) );
define( 'DB_CHARSET', dtc_get_required_env( 'DB_CHARSET' ) );
define( 'DB_COLLATE', dtc_get_required_env( 'DB_COLLATE', true ) );

/** Authentication keys and salts. */
define( 'AUTH_KEY', dtc_get_required_env( 'WP_AUTH_KEY' ) );
define( 'SECURE_AUTH_KEY', dtc_get_required_env( 'WP_SECURE_AUTH_KEY' ) );
define( 'LOGGED_IN_KEY', dtc_get_required_env( 'WP_LOGGED_IN_KEY' ) );
define( 'NONCE_KEY', dtc_get_required_env( 'WP_NONCE_KEY' ) );
define( 'AUTH_SALT', dtc_get_required_env( 'WP_AUTH_SALT' ) );
define( 'SECURE_AUTH_SALT', dtc_get_required_env( 'WP_SECURE_AUTH_SALT' ) );
define( 'LOGGED_IN_SALT', dtc_get_required_env( 'WP_LOGGED_IN_SALT' ) );
define( 'NONCE_SALT', dtc_get_required_env( 'WP_NONCE_SALT' ) );

$table_prefix = 'wp_';

define( 'WP_DEBUG', false );
define( 'DTC_API_URL', dtc_get_required_env( 'DTC_API_URL' ) );
define( 'DTC_API_KEY', dtc_get_required_env( 'DTC_API_KEY' ) );

$dtc_api_ca_cert = dtc_get_optional_env( 'DTC_API_CA_CERT' );

if ( null === $dtc_api_ca_cert ) {
	$dtc_api_ca_cert = __DIR__ . '/certs/dtc-api-ca.crt';
}

if ( ! is_file( $dtc_api_ca_cert ) || ! is_readable( $dtc_api_ca_cert ) ) {
	throw new RuntimeException( 'The DTC API CA certificate is missing or unreadable.' );
}

define( 'DTC_API_CA_CERT', $dtc_api_ca_cert );
