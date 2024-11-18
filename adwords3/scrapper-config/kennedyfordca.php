<?php
global $scrapper_configs;
$scrapper_configs["kennedyfordca"] = array(
    'entry_points'        => array(
        'used' => 'https://kennedyford.ca/used-inventory/',
    ),
    'vdp_url_regex'       => '/\/view\/(?:new|used)-/',
    'picture_selectors'   => ['.m-auto.mr-2.thumbnail-mobile-item'],
    'picture_nexts'       => ['button.vgs__next'],
    'picture_prevs'       => ['button.vgs__prev'],

    "use-proxy"           => true,
    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://kennedyford.ca";
        $vdp_url_regex        = '/\/view\/(?:new|used)-/i';
        $images_regx          = '/<meta property="og:image" content="(?<img_url>[^"]+)/i';
        $images_fallback_regx = null;
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
            // 'title'          => '/<div id="infobase" class=" ui-widget-content">\s*<h1>(?<title>[^<]+)<\/h1>\s*<\/div>/i',
            'year'           => '/<h1 class="block font-bold leading-tight border-0 text-primary title lg:text-left">\s*(?<year>[0-9]{4})/i',
            'make'           => '/<h1 class="block font-bold leading-tight border-0 text-primary title lg:text-left">\s*[^\s*]+\s*(?<make>[^\s*]+)/i',
            'model'          => '/<h1 class="block font-bold leading-tight border-0 text-primary title lg:text-left">\s*[^\s*]+\s*\s*[^\s*]+\s*(?<model>[^\n]+)/i',

            'price'          => '/Total Vehicle Price<\/td>\s*[^>]+>(?<price>[^<]+)/i',
            //  'msrp'           => '/<div class="price "[^>]+>(?<msrp>[^<]+)<\/div>/i',
            // 'engine'         => '/Engine:[^>]+>\s*[^>]+>\s*(?<engine>[^<]+)/i',

            'transmission'   => '/key-feature-item-label">Transmission:[^>]+>\s*[^>]+>\s*(?<transmission>[^<]+)<\/span>/i',

            'kilometres'     => '/text-sm key-feature-item-label">Mileage:[^>]+>\s*[^>]+>\s*(?<kilometres>[^KM]+)/i',

            'exterior_color' => '/Exterior Colour:[^>]+>\s*[^>]+>\s*(?<exterior_color>[^<]+)/i',

            'stock_number'   => '/Stock\s*#\s*:\s*(?<stock_number>[^\s*]+)/i',

            'vin'            => '/VIN\s*#\s*:\s*(?<vin>[^\s*]+)/i',
            'body_style'     => '/Body Style:<\/span>\s*[^>]+>(?<body_style>[^<]+)/i',

            'description'    => '/vehicle-description-content">\s*(?<description>[^<]+)/i',
            'drivetrain'     => '/Drivetrain:<\/span>\s*[^>]+>\s*(?<drivetrain>[^<]+)/i',
            'custom'         => '/<vdp-gallery[^"]+"\[&quot;(?<custom>[^\]]+)/i',
        ];

        $cars        = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        $return_cars = [];

        foreach ($cars as $car) {
            $car['trim']       = trim($car['trim']);
            $car['stock_type'] = trim(strtolower($car['stock_type']));
            $new_str           = str_replace('&quot;', '', str_replace('\/', '/', str_replace('\/\/', '', $car['custom'])));
            $img_parts         = explode(',', $new_str);
            $out               = [];

            foreach ($img_parts as $custom_img) {
                $custom_img = substr($custom_img, 0, strpos($custom_img, '?'));

                if (!empty($custom_img)) {
                    $out[] = 'https://' . $custom_img;
                }
            }

            $all_images = implode('|', $out);

            if (!empty($all_images)) {
                $car['all_images'] = $all_images;
            }

            $return_cars[] = $car;
        }

        return $return_cars;
    }
);
