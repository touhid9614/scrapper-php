<?php
global $scrapper_configs;
 $scrapper_configs["sunsetcountryfordcom"] = array( 
    "entry_points"        => array(
        'new' => 'https://www.sunsetcountryford.com/inventory/new/',
    ),

    'vdp_url_regex'       => '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-[^-]+-/i',
    "use-proxy"           => false,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.sunsetcountryford.com/inventory_pages-sitemap.xml";
        $vdp_url_regex        = '/\/inventory\/(?:New|certified|Used)-[0-9]{4}-[^-]+-/i';
        $images_regx          = '/data-lightbox="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];     // Mandatory url parameters
        $use_proxy            = false;   // Uses proxy to reach site
        $keymap               = null;   // Return the output data mapped against any car key
        $invalid_images       = [];     // List of image urls to be filtered out
        $use_custom_site      = true;   // Force crawler to use the given url as sitemap url

        $customFun = function ($car_data) {
            if ($car_data['price'] == "$0.00" || $car_data['price'] == "0.00") {
                $car_data = [];
            }

            $car_data['svin'] = url_to_svin($car_data['url']);

            return $car_data;
        };

        $data_capture_regx_full = [
            'stock_type'     => '/itemCondition":"(?<stock_type>[^"]+)/', // Must scrap
            'kilometres'     => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
            'engine'         => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
            'transmission'   => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color' => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color' => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/',
            'vin'            => '/data-vehicle="vin"\s*>(?<vin>[^<]+)/',
            'stock_number'   => '/data-vehicle="stock"\s*>(?<stock_number>[^<]+)/',
            'year'           => '/class="vehicle-title--year">(?<year>[^<]+)/',
            // 'stock_type'     => '/class="vehicle-title--type">(?<stock_type>[^<]+)/',
            'make'           => '/class="notranslate vehicle-title--make ">(?<make>[^<]+)/',
            'model'          => '/class="notranslate vehicle-title--model ">(?<model>[^<]+)/',
            //'trim'           => '/class="notranslate vehicle-title--trim ">(?<trim>[^<]+)/',
            'body_style'     => '/class="title-standardbody vehicle-title--subtitle-item">(?<body_style>[^<]+)/',
            'drivetrain'     => '/class="title-drivetrain vehicle-title--subtitle-item">(?<drivetrain>[^<]+)/',
            'price'          => '/,"price":(?<price>[^,]+),"priceCurrency":"USD"/',
            'description'    => '/name="description" content="(?<description>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $customFun);

        return $cars;
    }
);
//     'entry_points'           => array(   
//         'new'  => 'https://www.sunsetcountryford.com/inventory/new/',
//         'used'  => 'https://www.sunsetcountryford.com/inventory/used/',   
//     ),
//     'use-proxy'              => true,
//     'refine'                 => false,
//     'vdp_url_regex'          => '/\/inventory\//i',
//     // 'srp_page_regex'          => '/\/inventory\/(?:New|certified|Used)\//i',
//     'picture_selectors'      => ['.slick-slide img'],
//     'picture_nexts'          => ['.slick-next'],
//     'picture_prevs'          => ['.slick-prev'],
//     'details_start_tag'      => 'class="srpVehicles__wrap">',
//     'details_end_tag'        => 'class="disclaimer__wrap">',
//     'details_spliter'        => 'id="carbox',
//     'data_capture_regx'      => array(
//         'url'          => '/data-permalink="(?<url>[^"]+)/',
//         /*'year'         => '/year">\s*(?<year>[0-9]{4})/',
//         'make'         => '/vehicle-title--make\s*">\s*(?<make>[^\s]+)/',
//         'model'        => '/vehicle-title--model\s*">\s*(?<model>[^<]+)/',
//         'stock_number' => '/Stock#:<\/span>[^>]+>(?<stock_number>[^<]+)/',
//         'price'        => '/(?:MSRP|Market Price)<\/div><div\s*[^>]+>\s*<span\s*[^>]+><span\s*[^>]+>[^>]+><span\s*[^>]+>(?<price>[0-9,]+)/',
//         'vin'          => '/VIN#:<\/span>\s*<span\s*class="vehicleIds--value"\s*>(?<vin>[^<]+)/',*/
//     ),
//     'data_capture_regx_full' => array(
//         'kilometres'     => '/data-vehicle="miles"[^>]+>(?<kilometres>[^<]+)/',
//         'engine'         => '/Engine:<\/span>[^>]+>(?<engine>[^<]+)/',
//         'transmission'   => '/Transmission:<\/span>[^>]+>(?<transmission>[^<]+)/',
//         'exterior_color' => '/Exterior Color:<\/span>[^>]+>(?<exterior_color>[^<]+)/',
//         'interior_color' => '/Interior Color:<\/span>[^>]+>(?<interior_color>[^<]+)/',
//         'vin'            => '/data-vehicle="vin"\s*>(?<vin>[^<]+)/',
//         'stock_number'   => '/data-vehicle="stock"\s*>(?<stock_number>[^<]+)/',
//         'year'           => '/class="vehicle-title--year">(?<year>[^<]+)/',
//         // 'stock_type'     => '/class="vehicle-title--type">(?<stock_type>[^<]+)/',
//         'make'           => '/class="notranslate vehicle-title--make ">(?<make>[^<]+)/',
//         'model'          => '/class="notranslate vehicle-title--model ">(?<model>[^<]+)/',
//         'trim'           => '/class="notranslate vehicle-title--trim ">(?<trim>[^<]+)/',
//         'body_style'     => '/class="title-standardbody vehicle-title--subtitle-item">(?<body_style>[^<]+)/',
//         'drivetrain'     => '/class="title-drivetrain vehicle-title--subtitle-item">(?<drivetrain>[^<]+)/',
//         'price'          => '/,"price":(?<price>[^,]+),"priceCurrency":"USD"/',
//         'description'    => '/name="description" content="(?<description>[^"]+)/',
//     ),
//     'next_page_regx'         => '/rel="next"\shref="(?<next>[^"]+)"/',
//     'images_regx'            => '/class="img-fluid[^"]+"\s*alt="[^"]+"\s*src="[^"]+"\s*data-src="(?<img_url>[^"]+)"/',
//     'images_fallback_regx'   => '/property="og:image" content="(?<img_url>[^"]+)"/',

