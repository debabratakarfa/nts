<?php
/**
 * Core plugin functionality.
 *
 * @package NTS
 */

namespace NTS\Core;

use \WP_Error as WP_Error;
use NTS\Backend as Backend;
use NTS\Frontend as Frontend;

/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};
	add_action( 'init', $n( 'init' ) );
	add_action( 'wp_enqueue_scripts', $n( 'frontend_styles_scripts' ) );
	add_action( 'nts_init', $n( 'nts_init' ), 10 );
	do_action( 'nts_loaded' );
}

/**
 * Initializes the plugin and fires an action other plugins can hook into.
 *
 * @return void
 */
function init() {
	do_action( 'nts_init' );
}

/**
 * Activate the plugin
 *
 * @return void
 */
function activate() {
	// First load the init scripts in case any rewrite functionality is being loaded.
	init();
	flush_rewrite_rules();
}

/**
 * Deactivate the plugin
 *
 * Uninstall routines should be in uninstall.php
 *
 * @return void
 */
function deactivate() {
}

/**
 * NTS Init Apps function
 *
 * @return void Call function on NTS Apps init.
 */
function nts_init() {
	check_composer_install();
	load_classes();
}

/**
 * Load frontend Style and script.
 *
 * @return void Load CSS and JS files in frontend.
 */
function frontend_styles_scripts(){
	wp_enqueue_style( PLUGIN_NAME, NTS_URL. 'assets/css/main.css', array(), NTS_VERSION, 'all' );
	wp_enqueue_style( PLUGIN_NAME.'-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), NTS_VERSION, 'all' );
	wp_enqueue_script( PLUGIN_NAME, NTS_URL . 'assets/js/main.js', array( 'jquery', ), NTS_VERSION, true );
	wp_localize_script(
		PLUGIN_NAME,
		'nts_ajax_obj',
		array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
	);
}

/**
 * Check if Composer installed
 * -- If Installed and vendor folder not located then run
 * -- command to install composer component
 * If not installed then through WP_Error
 *
 * @return array Check if composer installed or not, if present then perform operation to install it.
 */
function check_composer_install() {
	if ( ! empty( shell_exec( 'composer --version' ) ) ) {
		if ( ! file_exists( NTS_PATH . '/vendor/autoload.php' ) ) {
			shell_exec( 'cd ' . NTS_PATH );
			shell_exec( 'composer isntall' );
			shell_exec( 'composer dump-autoload -o' );
			return new WP_Error( 'composer-installed', __( 'Composer and components installed', 'nts' ) );
		}
	} else {
		return new WP_Error( 'composer-not-available', __( 'Composer not installed', 'nts' ) );
	}
}

/**
 * Load Custom classes from Classes folder.
 *
 * @return void Loading pre-defined classes.
 */
function load_classes() {
	new Backend\CPT();
	new Backend\Metabox();
	new Backend\Shortcode();
	new Backend\Action();
	new Frontend\Page();
}
