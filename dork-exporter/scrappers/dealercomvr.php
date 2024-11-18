<?php

global $site_scrappers;

$site_scrappers['dealercomvr'] = array(
    'use-proxy' => true,
    'details_start_tag' => '<ul id="fullview">',
    'details_end_tag'   => '<div class="paging paging1">',
    'details_spliter'   => '<div class="compare">',
    'data_capture_regx' => array(
        'stock_number'  => '/Stock (?:Number|#):[^>]+>[^>]+>(?<stock_number>[^<]+)/',
        'title'         => '/<h2><a href="(?<url>\/(?:new|used)\/[^"]+)"><span>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'year'          => '/<h2><a href="(?<url>\/(?:new|used)\/[^"]+)"><span>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'make'          => '/<h2><a href="(?<url>\/(?:new|used)\/[^"]+)"><span>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'model'         => '/<h2><a href="(?<url>\/(?:new|used)\/[^"]+)"><span>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
        'price'         => '/<span>Price<\/span>[^>]+>[^>]+>[^>]+>[^>]+>(?<price>.+)/',
        'engine'        => '/Engine:<\/dt>\s*<dd[^>]+>(?<engine>[^<]+)/',
        'exterior_color'=> '/Ext. Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color'=> '/Int. Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
        'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
        'url'           => '/<h2><a href="(?<url>\/(?:new|used)\/[^"]+)"><span>(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
    ),
    'data_capture_regx_full' => array(
        'body_style'    => '/Bodystyle[^>]+>[^>]+><dd><span>(?<body_style>[^<]+)/',
        'transmission'  => '/Transmission[^>]+>[^>]+><dd><span>(?<transmission>[^<]+)/'
    ) ,
    'options_start_tag' => '<div id="features">',        
    'options_end_tag'   => '<div class="disclaimer">',        
    'options_regx'      => '/<dd><span>(?<option>[^<]+)/',        
    'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="nextPage"/',
    'images_regx'       => '/<span>\s*<img src="(?<img_url>http:\/\/pictures.dealer.com\/c\/[^\"]+)"/'
);

function dealercomvr_images_proc($image_url)
{
    return str_replace('thumb_', '', $image_url);
}