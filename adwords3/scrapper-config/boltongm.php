<?php

    global $scrapper_configs;

    $scrapper_configs['boltongm'] = array(
        'entry_points' => array(
            'new'   => 'http://inventory.boltongm.ca/new',
            'used'  => 'http://inventory.boltongm.ca/used'
        ),
        'use-proxy' => true,
        'details_start_tag' => '<div class="right">',
        'details_end_tag'   => '<div id="fb-root"></div>',
        'details_spliter'   => '<div class="row',
        'Mercedes-Benz'     => array(
            'model'         => '/class="blue_text">\s+<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})? ?(?<make>[^ ]+) [^ ]+ *(?<model>[^ ]+)[^<]+)/',
        ),
        'data_capture_regx' => array(
            'stock_number'  => '/Stock# : (?<stock_number>[^\s<]+)/',
            'title'         => '/class="blue_text">\s+<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})? ?(?<make>[^ ]+) (?<model>[^ ]+)[^<]+)/',
            'year'          => '/class="blue_text">\s+<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})? ?(?<make>[^ ]+) (?<model>[^ ]+)[^<]+)/',
            'make'          => '/class="blue_text">\s+<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})? ?(?<make>[^ ]+) (?<model>[^ ]+)[^<]+)/',
            'model'         => '/class="blue_text">\s+<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})? ?(?<make>[^ ]+) (?<model>[^ ]+)[^<]+)/',
            'price'         => '/<div class="price_text2" style="line-height: 17px;">(?<price>[^<]+)/',
            'body_style'    => '/Body Style : (?<body_style>[^\s<]+)/',
            'transmission'  => '/Transmission : (?<transmission>[^\s<]+)/',
            'exterior_color'=> '/Exterior : (?<exterior_color>[^\s<]+)/',
            'kilometres'    => '/Mileage : (?<kilometres>[^\s<]+)/',
            'url'           => '/class="blue_text">\s+<a href="(?<url>[^"]+)">(?<title>(?<year>[0-9]{4})? ?(?<make>[^ ]+) (?<model>[^ ]+)[^<]+)/'
        ),
        'data_capture_regx_full' => array(
            'interior_color'=> '/Interior:<\/li>\s+<li[^>]+>(?<interior_color>[^<]+)/',
            'engine'        => '/Engine:<\/li>\s+<li[^>]+>(?<engine>[^<]+)/'
        ) ,
        'next_page_regx'    => '/<a href=\'(?<next>[^\']+)\'><img src=\'\/images\/btn_next.gif\' alt=\'Next\'/',
        'images_regx'       => '/href="(?<img_url>http[^"]*.jpeg)"/'
    );