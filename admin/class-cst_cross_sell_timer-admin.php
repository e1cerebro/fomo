<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/admin
 * @author     UCHENNA NWACHUKWU <nwachukwu16@gmail.com>
 */
class Cst_cross_sell_timer_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		 wp_enqueue_style( 'datatable-css', 'https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css', "", "", false );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cst_cross_sell_timer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cst_cross_sell_timer-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script('jquery');

		wp_enqueue_script('jquery-datatable', 'https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', "", "", true);
		
		wp_enqueue_script( 'data-table', plugin_dir_url( __FILE__ ) . 'js/data-table.js', array( 'jquery' ), $this->version, true );
		

	}

	// Create the plugin admin menus
	public function cst_admin_menus(){
			add_menu_page( 
							__( 'FOMO', $this->plugin_name ),
							__( 'FOMO', $this->plugin_name ),
							'manage_options',
							'CrossSellTimer',
							array($this, 'cst_admin_menu_callback'),
							'dashicons-clock',
							6
						); 
			add_submenu_page( 
							'CrossSellTimer', //parent Page Slug
							__( '', $this->plugin_name ),
							__( '', $this->plugin_name ),
							'manage_options',  //Priviledge
							'CrossSellTimer', //Sub Menu Slug
							array($this, 'cst_admin_menu_callback')
			);

			add_submenu_page( 
								'CrossSellTimer', //parent Page Slug
								__( 'CSS Customization', $this->plugin_name ), //Page Title
								__( 'CSS Customization', $this->plugin_name ), //Menu Title
								'manage_options',  //Priviledge
								'css-customization', //Sub Menu Slug
								array($this, 'cst_css_customization_page_callback')

							);
			add_submenu_page( 
								'CrossSellTimer', //parent Page Slug
								__( 'FOMO Products', $this->plugin_name ), //Page Title
								__( 'FOMO Products', $this->plugin_name ), //Menu Title
								'manage_options',  //Priviledge
								'fomo-products-lists', //Sub Menu Slug
								array($this, 'cst_fomo_products_lists_callback')

							);
	}

	public function cst_product_options_grouping(){

		global $woocommerce, $post;
		// Checkbox
		woocommerce_wp_checkbox( 
			array( 
				'id'            => '_add_fomo', 
				'wrapper_class' => 'show_if_simple', 
				'label'         => __('Apply Special Discount', 'woocommerce' ),
				'desc_tip'    => 'true', 
				'description'   => __( 'Check this box if you want users to get a discount on other products when they add thisproduct to the cart!', 'woocommerce' ) 
				)
			);

			echo $post->ID;
	}


	public function cst_product_save_checkbox_qualified_for_fomo($post_id){

		$woocommerce_add_fomo = isset( $_POST['_add_fomo'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_add_fomo', $woocommerce_add_fomo );
	}


	public function cst_variation_settings_fields( $loop, $variation_data, $variation ) {
        woocommerce_wp_checkbox(
            array(
                'id'            => '_add_fomo[' . $variation->ID . ']',
                'label'         => __(' Apply Special Discount', 'woocommerce' ),
                'desc_tip'      => 'true',
                'description'   => __( 'Check this box if you want users to get a discount on other products when they add thisproduct to the cart!', 'woocommerce' ),
                'value'         => get_post_meta( $variation->ID, '_add_fomo', true ),
            )
        );

    }

    public function cst_product_save_checkbox_qualified_for_fomo_variable( $post_id ){
        // Checkbox
        $checkbox = isset( $_POST['_add_fomo'][ $post_id ] ) ? 'yes' : 'no';
        update_post_meta( $post_id, '_add_fomo', $checkbox );
    }


	/* 
		@Desc: This section contains the callback to all the functions to our admin wordpress page 
		@Pages: 1. cst_admin_menu_callback
				2. 
	*/
	public function cst_admin_menu_callback(){
		include_once('partials/cst_cross_sell_timer-admin-display.php');
	}
	public function cst_css_customization_page_callback(){
		include_once('partials/cst-css-customization.php');
	}
	public function cst_fomo_products_lists_callback(){
		include_once('partials/cst-add-fomo-product-settings.php');
	}


	/* This section contains the callback to all the functions to our admin wordpress page */

	public function cst_cross_sell_register_settings(){

		include_once('partials/settings-fields/cst-register-settings-fields.php');
		
	}

	public function cst_sales_end_date_field_callback(){
		include_once('partials/settings-fields/cst-fomo-page.php');
	}

	public function cst_cross_sell_placement_field_callback(){
        $value = get_option('cst_cross_sell_placement_field');
        $top    = ( 'Top' == $value ) ? "selected" : '';
        $Bottom = ( 'Bottom' == $value ) ? "selected" : '';
        $Both   = ( 'Both' == $value ) ? "selected" : '';

        echo "<select name='cst_cross_sell_placement_field' id='cst_cross_sell_placement_field'>";
              echo "<option  ".$top." value='Top'>Top</option>";
              echo "<option ".$Bottom." value='Bottom'>Bottom</option>";
              echo "<option  ".$Both." value='Both'>Both</option>";

         echo "</select>";

    }

	public function cst_sales_items_count_field_field_callback(){
        $value = get_option('cst_sales_items_count');

        echo "<select name='cst_sales_items_count' id='cst_sales_items_count'>";
        echo "<option value=''>---Select---</option>";
        for($count = 0 ; $count < 11; $count++):
            $selected = ( $count == $value) ? "selected" : '';
            echo "<option ".$selected." value='".$count."'>".$count."</option>";
        endfor;
        echo "</select>";


    }




	public function cst_sales_title_field_callback(){
		$header_title = get_option('cst_cross_sell_title');
		echo "<input style='width:46%;' type='text' placeholder ='Enter the title of the sales ' name='cst_cross_sell_title' value='".$header_title."'>";
	}
	/*This is a function to create the Section title field on the admin page*/
	public function cst_sales_section_title_field_callback(){
		$value = get_option('cst_sales_section_title');
		echo "<input style='width:46%;' type='text' placeholder ='Enter the title of the sales ' name='cst_sales_section_title' value='".$value."'>";
	}
	public function cst_sales_footer_title_field_callback(){
		$cst_footer_title = get_option('cst_sales_footer_title');
		echo "<input style='width:46%;' type='text' placeholder ='Enter the title of the sales ' name='cst_sales_footer_title' value='".$cst_footer_title."'>";
	}

	/*Function to display the sales completed field on the admin section*/
	public function cst_sales_time_complete_message_field_callback(){
		$cst_completed_message = get_option('cst_sales_time_complete_message');
		echo "<input style='width:46%;' type='text' placeholder ='Sales Completed Message' name='cst_sales_time_complete_message' value='".$cst_completed_message."'>";
	}



	public function cst_sales_timer_notify_admin_field_callback(){
		$cst_notify_admin = get_option('cst_sales_timer_notify_admin');
		echo "<label for='cst_sales_timer_notify_admin'> <input type='checkbox' id='cst_sales_timer_notify_admin' name='cst_sales_timer_notify_admin' name=''  checked> Notify By Email When Timer Ends</label>";
	}

	public function cst_sales_information_callback(){
		echo "Section description";
	}

	public function cst_sales_timer_settings_callback(){
		echo "Adjust the settings for the sales timer";
	}
	
	public function cst_sanitize_cross_settings_options($input){
	    delete_transient('all_fomo_products');
		return $input;
	}

}
