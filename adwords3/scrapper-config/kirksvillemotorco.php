<?php

global $scrapper_configs;
$scrapper_configs["kirksvillemotorco"] = array(                  
    'entry_points'        => array(
        'new' => 'https://www.kirksvillemotorco.com/VehicleSearchResults?search=new'
    ),
    'vdp_url_regex'       => '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'srp_page_regex'          => '/VehicleSearchResults\?search\=(?:new|used|certified)/i',
    'use-proxy'           => true,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.kirksvillemotorco.com/sitemap-inventory-sincro.xml";
        $vdp_url_regex        = '/\/VehicleDetails\/(?:new|used|certified)-[0-9]{4}-\S+/i';
        $images_regx          = '/"photoUrl":"(?<img_url>[^"]+)/i';
        $images_fallback_regx = '/<meta name="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = true;
        $invalid_images       = ['https://images.dealer.com/unavailable_stockphoto.png','https://media.assets.sincrod.com/websites/5.0-8416/websitesEar/websitesWebApp/css/common/images/en_US/noImage_large.png'];
        
        $annoy_func = function ($car) {
                        
            $ignore_data=[
                'G2010A',
                'C2851A',
                'B1440',
                
            ];
            if (in_array($car['stock_number'], $ignore_data)) 
            {
                slecho("Excluding car that has  ,{$car['stock_number']}");
                return null;

            }
            if ($car['stock_number']== "null") 
            {
                $car['stock_number']="";

            }

            if (strpos($car['all_images'], "/RTT/") !== false) {
                $car['all_images'] = "in-transit";
            }

            return $car;
        };

        $data_capture_regx_full = [
            //'title'          => '/og:title" content="(?<title>[^"]+)/',
            'stock_type'     => '/VehicleDetails\/(?<stock_type>[^\-]+)/i',
            'stock_number'   => '/stockNumber":(?:"|)(?<stock_number>[^,"]+)/',
            'exterior_color' => '/itemprop="color">(?<exterior_color>[^<]+)<\/span/',
            'engine'         => '/itemprop="vehicleEngine"[^>]+>\s*<[^>]+>\s*<[^>]+>(?<engine>[^<]+)/',
            'vin'           => '/itemprop="vehicleIdentificationNumber">(?<vin>[^<]+)/',
            'year'           => '/year":"(?<year>[^"]+)/',
            'make'           => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'model'          => '/"make":"(?<make>[^"]+)"\,"model":"(?<model>[^"]+)"/',
            'price'          => '/"(?:msrp|price)":"(?<price>[0-9,]+)/',
            'kilometres'        =>'/Miles[^>]+>[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'interior_color' => '/itemprop="vehicleInteriorColor">(?<interior_color>[^<]+)/',
            'transmission'   => '/<span itemprop="vehicleTransmission">(?<transmission>[^<]+)/',
        ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);

        return $cars;
    }
);



//   'all' => 'https://tm.smedia.ca/adwords3/client-data/dealereprocess/KirksvilleMotorCo.csv'
//     ),
//     'use-proxy' => true,
//     'vdp_url_regex' => '/\/VehicleDetails\/(?:new|used|certified)-/i',
//     'picture_selectors' => ['.owl-item'],
//     'picture_nexts' => ['.owl-next'],
//     'picture_prevs' => ['.owl-prev'],
//     'refine' => false,
//     'custom_data_capture' => function($url, $resp) {
//         $vehicles = convert_CSV_to_JSON($resp);

//         $result = [];

//         foreach ($vehicles as $vehicle) {
            
//              if(strpos($vehicle['WebsiteVDPURL'],"www.kirksvillemotorcompany.com")){
//                 continue;
//             }
          
//             $car_data = [
//                     'stock_number'  => $vehicle['Stock'],
//                     'vin'           => $vehicle['VIN'],
//                     'year'          => $vehicle['Year'],
//                     'make'          => $vehicle['Make'],
//                     'model'         => $vehicle['Model'],
//                     'trim'          => $vehicle['Trim'],
//                     'drivetrain'    => $vehicle['Drivetrain'],
//                     'fuel_type'     => $vehicle['Fuel_Type'],
//                     'transmission'  => $vehicle['Transmission_Description'],
//                     'body_style'    => $vehicle['Body'],
//                     'images'        => explode(',', $vehicle['ImageList']),
//                     'all_images'    => implode('|', explode(',', $vehicle['ImageList'])),
//                     'price'         => $vehicle['SellingPrice'],
//                     'url'           => $vehicle['WebsiteVDPURL'],
//                     'stock_type'    => $vehicle['Type'],
//                     'engine'        => $vehicle['EngineDisplacement'],
//                     'msrp'          => $vehicle['MSRP'],
//                     'description'   => $vehicle['Description'],
//                     'kilometres'    => $vehicle['Miles'],
//                     'exterior_color'=> $vehicle['ExteriorColor'],
//                     'interior_color'=> $vehicle['InteriorColor'],
//             ];


     

//                 $result[] = $car_data;
//         }

//         return $result;
//     }
// );