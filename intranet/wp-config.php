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
define ( 'WP_ALLOW_MULTISITE', true );

// Multisite
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'combank.intranet.com' );
define( 'PATH_CURRENT_SITE', '/intranet/' );
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
define( 'AUTH_KEY',         '#u(D1@DWG`frQ~HO?a%6TEY:cHHd:`G IkMQ8E<{=NW&3@jA:+kiZ%VGBbCjuUh%' );
define( 'SECURE_AUTH_KEY',  'L}|sN,=}.`Lb)#OPXBBXPVX?aQZrjX/_K!$#&fAq.tPZ(|$xq^j&dcw?QwNMUz1R' );
define( 'LOGGED_IN_KEY',    'b*rCLzEeMIu`Zg]$N.!I.R.7zH8AIT3_7IF+Iz[}vbvYUHsGn24vL}^2mO!K ~|]' );
define( 'NONCE_KEY',        '{W]fqi@6||4N$BC,D&!S]|IDkBS[e7}XSH3(6@KEof~WJXS}5N1!JCvpnJ9iP;Ah' );
define( 'AUTH_SALT',        'ZC>Z=xVNh(/g&gLt(6y0X? C#w$J.afN*#7?Wzs.@UXV8)l`YsDGdw|Aq(#OJ4$}' );
define( 'SECURE_AUTH_SALT', 'v-:rcVit}AL?Bs. !6pfSY^UH]KJFyx>*N;ciE^%*<] !O/en1D!8dnE&Cz]A0R0' );
define( 'LOGGED_IN_SALT',   'Z,VRvMS<Lr4g%O1^^n<@=>/GDp&J]>,m=p~@{P8&vT$}j]S]bd)[W +TG [G # b' );
define( 'NONCE_SALT',       'tPJ*U]86VG0%i()QwEjPlT9O{J$ZCQ8qwNMqi|f2.D@&9p6{gUz3850%QNX3?T`J' );

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
