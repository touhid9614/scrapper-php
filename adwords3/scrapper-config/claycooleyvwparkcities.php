<?php
    global $scrapper_configs;

    $scrapper_configs['claycooleyvwparkcities'] = array(
        'entry_points' => array(
            'new'   => 'https://www.claycooleyvwparkcities.com/VehicleSearchResults?search=new',
            'used'  => 'https://www.claycooleyvwparkcities.com/VehicleSearchResults?search=preowned'
        ),
        'vdp_url_regex'     => '/\/VehicleDetails\//i',
        'ty_url_regex'      => '/\/thankYou.do/i',
        'ajax_url_match'    => 'callback=secureLeadSubmission',
        'use-proxy'         => true,
        'picture_selectors' => ['.carousel li'],
        'picture_nexts'     => ['.flex-next'],
        'picture_prevs'     => ['.flex-prev'],
        'details_start_tag' => '<section class="vehicleListWrapper">',
        'details_end_tag'   => '<footer >',
        'details_spliter'   => '<article class="itemscope',
        'data_capture_regx' => array(
            'stock_number'      => '/Stock Number<\/span>\s*<span[^>]+>(?<stock_number>[^<]+)/',
            'year'              => '/itemprop="releaseDate" value="(?<year>[^"]+)"/',
            'make'              => '/itemprop="manufacturer" value="(?<make>[^"]+)"/',
            'model'             => '/itemprop="model" value="(?<model>[^"]+)"/',
            'price'             => '/<span class="price" itemprop="price"\s*title="(?<price>[^"]+)"/',
            'engine'            => '/Engine<\/span>\s[^<]+<span title="(?<engine>[^"]+)">/',
            'transmission'      => '/Transmission<\/span>\s[^<]+<span title="(?<transmission>[^"]+)">/',
            'kilometres'        => '/Kilometers<\/span>\s[^<]+<span title="(?<kilometres>[^"]+)">/',
            'exterior_color'    => '/Exterior<\/span>\s[^<]+<span title="(?<exterior_color>[^"]+)">/',
            'interior_color'    => '/Interior<\/span>\s[^<]+<span title="(?<interior_color>[^"]+)">/',
            'url'               => '/<a data-window-pixel="vsr_title"\s*href="(?<url>[^"]+)"/',
            'certified'         => '/<a data-window-pixel="vsr_title"\s*href="[^\/]+\/(?<certified>certified)-/'
        ),
        'data_capture_regx_full' => array(
            'body_style'    => '/highlight">Body Style: </span>(?<body_style>[^<]+)/',
            'trim'          => '/itemprop="trim" class="trim\s*">(?<trim>[^<]+)/'
        ) ,
        'next_page_regx'    => '/<a href="(?<next>[^"]+)" alt="Next Page">Next Page<\/a>/',
        'images_regx'       => '/media.push\({ src: \'(?<img_url>[^\']+)\'/',
    );
