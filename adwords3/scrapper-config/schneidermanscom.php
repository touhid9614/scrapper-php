<?php
global $scrapper_configs;
$scrapper_configs["schneidermanscom"] = array(
    "entry_points"        => array(
        'new' => 'https://www.schneidermans.com/',
    ),
    'vdp_url_regex'       => '/\/(?:products|collections)\/.*/i',
    "use-proxy"           => true,
    "custom_data_capture" => function ($url, $data) {
        $site                 = 'www.schneidermans.com';
        $vdp_url_regex        = '/\/(?:products|collections)\//i';
        $images_regx          = '/<img class=".*data-srcset="(?<img_url>[^\s]+) 1x,/i';
        $images_fallback_regx = null;
        $required_params      = [];
        $use_proxy            = true;
        $isSiteMapSent        = false;

        $data_capture_regx_full = [
            'title'       => '/<h2 class="product-view__name hide-mobile">(?<title>[^<]+)<\/h2>/i',
            'model'       => '/<h2 class="product-view__name hide-mobile">(?<model>[^<]+)<\/h2>/i',
            'price'       => '/<span class="pv-price__original-value js-price-original">(?<price>[^<]+)<\/span>/i',
            'msrp'        => '/<span class="pv-price__compare-value js-price-compare">(?<msrp>[^<]+)/i',
            'description' => '/<h3>Details<\/h3>(?<description>[^=]+)/i',
        ];

        $cars = schneidermanscom_process_data(sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy));
        // We can just return sitemap_crawler car data.

        return $cars;
    },
    'images_regx'         => '/<img class=".*data-srcset="(?<img_url>[^\s]+) 1x,/'
);

/**
 * { function_description }
 *
 * @param      <type>  $cars   The cars
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function schneidermanscom_process_data($cars)
{
    foreach ($cars as $key => $car_data) {
        $car_data['make']       = 'Schneidermans';
        $car_data['stock_type'] = 'new';
        $car_data['body_style'] = 'furniture';
        $car_data['year']       = date("Y");

        $cars[$key] = $car_data;
    }

    return $cars;
}
