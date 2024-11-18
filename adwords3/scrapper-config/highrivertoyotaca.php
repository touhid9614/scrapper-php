<?php
global $scrapper_configs;

$scrapper_configs["highrivertoyotaca"] = array(
    "entry_points"        => array(
        'new' => 'https://highrivertoyota.ca/NewToyotaCars', // Only one is enough
    ),
    'vdp_url_regex'       => '/\/(?:NewToyotaCars|UsedCars|TRD-Pro-Vehicles|Used-Under-15k)\/[0-9]{4}-/i',
    'srp_page_regex'      => '/ca\/(?:New|Used|certified)/i',
    'picture_selectors'   => ['img.slideshowThumbnail'],
    'picture_nexts'       => ['span.icon-Arrow-Right-6.thumbnailShiftRight'],
    'picture_prevs'       => ['span.icon-Arrow-Left-6.thumbnailShiftLeft'],
    'use-proxy'           => true,

    "custom_data_capture" => function ($url, $data) {
        $site                 = 'https://highrivertoyota.ca/SiteMap_Index.xml';
        $vdp_url_regex        = '/\/(?:NewToyotaCars|UsedCars|TRD-Pro-Vehicles|Used-Under-15k)\/[0-9]{4}-/i';
        $images_regx          = '/meta property="og:image" content="(?<img_url>[^"]+)"/';
        $images_fallback_regx = '/data-index="0" data-url="(?<img_url>[^"]+)"/';
        $required_params      = [];
        $use_proxy            = true;
        $keymap               = null;
        $invalid_images       = []; // No car images
        $use_custom_site      = true; // Set true to use the {$site} as sitemap url
        $annoy_func           = function ($car_data) {
            $id  = explode("-", $car_data['url']);
            $num = count($id) - 1;
            $vk  = $id[$num];

            if ($car_data['stock_type'] == 'new') {
                $img_cid = '2232344';
                $prc_cid = '2392489';
                $image_api_url = "https://highrivertoyota.ca/ElementSettings/highrivertoyota.ca/PhotoSlideshow/_Content?vk={$vk}&controlId={$img_cid}&pageGuid=9f0098f0-3820-46f3-a4e5-af77f9717d50";
            } else {
                $img_cid = '2345502';
                $prc_cid = '2345516';
                $image_api_url = "https://highrivertoyota.ca/ElementSettings/highrivertoyota.ca/PhotoSlideshow/_Content?vk={$vk}&controlId={$img_cid}&pageGuid=e1f4a679-b7c9-4e76-acad-e9529ba2a92a";
            }
            
            
            $price_api_url = "https://highrivertoyota.ca/ElementSettings/highrivertoyota.ca/VehiclePrice/_Content?vk={$vk}&controlId={$img_cid}&pageGuid={$car_data['vehicle_id']}";

            $image_response_data = HttpGet($image_api_url, true, true);
            $price_response_data = HttpGet($price_api_url, true, true);
            
            $image_regex = '/<div\s*class="slideshowPhoto"\s*data-has-loaded="false"\s*data-index="[0-9]*"\s*data-url="(?<img_url>[^"]+)/';
            $price_regex = '/<span\s*class="vehiclePriceDisplay"\s*itemprop="price"\s*title="(?<price>[^"]+)/';

            $im_urls = [];
            $matches = [];

            if (preg_match_all($image_regex, $image_response_data, $matches)) {
                foreach ($matches['img_url'] as $key => $value) {
                    $im_urls[] = "https:" . $value;
                }
            }

            // REMOVE COVERED CAR IMAGE
            // SOMETIMES SOME CARS HAVE 1 IMAGE AND IT'S VALID AS WELL
            $blank_img_rgx = '/\/ORDERNOW[0-9]{2}\/[0-9]{9}/';

            if (preg_match($blank_img_rgx, $im_urls[0])) {
                unset($im_urls[0]);
            }

            // send first image to last
           //   array_push($im_urls, array_shift($im_urls));

            // if (count($im_urls) < 2) {
            //    $car_data['all_images'] = '';
            // } else {
            //   $car_data['all_images'] = implode('|', $im_urls);
            // }

            $car_data['stock_type'] = strtolower($car_data['stock_type']);

            if (preg_match($price_regex, $price_response_data, $matches)) {
                $car_data['price'] = $matches['price'];
            }

            if($car_data['stock_number'] == "220108A" || $car_data['stock_number'] == "204186" ||$car_data['stock_number'] == "220104A" ||$car_data['stock_number'] == "220107A"||$car_data['stock_number'] == "220091AA"||$car_data['stock_number'] == "204199")
            {
                return [];
            }

            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/,\"stockTypes\":\[\"(?<stock_type>[^\"]+)\"\],\"/i', // must scrape
            'year'           => '/,\"vehicleData\":{\"years":\[\"(?<year>[0-9]{4})\"\],"makes":\[\"(?<make>[^"]+)\"\],\"models\":\[\"(?<model>[^"]+)\"\]/i',
            'make'           => '/,\"vehicleData\":{\"years":\[\"(?<year>[0-9]{4})\"\],"makes":\[\"(?<make>[^"]+)\"\],\"models\":\[\"(?<model>[^"]+)\"\]/i',
            'model'          => '/,\"vehicleData\":{\"years":\[\"(?<year>[0-9]{4})\"\],"makes":\[\"(?<make>[^"]+)\"\],\"models\":\[\"(?<model>[^"]+)\"\]/i',
            'price'          => '/\",\"publishedPrice\":\"(?<price>[^"]+)\"/i',
            'msrp'           => '/\",\"msrp\":\"(?<msrp>[^"]+)\",\"/i',
            'stock_number'   => '/\",\"stockNumber\":\"(?<stock_number>[^"]+)\",\"/i',
            'body_style'     => '/,\"styles\":\[\"(?<body_style>[^"]+)\"\],\"/i',
            'vin'            => '/\",\"vin\":\"(?<vin>[^"]+)\",\"/i',
            'engine'         => '/Engine:<\/td>\s*[^>]+>(?<engine>[^<]+)/i',
            'transmission'   => '/Transmission:<\/td>\s*[^>]+>(?<transmission>[^<]+)/i',
            'drivetrain'     => '/Drive Train:<\/td>\s*[^>]+>(?<drivetrain>[^<]+)/i',
            'fuel_type'      => '/Fuel Type:<\/td>\s*[^>]+>(?<fuel_type>[^<]+)/i',
            'exterior_color' => '/Exterior:<\/td>\s*[^>]+>(?<exterior_color>[^<]+)/i',
            'interior_color' => '/Interior:<\/td>\s*[^>]+>(?<interior_color>[^<]+)/i',
            'kilometres'     => '/itemprop="mileageFromOdometer">(?<kilometres>[^<]+)/',
            'vehicle_id'     => '/pageGuid=(?<vehicle_id>[^\&]+)/',
            'description'    => '/<meta content="(?<description>[^"]+)"\s*name="description"/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);

add_filter('filter_highrivertoyotaca_car_data', 'filter_highrivertoyotaca_car_data');

function filter_highrivertoyotaca_car_data($car_data) {

    if($car_data['stock_number'] == "220108A" || $car_data['stock_number'] == "204186" ||$car_data['stock_number'] == "220104A" ||$car_data['stock_number'] == "220107A"||$car_data['stock_number'] == "220091AA"||$car_data['stock_number'] == "204199")
    {
        return [];
    }
    return $car_data;
}