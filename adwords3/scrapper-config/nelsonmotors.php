<?php
    global $scrapper_configs;

    $scrapper_configs['nelsonmotors'] = array(
        'entry_points' => array(
            'new'   => 'http://www.nelsongm.com/new-inventory/index.htm',
            'used'  => 'http://www.nelsongm.com/used-inventory/index.htm'
        ),
        'use-proxy' => true,
        'details_start_tag' => '<ul id="fullview">',
        'details_end_tag'   => '<div class="paging paging1">',
        'details_spliter'   => '<div class="compare">',
        'data_capture_regx' => array(
            'stock_number'  => '/<dd class="stockNumberValue">(?<stock_number>[^<]+)/',
            'year'          => '/<h2><a href="(?<url>[^"]+)"><span>(?<title>(?<year>[0-9]{4}) (?<make>[^ <]+) (?<model>(?:[^ <]+)(?: [^ <]+)?))/',
            'make'          => '/<h2><a href="(?<url>[^"]+)"><span>(?<title>(?<year>[0-9]{4}) (?<make>[^ <]+) (?<model>(?:[^ <]+)(?: [^ <]+)?))/',
            'model'         => '/<h2><a href="(?<url>[^"]+)"><span>(?<title>(?<year>[0-9]{4}) (?<make>[^ <]+) (?<model>(?:[^ <]+)(?: [^ <]+)?))/',
            'price'         => '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/',
            'engine'        => '/<dd class="engineValue">(?<engine>[^<]+)/',
            'transmission'  => '/<dd class="transmissionValue">(?<transmission>[^<]+)/',
            'kilometres'    => '/<dd class="mileageValue">(?<kilometres>[0-9,]+)/',
            'url'           => '/<h2><a href="(?<url>[^"]+)"><span>(?<title>(?<year>[0-9]{4}) (?<make>[^ <]+) (?<model>(?:[^ <]+)(?: [^ <]+)?))/',
            'exterior_color'=> '/<dd class="extColorValue">(?<exterior_color>[^<]+)/',
            'interior_color'=> '/<dd class="intColorValue">(?<interior_color>[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/Bodystyle<\/span><\/dt><dd><span>(?<body_style>[^<]+)/'
        ) ,
        'options_start_tag' => '<div id="options">',        
        'options_end_tag'   => '</ul>',        
        'options_regx'      => '/<li><span>(?<option>[^<]+)/',        
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="nextPage"/',
        'images_regx'       => '/<li>\s*<a href="(?<img_url>\/\/pictures.dealer.com\/c\/[^"]+)" class="">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
?>
