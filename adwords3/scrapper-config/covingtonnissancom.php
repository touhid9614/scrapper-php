<?php
global $scrapper_configs;
$scrapper_configs["covingtonnissancom"] = array( 
	"entry_points" => array(

	    'new' => 'https://www.covingtonnissan.com/new-nissan-covington-va',
        'used' => 'https://www.covingtonnissan.com/used-cars-covington-va',
    ),
    
    'vdp_url_regex' => '/\/vehicle-details\/(?:new|used)-[0-9]{4}-/i',
    'use-proxy' => true,
    'picture_selectors' => ['.mod-vehicle-gallery .images ul li.active'],
    'picture_nexts' => ['.browse.right'],
    'picture_prevs' => ['.browse.left'],
    'details_start_tag' => '<div class="c-vehicles grid">',
    'details_end_tag' => '<div class="com-inventory-listing-pagination row ie8">',
    'details_spliter' => '<div class="vehicle"',
   

    'data_capture_regx' => array(
        'stock_number' => '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
        'url' => '/<meta itemprop="url" content="(?<url>[^"]+)/',
        'title' => '/<meta itemprop="name" content="(?<title>[^"]+)"\/>\s*<meta/',
        'year' => '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
        'make' => '/<meta itemprop="brand" content="(?<make>[^"]+)/',
        'model' => '/<meta itemprop="model" content="(?<model>[^"]+)/',
        'price' => '/class="price-value text-bold">(?<price>[^<]+)/',
        'exterior_color' => '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
        'engine' => '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
        'transmission' => '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
        'kilometres' => '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
       
    ),

    'data_capture_regx_full' => array(
        
    ),

    'next_page_regx' => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
    'images_regx' => '/<li><img (?:src|data-lazy)="(?<img_url>[^"]+)" alt="[^"]+" class="img-responsive" itemprop="image"/'
);