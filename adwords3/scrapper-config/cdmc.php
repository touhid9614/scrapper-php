<?php

global $scrapper_configs;
$scrapper_configs["cdmc"] = array(
    'entry_points' => array(
        'new' => 'https://www.cdmc.ca/inventory/New/',
        'used' => 'https://www.cdmc.ca/inventory/Used/'
    ),
    'use-proxy' => true,
    'vdp_url_regex' => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i',
    'picture_selectors' => ['.owl-item.cloned'],
    'picture_nexts' => ['#newnext'],
    'picture_prevs' => ['#newprev'],
    'details_start_tag' => 'class="srpVehicles__wrap">',
    'details_end_tag' => 'class="disclaimer__wrap">',
    'details_spliter' => 'class="carbox-wrap loading ">',
    'data_capture_regx' => array(
        'url' => '/data-permalink="(?<url>[^"]+)/',
        'year' => '/year">\s*(?<year>[0-9]{4})/',
        'make' => '/make notranslate">\s*(?<make>[^\s]+)/',
        'model' => '/model notranslate">\s*(?<model>[^<]+)/',
        'trim' => '/title-trim[^>]+>\s*(?<trim>[^<]+)/',
        'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
        'price' => '/(?:Sale Price|Retail Price)<\/div>[^\$]+\$[^>]+>(?<price>[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
        'engine'     => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
        'transmission' => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
        'drivetrain'   => '/Drivetrain:<\/span>[^>]+>(?<drivetrain>[^<]+)/',
        'exterior_color'   => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/', 
        'interior_color'   => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/', 
        'vin'   => '/"vin">(?<vin>[^<]+)/',
        'description'   => '/vehicle-descriptions__value ">(?<description>[^<]+)/',
        'body_style'    => '/data-vehicle="standardbody" >(?<body_style>[^<]+)/',
    ),
    'next_page_regx' => '/next page-numbers" href="(?<next>[^"]+)/',
    'images_regx' => '/data-lightbox="(?<img_url>[^"]+)"/',
);

