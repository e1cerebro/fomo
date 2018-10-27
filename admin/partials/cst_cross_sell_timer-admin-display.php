<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Cst_cross_sell_timer
 * @subpackage Cst_cross_sell_timer/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h2><?php echo get_admin_page_title(); ?></h2>
<?php echo settings_errors();?>
<form action="options.php" method="post">
    
    <?php settings_fields( 'cst_cross_sell_option_group' ); ?>
 
    <?php do_settings_sections( 'CrossSellTimer' ); ?>

    <?php submit_button(); ?>
    
</form>
