<?php

        $months = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July ',
            'August',
            'September',
            'October',
            'November',
            'December',
        );


        // Set the month option
        $cst_month = get_option( 'cst_cross_sell_date_month', 'Null' );
        $cst_selected_month;
        echo "<div class='cst-data-field'> ";
        echo "<span class='cst-description'>Month: </span>";
        echo "<select name='cst_cross_sell_date_month' id=''>";
            echo "<option value=''>Month</option>";
            foreach($months as $month):
                $cst_selected_month = ( $month == $cst_month) ? "selected" : '';
                echo "<option ".$cst_selected_month." value='".$month."'>".$month."</option>";
            endforeach;
        echo "</select>";
        echo "</div>";

        // Set the days option
        $cst_day = get_option( 'cst_cross_sell_date_day', 'Null' );
        $cst_selected_day;
        echo "<div class='cst-data-field'> ";
        echo "<span class='cst-description'>Day:  </span>";
        echo "<select name='cst_cross_sell_date_day' id=''>";
            echo "<option value=''>Day</option>";
            for($i = 1 ; $i <= 31; $i++):
                $cst_selected_day = ( $i == $cst_day) ? "selected" : '';
                echo "<option ".$cst_selected_day." value='".$i."'>".$i."</option>";
            endfor;
        echo "</select>";
        echo "</div>";

        // set the year option
        $cst_year = get_option( 'cst_cross_sell_date_year', 'Null' );
        $current_year = date('Y');
        $cst_selected_year;
        echo "<div class='cst-data-field'> ";
        echo "<span class='cst-description'>Year: </span>";
        echo "<select name='cst_cross_sell_date_year' id='cst_cross_sell_date_year'>";
                    echo "<option value=''>Year</option>";
            for($current_year ; $current_year <= 2100; $current_year++):
                $cst_selected_year = ( $current_year == $cst_year) ? "selected" : '';
                echo "<option ".$cst_selected_year." value='".$current_year."'>".$current_year."</option>";
            endfor;
        echo "</select>";
        echo "</div>";

        // // Set the current hour option
        $cst_hour = get_option( 'cst_cross_sell_date_hour', 'Null' );
        echo "<div class='cst-data-field'> ";
        echo "<span class='cst-description'>Hour: </span>";
        echo "<select name='cst_cross_sell_date_hour' id='cst_cross_sell_date_hour'>";
            echo "<option value=''>Hour</option>";
            for($hour = 1 ; $hour <= 24; $hour++):
                $cst_selected_hour = ( $hour == $cst_hour) ? "selected" : '';
                echo "<option ".$cst_selected_hour." value='".$hour."'>".$hour."</option>";
            endfor;
        echo "</select>";
        echo "</div>";

        // Set the current minutes option
        $cst_minutes = get_option( 'cst_cross_sell_date_minutes', 'Null' );
        echo "<div class='cst-data-field'> ";
echo "<span class='cst-description'>Minutes: </span>";
        echo "<select name='cst_cross_sell_date_minutes' id='cst_cross_sell_date_minutes'>";
            echo "<option value=''>Minutes</option>";
            for($minutes = 0 ; $minutes < 60; $minutes++):
                $cst_selected_minutes = ( $minutes == $cst_minutes) ? "selected" : '';
                echo "<option ".$cst_selected_minutes." value='".$minutes."'>".$minutes."</option>";
            endfor;
        echo "</select>";
        echo "</div>";

        // Set the current seconds option
        $cst_seconds = get_option( 'cst_cross_sell_date_seconds', 'Null' );
        echo "<div class='cst-data-field'> ";
        echo "<span class='cst-description'>Seconds: </span>";
        echo "<select name='cst_cross_sell_date_seconds' id='cst_cross_sell_date_seconds'>";
            echo "<option value=''>Seconds</option>";
            for($seconds = 0 ; $seconds < 60; $seconds++):
                $cst_selected_seconds = ( $seconds == $cst_seconds) ? "selected" : '';
                echo "<option ".$cst_selected_seconds." value='".$seconds."'>".$seconds."</option>";
            endfor;
        echo "</select>";
        echo "</div>";



