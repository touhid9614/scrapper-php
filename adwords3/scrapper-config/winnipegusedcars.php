<?php

global $scrapper_configs;

$scrapper_configs['winnipegusedcars'] = array(
    'entry_points' => array(
        'used' => 'https://www.nott.ca/used-vehicle-inventory/'
    ),

    'vdp_url_regex' => '/\/listings\//i',
    'ajax_url_match' => 'wp-admin/admin-ajax.php',
    'ajax_resp_match' => 'Sent Successfully',
    'use-proxy' => true,
    'refine' => false,
    'picture_selectors' => ['.fancybox_listing_link'],
    'picture_nexts' => ['.fancybox-next'],
    'picture_prevs' => ['.fancybox-prev'],
    'details_start_tag' => '<div class="sidebar">',
    'details_end_tag' => '<div class="inventory-sidebar',
    'details_spliter' => '<div class="tax">Plus Sales Tax',
    'must_contain_regx' => '/^((?!<span>SOLD<\/span>)[\s\S])*$/',

    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)">\s*<div\s*[^>]+>(?<year>[^\s]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
        'title' => '/href="(?<url>[^"]+)">\s*<div\s*[^>]+>(?<year>[^\s]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
        'year' => '/href="(?<url>[^"]+)">\s*<div\s*[^>]+>(?<year>[^\s]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
        'make' => '/href="(?<url>[^"]+)">\s*<div\s*[^>]+>(?<year>[^\s]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
        'model' => '/href="(?<url>[^"]+)">\s*<div\s*[^>]+>(?<year>[^\s]+)\s*(?<make>[^\s*]+)\s*(?<model>[^<]+)/',
        'price' => '/class="figure">\s*(?<price>[^<]+)/',
        'body_style' => '/Body Style: <\/td>\s*<td class=\'[^>]+>(?<body_style>[^<]+)/',
        //'kilometres' => '/Mileage: <\/td>\s*<td class=\'spec\'>(?<kilometres>[^<]+)/',
        'exterior_color' => '/Exterior Color: <\/td>\s*<td class=\'spec\'>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior Color: <\/td>\s*<td class=\'spec\'>(?<interior_color>[^<]+)/',
        'stock_number' => '/Stock Number: <\/td>\s*<td class=\'spec\'>(?<stock_number>[^<]+)/',
        'engine' => '/Engine: <\/td>\s*<td class=\'spec\'>(?<engine>[^<]+)/',
        'transmission' => '/Transmission: <\/td>\s*<td class=\'spec\'>(?<transmission>[^<]+)/',
    ),

    'data_capture_regx_full' => array(
        'make' => '/Make: <\/td><td>(?<make>[^<]+)/',
        'model' => '/Model: <\/td><td>(?<model>[^<]+)/',
        'price' => '/Price: <\/td><td>(?<price>[^<]+)/',
        'vin'  => '/VIN Number: <\/td><td>(?<vin>[^<]+)/',
        'description'  => '/<div class="tab-pane fade" id="comments">(?<description>[^=]+)/',
        'drivetrain' => '/Drivetrain: <\/td><td>(?<drivetrain>[^<]+)/'
    ),

    'next_query_regx' => '/<li data-page=\'[0-9]*\' class=\'disabled number\'><a href=\'#\'>[0-9]*<\/a><\/li>\s*<li data-(?<param>[^=]+)=\'(?<value>[0-9]*)\'/',
    'images_regx' => '/<li data-thumb="[^"]+"> <img src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter('filter_winnipegusedcars_post_data', 'filter_winnipegusedcars_post_data');
add_filter('filter_winnipegusedcars_car_data', 'filter_winnipegusedcars_car_data');


function filter_winnipegusedcars_post_data($post_data) 
{
    return str_replace('page=', 'paged=', $post_data);
}

add_filter("filter_winnipegusedcars_field_images", "filter_winnipegusedcars_field_images",10,2);

function filter_winnipegusedcars_field_images($im_urls,$car_data) 
{
    if (isset($car_data['stock_number']) && $car_data['stock_number'])
    {   
        $api_url="https://api.spincar.com/spin/nottautocorp/{$car_data['stock_number']}";
        
        $response_data = HttpGet($api_url);
              
        if ($response_data) 
        {
            $obj = json_decode($response_data);
            slecho("api url:" . $obj->info->options->numImgCloseup);  

            for ($i=0;$i<$obj->info->options->numImgCloseup;$i++)
            {  
                $img="{$obj->cdn_image_prefix}closeups/cu-{$i}.jpg";
                $im_urls[]=str_replace('//', 'https://', $img);
            }
            
        }
    }

    return  $im_urls;
}

add_filter('filter_winnipegusedcars_description', 'filter_winnipegusedcars_description', 10, 3);

function filter_winnipegusedcars_description($descs, $car, $campaign) 
{
    if (/* $campaign == 'search' && */$car['stock_type'] == 'used' && intval($car['year'] >= 2012)) 
    {
        for ($i = 0; $i < count($descs); $i++) {
            $descs[$i]['desc2'] .= " $0 down & no payments for 90 days.";
        }
    }

    return $descs;
}

function filter_winnipegusedcars_car_data($car_data)
{
    
    if (isset($car_data['stock_number']))
    {
        if (startsWith($car_data['stock_number'], 'C') || endsWith($car_data['stock_number'], 'C') || $car_data['stock_number']=='6263' || $car_data['stock_number']=='6354' )
        {
            slecho("this stock number contains charcter c");
            return null;
        }
    }
    slecho("this stock number does not contains charcter c");
    return $car_data;
}

add_filter("filter_winnipegusedcars_field_description", "filter_winnipegusedcars_field_description");
    
function filter_winnipegusedcars_field_description($description)
{
   return strip_tags($description);
}