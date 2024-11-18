<?php

    global $scrapper_configs;

    $scrapper_configs['mbdurham'] = array(
        'entry_points' => array(
            'new'   => 'http://durham.mercedes-benz.ca/en-CA/search-inventory/',
            'used'  => 'http://certified.mercedes-benz.ca/durham/used'
        ),
        'use-proxy' => true,
        'new'   => array(
            'details_start_tag' => '<div id="inventory-listing">',
            'details_end_tag'   => '<div class="inventory-refine bottom">',
            'details_spliter'   => '<div class="clear">',
            'data_capture_regx' => array(
                'stock_number'  => '/Stock Number:<\/span> ?(?<stock_number>[^<]+)/',
                'title'         => '/<div class="p45 details">\s*<h5 class="cufon">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]+)/',
                'year'          => '/<div class="p45 details">\s*<h5 class="cufon">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]+)/',
                'make'          => '/<div class="p45 details">\s*<h5 class="cufon">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]+)/',
                'model'         => '/<div class="p45 details">\s*<h5 class="cufon">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ <]+)[^<]+)/',
                'price'         => '/<h6 class="price-amount cufon"> ?(?<price>[^\.]+)/',
                'body_style'    => '/Body Style:<\/span> ?(?<body_style>[^<]+)/',
                'transmission'  => '/Transmission:<\/span> ?(?<transmission>[^\s<]+)/',
                'exterior_color'=> '/Ext. Color:<\/span> ?(?<exterior_color>[^<]+)/',
                'interior_color'=> '/Int. Color:<\/span> ?(?<interior_color>[^<]+)/',
                'url'           => '/<p class="view-details"><a data-href="(?<url>[^"]+)/'
            ),
            'data_capture_regx_full' => array(
                //'engine'        => '/class="engineValue"> ?(?<engine>[^<]+)/'
            ) ,
            'next_page_regx'    => '/<li class=\'arrow-right\'><a href=\'(?<next>[^\']+)/',
            'images_regx'       => '/<a href=\'(?<img_url>http:\/\/durham.mercedes-benz.ca\/InventoryImages\/[^\/]+\/[^\/]+\/[^\/]+\/BIG[^\']+)/'
        ),
        'used'   => array(
            'details_start_tag' => '<div id="seodiv">',
            'details_end_tag'   => '</noscript>',
            'details_spliter'   => '</a>',
            'data_capture_regx' => array(
                'title'         => '/<a href="(?<url>[^"]+)" title="(?<title>Used (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/',
                'year'          => '/<a href="(?<url>[^"]+)" title="(?<title>Used (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/',
                'make'          => '/<a href="(?<url>[^"]+)" title="(?<title>Used (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/',
                'model'         => '/<a href="(?<url>[^"]+)" title="(?<title>Used (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/',
                'price'         => '/<div class="Price border-bottom">&#36;(?<price>[^<]+)/',
                'kilometres'    => '/<div class="Mileage">(?<kilometres>[^<]+)/',
                'url'           => '/<a href="(?<url>[^"]+)" title="(?<title>Used (?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/'
            ),
            'data_capture_regx_full' => array(
                'stock_number'  => '/Stock Number:<\/th>\s*<td>(?<stock_number>[^<]+)/',
                //'engine'        => '/class="engineValue"> ?(?<engine>[^<]+)/',
                'transmission'  => '/Transmission:<\/th>\s*<td>(?<transmission>[^<]+)/',
                'exterior_color'=> '/Exterior:<\/th>\s*<td>(?<exterior_color>[^<]+)/',
                'interior_color'=> '/Interior:<\/th>\s*<td>(?<interior_color>[^<]+)/',
                'body_style'    => '/Bodystyle:<\/th>\s*<td>(?<body_style>[^<]+)/'
            ) ,
            //'next_page_regx'    => '/<a href="(?<next>[^"]+)" class="nextPage"/',
            'images_regx'       => '/<a id="[0-9]+" href="(?<img_url>\/photo\/[^"]+)"/'
        )
    );
?>