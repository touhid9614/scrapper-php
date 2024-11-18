<?php
global $scrapper_configs;
$scrapper_configs["downtownhyundaicom"] = array(
    "entry_points"      => array(
        'used' => 'https://www.downtownhyundai.com/Used-Inventory',
        'new'  => 'https://www.downtownhyundai.com/New-Inventory',
    ),

    'vdp_url_regex' => '/\/(?:New|Used|Certified)-Inventory\/[0-9]{4}-/i',
    'picture_selectors' => ['.slideshowThumbnails'],
    'picture_nexts' => ['.navButton.navRight'],
    'picture_prevs' => ['.navButton.navLeft'],
    'use-proxy' => true,

    "custom_data_capture"  => function ($url, $data) {
        $site                 = 'www.downtownhyundai.com/SiteMap1.xml';
        $vdp_url_regex        = '/\/(?:New|Used|Certified)-Inventory\/[0-9]{4}-/i';
        $images_regx          = '/class="carousel-image"><img src="(?<img_url>[^"]+)"/';// wrong regex
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/';// wrong regex
        $required_params      = [];
        $use_proxy            = true;

        $data_capture_regx_full = [
            'year'           => '/Year:<\/strong>\s*(?<year>[0-9]{4})/i',// wrong regex
            'make'           => '/Make\s*\:<\/strong> (?<make>[^<]+)/i',// wrong regex
            'model'          => '/Model :<\/strong> (?<model>[^<]+)/i',// wrong regex
            'title'          => '/<h3 class="title"><strong>(?<title>[^<]+)<\/strong><\/h3>/i',// wrong regex
            'stock_number'   => '/Stock #:<\/strong> (?<stock_number>[^<]+)<br\/>/i',// wrong regex
            'body_style'     => '/Type :<\/strong> (?<body_style>[^<]+)/i',// wrong regex
            'vin'            => '/Serial #:<\/strong>\s*(?<vin>[^<]+)/i',// wrong regex
            'price'          => '/<div class="slider-text"><small><h2>(?<price>[^<]+)<\/h2><\/small>/i',// wrong regex
            'engine'         => '/<strong>Engine  Hours:<\/strong>(?<engine>[^<]+)/i',// wrong regex
            'city'           => '/<p><strong>Branch:<\/strong>(?<city>[^<]+)/i',// wrong regex
            'exterior_color' => '/Type :<\/strong>\s*(?<exterior_color>[^<]+)/i', // wrong regex
            'description'    => '/<div class="description"><h3 class="smallerH">Base Equipment<\/h3>(?<description>[^=]+)/i',// wrong regex
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);

        return $cars;
    },

    'images_regx'          => '/class="carousel-image"><img src="(?<img_url>[^"]+)"/',// wrong regex
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/',// wrong regex
);