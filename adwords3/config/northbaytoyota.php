<?php

global $CronConfigs;
$CronConfigs["northbaytoyota"] = array(
    'password' => 'northbaytoyota',
    "email" => "regan@smedia.ca",
    'log' => true,
    'max_cost' => 2450,
    'cost_distribution' => array(),
    'new_title' => "[year(2)] [make(1)] [model]",
    "create" => array(
        "new_search" => true,
),
    "new_descs" => array(
        array(
            "desc1" => "Test Drive the [year]",
            "desc2" => "[make] [model] today.",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today.",
),
),
    "used_descs" => array(
        array(
            "desc1" => "Test Drive our [year]",
            "desc2" => "[make] [model] today.  Stock number- [stock_number]",
),
        array(
            "desc1" => "Call us today about the ",
            "desc2" => "[year] [make] [model] today.  Stock number- [stock_number]",
),
),
    //======smart offer=====
    "lead" => null,
    //=====dynamic social ads=====
    // "fb_title" => "[year] [model]  [lease] weekly",
    "fb_new_title" => "[year] [make] [model] [lease] + HST weekly",
    'fb_used_title' => '[year] [make] [model] [price]',
    'customer_id' => '548-413-5794',
    'fb_brand' => '[year] [make] [model] - [body_style]',
    "banner" => array(
        "template" => "northbaytoyota",
        "fb_description_2017_toyota" => "Are you still interested in our [Year] [Make] [Model]? Click for more info. Stock #: [stock_number]",
        "fb_description_used" => "Are you still interested in our [Year] [Make] [Model]? Click for more info! Stock #: [stock_number]",
        //"fb_description_new" => "Priced to sell!  [Year] [Make] [Model] Plus ZERO Maintenance for 4 Years with every new in-stock Toyota purchased or leased in December!. Lease [finance_term] from [lease]*.\nZERO Maintenance on ALL in-stock new models\n- Don’t pay for oil changes\n- Don’t pay for brakes\n- Don’t pay for tires\n- Not even wipers\nIncludes 4 year Platinum ECP Warranty! Click to view special offers.",
        "fb_description_new" => "Lease the [Year] [Make] [Model] [Trim] from [lease] + HST weekly at [finance_rate] for [finance_term]. Cash price [price]+HST. *See dealer for details.",
        "fb_lookalike_description_used" => "Check out our [Year] [Make] [Model] today! Click for more info.",
        "fb_lookalike_description_new" => "Check out our [Year] [Make] [Model] [Trim] today! Lease from [lease] + HST weekly at [finance_rate] for [finance_term]. Cash price [price]+HST. *See dealer for details.",
        "fb_2019clearout_description_new" => "Get Employee Pricing on remaining 2019 inventory! See dealer for more details.",
        "fb_barelyusedblowout_description" => "These former rental vehicles must go! Get a low kms, current model year vehicle with warranty at an unbelievable price! ",
        "fb_dynamiclead_description_new" => "Still interested in our [year] [make] [model]? Click below, fill in your info and a product specialist will be in touch to aid in any questions.",
        "fb_dynamiclead_description_used" => "Still interested in our [year] [make] [model]? Click below, fill in your info and a product specialist will be in touch to aid in any questions. Stock #: [stock_number]",
        "flash_style" => "default",
        "border_color" => "#282828",
        "styels" => array(
            "new_display" => "dynamic_banner",
            "used_display" => "custom_banner",
            "new_retargeting" => "dynamic_banner",
            "used_retargeting" => "custom_banner",
            "new_marketbuyers" => "dynamic_banner",
            "used_marketbuyers" => "custom_banner",
),
        "show_stock" => 'yes',
        //TO SHOW STOCK NUMBER
        'fb_style' => 'facebook_new_ad',
        "font_color" => "#ffffff",
),
);
// they dont want to pull data from catalog they want to pull data from inventory only. thats why the bellow previous codes are commented
// task link https://app.asana.com/0/687248649257779/1135952082198399
//https://app.asana.com/0/687248649257779/1200770787970302
add_filter('filter_northbaytoyota_description', 'filter_northbaytoyota_description', 10, 2);
function filter_northbaytoyota_description($descs, $car)
{
    if ($car['stock_type'] == 'used') {
        return $descs;
    }
    $retval = [];
    if (numarifyPrice($car['lease']) > 0) {
        $retval[] = [
            'title2' => processTextTemplate("Book a Test Drive Today", $car),
            "title3" => "Check Out Our Special Offers",
            //'desc' => processTextTemplate('For [finance_term] at [finance_rate] with $0 Down. Offer Ends Soon. Don’t Wait!', $car),
            'description' => processTextTemplate('Explore Our Full Toyota Lineup to Find Your Perfect Car.', $car),
            'description2' => processTextTemplate('Low Interest Rates. $0 Cash Down', $car),
];
        $retval[] = [
            'title2' => "See Deals & Incentives",
            "title3" => "Full Service Toyota Dealer",
            // 'desc' => processTextTemplate('[finance_rate] Lease Rate with $0 Down. Call Today & Schedule A Test Drive!', $car),
            'description' => "Huge Selection of Toyota Inventory",
            'description2' => processTextTemplate('Get Pricing, Payment & Lease Info. Book a test drive', $car),
];
    }
    if (numarifyPrice($car['finance']) > 0) {
        $retval[] = [
            'title2' => processTextTemplate('Finance From [finance] Weekly', $car),
            'desc' => processTextTemplate('For [finance_term] at [finance_rate] with $0 Down. Request a Quote!', $car),
];
    }
    return $retval;
}
add_filter('filter_northbaytoyota_banner_params', 'filter_northbaytoyota_banner_params', 10);
function filter_northbaytoyota_banner_params($params)
{
    if (strpos($params['type'], 'new') !== false) {
        $params['price'] = $params['lease'];
    }
    return $params;
}