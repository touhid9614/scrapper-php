<?php

    global $scrapper_configs;

    $scrapper_configs['courtesyforddanville'] = array(
        'entry_points' => array(
            'new'    => 'http://www.courtesyforddanville.com/search/new/tp/',
            'used'   => 'http://www.courtesyforddanville.com/search/used/tp/',
            //'certified' => 'http://www.courtesyforddanville.com/search/certified/tp/'
        ),
        //'use-proxy' => true,
        'proxy-area'        => 'FL',
        'vdp_url_regex'     => '/\/[^\/]+\/(?:new|used)-[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-/i',
        'picture_selectors' => ['.item.slideshow_item.active'],
        'picture_nexts'     => [],
        'picture_prevs'     => [],
        'details_start_tag' => '<div class="srp_results_count_container">',
        'details_end_tag'   => '<div id="details-disclaimer"',
        'details_spliter'   => '<div class="srp_vehicle_item_container srp_vehicle_table"',
        'data_capture_regx' => array(
            'stock_number'  => '/<meta\s*itemprop="sku"\s*content="(?<stock_number>[^"]+)/',
            'title'         => '/<meta\s*itemprop="name"\s*content="(?<title>[^"]+)/',
            'year'          => '/<meta\s*itemprop="releaseDate"\s*content="(?<year>[^"]+)/',
            'make'          => '/<meta\s*itemprop="brand"\s*content="(?<make>[^"]+)/',
            'model'         => '/<meta\s*itemprop="model"\s*content="(?<model>[^"]+)/',
            'transmission'  => '/<meta\s*itemprop="vehicleTransmission"\s*content="(?<transmission>[^"]+)/',
            'price'         => '/<meta\s*itemprop="price"\s*content="(?<price>[^"]+)/',
            'exterior_color'=> '/<meta\s*itemprop="color"\s*content="(?<exterior_color>[^"]+)/',
            'interior_color'=> '/<meta\s*itemprop="vehicleInteriorColor"\s*content="(?<interior_color>[^"]+)/',
            'kilometres'    => '/Miles:<\/dt>\s*<dd[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/srp_vehicle_title_container\'>\s*<h2>\s*<a href="(?<url>[^"]+)/'
        ),
        'data_capture_regx_full' => array(
            'engine'        => '/Engine<\/td>\s*<td[^>]+>(?<engine>[^<]+)/',
            'trim'          => '/Trim<\/td>\s*<td[^>]+>(?<trim>[^<]+)/',
            'model'         => '/<meta itemprop="model"\s*content="(?<model>[^"]+)/',
            //'certified'     => '/<img\s*class="(?<certified>certified)"/'
            
            
        ),
        'next_page_regx'        => '/<li class="active[^>]+.*<\/li>\s*<li[^>]+>\s*<a\s*class="[^"]+"\s*href="(?<next>[^"]+)/',
        'images_regx'           => '/<\/div>\s*<meta itemprop="image" content="(?<img_url>(?:https?:)?\/\/dealerimages[^"]+)/',
        'images_fallback_regx'  => '/<meta property="og:image" content="(?<img_url>[^"]+)"/'
    );
//    add_filter("filter_courtesyforddanville_field_images", "filter_courtesyforddanville_field_images");
//    
//    function filter_courtesyforddanville_field_images($im_urls)
//    {
//       $retval = array();
//
//        foreach($im_urls as $url) {
//            $retval[] = str_replace('w_100', 'w_800', $url);
//        }
//
//        return $retval;
//    }