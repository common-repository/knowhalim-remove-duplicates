<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://knowhalim.com/app/knowhalim-remove-duplicates-plugin/
 * @since             1.0.0
 * @package           Kh_Remove_Duplicates
 *
 * @wordpress-plugin
 * Plugin Name:       Knowhalim Remove Duplicates
 * Plugin URI:        https://knowhalim.com/app/knowhalim-remove-duplicates-plugin/
 * Description:       This plugin helps to remove duplicates from your wordpress and it supports custom post types.
 * Version:           1.0.0
 * Author:            Halim
 * Author URI:        https://knowhalim.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kh-remove-duplicates
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
define( 'KH_REMOVE_DUPLICATES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kh-remove-duplicates-activator.php
 */
function activate_kh_remove_duplicates() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kh-remove-duplicates-activator.php';
	Kh_Remove_Duplicates_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kh-remove-duplicates-deactivator.php
 */
function deactivate_kh_remove_duplicates() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kh-remove-duplicates-deactivator.php';
	Kh_Remove_Duplicates_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kh_remove_duplicates' );
register_deactivation_hook( __FILE__, 'deactivate_kh_remove_duplicates' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kh-remove-duplicates.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kh_remove_duplicates() {

	$plugin = new Kh_Remove_Duplicates();
	$plugin->run();

}
run_kh_remove_duplicates();