// );
// 	 'entry_points' => array(
//             'new'   => 'https://www.sunsetcountryford.com/queryInventory',
//             'used'  => 'https://www.sunsetcountryford.com/queryInventory'
//         ),
//         'vdp_url_regex'         => '/\/(?:new|pre-owned|certified)\/[^\/]+\/[^\/]+\/[0-9]{4}-[^\.]+.html/',
// //        'ajax_url_match'        => '/libs/formProcessor.html',
//         'use-proxy'             => true,
//         'next_method'           => 'POST',
//         'content_type'          => 'application/json',
        
//         'picture_selectors' => ['.lSPager li img'],
//         'picture_nexts'     => ['.right'],
//         'picture_prevs'     => ['.left'],
//         'custom_data_capture'   => function($url, $data){
        
//             $objects = json_decode($data);
            
//             if(!$objects) { slecho($data); return array(); }
            
//             $to_return = array();
            
//             foreach($objects->hits->hits as $obj)
//             {
//                 $obj = $obj->_source;
                
//                 $w_regex = '/(?<weekly>\$[0-9,.]+)/';
//                 $weekly = 0;
                
//                 $match = array();
                
//                 if(preg_match($w_regex, $obj->source->feed->trim, $match)) {
//                     $weekly = numarifyPrice($match['weekly']);
//                 }
                
