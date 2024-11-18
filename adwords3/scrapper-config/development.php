<?php
    global $scrapper_configs;

    $scrapper_configs['development'] = array(
        'entry_points' => array(
            'used'  => 'http://www.saintjohnnissan.com/used/',
        ),
        'use-proxy' => true,
        'details_start_tag' => '<div class="instock-inventory-content',
        'details_end_tag'   => '<div class="ajax-loading"',
        'details_spliter'   => '<div class="vehicle-list-cell',
        'data_capture_regx' => array(
            'url'           => '/<a onclick="[^"]+" href="(?<url>[^"]+)">*(New|Used)*(?<title>\s*(?<condition>[^ ]+) *(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ ]+)[^<]*)/',
            'title'         => '/title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/',
            'year'          =>  '/title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/',
            'make'          =>  '/title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/',
            'model'         =>  '/title="(?<title>(?<year>[0-9]{4}) (?<make>[^ ]+) (?<model>[^ "]+)[^"]+)/',
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'price'         => '/Price:[^>]+>[^>]+>(?<price>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'kilometres'    => '/Mileage:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'exterior_color'=> '/Exterior Colo[u]r:[^>]+>[^>]+>(?<exterior_color>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'body_style'    => '/Body Style:[^>]+>[^>]+>(?<body_style>[^<]+)/'
        ),
        'options_start_tag' => 'function loadInspectedOptions ()',        
        'options_end_tag'   => '.html(inspectedOptionsHtml)',        
        'options_regx'      => '/<a class="list-group-used-item ">(?<option>[^<]+)/',        
        'next_query_regx'   => '/<link rel="next" href="(?<next>[^"]+)"/',
        'images_regx'       => '/<img onerror="imgError\(this\);" src="(?<img_url>[^"]+)"/'
    );

?>
