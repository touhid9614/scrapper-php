<?php

global $scrapper_configs;
$scrapper_configs["vihonda"] = array(
    'entry_points'        => array(
        'used' => 'https://www.vipowersports.com/sitemap.xml',
    ),
    'vdp_url_regex'       => '/\/inventory\/[A-z0-9]+\-[A-z]+\-/i',
    'use-proxy'           => true,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.vipowersports.com/sitemap.xml";
        $vdp_url_regex        = '/\/inventory\/[A-z0-9]+\-[A-z]+\-/i';
        $images_regx          = '/"unit-image-container[^<]+<a href="(?<images>[^"]+)/i';
        $images_fallback_regx = null;
        $required_params      = [];
        $use_proxy            = true;
        $invalid_images       = [];
        $use_custom_site      = true;

        $annoy_func = function ($car) {
            $car['stock_type'] = trim(strtolower($car['stock_type']));

            return $car;
        };

        $data_capture_regx_full = [
            'stock_type'   => '/"usageStatus":"(?<stock_type>[^"]+)/i',
            'year'         => '/year=(?<year>[^\&]+)/',
            'make'         => '/"og:title" content="\s*(?<make>[^\s*]+)\s*(?<model>[^\-]+)/',
            'model'        => '/"og:title" content="\s*(?<make>[^\s*]+)\s*(?<model>[^\-]+)/',
            'price'        => '/<span\s*itemprop="price">(?<price>[^<]+)/i',
            'stock_number' => '/Stock\s*(?<stock_number>[^"]+)"\s*\/>\s*<meta/i',
            'vin'          => '/VIN[^>]+>[^>]+>(?<vin>[^<]+)/i',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);