<?php
        global $wpdb;

        include_once(MY_PLUGIN_PATH."utility_functions/cst-database_functions.php");
        if(isset($_POST['delete_fomo_product'])){
            $fomo_product_ID = $_POST['product_id'];
            cst_delete_fomo_product($fomo_product_ID);
            echo "<meta http-equiv='refresh' content='0'>";

        }

        //get all the product from the product table
        // Configure the args to fetch all the products from the database wp_posts table
        $args = array( 
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => -1,
            'post_type'           => 'product',
            'post_status'         => 'publish', 
            'orderby' => 'post_title',
            'order' => 'ASC'
            );

            /* Initialize the query object */
            $the_query = new WP_Query( $args );
            $show_success = '';
            /* Fetch all the posts */
            $products  = $the_query->get_posts();

            if(isset($_POST['submit'])){

                //Get the list of fomo product details.
                $all_fomo_products     = $_POST['fomo_product_list'];
                $fomo_discount_amount  = $_POST['fomo_discount_amount'];
                $fomo_discount_type    = $_POST['fomo_discount_type'];

                //implode the product array to form the string element for creating coupons
                $string_products       =  implode(",", $all_fomo_products);        
                //Create a dynamic coupon code for 
                $fomo_discount_code    = cst_create_dynamic_coupon($fomo_discount_amount, $fomo_discount_type, $string_products);

                //loop through the products
                foreach($all_fomo_products as $fomo_product){
                    $args = array(
                        'fomo_product_id'            =>  $fomo_product,
                        'fomo_discount_amount'       =>  $fomo_discount_amount,
                        'fomo_discount_code'         =>  $fomo_discount_code,
                        'fomo_discount_type'         =>  $fomo_discount_type,
                        'date_submitted'             =>  date('Y-m-d H:i:s'),
                    );
                    
                    //check if the product exist
                    if(!is_fomo_product_exist($args)){
                        //save product
                        $show_success =  cst_save_fomo_product($args);
                    }
                }
           }

?>
<?php if($show_success): ?>
    <div class="notice notice-success is-dismissible"> 
        <p><strong>Settings saved.</strong></p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
<?php elseif($show_success == '0'): ?>
    <div class="notice notice-error is-dismissible"> 
        <p><strong>Settings could not be saved.</strong></p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
<?php endif; ?>


<div class="fomo-settings-page">
    <div class="fomo-form-section">
        <div class="fomo-form-body">
        <div class="fomo-form-heading"> <h2>Add A New Product</h2> </div>

            <form action="" method="post" class="fomo-form">
                <select class="fomo-multi-select" name="fomo_product_list[]" id="" multiple>
                     <?php foreach ($products as $product): ?>
                        <option value="<?php echo esc_attr_e($product->ID); ?>"><?php echo  esc_attr_e($product->post_title); ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" min="1" name="fomo_discount_amount" value="1"/>
                <select name="fomo_discount_type" id="fomo_discount_type">
                     <option value="fixed_cart">Fixed cart discounts </option>
                    <option value="percent_product">Percentage discounts</option>
                    <option value="fixed_product">Fixed product discounts</option>
                 </select>
                <?php submit_button(); ?>
            </form>
        </div>
        <div class="fomo-product-list">
        <div class="fomo-form-heading">
            <h2>All Registered Products</h2> </div>

        <table id="fomo-table">
        <thead>
            <tr>
                <th style="text-align:center;">Id</th>
                <th style="text-align:center;">Product Name</th>
                <th style="text-align:center;">Discount Rate</th>
                <th style="text-align:center;">Discount Type</th>
                <th style="text-align:center;">Discount Code</th>
				<th style="text-align:center;"> Edit </th>
                <th style="text-align:left;"> Delete </th>
            </tr>
        </thead>
        <tbody>
           <?php $count = 0; foreach(cst_fomo_get_fomo_products(true) as $product): ?>
		    <tr>
                <td data-search="Tiger Nixon" style="text-align:center;"><?php echo ++$count; ?></td>
                <td style="text-align:center;"><?php  esc_attr_e( get_the_title( $product->fomo_product_id )); ?></td>
                <td style="text-align:center;"><?php esc_attr_e($product->fomo_discount_amount);?></td>
                <td style="text-align:center;"><?php $discount_type=explode("_",$product->fomo_discount_type); esc_attr_e(ucfirst($discount_type[0])." ".ucfirst($discount_type[1]));?></td>
                <td style="text-align:center;"><?php esc_attr_e($product->fomo_discount_code);?></td>
                <td style="text-align:center;"><button class="fomo-edit-button">Edit</button> </td>
                <td style="text-align:center;"> 
                    <form action="" method="POST">
                        <input type="hidden" name="product_id"  value="<?php echo $product->fomo_product_id; ?>"/>
                        <button type="submit" name="delete_fomo_product" class="fomo-delete-button">Delete</button>

                    </form>
            
                </td>
            </tr>  
        <?php endforeach;?>
        </tbody>
    </table>
        </div>
      
    </div>
</div>

	