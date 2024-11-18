<?php

    global $scrapper_configs;

    $scrapper_configs['chiefsauto'] = array(
        'entry_points' => array(
           'used'   => 'https://www.chiefsauto.com/inventory',
        ),
        'use-proxy' => true,
        //'proxy-area'        => 'CA',
        'vdp_url_regex'     => '/\/details\//i',
        'picture_selectors' => ['.vehicle-img .item'],
        'picture_nexts'     => ['.right'],
        'picture_prevs'     => ['.left'],
        'details_start_tag' => '<div class="c-wrapper c-table data-result-table">',
        'details_end_tag'   => '<section class="ss-section section-color3" id="map-locations"',
        'details_spliter'   => '<li class="vehicle-snapshot',
        'data_capture_regx' => array(
            'title'         => '/<a href="(?<url>[^"]+)">\s*<h3 class="[^"]+">(?<title>[^<]+)/',
            'year'          => '/vehicleModelDate":\s*(?<year>[^\,]+)/',
            'make'          => '/manufacturer":\s*"(?<make>[^"]+)/',
            'model'         => '/model":\s*"(?<model>[^"]+)/',
            'transmission'  => '/Trans:\s*<\/div><div\s*class="c-tablecell">(?<transmission>[^<]+)/',
            'engine'        => '/Engine:\s*<\/div><div\s*class="c-tablecell">(?<engine>[^<]+)/',
            'price'         => '/vehicle-price[^\n]+\s*<a[^\n]+\s*(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Mileage:\s*<\/div><div\s*class="c-tablecell">(?<kilometres>[^<]+)/',
            'url'           => '/<a href="(?<url>[^"]+)">\s*<h3 class="[^"]+">(?<title>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'exterior_color'=> '/Exterior Color:\s*<\/div><div\s*class="c-tablecell">(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior Color:\s*<\/div><div\s*class="c-tablecell">(?<interior_color>[^<]+)/',
            'stock_number'  => '/Stock:\s*<\/div><div\s*class="c-tablecell">(?<stock_number>[^<]+)/',
       ),
        //'next_page_regx'        => '/<li class="active[^>]+.*<\/li>\s*<li[^>]+>\s*<a\s*class="[^"]+"\s*href="(?<next>[^"]+)/',
        'images_regx'           => '/this.src=[^"]+"\s+src="(?<img_url>[^"]+)/',
        //'images_fallback_regx'  => '/item\s*active"><img src="(?<img_url>[^"]+)"/'
    );
    add_filter("filter_chiefsauto_field_images", "filter_chiefsauto_field_images");
    
    function filter_chiefsauto_field_images($im_urls)
    {
        return array_filter($im_urls, function($im_url){
            return !endsWith($im_url, 'nophoto.png');
        });
    }