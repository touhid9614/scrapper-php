<?php

global $site_scrappers;

$site_scrappers['flexdealer'] = array(
    'use-proxy' => true,
    'details_spliter'   => '<div class="article statevent-click"',
    'data_capture_regx' => array(
        'stock_number'  => '/Stock Number: <span>(?<stock_number>[^<]+)/',
        'url'           => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:image\)" href="(?<url>[^"]+)/',
        'title'         => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'year'          => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'make'          => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'model'         => '/<a class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'price'         => '/<div class="price actual">PRICE <span>(?<price>[^<]+)/',
        'engine'        => '/<i class="fd-icon fd-icon-cog pull-left"><\/i><div class="text-inner">(?<engine>[^<]+)/',
        'transmission'  => '/<i class="fd-icon fd-icon-cog pull-left"><\/i><div class="text-inner">[^<]+<br \/><span class="inner-span">(?<transmission>[^<]+)/',
        'kilometres'    => '/data-mileage="(?<kilometres>[^"]+)/',
        'exterior_color'=> '/<div class="ext-color truncate">(?<exterior_color>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
    ),
    'options_start_tag' => '<h6>All Features</h6>',
    'options_end_tag'   => '<div class="expand-button"></div>',
    'options_regx'      => '/<li>(?<option>[^<]+)/',
    'next_query_regx'   => '/{"(?<param>[^"]+)":(?<value>[^,]+)/',
    'next_method'       => 'POST',
    'images_regx'       => '/<img src=\'(?<img_url>http:\/\/media.flexdealer.com\/[^-]+-large.jpg)\' data-index=\'[0-9]*\' \/>/'
);

global $flexdealer_current_page;

$flexdealer_current_page = array();

add_filter('filter_flexdealer_post_data', 'filter_flexdealer_post_data', 10, 3);
add_filter('filter_flexdealer_data', 'filter_flexdealer_data');

function filter_flexdealer_post_data($post_data, $stock_type, $host)
{
    global $flexdealer_current_page;
    
    if(!isset($flexdealer_current_page[$host]))
    {
        $flexdealer_current_page[$host] = array(
            'new'   => 1,
            'used'  => 1
        );
    }
    
    if($post_data != '')
    {
        $paramval = explode('=', $post_data);
        
        if(count($paramval) == 2)
        {
            if($paramval[1] == '1')
            {
                $flexdealer_current_page[$host][$stock_type] = $flexdealer_current_page[$host][$stock_type] + 1;
            }
            else
            {
                return false;
            }
        }
    }
    
    $post_data = "widget=inventory2&condition=$stock_type&make=&model=&year=&year2=&price=&mileage=&type=&body=&adv-filter-set=false&certified=false&photos=false&videos=false&turbo=false&fuel=false&warranty=false&finance=false&lease=false&fuel2=&passenger=&sleep=&slideout=&length=&width=&height=&engine=&color=&interior=&transmission=&speed=&door=&drivetrain=&cylinder=&search=&sorttype=year&pagenum=$flexdealer_current_page[$host][$stock_type]&sortdir=down&deselect_x=&deselect_y=";
    
    return $post_data;
}

function filter_flexdealer_data($data)
{
    if($data)
    {
        $obj = json_decode($data);
        
        if($obj->hasHtml == 1)
        {
            $data = $obj->html;
        }
        else
        {
            $data = $obj->message;
        }
    }
    
    return $data;
}
?>
