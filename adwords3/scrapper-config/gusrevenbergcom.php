<?php
global $scrapper_configs;
$scrapper_configs["gusrevenbergcom"] = array( 
    "entry_points" => array(
	       
        'new' => 'https://www.gusrevenberg.com/en/new-catalog',
         
       ),
    'vdp_url_regex'       => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
    'use-proxy'           => false,

    'picture_selectors'   => ['.current'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.gusrevenberg.com/en/sitemap-xml";
        $vdp_url_regex        = '/\/en\/(?:new|used)-(?:catalog|inventory)\//i';
        $images_regx          = '/<img src="(?<img_url>[^"]+)"\s*alt="[^"]+"\s*itemprop="image/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = false;
        $use_custom_site      = true;

        $data_capture_regx_full = [
            'stock_type'     => '/vehicleType:\'(?<stock_type>[^\']+)/i',
            'year'           => '/year:\s*\'(?<year>[^\']+)/i',
            'make'           => '/make:\s*\'(?<make>[^\']+)/i',
            'model'          => '/model:\s*\'(?<model>[^\']+)/i',
            'price'          => '/displayedPrice:\s*\'(?<price>[^\.]+)/i',
            'trim'          => '/trim:\s*\'(?<trim>[^\']+)/',
            'body_style'    => '/bodyStyle\s*:\s*\'(?<body_style>[^\']+)/',
            'stock_number'   => '/Stock#(?<stock_number>[^<]+)/i',
            'vin'            => '/VIN[^>]+>\s*[^>]+>\s*(?<vin>[^<]+)/i',
      ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        return $cars;

    },
     'images_regx'          => '/loading="lazy" alt="[^"]+"\s*height="400"\s*width="600"\s*data-src="(?<img_url>[^"]+)/',
     'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/',
);
// 	"entry_points" => array(
// 	 'used' => 'https://www.gusrevenberg.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
//         'new' => 'https://www.gusrevenberg.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
//     ),
//        'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
//        // 'ajax_url_match' => '/ajax/xxSubmitForm.asp',
//         'use-proxy' => true,
//         'picture_selectors' => ['.pswp-thumbnail'],
//         'picture_nexts' => ['.pswp__button--arrow--right'],
//         'picture_prevs' => ['.pswp__button--arrow--left'],
//         'custom_data_capture' => function($url, $data) {

//             $objects = json_decode($data);

//             if (!$objects) {
//                 slecho($data);
//             }

//             $to_return = array();

//             foreach ($objects->pageInfo->trackingData as $obj) {

//                 $car_data = array(
//                     'stock_number' => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
//                     'stock_type' => $obj->newOrUsed,
//                     'vin' => $obj->vin,
//                     'year' => $obj->modelYear,
//                     'make' => $obj->make,
//                     'model' => $obj->model,
//                     'body_style' => $obj->bodyStyle,
//                     'price' => $obj->askingPrice,
//                     'trim' => $obj->trim,
//                     'transmission' => $obj->transmission,
//                     'kilometres' => $obj->odometer,
//                     'exterior_color'    => $obj->exteriorColor,
//                     'interior_color'    => $obj->interiorColor,
//                     'fuel_type'    => $obj->fuelType,
//                     'drive_train'    => $obj->driveLine,
//                     'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
//                    // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
//                     'url' => "https://www.gusrevenberg.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
//                 );

//                 $to_return[] = $car_data;
//             }

//             return $to_return;
//         },
//         'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
//         'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
// );
        
//  add_filter("filter_gusrevenbergcom_next_page", "filter_gusrevenbergcom_next_page", 10, 2);       
//  function filter_gusrevenbergcom_next_page($next, $current_page) {

    
//         $start_tag = 'start=';
//         $end_tag = '&';

//         if (stripos($current_page, $start_tag)) {
//             $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
//         }

//         if (strpos($resp, $end_tag)) {
//             $resp = substr($resp, 0, stripos($resp, $end_tag));
//         }

//         $rep_value = $resp + 18;


//         $find = "start=" . $resp;
//         $rep = "start=" . $rep_value;
//         $next = str_replace($find, $rep, $current_page);
//         slecho($next);
    
//     return $next;
// }
