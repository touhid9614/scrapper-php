<?php

global $scrapper_configs;
$scrapper_configs["vacarsonlinecom"] = array(
    "entry_points"         => array(
        'used' => 'https://www.vacarsonline.com/inventory',
    ),
    'vdp_url_regex'        => '/\/VehicleDetails\/[0-9]{4}\/[A-z0-9]{4,9}\/Hopewell-VA-[0-9]{4}-/i',
    'use-proxy'            => false,
    'picture_selectors'    => ['.scroll-content-item'],
    'picture_nexts'        => ['.bx-next'],
    'picture_prevs'        => ['.bx-prev'],

    "custom_data_capture"  => function ($url, $data) {
        $site                 = "www.vacarsonline.com";
        $vdp_url_regex        = '/\/VehicleDetails\/[0-9]{4}\/[A-z0-9]{4,9}\/Hopewell-VA-[0-9]{4}-/i';
        $images_regx          = '/data-is_stock_image="0" data-src=".*full="(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<img class="photoclick" src="(?<img_url>[^"]+)/i';
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
            'title'          => '/<div id="infobase" class=" ui-widget-content">\s*<h1>(?<title>[^<]+)<\/h1>\s*<\/div>/i',
            'year'           => '/<div class="infoinfo infoinfoyear">(?<year>[0-9]{4})<\/div>/i',
            'make'           => '/<div class="infoinfo infoinfomake">(?<make>[^<]+)<\/div>/i',
            'model'          => '/<div class="infoinfo infoinfomodel">(?<model>[^<]+)<\/div>/i',
            'price'          => '/<div class="price mainprice"[^>]+>(?<price>[^<]+)<\/div>/i',
            'msrp'           => '/<div class="price "[^>]+>(?<msrp>[^<]+)<\/div>/i',
            'engine'         => '/<div class="infoinfo infoinfoengine">(?<engine>[^<]+)<\/div>/i',
            'transmission'   => '/<div class="infoinfo infoinfotransmission">(?<transmission>[^<]+)<\/div>/i',
            'kilometres'     => '/<div class="infoinfo infoinfomileage">(?<kilometres>[^<]+)<\/div>/i',
            'exterior_color' => '/<div class="infoinfo infoinfoextcolor">(?<exterior_color>[^<]+)<\/div>/i',
            'stock_number'   => '/<div class="infoinfo infoinfostock">(?<stock_number>[^<]+)<\/div>/i',
            'vin'            => '/<div class="infoinfo infoinfovin">(?<vin>[^<]+)<\/div>/i',
            'body_style'     => '/<div class="infoinfo infoinfostyle">(?<body_style>[^<]+)<\/div>/i',
            // 'description'    => '/<div id="commentscomments" class="overthrow">(?<description>[^=]+)/i',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        return $cars;

        /* // We can just return $cars at this point since sitemap_crawler provides good data.
        // However for this dealer we discovered that their data api which uses vin and it seemed
        // like a good idea to exploit the api to get missing fields or correct existing ones.

        $api_data = va_group_api_data(generate_vinlist($cars));

        // Now carefully merge these two data sets.
        foreach ($cars as $car_data) {
            if (isset($car_data['vin']) && !empty($car_data['vin']) && strlen($car_data['vin']) == 17) {
                $vin               = $car_data['vin'];
                $merged_data[$vin] = array_merge($api_data[$vin], $car_data);
            } else {
                $merged_data[] = $car_data;
            }
        }

        return $merged_data; */
    },

    'images_regx'          => '/data-is_stock_image="0" data-src=".*full="(?<img_url>[^"]+)/i',
    'images_fallback_regx' => '/<img class="photoclick" src="(?<img_url>[^"]+)/i'
);

/*
add_filter('filter_vacarsonlinecom_post_data', 'filter_vacarsonlinecom_post_data');

function filter_vacarsonlinecom_post_data($post_data) {
return "fromAjax=y&sid=&doWhat=inventorySearch&func=getNextPage";
}

add_filter('filter_vacarsonlinecom_cookies', 'filter_vacarsonlinecom_cookies');
add_filter('filter_vacarsonlinecom_data', 'filter_vacarsonlinecom_data');

function filter_vacarsonlinecom_cookies($cookies) {
slecho("show cookie:" . $cookies);
return $cookies;
}

function filter_vacarsonlinecom_data($data) {
slecho("response datas:" . $data);

return $data;
}
 */
