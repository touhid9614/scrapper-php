<?php
    global $scrapper_configs;

    $scrapper_configs['adrenalinmotors'] = array(
        'entry_points' => array(
            'used'  => 'https://www.adrenalinmotors.ca/vehicles/',
        ),
        'vdp_url_regex'     => '/\/vehicles\/[0-9]*\/[0-9]{4}-/i',
        
        'use-proxy' => true,
        'picture_selectors' => ['.vehicle_show img'],
        'picture_nexts'     => ['.right.next'],
        'picture_prevs'     => ['.prev.left'],
        
        'details_start_tag' => '<form class="vehicle_search"',
        'details_end_tag'   => '<footer>',
        'details_spliter'   => '<a class="inventory-item"',
        
        'must_not_contain_regx' => '/<img class="sold-banner" alt="Sold" [^>]+>/',
        
        'data_capture_regx' => array(
            'url'           => '/href="(?<url>[^"]+)"><div class=\'inventory-/',
            'year'          => '/inventory-name\'>\s*<span>(?<year>[0-9]{4})[^\n]+\s*<span>(?<make>[^<]+)/',
           // 'make'          => '/inventory-name\'>\s*<span>(?<year>[0-9]{4})[^\n]+\s*<span>(?<make>[^<]+)/',
           // 'model'         => '/inventory-model\'>\s*<span>(?<model>[^<]+)[^\n]+\s*<span>(?<trim>[^<]+)/',
            'trim'          => '/inventory-model\'>\s*<span>(?<model>[^<]+)[^\n]+\s*<span>(?<trim>[^<]+)/',
            'price'         => '/<div class=\'caption\'>\s*(<span[^\n]+\s*<span[^>]+>Now\s*)?(?<price>\$[0-9,]+)/',
            'kilometres'    => '/inventory-odometer\'>\s*<span>(?<kilometres>[^<]+)/',
         ),
        'data_capture_regx_full' => array(
            'make'          => '/Make<\/dt>\s*<dd[^>]*>(?<make>[^<]+)/',
            'model'         => '/Model<\/dt>\s*<dd[^>]*>(?<model>[^<]+)/',
            'stock_number'  => '/Stock<\/dt>\s*<dd[^>]+>(?<stock_number>[^<]+)/',
            'exterior_color'=> '/Body (Or Basic )?Color<\/dt>\s*<dd[^>]+>(?<exterior_color>[^<]+)/',
            'engine'        => '/Engine Size<\/dt>\s*<dd[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission Type<\/dt>\s*<dd[^>]+>(?<transmission>[^<]+)/',
            'interior_color'=> '/Interior (Or Basic )?Color<\/dt>\s*<dd[^>]+>(?<interior_color>[^<]+)/',
            'body_style'    => '/Body Style<\/dt>\s*<dd[^>]*>(?<body_style>[^<]+)/'
            
        ),
        //'next_page_regx'    => '/<li id="il-pagination-element-[0-9]*" class="active">\s*<a.*\s*<\/li>\s*<li[^>]+>\s*<a href="(?<next>[^"]+)"/',
        'images_regx'       => '/<a data-original="(?<img_url>[^"]+)" data-no-turbolink/'
    );
    add_filter('filter_adrenalinmotors_field_url', 'filter_adrenalinmotors_field_url');
    function filter_adrenalinmotors_field_url($url)
    {
        slecho("URL:".$url);
        return $url;
    }