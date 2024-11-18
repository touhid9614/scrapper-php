<?php
global $scrapper_configs;
 $scrapper_configs["legacycars"] = array( 
    'entry_points'        => array(
        'new' => 'https://legacycars.ca/newandusedcars?clearall=1'
    ),
    'vdp_url_regex'       => '/\/vdp\//i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://legacycars.ca/";
        $vdp_url_regex        = '/\/vdp\//i';
        $images_regx          = '/data-src=\'(?<img_url>[^\']+)/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = false;
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png','https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];

        $data_capture_regx_full = [
            'year' => '/Year[^>]+>(?<year>[^<]+)<\/p>/',
            'make' => '/Make[^>]+>(?<make>[^<]+)<\/p>/',
            'stock_number' => '/Stock[^>]+>(?<stock_number>[^<]+)<\/p/',
            'stock_type' => '/ca\/vdp\/[^\/]+\/(?<stock_type>[^\-]+)/',
            'kilometres' => '/l>Mileage[^>]+>(?<kilometres>[^<]+)<\/p/',
            'model' => '/Model[^>]+>(?<model>[^<]+)<\/p>/',
            'price' => '/class=\'price-4\'>(?<price>[^<]+)/',
            'kilometres'        => '/Mileage[^>]+>(?<kilometres>[^<]+)/',
            'trim' => '/class="i11r_optTrim"><label>Trim[^>]+>(?<trim>[^<]+)/',
            'exterior_color' => '/I"i11r_optColor"><label>Color[^>]+>(?<exterior_color>[^<]+)/',
            'transmission' => '/Transmission:[^>]+>\s*<span[^>]+>(?<transmission>[^<]+)/',
            'description' => '/og:description" content="(?<description>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);



















// 	'entry_points' => array(
//             'used'   => 'https://www.legacycars.ca/newandusedcars?clearall=1&pagesize=500',
            
//         ),
//         'vdp_url_regex'     => '/\/vdp\//i',
     
//         'refine' => false,
//         'proxy-area'        => 'FL',
//         //'next_method'       => 'POST',
//         'srp_page_regex'         => '/ca\/newandusedcars/i',
//         'picture_selectors' => ['.swiper-slide'],
//         'picture_nexts'     => ['.swiper-button-next'],
//         'picture_prevs'     => ['.swiper-button-prev'],
//         'details_start_tag' => 'class="s66r_header sticky-top"',
//         'details_end_tag'   => 'class="modal-footer">',
//         'details_spliter'   => 'class="i11r-vehicle">',
     
//        'data_capture_regx' => array(
//         'stock_number' => '/Stock #[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
//         'vin'           => '/VIN:[^\;]+\;(?<vin>[^<]+)/',
//         'url' => '/<a aria-label="[^"]+"\s*[^"]+"(?<year>[^\s*]+)\s*(?<make>[^\s*]+)[^"][^"]+"[^"]+"(?<url>[^"]+)/',
//         'year' => '/<a aria-label="[^"]+"\s*[^"]+"(?<year>[^\s*]+)\s*(?<make>[^\s*]+)/',
//         'make' => '/<a aria-label="[^"]+"\s*[^"]+"(?<year>[^\s*]+)\s*(?<make>[^\s*]+)/',
//         'price' => '/Internet\s*[^>]+>\s*<span class="price-price">\s*(?<price>\$[0-9,]+)/',
//         'engine' => '/Engine:<\/label>\s*(?<engine>[^\s*]+)/',  
//         ),
//     'data_capture_regx_full' => array(
//         'model' => '/Model[^>]+>(?<model>[^<]+)<\/p>/',
//         'price' => '/class=\'price-4\'>(?<price>[^<]+)/',
//         'kilometres'        => '/Mileage[^>]+>(?<kilometres>[^<]+)/',
//         'trim' => '/class="i11r_optTrim"><label>Trim[^>]+>(?<trim>[^<]+)/',
//         'exterior_color' => '/I"i11r_optColor"><label>Color[^>]+>(?<exterior_color>[^<]+)/',
//         'transmission' => '/Transmission:[^>]+>\s*<span[^>]+>(?<transmission>[^<]+)/',
//         'description' => '/og:description" content="(?<description>[^"]+)/',
//     ),
//     'images_regx' => '/data-src=\'(?<img_url>[^\']+)/'
// );