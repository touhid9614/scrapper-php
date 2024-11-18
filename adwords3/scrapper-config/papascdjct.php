<?php

global $scrapper_configs;

$scrapper_configs['papascdjct'] = array(
    'entry_points' => array(
        'new' => 'https://www.papascdjct.com/new-inventory/index.htm',
        'used' => 'https://www.papascdjct.com/used-inventory/index.htm'
    ),
    'vdp_url_regex' => '/\/(?:new|used|certified|fleet-used)\/[^\/]+\/[0-9]{4}-/i',
    'ty_url_regex' => '/\/contact-form-confirm.htm/i',
    'use-proxy' => true,
    'picture_selectors' => ['.jcarousel-list-horizontal li'],
    'picture_nexts' => ['.imageScrollNext'],
    'picture_prevs' => ['.imageScrollPrev'],
    
      'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
    
    'data_capture_regx' => array(
        'url' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'title' => '/class="url"\s*href="(?<url>[^"]+)">(?<title>[^<]+)/',
        'year' => '/data-year="(?<year>[^"]+)/',
        'make' => '/data-make="(?<make>[^"]+)/',
        'model' => '/data-model="(?<model>[^"]+)/',
        'trim' => '/data-trim="(?<trim>[^"]+)/',
        'price' => '/"(?:invoicePrice|internetPrice|stackedFinal|final|msrp|salePrice|retailValue|askingPrice|stackedConditionalFinal) final-price"><span[^>]+.*<span class=\'value\'\s*>(?<price>\$[0-9,]+)/',
        'kilometres' => '/Mileage:<\/dt>\s*<dd>(?<kilometres>[^\<]+)/',
        'stock_number' => '/Stock #:<\/dt>\s*<dd>(?<stock_number>[^\<]+)/',
        'engine' => '/Engine:<\/dt>\s*<dd>(?<engine>[^\<]+)/',
        'body_style' => '/data-bodyStyle="(?<body_style>[^"]+)/',
        'transmission' => '/Transmission:<\/dt>\s*<dd>(?<transmission>[^\<]+)/',
        'exterior_color' => '/Exterior Colou?r:<\/dt>\s*<dd>(?<exterior_color>[^\<]+)/',
        'interior_color' => '/Interior Colou?r:<\/dt>\s*<dd>(?<interior_color>[^\<]+)/',
        'certified' => '/<li class="(?<certified>certified)"><div class=\'badge \'\s*>/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/Mileage\n.+\n.+\n<span class="value">\n(?<kilometres>.+)/',
        'price' => '/final-price".*\s*<strong class="h1 price" >(?<price>\$[0-9,]+)<\/strong>\s*<span class="[^"]+" >Your Price Could Be/',
    ),
    'next_page_regx' => '/href="(?<next>[^"]+)"\s*rel="next"/',
    'images_regx' => '/<a href="(?<img_url>[^"]+)"\s*class="js-link">/',
    'images_fallback_regx' => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
);

add_filter("filter_papascdjct_field_images", "filter_papascdjct_field_images");

function filter_papascdjct_field_images($im_urls)
{
    $images=  array_filter($im_urls,function($img_url){
        return !endsWith($img_url,"notfound.jpg");
    }
    );

    if(count($images) < 2) { return array(); }

    return $images;
}
