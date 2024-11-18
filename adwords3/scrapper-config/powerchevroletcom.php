<?php
global $scrapper_configs;
$scrapper_configs["powerchevroletcom"] = array( 
    "entry_points" => array(
	    'new' => 'https://www.powerchevrolet.com/searchnew.aspx?pn=100',
    ),
    'vdp_url_regex'       => '/(?:new|used)-[A-z]+\-[0-9]{4}/i',
    'use-proxy'           => false,
    'refine'              => false,

    "custom_data_capture" => function ($url, $data) {
        $site                 = "https://www.powerchevrolet.com/sitemap.xml";
        $vdp_url_regex        = '/(?:new|used)-[A-z]+\-[0-9]{4}/i';
        $images_regx          = '/hyperlink\'>\s*<img src="(?<img_url>[^"]+)"/i';
        $images_fallback_regx = '/<meta property="og:image" content="(?<img_url>[^"]+)"/i';
        $required_params      = [];
        $use_proxy            = false;

        $data_capture_regx_full = [
            'stock_type'     => '/condition: "(?<stock_type>[^"]+)/',
            'year'           => '/<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)/i',
            'make'           => '/<title>(?<year>[^\s*]+)\s*(?<make>[^\s*]+)/i',
            'model'          => '/vehicleModel=\'(?<model>[^\']+)/i',
            'price'          => '/vehicle_price:\'(?<price>[^\']+)/i',
            'interior_color' => '/<td class="SpecLabelContainer">Interior Color[^>]+>\s*[^>]+>\s*(?<interior_color>[^<]+)/i', 
            'body_style'     => '/Body\s*Style[^>]+>[^"]+"[^"]+"\s*title=[^>]+>(?<body_style>[^<]+)/i',
            'vin'            => '/vin:\'(?<vin>[^\']+)/i',
            'stock_number'   => '/"stockNumber": "(?<stock_number>[^"]+)/i',
            'kilometres'     => '/Mileage[^>]+>[^>]+>(?<kilometres>[0-9,]+)/i',
            'trim'           => '/trimLevel: "(?<trim>[^"]+)/i',
      ];

        $cars = sitemap_crawler($site, $vdp_url_regex, $data_capture_regx_full, $images_regx, $images_fallback_regx, $required_params, $use_proxy, $keymap, $invalid_images, $use_custom_site, $annoy_func);
        return $cars;

    },
     'images_regx'          => '/hyperlink\'>\s*<img src="(?<img_url>[^"]+)"/',
    //'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/',
);
//add_filter('filter_powerchevroletcom_car_data', 'filter_powerchevroletcom_car_data');
//
//function filter_powerchevroletcom_car_data($car_data)
//{               
//            
//            if ($car_data['price']=='') 
//            {
//                $car_data['price'] = $car_data['msrp'];
//
//            }
//    
//    return $car_data;
//}