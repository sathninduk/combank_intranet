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
define( 'DB_NAME', 'cmbintra_aml' );

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
define( 'AUTH_KEY',         'WzvKL`ASpyfys+=JG2h7Jp`9*E#:BcE}hE}$umI.3gt@.2,DW[)S4L!vb94B&9kF' );
define( 'SECURE_AUTH_KEY',  '/oWBvo~_vHA!W<z5L-%3^JFp)+Ht%H^P7bK}KfTOvCfQpdb6CmP uL(m9B5=b7j<' );
define( 'LOGGED_IN_KEY',    'UFc,}sgVI,EX/jY+=jX?;]JV Yw6eFf[Tb?1k ,x4S|>[|yVov`K7+XcdFK?^Jvu' );
define( 'NONCE_KEY',        'hydcbw`:/gx.T9C,w7ODQ(kI=hd C-;KPIu?Y|D@)s>aFBjUHDD#$&ha}Zq>P#as' );
define( 'AUTH_SALT',        '1[ko)aW+aRWRp%o1R.:`J+sx!m&QtX%#kA@V;3/s!R@.W-/[cXq%#jLg/VY9?fR5' );
define( 'SECURE_AUTH_SALT', 'k{@we=~t1$NVyp%*iBz:F`n5FFzH/fTF3mnXi!`C~OHe18p1Z@e?mP,NagPK!Lcj' );
define( 'LOGGED_IN_SALT',   ';P5H[WJuY9p7x0Q~%9%:TD![-K,LxJH]kU+z;OE.^>V)dg &9iJiK[_K0;(@y`4U' );
define( 'NONCE_SALT',       '-3fpHJ-<;Ez Msh<JIq/0,Ys?kY10W=u6!Oec0{>2pN$6^o+K.(x@SdjF7Vp=Qp>' );

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
