<?php

    global $scrapper_configs;

    $scrapper_configs['murraypen'] = array(
        'entry_points' => array(
            'new'   => 'https://www.murraygmpenticton.ca/new-inventory/index.htm',
            'used'  => 'https://www.murraygmpenticton.ca/used-inventory/index.htm'
        ),
        'vdp_url_regex'     => '/\/(?:new|certified|used)\/[^\/]+\/[0-9]{4}-.*\.htm/i',
        'ty_url_regex'      => '/\/form\/confirm.htm/i',
        'use-proxy' => true,
        'picture_selectors' => ['.jcarousel li'],
        'picture_nexts'     => ['.imageScrollNext.next'],
        'picture_prevs'     => ['.imageScrollPrev.previous'],
        'details_start_tag' => '<ul class="inventoryList data full list-unstyled">',
        'details_end_tag'   => '<div class="ft">',
        'details_spliter'   => '<div class="item-compare">',
        'data_capture_regx' => array(
            'stock_number'  => '/Stock #:[^>]+>[^>]+>(?<stock_number>[^<]+)/',
            'title'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'year'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'make'          => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'model'         => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/',
            'price'         => '/final-price.*class=\'value[^>]+>(?<price>\$[0-9,]+)/',
            'body_style'    => '/Bodystyle:[^>]+>[^>]+>(?<body_style>[^<]+)/',
            'engine'        => '/Engine:[^>]+>[^>]+>(?<engine>[^<]+)/',
            'transmission'  => '/Transmission:[^>]+>[^>]+>(?<transmission>[^<]+)/',
            'exterior_color'=> '/Exterior Colou?r:[^>]+>[^>]+>(?<exterior_color>[^<\[]+)/',
            'interior_color'=> '/Interior Colou?r:[^>]+>[^>]+>(?<interior_color>[^<]+)/',
            'kilometres'    => '/Kilometres:[^>]+>[^>]+>(?<kilometres>[^<]+)/',
            'url'           => '/class="url" *href="(?<url>[^"]+)"> *(?<title>(?<year>[^ ]+) *(?<make>[^ ]+) *(?<model>[^ <]+)[^<]*)/'
        ),
        'data_capture_regx_full' => array(
            'trim' => '@"trim": "(?<trim>[^"]+)@'
        ),
        'options_start_tag' => '<dt>Options</dt>',
        'options_end_tag'   => '</dd>',
        'options_regx'      => '/<li><span>(?<option>[^<]+)/',
        'next_page_regx'    => '/rel="next" *(?:data-href|href)="(?<next>[^"]+)"/',
        'images_regx'       => '/<li>\s*<a href="(?<img_url>https:\/\/pictures\.dealer\.com[^"]+)" class="[^"]+">/',
        'images_fallback_regx'  => '/<meta name="og:image" content="(?<img_url>[^"]+)"/',
        'auto_texts_regx'   => '/<a href="#" class="dialog xsmall" data-href="[^>]+>\s*(?<auto_text>[^<]+)<\/a>/'
    );
add_filter("filter_murraypen_field_images", "filter_murraypen_field_images");
    
    function filter_murraypen_field_images($im_urls)
    {
      return array_filter($im_urls, function($img_url){
            return !endsWith($img_url, "unavailable_stockphoto.png");
        });
    }
