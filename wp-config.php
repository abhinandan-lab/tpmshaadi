<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'tpmshaadi' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'wU?>S|)+.%zZ7z9-({v(<4x& Z;!n<nBII(S6LK}gQ:-|6Gw+m$ Ca,GOdv`k=0!' );
define( 'SECURE_AUTH_KEY',  '[Ch@1<riw=##o<Ve!xXu|j*4Sh9;R>6dO|aKWqQe0<_5kSM3JotW~O=IoTai_l@`' );
define( 'LOGGED_IN_KEY',    'PbP|F|[Bt::> {f6@~OYHW)Xu8YnnNu2hFpAGoE~89uXEJr$#QN]G#05lz)(QO1l' );
define( 'NONCE_KEY',        '`5Z;RC<ra^LSm%zgpe%o14;>1b,dxxN&5pT[f3W`J D89SZ3Rr^K=0 G}Vv>CB}o' );
define( 'AUTH_SALT',        '.KER%LlV7RLa94nRIC-qiJ,Zi!{j@_:8-SX2o-l kxX!ze~C,Gy=Z-+_88*Lq69v' );
define( 'SECURE_AUTH_SALT', '$486%rP_veJLQy(PeBik((3%NJTdZhbs;qjZ@F.ufp7.pInTrqr>1l:N&H,f#M4p' );
define( 'LOGGED_IN_SALT',   '{2:FP>2x,8DZ[R[TY|BJ$mAvv BO[_{8(YThtk$cHVJnf#v?Iz6U=#+f2oJr$H}/' );
define( 'NONCE_SALT',       '|pRG0KCk/rH40P<#U)o0wb0-RW3+p|a$zSuQzfsGlwPs/TyA8r*Ovxf.=lZbN6Jh' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
