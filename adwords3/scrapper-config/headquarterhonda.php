<?php
    global $scrapper_configs;

    $scrapper_configs['headquarterhonda'] = array(
        'entry_points' => array(
            'new'   => 'http://www.headquarterhonda.com/new-vehicles/',
            'used'  => 'http://www.headquarterhonda.com/used-vehicles/'
        ),
        'vdp_url_regex'     => '/\/inventory\/[0-9]{4}-/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel li'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
        'details_start_tag' => '<table class="results_table">',
        'details_end_tag'   => '</table>',
        'details_spliter'   => '<div class="vehicle list-view',
        'data_capture_regx' => array(
            'stock_number'  => '/STOCK #:\s(?<stock_number>[^<]+)/',
            'title'         => '/<h2>\s.*<a\shref="(?<url>[^"]+)">\s.*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+))\s(?<trim>[^\s]+)\s[^<]+/',
            'year'          => '/<h2>\s.*<a\shref="(?<url>[^"]+)">\s.*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+))\s(?<trim>[^\s]+)\s[^<]+/',
            'make'          => '/<h2>\s.*<a\shref="(?<url>[^"]+)">\s.*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+))\s(?<trim>[^\s]+)\s[^<]+/',
            'model'         => '/<h2>\s.*<a\shref="(?<url>[^"]+)">\s.*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+))\s(?<trim>[^\s]+)\s[^<]+/',
            'trim'          => '/<h2>\s.*<a\shref="(?<url>[^"]+)">\s.*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+))\s(?<trim>[^\s]+)\s[^<]+/',
            'price'         => '/<span class="price-label">\s.*MSRP:.*\s.*\s*(?<price>[^<]+)/',
            'body_style'    => '/Body:.*\s.*<dd>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:.*\s.*<span.*">(?<engine>[^<]+)/',
            'transmission'  => '/Trans:.*\s.*">\s(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior:.*\s.*">\s(?<exterior_color>[^<]+)/',
            'interior_color'=> '/Interior:.*\s.*">\s(?<interior_color>[^<]+)/',
            'kilometres'    => '/Mileage:.*\s.*<dd>\s(?<kilometres>[^<]+)/',
            'url'           => '/<h2>\s.*<a\shref="(?<url>[^"]+)">\s.*(?<title>(?<year>[0-9]{4})\s(?<make>[^\s]+)\s(?<model>[^\s]+))\s(?<trim>[^\s]+)\s[^<]+/'
        ),
        'data_capture_regx_full' => array(
            'trim' => '@"trim": "(?<trim>[^"]+)@'
        ),
        'next_page_regx'    => '/<a\shref=".*data-page="(?<next>[^"]+)"\sclass="next"/',
        'images_regx'       => '/<div class="item">\s.*src="(?<img_url>[^"]+)/',
       // 'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );
