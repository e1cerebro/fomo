<?php

  
    /**
     * Function to save a new promo product
     * @args: array of products to insert to the database.
     */
    function cst_save_fomo_product($args){
        global $wpdb;
        $status = $wpdb->insert(FOMO_PRODUCT_TABLE, $args);
         $wpdb->flush();
        return $status;
    }

    /**
     * Update a FOMO product.
     * 
     */
    function cst_update_fomo_product($args, $table=FOMO_PRODUCT_TABLE, $key){
        global $wpdb;
        $status =  $wpdb->update($table,$args, array('fomo_product_id'=>intval($key)),array( '%d' ));
        $wpdb->flush();
        return $status;
    }

    /***
     * @Desc: Delete the product
     */
    function cst_delete_fomo_product($fomo_product_id){
        global $wpdb;
        $wpdb->delete(FOMO_PRODUCT_TABLE , array( 'fomo_product_id' => $fomo_product_id ) );
    }
    /***
     * @desc: This function checks if a product exists in the fFOMO table.
     * @arg1: Product ID
     * @arg2: $table name
     * 
     * @returns: boolean
     */
    function is_fomo_product_exist($fomo_product_id, $table=FOMO_PRODUCT_TABLE){
        
        global $wpdb;
        
        $result = $wpdb->get_results( "SELECT * FROM $table Where `fomo_product_id` =  '$fomo_product_id' " );
        $wpdb->flush();
        
        if(count($result) != '0'){
            return true;
        }else{
            return false;
        }

    }


    /***
     * @desc: Get all FOMO products
     * 
     * @return: array/ boolean
     */

    function cst_fomo_get_fomo_products($get_all = false, $limit=true){

        if(false == get_transient('all_fomo_products')){
                global $wpdb;
            
                if($get_all == false){

                    $fomo_products = $wpdb->get_results( "SELECT  `id`,`fomo_product_id`, `fomo_discount_amount`, `fomo_discount_code`, `fomo_discount_type` FROM ".FOMO_PRODUCT_TABLE." LIMIT ".get_option('cst_sales_items_count'));

                }else{
                    $fomo_products = $wpdb->get_results( "SELECT  `id`,`fomo_product_id`, `fomo_discount_amount`, `fomo_discount_code`, `fomo_discount_type` FROM ".FOMO_PRODUCT_TABLE);
                }

                $wpdb->flush();


                if(count($fomo_products) != '0'){
                    set_transient( 'all_fomo_products' , $fomo_products , 60*60*24 );
                    return $fomo_products;
                }else{
                    return false;
                }

        }else{
              return get_transient('all_fomo_products');

        }


        
    }

    function GetImageUrlsByProductId( $productId){
                
        // $product = new WC_product($productId);
        // $attachmentIds = $product->get_gallery_attachment_ids();
        // $imgUrls = array();
        // foreach( $attachmentIds as $attachmentId )
        // {
        //     $imgUrls[] = wp_get_attachment_url( $attachmentId );
        // }
        // return $imgUrls;

        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $productId ), 'single-post-thumbnail' );
        return $image[0];

    }

    function cst_create_dynamic_coupon($discount, $fomo_discount_type, $string_products){
        
        $coupon_code = "fomo_discount_".cst_generate_random_coupon_code()."_".$discount; // Code
        $amount = $discount; // Amount
        $discount_type = $fomo_discount_type; // Type: fixed_cart, percent, fixed_product, percent_product
                        
        $coupon = array(
            'post_title' => $coupon_code,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type'   => 'shop_coupon'
        );
                            
        $new_coupon_id = wp_insert_post($coupon);
                            
        //Add meta
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
        update_post_meta( $new_coupon_id, 'individual_use', 'no' );
        update_post_meta( $new_coupon_id, 'product_ids', $string_products);
        update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
        update_post_meta( $new_coupon_id, 'usage_limit', '' );
        update_post_meta( $new_coupon_id, 'expiry_date', '' );
        update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
        update_post_meta( $new_coupon_id, 'free_shipping', 'no' );

        return $coupon_code;

    }


    function cst_dynamically_apply_coupon($coupon_code){
        global $woocommerce;
         if (!$woocommerce->cart->add_discount( sanitize_text_field( $coupon_code ))) {
           // wc_print_notices();
        }

        wc_print_notices();
      }


      function cst_generate_random_coupon_code(){
            $seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.date('Y-m-dH:i:s')); 
            shuffle($seed);  
            $rand = '';
            foreach (array_rand($seed, 8) as $k) $rand .= $seed[$k];
            return $rand;
      }

      function cst_remove_all_coupon_applied(){

        global $woocommerce;
        foreach (cst_get_all_coupons() as $code) {
            $woocommerce->cart->remove_coupon($code->fomo_discount_code);
        }
        

      }

      function cst_get_all_coupons(){
            $coupons = array();
            global $wpdb;
            $coupons = $wpdb->get_results( "SELECT DISTINCT  `fomo_discount_code` FROM ".FOMO_PRODUCT_TABLE);
            $wpdb->flush();
            return $coupons;

      }

      function cst_delete_coupon_codes(){

            foreach (cst_fomo_get_fomo_products(true) as $product) {
                //Delete the product
               // cst_delete_fomo_product($product->fomo_product_id)
                //Remove coupon from cart
                cst_remove_cart_coupon($product->fomo_discount_code);
            }

            return true;
      }

      function _does_fomo_product_exist(){
            global $woocommerce;

            $items = $woocommerce->cart->get_cart();
            $product_exist = false;
            $fomo_products = array();
            //Check if there is a FOMO product in the cart and display the FOMO options
            foreach($items as $item => $values){
                $_product_id = wc_get_product($values['data']->get_id());
                if(get_post_meta($_product_id->id,'_add_fomo', 1) == 'yes'){
                    $product_exist = true;
                     break;
                }
            }

            return $product_exist;
      }


      function cst_remove_cart_coupon($code){
            global $woocommerce;
             $woocommerce->cart->remove_coupon($code);
       }

       function cst_get_promo_end_date(){
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
            return $cst_month." ".$cst_day.", ".$cst_year." ".$cst_hour.":".$cst_minutes.":".$cst_seconds;

       }


       function cst_get_time_diff(){
           $datetime1 = new DateTime(date("y-m-d H:i:s"));
           $datetime2 = new DateTime(cst_get_promo_end_date());
           $interval = $datetime1->diff($datetime2);
           return (int)$interval->format('%i');
       }