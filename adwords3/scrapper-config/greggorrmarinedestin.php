<?php
global $scrapper_configs;
$scrapper_configs["greggorrmarinedestin"] = array(
    "entry_points" => array(
        'new' => 'https://www.greggorrmarinedestin.com/boats-for-sale/New/?option=100',
        'used' => 'https://www.greggorrmarinedestin.com/boats-for-sale/Used/?option=100'
    ),

    'vdp_url_regex' => '/\/boats-for-sale\/[0-9]{4}-/i',
    'picture_selectors' => ['div.galleria-image.lazy > img'],
    'picture_nexts' => ['div.galleria-image-nav-right'],
    'picture_prevs' => ['div.galleria-image-nav-left'],

    'details_start_tag' => 'id="boat-list">',
    'details_end_tag' => 'id="inventory-results-contact-form"',
    'details_spliter' => '<div class="col-xs-12 boat list-group-item">',

    'data_capture_regx' => array(
        'url' => '/<a href="(?<url>[^"]+)">/'
    ),
    'data_capture_regx_full' => array(
        'year' => '/Year:<[^\s]+\s(?<year>[^<]+)<\/div>/',
        'make' => '/Make:<[^\s]+\s(?<make>[^<]+)<\/div>/',
        'model' => '/Model:<[^\s]+\s(?<model>[^<]+)<\/div>/',
        'kilometres' => '/Range:<[^\s]+\s(?<kilometres>[^<]+)<\/div>/',
        'vin' => '/Boat Hull ID:<[^\s]+\s(?<vin>[^<]+)<\/div>/'
    ),
    'images_regx' => '/<a href="(?<img_url>[^"]+)">\s*<img alt="[^"]+" class="" src="/',
);

