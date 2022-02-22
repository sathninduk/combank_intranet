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
define( 'DB_NAME', 'cmbintra_home' );

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
define( 'AUTH_KEY',         'QhI>Q>n-<K9f&6 SAAm+StsP/G?Lz4X9AvoXna=yWr3U Yj3Rzc2K~1H=L9f-H67' );
define( 'SECURE_AUTH_KEY',  'HfwDE]$7bX6~?mj9=]@VaYu3X4;S:eLeUqa-+0m?pEi}C=woN#i$Hlu/+qC*jHrA' );
define( 'LOGGED_IN_KEY',    'GBTnFqEG{W?)vN+Oi`;ZllI#tLb+=b&uxAcc!~QnXn9<Lm|5XLCXh:|7v8rg^tcr' );
define( 'NONCE_KEY',        'G|nIu!K|S$KQf%w%r(G<EPg/-uv[G2mlyEE/rn , n8sT]qx48%/`{mFE7@iRf}f' );
define( 'AUTH_SALT',        '^TvXihV<+>2FPl)?%i$[zOwk-{Xh+j]t$Xc/UEf$?<<>ywMjMC<x3gT=pIG^qFb!' );
define( 'SECURE_AUTH_SALT', '3S5fj)2]ixa1*$]1t`Es0_{T[z:x8t>|LQ_.P?5n]DkR&+O3:HEh*#S7 S&4z<-v' );
define( 'LOGGED_IN_SALT',   '*<fjr/E8Jt=rXQ6KXts$h9Mlw,l0>]^d6}p#Um)i{5ZSf4Ylj!DcM>bk_[J+>oiy' );
define( 'NONCE_SALT',       'l$:B+Iqo_0f?o?/u!c#w)|}4|WaD/d97-~:_Pf%p;:BED|AA7FM*IvoiQpI3zGkv' );

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
