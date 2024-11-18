<?php
global $scrapper_configs;
$scrapper_configs["waltersbroshdcom"] = array( 
	"entry_points" => array(
		
            'used' => 'https://waltersbroshd.com/pre-owned-inventory?page=1',
            'new'  => 'https://waltersbroshd.com/new-inventory?page=1',
            
         ),
        'vdp_url_regex'     => '/\/inventory\/[^\/]+\//i',
        'use-proxy' => true,
        'refine'=>false,
        'picture_selectors' => ['.r58-slider-slide'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        
        'details_start_tag' => '<ul id="inventoryBikesList',
        'details_end_tag'   => '<footer class',
        'details_spliter'   => '<li class="inventoryList-bike',
        'data_capture_regx' => array(
            'url' => '/inventoryList-bike-details-title">\s*<a href="(?<url>[^"]+)">/',
            'year' => '/Year:<\/td><td>(?<year>[^<]+)/',
           // 'make' => '/inventoryList-bike-details-title">\s*<a href=[^>]+>\s*(?<make>[A-Z]+)/',

            'stock_number' => '/Stock number:[^>]+>[^>]+>(?<stock_number>[^\<]+)/',
            'exterior_color' => '/>Color:[^>]+>[^>]+>(?<exterior_color>[^\s*<]+)/',
          
             'price'         => '/class="inventoryList-bike-details-price ">\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:<\/td><td>(?<kilometres>[0-9^<]+)/',
            
    ),
        'data_capture_regx_full' => array(   
             'vin'  => '/VIN number:[^>]+>\s*[^>]+>(?<vin>[^\<]+)/',

              'make' => '/make":"(?<make>[^"]+)/',

              'model' => '/"model":"(?<model>[^"]+)/',

      // 'stock_type' => '/<td>Condition:[^>]+>\s*[^>]+>\s*(?<stock_type>[^\s*]+)/',

     'description' => '/<meta property="og:description" content="(?<description>[^"]+)/',
         
        ) , 
        'next_query_regx'   => '/class="is-active">[^>]+>[^>]+>[^>]+>[^>]+><a href="[^"]+"\s*data-(?<param>page)="(?<value>[0-9]*)">/',
        'images_regx'       => '/data-lightbox-prevent href="(?<img_url>[^"]+)"/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

// add_filter('filter_waltersbroshdcom_car_data', 'filter_waltersbroshdcom_car_data');
// function filter_waltersbroshdcom_car_data($car_data)
//     {
//         $car_data['make'] = strip_tags($car_data['make']);
//         $car_data['model'] = strip_tags($car_data['model']);
//         $car_data['title'] = strip_tags($car_data['title']);
//         $car_data['make'] = preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['make']);
//         $car_data['model'] = preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['model']);
//         $car_data['title'] = preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['title']);

//         return $car_data;
//     }