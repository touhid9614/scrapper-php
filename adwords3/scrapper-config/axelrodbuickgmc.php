<?php
global $scrapper_configs;
$scrapper_configs["axelrodbuickgmc"] = array(
    'entry_points'        => array(
        'new' => 'https://www.axelrodbuickgmc.com/VehicleSearchResults?search=new'
    ),
    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.axelrodbuickgmc.com/sitemap-inventory-sincro.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx          = '/photoUrl":"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png','https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];

        $annoy_func = function ($car) {
            if($car['stock_type'] == 'certified'){
                $car['stock_type'] = 'used';
            }
            return $car;
        };

        $data_capture_regx_full = [
            //'title'          => '/og:title" content="(?<title>[^"]+)/',
            'stock_type'     => '/VehicleDetails\/(?<stock_type>[^\-]+)/i',
            'stock_number'   => '/"stockNumber":"(?<stock_number>[^"]+)/',
            'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
            'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'vin'           => '/"vin":"(?<vin>[^"]+)/',
            'year'           => '/year":"(?<year>[^"]+)/',
            'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'model'          => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'price'          => '/"price":"(?<price>[0-9,]+)/',
            'kilometres'        =>'/Miles[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);

//    'entry_points'           => array(
//        'new'  => 'https://www.axelrodbuickgmc.com/VehicleSearchResults?search=new?handler=deferredBlockHandler&use.hydra.deferred.blocks=true&blockCacheType=consumer-eager-lazy&blockUri=view%2FconsumerBlock%3Fid%3Dview%2Fcard%2F00243bbd-2658-48fb-ae55-7ff2ad04e29b%2Cview%2Fcard%2F517a83df-1dee-4901-82d3-29bf77a3f9a6%26lazyId%3Dundefined%26fields%3Dhtml%2Chead%2Cscripts%2CautofillTokens&siteFront=false&search=new',
//        'used' => 'https://www.axelrodbuickgmc.com/VehicleSearchResults?search=preowned?handler=deferredBlockHandler&use.hydra.deferred.blocks=true&blockCacheType=consumer-eager-lazy&blockUri=view%2FconsumerBlock%3Fid%3Dview%2Fcard%2F00243bbd-2658-48fb-ae55-7ff2ad04e29b%2Cview%2Fcard%2F517a83df-1dee-4901-82d3-29bf77a3f9a6%26lazyId%3Dundefined%26fields%3Dhtml%2Chead%2Cscripts%2CautofillTokens&siteFront=false&search=preowned',
//    ),
//    'vdp_url_regex'     => '/\/VehicleDetails\//i',
//    //'vdp_url_regex'          => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-/',
//    // 'srp_page_regex'      => '/VehicleSearchResults/i',
//    'use-proxy'              => false,
//    'refine'                 => false,
//    'picture_selectors'      => ['.deck-gallery[smartgallery] > .deck > section'],
//    'picture_nexts'          => ['.arrow.single.next'],
//    'picture_prevs'          => ['.arrow.single.prev'],
//
//    'details_start_tag'      => '<ul each="cards">',
//    'details_end_tag'        => '<div class="content" id="pageDisclaimer">',
//    'details_spliter'        => 'data-attrs="card-vehicleListings-',
//
//    'data_capture_regx'      => array(
//        'url' => '/<a itemprop="url" href="(?<url>[^"]+)/',
//    ),
//    'data_capture_regx_full' => array(
//        'stock_number'   => '/<span class="value" itemprop="sku">(?<stock_number>[^<]+)/',
//        'transmission'   => '/<span class="value" itemprop="vehicleTransmission"[^\n]+\s*<span[^>]+>(?<transmission>[^<]+)/',
//        'engine'         => '/<span class="value" itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
//        'exterior_color' => '/<span class="value" itemprop="color">(?<exterior_color>[^<]+)/',
//        'kilometres'     => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/',
//        'certified'      => '/"vehicle":\{"category":"(?<certified>certified)/',
//        'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
//        'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
//        'vin'            => '/,"vin":"(?<vin>[^"]+)","/',
//        'msrp'           => '/","msrp":"(?<msrp>[^"]+)","/',
//        'year'           => '/,"year":"(?<year>[^"]+)","/',
//        'model'          => '/,"model":"(?<model>[^"]+)","/',
//        'trim'           => '/,"trim":"(?<trim>[^"]+)","/',
//        'make'           => '/,"make":"(?<make>[^"]+)","/',
//        'price'          => '/itemprop="price"\s*data-action="priceSpecification"[^>]+>(?<price>[^<]+)<\/span>/',
//    ),
//    'next_page_regx'         => '/data-action=\\\"next\\\" href=\\\"(?<next>[^\\\"]+)/',
//    'images_regx'            => '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/',
//    'images_fallback_regx'   => '/<meta if="[^"]+"\sproperty="og:image" content="(?<img_url>[^"]+)"/',
//);
//
//add_filter("filter_axelrodbuickgmc_next_page", "filter_axelrodbuickgmc_next_page", 10, 2);
//add_filter("filter_axelrodbuickgmc_field_images", "filter_axelrodbuickgmc_field_images");
//
//function filter_axelrodbuickgmc_next_page($next, $current_page)
//{
//            slecho("Filtering Next url:" . $next);
//        $car_type= explode('=', $current_page);
//       
//        $next = ($next . "&handler=deferredBlockHandler&use.hydra.deferred.blocks=true&blockCacheType=consumer-eager-lazy&blockUri=view%2FconsumerBlock%3Fid%3Dview%2Fcard%2F00243bbd-2658-48fb-ae55-7ff2ad04e29b%2Cview%2Fcard%2F517a83df-1dee-4901-82d3-29bf77a3f9a6%26lazyId%3Dundefined%26fields%3Dhtml%2Chead%2Cscripts%2CautofillTokens&siteFront=false");
//        return urlCombine($next, "?search={$car_type[count($car_type)-1]}");
//}
//
//function filter_axelrodbuickgmc_field_images($im_urls)
//{
//    if (count($im_urls) < 8) {
//        return [];
//    }
//
//    return $im_urls;
//}
    // 'entry_points'        => array(
    //     'new' => 'https://www.axelrodbuickgmc.com/VehicleSearchResults?search=new'
    // ),
    // 'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    // 'use-proxy'           => true,

    // 'picture_selectors'   => ['.scroll-content-item'],
    // 'picture_nexts'       => ['.bx-next'],
    // 'picture_prevs'       => ['.bx-prev'],

    // "custom_data_capture" => function ($url, $data) {
    //     $site                 = "https://www.axelrodbuickgmc.com/sitemap.xml";
    //     $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
    //     $images_regx          = '/itemprop="associatedMedia".*data-src="(?<img_url>[^"]+)/i';
    //     $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
    //     $required_params      = [];
    //     $use_proxy            = true;
    //     $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png'];
    //    $annoy_func = function ($car) {
    //       $imgs   = [];
    //        $images = explode('|', $car['all_images']);

    //        $retval            = preg_replace('/http(s)?:.*(?=http)/', '', $images, -1);
    //         $car['all_images'] = implode("|", $retval);

    //       $im_urls=array_unique($im_urls);
    //              if (count($im_urls) < 2) {
    //             $car_data['all_images'] = implode('|', $im_urls);
    //         } else {
    //             $car_data['all_images'] = '';
    //            // slecho ("less than two images");
    //         }
    //         return $car;
    //     };
    //     $data_capture_regx_full = [
    //        // 'title'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
    //         'stock_type'     => '/"category":"(?<stock_type>[^"]+)/i',
    //         'year'           => '/"year":"(?<year>[^"]+)/i',
    //         'make'           => '/"make":"(?<make>[^"]+)/i',
    //         'model'          => '/"model":"(?<model>[^"]+)/i',
    //         'trim'           => '/trim":"(?<trim>[^"]+)","year/i',
    //      'price'          => '/"price":"(?<price>[^"]+)/i',    
    //      'engine'         => '/Engine<\/span>\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<engine>[^<]+)/i',
    //      'transmission' => '/itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
    //      'kilometres'     => '/itemprop="mileageFromOdometer">\s*<span>(?<kilometres>[^<]+)/i',
    //        // 'exterior_color' => '/Exterior Colour<\/dt><[^>]+><span>(?<exterior_color>[^<]+)<\/span>/i',
           
    //     'stock_number' => '/Stock Number<\/span>[^>]+>(?<stock_number>[^<]+)/',
    //     'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
    //     'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
    //     'vin' => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
    //     ];

    //     $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

    //     return $cars;
    // }
    // );