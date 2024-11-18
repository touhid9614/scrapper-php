<?php
global $scrapper_configs;
$scrapper_configs["gravelautocom"] = array(
    'entry_points'           => array(
        'used' => 'https://www.gravelauto.com/en/used-inventory?limit=500',
        'new'  => 'https://www.gravelauto.com/en/new-inventory?limit=533'
    ),
    'url_resolve'            => array(
        'gravelautocom'    => '/www.gravelauto.com\/en/i',
        'gravelauto_frcom' => '/www.gravelauto.com\/fr/i'
    ),
    'picture_selectors'      => ['.inventory-photo-gallery-from-catalog__picture-img'],
    'picture_nexts'          => [''],
    'picture_prevs'          => [''],
    'vdp_url_regex'          => '/\/en\/(?:new|used)-inventory\//i',
    'use-proxy'              => true,
    'refine'                 => false,
    'details_start_tag'      => '<div class="inventory-listing-charlie__vehicles',
    'details_end_tag'        => '<span id="price-legal">',
    'details_spliter'        => '<article class="inventory-preview-bravo"',
    // 'must_not_contain_regx' => '/ceLabel_fontColor">\s*Sold at<\/p>/',
    'data_capture_regx'      => array(
        'stock_number' => '/#\s*stock(?<stock_number>[^<]+)/',
        'year'         => '/<a\s*href="(?<url>[^"]+)" class="inventory-preview-bravo-section-title__vehicle-name"[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+))/',
        'make'         => '/<a\s*href="(?<url>[^"]+)" class="inventory-preview-bravo-section-title__vehicle-name"[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+))/',
        'model'        => '/<a\s*href="(?<url>[^"]+)" class="inventory-preview-bravo-section-title__vehicle-name"[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+))/',
        'price'        => '/vehicleCashPurchase_sellingPrice_fontColor">\s*(?<price>\$[0-9,]+)/',
        'url'          => '/<a\s*href="(?<url>[^"]+)" class="inventory-preview-bravo-section-title__vehicle-name"[^>]+>(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s*]+)\s*(?<model>[^\s<]+))/'
    ),
    'data_capture_regx_full' => array(
        'transmission'   => '/Transmission:[^>]+>\s*[^>]+>(?<transmission>[^<]+)/',
        'vin'            => '/VIN #:[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'body_style'     => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'exterior_color' => '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',
        'body_style'     => '/Bodystyle:[^>]+>\s*[^>]+>(?<body_style>[^<]+)/',
        'kilometres'     => '/Mileage:[^>]+>\s*[^>]+>(?<kilometres>[0-9 ,]+)/'
    ),
    'images_regx'            => '/(?:inventoryDetailsHeader_separator_borderColor">|gallery-delta-slider__slide[^>]+>)\s*<img src="\s*(?<img_url>[^"]+)"/'
);