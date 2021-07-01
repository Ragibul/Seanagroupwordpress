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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'seanagroup');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '|7! <H9>WY?mV;S3~EFq&O&`F|`5;4Fd+>O/NAC| Kj_d{9dPdj.Dn!$H 4%n,j:');
define('SECURE_AUTH_KEY',  'cZ.%7MiSN,KZ}H33Yl`LsOsq>_(>ghfy$g2uSkSdr1rBE];;&5 fQST]bxeYfX h');
define('LOGGED_IN_KEY',    'o[o)&c3]Y!yd#@a$eOxQds8dypR7jP&cM]Z{jlR7nFrcECy4b@br7Y>vWg9{E@yh');
define('NONCE_KEY',        '.P[-/O0exOXVue}E7y)-H+@Q*z?b2DHS3:?m~`a]1m~FTNnXc` qsYQ?40<4=N3k');
define('AUTH_SALT',        'Lehhk~)C+BOk@RFAz6~9Q$N[whr$tjy0+p#W/Bs)z><_~ t4wB2Lu*I/A2paFx@f');
define('SECURE_AUTH_SALT', 'N{KnqaA;=Blg1.G5VX4BjC`>:c2FjA-%O6~/fzC?sfxi8ec<~^(yc>SH5eEt0G} ');
define('LOGGED_IN_SALT',   ';vtns6Z7akyjC74K8L.szBdmEn|!U]xFqE+nbc40ZmSL:1]c(<fkwrS>BaQ11)ED');
define('NONCE_SALT',       '~$v hKJdu)?.&>U-h!&.89Q@[Mw~O+~RNbXQ92cvk<&a>3- gmC*_PO{a9T3V/IL');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
