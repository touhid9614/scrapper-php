<?php

global $scrapper_configs;

$scrapper_configs['murraychillhon'] = array(
    'entry_points' => array(
        'new'   => 'http://www.murrayhonda.ca/new-honda-vehicle-sales-chilliwack',
        'used'  => 'http://www.murrayhonda.ca/used-vehicle-sales-chilliwack'
    ),
    'use-proxy' => true,
    
    'details_spliter'   => '<div class="article"',
    'data_capture_regx' => array(
        'stock_number'  => '/id=\'vid-(?<stock_number>[^\']+)/',
        'url'           => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:image\)" href="(?<url>[^"]+)/',
        'title'         => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'year'          => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'make'          => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'model'         => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'price'         => '/<li class="new-price">(?<price>[^<]+)/',
        'engine'        => '/<i class="fd-icon fd-icon-cog pull-left"><\/i><div class="text-inner">(?<engine>[^<]+)/',
        'transmission'  => '/<i class="fd-icon fd-icon-cog pull-left"><\/i><div class="text-inner">[^<]+<br \/><span class="inner-span">(?<transmission>[^<]+)/',
        'kilometres'    => '/<span class="odometer" data-mileage="(?<kilometres>[^<"]+)/',
        'exterior_color'=> '/<div class="ext-color truncate">(?<exterior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'options_start_tag' => '<h3>Features</h3>',        
    'options_end_tag'   => '<script>',        
    'options_regx'      => '/<li>(?<option>[^<]+)/',        
    'next_query_regx'   => '/{"(?<param>[^"]+)":(?<value>[^,]+)/',
    'next_method'       => 'POST',
    'images_regx'       => '/<img src=\'(?<img_url>http:\/\/media.flexdealer.com\/[^-]+-large.jpg)\' data-index=\'[0-9]*\' \/>/'
);

// global $mcfaddenhonda_current_page;

// $mcfaddenhonda_current_page = array(
//     'new'   => 1,
//     'used'  => 1
// );

// add_filter('filter_mcfaddenhonda_post_data', 'filter_mcfaddenhonda_post_data', 10, 2);
// add_filter('filter_mcfaddenhonda_data', 'filter_mcfaddenhonda_data');

// function filter_mcfaddenhonda_post_data($post_data, $stock_type)
// {
//     global $mcfaddenhonda_current_page;
    
//     if($post_data != '')
//     {
//         $paramval = explode('=', $post_data);
        
//         if(count($paramval) == 2)
//         {
//             if($paramval[1] == '1')
//             {
//                 $mcfaddenhonda_current_page[$stock_type] = $mcfaddenhonda_current_page[$stock_type] + 1;
//             }
//             else
//             {
//                 return false;
//             }
//         }
//     }
    
//     $post_data = "widget=inventory2&condition=$stock_type&make=Honda&model=&year=&year2=&price=&mileage=&type=&body=&adv-filter-set=false&certified=false&photos=false&videos=false&turbo=false&fuel=false&warranty=false&finance=false&lease=false&fuel2=&passenger=&sleep=&slideout=&length=&width=&height=&engine=&color=&interior=&transmission=&speed=&door=&drivetrain=&cylinder=&search=&sorttype=year&pagenum=$mcfaddenhonda_current_page[$stock_type]&sortdir=down&deselect_x=&deselect_y=";
    
//     return $post_data;
// }

// function filter_mcfaddenhonda_data($data)
// {
//     if($data)
//     {
//         $obj = json_decode($data);
        
//         if($obj->hasHtml == 1)
//         {
//             $data = $obj->html;
//         }
//         else
//         {
//             $data = $obj->message;
//         }
//     }
    
//     return $data;
// }

?>