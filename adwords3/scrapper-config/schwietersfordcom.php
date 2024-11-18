<?php
global $scrapper_configs;
$scrapper_configs["schwietersfordcom"] = array( 
    'entry_points' => array(
        'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/SchwietersFord.csv'
           ),
      'vdp_url_regex'         => '/\/auto\//',
       'use-proxy'         => true,
      'refine' => false,
      'picture_selectors' => ['.preview_vehicle_image_item'],
      'picture_nexts'     => ['.dep_image_slider_alt_next_btn'],
      'picture_prevs'     => ['.dep_image_slider_alt_prev_btn'],
  
  'custom_data_capture' => function($url, $resp) {
      $vehicles = convert_CSV_to_JSON($resp);

      $result = [];

      foreach ($vehicles as $vehicle) {
          $car_data = [
              'stock_number' => $vehicle['Stock #'],
              'vin' => $vehicle['VIN'],
              'year' => $vehicle['Year'],
              'make' => $vehicle['Make'],
              'model' => $vehicle['Model'],
              'trim' => $vehicle['Series'],
              'drivetrain' => $vehicle['Drivetrain Desc'],
              'fuel_type' => $vehicle['Fuel'],
              'transmission' => $vehicle['Transmission'],
              'body_style' => $vehicle['Body'],
              'images' => explode('|', $vehicle['Photo Url List']),
              'all_images' => $vehicle['Photo Url List'],
              'price' => $vehicle['Price'] > 0 ? $vehicle['Price'] : $vehicle['MSRP'],
              'url'  => "https://www.schwietersford.com/auto/*/" . $vehicle['VIN'],
              'stock_type' => $vehicle['New/Used'] == 'N' ? "new" : 'used',
              'exterior_color' => $vehicle['Colour'],
              'interior_color' => $vehicle['Interior Color'],
              'engine' => $vehicle['Engine'],
              'description' => strip_tags($vehicle['Description']),
              'kilometres' => $vehicle['Odometer'],
          ];


          $result[] = $car_data;
      }
      return $result;
  }
);


//	 'entry_points' => array(
//           'used' => 'https://www.schwietersford.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_USED:inventory-data-bus1/getInventory?start=0&page=1',
//        'new' => 'https://www.schwietersford.com/apis/widget/INVENTORY_LISTING_DEFAULT_AUTO_NEW:inventory-data-bus1/getInventory?start=0&page=1'
//    ),
//       'vdp_url_regex' => '/\/(?:new|used|certified)\/[^\/]+\/[0-9]{4}-/i',
//       // 'ajax_url_match' => '/ajax/xxSubmitForm.asp',
//        'use-proxy' => true,
//        'picture_selectors' => ['.pswp-thumbnail'],
//        'picture_nexts' => ['.pswp__button--arrow--right'],
//        'picture_prevs' => ['.pswp__button--arrow--left'],
//        'custom_data_capture' => function($url, $data) {
//
//            $objects = json_decode($data);
//
//            if (!$objects) {
//                slecho($data);
//            }
//
//            $to_return = array();
//
//            foreach ($objects->pageInfo->trackingData as $obj) {
//
//                $car_data = array(
//                    'stock_number' => !empty($obj->stockNumber) ? $obj->stockNumber : $obj->vin,
//                    'stock_type' => $obj->newOrUsed,
//                    'vin' => $obj->vin,
//                    'year' => $obj->modelYear,
//                    'make' => $obj->make,
//                    'model' => $obj->model,
//                    'body_style' => $obj->bodyStyle,
//                    'price' => $obj->pricing->finalPrice,
//                    'trim' => $obj->trim,
//                    'transmission' => $obj->transmission,
//                    'kilometres' => $obj->odometer,
//                    'exterior_color'    => $obj->exteriorColor,
//                    'interior_color'    => $obj->interiorColor,
//                    'fuel_type'    => $obj->fuelType,
//                    'drive_train'    => $obj->driveLine,
//                    'options'           => isset($obj->installed_options)?$obj->installed_options:array(),
//                   // 'images'            => array_merge($obj->photos->user, $obj->photos->stock),    
//                    'url' => "https://www.schwietersford.com/{$obj->newOrUsed}/{$obj->make}/{$obj->modelYear}-{$obj->make}-{$obj->model}-{$obj->uuid}".".htm",
//                                
//                );
//
//                $to_return[] = $car_data;
//            }
//
//            return $to_return;
//        },
//        'next_page_regx' => '/enableMyCars":(?<next>[^"]+)/',
//        'images_regx' => '/"id":[^"]+"uri":"(?<img_url>[^"]+)"[^"]+"thumbnail/',
//   
//);
//add_filter("filter_schwietersfordcom_field_images", "filter_schwietersfordcom_field_images");
//add_filter("filter_schwietersfordcom_next_page", "filter_schwietersfordcom_next_page", 10, 2);
// function filter_schwietersfordcom_next_page($next, $current_page) {
//
//    
//        $start_tag = 'start=';
//        $end_tag = '&';
//
//        if (stripos($current_page, $start_tag)) {
//            $resp = substr($current_page, stripos($current_page, $start_tag) + strlen($start_tag));
//        }
//
//        if (strpos($resp, $end_tag)) {
//            $resp = substr($resp, 0, stripos($resp, $end_tag));
//        }
//
//        $rep_value = $resp + 18;
//
//
//        $find = "start=" . $resp;
//        $rep = "start=" . $rep_value;
//        $next = str_replace($find, $rep, $current_page);
//        slecho($next);
//    
//    return $next;
//}
//
//function filter_schwietersfordcom_field_images($im_urls)
//{
//    if (count($im_urls) < 8) {
//        return [];
//    }
//    foreach($im_urls as $im_url){
//        if(endsWith($im_url, '2cdbbff1109a6bc38b1648d866b6add8x.jpg')){
//            return null;
//        }
//    }
//    return $im_urls;
//}