//                 $car_data = array(
//                     'stock_number'      => $obj->dealer->stock?$obj->dealer->stock:$obj->_id,
//                     'vin'               => $obj->vin,
//                     'year'              => $obj->year,
//                     'make'              => $obj->make,
//                     'model'             => $obj->model,
//                     'drivetrain'        => $obj->filters->drivetrain,
//                     'trim'              => $obj->source->feed->trim,
//                     'body_style'        => $obj->color->exterior,
//                     'fuel_type'         => $obj->filters->fuel_type,
//                     'price'             => $obj->price->minPrice - $obj->source->feed->attributes->{'Incentive Cadeliveryallowance'},
//                     'weekly'            => $weekly,
//                     'biweekly'          => $weekly * 2,
//                     'engine'            => $obj->filters->engine,
//                     'transmission'      => $obj->source->feed->transmissionType,
//                     'kilometres'        => $obj->mileage,
//                     'url'               => "https://www.sunsetcountryford.com/" . strtolower($obj->filters->condition) .
//                                            '/' . strtolower($obj->make) . '/' . strtolower($obj->model) .
//                                            '/' . strtolower($obj->year) . '-' . strtolower($obj->filters->exteriorColor) .
//                                            '-' . strtolower($obj->filters->trim) . '-' . strtolower($obj->_id) . '.html',
//                     'exterior_color'    => $obj->color->exteriorColor,
//                     'interior_color'    => $obj->color->interiorColor,
//                     'options'           => isset($obj->source->feed->attributes->Options)?$obj->source->feed->attributes->Options:array(),
//                     'images'            => array_merge($obj->source->feed->images->uploaded, $obj->source->feed->images->managed, $obj->source->feed->images->managed_feed_image),
//                 );
//                 $retval = array();
                
//                 if(count($car_data['images']) < 2) { $car_data['images'] = array(); }
                
//                  foreach($car_data['images'] as $url) {
//                  $url      = str_replace('https://imgcdn0.searchoptics.com/s/crop_px/0,0,640,480-640/', '', $url);
//                  $retval[] = str_replace('|', '%7C', $url);
//                  }
        
//                 $car_data['all_images'] = implode('|', $retval);
                
//                 $to_return[] = $car_data;
//             }
            
//             return $to_return;
//         }
//     );

//     add_filter('filter__post_data', 'filter_sunsetcountryfordcom_post_data', 10, 2);
//     add_filter('filter_sunsetcountryfordcom_car_data', 'filter_sunsetcountryfordcom_car_data');
//     function filter_sunsetcountryfordcom_car_data($car_data) {

//     if(empty($car_data['exterior_color']))
//     {
//         $car_data['exterior_color'] = "Other";
//     }
//     return $car_data;
// }

