<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/includes
 * @author     UCHENNA NWACHUKWU <nwachukwu16@gmail.com>
 */
class Cst_cross_sell_timer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'cst_cross_sell_timer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
