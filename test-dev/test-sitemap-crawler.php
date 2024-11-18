<?php

/* SMEDIA DIRECTORY MAPPING */
$base_dir    = dirname(__DIR__);
$adwords_dir = "{$base_dir}/adwords3";

require_once "{$adwords_dir}/config.php";
require_once "{$adwords_dir}/db_connect.php";
require_once "{$adwords_dir}/utils.php";

$site                 = "https://www.echovalleygm.com/sitemap.xml";
$vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}/';
$images_regx          = '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/i';
$images_fallback_regx = '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/i';
$required_params      = []; // Mandatory url parameters
$use_proxy            = true; // Uses proxy to reach site
$keymap               = null; // Return the output data mapped against any car key
$invalid_images       = ['photo_unavailable_320.gif']; // List of image urls to be filtered out
$use_custom_site      = true; // Force crawler to use the given url as sitemap url

$annoy_func = function ($car) {
    // filter stock_numbers
    $drop_stocks = ['20257', '16334', '22567', '18043'];

    if (in_array($car['stock_number'], $drop_stocks)) {
        return [];
    }

    // filter model
    $car_data['model'] = str_replace(['&', ';'], [' and ', ''], $car_data['model']);

    // image filter
    $imgs = explode("|", $car['all_images']);
    if (count($imgs) < 2) {
        return [];
    }

    return $car;
};

$data_capture_regx_full = [
    'stock_type'     => '/"category":"(?<stock_type>[^"]+)","/i',
    'year'           => '/","year":"(?<year>[^"]+)","/i',
    'make'           => '/","make":"(?<make>[^"]+)","/i',
    'model'          => '/","model":"(?<model>[^"]+)","/i',
    'trim'           => '/","trim":"(?<trim>[^"]+)","/i',
    'stock_number'   => '/,"stockNumber":"(?<stock_number>[^"]+)","/',
    'exterior_color' => '/","exterior":"(?<exterior_color>[^"]+)","/',
    'interior_color' => '/","interior":"(?<interior_color>[^"]+)","/',
    'price'          => '/<span not="pinBasedDealerPricingFeatureEnabled" itemprop="price"[^<]+>(?<price>[^<]+)<\/span>/',
    'msrp'           => '/","msrp":(?<msrp>[^,]+),/',
    'engine'         => '/<span class="value" itemprop="vehicleEngine">(?<engine>[^<]+)<\/span>/',
    'transmission'   => '/","transmission":"(?<transmission>[^"]+)"/',
    'drivetrain'     => '/<span class="value" itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)<\/span>/',
    'kilometres'     => '/","miles":"(?<kilometres>[^"]+)","/',
    'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
    'vin'            => '/","vin":"(?<vin>[^"]+)","/',
    'vehicle_id'     => '/<a rel="nofollow" data-vehicleid="(?<vehicle_id>[^"]+)"/',
    'custom'         => '/<span itemprop="mpn">(?<custom>[^<]+)<\/span>/',
    'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
];

// Uncomment the line below to check if it can get VDP
// print_r(checkSitemap($site, $vdp_url_regex));exit();

$cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

print_r($cars);

function checkSitemap($site, $vdp_url_regex)
{
    return classifyURLs(getSitemap("{$site}"), ['vdp' => $vdp_url_regex]);
}
