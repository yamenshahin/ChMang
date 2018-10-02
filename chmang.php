<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/yamenshahin/
 * @since             1.0.0
 * @package           Chmang
 *
 * @wordpress-plugin
 * Plugin Name:       Manage Roles Employee and Donor
 * Plugin URI:        https://github.com/yamenshahin/ChMang
 * Description:       Manage roles for employee and donor. Also give dashboard for both users.
 * Version:           1.0.0
 * Author:            Yamen Shahin
 * Author URI:        https://github.com/yamenshahin/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       chmang
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-chmang-activator.php
 */
function activate_chmang() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chmang-activator.php';
	Chmang_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-chmang-deactivator.php
 */
function deactivate_chmang() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chmang-deactivator.php';
	Chmang_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_chmang' );
register_deactivation_hook( __FILE__, 'deactivate_chmang' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-chmang.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_chmang() {

	$plugin = new Chmang();
	$plugin->run();

}
run_chmang();
