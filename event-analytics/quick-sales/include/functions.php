<?php

function get_data_table($cron_name) {
    return "{$cron_name}_scrapped_data";
}

function getlastfriday($before = null) {

    if($before == null) {
        $before = time();
    }

    //Make Sunday the 3rd day of week
    $dayofweek = date('w', $before) + 2;
    //Make it circle around
    if($dayofweek > 6) { $dayofweek -= 7; }

    //Substract the number of seconds since last friday
    //Friday is 0 so simply substruct $dayofweek days from $before
    $date = substractday($before, $dayofweek);

    //Friday 5:00PM is the point
    $friday = addhour(strtotime(date('d-m-Y', $date)), 17);

    return $friday;
}

function getnextfriday($after = null) {
    if($after == null) {
        $after = time();
    }

    //Make Sunday the 3rd day of week
    $dayofweek = date('w', $after) + 2;
    //Make it circle around
    if($dayofweek > 6) { $dayofweek -= 7; }

    //Add the number of seconds until next friday
    //Friday rotates to 0 so simply add 7 - $dayofweek days with $after
    $date = addday($after, 7 - $dayofweek);
    
    //Friday 5:00PM is the point
    $friday = addhour(strtotime(date('d-m-Y', $date)), 17);

    return $friday;
}

function substracthour($timestamp, $hour = 1) {
    return $timestamp - ($hour * 60 * 60);
}

function addhour($timestamp, $hour = 1) {
    return $timestamp + ($hour * 60 * 60);
}

function substractday($timestamp, $day = 1) {
    return $timestamp - ($day * 24 * 60 * 60);
}

function addday($timestamp, $day = 1) {
    return $timestamp + ($day * 24 * 60 * 60);
}
