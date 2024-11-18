<?php

/**
 * Google Maps API config
 */
$maps_api_key       = 'AIzaSyDzWuVeMAnzVi8ftq8cqMyRBL4zOoqoTQ4';
$maps_api_endpoint  = 'https://maps.google.com/maps/api/geocode/json?sensor=false';

require_once 'utils.php';

print_r(getGeoLocation("YO10 5DD"));