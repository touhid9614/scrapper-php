<?php
    global $scrapper_configs;

    $scrapper_configs['kalawsky'] = array(
        'entry_points' => array(
            'new'   => 'http://www.kalawsky.com/VehicleSearchResults?search=new',
            'used'  => 'http://www.kalawsky.com/VehicleSearchResults?search=preowned'
       ),
        'vdp_url_regex'     => '/\/VehicleDetails\//i',
        'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy' => true,
        'details_start_tag' => '<ul class="results_list ">',
        'details_end_tag'   => '<form id="results_list_footer" action="">',
        'details_spliter'   => '<li class="results_list_row',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock Number:<\/label>\s[^<]+<span>(?<stock_number>[^<]+)<\/span>/',
            'year'          => '/<span>(?<year>20[0-9]{2})<\/span>[^<]+<span>(?<make>[^<]+)<\/span>[^<]+<span>(?<model>[^<]+)<\/span>/',
            'make'          => '/<span>(?<year>20[0-9]{2})<\/span>[^<]+<span>(?<make>[^<]+)<\/span>[^<]+<span>(?<model>[^<]+)<\/span>/',
            'model'         => '/<span>(?<year>20[0-9]{2})<\/span>[^<]+<span>(?<make>[^<]+)<\/span>[^<]+<span>(?<model>[^<]+)<\/span>/',
            'price'         => '/(Price|Sale Price|MSRP):<\/label>\s[^<]+<span>(?<price>[^<]+)<\/span>/',
            'engine'        => '/Engine:<\/label>\s[^<]+<span>(?<engine>[^<]+)<\/span>/',
            'transmission'  => '/Transmission:<\/label>\s[^<]+<span>(?<transmission>[^<]+)<\/span>/',
            'kilometres'    => '/(?<kilometres>[0-9,]+) Kilometers/',
            'url'           => '/<a href="(?<url>[^"]+)" title="Click to see more details of/',
            'exterior_color'=> '/Exterior:<\/label>\s[^<]+<span>(?<exterior_color>[^<]+)<\/span>/', //invalid by wish
            'interior_color'=> '/Interior:<\/label>\s[^<]+<span>(?<interior_color>[^<]+)<\/span>/',
            'body_style'    => '/Variation : (?<body_style>[^<]+)/' //invalid by wish
        ),
        'data_capture_regx_full' => array(
            'trim' => '@itemprop="trim" class="trim">(?<trim>[^<]+)@'
        ) ,
        'next_page_regx'    => '/<li class="pageNavigation_control_right">[^<]+<a class="spriteContainer sprite-icon_paginationRight_on" href="(?<next>[^"]+)"/',
        'images_regx'       => '/"full":"(?<img_url>[^"]+)"/'
    );
