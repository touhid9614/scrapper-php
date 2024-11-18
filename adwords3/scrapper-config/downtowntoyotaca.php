<?php

global $scrapper_configs;
$scrapper_configs["downtowntoyotaca"] = array(
    "entry_points"        => array(
        'used' => 'https://www.downtowntoyota.ca/Used-Inventory', // Only one is enough
    ),
    'vdp_url_regex'       => '/\/(?:New-Inventory|Used-Inventory|Certified-Inventory)\/[0-9]{4}-/i',
    'picture_selectors'   => ['img.slideshowThumbnail'],
    'picture_nexts'       => ['span.icon-Arrow-Right-6.thumbnailShiftRight'],
    'picture_prevs'       => ['span.icon-Arrow-Left-6.thumbnailShiftLeft'],
    'use-proxy'           => true,

    "custom_data_capture" => function ($url, $data) {
        $site                 = 'www.downtowntoyota.ca/SiteMap_Index.xml';
        $vdp_url_regex        = '/\/(?:New-Inventory|Used-Inventory|Certified-Inventory)\/[0-9]{4}-/i';
        $images_regx          = null;
        $images_fallback_regx = null;
        $required_params      = [];
        $use_proxy            = true;
        $keymap               = null;
        $invalid_images       = [];     // No car images
        $use_custom_site      = true;   // Use the $site as sitemap url or not

        // This function will automatically get applied on all the cars.
        // So, change anything here.
        $annoy_func = function ($car_data) {
            $id      = explode("-", $car_data['url']);
            $num     = count($id) - 1;
            $vk      = $id[$num];
            $custom  = $car_data['custom'];
            $api_url = "https://www.downtowntoyota.ca/ElementSettings/downtowntoyota.ca/PhotoSlideshow/_Content?vk={$vk}&controlId=1797847&pageGuid={$custom}";

            slecho("api url:" . $api_url);
            $response_data = HttpGet($api_url);
            $regex         = '/<div class="photo" data-has-loaded="false" data-index="[0-9]*" data-url="(?<img_url>[^"]+)"/';
            $im_urls       = [];
            $matches       = [];

            if (preg_match_all($regex, $response_data, $matches)) {
                foreach ($matches['img_url'] as $key => $value) {
                    $im_urls[] = "https:" . $value;
                }
            }

            unset($im_urls[0]);
            unset($car_data['custom']);

            if (count($im_urls) >= 2) {
                $car_data['all_images'] = implode('|', $im_urls);
            } else {
                $car_data['all_images'] = '';
            }

            if ($car_data['stock_type'] == 'certified') {
                $car_data['stock_type'] = "used";
            }

            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/,\"stockTypes\":\[\"(?<stock_type>[^\"]+)\"\],\"/i', // must scrape
            'year'           => '/,\"vehicleData\":{\"years":\[\"(?<year>[0-9]{4})\"\],"makes":\[\"(?<make>[^"]+)\"\],\"models\":\[\"(?<model>[^"]+)\"\],\"trims\":\[\"(?<trim>[^"]+)\"\],/i',
            'make'           => '/,\"vehicleData\":{\"years":\[\"(?<year>[0-9]{4})\"\],"makes":\[\"(?<make>[^"]+)\"\],\"models\":\[\"(?<model>[^"]+)\"\],\"trims\":\[\"(?<trim>[^"]+)\"\],/i',
            'model'          => '/,\"vehicleData\":{\"years":\[\"(?<year>[0-9]{4})\"\],"makes":\[\"(?<make>[^"]+)\"\],\"models\":\[\"(?<model>[^"]+)\"\],\"trims\":\[\"(?<trim>[^"]+)\"\],/i',
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
            'kilometres'     => '/Odometer:<\/td>\s*[^>]+>(?<kilometres>[^<]+)/',
            'custom'         => '/pageGuid=(?<custom>[^\&]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);

add_filter('filter_for_fb_downtowntoyotaca', 'filter_for_fb_downtowntoyotaca', 10, 1);

function filter_for_fb_downtowntoyotaca($car)
{
    // Need to remove no-car images from feeds

    return $car;
}
