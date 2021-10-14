<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://seowp.pl
 * @since             1.0.0
 * @package           mpc
 *
 * @wordpress-plugin
 * Plugin Name:       mpc-todo
 * Plugin URI:        http://
 * Description:       MPC todo wordpress plugin
 * Version:           1.0.0
 * Author:            AKC
 * Author URI:        http://seowp.pl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mpc-todo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'mpc_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mpc-activator.php
 */
function activate_mpc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mpc-activator.php';
	mpc_Activator::activate(); 
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mpc-deactivator.php
 */
function deactivate_mpc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mpc-deactivator.php';
	mpc_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mpc' );
register_deactivation_hook( __FILE__, 'deactivate_mpc' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mpc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mpc() {

	$plugin = new mpc();
	$plugin->run();

}
run_mpc();
