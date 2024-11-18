<?php

global $scrapper_configs;
$scrapper_configs["stephenwadenissancom"] = array(
    
    "entry_points" => array(
         'used' => 'https://www.stephenwadenissan.com/inventory/used',
         'new' => array(
            'https://www.stephenwadenissan.com/inventory/new/nissan/titan?years=2021',
            'https://www.stephenwadenissan.com/inventory/new/nissan/sentra?years=2021',
            'https://www.stephenwadenissan.com/inventory/new/nissan/kicks?years=2021',
            'https://www.stephenwadenissan.com/inventory/new/nissan/altima?years=2021',
            'https://www.stephenwadenissan.com/inventory/new/nissan/armada?years=2021',
            'https://www.stephenwadenissan.com/inventory/new/nissan/frontier?years=2022',
            'https://www.stephenwadenissan.com/inventory/new/nissan/leaf?years=2022',
            'https://www.stephenwadenissan.com/inventory/new/nissan/murano?years=2021',
            'https://www.stephenwadenissan.com/inventory/new/nissan/pathfinder?years=2022',
            'https://www.stephenwadenissan.com/inventory/new/nissan/frontier?years=2021',
           
        ),
        
    ),
    'vdp_url_regex' => '/\/viewdetails\/(?:new|used)\//i',
    'use-proxy' => true,
    'refine'=>false,
    'picture_selectors' => ['.vehicle-img'],
    'picture_nexts' => ['.fa-chevron-right'],
    'picture_prevs' => ['.fa-chevron-left'],
    
    'details_start_tag' => '<div class="row mb-5 mt-2 m-2"',
    'details_end_tag' => '<div class="website-primary-footer w-100">',
    'details_spliter' => '<div class="inventory-car-parent-box-2 vehicledetails-box',
    
    'data_capture_regx' => array(
        'url'   => '/<div class="d-flex">\s*<a href="(?<url>[^"]+)"/',
        'year'  => '/<div class="vehiclebox-title[^>]+>\s*[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make'  => '/<div class="vehiclebox-title[^>]+>\s*[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/<div class="vehiclebox-title[^>]+>\s*[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'price' => '/WAG Price[^>]+>\s*[^>]+>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:\s*(?<kilometres>[0-9,]+)/',
        'vin'   => '/VIN:\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<vin>[^<]+)/',
        'stock_number' => '/Stock: #\s*[^>]+>\s*[^>]+>\s*[^>]+>(?<stock_number>[^<]+)/',
        'engine' => '/Engine Size:\s*(?<engine>[^<]+)/',
        
    ),
    'data_capture_regx_full' => array(
   
        
    ),
    'next_page_regx' => '/<a class="page-link color-primary _text_color theme-text-color"\s*href="(?<next>[^"]+)" rel=""><em class/',
    'images_regx' => '/<a itemprop="url" href="(?<img_url>[^"]+)/',
);

add_filter("filter_stephenwadenissancom_field_images", "filter_stephenwadenissancom_field_images", 10, 2);

function filter_stephenwadenissancom_field_images($im_urls, $car_data)
{
    if (isset($car_data['vin']) && $car_data['vin']) {
        $api_url = "https://www.stephenwadenissan.com/Api/api/Inventory/getVehicleImages/?styleId=0&width=0&height=0&accountID=61727&enableNewImageRules=true&vin={$car_data['vin']}";

               
        slecho("api url:" . $api_url);
        $response_data = HttpGet($api_url, true, true);

        if ($response_data) {
            $obj = json_decode($response_data);
            return $obj->showAllList;
        }
    }
}