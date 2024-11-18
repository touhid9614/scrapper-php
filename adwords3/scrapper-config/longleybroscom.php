<?php

global $scrapper_configs;
$scrapper_configs["longleybroscom"] = array(
    'entry_points'        => array(
        'new' => 'https://www.longleybros.com/searchnew.aspx'
    ),
    'vdp_url_regex'       => '/\/(?:new|used|certified)\-[^\-]+\-[0-9]{4}/',
    'use-proxy'           => false,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.longleybros.com/sitemap.xml";
        $vdp_url_regex        = '/\/(?:new|used|certified)\-[^\-]+\-[0-9]{4}/';
        $images_regx          = '/srcset="(?<img_url>[^\?]+)/';
        $images_fallback_regx = '/rel="image_src" href="(?<img_url>[^"]+)/';
        $required_params      = [];
        $use_proxy            = false;
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png','https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png','https://media.assets.sincrod.com/websites/5.0-8538/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];

        $annoy_func = function ($car) {
            if($car['year'] == "" && $car['make'] == ""){
                $car = [];
            }
            
            $retval   = [];
            $images = explode('|', $car['all_images']);

            $retval            = preg_replace('/http(s)?:.*(?=http)/', '', $images, -1);
            unset($retval[0]); 
            $car['all_images'] = implode("|", $retval);

            return $car;
        };
        
        $data_capture_regx_full = [
            //'title'          => '/og:title" content="(?<title>[^"]+)/',
            'stock_type'     => '/"status":"(?<stock_type>[^"]+)/i',
            'stock_number'   => '/StockNumber":\s*"(?<stock_number>[^"]+)/',
            'vin'           => '/VIN:\s*[^>]+>\s*<span\s*class="vehicle-identifiers__value">(?<vin>[^<]+)/',
            'year'           => '/year":"(?<year>[^"]+)/',
            'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'model'          => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'price'          => '/Internet Price[^>]+>[^>]+>(?<price>[^<]+)/',
            'kilometres'        =>'/Mileage[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);
add_filter("filter_longleybroscom_field_price", "filter_longleybroscom_field_price", 10, 3);

function filter_longleybroscom_field_price($price, $car_data, $spltd_data) {
    $prices = [];

    slecho('');

    if ($price && numarifyPrice($price) > 0) {
        $prices[] = numarifyPrice($price);
        slecho("Regex Selling Price: $price");
    }

    $final_regex = '/FINAL PRICE:[^>]+>\s*<span\s*class="pri[^>]+>(?<price>[^<]+)/';
    $msrp_regex = '/MSRP:[^>]+>[^>]+>[^>]+>\s*<span\s*class="priceBloc[^>]+>(?<price>[^<]+)/';

    $matches = [];

    if (preg_match($final_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex Sale Price: {$matches['price']}");
    }

    if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
        $prices[] = numarifyPrice($matches['price']);
        slecho("Regex MSRP: {$matches['price']}");
    }

    if (count($prices) > 0) {
        $price = butifyPrice(min($prices));
    }

    slecho("Sale Price: {$price}" . '<br>');
    return $price;
}


//     "entry_points" => array(
//         'new' => 'https://www.longleybros.com/searchnew.aspx',
//         'used' => 'https://www.longleybros.com/searchused.aspx'
//     ),
//     'use-proxy' => true,
//     'refine' => false,
//     'vdp_url_regex' => '/\/(?:new|used)-[^-]+-[0-9]{4}/i',
//     'picture_selectors' => ['#vehicleImgLarge .carousel-inner .item .row', '.mfp-figure .mfp-img '],
//     'picture_nexts' => ['.mfp-arrow.mfp-arrow-right'],
//     'picture_prevs' => ['.mfp-arrow.mfp-arrow-left'],
//     'details_start_tag' => '<!-- Vehicle Start -->',
//     'details_end_tag' => '<div class="row srpDisclaimer">',
//     'details_spliter' => '<!-- Vehicle End -->',
//     'data_capture_regx' => array(
//         'stock_number' => '/Stock #:[^>]+>(?<stock_number>[^<]+)<\/li>/',
//         'title' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
//         'year' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
//         'make' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
//         'model' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
//         'price' => '/Internet Price\s*<\/span><[^>]+>(?<price>[$0-9,]+)/',
//         'engine' => '/Engine: <\/strong>\s*(?<engine>[^<]+)/',
//         'transmission' => '/Transmission: <\/strong>\s*(?<transmission>[^<]+)/',
//         'exterior_color' => '/Ext. Color: <\/strong>\s*(?<exterior_color>[^<]+)/',
//         'interior_color' => '/Int. Color: <\/strong>\s*(?<interior_color>[^<]+)/',
//         'kilometres' => '/Mileage:\s*<\/strong>\s*(?<kilometres>[^<]+)/',
//         'url' => '/<a class="stat-text-link"\s*data-loc="[^"]+"\s*href="(?<url>[^"]+)">\s*<span[^>]+>(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^\n<]*)/',
//         'body_style' => '/Body Style: <\/strong>\s*(?<body_style>[^<]+)/'
//     ),
//     'data_capture_regx_full' => array(
//          'stock_number' => '/Stock\s*#:\s*(?<stock_number>[^<]+)<\/li>/',
//          'vin' => '/VIN:\s*(?<vin>[^<]+)<\/li>/',
//     ),
//     'next_page_regx' => '/<li\s*class="active[^>]+>[\s\S]+?<\/li>\s*<li\s*>\s*<a[\s\S]+?href="(?<next>[^"]+)"/',
//     'images_regx' => '/<!-- zoom feature element -->\s*<img src="(?<img_url>[^\?]+)/',
// );

// add_filter("filter_longleybroscom_field_price", "filter_longleybroscom_field_price", 10, 3);

// function filter_longleybroscom_field_price($price, $car_data, $spltd_data) {
//     $prices = [];

//     slecho('');

//     if ($price && numarifyPrice($price) > 0) {
//         $prices[] = numarifyPrice($price);
//         slecho("Regex Selling Price: $price");
//     }

//     $internet_regex = '/FINAL PRICE:\s*<\/span><[^>]+>(?<price>[$0-9,]+)/';
//     $retail_regex = '/Retail Price:\s*<\/span>\s*<span class="pull-right[^>]+>(?<price>[$0-9,]+)/';
//     $msrp_regex = '/MSRP:\s*<\/span><[^>]+>(?<price>[$0-9,]+)/';

//     $matches = [];

//     if (preg_match($internet_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Sale Price: {$matches['price']}");
//     }

//     if (preg_match($retail_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex Price: {$matches['price']}");
//     }

//     if (preg_match($msrp_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//         slecho("Regex MSRP: {$matches['price']}");
//     }

//     if (count($prices) > 0) {
//         $price = butifyPrice(min($prices));
//     }

//     slecho("Sale Price: {$price}" . '<br>');
//     return $price;
// }
