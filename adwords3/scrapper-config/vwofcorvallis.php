<?php
    global $scrapper_configs;

    $scrapper_configs['vwofcorvallis'] = array(
       'entry_points' => array(
            'new'   => 'https://www.vwofcorvallis.com/new-inventory/index.htm',
            'used'  => 'https://www.vwofcorvallis.com/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.prev'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'price'         => '/final-price.*class=\'value[^>]+>(?<price>[^<]+)/',
            'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine Layout:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
        ),
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<li>\s*<a href="(?<img_url>(?:https?:)?\/\/pictures.dealer.com\/c\/[^"]+)" class="">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );