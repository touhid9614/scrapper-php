<?php

global $scrapper_configs;
$scrapper_configs["utahtruckcountry"] = array(
    'entry_points' => array(
        'used' => 'https://www.utahtruckcountry.com/used-vehicles-lehi-ut?limit=200&page=1',
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?: new|used)-[0-9]{4}/i',
    'use-proxy' => true,
   // 'init_method' => 'GET',
    //'next_method' => 'POST',

    'picture_selectors' => ['.zoom-thumbnails__thumbnail'],
    'picture_nexts' => ['.df-icon-chevron-right'], 
    'picture_prevs' => ['.df-icon-chevron-left'],  

    'details_start_tag' => '<div class="inventory-listing vehicle-items',
    //'details_end_tag' => '<footer id="Footer_wrap">',//<div id="FooterPane" class="s59r_Footer container">
    'details_spliter' => '<div class="vehicle-item inventory-listing__item',


    'data_capture_regx' => array(
      
        'url' => '/<div class="vehicle-item__descr js-vehicle-item-descr">\s*<a href="(?<url>[^"]+)"[^>]+>\s*<[^>]+>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'year' => '/<div class="vehicle-item__descr js-vehicle-item-descr">\s*<a href="(?<url>[^"]+)"[^>]+>\s*<[^>]+>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'make' => '/<div class="vehicle-item__descr js-vehicle-item-descr">\s*<a href="(?<url>[^"]+)"[^>]+>\s*<[^>]+>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'model' => '/<div class="vehicle-item__descr js-vehicle-item-descr">\s*<a href="(?<url>[^"]+)"[^>]+>\s*<[^>]+>\s*(?<year>[^\s]+)\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)/',
        'engine' => '/Engine:[^>]+>\s*[^>]+>(?<engine>[^<]+)/',
        'price' => '/class="price_value">\s*(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:[^>]+>\s*[^>]+>(?<kilometres>[^<]+)/',
    ),


    'data_capture_regx_full' => array(
        'exterior_color' => '/>Exterior Color[^>]+>\s*[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/>Interior Color[^>]+>\s*[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'transmission' => '/>Transmission<\/div>[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'vin' => '/>VIN[^>]+>\s*[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'year' => '/>Year[^>]+>\s*[^>]+>\s*[^>]+>(?<year>[0-9]{4})/',
        'make' => '/>Make[^>]+>\s*[^>]+>\s*[^>]+>(?<make>[^<]+)/',
        'model' => '/>Model[^>]+>\s*[^>]+>\s*[^>]+>(?<model>[^<]+)/',
        'body_style' => '/>Body Style[^>]+>\s*[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'stock_number' => '/>Stock[^>]+>\s*[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',

    ),
    //'next_query_regx' => '/dxp-num dxp-current">[^<]+<\/b><a class="dxp-num" onclick="__doPostBack\(&#39;ctl02\$ctl01\$ctl00\$ASPxPager(?:1|2)&#39;,+&#39;(?<param>PN)(?<value>[0-9]+)+/',
    'images_regx' => '/data-srcset="(?<img_url>[^\s]+)\s600w/'
);