//     function filter_sunsetcountryfordcom_post_data($post_data, $stock_type)
//     {
//         if($stock_type == 'new')
//         {
//             $post_data = '{"size":1000,"from":0,"query":{"filtered":{"filter":{"bool":{"must":[{"not":{"term":{"administration.isSold":"1"}}},{"not":{"term":{"administration.isHideFromSite":"1"}}},{"bool":{"should":[{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_b8355"}},{"term":{"dealer.dealership_feed_id.lower":"5597"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"used_b8355"}},{"term":{"dealer.dealership_feed_id.lower":"5598"}},{"term":{"filters.condition.lower":"pre-owned"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"certified_b8355"}},{"term":{"dealer.dealership_feed_id.lower":"5599"}},{"term":{"filters.condition.lower":"certified"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}}]}},{"bool":{"should":[{"bool":{"must":[{"term":{"filters.condition.lower":"new"}},{"term":{"filters.make.lower":"ford"}}]}},{"bool":{"must":[{"term":{"filters.condition.lower":"pre-owned"}}]}},{"bool":{"must":[{"term":{"filters.condition.lower":"certified"}}]}}]}},{"bool":{"should":[{"term":{"filters.condition.lower":"new"}}]}}]}},"query":{"bool":{"should":[{"match_all":{}},{"boosting":{"positive":{"range":{"msrp":{"gte":1}}},"negative":{"range":{"msrp":{"lt":1}}},"negative_boost":0.5}}]}}}},"aggregations":{"colors":{"terms":{"field":"filters.exteriorColor.lower","size":0,"order":{"_term":"asc"}}},"doors":{"terms":{"field":"filters.doors.lower","size":0,"order":{"_term":"asc"}}},"fuelType":{"terms":{"field":"filters.fuel_type.lower","size":0,"order":{"_term":"asc"}}},"makes":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}},"models":{"terms":{"field":"filters.model.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawModel":{"terms":{"field":"filters.model","size":0,"order":{"_term":"asc"}}},"byTrim":{"terms":{"field":"filters.trim.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawTrim":{"terms":{"field":"filters.trim","size":0,"order":{"_term":"asc"}}}}},"byMake":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}}}},"bodyStyles":{"terms":{"field":"filters.bodyStyle.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"SubbodyStyles":{"terms":{"field":"filters.sub_bodystyle.lower","size":0,"order":{"_term":"asc"}}}}},"minPrice":{"min":{"field":"filters.price.minPrice"}},"maxPrice":{"max":{"field":"filters.price.maxPrice"}},"monthlyMinPrice":{"min":{"field":"filters.price.monthlyMinPrice"}},"monthlyMaxPrice":{"max":{"field":"filters.price.monthlyMaxPrice"}},"priceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.maxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.maxPrice","interval":5000}}}},"monthlyPriceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.monthlyMaxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.monthlyMaxPrice","interval":100}}}},"mileageBreakdown":{"histogram":{"field":"filters.mileage","interval":15000}},"registrationBreakdown":{"date_histogram":{"field":"date.registrationDate","interval":"year","format":"yyyy","offset":"+366d"}},"minYear":{"min":{"field":"filters.year"}},"maxYear":{"max":{"field":"filters.year"}},"years":{"terms":{"field":"filters.year","size":0,"order":{"_term":"desc"}}},"conditions":{"terms":{"field":"filters.condition.lower"}},"maxMileage":{"max":{"field":"filters.mileage"}},"retailers":{"terms":{"field":"filters.dealer_map_key.lower","size":0}},"transmissions":{"terms":{"field":"filters.transmissionType.lower","size":0,"order":{"_term":"asc"}}},"engines":{"terms":{"field":"filters.engine.lower","size":0,"order":{"_term":"asc"}}},"packages":{"terms":{"field":"filters.packages.lower","size":0,"order":{"_term":"asc"}}},"Custom Field 1":{"terms":{"field":"filters.Custom Field 1.lower","size":0}},"Custom Field 2":{"terms":{"field":"filters.Custom Field 2.lower","size":0}},"Custom Field 3":{"terms":{"field":"filters.Custom Field 3.lower","size":0}},"Custom Field 4":{"terms":{"field":"filters.Custom Field 4.lower","size":0}},"Custom Field 5":{"terms":{"field":"filters.Custom Field 5.lower","size":0}},"Custom Field 6":{"terms":{"field":"filters.Custom Field 6.lower","size":0}},"Custom Field 7":{"terms":{"field":"filters.Custom Field 7.lower","size":0}},"Custom Field 8":{"terms":{"field":"filters.Custom Field 8.lower","size":0}},"Custom Field 9":{"terms":{"field":"filters.Custom Field 9.lower","size":0}},"Custom Field 10":{"terms":{"field":"filters.Custom Field 10.lower","size":0}}},"sort":["_score",{"msrp":{"order":"asc"}}]}';
//         }
//         elseif($stock_type == 'used')
//         {
//             $post_data = '{"size":1000,"from":0,"query":{"filtered":{"filter":{"bool":{"must":[{"not":{"term":{"administration.isSold":"1"}}},{"not":{"term":{"administration.isHideFromSite":"1"}}},{"bool":{"should":[{"bool":{"must":[{"term":{"dealer.export_id.lower":"new_b8355"}},{"term":{"dealer.dealership_feed_id.lower":"5597"}},{"term":{"filters.condition.lower":"new"}},{"bool":{"should":[{"range":{"filters.price.msrp":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyMsrp":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"used_b8355"}},{"term":{"dealer.dealership_feed_id.lower":"5598"}},{"term":{"filters.condition.lower":"pre-owned"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}},{"bool":{"must":[{"term":{"dealer.export_id.lower":"certified_b8355"}},{"term":{"dealer.dealership_feed_id.lower":"5599"}},{"term":{"filters.condition.lower":"certified"}},{"bool":{"should":[{"range":{"filters.price.price":{"gte":0}}}]}},{"bool":{"should":[{"range":{"filters.price.monthlyPrice":{"gte":0}}}]}}]}}]}},{"bool":{"should":[{"term":{"filters.condition.lower":"certified"}},{"term":{"filters.condition.lower":"pre-owned"}}]}}]}},"query":{"bool":{"should":[{"match_all":{}}]}}}},"aggregations":{"colors":{"terms":{"field":"filters.exteriorColor.lower","size":0,"order":{"_term":"asc"}}},"doors":{"terms":{"field":"filters.doors.lower","size":0,"order":{"_term":"asc"}}},"fuelType":{"terms":{"field":"filters.fuel_type.lower","size":0,"order":{"_term":"asc"}}},"makes":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}},"models":{"terms":{"field":"filters.model.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawModel":{"terms":{"field":"filters.model","size":0,"order":{"_term":"asc"}}},"byTrim":{"terms":{"field":"filters.trim.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"rawTrim":{"terms":{"field":"filters.trim","size":0,"order":{"_term":"asc"}}}}},"byMake":{"terms":{"field":"filters.make.lower","size":0,"order":{"_term":"asc"}}}}},"bodyStyles":{"terms":{"field":"filters.bodyStyle.lower","size":0,"order":{"_term":"asc"}},"aggregations":{"SubbodyStyles":{"terms":{"field":"filters.sub_bodystyle.lower","size":0,"order":{"_term":"asc"}}}}},"minPrice":{"min":{"field":"filters.price.minPrice"}},"maxPrice":{"max":{"field":"filters.price.maxPrice"}},"monthlyMinPrice":{"min":{"field":"filters.price.monthlyMinPrice"}},"monthlyMaxPrice":{"max":{"field":"filters.price.monthlyMaxPrice"}},"priceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.maxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.maxPrice","interval":5000}}}},"monthlyPriceBreakdown":{"filter":{"bool":{"must":[{"not":{"term":{"filters.price.monthlyMaxPrice":0}}}]}},"aggregations":{"breakdown":{"histogram":{"field":"filters.price.monthlyMaxPrice","interval":100}}}},"mileageBreakdown":{"histogram":{"field":"filters.mileage","interval":15000}},"registrationBreakdown":{"date_histogram":{"field":"date.registrationDate","interval":"year","format":"yyyy","offset":"+366d"}},"minYear":{"min":{"field":"filters.year"}},"maxYear":{"max":{"field":"filters.year"}},"years":{"terms":{"field":"filters.year","size":0,"order":{"_term":"desc"}}},"conditions":{"terms":{"field":"filters.condition.lower"}},"maxMileage":{"max":{"field":"filters.mileage"}},"retailers":{"terms":{"field":"filters.dealer_map_key.lower","size":0}},"transmissions":{"terms":{"field":"filters.transmissionType.lower","size":0,"order":{"_term":"asc"}}},"engines":{"terms":{"field":"filters.engine.lower","size":0,"order":{"_term":"asc"}}},"packages":{"terms":{"field":"filters.packages.lower","size":0,"order":{"_term":"asc"}}},"Custom Field 1":{"terms":{"field":"filters.Custom Field 1.lower","size":0}},"Custom Field 2":{"terms":{"field":"filters.Custom Field 2.lower","size":0}},"Custom Field 3":{"terms":{"field":"filters.Custom Field 3.lower","size":0}},"Custom Field 4":{"terms":{"field":"filters.Custom Field 4.lower","size":0}},"Custom Field 5":{"terms":{"field":"filters.Custom Field 5.lower","size":0}},"Custom Field 6":{"terms":{"field":"filters.Custom Field 6.lower","size":0}},"Custom Field 7":{"terms":{"field":"filters.Custom Field 7.lower","size":0}},"Custom Field 8":{"terms":{"field":"filters.Custom Field 8.lower","size":0}},"Custom Field 9":{"terms":{"field":"filters.Custom Field 9.lower","size":0}},"Custom Field 10":{"terms":{"field":"filters.Custom Field 10.lower","size":0}}},"sort":[{"filters.year":{"order":"desc","ignore_unmapped":true}}]}';
//         }
        
//         return $post_data;
//     }

    