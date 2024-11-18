<?php
global $scrapper_configs;
$scrapper_configs["whitesfrontiercom"] = array(
     'entry_points'        => array(
        'new' => 'https://www.whitesfrontier.com/VehicleSearchResults?search=new',
    ),
    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy'           => true,

    'picture_selectors'   => ['.scroll-content-item'],
    'picture_nexts'       => ['.bx-next'],
    'picture_prevs'       => ['.bx-prev'],

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.whitesfrontier.com/sitemap.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx          = '/"photoUrl":"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = false;
        $invalid_images       = ['https://media.assets.sincrod.com/websites/5.0-8359/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];
        
        $annoy_func = function ($car) {
        $imgs   = [];
        $images = explode('|', $car['all_images']);

        $retval            = preg_replace('/http(s)?:.*(?=http)/', '', $images, -1);
        $car['all_images'] = implode("|", $retval);

        // $im_urls=array_unique($im_urls);
        // if (count($im_urls) < 2) {
        //     $car_data['all_images'] = implode('|', $im_urls);
        // } else {
        //     $car_data['all_images'] = '';
        //     // slecho ("less than two images");
        // }
        
        return $car;
    };
        
        $data_capture_regx_full = [
          
             'stock_type'     => '/"category":"(?<stock_type>[^"]+)/i',
             'year'           => '/,"year":"(?<year>[^"]+)/i',
             'make'           => '/"category":"[^"]+","make":"(?<make>[^"]+)/i',
             'model'          => '/"category":"[^"]+","make":"[^"]+","model":"(?<model>[^"]+)/i',
             'trim'           => '/"category":"[^"]+","make":"[^"]+","model":"[^"]+","trim":"(?<trim>[^"]+)/i',
             'price'          => '/,"(?:price|msrp)":"(?<price>[^"]+)/i',    
             'engine'         => '/Engine<\/span>\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<engine>[^<]+)/i',
             'transmission'   => '/"transmission":"(?<transmission>[^"]+)/',
             'kilometres'     => '/miles":"(?<kilometres>[^"]+)/i',
             'stock_number'   => '/"stockNumber":"(?<stock_number>[^"]+)/',
             'interior_color' => '/"interior":"(?<interior_color>[^"]+)/',
             'body_style'     => '/"bodyType":"(?<body_style>[^"]+)/',
             'vin'            => '/"vin":"(?<vin>[^"]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        $return_cars = [];
          
        foreach ($cars as $car) {          
            if (strtolower($car['stock_type']) == 'certified') {
                $car['stock_type'] = 'cpo';
            } 
              $return_cars[] = $car;
          }  
          return $return_cars;
      }
);
add_filter('filter_whitesfrontiercom_car_data', 'filter_whitesfrontiercom_car_data');
function filter_whitesfrontiercom_car_data($car_data)
{               
    if(strpos($car_data['all_images'],"3138")){
        $car_data['all_images']="";
    }

    if(strpos($car_data['all_images'],"31240")){
        $car_data['all_images']="";
    }

    if(strpos($car_data['all_images'],"noImage_large")){
        $car_data['all_images']="";
    }

    if(strpos($car_data['all_images'],"3168")){
        $car_data['all_images']="";
    }
    return $car_data;
}
  
add_filter('filter_for_fb_whitesfrontiercom', 'filter_for_fb_whitesfrontiercom', 10, 2);

function filter_for_fb_whitesfrontiercom($car_data, $feed_type)
{
   
    
    $ignore_data=[
                    '2GC4YNE74R1120219',
                    '2GC4YPE71R1118889',
                    '1GTUUEEL5RZ130905',
                    '1GT40FDA5PU101674',
                ];
    
    if (in_array($car_data['vin'], $ignore_data)) {
        
        
        $car_data['all_images'] = "";

        return null;
    }
    return $car_data;
}
