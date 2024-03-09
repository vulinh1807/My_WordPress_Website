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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'vulinh' );

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
define( 'AUTH_KEY',         'J.c$<C=%t0PIG..*S,9,@MHj*o{JoHl_!7i/dwGRN$cj.|d2z#=aM6uDARRLzKDe' );
define( 'SECURE_AUTH_KEY',  'r?7$K`]h%=W<S~srlx{j.SnY,Xv$;<U{~V_W{j4=V-K-TE}^SF <t{~aAkO@LEG0' );
define( 'LOGGED_IN_KEY',    '8F%FKGKAjs.vzZK5_6&9j1rIEP$1PS`?,KV[k.b0N~0v5Aj_:`lME%i,S 2<4Gq`' );
define( 'NONCE_KEY',        'L6HIMag<>n`gn+=x8bGH0X}yQ^JEqE5dM5YGY1Qy.Ew_vLncf``|0v74n^wMf^eG' );
define( 'AUTH_SALT',        'm`/LM?jj]X=flFLOZu2FWM(|[m/ueR5zy&*}M(!kFC(8ul>`yc`y`Bt=a$UIiI>[' );
define( 'SECURE_AUTH_SALT', '[aF0e`?(vKU9GyP/nDH9;w:WFDll;j<WIMr!&WFidTtS:C{2owuJLT#fFGZ|<3H;' );
define( 'LOGGED_IN_SALT',   '#%_7~>V,mYzn-e>?DNs;(i}tAd$:H06ar/?89=D# bsP0GKDjlU7%7gM/.-/&23-' );
define( 'NONCE_SALT',       ',-XN,_c[F{xJP]3IU{ xW.}}E1a]Ju^|O3.-c/wC96@_hgVEBlTd>BtXz$.!n4{C' );

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
