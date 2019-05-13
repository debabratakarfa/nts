<?php
/**
 * Plugin Name: NTS
 * Plugin URI:  https://www.deb.im/nts/
 * Description: NTS Test plugin
 * Version:     0.0.1
 * Author:      Debabrata Karfa
 * Author URI:  https://www.deb.im/
 * Text Domain: nts
 * Domain Path: /languages
 *
 * @package NTS
 */

// Useful global constants.
define( 'NTS_VERSION', '0.0.1' );
define( 'NTS_URL', plugin_dir_url( __FILE__ ) );
define( 'NTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'NTS_INC', NTS_PATH . '/' );
define( 'PLUGIN_NAME', 'nts-vote' );

// Include files.
require_once NTS_INC . 'app/core.php';

// Activation/Deactivation.
register_activation_hook( __FILE__, '\NTS\Core\activate' );
register_deactivation_hook( __FILE__, '\NTS\Core\deactivate' );

// Bootstrap.
NTS\Core\setup();

// Require Composer autoloader if it exists.
if ( file_exists( NTS_PATH . '/vendor/autoload.php' ) ) {
	require_once NTS_PATH . 'vendor/autoload.php';
}


