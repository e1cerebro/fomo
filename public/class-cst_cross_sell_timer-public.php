<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/public
 * @author     UCHENNA NWACHUKWU <nwachukwu16@gmail.com>
 */
include_once(MY_PLUGIN_PATH."utility_functions/cst-database_functions.php");

class Cst_cross_sell_timer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cst_cross_sell_timer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cst_cross_sell_timer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cst_cross_sell_timer-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name."font",'https://fonts.googleapis.com/css?family=Orbitron', array(), '', 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cst_cross_sell_timer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cst_cross_sell_timer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cst_cross_sell_timer-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'cst_script_ajax' , array( 'ajax_url' => admin_url('admin-ajax.php')) );


	}

	// // define the woocommerce_after_cart_contents callback 
	public function action_woocommerce_after_cart_contents() { 
		include_once("partials/cst_cross_sell_timer-public-display.php");
	}

	public function cst_get_end_time(){
		$cst_month = get_option( 'cst_cross_sell_date_month', 'Jan' );
 		
		// Set the days option
		$cst_day = get_option( 'cst_cross_sell_date_day', '01' );
		
		// set the year option
		$cst_year = get_option( 'cst_cross_sell_date_year', '2080' );
			
		// // Set the current hour option
		$cst_hour = get_option( 'cst_cross_sell_date_hour', '00' );
	
		// Set the current minutes option
		$cst_minutes = get_option( 'cst_cross_sell_date_minutes', '00' );
		
		// Set the current seconds option
		$cst_seconds = get_option( 'cst_cross_sell_date_seconds', '00' );
		echo $cst_month." ".$cst_day." ,".$cst_year." ".$cst_hour.":".$cst_minutes.":".$cst_seconds;
		die();
	 }
	 
	 public function cst_product_options_grouping(){

		die("Hello");
	}


	public function cst_woocommerce_cart_item_removed(){
		if(!_does_fomo_product_exist()){
			cst_remove_all_coupon_applied();
		}
	}

	public function cst_delete_fomo_products(){
		if(cst_delete_coupon_codes()){
			echo "Yes: Ended";
		}else{
			echo "No: Ended";	
		}
		die();
	}


}
