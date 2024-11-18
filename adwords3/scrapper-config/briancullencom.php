<?php
global $scrapper_configs;
$scrapper_configs["briancullencom"] = array( 
	"entry_points" => array(
	    'new' => 'https://www.briancullen.com/en/new-inventory',
        'used' => 'https://www.briancullen.com/en/used-inventory',
    ),
    'vdp_url_regex' => '/\/en\/(?:new|used|certified)-inventory\//i',
    'use-proxy' => true,
    'picture_selectors' => ['.gallery-delta__thumbnails-item span.overlay img'],
    'picture_nexts' => ['div.gallery-delta-slider__controls a:nth-of-type(2)'],
    'picture_prevs' => ['div.gallery-delta-slider__controls a:nth-of-type(1)'],
    
    'details_start_tag' => '<div class="inventory-listing-charlie__vehicles">',
    'details_end_tag' => '<ul class="pagination">',
    'details_spliter' => '<article class="inventory-preview-bravo"',
    'data_capture_regx' => array(
        'url' => '/class="inventory-preview-bravo-section-title"\s*[^>]+>\s*<a href="(?<url>[^"]+)"/',
        'title' => '/class="inventory-preview-bravo-section-title__vehicle-name"\s*itemprop="name"[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'stock_number' => '/#\s*stock(?<stock_number>[^<]+)/',
        
        'year' => '/class="inventory-preview-bravo-section-title__vehicle-name"\s*itemprop="name"[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'make' => '/class="inventory-preview-bravo-section-title__vehicle-name"\s*itemprop="name"[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'model' => '/class="inventory-preview-bravo-section-title__vehicle-name"\s*itemprop="name"[^>]+>(?<title>(?<year>[^ ]+) *(?<make>[^ <]+) *(?<model>[^ <]+)?[^<]*)/',
        'price' => '/Available at<\/p>\s*<[^>]+>\s*(?<price>\$[0-9,]+)/',
    ),
    'data_capture_regx_full' => array(
        'kilometres' => '/Mileage:<\/div>\s*[^>]+>(?<kilometres>[^<]+)/',
        'body_style' => '/Bodystyle[^>]+>\s*[^>]+>(?<body_style>[^<]+)<\/div>/',
        'transmission' => '/Transmission:<\/div>[^>]+\s*inventory-details__content-value">(?<transmission>[^<]+)/',
        'exterior_color' => '/Ext. Color:[^>]+>\s*[^>]+>(?<exterior_color>[^<]+)/',
        'interior_color' => '/Int. color:[^>]+>\s*[^>]+>(?<interior_color>[^<]+)/',

    ),
    'next_page_regx' => '/<a class="pagination__page-arrows-text\s"\shref="(?<next>[^"]+)"[^>]+>[^>]+>Next/',
    'images_regx' => '/<div class="gallery-delta-slider__slide">\s*<img src="(?<img_url>[^"]+)"/',
    'images_fallback_regx' => '/class="inventory-vehicle-photo-gallery--single-picture">\s*<img src="(?<img_url>[^"]+)"/'
);
   add_filter("filter_briancullencom_field_images", "filter_briancullencom_field_images");
  function filter_briancullencom_field_images($im_urls)
    {  
      
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'AIM_default_image_28361_5f063e0cdbc03.jpg');
        });
    }