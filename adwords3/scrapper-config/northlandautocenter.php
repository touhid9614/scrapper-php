<?php
global $scrapper_configs;
$scrapper_configs['northlandautocenter']=array(
     'entry_points' => array(
           'used'  => 'http://www.northlandautocenter.com/used-inventory'
        ),
        'vdp_url_regex'     => '/\/inventory\/details\/(?:new|used)\//i',

        //'use-proxy' => true,
        'proxy-area'        => 'FL',
        'picture_selectors' => ['.fotorama__nav__frame'],
        'picture_nexts'     => ['.fotorama__arr--next'],
        'picture_prevs'     => ['.fotorama__arr--prev'],
        'details_start_tag' => '<div class="block-grid-lg-1 block-grid-md-1 block-grid-sm-2 block-grid-xs-1" id="results-row">',
        'details_end_tag'   => '<div class="cb-footer">',
        'details_spliter'   => '<div class="block-grid-item">',
        
        'data_capture_regx' => array(
          
            'url'           => '/class="panel-title">\s*<a\s*href="(?<url>[^"]+)/',
            'year'          => '/class="result-year">(?<year>[^\<]+)/',
            'make'          => '/class="result-make">(?<make>[^\<]+)/',
            'model'         => '/class="result-model">(?<model>[^\<]+)/',
            'price'         => '/class=\'price[^>]+>Our\s*Price\s\$(?<price>[0-9,]+)/',
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
            'make'          => '/<strong>Make[^>]+[^\s]+\s*<td[^>]+>(?<make>[^<]+)/',
            'model'          => '/<strong>Model[^>]+[^\s]+\s*<td[^>]+>(?<model>[^<]+)/',
            
        ),
        'next_page_regx'    => '/<li\s*class="active">\s*<a.*\s*<\/li>\s*<li>\s*<a\s*href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*data-thumb="[^<]/',
        'images_fallback_regx' => '/<meta property="og:image" content="(?<img_url>[^"]+)/'
);

    add_filter("filter_northlandautocenter_field_image", "filter_northlandautocenter_field_image");
    
    function filter_northlandautocenter_field_image($im_urls)
    {   
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'nophoto_Large.jpg');
        });
        
        
    }

