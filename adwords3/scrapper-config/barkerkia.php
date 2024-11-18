<?php

global $scrapper_configs;
$scrapper_configs["barkerkia"] = array(
    'entry_points' => array(
        'new' => 'https://www.barkerkia.com/new-kia-houma-la',
        'used' => 'https://www.barkerkia.com/used-cars-houma-la',
    ),
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used|certified)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.thumb'],
    'picture_nexts' => ['.right'],
    'picture_prevs' => ['.left'],
    'details_start_tag' => '<div class="c-vehicles list">',
    'details_end_tag' => '<div class="com-inventory-listing-pagination row',
    'details_spliter' => '<div class="vehicle"',
    'data_capture_regx' => array(
        'stock_number' => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
        'url' => '/<meta itemprop="url" content="(?<url>[^"]+)/',
        'title' => '/<meta itemprop="name" content="(?<title>[^"]+)/',
        'year' => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
        'make' => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
        'model' => '/<meta itemprop="model" content="(?<model>[^"]+)/',
        'price' => '/(?:Final Price:|Our Price:)\s*<[^>]+>\s*<[^>]+>\s*<[^>]+>\s*.*(?<price>\$[0-9,]+)/',
        'exterior_color' => '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
        'transmission' => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
        'kilometres' => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
    ),
    'data_capture_regx_full' => array(
        'interior_color' => '/Interior:<\/strong><\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',
    ),
    'next_page_regx' => '/<li id="il-pagination-element-[^"]+" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/<li><img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/'
);

add_filter("filter_barkerkia_field_images", "filter_barkerkia_field_images");

function filter_barkerkia_field_images($im_urls)
    {    
        $retval = [];
         $count =0;
         if(count($im_urls) > 14) { 
             
             foreach($im_urls as $img)
            {   
                $count++;
                $retval[] = $img;
                if($count>14){
                    break;
                }
            }
             return $retval; 
         }
         else{
             return $im_urls;
         }
         
    }
   