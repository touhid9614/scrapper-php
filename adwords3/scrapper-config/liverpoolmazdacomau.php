<?php
global $scrapper_configs;
$scrapper_configs["liverpoolmazdacomau"] = array( 
	"entry_points" => array(
            'all'  => 'https://www.liverpoolmazda.com.au/all-stock/list/?q=perpage%3A30',
            //  'new'  => [
            //     'https://www.liverpoolmazda.com.au/demo-mazda-liverpool/?q=perpage%3A30',
            //     'https://www.liverpoolmazda.com.au/new-mazda-for-sale-liverpool/?q=perpage%3A30',
            // ],
            'demo'  => 'https://www.liverpoolmazda.com.au/demo-mazda-liverpool/?q=perpage%3A30',
            'new'  => 'https://www.liverpoolmazda.com.au/new-mazda-for-sale-liverpool/?q=perpage%3A30',
            'used'  => 'https://www.liverpoolmazda.com.au/used-mazda-liverpool/?q=perpage%3A30',
        
    ),
    'use-proxy' => true,
    "refine"=> false,
    'proxy-area'   => 'CA',
     'vdp_url_regex'          => '/\/(?:new|used|certified-used|demo|all-stock|[A-z]+).*\/view\/[0-9]{4}-/i',

    'details_start_tag' => '<div id="stockListCanvas"',
    'details_end_tag'        => '<footer class="footer default">',
    'details_spliter' => '<div class="col-sm-6 col-md-4 stock-item-col hidden-xs">',

    'data_capture_regx' => array(
        'title' => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'url' => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'year' => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'make' => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'model' => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)[^<]+)/',
        'trim'  => '/<a href="(?<url>[^"]+)"\s*title="[^>]+><h3[^>]+>(?<title>.*?(?<year>[0-9]{4}) (?<make>[^\s]+) (?<model>[^\s]+)(?<trim>[^<]+))/',
        'price' => '/<h2 class="price_stocklist stocklist-price ">\s*(?<price>\$[0-9,]+)/',
        'transmission' => '/Transmission<\/td>\s*<td>\s*(?<transmission>[^\n<]+)/',
        'kilometres' => '/Odometer<\/td>\s*<td>\s*(?<kilometres>[^\s*]+)/',
    ),
    'data_capture_regx_full' => array(
        'stock_type'     => '/"Condition":"(?<stock_type>[^"]+)/',
    	'engine' => '/"vehicleEngine":"(?<engine>[^"]+)/',
        // 'stock_type'     => '/,"itemCondition":"(?<stock_type>[^"]+)","/',
        'exterior_color' => '/"color":"(?<exterior_color>[^"]+)/',
        'fuel_type'     =>  '/fuelType":\s*"(?<fuel_type>[^"]+)/',
    	'stock_number' => '/"sku":"(?<stock_number>[^"]+)/',
    	'vin' => '/"vehicleIdentificationNumber":"(?<vin>[^"]+)/',
        'body_style' => '/"bodyType":"(?<body_style>[^"]+)/',
        'drivetrain'    => '/driveWheelConfiguration":"(?<drivetrain>[^"]+)/',
        'description'   => '/<meta name="description" content="(?<description>[^"]+)"><meta/',
    ),
    'next_page_regx' => '/rel="next"\s*(?:data-href|href)="(?<next>[^"]+)"/',
    'images_regx' => '/<a class="enlarge-image" href="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);


add_filter('filter_liverpoolmazdacomau_car_data', 'filter_liverpoolmazdacomau_car_data');

function filter_liverpoolmazdacomau_car_data($car_data) {
    //https://app.asana.com/0/1145853562025778/1200772161046646/f
    //sold car remove
    if ($car_data['stock_number'] == 'Z43723'|$car_data['stock_number'] == 'MHM17389') {
		return null;
	}
    
     
    if($car_data['stock_type']=='demo'){
        $car_data['custom_1']="demo";
        $car_data['custom']="demo";
        $car_data['stock_type']="new";
    }
    else{
        $car_data['custom_1']=$car_data['stock_type'];
        $car_data['custom']=$car_data['stock_type'];
    }

    // //so many stock type is found with garbage text so I have written the condition to filter out the proper one.
    // if(strtolower(str_contains($car_data['stock_type'], "used"))){
    //     $car_data['stock_type'] = "used";
    // }
    // else if(strtolower(str_contains($car_data['stock_type'], "demo"))){
    //     $car_data['stock_type'] = "new";
    // }
    // else if(strtolower(str_contains($car_data['stock_type'], "new"))){
    //     $car_data['stock_type'] = "new";
    // }
    
    $car_data['description'] = strip_tags(preg_replace("/[^a-zA-Z0-9`_.,;@#%~'\"\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:\-\s\\\\]+/", "", $car_data['description']));
    $car_data['description'] =str_replace("<","",$car_data['description']);
    
    return $car_data;
}
    
