<?php
global $scrapper_configs;
$scrapper_configs['unzens']=array(
     'entry_points' => array(
            'new'   => 'http://unzens.com/new-inventory',
            'used'  => 'http://unzens.com/used-inventory'
        ),
        'vdp_url_regex'     => '/\/inventory\/details\/(?:new|used)\//i',
//        'ty_url_regex'      => '/\/eprice-[^\?]+\?.*form-action=success/i',
        'use-proxy' => true,
        'picture_selectors' => ['.fotorama__nav__frame'],
        'picture_nexts'     => ['.fotorama__arr--next'],
        'picture_prevs'     => ['.fotorama__arr--prev'],
        'details_start_tag' => '<div class="block-grid-lg-1 block-grid-md-1 block-grid-sm-2 block-grid-xs-1" id="results-row">',
        'details_end_tag'   => '<div class="cb-footer">',
        'details_spliter'   => '<div class="block-grid-item">',
        
        'data_capture_regx' => array(
            
//            'url'           => '/<a\s*href="[^"]+"><span[^</]+</span>\s*/',
//            'year'          => '/<a\s*href="[^"]+"><span[^</]+</span>\s*<span[^>]+>(?<year>[0-9]{4})</span>\s*<span[^>]+>(?<make>[^<]+)</span>\s*<span[^>]+>(?<model>[^<]+)</span>\s*<span[^>]+>(?<trim>[^<]+)/',
//            'make'          => '/<a\s*href="[^"]+"><span[^</]+</span>\s*<span[^>]+>(?<year>[0-9]{4})</span>\s*<span[^>]+>(?<make>[^<]+)</span>\s*<span[^>]+>(?<model>[^<]+)</span>\s*<span[^>]+>(?<trim>[^<]+)/',
//            'model'         => '/<a\s*href="[^"]+"><span[^</]+</span>\s*<span[^>]+>(?<year>[0-9]{4})</span>\s*<span[^>]+>(?<make>[^<]+)</span>\s*<span[^>]+>(?<model>[^<]+)</span>\s*<span[^>]+>(?<trim>[^<]+)/',
//            
            'url'           => '/class="panel-title">\s*<a\s*href="(?<url>[^"]+)/',
           // 'title'         => '/<meta itemprop="name" content="(?<title>[^"]+)/',
            'year'          => '/class=\'result-year\'>(?<year>[^\<]+)/',
            'make'          => '/class=\'result-make\'>(?<make>[^\<]+)/',
            'model'         => '/class=\'result-model\'>(?<model>[^\<]+)/',
            'price'         => '/class="price[^>]+>Unzen\s*Price:\s\$(?<price>[^<]+)/',
           // 'trim'          => '/<a\s*href="[^"]+"><span[^</]+</span>\s*<span[^>]+>(?<year>[0-9]{4})</span>\s*<span[^>]+>(?<make>[^<]+)</span>\s*<span[^>]+>(?<model>[^<]+)</span>\s*<span[^>]+>(?<trim>[^<]+)/',
            'stock_number'  => '/<strong>Stock#[^>]+>[^\s]+\s*<td>(?<stock_number>[^<]+)/',
            'interior_color'=> '/<strong>Int[^>]+>[^\s]+\s*<td>(?<interior_color>[^<]+)/',
            'exterior_color'=> '/<strong>Color[^>]+>[^\s]+\s*<td>(?<exterior_color>[^<]+)/',
            'engine'        => '/<strong>Eng[^>]+>[^\s]+\s*<td>(?<engine>[^<]+)/',
            'transmission'  => '/<strong>Trans.[^>]+>[^\s]+\s*<td>(?<transmission>[^<]+)/',
            'kilometres'    => '/<strong>Mileage[^>]+>[^\s]+\s*<td>(?<kilometres>[^<]+)/'
            
       
            ),
        'data_capture_regx_full' => array(
            //'title'         => '/<h1\s*class="vdp-title[^>]+>\s*(?<title>[^<]+)/',
            'body_style'    => '/<strong>Body\s*Style[^>]+[^\s]+\s*<td[^>]+>(?<body_style>[^<]+)/',
            
        ),
        'next_page_regx'    => '/<li\s*class="active">\s*<a.*\s*<\/li>\s*<li>\s*<a\s*href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*data-thumb="[^<]/'
);
//add_filter("filter_unzens_field_title", "filter_unzens_field_title");


//function filter_unzens_field_title($title) {
//    return preg_replace('/\s\s+/', ' ', $title);
//}
