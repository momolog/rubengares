<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

  if ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) ) {
    include( dirname( __FILE__ ) . '/wp-config-local.php' );
    define( 'WP_LOCAL_DEV', true ); // We'll talk about this later
  } else {
    define('DB_NAME', 	  'db30334_1');           // Der Name der Datenbank, die du benutzt.
    define('DB_USER', 	  'db30334_1');           // Dein MySQL Datenbank Benutzername.
    define('DB_PASSWORD', 'plack47{Sohl');        // Dein MySQL Passwort
    define('DB_HOST', 	  'mysql5.presber.net');
  }


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '`hZwoH7oXE$TjzS@C!uduz0AKkiD84i&s*8Ro-~6tp.I>c{g!Q@(1_poHC.aVv+;');
define('SECURE_AUTH_KEY',  'vit2^s5QNZ390%?S D$XQZ`#GDyEgQmIJ873{wQYDp&6OJ6NlK[,jzVg@@WOAU,J');
define('LOGGED_IN_KEY',    '+D]U}2%raTV?5<b2}9Wx(<_1D6N/i&s^xd;Me/wi<{<;`KrjD.3V*yI=>H7*1~D5');
define('NONCE_KEY',        'i#BTr[>rb1f`A;h0T#*K[Tks~M41z`6!T(]si(IZxWT_mPPR+0$Shm~L/_o=K>8f');
define('AUTH_SALT',        'Nw+V*x<4QQu{pWu4u$)Pr@1I2vO&vqj;MPy)LL|w<_1g&-U?P)(P&A_Vk-d41a20');
define('SECURE_AUTH_SALT', 'LqBMwJm`Tv*dMQKB7j,9H$gj!I2tRzC=8(S0tv0NB#9v8mKgF,BMtM/:fx*X~LXc');
define('LOGGED_IN_SALT',   'u/04DX?yTt~km$T>aE%j<=4Rd12jokr]p+1j%J+}s)@H:TDI..X0T/A<4X^h{Zih');
define('NONCE_SALT',       '3?[&gJl5:~>KzXgHgJS3_:.ulrfi+%t5u9?7y4*4i(Dn29N>;?ajCdAK4Jb7!uTx');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_rubengares_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
