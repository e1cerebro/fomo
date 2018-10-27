<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/includes
 * @author     UCHENNA NWACHUKWU <nwachukwu16@gmail.com>
 */
class Cst_cross_sell_timer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Cst_cross_sell_timer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'cst_cross_sell_timer';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Cst_cross_sell_timer_Loader. Orchestrates the hooks of the plugin.
	 * - Cst_cross_sell_timer_i18n. Defines internationalization functionality.
	 * - Cst_cross_sell_timer_Admin. Defines all hooks for the admin area.
	 * - Cst_cross_sell_timer_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cst_cross_sell_timer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-cst_cross_sell_timer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-cst_cross_sell_timer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-cst_cross_sell_timer-public.php';

		$this->loader = new Cst_cross_sell_timer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Cst_cross_sell_timer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Cst_cross_sell_timer_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Cst_cross_sell_timer_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin,'cst_admin_menus'); 
		$this->loader->add_action( 'woocommerce_product_options_general_product_data', $plugin_admin,'cst_product_options_grouping'); 
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin,'cst_product_save_checkbox_qualified_for_fomo'); 

		/*Creating the meta field for the variable product*/
		$this->loader->add_action( 'woocommerce_product_after_variable_attributes', $plugin_admin,'cst_variation_settings_fields', 10, 3 );
        $this->loader->add_action( 'woocommerce_save_product_variation', $plugin_admin,'cst_product_save_checkbox_qualified_for_fomo_variable', 10, 2 );

        $this->loader->add_action( 'admin_init', $plugin_admin,'cst_cross_sell_register_settings');
		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Cst_cross_sell_timer_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
 		$this->loader->add_action( 'woocommerce_after_cart_table', $plugin_public,'action_woocommerce_after_cart_contents', 10, 0 ); 
 		$this->loader->add_action( 'woocommerce_before_checkout_form', $plugin_public,'cst_woocommerce_cart_item_removed', 10 );
		$this->loader->add_action( 'wp_ajax_nopriv_cst_get_end_time', $plugin_public, 'cst_get_end_time' );
		$this->loader->add_action( 'wp_ajax_cst_get_end_time', $plugin_public, 'cst_get_end_time' );
		$this->loader->add_action( 'wp_ajax_nopriv_cst_delete_fomo_products', $plugin_public, 'cst_delete_fomo_products' );
		$this->loader->add_action( 'wp_ajax_cst_delete_fomo_products', $plugin_public, 'cst_delete_fomo_products' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Cst_cross_sell_timer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
