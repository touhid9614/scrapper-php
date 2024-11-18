<?php

global $scrapper_configs;
$scrapper_configs["evergreennissan"] = array(
    'entry_points' => array(
        'used' => 'https://www.evergreennissan.com/en/used-inventory?limit=100',
        'new' => 'https://www.evergreennissan.com/en/new-inventory?limit=114',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used)\-inventory/i',
    'use-proxy' => true,
    'picture_selectors' => ['div.main-image'],
    'picture_nexts' => ['.lb-next'],
    'picture_prevs' => ['.lb-prev'],
    'details_start_tag' => '<div class="inventory-listing__vehicles',
    'details_end_tag' => '<p class="inventory-listing__disclaimer smallprint"',
    'details_spliter' => '<article class="inventory-list-layout',
    'data_capture_regx' => array(
        'url' => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)/',
        'year' => '/<a class="inventory-list-layout__preview-name" href="[^-]+-[^\/]+\/[^\/]+\/[^\/]+\/(?<year>[^-]+)/',
        'make' => '/<a class="inventory-list-layout__preview-name" href="[^-]+-[^\/]+\/[^\/]+\/[^\/]+\/[0-9]{4}-(?<make>[^-]+)/',
        'model' => '/<a class="inventory-list-layout__preview-name" href="[^-]+-[^\/]+\/[^\/]+\/[^\/]+\/[0-9]{4}-[^-]+-(?<model>[^-]+)/',
        'price' => '/<meta itemprop="price" content="(?<price>[^"]+)/',
        'kilometres' => '/<span itemprop="mileageFromOdometer"[^>]+>(?<kilometres>[^<]+)<\/span>/',
        'trim' => '/data-theme-style="vehiclePreviewName_color">\s*<span itemprop="name">(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*(?<trim>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'body_style' => '/Bodystyle:<\/div>\s*[^>]+>(?<body_style>[^<]+)/',
        /* 'engine' => '/Engine Type\s*<\/span>[^>]+>\s*(?<engine>[^<]+)/', */
        'interior_color' => '/Int\. color:<\/div>[^>]+>(?<interior_color>[^<]+)<\/div>/',
        'exterior_color' => '/Ext\. Color:<\/div>[^>]+>(?<exterior_color>[^<]+)<\/div>/',
        'transmission' => '/Transmission:<\/div>\s*[^>]+>(?<transmission>[^<]+)/',
        'stock_number' => '/<span itemprop="vehicleIdentificationNumber">(?<stock_number>[^<]+)<\/span>/',
        'vin' => '/<span itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)<\/span>/',
        'trim' => '/<h1 class="title__primary inventory-details__name" itemprop="name">(?<year>[^ ]+)\s*(?<make>[^ ]+)\s*(?<model>[^ ]+)\s*(?<trim>[^<]+)/',
        'fuel_type' => '/Fuel:<\/div>\s*[^>]+>(?<fuel_type>[^<]+)/',
    ),
    'next_page_regx' => '/(?:<li class="active"><span>|data-current-page=")(?<next>[^(?:<|")]+)/',
    'images_regx' => '/(?:<span class="overlay">\s*<img\s*src="|img class="[^"]+"\s*src=")(?<img_url>[^"]+)(?:"|"\s*itemprop="image"\s*alt=)/',

//img class="[^"]+"\s*src="(?<img_url>[^"]+)"\s*itemprop="image"\s*alt=

    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);




add_filter("filter_evergreennissan_next_page", "filter_evergreennissan_next_page", 10, 2);

function filter_evergreennissan_next_page($next, $current_page) {

    slecho($current_page);
    $next = explode('/', $next);
    $index = count($next) - 1;
    $next = ($next[$index]);
    $next++;
    $peg = "page=" . $next;
    $prev = "page=" . ($next - 1);
    $url = str_replace($prev, $peg, $current_page);
    slecho("Next url:" . $url);
    return $url;
}
 add_filter("filter_evergreennissan_field_images", "filter_evergreennissan_field_images");


        function filter_evergreennissan_field_images($im_urls)
        {
            if(count($im_urls) <= 4) { return array(); }
            
            return $im_urls;
            
        }

       add_filter('filter_evergreennissan_car_data', 'filter_evergreennissan_car_data');
       function filter_evergreennissan_car_data($car_data) {
    

    $car_data['make'] = ucfirst($car_data['make']);
    
    $car_data['model'] = ucfirst($car_data['model']);
    
    $car_data['trim'] = ucfirst($car_data['trim']);



    return $car_data;
}