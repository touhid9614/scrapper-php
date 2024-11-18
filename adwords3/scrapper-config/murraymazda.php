<?php

global $scrapper_configs;

$scrapper_configs['murraymazda'] = array(
    'entry_points' => array(
        'new'   => 'http://www.murraymazda.ca/new-mazda-vehicle-sales-chilliwack',
        'used'  => 'http://www.murraymazda.ca/used-vehicle-sales-chilliwack'
    ),
    'use-proxy' => true,
    'details_spliter'   => '<a class="article statevent-click"',
    'data_capture_regx' => array(
        'stock_number'  => '/Stock Number: <span>(?<stock_number>[^<]+)/',
        'url'           => '/<span class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:image\)" href="(?<url>[^"]+)"/',
        'title'         => '/<span class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'year'          => '/<span class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'make'          => '/<span class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
        'model'         => '/<span class="statevent-click" data-stateventcategory="Navigation" data-stateventaction="Move" data-stateventlabel="Products\(element:title\)" href="[^"]+">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]*)/',
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

global $achrysler_current_page;

$achrysler_current_page = array(
    'new'   => 1,
    'used'  => 1
);

add_filter('filter_murraymazda_post_data', 'filter_murraymazda_post_data', 10, 2);
add_filter('filter_murraymazda_data', 'filter_murraymazda_data');

function filter_murraymazda_post_data($post_data, $stock_type)
{
    global $achrysler_current_page;
    
    if($post_data != '')
    {
        $paramval = explode('=', $post_data);
        
        if(count($paramval) == 2)
        {
            if($paramval[1] == '1')
            {
                $achrysler_current_page[$stock_type] = $achrysler_current_page[$stock_type] + 1;
            }
            else
            {
                return false;
            }
        }
    }
    
    $post_data = "widget=inventory2&condition=$stock_type&make=&model=&year=&year2=&price=&mileage=&type=&body=&adv-filter-set=false&certified=false&photos=false&videos=false&turbo=false&fuel=false&warranty=false&finance=false&lease=false&fuel2=&passenger=&sleep=&slideout=&length=&width=&height=&engine=&color=&interior=&transmission=&speed=&door=&drivetrain=&cylinder=&search=&sorttype=year&pagenum=$achrysler_current_page[$stock_type]&sortdir=down&deselect_x=&deselect_y=";
    
    return $post_data;
}

function filter_murraymazda_data($data)
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