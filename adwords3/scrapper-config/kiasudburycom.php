<?php
global $scrapper_configs;
$scrapper_configs["kiasudburycom"] = array( 
	 'entry_points' => array(
            'used'   => 'https://www.kiasudbury.com/en/used-inventory/api/listing?limit=500', 
            'new'    => 'https://www.kiasudbury.com/en/new-catalog',  
            
             
           
        ),
        'vdp_url_regex'     => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
        'used' => array(
                    'use-proxy'         => true,
                   'refine'            => false,
                   'picture_selectors' => ['.ril-inner img'],
                   'picture_nexts'     => ['.next-button'],
                   'picture_prevs'     => ['.prev-button'],
                   'content_type'      => 'application/json',
                   'custom_data_capture'   => function($url, $data){

                   $objects = json_decode($data);


                   if(!$objects) {
                       //slecho($data);
                        return array();
                   }


                   $to_return = array();
                       foreach($objects->vehicles as $obj)
                            {

                       $car_data = array(
                           'stock_number'      => $obj->stockNo?$obj->stockNo:$obj->serialNo,
                           'year'              => $obj->year,
                           'make'              => $obj->make->name,
                           'model'             => $obj->model->name,
                           'trim'              => $obj->trim->name,
                           'price'             => $obj->salePrice,
                           'transmission'      => $obj->transmission,
                           'kilometres'        => $obj->odometer,
                           'vin'               => $obj->serialNo,
                           'drivetrain'        => $obj->driveTrain,
                           'url'               => "https://www.kiasudbury.com/en/used-inventory/" . $obj->make->name . '/' . $obj->model->name . '/' . $obj->year . '/' . $obj->year . '-' . $obj->make->name . '-' . $obj->model->name . '-id' . $obj->vehicleId,
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
            
     'new' => array(
        'vdp_url_regex' => '/\/en\/(?:new|used)-(?:catalog|inventory)\//i',
        'custom_data_capture' => function($url, $resp) {
            global $proxy_list;

            $inventory = kiasudburycom_get_newInventory($url, $resp);

            slecho("Count of vehicles :" . count($inventory));

            $to_return = [];
            foreach ($inventory as $url) {
                slecho("URL = " . $url);
                $car_data = [];
                $car_data['url'] = $url;
                $car_data['stock_number'] = md5($url);
                $temp_data = HttpGet($url, $proxy_list);
                $data_capture_regx_full = array(
                    'make' => '/\&desired_make=(?<make>[^\&]+)/',
                    'model' => '/carId.*desired_model=(?<model>[^\&]+)/',
                    'body_style' => '/<meta property="og:image" content="https:\/\/[^\/]+\/[^\/]+\/newcar(?:\/ca|)\/[0-9]{4}\/[^\/]+\/[^\/]+\/[^\/]+\/(?<body_style>[^\/]+)/',
                    'year' => '/year:\'(?<year>[^\']+)/',
                    'trim' => '/desired_trim=(?<trim>[^"]+)"\s*/',
                    'price' => '/"vehicleCashPurchase_sellingPrice_fontColor">\s*(?<price>\$[0-9,]+)/',
                    'lease' => '/Lease .+Underline">weekly<\/span>\s+from<\/div>\s*[^\n]+\s+.+showroom-financing[^\"]+">[^>]+>(?<lease>\$[0-9,]+)\*<\/span>/',
                    'lease_term' => '/Term for (?<lease_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<lease_rate>[0-9\.\%]+)/',
                    'lease_rate' => '/Term for (?<lease_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<lease_rate>[0-9\.\%]+)/',
                    'finance' => '/Finance weekly from<\/div>\s*[^\n]+\s+.+showroom-financing[^\"]+">[^>]+>(?<finance>\$[0-9,]+)\*<\/span>/',
                    'finance_term' => '/Term for (?<finance_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<finance_rate>[0-9\.\%]+)/',
                    'finance_rate' => '/Term for (?<finance_term>[0-9]+\s*months)<[^\n]+\s*<div[^\n]+>\s*.*>(?<finance_rate>[0-9\.\%]+)/',
                );
                foreach ($data_capture_regx_full as $key => $regx) {
                    if (preg_match($regx, $temp_data, $match)) {
                        if (array_key_exists($key, $match)) {
                            $car_data[$key] = str_replace("\n", '', $match[$key]);
                            if ($key == 'model') {
                                $car_data[$key] = str_replace('+', ' ', $match[$key]);
                            }

                            if ($key == 'trim') {

                                $car_data[$key] = str_replace('+', ' ', $match[$key]);
                                $car_data[$key] = str_replace('_', ' ', $match[$key]);
                            }
                        }
                    } else {
                        //slecho(print_r($match, true));
                        slecho("Error in $key regex");
                    }
                }
                $images_regex = '/class="overlay swiper-slide"  data-overlay>\s*<img\s*src="(?<img_url>[^"]+)/';
                $images_fallback_regex = '/<meta property="og:image" content="(?<img_url>[^"]+)"/';

                $matches = array();

                if (preg_match_all($images_regex, $temp_data, $matches)) {
                    if (count($matches['img_url']) <= 3) {
                        
                    } else {
                        
                        $car_data['images'] = str_replace("w195h145c", 'w600h400c', $matches['img_url']);
                        $car_data['all_images'] = implode('|', $car_data['images']);
                    }
                } elseif (preg_match_all($images_fallback_regex, $temp_data, $matches)) {
                    if (count($matches['img_url']) <= 3) {
                        
                    } else {
                        
                        $car_data['images'] = str_replace("w195h145c", 'w600h400c', $matches['img_url']);
                        $car_data['all_images'] = implode('|', $car_data['images']);
                    }
                }

                $to_return[] = $car_data;
            }
            return $to_return;
        },
    ),       
);


function kiasudburycom_get_newInventory($url, $temp) {
    global $proxy_list;
    $details_start_tag = '<article class="catalog-card-vertical';
    $details_end_tag = '<div class="cell catalog-listing-alpha__disclaimer">';
    $details_spliter = 'More Details</a>';

    if ($details_start_tag) {
        $temp = substr($temp, stripos($temp, $details_start_tag));
    }

    if ($details_end_tag) {
        $temp = substr($temp, 0, stripos($temp, $details_end_tag));
    }

    $spltd = $temp;
    if ($details_spliter) {
        $spltd = explode($details_spliter, $temp);
    }

    $vdp_url = '';
    $car_url = [];
    $ttl_inventory = [];
    foreach ($spltd as $data) {

        $url_regex = '/<a href="(?<url>[^"]+)"\s*title="[0-9]{4}/';
        if (preg_match($url_regex, $data, $matches)) {
            $vdp_url = 'https://www.kiasudbury.com' . $matches['url'];
        }
        $vdp_data = HttpGet($vdp_url, $proxy_list);
        $car_url_regx = '/data-tab-link="(?<car_url>[^"]+)"/';

        if (preg_match_all($car_url_regx, $vdp_data, $matches)) {
            $car_url = $matches['car_url'];
        }
        $ttl_inventory = array_merge($ttl_inventory, $car_url);
    }
    $ttl_inventory = array_map(function($url) {
        return 'https://www.kiasudbury.com/' . $url;
    }
            , $ttl_inventory);
    return $ttl_inventory;
}
