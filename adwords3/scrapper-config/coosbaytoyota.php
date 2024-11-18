<?php
global $scrapper_configs;

$scrapper_configs['coosbaytoyota'] = array(
    'entry_points'           => array(
        'used' => 'https://www.coosbaytoyota.com/search/used-coos-bay-or/?cy=97420&tp=used',
        'new'  => 'https://www.coosbaytoyota.com/search/new-toyota-coos-bay-or/?cy=97459&tp=new',
    ),

    'use-proxy'              => false,
    //'proxy-area'             => 'FL',
   // 'scrapper_config'        => 20,

    'vdp_url_regex'          => '/\/auto\/(?:nuevo|usado|new|used)-[0-9]{4}-/i',
    // 'srp_page_regex'         => '/\/auto\/(?:nuevo|usado|new|used)-[0-9]{4}-/i',

    'picture_selectors'      => ['.dep_image_slider_ul_style li'],
    'picture_nexts'          => ['.dep_image_slider_next_btn'],
    'picture_prevs'          => ['.dep_image_slider_prev_btn'],

    'details_start_tag'      => '<div class="srp_results_count_container"',
    'details_end_tag'        => '<div id="details-disclaimer"',
    'details_spliter'        => 'class="srp_vehicle_wrapper srp_vehicle_item_container',

    'data_capture_regx'      => array(
        'stock_number'   => '/bold">Stock #[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'year'           => '/<a href="(?<url>[^"]+)"\s*alt="(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s"]+)[^"]+)/',
        'make'           => '/<a href="(?<url>[^"]+)"\s*alt="(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s"]+)[^"]+)/',
        'model'          => '/<a href="(?<url>[^"]+)"\s*alt="(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s"]+)[^"]+)/',
        'transmission'   => '/<meta\s*itemprop="vehicleTransmission"\s*content="(?<transmission>[^"]+)/',
        'price'          => '/class="vehicle_price[^>]+>\s*(?<price>[^\s*]+)/',
        'exterior_color' => '/Exterior Color[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres'     => '/Mileage[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url'            => '/<a href="(?<url>[^"]+)"\s*alt="(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s"]+)[^"]+)/',
        'trim'           => '/bold">Trim[^>]+>[^>]+>(?<trim>[^<]+)/',
        'vin'            => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'engine' => '/Engine<\/td>\s*<[^>]+>(?<engine>[^<]+)/',
    ),
    'next_page_regx'         => '/<li class="active[^>]+.*<\/li>\s*<li[^>]+>\s*<a\s*class="[^"]+"\s*href="(?<next>[^"]+)/',
    'images_regx'            => '/<meta property="og:image" content="(?<img_url>[^"]+)"/',
);
