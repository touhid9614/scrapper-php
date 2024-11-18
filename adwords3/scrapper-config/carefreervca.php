<?php
global $scrapper_configs;
$scrapper_configs["carefreervca"] = array( 
// 	 'entry_points' => array(
//                'used'  => 'https://www.carefreerv.ca/used-rvs-for-sale?page=1',
//                'new'   => 'https://www.carefreerv.ca/new-rvs-for-sale?page=1',
           
//         ),
//         'vdp_url_regex'     => '/\/product\/(?:new|used)-/i',
//         'ty_url_regex'      => '/\/contact-confirmation/i',
//         'use-proxy'         => true,
//         'refine'            => false,
     
//         'picture_selectors' => ['#main > div > div.row > div.col-md-7 > div.detailMedia > div.detail-thumbnail-wrapper.hidden-xs > div > div > img'],
//         'picture_nexts'     => ['.sliderNext'],
//         'picture_prevs'     => ['.sliderPrev'],
     
//         'details_start_tag' => '<div class="listingPagination listingToolbar">',
//         'details_end_tag'   => '<div class="listingPagination bottomPaging',
//         'details_spliter'   => "<li class='unit",
//         'data_capture_regx' => array(
//             'stock_number'      => '/data-stocknumber="(?<stock_number>[^"]+)/',
//             'url'               => '/data-unitlink="(?<url>[^"]+)/',
//             'year'              => '/data-year="(?<year>[^"]+)/',
//             'make'              => '/unit-mfg">(?<make>[^"]+)/',
//             'model'             => '/data-brand="(?<model>[^"]+)/',
//             'trim'              => '/unit-model">(?<trim>[^<]+)/',
//             'price'             => '/data-saleOrRegularPrice="(?<price>[^"]+)/',
//             'body_style'        => '/data-type="(?<body_style>[^"]+)/',
//         ),
//         'data_capture_regx_full' => array(
//             'stock_number'      => '/<span class="stock-number-text">(?<stock_number>[^<]+)/',
//             'vin'               => '/Specvin specs-desc">(?<vin>[^<]+)/',
//             'exterior_color'    => '/SpecInteriorColor specs-desc">(?<exterior_color>[^<]+)/',
//         ),
//         'next_query_regx'   => '/<a href="#" class="next" title="Next Page" data-(?<param>page)="(?<value>[0-9]*)"/',
//         'images_regx'       => '/<li>\s*<img llsrc="(?<img_url>[^"]+)"/'
//     );

// add_filter('filter_carefreervca_car_data', 'filter_carefreervca_car_data');
// function filter_carefreervca_car_data($car_data) {

//     if(empty($car_data['exterior_color']))
//     {
//         $car_data['exterior_color'] = "Not Defined";
//     }
//     $ignore_data=[
//                   'P51579',
//                   '51349A',
//                   'P51652',
//                   'P51343',
//                   'P51209',
//                   'P51567',
//                   'C51680',
                  
//               ];
    
//     if (in_array($car_data['stock_number'], $ignore_data)) 
//     {
//         slecho("Excluding car that has  ,{$car_data['stock_number']}");
//          return null;

//     }
//     return $car_data;
// }

// add_filter("filter_carefreervca_field_images", "filter_carefreervca_field_images");

// function filter_carefreervca_field_images($im_urls) {
//     if (count($im_urls) < 4) {
//         return array();
//     }

//     return $im_urls;
// }

    

    //some stock numbers were missing i believe its because of their next page issue that's why i am using crawler to find out//


    "entry_points"        => array(
        'new' => 'https://www.carefreerv.ca/new-rvs-for-sale',
    ),

    'vdp_url_regex'       => '/\/product\/(?:new|used)-/',
   

    'use-proxy'           => true,
    'refine'              => false,

    'picture_selectors'   => ['.deck-gallery[smartgallery] > .deck > section'],
    'picture_nexts'       => ['div.arrow.single.next'],
    'picture_prevs'       => ['div.arrow.single.prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.carefreerv.ca/sitemap.xml";
        $vdp_url_regex        = '/\/product\/(?:new|used)-/';
        $images_regx          = '/<li>\s*<img llsrc="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = []; // Mandatory url parameters
        $use_proxy            = true; // Uses proxy to reach site
        $keymap               = null; // Return the output data mapped against any car key
        $invalid_images       = ['photo_unavailable_320.gif']; // List of image urls to be filtered out
        $use_custom_site      = true; // Force crawler to use the given url as sitemap url

        $annoy_func = function ($car) {
            // filter stock_numbers
           $drop_stocks = ['P51579', '51349A', 'P51652', 'P51343' ,'P51209', 'P51567', 'C51680'];


           if (in_array($car['stock_number'], $drop_stocks)) {
               return [];
           }
       
            // image filter
            $imgs = explode("|", $car['all_images']);
            if (count($imgs) < 4) {
                return [];
            }


            return $car;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'year'           => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'make'           => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'model'          => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'trim'           => '/<meta property="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
            'stock_number'   => '/<span class="stock-number-text">(?<stock_number>[^<]+)/',
            'exterior_color' => '/SpecInteriorColor specs-desc">(?<exterior_color>[^<]+)/',
           // 'interior_color' => '/","interior":"(?<interior_color>[^"]+)","/',
            'price'          => '/data-saleprice="(?<price>[^"]+)/',
            //'engine'         => '/<span class="value" itemprop="vehicleEngine">(?<engine>[^<]+)<\/span>/',
           // 'transmission'   => '/","transmission":"(?<transmission>[^"]+)"/',
           // 'drivetrain'     => '/<span class="value" itemprop="driveWheelConfiguration">(?<drivetrain>[^<]+)<\/span>/',
           // 'kilometres'     => '/","miles":"(?<kilometres>[^"]+)","/',
            'body_style'     => '/data-type="(?<body_style>[^"]+)/',
            'vin'            => '/Specvin specs-desc">(?<vin>[^<]+)/',
           // 'vehicle_id'     => '/<a rel="nofollow" data-vehicleid="(?<vehicle_id>[^"]+)"/',
           // 'custom'         => '/<span itemprop="mpn">(?<custom>[^<]+)<\/span>/',
          //  'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);
