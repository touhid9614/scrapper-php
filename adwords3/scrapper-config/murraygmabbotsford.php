<?php

global $scrapper_configs;
$scrapper_configs["murraygmabbotsford"] = array(
    'entry_points' => array(
         'new' => 'https://www.murraygmabbotsford.com/inventory/new/',
    ),
    'vdp_url_regex'        => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i',

    'picture_selectors'    => ['.scroll-content-item'],
    'picture_nexts'        => ['.bx-next'],
    'picture_prevs'        => ['.bx-prev'],

    "use-proxy"            => true,

    "custom_data_capture"  => function ($url, $data) {
        $site                 = "www.murraygmabbotsford.com";
        $vdp_url_regex        = '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-/i';
        $images_regx          = '/data-lightbox="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
          // 'title'          => '/<h1 class="font-montserrat[^>]+>\s*(?<title>(?<year>[^ ]+) *(?<make>[^ \s*]+) *(?<model>[^ \s*]+)?[^\s*]*)/i',
             'stock_type'        => '/itemCondition":"(?<stock_type>[^"]+)/',
            'year'           => '/vehicle-title--year">\s*(?<year>[^<]+)/i',
            'make'           => '/class="notranslate vehicle-title--make\s*">\s*(?<make>[^<]+)/i',
            'model'          => '/class="notranslate vehicle-title--model\s*">\s*(?<model>[^<]+)/i',

            'price'          => '/name="description" content="[^\$]+\$(?<price>[^.]+)/i',
     
            'transmission'   => '/data-vehicle="transdescription" >\s*(?<transmission>[^<]+)/i',
           
            'exterior_color' => '/data-vehicle="extcolor" >\s*(?<exterior_color>[^<]+)/i',

            'stock_number'   => '/Stock #[^>]+>\s*[^>]+>\s*(?<stock_number>[^<]+)/i',

            'vin'            => '/data-vehicle="vin" >\s*(?<vin>[^<]+)/i',

            'kilometres'     => '/data-vehicle="miles"\s*[^>]+>(?<kilometres>[^<]+)/',

            
            
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
        return $cars;

    },

    'images_regx'          => '/data-lightbox="(?<img_url>[^"]+)"/i',
    'images_fallback_regx' => '/property="og:image" content="(?<img_url>[^"]+)"/i'
);