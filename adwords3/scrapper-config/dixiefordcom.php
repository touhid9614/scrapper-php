<?php

global $scrapper_configs;

$scrapper_configs['dixiefordcom'] = array(
    'entry_points'        => array(
        'used' => 'https://dixieford.com/used-inventory/',
    ),
    'vdp_url_regex'       => '/\/view\/(?:new|used)-/',
    'picture_selectors'   => ['.m-auto.mr-2.thumbnail-mobile-item'],
    'picture_nexts'       => ['button.vgs__next'],
    'picture_prevs'       => ['button.vgs__prev'],

    "use-proxy"           => true,
    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://dixieford.com";
        $vdp_url_regex        = '/\/view\/(?:new|used)-/i';
        $images_regx          = '/-->\s*<meta property="og:image" content="(?<img_url>[^"]+)/i';
        $images_fallback_regx = null;
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
            'stock_type'     => '/Condition:<\/span>[^>]+>(?<stock_type>[^<]+)/i',
            'year'           => '/<h1 class="text-primary border-0 block leading-tight vdp-title-value">\s*(?<year>[0-9]{4})/i',
            'make'           => '/<h1 class="text-primary border-0 block leading-tight vdp-title-value">\s*[^\s*]+\s*(?<make>[^\s*]+)/i',
            'model'          => '/<h1 class="text-primary border-0 block leading-tight vdp-title-value">\s*[^\s*]+\s*\s*[^\s*]+\s*(?<model>[^\n]+)/i',
            'trim'           => '/>(?<trim>[^<]+)<\/h2>/i',
            'title'          => '/vdp-title-value">(?<title>[^<]+)<\/h1>/i',
            'price'          => '/Total Vehicle Price<\/td>\s*[^>]+>(?<price>[^<]+)/i',
            'msrp'           => '/Basic Sale Price <\/td>\s*[^>]+>(?<msrp>[^<]+)/i',
            'engine'         => '/Engine:[^>]+>\s*[^>]+>\s*(?<engine>[^<]+)/i',
            'transmission'   => '/Transmission:[^>]+>\s*[^>]+>\s*(?<transmission>[^<]+)<\/span>/i',
            'kilometres'     => '/Mileage:[^>]+>\s*[^>]+>\s*(?<kilometres>[^<]+)/i',
            'exterior_color' => '/Exterior Colour:[^>]+>\s*[^>]+>\s*(?<exterior_color>[^<]+)/i',
            'interior_color' => '/Interior Colour:<\/span>[^>]+>(?<interior_color>[^<]+)/i',
            'stock_number'   => '/Stock\s*#\s*:\s*(?<stock_number>[^\s*]+)/i',
            'vin'            => '/Vin\s*#\s*:\s*(?<vin>[^\s*]+)/i',
            'body_style'     => '/Body Style:<\/span>\s*[^>]+>(?<body_style>[^<]+)/i',
            'description'    => '/vehicle-description-content">(?<description>[\s\S]*?(?=<\/div>))/i',
            'drivetrain'     => '/Drivetrain:<\/span>\s*[^>]+>\s*(?<drivetrain>[^<]+)/i',
            'custom'         => '/<vdp-gallery[^"]+"\[&quot;(?<custom>[^\]]+)/i',
            'disclaimer'     => '/disclaimer-content">(?<disclaimer>[^<]+)</i'
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);

        $return_cars = [];

        foreach ($cars as $car) {
            $car['description'] = trim(strip_tags($car['description']));
            $car['disclaimer']  = trim(str_replace('* ', '', strip_tags($car['disclaimer'])));
            $car['title']       = trim(preg_replace('/\s+/', ' ', $car['title']));
            $car['trim']        = trim($car['trim']);
            $car['stock_type']  = trim(strtolower($car['stock_type']));

            $new_str   = str_replace('&quot;', '', str_replace('\/', '/', str_replace('\/\/', '', $car['custom'])));
            $img_parts = explode(',', $new_str);
            $out       = [];

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

            $failed_image = $car['url'] . 'http:';

            if ($car['all_images'] == $failed_image) {
                $car['all_images'] = '';
            }

            unset($car['custom']);

            $return_cars[] = $car;
        }

        return $return_cars;
    }
);

add_filter('filter_for_fb_dixiefordcom', 'filter_for_fb_dixiefordcom', 10, 1);

function filter_for_fb_dixiefordcom($car)
{
    return $car;
}

add_filter('filter_for_marketplace_dixiefordcom', 'filter_for_marketplace_dixiefordcom', 10, 1);

function filter_for_marketplace_dixiefordcom($car)
{
    if (numarifyPrice($car['price']) <= 2000) {
        return null;
    }

    return $car;
}