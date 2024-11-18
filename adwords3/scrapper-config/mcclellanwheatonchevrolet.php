<?php
    global $scrapper_configs;

    $scrapper_configs['mcclellanwheatonchevrolet'] = array(
        'entry_points' => array(
            'new'   => 'http://www.mcclellanwheatonchevrolet.ca/VehicleSearchResults?search=new',
            'used'  => 'http://www.mcclellanwheatonchevrolet.ca/VehicleSearchResults?search=preowned'
        ),
        'vdp_url_regex'     => '/\/VehicleDetails\//i',
        'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy' => true,
        'details_start_tag' => '<section class="vehicleListWrapper">',
        'details_end_tag'   => '<footer >',
        'details_spliter'   => '<article class="itemscope',
        'data_capture_regx' => array(
            'stock_number' => '/<a data-window-pixel="vsr_title" href="VehicleDetails\/[^\/]+\/(?<stock_number>[^"]+)"/',
            'year'          => '/<span class="year" itemprop="releaseDate" value="(?<year>[^"]+)"/',
            'make'          => '/<span class="make" itemprop="manufacturer" value="(?<make>[^"]+)"/',
            'model'          => '/<span class="model" itemprop="model" value="(?<model>[^"]+)"/',
            'price'          => '/<span class="price" itemprop="price"\s*title="(?<price>[^"]+)"/',
            'engine'         => '/Engine<\/span>\s[^<]+<span title="(?<engine>[^"]+)">/',
            'transmission'  => '/Transmission<\/span>\s[^<]+<span title="(?<transmission>[^"]+)">/',
            'kilometres'  => '/Kilometers<\/span>\s[^<]+<span title="(?<kilometres>[^"]+)">/',
            'exterior_color'  => '/Exterior<\/span>\s[^<]+<span title="(?<exterior_color>[^"]+)">/',
            'interior_color'  => '/Interior<\/span>\s[^<]+<span title="(?<interior_color>[^"]+)">/',
            'url'  => '/<a data-window-pixel="vsr_title"\s[^h]href="(?<url>[^"]+)"/',
            // 'stock_number'  => '/Stock Number:<\/label>\s[^<]+<span>(?<stock_number>[^<]+)<\/span>/',
            // 'year'          => '/<span>(?<year>20[0-9]{2})<\/span>[^<]+<span>(?<make>[^<]+)<\/span>[^<]+<span>(?<model>[^<]+)<\/span>/',
            // 'make'          => '/<span>(?<year>20[0-9]{2})<\/span>[^<]+<span>(?<make>[^<]+)<\/span>[^<]+<span>(?<model>[^<]+)<\/span>/',
            // 'model'         => '/<span>(?<year>20[0-9]{2})<\/span>[^<]+<span>(?<make>[^<]+)<\/span>[^<]+<span>(?<model>[^<]+)<\/span>/',
            // 'price'         => '/(Price|Sale Price|MSRP):<\/label>\s[^<]+<span>(?<price>[^<]+)<\/span>/',
            // 'engine'        => '/Engine:<\/label>\s[^<]+<span>(?<engine>[^<]+)<\/span>/',
            // 'transmission'  => '/Transmission:<\/label>\s[^<]+<span>(?<transmission>[^<]+)<\/span>/',
            // 'kilometres'    => '/(?<kilometres>[0-9,]+) Kilometers/',
            // 'url'           => '/<a href="(?<url>[^"]+)" title="Click to see more details of/',
            // 'exterior_color'=> '/Exterior:<\/label>\s[^<]+<span>(?<exterior_color>[^<]+)<\/span>/', //invalid by wish
            // 'interior_color'=> '/Interior:<\/label>\s[^<]+<span>(?<interior_color>[^<]+)<\/span>/',
            // 'body_style'    => '/Variation : (?<body_style>[^<]+)/' //invalid by wish
        ),
        'data_capture_regx_full' => array(
            'trim' => '@itemprop="trim" class="trim">(?<trim>[^<]+)@'
        ) ,
        //'next_page_regx'    => '/<li class="pageNavigation_control_right">[^<]+<a class="spriteContainer sprite-icon_paginationRight_on" href="(?<next>[^"]+)"/',
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" alt="Next Page">Next Page<\/a>/',
        'images_regx'       => '/media.push\({ src: \'(?<img_url>[^\']+)\'/',
    );
?>
