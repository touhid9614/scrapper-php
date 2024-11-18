<?php

    global $scrapper_configs;

    $scrapper_configs['riversideauto'] = array(
        'entry_points' => array(
           'used'   => 'https://www.riversideauto.com/inventory?PageNumber=1&BodyStyle=&Make=&MaxPrice=&Condition=&SoldStatus=AllVehicles&Mileage=&Sort=MakeAsc&StockNumber=&PageSize=100',
        ),
        'use-proxy' => true,
        'proxy-area'        => 'FL',
        'vdp_url_regex'     => '/\/details\//i',
        'picture_selectors' => ['.vehicle-img .item'],
        'picture_nexts'     => ['.glyphicon.glyphicon-chevron-right'],
        'picture_prevs'     => ['.glyphicon.glyphicon-chevron-left'],
        
        'details_start_tag' => '<ul class="list-unstyled list-inline vehicle-section">',
        'details_end_tag'   => '<ul class="list-inline pagination-cfs">',
        'details_spliter'   => '<li class="vehicle-snapshot vehicle-list',
        'must_not_contain_regex' => '/vehicle-price[^\n]+\s*Sold\s*<\/h3>/',
        'data_capture_regx' => array(
            'title'         => '/<a href="(?<url>[^"]+)">\s*<h3 class="[^"]+">(?<title>[^<]+)/',
            'year'          => '/vehicleModelDate":\s*(?<year>[^\,]+)/',
            'make'          => '/manufacturer":\s*"(?<make>[^"]+)/',
            'model'         => '/model":\s*"(?<model>[^"]+)/',
            'transmission'  => '/Trans:\s+<\/div><div\s+class[^>]+>(?<transmission>[^<]+)/',
            'engine'        => '/Engine:\s+<\/div><div\s+class[^>]+>(?<engine>[^<]+)/',
            'price'         => '/vehicle-price[^\n]+\s*<a[^\n]+\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:\s+<\/div><div\s+class[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/<a href="(?<url>[^"]+)">\s*<h3 class="[^"]+">/'
        ),
        'data_capture_regx_full' => array(
            'exterior_color'=> '/Exterior Color:\s+<\/div><div\s+class[^>]+>(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:\s+<\/div><div\s+class[^>]+>(?<interior_color>[^<]+)/',
            'stock_number'  => '/Stock:\s+<\/div><div\s+class[^>]+>(?<stock_number>[^<]+)/',
       ),
        'next_page_regx'        => '/<a href="(?<next>[^"]+)"\s*class="btn/',
        'images_regx'           => '/this\.src=[^"]+"\s+src="(?<img_url>[^"]+)/',
        'images_fallback_regx'  => '/<meta content="(?<img_url>[^"]+)" property="og:image"/'
    );
    add_filter("filter_riversideauto_field_images", "filter_riversideauto_field_images");
    add_filter("filter_riversideauto_field_url", "filter_riversideauto_field_url");
    
    function filter_riversideauto_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'nophoto.png');
        });
    }
    function filter_riversideauto_field_url($url)
    {
        return "https://www.riversideauto.com".trim($url);
    }