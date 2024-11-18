<?php

global $scrapper_configs;
$scrapper_configs["vipowersports"] = array(
        'entry_points' => array(
            'used'   => 'https://www.vipowersports.com/search/inventory/usage/Used/availability/In%20Stock/sort/year-recent/type/Street%20Bikes/type/Cruiser~~V-Twin/type/ATV/type/Dirt%20Bikes/type/Scooters',
            'new'    => 'https://www.vipowersports.com/search/inventory/usage/New/industry/Powersports/type/Street%20Bikes/type/ATV/type/Dirt%20Bikes/type/Side%20x%20Side/type/Scooters/type/Electric%20Dirt%20Bike/type/Cruiser~~V-Twin',
        ),
        'proxy-area'             => 'CA',
        'refine'    => false,

        'vdp_url_regex'           => '/\/inventory\/[0-9]{4}\-/i',
        'srp_page_regex'          => '/search\/inventory\//i',
     
        'details_start_tag' => '<div class="search-results-list">',
        'details_end_tag'   => '<footer class="footer-b',
        'details_spliter'   => '<div class="panel panel-default search-result">',

        'data_capture_regx' => array(
            'stock_number'  => '/Stock #<\/strong>\s*.*\s*<td[^>]+>\s*(?<stock_number>[^<]+)/',
            'year' => '/data-model-year>(?<year>[0-9]{4})/',
            'make' => '/data-model-brand>(?<make>[^<]+)/',
            'model' => '/data-model-name>(?<model>[^<]+)/',
            'price' => '/itemprop="price">\s*(?<price>\$[0-9,]+)/',
            'body_style' => '/Style<\/strong>\s*.*\s*<td[^>]+>\s*(?<body_style>[^<]+)/',
            'exterior_color' => '/Color<\/strong>\s*.*\s*<td[^>]+>\s*(?<exterior_color>[^<]+)/',     
            'url' => '/fa-search-plus">[^>]+>[^>]+>\s*<a\s*href="(?<url>[^"]+)">\s*<picture>\s*<source/'
        ),
        'data_capture_regx_full' => array(
            'vin'           => '/VIN[^\=]*[^\>]*\>(?<vin>[^\<]+)/',
            'fuel_type'     => '/Fuel System[^>]*>[^>]*>(?<fuel_type>[^<]+)/',
            'engine'        => '/Engine Type[^>]*>[^>]*>(?<engine>[^<]+)/',
            'drivetrain'    => '/Engine Type[^>]*>[^>]*>(?<drivetrain>[^<]+)/',
            'description'   => '/name=\"description\"[^"]+\"(?<description>[^\"]+)/',
            'kilometres'    => '/strong\>Usage[^=]*[^>]*\>(?<kilometres>[^\<]+)/',
        ),
    'next_page_regx' => '/<li class="active">\s*<a href="[^"]+">[^\n]+\s*<\/li>\s*<li [^>]+>\s*<a href="(?<next>[^"]+)/',
    'images_regx' => '/<img data-highres="[^\?]+\?img=(?<img_url>[^\&]+)/',
);
 
add_filter("filter_vipowersports_field_images", "filter_vipowersports_field_images");

function filter_vipowersports_field_images($im_urls) {
    $retval = array();
    // slecho(implode('|', $im_urls));
    foreach ($im_urls as $im_url) {
        $retval[] = str_replace(['https://www.vipowersports.com/inventory/','%3a','%2f','+','https://www.vipowersports.com/new-models/'],['',':','/',' ',''],$im_url);
    }
    //   slecho(implode('|', $retval));
    return $retval;
}
add_filter('filter_vipowersports_car_data', 'filter_vipowersports_car_data');

function filter_vipowersports_car_data($car_data) {

    $car_data['engine'] = str_replace('&#176;', '', $car_data['engine']);
    $car_data['engine'] = str_replace('&#174;', '', $car_data['engine']);
    $car_data['engine'] = str_replace('â„¢', '', $car_data['engine']);
    $car_data['engine'] = str_replace('&#39;', '', $car_data['engine']);
    $car_data['engine'] = str_replace('&#160;', '', $car_data['engine']);
    $car_data['engine'] = str_replace('&#173;', '', $car_data['engine']);
    
    $car_data['make'] = str_replace('&#174;', '', $car_data['make']);
    $car_data['model'] = str_replace('â„¢', '', $car_data['model']);
    $car_data['model'] = str_replace('Â', '', $car_data['model']);
    $car_data['model'] = str_replace('©', '', $car_data['model']);
    $car_data['model'] = str_replace('®', '', $car_data['model']);

    $car_data['fuel_type'] = str_replace('&#216;', '', $car_data['fuel_type']);

    $car_data['drivetrain'] = str_replace('&#176;', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('&#174;', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('â„¢', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('&#39;', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('&#160;', '', $car_data['drivetrain']);
    $car_data['drivetrain'] = str_replace('&#173;', '', $car_data['drivetrain']);
   // $car_data['make'] = strtolower($car_data['make']);
   //  $car_data['make'] = strtolower($car_data['make']);
    if(strpos($car_data['make'],"LL BRANDS")){
        return null;
    }
    if(strpos($car_data['body_style'],"Bike") || strpos($car_data['body_style'],"ruiser") || strpos($car_data['body_style'],"cooters") ||  strpos($car_data['body_style'],"Touring") ||  strpos($car_data['body_style'],"tandard"))
    {
        $car_data['body_style']="Bikes";
    }
    else if(strpos($car_data['body_style'],"x Side")){
        $car_data['body_style']="UTV";
    }
    else if($car_data['body_style']=='ATV'){
        $car_data['body_style']="ATV";
    }
    
     if(strlen($car_data['model'])>12){
        $arr_model=explode(" ",$car_data['model']);
        $car_data['model']=$arr_model[0];
    }
    
    if($car_data['make']=='Surron'){
        $car_data['body_style']="Bikes";
    }
    return $car_data;
}

