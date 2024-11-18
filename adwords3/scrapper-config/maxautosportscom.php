<?php
global $scrapper_configs;
$scrapper_configs["maxautosportscom"] = array( 
  'entry_points'        => array(
        'new' => 'https://www.maxautosports.com/inventory/'
    ),
    'vdp_url_regex'       => '/\/(?:new|used|certified)-vehicle-[0-9]{4}-/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.maxautosports.com/sitemap.xml";
        $vdp_url_regex        = '/\/(?:new|used|certified)-vehicle-[0-9]{4}-/i';
        $images_regx          = '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png'];

        $data_capture_regx_full = [
            'title'          => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'stock_type'     => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'year'           => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'make'           => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'model'          => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'trim'           => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'stock_number'   => '/Stock\s*\#(?<stock_number>[^"]+)"\//',
            'price'          => '/<meta property="product:sale_price:amount" content="(?<price>[^"]+)/i',
            'vin'            => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
            // 'engine'         => '/Engine<\/span>\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<engine>[^<]+)/i',
            // 'transmission'   => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
            // 'kilometres'     => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/i',  
            // 'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            // 'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);