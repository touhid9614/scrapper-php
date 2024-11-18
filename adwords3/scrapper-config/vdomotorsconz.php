<?php
global $scrapper_configs;
$scrapper_configs["vdomotorsconz"] = array( 
	"entry_points" => array(
     
      'used' => 'https://www.vdomotors.co.nz/vehicles',
        
    ),
    'vdp_url_regex' => '/\/vehicle\/[0-9]{4}/i',
    'use-proxy' => true,
    'refine'=>false,
   'picture_selectors' => ['.slick-lightbox-slick-img'],
    'picture_nexts' => ['.slick-next'],
    'picture_prevs' => ['.slick-prev'],
     'details_start_tag' => '<div class="row vehicle-results gallery">',
    'details_end_tag' => '<footer>',
    'details_spliter' => '<li class="vehicle',
    'data_capture_regx' => array(
        'url' => '/<div class="small-10 columns">\s*<a href="(?<url>[^"]+)">/',
        'year' => '/<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
        'make' => '/<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
        'model' => '/<h6[^>]+>\s*(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s*]+)/',
        'price' => '/<span class="price">[^>]+>[^>]+>(?<price>\$[0-9,]+)/',
       
    ),
    'data_capture_regx_full' => array(
         'transmission'      => '/Transmission<\/div>\s*[^>]+>\s*(?<transmission>[^\s*]+)/',
         'kilometres'        => '/Odometer<\/div>\s*<[^>]+>\s*(?<kilometres>[^(\s|k)]+)/',
         'body_style'        => '/Body<\/div>\s*[^>]+>(?<body_style>[^<]+)/',
        'engine'            => '/Engine<\/div>\s*[^>]+>(?<engine>[^<]+)/',   
        'exterior_color' => '/Ext Colour<\/div>\s*[^>]+>\s*(?<exterior_color>[^<]+)/',
        'stock_number' => '/Stock#\s*(?<stock_number>[^\s*]+)/',
       // 'interior_color' => '/Int Colour<\/div>\s*<div [^>]+>\s*(?<interior_color>[^\n]+)/',
    ),
    'next_page_regx' => '/<span class="btn-current">[^>]+><a class="btn-numerics" href="(?<next>[^"]+)">/',
    'images_regx' => '/onclick="openPSGallery[^>]+>\s*<img src="(?<img_url>[^"]+)"/'
);

add_filter("filter_vdomotorsconz_field_images", "filter_vdomotorsconz_field_images");
function filter_vdomotorsconz_field_images($im_urls)
{
    $new_im_urls = [];
    $url_base = "https://www.vdomotors.co.nz";
     foreach ($im_urls as $im_url)
    {
        $new_im_url = preg_replace("/https:\/\/www.vdomotors.co.nz\/vehicle\/[^\/]+/", $url_base, $im_url);
        array_push($new_im_urls, $new_im_url);
    }
    return $new_im_urls;
}