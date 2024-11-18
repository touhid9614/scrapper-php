<?php

global $scrapper_configs;
$scrapper_configs["sherwoodhonda"] = array(
    "entry_points" => array(
	  // 'new' => 'https://www.sherwoodhonda.ca/new/inventory/search.html?filterid=q0-500',
        'used' => 'https://www.sherwoodhonda.ca/used/search.html?filterid=q0-500',
    ),     
    'vdp_url_regex' => '/\/(?:new|used|demos)\/.*[0-9]{4}-/i',
    'refine'=>false,
    // 'use-proxy' => false,
    // 'proxy-area' => 'CA',
        'details_start_tag' => 'id="tradeInBar"',
        'details_end_tag' => '</footer>',
        'details_spliter' => 'class="carBoxWrapper"',
        'data_capture_regx' => array(
            'url' => '/<div class="carBasics flex-between">\s*<a\s*[^"]+"(?<url>[^"]+)/',
            // 'vin' => '/data-vin="[^>]+>\s*<a href="(?<vin>[^"]+)"\s*title="/',
            //'title' => '/<div class="divSpan divSpan12 carBasics">\s*<a href="(?<url>[^"]+)" title="(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+))/',
            'year' => '/class=\'divModelYear[^>]+>(?<year>[^\s*]+)\s*(?<model>[^<]+)/',
            'make' => '/class=\'divMake[^>]+>(?<make>[^<]+)/',
            'model' => '/class=\'divModelYear[^>]+>(?<year>[^\s*]+)\s*(?<model>[^<]+)/',
            'kilometres' => '/class=\'divSpan divSpan12 carDescription elIsLoadable\'><span [^>]+><span [^>]+>(?<kilometres>[0-9 ,]+)\s*KM/',
            'price' => '/carPrice elIsLoadable[^>]+>[^>]+>(?<price>[^<]+)/',
        ),
        'data_capture_regx_full' => array(
            'stock_type' => '/specsNoStock[^\:]*\:\s*[A-Za-z0-9]+-(?<stock_type>new)/',
        	'price' => '/Your price:[^>]+>\s*[^>]+>(?<price>[^<]+)/',
            'stock_number' => '/specsNoStock\'>Stock #:\s(?<stock_number>[^<]+)/',
            //'vin' => '/specsNoStock\'>Stock #:\s(?<vin>[^<]+)/',
            'kilometres' => '/specsKM\'>Kilometers:\s(?<kilometres>[0-9 ,]+)/',
            'engine' => '/specsEngine\'>Engine:\s(?<engine>[^<]+)/',
            'transmission' => '/specsTransmission\'>Transmission:\s(?<transmission>[^<]+)/',
            'exterior_color' => '/specsTransmission\'>Transmission:\s(?<exterior_color>[^<]+)/',
            'body_style' => '/specsBodyType\'>Category:\s(?<body_style>[^<]+)/',
            'vin'           => '/VIN:(?<vin>[^<][A-z0-9]+)/',
            'fuel_type' => '/specsFuel\'>Fuel:\s(?<fuel_type>[^<]+)/'
        ),
         
    'images_regx' => '/<a rel="slider-lightbox[^"]+"\shref="(?<img_url>[^"]+)/',
    'images_fallback_regx' => '/<meta  property="og:image" content="(?<img_url>[^"]+)/'
);
add_filter("filter_sherwoodhonda_field_images", "filter_sherwoodhonda_field_images");
    
function filter_sherwoodhonda_field_images($im_urls)
{
    if(count($im_urls)<2)
    {
        return [];
    }
    
    return $im_urls;
}

add_filter('filter_sherwoodhonda_car_data', 'filter_sherwoodhonda_car_data');

function filter_sherwoodhonda_car_data($car_data)
{       
    if($car_data['body_style'] == "Cars" || $car_data['body_style'] == "Car"){
        $car_data['body_style'] = "Sedan";
    }      
    // //https://app.guidecx.com/app/projects/a026ab5f-6fcc-4109-93a3-75da4d45a6db/notes
    // //removing first images for used. As used car contains first images banners.   
    // $all_images = explode('|', $car_data['all_images']);

    // if($car_data['stock_type'] == "used"){
    //     unset($all_images[0]);
    // }

    // $car_data['all_images'] = implode(',', $all_images);
    
    return $car_data;
}