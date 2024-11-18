<?php

global $site_scrappers;

$site_scrappers['dealeron'] = array(
    'use-proxy' => true,
    'details_start_tag' => '<div id="inventoryBlock">',
    'details_end_tag'   => '<div id="pagingBlockBottom">',
    'details_spliter'   => '<div class="invBlock4">',
    'data_capture_regx' => array(
        'stock_number'  => '/Stock\s*#: <\/strong>\s+(?<stock_number>.+)/',
        'title'         => '/<h1>\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>.+))/',
        'year'          => '/<h1>\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>.+))/',
        'make'          => '/<h1>\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>.+))/',
        'model'         => '/<h1>\s*(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>.+))/',
        'price'         => '/(?:MSRP:|Internet Price:)<\/span> <span >(?<price>[^<]+)/',
        'engine'        => '/Engine: <\/strong>\s+(?<engine>.+)/',
        'transmission'  => '/Transmission: <\/strong>\s+(?<transmission>.+)/',
        'exterior_color'=> '/Ext. Color: <\/strong>\s+(?<exterior_color>.+)/',
        'interior_color'=> '/Int. Color: <\/strong>\s+(?<interior_color>.+)/',
        'kilometres'    => '/Kilometers: <\/strong>\s+(?<kilometres>.+)/',
        'url'           => '/<div class="invBlock1" rel="(?<url>[^"]+)/',
        'body_style'    => '/Body Style: <\/strong>\s+(?<body_style>.+)/'
    ),
    'data_capture_regx_full' => array(
    ) ,
    'next_page_regx'    => '/<div id="Nextbutton" class="btn4">\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '@javascript\:SetGalleryPic\(\'(?<img_url>http://[^\']+.jpg)@',
    'images_fallback_regx' =>  '@id="car_pic" alt="[^"]+" title="[^"]+" src="(?<img_url>http[^"]+.jpg)"@'
);

function dealeron_images_proc($imageurl)
{
    return str_replace(' ', '%20', $imageurl);
}

?>
