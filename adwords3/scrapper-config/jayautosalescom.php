<?php
global $scrapper_configs;
$scrapper_configs["jayautosalescom"] = array( 
	 'entry_points' => array(
            'used' => 'https://www.jayautosales.com/inventory/'
        ),
        'vdp_url_regex'     => '/\/inventory\/view\/[^\/]+\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.vehicle_slide.slick-slide.slick-cloned img'],
        'picture_nexts'     => ['.slick-next'],
        'picture_prevs'     => ['.slick-prev'],
        
        'details_start_tag' => '<ul class="list">',
        'details_end_tag'   => '<div class="pagination_wrapper">',
        'details_spliter'   => '<li class="vehicle-item',
        'data_capture_regx' => array(
            'url'           => '/class="title_price">\s*<a href="(?<url>[^"]+)"/',
            'title'         => '/<h4 class="name">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'year'          => '/<h4 class="name">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'make'          => '/<h4 class="name">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'model'         => '/<h4 class="name">\s*(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'price'         => '/class="price_holder  ">\s*[^>]+>(?<price>\$[0-9,]+)/',
            'kilometres'    => '/class="col option col-12 col-md-12 col-lg-9">\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*[^>]+>\s*(?<kilometres>[^\s]+)/',
            'stock_number'  => '/STOCK ID\s*:\s*(?<stock_number>[^<]+)/',
            'engine'        => '/class="svg_icon_engine icon"[^\n]+\n[^\n]+\n[^\n]+\n[^\n]+\n\s*(?<engine>[^<]+)/',
            'transmission'  => '/class="svg_icon_gearshift icon" [^\n]+\n[^\n]+\n[^\n]+\n[^\n]+\n[^\n]+\n[^\n]+\n\s*(?<transmission>[^\s]+)/',
            
        ),
        'data_capture_regx_full' => array(        


        ) ,
        'next_page_regx'    => '/active">[^>]+>[^>]+><\/li><li><a href="(?<next>[^"]+)/',
        'images_regx'       => '/<div class="col col-12 additional_photos_col">\s*.*(?:href|<img src)="(?<img_url>[^"]+)"/',
    );

