<?php
define( 'WP_CACHE', false );

 // Added by WP Rocket


// define('EVENT_AGGREGATOR_API_BASE_URL', 'https://ea.lndo.site/');
define( 'EVENT_AGGREGATOR_API_BASE_URL', 'https://ea-staging.theeventscalendar.com/' );

define( 'SAVEQUERIES', true );
//define( 'TEC_CUSTOM_TABLES_V1_DISABLED', true );
// define( 'TEC_EVENTS_CUSTOM_TABLES_V1_MIGRATION_ENABLED', true );
// define( 'TEC_CUSTOM_TABLES_V1_ALT_UPDATE_FLOW', true );
 define( 'TEC_EVENTS_CUSTOM_TABLES_V1_RRULE_UI_ENABLED', true );
// define('TEC_EVENTS_CUSTOM_TABLES_V1_MIGRATION_STOP_ON_FAILURE', true);
// define( 'TEC_EVENTS_CUSTOM_TABLES_V1_MULTI_RULE_MIGRATION_ENABLED',true);
define('FS_METHOD', 'direct');
define('SCRIPT_DEBUG', true);
define('DISABLE_WP_CRON', false);
define('WP_ALLOW_REPAIR', true);
define( 'WP_DEBUG', true);
define( 'WP_DEBUG_LOG', true );
define('TRIBE_CACHE_VIEWS', false);
if(!function_exists('dd')) {
	function dd() {
		echo "<pre>";
		echo "\n------\n";
		$stack = debug_backtrace();
		$output = array_shift($stack);
		echo "\n".$output['file'].":".$output['line']."\n\n";
		$args = func_get_args();
		foreach($args as $arg) {
			echo "------\n";
			var_export($arg);
		}
		exit;
	}
}

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * This has been slightly modified (to read environment variables) for use in Docker.
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// IMPORTANT: this file needs to stay in-sync with https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php
// (it gets parsed by the upstream wizard in https://github.com/WordPress/WordPress/blob/f27cb65e1ef25d11b535695a660e7282b98eb742/wp-admin/setup-config.php#L356-L392)

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
	// https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $_ENV['WORDPRESS_DB_NAME']);

/** MySQL database username */
define( 'DB_USER', $_ENV['WORDPRESS_DB_USER']);

/** MySQL database password */
define( 'DB_PASSWORD', $_ENV['WORDPRESS_DB_PASSWORD']);

/**
 * Docker image fallback values above are sourced from the official WordPress installation wizard:
 * https://github.com/WordPress/WordPress/blob/f9cc35ebad82753e9c86de322ea5c76a9001c7e2/wp-admin/setup-config.php#L216-L230
 * (However, using "example username" and "example password" in your database is strongly discouraged.  Please use strong, random credentials!)
 */

/** MySQL hostname */
define( 'DB_HOST',  $_ENV['WORDPRESS_DB_HOST']);

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8');

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '');

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         '21edeb205c93e6f36f6a6b13ab5891ffe8f7eb3a') );
define( 'SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'c5d3b8124fac5a3693273594ebe7fe3423901d35') );
define( 'LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    'bc350312d9c8ad383b929d83757351babf75a032') );
define( 'NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        'f94cf38c924fd1aada241707715c57d3db4be8ab') );
define( 'AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        'bb809b7725713bc9223079827058f3a8a531207c') );
define( 'SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', '7924e82bbd9dfe8f05dd56920d6fc98af1940b82') );
define( 'LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   '2a5ebd4229d7fbed60b71ff9934e3c6086cd2ad8') );
define( 'NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       '6ed76afa9ff82a3d172d47df9be12ef6a560fb62') );
// (See also https://wordpress.stackexchange.com/a/152905/199287)

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

/* Add any custom values between this line and the "stop editing" line. */

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
