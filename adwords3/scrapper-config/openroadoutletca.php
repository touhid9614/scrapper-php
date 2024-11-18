<?php
global $scrapper_configs;
$scrapper_configs["openroadoutletca"] = array(
     'entry_points' => array( 
            'new'  => array(
                'https://www.openroadoutlet.ca/default.asp?condition=new&page=xAllInventory&pg=1&sortby=Price%7Casc&sz=50',
                'https://www.openroadoutlet.ca/default.asp?condition=new&page=xAllInventory&pg=2&sortby=Price%7Casc&sz=50',
                'https://www.openroadoutlet.ca/default.asp?condition=new&page=xAllInventory&pg=3&sortby=Price%7Casc&sz=50',
                'https://www.openroadoutlet.ca/default.asp?condition=new&page=xAllInventory&pg=4&sortby=Price%7Casc&sz=50',
                'https://www.openroadoutlet.ca/default.asp?condition=new&page=xAllInventory&pg=5&sortby=Price%7Casc&sz=50',
                'https://www.openroadoutlet.ca/default.asp?condition=new&page=xAllInventory&pg=6&sortby=Price%7Casc&sz=50',
            ),
            'used' => 'https://www.openroadoutlet.ca/default.asp?condition=pre-owned&page=xAllInventory&pg=1&sortby=Price%7Casc&sz=50'
        ),
        'srp_page_regex'         => '/asp\?condition=(?:new|used)\&page/i',
        'vdp_url_regex'     => '/\/(?:New|Pre-owned)-Inventory-[0-9]{4}.*-[0-9]{7,9}/i',
        'refine'            => false,
        'use-proxy' => true,
        
        'details_start_tag' => '<h2 class="v7list-subheader__heading">',
        'details_end_tag'   => '<div class="v7list-footer">',
        'details_spliter'   => '<li class="v7list-results__item"',
        'data_capture_regx' => array(
            'url'           => '/vehicle-heading__link" href="(?<url>[^"]+)/',
            'year'          => '/<span class="vehicle-heading__year">(?<year>[^<]+)/',
            'make'          => '/vehicle-heading__name">(?<make>[^<]+)/',
            'model'         => '/vehicle-heading__model">(?<model>[^<]+)/',
            'price'         => '/Our Price[^>]+>[^>]+>(?<price>[^<]+)/',
            'stock_number'  => '/Stock Number:\s[^>]+>(?<stock_number>[^<]+)/',
        ),
        'data_capture_regx_full' => array(  
            //custom_2 is for tiktok feeds, filtering them in car_data filter. 
            'custom_2'  => '/"product_category":"(?<custom_2>[^"]+)/',      
            'stock_number' => '/Stock Number<\/label>\s*[^>]+>(?<stock_number>[^\<]+)/',
            'vin' => '/Stock Number<\/label>\s*[^>]+>(?<vin>[^<]+)/',
            'fuel_type' => '/Fuel Type<\/label>\s*[^>]+>(?<fuel_type>[^<]+)/',
            'exterior_color' => '/Color<\/label>\s*[^>]+>(?<exterior_color>[^\<]+)/',
            'description' => '/<meta name="description" content="(?<description>[^"]+)/',
            'engine' => '/Engine<\/label>\s*[^>]+>(?<engine>[^\<]+)/',
            'kilometres' => '/Odometer<\/label>\s*[^>]+>(?<kilometres>[^\s*]+)/',
            'body_style' => '/Body Style<\/label>\s*[^>]+>(?<body_style>[^\<]+)/',
        ) ,
        //'next_page_regx' => '/v7list-pagination__page">Page\s*(?<next>[^\s]+)\sof[^>]+>\s*[^>]+>[^>]+>[^"]+"[^"]+" aria-label="Next Page of Results">/',
        'images_regx'       => '/<div class="lS-image-wrapper">\s*<img src="(?<img_url>[^"]+)/',
        'images_fallback_regx'   => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);
 
   
add_filter("filter_openroadoutletca_field_images", "filter_openroadoutletca_field_images");
function filter_openroadoutletca_field_images($im_urls)
{
    $retval_im = array();

    foreach($im_urls as $url) {
        $url=str_replace('https://www.openroadoutlet.ca/', '', $url);
        $retval_im[] = str_replace('&#x2F;', '/', $url);
    }
    
    return $retval_im;

}
    
add_filter("filter_openroadoutletca_next_page", "filter_openroadoutletca_next_page", 10, 2);
function filter_openroadoutletca_next_page($next, $current_page) {

    slecho($current_page);
    $next = explode('/', $next);
    $index = count($next) - 1;
    $next = ($next[$index]);
    $next++;
    $peg = "pg=" . $next;
    $prev = "pg=" . ($next - 1);
    $url = str_replace($prev, $peg, $current_page);

    return $url;
}

add_filter('filter_openroadoutletca_car_data', 'filter_openroadoutletca_car_data');

function filter_openroadoutletca_car_data($car_data)
{               
            
    $autos = [
        'Dodge',
        'Ford',
        'GMC',
        'Jeep',
        'Nissan',
        'Chevrolet',
    ];
    if (in_array($car_data['make'], $autos)) 
    {   
        $car_data['body_style'] = "autos";
    }

    $powersports = [
        'Apollo',
        'Argo',
        'Beta',
        'Can-Am',
        'CFMoto',
        'GoTrax',
        'Indian Motorcycle',
        'Harley Davidson',
        'SURRON',
        'Tao Motor',
        'Thumpstar',
        'YCF',
    ];
    if (in_array($car_data['make'], $powersports)) 
    {   
        $car_data['body_style'] = "powersports";
    }

    $marine = [
        'Angler Qwest',
        'Marlon',
        'Polar Kraft',
    ];
    if (in_array($car_data['make'], $marine)) 
    {   
        $car_data['body_style'] = "boat";
    }

    $rvs = [
        'Forest River Shasta',
        'Prime Time Avenger',
        'Coachmen Viking',
        'Gulf Stream Amerilite',
        'Sunset Park RV',
        'Sunset Park RV Sun Lite',
        'Sunset Park RV Sunray',
    ];
    if (in_array($car_data['make'], $rvs)) 
    {   
        $car_data['body_style'] = "rvs";
    }

    //for Tiktok Feeds
    if($car_data['custom_2'] == "Motorcycle / Scooter" || $car_data['custom_2'] == "ATV"){
        if($car_data['body_style'] != "powersports"){
            $car_data['body_style'] = "other";
        }
    }
    
    return $car_data;
}

    
