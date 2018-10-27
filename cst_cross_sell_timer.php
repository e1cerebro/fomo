<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Cst_cross_sell_timer
 *
 * @wordpress-plugin
 * Plugin Name:       Cross Sell Timer
 * Plugin URI:        #
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            UCHENNA NWACHUKWU
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cst_cross_sell_timer
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
global $wpdb;
$table = $wpdb->prefix . "fomo_products";
define( 'PLUGIN_NAME_VERSION', '1.0.0' );
define( 'MY_PLUGIN_PATH', plugin_dir_path(__FILE__ ));
define( 'FOMO_PRODUCT_TABLE', $table);



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cst_cross_sell_timer-activator.php
 */
function activate_cst_cross_sell_timer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cst_cross_sell_timer-activator.php';
	Cst_cross_sell_timer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cst_cross_sell_timer-deactivator.php
 */
function deactivate_cst_cross_sell_timer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cst_cross_sell_timer-deactivator.php';
	Cst_cross_sell_timer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cst_cross_sell_timer' );
register_deactivation_hook( __FILE__, 'deactivate_cst_cross_sell_timer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cst_cross_sell_timer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cst_cross_sell_timer() {

	$plugin = new Cst_cross_sell_timer();
	$plugin->run();

}
run_cst_cross_sell_timer();
