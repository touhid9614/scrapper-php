<?php

global $scrapper_configs;

$scrapper_configs['regency100mile'] = array(
    'entry_points' 				=> array(
        'new' 					=> 'http://www.regency100mile.ca/new-cars-100-mile-house-bc',
        'used' 					=> 'http://www.regency100mile.ca/used-cars-100-mile-house-bc'
    ),
    'vdp_url_regex' 			=> '/\/vehicle-details\/(?:new|used|certified)-[0-9]{4}-\S+/i',
    'use-proxy' 				=> true,
        'picture_selectors' 	=> ['div.thumb'],
        'picture_nexts'     	=> ['browse right'],
        'picture_prevs'     	=> ['browse left'],
        'details_start_tag' 	=> '<div class="c-vehicles list">',
        'details_end_tag'   	=> '<div class="com-inventory-listing-pagination row',
        'details_spliter'   	=> '<div class="vehicle"',
        'must_contain_regx' 	=> '/<link itemprop="availability" href="http:\/\/schema.org\/InStock"\/>/i',
        
        'data_capture_regx' 	=> array(
            'stock_number'  	=> '/<meta itemprop="sku" content="(?<stock_number>[^"]+)/',
            'url'           	=> '/<meta itemprop="url" content="(?<url>[^"]+)/',
            'title'         	=> '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          	=> '/<meta itemprop="releaseDate" content="(?<year>[^"]+)/',
            'make'          	=> '/<meta itemprop="brand" content="(?<make>[^"]+)/',
            'model'         	=> '/<meta itemprop="model" content="(?<model>[^"]+)/',
            'price'         	=> '/<meta itemprop="price" content="(?<price>[^"]+)/',
            'exterior_color'	=> '/<meta itemprop="color" content="(?<exterior_color>[^"]+)/',
            'engine'        	=> '/<span class="spec-value spec-value-enginedescription">(?<engine>[^<]+)/',
            'transmission'  	=> '/<span class="spec-value spec-value-transmission">(?<transmission>[^<]+)/',
            'kilometres'    	=> '/<span class="spec-value spec-value-miles">(?<kilometres>[^<]+)/',
          //'certified'     	=>'/<img\s*src="[^"]+"\s*alt="Certified"\s*class="[^"]+"\s*title="(?<certified>[^"]+)"/'

        ),
        'data_capture_regx_full'=> array(
            'trim'          	=> '/Trim:<\/strong><\/span>\s*<span[^>]+>(?<trim>[^<]+)/',
            'model'         	=> '/Model:<\/strong><\/span>\s*<span[^>]+>(?<model>[^<]+)/',
            'body_style'    	=> '/Body:<\/strong><\/span>\s*<span[^>]+>(?<body_style>[^<]+)/',
          //'interior_color'	=> '/Interior:<\/strong><\/span>\s*<span[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    	=> '/Mileage:<\/strong><\/span>\s*<span[^>]+>(?<kilometres>[^<]+)/',
        ),
        'next_page_regx'    	=> '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       	=> '/<li><img src="(?<img_url>[^"]+)" alt="[0-9]{4} [^"]+" class="img-responsive" itemprop="image"/'
    );

    add_filter("filter_regency100mile_field_images", "filter_regency100mile_field_images");

    function filter_regency100mile_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url)
        {
            return !endsWith($im_url, 'noimage.jpg');
        });
    }