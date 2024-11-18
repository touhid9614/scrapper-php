<?php
global $scrapper_configs;
$scrapper_configs["nwiqualityautosalescom"] = array(
    'entry_points'         => array(
        'used' => 'https://www.nwiqualityautosales.com/inventory/',
    ),
    'vdp_url_regex'        => '/\/inventory\//i',
    'picture_selectors'    => ['.scroll-content-item'],
    'picture_nexts'        => ['.bx-next'],
    'picture_prevs'        => ['.bx-prev'],

    "custom_data_capture"  => function ($url, $data) {
        $site                 = "www.nwiqualityautosales.com/sitemap_index.xml";
        $vdp_url_regex        = '/\/inventory\//i';
        $images_regx          = '/data-thumb="(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)/i';
        $required_params      = [];
        $use_proxy            = true;
        $keymap               = null;
        $invalid_images       = []; // Put images which should be ignored
        $use_custom_site      = true;

        // We can use this function to modify car data
        $anonymous_function = function ($car_data) {
            $car_data['stock_type'] = 'used'; // Since all are used, we can set hard coded data
            return $car_data;
        };

        $data_capture_regx_full = [
            'title'          => '/<h1 class="h2">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/i',
            'year'           => '/<h1 class="h2">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/i',
            'make'           => '/<h1 class="h2">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/i',
            'model'          => '/<h1 class="h2">(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/i',
            'trim'           => '/Trim<\/span>\s*<span class="dws-vehicle-fields-value">(?<trim>[^<]+)/i',
            'drivetrain'     => '/Drivetrain<\/span>\s*<span class="dws-vehicle-fields-value">(?<drivetrain>[^<]+)/i',
            'doors'          => '/Doors<\/span>\s*<span class="dws-vehicle-fields-value">(?<doors>[^<]+)/i',
            'price'          => '/<span class="dws-vdp-single-field-value dws-vdp-single-field-value-vehicleprice">(?<price>[^<]+)/i',
            'engine'         => '/Engine<\/span>[^>]+>(?<engine>[^<]+)/i',
            'transmission'   => '/Transmission<\/span>[^>]+>(?<transmission>[^<]+)/i',
            'kilometres'     => '/Mileage<\/span>[^>]+>(?<kilometres>[^<]+)/i',
            'exterior_color' => '/Exterior Color<\/span>[^>]+>(?<exterior_color>[^<]+)/i',
            'interior_color' => '/Interior Color<\/span>[^>]+>(?<interior_color>[^<]+)/i',
            'stock_number'   => '/Stock No.<\/span>[^>]+>(?<stock_number>[^<]+)/i',
            'vin'            => '/VIN<\/span>[^>]+>(?<vin>[^<]+)/i',
            'description'    => '/<div class=" dws-vdp-seller-notes-container" id="DWS_VDP_Seller_Notes_10[^>]+>(?<description>[^<]+)/i',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $anonymous_function);
        return $cars;

    },

    'images_regx'          => '/data-thumb="(?<img_url>[^"]+)/i',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/i'
);
