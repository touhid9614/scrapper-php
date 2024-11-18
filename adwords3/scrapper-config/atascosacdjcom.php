<?php
global $scrapper_configs;
$scrapper_configs["atascosacdjcom"] = array( 
//	'entry_points' => array(
//        'used'  => 'https://www.atascosacdj.com/used-inventory/index.htm',
//       ),
//      'vdp_url_regex'       => '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i',
//      'use-proxy'           => true,
//      'refine'             => false,
//      'picture_selectors'   => ['.scroll-content-item'],
//      'picture_nexts'       => ['.bx-next'],
//      'picture_prevs'       => ['.bx-prev'],
//  
//      "custom_data_capture" => function ($url, $data) {
//          $site                 = "https://www.atascosacdj.com/sitemap.xml";
//          $vdp_url_regex        = '/\/(?:new|used)\/[^\/]+\/[0-9]{4}-/i';
//          $images_regx          = '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/i';
//          $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
//          $required_params      = [];
//          $use_proxy            = true;
//  
//          $data_capture_regx_full = [
//              'title'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
//              'stock_type'     => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
//              'year'           => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
//              'make'           => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
//              'model'          => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
//              'trim'           => '/<meta name="og:title" content="(?<title>(?<stock_type>[^ ]+) *(?<year>[^ <]+) *(?<make>[^ <]+) *(?<model>[^ <]+) *(?<trim>[^ <]+) *?[^\s*]*)/i',
//              'price'          => '/final-price .price-value">(?<price>[^<]+)/i',
//              'engine'         => '/Engine<\/dt>[^>]+>[^>]+>(?<engine>[^<]+)<\/span>/i',
//              'transmission'   => '/"transmission":\s*"(?<transmission>[^"]+)/i',
//              'kilometres'     => '/odometer:\s*\'(?<kilometres>[^\']+)/i',
//              'exterior_color' => '/Exterior Colour<\/dt><[^>]+><[^>]+><[^>]+><[^>]+>(?<exterior_color>[^<]+)/i',
//              'interior_color' => '/Interior Colour[^>]+>[^>]+>[^>]+>(?<interior_color>[^<]+)<\/span>/i',
//              'stock_number'   => '/"stockNumber":\s*"(?<stock_number>[^"]+)/i',
//              'vin'            => '/vin:\s*\'(?<vin>[^\']+)/i',
//              'body_style'     => '/bodyStyle:\s*\'(?<body_style>[^\']+)/i',
//              
//          ];
//  
//          $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy);
//          $return_cars = [];
//            $im_urls=[];
//          foreach ($cars as $car) {
//              $car['transmission'] = str_replace('\x2D', '', $car['transmission']);
//  
//              if (!$car['transmission']) {
//                  $car['transmission'] = '';
//              }
//  
//              if (strtolower($car['trim']) == 'for') {
//                  $car['trim'] = '';
//              }
//              
//              
//         //     unset($car['custom']);
//              $return_cars[] = $car;
//          }
//  
//          return $return_cars;
//      }
//  );
//add_filter("filter_atascosacdjcom_field_images", "filter_atascosacdjcom_field_images");
//    
//    function filter_atascosacdjcom_field_images($im_urls)
//    {
//       if(count($im_urls)<2)
//            {
//            return [];
//            
//            }
//       
//        return $im_urls;
//    }
     'entry_points' => array(
          'used' => 'https://www.atascosacdj.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
        'new' => 'https://www.atascosacdj.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
    ),
       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
      'srp_page_regex' => '/\/(?:new|used|certified)-inventory/i',
       // 'ajax_url_match' => '/ajax/xxSubmitForm.asp',
        'use-proxy' => true,
        'picture_selectors' => ['.pswp-thumbnail'],
        'picture_nexts' => ['.pswp__button--arrow--right'],
        'picture_prevs' => ['.pswp__button--arrow--left'],
        'custom_data_capture' => function($url, $data) {

            $objects = json_decode($data);

            if (!$objects) {
                slecho($data);
            }

            $to_return = array();

            foreach ($objects->pageInfo->trackingData as $obj) {

                $car_data = array(
                    'stock_number' => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
                    'stock_type' => $obj->newOrUsed,
                    'vin' => $obj->vin,
                    'year' => $obj->modelYear,
                    'make' => $obj->make,
                    'model' => $obj->model,
                    'body_style' => $obj->bodyStyle,
                //   'price' => $obj->internetPrice,
                    'trim' => $obj->trim,
                    'transmission' => $obj->transmission,
                    'kilometres' => $obj->odometer,
                    'exterior_color'    => $obj->exteriorColor,
                    'interior_color'    => $obj->interiorColor,
                    'fuel_type'    => $obj->fuelType,
                    'drive_train'    => $obj->driveLine,
                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
                    'url' => "https://www.atascosacdj.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
                                
                );
                 $response_data = HttpGet($car_data['url']);
                $regex       =  '/<meta name="description" content="(?<description>[^"]+)/';
                $matches = [];
                if(preg_match($regex, $response_data, $matches)) {

                $car_data['description']=$matches['description'];

                }  
                
            //$response_data = HttpGet($car_data['url']);
            $regex = '/(?:.askingPrice|.final-price) .price-value">(?<price>[^<]+)/';
            $matches = [];
            if (preg_match($regex, $response_data, $matches)) {

                $car_data['price'] = $matches['price'];
            }    
                
                
                $to_return[] = $car_data;
            }

            return $to_return;
        },
        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
   
);
        
 add_filter("filter_atascosacdjcom_next_page", "filter_atascosacdjcom_next_page", 10, 2);       
 function filter_atascosacdjcom_next_page($next, $current_page) {

    
        $start_tag = 'start=';
        $end_tag = '&';

        if (stripos($current_page, $start_tag)) {
            $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
        }

        if (strpos($resp, $end_tag)) {
            $resp = substr($resp, 0, stripos($resp, $end_tag));
        }

        $rep_value = $resp + 18;


        $find = "start=" . $resp;
        $rep = "start=" . $rep_value;
        $next = str_replace($find, $rep, $current_page);
        slecho($next);
    
    return $next;
}

add_filter("filter_atascosacdjcom_field_images", "filter_atascosacdjcom_field_images");
    
    function filter_atascosacdjcom_field_images($im_urls)
    {
       if(count($im_urls)<2)
            {
            return [];
            
            }
       
        return $im_urls;
    }