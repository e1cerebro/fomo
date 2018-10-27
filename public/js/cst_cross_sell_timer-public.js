(function($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */


    //Use ajax request to get the current expiry date that the user specified in the settings page

    function get_event_end_date() {

        var event_end_date;

        jQuery.ajax({
            url: cst_script_ajax.ajax_url,
            type: 'post',
            async: false,
            data: {
                action: 'cst_get_end_time',
            },
            success: function(response) {
                event_end_date = response;

            }
        });
        return event_end_date;
    }

    function cst_delete_fomo_products() {
        jQuery.ajax({
            url: cst_script_ajax.ajax_url,
            type: 'post',
            async: false,
            data: {
                action: 'cst_delete_fomo_products',
            },
            success: function(response) {
                console.log("Response: ", response);
                $(".fomo-product-section").remove();
            }
        });
    }




    var time_t = get_event_end_date();
    var deadline = new Date(time_t).getTime();



    //Check if the page has a cross sell products
    function countdown() {
        var now = new Date().getTime();
        var t = deadline - now;
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        var hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((t % (1000 * 60)) / 1000);



        if (t <= 0) {
            clearInterval(timer);
            $(".days").html(0);
            $(".hours").html("00");
            $(".minutes").html("00");
            $(".seconds").html("00");
            $(".timer-header-message").html("EXPIRED");
            cst_delete_fomo_products();
        } else {

            var hours = (hours < 10) ? "0" + hours : hours;
            var minutes = (minutes < 10) ? "0" + minutes : minutes;
            var seconds = (seconds < 10) ? "0" + seconds : seconds;

            $(".days").html(days);
            $(".hours").html(hours);
            $(".minutes").html(minutes);
            $(".seconds").html(seconds);
        }



    }
    var timer = setInterval(countdown, 1000);


})(jQuery);