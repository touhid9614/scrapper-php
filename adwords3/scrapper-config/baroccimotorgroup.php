<?php

    global $scrapper_configs;

    $scrapper_configs['baroccimotorgroup'] = array(
        'entry_points' => array(
            'used' => 'https://www.baroccimotorgroup.com/inventory/'
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        'use-proxy' => true,
        'picture_selectors' => ['.flexslider .slides > li'],
        'picture_nexts'     => ['.flex-next'],
        'picture_prevs'     => ['.flex-prev'],
        
        'details_start_tag' => '<div id="inventory-all"',
        'details_end_tag'   => '<div id="footer">',
        'details_spliter'   => '<img class="media-object',
        'data_capture_regx' => array(
            'url'           => '/<a href="(?<url>[^"]+)" class="details_link"/',
            'title'         => '/class="details_link">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'year'          => '/class="details_link">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'make'          => '/class="details_link">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'model'         => '/class="details_link">(?<title>(?<year>[0-9]{4})\s*(?<make>[^\s]+)\s*(?<model>[^\s]+)\s*[^<]+)/',
            'price'         => '/class="price">(?<price>\$[0-9,]+)/',
            'kilometres'    => '/Miles:\s*(?<kilometres>[^<\s]+)\s*/',
            'stock_number'  => '/Stock#\s*(?<stock_number>[^<]+)/',
            'engine'        => '/Color:\s*(?<exterior_color>[^<]+)<br\s*\/>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:\s*(?<transmission>[^<]+)/',
            'exterior_color'=> '/Color:\s*(?<exterior_color>[^<]+)<br\s*\/>(?<engine>[^<]+)/',
        ),
        'data_capture_regx_full' => array(        
//            'make'          => '@make\: \'(?<make>[^\']+)\'@',
//            'model'         => '@model\: \'(?<model>[^\']+)\'@',
            'body_style'    => '@Bodystyle:<\/strong>\s*(?<body_style>[^<]+)@',
            'trim'          => '@trim-header">(?<trim>[^<]+)@',
            'body_style'    => '/data-bodyStyle="(?<body_style>[^"]+)/',
            'interior_color'=> '/Interior Color:<\/strong>\s*(?<interior_color>[^<]+)/'


        ) ,
        //'next_page_regx'    => '/href="(?<next>[^"]+)"\s*rel="next"/',
        'images_regx'       => '/<li>\s*<img src="(?<img_url>[^"]+)/'
    );

