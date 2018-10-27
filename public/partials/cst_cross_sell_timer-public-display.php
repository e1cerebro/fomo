<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/public/partials
 */
    //Include the  global functions
    include_once(MY_PLUGIN_PATH."utility_functions/cst-database_functions.php");

    global $woocommerce;

    if(isset($_POST['submit'])){
        $product_id = $_POST['fomo-product-id'];
        $woocommerce->cart->add_to_cart($product_id);
        // Dynamically apply coupon code to the product that the user added
           cst_dynamically_apply_coupon($_POST['fomo-discount-code']);
           echo "<meta http-equiv='refresh' content='0'>";

    }

    $items = $woocommerce->cart->get_cart();
    $display_fomo_section = false;
    $fomo_products = array();
    //Check if there is a FOMO product in the cart and display the FOMO options
    foreach($items as $item => $values){
        $_product_id = wc_get_product($values['data']->get_id());
        if(get_post_meta($_product_id->id,'_add_fomo', 1) == 'yes'){
            $display_fomo_section = true;
            $fomo_products = cst_fomo_get_fomo_products(false, true);
            break;
        }
    }

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php if(cst_get_time_diff() > 0): ?>
     <?php if($display_fomo_section):?>

         <?php if( 'Top' == get_option('cst_cross_sell_placement_field') || 'Both' == get_option('cst_cross_sell_placement_field')): ?>
             <?php include('snippets/cst-timer-clock.php'); ?>

         <?php  endif; ?>
    
    <div class="fomo-product-section">
            <h2 class="fomo-header-title"><?php echo get_option('cst_sales_section_title', 'Hot Deals'); ?></h2>
        <?php if($fomo_products != false): ?>
            <div class="fomo-product-rows">

            <?php foreach ($fomo_products as $fomo_product): ?>
                    <div class="fomo-product-row">
                        <div class="fomo-single-product">
                            <a href="<?php echo get_permalink( $fomo_product->fomo_product_id); ?>">
                                <img class="fomo-product-image" src="<?php echo GetImageUrlsByProductId( $fomo_product->fomo_product_id); ?>" alt="">
                            </a>
                        </div>
                        <div class="fomo-product-title">
                            <p>
                                <a href="<?php echo get_permalink( $fomo_product->fomo_product_id); ?>"> <?php esc_attr_e( get_the_title( $fomo_product->fomo_product_id )); ?>
                                    <?php if('fixed_product' == $fomo_product->fomo_discount_type): ?>
                                        <span class="fomo-percent-off">(<?php echo	get_woocommerce_currency_symbol().$fomo_product->fomo_discount_amount; ?> OFF)</span>
                                    <?php elseif('percent_product' == $fomo_product->fomo_discount_type): ?>
                                        <span class="fomo-percent-off">(<?php echo $fomo_product->fomo_discount_amount; ?>% OFF)</span>
                                    <?php elseif('fixed_cart' == $fomo_product->fomo_discount_type): ?>
                                        <span class="fomo-percent-off">(<?php echo	get_woocommerce_currency_symbol().$fomo_product->fomo_discount_amount; ?> OFF)</span>
                                    <?php endif;?>
                                </a>
                            </p>
                        </div>
                        <?php if( strlen(wc_get_product($fomo_product->fomo_product_id)->get_regular_price()) > 0):?>

                        <div class="fomo-product-price">

                                <p><?php echo get_woocommerce_currency_symbol().wc_get_product($fomo_product->fomo_product_id)->get_regular_price();?></p>


                        </div>
                        <div class="fomo-add-to-cart">
                            <form action="" method="POST">
                                <input name="fomo-product-id" type="hidden" value="<?php echo $fomo_product->fomo_product_id; ?>">
                                <input name="fomo-discount-code" type="hidden" value="<?php echo $fomo_product->fomo_discount_code; ?>">
                                <button type="submit" name="submit" class="fomo-add-to-cart-button"><?php  esc_attr_e('Add to cart', $this->plugin_name);?></button>
                            </form>
                        </div>
                        <?php else:?>
                            <p></p>
                        <?php endif;?>
                    </div>

            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

     <?php if( 'Bottom' == get_option('cst_cross_sell_placement_field') || 'Both' == get_option('cst_cross_sell_placement_field')): ?>
        <?php include('snippets/cst-timer-clock.php'); ?>
     <?php  endif; ?>
    <?php else: ?>
    <?php cst_remove_all_coupon_applied(); ?>
    <?php endif; ?> 

<?php endif; ?>