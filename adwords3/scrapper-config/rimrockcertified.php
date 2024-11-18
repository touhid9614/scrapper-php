<?php

global $scrapper_configs;

$scrapper_configs['rimrockcertified'] = array(
    'entry_points' => array(
        'used' => 'https://www.rimrockcertified.com/VehicleSearchResults?search=preowned'
    ),
    'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/i',
    'used-proxy' => true,
    'picture_selectors' => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts' => ['.arrow.single.next'],
    'picture_prevs' => ['.arrow.single.prev'],
    'details_start_tag' => '<div id="inv_results_container">',
    'details_end_tag' => '<div id="footerWrapper">',
    'details_spliter' => '<li class="results_list_row results_list_',
    'data_capture_regx' => array(
        'stock_number' => '/Stock Number:<\/label>\s*<span>\s*(?<stock_number>[^<]+)/',
        'transmission' => '/Transmission:<\/label>\s*<span>\s*(?<transmission>[^<]+)/',
        'engine' => '/Engine:<\/label>\s*<span>\s*(?<engine>[^<]+)/',
        'interior_color' => '/Interior:<\/label>\s*<span>\s*(?<interior_color>[^<]+))/',
        'vin' => '/VIN:<\/label>\s*<span>\s*(?<vin>[^<]+)/',
        'exterior_color' => '/Exterior:<\/label>\s*<span>\s*(?<exterior_color>[^<]+)/',
        'price' => '/Internet Price:<\/label>\s*<span>\s*(?<price>[^<]+)/',
        'url' => '/<div class="results_media_img">\s*<a href="(?<url>[^"]+)/',
        'year' => '/<\/span>\s*<span>\s*(?<year>[0-9]{4})/',
        'make' => '/<\/span>\s*<span>\s*[^>]+>\s*<span>(?<make>[^<]+)<\/span>\s*<span>(?<model>[^<]+)/',
        'model' => '/<\/span>\s*<span>\s*[^>]+>\s*<span>(?<make>[^<]+)<\/span>\s*<span>(?<model>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/Mileage:<\/label>\s*<span>\s*(?<kilometres>[^<]+)/',
    ),
    'next_page_regx' => '/class="spriteContainer sprite-icon_paginationRight_on_bot"\s*href="(?<next>[^"]+)"/',
    'images_regx' => '/<div id="media_placeholder">\s*<img class="" src="(?<img_url>[^"]+)/',
);
