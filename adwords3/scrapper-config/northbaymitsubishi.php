<?php
global $scrapper_configs;
$scrapper_configs["northbaymitsubishi"] = array(
        'entry_points'      => array(
            'new'  => 'https://service.vehicles.sm360.ca/inventory/vehicles-new?includeMetadata=true&location=ON&organizationId=344&organizationUnitId=927',
            'used' => 'https://www.northbaymitsubishi.ca/en/used-inventory/api/listing?limit=500',
        ),
    
        "refine"                 => false,
        'srp_page_regex'        => '/\/en\/(?:new|used)-(?:catalog|inventory)/i',
        'vdp_url_regex'         => '/\/en\/(?:new|used)-(?:catalog|inventory)\/.*\/[0-9]{4}-/i',
        'new'  => array(
            'content_type' => 'application/json;charset=UTF-8',
            'init_method' => 'POST',
            'next_method' => 'POST',
            'additional_headers' => array(
              //  "Content-Length" => "94449", 
            ),
        
               'custom_data_capture' => function($url, $data) {
                $objects = json_decode($data);
        
                if (!$objects) {
                    slecho($data);
                    return array();
                }
        
                $to_return = array();
                
                foreach ($objects->inventoryVehicles as $obj) {
                    
                    $car_data = array(
                        'stock_number' => $obj->stockNo?$obj->stockNo:$obj->vin,
        
                        'year' => $obj->year,
        
                        'make' => $obj->make->name,
        
                        'model' => $obj->model->name,
        
                        'price' => $obj->paymentOptions->cashPurchase->sellingPrice,
        
                        'kilometres' => $obj->odometer, 
        
                        'vin'               => $obj->serialNo,
        
                        'body_style' => $obj->bodyStyle->slug,
                        'fuel_type'         => $obj->fuel->name,
                        'exterior_color' => $obj->exteriorColor->colorDescription,
        
                        'interior_color' => $obj->interiorColor->colorDescription,
        
                        'all_images'   => "https://img.sm360.ca/ir/w360h197c/images/newcar/" . $obj->multimedia->exterior->front,
                     );
                    
                     if($obj->vehicleStatus == "SOLD"){
                        $car_data = [];
                     }

                    $car_data['url']=strtolower("https://www.northbaymitsubishi.ca/en/new-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId);
             
                    $to_return[] = $car_data;
                }
                return $to_return;
            },
        ),
        'used'            => array(
           'vdp_url_regex'         => '/\/en\/(?:used-inventory|used-catalog)\//i',
           'custom_data_capture'   => function($url, $data){
    
                       $objects = json_decode($data);
    
                       if(!$objects) {
                            return array();
                       }
    
                        $to_return = array();
                        foreach($objects->vehicles as $obj)
                        {
                            $stock_type = $obj->newVehicle?"new":"used";
                            $car_data = array(
                                'stock_number'      => $obj->stockNo?$obj->stockNo:$obj->serialNo,
                                'year'              => $obj->year,
                                'make'              => ucwords(strtolower($obj->make->name)),
                                'model'             => ucwords(strtolower($obj->model->name)),
                                //'trim'              => $obj->trim->name,
                                'price'             => $obj->salePrice,
                                'msrp'             => $obj->listPrice,
                                'transmission'      => $obj->transmission,
                                'kilometres'        => $obj->odometer,
                                'vin'               => $obj->serialNo,
                                'fuel_type'         => $obj->fuel->name,
                                'drivetrain'        => $obj->driveTrain,
                                'url'               => "https://www.northbaymitsubishi.ca/en/" . $stock_type . "-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId,
                                'all_images'         => $obj->multimedia->mainPicture?"https://img.sm360.ca/images/inventory" . $obj->multimedia->mainPicture:'',
                           );
                           
                            $images = [];
                            foreach ($obj->multimedia->pictures as $picture) {
                                $images[] = 'https://img.sm360.ca/images/inventory' . $picture;
                            }
                             
                            $car_data['all_images'] = implode("|", $images);
    
                            $to_return[] = $car_data;
                        }
                              
                       return $to_return;
                   },
        ),
    
    );
    
    add_filter("filter_northbaymitsubishi_field_images", "filter_northbaymitsubishi_field_images");
    function filter_northbaymitsubishi_field_images($im_urls)
    {
        for ($i = 0; $i < count($im_urls); $i++) {
            $im_urls[$i] = str_replace(['w100h75', 'w195h145c'], 'w600h400', $im_urls[$i]);
        }
    
        return $im_urls;
    }
    
    add_filter("filter_northbaymitsubishi_field_model", "filter_northbaymitsubishi_field_model");
    function filter_northbaymitsubishi_field_model($model)
    {
        return str_replace('+', ' ', $model);
    }
    
    add_filter('filter_northbaymitsubishi_post_data', 'filter_northbaymitsubishi_post_data', 10, 2);
    
    function filter_northbaymitsubishi_post_data($post_data, $stock_type) {
        if ($stock_type == 'new') {
            $post_data = '{"pagination":{"pageNumber":1,"pageSize":1000},"paymentOptionRequest":{"cashDown":0,"financePlan":null,"kmPerYearPlan":null,"lien":0,"paymentFrequency":52,"purchaseMethod":"cash","saleType":"retail","taxPlan":"standard","term":96,"tradeIn":0,"priceIncreaseRollCount":0},"makePriority":[3],"sortList":[{"direction":"ASC","vehicleSortParameter":"SALE_PRICE"}],"vehicle":{"colanderSlug":"new","soldDaysShown":0,"vehicleInventoryStatuses":["FOR_SALE","SOLD","VIRTUAL","ON_HOLD"]}}';
        }
        return $post_data;
    }

//     'entry_points'  => array(
//         'new'  => 'https://www.northbaymitsubishi.ca/en/new-catalog',
//         'used' => 'https://www.northbaymitsubishi.ca/en/used-inventory',
//     ),
     
//     'vdp_url_regex' => '/\/en\/(?:new|used)-(?:catalog|inventory)\/.*\/[0-9]{4}-/i',
//     // 'srp_page_regex'      => '/\/en\/(?:new|used)-(?:catalog|inventory)/i',
//     'used'          => array(
//         'details_start_tag'      => '<section class="inventory-listing__content',
//         'details_end_tag'        => '<section class="inventory-listing__form"',
//         'details_spliter'        => '<article class="inventory-list-layout-wrapper',
//         'use-proxy'              => true,
//         'refine'                 => false,
//         'picture_selectors'      => ['.slide a img'],
//         'picture_nexts'          => ['div a.next'],
//         'picture_prevs'          => ['div a.previous'],
//         'data_capture_regx'      => array(
//             'url'        => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
//             'title'      => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
//             'year'       => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
//             'make'       => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
//             'model'      => '/<a class="inventory-list-layout__preview-name" href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
//             'price'      => '/<div class="inventory-list-layout__preview-price-current vehicle__rebate"\s*[^>]+>\s*(?<price>[^<]+)/',
//             'kilometres' => '/class="inventory-list-layout__preview-km">\s*<[^>]+><\/span>\s*<[^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
//         ),
//         'data_capture_regx_full' => array(
//             'stock_number'   => '/Inventory\s*#:<\/div>\s*<[^>]+>(?<stock_number>[^<]+)/',
//             'kilometres'     => '/Mileage:<\/div>\s*<[^>]+>(?<kilometres>[^<]+)/',
//             'transmission'   => '/Transmission:<\/div>\s*<[^>]+>(?<transmission>[^<]+)/',
//             //  'engine'         => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
//             'exterior_color' => '/Ext. Color:<\/div>\s*[^>]+>(?<exterior_color>[^<]+)/',
//             'interior_color' => '/Int. color:<\/div>\s*[^>]+>(?<interior_color>[^<]+)/',
//             'body_style'     => '/Bodystyle:<\/div>\s*<[^>]+>(?<body_style>[^<]+)/',
//             'vin'            => '/Inventory\s*#:<\/div>\s*<[^>]+>(?<vin>[^<]+)/',
//             'description'    => '/<meta name="description" content="(?<description>[^"]+)/',
//             'drivetrain'     => '/Drivetrain:<\/div>\s*[^>]+>(?<drivetrain>[^<]+)/',
//             'fuel_type'      => '/Fuel:<\/div>\s*[^>]+>(?<fuel_type>[^<]+)/',
//         ),
//         'next_page_regx'         => '/class="pagination__page-arrows-text\s*"\s*href="(?<next>[^"]+)/',
//         'images_regx'            => '/<div class="gallery-delta__main-picture"[^>]+>\s*[^>]+>\s*[^>]+>\s*<img src="(?<img_url>[^"]+)"/',
//     ),

//     'new'           => array(
//         'vdp_url_regex'       => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
//         'custom_data_capture' => function ($url, $resp) {
//             global $proxy_list;

//             $inventory = northbaymitsubishi_get_new_inventory($url, $resp);

//             slecho("Count of vehicles :" . count($inventory));

//             $to_return = [];

//             foreach ($inventory as $url) {
//                 $car_data                 = [];
//                 $car_data['url']          = $url;
//                 $car_data['stock_number'] = md5($url);
//                 $temp_data                = HttpGet($url, true, true);
//                $data_capture_regx_full   = array(
//                      'make' => '/\&desired_make=(?<make>[^\&]+)/',
//                     'model' => '/carId.*desired_model=(?<model>[^\&]+)/',
//                     'body_style' => '/<meta property="og:image" content="https:\/\/[^\/]+\/[^\/]+\/newcar(?:\/ca|)\/[0-9]{4}\/[^\/]+\/[^\/]+\/[^\/]+\/(?<body_style>[^\/]+)/',
//                     'year' => '/year:\'(?<year>[^\']+)/',
//                //     'trim' => '/desired_trim=(?<trim>[^"]+)"\s*title="Book/',
//                     'price' => '/showroom-price__price-amount">\s*(?<price>\$[0-9,]+)/',
//                //       'trim'         => '/desired_trim=(?<trim>[^"]+)"\s*title="Book/',             
//                 //    'lease'        => '/Lease .+Underline">weekly<\/span>\s+from<\/div>\s*[^\n]+\s+.+showroom-financing[^\"]+">[^>]+>(?<lease>\$[0-9,]+)\*<\/span>/',
//                 //    'lease_term'   => '/Term for (?<lease_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<lease_rate>[0-9\.\%]+)/',
//                 //    'lease_rate'   => '/Term for (?<lease_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<lease_rate>[0-9\.\%]+)/',
//                 //    'finance'      => '/Finance weekly from<\/div>\s*[^\n]+\s+.+showroom-financing[^\"]+">[^>]+>(?<finance>\$[0-9,]+)\*<\/span>/',
//                 //    'finance_term' => '/Term for (?<finance_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<finance_rate>[0-9\.\%]+)/',
//                 //    'finance_rate' => '/Term for (?<finance_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<finance_rate>[0-9\.\%]+)/',
//                 );
//                 foreach ($data_capture_regx_full as $key => $regx) {
//                     if (preg_match($regx, $temp_data, $match)) {
//                         if (array_key_exists($key, $match)) {
//                             $car_data[$key] = str_replace("\n", '', $match[$key]);
                            
//                             if ($key == 'make') {
//                                 $car_data[$key] = str_replace('+', ' ', $match[$key]);
//                                 $car_data[$key] = ucwords($car_data[$key]);
//                             }
//                             if ($key == 'model') {
//                                 $car_data[$key] = str_replace('+', ' ', $match[$key]);
//                                 $car_data[$key] = ucwords($car_data[$key]);
//                             }

//                             if ($key == 'trim') {
//                                 $car_data[$key] = str_replace('+', ' ', $match[$key]);
//                                 $car_data[$key] = ucwords($car_data[$key]);
//                             }
//                         }
//                     } else {
//                         slecho("Error in $key regex");
//                     }
//                 }
//                 $images_regex          = '/class="catalog-details__content-images__slider-item[^>]+>\s*<img src="(?<img_url>[^"]+)"\s*alt/';
//                 $images_fallback_regex = '/<meta property="og:image" content="(?<img_url>[^"]+)"/';

//                 $matches = [];

//                 if (preg_match_all($images_regex, $temp_data, $matches)) {
//                     if (count($matches['img_url']) > 2) {
//                         $car_data['images']     = str_replace("w195h145c", 'w600h400c', $matches['img_url']);
//                         $car_data['all_images'] = implode('|', $car_data['images']);
//                     }
//                 } elseif (preg_match_all($images_fallback_regex, $temp_data, $matches)) {
//                     if (count($matches['img_url']) > 2) { 
//                         $car_data['images']     = str_replace("w195h145c", 'w600h400c', $matches['img_url']);
//                         $car_data['all_images'] = implode('|', $car_data['images']);
//                     }
//                 }

//                 $to_return[] = $car_data;
//             }
//             return $to_return;
//         },
//     ),
// );

// add_filter("filter_northbaymitsubishi_field_price", "filter_northbaymitsubishi_field_price", 10, 3);

// function filter_northbaymitsubishi_field_price($price, $car_data, $spltd_data)
// {
//     $prices = [];

//     if ($price && numarifyPrice($price) > 0) {
//         $prices[] = numarifyPrice($price);
//     }

//     $onsale_regex = '/on sale for\s*[^>]+>(?<price>[^<]+)/';

//     $matches = [];

//     if (preg_match($onsale_regex, $spltd_data, $matches) && numarifyPrice($matches['price']) > 0) {
//         $prices[] = numarifyPrice($matches['price']);
//     }

//     if (count($prices) > 0) {
//         $price = butifyPrice(min($prices));
//     }

//     return $price;
// }

// add_filter("filter_northbaymitsubishi_field_images", "filter_northbaymitsubishi_field_images", 10, 2);

// function filter_northbaymitsubishi_field_images($im_urls, $car_data)
// {
//     if (isset($car_data['url']) && $car_data['url']) {
//         $id            = explode("id", $car_data['url']);
//         $api_url       = "https://www.northbaymitsubishi.ca/en/inventory/" . $car_data['stock_type'] . "/fragments/vehiclesByIds?view=ninjabox-gallery&vehicleId={$id[1]}";
//         $response_data = HttpGet($api_url);
//         $regex         = '/<img src="(?<img_url>[^"]+)" alt=/';
//         $matches       = [];
//         if (preg_match_all($regex, $response_data, $matches)) {
//             foreach ($matches['img_url'] as $key => $value) {
//                 $im_urls[] = $value;
//             }
//         }
//     }
//     return array_filter($im_urls, function ($im_url) {
//         return !endsWith($im_url, 'no-photo1594838900745.jpg');
//     });
//     return $im_urls;
// }

// function northbaymitsubishi_get_new_inventory($url, $temp)
// {
//     $details_start_tag = '<div id="catalog-listing-alpha__mitsubishi"';
//     $details_end_tag   = '<p class="catalog-listing-alpha__disclaimer smallprint';
//     $details_spliter   = 'More Details</a>';

//     if ($details_start_tag) {
//         $temp = substr($temp, stripos($temp, $details_start_tag));
//     }

//     if ($details_end_tag) {
//         $temp = substr($temp, 0, stripos($temp, $details_end_tag));
//     }

//     $spltd = $temp;

//     if ($details_spliter) {
//         $spltd = explode($details_spliter, $temp);
//     }

//     $vdp_url       = '';
//     $car_url       = [];
//     $ttl_inventory = [];

//     foreach ($spltd as $data) {
//         $url_regex = '/<a href="(?<url>[^"]+)"\s*title="[0-9]{4}/';

//         if (preg_match($url_regex, $data, $matches)) {
//             $vdp_url = 'https://www.northbaymitsubishi.ca' . $matches['url'];
//             $ttl_inventory[] = $vdp_url;
//         }

//         /*$vdp_data     = HttpGet($vdp_url, true, true);
//         $car_url_regx = '/<a href="(?<car_url>[^"]+)"\s*title="[^"]+"\s*class="tabs-title/';

//         if (preg_match_all($car_url_regx, $vdp_data, $matches)) {
//             $car_url = $matches['car_url'];
//         }

//         $ttl_inventory = array_merge($ttl_inventory, $car_url);*/
//     }

//     /*$ttl_inventory = array_map(function ($url) {
//         return 'https://www.northbaymitsubishi.ca/' . $url;
//     } , $ttl_inventory);*/

//     return $ttl_inventory;
// }
