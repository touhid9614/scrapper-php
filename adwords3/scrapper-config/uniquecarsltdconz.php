<?php
global $scrapper_configs;
$scrapper_configs["uniquecarsltdconz"] = array( 
	 'entry_points' => array(
        'used' => 'https://www.uniquecarsltd.co.nz/vehicles',
        
    ),
    'vdp_url_regex' => '/\/vehicle\/[0-9]{4}/i',
    'use-proxy' => true,
    'refine'=>false,
   'picture_selectors' => ['.gallery-thumb-wrapper .gallery-thumbs .thumb-item'],
    'picture_nexts' => ['.gallery-counter .icon-arrow-right'],
    'picture_prevs' => ['.gallery-counter .icon-arrow-left'],
     'details_start_tag' => '<div class="row vehicle-results gallery">',
    'details_end_tag' => '<footer>',
    'details_spliter' => '<li class="vehicle">',
    'data_capture_regx' => array(
        'url' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
        'year' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
        'make' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
        'model' => '/href="(?<url>[^"]+)">\s*<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
        'price' => '/<span class="amount">(?<price>\$[0-9,]+)/',
       'stock_number' => '/class="small-10 columns">\s*<a href="\/[^\/]+\/[^\/]+\/(?<stock_number>[^\?]+)/',
    ),
    'data_capture_regx_full' => array(
         'transmission'      => '/Transmission<\/div>\s*[^>]+>\s*(?<transmission>[^\s*]+)/',
         'kilometres'        => '/Odometer<\/div>\s*<[^>]+>\s*(?<kilometres>[^(\s|k)]+)/',
         'body_style'        => '/Body<\/div>\s*[^>]+>(?<body_style>[^<]+)/',
         'engine'            => '/Engine<\/div>\s*[^>]+>(?<engine>[^<]+)/',   
        'exterior_color' => '/Ext Colour<\/div>\s*[^>]+>\s*(?<exterior_color>[^<]+)/',
        'interior_color' => '/Interior<\/div>\s*<div [^>]+>\s*(?<interior_color>[^\n]+)/',
    ),
    'next_page_regx' => '/<a class="btn-next" href="(?<next>[^"]+)">><\/a>/',
    'images_regx' => '/<a style="" onclick[^<]+<img src="..\/..\/(?<img_url>[^"]+)/'
);

add_filter("filter_uniquecarsltdconz_field_images", "filter_uniquecarsltdconz_field_images");
function filter_uniquecarsltdconz_field_images($im_urls)
{
    $new_im_urls = [];
    $url_base = "https://www.uniquecarsltd.co.nz";
     foreach ($im_urls as $im_url)
    {
        $new_im_url = preg_replace("/https:\/\/www.uniquecarsltd.co.nz\/vehicle\/[^\/]+/", $url_base, $im_url);
        array_push($new_im_urls, $new_im_url);
    }
    return $new_im_urls;
}