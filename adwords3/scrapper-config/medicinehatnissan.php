<?php

global $scrapper_configs;
$scrapper_configs["medicinehatnissan"] = array(
    'entry_points' => array(
      //  'new' => 'https://www.medicinehatnissan.com/en/new-catalog',
        'new' => 'https://www.medicinehatnissan.com/en/new-inventory?limit=200',
        'used' => 'https://www.medicinehatnissan.com/en/used-inventory?limit=200',
        
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/en\/(?:new|used)-[^\/]+\/[^\/]+\/[^\/]+\/[0-9]{4}-/i',
    'picture_selectors' => ['.image-select li a', '#bxslider-pager a'],
    'picture_nexts' => ['', '#cboxNext'],
    'picture_prevs' => ['', '#cboxPrevious'],
//    'new' => array(
//        'details_start_tag' => '<div id="catalog-listing-alpha__nissan"',
//        'details_end_tag' => '<footer class="footer-delta"',
//        'details_spliter' => 'class="catalog-block-alpha__wrapper',
//        'data_capture_regx' => array(
//            'url' => '/<a class="catalog-block-alpha__name-anchor cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
//            'title' => '/<a class="catalog-block-alpha__name-anchor cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
//            'year' => '/<a class="catalog-block-alpha__name-anchor cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
//            'make' => '/<a class="catalog-block-alpha__name-anchor cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
//            'model' => '/<a class="catalog-block-alpha__name-anchor cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
//            'price' => '/itemprop="price"[^>]+>\s*.*\s*.*\s*(?<price>[^\s]+)/',
//        ),
//        'data_capture_regx_full' => array(
//        ),
//        'images_regx' => '/<span class="overlay">\s*<img\s*src="(?<img_url>[^"]+)"/',
//    ),
//    'used' => array(
        'details_start_tag' => '<section class="page-content__right">',
        'details_end_tag' => '<div class="page-wrapper footer-delta__wrapper">',
        'details_spliter' => '<article class="inventory-list-layout-wrapper',
        'data_capture_regx' => array(
            'title' => '/<a class="inventory-list-layout__preview-name cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'year' => '/<a class="inventory-list-layout__preview-name cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'make' => '/<a class="inventory-list-layout__preview-name cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'model' => '/<a class="inventory-list-layout__preview-name cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/',
            'price' => '/itemprop="price"[^>]+>\s*.*\s*.*\s*(?<price>[^<]+)/',
            'kilometres' => '/itemprop="mileageFromOdometer"[^>]+>(?<kilometres>[^<]+)/',
            'transmission' => '/itemprop="vehicleTransmission"[^>]+>(?<transmission>[^<]+)/',
            'vin' => '/data-vin="(?<vin>[^"]+)/',
            'url' => '/<a class="inventory-list-layout__preview-name cars-name" href="(?<url>[^"]+)"\s*title="(?<title>(?<year>[^ ]+) *(?<make>[^ "]+) *(?<model>[^ "]+)?[^"]*)/'
        ),
        'data_capture_regx_full' => array(
            'stock_number' => '/itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)/',
            'drivetrain' => '/Drivetrain:[^>]+>[^>]+>(?<drivetrain>[^<]+)/',
            'body_style' => '/Bodystyle:\s*[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'fuel_type' => '/Fuel[^>]+>[^>]+>(?<fuel_type>[^<]+)/',
            'description' => '/<meta name="description" content="(?<description>[^<]+)"/',
            'exterior_color' => '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^\<]+)/',
            'interior_color' => '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^\<]+)/',
        ),
        'images_regx' => '/<span class="overlay">\s*<img class="[^"]+"\s*src="(?<img_url>[^"]+)"/',
  //  ),
);

add_filter("filter_medicinehatnissan_field_images", "filter_medicinehatnissan_field_images", 10, 2);

function filter_medicinehatnissan_field_images($im_urls, $car_data) {

    if (isset($car_data['url']) && $car_data['url']) {
        $id = explode("id", $car_data['url']);
        $api_url = "https://www.medicinehatnissan.com/en/inventory/" . $car_data['stock_type'] . "/fragments/vehiclesByIds?view=ninjabox-gallery&vehicleId={$id[1]}";
        $response_data = HttpGet($api_url);
        $regex = '/<img src="(?<img_url>[^"]+)" alt=/';

        $matches = [];


        if (preg_match_all($regex, $response_data, $matches)) {

            foreach ($matches['img_url'] as $key => $value) {
                $im_urls[] = $value;
            }
            //return  $im_urls;
        }
    }

    if (count($im_urls) == 3) {
        return array();
    }
    return $im_urls;
}

add_filter('filter_medicinehatnissan_car_data', 'filter_medicinehatnissan_car_data');

function filter_medicinehatnissan_car_data($car_data) {

    if ($car_data['stock_number'] === '9MI1521') {
        slecho("Excluding car that has stock number 9MI1521 ,{$car_data['url']}");
        return null;
    }
    return $car_data;
}
