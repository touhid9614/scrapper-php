<?php 
// global $scrapper_configs;
// $scrapper_configs["carznvanzconz"] = array( 
//     'entry_points' => array(
//            'all'   => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/carznvanzconz.csv'
//        ),
//        'vdp_url_regex'     => '/\/vehicle\//i',
//        
//        'use-proxy' => true,
//        'picture_selectors' => ['.inner'],
//        'picture_nexts'     => ['.pswp__button.pswp__button--arrow--right'],
//        'picture_prevs'     => ['.pswp__button.pswp__button--arrow--left'],
//        'custom_data_capture' => function($url,$data) {
//            $vehicles = convert_CSV_to_JSON($data);
//            
//            $result = [];
//            
//            foreach($vehicles as $vehicle) {
//                $car_data = [
//                    'stock_number'  => $vehicle['StockNo'],
//                    'vin'           => $vehicle['VIN'],
//                    'year'          => $vehicle['Year'],
//                    'make'          => $vehicle['Manufacturer'],
//                    'model'         => $vehicle['Model'],
//                    'trim'          => $vehicle['Trim'],
//                    'body_style'    => $vehicle['BodyStyle'],
//                    'engine'        => $vehicle['Engine'],
//                    'drivetrain'    => $vehicle['Drivetrain Desc'],
//                    'transmission'  => $vehicle['Transmission'], 
//                    'fuel_type'     => $vehicle['FuelType1'],
//                    'images'        => explode(',', $vehicle['Photo Url List']),
//                    'all_images'    => implode('|', explode(',', $vehicle['Photo Url List'])),
//                    'price' => $vehicle['SpecialPriceAmount'] > 0 ? $vehicle['SpecialPriceAmount'] : ($vehicle['RetailPriceAmount'] > 0 ? $vehicle['RetailPriceAmount'] : "please call") ,
//                    // 'price'         => $vehicle['SpecialPriceAmount']==''?$vehicle['MSRP']: $vehicle['Price'],
//                    // 'url'           => "https://www.bonifacehierschryslerdodge.com/auto/*/" . $vehicle['VIN'],
//                    'url' => "https://www.carznvanz.co.nz/vehicle/".$vehicle["Year"]."-".$vehicle["Manufacturer"]."-".$vehicle["Model"]."/".$vehicle["StockNo"]."?s=1",
//                    'stock_type'    => "used",
//                    'exterior_color'=> $vehicle['ExtColor1'],
//
//                ];
//                
//               
//                
//                $result[] = $car_data;
//            }
//            
//            return $result;
//        },
//        'images_regx' => '/<a style=[^>]+>\s*<img src="(?<img_url>[^"]+)"/',
//    );
//
//



//https://app.asana.com/0/1159366839112632/1189429470551873




 global $scrapper_configs;
 $scrapper_configs["carznvanzconz"] = array( 
 	 'entry_points' => array(
         'used' => 'https://www.carznvanz.co.nz/vehicles', 
     ),
     'vdp_url_regex' => '/\/vehicle\/[0-9]{4}/i',
    // 'use-proxy' => true,
     'refine'=>false,
    'picture_selectors' => ['.gallery-thumb-wrapper .gallery-thumbs .thumb-item'],
     'picture_nexts' => ['.gallery-counter .icon-arrow-right'],
     'picture_prevs' => ['.gallery-counter .icon-arrow-left'],
      'details_start_tag' => '<div class="row vehicle-results gallery">',
     'details_end_tag' => '<footer>',
     'details_spliter' => '<li class="vehicle">',
     'data_capture_regx' => array(
         'url' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*]+)/',
         'year' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*]+)/',
         'make' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*]+)/',
         'model' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*]+)/',
         'trim' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)\s*(?<trim>[^\s*]+)/',
         'price' => '/<span class="amount">(?<price>\$[0-9,]+)/',
         'stock_number' => '/class="small-10 columns">\s*<a href="\/[^\/]+\/[^\/]+\/(?<stock_number>[^\?]+)/',
         'msrp' => '/<span class="amount">(?<msrp>\$[0-9,]+)/',
     ),
     'data_capture_regx_full' => array(
          'transmission'      => '/Transmission<\/div>\s*[^>]+>\s*(?<transmission>[^\s*]+)/',
          'kilometres'        => '/Odometer<\/div>\s*<[^>]+>\s*(?<kilometres>[^(\s|k)]+)/',
          'body_style'        => '/Body<\/div>\s*[^>]+>(?<body_style>[^<]+)/',
          'engine'            => '/Engine<\/div>\s*[^>]+>(?<engine>[^<]+)/',   
          'exterior_color' => '/Ext Colour<\/div>\s*[^>]+>\s*(?<exterior_color>[^<]+)/',
          'interior_color' => '/Interior<\/div>\s*<div [^>]+>\s*(?<interior_color>[^\n]+)/',
          'vin'           => '/"vin": "(?<vin>[^"]+)/',
          'description' => '/class="short-desc">(?<description>[^<]+)/',
          'fuel_type'      => '/<option value="petrol">(?<fuel_type>[^<]+)/',
          'drivetrain' => '/"driveTrain":"(?<drivetrain>[^"]+)/',
     ),
     'next_page_regx' => '/<a class="btn-next" href="(?<next>[^"]+)">><\/a>/',
     'images_regx' => '/<a style="" onclick[^<]+<img src="..\/..\/(?<img_url>[^"]+)/'
 );

 add_filter("filter_carznvanzconz_field_images", "filter_carznvanzconz_field_images");
 function filter_carznvanzconz_field_images($im_urls)
 {
     $new_im_urls = [];
     $url_base = "https://www.carznvanz.co.nz";
      foreach ($im_urls as $im_url)
     {
         $new_im_url = preg_replace("/https:\/\/www.carznvanz.co.nz\/vehicle\/[^\/]+/", $url_base, $im_url);
         array_push($new_im_urls, $new_im_url);
     }
     return $new_im_urls;
 }
 add_filter('filter_carznvanzconz_car_data', 'filter_carznvanzconz_car_data');

 function filter_carznvanzconz_car_data($car_data) {

     if(!isset($car_data['exterior_color'])){
        $car_data['exterior_color']="other";
     }
     if(!isset($car_data['vin'])){
         $car_data['vin']=md5($car_data['url']);
     }
     if(!isset($car_data['drivetrain'])){
        $car_data['drivetrain']="Other";
     }

     return $car_data;
 }
