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
define( 'DB_NAME', 'sojib' );

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
define( 'AUTH_KEY',         '^W{1!#7g 3kG<&Mw%K91e5BdDPl/oEgr3&_ %>v/U6x%YSA?u)4/ptowVo~6Yp2S' );
define( 'SECURE_AUTH_KEY',  '-4}6.AV!mEuHCJ!9Zo|Kn3?inUb 0@mNg@ly`.lmR$wx:z~v((O3;Z>YN8v;^!Xj' );
define( 'LOGGED_IN_KEY',    '}1*j)RFaS|H]_9R{zv#liwqvd2CZt(,$:K-T]_-X2hW-dunu:Hl0mYNvV=dO#)x3' );
define( 'NONCE_KEY',        ';T>04?(NMwD+?3jKx-Cm$gq*22u;KV:!tlw==pD|r1w1)*%;t}X#L=pLNJfd%_Mm' );
define( 'AUTH_SALT',        '++ VX7R5SnpsyO8o[k%Hz:<xEy4!!hmSI5x.bwVmmz1T%T=cWl{$W:m%2!>MGXm6' );
define( 'SECURE_AUTH_SALT', '9Q~Rx5`WL%me=mmnf=[a:#Ks[{%;%)mV7]=10/|-bB`Jm@|!xurs}cTQqot1HyY1' );
define( 'LOGGED_IN_SALT',   'UA.kAW:ozW~7aB@$237UU|3erm)WlA.6`n26l`c}!W*tE5SIaL]8[sotHVA_dg{o' );
define( 'NONCE_SALT',       '>Yyn]j}26cUc*j6>_A,d.JdQDow#~f~+KrvRP~}M~9~pO~0rrE+?cho@4r+hf]HB' );

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
