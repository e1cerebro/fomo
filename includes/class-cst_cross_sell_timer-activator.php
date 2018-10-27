<?php

/**
 * Fired during plugin activation
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/includes
 * @author     UCHENNA NWACHUKWU <nwachukwu16@gmail.com>
 */
class Cst_cross_sell_timer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		// creates my_table in database if not exists

		$table = $wpdb->prefix . "fomo_products"; 
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $table ( 
			    `id` int(11) NOT NULL AUTO_INCREMENT,
				`fomo_product_id` varchar(225) DEFAULT NULL,
				`fomo_discount_amount` varchar(225) DEFAULT NULL,
				`fomo_discount_code` varchar(225) DEFAULT NULL,
				`fomo_discount_type` varchar(225) DEFAULT NULL,
				`date_submitted` varchar(225) DEFAULT NULL,
				PRIMARY KEY (`id`)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );


		$table = $wpdb->prefix . "fomo_discount_codes"; 
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $table ( 
			    `id` int(11) NOT NULL AUTO_INCREMENT,
				`discount_id` varchar(225) DEFAULT NULL,
				`date_submitted` varchar(225) DEFAULT NULL,
				PRIMARY KEY (`id`)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
