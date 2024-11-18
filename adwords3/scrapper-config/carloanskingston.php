<?php

    global $scrapper_configs;

    $scrapper_configs['carloanskingston'] = array(
        'entry_points' => array(
            'used'  => 'http://www.carloanskingston.ca/used-cars-kingston?Layout=List&ps=12'
        ),
        'vdp_url_regex'     => '/www\.carloanskingston\.ca\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/thank-you-used/i',
        'use-proxy' => true,
        'details_start_tag' => '<div class="eziInvListView">',
        'details_end_tag'   => '<div class="eziPager">',
        'details_spliter'   => '<div class="eziVehicle eziVehicleList"',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/<h2 class="eziVehicleName">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^< ]+)[^<]*)/',
            'year'          => '/<h2 class="eziVehicleName">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^< ]+)[^<]*)/',
            'make'          => '/<h2 class="eziVehicleName">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^< ]+)[^<]*)/',
            'model'         => '/<h2 class="eziVehicleName">(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^< ]+)[^<]*)/',
            'price'         => '/class="eziPriceValue">(?<price>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'kilometres'    => '/<div class="eziOdometer">(?<kilometres>[^<]+)/',
            'url'           => '/<div class="eziGetMoreInfo"><a href="(?<url>[^"]+)"/'
        ),
        'data_capture_regx_full' => array(
            'interior_color'=> '/Interior:[^>]+><span>(?<interior_color>[^<]+)/',
            'body_style'    => '/<li>Variation <span>(?<body_style>[^<]+)/'
        ),
        'images_regx'       => '/<li><img src="(?<img_url>[^"]+)"/',
        'next_page_regx'    => '/<a title="Next" href="(?<next>[^"]+)"/'
    );
