<?php
    global $scrapper_configs;

    $scrapper_configs['motorcitychrysler'] = array(
        'entry_points' => array(
            'new'   => 'http://www.motorcitychrysler.ca/new-inventory/index.htm',
            'used'  => 'http://www.motorcitychrysler.ca/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel-item'],
        'picture_nexts'     => ['.next'],
        'picture_prevs'     => ['.previous'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'price'         => '/(?:internetPrice|askingPrice)(final-price)?.*class=\'value[^>]+>(?<price>[^<]+)/',
            'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
        ),
        'data_capture_regx_full' => array(
            'make'          => '@make: \'(?<make>[^\']+)@',
            'model'         => '@model: \'(?<model>[^\']+)@',
            'body_style'    => '@bodyStyle: \'(?<body_style>[^\']+)@',
            'trim'          => '@trim: \'(?<trim>[^\']+)@'
        ),
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<a\s*href="(?<img_url>[^"]+)"\s*class="js-link"/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/'
    );

//add_filter("filter_motorcitychrysler_field_images", "filter_motorcitychrysler_field_images");
//
//function filter_motorcitychrysler_field_images($im_urls)
//{
//    $retval = array();
//
//    foreach($im_urls as $url) {
//        $retval[] = str_replace('thumb_', '', $url);
//    }
//
//    return $retval;
//}