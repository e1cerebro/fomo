<?php

// Month settings
register_setting(
    'cst_cross_sell_option_group',
    'cst_cross_sell_date_month',
    array($this, 'cst_sanitize_cross_settings_options')
);

// Year settings
register_setting(
    'cst_cross_sell_option_group',
    'cst_cross_sell_date_year'
//array($this, 'cst_sanitize_cross_settings_options')
);

// Day settings
register_setting(
    'cst_cross_sell_option_group',
    'cst_cross_sell_date_day'
//array($this, 'cst_sanitize_cross_settings_options')
);

// Hour settings
register_setting(
    'cst_cross_sell_option_group',
    'cst_cross_sell_date_hour'
//array($this, 'cst_sanitize_cross_settings_options')
);

// Minutes settings
register_setting(
    'cst_cross_sell_option_group',
    'cst_cross_sell_date_minutes'
//array($this, 'cst_sanitize_cross_settings_options')
);

// Seconds settings
register_setting(
    'cst_cross_sell_option_group',
    'cst_cross_sell_date_seconds'
//array($this, 'cst_sanitize_cross_settings_options')
);
//Create a settings field on the admin page for the date
add_settings_field(
    "cst_sales_end_date_field",
    "Sales End Date",
    array($this, 'cst_sales_end_date_field_callback'),
    'CrossSellTimer',
    'cst_sales_timer_settings',
    array()
);


//////////////////////////////////////////////
/// SALES TIMER PLACEMENT
//////////////////////////////////////////////
// Timer Placement
register_setting(
    'cst_cross_sell_option_group',
    'cst_cross_sell_placement_field'
//array($this, 'cst_sanitize_cross_settings_options')
);

add_settings_field(
    "cst_sales_timer_placement_field",
    "Sales Timer Placement",
    array($this, 'cst_cross_sell_placement_field_callback'),
    'CrossSellTimer',
    'cst_sales_timer_settings',
    array()
);


//////////////////////////////////////////////
/// SALES TIMER PLACEMENT
//////////////////////////////////////////////
// Timer Placement
register_setting(
    'cst_cross_sell_option_group',
    'cst_sales_items_count'
//array($this, 'cst_sanitize_cross_settings_options')
);

add_settings_field(
    "cst_sales_items_count_field",
    "Sales Items To Display",
    array($this, 'cst_sales_items_count_field_field_callback'),
    'CrossSellTimer',
    'cst_sales_timer_settings',
    array()
);





    //////////////////////////////////////////////
/// SALES HEADER TITLE
   //////////////////////////////////////////////

    register_setting( 
        'cst_cross_sell_option_group',
        'cst_cross_sell_title' 
        //array($this, 'cst_sanitize_cross_settings_options')
    );

    add_settings_field(
        "cst_sales_title_field",
        "Sales Header Title",
        array($this, 'cst_sales_title_field_callback'),
        'CrossSellTimer',
        'cst_sales_information',
        array()
    );


//////////////////////////////////////////////
///  SECTION HEADER TITLE
//////////////////////////////////////////////

    register_setting(
        'cst_cross_sell_option_group',
        'cst_sales_section_title'
        //array($this, 'cst_sanitize_cross_settings_options')
    );

    add_settings_field(
        "cst_sales_section_title_field",
        "Sales Section Title",
        array($this, 'cst_sales_section_title_field_callback'),
        'CrossSellTimer',
        'cst_sales_information',
        array()
    );



//////////////////////////////////////////////
/// FOOTER TITLE
//////////////////////////////////////////////
    register_setting(
        'cst_cross_sell_option_group',
        'cst_sales_footer_title'
        //array($this, 'cst_sanitize_cross_settings_options')
    );

    add_settings_field(
        "cst_sales_footer_title_field",
        "Sales Footer Title",
        array($this, 'cst_sales_footer_title_field_callback'),
        'CrossSellTimer',
        'cst_sales_information',
        array()
    );

//////////////////////////////////////////////
///  SALES COMPLETED MESSAGE
//////////////////////////////////////////////

/*
 * Register the field in the database:
 *  @param 2 (cst_sales_time_complete_message) :
 *  is the name we can use to retrieve the settings from the database.
*/
register_setting(
    'cst_cross_sell_option_group',
    'cst_sales_time_complete_message'
//array($this, 'cst_sanitize_cross_settings_options')
);

add_settings_field(
    "cst_sales_time_complete_message_field",
    "Sales Completed Message",
    array($this, 'cst_sales_time_complete_message_field_callback'),
    'CrossSellTimer',
    'cst_sales_information',
    array()
);

//////////////////////////////////////////////
///  NOTIFY ADMIN WHEN SALES ENDS
//////////////////////////////////////////////


    register_setting( 
        'cst_cross_sell_option_group',
        'cst_sales_timer_notify_admin' 
        //array($this, 'cst_sanitize_cross_settings_options')
    );

    /*
     * add the field to the admin section:
    */
    add_settings_field(
        "cst_sales_timer_notify_admin_field", //field ID
        "Notify Admin When Sales Ends", //Field Label
        array($this, 'cst_sales_timer_notify_admin_field_callback'), //Function to create the field
        'CrossSellTimer', //page slug
        'cst_sales_information',  //Section where the field will be placed
        array()
    );



    add_settings_section(
        "cst_sales_timer_settings",
        "Timer Settings",
        array($this, 'cst_sales_timer_settings_callback'),
        'CrossSellTimer'
    );

    add_settings_section(
            "cst_sales_information",
            "Sales Information",
            array($this, 'cst_sales_information_callback'),
            'CrossSellTimer'
    );
















