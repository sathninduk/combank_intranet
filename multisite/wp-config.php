<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'combank_intranet' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'Combank@123' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/** Multisite */
define( 'WP_ALLOW_MULTISITE', true );

define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'combank.intranet.com' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

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
define( 'AUTH_KEY',         'G@T:3$:k%*^g!K6@#gK@j)@a-RG9XBeU}(j@ sWnAfRK+EB}d]DYX9e+lf_B=;U.' );
define( 'SECURE_AUTH_KEY',  'Tm:=DrqDbTD/39R[gM:6q^zG3^^D6fdKtVb#Q90a(@FMwUy11GU{s^quUIPedzv,' );
define( 'LOGGED_IN_KEY',    'YxQ{=p55F}4jMAaX|@ON(7lpJ^}Y3Oj|Rguw;>^CXm[BEgaRIfZNCLXoka3W)2dM' );
define( 'NONCE_KEY',        '`zv-A5k2/ck^,DMtB067LZ_kgy6F[Z}Z?hAF2#wAcpmr$b.$@yQi28eO&:3*Z3|i' );
define( 'AUTH_SALT',        ':yH9B&^Z,zGZN[4^[![Nn>C)30A;_+g~V%{]9(w;TV9KK8WgS_A8Nq-b?`1<1p}E' );
define( 'SECURE_AUTH_SALT', '77nr8T$ms@)6SLx(?KihMY)em5clj}BC;S{B5%DJ0Mn:bo2NVO|{^U?/P>@mw|)<' );
define( 'LOGGED_IN_SALT',   'KVV:}J0;2FRDnst=(!@Z[uxMSD5F+UJx~?3t<StM0].|_6]=PE;?=SN+(?OUq8xW' );
define( 'NONCE_SALT',       'U~}*a9xDlDcJSq+4J%QEkDc4:&Y19fK 7zG1tbtWAU-IuRWO];z~,k:<H;e>iH6C' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
