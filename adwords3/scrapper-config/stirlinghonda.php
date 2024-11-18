<?php

global $scrapper_configs;

$scrapper_configs['stirlinghonda'] = array(
    'entry_points' => array(
        "new" => "http://www.stirlinghonda.com/en_us/typebrowse.asp?Vintage=395",
        "used" => "http://www.stirlinghonda.com/en_us/typebrowse.asp?Vintage=396",
    ),
    'vdp_url_regex' => '/\/unitDetail.asp/i',
    'use-proxy' => true,
    'ty_url_regex' => '/ConfirmMail.asp/',
    'picture_selectors' => ['.flex-active-slide'],
    'picture_nexts' => ['#lightGallery-next'],
    'picture_prevs' => ['#lightGallery-prev'],
    'details_start_tag' => '<div id="inventory" style="background:none;">',
    'details_end_tag' => '<div id="botNavBar">',
    'details_spliter' => '<div class="invUnitThumb">',
    'data_capture_regx' => array(
        'car_id' => '/unitInfo">\s*<a\s*href="(?<url>[^"]*longview-wa=(?<car_id>[0-9]+))"\s*title="Get details about this\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^"]+)/',
        'url' => '/unitInfo">\s*<a\s*href="(?<url>[^"]+)"/',
        'title' => '/unitInfo">\s*<a\s*href="(?<url>[^"]+)"\s*title="Get details about this\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^"]+)/',
        'year' => '/unitInfo">\s*<a\s*href="(?<url>[^"]+)"\s*title="Get details about this\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^"]+)/',
        'make' => '/unitInfo">\s*<a\s*href="(?<url>[^"]+)"\s*title="Get details about this\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^"]+)/',
        'model' => '/unitInfo">\s*<a\s*href="(?<url>[^"]+)"\s*title="Get details about this\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^"]+)/',
        'stock_number' => '/Stock\s*No:\s*.*\s*<span class="value">(?<stock_number>[^<]+)/',
        'price' => '/"spec_price[^>]+><p>[^<]+<span>[^>]+>(?<price>[^<]+)/',
        'kilometres' => '/Mileage:\s*.*\s*<span class="value">(?<kilometres>[^<]+)/',
        'body_style' => '/Body:\s*.*\s*<span class="value">(?<body_style>[^<]+)/',
        'exterior_color' => '/Ext\s*Color:\s*.*\s*<span class="value">(?<exterior_color>[^<]+)/',
        'engine' => '/Engine:\s*.*\s*<span class="value">(?<engine>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'transmission' => '/Transmission:<\/td><td[^>]+>(?<transmission>[^<]+)/',
//        'trim'                  => '/Trim.*\s*.*\s*<t.*\s*[^>]+>(?<trim>[^<]+)/',
//        'interior_color'        => '/Interior:\s*.*\s*<t.*\s*[^>]+>(?<interior_color>[^<]+)/'
    ),
    'next_page_regx' => '/id="botNavBar"><a\s*href="(?<next>[^"]+)"><img.*class="next"/',
    'images_regx' => '/<li(\s*data-src="[^"]+"\s*)?><img\s*src="(?<img_url>[^"]+) /'
);

add_filter("filter_stirlinghonda_field_images", "filter_stirlinghonda_field_images", 10, 2);

function filter_stirlinghonda_field_images($im_urls, $car_data) {

    $im_urls = [];

    for ($i = 1; $i < 10; $i++) {
        $img_src = "http://www.stirlinghonda.com/stkPhotos/StirlingHonda/{$car_data['car_id']}_s$i.jpg";
        //echo $img_src;
        // slecho("Test Img $i: $img_src");

        if (!check_url_exists($img_src)) {
            break;
        }

        // slecho("Test Img Success $i: $img_src");

        $im_urls[] = $img_src;
    }

    return $im_urls;
}

function check_url_exists($file) {
    $file_headers = http_get_headers($file);

    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $exists = false;
    } else {
        $exists = true;
    }

    return $exists;
}
