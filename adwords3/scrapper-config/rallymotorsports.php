<?php

global $scrapper_configs;

$scrapper_configs['rallymotorsports'] = array(
    'entry_points' => array(
        'used'  => 'http://www.rallymotorsports.ca/imglib/Inventory/cache/335/UVehInv.js?v=2142545',
        'new'   => array(
            'http://www.rallymotorsports.ca/inventory/v1/Current',
            'http://www.rallymotorsports.ca/inventory/v1/2015/',
            'http://www.rallymotorsports.ca/inventory/v1/2014/',
            'http://www.rallymotorsports.ca/inventory/v1/2013/'
        )
    ),
    'use-proxy' => true,
    'refine'    => false,
    'new'   => array(
        'details_start_tag' => '<ul class="makes">',
        'details_end_tag'   => '<div id="footerWrapper">',
        'details_spliter'   => '</li>',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>.+(?!---)--(?<stock_number>[^"]+))">\s*<img class="make-image"/',
            'stock_number'  => '/<a href="(?<url>.+(?!---)--(?<stock_number>[^"]+))">\s*<img class="make-image"/'
        ),
        'data_capture_regx_full' => array(
            'year'          => '/"year":(?<year>[0-9]{4})/',
            'make'          => '/"make":"(?<make>[^"]+)/',
            'model'         => '/"model":"(?<model>[^"]+)/',
            'trim'          => '/"trim":"(?<trim>[^"]+)/',
            'description'   => '/"description":"(?<description>.+)"};/',
            'price'         => '/"price":"(?<price>[^"]+)/'
        ),
        'images_regx'       => '/<li><a href="#"><img src="(?<img_url>\/\/cdn.dealerspike.com\/imglib\/v1\/120x90\/imglib\/[^"]+)/'
    ),
    'used'   => array(
        'details_spliter'   => '},{',
        'data_capture_regx' => array(
            'stock_number'  => '/"id":"(?<stock_number>[^"]+)/',
            'url'           => '/"id":"(?<url>[^"]+)/',
            'year'          => '/"bike_year":"(?<year>[^"]+)/',
            'make'          => '/"manuf":"(?<make>[^"]+)/',
            'model'         => '/"model":"(?<model>[^"]+)/',
            'price'         => '/"price":"(?<price>[^"]+)/',
            'engine'        => '/"engine":"(?<engine>[^"]+)/',
            'kilometres'    => '/"miles":"(?<kilometres>[^"]+)/',
            'exterior_color'=> '/"color":"(?<exterior_color>[^"]+)/',
            'body_style'    => '/"vehtypename":"(?<body_style>[^"]+)/'
        ),
        'images_regx'       => '/<li class="photo image_[0-9]+"[^<]+<a[^<]+<img src="[^"]+" data-src="(?<images_regx>[^"]+)"/'
    )
);

add_filter('filter_rallymotorsports_field_url', 'rallymotorsports_field_url');
add_filter('filter_rallymotorsports_field_make', 'unicodify');
add_filter('filter_rallymotorsports_field_model', 'unicodify');
add_filter('filter_rallymotorsports_entry_points', 'rallymotorsports_entry_points');

function rallymotorsports_field_url($id)
{
    if(is_numeric($id))
    {
        return "http://www.rallymotorsports.ca/default.asp?page=xPreOwnedInventoryDetail&id=$id&s=Year&d=D&t=preowned&fr=xPreOwnedInventory";
    }
    else
    {
        return $id;
    }
}

function rallymotorsports_images_proc($image_url)
{
    $tmp = str_replace('120x90', '800x600', $image_url);
    return str_replace('_th.jpg', '.jpg', $tmp);
}

function unicodify($txt)
{
    $temp = str_replace('\u00ae', '®', $txt);
    $temp2 = str_replace('\u2122', '™', $temp);
    $temp3 = str_replace('\u00AE', '®', $temp2);
    return $temp3;
}

function rallymotorsports_entry_points($entry_points)
{
    $ep = $entry_points['new'];
    
    $new_ep = array();
    
    foreach($ep as $entry_point)
    {
        $urls = rallymotorsports_get_list_page($entry_point);
        $new_ep = array_merge($new_ep, $urls);
    }
    
    $entry_points['new'] = $new_ep;
    
    return $entry_points;
}

function rallymotorsports_get_list_page($url)
{
    $grand_parents = array();
    $parents = array();
    $current = array($url);
    
    while(count($current) > 0)
    {
        $new_current = array();
        
        foreach($current as $u)
        {
            $uls = rallymotorsports_get_page_links($u);
            
            foreach($uls as $ul)
            {
                $new_current[] = urlCombine($u, $ul);
            }
        }
        
        $grand_parents = $parents;
        $parents = $current;
        $current = $new_current;
    }
    
    return $grand_parents;
}

function rallymotorsports_get_page_links($url)
{
    $urls = array();
    
    $regex = '/<a href="(?<url>[^"]+)">\s*<img class="make-image"/';
    
    $data = HttpGet($url);
    
    $matchs = array();
    
    if($data && preg_match_all($regex, $data, $matchs))
    {
        $urls = $matchs['url'];
    }
    
    return $urls;
}